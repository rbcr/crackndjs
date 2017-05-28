<?php
    class App{
        private $url_controller = null;

        private $url_action = null;

        private $url_params = array();

        public function __construct(){
            $this->splitUrl();

            if (!$this->url_controller){

                require APP . 'controller/DefaultController.php';
                $page = new DefaultController();
                $page->index();

            }elseif(file_exists(APP . 'controller/' . ucfirst($this->url_controller) . 'Controller.php')){
                $this->url_controller = ucfirst($this->url_controller).'Controller';
                require APP . 'controller/' . $this->url_controller . '.php';
                $this->url_controller = new $this->url_controller();
                unset($this->url_params[0]);
                if (method_exists($this->url_controller, $this->url_action)) {
                    unset($this->url_params[1]);
                    if (!empty($this->url_params)) {
                        call_user_func_array(array($this->url_controller, $this->url_action), $this->url_params);
                    } else {
                        $this->url_controller->{$this->url_action}();
                    }
                }else{
                    $this->url_action = '';
                    if(strlen($this->url_action) == 0) {
                        call_user_func_array(array($this->url_controller,'index'), $this->url_params);
                    }
                }
            } else {
                header('location: ' . URL);
            }
            // for debugging. uncomment this if you have problems with the URL
            /*echo 'Controller: ' . $this->url_controller . '<br>';
            echo 'Action: ' . $this->url_action . '<br>';
            echo 'Parameters: ' . print_r($this->url_params, true) . '<br>'; */
        }

        private function splitUrl()
        {
            if (isset($_GET['url'])) {
                $url = trim($_GET['url'], '/');
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode('/', $url);
                $this->url_controller = isset($url[0]) ? $url[0] : null;
                $this->url_action = isset($url[1]) ? $url[1] : null;
                //unset($url[0], $url[1]);
                $this->url_params = array_values($url);
            }
        }

        public function url($direccion = null){
            return URL.$direccion;
        }
    }