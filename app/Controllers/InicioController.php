<?php

namespace Com\Daw2\Controllers;

class InicioController extends \Com\Daw2\Core\BaseController{
    
    const categorias = array('Teclados','Monitores','Ratones');
    
    public function index(){
        $modelCategoria = new \Com\Daw2\Models\CategoriaModel();
        $data = [];
        $data['categoria'] = $modelCategoria->getAll();

        $this->view->showViews(array('index.php','templates/footer.view.php'),$data);
    }
    
       public function test(){
        $this->view->show('hola.php');
    }
    
    
    function lista_productos($id){  
        $model = new \Com\Daw2\Models\ProductosGeneralModel();
        $modelCategoria = new \Com\Daw2\Models\CategoriaModel();
        $category_info = $modelCategoria->selectCategory($id);
        if(!$category_info){
            $this->errorLoadCategory($id);
        }else{
         $data = [];
        $data['input'] = filter_var_array($_GET, FILTER_SANITIZE_SPECIAL_CHARS);
        $data['direccion'] = '/productos/categoria/'.$id;
        $data['titulo'] = 'Productos - '.$category_info['nombre_categoria'];
        $data['descripcion'] = $category_info['descripcion'];
        $data['seccion'] = $category_info['nombre_categoria'];
        $data['categoria'] = $modelCategoria->getAll();
        $data['productos'] = $model->showCategory($id,$_GET);
        
        $copiaGET = $_GET;
        unset($copiaGET['filterby']);
        if(count($copiaGET) > 0){
            $data['queryString'] = "&".http_build_query($copiaGET);
        }else{
            $data['queryString'] = "";
        }
  
        $data['error'] = 'No se encuentran aún productos registrados.';
          $this->view->showViews(array('templates/header_listado.php','templates/header_navbar.php','productos_inicio.view.php','templates/footer.view.php'),$data);
 
        }
        
    }
    
    /*Se lanza este método cuando el valor devuelto es false*/
    private function errorLoadCategory($id){
        
        $data = [];
        $data['titulo'] = 'Error'; 
        $data['mensaje'] = "No se puede encontrar registro <span class='text-danger'>".$id."</span> de datos en la tabla categorías";
        $this->view->showViews(array('templates/header_listado.php','templates/header_navbar.php','errorCargarCategoria.view.php','templates/footer.view.php'),$data);
        
    }

}

