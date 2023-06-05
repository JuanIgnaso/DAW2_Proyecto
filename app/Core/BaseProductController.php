<?php
  namespace Com\Daw2\Core;
 
  
  abstract class BaseProductController extends \Com\Daw2\Core\BaseController{
      protected const IVA = 21;
      
      /***
       * Comprueba la imagen, de que cumpla conforme a los estandard
       * 1:1, que el tamaño de imagen y el formato
       */
      protected function checkFormImage($file): ?string{
          //Respuesta
          $resp = NULL;
               
          //COMPROBACION DE IMG
          if(!empty($file["tmp_name"])){
           $check = getimagesize($file["tmp_name"]);
           $formato = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
          } 
          
          if(isset($check)){
          if($check == false){
              $resp = 'debes de subir una imagen';  
              }else{
                  if ($file["size"] > 2000000) {  // TAMAÑO DE LA IMAGEN
                      $resp = 'Limite máximo de tamaño superado'.basename($file["name"]);
                  }
                  if($check[0] != $check[1]){  // DIMENSIONES
                      $resp = 'La imagen debe de mantener el formato 1:1';  
                  } 
                  if($formato != 'jpg' && $formato != "png" && $formato != "jpeg"){ //FORMATO
                      $resp = 'Solo se permiten imagenes en .jpg, .png y .jpeg';
                }  
              }

          }
          
         return $resp; 
      }
 }

