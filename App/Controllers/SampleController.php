<?php
namespace App\Controllers;

class SampleController {
    public function index(){
    
    }

    public function cache(){
        $cache = new \Cracknd\Cache();
        $value = $cache->cache_manager->remember('users', 1000, function (){
            return \Models\User::orderBy('id', 'ASC')->get();
        });

        //var_dump($cache->cache_manager->get('users'));
    }
}