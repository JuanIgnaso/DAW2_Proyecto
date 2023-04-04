<?php

namespace Com\Daw2\Controllers;

/*
Funcion para destruir la session
*/

class SessionController extends \Com\Daw2\Core\BaseController{
    
    public function logout(){
        if(isset($_SESSION['usuario'])){
            session_destroy();
        }
        header('location: /');
    }
}

