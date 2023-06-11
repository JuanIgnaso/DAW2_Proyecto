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
               
