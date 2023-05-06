<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login o Registrarse</title>
    <!-- LINKS -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap-css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/bootstrap-html-examples/sign-in/signin.css">
    <link rel="stylesheet" href="assets/css/login_register.css">
    <link rel="stylesheet" href="assets/css/comun.css">
    <!-- FAVICON -->
    <link rel="icon" type="image/x-icon" href="assets/svg/gallaecia-pc-favicon.svg">
</head>
<body>
    <div id="fondo_login"></div>
    <!-- MAIN DEL LOGIN -->
    <main class="form-signin w-100 m-auto rounded" id="idCuerpoLogin">
        <form action="<?php echo $seccion;?>" method="post">
          <img class="mb-4" src="assets/svg/Gallaecia_PC_Logo.svg" alt="" width="70%">
          <h1 class="h3 mb-3 fw-normal text-center">Porfavor introduce correo y contraseña</h1>
          <div class="form-floating">
            <input type="email" class="form-control rounded" id="floatingInput" name="email" placeholder="nombre@ejemplo.com" value="<?php echo isset($_COOKIE['email']) ? $_COOKIE['email'] : '' ;?>">
            <label for="floatingInput">Dirección email</label>
          </div>
          <?php
          if($seccion == '/register'){
          ?>
          <div class="form-floating">
            <input type="text" class="form-control rounded" id="floatingInput" name="nombre_usuario" placeholder="Nombre Usuario">
            <label for="floatingInput">Nombre Usuario</label>
          </div> 
         <?php
          }
         ?>
          <div class="form-floating">
            <input type="password" class="form-control rounded" id="floatingPassword" name="pass1" placeholder="Contraseña" value="<?php echo isset($_COOKIE['password']) ? $_COOKIE['password'] : '' ;?>">
            <label for="floatingPassword">Contraseña</label>
          </div>
          <div class="checkbox mb-3">
           <?php
           if($seccion == '/login'){
           ?>   
            <label id="label_remember_me">
              <input type="checkbox" value="remember_me" <?php echo isset($_COOKIE['email']) ? 'checked' : '';?> id="remember_me" name="remember_me"> Recuerdame
            </label>
              <?php
               }
               
              ?>
              <?php
              if(isset($loginError) && !empty($loginError) > 0){
              ?>
              <p class="text-danger">Error Al Introducir Los Datos</p>
              <?php
              }
              ?>
          </div>
          <button class="w-100 btn btn-lg rounded" id="id_boton_login" type="submit"><?php echo $accion;?></button>
          <p class="mt-5 mb-3 text-muted">Gallaecia PC &copy; 2023</p>
        </form>
      </main>
      <script>
        /*
        Aplicar un estilo al label de la checkbox en función de su estado.
        */
        var x = document.getElementById('remember_me');
        var y = document.getElementById('label_remember_me');

        x.addEventListener('change',recordar);

        function recordar(){
          if(x.checked){
          y.setAttribute('class','recordar');
        }else{
          //Se elimina la clase en caso de no estar marcado.
          y.removeAttribute('class');
        }
        }

      </script>
</body>
</html>