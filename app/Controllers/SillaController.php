<?php

namespace Com\Daw2\Controllers;

class SillaController extends \Com\Daw2\Core\BaseController{
   
    
    
    public function showListaSillas(){
        $model =  new \Com\Daw2\Models\SillasModel();

        $data = [];
        $data['seccion'] = '/inventario/Sillas';
        $data['tipo'] = 'Sillas';
        $data['productos'] = $model->filterAll($_GET);  
        $data['input'] = filter_var_array($_GET,FILTER_SANITIZE_SPECIAL_CHARS);
        $data['alturas'] =$model->getChairHight();
        $data['anchuras'] = $model->getChairLenght();
        
        $copiaGET = $_GET;
        unset($copiaGET['order']);
        if(count($copiaGET) > 0){
            $data['queryString'] = "&".http_build_query($copiaGET);
        }else{
            $data['queryString'] = "";
        }
        
        
        $this->view->showViews(array('templates/inventarioHead.php','Sillas.view.php'),$data); 
    }
    
}