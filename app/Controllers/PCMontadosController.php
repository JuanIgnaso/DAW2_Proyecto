<?php



namespace Com\Daw2\Controllers;

class PCMontadosController extends \Com\Daw2\Core\BaseProductController{
    
    /*Consigue el tipo de almacenamiento*/
   private function getAlmacenamiento():array{
      $model = new \Com\Daw2\Models\PCMontadosModel();
      $tipo =  $model->getAlmacenamientoTipo();
        $patrones = array();
        $patrones[0] = '/\'/';
        $patrones[1] = '/\(/';
        $patrones[2] = '/\)/';
        return preg_replace($patrones,'',explode(',',$tipo[0]['SUBSTRING(COLUMN_TYPE,5)']));
   }
    
    
    /*Muestra la lista de productos*/
    public function showListaPC(){
        
       $model =  new \Com\Daw2\Models\PCMontadosModel();
       $data = []; 
       $data['titulo'] = 'Inventario PC Montados';
       $data['tipo'] = 'PC Montados';
       $data['seccion'] = '/inventario/Ordenadores';
       $data['input'] = filter_var_array($_GET,FILTER_SANITIZE_SPECIAL_CHARS);
       $data['productos'] = $model->filterAll($_GET);
       $data['almacenamientos'] = $model->getStorageQuantity();
       $data['memorias'] = $model->getMemoryQuantity();

       $copiaGET = $_GET;
        unset($copiaGET['order']);
        if(count($copiaGET) > 0){
            $data['queryString'] = "&".http_build_query($copiaGET);
        }else{
            $data['queryString'] = "";
        }
       
       
      $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','PCMontados.view.php'),$data); 
 
    }
    
    /*Muestra la lista para añadir*/
   function showAdd(){
       $model = new \Com\Daw2\Models\PCMontadosModel(); 
       $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();


        $data = [];
        $data['titulo_seccion'] = 'Añadir PC';
        $data['accion'] = 'Añadir';
        $data['seccion'] = '/inventario/Ordenadores/add';
        $data['tipo'] = 'PC Montados';
        $data['volver'] = '/inventario/Ordenadores';
        $data['titulo'] = 'Añadir Producto';
        $data['almacenamiento_tipo'] = $this->getAlmacenamiento();
        $data['proveedor'] = $modelProv->getAll();
        $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddOrdenador.view.php'),$data); 
    } 
    
    /*Añade el producto*/
    public function add(){
       $model = new \Com\Daw2\Models\PCMontadosModel(); 
       $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();

        $data = [];
        $data['titulo_seccion'] = 'Añadir PC';
        $data['accion'] = 'Añadir';
        $data['seccion'] = '/inventario/Ordenadores/add';
        $data['volver'] = '/inventario/Ordenadores';
        $data['errores'] =$this->checkForm($_POST);
        
        if(count($data['errores']) == 0){
            
           if(!empty($_FILES["imagen"]["tmp_name"])){
               $upload = new \Com\Daw2\Helpers\FileUpload('assets/img/pc_montados/');
               if($upload->uploadPhoto()){
                 $_POST['imagen_p'] = '/assets/img/pc_montados/'.$_FILES["imagen"]["name"];
               }       
              }  

            $result = $this->addPC(10,$_POST);
          if($result){
            header('location: '.$data['volver']); 
            $_SESSION['action'] = 'Se ha añadido el elemento con éxito';

        }else{
             $_SESSION['error_añadir'] = 'Ha ocurrido un error al intentar añadir el producto';
            $data['seccion'] = '/inventario/Ordenadores/add';
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data['proveedor'] = $modelProv->getAll();
            $data['volver'] = '/inventario/Ordenadores';
            $data['almacenamiento_tipo'] = $this->getAlmacenamiento();

            $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddOrdenador.view.php'),$data); 
            }
        }else{
            $data['seccion'] = '/inventario/Ordenadores/add';
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data['proveedor'] = $modelProv->getAll();
            $data['volver'] = '/inventario/Ordenadores';
            $data['almacenamiento_tipo'] = $this->getAlmacenamiento();

            $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddOrdenador.view.php'),$data); 
        }
    }
    
    /*Ejecuta las consultas contra la base de datos*/
    private function addPC(int $categoria,array $post): bool{
      $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
      $model = new \Com\Daw2\Models\PCMontadosModel();
      
      if($modelGeneral->insertProduct($categoria,$post,self::IVA)){
          if($model->insertPC($post)){
              return true;
          }else{
              return false;
          }
      }else{
          return false;
      }

    }
    
    /*Muestra la vista para editar*/
    function showEdit($cod){
       $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();
       $model = new \Com\Daw2\Models\PCMontadosModel();
 
       $data = [];
       $input = $model->getProducto($cod);
        $data = [];
        $data['seccion'] = '/inventario/Ordenadores/edit/'.$cod;
        $data['proveedor'] = $modelProv->getAll();
        $data['titulo'] = 'Editar Producto';
        $data['titulo_seccion'] = 'Modificar Ordenador';
        $data['accion'] = 'Aplicar Cambios';
        $data['volver'] = '/inventario/Ordenadores';
        $data['input'] = $input;
        $data['almacenamiento_tipo'] = $this->getAlmacenamiento();

        
       $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddOrdenador.view.php'),$data);     
    }
    
    /*Edita el producto*/
    public function edit($cod){
    $model = new \Com\Daw2\Models\PCMontadosModel();
    $data = [];
    $data['volver'] = '/inventario/Ordenadores';
    $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();

    $data['errores'] = $this->checkForm($_POST,$alta = false);
        if(count($data['errores']) == 0){
                 
        $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
   
        $urlimg = $modelGeneral->getProductImg($_POST['codigo_producto']);

        if(!empty($_FILES["imagen"]["tmp_name"])){
          unlink(substr($urlimg,1,strlen($urlimg)));
           $upload = new \Com\Daw2\Helpers\FileUpload('assets/img/pc_montados/');
           if($upload->uploadPhoto()){
             $_POST['imagen_p'] = '/assets/img/pc_montados/'.$_FILES["imagen"]["name"];
           }       
          }else{
            $_POST['imagen_p'] = $urlimg;
        }  
        
            $result = $this->modifyPC($_POST['id_ordenador'],$_POST['codigo_producto'],$_POST);
           if($result){
               header('location: '.$data['volver']);
               $_SESSION['action'] = 'Cambios realizados con éxito';

           }else{
                 $_SESSION['error_añadir'] = 'Ha ocurrido un error al intentar editar el producto';
                $data['seccion'] = '/inventario/Ordenadores/edit/'.$cod;
                $data['proveedor'] = $modelProv->getAll();
                $data['titulo'] = 'Editar Producto';
                $data['titulo_seccion'] = 'Modificar Ordenador';
                $data['accion'] = 'Aplicar Cambios';
                $data['volver'] = '/inventario/Ordenadores';
                $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
                $data['input']['url_imagen'] = $_POST['imagen'];
                $data['almacenamiento_tipo'] = $this->getAlmacenamiento();

                $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddOrdenador.view.php'),$data);  
           }
        }else{
            $data['seccion'] = '/inventario/Ordenadores/edit/'.$cod;
            $data['proveedor'] = $modelProv->getAll();
            $data['titulo'] = 'Editar Producto';
            $data['titulo_seccion'] = 'Modificar Ordenador';
            $data['accion'] = 'Aplicar Cambios';
            $data['volver'] = '/inventario/Ordenadores';
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data['input']['url_imagen'] = $_POST['imagen'];
            $data['almacenamiento_tipo'] = $this->getAlmacenamiento();

            $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddOrdenador.view.php'),$data);     
        }
    
    }
    
    /*Ejecuta la edición contra la Base De Datos*/
    private function modifyPC($idMon,$id,array $post): bool{
      $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
      $model = new \Com\Daw2\Models\PCMontadosModel();

      
      if($modelGeneral->editProduct($post,$id,self::IVA)){
          if($model->editOrdenador($post)){
              return true;
          }else{
              return false;
          }
      }else{
          return false;
      }

    }
   
   
    /*Comprueba el formulario*/
    private function checkForm(array $post, bool $alta = true):array{
        
      $errores = []; 
      $model = new \Com\Daw2\Models\SillasModel(); 
      $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();
      $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
      $tipoAlmacenamiento = $this->getAlmacenamiento();
      
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

      if(empty($post['caja'])){
          $errores['caja'] = 'Tienes que escribir una caja';
      }else if(strlen(trim($post['caja'])) == 0){
          $errores['caja'] = 'No se aceptan cadenas vacías';
      }else if(!preg_match('/[a-zA-Z0-9\s\-]+/',$post['caja'])){
          $errores['caja'] = 'nombre de caja no válido';
      }
      
      if(empty($post['cpu'])){
          $errores['cpu'] = 'Tienes que escribir una cpu';
      }else if(strlen(trim($post['cpu'])) == 0){
          $errores['cpu'] = 'No se aceptan cadenas vacías';
      }else if(!preg_match('/[a-zA-Z0-9\s\-]+/',$post['cpu'])){
          $errores['cpu'] = 'nombre de cpu no válido';
      }
      
      
    if(empty($post['targeta_video'])){
          $errores['targeta_video'] = 'Tienes que escribir una targeta video';
      }else if(strlen(trim($post['targeta_video'])) == 0){
          $errores['targeta_video'] = 'No se aceptan cadenas vacías';
      }else if(!preg_match('/[a-zA-Z0-9\s\-]+/',$post['targeta_video'])){
          $errores['targeta_video'] = 'nombre de targeta video no válido';
      }
      
      
           
    if(empty($post['almacenamiento'])){
          $errores['almacenamiento'] = 'Tienes que definir un almacenamiento';
      }else if(strlen(trim($post['almacenamiento'])) == 0){
          $errores['almacenamiento'] = 'No se aceptan cadenas vacías';
      }else if(!preg_match('/^[1-9][0-9]*([TG])([B])$/',$post['almacenamiento'])){
          $errores['almacenamiento'] = 'almacenamiento no válido';
      } 
      
       if(empty($post['memoria'])){
          $errores['memoria'] = 'Tienes que definir una memoria';
      }else if(strlen(trim($post['memoria'])) == 0){
          $errores['memoria'] = 'No se aceptan cadenas vacías';
      }else if(!preg_match('/^[1-9][0-9]+GB$/',$post['memoria'])){
          $errores['memoria'] = 'memoria no válida';
      } 
      
      
            
    if(empty($post['alimentacion'])){
          $errores['alimentacion'] = 'Tienes que escribir un tipo de alimentacion';
      }else if(strlen(trim($post['alimentacion'])) == 0){
          $errores['alimentacion'] = 'No se aceptan cadenas vacías';
      }else if(!preg_match('/[a-zA-Z0-9\s\-]+/',$post['targeta_video'])){
          $errores['alimentacion'] = 'nombre de alimentacion no válido';
      }
      
      if(empty($post['almacenamiento_tipo'])){
       $errores['almacenamiento_tipo'] = 'Debes de escoger un tipo';
 
      }
      else if(!in_array($post['almacenamiento_tipo'],$tipoAlmacenamiento)){
          $errores['almacenamiento_tipo'] = 'Tipo de almacenamiento no permitido';
      }
      
     $errores['url_imagen'] = $this->checkFormImage($_FILES["imagen"]);
     if($errores['url_imagen'] == NULL){
         unset($errores['url_imagen']);
     }

      return $errores;
    }
}
