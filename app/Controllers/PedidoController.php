<?php

namespace Com\Daw2\Controllers;

class PedidoController extends \Com\Daw2\Core\BaseController{
    

    
    public function showCheckOut(){
        $modelCategoria = new \Com\Daw2\Models\CategoriaModel();
        $data = [];
        $data['titulo'] = 'Tramitando Pedido';
        $data['categoria'] = $modelCategoria->getAll();
        
        $this->view->showViews(array('templates/header_checkout.php','templates/header_checkout_navbar.php','CheckOutView.php','templates/footer.view.php'),$data);     
    }
    
    
    
    function terminarCompra(){
        $modelo = new \Com\Daw2\Models\ProductosGeneralModel();
        $userModel = new \Com\Daw2\Models\UsuarioSistemaModel();
        $dirModel = new \Com\Daw2\Models\DireccionEnvioModel();
        
        //lo que recibes de ajax pro POST
        
        $dir_pedido = $_POST['envio'];
        $errores = [];
        
        if(!isset($_POST['datos'])){
            $errores['carrito'] = 'No se encuentran productos que comprar';
             echo json_encode($errores);
             http_response_code(400);
             exit;
        }else{
            $recogida = $_POST['datos'];
            $errores = $this->checkForm($dir_pedido);
        }   
        
        if(count($errores) == 0){
               $var = $modelo->updateStock($recogida);

            if ($var) {
                http_response_code(200);
                $dirModel->insertShippingAddress($dir_pedido, $dir_pedido['id']);
                $_SESSION['usuario']['cartera'] = $_SESSION['usuario']['cartera'] - $_POST['total'];
                $update = $userModel->updateUserWallet($_POST['total'], $_SESSION['usuario']['id_usuario']);
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
        if(empty($dir_envio['nombre_titular'])){
            $errores['nombre'] = 'No se aceptan campos vacíos';
        }else if($model->userNameExists($dir_envio['id'],$dir_envio['nombre_titular'])){
           $errores['nombre'] = 'El Nombre ya se encuentra en uso';  
        }else if(strlen(trim($dir_envio['nombre_titular'])) == 0){
            $errores['nombre'] = 'No se aceptan cadenas vacías'; 
        }
        if(empty($dir_envio['provincia'])){
            $errores['provincia'] = 'El campo provincia está vacío';
        }else if(strlen(trim($dir_envio['provincia'])) == 0){
            $errores['provincia'] = 'No se aceptan cadenas vacías';
        }
        
        if(empty($dir_envio['ciudad'])){
            $errores['ciudad'] = 'El campo ciudad está vacío';
        }else if(strlen(trim($dir_envio['ciudad'])) == 0){
            $errores['ciudad'] = 'No se aceptan cadenas vacías';
        }
        
        if(empty($dir_envio['cod_postal'])){
            $errores['cod_postal'] = 'El campo codigo postal está vacío';
        }else if(!preg_match('/[0-9]{5}/',$dir_envio['cod_postal'])){
           $errores['postal'] = 'el codigo postal debe estar compuesto por 5 números.'; 
        }else if(strlen(trim($dir_envio['cod_postal'])) == 0){
            $errores['postal'] = 'No se aceptan cadenas vacías';
        }
        
        if(empty($dir_envio['calle'])){
            $errores['calle'] = 'El campo calle está vacío';
        }else if(strlen(trim($dir_envio['calle'])) == 0){
            $errores['calle'] = 'No se aceptan cadenas vacías';
        }
        return $errores;
        
    }
    
    
    /***
     * Comprobar el salario del usuario
     */
    function checkUserSalary(){
        if($_POST['total'] >= $_SESSION['usuario']['cartera']){
          $var = false;
        }else{
            $var = true;
        }
        if ($var) {
            http_response_code(200);    
            echo json_encode(["hola"=>'todo ok']);
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

