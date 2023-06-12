  //Animacion boton reset
  var f = document.querySelector('#reset');

  f.addEventListener('mouseover',function(){
     f.setAttribute('class',"fa-solid fa-trash-can fa-2xl fa-flip");
     f.setAttribute('class',"fa-solid fa-trash-can fa-2xl fa-flip");
  });

  f.addEventListener('mouseout',function(){
     f.setAttribute('class',"fa-solid fa-trash-can fa-2xl"); 
  });