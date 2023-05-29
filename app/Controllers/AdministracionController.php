<?php



namespace Com\Daw2\Controllers;

class AdministracionController extends \Com\Daw2\Core\BaseController{
   
    
    
    public function showAdministracion(){
        $modelCategoria = new \Com\Daw2\Models\CategoriaModel();
        $data = [];
        $data['titulo'] = 'Tramitando Pedido';
        $data['categoria'] = $modelCategoria->getAll();
        
        $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','Administracion.view.php'),$data);     
    }
    
    
    
    public function showEditUser($id){
         $model = new \Com\Daw2\Models\UsuarioSistemaModel();
         $rolModel = new \Com\Daw2\Models\RolModel();   
         $data = [];
         $data['id_rol'] = $rolModel->getUsersRol();
         $data['titulo'] = 'Modificar Usuario';
         $data['volver'] = '/inventario/UsuariosSistema';
         $data['titulo_seccion'] = 'Modificar Usuario';
         $data['seccion'] = '/inventario/UsuariosSistema/edit/'.$id;
         $data['accion'] = 'Aplicar Cambios'; 
         $input = $model->getUser($id);
         unset($input['pass']);
         $data['input'] = $input;

        $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddUser.view.php'),$data);      
    }
    
    
    function edit($id){
        $model = new \Com\Daw2\Models\UsuarioSistemaModel();
        $rolModel = new \Com\Daw2\Models\RolModel();  
        $data = [];
        $data['errores'] = $this->checkForm($_POST,$alta = false);
        if(count($data['errores']) == 0){
          if($model->editUserWeb($_POST)){
            unset($_POST['pass']);
              $_SESSION['action'] = 'ambios realizados con éxito';
              $data['id_rol'] = $rolModel->getUsersRol();
               $data['titulo'] = 'Modificar Usuario';
               $data['seccion'] = '/inventario/UsuariosSistema/edit/'.$id;
               $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
               $data['volver'] = '/inventario/UsuariosSistema';
               $data['accion'] = 'Aplicar Cambios';
                
               $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddUser.view.php'),$data);      


          }else{
              
                 $_SESSION['action'] = 'Ha ocurrido un error al intentar intentar aplicar los cambios';
                 unset($_POST['pass']);
                 $_SESSION['action'] = 'ambios realizados con éxito';
                $data['id_rol'] = $rolModel->getUsersRol();
               $data['titulo'] = 'Modificar Usuario';
               $data['seccion'] = '/inventario/UsuariosSistema/edit/'.$id;
               $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
               $data['volver'] = '/inventario/UsuariosSistema';
               $data['accion'] = 'Aplicar Cambios';
                
               $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddUser.view.php'),$data);      
          }  
        }else{
           
           $data['id_rol'] = $rolModel->getUsersRol();
           $data['titulo'] = 'Modificar Usuario';
           $data['seccion'] = '/inventario/UsuariosSistema/edit/'.$id;
           $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
           $data['volver'] = '/inventario/UsuariosSistema';
           $data['accion'] = 'Aplicar Cambios'; 
        
           $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddUser.view.php'),$data);      
        }
    }
    
    
    public function showAddUser(){

         $model = new \Com\Daw2\Models\UsuarioSistemaModel();
         $rolModel = new \Com\Daw2\Models\RolModel();

         $data = [];
         $data['id_rol'] = $rolModel->getUsersRol();
         $data['titulo'] = 'Registrar Nuevo Usuario';
         $data['volver'] = '/inventario/UsuariosSistema';
         $data['titulo_seccion'] = 'Añadir Nuevo Usuario';
         $data['seccion'] = '/inventario/UsuariosSistema/add';
         $data['accion'] = 'Añadir';

        $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddUser.view.php'),$data);     


    }
    

    function addUser(){
       $rolModel = new \Com\Daw2\Models\RolModel();
       $model = new \Com\Daw2\Models\UsuarioSistemaModel();
       $data = [];
       $data['titulo'] = 'Añadir Usuarios(Provisional)';
       $data['volver'] = '/inventario/UsuariosSistema';
       $data['errores'] = $this->checkForm($_POST);
       $data['seccion'] = '/inventario/UsuariosSistema/add';
       
       //Si no hay errores
       if(count($data['errores']) == 0){
            $model = new \Com\Daw2\Models\UsuarioSistemaModel();
            if($model->addUser($_POST)){
                header('location: /inventario/UsuariosSistema');   
            }else{
             $_SESSION['action'] = 'Ha ocurrido un error al intentar añadir el producto';
             $_SESSION['action']['background'] = 'bg-danger';
            }
  
       }else{
        $data['seccion'] = '/inventario/UsuariosSistema/add';
        $data['id_rol'] = $rolModel->getUsersRol();
        $data['accion'] = 'Añadir';
        $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddUser.view.php'),$data);     
       } 
 
    }
    
    
    private function checkForm(array $post, bool $alta = true): array{
        
       $errores = []; 
       $rolModel = new \Com\Daw2\Models\RolModel();
       $model = new \Com\Daw2\Models\UsuarioSistemaModel();
       
       if($alta){
          if($model->isUserNameUsed($post['nombre_usuario'])){
            $errores['nombre_usuario'] = 'nombre de usuario ya está en uso.'; 
          }
          
          if($model->isEmailUsed($post['email'])){
            $errores['email'] = 'dirección de correo ya está en uso.'; 
          }
          
         if(empty($post['pass'])){
           $errores['pass'] = 'Debes de asignar una contraseña';
         }
       }
       
       
       
       if(empty($post['nombre_usuario'])){
           $errores['nombre_usuario'] = 'No se permiten valores vacíos';
       }else if(strlen(trim($post['nombre_usuario'])) == 0){
            $errores['nombre_usuario'] = 'No se puede crear un nombre de usuario con solo espacios.'; 
       }else if(!preg_match('/[a-zA-Z0-9-_\s]{5,}/',$post['nombre_usuario'])){
            $errores['nombre_usuario'] = 'nombre de usuario no permitido.'; 
       }else if($model->occupiedUserName($post['id_usuario'], $post['nombre_usuario'])){
           $errores['nombre_usuario'] = 'nombre de usuario ya está en uso por otra persona.'; 
       }
       
       
       if(empty($post['email'])){
           $errores['email'] = 'No se permiten valores vacíos';
       }else if(strlen(trim($post['email'])) == 0){
            $errores['email'] = 'No se puede asignar un correo de usuario con solo espacios.'; 
       }else if(!filter_var($post['email'],FILTER_VALIDATE_EMAIL)){
            $errores['email'] = 'correo de usuario no permitido.'; 
       }else if($model->occupiedMail($post['id_usuario'], $post['email'])){
               $errores['email'] = 'direccion de correo ya está en uso por otra persona.'; 
       }  
       
       
       if(empty($post['id_rol'])){
           $errores['id_rol'] = 'Selecciona un rol de usuario';
       }else if(!$rolModel->rolExists($post['id_rol'])){
          $errores['id_rol'] = 'Rol Seleccionado no existe';
       }
      
        if(!empty($post['pass'])){
                if(!preg_match('/[a-zA-Z0-9-_\*\.]{6,}/',$post['pass'])){
                $errores['pass'] = 'Contraseña incorrecta, debe de tener al menos 6 caracteres de largo con letras numeros o caracteres * - _ .'; 
            }
        }   

       
       return $errores;
    }

    
}

