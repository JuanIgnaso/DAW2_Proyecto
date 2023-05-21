<?php
namespace Com\Daw2\Controllers;

class RatonController extends \Com\Daw2\Core\BaseController{
   
        
    
        private const IVA = [12,18,21];
    
    public function showListaRatones(){
        $modelCategoria = new \Com\Daw2\Models\CategoriaModel();
        $modelRaton =  new \Com\Daw2\Models\RatonesModel();
        $modelConexiones = new \Com\Daw2\Models\AuxModelConexionesRaton();
        
        $data = [];
        $data['seccion'] = '/inventario/Ratones';
        $data['tipo'] = 'Ratones';
        $data['titulo'] = 'Inventario Ratones';
        $data['input'] = filter_var_array($_GET,FILTER_SANITIZE_SPECIAL_CHARS);
        $data['productos'] = $modelRaton->filterAll($_GET);
        $data['conexiones'] = $modelConexiones->getAll();
        $data['categoria'] = $modelCategoria->getAll();
        
        $copiaGET = $_GET;
        unset($copiaGET['order']);
        if(count($copiaGET) > 0){
            $data['queryString'] = "&".http_build_query($copiaGET);
        }else{
            $data['queryString'] = "";
        }
          
        $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','Ratones.view.php'),$data); 
    }
    
    public function showEdit($cod){
        $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();
        $modelConec  = new \Com\Daw2\Models\AuxModelConexionesRaton();
        $model = new \Com\Daw2\Models\RatonesModel();
        $data = [];
        $input = $model->getProducto($cod);
        $data['seccion'] = '/inventario/Ratones/edit/'.$cod;
        $data['proveedor'] = $modelProv->getAll();
        $data['titulo'] = 'Editar Producto';
        $data['titulo_seccion'] = 'Añadir Nuevo Ratón';
        $data['id_conexion'] = $modelConec->getAll();
        $data['iva'] = self::IVA;
        $data['accion'] = 'Aplicar Cambios';
        $data['input'] = $input;
         $data['volver'] = '/inventario/Ratones';
        
        $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddRaton.view.php'),$data); 
    }
    
    
        public function edit($cod){
       
        $model = new \Com\Daw2\Models\RatonesModel();
       
        
        $data = [];
        $data['volver'] = '/inventario/Ratones';

        $data['errores'] = $this->checkForm($_POST,$alta = false);
        
        
        if(count($data['errores']) == 0){
            $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
            $urlimg = $modelGeneral->getProductImg($_POST['codigo_producto']);

             if(!empty($_FILES["imagen"]["tmp_name"])){
              unlink(substr($urlimg,1,strlen($urlimg)));
              $upload = new \Com\Daw2\Helpers\FileUpload('assets/img/ratones/');
              if($upload->uploadPhoto()){
                 $_POST['imagen_p'] = '/assets/img/ratones/'.$_FILES["imagen"]["name"];
               }       
              }else{
                $_POST['imagen_p'] = $urlimg;
              }
              
             $saneado = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
             $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
             $result = $this->modifyRaton($_POST['id'],$_POST['codigo_producto'],$_POST);
             
            if($result){
                header('location: /inventario/Ratones');   
            }else{
                 $_SESSION['error_añadir'] = 'Ha ocurrido un error al intentar añadir el producto';
                }
            }else{
                         $data['titulo'] = 'Editar Producto';
        $data['titulo_seccion'] =  'Editar Producto';
              $data['accion'] = 'Aplicar Cambios';
                $modelConec  = new \Com\Daw2\Models\AuxModelConexionesRaton();
                $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();
                $data['seccion'] = '/inventario/Ratones/edit/'.$cod;
                $data['id_conexion'] = $modelConec->getAll();
                $data['proveedor'] = $modelProv->getAll();
                $data['iva'] = self::IVA;
                $data['volver'] = '/inventario/Ratones';

                $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
                $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddRaton.view.php'),$data); 
  
            }
        }
        
        private function modifyRaton($idRaton,$id,array $post): bool{
      $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
      $model = new \Com\Daw2\Models\RatonesModel();
      
      if($modelGeneral->editProduct($post,$id)){
          if($model->editRaton($post,$idRaton)){
              return true;
          }else{
              return false;
          }
      }else{
          return false;
      }

    }
    
        
        
    
    
        public function showAdd(){
        $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();
        $model = new \Com\Daw2\Models\RatonesModel();
        $modelConec  = new \Com\Daw2\Models\AuxModelConexionesRaton();

        $data = [];
        $data['volver'] = '/inventario/Ratones';

        $data['seccion'] = '/inventario/Ratones/add';
        $data['proveedor'] = $modelProv->getAll();
        $data['titulo'] = 'Añadir Producto';
        $data['titulo_seccion'] = 'Añadir Nuevo Ratón';  
        $data['accion'] = 'Añadir';
        $data['id_conexion'] = $modelConec->getAll();
        $data['iva'] = self::IVA;
        $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddRaton.view.php'),$data); 
    }
    
    
    function add(){
    $model = new \Com\Daw2\Models\RatonesModel();
    $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();

    $data = [];
    $data['titulo'] = 'Añadir Producto';
    $data['titulo_seccion'] = 'Añadir Nuevo Ratón';  
    $data['errores'] = $this->checkForm($_POST);
    $data['accion'] = 'Añadir';
    $data['volver'] = '/inventario/Ratones';
    if(count($data['errores']) == 0){
        if(!empty($_FILES["imagen"]["tmp_name"])){
          $upload = new \Com\Daw2\Helpers\FileUpload('assets/img/ratones/');

           if($upload->uploadPhoto()){
             $_POST['imagen_p'] = '/assets/img/ratones/'.$_FILES["imagen"]["name"];
           }       
          }       
        $result = $this->addRaton(7,$_POST);          
        if($result){        
            header('location: /inventario/Ratones');   
        }else{
             $_SESSION['error_añadir'] = 'Ha ocurrido un error al intentar añadir el producto';
            }
    }else{
        $modelConec  = new \Com\Daw2\Models\AuxModelConexionesRaton();
        $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();
        $data['seccion'] = '/inventario/Ratones/add';
        $data['id_conexion'] = $modelConec->getAll();
        $data['proveedor'] = $modelProv->getAll();
        $data['iva'] = self::IVA;
        
        $data['input'] = $_POST;
        //var_dump($data['input']);die();
        $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddRaton.view.php'),$data); 
    }
    
    }
    
    private function addRaton(int $categoria,array $post): bool{
      $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
      $model = new \Com\Daw2\Models\RatonesModel();
      
      if($modelGeneral->insertProduct($categoria,$post)){
          if($model->insertRaton($post)){
              return true;
          }else{
              return false;
          }
      }else{
          return false;
      }

    }
    
//    function uploadPhoto($directorio): bool{
//        $dir = $directorio;
//        $src = $_FILES['imagen']['tmp_name'];
//        $output_dir = $dir.basename($_FILES['imagen']['name']);
//        
//        if(!is_dir($dir)){
//            mkdir($dir, 0775, true);
//        }
//        
//        if(move_uploaded_file($src,$output_dir)){
//            return true;
//        }else{
//            return false;
//        }
//        
//    }
    
    private function checkForm(array $post, bool $alta = true):array{
        
      $errores = [];  
      
      //COMPROBACION DE IMG
      if(!empty($_FILES["imagen"]["tmp_name"])){
       $check = getimagesize($_FILES["imagen"]["tmp_name"]);
       $formato = strtolower(pathinfo($_FILES["imagen"]['name'],PATHINFO_EXTENSION));
      }
      

      $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
      $modelConec  = new \Com\Daw2\Models\AuxModelConexionesRaton();
      $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();
      
      if(empty($post['nombre'])){
          $errores['nombre'] = 'Tienes que escribir un nombre';
      }else if(strlen(trim($post['nombre'])) == 0){
          $errores['nombre'] = 'No se aceptan cadenas vacías';
      }  
            else if($modelGeneral->occupiedProductName($post['nombre'],$post['codigo_producto'])){
            $errores['nombre'] = 'El nombre del producto ya está en uso';
      }
               
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
      
        
      if(!$modelProv->proveedorExists($post['proveedor'])){
          $errores['proveedor'] = 'El proveedor que has seleccionado no existe';
      }else if(empty((int)$post['proveedor'])){
          $errores['proveedor'] = 'Debes seleccionar un proveedor';
      }
      
      
      if(!in_array($post['iva'],self::IVA)){
          $errores['iva'] = 'Valor de IVA no permitido';
      }
        
   
       if(empty($post['dpi'])){
            $errores['dpi'] = 'Este campo es obligatorio';
        }else if(!filter_var($post['dpi'],FILTER_VALIDATE_INT)){
            $errores['dpi'] = 'El valor introducido debe de ser un número entero';
        }else if($post['dpi'] <= 0){
            $errores['dpi'] = 'No se puede introducir un valor igual o inferior a 0';
        }  
        
       
        if(empty($post['clase'])){
          $errores['clase'] = 'Tienes que escribir una clase';
      }else if(strlen(trim($post['clase'])) == 0){
          $errores['clase'] = 'No se aceptan cadenas vacías';
      }else if(!preg_match('/[a-zA-Z0-9\s]+/',$post['clase'])){
          $errores['clase'] = 'nombre de clase no válido';
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