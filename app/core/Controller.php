<?php
	class Controller{
		public static function loadLib($library) {
	        require_once URL_ROOT.'app/libs/' . $library . '.php';
	        return new $library();
	    }
	}