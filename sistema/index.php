<?php
	include_once "includes/header.php";
?>
<hr>
<header class="masthead bg-dark text-white text-center">
  <div class="container d-flex align-items-center flex-column">
    <!-- Masthead Avatar Image-->
    <img id="avatar-trucho" class="masthead-avatar mb-3" src="img/avataaars.svg" alt="..." />
    <!-- Masthead Heading-->
    <h1 class="h2 masthead-heading text-uppercase mb-0">Bienvenido <?= $_SESSION['nombre']?></h1>
    <!-- Icon Divider-->
    <div class="divider-custom divider-light">
      <div class="divider-custom-line"></div>
      <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
      <div class="divider-custom-line"></div>
    </div>
    <!-- Masthead Subheading-->
    <p class="masthead-subheading font-weight-light mb-3">
      <?php 
            switch($_SESSION['access']){
                case 1:
                    echo "Administrador";
                    break;
                case 2:
                    echo "Vendedor";
                    break;
                case 3: 
                    echo "Encargado de Sucursal";
                    break;
                case 4:
                    echo "Encargado de Almacen";
                    break;
            }
            ?>
    </p>
  </div>
</header>
<hr>
<?php if($_SESSION['access'] == 1 || $_SESSION['access'] == 3){ ?>
<div class="container-fluid mt-3">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="text-light h3 mb-0 text-gray-800">Panel de Ventas</h1>
  </div>
  <!-- Content Row -->
  <div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <a class="col-xl-3 col-md-6 mb-4" href="lista_usuarios.php">
      <div class="card border-left-primary shadow h-100 py-2 bg-white">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Número de Empleados
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">
                <?php echo empleado::contar_empleados_habilitados(); ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-user fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </a>
    <!-- Earnings (Monthly) Card Example -->
    <a class="col-xl-3 col-md-6 mb-4" href="lista_cliente.php">
      <div class="card border-left-success shadow h-100 py-2 bg-white">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Número de Clientes
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">
                <?php echo cliente::contar_clientes_habilitados(); ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </a>
    <!-- Earnings (Monthly) Card Example -->
    <a class="col-xl-3 col-md-6 mb-4" href="lista_productos.php">
      <div class="card border-left-info shadow h-100 py-2 bg-white">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Productos</div>
              <div class="row no-gutters align-items-center">
                <div class="col-auto">
                  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                    <?php echo  producto::contar_productos(); ?></div>
                </div>
                <div class="col">
                  <div class="progress progress-sm mr-2">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50"
                      aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </a>
    <!-- Pending Requests Card Example -->
    <a class="col-xl-3 col-md-6 mb-4" href="nuevo_reporte.php">
      <div class="card border-left-warning bg-white shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Ventas</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><img style="width: 150px; height: 100px;"
                src="../dinero.gif"></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
  </div>
  </a>
  <!-- PARA DESPUES ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ
    <div class="col-lg-6">
        <div class="au-card m-b-30">
            <div class="au-card-inner">
                <h3 class="text-light title-2 m-b-40">Productos con stock mínimo</h3>
                <canvas id="sales-chart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="au-card m-b-30">
            <div class="au-card-inner">
                <h3 class="text-light title-2 m-b-40">Productos más vendidos</h3>
                <canvas id="polarChart"></canvas>
            </div>
        </div>
    </div>
    -->
</div>
<?php }?>
<?php if($_SESSION['access'] == 2 || $_SESSION['access'] == 4){?>
<div class="mt-3 container d-flex align-items-center flex-column">
  <img class="work-work" src="img/Workwork.png" alt="">
</div>
<?php } ?>
<?php include_once "includes/footer.php"; ?>
<style>
#avatar-trucho {
  width: 220px
}

.work-work {
  width: 120px
}
</style>