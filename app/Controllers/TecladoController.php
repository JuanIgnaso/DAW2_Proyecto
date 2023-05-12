<?php

namespace Com\Daw2\Controllers;

class TecladoController extends \Com\Daw2\Core\BaseController{
   
    
    
    public function showListaTeclados(){
        $modelCategoria = new \Com\Daw2\Models\CategoriaModel();
        $modelTeclado =  new \Com\Daw2\Models\TecladosModel();
        
        
        //clase, conectividad y idioma
        
        $conectividadModel = new \Com\Daw2\Models\AuxConectividadTecladoModel();
        $claseModel = new \Com\Daw2\Models\AuxClaseTecladoModel();
        $idiomaModel =  new \Com\Daw2\Models\AuxIdiomaModel();
        
        $data = [];
        $data['seccion'] = '/inventario/Teclados';
        $data['tipo'] = 'Teclados';
        $data['titulo'] = 'Tramitando Pedido';
        $data['productos'] = $modelTeclado->filterAll();
        $data['conectividades'] = $conectividadModel->getAll();
        $data['clases'] = $claseModel->getAll();
        $data['idiomas'] = $idiomaModel->getAll();
        $this->view->showViews(array('Teclados.view.php'),$data); 
    }
    
}
