<?php
namespace Com\Daw2\Controllers;

class ConsolasController extends \Com\Daw2\Core\BaseController{
   
    private const IVA = [12,18,21]; 
    
    public function showListaConsolas(){
        $model =  new \Com\Daw2\Models\ConsolasModel();
        $modelConexiones = new \Com\Daw2\Models\AuxModelConexionesRaton();
        
        $data = [];
        $data['seccion'] = '/inventario/Consolas';
        $data['tipo'] = 'Consolas';
        $data['titulo'] = 'Inventario Consolas';
        $data['productos'] = $model->filterAll($_GET);
        $data['conexiones'] = $modelConexiones->getAll();
        
                
        $copiaGET = $_GET;
        unset($copiaGET['order']);
        if(count($copiaGET) > 0){
            $data['queryString'] = "&".http_build_query($copiaGET);
        }else{
            $data['queryString'] = "";
        }
        
        
        $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','Consolas.view.php'),$data); 
    }
    
    
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
        $data['iva'] = self::IVA;   
        $data['proveedor'] = $modelProv->getAll();
        $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddConsolas.view.php'),$data); 
    }
    
    
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
           if($this->uploadPhoto('assets/img/consolas/')){
             $_POST['imagen_p'] = '/assets/img/consolas/'.$_FILES["imagen"]["name"];
           }       
        }   
            
            
          $result = $this->addConsola(6,$_POST);
          if($result){
            header('location: '.$data['volver']);   
        }else{
             $_SESSION['error_añadir'] = 'Ha ocurrido un error al intentar añadir el producto';
            }
        }else{
            $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();
            $data['seccion'] = '/inventario/Consolas/add';
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data['iva'] = self::IVA;
            $data['proveedor'] = $modelProv->getAll();
            $data['volver'] = '/inventario/Consolas';
            $data['id_conexion'] = $modelConexiones->getAll();


            $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddConsolas.view.php'),$data); 
        }
    }
    
    
    
     private function uploadPhoto($directorio): bool{
        $dir = $directorio;
        $src = $_FILES['imagen']['tmp_name'];
        $output_dir = $dir.basename($_FILES['imagen']['name']);
        
        if(!is_dir($dir)){
            mkdir($dir, 0775, true);
        }
        
        if(move_uploaded_file($src,$output_dir)){
            return true;
        }else{
            return false;
        }
        
    }
    
    
        
      private function addConsola(int $categoria,array $post): bool{
      $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
      $model =  new \Com\Daw2\Models\ConsolasModel();

      
      if($modelGeneral->insertProduct($categoria,$post)){
          if($model->insertConsola($post)){
              return true;
          }else{
              return false;
          }
      }else{
          return false;
      }

    }
    
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
        $data['iva'] = self::IVA;
        $data['accion'] = 'Aplicar Cambios';
        $data['volver'] = '/inventario/Consolas';
        $data['input'] = $input;
        $data['id_conexion'] = $modelConexiones->getAll();


        
       $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddConsolas.view.php'),$data);     
    }
    
    
    
    public function edit($cod){
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
               if($this->uploadPhoto('assets/img/consolas/')){
                 $_POST['imagen_p'] = '/assets/img/consolas/'.$_FILES["imagen"]["name"];
               }       
              }else{
                $_POST['imagen_p'] = $urlimg;
              }           
                 
           $result = $this->modifyConsola($_POST['id_consola'],$_POST['codigo_producto'],$_POST);
           if($result){
               header('location: '.$data['volver']);
           }else{
                 $_SESSION['error_añadir'] = 'Ha ocurrido un error al intentar añadir el producto';
            }
        }else{
            $modelConexiones = new \Com\Daw2\Models\AuxModelConexionesRaton();

            $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();
            $data['seccion'] = '/inventario/Consolas/edit/'.$cod;
            $data['proveedor'] = $modelProv->getAll();
            $data['titulo'] = 'Editar Producto';
            $data['titulo_seccion'] = 'Modificar Consola';
            $data['iva'] = self::IVA;
            $data['accion'] = 'Aplicar Cambios';
            $data['volver'] = '/inventario/Consolas';
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
             $data['id_conexion'] = $modelConexiones->getAll();

            $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddConsolas.view.php'),$data);     
        }
    }
    
    
    
    private function modifyConsola($idMon,$id,array $post): bool{
      $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
      $model =  new \Com\Daw2\Models\ConsolasModel();

      
      if($modelGeneral->editProduct($post,$id)){
          if($model->editConsola($post)){
              return true;
          }else{
              return false;
          }
      }else{
          return false;
      }

    }

      
    
    
    
    
    private function checkForm(array $post, bool $alta = true):array{
        
      $errores = []; 
      $model = new \Com\Daw2\Models\ConsolasModel(); 
      $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();
      $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
      $modelConec  = new \Com\Daw2\Models\AuxModelConexionesRaton();

      
      //COMPROBACION DE IMG
      if(!empty($_FILES["imagen"]["tmp_name"])){
       $check = getimagesize($_FILES["imagen"]["tmp_name"]);
       $formato = strtolower(pathinfo($_FILES["imagen"]['name'],PATHINFO_EXTENSION));
      }
      
      
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
      
      if(empty($post['iva'])){
        $errores['iva'] = 'tienes que escoger un iva';
      }
      
      else if(!in_array($post['iva'],self::IVA)){
          $errores['iva'] = 'Valor de IVA no permitido';
      }
      
       if(!empty($post['juego_incluido']) && strlen(trim($post['marca'])) == 0){
          $errores['juego_incluido'] = 'No se aceptan cadenas vacías';
      }

      if(!isset($post['manual_usuario'])){
          $errores['manual_usuario'] = 'debes escoger una de las dos opciones';
      }
      
       if(!empty($post['mando_incluido']) && strlen(trim($post['mando_incluido'])) == 0){
          $errores['mando_incluido'] = 'No se aceptan cadenas vacías';
          if(!preg_match('/[a-zA-Z0-9\s]+/',$post['mando_incluido'])){
            $errores['mando_incluido'] = 'Nombre de mando no permitido';
          }
      }
      
      
      if(!$modelConec->conexionExists($post['id_conexion'])){
          $errores['conexion'] = 'La conexion que has seleccionado no existe';
      }else if(empty($post['id_conexion'])){
          $errores['conexion'] = 'Debes seleccionar una conexion';
      }
      
      
      
            
    if(isset($check)){
    if($check == false){
        $errores['url_imagen'] = 'debes de subir una imagen';  
    }else{
       if ($_FILES["imagen"]["size"] > 10000000) {  // TAMAÑO DE LA IMAGEN
             $errores['url_imagen'] = 'Limite máximo de tamaño superado'.basename($_FILES["imagen"]["name"]);
       }if($check[0] != $check[1]){  // DIMENSIONES
            $errores['url_imagen'] = 'La imagen debe de mantener el formato 1:1';  
        } 
        if($formato != 'jpg' && $formato != "png" && $formato != "jpeg"){ //FORMATO
         $errores['url_imagen'] = 'Solo se permiten imagenes en .jpg, .png y .jpeg';
         }  
    }

 }
      
      return $errores;
    }
    
}