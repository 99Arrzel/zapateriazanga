<?php include_once "includes/header.php";?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 text-light">Registrar Nuevo Cliente</h1>
    <a href="lista_cliente.php" class="btn btn-primary font-weight-bold">Listar</a>
  </div>
  <!-- Content Row -->
  <div class="row">
    <div class="col-lg-6 m-auto">
      <div class="card">
        <div class="card-header bg-primary text-white font-weight-bold">
          Clientes
        </div>
        <div class="card-body" id="mcform">
          <div class="form-group">
            <h3 class="text-light">Buscar Cliente</h3>
            <p class="text-light" style="font-size: 15px;">■ Si desea editar a un cliente coloque la id de alguno y presione Enter.</p>
          </div>
          <div class="form-group">
            <label for="idCliente" class="text-light">ID</label>
            <input class="form-control" placeholder="ID" name="idCliente" id="idCliente"
              oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
              type="number" maxlength="8" />
          </div>
          <h3 class="text-light">Nuevo Cliente</h3>
          <form action="" method="post" autocomplete="off" id="frm_reg_cliente">
            <label class="text-warning h3" id="lblMensaje"></label>
            <div class="form-group">
              <label for="ci" class="text-light">CI</label>
              <input class="form-control" type="text" placeholder="Ingrese CI" name="ci" id="ci"
                onkeypress="return /[0-9-]/i.test(event.key)" required>
            </div>
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
              <input type="text" onkeypress="return /[a-z ]/i.test(event.key)" class="form-control"
                placeholder="Apellido Materno" name="apMaterno" id="apMaterno" required>
            </div>
            <div class="form-group">
              <label for="telefono" class="text-light">Teléfono</label>
              <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)"
                placeholder="Teléfono" name="telefono" id="telefono"
                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                maxlength="8" />
            </div>
            <br>
            <!--
              <button type="submit" id="reg_cliente" name="registrar_cliente" class="btn btn-primary"
              onclick="reg_cliente(this)">Guardar
              Cliente</button>
            -->
            <div class="form-group">
              <button type="submit" value="insert" name="accion" class="btn btn-primary">Guardar Cliente</button>
              <button type="submit" value="update" name="accion" class="btn btn-primary ml-2">Modificar Cliente</button>
              <button type="submit" value="delete" name="accion" class="btn btn-primary mt-2">Eliminar Cliente</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>
<script src="vendor/jquery/jquery.min.js"></script>
<!--HAY Q INCLUIR ESTA WEA SI O SI-->
<script type="text/javascript">
  //-----------ANTIGUO CODIGO-----------------
  // $(document).ready(function() {
  //   $('#reg_cliente').click(function() { //ID del boton del formulario
  //     var datos = $('#frm_reg_cliente').serialize(); //ID del formulario
  //     $.ajax({ 
  //       type: "POST",
  //       url: "negocio/Reg_Cliente.php", //direccion del php q vamos a usar
  //       data: datos,
  //       success: function(res) { //echo que devuelve el llamado al php
  //         $('#lblMensaje').text(res); //asignar la respuesta al l*abel mensaje
  //         if ($('#lblMensaje').text() == "Se registro correctamente") {
  //           document.getElementById("ci").value = "";
  //           document.getElementById("nombre").value = "";
  //           document.getElementById("apPaterno").value = "";
  //           document.getElementById("apMaterno").value = "";
  //           document.getElementById("telefono").value = "";
  //           console.log(datos);
  //         }
  //       }
  //     });
  //     return false; //evitar q  se recargue la pagina
  //   });
  // });
  //------------------------------------------------
$(document).ready(function() {
  var botonClickeado;
  $("button").click(function() {
    botonClickeado = $(this).val();
    //alert(botonClickeado);
    //console.log(botonClickeado);
  });
  $('#frm_reg_cliente button').click(function() { //ID del boton del formulario
    var datos = $('#frm_reg_cliente').serializeArray(); //ID del formulario
    var idCliente = $('#idCliente').val();
    datos.push({
      "name": "accion",
      "value": botonClickeado
    });
    datos.push({
      "name": "id",
      "value": idCliente
    });
    $.ajax({
      type: "POST",
      url: "negocio/Reg_Cliente.php", //direccion del php q vamos a usar
      data: datos,
      success: function(res) { //echo que devuelve el llamado al php
        $('#lblMensaje').text(res); //asignar la respuesta al l*abel mensaje
        if ($('#lblMensaje').text() == "Se registro correctamente" || $('#lblMensaje').text() == "Se elimino correctamente") {
          document.getElementById("ci").value = "";
          document.getElementById("nombre").value = "";
          document.getElementById("apPaterno").value = "";
          document.getElementById("apMaterno").value = "";
          document.getElementById("telefono").value = "";
        }
        console.log(res);
      }
    });
    return false; //evitar q se recargue la pinche pagina
  });
});

$('#idCliente').keydown(function(e) {
  var key = e.keyCode
  var id_cliente = $('#idCliente').val();
  if (key == 13) {
    //console.log(id_cliente);
    $.ajax({
      type: "GET",
      datatype: "json",
      url: "negocio/Bus_Cliente.php?id_cliente=" + id_cliente, //direccion del php q vamos a usar
      data: id_cliente,
      success: function(res) { //echo que devuelve el llamado al php
        var myObj = JSON.parse(res);
        if (myObj.length > 0)
          $('#lblMensaje').text("Se encontro cliente"); //asignar la respuesta al l*abel mensaje
        else $('#lblMensaje').text("No se encontro cliente");
        console.log("entro");

        //populate("#frm_reg_cliente",res);

        document.getElementById("ci").value = myObj[0].ci;
        document.getElementById("nombre").value = myObj[0].nombre;
        document.getElementById("apPaterno").value = myObj[0].apPaterno;
        document.getElementById("apMaterno").value = myObj[0].apMaterno;
        document.getElementById("telefono").value = myObj[0].telefono;
      }
    });
  }
});
</script>
<!-- /.container-fluid -->
<?php include_once "includes/footer.php"; ?>