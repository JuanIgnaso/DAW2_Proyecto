$('#uploadImage').click(function(){
            //Mensaje a mostrar
            let k = document.getElementById('resp_sub_foto');
            
          // Haciendo la imagen un objeto FILE
           var file = $('#imageButton').prop("files")[0];

            // Haciendo el objeto Form
           var form = new FormData();

            // Añadiendo la imagen al form
            form.append("image", file);

            console.log(form.get('image'));
           // Llamada a AJAX
            $.ajax({
                url: "/post_foto",
               type: "POST",
               data:  form,
                contentType: false,
               processData:false,
             success: function(result){
                  k.style.display = 'block';
                  k.setAttribute('class','text-success');
                  k.innerHTML = result;
                  console.log(result);

                },
                error: function(error){
                  
                  
                  k.style.display = 'block';
                  let resp = error.responseText;
                  k.removeAttribute('class');
                  k.setAttribute('class','text-danger');
                  k.innerHTML  = resp;
                 // console.log(error);
                   
               } 
            });
        });

    
        


