<?php

namespace Com\Daw2\Controllers;

class MonitorController extends \Com\Daw2\Core\BaseController{
   
    
    
    public function showListaMonitores(){
        $modelMonitor =  new \Com\Daw2\Models\MonitoresModel();
        $modelTec =  new  \Com\Daw2\Models\AuxTecnologiaModel();
        
        //clase, conectividad y idioma
        
        
        $data = [];
        $data['seccion'] = '/inventario/Monitores';
        $data['tipo'] = 'Monitores';
        $data['titulo'] = 'Inventario Monitores';
        $data['input'] = filter_var_array($_GET,FILTER_SANITIZE_SPECIAL_CHARS);
        $data['productos'] = $modelMonitor->filterAll($_GET);
        $data['tecnologias'] = $modelTec->getAll();
        $data['refrescos'] = $modelMonitor->getRefreshRate();
               
        $copiaGET = $_GET;
        unset($copiaGET['order']);
        if(count($copiaGET) > 0){
            $data['queryString'] = "&".http_build_query($copiaGET);
        }else{
            $data['queryString'] = "";
        }
        
        
        $this->view->showViews(array('templates/inventarioHead.php','MonitoresView.php'),$data); 
    }
    
}