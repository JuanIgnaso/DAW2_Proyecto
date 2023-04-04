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
        
                    
            Route::add('/login',
                    function(){
                    $controler = new \Com\Daw2\Controllers\UsuarioSistemaController();
                    $controler->login();
                    }
                    ,'get');
  
            
             /*DESLOGUEAR USUARIO*/
                    
             Route::add('/logout',
                     function(){
                     $controller = new \Com\Daw2\Controllers\SessionController();
                     $controller->logout();
                     }
                     ,'get');        
                    
          /*

                   Route::add('/', 
                function(){
                    $controlador = new \Com\Daw2\Controllers\InicioController();
                    $controlador->index();
                }
                , 'get');     
           
            
           */
        
        
        
        /*

  Enlaces a manejo de usuarios*******************************************
         */
         /* Route::add('/login', 
                function(){
                    $controlador = new \Com\Daw2\Controllers\UsuarioSistemaController();
                    $controlador->login();
                }
           , 'get'); 
           
            Route::add('/login', 
                function(){
                    $controlador = new \Com\Daw2\Controllers\UsuarioSistemaController();
                    $controlador->loginUser();
                }
           , 'post'); */
           
         
           
           
          
/**********************************************************************/                
                
        
/***********************************************************************/

                
                /*
                ENCARGADOS PRODUCTOS
                */
                
                
                
                /*
                ENCARGADOS PROVEEDORES    
                 */



                

                /******CATEGORÍAS******/

                                
                

                
               

                


                
                    
        Route::methodNotAllowed(
            function(){
                $controller = new \Com\Daw2\Controllers\ErroresController();
                $controller->error405();
            }
        );
        
        Route::run();
    
    }
}

