<?php
namespace Com\Daw2\Controllers;

class ConsolasController extends \Com\Daw2\Core\BaseProductController{
    
   /*Muestra la lista de productos*/
    public function showListaConsolas(){
        $model =  new \Com\Daw2\Models\ConsolasModel();
        $modelConexiones = new \Com\Daw2\Models\AuxModelConexionesRaton();
        
        $data = [];
        $data['seccion'] = '/inventario/Consolas';
        $data['tipo'] = 'Consolas';
        $data['titulo'] = 'Inventario Consolas';
        $data['productos'] = $model->filterAll($_GET);
        $data['conexiones'] = $modelConexiones->getAll();
        $data['input'] = filter_Var_Array($_GET,FILTER_SANITIZE_SPECIAL_CHARS);

                
        $copiaGET = $_GET;
        unset($copiaGET['order']);
        if(count($copiaGET) > 0){
            $data['queryString'] = "&".http_build_query($copiaGET);
        }else{
            $data['queryString'] = "";
        }
        
        
        $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','Consolas.view.php'),$data); 
    }
    
    /*Muestra la vista para añadir*/
    function showAdd(){
        $model =  new \Com\Daw2\Models\ConsolasModel();
        $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();
        $modelConexiones = new \Com\Daw2\Models\AuxModelConexionesRaton();


        $data = [];
        $data['titulo_seccion'] = 'Añadir Consola';
        $data['accion'] = 'Añadir';
        $data['seccion'] = '/inventario/Consolas/add';
        $data['tipo'] = 'Consolas';
        $data['volver'] = '/inventario/Consolas';
        $data['titulo'] = 'Añadir Producto';
        $data['id_conexion'] = $modelConexiones->getAll();
        $data['proveedor'] = $modelProv->getAll();
        $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddConsolas.view.php'),$data); 
    }
    
    /*Añade el producto*/
    function add(){
        $model =  new \Com\Daw2\Models\ConsolasModel();
        $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();
        $modelConexiones = new \Com\Daw2\Models\AuxModelConexionesRaton();

        $data = [];
        $data['titulo_seccion'] = 'Añadir Consola';
        $data['accion'] = 'Añadir';
        $data['seccion'] = '/inventario/Consolas/add';
        $data['tipo'] = 'Consolas';
        $data['volver'] = '/inventario/Consolas';
        $data['errores'] = $this->checkForm($_POST);
        if(count($data['errores']) == 0){
            
            
        if(!empty($_FILES["imagen"]["tmp_name"])){
             $upload = new \Com\Daw2\Helpers\FileUpload('assets/img/consolas/');
  
            
            
        if($upload->uploadPhoto()){
             $_POST['imagen_p'] = '/assets/img/consolas/'.$_FILES["imagen"]["name"];
           }       
        }   
            
            
          $result = $this->addConsola(6,$_POST);
          if($result){
            header('location: '.$data['volver']);
            $_SESSION['action'] = 'Se ha añadido el elemento con éxito';

        }else{
            $_SESSION['error_añadir'] = 'Ha ocurrido un error al intentar añadir el producto';
            $data['seccion'] = '/inventario/Consolas/add';
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data['proveedor'] = $modelProv->getAll();
            $data['volver'] = '/inventario/Consolas';
            $data['id_conexion'] = $modelConexiones->getAll();


            $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddConsolas.view.php'),$data); 
        }
        }else{
            
            $data['seccion'] = '/inventario/Consolas/add';
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data['proveedor'] = $modelProv->getAll();
            $data['volver'] = '/inventario/Consolas';
            $data['id_conexion'] = $modelConexiones->getAll();


            $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddConsolas.view.php'),$data); 
        }
    }
    

    
    /*Añade el producto a la base de datos*/    
    private function addConsola(int $categoria,array $post): bool{
      $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
      $model =  new \Com\Daw2\Models\ConsolasModel();

      
      if($modelGeneral->insertProduct($categoria,$post,self::IVA)){
          if($model->insertConsola($post)){
              return true;
          }else{
              return false;
          }
      }else{
          return false;
      }

    }
    
    /*Muestra la vista para añadir*/
    function showEdit($cod){
       $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();
        $model =  new \Com\Daw2\Models\ConsolasModel();
        $modelConexiones = new \Com\Daw2\Models\AuxModelConexionesRaton();


       $data = [];
       $input = $model->getProducto($cod);
        $data['seccion'] = '/inventario/Consolas/edit/'.$cod;
        $data['proveedor'] = $modelProv->getAll();
        $data['titulo'] = 'Editar Producto';
        $data['titulo_seccion'] = 'Modificar Consola';
        $data['accion'] = 'Aplicar Cambios';
        $data['volver'] = '/inventario/Consolas';
        $data['input'] = $input;
        $data['id_conexion'] = $modelConexiones->getAll();


        
       $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddConsolas.view.php'),$data);     
    }
    
    
    /*funcion para editar el producto*/
    public function edit($cod){
       $modelConexiones = new \Com\Daw2\Models\AuxModelConexionesRaton();
       $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();
       $model =  new \Com\Daw2\Models\ConsolasModel();
         $data = [];
         $data['errores'] = $this->checkForm($_POST,$alta = false);
         $data['volver'] = '/inventario/Consolas';

          if(count($data['errores']) == 0){
           $saneado = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
           $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
           
           
           $urlimg = $modelGeneral->getProductImg($_POST['codigo_producto']);
           
             if(!empty($_FILES["imagen"]["tmp_name"]) && $urlimg != NULL){
             unlink(substr($urlimg,1,strlen($urlimg)));
              
              $upload = new \Com\Daw2\Helpers\FileUpload('assets/img/consolas/');

              
                   if($upload->uploadPhoto()){
                     $_POST['imagen_p'] = '/assets/img/consolas/'.$_FILES["imagen"]["name"];
                   }       
              }else{
                $_POST['imagen_p'] = $urlimg;
              }           
                 
            $result = $this->modifyConsola($_POST['id_consola'],$_POST['codigo_producto'],$_POST);
            if($result){
               header('location: '.$data['volver']);
               $_SESSION['action'] = 'Cambios realizados con éxito';
            }else{
                
                $_SESSION['error_añadir'] = 'Ha ocurrido un error al intentar editar el producto';
                $data['seccion'] = '/inventario/Consolas/edit/'.$cod;
                $data['proveedor'] = $modelProv->getAll();
                $data['titulo'] = 'Editar Producto';
                $data['titulo_seccion'] = 'Modificar Consola';
                $data['accion'] = 'Aplicar Cambios';
                $data['volver'] = '/inventario/Consolas';
                $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
                $data['input']['url_imagen'] = $_POST['imagen'];
                $data['id_conexion'] = $modelConexiones->getAll();

                $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddConsolas.view.php'),$data);  
                 
            }
            
        }else{    
         
            $data['seccion'] = '/inventario/Consolas/edit/'.$cod;
            $data['proveedor'] = $modelProv->getAll();
            $data['titulo'] = 'Editar Producto';
            $data['titulo_seccion'] = 'Modificar Consola';
            $data['accion'] = 'Aplicar Cambios';
            $data['volver'] = '/inventario/Consolas';
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data['input']['url_imagen'] = $_POST['imagen'];
             $data['id_conexion'] = $modelConexiones->getAll();

            $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddConsolas.view.php'),$data);     
        }
    }
    
    
    /*Ejecuta la modificación a la base de datos*/
    private function modifyConsola($idMon,$id,array $post): bool{
      $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
      $model =  new \Com\Daw2\Models\ConsolasModel();

      
      if($modelGeneral->editProduct($post,$id,self::IVA)){
          if($model->editConsola($post)){
              return true;
          }else{
              return false;
          }
      }else{
          return false;
      }

    }

      
    
    
    
    /*Función para comprobar el formulario del producto*/
    private function checkForm(array $post, bool $alta = true):array{
        
      $errores = []; 
      $model = new \Com\Daw2\Models\ConsolasModel(); 
      $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();
      $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
      $modelConec  = new \Com\Daw2\Models\AuxModelConexionesRaton();

      if(empty($post['nombre'])){
          $errores['nombre'] = 'Tienes que escribir un nombre';
      }else if(strlen(trim($post['nombre'])) == 0){
          $errores['nombre'] = 'No se aceptan cadenas vacías';
      }  
        else if($modelGeneral->occupiedProductName($post['nombre'],$post['codigo_producto'])){
        $errores['nombre'] = 'El nombre del producto ya está en uso';
           }else
        if($alta){
         if($modelGeneral->productNameExists($post['nombre'])){
        $errores['nombre'] = 'El nombre del producto que intentas registrar ya existe';
        }
           
      } 
  
      if(empty($post['marca'])){
          $errores['marca'] = 'Tienes que escribir una marca';
      }else if(strlen(trim($post['marca'])) == 0){
          $errores['marca'] = 'No se aceptan cadenas vacías';
      }else if(!preg_match('/[a-zA-Z0-9\s]+/',$post['marca'])){
          $errores['marca'] = 'nombre de marca no válido';
      }
      
      if(empty($post['precio_bruto'])){
            $errores['precio_bruto'] = 'Este campo es obligatorio';
        }else if(!filter_var($post['precio_bruto'],FILTER_VALIDATE_FLOAT)){
            $errores['precio_bruto'] = 'El valor introducido debe de ser un número decimal';
        }else if($post['precio_bruto'] <= 0){
        $errores['precio_bruto'] = 'No se puede introducir un valor igual o inferior a 0';
       }
      
        
      
       if(empty($post['stock'])){
            $errores['stock'] = 'Este campo es obligatorio';
        }else if(!filter_var($post['stock'],FILTER_VALIDATE_INT)){
            $errores['stock'] = 'El valor introducido debe de ser un número entero';
        }else if($post['stock'] <= 0){
            $errores['stock'] = 'No se puede introducir un valor igual o inferior a 0';
        }
      
      if(empty($post['proveedor'])){
          
      $errores['proveedor'] = 'Elige un proveedor';
  
      }  
      else if(!$modelProv->proveedorExists($post['proveedor'])){
          $errores['proveedor'] = 'El proveedor que has seleccionado no existe';
      }else if(empty((int)$post['proveedor'])){
          $errores['proveedor'] = 'Debes seleccionar un proveedor';
      }
     
       if(empty($post['juego_incluido']) && strlen(trim($post['marca'])) == 0){
          $errores['juego_incluido'] = 'No se aceptan cadenas vacías';
      }

      if(!isset($post['manual_usuario'])){
          $errores['manual_usuario'] = 'debes escoger una de las dos opciones';
      }else if($post['manual_usuario'] != 'Si' && $post['manual_usuario'] != 'No'){
          $errores['manual_usuario'] = 'Valor no permitido';
      }
      
       if(!empty($post['mando_incluido']) && strlen(trim($post['mando_incluido'])) == 0){
          $errores['mando_incluido'] = 'No se aceptan cadenas vacías';
          if(!preg_match('/[a-zA-Z0-9\s]+/',$post['mando_incluido'])){
            $errores['mando_incluido'] = 'Nombre de mando no permitido';
          }
      }
      
      
      if(empty($post['id_conexion'])){
          $errores['conexion'] = 'Debes seleccionar una conexion';
      }else if(!$modelConec->conexionExists($post['id_conexion'])){
          $errores['conexion'] = 'La conexion que has seleccionado no existe ';
      }
      
      $errores['url_imagen'] = $this->checkFormImage($_FILES["imagen"]);
      if($errores['url_imagen'] == NULL){
          unset($errores['url_imagen']);
      }

                      
      
      return $errores;
    }
    
}