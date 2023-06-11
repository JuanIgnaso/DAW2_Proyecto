            
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
//              alert('hola');
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

