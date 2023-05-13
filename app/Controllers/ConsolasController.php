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
        $data['productos'] = $model->filterAll();
        $data['conexiones'] = $modelConexiones->getAll();
        $this->view->showViews(array('templates/inventarioHead.php','Consolas.view.php'),$data); 
    }
    
}