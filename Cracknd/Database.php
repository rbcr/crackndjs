<?php
namespace Cracknd;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as DB;

class Database{
    function __construct($connections){
        $capsule = new Capsule;

        foreach ($connections as $connection){
            $capsule->addConnection([
                'driver'    => $connection['type'],
                'host'      => $connection['host'],
                'database'  => $connection['db'],
                'username'  => $connection['user'],
                'password'  => $connection['password'],
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'dsn'       => $connection['dsn'],
                'prefix'    => $connection['prefix']
            ], $connection['name']);
        }

        $capsule->setEventDispatcher(new Dispatcher(new Container));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        DB::connection()->enableQueryLog();

        return $capsule;

    }

    public static function getLogQuerys(){
        return DB::getQueryLog();
    }
}