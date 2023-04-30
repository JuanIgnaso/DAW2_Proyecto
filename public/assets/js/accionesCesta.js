    /*
           * elementos mirar en /assets/html/elementosCesta.html
           * 
           */   
          var cuerpo = document.getElementById('cuerpo_carrito');
          var btn_borrar_producto = document.getElementById('btn_borrar_producto');
          var elementos = cuerpo.getElementsByClassName('borrar'); 
            
          /*Botón para añadir producto al carrito*/
          var btn_anadir_p = document.getElementById('anadir_carrito_btn');
          
          /*Input que contiene la cantidad*/
          var cantidad = document.getElementById('cantidad');   
            
          /*DATOS DEL PRODUCTO EN CUESTION*/  
          //id
          var id = document.getElementById('id_producto');
          //nombre
          var n = document.getElementById('nombre');
          //precio
          var p = document.getElementById('precio');
          //cantidad
          var c = document.getElementById('cantidad');
          //Boton checkout
          var checkout = document.getElementById('btn_checkout');
          
          //Nombre usuario
          var nombre_usuario = document.getElementById('nombre_usuario');
          
          //LocalStorage
          const miLocalStorage = window.localStorage;
          
          //Limite máximo
          var max_limit = document.getElementById('limite_alcanzado');
          
          //Numero items carrito
          var carrito_items = document.getElementById('carrito_items');
         
          
          //boton carrito
          var open_carrito = document.getElementById('btn_carrito');
          open_carrito.addEventListener('click',function(){
            if(carrito.length == 0){
              removeChilds();
              cuerpo.innerHTML = '<p class="text-danger text-center">No hay ningún elemento en la cesta!</p>';
          }
          });
           
       
         var producto = {};
          var carrito = [];
          
          //Cargar Carro
           cargarCarritoDeLocalStorage();
           cargarCarrito();
         
          
              /*Añadir Producto a cesta*/
             btn_anadir_p.addEventListener('click',function(){
              //Se busca el elemento dentro del carrito 
              const found = carrito.find(element => element.codigo_producto == Number(id.innerHTML));
              if(found == undefined){
              //Si devuelve undefined quiere decir que el producto no existe dentro del carrito por lo tanto
              //procedemos a crearlo y añadirlo a la cesta.
              producto.codigo_producto = Number(id.innerHTML);
              producto.nombre = n.innerHTML;
              producto.precio = parseFloat(p.innerHTML);
              producto.cantidad = Number(c.value);
              carrito.push(producto);
              
              }else{
                  //Si la suma de la cantidad es igual o menor se suma.
                  if((found.cantidad + Number(c.value)) <= Number(c.getAttribute('max'))){
                  found.cantidad += Number(c.value);
                  let actualizar_Val = document.getElementById('cantidad_cesta_' + (found.codigo_producto));
                  actualizar_Val.innerHTML = found.cantidad;  
                  }else{
                      //En caso de pasarse se muestra una advertencia.
                    mostrarLimite();
                    setTimeout(ocultarLimite, 5000);
                  }

              }
              console.log();
             
              guardarCarrito();
              cargarCarrito();

          });
          
          /*Mostrar y ocultar advertencia*/
           mostrarLimite = () => {max_limit.style.display = 'block';};
           ocultarLimite = () => {max_limit.style.display = 'none';};   
          
          
          function cargarCarrito(){
              if(carrito.length != 0){
                  removeChilds();
                   for (var i = 0; i < carrito.length; i++) {
                   printObj(carrito[i]);                  
                   } 
                   carrito_items.style.display = 'block';
                   carrito_items.innerHTML = carrito.length;
                   checkout.style.display = 'block';
                //   printCheckOut(); 
              }else{
                  checkout.style.display = 'none';
                  carrito_items.style.display = 'none';
                  removeChilds();
              cuerpo.innerHTML = '<p class="text-danger text-center">No hay ningún elemento en la cesta!</p>';
              }
             
          }

          function printObj(e){ 
              
                let caja = document.createElement('div');
                caja.setAttribute('class','col-12 border-bottom border-secondary border-opacity-50 d-flex justify-content-between gap-2 align-items-center');
                let div_lista = document.createElement('div'); 
                div_lista.setAttribute('class','col-8');
                div_lista.append(createList(e));
                caja.append(div_lista);
                
                let span_cantidad  = document.createElement('span');
                span_cantidad.setAttribute('id','cantidad_cesta_' + (e.codigo_producto)); 
                span_cantidad.setAttribute('class','col-2'); 
               
                span_cantidad.textContent = e.cantidad;              
                caja.append(span_cantidad);
                caja.append(createButton(e));               
                cuerpo.append(caja);
                }
            
            //Crea el botón con el cual se va a borrar el elemento de la lista.
            function createButton(e){
                let boton_borrar = document.createElement('button');
                boton_borrar.setAttribute('class','col-2 borrar btn btn-default p-0');
                boton_borrar.setAttribute('id','btn_borrar_producto');
                boton_borrar.innerHTML = '<i class="fa-sharp fa-regular fa-rectangle-xmark fa-2x" style="color: #ff0000;"></i>';
                boton_borrar.addEventListener('click',function(){
                    carrito.splice(carrito.indexOf(e),1);
                    this.parentNode.remove();
                   if(carrito.length == 0){
                    checkout.style.display = 'none';
                    cuerpo.innerHTML = '<p class="text-danger text-center">No hay ningún elemento en la cesta!</p>';
                   }
                    guardarCarrito();
                });
                return boton_borrar;
            } 
             
                
            //Crea la lista que contiene el nombre del producto y el precio    
            function createList(e){
              let list =  document.createElement('ol');
                list.setAttribute('class','p-0 m-0');
                list.setAttribute('style','list-style: none');
                    let datos = [e.nombre,e.precio];
                    let nodes = datos.map(dato => {
                        let li = document.createElement('li');
                        li.textContent = dato;
                        list.append(li);
                    });
                    return list;
            }
                
  
           function removeChilds(){
           while (cuerpo.hasChildNodes()) {
            cuerpo.removeChild(cuerpo.firstChild);
            }
           }
             
            
             
             //Debería guardar el carrito en LocalStorage
             function guardarCarrito(){
                 miLocalStorage.setItem('carrito_' + nombre_usuario.innerHTML,JSON.stringify(carrito));
                 console.log('guardado' + 'carrito_' + nombre_usuario.innerHTML);
             }
             
             //Cargar el carrito
              function cargarCarritoDeLocalStorage(){
                // ¿Existe un carrito previo guardado en LocalStorage?
                if (miLocalStorage.getItem('carrito_' + nombre_usuario.innerHTML) !== null) {
                    // Carga la información
                    carrito = JSON.parse(miLocalStorage.getItem('carrito_' + nombre_usuario.innerHTML));
                }
            }


