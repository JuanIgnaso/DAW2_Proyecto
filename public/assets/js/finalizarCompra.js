
                                 
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
                   calcularTotal((gastos));
               }
           });
           
            normal.addEventListener('change',function(){
               if(this.checked){
                   gastos = 3.95;
                   calcularTotal(gastos);
               }
           });
           
            sin_logo.addEventListener('change',function(){
               if(this.checked){
                  gastos = gastos - 1;
                   calcularTotal((gastos));
               }
           });
           
            con_logo.addEventListener('change',function(){
               if(this.checked){
                   gastos = 3.95;
                   calcularTotal(gastos);
               }
           });
           
           
           function calcularTotal(cant){
               let sum  = 0;
               for (var i = 0; i < carrito.length; i++) {
                   sum += (carrito[i].cantidad * carrito[i].precio);
            }
            total.innerHTML = (sum + cant).toFixed(2);
           }
           
           
           function ajax() {
               

            //funcion de ajax en JQuery
            $.ajax({

                //url que pones para ir al controlador (usando front controller)
                url: '/test_cesta',

                //metodo con el que enviar los datos (GET / POST) 
                type: 'POST',

                // contenido que envias por ajax
            data: {
                    envio:post_dir_envio,
                    datos: carrito,
                    total: parseFloat(total.innerHTML)//array, variable etc.
                },


                //si la respuesta es correcta (200) (lo que recibe del controller)
                success: function(response) {
                    window.alert('success!'); //el mensaje que recibe de ajax (No es JSON) (array, string etc.)
                   //window.location.replace("http://gallaeciapc.localhost:8080/checkout/success");
                   // purchaseSuccess();
                    console.log(response);
                    if(response){
                        window.location.href = 'http://gallaeciapc.localhost:8080/checkout/success';
                    }
                    
                },

                //si la respuesta no es correcta (400) (lo que recibe del controller)
                error: function(error) {
                   // error = JSON.parse(error.responseText);  //El mensaje que recibe de ajax (Es un JSON) (array, string etc.) 
                    
                    window.alert('failure!');
                }

                //PD: los mensajes que sean de 'error' estan en JSON, tienes que hacerles un JSON.parse(), los de 'success' no tienes que hacerlo, los puedes usar sin JSON.parse()
            });
            
        }
        
        function enable_shopping(){
                     //funcion de ajax en JQuery
            $.ajax({

                //url que pones para ir al controlador (usando front controller)
                url: '/check_salario',

                //metodo con el que enviar los datos (GET / POST) 
                type: 'POST',

                // contenido que envias por ajax
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
                    window.alert('failure!');
                     no_money.style.display = 'block';
                }

                //PD: los mensajes que sean de 'error' estan en JSON, tienes que hacerles un JSON.parse(), los de 'success' no tienes que hacerlo, los puedes usar sin JSON.parse()
            });
        }

