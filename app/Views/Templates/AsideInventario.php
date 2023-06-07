    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3 sidebar-sticky">
          
          
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
          <span>Usuarios</span>
        </h6>
        <ul class="nav flex-column mb-2">
            
        <?php
        if(isset($_SESSION['permisos']) && in_array('usuarios',$_SESSION['permisos'])){
        ?>    
          <li class="nav-item">
            <a class="nav-link" href="/inventario/UsuariosSistema">
              <span data-feather="file-text" class="align-text-bottom"></span>
              Usuarios
            </a>
          </li>
       <?php
        }
       ?>   
          <li class="nav-item">
            <a class="nav-link" href="/inventario/Proveedores">
              <span data-feather="file-text" class="align-text-bottom"></span>
             Proveedores
            </a>
          </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
          <span>Categorías</span>
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link" href="/inventario/Ratones">
              <span data-feather="file-text" class="align-text-bottom"></span>
              Ratones
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/inventario/Teclados">
              <span data-feather="file-text" class="align-text-bottom"></span>
              Teclados
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/inventario/Monitores">
              <span data-feather="file-text" class="align-text-bottom"></span>
             Monitores
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/inventario/Ordenadores">
              <span data-feather="file-text" class="align-text-bottom"></span>
              PC-Montados
            </a>
          </li>
           <li class="nav-item">
            <a class="nav-link" href="/inventario/Sillas">
              <span data-feather="file-text" class="align-text-bottom"></span>
              Sillas
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text" class="align-text-bottom"></span>
              Software
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text" class="align-text-bottom"></span>
             Mandos
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/inventario/Consolas">
              <span data-feather="file-text" class="align-text-bottom"></span>
              Consolas
            </a>
          </li>
        </ul>
      </div>
        
    </nav>
