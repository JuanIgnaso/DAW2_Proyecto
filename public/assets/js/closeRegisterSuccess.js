/*
 * Oculta la modal de Register Success cuando el usuario se registra exitosamente
 * 
 */
    var closeX = document.getElementById('closeX');
      //Solo se ejecuta si la variable existe
    if(closeX != null){

       setTimeout(() => {
       closeX.parentNode.parentNode.style.display = 'none';
      }, 7000);


       closeX.addEventListener('click',function(){
       this.parentNode.parentNode.style.display = 'none'; 
    });  
    }


