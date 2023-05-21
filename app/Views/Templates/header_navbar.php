<body>
    <div class="container-fluid">    
        <div class="row" id="cabeza">
            <header class="position-fixed d-flex navegador mb-0 flex-wrap align-items-center justify-content-center justify-content-md-between py-3 shadow p-3" id="header">
                <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
                  <img role="img" width="200px" aria-label="Bootstrap" src="/assets/svg/Gallaecia_PC_Logo.svg" alt="logo_empresa">
                  <!--  class="bi me-2" -->
                  <!-- <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg> -->
                </a>
          
                <ul class="nav col-12 col-sm-6 mb-2 justify-content-center gap-1 mb-md-0">
                  <li><a href="/" class="nav-link px-2 link-secondary rounded">Inicio</a></li>
                  <!-- DropDown **********-->
                  <li>
                    <div class="dropdown">
                      <button class="dropbtn nav-link px-2 link-secondary rounded">Productos</button>
                      <div class="dropdown-content">
                            <?php include 'header_bar_dropdownmenu.php';?>
                      </div>
                    </div>
                  </li>
                  <!-- **********
                  <li><a href="#" class="nav-link px-2 link-dark rounded">About</a></li>******** -->
                  <?php
                  if(isset($_SESSION['permisos']) && isset($_SESSION['permisos']['inventario'])){
                  ?>
                  <li><a href="/inventario" class="nav-link px-2 link-dark rounded">Inventario</a></li>
                  <?php
                  }
                  ?>
                </ul>
                              
                <div class="col-md-3 text-end" id="log_user">
                    <?php
                    if(isset($_SESSION['usuario'])){
                    ?>
                    <div class="col-12 d-flex align-items-center justify-content-end gap-2">
                   
                        <!-- MODAL CARRITO  -->    

                        <button class='btn btn-default position-relative' id="btn_carrito"><i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i><span id="carrito_items" class="badge bg-danger position-absolute top-0 start-100 translate-middle"></span></button>
                        
                        <!-- Foto perfil -->

                         <div id="foto_perfil_navbar" class="rounded-circle" style="background-image: url('<?= is_null($_SESSION['usuario']['profile_image']) ? '/assets/img/profiles/Default_Profile_Photo.svg' : $_SESSION['usuario']['profile_image'];?>');">
                            
                        </div>  
                     <a class="col-auto text-light m-0" id="nombre_usuario" href="/mi_Perfil"><?php echo $_SESSION['usuario']['nombre_usuario'];?></a>
                    <button type="button" class="btn btn-outline-light" id="log_out"><a href="/logout">Log-Out</a></button>          
                    </div>
                     <?php
                    }else{
                    ?>
                    <button type="button" class="btn btn-outline-light" id="login"><a href="/login">Login</a></button>
                  <button type="button" class="activo btn btn-outline-light" id="sign_up"><a href="/register">Sign Up</a></button>
                  <?php
                    }
                  ?>
                </div>
              </header>
            <script src="/assets/js/adapt_navbar.js"></script>
        </div>
        
                        <div class="row">
                        <div class="col-11 col-sm-6 col-lg-3 m-auto class_modal_carrito p-0 border rounded" id="mi_modal_carrito">
                              <!-- COntenido del modal -->
                            <div class="col-12  contenido_modal_carrito">
                                <header class="d-flex p-2 justify-content-between" id="cabecera_carrito">
                                   <h2 class="text-light text-center">Mi Carrito</h2>
                                   <span class="close_carrito text-dark"><i class="fa-sharp fa-regular fa-rectangle-xmark  fa-lg"></i></span>     
                                </header>
                                <!-- cuerpo -->
                                <div class="col-12 p-2 m-0" id="cuerpo_carrito">
                                    <!-- caja del producto -->
 
                               </div>
                                <button class='btn btn-default p-2 text-center  mt-2' id="btn_checkout"><a href="/checkout">Terminar Compra</a></button>
                            </div>
                             <!-- // -->
                        </div>
                    </div>
        
        <script>
            
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
        </script>
        
        