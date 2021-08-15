<?php include_once "includes/header.php";
$mensaje = "";
$res = marca::traer_marcas_habilitadas();
$res2 = marca::traer_marcas_deshabilitadas();
//=================================== ACTUALIZAR ===================================
foreach($_POST as $key=>$value){
  $a = strstr($key, 'gua');
  $b = (substr($a, 0, 3)=='gua')? true:false;
  if($b){
    if(trim($_POST['nombre2']) == "")
    {
        $mensaje = "No deje espacios en blanco.";
    }else{
      $aux = strtolower(trim($_POST['nombre2']));
      $nombres = marca::traer_nombre_marcas();
      foreach($nombres as  $key=>$datos2){
        if($aux == $datos2->nombre){
            $mensaje = "La marca ya existe";
        }
      }
      if($mensaje != "La marca ya existe"){
        $brand = new marca;
        $nombre2 = ucwords(strtolower($_POST['nombre2']));
        $nombre2 = preg_replace('/\s+/', ' ', $nombre2);
        $nombre2 = ltrim(rtrim($nombre2));
        $brand->id = trim($_POST['id2']);
        $brand->nombre = $nombre2;
        $brand->update();
        $mensaje = "Datos Actualizados";
      }else{
        $mensaje = "La marca ya existe";
      }
    }
  }else{
    $a = strstr($key, 'del');
    $b = (substr($a, 0, 3) == 'del')? true:false;
    if($b){
      $brand = new marca();
      $brand->id = trim($_POST['id2']);
      $brand->delete_logico();
      $mensaje = "Datos Eliminados";
    }
  }
  $a = strstr($key, 'res');
  $b = (substr($a, 0, 3)=='res')? true:false;
  if($b){
    $brand = new marca();
    $brand->id = trim($_POST['id2']);
    $brand->restaurar();
    $mensaje = "Datos restaurados";
  }
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 text-light">Registrar Marca</h1>
    <a href="lista_marcas.php" class="btn btn-primary font-weight-bold">Listar</a>
  </div>
  <!-- Content Row -->
  <div class="row">
    <div class="col-lg-6 m-auto">
      <div class="card">
        <div class="card-header bg-primary text-white font-weight-bold">
          Nueva Marca
        </div>
        <div id="mcform" class="card-body">
          <form id="frm_RegistrarMarca" action="" method="post" autocomplete="off">
            <label id="lblMensaje" class="text-warning h3"><?php echo $mensaje; ?></label>
            <div class="form-group">
              <label for="marca" class="text-light">Nombre</label>
              <input type="text" onkeypress="return /[a-z ]/i.test(event.key)" placeholder="Ingrese nombre de la marca"
                name="nombre" id="nombre" class="form-control" required>
            </div>
            <br>
            <button type="submit" id="bttn_RegistrarMarca" name="registrar_marca"
              class="btn btn-primary text-white font-weight-bold">Guardar Marca</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="vendor/jquery/jquery.min.js"></script>
<!-- /.container-fluid -->
<?php include_once "includes/footer.php"; ?>
<script type="text/javascript">
$(document).ready(function() {
  $('#bttn_RegistrarMarca').click(function() {
    var datos = $('#frm_RegistrarMarca').serialize();
    $.ajax({ //TE ODIO AJAX
      type: "POST",
      url: "negocio/Reg_Marca.php",
      data: datos,
      success: function(res) {
        $('#lblMensaje').text(res);
        if ($('#lblMensaje').text() == "Se registro correctamente") {
          document.getElementById("nombre").value = "";
          //Si se registro, para pasar el dato a la tabla
          //Saca el id y nombre de var datos. ya que eso quiere
          //decir que no estaban repetidos.
        }
      }
    });
    return false;
  });
});
</script>