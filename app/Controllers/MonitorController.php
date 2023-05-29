<?php

namespace Com\Daw2\Controllers;

class MonitorController extends \Com\Daw2\Core\BaseController{
 
    
    public function showListaMonitores(){
        $modelMonitor =  new \Com\Daw2\Models\MonitoresModel();
        $modelTec =  new  \Com\Daw2\Models\AuxTecnologiaModel();
        
        //clase, conectividad y idioma
        
        
        $data = [];
        $data['seccion'] = '/inventario/Monitores';
        $data['tipo'] = 'Monitores';
        $data['titulo'] = 'Inventario Monitores';
        $data['input'] = filter_var_array($_GET,FILTER_SANITIZE_SPECIAL_CHARS);
        $data['productos'] = $modelMonitor->filterAll($_GET);
        $data['tecnologias'] = $modelTec->getAll();
        $data['refrescos'] = $modelMonitor->getRefreshRate();
               
        $copiaGET = $_GET;
        unset($copiaGET['order']);
        if(count($copiaGET) > 0){
            $data['queryString'] = "&".http_build_query($copiaGET);
        }else{
            $data['queryString'] = "";
        }
        
        $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','MonitoresView.php'),$data); 
    }
    
    
    function showAdd(){
       $model = new \Com\Daw2\Models\MonitoresModel(); 
       $idiomaModel =  new \Com\Daw2\Models\AuxIdiomaModel();
       $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();
       $modelTec =  new  \Com\Daw2\Models\AuxTecnologiaModel();


        $data = [];
        $data['titulo_seccion'] = 'Añadir Monitor';
        $data['accion'] = 'Añadir';
        $data['seccion'] = '/inventario/Monitores/add';
        $data['tipo'] = 'Monitores';
        $data['volver'] = '/inventario/Monitores';
        $data['titulo'] = 'Añadir Producto';
        $data['tecnologia'] = $modelTec->getAll();
        $data['proveedor'] = $modelProv->getAll();
        $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddMonitor.view.php'),$data); 
    }
    
    
    public function add(){
       $model = new \Com\Daw2\Models\MonitoresModel(); 
       $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();

        
          $data = [];
          $data['titulo'] = 'Añadir Producto';
          $data['titulo_seccion'] = 'Añadir Monitor';
          $data['errores'] = $this->checkForm($_POST);
          $data['accion'] = 'Añadir';
          $data['volver'] = '/inventario/Monitores';
          
          if(count($data['errores']) == 0){
              
            if(!empty($_FILES["imagen"]["tmp_name"])){
                $upload = new \Com\Daw2\Helpers\FileUpload('assets/img/monitores/');
               if($upload->uploadPhoto()){
                 $_POST['imagen_p'] = '/assets/img/monitores/'.$_FILES["imagen"]["name"];
               }       
            }    
   
              $result = $this->addMonitor(9,$_POST);
              if($result){
                header('location: '.$data['volver']);   
            }else{
                 $_SESSION['error_añadir'] = 'Ha ocurrido un error al intentar añadir el producto';
                }
          }else{
            $modelTec =  new  \Com\Daw2\Models\AuxTecnologiaModel();
            $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();
            $data['seccion'] = '/inventario/Monitores/add';
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data['proveedor'] = $modelProv->getAll();
            $data['tecnologia'] = $modelTec->getAll();
            $data['volver'] = '/inventario/Monitores';

             $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddMonitor.view.php'),$data); 

          }

    }
    
    private function addMonitor(int $categoria,array $post): bool{
      $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
      $model = new \Com\Daw2\Models\MonitoresModel();
      
      if($modelGeneral->insertProduct($categoria,$post,self::IVA)){
          if($model->insertMonitor($post)){
              return true;
          }else{
              return false;
          }
      }else{
          return false;
      }

    }
    
    
    function showEdit($cod){
       $modelTec =  new  \Com\Daw2\Models\AuxTecnologiaModel();
       $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();
       $model = new \Com\Daw2\Models\MonitoresModel(); 
       $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
       $data = [];
       $input = $model->getProducto($cod);
        $data = [];
        $data['seccion'] = '/inventario/Monitores/edit/'.$cod;
        $data['proveedor'] = $modelProv->getAll();
        $data['titulo'] = 'Editar Producto';
        $data['titulo_seccion'] = 'Modificar Monitor';
        $data['accion'] = 'Aplicar Cambios';
        $data['volver'] = '/inventario/Monitores';
        $data['tecnologia'] = $modelTec->getAll();
        $data['input'] = $input;
        
       $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddMonitor.view.php'),$data);     
    }
    
    
    
    
    
    public function edit($cod){
        $model = new \Com\Daw2\Models\MonitoresModel(); 
        $data = [];
        $data['errores'] = $this->checkForm($_POST,$alta = false);
        if(count($data['errores']) == 0){
           $saneado = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
           $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
           $urlimg = $modelGeneral->getProductImg($_POST['codigo_producto']);
           
             if(!empty($_FILES["imagen"]["tmp_name"])){
              unlink(substr($urlimg,1,strlen($urlimg)));
              $upload = new \Com\Daw2\Helpers\FileUpload('assets/img/monitores/');
               if($upload->uploadPhoto()){
                 $_POST['imagen_p'] = '/assets/img/monitores/'.$_FILES["imagen"]["name"];
               }       
              }else{
                $_POST['imagen_p'] = $urlimg;
              }
              
           $result = $this->modifyMonitor($_POST['id_monitor'],$_POST['codigo_producto'],$_POST);
           if($result){
               header('location: /inventario/Monitores');
           }else{
                 $_SESSION['error_añadir'] = 'Ha ocurrido un error al intentar añadir el producto';
            }
        }else{
           $modelTec =  new  \Com\Daw2\Models\AuxTecnologiaModel();
           $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();
           $model = new \Com\Daw2\Models\MonitoresModel(); 
           $data['titulo'] = 'Editar Producto';
           $data['titulo_seccion'] = 'Modificar Monitor';
           $data['seccion'] = '/inventario/Monitores/edit/'.$cod;
           $data['proveedor'] = $modelProv->getAll();
           $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
           $data['volver'] = '/inventario/Monitores';
           $data['accion'] = 'Aplicar Cambios';
           $data['tecnologia'] = $modelTec->getAll();
           
           $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddMonitor.view.php'),$data);     
        }
    }
    
    
    private function modifyMonitor($idMon,$id,array $post): bool{
      $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
      $model = new \Com\Daw2\Models\MonitoresModel();
      
      if($modelGeneral->editProduct($post,$id,self::IVA)){
          if($model->editMonitor($post)){
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

          $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
          $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();
          $modelTec =  new  \Com\Daw2\Models\AuxTecnologiaModel();


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

           if(empty($post['pulgadas'])){
                $errores['pulgadas'] = 'Este campo es obligatorio';
            }else if(!filter_var($post['pulgadas'],FILTER_VALIDATE_FLOAT)){
                $errores['pulgadas'] = 'El valor introducido debe de ser un número decimal';
            }else if($post['pulgadas'] <= 0){
            $errores['pulgadas'] = 'No se puede introducir un valor igual o inferior a 0';
            }


          if(empty($post['refresco'])){
              $errores['refresco'] = 'Tienes que escribir una tasa de refresco';
          }else if(strlen(trim($post['refresco'])) == 0){
              $errores['refresco'] = 'No se aceptan cadenas vacías';
          }else if(!preg_match('/^[1-9]{1}[0-9]+Hz$/',$post['refresco'])){
              $errores['refresco'] = 'tasa de refresco no válida';
          }

          if(empty($post['entrada_video'])){
              $errores['entrada_video'] = 'Tienes que escribir una entrada de video';
          }else if(strlen(trim($post['entrada_video'])) == 0){
              $errores['entrada_video'] = 'No se aceptan cadenas vacías';
          }else if(!preg_match('/^[a-zA-Z, ]+/',$post['entrada_video'])){
              $errores['entrada_video'] = 'entrada de video no válida';
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