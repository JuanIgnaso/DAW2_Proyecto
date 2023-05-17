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
                    
                    Route::add('/productos/categoria/([A-Za-z0-9]+)/product_detail/([A-Za-z0-9\.\-\/\+\s ]+)',
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
                    
         //REGISTRARSE
                       Route::add('/register',
                    function(){
                    $controler = new \Com\Daw2\Controllers\UsuarioSistemaController();
                    $controler->register();
                    }
                    ,'get');         
  
        //Acción de registrar
                   Route::add('/register',
                    function(){
                    $controler = new \Com\Daw2\Controllers\UsuarioSistemaController();
                    $controler->registerUser();
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
       
       
       if(isset($_SESSION['permisos']) && isset($_SESSION['permisos']['inventario'])){
        
           
           /*****************VENTANAS INVENTARIO*****************/
           Route::add('/inventario',
                     function(){
                     $controller = new \Com\Daw2\Controllers\AdministracionController();
                     $controller->showAdministracion();
                     }
                     ,'get'); 
                     
                     
               Route::add('/inventario/Ratones',
                     function(){
                     $controller = new \Com\Daw2\Controllers\RatonController();
                     $controller->showListaRatones();
                     }
                     ,'get'); 
                     
                  Route::add('/inventario/Ratones/edit/([A-Za-z0-9]+)',
                     function($cod){
                     $controller = new \Com\Daw2\Controllers\RatonController();
                     $controller->showEdit($cod);
                     }
                     ,'get'); 
                     
                    Route::add('/inventario/Ratones/edit/([A-Za-z0-9]+)',
                     function($cod){
                     $controller = new \Com\Daw2\Controllers\RatonController();
                     $controller->edit($cod);
                     }
                     ,'post'); 
                     
                     
                     
                    Route::add('/inventario/Ratones/add',
                     function(){
                     $controller = new \Com\Daw2\Controllers\RatonController();
                     $controller->showAdd();
                     }
                     ,'get'); 
                        
                    Route::add('/inventario/Ratones/add',
                     function(){
                     $controller = new \Com\Daw2\Controllers\RatonController();
                     $controller->add();
                     }
                     ,'post'); 
                     
                     
                 Route::add('/inventario/Teclados',
                     function(){
                     $controller = new \Com\Daw2\Controllers\TecladoController();
                     $controller->showListaTeclados();
                     }
                     ,'get');  
                     
                                         
                    Route::add('/inventario/Teclados/add',
                     function(){
                     $controller = new \Com\Daw2\Controllers\TecladoController();
                     $controller->showAdd();
                     }
                     ,'get'); 
                         
                   
                                                              
                    Route::add('/inventario/Teclados/add',
                     function(){
                     $controller = new \Com\Daw2\Controllers\TecladoController();
                     $controller->add();
                     }
                     ,'post');
                     
                     
                   Route::add('/inventario/Teclados/edit/([A-Za-z0-9]+)',
                     function($cod){
                     $controller = new \Com\Daw2\Controllers\TecladoController();
                     $controller->showEdit($cod);
                     }
                     ,'get');   
                     
                     
                  Route::add('/inventario/Teclados/edit/([A-Za-z0-9]+)',
                     function($cod){
                     $controller = new \Com\Daw2\Controllers\TecladoController();
                     $controller->edit($cod);
                     }
                     ,'post');   
                     
                     
                Route::add('/inventario/Monitores',
                     function(){
                     $controller = new \Com\Daw2\Controllers\MonitorController();
                     $controller->showListaMonitores();
                     }
                     ,'get');      
                     
                                  
                Route::add('/inventario/Monitores/add',
                     function(){
                     $controller = new \Com\Daw2\Controllers\MonitorController();
                     $controller->showAdd();
                     }
                     ,'get');    
                     
                Route::add('/inventario/Monitores/add',
                     function(){
                     $controller = new \Com\Daw2\Controllers\MonitorController();
                     $controller->add();
                     }
                     ,'post'); 
                     
                     
             Route::add('/inventario/Monitores/edit/([A-Za-z0-9]+)',
             function($cod){
             $controller = new \Com\Daw2\Controllers\MonitorController();
             $controller->showEdit($cod);
             }
             ,'get');     
                     
                     
                                   
             Route::add('/inventario/Monitores/edit/([A-Za-z0-9]+)',
             function($cod){
             $controller = new \Com\Daw2\Controllers\MonitorController();
             $controller->edit($cod);
             }
             ,'post');          
                     
                     
                  Route::add('/inventario/Sillas',
                     function(){
                     $controller = new \Com\Daw2\Controllers\SillaController();
                     $controller->showListaSillas();
                     }
                     ,'get');    
                     
                   Route::add('/inventario/Sillas/add',
                     function(){
                     $controller = new \Com\Daw2\Controllers\SillaController();
                     $controller->showAdd();
                     }
                     ,'get'); 
                     
                   Route::add('/inventario/Sillas/add',
                     function(){
                     $controller = new \Com\Daw2\Controllers\SillaController();
                     $controller->add();
                     }
                   ,'post');
                   
                   
                   
                    Route::add('/inventario/Sillas/edit/([A-Za-z0-9]+)',
                     function($cod){
                     $controller = new \Com\Daw2\Controllers\SillaController();
                     $controller->showEdit($cod);
                     }
                     ,'get');   
                     
                     
                                        
                    Route::add('/inventario/Sillas/edit/([A-Za-z0-9]+)',
                     function($cod){
                     $controller = new \Com\Daw2\Controllers\SillaController();
                     $controller->edit($cod);
                     }
                     ,'post');   
                    
                                        
                  Route::add('/inventario/Ordenadores',
                     function(){
                     $controller = new \Com\Daw2\Controllers\PCMontadosController();
                     $controller->showListaPC();
                     }
                     ,'get');    
                     
                    
                                                        
                  Route::add('/inventario/Consolas',
                     function(){
                     $controller = new \Com\Daw2\Controllers\ConsolasController();
                     $controller->showListaConsolas();
                     }
                     ,'get');       
                     
               /*BORRAR PRODUCTO*/
                       Route::add('/borrar_producto',
                     function(){
                     $controller = new \Com\Daw2\Controllers\ProductoController();
                     $controller->deleteProduct();
                     }
                     ,'post');
                     
                     Route::add('/borrar_producto',
                     function(){
                     $controller = new \Com\Daw2\Controllers\ProductoController();
                     $controller->deleteProduct();
                     }
                     ,'get');   
                    
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
            
            /** HAY QUE METERLE GET Y POST **/
            
                        Route::add('/mi_Perfil/edit',
                function () {
                    $controlador = new \Com\Daw2\Controllers\UsuarioSistemaController();
                    $controlador->showEditProfile();
                }
                , 'get');
                
                 Route::add('/mi_Perfil/edit',
                function () {
                    $controlador = new \Com\Daw2\Controllers\UsuarioSistemaController();
                    $controlador->editProfile();
                }
                , 'post');
                
                
                
                //editar foto perfil***************************************
                     Route::add('/post_foto',
                     function(){
                     $controller = new \Com\Daw2\Controllers\UsuarioSistemaController();
                     $controller->editProfilePhoto();
                     }
                     ,'post');   
                     
                     Route::add('/post_foto',
                     function(){
                     $controller = new \Com\Daw2\Controllers\UsuarioSistemaController();
                     $controller->editProfilePhoto();
                     }
                     ,'get'); 
            
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
                     
                     
                     
                      Route::add('/check_dir',
                     function(){
                     $controller = new \Com\Daw2\Controllers\PedidoController();
                     $controller->checkShippingAddress();
                     }
                     ,'post'); 
                     
                     
                     
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

