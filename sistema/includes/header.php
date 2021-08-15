<?php
include "includes/functions.php";
include "includes/reutilizaciones.php";
include "../init.php";
// Datos Usuario
	if($_SESSION['logeado'] != 1){
		header('location: ../index.php');
	}
    if((time() - $_SESSION['last_login_timestamp'] > 999999999)){ //5 min inactivo, chausango
        session_destroy();
        header('location: ../index.php');
        //session_start();
    }else{
        $_SESSION['last_login_timestamp'] = time();
    }  
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AJR</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="all,follow">
  <!-- Bootstrap CSS-->
  <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
  <!-- Custom Font Icons CSS-->
  <link rel="stylesheet" href="css/font.css">
  <!-- Google fonts - Muli-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
  <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet"
    type="text/css" />
  <!-- theme stylesheet-->
  <link rel="stylesheet" href="css/style.violet.css" id="theme-stylesheet">
  <!-- Custom stylesheet - for your changes-->
  <link rel="stylesheet" href="css/custom.css">
  <!-- Favicon-->
  <link rel="shortcut icon" href="img/favicon.ico">
  <!-- Tables-->
  <link rel="stylesheet" type="text/css" href="css/dataTables.bootstrap4.min.css" />
  <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>

<body>
  <header class="header">
    <nav class="navbar navbar-expand-lg">
      <div class="container-fluid d-flex align-items-center justify-content-between">
        <div class="navbar-header">
          <!-- Navbar Header--><a href="index.php" class="navbar-brand">
            <div class="brand-text brand-big visible text-uppercase"><strong
                class="text-primary">Zapateria</strong><strong> AJR</strong></div>
            <div class="brand-text brand-sm"><strong class="text-primary">AJR</strong><strong></strong>
            </div>
          </a>
          <!-- Sidebar Toggle Btn-->
          <button class="sidebar-toggle"><i class="fas fa-bars"></i></button>
        </div>
        <h4 class="text-light"><?php echo fechaPeru(); ?></h4>
        <div class="right-menu list-inline no-margin-bottom">
          <!-- Log out               -->
          <div class="list-inline-item logout">
            <a id="logout" href="salir.php" class="text-light nav-link">
              <span class="d-none d-sm-inline">Cerrar sessión </span><i class="icon-logout"></i>
            </a>
          </div>
        </div>
      </div>
    </nav>
  </header>
  <div class="d-flex align-items-stretch">
    <!-- Sidebar Navigation-->
    <nav id="sidebar">
      <!-- Sidebar Header-->
      <div class="sidebar-header d-flex align-items-center">
        <div class="avatar"><img src="img/logop.jpg" class="img-fluid rounded-circle"></div>
        <div class="text-light title">
          <h1 class="h5 text-light"><?= $_SESSION['nombre']; ?></h1>
          <?php if($_SESSION['access'] == 1){?>
          <p><?= "Administrador"; ?></p>
          <?php } ?>
          <?php if($_SESSION['access'] == 2){?>
          <p><?= "Vendedor"; ?></p>
          <?php } ?>
          <?php if($_SESSION['access'] == 3){?>
          <p><?= "Encargado de Sucursal"; ?></p>
          <?php } ?>
          <?php if($_SESSION['access'] == 4){?>
          <p><?= "Encargado de Almacen"; ?></p>
          <?php } ?>
        </div>
      </div>
      <ul class="text-light navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Divider -->
        <!-- Nav Item - Pages Collapse Menu -->
        <?php if($_SESSION['access'] == 1 || $_SESSION['access'] == 3){ ?>
        <li class="nav-item">
          <?= "<span><a href='nuevo_reporte.php'><i class='fas fa-fw fa-cog'></i> Reportes</a></span>" ?>
        </li>
        <?php } ?>
        <!-- Nav Item - Pages Collapse Menu -->
        <?php if($_SESSION['access'] == 1 || $_SESSION['access'] == 2 || $_SESSION['access'] == 3){?>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Ventas</span>
            <i class="fas fa-angle-down fa-lg float-right"></i>
          </a>
          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-dark py-2 collapse-inner rounded">
              <a class="collapse-item" href="nueva_venta.php">Nueva venta</a>
              <!--<a class="collapse-item" href="ventas.php">Ventas</a>-->
              <a class="collapse-item" href="nuevo_cambio.php">Registrar Cambio</a>
            </div>
          </div>
        </li>
        <?php } ?>
        <!-- Nav Item - Productos Collapse Menu -->
        <?php if($_SESSION['access'] == 1 || $_SESSION['access'] == 3 || $_SESSION['access'] == 4){?>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Productos</span>
            <i class="fas fa-angle-down fa-lg float-right"></i>
          </a>
          <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-dark py-2 collapse-inner rounded">
              <a class="collapse-item" href="registro_producto.php">Nuevo Producto</a>
              <a class="collapse-item" href="lista_productos.php">Productos</a>
              <?php if($_SESSION['access'] == 1 || $_SESSION['access'] == 3){?>
              <a class="collapse-item" href="registro_compra.php">Comprar Producto</a>
              <a class="collapse-item" href="asignar_productos.php">Asignar Productos</a>
              <a class="collapse-item" href="mover_producto.php">Mover Productos</a>
              <?php } ?>
            </div>
          </div>
        </li>
        <?php }?>
        <!-- Nav Item - Clientes Collapse Menu -->
        <?php if($_SESSION['access'] == 1 || $_SESSION['access'] == 3 || $_SESSION['access'] == 2){?>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClientes"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-users"></i>
            <span>Clientes</span>
            <i class="fas fa-angle-down fa-lg float-right"></i>
          </a>
          <div id="collapseClientes" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-dark py-2 collapse-inner rounded">
              <a class="collapse-item" href="registro_cliente.php">Nuevo Clientes</a>
              <a class="collapse-item" href="lista_cliente.php">Clientes</a>
            </div>
          </div>
        </li>
        <?php }?>
        <!-- Nav Item - Utilities Collapse Menu -->
        <?php if($_SESSION['access'] == 1 || $_SESSION['access'] == 3 || $_SESSION['access'] == 4){?>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProveedor"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-hospital"></i>
            <span>Proveedor</span>
            <i class="fas fa-angle-down fa-lg float-right"></i>
          </a>
          <div id="collapseProveedor" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-dark py-2 collapse-inner rounded">
              <a class="collapse-item" href="registro_proveedor.php">Nuevo Proveedor</a>
              <a class="collapse-item" href="lista_proveedor.php">Proveedores</a>
            </div>
          </div>
        </li>
        <?php }?>
        <?php if($_SESSION['access'] == 1 || $_SESSION['access'] == 3){?>
        <li class="nav-item">
          <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseUsuarios" aria-expanded="true">
            <i class="fas fa-user"></i>
            <span>Empleados</span>
            <i class="fas fa-angle-down fa-lg float-right"></i>
          </a>
          <div id="collapseUsuarios" class="collapse">
            <div class="bg-dark py-2 collapse-inner">
              <a class="collapse-item" href="registro_usuario.php">Nuevo Empleado</a>
              <a class="collapse-item" href="lista_usuarios.php">Empleados</a>
            </div>
          </div>
        </li>
        <?php } ?>
        <?php if($_SESSION['access'] == 1 || $_SESSION['access'] == 3){?>
        <li class="nav-item">
          <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseOtros" aria-expanded="true">
            <i class="fas fa-hospital"></i>
            <span>Otros</span>
            <i class="fas fa-angle-down fa-lg float-right"></i>
          </a>
          <div id="collapseOtros" class="collapse">
            <div class="bg-dark py-2 collapse-inner">
              <a class="collapse-item" href="registro_movimiento_ex.php">Gastos Extras</a>
              <a class="collapse-item" href="registro_categoria.php">Categorias</a>
              <a class="collapse-item" href="registro_marca.php">Marcas</a>
              <a class="collapse-item" href="registro_colores.php">Colores</a>
            </div>
          </div>
        </li>
        <?php } ?>
        <li class="nav-item">
          <a class="nav-link" href="configuracion.php" aria-expanded="true">
            <i class="fas fa-tools"></i>
            <span>Configuración</span>
          </a>
        </li>
      </ul>
    </nav>
    <!-- Sidebar Navigation end-->
    <div class="page-content">
      <div class="page-header">