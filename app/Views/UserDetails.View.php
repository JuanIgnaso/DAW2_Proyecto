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
        </div>
        <!--  -->
<form method="<?php echo $metodo;?>"  action="/mi_Perfil" class="">
        <div class="row d-flex align-items-start justify-content-between">
          <!-- CUERPO DEL FORMULARIO -->
          <main class="col-12 col-md-8 ms-0 ms-md-2 mt-2 mb-5">
              <header class="col-12">
                <h2 class="display-5 m-0 p-2" id="nombre__usuario"><?php echo $info_usuario['nombre_usuario'];?></h2>
              </header>
              <div class="row">
                <!-- Foto de perfil del usuario -->
                <section class="col-12 col-md-5">
                    <div class="col-10 m-auto text-center">
                     <img src="/assets/img/profiles/default_profile_photo.jpg" class="img-fluid rounded" alt="...">
                     <p>Foto de Perfil</p>
                    </div>
                </section>
                <!-- Datos generales del usuario Nombre / Correo / Wallet -->
        
                <section class="col-12 col-md-7 border border-secondary border-opacity-50 ">
                    
                  <div class="col-12 d-flex flex-column pb-4">
                    <label for="" class="display-6">Nombre de Usuario</label>
                    <input type="text" id="country" name="nombre_usuario" value="<?php echo isset($input['nombre_usuario']) ? $info_usuario['nombre_usuario'] : $info_usuario['nombre_usuario'] ;?>" readonly style="border:none;" class="mt-1">
                  </div>
                  <div class="col-12 d-flex flex-column  pb-4">
                    <label for="" class="display-6">Dirección de Correo</label>
                    <input type="text" id="country" name="email" value="<?php echo isset($input['email']) ? $info_usuario['email'] : $info_usuario['email'] ;?>" readonly style="border:none;" class="mt-1">
                  </div>
                  <div class="col-12 d-flex flex-column  pb-4">
                    <label for="" class="display-6">Saldo Actual</label>
                    <input type="text" id="country" name="cartera" value="<?php echo isset($input['cartera']) ? $info_usuario['cartera'] : $info_usuario['cartera'] ;?>" readonly style="border:none;"  class="mt-1">
                  </div>
                  <div class="col-12 pb-4 d-none">
                    <label for="" class="display-6">Nueva Contraseña</label>
                      <!-- contraseña -->
                      <div class="col-12 d-flex flex-column flex-md-row mt-1">
                        <div class="col-12 col-md-6 p-1">
                          <label for="">Escriba la contraseña</label>
                          <input type="password" name="" id="" class="col-12">
                        </div>
                        <div class="col-12 col-md-6 p-1">
                          <label for="">Repita la contraseña</label>
                          <input type="password" name="" id="" class="col-12">
                        </div>
                      </div>

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
                          <label for="">Nombre Titular<?php echo $info_usuario['nombre_titular'] == NULL ? '(No especificado)' : '' ;?></label>
                          <input type="text" id="country" name="nombre_titular" value="<?php echo isset($input['nombre_titular']) ? $info_usuario['nombre_titular'] : $info_usuario['nombre_titular'] ;?>" readonly style="border:none;"  class="mt-1">
                        </div>
                        <div class="col d-flex flex-column">
                          <label for="">Provincia<?php echo $info_usuario['provincia'] == NULL ? '(No especificado)' : '' ;?></label>
                          <input type="text" id="country" name="provincia" value="<?php echo isset($input['provincia']) ? $info_usuario['provincia'] : $info_usuario['provincia'] ;?>" readonly style="border:none;"  class="mt-1">
                        </div>
                        <div class="col d-flex flex-column">
                          <label for="">Ciudad<?php echo $info_usuario['ciudad'] == NULL ? '(No especificado)' : '' ;?></label>
                          <input type="text" id="country" name="ciudad" value="<?php echo isset($input['ciudad']) ? $info_usuario['ciudad'] : $info_usuario['ciudad'] ;?>" readonly style="border:none;"  class="mt-1">
                        </div>
                        <div class="col d-flex flex-column">
                          <label for="">Código Postal<?php echo $info_usuario['cod_postal'] == NULL ? '(No especificado)' : '' ;?></label>
                          <input type="text" id="country" name="cod_postal" value="<?php echo isset($input['cod_postal']) ? $info_usuario['cod_postal'] : $info_usuario['cod_postal'] ;?>" readonly style="border:none;"  class="mt-1">
                        </div>
                        <div class="col d-flex flex-column">
                          <label for="">Calle<?php echo $info_usuario['calle'] == NULL ? '(No especificado)' : '' ;?></label>
                          <input type="text" id="country" name="calle" value="<?php echo isset($input['calle']) ? $info_usuario['calle'] : $info_usuario['calle'] ;?>" readonly style="border:none;"  class="mt-1">
                        </div>
                      </div>
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
                          <a id="accion_enlace" class="confirmar_accion p-2 btn m-auto"></a>
                         </footer>
                    </div>
                   
                </div>
                 <!--  -->
          </div>
          <aside class="col-12 col-sm-4 col-md-2 col-lg-1 shadow p-3 mb-5 border border-secondary border-opacity-50 p-0">
              <h3 class="text-center mb-3">Acciones</h3>
              <div class="w-100 d-flex flex-row flex-sm-column">
                  <div class="col col-sm-12 text-center accion ">
                        <button  id="borrar_perfil" type="button"><i class="fa-regular fa-trash-can p-2" style="color: #fff;"></i></button>
                        <p>Borrar</p>
                        <span class="ayuda">Elimina El Perfil</span>
                    </div>
                     <div class="col col-sm-12 text-center accion">
                        <button type="button"><i class="fa-sharp fa-solid fa-pen-to-square p-2"  style="color: #fff;"></i></button>
                        <p>Editar</p>
                         <span class="ayuda">Cambia Información de tu perfil</span>
                    </div>
                    <div class="col col-sm-12 text-center accion">
                        
                        <button type="button" id="dar_baja"><i class="fa-sharp fa-solid fa-right-from-bracket p-2"  style="color: #fff;"></i></button>
                        <p>Dar De Baja</p>
                         <span class="ayuda">Borra Manteniendo tus datos.</span>
                    </div>
              </div>
         
          </aside>
           
        </div>
        </form> 
        <script>
            
            /*Variables con contenido
             * Cabecera de la modal
             * */
            var adv = document.getElementById('advertencia');
            
            /*Mensaje alerta*/
            var msj_al = document.getElementById('mensaje_alerta');
            
            /*Accion enlace*/
            var url = document.getElementById('accion_enlace');
            
            
            /*Coger la ventana modal*/
        var modal = document.getElementById("mi_modal_baja");

        // Coger el botón que abre la modal
        var btn = document.getElementById("dar_baja");
        var btn_borrar = document.getElementById("borrar_perfil");

        // coger el <span> que cierra la modal
        var span = document.getElementsByClassName("close_baja")[0];

        // Cuando el usuario le da al botón, abrir la modal
        btn.onclick = function() {
          modal.style.display = "block";
          adv.innerHTML = 'Estás a punto de Darte de Baja<i class="fa-solid fa-triangle-exclamation fa-1x" style="color: #ff0000;"></i>';
          msj_al.innerHTML  = 'Si realizas esta acción borrarás tu cuenta pero tus datos no se perderán.';
          url.innerHTML = 'Dar De Baja';
          url.setAttribute('href',"/mi_Perfil/baja/<?php echo $info_usuario['nombre_usuario'];?>");
       }
       
       //Modal con advertencia para borrar
       
       btn_borrar.onclick = function() {
          modal.style.display = "block";
          adv.innerHTML = 'Vas a Borrar Tu Perfil<i class="fa-solid fa-triangle-exclamation fa-1x" style="color: #ff0000;"></i>';
          msj_al.innerHTML  = 'Si realizas esta acción borrarás tu cuenta perdiendo todos tus datos, estas seguro de que deseas realizar esta acción?.';
          url.innerHTML = 'Borrar Mi Cuenta';
          url.setAttribute('href',"/mi_Perfil/delete/<?php echo $info_usuario['nombre_usuario'];?>");
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