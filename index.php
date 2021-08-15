<?php
$alert = '';
require_once('init.php');
if ($session->is_signed_in()) {
  header('location: sistema/');
} else {
  if (!empty($_POST)) {
    if (empty($_POST['usuario']) || empty($_POST['clave'])) {
      $alert = '<div class="alert alert-danger" role="alert">
        Ingrese su usuario y su clave
      </div>';
    } else {
      $usuario = trim($_POST['usuario']);
      $password = trim($_POST['clave']);
      $usuario_encontrado = usuario::verificar_usuario($usuario, $password);
      if($usuario_encontrado){
        $session->login($usuario_encontrado);
        header('location: sistema/index.php');
      }else{
        $alert = '<div class="alert alert-danger" role="alert">
          Usuario o contraseña incorrecta
        </div>';
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>AJR</title>

  <!-- Custom fonts for this template-->
  <link rel="stylesheet" href="sistema/vendor/bootstrap/css/bootstrap.min.css">
  <!-- Custom styles for this template-->
  <link href="sistema/css/style.violet.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">
  <div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image">
                <img src="sistema/img/logop.jpg" class="img-thumbnail">
              </div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Iniciar Sesión</h1>
                  </div>
                  <form class="user" method="POST">
                    <?php echo isset($alert) ? $alert : ""; ?>
                    <div class="form-group">
                      <label for="">Usuario</label>
                      <input type="text" class="form-control" placeholder="Usuario" name="usuario"></div>
                    <div class="form-group">
                      <label for="">Contraseña</label>
                      <input type="password" class="form-control" placeholder="Contraseña" name="clave">
                    </div>
                    <input type="submit" value="Iniciar" class="btn btn-primary">
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </d<iv>
  </div>
  <!-- JavaScript files-->
    <script src="sistema/vendor/jquery/jquery.min.js"></script>
    <script src="sistema/vendor/popper.js/umd/popper.min.js"> </script>
    <script src="sistema/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="sistema/vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="sistema/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="sistema/js/front.js"></script>
</body>

</html>
