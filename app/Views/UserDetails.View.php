<div class="row">
            <header class="col-12">
               
              <h1 class="display-3" id="cabecera_profile">Información Del Perfil</h1>
            </header>
          <nav class="col-12 border-bottom border-secondary border-opacity-50"  id="navegador_Sec">
            <ol class="d-flex gap-3 align-items-center p-0 mb-1">
              <li><a href="/">Inicio</a></li>
              <li>Mi Perfil</li>
            </ol>
          </nav>
            <?php
               if(isset($_SESSION['success'])){
               ?>
                <h3 id="mensaje_edit" class="col-12 text-light bg-success position-absolute bg-opacity-100 p-2 display-block"><?php echo $_SESSION['success'];?></h3>
                <?php
                unset($_SESSION['success']);
               }
                ?>
                
</div>
<!-- SCRIPT PARA OCULTAR EL MENSAJE -->
    <script src="/assets/js/ocularNotificacion.js">

    </script>


        <!-- VENTANA DE AVISO AL REALIZAR LA ACCION DE BORRADO/BAJA DE TU PROPIA CUENTA -->
        <div class="col-6 m-auto bg-opacity-10 bg-success rounded" id="alerta">
            <h4>Acción Realizada Con Exito.</h4>
            <p id="alerta_texto"></p>
            <hr>
            <p class="mb-0">Para cualquier duda sobre su cuenta contacte a support_GallaeciaPC@gmail.com</p>
          </div>
        <!--  -->
        <div class="row d-flex align-items-start justify-content-between">
          <!-- CUERPO DEL FORMULARIO -->
          <main class="col-12 col-md-8 ms-0 ms-md-2 mt-2 mb-5">
              <header class="col-12">
                <h2 class="display-5 m-0 p-2" id="nombre__usuario"><?php echo $info_usuario['nombre_usuario'];?></h2>
              </header>
              <div class="row">
                <!-- Foto de perfil del usuario -->
                <section class="col-12 col-lg-6">
 
                    <div class="col-10 m-auto text-center">
                        
                        <!-- CAJA DE LA FOTO -->
                         <div id="caja_foto">
                          <img src="<?= is_null($info_usuario['profile_image']) ? '/assets/img/profiles/Default_Profile_Photo.jpg' : $info_usuario['profile_image'];?>"   id="foto_img" alt="imagen de perfil">
                         </div>
                     <p>Foto de Perfil</p>
                     <p id="resp_sub_foto" style="display:none;"></p>
                     <?php
                     if($seccion != '/mi_Perfil'){                    
                     ?>
                     
                  <div class="col-12 d-flex flex-column pb-4">
                <form id="imageForm" class="d-flex">
      
                            <input type="file" name="image" accept="image/*" id="imageButton"/>
                    <br>
                    <input type="button" name="submit" value="Upload" id="uploadImage">
                </form>
                         
                  </div>
     
                     <?php
                     }
                     ?>
                     
                    </div>
                </section>
                <!-- Datos generales del usuario Nombre / Correo / Wallet -->

                <section class="col-12 col-lg-6 border border-secondary border-opacity-50 ">
               <form method="post"  action="<?php echo $seccion ;?>" class="">
   
                  <div class="col-12 d-flex flex-column pb-4">
                    <label for="" class="display-6">Nombre de Usuario</label>
                    <input type="text" id="country" name="nombre_usuario" value="<?php echo isset($input['nombre_usuario']) ? $input['nombre_usuario'] : $info_usuario['nombre_usuario'] ;?>" <?php echo $seccion == '/mi_Perfil/edit' ? '' : "readonly style='border:none'";?> class="mt-1">
                     <p class="text-danger m-0"  <?php echo $seccion == '/mi_Perfil' ? "style='display:none;'" : "style='display:block;'" ;?>><?php echo isset($errores['nombre_usuario']) ? $errores['nombre_usuario'] : '';?></p>          
                  </div>
                  <div class="col-12 d-flex flex-column  pb-4">
                    <label for="" class="display-6">Dirección de Correo</label>
                    <input type="text" id="country" name="email" value="<?php echo isset($input['email']) ? $input['email'] : $info_usuario['email'] ;?>" <?php echo $seccion == '/mi_Perfil/edit' ? '' : "readonly style='border:none'";?> class="mt-1">
                      <p class="text-danger m-0"  <?php echo $seccion == '/mi_Perfil' ? "style='display:none;'" : "style='display:block;'" ;?>><?php echo isset($errores['email']) ? $errores['email'] : '';?></p>          
                  </div>
                    <?php
                    if($seccion == '/mi_Perfil'){
                    ?>
                  <div class="col-12 d-flex flex-column  pb-4">
                    <label for="" class="display-6">Saldo Actual</label>
                    <input type="text" id="country" name="cartera" value="<?php echo isset($input['cartera']) ? $input['cartera'] : $info_usuario['cartera'] ;?>" readonly style='border:none'  class="mt-1">
                  </div>
                    <?php
                    }else{
                    ?>
                  <div class="col-12 d-flex flex-column  pb-4">
                    <label for="" class="display-6">Actualizar Saldo?</label>
                    <p class="text-secondary m-0"  <?php echo $seccion == '/mi_Perfil' ? "style='display:none;'" : "style='display:block;'" ;?>><i class="fa-sharp fa-solid fa-circle-info m-1"></i>En Caso de no desear hacer ningún cambio, puedes dejar este campo en blanco.</p>
                    <input type="text" id="country" name="cartera" value="<?php echo isset($input['cartera']) ? $input['cartera'] : '' ;?>"  class="mt-1">
                    <p class="text-danger m-0"  <?php echo $seccion == '/mi_Perfil' ? "style='display:none;'" : "style='display:block;'" ;?>><?php echo isset($errores['cartera']) ? $errores['cartera'] : '';?></p>          
                  </div>
                    <?php
                    }
                    ?>

                  <div class="col-12 pb-4" <?php echo $seccion == '/mi_Perfil' ? "style='display:none;'" : "style='display:block;'" ;?>">
                    <label for="" class="display-6">Nueva Contraseña</label>
                    <p class="text-secondary m-0"  <?php echo $seccion == '/mi_Perfil' ? "style='display:none;'" : "style='display:block;'" ;?>><i class="fa-sharp fa-solid fa-circle-info m-1"></i>En Caso de no desear hacer ningún cambio, puedes dejar este campo en blanco.</p>

                      <!-- contraseña -->
                      <div class="col-12 d-flex flex-column flex-md-row mt-1">
                        <div class="col-12 col-md-6 p-1">
                          <label for="">Escriba la contraseña</label>
                          <input type="password" name="password" id="" class="col-12" value="<?php echo isset($input['password']) ? $input['password'] : '';?>">
                        </div>
                        <div class="col-12 col-md-6 p-1">
                          <label for="">Repita la contraseña</label>
                          <input type="password" name="password2" id="" class="col-12"  value="<?php echo isset($input['password2']) ? $input['password2'] : '';?>">
                        </div>
                      </div>
                        <p class="text-danger m-0"  <?php echo $seccion == '/mi_Perfil' ? "style='display:none;'" : "style='display:block;'" ;?>><?php echo isset($errores['password']) ? $errores['password'] : '';?></p>          

                  </div>
                </section>
              </div>

              <!-- Datos envío -->
              <div class="row">
                <section class="col-12 border border-secondary border-opacity-50 mt-3">
                  <header>
                      <h2>Datos De Envío</h2>
                  </header>
                      <div class="row row-cols-1 row-cols-sm-2">
                        <div class="col d-flex flex-column">
                            
                            <label for="">Nombre Titular<span><?php echo isset($info_usuario['direccion']['nombre_titular']) && $seccion == '/mi_Perfil' ? $info_usuario['direccion']['nombre_titular'] : '(No Especificado)' ;?></span></label>
                          <input type="text" id="country" name="nombre_titular" value="<?php echo isset($input['direccion']['nombre_titular']) ? $input['direccion']['nombre_titular'] : '' ;?>" <?php echo $seccion == '/mi_Perfil/edit' ? '' : "readonly style='border:none'";?>  class="mt-1">
                         <p class="text-danger m-0"  <?php echo $seccion == '/mi_Perfil' ? "style='display:none;'" : "style='display:block;'" ;?>><?php echo isset($errores['nombre_titular']) ? $errores['nombre_titular'] : '';?></p>          

                        </div>
                        <div class="col d-flex flex-column">
                            <label for="">Provincia<span><?php echo isset($info_usuario['direccion']['provincia']) && $seccion == '/mi_Perfil' ? $info_usuario['direccion']['provincia'] : '(No Especificado)' ;?></span></label>
                          <input type="text" id="country" name="provincia" value="<?php echo isset($input['direccion']['provincia']) ? $input['direccion']['provincia'] : '' ;?>" <?php echo $seccion == '/mi_Perfil/edit' ? '' : "readonly style='border:none'";?>  class="mt-1">
                          <p class="text-danger m-0"  <?php echo $seccion == '/mi_Perfil' ? "style='display:none;'" : "style='display:block;'" ;?>><?php echo isset($errores['provincia']) ? $errores['provincia'] : '';?></p>          
                        </div>
                        <div class="col d-flex flex-column">
                            <label for="">Ciudad<span><?php echo isset($info_usuario['direccion']['ciudad']) && $seccion == '/mi_Perfil' ? $info_usuario['direccion']['ciudad'] : '(No Especificado)' ;?></span></label>
                          <input type="text" id="country" name="ciudad" value="<?php echo isset($input['direccion']['ciudad']) ? $input['direccion']['ciudad'] : '' ;?>" <?php echo $seccion == '/mi_Perfil/edit' ? '' : "readonly style='border:none'";?>  class="mt-1">
                           <p class="text-danger m-0"  <?php echo $seccion == '/mi_Perfil' ? "style='display:none;'" : "style='display:block;'" ;?>><?php echo isset($errores['ciudad']) ? $errores['ciudad'] : '';?></p>          
                        </div>
                        <div class="col d-flex flex-column">
                            <label for="">Código Postal<span><?php echo isset($info_usuario['direccion']['cod_postal']) && $seccion == '/mi_Perfil' ? $info_usuario['direccion']['cod_postal'] : '(No Especificado)' ;?></span></label>
                          <input type="text" id="country" name="cod_postal" value="<?php echo isset($input['direccion']['cod_postal']) ? $input['direccion']['cod_postal'] : '' ;?>" <?php echo $seccion == '/mi_Perfil/edit' ? '' : "readonly style='border:none'";?>  class="mt-1">
                          <p class="text-danger m-0"  <?php echo $seccion == '/mi_Perfil' ? "style='display:none;'" : "style='display:block;'" ;?>><?php echo isset($errores['cod_postal']) ? $errores['cod_postal'] : '';?></p>          
                        </div>
                        <div class="col d-flex flex-column">
                            <label for="">Calle<span><?php echo isset($info_usuario['direccion']['calle']) && $seccion == '/mi_Perfil' ? $info_usuario['direccion']['calle'] : '(No Especificado)' ;?></span></label>
                          <input type="text" id="country" name="calle" value="<?php echo isset($input['direccion']['calle']) ? $input['direccion']['calle'] : '' ;?>" <?php echo $seccion == '/mi_Perfil/edit' ? '' : "readonly style='border:none'";?>  class="mt-1">
                          <p class="text-danger m-0"  <?php echo $seccion == '/mi_Perfil' ? "style='display:none;'" : "style='display:block;'" ;?>><?php echo isset($errores['calle']) ? $errores['calle'] : '';?></p>          
                        </div>
                   <p class="text-danger m-0"  <?php echo $seccion == '/mi_Perfil' ? "style='display:none;'" : "style='display:block;'" ;?>><?php echo isset($errores['direccion']) ? $errores['direccion'] : '';?></p>          

                </section>
              </div>
          </main>
          <div class="col-4 class_modal_baja" id="mi_modal_baja">
                <!-- COntenido del modal -->
                <div class="col-12  contenido_modal_baja">
                    <header class="d-flex border-bottom border-secondary p-2 justify-content-between">
                       <h2 class="text-light text-left text-danger" id="advertencia"></h2>
                       <span class="close_baja text-dark">X</span>     
                    </header> 
                    <div class="col-12 p-1 d-flex flex-column">
                        
                         <p class="text-danger text-center" id="mensaje_alerta"></p>
                         <footer class="col-12 text-center">
                          <button id="accion_boton" type="button" class="confirmar_accion p-2 btn m-auto"></button>
                         </footer>
                    </div>
                   
                </div>
                 <!--  -->
          </div>
          <aside class="col-12 col-sm-4 col-md-2 col-lg-1 shadow p-3 mb-5 border border-secondary border-opacity-50 p-0">
              <h3 class="text-center mb-3">Acciones</h3>
              <div class="w-100 d-flex flex-row flex-sm-column">
                  <?php
                  if($seccion == '/mi_Perfil'){
                  ?>
                     <div class="col col-sm-12 text-center accion">
                       <a href="/mi_Perfil/edit"><button type="button"><i class="fa-sharp fa-solid fa-pen-to-square p-2"  style="color: #fff;"></i></button></a>  
                        <p>Editar</p>
                         <span class="ayuda">Cambia Información de tu perfil</span>
                    </div>
                    <div class="col col-sm-12 text-center accion">
                        
                        <button type="button" id="dar_baja"><i class="fa-sharp fa-solid fa-right-from-bracket p-2"  style="color: #fff;"></i></button>
                        <p>Dar De Baja</p>
                         <span class="ayuda">Borra Manteniendo tus datos.</span>
                    </div>
                  <?php
                  }else{
                  ?>
                  
                  <div class="col col-sm-12 text-center accion ">
                        <button  id="editar_perfil" type="submit"><i class="fa-sharp fa-solid fa-thumbs-up p-2" style="color: #fff;"></i></button>
                        <p>Aplicar Cambios</p>
                        <span class="ayuda">Confirmar cambios realizados</span>
                    </div>
                     <div class="col col-sm-12 text-center accion">
                       <a href="/mi_Perfil"><button type="button"><i class="fa-sharp fa-solid fa-xmark p-2"  style="color: #fff;"></i></button></a>  
                        <p>Volver</p>
                         <span class="ayuda">Volver a ver mi Perfil</span>
                    </div>
                  <?php
                  }
                  ?>
              </div>
         </form>
          </aside>
           
        </div>
         
        <script>
            
            /*Variables con contenido
             * Cabecera de la modal
             * */
            var adv = document.getElementById('advertencia');
            
            /*Mensaje alerta*/
            var msj_al = document.getElementById('mensaje_alerta');
            
            /*Accion enlace*/
            var url = document.getElementById('accion_boton');
            
            
                /*Coger la ventana modal*/
            var modal = document.getElementById("mi_modal_baja");

            // Coger el botón que abre la modal
            var btn = document.getElementById("dar_baja");
            var btn_borrar = document.getElementById("borrar_perfil");

            // coger el <span> que cierra la modal
            var span = document.getElementsByClassName("close_baja")[0];

            //Nombre del usuario
            var user_name = document.getElementById('nombre__usuario');


            //Ventana confirmación:
            var conf = document.getElementById('alerta');
            var alert_Text = document.getElementById('alerta_texto');

        // Cuando el usuario le da al botón, abrir la modal
        btn.onclick = function() {
          modal.style.display = "block";
          adv.innerHTML = 'Estás a punto de Darte de Baja<i class="fa-solid fa-triangle-exclamation fa-1x" style="color: #ff0000;"></i>';
          msj_al.innerHTML  = 'Si realizas esta acción borrarás tu cuenta pero tus datos no se perderán.';
          url.innerHTML = 'Dar De Baja';
         url.addEventListener('click',function(){
                       $.ajax({
               url: '/mi_Perfil/baja',
               
               type: 'POST',
               
               data: {
                   dato: user_name.innerHTML
               },
               success: function(response) {
//                 let msg = 'Esto es un hasta luego?, lamentamos que no desee estar en activo en nuestra página, pero quizás...';
              alert('hola');
                 window.location.href = 'http://gallaeciapc.localhost:8080/';             
               },
               error: function(error){
                  error = error.responseText;
                  console.log(error);
                   window.alert(error);
               },
           });  
         });
         
         // url.setAttribute('href',"/mi_Perfil/baja/<?php echo $info_usuario['nombre_usuario'];?>");
       }
       
       
       //AJAX CON LOS BOTONES
       
       function volverInicio(){
           window.location.href = 'http://gallaeciapc.localhost:8080/';
       }
       //Para Dar De Baja
       function darBaja(){
           
           $.ajax({
               url: '/mi_Perfil/baja',
               
               type: 'POST',
               
               data: {
                   dato: user_name.innerHTML
               },
               success: function(response) {
//                 let msg = 'Esto es un hasta luego?, lamentamos que no desee estar en activo en nuestra página, pero quizás...';
              alert('hola');
                 window.location.href = 'http://gallaeciapc.localhost:8080/';             
               },
               error: function(error){
                  error = error.responseText;
                  console.log(error);
                   window.alert(error);
               },
           });                
            
       }
       
       
       

       
       
     
                 /*Mostrar y ocultar advertencia*/
           mostrarLimite = (msg) => {conf.style.display = 'block';
                                     conf.style.position = 'absolute';
                                    alert_Text.innerHTML = msg;
           };
           ocultarLimite = () => {max_limit.style.display = 'none';
           conf.style.position = 'relative';
            }; 
           
           
           function showAlerMessage(msg){
               mostrarLimite(msg);
               setTimeout(ocultarLimite, 7000);
           }
       

        // Cerrar la modal cuando el usuario le da al <span>
        span.onclick = function() {
          modal.style.display = "none";
        }

        // Cerrar la modal también cuando el usuario le dé fuera de la modal
        window.onclick = function(event) {
          if (event.target == modal) {
            modal.style.display = "none";
          }
        } 
        </script>
        <script>


        $('#uploadImage').click(function(){
            //Mensaje a mostrar
            let k = document.getElementById('resp_sub_foto');
            
          // Making the image file object
           var file = $('#imageButton').prop("files")[0];

            // Making the form object
           var form = new FormData();

            // Adding the image to the form
            form.append("image", file);

            console.log(form.get('image'));
           // The AJAX call
            $.ajax({
                url: "/post_foto",
               type: "POST",
               data:  form,
                contentType: false,
               processData:false,
             success: function(result){
                                 // window.location.href = 'http://gallaeciapc.localhost:8080/mi_Perfil';
                  
                  k.style.display = 'block';
                  k.setAttribute('class','text-success');
                  k.innerHTML = result;
                  console.log(result);

                },
                error: function(error){
                  
                  
                  k.style.display = 'block';
                  let resp = error.responseText;
                  k.removeAttribute('class');
                  k.setAttribute('class','text-danger');
                  k.innerHTML  = resp;
                 // console.log(error);
                   
               } 
            });
        });

    
        
        </script>