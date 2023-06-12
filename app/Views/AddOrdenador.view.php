
      
      
<!-- CARRITO -->
  <?php
      include $_ENV['folder.views'].'/templates/carrito.php';
   ?>
       

<div class="container-fluid">
    <div class="row">

      <?php
      include $_ENV['folder.views'].'/templates/AsideInventario.php';
      ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

           <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <div class="col-12 d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
                    <h1 class="h2"><?php echo isset($titulo_seccion) ? $titulo_seccion : 'Inventario';?></h1>
                    <a href="<?php echo $volver;?>" class="btn btn-dark text-light ml-1">Volver<i class="fa-solid fa-circle-chevron-left p-2"></i></a>
                </div>
            </div>

            <h2>Bienvenido al panel de incio de Administración</h2>


             <?php
               if(isset($_SESSION['error_añadir'])){
              ;?>
                <div class="col-12 bg-danger text-light p-2 mb-2 text-center d-flex align-items-center justify-content-center gap-3">
                    <i class="fa-solid fa-triangle-exclamation"></i><p class="m-0"><?php echo $_SESSION['error_añadir'] ;?></p>
                </div>
              <?php
              unset($_SESSION['error_añadir']);
               }
              ;?>


            <div class="table-responsive text-center" style="min-height: 1000px; max-height: auto;">
            <form action="<?php echo $seccion;?>" method="post" enctype="multipart/form-data"> 
                  <div class="col-8 col-md-6 col-lg-3">

                           <div id="col-12">
                                <img id="foto_img"  src="
                                     <?php
                                     if(!isset($input['url_imagen'])){
                                         echo '/assets/img/default_image.png';
                                     }else if($input['url_imagen'] == NULL){
                                       echo '/assets/img/default_image.png';
                                     }else{
                                       echo $input['url_imagen'];  
                                     }
                                ;?>" alt="">
                                <input type="hidden" id="imagen" name="imagen" value="<?php
                                     if(!isset($input['url_imagen'])){
                                         echo '/assets/img/default_image.png';
                                     }else if($input['url_imagen'] == NULL){
                                       echo '/assets/img/default_image.png';
                                     }else{
                                       echo $input['url_imagen'];  
                                     }
                                ;?>" />
                            </div>


                            <footer class="blockquote-footer col-12 pb-2 m-auto text-center">
                                <p>Foto del Producto</p>
                                <label for="">Selecciona una imagen</label>
                                <input class="col-12 text-center" type="file" name="imagen" id="">
                            <p class="text-danger small"><?php echo isset($errores['url_imagen']) ? $errores['url_imagen'] : '';?></p>

                            </footer> 
                  </div>

                <section class="row row-cols-1 m-0 row-cols-sm-2 row-cols-lg-3">
                     <input type="hidden" id="postId" name="id_ordenador" value="<?php echo isset($input['id_ordenador']) ? $input['id_ordenador'] : '';?>" />

                      <input type="hidden" id="postId" name="codigo_producto" value="<?php echo isset($input['codigo_producto']) ? $input['codigo_producto'] :'';?>" />
                      <div class="col d-flex flex-column">
                         <label for="nombre">Nombre</label>
                         <input type="text" id="nombre" name="nombre" value="<?php echo isset($input['nombre']) ? $input['nombre'] : '' ;?>" class="mt-1">
                         <p class="text-danger small"><?php echo isset($errores['nombre']) ? $errores['nombre'] : '';?></p>
                      </div>


                      <div class="col d-flex flex-column">
                         <label for="marca">Marca</label>
                         <input type="text" id="marca" name="marca" value="<?php echo isset($input['marca']) ? $input['marca'] : '' ;?>" class="mt-1">
                         <p class="text-danger small"><?php echo isset($errores['marca']) ? $errores['marca'] : '';?></p>
                     </div>


                    <div class="col d-flex flex-column">
                         <label for="desc_producto">Desc producto</label>
                         <textarea id="desc_producto" name="desc_producto" rows="4" cols="50" ><?php echo isset($input['desc_producto']) ? $input['desc_producto'] : '' ;?></textarea>
                    </div>

                    <div class="col d-flex flex-column">
                         <label for="precio_bruto">Precio</label>
                        <input type="text" id="precio_bruto" name="precio_bruto" value="<?php echo isset($input['precio_bruto']) ? $input['precio_bruto'] : '' ;?>" class="mt-1">
                        <p class="text-danger small"><?php echo isset($errores['precio_bruto']) ? $errores['precio_bruto'] : '';?></p>
                    </div>

                    <div class="col d-flex flex-column">
                         <label for="stock">Stock</label>
                        <input type="text" id="stock" name="stock" value="<?php echo isset($input['stock']) ? $input['stock'] : '' ;?>" class="mt-1">
                        <p class="text-danger small"><?php echo isset($errores['stock']) ? $errores['stock'] : '';?></p>
                    </div>  


                    <div class="col d-flex flex-column">
                         <label for="caja">Caja</label>
                        <input type="text" id="caja" name="caja" value="<?php echo isset($input['caja']) ? $input['caja'] : '' ;?>" class="mt-1">
                        <p class="text-danger small"><?php echo isset($errores['caja']) ? $errores['caja'] : '';?></p>
                    </div> 


                    <div class="col d-flex flex-column">
                         <label for="cpu">CPU</label>
                        <input type="text" id="cpu" name="cpu" value="<?php echo isset($input['cpu']) ? $input['cpu'] : '' ;?>" class="mt-1">
                        <p class="text-danger small"><?php echo isset($errores['cpu']) ? $errores['cpu'] : '';?></p>
                    </div>  


                    <div class="col d-flex flex-column">
                        <label for="targeta_video">Targeta Video</label>
                        <input type="text" id="targeta_video" name="targeta_video" value="<?php echo isset($input['targeta_video']) ? $input['targeta_video'] : '' ;?>" class="mt-1">
                        <p class="text-danger small"><?php echo isset($errores['targeta_video']) ? $errores['targeta_video'] : '';?></p>
                    </div>  



                    <div class="col d-flex flex-column">
                        <label for="almacenamiento">Almacenamiento</label>
                        <input type="text" id="almacenamiento" name="almacenamiento" value="<?php echo isset($input['almacenamiento']) ? $input['almacenamiento'] : '' ;?>" class="mt-1">
                        <p class="text-danger small"><?php echo isset($errores['almacenamiento']) ? $errores['almacenamiento'] : '';?></p>
                    </div>   

                    <div class="col d-flex flex-column">
                        <label for="memoria">Memoria</label>
                        <input type="text" id="memoria" name="memoria" value="<?php echo isset($input['memoria']) ? $input['memoria'] : '' ;?>" class="mt-1">
                        <p class="text-danger small"><?php echo isset($errores['memoria']) ? $errores['memoria'] : '';?></p>
                    </div>   


                    <div class="col d-flex flex-column">
                        <label for="alimentacion">Alimentacion</label>
                        <input type="text" id="alimentacion" name="alimentacion" value="<?php echo isset($input['alimentacion']) ? $input['alimentacion'] : '' ;?>" class="mt-1">
                        <p class="text-danger small"><?php echo isset($errores['alimentacion']) ? $errores['alimentacion'] : '';?></p>
                    </div>   

                      <div class="col d-flex flex-column">
                         <label for="proveedor">Proveedor</label>
                            <select name="proveedor" id="proveedor">
                                   <option value="">-</option>
                                   <?php
                                   foreach ($proveedor as $proveedor) {
                                   ?>
                                   <option value="<?php echo $proveedor['id_proveedor'];?>" <?php echo (isset($input['proveedor']) && $proveedor['id_proveedor'] == $input['proveedor']) ? 'selected' : ''; ?>><?php echo $proveedor['id_proveedor'].' - '.$proveedor['nombre_proveedor'] ;?></option>

                                   <?php
                                   }
                                   ?>
                             </select>
                    <p class="text-danger small"><?php echo isset($errores['proveedor']) ? $errores['proveedor'] : '';?></p>

                    </div>


                    <div class="col d-flex flex-column">
                        <label for="almacenamiento_tipo">Almacenamiento Tipo</label>
                        <select name="almacenamiento_tipo" id="almacenamiento_tipo">
                               <option value="">-</option>

                               <?php
                               foreach ($almacenamiento_tipo as $almacenamiento) {
                               ?>
                                <option value="<?php echo $almacenamiento;?>" <?php echo (isset($input['almacenamiento_tipo']) && $almacenamiento == $input['almacenamiento_tipo']) ? 'selected' : ''; ?>><?php echo $almacenamiento ;?></option>
                               <?php
                               }
                               ?>

                         </select>
                        <p class="text-danger small"><?php echo isset($errores['almacenamiento_tipo']) ? $errores['almacenamiento_tipo'] : '';?></p>
                    </div>
                      
                </section>

              <footer class="col-12 mt-3 p-2 d-flex align-items-center justify-content-md-end justify-content-center gap-2">
                    <a href="<?php echo $volver;?>" class="btn btn-danger text-light ml-1">Cancelar<i class="fa-solid fa-ban p-2"></i></a>
                    <button type="submit" class="btn btn-success  ml-2"><?php echo $accion ;?><i class="fa-solid fa-circle-plus p-2"></i></button>
              </footer>

          </form>   

           </div>

       </main>
    </div>
 
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
  </body>
</html>



