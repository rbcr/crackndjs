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

    public static function get_dir_contents($path){
        $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        $files = array();
        foreach ($rii as $file)
            if (!$file->isDir())
                $files[] = $file->getPathname();
        return $files;
    }

    public static function move_file($archivo, $directorio_actual, $nuevo_directorio, $rename_file = null){
        try{
            $strings = new Strings();
            $uploads_directory = storage_path('');
            if(!is_dir("$uploads_directory/$nuevo_directorio"))
                mkdir("$uploads_directory/$nuevo_directorio", 0777, true);
            $file_info = pathinfo("$directorio_actual/$archivo");
            $filename = $file_info['basename'];
            rename("$directorio_actual/$filename", "$directorio_actual/" . $strings->to_slug(html_entity_decode($file_info['filename'])) . '.' . $file_info['extension']);
            $filename =  $strings->to_slug(html_entity_decode($file_info['filename'])) . '.' . $file_info['extension'];
            if(!empty($rename_file)){
                $new_filename = $rename_file . '.' . $file_info['extension'];
                rename("$directorio_actual/$filename", "$uploads_directory/$nuevo_directorio/$new_filename");
                return $new_filename;
            } else {
                rename("$directorio_actual/$filename", "$uploads_directory/$nuevo_directorio/$filename");
                return $filename;
            }
        } catch (\Exception $exception) {
            return false;
        }
    }

    public static function copy_file($archivo, $directorio_actual, $nuevo_directorio, $rename_file = null){
        try{
            $strings = new Strings();
            $uploads_directory = storage_path('');
            if(!is_dir("$uploads_directory/$nuevo_directorio"))
                mkdir("$uploads_directory/$nuevo_directorio", 0777, true);
            $file_info = pathinfo("$directorio_actual/$archivo");
            $filename = $file_info['basename'];
            copy("$directorio_actual/$filename", "$directorio_actual/" . $strings->to_slug(html_entity_decode($file_info['filename'])) . '.' . $file_info['extension']);
            $filename =  $strings->to_slug(html_entity_decode($filename));
            if(!empty($rename_file)){
                $new_filename = $rename_file . '.' . $file_info['extension'];
                copy("$directorio_actual/$filename", "$uploads_directory/$nuevo_directorio/$new_filename");
                return $new_filename;
            } else {
                copy("$directorio_actual/$filename", "$uploads_directory/$nuevo_directorio/$filename");
                return $filename;
            }
        } catch (\Exception $exception) {
            return false;
        }
    }

    public static function get_human_redeable_size($bytes, $decimals){
        $size = array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }

    public function upload_to_cdn($archivo, $directorio, $inUploadsFolder = true, $contentType = null, $returnBasenameOnly = false, $returnPublicUrl = false, $dropLocalFile = true){
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

        if($dropLocalFile)
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
}