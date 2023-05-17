<?php

namespace Com\Daw2\Controllers;

class MonitorController extends \Com\Daw2\Core\BaseController{
    private const IVA = [12,18,21];

    
    
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
        $data['tecnologias'] = $modelTec->getAll();
        $data['ivas'] = self::IVA;
        $data['proveedores'] = $modelProv->getAll();
        $this->view->showViews(array('AddMonitor.view.php'),$data); 
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
            $data['ivas'] = self::IVA;
            $data['proveedores'] = $modelProv->getAll();
            $data['tecnologias'] = $modelTec->getAll();
            $data['volver'] = '/inventario/Monitores';

             $this->view->showViews(array('AddMonitor.view.php'),$data); 

          }

    }
    
    
    private function addMonitor(int $categoria,array $post): bool{
      $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
      $model = new \Com\Daw2\Models\MonitoresModel();
      
      if($modelGeneral->insertProduct($categoria,$post)){
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
        $data['proveedores'] = $modelProv->getAll();
        $data['titulo'] = 'Editar Producto';
        $data['titulo_seccion'] = 'Modificar Monitor';
        $data['ivas'] = self::IVA;
        $data['accion'] = 'Aplicar Cambios';
        $data['volver'] = '/inventario/Monitores';
        $data['tecnologias'] = $modelTec->getAll();
        $data['input'] = $input;
        
       $this->view->showViews(array('AddMonitor.view.php'),$data);     
    }
    
    
    
    private function checkForm(array $post, bool $alta = true):array{
        
      $errores = [];  
        
      $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
      $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();
      $modelTec =  new  \Com\Daw2\Models\AuxTecnologiaModel();

      
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
      
      if(empty($post['proveedores'])){
          
      $errores['proveedor'] = 'Elige un proveedor';
  
      }  
      else if(!$modelProv->proveedorExists($post['proveedores'])){
          $errores['proveedor'] = 'El proveedor que has seleccionado no existe';
      }else if(empty((int)$post['proveedores'])){
          $errores['proveedor'] = 'Debes seleccionar un proveedor';
      }
      
      if(empty($post['ivas'])){
        $errores['iva'] = 'tienes que escoger un iva';
      }
      
      else if(!in_array($post['ivas'],self::IVA)){
          $errores['iva'] = 'Valor de IVA no permitido';
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
     
      return $errores;
        
    }
    
    
}