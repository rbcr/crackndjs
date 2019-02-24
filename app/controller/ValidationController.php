<?php
class ValidationController extends Controller {
    private $factory;

    public function __construct(){
        $this->factory = new JeffOchoa\ValidatorFactory($namespace = 'lang', $lang = 'es', $group = 'validation');
    }

    public function index() {
        $rules = ['body' => 'required'];
        $validator = $this->factory->translationsRootPath(URL_ROOT . 'app/')->make($data = [], $rules);
        $response = ['status' => (!$validator->fails()) ? true : false, 'response' => (!$validator->fails()) ? 'Request exítoso' : ['errors' => $validator->errors()]];
        echo json_encode($response);
    }
}