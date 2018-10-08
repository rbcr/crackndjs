<?php
	/**
	 * Alias de los namespaces de las librerias y paquetes cargados en el autoloader de composer
	 */
	class_alias('Illuminate\Database\Eloquent\Model', 'Model');
	class_alias('Illuminate\Database\Capsule\Manager', 'DB');
	class_alias('Carbon\Carbon', 'Carbon');
    class_alias('Cartalyst\Sentinel\Native\Facades\Sentinel', 'Sentinel');