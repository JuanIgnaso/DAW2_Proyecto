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
        $data['conectividades'] = $modelConexiones->getAll();
        $data['ivas'] = self::IVA;   
        $data['proveedores'] = $modelProv->getAll();
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
            $data['ivas'] = self::IVA;
            $data['proveedores'] = $modelProv->getAll();
            $data['volver'] = '/inventario/Consolas';
            $data['conectividades'] = $modelConexiones->getAll();


            $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddConsolas.view.php'),$data); 
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
        $data['proveedores'] = $modelProv->getAll();
        $data['titulo'] = 'Editar Producto';
        $data['titulo_seccion'] = 'Modificar Consola';
        $data['ivas'] = self::IVA;
        $data['accion'] = 'Aplicar Cambios';
        $data['volver'] = '/inventario/Consolas';
        $data['input'] = $input;
        $data['conectividades'] = $modelConexiones->getAll();


        
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
            $data['proveedores'] = $modelProv->getAll();
            $data['titulo'] = 'Editar Producto';
            $data['titulo_seccion'] = 'Modificar Consola';
            $data['ivas'] = self::IVA;
            $data['accion'] = 'Aplicar Cambios';
            $data['volver'] = '/inventario/Consolas';
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
             $data['conectividades'] = $modelConexiones->getAll();

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
      
       if(!empty($post['juego_incluido']) && strlen(trim($post['marca'])) == 0){
          $errores['juego_incluido'] = 'No se aceptan cadenas vacías';
      }

      if(!isset($post['manual'])){
          $errores['manual_usuario'] = 'debes escoger una de las dos opciones';
      }
      
       if(!empty($post['mando_incluido']) && strlen(trim($post['mando_incluido'])) == 0){
          $errores['mando_incluido'] = 'No se aceptan cadenas vacías';
          if(!preg_match('/[a-zA-Z0-9\s]+/',$post['mando_incluido'])){
            $errores['mando_incluido'] = 'Nombre de mando no permitido';
          }
      }
      
      
      if(!$modelConec->conexionExists($post['conectividades'])){
          $errores['conexion'] = 'La conexion que has seleccionado no existe';
      }else if(empty($post['conectividades'])){
          $errores['conexion'] = 'Debes seleccionar una conexion';
      }
      
      return $errores;
    }
    
}