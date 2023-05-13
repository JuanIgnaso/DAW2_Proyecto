<?php

namespace Com\Daw2\Controllers;

class SillaController extends \Com\Daw2\Core\BaseController{
   
    
    
    public function showListaSillas(){
        $modelCategoria = new \Com\Daw2\Models\CategoriaModel();
        $model =  new \Com\Daw2\Models\SillasModel();

        $data = [];
        $data['seccion'] = '/inventario/Sillas';
        $data['tipo'] = 'Monitores';
        $data['productos'] = $model->filterAll();     
        $this->view->showViews(array('templates/inventarioHead.php','Sillas.view.php'),$data); 
    }
    
}