<?php

namespace Com\Daw2\Controllers;

class InicioController extends \Com\Daw2\Core\BaseController{
    
    public function index(){
        $this->view->showViews(array('index.php','templates/footer.view.php'));
    }
    

}

