<div class="row">
    <nav class="col-12 bg-purple p-3 mb-1" id="navegador_Sec">
        <ol class="d-flex justify-content-md-start justify-content-center gap-2 m-0" >
            <li><a href="/">Inicio</a></li>
            <li><a href="/productos/categoria/<?php echo $datos_generales['categoria'] ;?>"><?php echo $datos_generales['nombre_categoria'];?></a></li>
            <li><?php echo $datos_generales['nombre'];?></li>
        </ol>

    </nav>
</div>

<!-- MAIN -->
<main class="row">
    <section class="col-12" id="id_product_section">
        <!-- CAJA DEL PRODUCTO -->
        <div class="col-12 col-sm-8 m-auto mb-3">
            <div class="row">
                <!-- FOTO -->
                <div class="col-12 col-lg-6 p-0 position-relative">
                    <img src="<?php echo $datos_generales['url_imagen'];?>" alt="imagen_producto" style="width: 100%;"/>
                     <button class='btn btn-default position-absolute' id="modal_btn"><i class="fa-sharp fa-regular fa-image fa-2xl" style="color: #ff8000;"></i></button>
                </div>
                <!-- DETALLES -->
                <div class="col-12 col-lg-6" id="detalles_box">
                    <h2 class="display-6" id="nombre"><?php echo $datos_generales['nombre'];?></h2>
                    <!-- PRECIO -->
                    <div class="col-12 border-bottom border-secondary" id="precio-box">
                        <h2 class="display-5" id="precio"><?php echo number_format($datos_generales['precio'],2,'.','');?>€</h2> 
                    </div>
                    <!-- VENDIDO POR -->
                    <div class="col-12 text-secondary p-2 mt-2" id="vendido_por">
                        <ol class="d-flex">
                            <li>Vendido Por:<?php echo $datos_generales['nombre_proveedor'];?></li>
                            <li>Enviado Por: Gallaecia PC</li>
                        </ol>
                    </div>
                    <!-- DETALLES MARCA, COD PRODUCTO, CATEGORIA -->
                    <div class="col-12 text-secondary p-2 mt-2" id="marca_box">
                        <ol class="d-flex gap-1">
                            <li>Marca: <?php echo $datos_generales['marca'];?></li>
                            <li>Código Producto:<span id="id_producto"><?php echo $datos_generales['codigo_producto'];?></span></li>
                            <li>Categoría: <?php echo $datos_generales['nombre_categoria'];?></li>
                        </ol>  
                    </div>
                    <!-- GARANTÍA -->
                    <div class="col-12 text-secondary ps-2 pt-3 pb-3 mt-2" id="garantia-box">
                        <ol class="d-flex gap-1">
                            <li><i class="fa-sharp fa-solid fa-star"></i></li>
                            <li><strong>Hasta 3 años de Garantía!</strong></li>                      
                        </ol>  
                    </div>
                    <!-- ENVÍO -->
                    <div class="col-12 text-secondary ps-2 pt-3 pb-3 mt-2" id="envio-box">
                        <ol class="d-flex gap-1">
                            <li><i class="fa-sharp fa-solid fa-truck-fast"></i></li>
                            <li><strong>Envío por 3.95€</strong></li>
                            <li id="envio_Details"><strong>Recibido a casa en menos de 5 días laborables</strong></li>
                        </ol>  
                    </div>
                    
                    <!-- COMPARTIR -->
                    <div class="col-12 text-secondary ps-2 pt-3 pb-3 mt-2 d-flex gap-3 justify-content-end" id="compartir-box">
                        <span>Compartir:</span>
                        <ol class="d-flex gap-3">
                            <li><a href="https://twitter.com/"><i class="fa-brands fa-twitter fa-2xl" style="color: #272727;"></i></a></li>
                            <li><a href="https://www.facebook.com/"><i class="fa-brands fa-facebook-f fa-2xl" style="color: #272727;"></i></a></li>
                            <li><a href="https://www.instagram.com/"><i class="fa-brands fa-instagram  fa-2xl" style="color: #272727;"></i></a></li>
                        </ol> 
                    </div>
                    <div class="col-12 text-center" id="limite_alcanzado">
                        <p class="text-danger m-0"><span class="badge bg-danger">!</span> Límite Máximo Alcanzado, no puedes comprar más de este producto.</p>
                    </div>
                    <!-- AÑADIR AL CARRITO -->
                   <div class="col-12 text-secondary ps-2 pt-3 pb-3 mt-2 d-flex flex-column flex-sm-row gap-3 justify-content-center align-items-center" id="compartir-box">
                       
                       <div class="d-flex align-items-center gap-2">
                           <span>Cantidad:</span>
                             <input type="number" id="cantidad" min="1" value="1" max="<?php echo $datos_generales['stock'] <= 10 ? $datos_generales['stock'] : 10;?>" name="cantidad"<?php echo $datos_generales['stock'] == 0 ? 'disabled' : '';?>>
                       </div> 
                       <?php
                       if($datos_generales['stock'] != 0){
                       ?>
                             <div id="caja_btn_carrito" class="border rounded p-1">
                                 <button class='btn btn-default' id="anadir_carrito_btn" <?php echo isset($_SESSION['usuario']) ? '' : 'disabled';?>><i class="fa-sharp fa-solid fa-cart-shopping fa-2xl p-1" id="icono_carrito"></i><strong>Añadir Al Carrito</strong></button>
                             </div>
                       <?php
                       }else{
                       ?>
                       <span class="text-danger">Producto No Disponible</span>
                       <?php
                       }
                       ?>
                    </div>             
                </div>
            </div>
        </div>
        <!-- SCRIPT PARA LA ANIMACIÓN DEL CARRITO -->
        <script src="/assets/js/animacion_carrito.js"></script>
        <script>
            /*Coger la ventana modal*/
        var modal = document.getElementById("mi_modal_carrito");

        // Coger el botón que abre la modal
        var btn = document.getElementById("carrito_btn");

        // coger el <span> que cierra la modal
        var span = document.getElementsByClassName("close_carrito")[0];

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
        </script>
        
        
        
        
        
        
        <div class="row">
          
            <div class="col-10 col-sm-5 m-auto class_modal p-0" id="mi_modal">
                  <!-- COntenido del modal -->
                <div class="col-12  contenido_modal">
                    <header class="d-flex border-bottom border-secondary p-2 justify-content-between">
                       <h2 class="text-light text-center">Imágen Del Producto</h2>
                       <span class="close text-dark">X</span>     
                    </header> 
                    <img src="<?php echo $datos_generales['url_imagen'];?>" alt="alt" width="100%"/>
                </div>
                 <!--  -->
            </div>
           
        </div>
        <!-- SCRIPT PARA LA VENTANA MODAL -->
        <script src="/assets/js/modal_window_script.js"></script>   
    </section>
    <section class="col-12 p-0" id="detalles">
        <div class="col-10 m-auto">
         <article>
             <h2 class="display-4">Descripción Del Producto</h2>
             <div class="col-12 divisor"></div>
             <p><?php echo $datos_generales['desc_producto'];?> </p>
        </article>
        <article class="mb-2">
            <h2 class="display-4">Especificaciones</h2>
            <div class="col-12 divisor"></div>
            <ul id="lista_caracteristicas" class="m-0">
                <?php
                foreach($detalles_producto as $key => $value){
                ?>
                <li><strong><?php echo ucfirst(preg_replace('/_/',' ',$key));?>: </strong><?php echo $value;?> </li>
                <?php
                }
                ?>
            </ul>

        </article>
        </div>
    </section> 
</main>