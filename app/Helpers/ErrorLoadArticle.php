<?php

namespace Com\Daw2\Helpers;

class ErrorLoadArticle extends \Com\Daw2\Core\BaseController{
    
    private $titulo;
    private $mensaje;
    
     function __construct(string $titulo, string $mensaje){
        $this->titulo = $titulo;
        $this->mensaje = $mensaje;
    }
    
    function loadError(){
        $data = [];
        $data['titulo'] = $this->titulo; 
        $data['mensaje'] = $this->mensaje;
       $this->view->showViews(array('templates/header_listado.php','templates/header_navbar.php','errorCargarCategoria.view.php','templates/footer.view.php'),$data);
    }
    
    public function getTitulo() {
        return $this->titulo;
    }

    public function getMensaje() {
        return $this->mensaje;
    }


}

