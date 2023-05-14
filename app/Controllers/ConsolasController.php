<?php
namespace Com\Daw2\Controllers;

class ConsolasController extends \Com\Daw2\Core\BaseController{
   
    
    
    public function showListaConsolas(){
        $model =  new \Com\Daw2\Models\ConsolasModel();
        $modelConexiones = new \Com\Daw2\Models\AuxModelConexionesRaton();
        
        $data = [];
        $data['seccion'] = '/inventario/Consolas';
        $data['tipo'] = 'Consolas';
        $data['titulo'] = 'Inventario Consolas';
        $data['productos'] = $model->filterAll($_GET);
        $data['conexiones'] = $modelConexiones->getAll();
        
                
        $copiaGET = $_GET;
        unset($copiaGET['order']);
        if(count($copiaGET) > 0){
            $data['queryString'] = "&".http_build_query($copiaGET);
        }else{
            $data['queryString'] = "";
        }
        
        
        $this->view->showViews(array('templates/inventarioHead.php','Consolas.view.php'),$data); 
    }
    
}