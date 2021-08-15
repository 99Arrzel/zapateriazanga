<?php include_once "includes/header.php"; 
date_default_timezone_set('America/La__');
if(isset($_POST['bttn_nuevo_reporte']))
{
  $fecha_inicio = $_POST['fecha_inicio'];
	$fecha_fin = $_POST['fecha_fin'];
  $num_sucursal = $_POST['num_sucursal'];
	switch($_POST['tipo_reporte']){
		case 0:
			$res2 = venta::traer_ventas_realizadas_fechas($fecha_inicio, $fecha_fin, $num_sucursal);
      if($num_sucursal == 0)
      $mensaje = "Reporte de V̲E̲N̲T̲A̲ generado desde ".$fecha_inicio." hasta ".$fecha_fin." <br><br> TODAS LAS SUCURSALES";
      else
			$mensaje = "Reporte de V̲E̲N̲T̲A̲ generado desde ".$fecha_inicio." hasta ".$fecha_fin." <br><br> SUCURSAL#".$num_sucursal;
			break;
		case 1:
			$res2 = movimiento::traer_ultimos_movimientos_compras_fechas($fecha_inicio, $fecha_fin, $num_sucursal);
			if($num_sucursal == 0)
      $mensaje = "Reporte de C̲O̲M̲P̲R̲A̲ generado desde ".$fecha_inicio." hasta ".$fecha_fin." <br><br> TODAS LAS SUCURSALES";
			else
      $mensaje = "Reporte de C̲O̲M̲P̲R̲A̲ generado desde ".$fecha_inicio." hasta ".$fecha_fin." <br><br> SUCURSAL#".$num_sucursal;
			break;
		case 2:
			$res2 = movimiento::traer_ultimos_movimientos_extras_fechas($fecha_inicio, $fecha_fin, $num_sucursal);
			if($num_sucursal == 0)
      $mensaje = "Reporte de G̲A̲S̲T̲O̲S̲ E̲X̲T̲R̲A̲S̲ generado desde ".$fecha_inicio." hasta ".$fecha_fin." <br><br> TODAS LAS SUCURSALES";
      else
      $mensaje = "Reporte de G̲A̲S̲T̲O̲S̲ E̲X̲T̲R̲A̲S̲ generado desde ".$fecha_inicio." hasta ".$fecha_fin." <br><br> SUCURSAL#".$num_sucursal;
      break;	
	}
}
?> 
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <div class="form-group">
        <h4 class="text-center text-light">Reportes</h4>
      </div>
      <div class="card">
        <div class="card-body">
          <form method="post" name="frm_nuevo_reporte" id="frm_nuevo_reporte">
            <input type="hidden" name="action" value="addCliente">
            <input type="hidden" id="idcliente" value="1" name="idcliente" required>
            <div class="row">
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="text-light">Tipo de Reporte:</label>
                  <select id="tipo_reporte" name="tipo_reporte" class="bg-dark text-light form-control">
                    <option value="0">Ventas productos</option>
                    <option value="1">Compras productos</option>
                    <option value="2">Movimientos extras</option>
                  </select>
                </div>
              </div>
							<div class="col-lg-4">
                <div class="form-group">
                  <label class="text-light">Sucursal:</label>
                  <select id="num_sucursal" name="num_sucursal" class="bg-dark text-light form-control">
                    <option selected value="0">General</option>
                    <option value="1">Sucursal #1</option>
                    <option value="2">Sucursal #2</option>
                  </select>
                </div>
              </div>
						</div>
						<div class="row">
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="text-light">Desde:</label>
                  <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control"
                    max="<?=date("Y-m-d");?>" required>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="text-light">Hasta:</label>
                  <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" max="<?=date("Y-m-d");?>"
                    required>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-lg-6">
                <div id="acciones_venta" class="form-group">
                  <button type="submit" class="btn btn-primary" id="bttn_nuevo_reporte" name="bttn_nuevo_reporte"><i
                      class="fas fa-save"></i> Generar
                    Reporte</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <h4 class="text-left text-warning"><?=$mensaje?></h4>
      <br>
      <?php 
				switch($_POST['tipo_reporte']){
					case 0:
            if($_POST['num_sucursal'] == 0){
              echo'
              <div class="table-responsive">
                <table class="table table-hover" id="Ventas_Todo">
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
              '; 
            }
            else{
              echo'
              <div class="table-responsive">
                <table class="table table-hover" id="Ventas_Especifico">
                  <thead class="thead-dark">
                    <tr>
                      <th>Fecha</th>
                      <th>ID Venta</th>
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
              '; 
            }
						break;
					case 1:
            if($_POST['num_sucursal'] == 0){
              echo'
              <div class="table-responsive">
                <table class="table table-hover" id="Compras_Todo">
                  <thead class="thead-dark">
                    <tr>
                      <th>Fecha</th>
                      <th>ID Compra</th>
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
              '; 
            }else{
              echo'
              <div class="table-responsive">
                <table class="table table-hover" id="Compras_Especifico">
                  <thead class="thead-dark">
                    <tr>
                      <th>Fecha</th>
                      <th>ID Compra</th>
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
              '; 
            }
						break;
					case 2:
            if($_POST['num_sucursal'] == 0){
              echo'
              <div class="table-responsive">
                <table class="table table-hover" id="Mov_Todo">
                  <thead class="thead-dark">
                    <tr>
                      <th>Sucursal</th>
                      <th>Fecha</th>
                      <th>Empleado</th>
                      <th>Concepto</th>
                      <th>Tipo Transaccion</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                </table>
              </div>
              ';
            }else{
              echo'
              <div class="table-responsive">
                <table class="table table-hover" id="Mov_Especifico">
                  <thead class="thead-dark">
                    <tr>
                      <th>Fecha</th>
                      <th>Empleado</th>
                      <th>Concepto</th>
                      <th>Tipo Transaccion</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                </table>
              </div>
              ';
            } 
						break;	
				}
			?>
    </div>
  </div>
</div>
<!-- /.container-fluid -->
<?php include_once "includes/footer.php";?>
<script>
const hoy = new Date();
const options = {
  weekday: 'long',
  year: 'numeric',
  month: 'long',
  day: 'numeric'
};
const impFecha = hoy.toLocaleDateString('es-ES', options);
var datos2 = <?php echo json_encode($res2); ?>;
var groupColumn = 0;
//===================================VENTAS===================================
<?php if($_POST['tipo_reporte'] == 0 && $_POST['num_sucursal'] == 0){?>
var groupColumn = 2;
var testArray = [0,1,2];
var tabla_producto = $('#Ventas_Todo').DataTable({
  data: datos2,
  order: [[2, 'asc'], [0, 'asc']],
  columnDefs: [ {
    targets: [ 0, 2, 1],
    visible: false
  } ],
  displayLength: 25,
  dom: 'B<lf>rtip',
  buttons: [{
      extend: 'print',
      text: 'Imprimir',
      customize: function(win) {
        $(win.document.body).find('table').find('td').css('color', 'black');
      },
      exportOptions: {
				columns: [0,2,3, 4, 5, 6, 7, 8],
        grouped_array_index:['id_venta']
        //grouped_array_index: ['id_sucursal']
      },
      
      className: 'btn btn-info mb-2 mt-2 ml-2',
      filename: "Ventas desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
      messageTop: "Ventas desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
    },
    {//EXCEL
      extend: 'excel',
      text: 'EXCEL',
      exportOptions: {
        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
      },
      className: 'btn btn-info mb-2 mt-2 ml-2',
      filename: "Ventas desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
      messageTop: "Ventas desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
    },
    {//PDF
      extend: 'pdf',
      text: 'PDF',
      footer: 'true',
      header: 'true',
      orientation: 'portrait',
      exportOptions: {
        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
      },
      className: 'btn btn-info mb-2 mt-2 ml-2',
      filename: "Ventas desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
      messageTop: "Ventas desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
    }
  ],
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
<?php }elseif ($_POST['tipo_reporte'] == 0 && $_POST['num_sucursal'] != 0) {?>
var tabla_producto = $('#Ventas_Especifico').DataTable({
  data: datos2,
  order: [[1, 'asc'], [0, 'asc']],
  columnDefs: [ {
    targets: [ 0, 1],
    visible: false
  } ],
  displayLength: 25,
  dom: 'B<lf>rtip',
  buttons: [{
      extend: 'print',
      text: 'Imprimir',
      customize: function(win) {
        $(win.document.body).find('table').find('td').css('color', 'black');
      },
      exportOptions: {
				columns: [0, 1, 2, 3, 4, 5, 6, 7]
      },
      className: 'btn btn-info mb-2 mt-2 ml-2',
      filename: "Ventas desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
      messageTop: "Ventas desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
    },
    {
      extend: 'excel',
      text: 'EXCEL',
      exportOptions: {
        columns: [0, 1, 2, 3, 4, 5, 6, 7]
      },
      className: 'btn btn-info mb-2 mt-2 ml-2',
      filename: "Ventas desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
      messageTop: "Ventas desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
    },
    {
      extend: 'pdf',
      text: 'PDF',
      footer: 'true',
      header: 'true',
      orientation: 'portrait',
      exportOptions: {
        columns: [0, 1, 2, 3, 4, 5, 6, 7]
      },
      className: 'btn btn-info mb-2 mt-2 ml-2',
      filename: "Ventas desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
      messageTop: "Ventas desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
    }
  ],
  columns: [{
      data: 'fecha',
    },
    {
      data: 'id_venta'
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
<?php } ?>
//===================================COMPRAS===================================
<?php if($_POST['tipo_reporte'] == 1 && $_POST['num_sucursal'] == 0){?>
var groupColumn = 2;
var tabla_producto = $('#Compras_Todo').DataTable({
  data: datos2,
  order: [[2, 'asc'], [0, 'asc']],
  columnDefs: [ {
    targets: [ 0, 2, 1],
    visible: false
  } ],
  displayLength: 25,
  dom: 'B<lf>rtip',
  buttons: [{
      extend: 'print',
      text: 'Imprimir',
      customize: function(win) {
        $(win.document.body).find('table').find('td').css('color', 'black');
      },
      exportOptions: {
        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
      },
      className: 'btn btn-info mb-2 mt-2 ml-2',
      filename: "Compras desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
      messageTop: "Compras desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
    },
    {
      extend: 'excel',
      text: 'EXCEL',
      exportOptions: {
        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
      },
      className: 'btn btn-info mb-2 mt-2 ml-2',
      filename: "Compras desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
      messageTop: "Compras desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
    },
    {
      extend: 'pdf',
      text: 'PDF',
      exportOptions: {
        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
      },
      className: 'btn btn-info mb-2 mt-2 ml-2',
      filename: "Compras desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
      messageTop: "Compras desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
    }
  ],
  columns: [
		{
      data: 'fecha',
    },
    {
      data: 'id_compra',
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
          '<tr class="group bg-info font-weight-bold"><td colspan="8">' + group + '</td></tr>'
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
<?php }elseif ($_POST['tipo_reporte'] == 1 && $_POST['num_sucursal'] != 0) {?>
var tabla_producto = $('#Compras_Especifico').DataTable({
  data: datos2,
  order: [[1, 'asc'], [0, 'asc']],
  columnDefs: [ {
    targets: [ 0, 1],
    visible: false
  } ],
  displayLength: 25,
  dom: 'B<lf>rtip',
  buttons: [{
      extend: 'print',
      text: 'Imprimir',
      customize: function(win) {
        $(win.document.body).find('table').find('td').css('color', 'black');
      },
      exportOptions: {
        columns: [0, 1, 2, 3, 4, 5, 6, 7],
      },
      className: 'btn btn-info mb-2 mt-2 ml-2',
      filename: "Compras desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
      messageTop: "Compras desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
    },
    {
      extend: 'excel',
      text: 'EXCEL',
      exportOptions: {
        columns: [0, 1, 2, 3, 4, 5, 6, 7],
      },
      className: 'btn btn-info mb-2 mt-2 ml-2',
      filename: "Compras desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
      messageTop: "Compras desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
    },
    {
      extend: 'pdf',
      text: 'PDF',
      exportOptions: {
        columns: [0, 1, 2, 3, 4, 5, 6, 7],
      },
      className: 'btn btn-info mb-2 mt-2 ml-2',
      filename: "Compras desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
      messageTop: "Compras desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
    }
  ],
  columns: [
		{
      data: 'fecha',
    },
    {
      data: 'id_compra',
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
<?php } ?>
//===================================MOVIMIENTOS-EXTRAS===================================
<?php if($_POST['tipo_reporte'] == 2 && $_POST['num_sucursal'] == 0){?>
var tabla_producto = $('#Mov_Todo').DataTable({
  data: datos2,
  order: [[1, 'asc'], [0, 'asc']],
  columnDefs: [ {
    targets: [ 0, 1],
    visible: false
  } ],
  displayLength: 25,
  dom: 'B<lf>rtip',
  buttons: [{
      extend: 'print',
      text: 'Imprimir',
      exportOptions: {
        columns: [0, 1, 2, 3, 4, 5],
      },
      customize: function(win) {
        $(win.document.body).find('table').find('td').css('color', 'black');
      },
      className: 'btn btn-info mb-2 mt-2 ml-2',
      filename: "Movimientos extras desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
      messageTop: "Movimientos extras desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
    },
    {
      extend: 'excel',
      text: 'EXCEL',
      exportOptions: {
        columns: [0, 1, 2, 3, 4, 5],
      },
      className: 'btn btn-info mb-2 mt-2 ml-2',
      filename: "Movimientos extras desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?> <?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
      messageTop: "Movimientos extras desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?> <?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
    },
    {
      extend: 'pdf',
      text: 'PDF',
      exportOptions: {
        columns: [0, 1, 2, 3, 4, 5],
      },
      className: 'btn btn-info mb-2 mt-2 ml-2',
      filename: "Movimientos extras desde - <?= $fecha_inicio;?> - hasta <?= $fecha_fin;?> <?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
      messageTop: "Movimientos extras desde - <?= $fecha_inicio;?> - hasta <?= $fecha_fin;?> <?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
    }
  ],
  columns: [
    {
      data: 'id_sucursal'
    },
    {
      data: 'fecha'
    },
    {
      data: 'id_empleado'
    },
    {
      data: 'tc_nombre'
    },
    {
      data: 'tt_nombre'
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
          '<tr class="group bg-info font-weight-bold"><td colspan="5">' + group + '</td></tr>'
        );
        last = group;
      }
    });
    api.column(1, {
      page: 'current'
    }).data().each(function(group, i) {
      if (last !== group) {
        $(rows).eq(i).before(
          '<tr class="group" style=background-color:#171a21;><td colspan="9">' + group + '</td></tr>'
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
<?php }elseif ($_POST['tipo_reporte'] == 2 && $_POST['num_sucursal'] != 0) {?>
var tabla_producto = $('#Mov_Especifico').DataTable({
  data: datos2,
  columnDefs: [{
    visible: false,
    targets: groupColumn
  }],
  order: [
    [groupColumn, 'asc']
  ],
  displayLength: 25,
  dom: 'B<lf>rtip',
  buttons: [{
      extend: 'print',
      text: 'Imprimir',
      customize: function(win) {
        $(win.document.body).find('table').find('td').css('color', 'black');
      },
      exportOptions: {
        columns: [0, 1, 2, 3, 4],
      },
      className: 'btn btn-info mb-2 mt-2 ml-2',
      filename: "Movimientos extras desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
      messageTop: "Movimientos extras desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
    },
    {
      extend: 'excel',
      text: 'EXCEL',
      exportOptions: {
        columns: [0, 1, 2, 3, 4],
      },
      className: 'btn btn-info mb-2 mt-2 ml-2',
      filename: "Movimientos extras desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
      messageTop: "Movimientos extras desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
    },
    {
      extend: 'pdf',
      text: 'PDF',
      exportOptions: {
        columns: [0, 1, 2, 3, 4],
      },
      className: 'btn btn-info mb-2 mt-2 ml-2',
      filename: "Movimientos extras desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
      messageTop: "Movimientos extras desde - <?= $fecha_inicio;?> hasta <?= $fecha_fin;?><?php if($num_sucursal == 0)echo"TODAS LAS SUCURSALES";else echo"SUCURSAL#".$num_sucursal;?>",
    }
  ],
  columns: [
    {
      data: 'fecha'
    },
    {
      data: 'id_empleado'
    },
    {
      data: 'tc_nombre'
    },
    {
      data: 'tt_nombre'
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
          '<tr class="group" style=background-color:#171a21;><td colspan="9">' + group + '</td></tr>'
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
<?php } ?>
</script>
