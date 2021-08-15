<?php include_once "includes/header.php"; 
$res = movimiento::traer_ultimos_movimientos_realizados();
$conceptos = concepto::traer_nombre_conceptos();
$tipo_transaccion = tipo_transaccion::traer_nombre_transacciones();
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <div class="form-group">
        <h3 class="text-light text-center">Movimiento Extra</h3>
      </div>
      <div class="card">
        <div class="card-body" id="mcform">
          <form method="post" id="frm_movimiento_extra">
            <label class="text-warning h3" id="lblMensaje"><?= $mensaje?></label>
            <div class="row">
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="text-light">Nombre Empleado:</label>
                  <input type="text" name="empleado" id="empleado" value="<?= $_SESSION['nombre'];?>"
                    class="form-control text-light" disabled>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="text-light">CI Empleado:</label>
                  <input type="text" name="ci_empleado" id="ci_empleado" value="<?= $_SESSION['ci_empleado'];?>"
                    class="form-control text-light" disabled>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="text-light">Fecha:</label>
                  <input type="text" name="nom_cliente" id="nom_cliente" value="<?= date("m/d/Y"); ?>"
                    class="form-control text-light" disabled required>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="text-light">Tipo Transaccion</label>
                  <select id="id_tipo_transaccion" name="id_tipo_transaccion" class="bg-dark text-light form-control">
                    <?php for($i = 0; $i<count($tipo_transaccion); $i=$i+1){?>
                    <option class="text-light" value='<?= $tipo_transaccion[$i]->id?>'>
                      <?= $tipo_transaccion[$i]->descripcion ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="text-light">Concepto</label>
                  <select id="id_concepto" name="id_concepto" class="bg-dark text-light form-control">
                    <?php for($i = 0; $i<count($conceptos); $i=$i+1){?>
                    <option class="text-light" value='<?= $conceptos[$i]->id?>'>
                      <?= $conceptos[$i]->descripcion ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="text-light">Total BS.</label>
                  <input type="text" onkeypress="return /[0-9]/i.test(event.key)" placeholder="0" name="total"
                    id="total" class="text light form-control" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="text-light">Sucursal:</label>
                  <input type="text" value="<?= "Sucursal#".$_SESSION['id_sucursal'];?>" class="form-control text-light" disabled>
                </div>
              </div>
              <div class="col-lg-8">
                <div class="form-group">
                  <label class="text-light">Descripción</label>
                  <textarea style="resize:none;" class="text light form-control" name="descripcion" id="descripcion"
                    rows="3" required></textarea>
                </div>
              </div>
            </div>
            <div>
              <button type="submit" id="bttn_registro_movimiento" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
      <h4 class="text-light text-center">Ultimas Transacciones de la Sucursal#<?= $_SESSION['id_sucursal'];?></h4>
      <br>
      <p class="text-light" style="font-size: 15px;">■ Si desea sacar reporte de todos los movimientos extras de una sucursal en especifica dirijase a Reportes.</p>
      <div class="table-responsive">
        <table class="table table-hover" id="table_id">
          <thead class="thead-dark">
            <tr>
              <th>Fecha</th>
              <th>Empleado</th>
              <th>Tipo Transaccion</th>
              <th>Concepto</th>
              <th>Descripcion</th>
              <th>Total</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
<?php include_once "includes/footer.php"; ?>
<script>
const hoy = new Date();
const options = {
  weekday: 'long',
  year: 'numeric',
  month: 'long',
  day: 'numeric'
};
const impFecha = hoy.toLocaleDateString('es-ES', options);
var datos = <?php echo json_encode($res); ?>;

$(document).ready(function() {
  //REGISTRANDO MOVIMIENTO
  $('#bttn_registro_movimiento').click(function() { //ID del boton del formulario
    var datos = $('#frm_movimiento_extra').serialize(); //ID del formulario
    //alert(datos);
    $.ajax({
      type: "POST",
      url: "negocio/Reg_Mov_Extra.php",
      data: datos,
      success: function(res) {
        $('#lblMensaje').text(res);
        if ($('#lblMensaje').text() == "Se registro correctamente") {
          alert("Se registro correctamente");
          document.getElementById("descripcion").value = "";
          document.getElementById("total").value = "";
          location.reload();
        }
      }
    });
    return false;
  });
  //MOSTRANDO ULTIMOS MOVIMIENTOS
  $('#table_id').DataTable({
    data: datos,
    dom: 'B<lf>rtip',
    buttons: [{
        extend: 'print',
        text: 'Imprimir',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5],
        },
        className: 'btn btn-info mb-2 mt-2 ml-2',
        filename: "Movimientos realizados hasta la fecha -" + impFecha,
        messageTop: "Movimientos realizados hasta la fecha -" + impFecha,
      },
      {
        extend: 'excel',
        text: 'EXCEL',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5],
        },
        className: 'btn btn-info mb-2 mt-2 ml-2',
        filename: "Movimientos realizados hasta la fecha -" + impFecha,
        messageTop: "Movimientos realizados hasta la fecha -" + impFecha,
      },
      {
        extend: 'pdf',
        text: 'PDF',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5],
        },
        className: 'btn btn-info mb-2 mt-2 ml-2',
        filename: "Movimientos realizados hasta la fecha -" + impFecha,
        messageTop: "Movimientos realizados hasta la fecha -" + impFecha,
      }
    ],
    columns: [{
        data: 'fecha'
      },
      {
        data: 'id_empleado'
      },
      {
        data: 'tt_nombre'
      },
      {
        data: 'tc_nombre'
      },
      {
        data: 'descripcion'
      },
      {
        data: 'total'
      }
    ],
    language: {
      "decimal": "",
      "emptyTable": "No hay datos",
      "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
      "infoEmpty": "Mostrando 0 a 0 de 0 registros",
      "infoFiltered": "(Filtro de _MAX_ total registros)",
      "infoPostFix": "",
      "thousands": ",",
      "lengthMenu": "Mostrar _MENU_ registros",
      "loadingRecords": "Cargando...",
      "processing": "Procesando...",
      "search": "Buscar:",
      "zeroRecords": "No se encontraron coincidencias",
      "paginate": {
        "first": "Primero",
        "last": "Ultimo",
        "next": "Siguiente",
        "previous": "Anterior"
      },
      "aria": {
        "sortAscending": ": Activar orden de columna ascendente",
        "sortDescending": ": Activar orden de columna desendente"
      }
    }
  });
});
</script>