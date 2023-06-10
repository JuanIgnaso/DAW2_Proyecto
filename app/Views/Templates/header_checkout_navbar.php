<body>
    <div class="container-fluid">    
        <div class="row" id="cabeza">
            <header class="position-fixed d-flex navegador mb-0 flex-wrap align-items-center justify-content-center justify-content-md-between py-3 shadow p-3" id="header">
                <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
                  <img role="img" width="200px" aria-label="Bootstrap" src="/assets/svg/Gallaecia_PC_Logo.svg" alt="logo_empresa">
                  <!--  class="bi me-2" -->
                  <!-- <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg> -->
                </a>
          
                <ul class="nav col-12 col-sm-6 mb-2 justify-content-center gap-1 mb-md-0">
                      <li><a href="/" class="nav-link px-2 link-secondary rounded">Inicio</a></li>
                      <!-- DropDown **********-->
                      <li>
                        <div class="dropdown">
                          <button class="dropbtn nav-link px-2 link-secondary rounded">Productos</button>
                          <div class="dropdown-content">
                                <?php include 'header_bar_dropdownmenu.php';?>
                          </div>
                        </div>
                      </li>
                      <!-- **********
                      <li><a href="#" class="nav-link px-2 link-dark rounded">About</a></li>******** -->
                      <?php
                      if(isset($_SESSION['permisos']) && in_array('inventario',$_SESSION['permisos'])){
                      ?>
                      <li><a href="/inventario" class="nav-link px-2 link-dark rounded">Inventario</a></li>
                      <?php
                      }
                      ?>
                </ul>
                              
                <div class="col-md-3 text-end" id="log_user">
                    <?php
                    if(isset($_SESSION['usuario'])){
                    ?>
                    <div class="col-12 d-flex align-items-center justify-content-end gap-2">
                   
                        <!-- MODAL CARRITO  -->    

                        
                                           
                        <!-- Foto perfil -->

                         <div id="foto_perfil_navbar" class="rounded-circle" style="background-image: url('<?= is_null($_SESSION['usuario']['profile_image']) ? '/assets/img/profiles/Default_Profile_Photo.jpg' : $_SESSION['usuario']['profile_image'];?>');">
                            
                        </div>    
                        
                    <a class="col-auto text-light m-0" id="nombre_usuario" href="/mi_Perfil"><?php echo $_SESSION['usuario']['nombre_usuario'];?></a>
                    <button type="button" class="btn btn-outline-light" id="log_out"><a href="/logout">Log-Out</a></button>          
                    </div>
                     <?php
                    }else{
                    ?>
                    <button type="button" class="btn btn-outline-light" id="login"><a href="/login">Login</a></button>
                    <button type="button" class="activo btn btn-outline-light" id="sign_up"><a href="/register">Sign Up</a></button>
                  <?php
                    }
                  ?>
                </div>
            </header>
            <script src="/assets/js/adapt_navbar.js"></script>
        </div>
        
                       