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
        $data['proveedores'] = $modelProv->getAll();
        $data['titulo'] = 'Editar Producto';
        $data['titulo_seccion'] = 'Añadir Nuevo Ratón';
        $data['conexiones'] = $modelConec->getAll();
        $data['ivas'] = self::IVA;
        $data['accion'] = 'Aplicar Cambios';
        $data['input'] = $input;
         $data['volver'] = '/inventario/Ratones';
        
        $this->view->showViews(array('AddRaton.view.php'),$data); 
    }
    
    
        public function edit($cod){
       
        $model = new \Com\Daw2\Models\RatonesModel();
       
        
        $data = [];
        $data['volver'] = '/inventario/Ratones';

        $data['errores'] = $this->checkForm($_POST,$alta = false);
        
        
        if(count($data['errores']) == 0){
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
                $data['conexiones'] = $modelConec->getAll();
                $data['proveedores'] = $modelProv->getAll();
                $data['ivas'] = self::IVA;
                $data['volver'] = '/inventario/Ratones';

                $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
                $this->view->showViews(array('AddRaton.view.php'),$data); 
  
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
        $data['proveedores'] = $modelProv->getAll();
        $data['titulo'] = 'Añadir Producto';
        $data['titulo_seccion'] = 'Añadir Nuevo Ratón';  
        $data['accion'] = 'Añadir';
        $data['conexiones'] = $modelConec->getAll();
        $data['ivas'] = self::IVA;
        $this->view->showViews(array('AddRaton.view.php'),$data); 
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
        $data['conexiones'] = $modelConec->getAll();
        $data['proveedores'] = $modelProv->getAll();
        $data['ivas'] = self::IVA;
        $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        $this->view->showViews(array('AddRaton.view.php'),$data); 
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
    
    private function checkForm(array $post, bool $alta = true):array{
        
      $errores = [];  
        
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
      
        
      if(!$modelProv->proveedorExists($post['proveedores'])){
          $errores['proveedor'] = 'El proveedor que has seleccionado no existe';
      }else if(empty((int)$post['proveedores'])){
          $errores['proveedor'] = 'Debes seleccionar un proveedor';
      }
      
      
      if(!in_array($post['ivas'],self::IVA)){
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
      

      if(!$modelConec->conexionExists($post['conexiones'])){
          $errores['conexion'] = 'La conexion que has seleccionado no existe';
      }else if(empty($post['proveedores'])){
          $errores['conexion'] = 'Debes seleccionar una conexion';
      }
      
      
      
      
      return $errores;
        
    }
    
}