<?php
	use Illuminate\Database\Capsule\Manager as Capsule;

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

	use Illuminate\Events\Dispatcher;
	use Illuminate\Container\Container;
	$capsule->setEventDispatcher(new Dispatcher(new Container));

	$capsule->setAsGlobal();

	$capsule->bootEloquent();