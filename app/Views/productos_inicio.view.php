
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
            <form method="get"  action="<?php echo $direccion;?>" class="p-0">
            <header class="col-12 p-0">
                <h2 class="display-6 text-left pt-5 ps-2">Barra De Búsqueda</h2>
                <p class="p-0 m-0 text-md-left mb-3 ps-2">Si lo deseas puedes filtrar o que muestren los productos utilizando los filtros de abajo.</p>
                <!-- BARRA DE BÚSQUEDA -->
                <div class="col-12" id="barra_nav_busqueda">
                    <div class="col-12  col-lg-8 m-auto p-2 d-flex flex-column flex-md-row justify-content-center">
                     <ul class="nav col-auto m-auto mb-2  justify-content-center gap-1 gap-md-2 gap-lg-3 mb-md-0">
                         <li>
                             <a class="nav-link px-2 link-secondary rounded" href="<?php echo $direccion;?>?filterby=1<?php echo $queryString; ?>">Precio Mayor</a>
                         </li>
                        
                        <li>
                            <a class="nav-link px-2 link-secondary rounded" href="<?php echo $direccion;?>?filterby=2<?php echo $queryString; ?>">Precio Menor</a>
                        </li>
                        
                         <li>
                            <a class="nav-link px-2 link-secondary rounded" href="<?php echo $direccion;?>?filterby=3<?php echo $queryString; ?>">Disponibilidad</a>
                        </li>
                        
                        <li>
                            <a class="nav-link px-2 link-secondary rounded" href="<?php echo $direccion;?>?filterby=4<?php echo $queryString; ?>">Novedades</a>
                        </li>
                    </ul>
                        <div role="search" class="col-10 col-sm-6 col-md-4 col-lg-auto m-auto  d-flex align-items-center gap-2">
                          <input class="form-control" type="search" placeholder="Buscar" aria-label="Search" id="buscar" name="nombre">
                         <button class='btn btn-default' type='submit' value='submit'>
                                <i class="fa-solid fa-magnifying-glass fa-xl" id="id_buscar_icon"></i>
                           </button>
                          <select name="buscar_por" id="id_buscar_por" class="border rounded">
                            <option value="nombre">Nombre</option>
                            <option value="marca">Marca</option>
                            <option value="nombre_proveedor">Proveedor</option>
                          </select>
                        </div>
                  </div>
                </div>
                <!-- -->
            </header>  
            </form>    
        </div>
        
        <!-- SECCIÓN -->
        
        <div class="row h-auto" id="cuerpo_productos">
            <section class="col-12 col-md-10 bg-light m-auto border rounded mt-2 p-2">
                <?php
                if(is_null($productos)){
                ?>
                <div class="d-flex justify-content-center align-items-center" id="error_mostrar">
                    <p class="text-danger text-center ">No se encuentran registros en estos momentos</p>
                </div>
                <?php
                }else{
                    if(strlen($direccion) != strlen($_SERVER['REQUEST_URI'])){
                ?>

                    <header class="col-12 text-center cabecera_lista_productos border-bottom border-secondary">
                       <a class="btn p-2" href="<?php echo $direccion;?>">Reinciar Filtros</a>
                    </header>
                <?php
                    }
                ?>
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5">
                  <?php
                  foreach($productos as $producto){
                  ?>  
                    <article class="caja_producto col">
                        <header class="d-flex">
                            <!-- URL de la imagen también -->
                        <img src="<?php echo $producto['url_imagen'];?>" alt="imagen_ejemplo"/>
                        </header>
                        <!-- PHP en función si esta o no en oferta -->
                        <div class="col-12 p-1">
                            <div class="col-6 text-success text-center border border-success rounded">
                                Oferta
                            </div>
                        </div>
                        <!-- Contenido de aquí por PHP -->
                        <a class="h5 text-center border-dark text-dark" href="<?php echo $direccion.'/product_detail/'.$producto['nombre'];?>"><?php echo $producto['nombre'];?></a>
                      
                        <div class="col-12 d-flex flex-column flex-sm-row align-items-center border-dark border-bottom p-2 producto-estado">
                            <h5 class="col-6 text-center text-sm-left"><?php echo round($producto['precio'],2);?>€</h5>
                            <!-- PHP danger si esta agotado o primary si está disponible -->
                            <?php
                            if($producto['stock'] <= 0){
                            ?>
                            <h5 class="col-8 col-sm-6 text-danger text-center border border-danger rounded p-2">Agotado</h5>
                            <?php
                            }else if($producto['stock'] < 5){
                            ?>
                            
                                <h6 class="text-warning text-center border border-warning rounded p-2">Últimas Unidades</h6> 
                 
                            <?php
                            }else{
                            ?>
                            <h5 class="col-6 text-primary text-center border border-primary rounded p-2">En Stock</h5>
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
