<?php include_once "includes/header.php"; ?>
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 text-light">Registrar color</h1>
    <a href="lista_colores.php" class="btn btn-primary font-weight-bold">Listar</a>
  </div>
  <!-- Content Row -->
  <div class="row">
    <div class="col-lg-6 m-auto">
      <div class="card">
        <div class="card-header bg-primary text-white font-weight-bold">
          Nuevo Color
        </div>
        <div id="mcform" class="card-body">
          <form id="frm_RegistrarColor" action="" method="post" autocomplete="off">
            <label id="lblMensaje" class="text-warning h3"></label>
            <div class="form-group">
              <label for="color" class="text-light">Nombre</label>
              <input type="text" onkeypress="return /[a-z ]/i.test(event.key)" placeholder="Ingrese nombre del color"
                name="nombre" id="nombre" class="form-control" required>
            </div>
            <br>
            <button type="submit" id="bttn_RegistrarColor" name="registrar_color"
              class="btn btn-primary text-white font-weight-bold">Guardar Color</button>
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
  $('#bttn_RegistrarColor').click(function() {
    var datos = $('#frm_RegistrarColor').serialize();
    $.ajax({ //TE ODIO AJAX
      type: "POST",
      url: "negocio/Reg_Color.php",
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