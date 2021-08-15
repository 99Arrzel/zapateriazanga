<?php include_once "includes/header.php"; 
$res = color::traer_colores_habilitados();
$res2 = color::traer_colores_deshabilitados();
?>
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 text-light">Colores</h1>
    <a href="registro_colores.php" class="btn btn-primary">Nuevo</a>
  </div>
  <hr>
  <?php 
    $v1 = color::contar_colores_habilitados();
    $v2 = color::contar_colores_deshabilitados();?>
  <?php filtro($v1, $v2);?>
  <!-- //================================TABLA HABILITADOS================================ -->
  <hr id="hr_hab_sep">
  <label id="lbl_hab" class="text-light" for="">Habilitados: </label>
  <div class="row">
    <div id="tb_availables" class="col-12">
      <div class="bg-dark">
        <table class="col-12 table table-dark" id="table_id">
          <thead class="thead-dark">
            <tr>
              <th>ID</th>
              <th>NOMBRE</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <!-- //================================TABLA DESHABILITADOS================================ -->
  <hr id="hr_des_sep">
  <label id="lbl_des" class="text-light" for="">Deshabilitados: </label>
  <div class="row">
    <div id="tb_unavailables" class="col-12">
      <div class="bg-dark">
        <table class="col-12 table table-dark" id="table_id_un">
          <thead class="thead-dark">
            <tr>
              <th>ID</th>
              <th>NOMBRE</th>
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
const hoy = new Date();
const options = {
  weekday: 'long',
  year: 'numeric',
  month: 'long',
  day: 'numeric'
};
const impFecha = hoy.toLocaleDateString('es-ES', options);
//================================TABLA HABILITADOS================================
var datos = <?php echo json_encode($res); ?>;
$(document).ready(function() {
  $('#table_id').DataTable({
    data: datos,
    columns: [{
        data: 'id'
      },
      {
        data: 'nombre'
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
//================================TABLA DESHABILITADOS================================
var datos2 = <?php echo json_encode($res2); ?>;
$(document).ready(function() {
  $('#table_id_un').DataTable({
    data: datos2,
    columns: [{
        data: 'id'
      },
      {
        data: 'nombre'
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