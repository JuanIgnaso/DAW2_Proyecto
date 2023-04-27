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
      <main class="row pt-2 pb-2">

        <div class="col-12 col-lg-9 m-auto bg-light">
        <div class="row  row-cols-1 row-cols-md-2 ">
          <section class="col p-3">
            <header class="col-12 d-flex align-items-center justify-content-center gap-3">
              <h2 class="display-6 text-center">Cesta del pedido</h2>
            </header>
                <table class="w-100 table table-light table-striped  display-block">
                  <thead class="text-left">
                      <tr>
                        <th>Nombre Producto</th><th>Cantidad</th><th>Precio</th>
                      </tr>
                  </thead>
                  <tbody class="cuerpo_tabla w-100">
                      <tr>
                        <td>Nombre Producto 2</td>
                        <td>2</td>
                        <td>43.33</td>
                      </tr>
                      <tr>
                        <td>Nombre Producto 6</td>
                        <td>6</td>
                        <td>114.00</td>
                      </tr>
                      <tr>
                        <td>Nombre Producto 77</td>
                        <td>1</td>
                        <td>344.55</td>
                      </tr>
                      <tr>
                        <td>Nombre Producto 1</td>
                        <td>3</td>
                        <td>3.99</td>
                      </tr>
                      <tr>
                        <td>Nombre Producto 2</td>
                        <td>2</td>
                        <td>43.33</td>
                      </tr>
                      <tr>
                        <td>Nombre Producto 6</td>
                        <td>6</td>
                        <td>114.00</td>
                      </tr>
                      <tr>
                        <td><p>Nombre Producto 7555555555555ddddddd7</p></td>
                        <td>1</td>
                        <td>344.55</td>
                      </tr>
                      <tr>
                        <td>Nombre Producto 1</td>
                        <td>3</td>
                        <td>3.99</td>
                      </tr>
                      <tr>
                        <td>Nombre Producto 2</td>
                        <td>2</td>
                        <td>43.33</td>
                      </tr>
                      <tr>
                        <td>Nombre Producto 6</td>
                        <td>6</td>
                        <td>114.00</td>
                      </tr>
                      <tr>
                        <td>Nombre Producto 77</td>
                        <td>1</td>
                        <td>344.55</td>
                      </tr>
                      <tr>
                        <td>Nombre Producto 1</td>
                        <td>3</td>
                        <td>3.99</td>
                      </tr>
                      <tr>
                        <td>Nombre Producto 77</td>
                        <td>1</td>
                        <td>344.55</td>
                      </tr>
                      <tr>
                        <td>Nombre Producto 1</td>
                        <td>3</td>
                        <td>3.99</td>
                      </tr>
                  </tbody>
                </table>
                
                <!-- footer -->
                <div class="row">
                  <footer class="col-12 d-flex align-items-center flex-row justify-content-end gap-3">
                    <h4>TOTAL: </h4><span id="precio_total">422.4€</span>
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
                      <h2 class="text-start">Tipo de Envío</h2>
                      <div class="col-12 d-flex flex-column gap-1 justify-content-around p-2">
                        <div class="col d-flex text-center gap-2">
                          <input type="radio" name="ch1" id="">
                        <label for="">Envío Normal</label>
                          
                        </div>
                      <div class="col  d-flex  text-center gap-2">
                        <input type="radio" name="ch1" id="">
                        <label for="">Urgente<span><strong> + 2.50€</strong></span></label>  
                         
                        </div>
                      </div>
                      
                  </div>
                  <div class="col-12  border-bottom border-secondary">
                    <h2 class="text-start">Forma del Embalaje</h2>
                    <div class="col-12 d-flex flex-column gap-1 justify-content-around p-2">
                      <div class="col d-flex  text-center gap-2">
                        <input type="radio" name="ch2" id="">
                        <label for="">Con logo la Empresa</label>
                          
                      </div>

                      <div class="col  d-flex  text-center gap-2">
                        <input type="radio" name="ch2" id="">
                        <label for="">En Blanco<span><strong> - 1.00€</strong></span></label>  
                          
                        </div>
                    </div>
                  </div>
                </div>

                <!-- Datos del cliente -->
                <div class="row  border-bottom border-secondary">
                  <h3 class="display-6 text-center">Datos Del Usuario</h3>
                    <div class="row row-cols-1 row-cols-sm-2 mb-2 p-2 m-auto">
                        <div class="col  d-flex flex-column text-left">
                          <label for="">Nombre Titular</label>  
                            <input type="text" name="nombre" id="" class=" rounded">
                        </div>
                        <div class="col  d-flex flex-column text-left">
                          <label for="">Apellidos</label>  
                            <input type="text" name="nombre" id="" class=" rounded">
                        </div>
                        <div class="col  d-flex flex-column text-left">
                          <label for="">Número de Contacto</label>  
                            <input type="text" name="nombre" id="" class=" rounded">
                        </div>
                        <div class="col  d-flex flex-column text-left">
                          <label for="">Provincia</label>  
                            <input type="text" name="nombre" id="" class=" rounded">
                        </div>
                        <div class="col  d-flex flex-column text-left">
                          <label for="">Población</label>  
                            <input type="text" name="nombre" id="" class=" rounded">
                        </div>
                        <div class="col  d-flex flex-column text-left">
                          <label for="">Código Postal</label>  
                            <input type="text" name="nombre" id="" class=" rounded">
                        </div>
                        <div class="col  d-flex flex-column text-left">
                          <label for="">Calle</label>  
                            <input type="text" name="nombre" id="" class=" rounded">
                        </div>
                      </div>
                    </div>
                    <footer class="col-12 text-center">
                      <button type="submit" class="mt-3  p-2 rounded" id="finalizar_Compra">Finalizar Compra</button>
                    </footer>
                   
               
          </section>
        </div>
      </div>
      </main>