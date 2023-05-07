//Cogemos la X de la ventana
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


