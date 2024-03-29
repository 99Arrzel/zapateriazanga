﻿<?php include_once "includes/header.php"; 
$res = persona::traer_todo_persona_empleado_habilitados();
$res2 = persona::traer_todo_persona_empleado_deshabilitados();					
//=================================== ACTUALIZAR ===================================
/*
  foreach($_POST as $key=>$value){
    $a = strstr($key, 'gua');
    $b = (substr($a, 0, 3)=='gua')? true:false;

    if($b){
      if(trim($_POST['ci']) == "" || trim($_POST['nombre']) == "" || trim($_POST['apPaterno']) == "" ||
      trim($_POST['apMaterno']) == "" || trim($_POST['telefono']) == "" || trim($_POST['direccion']) == ""
      )
      {
        $mensaje = "No deje espacios en blanco.";
      }else{
        $aux = trim($_POST['ci']);
        //$cis = persona::traer_ci_entero();
        //foreach($cis as  $key=>$datos2){
        //	if($aux == $datos2->ci){
        //		$mensaje = "El usuario ya existe";
        //	}
        //}
        if($mensaje != "El usuario ya existe"){
          $persona = new persona;
          //Nombre
          $nombre = ucwords(strtolower($_POST['nombre']));
          $nombre = preg_replace('/\s+/', ' ', $nombre);
          $nombre = ltrim(rtrim($nombre));
          //ApellidoP
          $apPaterno = ucwords(strtolower($_POST['apPaterno']));
          $apPaterno = preg_replace('/\s+/', ' ', $apPaterno);
          $apPaterno = ltrim(rtrim($apPaterno));
          //ApellidoM
          $apMaterno = ucwords(strtolower($_POST['apMaterno']));
          $apMaterno = preg_replace('/\s+/', ' ', $apMaterno);
          $apMaterno = ltrim(rtrim($apMaterno));
          //Insertando
          $persona->id = trim($_POST['id']);
          $persona->ci = $aux;
          $persona->nombre    = $nombre;
          $persona->apPaterno = $apPaterno;
          $persona->apMaterno = $apMaterno;
          $persona->telefono  = trim($_POST['telefono']);
          $persona->direccion = trim($_POST['direccion']);
          $persona->update();
          $mensaje = "Datos Actualizados";
        }else{
          $mensaje = "El usuario ya existe";
        }
      }
    }else{
      $a = strstr($key, 'del');
      $b = (substr($a, 0, 3) == 'del')? true:false;
      if($b){
        $worker = new empleado();
        $user = new usuario();
        $worker->id = trim($_POST['id2']);
        $user->idEmpleado = trim($_POST['id2']);
        $worker->delete_logico();
        $user->delete_logico();
        $mensaje = "Datos Eliminados";
      }
    }
    $a = strstr($key, 'res');
    $b = (substr($a, 0, 3)=='res')? true:false;
    if($b){
      $worker = new empleado();
      $user = new usuario();
      $worker->id = trim($_POST['id2']);
      $user->idEmpleado = trim($_POST['id2']);
      $worker->restaurar();
      $user->restaurar();
      $mensaje = "Datos Restaurados";
    }
  }
*/
?>
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 text-light">Empleados</h1>
    <a href="registro_usuario.php" class="btn btn-primary">Nuevo</a>
  </div>
  <hr>
  <?php 
    $v1 = empleado::contar_empleados_habilitados();
    $v2 = empleado::contar_empleados_deshabilitados();?>
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
              <th>CI</th>
              <th>NOMBRE</th>
              <th>APELLIDO PATERNO</th>
              <th>APELLIDO MATERNO</th>
              <th>TELEFONO</th>
              <th>DIRECCION</th>
              <th>SUELDO</th>
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
              <th>CI</th>
              <th>NOMBRE</th>
              <th>APELLIDO PATERNO</th>
              <th>APELLIDO MATERNO</th>
              <th>TELEFONO</th>
              <th>DIRECCION</th>
              <th>SUELDO</th>
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
    dom: 'B<lf>rtip',
    buttons: [{
        extend: 'print',
        text: 'Imprimir',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7],
        },
        className: 'btn btn-info mb-2 mt-2 ml-2',
        filename: "Empleados habilitados hasta la fecha -" + impFecha,
        messageTop: "Empleados habilitados hasta la fecha -" + impFecha,
      },
      {
        extend: 'excel',
        text: 'EXCEL',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7],
        },
        className: 'btn btn-info mb-2 mt-2 ml-2',
        filename: "Empleados habilitados hasta la fecha -" + impFecha,
        messageTop: "Empleados habilitados hasta la fecha -" + impFecha,
      },
      {
        extend: 'pdf',
        text: 'PDF',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7],
        },
        className: 'btn btn-info mb-2 mt-2 ml-2',
        filename: "Empleados habilitados hasta la fecha -" + impFecha,
        messageTop: "Empleados habilitados hasta la fecha -" + impFecha,
      }
    ],
    columns: [{
        data: 'id'
      },
      {
        data: 'ci'
      },
      {
        data: 'nombre'
      },
      {
        data: 'apPaterno'
      },
      {
        data: 'apMaterno'
      },
      {
        data: 'telefono'
      },
      {
        data: 'direccion'
      },
      {
        data: 'sueldo'
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
		dom: 'B<lf>rtip',
    buttons: [{
        extend: 'print',
        text: 'Imprimir',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7],
        },
        className: 'btn btn-info mb-2 mt-2 ml-2',
        filename: "Empleados deshabilitados hasta la fecha -" + impFecha,
        messageTop: "Empleados deshabilitados hasta la fecha -" + impFecha,
      },
      {
        extend: 'excel',
        text: 'EXCEL',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7],
        },
        className: 'btn btn-info mb-2 mt-2 ml-2',
        filename: "Empleados deshabilitados hasta la fecha -" + impFecha,
        messageTop: "Empleados deshabilitados hasta la fecha -" + impFecha,
      },
      {
        extend: 'pdf',
        text: 'PDF',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7],
        },
        className: 'btn btn-info mb-2 mt-2 ml-2',
        filename: "Empleados deshabilitados hasta la fecha -" + impFecha,
        messageTop: "Empleados deshabilitados hasta la fecha -" + impFecha,
      }
    ],
    columns: [{
        data: 'id'
      },
      {
        data: 'ci'
      },
      {
        data: 'nombre'
      },
      {
        data: 'apPaterno'
      },
      {
        data: 'apMaterno'
      },
      {
        data: 'telefono'
      },
      {
        data: 'direccion'
      },
      {
        data: 'sueldo'
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