<?php

namespace Com\Daw2\Controllers;

class ProveedorController extends \Com\Daw2\Core\BaseController{
    
    public function showProveedores(){
        $model = new \Com\Daw2\Models\ProveedorModel();
        
        $data = [];
        $data['seccion'] = '/inventario/Proveedores';
        $data['tipo'] = 'Proveedores';
        $data['titulo'] = 'Inventario Proveedores';
        $data['input'] = filter_var_array($_GET,FILTER_SANITIZE_SPECIAL_CHARS);
        $data['proveedores'] = $model->filterAll($_GET);
     
        $copiaGET = $_GET;
        unset($copiaGET['order']);
        if(count($copiaGET) > 0){
            $data['queryString'] = "&".http_build_query($copiaGET);
        }else{
            $data['queryString'] = "";
        }
          
        $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','Proveedores.view.php'),$data); 
    }
    
    
    function deleteProveedor(){
        $codigo_proveedor = $_POST['producto'];
        $model =  new \Com\Daw2\Models\ProveedorModel();
        $accion = $model->deleteProveedor($codigo_proveedor);
        
        if($accion){
         http_response_code(200); 
         echo json_encode(["hola"=>"todo correcto."]); //texto de error o array de errores que quieres mostrarle al usuario (se lo  envias a Ajax)

        }else{
        http_response_code(400);  
          echo json_encode(["algo salió mal."]); //texto de error o array de errores que quieres mostrarle al usuario (se lo  envias a Ajax)

        }
        
    }
      
    
    function showAdd(){
        
        $model = new \Com\Daw2\Models\ProveedorModel();

        $data = [];
        $data['titulo_seccion'] = 'Añadir Proveedor';
        $data['accion'] = 'Añadir';
        $data['seccion'] = '/inventario/Proveedores/add';

        $data['tipo'] = 'Proveedores';
        $data['volver'] = '/inventario/Proveedores';
        $data['titulo'] = 'Añadir Proveedor';
       $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddProveedor.view.php'),$data); 
    }
    
    
    public function add(){
        
        $model = new \Com\Daw2\Models\ProveedorModel();

          $data = [];

          $data['errores'] = $this->checkForm($_POST);
        $data['titulo_seccion'] = 'Añadir Proveedor';
        $data['accion'] = 'Añadir';
        $data['seccion'] = '/inventario/Proveedores/add';

        $data['tipo'] = 'Proveedores';
        $data['volver'] = '/inventario/Proveedores';
        $data['titulo'] = 'Añadir Proveedor';
          
          if(count($data['errores']) == 0){
              $result = $model->insertProveedor($_POST);
              if($result){
                header('location: '.$data['volver']);   
            }else{
                 $_SESSION['error_añadir'] = 'Ha ocurrido un error al intentar añadir el producto';
                }
          }else{
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data['titulo_seccion'] = 'Añadir Proveedor';
            $data['accion'] = 'Añadir';
            $data['seccion'] = '/inventario/Proveedores/add';

            $data['tipo'] = 'Proveedores';
            $data['volver'] = '/inventario/Proveedores';
            $data['titulo'] = 'Añadir Proveedor';

             $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddProveedor.view.php'),$data); 

          }
    }
       
      
    function showEdit($cod){
       $model = new \Com\Daw2\Models\ProveedorModel();

       $data = [];      
       $input = $model->getProveedor($cod);
        $data['seccion'] = '/inventario/Proveedores/edit/'.$cod;
        $data['titulo'] = 'Editar Proveedor';
        $data['titulo_seccion'] = 'Modificar Proveedor';
        $data['accion'] = 'Aplicar Cambios';
        $data['volver'] = '/inventario/Proveedores';
        $data['input'] = $input;
        
       $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddProveedor.view.php'),$data);     
    } 
    
    
    public function edit($cod){
      $model = new \Com\Daw2\Models\ProveedorModel();
      $data = [];      
      $data['errores'] = $this->checkForm($_POST,$alta = false);
       if(count($data['errores']) == 0){
         $saneado = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
         $model->editProveedor($_POST);
         if($model){
          header('location: /inventario/Proveedores');    
         }else{
          $_SESSION['error_añadir'] = 'Ha ocurrido un error al intentar añadir el proveedor';
         }
       }else{
           $data['titulo'] = 'Editar Proveedor';
           $data['titulo_seccion'] = 'Modificar Proveedor';
           $data['seccion'] = '/inventario/Proveedores/edit/'.$cod;
           $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
           $data['volver'] = '/inventario/Proveedores';
           $data['accion'] = 'Aplicar Cambios';
           
           $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddProveedor.view.php'),$data);     
        }
    }
    
    
    
   private function checkForm(array $post, bool $alta = true):array{
        
      $errores = [];  
        
      $model = new \Com\Daw2\Models\ProveedorModel();

      if(empty($post['nombre_proveedor'])){
          $errores['nombre_proveedor'] = 'Debes escribir un nombre';
      }else if(strlen(trim($post['nombre_proveedor'])) == 0){
         $errores['nombre_proveedor'] = 'no se aceptan cadenas vacías'; 
      }else if(!preg_match('/[a-zA-Z0-9\s]{5,}/',$post['nombre_proveedor'])){
       $errores['nombre_proveedor'] = 'nombre de proveedor inválido, debe de tener al menos 5 caracteres de largo';   
      }else if($model->nombreOcupado($post)){
        $errores['nombre_proveedor'] = 'nombre de proveedor ocupado por otro proveedor';  
      }
      if($alta){
          
         if($model->nombreExists($post['nombre_proveedor'])){
      $errores['nombre_proveedor'] = 'nombre de proveedor ya está en uso.';   
      } 
          
         if($model->direccionExists($post['direccion'])){
      $errores['direccion'] = 'nombre de direccion ya está en uso.';   
      } 
      }
      
      if(empty($post['direccion'])){
          $errores['direccion'] = 'Debes escribir una direccion';
      }else if(strlen(trim($post['direccion'])) == 0){
         $errores['direccion'] = 'no se aceptan cadenas vacías'; 
      }else if(!preg_match('/[a-zA-Z0-9º\s]{5,}/',$post['direccion'])){
       $errores['direccion'] = 'nombre de direccion inválido, debe de tener al menos 5 caracteres de largo';   
      } else if($model->direccionOcupada($post)){
          $errores['direccion'] = 'Direccion en uso por otro proveedor'; 
      }
      
      if(empty($post['website'])){
          $errores['website'] = 'Debes escribir una website';
      }else if(strlen(trim($post['website'])) == 0){
         $errores['website'] = 'no se aceptan cadenas vacías'; 
      }else if(!filter_var($post['website'],FILTER_VALIDATE_DOMAIN)){
       $errores['website'] = 'nombre de website inválido';   
      }
      
      if(empty($post['email_proveedor'])){
          $errores['email_proveedor'] = 'Debes escribir un correo';
      }else if(strlen(trim($post['email_proveedor'])) == 0){
         $errores['email_proveedor'] = 'no se aceptan cadenas vacías'; 
      }else if(!filter_var($post['email_proveedor'],FILTER_VALIDATE_EMAIL)){
       $errores['email_proveedor'] = 'nombre de correo inválido';   
      }
     
      
       if(strlen(trim($post['telefono'])) == 0){
         $errores['telefono'] = 'no se aceptan cadenas vacías'; 
      }else if(!preg_match('/[0-9]{9}/',$post['telefono'])){
       $errores['telefono'] = 'el número de telefono se debe de componer de 9 cifras';   
      }
     
     
      return $errores;
        
    }
     
    
}
