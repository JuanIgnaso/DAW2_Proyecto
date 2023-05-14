    
       var codigo = 0;   
      
      //Abrir La Modal
      function abrirModal(e){
         document.getElementById('modal_inventario_borrar').style.display = 'block'; 
         console.log(e.parentNode.parentNode.parentNode.getAttribute('id'));
         codigo = e.parentNode.parentNode.parentNode.getAttribute('id');
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
                url: '/borrar_producto',

                
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

                    //error = JSON.parse(error.responseText);
                     let resp = JSON.parse(error);
                    console.log(resp);
                    
                }
            });
         
      }
      

