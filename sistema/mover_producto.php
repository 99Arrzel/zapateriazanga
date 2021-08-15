<?php include_once "includes/header.php";
if(isset($_POST['btn_buscar_almacen'])){
  $id_almacen = $_POST['id_almacen'];
  $res2 = producto::traer_productos_almacen($id_almacen);
}
$producto_almacen = almacen::traer_almacenes();
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <form action="" method="post" autocomplete="off" id="frm_mover">
            <h4 class="text-left text-light">Mover productos entre sucursales</h4>
            <br>
            <div class="form-group">
              <label class="text-light">Seleccione el almacen: </label>
              <div class="row">
                <br>
                <select id="id_almacen" name="id_almacen" class="col-lg-4 bg-dark text-light form-control ml-3">
                  <?php for($i = 0; $i<count($producto_almacen); $i=$i+1){?>
                  <option class="text-light" value='<?= $producto_almacen[$i]->id?>'>
                    <?= $producto_almacen[$i]->nombre ?>
                  </option>
                  <?php } ?>
                </select>
                <button class="ml-3 btn btn-info" type="submit" id="btn_buscar_almacen" name="btn_buscar_almacen">Cargar Productos</button>
                <a href="lista_productos.php" target="_blank" type="button" class="ml-5 btn btn-warning text-dark"
                    id="btn_listar_productos_sucursales"><i class="fas fa-hospital"></i>
                    Mostrar todos los productos</a>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!--===============================TABLA-PRODUCTOS-CARGADOS===============================-->
      <h4 class="text-left text-light">Productos del Almacen#<?= $id_almacen;?></h4>
      <div class="table-responsive">
        <form action="">
          <table class="table table-hover" id="tb_productos_cargados">
            <thead class="thead-dark">
              <tr>
                <th>ID PRODUCTO</th>
                <th>CATEGORIA</th>
                <th>MARCA</th>
                <th>NOMBRE</th>
                <th>TALLA</th>
                <th>COLOR</th>
                <th>CANTIDAD TOTAL</th>
                <th>ACCIÓN</th>
              </tr>
            </thead>
          </table>
          <br>
        </form>
      </div>
      
      <!--===============================TABLA-PRODUCTOS-AGREGADOS===============================-->
      <div class="card">
        <div class="card-body">
          <form action="" method="post" autocomplete="off" id="frm_mover">
            <div class="form-group">
              <label class="text-light">Seleccione el almacen de destino: </label>
              <div class="row">
                <select id="id_almacenaux" name="id_almacenaux" class="col-lg-4 bg-dark text-light form-control ml-3">
                  <?php for($i = 0; $i<count($producto_almacen); $i=$i+1){?>
                  <option class="text-light" value='<?= $producto_almacen[$i]->id?>'>
                    <?= $producto_almacen[$i]->nombre ?>
                  </option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </form>
          <label id="lblMensaje" class="text-warning h3"><?= $mensaje ?></label>
        </div>
      </div>
      <h4 class="text-left text-light">Productos seleccionados:</h4>
      <div class="table-responsive">
        <form method="POST">
          <table class="table table-hover bg-dark" id="tb_productos_agregados">
            <thead class="thead-dark">
              <tr>
                <th>ID PRODUCTO</th>
                <th>CATEGORIA</th>
                <th>MARCA</th>
                <th>NOMBRE</th>
                <th>TALLA</th>
                <th>COLOR</th>
                <th>CANTIDAD TOTAL</th>
                <th>CANTIDAD A MOVER</th>
                <th>ACCIÓN</th>
              </tr>
            </thead>
          </table>
          <br>
        </form>
      </div> 
      <div class="card">
        <div class="card-body">
          <form action="" method="POST">
            <div class="row">
              <div class="mt-2 col-lg-12">
                <div id="acciones_venta" class="form-group">
                  <button type="submit" class="btn btn-primary" id="btn_mover"><i class="fas fa-save"></i>
                    Mover Productos</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="vendor/jquery/jquery.min.js"></script>
<!-- /.container-fluid -->
<?php include_once "includes/footer.php"; ?>
<script>
var datos2 = <?php echo json_encode($res2); ?>;
var i = 1;
//MOVIENDO PRODUCTOS DE ALMACEN
$(document).ready(function() {
  $('#btn_mover').click(function() {
    var k = 0;
    var filas = $('#tb_productos_agregados tr').length;
    var cantidades = [];
    var cantidadesaux = [];
    var ids = [];
    var longitud_productos = 0;
    $('#tb_productos_agregados tr').each(function(index, tr) {
      var tds = $(tr).find('td');
      longitud_productos = tds.length;
      if (tds.length > 1) {
        ids[k] = {
          id: tds[0].textContent
        }
        cantidadesaux[k] = {
          cantidadaux: tds[6].textContent
        }
        cantidades[k] = {
          cantidad: tds.find("input[type='text']").val()
        }
        k++;
      }
    });
    //console.log(values(ids));
    var datos_venta = {
      cantidad: cantidades,
      cantidadaux: cantidadesaux,
      contador: k,
      id_producto: ids,
      id_almacen: document.getElementById("id_almacen").value,
      id_almacenaux: document.getElementById("id_almacenaux").value
    };
    console.log(datos_venta);
    //alert();
    //alert("a");
    $.ajax({
      type: "POST",
      url: "negocio/Reg_Movimiento_Almacen.php",
      data: datos_venta,
      success: function(res) {
        $('#lblMensaje').text(res);
        if ($('#lblMensaje').text() == "Se movio correctamente") {
          alert("Se movio correctamente");
          location.reload();
        }
      }
    });
    return false;
  });
});
//MOSTRANDO PRODUCTOS CARGADOS EN LA TABLA
$('#tb_productos_cargados').DataTable({
  data: datos2,
  columns: [{
      data: 'id',
      className: 'text-warning font-weight-bold'
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
      data: 'talla'
    },
    {
      data: 'id_color'
    },
    {
      data: 'cantidad',
      className: 'text-warning font-weight-bold'
    },
    {
      data: null,
      defaultContent: "<button type='button' class='btn btn-info'>Seleccionar</button>"
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
//AGREGANDO A TABLA TEMPORAL
$('#tb_productos_cargados tbody').on('click', 'button', function(e) {
  var tr = $(this).closest("tr");
  var data = $("#tb_productos_cargados").DataTable().row(tr).data();
  $.ajax({
    type: "POST",
    url: "negocio/ob_producto_mover.php",
    data: data,
    success: function(res) {
      var aux = JSON.parse(res);
      //alert(res);
      $("#tb_productos_cargados").DataTable().row(tr).remove().draw();
      //alert(aux);
      //$("#tb_productos_agregados").DataTable().row.add(aux).draw();
      //console.log(aux[7]);
      fila = '<tr id="row' + i + '"><td class="text-center text-warning font-weight-bold">' + aux[0] +
        '</td><td>' + aux[4] + '</td><td>' + aux[5] +
        '</td><td>' + aux[1] + '</td><td>' + aux[2] + '</td><td>' + aux[3] +
        '</td><td class="font-weight-bold text-warning">' + aux[6] +
        '</td><td><input onkeypress="return /[0-9]/i.test(event.key)" type="text" class="text-light form-control" name="control_cantidad" max="' +
        aux[6] + '" value="' + aux[6] + '"></td>' +
        '</td><td><button type="button" name="remove" id="btnQuitar"' +
        'onclick="eliminarFila(this)" class="btn btn-danger btn_remove borrar">Quitar</button></td></tr>';
      i++;
      //console.log("algo", fila);
      $('#tb_productos_agregados tr:first').after(fila);
    }
  });
});

function eliminarFila(index) {
  var t = $('#tb_productos_cargados').DataTable();
  var rowjQuery = $(index).closest("tr");
  var row_index = rowjQuery[0].rowIndex - 1;
  //var row_index = $(this).closest("tr").index();
  var datostabla = [];
  var k = 0;
  var i = 0;
  var filas = $('#tb_productos_agregados tr').length;
  $('#tb_productos_cargados tr').each(function(indice, tr) {
    //console.log("Entro");
    var tds = $(tr).find('td');
    //console.log(tds);
    if (tds.length > 1) {
      datostabla[k++] = {
        id: tds[0].textContent,
        nombre: tds[1].textContent,
        talla: tds[2].textContent,
        id_color: tds[3].textContent,
        id_categoria: tds[4].textContent,
        id_marca: tds[5].textContent,
        cantidad: tds[6].textContent
      }
      //console.log(datostabla[k]);
    }
  });
  t.row.add(datostabla[row_index]).draw();
  rowjQuery.remove();
}

$('#tb_productos_cargados').keypress(function(e) {
  if (e.ctrlKey || e.altKey || e.keyCode == 13) {
    e.preventDefault();
    return false;
  }
});
</script>