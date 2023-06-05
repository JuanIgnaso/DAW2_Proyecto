<?php

namespace Com\Daw2\Controllers;

class SillaController extends \Com\Daw2\Core\BaseProductController{

   /*Función privada para conseguir los tipos de silla*/
   private function getTipos():array{
      $model = new \Com\Daw2\Models\SillasModel();
      $tipo =  $model->getTipo();
        $patrones = array();
        $patrones[0] = '/\'/';
        $patrones[1] = '/\(/';
        $patrones[2] = '/\)/';
        return preg_replace($patrones,'',explode(',',$tipo[0]['SUBSTRING(COLUMN_TYPE,5)']));
   }
    
   
   /*Mostrar la lista de productos*/
    public function showListaSillas(){
        $model =  new \Com\Daw2\Models\SillasModel();

        $data = [];
        $data['seccion'] = '/inventario/Sillas';
        $data['tipo'] = 'Sillas';
        $data['productos'] = $model->filterAll($_GET);  
        $data['input'] = filter_var_array($_GET,FILTER_SANITIZE_SPECIAL_CHARS);
        $data['alturas'] =$model->getChairHight();
        $data['anchuras'] = $model->getChairLenght();
        
        $copiaGET = $_GET;
        unset($copiaGET['order']);
        if(count($copiaGET) > 0){
            $data['queryString'] = "&".http_build_query($copiaGET);
        }else{
            $data['queryString'] = "";
        }
        
        
        $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','Sillas.view.php'),$data); 
    }
    
    
    /*Mostrar la vista para añadir*/
    function showAdd(){
       $model = new \Com\Daw2\Models\SillasModel(); 
       $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();


        $data = [];
        $data['titulo_seccion'] = 'Añadir Silla';
        $data['accion'] = 'Añadir';
        $data['seccion'] = '/inventario/Sillas/add';
        $data['tipo'] = 'Sillas';
        $data['volver'] = '/inventario/Sillas';
        $data['titulo'] = 'Añadir Producto';
        $data['tipo_silla'] = $this->getTipos();
        $data['proveedor'] = $modelProv->getAll();
        $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddSilla.view.php'),$data); 
    }
    
    /*Añade el producto*/
    public function add(){
     $model = new \Com\Daw2\Models\SillasModel(); 
     $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();

    
      $data['titulo'] = 'Añadir Producto';
      $data['titulo_seccion'] = 'Añadir Silla';
      $data['errores'] = $this->checkForm($_POST);
      $data['accion'] = 'Añadir';
      $data['volver'] = '/inventario/Sillas';
      
       if(count($data['errores']) == 0){
           
               if(!empty($_FILES["imagen"]["tmp_name"])){
                   $upload = new \Com\Daw2\Helpers\FileUpload('assets/sillas/');
                   if($upload->uploadPhoto()){
                     $_POST['imagen_p'] = '/assets/img/sillas/'.$_FILES["imagen"]["name"];
                   }       
                } 

              $result = $this->addSilla(3,$_POST);
              if($result){
                header('location: '.$data['volver']);  
                $_SESSION['action'] = 'Se ha añadido el elemento con éxito';

            }else{
                $_SESSION['error_añadir'] = 'Ha ocurrido un error al intentar añadir el producto';
                $data['seccion'] = '/inventario/Sillas/add';
                $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
                $data['proveedor'] = $modelProv->getAll();
                $data['volver'] = '/inventario/Sillas';
                $data['tipo_silla'] = $this->getTipos();

                $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddSilla.view.php'),$data); 
            }
        }else{
            $data['seccion'] = '/inventario/Sillas/add';
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data['proveedor'] = $modelProv->getAll();
            $data['volver'] = '/inventario/Sillas';
            $data['tipo_silla'] = $this->getTipos();

            $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddSilla.view.php'),$data); 
        }

    }
     
    /*Añade el producto a la tabla de la Base De Datos*/
    private function addSilla(int $categoria,array $post): bool{
      $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
      $model = new \Com\Daw2\Models\SillasModel();
      
      if($modelGeneral->insertProduct($categoria,$post,self::IVA)){
          if($model->insertSilla($post)){
              return true;
          }else{
              return false;
          }
      }else{
          return false;
      }

    }
    
    /*Muestra la ventana para editar*/
     function showEdit($cod){
       $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();
       $model = new \Com\Daw2\Models\SillasModel(); 
       $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
       $data = [];
       $input = $model->getProducto($cod);
        $data = [];
        $data['seccion'] = '/inventario/Sillas/edit/'.$cod;
        $data['proveedor'] = $modelProv->getAll();
        $data['titulo'] = 'Editar Producto';
        $data['titulo_seccion'] = 'Modificar Silla';
        $data['accion'] = 'Aplicar Cambios';
        $data['volver'] = '/inventario/Sillas';
        $data['input'] = $input;
        $data['tipo_silla'] = $this->getTipos();

        
       $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddSilla.view.php'),$data);     
    }
    
    /*Edita el producto*/
    public function edit($cod){
         $model = new \Com\Daw2\Models\SillasModel(); 
         $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();
         $data = [];
         $data['errores'] = $this->checkForm($_POST,$alta = false);
         $data['volver'] = '/inventario/Sillas';

        if(count($data['errores']) == 0){
            $saneado = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
          
            $urlimg = $modelGeneral->getProductImg($_POST['codigo_producto']);
           
             if(!empty($_FILES["imagen"]["tmp_name"])){
                  unlink(substr($urlimg,1,strlen($urlimg)));
                  $upload = new \Com\Daw2\Helpers\FileUpload('assets/img/ratones/');
                   if($upload->uploadPhoto()){
                     $_POST['imagen_p'] = '/assets/img/sillas/'.$_FILES["imagen"]["name"];
                   }       
             }else{
                $_POST['imagen_p'] = $urlimg;
             }
           
           
           $result = $this->modifySilla($_POST['id_silla'],$_POST['codigo_producto'],$_POST);
           if($result){
               header('location: '.$data['volver']);
               $_SESSION['action'] = 'Cambios realizados con éxito';

           }else{
                 $_SESSION['error_añadir'] = 'Ha ocurrido un error al intentar añadir el producto';
                $data['seccion'] = '/inventario/Sillas/edit/'.$cod;
                $data['proveedor'] = $modelProv->getAll();
                $data['titulo'] = 'Editar Producto';
                $data['titulo_seccion'] = 'Modificar Silla';
                $data['accion'] = 'Aplicar Cambios';
                $data['volver'] = '/inventario/Sillas';
                $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
                $data['input']['url_imagen'] = $_POST['imagen'];            
                $data['tipo_silla'] = $this->getTipos();

                $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddSilla.view.php'),$data);     
           }
            
        }else{
            $data['seccion'] = '/inventario/Sillas/edit/'.$cod;
            $data['proveedor'] = $modelProv->getAll();
            $data['titulo'] = 'Editar Producto';
            $data['titulo_seccion'] = 'Modificar Silla';
            $data['accion'] = 'Aplicar Cambios';
            $data['volver'] = '/inventario/Sillas';
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data['input']['url_imagen'] = $_POST['imagen'];            
            $data['tipo_silla'] = $this->getTipos();

            $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddSilla.view.php'),$data);     
        }
    }
    
    /*Ejecuta la modificación contra la Base De Datos*/
    private function modifySilla($idMon,$id,array $post): bool{
      $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
      $model = new \Com\Daw2\Models\SillasModel();
      
      if($modelGeneral->editProduct($post,$id,self::IVA)){
          if($model->editSilla($post)){
              return true;
          }else{
              return false;
          }
      }else{
          return false;
      }

    }
    
    
    
    /*Comprobar el formulario*/
    private function checkForm(array $post, bool $alta = true):array{
        
      $errores = []; 
      $model = new \Com\Daw2\Models\SillasModel(); 
      $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();
      $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
      $tipos = $this->getTipos();
      
      
      
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
           
      if(empty($post['altura'])){
          $errores['altura'] = 'Tienes que escribir una altura';
      }else if(strlen(trim($post['altura'])) == 0){
          $errores['altura'] = 'No se aceptan cadenas vacías';
      }else if(!preg_match('/^[1-9]{1}[0-9]+cm$/',$post['altura'])){
          $errores['altura'] = 'medida no válida';
      }
      
      if(empty($post['anchura'])){
          $errores['anchura'] = 'Tienes que escribir una anchura';
      }else if(strlen(trim($post['anchura'])) == 0){
          $errores['anchura'] = 'No se aceptan cadenas vacías';
      }else if(!preg_match('/^[1-9]{1}[0-9]+cm$/',$post['anchura'])){
          $errores['anchura'] = 'medida no válida';
      }
      
      if(empty($post['tipo_silla'])){
          $errores['tipo'] = 'Tienes que escoger un tipo de silla';
      }else if(!in_array($post['tipo_silla'],$tipos)){
          $errores['tipo'] = 'Valor no permitido';
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