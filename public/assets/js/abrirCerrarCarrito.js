 /*
           * elementos mirar en /assets/html/elementosCesta.html
           * 
           * 
           * 
           */  
            
            
            
          var cuerpo = document.getElementById('cuerpo_carrito');
          var btn_borrar_producto = document.getElementById('btn_borrar_producto');
          var elementos = cuerpo.getElementsByClassName('borrar');   
         
          

          
        
          
            
            /*Coger la ventana modal*/
        var mod = document.getElementById("mi_modal_carrito");

        // Coger el botón que abre la modal
        var btn = document.getElementById("btn_carrito");

        // coger el <span> que cierra la modal
        var span = document.getElementsByClassName("close_carrito")[0];

        // Cuando el usuario le da al botón, abrir la modal
        btn.onclick = function() {
          mod.style.display = "block";
          if(elementos.length == 0){
               removeChilds();
                cuerpo.innerHTML = '<p class="text-danger text-center">No hay ningún elemento en la cesta!</p>';
                }
        }

        // Cerrar la modal cuando el usuario le da al <span>
        span.onclick = function() {
          mod.style.display = "none";
        }

        // Cerrar la modal también cuando el usuario le dé fuera de la modal
        window.onclick = function(event) {
          if (event.target == mod) {
            mod.style.display = "none";
          }
        } 
        
        
        
         window.onload = addEvents();
                function addEvents(){

                    for (var i = 0; i < elementos.length; i++) {
                           elementos[i].addEventListener('click',function(){
                    this.parentNode.remove();
                     if(elementos.length == 0){
                         removeChilds();
                         cuerpo.innerHTML = '<p class="text-danger text-center">No hay ningún elemento en la cesta!</p>';
                     }
                });
                 }

                }
                
                
   function removeChilds(){
   while (cuerpo.hasChildNodes()) {
    cuerpo.removeChild(cuerpo.firstChild);
    }
   }

