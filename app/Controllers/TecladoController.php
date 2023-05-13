<?php

namespace Com\Daw2\Controllers;

class TecladoController extends \Com\Daw2\Core\BaseController{
   
    
    
    public function showListaTeclados(){
        //$modelCategoria = new \Com\Daw2\Models\CategoriaModel();
        $modelTeclado =  new \Com\Daw2\Models\TecladosModel();
        
        
        //clase, conectividad y idioma
        
        $conectividadModel = new \Com\Daw2\Models\AuxConectividadTecladoModel();
        $claseModel = new \Com\Daw2\Models\AuxClaseTecladoModel();
        $idiomaModel =  new \Com\Daw2\Models\AuxIdiomaModel();
        
        $data = [];
        $data['seccion'] = '/inventario/Teclados';
        $data['tipo'] = 'Teclados';
        $data['titulo'] = 'Inventario Teclados';
        $data['input'] = filter_var_array($_GET,FILTER_SANITIZE_SPECIAL_CHARS);
        $data['productos'] = $modelTeclado->filterAll($_GET);
        $data['conectividades'] = $conectividadModel->getAll();
        $data['clases'] = $claseModel->getAll();
        $data['idiomas'] = $idiomaModel->getAll();
        
        
        $copiaGET = $_GET;
        unset($copiaGET['order']);
        if(count($copiaGET) > 0){
            $data['queryString'] = "&".http_build_query($copiaGET);
        }else{
            $data['queryString'] = "";
        }
        
        
        $this->view->showViews(array('templates/inventarioHead.php','Teclados.view.php'),$data); 
    }
    
}
