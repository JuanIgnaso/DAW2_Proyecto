<?php

namespace Com\Daw2\Controllers;

class PedidoController extends \Com\Daw2\Core\BaseController{
    
    public function showCheckOut(){
        $modelCategoria = new \Com\Daw2\Models\CategoriaModel();
        $data = [];
        $data['titulo'] = 'Tramitando Pedido';
        $data['categoria'] = $modelCategoria->getAll();
        
        $this->view->showViews(array('templates/header_checkout.php','templates/header_navbar.php','CheckOutView.php','templates/footer.view.php'),$data);     
    }
    
        function terminarCompra(){
        
        //lo que recibes de ajax pro POST
        $recogida = $_POST['datos'];
        var_dump($recogida);
        exit;
        // si no hay error (lo que querias hacer salió bien, Ejemplo: cambiar un dato desde el modelo)
        $var = true;
        if ($var) {
            http_response_code(200);
            echo json_encode(["hola"=>"adios jaja"]);
            //header("location: /laquesea");
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
    /*
update productos set("stock" = ((select(stock) FROM productos WHERE codigo_producto = $id)-cantidad) ) WHERE codigo_producto = $id;

select(stock) FROM table WHERE id = $id) 
     *      */
}

