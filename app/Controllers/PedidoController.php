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
        $dir_pedido = $_POST['envio'];
        $errores = $this->checkForm($dir_pedido);
        if(count($errores) == 0){
               $var = $modelo->updateStock($recogida);


            //exit;
            // si no hay error (lo que querias hacer salió bien, Ejemplo: cambiar un dato desde el modelo)
            //$var = true;
            if ($var) {
                http_response_code(200);
                $_SESSION['usuario']['cartera'] = $_SESSION['usuario']['cartera'] - $_POST['total'];
                $update = $userModel->updateUserWallet($_POST['total'], $_SESSION['usuario']['id_usuario']);
               // echo $_SESSION['usuario']->getCartera();
                //header('location: /checkout/sucess');
                //echo json_encode(["hola"=>$_POST['total']]);
                echo json_encode($dir_pedido);
                exit;
            } else {
                // si hay error (lo que querias hacer salió mal)
                http_response_code(400);
                echo json_encode(["hola"=>"adios"]); //texto de error o array de errores que quieres mostrarle al usuario (se lo  envias a Ajax)
                exit;
            } 
        }else{
           http_response_code(400);
           echo json_encode($errores); //texto de error o array de errores que quieres mostrarle al usuario (se lo  envias a Ajax)
           exit; 
        }
        


        // lo que le envias a ajax de respuesta (lo que recibe ajax)
        echo json_encode($recogida);
        exit;
    }
    
    
    function checkForm(array $dir_envio): array{
        $model = new \Com\Daw2\Models\DireccionEnvioModel();
        $errores = [];
        if(empty($dir_envio['nombre'])){
            $errores['nombre'] = 'No se aceptan cadenas vacías';
        }else if($model->userNameExists($dir_envio['id'],$dir_envio['nombre'])){
           $errores['nombre'] = 'El Nombre ya se encuentra en uso';  
        }
        if(empty($dir_envio['provincia'])){
            $errores['provincia'] = 'El campo provincia está vacío';
        }
        if(empty($dir_envio['ciudad'])){
            $errores['ciudad'] = 'El campo ciudad está vacío';
        }
        if(empty($dir_envio['postal'])){
            $errores['postal'] = 'El campo codigo postal está vacío';
        }else if(!preg_match('/[0-9]{5}/',$dir_envio['postal'])){
           $errores['postal'] = 'el codigo postal debe estar compuesto por 5 números.'; 
        }
        if(empty($dir_envio['calle'])){
            $errores['calle'] = 'El campo calle está vacío';
        }
        return $errores;
        
    }
    
    
    
    function checkUserSalary(){
        if($_POST['total'] >= $_SESSION['usuario']['cartera']){
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
    
    function checkShippingAddress(){
        $model = new \Com\Daw2\Models\DireccionEnvioModel();
         //lo que recibes de ajax pro POST
        
        $recogida = $_POST['id'];
        $consulta = $model->getUserShippingAddress($recogida);
        if(!is_null($consulta)){
            http_response_code(200);
            echo json_encode($consulta);
            //header("location: /laquesea");
            exit;
        }else {
            // si hay error (lo que querias hacer salió mal)
            http_response_code(400);
            echo json_encode(["hola"=>"mal"]); //texto de error o array de errores que quieres mostrarle al usuario (se lo  envias a Ajax)
            exit;
        }
        // si no hay error (lo que querias hacer salió bien, Ejemplo: cambiar un dato desde el modelo)
        
        
          
         

    }
    
    function checkOutSuccess(){
       $modelCategoria = new \Com\Daw2\Models\CategoriaModel();
        $data = [];
        $data['titulo'] = 'Pedido Confirmado';
        $data['categoria'] = $modelCategoria->getAll();
        $this->view->showViews(array('templates/header.view.php','templates/header_navbar.php','CheckOutSuccess.view.php','templates/footer.view.php'),$data);     

    }

}

