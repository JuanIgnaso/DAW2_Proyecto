<?php

namespace Com\Daw2\Controllers;

class PedidoController extends \Com\Daw2\Core\BaseController{
    
    public function showCheckOut(){
        $modelCategoria = new \Com\Daw2\Models\CategoriaModel();
        $data = [];
        $data['titulo'] = 'Tramitando Pedido';
        $data['categoria'] = $modelCategoria->getAll();
        
        $this->view->showViews(array('templates/header_checkout.php','templates/header_checkout_navbar.php','CheckOutView.php','templates/footer_checkout.view.php'),$data);     
    }
    
        function terminarCompra(){
        $modelo = new \Com\Daw2\Models\ProductosGeneralModel();
        $userModel = new \Com\Daw2\Models\UsuarioSistemaModel();
        
        //lo que recibes de ajax pro POST
        $recogida = $_POST['datos'];
        $var = $modelo->updateStock($recogida);
        
        
        //exit;
        // si no hay error (lo que querias hacer salió bien, Ejemplo: cambiar un dato desde el modelo)
        //$var = true;
        if ($var) {
            http_response_code(200);
            $_SESSION['usuario']['cartera'] = $_SESSION['usuario']['cartera'] - $_POST['total'];
            $update = $userModel->updateUserWallet($_POST['total'], $_SESSION['usuario']->getIdUsuario());
           // echo $_SESSION['usuario']->getCartera();
            //header('location: /checkout/sucess');
            //echo json_encode(["hola"=>$_POST['total']]);
            echo json_encode(true);
            exit;
        } else {
            // si hay error (lo que querias hacer salió mal)
            http_response_code(400);
            echo json_encode(["hola"=>"adios"]); //texto de error o array de errores que quieres mostrarle al usuario (se lo  envias a Ajax)
            exit;
        }


        // lo que le envias a ajax de respuesta (lo que recibe ajax)
        echo json_encode($recogida);
        exit;
    }
    
    function checkUserSalary(){
        if($_POST['total'] >= $_SESSION['usuario']->getCartera()){
          $var = false;
        }else{
            $var = true;
        }
        if ($var) {
            http_response_code(200);    
            echo json_encode(["hola"=>'todo ok']);
             //$this->checkOutSuccess();
            exit;
        } else {
            // si hay error (lo que querias hacer salió mal)
            http_response_code(400);
            echo json_encode(["hola"=>"adios"]); //texto de error o array de errores que quieres mostrarle al usuario (se lo  envias a Ajax)
            exit;
        }
         
    }
    
    function checkOutSuccess(){
       $modelCategoria = new \Com\Daw2\Models\CategoriaModel();
        $data = [];
        $data['titulo'] = 'Pedido Confirmado';
        $data['categoria'] = $modelCategoria->getAll();
        $this->view->showViews(array('templates/header.view.php','templates/header_navbar.php','CheckOutSuccess.view.php','templates/footer.view.php'),$data);     

    }

}

