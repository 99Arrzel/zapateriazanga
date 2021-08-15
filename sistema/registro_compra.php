<?php include_once "includes/header.php"; 
$res2 = producto::traer_productos_nostock();
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <label id="lblMensaje" class="text-warning h3"><?= $mensaje ?></label>
          <form action="" method="post" autocomplete="off" id="frm_nueva_venta">
            <h4 class="text-left text-light">Datos de la Compra</h4>
            <br>
            <div class="row">
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="text-light">CI Vendedor:</label>
                  <input type="text" id="ci_empleado" name="ci_empleado" class="text-light form-control"
                    value="<?=$_SESSION['ci_empleado'];?>" disabled required>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="text-light">Vendedor:</label>
                  <input type="text" class="text-light form-control" value="<?=$_SESSION['nombre']; ?>" disabled
                    required>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="text-light">Fecha:</label>
                  <input type="text" name="fecha_venta" id="fecha_venta" class="text-light form-control"
                    value="<?= date("m/d/Y"); ?>" disabled required>
                </div>
              </div>
            </div>
            <h4 class="text-left text-light">Productos</h4>
            <div class="row">
              <div class="col-lg-12">
                <div id="acciones_venta" class="form-group">
                  <button data-toggle="modal" data-target=".bd-example-modal-xl-2" class="btn btn-info"
                    id="btn_anular_venta">Seleccionar
                    Productos</button>
                  <button type="submit" class="ml-5 btn btn-primary" id="btn_facturar_venta"><i class="fas fa-save"></i>
                    Generar Compra</button>
                  <a href="lista_productos.php" target="_blank" type="button" class="ml-5 btn btn-warning text-dark"
                    id="btn_listar_productos_sucursales"><i class="fas fa-hospital"></i>
                    Mostrar todos los productos</a>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-sm-1 text-light"><h5>Total: </h5></div>
        <div class="col-sm-3">
          <input class="text-light form-control" id="lbltotal" value = "0">
        </div>
        <div class="col-sm-3 text-light">Bs.</div>
      </div>
      <div class="table-responsive">
        <form action="">
          <table class="table table-hover" id="tb_productos_agregados">
            <thead class="thead-dark">
              <tr>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>TALLA</th>
                <th>PRECIO</th>
                <th>COLOR</th>
                <th>CATEGORIA</th>
                <th>MARCA</th>
                <th>CANTIDAD</th>
                <th>SUBTOTAL</th>
                <th>ACCIÓN</th>
              </tr>
            </thead>
          </table>
          <br>
          <!--<label id="lblTotal" class="text-warning h3"></label>-->
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ================================================MODAL PRODUCTO================================================ -->
<?php buscar_producto_modal(); ?>
<script src="vendor/jquery/jquery.min.js"></script>
<!-- /.container-fluid -->
<?php include_once "includes/footer.php"; ?>
<script>
var datos2 = <?php echo json_encode($res2); ?>;
var sumaTotal = 0;
var i = 1;
var cantActual=1;

function sumar_total (valor) {
  console.log("SE LLAMA"); 
  valor = parseFloat(valor);
  sumaTotal = sumaTotal + valor;
  presio = document.getElementById('txt_campo_1').innerHTML;
  total = document.getElementById('lbltotal').innerHTML;
  if(total == null || total == undefined || total == ""){total = "0";}
  total = total + (parseInt(presio) * parseInt(valor));
  console.log(sumaTotal);
  $("#lbltotal").val(sumaTotal);
  //document.getElementById('lbltotal').innerHTML = parseFloat(valor);
}
function restar_total(valor){
  var lbltotal = $("#lbltotal").val();
  var resta=lbltotal-valor;
  $("#lbltotal").val(resta);
}
//REGISTRANDO COMPRA
$(document).ready(function() {
  $('#btn_facturar_venta').click(function() {
    var data = [];
    var k = 0;
    var filas = $('#tb_productos_agregados tr').length;
    var total = 0;
    var precios = [];
    var cantidades = [];
    var ids = [];
    var longitud_productos = 0;
    $('#tb_productos_agregados tr').each(function(index, tr) {
      var tds = $(tr).find('td');
      longitud_productos = tds.length;
      if (tds.length > 1) {
        data[k] = {
          precio: tds[3].textContent
        }
        ids[k] = {
          id: tds[0].textContent
        }
        precios[k] = {
          precio: tds[3].textContent
        }
        cantidades[k] = {
          cantidad: tds.find("input[type='text']").val()
        }
        total = total + parseFloat(data[k].precio) * parseFloat(cantidades[k].cantidad);
        k++;
      }
    });
    var datos_venta = {
      ci_empleado: document.getElementById("ci_empleado").value,
      totalxD: total,
      cantidad: cantidades,
      precio: precios,
      contador: k,
      id_producto: ids
    };
    console.log(datos_venta);
    if (total > 0) {
      $.ajax({
        type: "POST",
        url: "negocio/Reg_Compra.php",
        data: datos_venta,
        success: function(res) {
          $('#lblMensaje').text(res);
          if ($('#lblMensaje').text() == "Se registro correctamente") {
            alert("Se registro correctamente.");
            //$('#lblTotal').text("Total a pagar: " + total + "Bs.");
            $('#lblTotal').text("0");
            if(res=="Se registro correctamente"){location.reload();}
          }
        }
      });
    } else {
      $('#lblMensaje').text("Rellene todos los datos necesarios porfavor.");
    }
  });
});
//MOSTRANDO PRODUCTOS EN LA TABLA DEL MODAL
var tabla_producto = $('#table_id_pro').DataTable({
  data: datos2,
  columns: [{
      data: 'id'
    },
    {
      data: 'nombre'
    },
    {
      data: 'talla'
    },
    {
      data: 'id_categoria'
    },
    {
      data: 'id_marca'
    },
    {
      data: 'id_color'
    },
    {
      data: 'precio'
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
    url: "negocio/ob_producto.php",
    data: data,
    success: function(res) {
      var aux = JSON.parse(res);
      $("#table_id_pro").DataTable().row(tr).remove().draw();
      //alert(aux);
      //$("#tb_productos_agregados").DataTable().row.add(aux).draw();
      //console.log(aux[1]);
      fila = '<tr id="row' + i + '"><td>' + aux[0] + '</td><td>' + aux[1] + '</td><td>' + aux[2] +
        '</td><td id="txt_campo_1">' + aux[3] + '</td><td>' + aux[4] + '</td><td>' + aux[5] + '</td><td>' + aux[6] +
        '</td><td><input onkeypress="return /[0-9]/i.test(event.key)" type="text" class="text-light form-control" name="control_cantidad" value="1"></td><td>'+aux[3]+'</td><td><button type="button" name="remove" id="btnQuitar"'
        +'onclick="eliminarFila(this)" class="btn btn-danger btn_remove borrar">Quitar</button></td></tr>';
      i++;
      //console.log("algo", fila);
      $('#tb_productos_agregados tr:first').after(fila);

      sumar_total(aux[3]);
    }
  });
});

function eliminarFila(index) {
  var t = $('#table_id_pro').DataTable();
  var rowjQuery = $(index).closest("tr");
  var row_index = rowjQuery[0].rowIndex - 1;
  //var row_index = $(this).closest("tr").index();
  var datostabla = [];
      var k=0;
      var i=0;
      var filas = $('#tb_productos_agregados tr').length;
      var subt=[];

      $('#tb_productos_agregados tr').each(function(indice, tr) {
        //console.log("Entro");
        var tds = $(tr).find('td');
        //console.log(tds);
        if (tds.length > 1) {
          datostabla[k++] = {
                id: tds[0].textContent,
                nombre: tds[1].textContent,
                talla : tds[2].textContent,
                id_categoria : tds[5].textContent,
                id_marca : tds[6].textContent,
                id_color : tds[4].textContent,
                precio : tds[3].textContent,
                cantidad: tds[7].children[0].value
            }
            subt[i++]={subtotal:tds[8].textContent}
            //console.log(k);
        }
    });

    console.log("el indice es "+ row_index);
    console.log("la cantidad de filas "+filas);
      
    console.log(datostabla[row_index].id);
    console.log(datostabla[row_index].nombre);
    console.log("cantidad es "+datostabla[row_index].cantidad);

    console.log("DATOS DE LA TABLA");
    console.log(datostabla[row_index]);
    
    t.row.add(datostabla[row_index]).draw();

    restar_total(parseInt(subt[row_index].subtotal));
    rowjQuery.remove();
}

$('#tb_productos_agregados').keydown(function(e) {
  if (e.ctrlKey || e.altKey || e.keyCode == 13) {
    console.log("presionaste " + e.keyCode);
    var trp=e.target.parentElement.parentElement;
    var precio = trp.children[3].textContent;
    var cant= trp.children[7].children[0].value;
    
    console.log("Subtotal:"+(precio*cant));
    if(cant==0 || cant=="") {
      cant=1;
      trp.children[7].children[0].value=1;
      //console.log("cant"+cant);
    }
    var subtotal = cant*precio;
    trp.children[8].textContent =subtotal;
    
    CalcularTotal();
    e.preventDefault();
    return false;
  }
});
$('#tb_productos_agregados').keypress(function(e) {
  if (e.ctrlKey || e.altKey || e.keyCode == 13) {
    e.preventDefault();
    return false;
  }
});
function CalcularTotal(){
  var datostabla=[];
  var k=0;
  $('#tb_productos_agregados tr').each(function(indice, tr) {
      var tds = $(tr).find('td');
      if (tds.length > 1) {
        datostabla[k++] = {
              subtotal : tds[8].textContent
          }
      }
  });

  var sumatoria=0;
  console.log(datostabla);
  for (let index = 0; index < datostabla.length; index++) {
    sumatoria += parseInt(datostabla[index].subtotal);    
  }
  console.log(sumatoria);
  $("#lbltotal").val(sumatoria);
}
</script>