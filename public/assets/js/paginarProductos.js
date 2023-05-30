       
        const tableItems = document.getElementsByClassName('caja_producto');       
        //Elementos paginados
        const numerosPaginados = document.getElementById("pagination-numbers");

        //Boton anterior y boton siguiente
        const pag_anterior = document.getElementById('prev-button');
        const pag_siguiente = document.getElementById('next-button');
        
        
        /*Variables para calcular las páginas***************/
        var elementosTotales = tableItems.length;
        var limitePaginacion = 4;//<-Elementos por página
        var numPaginas = Math.ceil(elementosTotales / limitePaginacion); //<-Numero de páginas
        let pagActual;
        
        
         function cargar(){
            getNumPag(); 
            defPagActual(1);

            //Definir pag anterior
            pag_anterior.addEventListener('click',function(){
                defPagActual(pagActual - 1);
            });

            //Definir pag siguiente
            pag_siguiente.addEventListener('click',function(){
                defPagActual(pagActual + 1);

            });

            document.querySelectorAll(".pagination-number").forEach((element)=>{
                const pagIndex = Number(element.getAttribute('page-index'));
                if(pagIndex){
                    element.addEventListener('click',function(){
                        defPagActual(pagIndex);
                    });
                }
            });
        }
        
        //Añadimos la cantidad de páginas dependiendo del número de la
        function getNumPag(){
            for (let index = 1; index < numPaginas; index++) {
                addNumPag(index);
            }
        }
        
        //Función para añadir los botones de cada página
        function addNumPag(num){
            let numPag = document.createElement('button');
            numPag.setAttribute('class','pagination-number');
            numPag.innerHTML = num;
            numPag.setAttribute('page-index',num);
            numPag.setAttribute('aria-label','Page '+ num);
            //Añadimos elemento
            numerosPaginados.appendChild(numPag);
        }
        
        
        //Definir página actual activa
        function manejarPagActiva(){
            
            document.querySelectorAll('.pagination-number').forEach((button) =>{
                button.classList.remove('active');

                const pagIndex = Number(button.getAttribute('page-index'));
                if(pagIndex == pagActual){
                    button.classList.add('active');
                }
            });
        }
        
                //Definir el valor de la página actual
        defPagActual = (pagNum) =>{
            pagActual = pagNum;

            manejarPagActiva();
            handlePageButtonsStatus();

            const pagAnt = (pagNum - 1) * limitePaginacion; //<-Página Anterior
            const pagAct = pagNum * limitePaginacion; //<-Página Actual
            
            //Mostrar los items de la página actual y ocultar los de las otras páginas
           for (var i = 0; i < tableItems.length; i++) {
                tableItems[i].style.display = 'none';
                if(i >= pagAnt && i < pagAct){
                   tableItems[i].style.display = 'block';  
                }
            } 
        
//        tableItems.forEach((item,index) => {
//                item.style.display = 'none';
//                if(index >= pagAnt && index < pagAct){
//                   item.style.display = 'block';                
//                }
//            });
        };

        //deshabilitar boton
        const deshabilitarBoton = (button) => {
            button.classList.add('disabled');
            button.setAttribute('disabled',true);
        };

        //habilitar boton
        const habilitarBoton = (button) =>{
            button.classList.remove('disabled');
            button.removeAttribute('disabled');
        };

        //Manejar el estado del boton de la página
        const handlePageButtonsStatus = () => {
            if (pagActual === 1) {
                deshabilitarBoton(pag_anterior);
            } else {
                habilitarBoton(pag_anterior);
            }
            if (numPaginas ===  pagActual) {
                deshabilitarBoton(pag_siguiente);
            } else {
                habilitarBoton(pag_siguiente);
            }

        };
        
        //Al cargar la página cargamos el select con las columnas de la tabla
        window.addEventListener('load',function(){      
            console.log(tableItems.length);
            //Si la tabla tiene filas cargamos las siguientes funciones
            if(tableItems.length != 0){ 
                cargar(); //Calcula el número de páginas, define la pagina actual con las páginas anterior y siguiente 
                        //y le añade a los botones de primera y última página para pasar de página
            }
        });
        
        
