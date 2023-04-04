<?php

namespace Com\Daw2\Controllers;

class InicioController extends \Com\Daw2\Core\BaseController{
    
    public function index(){
        $this->view->show('index.php');
    }
    
        public function login(){
        $this->view->show('login.php');
    }
}

