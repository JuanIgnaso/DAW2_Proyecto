
       var msj_accion = document.querySelector('#mensaje');
       var btn_acc = document.querySelector('#conf_acc');   
          
       var codigo = 0 
      
      //Abrir La Modal
      function abrirModal(e){
         document.getElementById('modal_inventario_borrar').style.display = 'block'; 
         console.log(e.parentNode.parentNode.parentNode.getAttribute('id'));
         codigo = e.parentNode.parentNode.parentNode.getAttribute('id');
         msj_accion.innerHTML = 'Deseas Confirmar la acción?';
          btn_acc.style.display = 'block';
      }
      
      //Cerrar La Modal
      function closeModal(){
        document.getElementById('modal_inventario_borrar').style.display = 'none';
        console.log(codigo);
      }
      
      //Borrar la columna y el producto de la BBDD
      function borrar(){
          
          let columna = document.getElementById(codigo);
                   
               $.ajax({

                //url a donde se colocan los datos
                url: '/borrar_proveedor',

                
                type: 'POST',

                
            data: {
                    
                    producto: parseInt(codigo)//codigo del producto
                },


                //Borrar la columna y cerrar la modal en caso de success
                success: function(response) {
                    let resp = JSON.parse(response);
                    console.log(resp); 
                    columna.remove();
                   document.getElementById('modal_inventario_borrar').style.display = 'none';
                },

                //Cerrar modal y mostrar mensaje de error
                error: function(error) {
                   // error = JSON.parse(error.responseText);  //El mensaje que recibe de ajax (Es un JSON) (array, string etc.) 

                    error = JSON.parse(error.responseText);
                     let resp =error;
                     msj_accion.innerHTML = resp;
                     btn_acc.style.display = 'none';
                   //document.getElementById('modal_inventario_borrar').style.display = 'none';
                   
                    
                }
            });
         
      }