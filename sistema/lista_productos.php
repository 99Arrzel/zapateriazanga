<?php include_once "includes/header.php"; 
$res2 = producto::traer_productos_stock_sucursales();
?>
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 text-light">Productos en Todas las Sucursales</h1>
  </div>
  <hr>
  <!-- //================================TABLA PRODUCTOS TODAS SUCURSALES================================ -->
  <div class="row">
    <div id="tb_availables" class="col-12">
      <div class="bg-dark">
        <table class="col-12 table table-dark" id="table_id_pro">
          <thead class="thead-dark">
            <tr>
              <th>ID</th>
              <th>CATEGORIA</th>
              <th>MARCA</th>
              <th>PRODUCTO</th>
              <th>COLOR</th>
              <th>TALLA</th>
              <th>PRECIO</th>
              <th>SUCURSAL</th>
              <th>STOCK</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->
<?php include_once "includes/footer.php"; ?>

<?php if($_SESSION['access']==1 || $_SESSION['access']==3){?>
<script>
const hoy = new Date();
const options = {
  weekday: 'long',
  year: 'numeric',
  month: 'long',
  day: 'numeric'
};
const impFecha = hoy.toLocaleDateString('es-ES', options);
var groupColumn = 7;

var datos2 = <?php echo json_encode($res2); ?>;
var tabla_producto = $('#table_id_pro').DataTable({
  data: datos2,
  dom: 'B<lf>rtip',
  columnDefs: [{
    visible: false,
    targets: groupColumn
  }],
  order: [
    [groupColumn, 'asc']
  ],
  displayLength: 25,
  buttons: [{
      extend: 'print',
      text: 'Imprimir',
      exportOptions: {
        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
      },
      className: 'btn btn-info mb-2 mt-2 ml-2',
      filename: "Productos con stock hasta la fecha -" + impFecha,
      messageTop: "Productos con stock hasta la fecha -" + impFecha,
    },
    {
      extend: 'excel',
      text: 'EXCEL',
      exportOptions: {
        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
      },
      className: 'btn btn-info mb-2 mt-2 ml-2',
      filename: "Productos con stock hasta la fecha -" + impFecha,
      messageTop: "Productos con stock hasta la fecha -" + impFecha,
    },
    {
      extend: 'pdf',
      text: 'PDF',
      exportOptions: {
        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
      },
      className: 'btn btn-info mb-2 mt-2 ml-2',
      filename: "Productos con stock hasta la fecha -" + impFecha,
      messageTop: "Productos con stock hasta la fecha -" + impFecha,
    }
  ],
  columns: [{
      data: 'id'
    },
    {
      data: 'id_categoria'
    },
    {
      data: 'id_marca'
    },
    {
      data: 'nombre'
    },
    {
      data: 'id_color'
    },
    {
      data: 'talla'
    },
    {
      data: 'precio'
    },
    {
      data: 'nombre_sucursal',
    },
    {
      data: 'cantidad',
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
          '<tr class="bg-info group font-weight-bold text-uppercase"><td colspan="8" class="text-light">' + group + '</td></tr>'
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
<?php } ?>
<?php if($_SESSION['access']==2 || $_SESSION['access']== 4){?>
<script>
var datos2 = <?php echo json_encode($res2); ?>;
var groupColumn = 7;

var tabla_producto = $('#table_id_pro').DataTable({
  data: datos2,
  columnDefs: [{
    visible: false,
    targets: groupColumn
  }],
  order: [
    [groupColumn, 'asc']
  ],
  displayLength: 25,
  columns: [{
      data: 'id'
    },
    {
      data: 'id_categoria'
    },
    {
      data: 'id_marca'
    },
    {
      data: 'nombre'
    },
    {
      data: 'id_color'
    },
    {
      data: 'talla'
    },
    {
      data: 'precio'
    },
    {
      data: 'nombre_sucursal',
    },
    {
      data: 'cantidad',
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
          '<tr class="bg-info group font-weight-bold text-uppercase group"><td colspan="8">' + group + '</td></tr>'
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
<?php } ?>