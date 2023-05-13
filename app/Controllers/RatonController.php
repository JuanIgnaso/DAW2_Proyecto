<?php
namespace Com\Daw2\Controllers;

class RatonController extends \Com\Daw2\Core\BaseController{
   
    
    
    public function showListaRatones(){
        $modelCategoria = new \Com\Daw2\Models\CategoriaModel();
        $modelRaton =  new \Com\Daw2\Models\RatonesModel();
        $modelConexiones = new \Com\Daw2\Models\AuxModelConexionesRaton();
        
        $data = [];
        $data['seccion'] = '/inventario/Ratones';
        $data['tipo'] = 'Ratones';
        $data['titulo'] = 'Inventario Ratones';
        $data['input'] = filter_var_array($_GET,FILTER_SANITIZE_SPECIAL_CHARS);
        $data['productos'] = $modelRaton->filterAll($_GET);
        $data['conexiones'] = $modelConexiones->getAll();
        $data['categoria'] = $modelCategoria->getAll();
        
        $copiaGET = $_GET;
        unset($copiaGET['order']);
        if(count($copiaGET) > 0){
            $data['queryString'] = "&".http_build_query($copiaGET);
        }else{
            $data['queryString'] = "";
        }
        
        
        
        $this->view->showViews(array('templates/inventarioHead.php','Ratones.view.php'),$data); 
    }
    
}