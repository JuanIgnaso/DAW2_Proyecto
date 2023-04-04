<?php

namespace Com\Daw2\Controllers;

class InicioController extends \Com\Daw2\Core\BaseController{
    
    public function index(){
        $this->view->showViews(array('index.php','templates/footer.view.php'));
    }
    
    public function lista_productos(){
        $this->view->showViews(array('perifericos_entrada_inicio.view.php','templates/footer.view.php'));
    }

}

