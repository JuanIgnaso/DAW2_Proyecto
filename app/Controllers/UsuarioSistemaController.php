<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

namespace Com\Daw2\Controllers;

class UsuarioSistemaController extends \Com\Daw2\Core\BaseController{
    
    
    //IDS DE ROLES
    private const USUARIO_REGISTRADO = 1;
    private const MANEJO_INVENTARIO = 2;
    private const ADMINISTRADOR = 3;
    
    
    //Funcion para mostrar la pantalla de login
    public function login(){
        $this->view->show('login.php');
    }
    
    public function loginUser(){
        //Llamada al modelo
        $model = new \Com\Daw2\Models\UsuarioSistemaModel();
        $usuario = $model->login($_POST);
        $_vars  = [];
        if(isset($_POST['remember_me'])){
            $_vars['remember'] = $_POST['remember_me'];
        }
         
        //Si es nulo, quiere decir que el usuario no ha introducido bien la contraseña o nombre de usuario
        if(is_null($usuario)){
            $_vars['loginError'] = 'Datos de Acceso Incorrectos'; 
        }else{
            $_SESSION['usuario'] = $usuario;
            $_SESSION['permisos'] = $this->getPermisos($_SESSION['usuario']['id_rol']);
            $model->updateLastLogin($_POST['email']);
            if(!empty($_vars['remember'])){
                //Creamos la Cookie de nombre usuario y password
                setcookie('email',$_SESSION['usuario']['email'],time()+3600*24*7);
                setcookie('password',$_POST['password'],time()+3600*24*7);

            }else{
                //Hacemos caducar las cookies.
                setcookie('email',$_SESSION['usuario']['email'],time() - 3600);
                setcookie('password',$_POST['password'],time() - 3600);
            }
            header('Location: /');
          
            
        }
        $this->view->show('login.php',$_vars);
    }
    
    
    private function getPermisos(int $id_rol):array{
        $permisos = array();
        if($id_rol == 1){
         $permisos = array('comprar' => ['r','w','d']);
        }
        if($id_rol == 2){
           $permisos = array(
               'comprar' => ['r','w','d'],
               'inventario' => ['r','w','d']
               ); 
        }
        if($id_rol == 3){
            $permisos = array(
                'usuarios' => ['r','w','d'],
                'inventario' => ['r','w','d'],
                'comprar' => ['r','w','d']  
                
            );
        }
        
        return $permisos;
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
    
    function showUserProfile(){
    $data = [];
            $modelCategoria = new \Com\Daw2\Models\CategoriaModel();

    $data['categoria'] = $modelCategoria->getAll();
    $data['metodo'] = 'get';
    $data['titulo'] = 'Perfil Del Usuario';
    $info = $_SESSION['usuario'];
    $data['info_usuario'] = $info;
    $this->view->showViews(array('templates/header_my_profile.view.php','templates/header_navbar.php','UserDetails.view.php','templates/footer.view.php'),$data);

    }
    
    
        function darDeBaja($nombre){
        $data = [];
        $model = new \Com\Daw2\Models\UsuarioSistemaModel();
        $data['seccion'] = '/mi_Perfil/baja/'.$nombre;
        $model->darDeBaja($nombre);
        session_destroy();
        header('Location: /');
        
    }
}