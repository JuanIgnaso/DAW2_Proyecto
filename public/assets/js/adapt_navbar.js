/*Adapta el margen inferior de la barra de navegación superior para evitar
 que el cuerpo se quede por detras del navbar*/
var xh = document.getElementById('cabeza');
var xx = document.getElementById('header');
           
   window.addEventListener('load',function(){
        xh.style.marginBottom = xx.clientHeight + 'px'; 
    });
         
    window.addEventListener('resize',function(){
       xh.style.marginBottom = xx.clientHeight + 'px'; 
 });

