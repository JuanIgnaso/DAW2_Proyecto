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
        $data['titulo'] = 'Tramitando Pedido';
        $data['productos'] = $modelRaton->filterAll();
        $data['conexiones'] = $modelConexiones->getAll();
        $data['categoria'] = $modelCategoria->getAll();
        $this->view->showViews(array('Ratones.view.php'),$data); 
    }
    
}