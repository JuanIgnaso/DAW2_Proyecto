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
    
    //PATRONES
    private const _PATRON_PASSWORD = '/[a-zA-Z0-9 \_\-\*\#]+/';

    
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
    $modelU  = new \Com\Daw2\Models\UsuarioSistemaModel();
    //$data['us'] = $modelU->getUserId();
    $data['categoria'] = $modelCategoria->getAll();
   // $data['metodo'] = 'get';
    $data['titulo'] = 'Perfil Del Usuario';
    $data['seccion'] = '/mi_Perfil';
    $info = $_SESSION['usuario'];
    $data['info_usuario'] = $info;
    $this->view->showViews(array('templates/header_my_profile.view.php','templates/header_navbar.php','UserDetails.view.php','templates/footer.view.php'),$data);

    }
    
    
    function showEditProfile(){
    $data = [];
    $modelCategoria = new \Com\Daw2\Models\CategoriaModel();
    $input = $_SESSION['usuario'];
    $data['categoria'] = $modelCategoria->getAll();
    $data['seccion'] = '/mi_Perfil/edit';
    $data['titulo'] = 'Modificar Mi Perfil';
   
    $data['info_usuario'] = $input;
    unset($data['info_usuario']['cartera']);
    
    
    
    $this->view->showViews(array('templates/header_my_profile.view.php','templates/header_navbar.php','UserDetails.view.php','templates/footer.view.php'),$data);

    }
    
    
    //EDITAR PERFIL
    function editProfile(){
    $data = [];
    $modelCategoria = new \Com\Daw2\Models\CategoriaModel();
    $data['categoria'] = $modelCategoria->getAll();
    $data['seccion'] = '/mi_Perfil/edit';
    $data['titulo'] = 'Modificar Mi Perfil';
    $data['errores'] = $this->checkForm($_POST);
    
    if(count() == 0){
    $saneado = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    $model = new \Com\Daw2\Models\UsuarioSistemaModel();
    $result = $model->editUser($_POST,$_SESSION['id_usuario']);
    
        
    }else{
    $data['categoria'] = $modelCategoria->getAll();
    $data['seccion'] = '/mi_Perfil/edit';
    $data['titulo'] = 'Modificar Mi Perfil';
    $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    $this->view->showViews(array('templates/header_my_profile.view.php','templates/header_navbar.php','UserDetails.view.php','templates/footer.view.php'),$data);
    }
    }
    
    
    private function checkForm(array $datos): array{
        $model = new \Com\Daw2\Models\UsuarioSistemaModel();
        $errores = [];
        if(empty($post['nombre_usuario'])){
            $errores['nombre_usuario'] = 'No se admiten valores vacios';
        }if(count(trim($post['nombre_usuario'])) == 0){
            $errores['nombre_usuario'] = 'No se admiten cadenas vacías';
        }
        if($model->occupiedUserName($_SESSION['usuario']['id_usuario'],$datos['nombre_usuario'])){
            $errores['nombre_usuario'] = 'El nombre que has escrito ya se encuentra en uso.';
        }
        if(!filter_var($datos['email'],FILTER_VALIDATE_EMAIL)){
            $errores['email'] = 'Formato de correo incorrecto';
        }
        if($model->occupiedMail($_SESSION['usuario']['id_usuario'],$datos['email'])){
          $errores['email'] = 'El correo que deseas escoger ya está en uso';  
        }
        if(count(trim($post['pass1'])) == 0 || count(trim($post['pass2'])) == 0){
            $errores['pass'] = 'No se admiten valores vacios';
        }
        if($post['pass1'] != $post['pass2']){
            $errores['pass'] = 'Las contraseñas no coinciden.';
        }
        if(!preg_match(self::_PATRON_PASSWORD,$post['pass1']) || !preg_match(self::_PATRON_PASSWORD,$post['pass2'])){
             $errores['pass'] = 'formato de contraseña incorrecto.';
        }
        //DINERO
        if(!filter_var($post['cartera'],FILTER_VALIDATE_FLOAT)){
            $errores['cartera'] = 'El valor introducido debe de ser un número decimal';
        }else if($post['cartera'] <= 0){
            $errores['cartera'] = 'No se puede introducir un valor igual o inferior a 0';
        }
        
        //NOMBRE TITULAR
         if(empty($post['nombre_titular'])){
            $errores['nombre_titular'] = 'No se admiten valores vacios';
        }if(count(trim($post['nombre_usuario'])) == 0){
            $errores['nombre_titular'] = 'No se admiten cadenas vacías';
        }
        if(!preg_match('/[a-zA-Z ]+/',$post['nombre_titular'])){
             $errores['nombre_titular'] = 'sólo se admiten letras en el nombre del titular';
        }
        
        //Provincia
          if(empty($post['provincia'])){
            $errores['provincia'] = 'No se admiten valores vacios';
        }if(count(trim($post['provincia'])) == 0){
            $errores['provincia'] = 'No se admiten cadenas vacías';
        }
        if(!preg_match('/[a-zA-Z ]+/',$post['provincia'])){
             $errores['provincia'] = 'sólo se admiten letras en el nombre de la provincia';
        }
        
        //Ciudad
          if(empty($post['ciudad'])){
            $errores['ciudad'] = 'No se admiten valores vacios';
        }if(count(trim($post['ciudad'])) == 0){
            $errores['ciudad'] = 'No se admiten cadenas vacías';
        }
        if(!preg_match('/[a-zA-Z ]+/',$post['ciudad'])){
             $errores['ciudad'] = 'sólo se admiten letras en el nombre de la ciudad';
        }
        
        //COD POSTAL
            if(empty($post['cod_postal'])){
                $errores['cod_postal'] = 'No se admiten valores vacíos';
            }
            if(!preg_match('/[0-9]{5}/',$post['cod_postal'])){
                $errores['cod_postal'] = 'El código postal debe de estar compuesto por 5 cifras';
            }
        
        //Calle
            
          if(empty($post['calle'])){
            $errores['calle'] = 'No se admiten valores vacios';
        }if(count(trim($post['ciudad'])) == 0){
            $errores['calle'] = 'No se admiten cadenas vacías';
        }
        if(!preg_match('/[a-zA-Z0-9 \,\.]+/',$post['calle'])){
             $errores['calle'] = 'caracteres inválidos a la hora de declarar el nombre de calle.';
        }
        
        return $errores;
    }
    
   
    
    
    
        function darDeBaja(){
    
        $model = new \Com\Daw2\Models\UsuarioSistemaModel();
        $nombre = $_POST['dato'];
        $d = [
            "hola" => "adios"
        ];
        $var = $model->darDeBaja($nombre);
        if($var){
            
             http_response_code(200);
            session_destroy();
             exit;
        }else{
          http_response_code(400);  
          echo json_encode(["hola"=>"adios"]); //texto de error o array de errores que quieres mostrarle al usuario (se lo  envias a Ajax)
         exit;
        }
        
        //header('Location: /');
        
        echo json_encode($nombre);
        exit;
        
    }
    
        function borrarUsuario(){
        $model = new \Com\Daw2\Models\UsuarioSistemaModel();
        $nombre = $_POST['datoborrar'];
        $d = [
            "hola" => "adios"
        ];
        $var = $model->deleteUser($nombre);
        if($var){
            
             http_response_code(200);
             session_destroy();
             exit;
        }else{
          http_response_code(400);  
          echo json_encode(["hola"=>"adios"]); //texto de error o array de errores que quieres mostrarle al usuario (se lo  envias a Ajax)
         exit;
        }
        
        //header('Location: /');
        
        echo json_encode($nombre);
        exit;
    }
    
}