
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
        <h1 class="h2">Panel Administración: <?php echo isset($tipo) ? $tipo : '' ;?></h1>
        <a href="/inventario/UsuariosSistema/add" class="btn btn-success ml-1">Añadir<i class="fa-solid fa-circle-plus p-1"></i></a>

      </div>

      <!--<canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>-->
        
      <h2>Filtros de búsqueda  <?php echo isset($tipo) ? $tipo : '' ;?></h2>
       <form method="get"  action="<?php echo $seccion;?>">
      <div class="table-responsive text-center" style="min-height: 1000px; max-height: auto;">

            <?php
                if(isset($_SESSION['action'])){
             ?> 

            <div class="col-12 bg-primary text-light p-2 text-center d-flex align-items-center justify-content-center gap-3">
                <i class="fa-sharp fa-solid fa-circle-exclamation"></i><p class="m-0"><?php echo $_SESSION['action'] ;?></p>
            </div>

            <?php
            }
            unset($_SESSION['action']);
            ?>       
          
          
          <div class="row row-cols-1 m-0 row-cols-sm-2 row-cols-lg-3">
              <div class="col d-flex flex-column">
                 <label for="">Nombre Usuario</label>
                <input type="text" id="nombre_usuario" name="nombre_usuario" value="<?php echo isset($input['nombre_usuario']) ? $input['nombre_usuario'] : '' ;?>" class="mt-1">
            </div>
              
              
             <div class="col d-flex flex-column">
                 <label for="">Correo</label>
                <input type="text" id="email" name="email" value="<?php echo isset($input['email']) ? $input['email'] : '' ;?>" class="mt-1">
            </div>
              
            <div class="col d-flex flex-column">
                 <label for="">Rol</label>
                    <select name="id_rol[]" id="id_rol" multiple>
                           <option value="">-</option>
                           <?php
                           foreach ($id_rol as $rol) {
                           ?>
                           <option value="<?php echo $rol['id_rol'];?>" <?php echo (isset($_GET['id_rol']) && in_array($rol['id_rol'],$_GET['id_rol'])) ? 'selected' : ''; ?>><?php echo $rol['id_rol'].' - '.$rol['nombre_rol'] ;?></option>
                           
                           <?php
                           }
                           ?>
                     </select>
            </div>
                                   
              
          </div>
          
          <div class="col-12 d-flex align-items-center justify-content-center  border-bottom border-secondary justify-content-md-end p-3 gap-3">
                <a href="/inventario/UsuariosSistema" value="" name="reiniciar" id="reiniciar" class="btn boton-cancelar">Reiniciar filtros</a>
              <input type="submit" value="Aplicar filtros" name="enviar" id="enviar" class="btn boton-aplicar ml-2"/>
          </div>
       </form>
          <div class="col-12">
            <p>Busca si lo prefieres entre uno de los siguientes filtros</p> 
          </div>


      <?php
      if(count($usuarios) != 0){
      ?>
 <!-- MODAL BORRAR -->
      <div class="col-6 col-sm-4 border border-2 border-dark rounded bg-light" id="modal_inventario_borrar">
          <header class=" border-bottom border-secondary col-12 d-flex justify-content-between align-items-center p-2">
              <h4 class="p-0 m-0" style="color:#272727">Confimar</h4>
              <span id="cerrar" class="font-weight-bold" onclick="closeModal()">X</span>
          </header>
          <div class="col-12 p-2">
              <p class="p-0 mb-2">Desea confirmar la acción?</p>
              <button type="button" class="btn" id="conf_acc" onclick="borrar()">Continuar</button>
          </div>
      </div>
 
     <div class="table-responsive">
        <table class="table table-striped table-sm" id="tabla_contenido">
          <thead>
            <tr>
              <th scope="col"><a href="<?php echo $seccion;?>?order=1<?php echo $queryString; ?>">ID.</a></th>
              <th scope="col"><a href="<?php echo $seccion;?>?order=2<?php echo $queryString; ?>">Email</a></th>
              <th scope="col"><a href="<?php echo $seccion;?>?order=3<?php echo $queryString; ?>">Nombre Usuario</a></th>
              <th scope="col"><a href="<?php echo $seccion;?>?order=4<?php echo $queryString; ?>">Rol</a></th>   
              <th scope="col"><a href="<?php echo $seccion;?>?order=5<?php echo $queryString; ?>">Último Login</a></th>
              <th scope="col">Acción</th>
            </tr>
          </thead>
          <tbody>
           <?php
            foreach ($usuarios as $usuario) {
                     
           ?>   
            <tr  class='<?php echo $usuario['baja'] == 1 ? 'table-dark' : '';?>'>
              <td><?php echo $usuario['id_usuario'];?></td>
              <td><?php echo $usuario['email'];?></td>
              <td><?php echo $usuario['nombre_usuario'];?></td>
              <td><?php echo $usuario['nombre_rol'];?></td>
              <td><?php echo $usuario['ultimo_login'];?></td>
              <td>
                  
                  <div class="acciones col-12 f-flex justify-content-center gap-1 flex-column flex-sm-row">
                   <?php
                         if($usuario['nombre_usuario'] != $_SESSION['usuario']['nombre_usuario']){
                    ?>
                      <button id="borrar_<?php echo $usuario['nombre_usuario'];?>" type="button" onclick="abrirModal(this)" class="btn p-0"  <?php echo $usuario['nombre_usuario'] == $_SESSION['usuario']['nombre_usuario'] ? 'disabled' : '';?>><i class="fa-solid fa-trash-can" style="color: #FF4500;"></i></button>
                      <a href="<?php echo $usuario['id_usuario'] == $_SESSION['usuario']['id_usuario'] ? '/inventario/UsuariosSistema' : '/inventario/UsuariosSistema/edit/'.$usuario['id_usuario'];?>"class="btn p-0"><i class="fa-solid fa-square-pen" style="color: #8000ff;"></i></a>
                      <button id="<?php echo $usuario['nombre_usuario'];?>" type="button" onclick='darBajaUsr(this.getAttribute("id"))' <?php echo $usuario['nombre_usuario'] == $_SESSION['usuario']['nombre_usuario'] ? 'disabled' : '';?> class="btn p-0"><i class="fa-solid fa-toggle-<?php echo $usuario['baja'] == 1 ? 'off' : 'on';?>" style="color: orangered;"></i></button>
                    <?php
                      }
                     ?>
                       
                  </div>
                  
              </td>
            </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
     </div>
 
        
        <script>
        //DAR DE BAJA USUARIO console.log(p.replace('dog', 'monkey'));
        function darBajaUsr(e){
                       
           $.ajax({
               url: '/inventario/UsuariosSistema/baja/' + e,
               
               type: 'POST',
               
               data: {
                   dato: e
               },
               success: function(response) {
                   //Si lo da de baja o no, recargamos la página para actualizar los registros
                 location.reload();              
               },
               error: function(error){
                  error = error.responseText;
                  console.log(error);
                   window.alert(error);
               },
           }); 
        }
        </script>
 
 
 
               <!-- SCRIPT BORRAR -->
      <script>

          
          
       var nombre = ''; 
      
      //Abrir La Modal
      function abrirModal(e){
         document.getElementById('modal_inventario_borrar').style.display = 'block'; 
         console.log(e.getAttribute('id'));
         let n = e.getAttribute('id');
         nombre = n.replace('borrar_','');
      }
      
      //Cerrar La Modal
      function closeModal(){
        document.getElementById('modal_inventario_borrar').style.display = 'none';
        console.log(nombre);
      }
      
      //Borrar la columna y el producto de la BBDD
      function borrar(){
          
         // let columna = document.getElementById(codigo);
                   
               $.ajax({

                //url a donde se colocan los datos
                url: '/inventario/UsuariosSistema/delete/' + nombre,

                
                type: 'POST',

                
            data: {
                    
                    usuario: nombre//codigo del producto
                },


                //Borrar la columna y cerrar la modal en caso de success
                success: function(response) {
//                   let resp = JSON.parse(response);
//                   console.log(resp); 
                   //document.getElementById('modal_inventario_borrar').style.display = 'none';
                   location.reload();              

                },

                //Cerrar modal y mostrar mensaje de error
                error: function(error) {
                   // error = JSON.parse(error.responseText);  //El mensaje que recibe de ajax (Es un JSON) (array, string etc.) 

                    error = JSON.parse(error.responseText);
                     let resp =error;
                   document.getElementById('modal_inventario_borrar').style.display = 'none';
                    window.alert((resp));
                    
                }
            });
         
      }
      </script>
      <?php
      }else{
      ?>
      <p class="text-danger">No se encuentran registros.</p>
      <?php
      }
      ?>
      </div>
           <footer class="mt-2 mb-2 col-12 col-md-8 col-lg-6 col-xl-4 m-auto bg-light rounded">
                    <!-- Navegador para mover las páginas -->
               <nav class="pagination-container" style="display:flex; margin:auto;">
                   <!-- Página anterior -->
                   <button class="pagination-button" id="prev-button" title="Previous page" aria-label="Previous page">     
                   &lt;       
                   </button>


               <!-- Númnero de páginas -->
                   <div id="pagination-numbers">

                   </div>


               <!-- Siguiente página -->
                   <button class="pagination-button" id="next-button" title="Next page" aria-label="Next page">        
                   &gt;      
                   </button>

               </nav>
        </footer>                       
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
        <script src="/assets/js/paginarElementosTabla.js"></script>

      
        <script src="/assets/js/accionesCesta.js"></script>

  </body>
</html>
