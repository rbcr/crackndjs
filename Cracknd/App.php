<?php
namespace Cracknd;

class App{
    protected $cracknd;
    protected $database;

    public function __construct(){
        require_once root_path('config/config.php');
        $this->database = new Database($connections);
        $this->cracknd = new Core();
    }

    public function init(){
        $this->cracknd->enable_routes();
    }
}