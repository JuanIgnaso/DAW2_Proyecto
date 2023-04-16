<?php

namespace Com\Daw2\Controllers;

class InicioController extends \Com\Daw2\Core\BaseController{
    
    const categorias = array('Teclados','Monitores','Ratones');
    
    public function index(){
        $this->view->showViews(array('index.php','templates/footer.view.php'));
    }
    
    
    
    function lista_productos($id){  
        $model = new \Com\Daw2\Models\ProductosGeneralModel();
        $modelCategoria = new \Com\Daw2\Models\CategoriaModel();
        $category_info = $modelCategoria->selectCategory($id);
        $data = [];
        $data['direccion'] = '/productos/categoria/'.$id;
        $data['titulo'] = 'Productos - '.$category_info['nombre_categoria'];
        $data['descripcion'] = $category_info['descripcion'];
        $data['seccion'] = $category_info['nombre_categoria'];
        $data['productos'] = $model->showCategory($id,$_GET);
        
        $data['error'] = 'No se encuentran aún productos registrados.';
          $this->view->showViews(array('templates/header_listado.php','templates/header_navbar.php','productos_inicio.view.php','templates/footer.view.php'),$data);

    }
    
//         function lista_ratones(){
//        $model = new \Com\Daw2\Models\ProductosGeneralModel();
//        $data = [];
//        $data['titulo'] = 'Periféricos - Ratones';
//        $data['descripcion'] = 'Esta es la sección de Ratones, en la que el usuario podrá encontrar entre una amplia variedad de marcas y tipos, DPI, RGB, gaming, TrackBall... el que mejor se adapte a tus necesidades del día a día.';
//        $data['seccion'] = 'Ratones';
//        $data['productos'] = $model->showCategory(self::categorias[1]);
//        $data['error'] = 'No se encuentran aún productos registrados.';
//        $this->view->showViews(array('templates/header_listado.php','ratones_inicio.view.php','templates/footer.view.php'),$data);
//
//    }
//    
//        function lista_monitores(){
//        $model = new \Com\Daw2\Models\ProductosGeneralModel();
//        $data = [];
//        $data['titulo'] = 'Periféricos - Monitores';
//        $data['descripcion'] = 'Aquí encontrarás los Monitores, todo tamaño y tipo de pantallas, marcas como LG,AOC,Philips... y resoluciones dependiendo de tu uso, desde ofimática hasta el gaming.';
//        $data['seccion'] = 'Monitores';
//        $data['productos'] = $model->showCategory(self::categorias[2]);
//        $data['error'] = 'No se encuentran aún productos registrados.';
//        $this->view->showViews(array('templates/header_listado.php','templates/header_navbar.php','monitores_inicio.view.php','templates/footer.view.php'),$data);
//
//    }

}

