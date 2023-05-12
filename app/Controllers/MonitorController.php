<?php

namespace Com\Daw2\Controllers;

class MonitorController extends \Com\Daw2\Core\BaseController{
   
    
    
    public function showListaMonitores(){
        $modelCategoria = new \Com\Daw2\Models\CategoriaModel();
        $modelMonitor =  new \Com\Daw2\Models\MonitoresModel();
        $modelTec =  new  \Com\Daw2\Models\AuxTecnologiaModel();
        
        //clase, conectividad y idioma
        
        
        $data = [];
        $data['seccion'] = '/inventario/Monitores';
        $data['tipo'] = 'Monitores';
        $data['productos'] = $modelMonitor->filterAll();
        $data['tecnologias'] = $modelTec->getAll();      
        $this->view->showViews(array('MonitoresView.php'),$data); 
    }
    
}