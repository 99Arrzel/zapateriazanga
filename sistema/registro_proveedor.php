<?php include_once "includes/header.php";?>
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 text-light">Registrar Nuevo Proveedor</h1>
    <a href="lista_proveedor.php" class="btn btn-primary font-weight-bold">Listar</a>
  </div>
  <!-- Content Row -->
  <div class="row">
    <div class="col-lg-6 m-auto">
      <div class="card-header bg-primary text-white text-white font-weight-bold">
        Registro de Proveedor
      </div>
      <div id="mcform" class="card">
        <form id="frm_RegistrarProveedor" action="" autocomplete="off" method="post" class="card-body p-2">
          <label id="lblMensaje" class="text-warning h3"><?php echo $mensaje; ?></label>
          <div class="form-group">
            <label for="nombre" class="text-light">Nombre</label>
            <input type="text" onkeypress="return /[a-z ]/i.test(event.key)" placeholder="Ingrese Nombre" name="nombre"
              id="nombre" class="form-control" required>
          </div>
          <!--
					<div class="form-group">
						<label for="telefono" class="text-light">Telefono</label>
						<input type="text" placeholder="Ingrese Telefono" name="telefono" id="telefono" class="form-control" required>
					</div>
					-->
          <div class="form-group">
            <label for="telefono" class="text-light">Telefono</label>
            <input type="text" onkeypress="return /[0-9]/i.test(event.key)" placeholder="Ingrese Telefono"
              name="telefono" id="telefono" class="form-control"
              oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
              maxlength="8" required>
          </div>
          <br>
          <button id="bttn_RegistrarProveedor" type="submit" name="registrar_proveedor" class="btn btn-primary">Guardar
            Proveedor</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $('#bttn_RegistrarProveedor').click(function() {
    var datos = $('#frm_RegistrarProveedor').serialize();
    $.ajax({ //TE ODIO AJAX
      type: "POST",
      url: "negocio/Reg_Proveedor.php",
      data: datos,
      success: function(res) {
        $('#lblMensaje').text(res);
        if ($('#lblMensaje').text() == "Se registro correctamente") {
          document.getElementById("nombre").value = "";
          document.getElementById("telefono").value = "";
        }
      }
    });
    return false;
  });
});
</script>
<!-- /.container-fluid -->
<?php include_once "includes/footer.php"; ?>