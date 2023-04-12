<?php

namespace Com\Daw2\Controllers;

class InicioController extends \Com\Daw2\Core\BaseController{
    
    const categorias = array('Teclado','Monitor','Raton');
    
    public function index(){
        $this->view->showViews(array('index.php','templates/footer.view.php'));
    }
    
    function lista_teclados(){  
        $model = new \Com\Daw2\Models\ProductosGeneralModel();
        $data = [];
        $data['titulo'] = 'Periféricos - Teclados';
        $data['descripcion'] = 'Esta es la sección de teclados, en la que el usuario podrá encontrar entre una amplia variedad de marcas y tipos, entre mecánico, gaming, de membrana... el que mejor se adapte a tus necesidades del día a día.';
        $data['seccion'] = 'Teclados';
        $data['productos'] = $model->showCategory(self::categorias[0]);
        $data['error'] = 'No se encuentran aún productos registrados.';
          $this->view->showViews(array('templates/header_listado.php','teclados_inicio.view.php','templates/footer.view.php'),$data);

    }
    
         function lista_ratones(){
        $model = new \Com\Daw2\Models\ProductosGeneralModel();
        $data = [];
        $data['titulo'] = 'Periféricos - Ratones';
        $data['descripcion'] = 'Esta es la sección de Ratones, en la que el usuario podrá encontrar entre una amplia variedad de marcas y tipos, DPI, RGB, gaming, TrackBall... el que mejor se adapte a tus necesidades del día a día.';
        $data['seccion'] = 'Ratones';
        $data['productos'] = $model->showCategory(self::categorias[1]);
        $data['error'] = 'No se encuentran aún productos registrados.';
        $this->view->showViews(array('templates/header_listado.php','ratones_inicio.view.php','templates/footer.view.php'),$data);

    }
    
        function lista_monitores(){
        $model = new \Com\Daw2\Models\ProductosGeneralModel();
        $data = [];
        $data['titulo'] = 'Periféricos - Monitores';
        $data['descripcion'] = 'Aquí encontrarás los Monitores, todo tamaño y tipo de pantallas, marcas como LG,AOC,Philips... y resoluciones dependiendo de tu uso, desde ofimática hasta el gaming.';
        $data['seccion'] = 'Monitores';
        $data['productos'] = $model->showCategory(self::categorias[2]);
        $data['error'] = 'No se encuentran aún productos registrados.';
        $this->view->showViews(array('templates/header_listado.php','monitores_inicio.view.php','templates/footer.view.php'),$data);

    }

}

