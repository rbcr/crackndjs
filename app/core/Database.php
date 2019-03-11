<?php
	use Illuminate\Database\Capsule\Manager as Capsule;
    use Illuminate\Events\Dispatcher;
    use Illuminate\Container\Container;

	if(!empty(DB_HOST)){
        $capsule = new Capsule;

        $capsule->addConnection([
            'driver'    => DB_TYPE,
            'host'      => DB_HOST,
            'database'  => DB_NAME,
            'username'  => DB_USER,
            'password'  => DB_PASS,
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        $capsule->setEventDispatcher(new Dispatcher(new Container));

        $capsule->setAsGlobal();

        $capsule->bootEloquent();

        DB::connection()->enableQueryLog();
    }