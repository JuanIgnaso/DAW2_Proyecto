<?php



namespace Com\Daw2\Controllers;

class PCMontadosController extends \Com\Daw2\Core\BaseController{
    
    
    public function showListaPC(){
        
       $model =  new \Com\Daw2\Models\PCMontadosModel();
       $data = []; 
       $data['titulo'] = 'Inventario PC Montados';
       $data['tipo'] = 'PC Montados';
       $data['seccion'] = '/inventario/Ordenadores';
       $data['input'] = filter_var_array($_GET,FILTER_SANITIZE_SPECIAL_CHARS);
       $data['productos'] = $model->filterAll($_GET);
       $data['almacenamientos'] = $model->getStorageQuantity();
       $data['memorias'] = $model->getMemoryQuantity();

       $copiaGET = $_GET;
        unset($copiaGET['order']);
        if(count($copiaGET) > 0){
            $data['queryString'] = "&".http_build_query($copiaGET);
        }else{
            $data['queryString'] = "";
        }
       
       
      $this->view->showViews(array('templates/inventarioHead.php','PCMontados.view.php'),$data); 
 
    }
}
