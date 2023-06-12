//Resetear la foto de perfil del usuario
  var usr_id = document.querySelector('#postId');

  //Mostrar mensaje
  var alerta = document.querySelector('#reset_img');

  function resetUserImage(){
      $.ajax({
         //A donde enviamos la id
         url: '/reset_profile_photo',
         type: 'POST',
         data:{
             id:usr_id.value
         },
         success: function(response){
            alerta.style.display = 'block';
            alerta.setAttribute('class','text-success');
            alerta.innerHTML = response;
         },
         error: function(error){
            alerta.style.display = 'block';
            alerta.removeAttribute('class');
            alerta.setAttribute('class','text-danger');
            alerta.innerHTML = error.responseText;
         }
      });
  }

