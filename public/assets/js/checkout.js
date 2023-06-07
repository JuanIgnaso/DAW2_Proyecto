            //carrito
            
            var carrito = [];
                
          //LocalStorage
          const miLocalStorage = window.localStorage;
                                 
             window.onload =  enable_shopping;                   
                                 
            //Finalizar compra
            var finalizar = document.getElementById('finalizar_Compra');
                                 
            //Cuerpo de la tabla
            var chk = document.getElementById('checkout_table');
            
            var total= document.getElementById('suma_total');
            
            //gastos envío
            var gastos = 3.95;
            
            //Envío urgente
            var urgente = document.getElementById('urgente');
            var normal = document.getElementById('normal');
            //Sin logo
            var sin_logo = document.getElementById('sin_logo');
            var con_logo = document.getElementById('con_logo');
            
            //Modal no suficientes fondos
            var no_money = document.getElementById('not_enough_money_modal');
            
            
            //mensajes de errores
             var er_n = document.getElementById('error_nombre');
             var er_p = document.getElementById('error_provincia');
             var er_c = document.getElementById('error_ciudad');
             var er_po = document.getElementById('error_postal');
             var er_ca = document.getElementById('error_calle');

            
            carrito = JSON.parse(miLocalStorage.getItem('carrito_' + nombre_usuario.innerHTML));
           
           cargarTabla();
           calcularTotal(gastos);
           
           //Cargar la tabla
           function cargarTabla(){
               for (var i = 0; i < carrito.length; i++) {
                   chk.append(generateRow(carrito[i]));
            }
            calcularTotal();
           }
           
           //Genera el row de la tabla
           function generateRow(e){
               let tr = document.createElement('tr');
               
               let nombre = document.createElement('td');
               nombre.innerText = e.nombre;
               
               let cantidad = document.createElement('td');
               cantidad.innerText = e.cantidad;
               
               let total  = document.createElement('td');
               total.innerText = e.cantidad * e.precio;
               
               let borrar = document.createElement('td');
               borrar.setAttribute('class','align-items-center');
               let boton_borrar = document.createElement('button');
               boton_borrar.setAttribute('id','basura');
           
               boton_borrar.setAttribute('style','background-color:unset');
               boton_borrar.innerHTML = '<i class="fa-regular fa-trash-can fa-2x" style="color: #ff8000;"></i>';
               boton_borrar.addEventListener('click', function(){
                   this.parentNode.parentNode.remove();
                   carrito.splice(carrito.indexOf(e),1);
                   console.log(carrito.length);
                   guardarCarrito();
                   calcularTotal();
               });
               borrar.append(boton_borrar);
               tr.append(nombre);
               tr.append(cantidad);
               tr.append(total);
               tr.append(borrar);
               return tr;
           }
           
           /**ACTUALIZAR GASTOS DE ENVÍO**/
           urgente.addEventListener('change',function(){
               if(this.checked){
                  gastos += 2.5;
                   calcularTotal();
               }
           });
           
            normal.addEventListener('change',function(){
               if(this.checked){
                   gastos = 3.95;
                   calcularTotal();
               }
           });
           
            sin_logo.addEventListener('change',function(){
               if(this.checked){
                  gastos = gastos - 1;
                   calcularTotal();
               }
           });
           
            con_logo.addEventListener('change',function(){
               if(this.checked){
                   gastos = 3.95;
                   calcularTotal();
               }
           });
           
           
           function calcularTotal(){
               let sum  = 0;
               if(carrito.length == 0){
                   total.innerHTML = 0.0;
               }else{
                   for (var i = 0; i < carrito.length; i++) {
                   sum += (carrito[i].cantidad * carrito[i].precio);
                }
                total.innerHTML = (sum + gastos).toFixed(2);
               }
               
           }
           
           
                        //Cargar el carrito
              function cargarCarritoDeLocalStorage(){
                // ¿Existe un carrito previo guardado en LocalStorage?
                if (miLocalStorage.getItem('carrito_' + nombre_usuario.innerHTML) !== null) {
                    // Carga la información
                    carrito = JSON.parse(miLocalStorage.getItem('carrito_' + nombre_usuario.innerHTML));
                }
            }
           
                        //Debería guardar el carrito en LocalStorage
             function guardarCarrito(){
                 miLocalStorage.setItem('carrito_' + nombre_usuario.innerHTML,JSON.stringify(carrito));
                 console.log('guardado' + 'carrito_' + nombre_usuario.innerHTML);
             }
           
           

           //PROCESA LA COMPRA
           function ajax() {
               if(!ch.checked){
                post_dir_envio = {nombre_titular:post_nombre.value,
                               provincia:post_provincia.value,
                               ciudad:post_ciudad.value,
                               cod_postal:post_postal.value,
                               calle:post_calle.value,
                               id:id.value};          
                }

            //funcion de ajax en JQuery
            $.ajax({

                //url que pones para ir al controlador (usando front controller)
                url: '/test_cesta',

                //metodo con el que enviar los datos (GET / POST) 
                type: 'POST',

                // contenido que envias por ajax
            data: {
                    envio: post_dir_envio,
                    datos: carrito,
                    total: parseFloat(total.innerHTML)//array, variable etc.
                },


                //si la respuesta es correcta (200) (lo que recibe del controller)
                success: function(response) {
                    console.log(response);
                    if(response){
                    localStorage.removeItem('carrito_' + nombre_usuario.innerHTML);
                    errores.style.display='none';
                     errores.innerHTML = '';
                   window.location.href = 'http://gallaeciapc.localhost:8080/checkout/success';
                    

                }
                    
                },

                //si la respuesta no es correcta (400) (lo que recibe del controller)
                error: function(error) {
                   // error = JSON.parse(error.responseText);  //El mensaje que recibe de ajax (Es un JSON) (array, string etc.) 
                      let resp = JSON.parse(error.responseText);
                      
                      //Si el error de producto no encontrado existe en el JSON de respuesta
                      if(resp.error_compra != undefined){
                          alert(resp.error_compra);
                      }
                      
                   // window.alert('failure!');
                     errores.style.display='block';
                     //errores.innerHTML = JSON.stringify(resp);
                     er_n.style.display = 'block';
                     er_p.style.display = 'block';
                     er_c.style.display = 'block';
                     er_po.style.display = 'block';
                     er_ca.style.display = 'block';
                     
                     if(resp.nombre != undefined){
                       er_n.innerHTML = resp.nombre;  
                     }else{
                      er_n.innerHTML = ''; 
                     }
                     
                     if(resp.provincia != undefined){
                       er_p.innerHTML = resp.provincia;  
                     }else{
                      er_p.innerHTML = ''; 
                     }
                     
                     if(resp.ciudad != undefined){
                       er_c.innerHTML = resp.ciudad;  
                     }else{
                      er_c.innerHTML = ''; 
                     }
                     
                     if(resp.postal != undefined){
                       er_po.innerHTML = resp.postal;  
                     }else{
                      er_po.innerHTML = ''; 
                     }
                     
                     if(resp.calle != undefined){
                       er_ca.innerHTML = resp.nombre;  
                     }else{
                      er_ca.innerHTML = ''; 
                     }
                     
                     if(resp.carrito != undefined){
                       no_dir.style.display = 'block';
                       no_dir.innerHTML  = resp.carrito;
                      
                     }
                     
                             //window.alert(JSON.stringify(error, null, 2));
                }

            });
            
        }
        
        function enable_shopping(){
                     //funcion de ajax en JQuery
            $.ajax({

                //url que pones para ir al controlador (usando front controller)
                url: '/check_salario',

                
                type: 'POST',

                
            data: {
                    
                    total: parseFloat(total.innerHTML)//array, variable etc.
                },


                //si la respuesta es correcta (200) (lo que recibe del controller)
                success: function(response) {
                    finalizar.disabled = false; //el mensaje que recibe de ajax (No es JSON) (array, string etc.)
                    console.log(response);
                    no_money.style.display = 'none';
                },

                //si la respuesta no es correcta (400) (lo que recibe del controller)
                error: function(error) {
                   // error = JSON.parse(error.responseText);  //El mensaje que recibe de ajax (Es un JSON) (array, string etc.) 
                    finalizar.disabled = true;
                   
                    //error = JSON.parse(error.responseText);
                     let resp = JSON.parse(error);
                    console.log(resp);
                     no_money.style.display = 'block';
                }

                //PD: los mensajes que sean de 'error' estan en JSON, tienes que hacerles un JSON.parse(), los de 'success' no tienes que hacerlo, los puedes usar sin JSON.parse()
            });
        }



