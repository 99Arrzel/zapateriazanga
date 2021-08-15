<?php include_once "includes/header.php"; 
$res2 = producto::traer_productos_asignar();
$producto_almacen = almacen::traer_almacenes();
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <label id="lblMensaje" class="text-warning h3"><?= $mensaje ?></label>
          <form action="" method="post" autocomplete="off" id="frm_nueva_venta">
            <h4 class="text-left text-light">Productos Comprados sin asignar</h4>
            <br>
            <div class="form-group">
              <label class="text-light">Almacen a asignar:</label>
              <select id="id_almacen" name="id_almacen" class="col-lg-4 bg-dark text-light form-control">
                <?php for($i = 0; $i<count($producto_almacen); $i=$i+1){?>
                <option class="text-light" value='<?= $producto_almacen[$i]->id?>'><?= $producto_almacen[$i]->nombre ?>
                </option>
                <?php } ?>
              </select>
            </div>
            <h4 class="text-left text-light">Productos</h4>
            <div class="row">
              <div class="col-lg-12">
                <div id="acciones_venta" class="form-group">
                  <button data-toggle="modal" data-target=".bd-example-modal-xl-2" class="btn btn-info"
                    id="btn_anular_venta">Seleccionar
                    Productos</button>
                  <button type="submit" class="ml-5 btn btn-primary" id="btn_facturar_venta"><i class="fas fa-save"></i>
                    Asignar Producto</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="table-responsive">
        <form action="">
          <table class="table table-hover" id="tb_productos_agregados">
            <thead class="thead-dark">
              <tr>
                <th>ID PRODUCTO</th>
                <th>CATEGORIA</th>
                <th>MARCA</th>
                <th>NOMBRE</th>
                <th>TALLA</th>
                <th>COLOR</th>
                <th>CANTIDAD TOTAL</th>
                <th>CANTIDAD A ASGINAR</th>
                <th hidden>ID COMPRA</th>
                <th>ACCIÓN</th>
              </tr>
            </thead>
          </table>
          <br>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- ================================================MODAL PRODUCTO================================================ -->
<?php buscar_producto_asignar_modal(); ?>
<script src="vendor/jquery/jquery.min.js"></script>
<!-- /.container-fluid -->
<?php include_once "includes/footer.php"; ?>
<script>
var datos2 = <?php echo json_encode($res2); ?>;
var i = 1;

//REGISTRANDO EN ALMACEN
$(document).ready(function() {
  $('#btn_facturar_venta').click(function() {
    var k = 0;
    var filas = $('#tb_productos_agregados tr').length;
    var cantidades = [];
    var cantidadesaux = [];
    var idscompras = [];
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
        idscompras[k] = {
          id_compra: tds[7].textContent
        }
        k++;
      }
    });
    var datos_venta = {
      cantidad: cantidades,
      cantidadaux: cantidadesaux,
      id_compra: idscompras,
      contador: k,
      id_producto: ids,
      id_almacen: document.getElementById("id_almacen").value,
    };
    //console.log(datos_venta);
    $.ajax({
      type: "POST",
      url: "negocio/Reg_Asignacion.php",
      data: datos_venta,
      success: function(res) {
        $('#lblMensaje').text(res);
        if ($('#lblMensaje').text() == "Se registro correctamente") {
          alert("Se registro correctamente.");
          location.reload();
        }
      }
    });
  });
});
//MOSTRANDO PRODUCTOS EN LA TABLA DEL MODAL
var tabla_producto = $('#table_id_pro').DataTable({
  data: datos2,
  columns: [
    {
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
      data: 'talla'  
    },
    {
      data: 'id_color'  
    },
    {
      data: 'cantidad'
    },
    {
      data: 'id_compra',
      visible: false
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
//AGREGANDO A TABLA TEMPORAL v2.0 GOZU
$('#table_id_pro tbody').on('click', 'button', function(e) {
  var tr = $(this).closest("tr");
  var data = $("#table_id_pro").DataTable().row(tr).data();
  $.ajax({
    type: "POST",
    url: "negocio/ob_producto_asignado.php",
    data: data,
    success: function(res) {
      var aux = JSON.parse(res);
      //alert(res);
      $("#table_id_pro").DataTable().row(tr).remove().draw();
      //alert(aux);
      //$("#tb_productos_agregados").DataTable().row.add(aux).draw();
      console.log(aux[7]);
      fila = '<tr id="row' + i + '"><td class="text-center text-warning font-weight-bold">' + aux[0] + '</td><td>' + aux[4] + '</td><td>' + aux[5] +
        '</td><td>' + aux[1] + '</td><td>' + aux[2] + '</td><td>' +aux[3] + 
        '</td><td class="font-weight-bold text-warning">' +aux[6] + 
        '</td><td hidden class="font-weight-bold text-warning">' +aux[7] + 
        '</td><td><input onkeypress="return /[0-9]/i.test(event.key)" type="text" class="text-light form-control" name="control_cantidad" max="'+aux[6]+'" value="'+aux[6]+'"></td>'+ 
        '</td><td><button type="button" name="remove" id="btnQuitar"' +
        'onclick="eliminarFila(this)" class="btn btn-danger btn_remove borrar">Quitar</button></td></tr>';
      i++;
      //console.log("algo", fila);
      $('#tb_productos_agregados tr:first').after(fila);
    }
  });
});

function eliminarFila(index) {
  var t = $('#table_id_pro').DataTable();
  var rowjQuery = $(index).closest("tr");
  var row_index = rowjQuery[0].rowIndex - 1;
  //var row_index = $(this).closest("tr").index();
  var datostabla = [];
  var k = 0;
  var i = 0;
  var filas = $('#tb_productos_agregados tr').length;

  $('#tb_productos_agregados tr').each(function(indice, tr) {
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
      console.log(datostabla[k]);
    }
  });

  console.log("el indice es " + row_index);
  console.log("la cantidad de filas " + filas);

  console.log(datostabla[row_index].id);
  console.log(datostabla[row_index].nombre);
  console.log("cantidad es " + datostabla[row_index].cantidad);

  console.log("DATOS DE LA TABLA");
  console.log(datostabla[row_index]);

  t.row.add(datostabla[row_index]).draw();

  rowjQuery.remove();
}

$('#tb_productos_agregados').keypress(function(e) {
  if (e.ctrlKey || e.altKey || e.keyCode == 13) {
    e.preventDefault();
    return false;
  }
});

</script>