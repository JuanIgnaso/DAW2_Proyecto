    //pillar la notificación por ID
    var a = document.getElementById('mensaje_edit');
    
    window.onload = ocultar();

    function ocultar(){
      if(a !== null)  
         setTimeout(() => {
      a.style.display = 'none';
    }, 5000);
    }

