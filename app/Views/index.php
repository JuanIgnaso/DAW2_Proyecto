<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- ENLACES CSS -->
    <link rel="stylesheet" href="/assets/css/bootstrap-css/bootstrap.min.css">
    <!-- Vía JsDelivr -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> -->
    <!-- Quiźas utilice plantillas??? -->
    <link rel="stylesheet" href="/assets/css/index.css">
    <link rel="stylesheet" href="/assets/css/comun.css">
    <link rel="stylesheet" href="/assets/css/fontawesome/css/all.css"/>
    <!-- FAVICON -->
    <link rel="icon" type="image/x-icon" href="assets/svg/gallaecia-pc-favicon.svg">
    <title>Página De Inicio</title>
</head>
<body>
    <!-- Vía JsDelivr -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> -->
    <div class="container-fluid">
        
        <div class="row h-100">
            
          <?php
          if(isset($_SESSION['register_success'])){
          ?>  
            <div class="col-10 col-sm-6 display-block m-auto bg-light" id="modal-register">
                <header class="col-12 d-flex justify-content-between align-items-center">
                    <h3>Su cuenta ha sido registrada!</h3>
                    <button id="closeX">X</button>
                </header>
                <div class="col-12 m-0 p-2 text-center">
                    <i class="fa-sharp fa-solid fa-thumbs-up fa-beat p-2" style="color: #ff4500; font-size: 3.5rem;"></i>
                    <p><?php echo $_SESSION['register_success'];?></p>
                </div>
            </div>      
            <?php
            unset($_SESSION['register_success']);
            }
            ?>
            
            <script src="/assets/js/closeRegisterSuccess.js"></script>
            <div id="cabecera" class="col-12 d-flex flex-column justify-content-center">
              <h1 id="titulo_inicio">Gallaecia PCs</h1>
              <p>Bienvenido a nuestra Web! en la cual disponemos de lo último en PC montados, lo mejor para tí!.</p>
            </div>
        </div>
        
        <div class="row">
            <header class="d-flex navegador mb-0 flex-wrap align-items-center justify-content-center justify-content-md-between py-3 shadow p-3 mb-5">
                <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
                  <img role="img" width="200px" aria-label="Bootstrap" src="/assets/svg/Gallaecia_PC_Logo.svg" alt="logo_empresa">
                  <!--  class="bi me-2" -->
                  <!-- <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg> -->
                </a>
          
                <ul class="nav col-12 col-sm-6 mb-2 justify-content-center gap-1 mb-md-0">
                      <li><a href="#" class="nav-link px-2 link-secondary rounded">Inicio</a></li>
                      <!-- DropDown **********-->
                      <li>
                        <div class="dropdown">
                          <button class="dropbtn nav-link px-2 link-secondary rounded">Productos</button>
                          <div class="dropdown-content">
                            <?php include 'templates/header_bar_dropdownmenu.php';?>
                          </div>
                        </div>
                      </li>
                      <!-- **********
                      <li><a href="#" class="nav-link px-2 link-dark rounded">About</a></li> ******** -->
                      <?php
                      if(isset($_SESSION['permisos']) && in_array('inventario',$_SESSION['permisos'])){
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
                    <button class='btn btn-default position-relative' id="btn_carrito"><i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i><span id="carrito_items" class="badge bg-danger position-absolute top-0 start-100 translate-middle"></span></button>
 
                         <!-- Foto perfil -->

                         <div id="foto_perfil_navbar" class="rounded-circle" style="background-image: url('<?= is_null($_SESSION['usuario']['profile_image']) ? '/assets/img/profiles/Default_Profile_Photo.jpg' : $_SESSION['usuario']['profile_image'];?>');">
                            
                        </div> 
                     
                     <p class="col-auto text-light m-0" id="nombre_usuario"><a style="color:#fff;" href="mi_Perfil"><?php echo $_SESSION['usuario']['nombre_usuario'];?></a></p>
                    <button type="button" class="btn btn-outline-light" id="logout"><a href="/logout">Log-Out</a></button>          
                    </div>
                     <?php
                    }else{
                    ?>
                    <button type="button" class="btn btn-outline-light"><a href="/login">Login</a></button>
                  <button type="button" class="activo btn btn-outline-light"><a href="/register">Sign Up</a></button>
                  <?php
                    }
                   
                  ?>
                </div>
            </header>
        </div>
        
        <!-- MODAL CARRITO -->
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
                    <button class='btn btn-default p-2 text-center  mt-2' id="btn_checkout"><a href="/">Terminar Compra</a></button>
                </div>
                 <!-- // -->
            </div>
        </div>
        
        <!-- MAIN DE LA PAGINA -->
        <div class="row mb-3">
            <section class="col-12 col-lg-10 d-flex flex-column flex-md-row mb-5">
                <div class="col-12 col-md-8">
                    <header class="cabecera_seccion">
                      <h2 class="display-3 text-center text-md-start" style="position: relative; top: 0;">Quienes Somos Nosotros?</h2>
                      <div class="cabecera_Decorativo"></div>
                    </header>                        
                    <p class="p-2">Gallacecia PC, somos una tienda especializada en venta de equipos con más de 20 años de experiencia en el mundo del hardware de PC. Localizada en Pontevedra, por vocación propia, Galicia nos dedicamos a ofrecer siempre de lo mejor y con trato con el cliente excelente.</p>     
                </div>
               <img src="/assets/img/imagen_tienda.jpg" alt="imagen_tienda" class="cuadrado rounded">
            </section>

            <section class="col-12 col-lg-10 d-flex offset-0 offset-lg-2 flex-column flex-md-row justify-content-end">
                  <img src="/assets/img/setup_gaming.jpg" alt="imagen_set_up" class="cuadrado rounded order-2 order-md-1">
                  <div class="col-12 col-md-8 order-1 order-md-2">
                        <header class="cabecera_seccion">
                          <h2 class="display-3 text-center text-md-end" style="position: relative; top: 0;">Cual es nuestra inspiración tras este negocio?</h2>
                          <div class="cabecera_Decorativo"></div>
                        </header>                        
                        <p class="p-2">Aquí, en Gallaecia PC nuestra vocación e inspiración, es la gran pasión por el inmenso mundo de la Informática y mundo de la electrónica, el poder compartir nuestro sueño contigo, apostar por lo que cada vez está en más y mayor crecimiento en las nuevas tecnologías, ya sea en productividad, entretenimiento o enseñanza y que tú y todo el mundo siempre quede satisfecho. </p>     
                  </div>
            </section>
        </div>
          
            <!-- ZONA DE PRODUCTOS -->
        <section class="row justify-content-center" id="productos">
              <header class="col-12">
                    <h2 class="display-2 text-center mb-2">Nuestros Productos</h2>
              </header>
              <div class="col-8 col-md-6 col-lg-3 mb-3 mb-lg-0 productos-box">
                    <img src="/assets/svg/gamepad-solid.svg" alt="icono_raton" width="140" height="140">
                    <h2 class="fw-normal text-center">Consolas</h2>
                    <p>Si Ordenadores no es lo tuyo, hecha un vistazo a nuestros packs consolas.</p>
                    <a href="/productos/categoria/6" role="button" class="rounded enlace_productos">Ver Productos</a>
              </div><!-- /.col-lg-4 -->

              <div class="col-8 col-md-6 col-lg-3 mb-3 mb-lg-0 productos-box">
                <img src="/assets/svg/tv-solid.svg" alt="icono_monitor" width="140" height="140">
                <h2 class="fw-normal">Periféricos</h2>
                <p>Podrás ver númerosos perifericos de entrada y salida con numerosas marcas.</p>
                    <div class="dropdown">
                        <div class="rounded enlace_productos" role="button">Ver Productos</div>
                        <div class="dropdown-content" style="left: 100% !important; bottom: 0% !important;">
                            <a href="/productos/categoria/2">Teclados</a>
                            <a href="/productos/categoria/7">Ratones</a>
                            <a href="/productos/categoria/9">Monitores</a>
                            <a href="/productos/categoria/3">Sillas</a>
                            <a href="/productos/categoria/5">Mandos</a>
                        </div>
                    </div>
              </div><!-- /.col-lg-4 -->

              <div class="col-8 col-md-6 col-lg-3 mb-3 mb-lg-0 productos-box">
                    <img src="/assets/svg/laptop-solid.svg" alt="icono_ordenador" width="140" height="140">    
                    <h2 class="fw-normal">PCs Montados</h2>
                    <p>Si lo que quieres es comprar ordenadores hechos listos para usar, pincha aquí.</p>
                    <a href="/productos/categoria/10" role="button" class="rounded enlace_productos">Ver Productos</a>   
              </div><!-- /.col-lg-4 -->

              <div class="col-8 col-md-6 col-lg-3 mb-3 mb-lg-0 productos-box">
                    <img src="/assets/svg/microsoft.svg" alt="icono_sistema_operativo" width="140" height="140">    
                    <h2 class="fw-normal">Sistemas Operativos</h2>
                    <p>No hay nada más importante para poder usar un PC, desde Windows hasta distribuciones Linux.</p>
                    <a href="/productos/categoria/11" role="button" class="rounded enlace_productos">Ver Productos</a>   
              </div>

        </section>


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
            

        <!-- FOOTER -->
