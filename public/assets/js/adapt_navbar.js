var h = document.getElementById('cabeza');
var x = document.getElementById('header');
           
   window.addEventListener('load',function(){
        h.style.marginBottom = x.clientHeight + 'px'; 
    });
         
    window.addEventListener('resize',function(){
       h.style.marginBottom = x.clientHeight + 'px'; 
 });

