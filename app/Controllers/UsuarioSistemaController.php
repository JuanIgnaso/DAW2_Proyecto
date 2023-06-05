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
        $dirModel =  new \Com\Daw2\Models\DireccionEnvioModel();
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
            //Comprobar que el usuario tiene una direccion de envío asignada
            if(!is_null($dir = $dirModel->getUserShippingAddress($_SESSION['usuario']['id_usuario']))){
              $_SESSION['usuario']['direccion'] = $dir;  
            }
            
            $model->updateLastLogin($_POST['email']);
            if(!empty($_vars['remember'])){
                //Creamos la Cookie de nombre usuario y password
                setcookie('email',$_SESSION['usuario']['email'],time()+3600*24*7);
                setcookie('password',$_POST['pass'],time()+3600*24*7);

            }else{
                //Hacemos caducar las cookies.
                setcookie('email',$_SESSION['usuario']['email'],time() - 3600);
                setcookie('password',$_POST['pass'],time() - 3600);
            }
            header('Location: /');
          
            
        }
        $this->view->show('login.php',$_vars);
    }
    
    
    private function getPermisos(int $id_rol):array{
        $permisos = array();
        if($id_rol == self::USUARIO_REGISTRADO){
         $permisos = array('comprar' => ['r','w','d']);
        }
        if($id_rol == self::MANEJO_INVENTARIO){
           $permisos = array(
               'comprar' => ['r','w','d'],
               'inventario' => ['r','w','d']
               ); 
        }
        if($id_rol == self::ADMINISTRADOR){
            $permisos = array(
                'usuarios' => ['r','w','d'],
                'inventario' => ['r','w','d'],
                'proveedores' => ['r','w','d'],
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
        $dirModel =  new \Com\Daw2\Models\DireccionEnvioModel();

        $_vars['loginError'] = $this->checkRegister($_POST);
        if(count($_vars['loginError']) == 0){
           $model = new \Com\Daw2\Models\UsuarioSistemaModel();
           if($model->addUser($_POST,true)){
              $usuario = $model->login($_POST);
              $_SESSION['usuario'] = $usuario;
              $_SESSION['permisos'] = $this->getPermisos($_SESSION['usuario']['id_rol']); 
              if(!is_null($dir = $dirModel->getUserShippingAddress($_SESSION['usuario']['id_usuario']))){
              $_SESSION['usuario']['direccion'] = $dir;  
            }

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
        
        
        if(empty($post['pass'])){
            $loginError['password'] = 'Debes darle una contraseña';
        }else if(strlen(trim($post['pass'])) == 0){
          $loginError['pass'] = 'No de admiten cadenas vacías';
         } else  if(!preg_match(self::_PATRON_PASSWORD,$post['pass'])){
           $loginError['password'] = 'formato de contraseña incorrecto.';    
         }
         
         
         return $loginError;
    }
    
    
    
    //ADMINISTRACION DE USUARIOS
    //Mostrar Lista de usuarios existentes
    
    public function showUsersList(){
        
     $model = new \Com\Daw2\Models\UsuarioSistemaModel();
     $rolModel = new \Com\Daw2\Models\RolModel();

 
     $data = []; 
     $data['input'] = filter_var_array($_GET,FILTER_SANITIZE_SPECIAL_CHARS);
     $data['usuarios'] = $model->filterAll($_GET);
     $data['id_rol'] = $rolModel->getUsersRol();
     $data['seccion'] = '/inventario/UsuariosSistema';
     $data['titulo'] = 'Inventario Usuarios Web';
     $data['tipo'] = 'Usuarios';

     
       $copiaGET = $_GET;
        unset($copiaGET['order']);
        if(count($copiaGET) > 0){
           $data['queryString'] = "&".http_build_query($copiaGET);
        }else{
          $data['queryString'] = "";
       }
     
     
    $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','UsersList.view.php'),$data); 

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
        $data['input'] = $_SESSION['usuario'];
        unset($data['input']['cartera']);
        $data['info_usuario'] = $input;
        unset($data['info_usuario']['cartera']);



        $this->view->showViews(array('templates/header_my_profile.view.php','templates/header_navbar.php','UserDetails.view.php','templates/footer.view.php'),$data);

    }
    
    
    //EDITAR PERFIL
    function editProfile(){
        $data = [];
          $modelDir = new \Com\Daw2\Models\DireccionEnvioModel();
        $modelCategoria = new \Com\Daw2\Models\CategoriaModel();
        $data['categoria'] = $modelCategoria->getAll();
        $data['seccion'] = '/mi_Perfil/edit';
        $data['titulo'] = 'Modificar Mi Perfil';
        $data['errores'] = $this->checkForm($_POST);

        $input = $_SESSION['usuario'];

        if(count($data['errores']) == 0){
                if($this->checkEmpty($_POST)){
                $data['errores2'] = $this->checkForm2($_POST); 
               if(count($data['errores2']) == 0){
                 $dir = $modelDir->insertShippingAddress($_POST,$_SESSION['usuario']['id_usuario']);  

               } 
          }else{
              $dir = true;
          }

        $saneado = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        $model = new \Com\Daw2\Models\UsuarioSistemaModel();
        $usuario = $model->editUser($_POST,$_SESSION['usuario']['pass'],$_SESSION['usuario']['id_usuario']);           

            if($usuario && $dir){
                 $_SESSION['usuario'] = $model->updateUserSession($_SESSION['usuario']['id_usuario']);
                 $_SESSION['usuario']['direccion'] = $modelDir->getUserShippingAddress($_SESSION['usuario']['id_usuario']);
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
    
    
    
    
    //EDITAR FOTO DE PERFIL
    function editProfilePhoto(){
        
        $error = [];
        
        if(empty($_FILES['image']) || !isset($_FILES['image'])){
            http_response_code(400);  
            $error['error']  = "No has subido ningún archivo.";
            echo json_encode($error);

         exit;
        }
        
        
        $model = new \Com\Daw2\Models\UsuarioSistemaModel();
        $src = $_FILES['image']['tmp_name']; //nombre de archivo temporal
        
        

        //Nombre imagen
        $filename = $_FILES['image']['name']; //nombre del archivo definitivo


        //directorio de destino
        //$dir = "imagenes/".$filename;
        $dir = "assets/img/profiles/id".$_SESSION['usuario']['id_usuario'].'/';
        $output_dir = $dir.basename($_FILES['image']['name']);
        

        //Tipo de archivo
        $imageFileType = strtolower(pathinfo($output_dir,PATHINFO_EXTENSION));

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
          http_response_code(400);  
            echo   "Lo sentimos, solo archivos con extensión JPG, JPEG, PNG & GIF están permitidos.";
            
          //texto de error o array de errores que quieres mostrarle al usuario (se lo  envias a Ajax)
         exit;   
       
        }

        //Si el directorio no existe
        if(!is_dir($dir)){
            mkdir($dir, 0775, true);
        }
        
        //Borrar la imagen anterior     

        if (move_uploaded_file($src, $output_dir )) {
              if (!is_null($_SESSION['usuario']['profile_image'])) { //Si no es NULL se borra la foto anterior
                unlink(substr($_SESSION['usuario']['profile_image'],1,strlen($_SESSION['usuario']['profile_image'])));
              }
              
            if($model->updateUserAvatar($_SESSION['usuario']['id_usuario'],'/'.$output_dir)){
                http_response_code(200);
                 echo "El archivo ".$filename."Se acaba de subir correctamente";
            }
        } else{
        http_response_code(400);     
        $error['error']  = "Error! No se ha podido subir el archivo: ".$filename;
        echo json_encode($error); 
        exit;
        };
    }
    
    
    
    private function checkEmptyDir($var):bool{
        
        $cont  = 0;

        return strlen(trim($var)) == 0;
    }
    
    
    private function checkEmpty(array $post):bool{
      
        $dir = array(
           'nombre' => $post['nombre_titular'],
            'provincia' => $post['provincia'],
            'ciudad' => $post['ciudad'],
           'cod_postal' => $post['cod_postal'],
            'calle' => $post['calle']
        );
        
        $cont  = 0;
        foreach($dir as $x => $val) {
         if(empty($val)){
             $cont++;
         }
       }

        return $cont == 0;
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

        }
        
        
        //Devolver errores
        return $errores;

    }
    
    
   private function checkForm2(array $post): array{
       $errores = [];
       
       
               //NOMBRE TITULAR
        if(strlen(trim($post['nombre_titular'])) != 0){
              if(!preg_match('/[a-zA-Z ]+/',$post['nombre_titular'])){
             $errores['nombre_titular'] = 'sólo se admiten letras en el nombre del titular';
        }   
           if($this->checkEmptyDir($post['nombre_titular'])){
           $errores['nombre_titular'] = 'Tienes que cubrir todos los campos';
       }
        }
        //Provincia
        if(strlen(trim($post['provincia'])) != 0){
             if(!preg_match('/[a-zA-Z ]+/',$post['provincia'])){
             $errores['provincia'] = 'sólo se admiten letras en el nombre de la provincia';
            }  

            if($this->checkEmptyDir($post['provincia'])){
           $errores['provincia'] = 'Tienes que cubrir todos los campos';
       }
        }


        //Ciudad
        if(strlen(trim($post['ciudad'])) != 0){
            if(!preg_match('/[a-zA-Z ]+/',$post['ciudad'])){
             $errores['ciudad'] = 'sólo se admiten letras en el nombre de la ciudad';  
            }
            if($this->checkEmptyDir($post['ciudad'])){
               $errores['ciudad'] = 'Tienes que cubrir todos los campos';
            }
        }

        //COD POSTAL
        if(strlen(trim($post['cod_postal'])) != 0){
            if(!preg_match('/[0-9]{5}/',$post['cod_postal'])){
                    $errores['cod_postal'] = 'El código postal debe de estar compuesto por 5 cifras';
            }
            if($this->checkEmptyDir($post['cod_postal'])){
               $errores['cod_postal'] = 'Tienes que cubrir todos los campos';
            }
        }


        //Calle
        if(strlen(trim($post['calle'])) != 0){
             if(!preg_match('/[a-zA-Z0-9 \,\.]+/',$post['calle'])){
                 $errores['calle'] = 'caracteres inválidos a la hora de declarar el nombre de calle.';
            }
            if($this->checkEmptyDir($post['calle'])){
               $errores['calle'] = 'Tienes que cubrir todos los campos';
           }
        }
       
        return $errores;
    }
    
   
    function darDeBajaUsuario(){
    
        $model = new \Com\Daw2\Models\UsuarioSistemaModel();
        $nombre = $_POST['dato'];
        $d = [
            "hola" => "adios"
        ];
        $var = $model->darDeBaja($nombre);
        if($var){
            
             http_response_code(200);         
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
    
    
    
    function borrarUsuarioWeb(){
        $model = new \Com\Daw2\Models\UsuarioSistemaModel();
        $nombre = $_POST['usuario'];
        $d = [
            "hola" => "adios"
        ];
        $var = $model->deleteUser($nombre);
        if($var){
            
             http_response_code(200);
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