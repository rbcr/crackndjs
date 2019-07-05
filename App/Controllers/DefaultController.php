<?php
namespace App\Controllers;

class DefaultController{
    public function index(){
        $usuarios = \Models\User::where('id', '>', 0)->get();
        return json_encode($usuarios);
    }
}