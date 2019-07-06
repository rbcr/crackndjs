<?php
namespace Cracknd;

class Cache{
    private $filestore;
    public $cache_manager;

    public function __construct(){
        $this->filestore = new \Illuminate\Cache\FileStore(
            new \Illuminate\Filesystem\Filesystem(),
            storage_path('cache')
        );

        $this->cache_manager = new \Illuminate\Cache\Repository($this->filestore);
    }
}