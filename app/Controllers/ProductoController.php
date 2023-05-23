<?php

namespace Com\Daw2\Controllers;

class ProductoController extends \Com\Daw2\Core\BaseController{
    
    
    /*Carga el producto cogiendo ID y nombre de producto*/
    function load_product($id,$nombre){
        $modelCategoria = new \Com\Daw2\Models\CategoriaModel();
        $model = new \Com\Daw2\Models\ProductosGeneralModel();
        $data = [];
        $data['categoria'] = $modelCategoria->getAll();
        $data['datos_generales'] = $model->getProduct($nombre);
        $data['detalles_producto'] = $this->getDetails($nombre,$id);
        if(!$data['detalles_producto']){
            $this->errorLoadProduct($nombre,'Error',"No se puede encontrar el producto <span class='text-danger'>".$nombre."</span> en la Base De Datos");
        }
        $this->view->showViews(array('templates/header.view.php','templates/header_navbar.php','product_details_view.php','templates/footer.view.php'),$data);
    }
    

    
    function deleteProduct(){
        $codigo_producto = $_POST['producto'];
        $model =  new \Com\Daw2\Models\ProductosGeneralModel();
        
        $accion = $model->deleteProduct($codigo_producto);
        
       
        
        
        if($accion){
         http_response_code(200); 
         echo json_encode(["hola"=>"todo correcto."]); //texto de error o array de errores que quieres mostrarle al usuario (se lo  envias a Ajax)
         exit;
         
        }else{
        http_response_code(400);  
          echo json_encode(["hola"=>"algo salió mal."]); //texto de error o array de errores que quieres mostrarle al usuario (se lo  envias a Ajax)
          exit;
        }
        
    }
    
    
    private function getDetails($nombre,$id){
        $detalles;
        $productModel;
        //ESTÁ
        if($id == 2){
            $productModel = new \Com\Daw2\Models\TecladosModel();
            $detalles = $productModel->loadDetails($nombre);
        //ESTÁ    
        }else if($id == 3){
           $productModel = new \Com\Daw2\Models\SillasModel(); 
          $detalles = $productModel->loadDetails($nombre);
           //ESTÁ
        } else if($id == 6){
           $productModel = new \Com\Daw2\Models\ConsolasModel(); 
           $detalles = $productModel->loadDetails($nombre);
           //TENGO QUE METER COSAS
        }else if($id == 5){
           $productModel = new \Com\Daw2\Models\MandosModel(); 
           $detalles = $productModel->loadDetails($nombre);   
        }
        //ESTÁ
        else if($id == 7){
            $productModel = new \Com\Daw2\Models\RatonesModel(); 
           $detalles = $productModel->loadDetails($nombre);
        }   
        //ESTÁ
        else if($id == 9){
           $productModel = new \Com\Daw2\Models\MonitoresModel(); 
           $detalles = $productModel->loadDetails($nombre);
           unset($detalles['tecnologia']);
        } 
        //ESTÁ
        else if($id == 10){
            $productModel = new \Com\Daw2\Models\PCMontadosModel(); 
           $detalles = $productModel->loadDetails($nombre);
        }
        //HAY QUE INTRODUCIR DATOS
        else if($id == 11){
            $productModel = new \Com\Daw2\Models\SistemasOperativosModel(); 
           $detalles = $productModel->loadDetails($nombre);
        }else{
            $this->errorLoadProduct($id,'Error al cargar Categoría', "La categoría <span class='text-danger'>".$id."</span> que intentas cargar no existe!.");
        }
        return $detalles;
    }
    
    
    private function errorLoadProduct($nombre, string $error, string $mensaje){
        
        $data = [];
        $data['titulo'] = $error; 
        $data['mensaje'] = $mensaje;
        $this->view->showViews(array('templates/header_listado.php','templates/header_navbar.php','errorCargarCategoria.view.php','templates/footer.view.php'),$data);
        
    }
}
