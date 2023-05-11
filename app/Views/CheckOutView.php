        <div class="row   " id="gradiante">
          <header class="col-12 p-3 gap-2d-flex flex-column flex-sm-row align-items-center" id="cabecera-checkout">
            <h1 class="display-5">Resumen Del Pedido</h1>
          </header>
            <nav id="navegador_Sec">
                <ol class="d-flex gap-2 pb-2 p-0 m-0">
                    <li><a href="/">Inicio</a></li>
                    <li>CheckOut</li>
                </ol>

            </nav>
        </div>

<main class="row pt-2 pb-2"><!-- MIAA -->
<section class="col-9 mb-2 m-auto border border-danger text-danger bg-danger bg-opacity-25" id="not_enough_money_modal">
    <div class="col-12 d-flex align-items-center">
            <p class="m-0 p-2 col-12 text-center">Parece que no tienes suficente dinero para completar tu compra, prueba a eliminar productos de la cesta o a ingresar más fondos a tu cartera.</p>
    </div>
</section>
        <div class="col-12 col-lg-9 m-auto bg-light">
        <div class="row  row-cols-1 row-cols-md-2 ">
          <section class="col p-3">
            <header class="col-12 d-flex align-items-center justify-content-center gap-3">
              <h2 class="display-6 text-center">Cesta del pedido</h2>
            </header>
                <table class="w-100 table table-light table-striped  display-block">
                  <thead class="text-left">
                      <tr>
                          <th>Nombre Producto</th><th>Cantidad</th><th>Precio</th><th>Acción</th>
                      </tr>
                  </thead>
                  <tbody class="cuerpo_tabla w-100" id="checkout_table">
                     
                  </tbody>
                </table>
                
                <!-- footer -->
                <div class="row">
                  <footer class="col-12 d-flex align-items-center flex-row justify-content-end gap-3">
                    <h4>TOTAL: </h4><span id="suma_total"></span>
                  </footer>
                </div>
          </section>
            


          <!-- DATOS DE ENVÍO -->
          <section class="col p-3">
            <h2 class="display-6 text-center">Datos de Envío</h2>
            <p class="p-0 m-0">Rellena aquí todo lo relacionado con la forma y dirección de envío de tu pedido, para poder tramitar correctamente el envío.</p>
            <p class="text-danger small p-0 m-0">Gastos de envío por defecto es de: <span><strong>3.95€</strong></span>, Pueden variar según opción de embalaje y tipo de envío.</p>
                <div class="row p-2">
                  <div class="col-12 border-top border-secondary">
                      <h2 class="text-start"><?php echo $_SESSION['usuario']['cartera'];?>Tipo de Envío</h2>
                      <div class="col-12 d-flex flex-column gap-1 justify-content-around p-2">
                        <div class="col d-flex text-center gap-2">
                          <input type="radio" name="ch1" id="normal">
                        <label for="">Envío Normal</label>
                          
                        </div>
                      <div class="col  d-flex  text-center gap-2">
                        <input type="radio" name="ch1" id="urgente">
                        <label for="">Urgente<span><strong> + 2.50€</strong></span></label>  
                         
                        </div>
                      </div>
                      
                  </div>
                  <div class="col-12  border-bottom border-secondary">
                    <h2 class="text-start">Forma del Embalaje</h2>
                    <div class="col-12 d-flex flex-column gap-1 justify-content-around p-2">
                      <div class="col d-flex  text-center gap-2">
                        <input type="radio" name="ch2" id="con_logo">
                        <label for="">Con logo la Empresa</label>
                          
                      </div>

                      <div class="col  d-flex  text-center gap-2">
                        <input type="radio" name="ch2" id="sin_logo">
                        <label for="">En Blanco<span><strong> - 1.00€</strong></span></label>  
                          
                        </div>
                    </div>
                  </div>
                    <input type="hidden" id="postId" name="postId" value="<?php echo $_SESSION['usuario']['id_usuario'];?>" />
                </div>

                <!-- Datos del cliente -->
                <div class="row  border-bottom border-secondary">
                  <h3 class="display-6 text-center">Datos Del Usuario</h3>
                  
                  <!-- Si el checkbox esta marcado -->
                  <div id="formulario_cargar_envio" style="display: none;" class="row row-cols-1 row-cols-sm-2 mb-2 p-2 m-auto">
                        <div class="col  d-flex flex-column text-left">
                          <label for="">Nombre Titular</label>  
                          <p id="nombre_titular" class="col-12"></p>
                        </div>
                        <div class="col  d-flex flex-column text-left">
                          <label for="">Provincia</label>  
                          <p id="provincia" class="col-12"></p>
                        </div>
                        <div class="col  d-flex flex-column text-left">
                          <label for="">Ciudad</label>  
                          <p id="ciudad" class="col-12"></p>
                        </div>
                        <div class="col  d-flex flex-column text-left">
                          <label for="">Código Postal</label>  
                          <p id="cod_postal" class="col-12"></p>
                        </div>
                        <div class="col  d-flex flex-column text-left">
                          <label for="">Calle</label>  
                          <p id="calle" class="col-12"></p>
                        </div>
                      </div>
                  
                  <!-- Si el checkbox no esta marcado -->
                    <div id="formulario_dir_envio" style="display: flex;" class="row row-cols-1 row-cols-sm-2 mb-2 p-2 m-auto">
                        <div class="col  d-flex flex-column text-left">
                          <label for="">Nombre Titular</label>  
                            <input type="text" name="nombre_titular" id="inp_nombre" class=" rounded">
                            <p id="error_nombre" class="text-danger" style="display:none";></p>
                        </div>
                        <div class="col  d-flex flex-column text-left">
                          <label for="">Provincia</label>  
                            <input type="text" name="provincia" id="inp_provincia" class=" rounded" >
                            <p id="error_provincia" class="text-danger" style="display:none";></p>
                        </div>
                        <div class="col  d-flex flex-column text-left">
                          <label for="">Ciudad</label>  
                            <input type="text" name="ciudad" id="inp_ciudad" class=" rounded">
                            <p id="error_ciudad" class="text-danger" style="display:none";></p>
                        </div>
                        <div class="col  d-flex flex-column text-left">
                          <label for="">Código Postal</label>  
                            <input type="text" name="cod_postal" id="inp_postal" class=" rounded">
                            <p id="error_postal" class="text-danger" style="display:none";></p>
                        </div>
                        <div class="col  d-flex flex-column text-left">
                          <label for="">Calle</label>  
                            <input type="text" name="calle" id="inp_calle" class=" rounded">
                            <p id="error_calle" class="text-danger" style="display:none";></p>
                        </div>
                      </div>
                       <p id="errores_dir" class="col-12 text-danger p-2 ps-3 m-0" style='display:none;'></p>

                       <p id="no_dir" class="col-12 text-danger p-2 ps-3 m-0" style='display:none;'></p>
                    </div>
               
                       <div class="col-12 mt-2 d-flex align-items-center text-center gap-2">
                           <span>Usar Mi Dirección:</span>
                           <label class="cont align-items-center">
                            <input type="checkbox" id="usar_mi_direccion">
                            <span class="checkmark"></span>
                            
                          </label> 

                       </div>
                    <footer class="col-12 text-center">
                      <button type="submit" class="mt-3  p-2 rounded" onclick="ajax()" id="finalizar_Compra">Finalizar Compra</button>
                    </footer>
                   
               <script>
               var ch = document.getElementById('usar_mi_direccion');
               var id = document.getElementById('postId');
               var no_dir = document.getElementById('no_dir');
               
               //Datos del usuario
               var nombre_titular = document.getElementById('nombre_titular');
               var provincia = document.getElementById('provincia');
               var ciudad = document.getElementById('ciudad');
               var cod_postal = document.getElementById('cod_postal');
               var calle = document.getElementById('calle');
               
               
                          //Info de envio INPUTS
           var post_nombre = document.getElementById('inp_nombre');
           var post_provincia =  document.getElementById('inp_provincia');
           var post_ciudad =  document.getElementById('inp_ciudad');
           var post_postal = document.getElementById('inp_postal');
           var post_calle = document.getElementById('inp_calle');
           
           
           //Salida de errores del json de la direccion
           var errores = document.getElementById('errores_dir');
           
           
                var post_dir_envio = {nombre_titular:post_nombre.value,
                               provincia:post_provincia.value,
                               ciudad:post_ciudad.value,
                               cod_postal:post_postal.value,
                               calle:post_calle.value,
                                id:id.value};
           
           
               
               
               //ventanas
               var f = document.getElementById('formulario_dir_envio');
               var g = document.getElementById('formulario_cargar_envio');
               
               var x = post_nombre.value;
               
               ch.addEventListener('change',function(){
                   if(this.checked){
                       //Si esta marcado se hacen comprobaciones
                      $.ajax({
                        url: '/check_dir',  
                        type: 'POST',
                          data: {
                    
                          id: id.value//array, variable etc.
                          },
                           success: function(response) { // <-Si el usuario tiene asociada una direccion de envío
                                console.log(response);
                                let resp = JSON.parse(response);
                                nombre_titular.innerHTML = resp.nombre_titular;
                                provincia.innerHTML =  resp.provincia;
                                ciudad.innerHTML =  resp.ciudad;
                                cod_postal.innerHTML =  resp.cod_postal;
                                calle.innerHTML = resp.calle;
                                f.style.display = 'none';
                                g.style.display = 'flex';
                               
                                
                          post_dir_envio = { //<-Al post envío se le asocian los valores de los parrafos
                               nombre_titular:resp.nombre_titular,
                               provincia:resp.provincia,
                               ciudad: resp.ciudad,
                               cod_postal: resp.cod_postal,
                               calle: resp.calle,
                               id:id.value
                           };
                                
                           },
                          error: function(error){
                              error = JSON.parse(error.responseText);  //El mensaje que recibe de ajax (Es un JSON) (array, string etc.) 
                              no_dir.style.display = 'block';
                               no_dir.innerHTML  = 'No cuentas con ninguna dirección de envío asociada.';
                              ch.checked = false;
                             
                          }
                      });
                   }else{
                        post_dir_envio = {nombre_titular:post_nombre.value,
                               provincia:post_provincia.value,
                               ciudad:post_ciudad.value,
                               cod_postal:post_postal.value,
                               calle:post_calle.value,
                                id:id.value};
                      
                      
                       f.style.display = 'flex';
                       g.style.display = 'none';
                   }
               });
               
               </script>
          </section>
        </div>
      </div>
      </main>