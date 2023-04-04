<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- ENLACES CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap-css/bootstrap.min.css">
    <!-- Vía JsDelivr -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> -->
    <!-- Quiźas utilice plantillas??? -->
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/comun.css">
    <!-- FAVICON -->
    <link rel="icon" type="image/x-icon" href="assets/svg/gallaecia-pc-favicon.svg">
    <title>Página De Inicio</title>
</head>
<body>
    <!-- Vía JsDelivr -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> -->
    <div class="container-fluid">
        <div class="row h-100">
            <div id="cabecera" class="col-12 d-flex flex-column justify-content-center">
              <h1 id="titulo_inicio">Gallaecia PCs</h1>
              <p>Bienvenido a nuestra Web! en la cual disponemos de lo último en PC montados, lo mejor para tí!.</p>
            </div>
        </div>
        <div class="row">
            <header class="d-flex navegador mb-0 flex-wrap align-items-center justify-content-center justify-content-md-between py-3 shadow p-3 mb-5">
                <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
                  <img role="img" width="200px" aria-label="Bootstrap" src="assets/svg/Gallaecia_PC_Logo.svg" alt="logo_empresa">
                  <!--  class="bi me-2" -->
                  <!-- <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg> -->
                </a>
          
                <ul class="nav col-12 col-sm-6 mb-2 justify-content-center gap-1 mb-md-0">
                  <li><a href="#" class="nav-link px-2 link-secondary rounded">Inicio</a></li>
                  <!-- DropDown -->
                  <li>
                    <div class="dropdown">
                      <button class="dropbtn nav-link px-2 link-secondary rounded">Productos</button>
                      <div class="dropdown-content">
                        <a href="#">Perifericos Entrada</a>
                        <a href="#">Perifericos Salida</a>
                        <a href="#">Software</a>
                        <a href="#">PC Montados</a>
                      </div>
                    </div>
                  </li>
                  <li><a href="#" class="nav-link px-2 link-dark rounded">About</a></li>
                </ul>
          
                <div class="col-md-3 text-end" id="log_user">
                    <button type="button" class="btn btn-outline-light"><a href="/login">Login</a></button>
                  <button type="button" class="activo btn btn-outline-light">Sign-up</button>
                </div>
              </header>
        </div>
        <!-- MAIN DE LA PAGINA -->
        <div class="row mb-3">
            <section class="col-12 col-lg-10 d-flex flex-column flex-md-row mb-5">
              <div class="col-12 col-md-8">
                <header class="cabecera_seccion">
                  <h2 class="display-3 text-center text-md-start" style="position: relative; top: 0;">Quienes Somos Nosotros?</h2>
                  <div class="cabecera_Decorativo"></div>
                </header>                        
                <p class="p-2">Gallacecia PC, somos una tienda especializada en venta de equipos con más de 20 años de experiencia en el mundo del hardware de PC, haciendo uso de lo mejor. Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero inventore velit doloremque quo numquam sapiente ipsam tempore veritatis nihil qui, perferendis, in voluptas. Aut, provident. Reiciendis saepe aut itaque necessitatibus!</p>     
           </div>
           <img src="assets/img/imagen_tienda.jpg" alt="" class="cuadrado rounded">
          </section>

          <section class="col-12 col-lg-10 d-flex offset-0 offset-lg-2 flex-column flex-md-row justify-content-end">
              <img src="assets/img/setup_gaming.jpg" alt="imagen_set_up" class="cuadrado rounded order-2 order-md-1">
              <div class="col-12 col-md-8 order-1 order-md-2">
                <header class="cabecera_seccion">
                  <h2 class="display-3 text-center text-md-end" style="position: relative; top: 0;">Cual es nuestra inspiración tras este negocio?</h2>
                  <div class="cabecera_Decorativo"></div>
                </header>                        
                <p class="p-2">Gallacecia PC, somos una tienda especializada en venta de equipos con más de 20 años de experiencia en el mundo del hardware de PC, haciendo uso de lo mejor. Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero inventore velit doloremque quo numquam sapiente ipsam tempore veritatis nihil qui, perferendis, in voluptas. Aut, provident. Reiciendis saepe aut itaque necessitatibus!</p>     
              </div>
          </section>
        </div>
          
            <!-- ZONA DE PRODUCTOS -->
            <section class="row justify-content-center" id="productos">
              <header class="col-12">
                <h2 class="display-2 text-center mb-2">Nuestros Productos</h2>
              </header>
              <div class="col-8 col-md-6 col-lg-3 mb-3 mb-lg-0 productos-box">
                <img src="assets/svg/mouse-solid.svg" alt="icono_raton" width="140" height="140">
                <h2 class="fw-normal text-center">Periféricos Entrada</h2>
                <p>Teclados, Ratones... tablets hecha un vistazo a nuestros periféricos de entrada.</p>
                <a href="" role="button" class="rounded enlace_productos">Ver Productos</a>
              </div><!-- /.col-lg-4 -->

              <div class="col-8 col-md-6 col-lg-3 mb-3 mb-lg-0 productos-box">
                <img src="assets/svg/tv-solid.svg" alt="icono_monitor" width="140" height="140">
                <h2 class="fw-normal">Periféricos Salida</h2>
                <p>Podrás ver altavoces y monitores con una gran variedad y marcas.</p>
                <a href="" role="button" class="rounded enlace_productos">Ver Productos</a>
              </div><!-- /.col-lg-4 -->

              <div class="col-8 col-md-6 col-lg-3 mb-3 mb-lg-0 productos-box">
                <img src="assets/svg/laptop-solid.svg" alt="icono_ordenador" width="140" height="140">    
                <h2 class="fw-normal">PCs Montados</h2>
                <p>Si lo que quieres es comprar ordenadores hechos listos para usar, pincha aquí.</p>
                <a href="" role="button" class="rounded enlace_productos">Ver Productos</a>   
              </div><!-- /.col-lg-4 -->

              <div class="col-8 col-md-6 col-lg-3 mb-3 mb-lg-0 productos-box">
                <img src="assets/svg/microsoft.svg" alt="icono_sistema_operativo" width="140" height="140">    
                <h2 class="fw-normal">Sistemas Operativos</h2>
                <p>No hay nada más importante para poder usar un PC, desde Windows hasta distribuciones Linux.</p>
                <a href="" role="button" class="rounded enlace_productos">Ver Productos</a>   
              </div>

            </section>


        
        <!-- FOOTER -->
        <div class="row">
          <footer class="d-flex pie flex-wrap flex-column flex-lg-row justify-content-center align-items-center py-3 my-4" style="margin: 0 !important;">
              <div class="col-md-4 d-flex align-items-center">
                <span class="mb-3 mb-md-0 text-muted">&copy; Gallaecia PC 2023, Inc</span>
              </div>

              <ul class="nav justify-content-center">
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Inicio</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Productos</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Politicas De Privacidad</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">FAQs</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Sobre Nosotros</a></li>
              </ul>


              <ul class="nav col-md-4 justify-content-center list-unstyled d-flex">
                <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#twitter">
                  <symbol id="twitter" viewBox="0 0 16 16">
                    <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                  </symbol>
                </use></svg></a></li>
                <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#instagram">
                  <symbol id="instagram" viewBox="0 0 16 16">
                    <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
                </symbol>
                </use></svg></a></li>
                <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#facebook">
                  <symbol id="facebook" viewBox="0 0 16 16" class="ojo">
                    <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                  </symbol>
                </use></svg></a></li>
              </ul>
          </footer>
        </div>

    </div>
    <script>
      /*SCRIPT para mantener la barra de navegación arriba cuando el usuario hace scroll*/
      stickyElem = document.querySelector(".navegador");
       
      /* Coge la cantidad de alto
      del elemento del
      viewport y le añade la
      pageYOffset para conseguir el alto
      relativo a la página */
      currStickyPos = stickyElem.getBoundingClientRect().top + window.pageYOffset;
      window.onscroll = function() {
           
          /* Comprueba si el Y offset actual
          es mayor que la posición del elemento */
          if(window.pageYOffset > currStickyPos) {
              stickyElem.style.position = "fixed";
              stickyElem.style.top = "0px";
          } else {
              stickyElem.style.position = "relative";
              stickyElem.style.top = "initial";
          }
      }
      </script>
</body>
</html>