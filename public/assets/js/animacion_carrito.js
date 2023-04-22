            /*mouseover mouseout*/
            /*ratón fuera -> fa-sharp fa-solid fa-cart-shopping fa-2xl p-1*/
            /*ratón sobre el div-> fa-sharp fa-solid fa-cart-shopping fa-bounce fa-2xl p-1*/
            var caja = document.getElementById('caja_btn_carrito');
            var icono = document.getElementById('icono_carrito');
            
            caja.addEventListener('mouseover',function(){
                icono.setAttribute('class','fa-sharp fa-solid fa-cart-shopping fa-bounce fa-2xl p-1');
            });
            caja.addEventListener('mouseout',function(){
                icono.setAttribute('class','fa-sharp fa-solid fa-cart-shopping fa-2xl p-1');
            });

