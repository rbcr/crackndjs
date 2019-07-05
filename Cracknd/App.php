<?php
namespace Cracknd;

use App\Controllers\DefaultController;

class App{
    private $url_controller = null;
    private $url_action = null;
    private $url_params = [];
    protected $database;

    public function __construct(){
        $cracknd = new Core();
        require_once root_path('config/config.php');
        $this->database = new Database($connections);
    }

    public function init(){
        if(ROUTING_ENABLED){
            $routing = new Routes();
            return $routing->init();
        } else {
            $this->splitUrl();
            if (!$this->url_controller) {
                $default = new DefaultController();
                return $default->index();
            } else {
                if (file_exists(root_path('App/Controllers/' . ucfirst($this->url_controller) . 'Controller.php'))){
                    $this->url_controller = 'App\\Controllers\\' . ucfirst($this->url_controller) . 'Controller';
                    $this->url_controller = new $this->url_controller();
                    unset($this->url_params[0]);
                    if (method_exists($this->url_controller, $this->url_action)) {
                        unset($this->url_params[1]);
                        if (!empty($this->url_params))
                            return call_user_func_array([$this->url_controller, $this->url_action], $this->url_params);
                        else
                            return $this->url_controller->{$this->url_action}();
                    } else {
                        $this->url_action = null;
                        return call_user_func_array([new $this->url_controller, 'index'], $this->url_params);
                    }
                } else
                    return View::render('404');
            }
        }
    }

    private function splitUrl(){
        if (isset($_GET['url'])) {
            $url = trim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            $this->url_controller = isset($url[0]) ? $url[0] : null;
            $this->url_action = isset($url[1]) ? $url[1] : null;
            $this->url_params = array_values($url);
        }
    }
}