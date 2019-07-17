<?php
namespace Cracknd;

use OpenCloud\ObjectStore\Resource\DataObject;
use OpenCloud\Rackspace;

class Storage{
    private $client;
    private $objectStoreService;
    private $container;

    public function __construct($enable_cdn = false){
        if($enable_cdn === true){
            $this->client = new Rackspace(Rackspace::US_IDENTITY_ENDPOINT, array(
                'username' => RACKSPACE_USER,
                'apiKey'   => RACKSPACE_KEY
            ));
            $this->objectStoreService = $this->client->objectStoreService(null, RACKSPACE_REGION);
            $this->container = $this->objectStoreService->getContainer(RACKSPACE_CONTAINER);
        }
    }

    public function upload_to_cdn($archivo, $directorio, $inUploadsFolder = true, $contentType = null, $returnBasenameOnly = false, $returnPublicUrl = false){
        $localFileName  = ($inUploadsFolder) ? storage_path("uploads/$directorio/$archivo") : storage_path("$directorio/$archivo");
        $remoteFileName = RACKSPACE_FOLDER . "$directorio/$archivo";

        $metadata = ['Access-Control-Allow-Origin' => '*'];
        $metadataHeaders = DataObject::stockHeaders($metadata);
        if(!empty($contentType))
            $allHttpHeaders = ['Content-Type' => $contentType] + $metadataHeaders;
        else
            $allHttpHeaders = $metadataHeaders;

        $handle = fopen($localFileName, 'r');
        $this->container->uploadObject($remoteFileName, $handle, $allHttpHeaders);
        fclose($handle);

        $this->container->enableCdn();
        $object = $this->container->getObject($remoteFileName);

        @unlink($localFileName);

        if($returnBasenameOnly)
            return $object->getName();
        else {
            if($returnPublicUrl)
                return RACKSPACE_CDN . $remoteFileName;
            else {
                $expirationTime = 3600;
                $httpMethod = 'GET';
                return $object->getTemporaryUrl($expirationTime, $httpMethod);
            }
        }
    }

    public function get_temporary_url_cdn($file){
        try{
            $object = $this->container->getPartialObject($file);
            $expirationTime = 3600;
            $httpMethod = 'GET';
            return $object->getTemporaryUrl($expirationTime, $httpMethod);
        } catch (\Exception $exception){
            return false;
        }
    }

    public function drop_to_cdn($file){
        try{
            $object = $this->container->getObject($file);
            $object->delete();
            return true;
        } catch (\Exception $exception){
            return false;
        }
    }

    public static function get_human_redeable_size($bytes, $decimals){
        $size = array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }
}