<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- ENLACES CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap-css/bootstrap.min.css">
    <!-- Vía JsDelivr -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> -->
    <!-- Quiźas utilice plantillas??? -->
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/comun.css">
    <!-- FAVICON -->
    <link rel="icon" type="image/x-icon" href="assets/svg/gallaecia-pc-favicon.svg">
    <title>Página De Inicio</title>
</head>
<body>
    <div class="container-fluid">    
        <div class="row">
            <header class="d-flex navegador mb-0 flex-wrap align-items-center justify-content-center justify-content-md-between py-3 shadow p-3">
                <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
                  <img role="img" width="200px" aria-label="Bootstrap" src="assets/svg/Gallaecia_PC_Logo.svg" alt="logo_empresa">
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
                        <a href="#">Perifericos Entrada</a>
                        <a href="#">Perifericos Salida</a>
                        <a href="#">Software</a>
                        <a href="#">PC Montados</a>
                      </div>
                    </div>
                  </li>
                  <!-- ****************** -->
                  <li><a href="#" class="nav-link px-2 link-dark rounded">About</a></li>
                  <?php
                  if(isset($_SESSION['permisos']) && isset($_SESSION['permisos']['inventario'])){
                  ?>
                  <li><a href="#" class="nav-link px-2 link-dark rounded">Inventario</a></li>
                  <?php
                  }
                  ?>
                </ul>
                              
                <div class="col-md-3 text-end" id="log_user">
                    <?php
                    if(isset($_SESSION['usuario'])){
                    ?>
                    <div class="col-12 d-flex align-items-center justify-content-end gap-2">
                    <p class="col-auto text-light m-0"><?php echo $_SESSION['usuario']->getNombre();?></p>
                    <button type="button" class="btn btn-outline-light"><a href="/logout">Log-Out</a></button>          
                    </div>
                     <?php
                    }else{
                    ?>
                    <button type="button" class="btn btn-outline-light"><a href="/login">Login</a></button>
                  <button type="button" class="activo btn btn-outline-light">Sign-up</button>
                  <?php
                    }
                  ?>
                </div>
              </header>
        </div>
        <div class="row">
            <h2 class="display-3">Texto de Ejemplo</h2>
        </div>