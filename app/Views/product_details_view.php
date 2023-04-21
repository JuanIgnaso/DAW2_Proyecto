<div class="row">
    <nav class="col-12 bg-purple p-3" id="navegador_Sec">
        <ol class="d-flex justify-content-md-start justify-content-center gap-2 m-0" >
            <li><a href="/">Inicio</a></li>
            <li><a href="/">Categoria</a></li>
            <li>Nombre Producto</li>
        </ol>

    </nav>
</div>

<!-- MAIN -->
<main class="row">
    <section class="col-12" id="id_product_section">
        <!-- CAJA DEL PRODUCTO -->
        <div class="col-12 col-sm-8 m-auto">
            <div class="row">
                <!-- FOTO -->
                <div class="col-12 col-lg-6 bg-primary p-0 position-relative">
                    <img src="/assets/img/default_image" alt="imagen_producto" style="width: 100%;"/>
                     <button class='btn btn-default position-absolute' id="modal_btn"><i class="fa-sharp fa-regular fa-image fa-2xl" style="color: #ff8000;"></i></button>
                </div>
                <!-- DETALLES -->
                <div class="col-12 col-lg-6" id="detalles_box">
                    <h2 class="display-6">Nombre Del Producto</h2>
                    <!-- PRECIO -->
                    <div class="col-12 border-bottom border-secondary" id="precio-box">
                        <h2 class="display-5">342.44€</h2> 
                    </div>
                    <!-- VENDIDO POR -->
                    <div class="col-12 text-secondary p-2 mt-2" id="vendido_por">
                        <ol class="d-flex">
                            <li>Vendido Por: Patrocinador</li>
                            <li>Enviado Por: Gallaecia PC</li>
                        </ol>
                    </div>
                    <!-- DETALLES MARCA, COD PRODUCTO, CATEGORIA -->
                    <div class="col-12 text-secondary p-2 mt-2" id="marca_box">
                        <ol class="d-flex gap-1">
                            <li>Marca: Phantom Gaming</li>
                            <li>Código Producto: 0000004</li>
                            <li>Categoría: Nombre Categoría</li>
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
                            <li><i class="fa-brands fa-twitter fa-2xl" style="color: #272727;"></i></li>
                            <li><i class="fa-brands fa-facebook-f fa-2xl" style="color: #272727;"></i></li>
                            <li><i class="fa-brands fa-instagram  fa-2xl" style="color: #272727;"></i></li>
                        </ol>  
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
    <section class="col-12 p-0" id="detalles">
        <div class="col-10 m-auto">
         <article>
             <h2 class="display-4">Descripción Del Producto</h2>
             <div class="col-12 divisor"></div>
             <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse in orci eu erat pulvinar rutrum sed nec purus. Suspendisse laoreet ut quam vitae elementum. Mauris sit amet est congue, finibus metus nec, ullamcorper leo. Nulla bibendum maximus dolor, eget pretium metus dignissim ut. Praesent eu ante et nisl tempus volutpat. Aenean condimentum est justo, at consectetur ipsum venenatis nec. Nam ipsum tellus, elementum laoreet tristique sed, imperdiet vel dolor. Phasellus finibus a quam in consequat. Donec a leo venenatis, vehicula eros vitae, rhoncus neque. Aenean posuere, mi id malesuada ullamcorper, dolor erat porta felis, sed blandit metus purus non lorem. Nunc metus urna, rhoncus in viverra in, rutrum vel augue. </p>
        </article>
        <article class="mb-2">
            <h2 class="display-4">Especificaciones</h2>
            <div class="col-12 divisor"></div>
            <ul id="lista_caracteristicas" class="m-0">
                <li><strong>first</strong>Details </li>
                <li><strong>first</strong> Details</li>
                <li><strong>first</strong> Details</li>
                <li><strong>first</strong> Details</li>
                <li><strong>first</strong> Details</li>
                <li><strong>first</strong> Details</li>
            </ul>

        </article>
        </div>
    </section> 
</main>