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
        $data['proveedor'] = $modelProv->getAll();
        $data['titulo'] = 'Editar Producto';
        $data['titulo_seccion'] = 'Modificar Ratón';
        $data['iva'] = self::IVA;
        $data['accion'] = 'Aplicar Cambios';
        $data['volver'] = '/inventario/Teclados';
        $data['input'] = $input;
        $data['id_conectividad'] = $conectividadModel->getAll();
        $data['id_clase'] = $claseModel->getAll();
        $data['idioma_T'] = $idiomaModel->getAll();
        $diseño =  $model->getDiseño();
        $patrones = array();
        $patrones[0] = '/\'/';
        $patrones[1] = '/\(/';
        $patrones[2] = '/\)/';
        $data['diseño_Teclado'] = preg_replace($patrones,'',explode(',',$diseño[0]['SUBSTRING(COLUMN_TYPE,5)']));

        
        
        $this->view->showViews(array('templates/inventarioHead.php','templates/headerNavInventario.php','AddTeclado.view.php'),$data); 
    }
    
    
    
    public function edit($cod){
    $model = new \Com\Daw2\Models\TecladosModel(); 
    $data = [];

    $data['errores'] = $this->checkForm($_POST,$alta = false);
    if(count($data['errores']) == 0){
             $saneado = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
             $modelGeneral =  new \Com\Daw2\Models\ProductosGeneralModel();
             $urlimg = $modelGeneral->getProductImg($_POST['codigo_producto']);
                     
             
             if(!empty($_FILES["imagen"]["tmp_name"])){
              unlink(substr($urlimg,1,strlen($urlimg)));
               if($this->uploadPhoto('assets/img/teclados/')){
                 $_POST['imagen_p'] = '/assets/img/teclados/'.$_FILES["imagen"]["name"];
               }       
              }else{
                $_POST['imagen_p'] = $urlimg;
              }        
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
                $data['proveedor'] = $modelProv->getAll();
                $data['iva'] = self::IVA;
                $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
                $data['id_conectividad'] = $conectividadModel->getAll();
                $data['id_clase'] = $claseModel->getAll();
                $data['idioma_T'] = $idiomaModel->getAll();
                $diseño = $model->getDiseño();
                $data['volver'] = '/inventario/Ratones';

                $patrones = array();
                $patrones[0] = '/\'/';
                $patrones[1] = '/\(/';
                $patrones[2] = '/\)/';
                $data['diseño_Teclado'] = preg_replace($patrones,'',explode(',',$diseño[0]['SUBSTRING(COLUMN_TYPE,5)']));

                
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
        $data['proveedor'] = $modelProv->getAll();
        $data['accion'] = 'Añadir';
        $data['id_conectividad'] = $conectividadModel->getAll();
        $data['id_clase'] = $claseModel->getAll();
        $data['idioma_T'] = $idiomaModel->getAll();
        $data['iva'] = self::IVA;
        $diseño =  $model->getDiseño();
        $patrones = array();
        $patrones[0] = '/\'/';
        $patrones[1] = '/\(/';
        $patrones[2] = '/\)/';
        $data['diseño_Teclado'] = preg_replace($patrones,'',explode(',',$diseño[0]['SUBSTRING(COLUMN_TYPE,5)']));
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
             if(!empty($_FILES["imagen"]["tmp_name"])){
               if($this->uploadPhoto('assets/img/teclados/')){
                 $_POST['imagen_p'] = '/assets/img/teclados/'.$_FILES["imagen"]["name"];
               }       
              } 
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
            $data['iva'] = self::IVA;
            $data['proveedor'] = $modelProv->getAll();
            $data['id_conectividad'] = $conectividadModel->getAll();
            $data['id_clase'] = $claseModel->getAll();
            $data['idioma_T'] = $idiomaModel->getAll();
            $diseño =  $model->getDiseño();
            $patrones = array();
             $patrones[0] = '/\'/';
             $patrones[1] = '/\(/';
             $patrones[2] = '/\)/';
             $data['diseño_Teclado'] = preg_replace($patrones,'',explode(',',$diseño[0]['SUBSTRING(COLUMN_TYPE,5)']));
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
    
    
    
    
    private function checkForm(array $post, bool $alta = true):array{
        
      $errores = []; 
      
      //COMPROBACION DE IMG
      if(!empty($_FILES["imagen"]["tmp_name"])){
       $check = getimagesize($_FILES["imagen"]["tmp_name"]);
       $formato = strtolower(pathinfo($_FILES["imagen"]['name'],PATHINFO_EXTENSION));
      }
      
        
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
      
        
      if(!$modelProv->proveedorExists($post['proveedor'])){
          $errores['proveedor'] = 'El proveedor que has seleccionado no existe';
      }else if(empty((int)$post['proveedor'])){
          $errores['proveedor'] = 'Debes seleccionar un proveedor';
      }
      
      
      if(!in_array($post['iva'],self::IVA)){
          $errores['iva'] = 'Valor de IVA no permitido';
      }
      
      
     if(empty($post['diseño_Teclado'])){
         $errores['diseños'] = 'Tienes que selecionar un diseño de teclado';
     }
     
    if(!$idiomaModel->idiomaExists($post['idioma_T'])){
        $errores['idioma'] = 'el idioma seleccionado no existe.'; 
     }
     
     else if(!$idiomaModel->idiomaExists($post['idioma_T'])){
        $errores['idioma'] = 'el idioma seleccionado no existe.'; 
     }
     
     if(empty($post['id_conectividad'])){
        $errores['conectividad'] = 'selecciona una conectividad.'; 
     }else
     if(!$conectividadModel->conectividadExists($post['id_conectividad'])){
      $errores['conectividad'] = 'la conectividad seleccionada no existe.'; 
    
     }
      
     if(empty($post['id_clase'])){
      $errores['clase'] = 'selecciona una clase.'; 
    
     } else
     if(!$claseModel->claseExists($post['id_clase'])){
      $errores['clase'] = 'la clase seleccionada no existe.'; 
    
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
