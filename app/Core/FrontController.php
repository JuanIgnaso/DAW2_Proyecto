<?php

namespace Com\Daw2\Core;

use Steampixel\Route;

class FrontController{
    
    static function main(){
        session_start(); //Escribir aqui lo de session start para que mantenga la sesion
       
            /*
             Modificamos el login para que si no hay ningún usuario registrado
             * siempre nos redirija al login, evintado que pueda acceder a otras
             * partes de la web
            */
        
            Route::add('/',
                    function(){
                    $controler = new \Com\Daw2\Controllers\InicioController();
                    $controler->index();
                    }
                    ,'get');
                    
                    /*MOSTRAR LISTADO DE PRODUCTOS*/
                        Route::add('/productos/categoria/([A-Za-z0-9]+)',
                    function($id){
                    $controler = new \Com\Daw2\Controllers\InicioController();
                    $controler->lista_productos($id);
                    }
                    ,'get');
                    
                    Route::add('/productos/categoria/([A-Za-z0-9]+)/product_detail/([A-Za-z0-9\.\-\/ ]+)',
                    function($id,$nombre){
                    $controler = new \Com\Daw2\Controllers\ProductoController();
                    $controler->load_product($id,$nombre);
                    }
                    ,'get');
                    
                    Route::add('/test',
                    function(){
                    $controler = new \Com\Daw2\Controllers\InicioController();
                    $controler->test();
                    }
                    ,'get');

                    
            Route::add('/login',
                    function(){
                    $controler = new \Com\Daw2\Controllers\UsuarioSistemaController();
                    $controler->login();
                    }
                    ,'get');
                    
           Route::add('/login',
                    function(){
                    $controler = new \Com\Daw2\Controllers\UsuarioSistemaController();
                    $controler->loginUser();
                    }
                    ,'post');
  
            
             /*DESLOGUEAR USUARIO*/
                    
             Route::add('/logout',
                     function(){
                     $controller = new \Com\Daw2\Controllers\SessionController();
                     $controller->logout();
                     }
                     ,'get');        
                    
                     
       if(isset($_SESSION['permisos']) && isset($_SESSION['permisos']['usuarios'])){
           
                       /*MOSTRAR USUARIOS(PROVISIONAL)*/
          Route::add('/usuarios/add',
                     function(){
                     $controller = new \Com\Daw2\Controllers\UsuarioSistemaController();
                     $controller->showAdd();
                     }
                     ,'get');     
       
                  Route::add('/usuarios/add',
                     function(){
                     $controller = new \Com\Daw2\Controllers\UsuarioSistemaController();
                     $controller->addUser();
                     }
                     ,'post');  
           
       }     
       
       if(isset($_SESSION['usuario'])){
                     Route::add('/mi_Perfil',
                     function(){
                     $controller = new \Com\Daw2\Controllers\UsuarioSistemaController();
                     $controller->showUserProfile();
                     }
                     ,'get'); 
                     
                     
              Route::add('/mi_Perfil/baja',
                function () {
                    $controlador = new \Com\Daw2\Controllers\UsuarioSistemaController();
                    $controlador->darDeBaja();
                }
                , 'get');
                
                
                Route::add('/mi_Perfil/baja',
                function () {
                    $controlador = new \Com\Daw2\Controllers\UsuarioSistemaController();
                    $controlador->darDeBaja();
                }
                , 'post');
                
                
            Route::add('/mi_Perfil/delete',
                function () {
                    $controlador = new \Com\Daw2\Controllers\UsuarioSistemaController();
                    $controlador->borrarUsuario();
                }
                , 'get');
                
             Route::add('/mi_Perfil/delete',
                function () {
                    $controlador = new \Com\Daw2\Controllers\UsuarioSistemaController();
                    $controlador->borrarUsuario();
                }
            , 'post');
            
                        Route::add('/mi_Perfil/edit',
                function () {
                    $controlador = new \Com\Daw2\Controllers\UsuarioSistemaController();
                    $controlador->showEditProfile();
                }
                , 'get');
            
       }
           
       
       /*CHECKOUT*/
       
       if(isset($_SESSION['permisos']) && isset($_SESSION['permisos']['comprar'])){
                 Route::add('/checkout',
                     function(){
                     $controller = new \Com\Daw2\Controllers\PedidoController();
                     $controller->showCheckOut();
                     }
                     ,'get'); 
                     
                   Route::add('/test_cesta',
                     function(){
                     $controller = new \Com\Daw2\Controllers\PedidoController();
                     $controller->terminarCompra();
                     }
                     ,'post');   
                     
                     Route::add('/test_cesta',
                     function(){
                     $controller = new \Com\Daw2\Controllers\PedidoController();
                     $controller->terminarCompra();
                     }
                     ,'get');  
                     
                                        Route::add('/check_salario',
                     function(){
                     $controller = new \Com\Daw2\Controllers\PedidoController();
                     $controller->checkUserSalary();
                     }
                     ,'post');   
                     
//                     Route::add('/check_salario',
//                     function(){
//                     $controller = new \Com\Daw2\Controllers\PedidoController();
//                     $controller->checkUserSalary();
//                     }
//                     ,'get'); 
                     
                     
                     
                     Route::add('/checkout/success',
                     function(){
                     $controller = new \Com\Daw2\Controllers\PedidoController();
                     $controller->checkOutSuccess();
                     }
                     ,'post'); 
                                          
                     Route::add('/checkout/success',
                     function(){
                     $controller = new \Com\Daw2\Controllers\PedidoController();
                     $controller->checkOutSuccess();
                     }
                     ,'get'); 
                     
  
       }
         

                /******CATEGORÍAS******/

             
                    
        Route::methodNotAllowed(
            function(){
                $controller = new \Com\Daw2\Controllers\ErroresController();
                $controller->error405();
            }
        );
        
        
                Route::pathNotFound(
            function(){
                $controller = new \Com\Daw2\Controllers\ErroresController();
                $controller->error404();
            }
        );

        
        Route::run();
    
    }
}

