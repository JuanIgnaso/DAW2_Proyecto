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
    
    //Para cargar la vista provisional del usuario
    //ES PROVISIONAL Y DE TESTEO POR EL MOMENTO NO TIENE COMPROBACIONES DE VALORES ERRONEOS
    function showAdd(){
        $data = [];
        $rolModel = new \Com\Daw2\Models\RolModel();
        $rol = $rolModel->getUsersRol();
        $data['roles'] = $rol;
        $data['titulo'] = 'Añadir Usuarios(Provisional)';
        $data['seccion'] = '/usuarios/add';
        $this->view->showViews(array('templates/header_listado.php','templates/header_navbar.php','addUsersTest.view.php','templates/footer.view.php'),$data);
    }
    
    //ES PROVISIONAL Y DE TESTEO PARA PODER AÑADIR USUARIOS A LA BBDD
    //POR EL MOMENTO NO TIENE COMPROBACIONES DE VALORES ERRONEOS
    function addUser(){
       $rolModel = new \Com\Daw2\Models\RolModel();
       $model = new \Com\Daw2\Models\UsuarioSistemaModel();
       $rol = $rolModel->getUsersRol();
       $data = [];
       $data['roles'] = $rol;
       $data['titulo'] = 'Añadir Usuarios(Provisional)';
       $data['seccion'] = '/usuarios/add';
       $result = $model->addUser($_POST);
       if($result){
           header('Location: /');
       }   
 
    }
}