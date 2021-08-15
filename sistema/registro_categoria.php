<?php include_once "includes/header.php";
$mensaje = "";
//=================================== ACTUALIZAR ===================================
/*
  foreach($_POST as $key=>$value){
    $a = strstr($key, 'gua');
    $b = (substr($a, 0, 3)=='gua')? true:false;
    if($b){
      if(trim($_POST['nombre2']) == "")
      {
          $mensaje = "No deje espacios en blanco.";
      }else{
        $aux = strtolower(trim($_POST['nombre2']));
        $nombres = categoria::traer_nombre_categorias();
        foreach($nombres as  $key=>$datos2){
          if($aux == $datos2->nombre){
              $mensaje = "La categoria ya existe";
          }
        }
        if($mensaje != "La categoria ya existe"){
          $category = new categoria;
          $nombre2 = ucwords(strtolower($_POST['nombre2']));
          $nombre2 = preg_replace('/\s+/', ' ', $nombre2);
          $nombre2 = ltrim(rtrim($nombre2));
          $category->id = trim($_POST['id2']);
          $category->nombre = $nombre2;
          $category->update();
          $mensaje = "Datos Actualizados";
        }else{
          $mensaje = "La categoria ya existe";
        }
      }
    }else{
      $a = strstr($key, 'del');
      $b = (substr($a, 0, 3) == 'del')? true:false;
      if($b){
        $category = new categoria();
        $category->id = trim($_POST['id2']);
        $category->delete_logico();
        $mensaje = "Datos Eliminados";
      }
    }
    $a = strstr($key, 'res');
    $b = (substr($a, 0, 3)=='res')? true:false;
    if($b){
      $category = new categoria();
      $category->id = trim($_POST['id2']);
      $category->restaurar();
      $mensaje = "Datos restaurados";
    }
  }
*/
?>
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="text-light h3 mb-0 text-gray-800">Registrar Categoria</h1>
    <a href="lista_categorias.php" class="btn btn-primary font-weight-bold">Listar</a>
  </div>
  <!-- Content Row -->
  <div class="row">
    <div class="col-lg-6 m-auto">
      <div class="card">
        <div class="card-header bg-primary text-white font-weight-bold">
          Nueva Categoria
        </div>
        <div id="mcform" class="card-body">
          <form id="frm_RegistrarCategoria" action="" method="post" autocomplete="off">
            <label class="text-warning h3" id="lblMensaje"><?php echo $mensaje; ?></label>
            <div class="form-group">
              <label for="nombre" class="text-light">Nombre</label>
              <input type="text" onkeypress="return /[a-z]/i.test(event.key)"
                placeholder="Ingrese nombre de la categoría" name="nombre" id="nombre" class="form-control" required>
            </div>
            <br>
            <button id="bttn_RegistrarCategoria" type="submit" name="registrar_categoria"
              class="btn btn-primary text-white">Guardar
              Categoría</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="vendor/jquery/jquery.min.js"></script>
<!--/.container-fluid -->
<?php include_once "includes/footer.php"; ?>
<script type="text/javascript">
$(document).ready(function() {
  $('#bttn_RegistrarCategoria').click(function() {
    var datos = $('#frm_RegistrarCategoria').serialize();
    $.ajax({
      type: "POST",
      url: "negocio/Reg_Categoria.php",
      data: datos,
      success: function(res) {
        $('#lblMensaje').text(res);
        if ($('#lblMensaje').text() == "Se registro correctamente") {
          document.getElementById("nombre").value = "";
        }
      }
    });
    return false;
  });
});
</script>