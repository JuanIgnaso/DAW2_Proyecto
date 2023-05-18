<?php

namespace Com\Daw2\Controllers;

class TecladoController extends \Com\Daw2\Core\BaseController{
    private const IVA = [12,18,21];

    
    
    public function showListaTeclados(){
        //$modelCategoria = new \Com\Daw2\Models\CategoriaModel();
        $modelTeclado =  new \Com\Daw2\Models\TecladosModel();
        
        
        //clase, conectividad y idioma
        
        $conectividadModel = new \Com\Daw2\Models\AuxConectividadTecladoModel();
        $claseModel = new \Com\Daw2\Models\AuxClaseTecladoModel();
        $idiomaModel =  new \Com\Daw2\Models\AuxIdiomaModel();
        
        $data = [];
        $data['seccion'] = '/inventario/Teclados';
        $data['tipo'] = 'Teclados';
        $data['titulo'] = 'Inventario Teclados';
        $data['input'] = filter_var_array($_GET,FILTER_SANITIZE_SPECIAL_CHARS);
        $data['productos'] = $modelTeclado->filterAll($_GET);
        $data['conectividades'] = $conectividadModel->getAll();
        $data['clases'] = $claseModel->getAll();
        $data['idiomas'] = $idiomaModel->getAll();
        
        
        $copiaGET = $_GET;
        unset($copiaGET['order']);
        if(count($copiaGET) > 0){
            $data['queryString'] = "&".http_build_query($copiaGET);
        }else{
            $data['queryString'] = "";
        }
        
        
        $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','Teclados.view.php'),$data); 
    }
    
    
    public function showEdit($cod){
        $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();

        $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();
        $model = new \Com\Daw2\Models\TecladosModel(); 
        $conectividadModel = new \Com\Daw2\Models\AuxConectividadTecladoModel();
        $claseModel = new \Com\Daw2\Models\AuxClaseTecladoModel();
        $idiomaModel =  new \Com\Daw2\Models\AuxIdiomaModel();
        
        $data = [];
        $input = $model->getProducto($cod);
        $data['seccion'] = '/inventario/Teclados/edit/'.$cod;
        $data['proveedores'] = $modelProv->getAll();
        $data['titulo'] = 'Editar Producto';
        $data['titulo_seccion'] = 'Modificar Ratón';
        $data['ivas'] = self::IVA;
        $data['accion'] = 'Aplicar Cambios';
        $data['volver'] = '/inventario/Teclados';
        $data['input'] = $input;
        $data['conectividades'] = $conectividadModel->getAll();
        $data['clases'] = $claseModel->getAll();
        $data['idiomas'] = $idiomaModel->getAll();
        $diseño =  $model->getDiseño();
        $patrones = array();
        $patrones[0] = '/\'/';
        $patrones[1] = '/\(/';
        $patrones[2] = '/\)/';
        $data['diseños'] = preg_replace($patrones,'',explode(',',$diseño[0]['SUBSTRING(COLUMN_TYPE,5)']));

        
        
        $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddTeclado.view.php'),$data); 
    }
    
    
    
    public function edit($cod){
    $model = new \Com\Daw2\Models\TecladosModel(); 
    $data = [];

    $data['errores'] = $this->checkForm($_POST,$alta = false);
    if(count($data['errores']) == 0){
             $saneado = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
             $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
             $result = $this->modifyTeclado($_POST['id_Teclado'],$_POST['codigo_producto'],$_POST);
                     if($result){
                header('location: /inventario/Teclados');   
            }else{
                 $_SESSION['error_añadir'] = 'Ha ocurrido un error al intentar añadir el producto';
                }
            }else{
                $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();
                $conectividadModel = new \Com\Daw2\Models\AuxConectividadTecladoModel();
                $claseModel = new \Com\Daw2\Models\AuxClaseTecladoModel();
                $idiomaModel =  new \Com\Daw2\Models\AuxIdiomaModel();
                $data['titulo'] = 'Editar Producto';
                $data['titulo_seccion'] =  'Editar Producto';
                $data['accion'] = 'Aplicar Cambios';
                $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();
                $data['seccion'] = '/inventario/Teclados/edit/'.$cod;
                $data['proveedores'] = $modelProv->getAll();
                $data['ivas'] = self::IVA;
                $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
                $data['conectividades'] = $conectividadModel->getAll();
                $data['clases'] = $claseModel->getAll();
                $data['idiomas'] = $idiomaModel->getAll();
                $diseño = $model->getDiseño();
                $data['volver'] = '/inventario/Ratones';

                $patrones = array();
                $patrones[0] = '/\'/';
                $patrones[1] = '/\(/';
                $patrones[2] = '/\)/';
                $data['diseños'] = preg_replace($patrones,'',explode(',',$diseño[0]['SUBSTRING(COLUMN_TYPE,5)']));

                
                $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddTeclado.view.php'),$data); 
  
            }
    }
    
    
       private function modifyTeclado($idTec,$id,array $post): bool{
      $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
      $model = new \Com\Daw2\Models\TecladosModel();
      
      if($modelGeneral->editProduct($post,$id)){
          if($model->editTeclado($post,$idTec)){
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
        $model = new \Com\Daw2\Models\TecladosModel(); 
        $conectividadModel = new \Com\Daw2\Models\AuxConectividadTecladoModel();
        $claseModel = new \Com\Daw2\Models\AuxClaseTecladoModel();
        $idiomaModel =  new \Com\Daw2\Models\AuxIdiomaModel();
        
        $data = [];
        $data['seccion'] = '/inventario/Teclados/add';
        $data['tipo'] = 'Teclados';
        $data['volver'] = '/inventario/Teclados';
        $data['titulo'] = 'Añadir Producto';
        $data['proveedores'] = $modelProv->getAll();
        $data['accion'] = 'Añadir';
        $data['conectividades'] = $conectividadModel->getAll();
        $data['clases'] = $claseModel->getAll();
        $data['idiomas'] = $idiomaModel->getAll();
        $data['ivas'] = self::IVA;
        $diseño =  $model->getDiseño();
        $patrones = array();
        $patrones[0] = '/\'/';
        $patrones[1] = '/\(/';
        $patrones[2] = '/\)/';
        $data['diseños'] = preg_replace($patrones,'',explode(',',$diseño[0]['SUBSTRING(COLUMN_TYPE,5)']));
        $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddTeclado.view.php'),$data); 

    }
    
    
    public function add(){
       $model = new \Com\Daw2\Models\TecladosModel(); 
       $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();

        
          $data = [];
          $data['titulo'] = 'Añadir Producto';
          $data['errores'] = $this->checkForm($_POST);
          $data['accion'] = 'Añadir';
          $data['volver'] = '/inventario/Teclados';
          
          if(count($data['errores']) == 0){
              $result = $this->addTeclado(2,$_POST);
              if($result){
                header('location: '.$data['volver']);   
            }else{
                 $_SESSION['error_añadir'] = 'Ha ocurrido un error al intentar añadir el producto';
                }
          }else{
            $modelProv  = new \Com\Daw2\Models\AuxProveedoresModel();
            $conectividadModel = new \Com\Daw2\Models\AuxConectividadTecladoModel();
            $claseModel = new \Com\Daw2\Models\AuxClaseTecladoModel();
            $idiomaModel =  new \Com\Daw2\Models\AuxIdiomaModel();
            $data['seccion'] = '/inventario/Teclados/add';
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data['ivas'] = self::IVA;
            $data['proveedores'] = $modelProv->getAll();
            $data['conectividades'] = $conectividadModel->getAll();
            $data['clases'] = $claseModel->getAll();
            $data['idiomas'] = $idiomaModel->getAll();
            $diseño =  $model->getDiseño();
            $patrones = array();
             $patrones[0] = '/\'/';
             $patrones[1] = '/\(/';
             $patrones[2] = '/\)/';
             $data['diseños'] = preg_replace($patrones,'',explode(',',$diseño[0]['SUBSTRING(COLUMN_TYPE,5)']));
             $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddTeclado.view.php'),$data); 

          }

    }
    
    
    private function addTeclado(int $categoria,array $post): bool{
      $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
      $model = new \Com\Daw2\Models\TecladosModel();
      
      if($modelGeneral->insertProduct($categoria,$post)){
          if($model->insertTeclado($post)){
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
      $idiomaModel =  new \Com\Daw2\Models\AuxIdiomaModel();
      $conectividadModel = new \Com\Daw2\Models\AuxConectividadTecladoModel();
      $claseModel = new \Com\Daw2\Models\AuxClaseTecladoModel();

      
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
      
      
     if(empty($post['diseños'])){
         $errores['diseños'] = 'Tienes que selecionar un diseño de teclado';
     }
     
    if(!$idiomaModel->idiomaExists($post['idioma'])){
        $errores['idioma'] = 'el idioma seleccionado no existe.'; 
     }
     
     else if(!$idiomaModel->idiomaExists($post['idioma'])){
        $errores['idioma'] = 'el idioma seleccionado no existe.'; 
     }
     
     if(empty($post['conectividades'])){
        $errores['conectividad'] = 'selecciona una conectividad.'; 
     }else
     if(!$conectividadModel->conectividadExists($post['conectividades'])){
      $errores['conectividad'] = 'la conectividad seleccionada no existe.'; 
    
     }
      
     if(empty($post['clases'])){
      $errores['clase'] = 'selecciona una clase.'; 
    
     } else
     if(!$claseModel->claseExists($post['clases'])){
      $errores['clase'] = 'la clase seleccionada no existe.'; 
    
     }
      
      return $errores;
        
    }
    
}
