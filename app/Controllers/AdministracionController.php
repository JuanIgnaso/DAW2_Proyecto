<?php



namespace Com\Daw2\Controllers;

class AdministracionController extends \Com\Daw2\Core\BaseController{
   
    
    
    public function showAdministracion(){
        $modelCategoria = new \Com\Daw2\Models\CategoriaModel();
        $data = [];
        $data['titulo'] = 'Tramitando Pedido';
        $data['categoria'] = $modelCategoria->getAll();
        
        $this->view->showViews(array('Administracion.view.php'),$data);     
    }
    
}

