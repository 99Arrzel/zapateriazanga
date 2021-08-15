<?php include_once "includes/header.php";
?>
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 text-light">Registrar Nuevo Empleado</h1>
    <a href="lista_usuarios.php" class="btn btn-primary">Listar</a>
  </div>
  <!-- Content Row -->
  <form id="frm_RegistrarEmpleado" action="" method="post" autocomplete="off">
    <div class="row">
      <div class="col-lg-6 m-0">
        <div class="card">
          <div class="card-header bg-primary text-white font-weight-bold">
            Nuevo Empleado
          </div>
          <div id="mcform" class="card-body">
            <label id="lblMensaje" class="text-warning h3"><?php echo $mensaje; ?></label>
            <div class="form-group">
              <label for="nombre" class="text-light">Nombre</label>
              <input type="text" onkeypress="return /[a-z ]/i.test(event.key)" class="form-control"
                placeholder="Ingrese Nombre" name="nombre" id="nombre" required>
            </div>
            <div class="form-group">
              <label for="apPaterno" class="text-light">Apellido Paterno</label>
              <input type="text" onkeypress="return /[a-z ]/i.test(event.key)" class="form-control"
                placeholder="Apellido Paterno" name="apPaterno" id="apPaterno" required>
            </div>
            <div class="form-group">
              <label for="apMaterno" class="text-light">Apellido Materno</label>
              <input type="text" onpaste="return false;" onkeypress="return /[a-z ]/i.test(event.key)"
                class="form-control" placeholder="Apellido Materno" name="apMaterno" id="apMaterno" required>
            </div>
            <div class="form-group">
              <label for="telefono" class="text-light">Teléfono</label>
              <input type="number" onpaste="return false;" onkeypress="return /[0-9]/i.test(event.key)"
                class="form-control" placeholder="Teléfono" name="telefono" id="telefono"
                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                maxlength="8" required />
            </div>
            <div class="form-group">
              <label for="direccion" class="text-light">Direccion</label>
              <input type="text" onpaste="return false;" onkeypress="return /[a-z .0-9]/i.test(event.key)"
                class="form-control" placeholder="Ingrese Direccion" name="direccion" id="direccion" required>
            </div>
            <div class="form-group">
              <label for="sueldo" class="text-light">Sueldo Inicial</label>
              <input type="text" onpaste="return false;" onkeypress="return /[.0-9]/i.test(event.key)"
                class="form-control" placeholder="Ingrese Sueldo" name="sueldo" id="sueldo" required>
            </div>
            <div class="form-group">
              <label class="text-light">Sucursal</label>
              <select name="nsucursal" id="sucursal" class="bg-dark text-light form-control">
                <option id="suc1" value="1">Sucursal #1</option>
                <option value="2">Sucursal #2</option>
                <option value="3">Sucursal #3</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 m-0">
        <div class="card">
          <div class="card-header bg-primary text-white font-weight-bold">
            Datos de Usuario
          </div>
          <br>
          <div class="card-body">
            <div class="form-group">
              <label for="ci" class="text-light">CI:</label>
              <div class="row">
                <div class="col">
                  <input type="number" onpaste="return false;" onkeypress="return /[0-9-]/i.test(event.key)"
                    class="form-control" placeholder="Ingrese CI" name="ci" id="ci" required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="password" class="text-light">Contraseña</label>
              <input type="password" onpaste="return false;" onkeypress="return /[a-z 0-9]/i.test(event.key)"
                class="form-control" placeholder="Ingrese Contraseña" name="password" id="password" required>
            </div>
            <div class="form-group">
              <label for="confpass" class="text-light">Confirmar Contraseña</label>
              <input type="password" onpaste="return false;" onkeypress="return /[a-z 0-9]/i.test(event.key)"
                class="form-control" placeholder="Confirme Contraseña" name="confpass" id="confpass" required>
            </div>
            <div class="form-group">
              <label class="text-light">Rol</label>
              <select name="rol" id="rol" class="bg-dark text-light form-control">
                <option id="rol1" value="2">Vendedor</option>
                <option value="3">Encargado Sucursal</option>
                <option value="4">Encargado de Almacen</option>
              </select>
            </div>
            <br>
            <button id="bttn_RegistrarEmpleado" type="submit" name="registrar_empleado" class="btn btn-primary">Guardar
              Empleado</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
<script src="vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $('#bttn_RegistrarEmpleado').click(function() {
    var datos = $('#frm_RegistrarEmpleado').serialize();
    $.ajax({ //TE ODIO AJAX
      type: "POST",
      url: "negocio/Reg_Empleado.php",
      data: datos,
      success: function(res) {
        $('#lblMensaje').text(res);
        if ($('#lblMensaje').text() == "Se registro correctamente") {
          document.getElementById("nombre").value = "";
          document.getElementById("apPaterno").value = "";
          document.getElementById("apMaterno").value = "";
          document.getElementById("direccion").value = "";
          document.getElementById("telefono").value = "";
          document.getElementById("sueldo").value = "";
          document.getElementById("ci").value = "";
          document.getElementById("password").value = "";
          document.getElementById("confpass").value = "";
          document.getElementById("rol1").selected = true;
          document.getElementById("suc1").selected = true;
        }
      }
    });
    return false;
  });
});
</script>
<!-- /.container-fluid -->
<?php include_once "includes/footer.php";?>