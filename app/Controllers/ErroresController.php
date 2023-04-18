<?php

namespace Com\Daw2\Controllers;

class ErroresController extends \Com\Daw2\Core\BaseController{
    
    function error404():void{
        http_response_code(404);
        $data = ['titulo' => 'Error 404'];
        $data['texto'] = 'Error 404: Página no encontrada';
        $data['icono'] = 'fa-regular fa-face-frown';
        $this->view->showViews(array('templates/header_listado.php','templates/header_navbar.php','error.view.php','templates/footer.view.php'),$data);
    }
    
        function error405():void{
        http_response_code(405);
        $data = ['titulo' => 'Error 405'];
        $data['texto'] = 'Error 405: Método no permitido.';
        $data['icono'] = 'fa-solid fa-ban';
        $this->view->showViews(array('templates/header_listado.php','templates/header_navbar.php','error.view.php','templates/footer.view.php'),$data);
    }
}
