<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

namespace Com\Daw2\Controllers;

class UsuarioSistemaController extends \Com\Daw2\Core\BaseController{
    
    //Funcion para mostrar la pantalla de login
    public function login(){
        $this->view->show('login.php');
    }
    
    public function loginUser(){
        //Llamada al modelo
        $model = new \Com\Daw2\Models\UsuarioSistemaModel();
    }
}