  <body>
    
<header class="navbar navbar-dark sticky-top flex-md-nowrap justify-content-end justify-content-md-between p-1 shadow" style="background-color:#272727";>
    
        <div class="col-auto d-md-flex d-none">
            <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">

            <img role="img" width="200px" aria-label="Bootstrap" src="/assets/svg/Gallaecia_PC_Logo.svg" alt="logo_empresa">
                  <!--  class="bi me-2" -->
                  <!-- <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg> -->
               </a> 
        </div>
       
  <!--<a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">Company name</a>-->
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  
  <div class="col-md-3 text-end" id="log_user">
                    <?php
                    if(isset($_SESSION['usuario'])){
                    ?>
                    <div class="col-12 p-3 d-flex align-items-center justify-content-end gap-2">
                   
                        <!-- MODAL CARRITO  -->    

                        <button class='btn btn-default position-relative' id="btn_carrito"><i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i><span id="carrito_items" class="badge bg-danger position-absolute top-0 start-100 translate-middle"></span></button>
                     <a class="col-auto text-light m-0" id="nombre_usuario" href="/mi_Perfil"><?php echo $_SESSION['usuario']['nombre_usuario'];?></a>
                   
                    <div class="navbar-nav">
                    <div class="nav-item text-nowrap flex-column d-flex align-items-center justify-content-between">
                      <!--<a class="nav-link px-3" href="#">Log In</a>-->
                      <a class="nav-link px-3" href="#">Sign out</a>
                    </div>
                  </div>
                    
                    </div>
                
                     <?php
                    }else{
                    ?>
      
                   <div class="navbar-nav">
                    <div class="nav-item text-nowrap flex-column d-flex align-items-center justify-content-between">
                      <a class="nav-link px-3" href="#">Log In</a>
                      <a class="nav-link px-3" href="#">Sign out</a>
                    </div>
                  </div>
                    <!--<button type="button" class="btn btn-outline-light" id="login"><a href="/login">Login</a></button>-->
                  <!--<button type="button" class="activo btn btn-outline-light" id="sign_up"><a href="/register">Sign Up</a></button>-->
                  <?php
                    }
                  ?>
                </div>
  
  
         </div>
      
  
  <!--<input class="form-control form-control-dark w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search">-->

</header>
