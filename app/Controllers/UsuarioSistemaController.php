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
        $usuario = $model->login($_POST['email'], $_POST['password']);
        $_vars  = [];
        //Si es nulo, quiere decir que el usuario no ha introducido bien la contraseña o nombre de usuario
        if(is_null($usuario)){
            $_vars['loginError'] = 'Datos de Acceso Incorrectos';
        }else{
            $_SESSION['usuario'] = $usuario;
            $_SESSION['permisos'] = $_SESSION['usuario']->getRol()->get_permisos();
            header('Location: /');
            
        }
        $this->view->show('login.php',$_vars);
    }
}