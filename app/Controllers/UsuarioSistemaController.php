<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

namespace Com\Daw2\Controllers;

class UsuarioSistemaController extends \Com\Daw2\Core\BaseController{
    
    //ARRAY PRIVADO <-Controlar que en función de si esta vacío o no se ejecuta la consulta
    //de añadir la direccion de envio al usuario
    private $arrayDireccion = [];
    
    
    //IDS DE ROLES
    private const USUARIO_REGISTRADO = 1;
    private const MANEJO_INVENTARIO = 2;
    private const ADMINISTRADOR = 3;
    
    //PATRONES
    private const _PATRON_PASSWORD = '/[a-zA-Z0-9 \_\-\*\#]+/';

    
    //Funcion para mostrar la pantalla de login
    public function login(){
        $_vars  = [];
        $_vars['seccion'] = '/login';
        $_vars['accion'] = 'Iniciar Sesión';
         $this->view->show('login.php',$_vars);
    }
    
    public function loginUser(){
        //Llamada al modelo
        $model = new \Com\Daw2\Models\UsuarioSistemaModel();
        $usuario = $model->login($_POST);
        $_vars  = [];
        $_vars['seccion'] = '/login';
         $_vars['accion'] = 'Iniciar Sesión';
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
    
    
    /*
    Mostrar Formulario Para Registrarse /register
    */
    
     public function register(){
        $_vars  = [];
        $_vars['seccion'] = '/register';
         $_vars['accion'] = 'Crear Mi Cuenta';
        $this->view->show('login.php',$_vars);
    }
    
    
    /* Función Para Registrar el usuario*/
    public function registerUser(){
        $_vars  = [];
        $_vars['seccion'] = '/register';
        $_vars['accion'] = 'Crear Mi Cuenta';
        $_vars['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);  

        $_vars['loginError'] = $this->checkRegister($_POST);
        if(count($_vars['loginError']) == 0){
           $model = new \Com\Daw2\Models\UsuarioSistemaModel();
           if($model->addUser($_POST)){
              $usuario = $model->login($_POST);
              $_SESSION['usuario'] = $usuario;
              $_SESSION['permisos'] = $this->getPermisos($_SESSION['usuario']['id_rol']);           

              //redirige al inicio con la sessión iniciada.
              header('Location: /');
              $_SESSION['register_success'] = 'Nos encanta y llena de alegría saber que desea formar parte de nuestra Web, ya puede visitar y disfrutar de la compra de nuestros productos, gracias por confiar en nosotros.';
           }else{
             $_vars['loginError']['error'] = 'Ha habido un error al intentar crear la cuenta.';  
           }
 
        }else{
            $_vars['accion'] = 'Crear Mi Cuenta';
           $_vars['seccion'] = '/register';
        }
        
     $this->view->show('login.php',$_vars);
    
    }
    
    private function checkRegister(array $post): array{
       $loginError = [];  
       $model = new \Com\Daw2\Models\UsuarioSistemaModel();

        if(empty($post['nombre_usuario'])){
                    $loginError['nombre_usuario'] = 'Debes de escribir un nombre';
                }else if(strlen(trim($post['nombre_usuario'])) == 0){
                    $loginError['nombre_usuario'] = 'No se admiten cadenas vacías';
                }else if($model->isUserNameUsed($_POST['nombre_usuario'])){
                    $loginError['nombre_usuario'] = 'Nombre de usuario ya en uso'; 
                }
        if(empty($post['email'])){
                    $loginError['email'] = 'Debes usar un correo';
                }else if(strlen(trim($post['email'])) == 0){
                    $loginError['email'] = 'No se admiten cadenas vacías';
                }else if($model->isEmailUsed($_POST['email'])){
                    $loginError['email'] = 'Dirección de correo ya en uso'; 
                }else if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
                    $loginError['email'] = 'Formato de correo incorrecto'; 
                }        
        if(empty($post['password'])){
            $loginError['password'] = 'Debes darle una contraseña';
        }else if(strlen(trim($post['password'])) == 0){
          $loginError['password'] = 'No de admiten cadenas vacías';
         } else  if(!preg_match(self::_PATRON_PASSWORD,$post['password'])){
           $loginError['password'] = 'formato de contraseña incorrecto.';    
         }
         return $loginError;
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
    $input = $_SESSION['usuario'];
    
    
    if(count($data['errores']) == 0){
    $saneado = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    $model = new \Com\Daw2\Models\UsuarioSistemaModel();
    $modelDir = new \Com\Daw2\Models\DireccionEnvioModel();
    $usuario = $model->editUser($_POST,$_SESSION['usuario']['pass'],$_SESSION['usuario']['id_usuario']);
    if($this->checkEmptyDir($_POST['nombre_titular'],$_POST['provincia'],$_POST['ciudad'],$_POST['cod_postal'],$_POST['calle'])){
        $dir = true;
    }else{
      $dir = $modelDir->insertShippingAddress($_POST,$_SESSION['usuario']['id_usuario']);  
    }
    $result = false;
    if($dir && $usuario){
        $result = true;
    }
    if($result){
        //Cambiarlo
        $_SESSION['usuario'] = $model->updateUserSession($_SESSION['usuario']['id_usuario']);
        header('location: /mi_Perfil');
        $_SESSION['success'] = 'Los cambios realizados a tu perfil se han realizado con éxito!';
    }else{
        $data['categoria'] = $modelCategoria->getAll();
        $data['seccion'] = '/mi_Perfil/edit';
        $data['titulo'] = 'Modificar Mi Perfil';
        $data['errores'] = $this->checkForm($_POST,true); //<- Pasamos true porque estamos editando
    }
        
    }else{
   $data['info_usuario'] = $input;
    $data['categoria'] = $modelCategoria->getAll();
    $data['seccion'] = '/mi_Perfil/edit';
    $data['titulo'] = 'Modificar Mi Perfil';
    $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    $this->view->showViews(array('templates/header_my_profile.view.php','templates/header_navbar.php','UserDetails.view.php','templates/footer.view.php'),$data);
    }
    }
    
    private function checkEmptyDir($nombre,$provincia,$ciudad,$cod_postal,$calle):bool{
        $dir = array(
            'nombre' => $nombre,
            'provincia' => $provincia,
            'ciudad' => $ciudad,
            'cod_postal' => $cod_postal,
            'calle' => $calle
        );
        
        $cont  = 0;
        foreach($dir as $x => $val) {
          if(strlen(trim($val)) != 0){
              $cont++;
          }
        }
        return $cont == count($dir);
    }
    
    
    
    
    private function checkForm(array $post, bool $edit = true): array{

        $model = new \Com\Daw2\Models\UsuarioSistemaModel();
        $errores = [];
                
        if(!$edit){
            if(strlen(trim($post['password'])) == 0 || strlen(trim($post['password2'])) == 0){
            $errores['password'] = 'No se admiten valores vacios';
            }
        }else{
             if(empty($post['nombre_usuario'])){
                    $errores['nombre_usuario'] = 'No se admiten valores vacios';
                }else if(strlen(trim($post['nombre_usuario'])) == 0){
                    $errores['nombre_usuario'] = 'No se admiten cadenas vacías';
                }
                else if($model->occupiedUserName((int)$_SESSION['usuario']['id_usuario'],$post['nombre_usuario'])){
                    $errores['nombre_usuario'] = 'El nombre que has escrito ya se encuentra en uso.';
                }

                //EMAIL
                if(!filter_var($post['email'],FILTER_VALIDATE_EMAIL)){
                    $errores['email'] = 'Formato de correo incorrecto';
                }
                else if($model->occupiedMail((int)$_SESSION['usuario']['id_usuario'],$post['email'])){
                  $errores['email'] = 'El correo que deseas escoger ya está en uso';  
                }

                //CONTRASEÑA

                if($post['password'] != $post['password2']){
                    $errores['password'] = 'Las contraseñas no coinciden.';
                }
                if(!empty($post['password']) || !empty($post['password'])){
                          if(!preg_match(self::_PATRON_PASSWORD,$post['password']) || !preg_match(self::_PATRON_PASSWORD,$post['password2'])){
                     $errores['password'] = 'formato de contraseña incorrecto.';
                 }  
                }

                //DINERO
                if(!empty($post['cartera'])){
                    if(!filter_var($post['cartera'],FILTER_VALIDATE_FLOAT)){
                    $errores['cartera'] = 'El valor introducido debe de ser un número decimal';
                }else if($post['cartera'] <= 0){
                    $errores['cartera'] = 'No se puede introducir un valor igual o inferior a 0';
                }
                }


                //NOMBRE TITULAR
                if(strlen(trim($post['nombre_titular'])) != 0){
                      if(!preg_match('/[a-zA-Z ]+/',$post['nombre_titular'])){
                     $errores['nombre_titular'] = 'sólo se admiten letras en el nombre del titular';
                }   
                }

                //Provincia
                if(strlen(trim($post['provincia'])) != 0){
                     if(!preg_match('/[a-zA-Z ]+/',$post['provincia'])){
                     $errores['provincia'] = 'sólo se admiten letras en el nombre de la provincia';
                    }   
                }


                //Ciudad
                if(strlen(trim($post['ciudad'])) != 0){
                if(!preg_match('/[a-zA-Z ]+/',$post['ciudad'])){
                 $errores['ciudad'] = 'sólo se admiten letras en el nombre de la ciudad';  
                }
               
                }

                //COD POSTAL
                if(strlen(trim($post['cod_postal'])) != 0){
                if(!preg_match('/[0-9]{5}/',$post['cod_postal'])){
                        $errores['cod_postal'] = 'El código postal debe de estar compuesto por 5 cifras';
                    }
                }
                //Calle
                if(strlen(trim($post['calle'])) != 0){
                 if(!preg_match('/[a-zA-Z0-9 \,\.]+/',$post['calle'])){
                     $errores['calle'] = 'caracteres inválidos a la hora de declarar el nombre de calle.';
                }
                }
        }
        
        
        //Devolver errores
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