<?php include_once "includes/header.php"; 
$res2 = venta::Ventas_DosSemanas();
?>
<!-- Begin Page Content -->
<div class="container-fluid">
  <label class="text-warning h3" id="lblMensaje"><?= $dia;?></label>
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 text-light">Ventas en las ultimas dos semanas</h1>
  </div>
  <hr>
  <!-- //================================TABLA VENTAS ULTIMOS 15 DIAS================================ -->
  <div class="row">
    <div id="tb_availables" class="col-12">
      <div class="bg-dark">
        <table class="table table-hover" id="Ventas_DosSemanas">
          <thead class="thead-dark">
            <tr>
              <th>Fecha</th>
              <th>ID Venta</th>
              <th>Sucursal</th>
              <th>Empleado</th>
              <th>Categoria</th>
              <th>Marca</th>
              <th>Nombre</th>
              <th>Cantidad</th>
              <th>Total</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->
<?php include_once "includes/footer.php"; ?>
<script>
var groupColumn = 2;
var datos2 = <?php echo json_encode($res2); ?>;
var tabla_producto = $('#Ventas_DosSemanas').DataTable({
  data: datos2,
  order: [[2, 'asc'], [0, 'asc']],
  columnDefs: [ {
    targets: [ 0, 2, 1],
    visible: false
  } ],
  displayLength: 25,
  columns: [{
      data: 'fecha'
    },
    {
      data: 'id_venta'
    },
		{
      data: 'id_sucursal'
    },
    {
      data: 'id_empleado'
    },
    {
      data: 'categoria'
    },
    {
      data: 'marca'
    },
    {
      data: 'id_producto'
    },
    {
      data: 'cantidad'
    },
    {
      data: 'total'
    }
  ],
  drawCallback: function(settings) {
    var api = this.api();
    var rows = api.rows({
      page: 'current'
    }).nodes();
    var last = null;
    api.column(groupColumn, {
      page: 'current'
    }).data().each(function(group, i) {
      if (last !== group) {
        $(rows).eq(i).before(
          '<tr class="group bg-info font-weight-bold"><td colspan="9">' + group + '</td></tr>'
        );
        last = group;
      }
    });
    api.column(0, {
      page: 'current'
    }).data().each(function(group, i) {
      if (last !== group) {
        $(rows).eq(i).before(
          '<tr class="group" style=background-color:#171a21;><td colspan="9">' + group + '</td></tr>'
        );
        last = group;
      }
    });
    api.column(1, {
      page: 'current'
    }).data().each(function(group, i) {
      if (last !== group) {
        $(rows).eq(i).before(
          '<tr class="group text-center font-weight-bold" style=background-color:#2a475e;><td colspan="9">' + group + '</td></tr>'
        );
        last = group;
      }
    });
  },
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
</script>
