<?php
class DeployController extends Controller {
    public function index(){
        
    }

    public function init(){
        switch (ENVIROMENT){
            case "LOCAL":
            case "DEV":
                $sql_file = URL_ROOT . 'vendor/cartalyst/sentinel/schema/mysql.sql';
                if(file_exists($sql_file)){
                    $phinx_file = URL_ROOT . 'app/files/db/phinxlog.sql';
                    DB::unprepared(file_get_contents($phinx_file));
                    DB::unprepared(file_get_contents($sql_file));
                    $roles = ['Admin'];
                    foreach ($roles as $role){
                        $rol = new Role();
                        $rol->slug = Helper::to_slug($role);
                        $rol->name = $role;
                        $rol->permissions = '{"' . Helper::to_slug($role) . '":true}';
                        $rol->save();
                    }
                    $credentials = ['email' => 'admin@robsaurus.me', 'password'  => '12345678'];
                    $usuario = Sentinel::registerAndActivate($credentials);
                    $role = Sentinel::findRoleBySlug('admin');
                    $role->users()->attach($usuario);
                    $response = ['status' => true, 'message' => 'Se ha instalado y configurado correctamente los roles de usuario, usuario default: admin@robsaurus.me'];
                } else
                    $response = ['status' => false, 'message' => 'Error, no se encuentra instalado el paquete cartalyst/sentinel'];
                BREAK;

            default:
                $response = ['status' => false, 'message' => 'Entorno no válido'];
                break;
        }
        echo json_encode($response);
    }

    public function db(){
        $app = new Phinx\Console\PhinxApplication();
        $wrap = new Phinx\Wrapper\TextWrapper($app);

        $routes = [
            'status' => 'getStatus',
            'migrate' => 'getMigrate',
            'rollback' => 'getRollback',
        ];

        $env = isset($_GET['e']) ? $_GET['e'] : null;
        $target = isset($_GET['t']) ? $_GET['t'] : null;

        $output = call_user_func([$wrap, $routes[$command]], $env, $target);
        $error = $wrap->getExitCode() > 0;

        header('Content-Type: text/plain', true, $error ? 500 : 200);

        echo "<pre>$output</pre>";
    }
}