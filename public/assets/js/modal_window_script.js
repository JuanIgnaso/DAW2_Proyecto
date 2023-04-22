    /*Coger la ventana modal*/
        var modal = document.getElementById("mi_modal");

        // Coger el botón que abre la modal
        var btn = document.getElementById("modal_btn");

        // coger el <span> que cierra la modal
        var span = document.getElementsByClassName("close")[0];

        // Cuando el usuario le da al botón, abrir la modal
        btn.onclick = function() {
          modal.style.display = "block";
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