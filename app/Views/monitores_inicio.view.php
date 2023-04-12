<body>
    <div class="container-fluid">    
        <div class="row">
            <header class="d-flex navegador mb-0 flex-wrap align-items-center justify-content-center justify-content-md-between py-3 shadow p-3">
                <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
                  <img role="img" width="200px" aria-label="Bootstrap" src="../assets/svg/Gallaecia_PC_Logo.svg" alt="logo_empresa">
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
                        <a href="#">Perifericos Entrada</a>
                        <a href="#">Perifericos Salida</a>
                        <a href="#">Software</a>
                        <a href="#">PC Montados</a>
                      </div>
                    </div>
                  </li>
                  <!-- ****************** -->
                  <li><a href="#" class="nav-link px-2 link-dark rounded">About</a></li>
                  <?php
                  if(isset($_SESSION['permisos']) && isset($_SESSION['permisos']['inventario'])){
                  ?>
                  <li><a href="#" class="nav-link px-2 link-dark rounded">Inventario</a></li>
                  <?php
                  }
                  ?>
                </ul>
                              
                <div class="col-md-3 text-end" id="log_user">
                    <?php
                    if(isset($_SESSION['usuario'])){
                    ?>
                    <div class="col-12 d-flex align-items-center justify-content-end gap-2">
                    <p class="col-auto text-light m-0"><?php echo $_SESSION['usuario']->getNombre();?></p>
                    <button type="button" class="btn btn-outline-light"><a href="/logout">Log-Out</a></button>          
                    </div>
                     <?php
                    }else{
                    ?>
                    <button type="button" class="btn btn-outline-light"><a href="/login">Login</a></button>
                  <button type="button" class="activo btn btn-outline-light">Sign-up</button>
                  <?php
                    }
                  ?>
                </div>
              </header>
        </div>
        <div class="row">
            <header class=" header_Seccion col-12 text-center text-md-start">
                <ol class="navegador_secundario d-flex justify-content-md-start justify-content-center gap-2 m-0">
                    <li><a href="/">Inicio</a></li>
                    <li>|</li>
                    <!-- Editable tabién, cambia en funcion del tipo de producto -->
                    <li><?php echo $seccion;?></li>
                </ol>
                <!-- TEXTO DEL H1 Y PARRAFO DESCRIPTIVO EDITABLES, DEPENDE DEL TIPO DE PRODUCTO -->
                <section class="col-12 col-md-8">
                        <h1 class="display-2 titulo_seccion"><?php echo $titulo;?></h1>
                        <p class="text-light"><?php echo $descripcion;?></p>
                </section>

            </header>
     
        </div>
        <div class="row">
            <header class="col-12 p-0">
                <h2 class="display-6 text-center pt-5">Barra De Búsqueda</h2>
                <p class="p-0 m-0 text-center">Si lo deseas puedes filtrar o que muestren los productos utilizando los filtros de abajo.</p>
                <div class="col-12" id="barra_nav_busqueda">
                    <div class="col-12 col-lg-8 m-auto p-2 d-flex flex-column flex-md-row justify-content-center">
                     <ul class="nav col-auto m-auto mb-2 justify-content-center gap-3 mb-md-0">
                         <li>
                              <button class="dropbtn nav-link px-2 link-secondary rounded">Precio Mayor</button>
                         </li>
                        
                        <li>
                            <button class="dropbtn nav-link px-2 link-secondary rounded">Precio Menor</button>
                        </li>
                        
                         <li>
                            <button class="dropbtn nav-link px-2 link-secondary rounded">Disponibilidad</button>
                        </li>
                        
                        <li>
                            <button class="dropbtn nav-link px-2 link-secondary rounded">Novedades</button>
                        </li>

                    </ul>
                        <form role="search" class="col-auto m-auto col-md-2">
                          <input class="form-control" type="search" placeholder="Buscar" aria-label="Search" id="buscar">
                        </form>
                  </div>
                </div>
            </header>     
        </div>
        
        <!-- SECCIÓN -->
        
        <div class="row h-auto" id="cuerpo_productos">
            <section class="col-12 col-md-10 bg-light m-auto">
                <?php
                if(is_null($productos)){
                ?>
                <div class="d-flex justify-content-center align-items-center" id="error_mostrar">
                    <p class="text-danger text-center">No se encuentran registros en estos momentos</p>
                </div>
                <?php
                }else{
                ?>
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5">
                    
                  <?php
                  foreach($productos as $producto){
                  ?>  
                    <article class="caja_producto col">
                        <header class="d-flex">
                            <!-- URL de la imagen también -->
                        <img src="../<?php echo $producto['url_imagen'];?>" alt="imagen_ejemplo"/>
                        </header>
                        <!-- PHP en función si esta o no en oferta -->
                        <div class="col-12 p-1">
                            <div class="col-6 text-success text-center border border-success rounded">
                                Oferta
                            </div>
                        </div>
                        <!-- Contenido de aquí por PHP -->
                        <a class="h5 text-center border-dark text-dark" href=""><?php echo $producto['nombre'];?></a>
                        <div class="col-12w d-flex align-items-center border-dark border-bottom p-2">
                            <h4 class="col-6"><?php echo $producto['precio'];?>€</h4>
                            <!-- PHP danger si esta agotado o primary si está disponible -->
                            <?php
                            if($producto['stock'] != 0){
                            ?>
                            <h5 class="col-6 text-primary text-center border border-primary rounded p-2">En Stock</h5>
                            <?php
                            }else{
                            ?>
                            <h5 class="col-6 text-danger text-center border border-danger rounded p-2">Agotado</h5>
                            <?php
                            }
                            ?>
                        </div>
                        <p class="text-secondary m-0 text-center text-md-start">Vendido Por: <?php echo $producto['nombre_proveedor'];?></p>
                    </article>
                <?php
                  }
                ?>    
                       

                </div>
                <?php
                }
                ?>
            </section>
            
            <!-- PAGINAR -->
            <footer class="mt-2 mb-2 col-12 col-md-8 col-lg-6 col-xl-4 m-auto bg-light rounded">
                <nav id="paginas">
                    <ul class="d-flex justify-content-center flex-wrap">
                        <li><a href="url"><< Primera</a></li>
                        <li><a href="url">< Anterior</a></li>
                        <li><a href="url">Actual</a></li>
                        <li><a href="url">Siguiente ></a></li>
                        <li><a href="url">Ultima >></a></li>
                    </ul>

                </nav>
            </footer>
               
        </div>
