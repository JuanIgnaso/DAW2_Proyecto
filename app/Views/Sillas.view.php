
  <body>
    
<header class="navbar navbar-dark sticky-top flex-md-nowrap justify-content-end p-0 shadow" style="background-color:#272727";>
  <!--<a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">Company name</a>-->
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  
  <div class="col-md-3 text-end" id="log_user">
                    <?php
                    if(isset($_SESSION['usuario'])){
                    ?>
                    <div class="col-12 p-3 d-flex align-items-center justify-content-end gap-2">
                   
                        <!-- MODAL CARRITO  -->    

                        <button class='btn btn-default position-relative' id="btn_carrito"><i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i><span id="carrito_items" class="badge bg-danger position-absolute top-0 start-100 translate-middle"></span></button>
                     <a class="col-auto text-light m-0" id="nombre_usuario" href="/mi_Perfil"><?php echo $_SESSION['usuario']['nombre_usuario'];?></a>
                   
                    <div class="navbar-nav">
                    <div class="nav-item text-nowrap flex-column d-flex align-items-center justify-content-between">
                      <!--<a class="nav-link px-3" href="#">Log In</a>-->
                      <a class="nav-link px-3" href="#">Sign out</a>
                    </div>
                  </div>
                    
                    </div>
                
                     <?php
                    }else{
                    ?>
      
                   <div class="navbar-nav">
                    <div class="nav-item text-nowrap flex-column d-flex align-items-center justify-content-between">
                      <a class="nav-link px-3" href="#">Log In</a>
                      <a class="nav-link px-3" href="#">Sign out</a>
                    </div>
                  </div>
                    <!--<button type="button" class="btn btn-outline-light" id="login"><a href="/login">Login</a></button>-->
                  <!--<button type="button" class="activo btn btn-outline-light" id="sign_up"><a href="/register">Sign Up</a></button>-->
                  <?php
                    }
                  ?>
                </div>
  
  
         </div>
      
  
  <!--<input class="form-control form-control-dark w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search">-->

</header>
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
  
      
         <!-- Abrir Cerrar Carrito -->
       <script src="/assets/js/abrirCerrarCarrito.js"></script> 
      

<div class="container-fluid">
  <div class="row">

      <?php
      include $_ENV['folder.views'].'/templates/AsideInventario.php';
      ?>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Panel Administración: <?php echo isset($tipo) ? $tipo : 'Categoría';?></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
<!--          <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar" class="align-text-bottom"></span>
            This week
          </button>-->
        </div>
      </div>

      <!--<canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>-->
        
      <h2>Filtros de búsqueda de la categoría.</h2>
       <form method="get"  action="<?php echo $seccion;?>">
      <div class="table-responsive text-center" style="min-height: 1000px; max-height: auto;">

          <div class="row row-cols-1 m-0 row-cols-sm-2 row-cols-lg-3">
              <div class="col d-flex flex-column">
                 <label for="">Nombre</label>
                <input type="text" id="country" name="nombre" value="<?php echo isset($input['nombre']) ? $input['nombre'] : '' ;?>" class="mt-1">
            </div>
              
              
             <div class="col d-flex flex-column">
                 <label for="">min Precio</label>
                <input type="text" id="min_precio" name="min_precio" value="<?php echo isset($input['min_precio']) ? $input['min_precio'] : '' ;?>" class="mt-1">
            </div>
              
            <div class="col d-flex flex-column">
                 <label for="">max Precio</label>
                <input type="text" id="max_precio" name="max_precio" value="<?php echo isset($input['max_precio']) ? $input['max_precio'] : '' ;?>" class="mt-1">
            </div>  
                
              
           <div class="col d-flex flex-column">
                 <label for="">Altura</label>
                    <select name="alturas[]" id="alturas" multiple>
                           <option value="">-</option>
                           
                           <?php
                           foreach ($alturas as $altura) {
                           ?>
                           <option value="<?php echo $altura['altura'];?>" <?php echo (isset($_GET['alturas']) && in_array($altura['altura'], $_GET['alturas'])) ? 'selected' : ''; ?>><?php echo $altura['altura'];?></option>
                           
                           <?php
                           }
                           ?>
                              
                     </select>
            </div>
              
              
            <div class="col d-flex flex-column">
                 <label for="">Anchura</label>
                    <select name="anchuras[]" id="anchuras" multiple>
                           <option value="">-</option>
                           
                           <?php
                           foreach ($anchuras as $anchura) {
                           ?>
                           <option value="<?php echo $anchura['anchura'];?>" <?php echo (isset($_GET['anchuras']) && in_array($anchura['anchura'], $_GET['anchuras'])) ? 'selected' : ''; ?>><?php echo $anchura['anchura'];?></option>
                           
                           <?php
                           }
                           ?>
                              
                     </select>
            </div>  
              

            <div class="col d-flex flex-column">
                 <label for="">Tipo</label>
                <input type="text" id="tipo_silla" name="tipo_silla" value="<?php echo isset($input['tipo_silla']) ? $input['tipo_silla'] : '' ;?>" class="mt-1">
            </div>    
                          
              
          </div>
          
          <div class="col-12 d-flex align-items-center justify-content-center  border-bottom border-secondary justify-content-md-end p-3 gap-3">
              <a href="/inventario/Sillas" value="" name="reiniciar" class="btn boton-cancelar">Reiniciar filtros</a>
              <input type="submit" value="Aplicar filtros" name="enviar" class="btn boton-aplicar ml-2"/>
          </div>
       </form>
          <div class="col-12">
                       <p>Busca si lo prefieres entre uno de los siguientes filtros</p>
  
          </div>















      <?php
      if(count($productos) != 0){
      ?>


        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col"><a href="<?php echo $seccion;?>?order=1<?php echo $queryString; ?>">Cod.</a></th>
              <th scope="col"><a href="<?php echo $seccion;?>?order=2<?php echo $queryString; ?>">Nombre</a></th>
              <th scope="col"><a href="<?php echo $seccion;?>?order=3<?php echo $queryString; ?>">Proveedor</a></th>
              <th scope="col"><a href="<?php echo $seccion;?>?order=4<?php echo $queryString; ?>">Precio</a></th>   
              <th scope="col"><a href="<?php echo $seccion;?>?order=5<?php echo $queryString; ?>">Altura</a></th>
              <th scope="col"><a href="<?php echo $seccion;?>?order=6<?php echo $queryString; ?>">Anchura</a></th>
              <th scope="col"><a href="<?php echo $seccion;?>?order=7<?php echo $queryString; ?>">Tipo</a></th>
              <th scope="col"><a href="<?php echo $seccion;?>?order=8<?php echo $queryString; ?>">Ajustable</a></th>          
            </tr>
          </thead>
          <tbody>
           <?php
            foreach ($productos as $producto) {
                     
           ?>   
            <tr>
              <td><?php echo $producto['codigo_producto'];?></td>
              <td><?php echo $producto['nombre'];?></td>
              <td><?php echo $producto['nombre_proveedor'];?></td>
              <td><?php echo $producto['precio'];?></td>
              <td><?php echo $producto['altura'];?></td>
              <td><?php echo $producto['anchura'];?></td>
              <td><?php echo $producto['tipo_silla'];?></td>
              <td><?php echo $producto['ajustable'];?></td>
            </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      <?php
      }else{
      ?>
      <p class="text-danger">No se encuentran registros.</p>
      <?php
      }
      ?>
      </div>
    </main>
  </div>
</div>


    <script src="/assets/bootstrap-html-examples/assets/dist/js/bootstrap.bundle.min.js"></script>

      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="/assets/bootstrap-html-examples/dashboard/dashboard.js"></script>
  
  
      
              <div class="row m-0">
          <footer class="d-flex pos pie flex-wrap flex-column flex-lg-row justify-content-center align-items-center py-3 my-4" style="margin: 0 !important; z-index:30;">
              <div class="col-md-4 d-flex align-items-center text-center">
                <span class="mb-3 mb-md-0 text-muted text-center">&copy; Gallaecia PC 2023, Inc</span>
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
        <script src="/assets/js/accionesCesta.js"></script>
        <?php
        if($_SERVER['REQUEST_URI'] == '/checkout'){
        ?>
        <script src="/assets/js/finalizarCompra.js"></script>
        <?php
        }
        ?>   
  
  </body>
</html>
