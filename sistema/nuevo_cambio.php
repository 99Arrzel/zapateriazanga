<?php include_once "includes/header.php";
$res2 = producto::traer_productos_stock($_SESSION['id_sucursal']);
?>
<!-- Es, comparar res2 con los resultados del id de la venta y quitar los que ya existan -->
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 text-light">Registrar Cambio - LinkTruco</h1>
    <a href="lista_ventas_realizadas.php" target="_blank" class="btn btn-primary font-weight-bold">Listar Ultimas
      Ventas</a>
  </div>
  <!-- Content Row -->
  <div class="row">
    <div class="col-lg-6 m-auto">
      <div class="card">
        <div class="card-header bg-primary text-white font-weight-bold">
          Registrar Cambio
        </div>
        <div class="card-body" id="mcform">
          <div class="form-group">
            <h3 class="text-light">Buscar Venta</h3>
            <p class="text-light" style="font-size: 15px;">■ Coloque el numero de venta realizada y presione Enter.</p>
            <p class="text-light" style="font-size: 15px;">■ Recuerde que la venta debe ser dentro del plazo de las
              ultimas dos semanas.</p>
          </div>
          <div class="form-group">
            <label for="num_venta" class="text-light">#Numero de Venta</label>
            <input class="form-control" name="num_venta" id="num_venta" onkeypress="return /[0-9-]/i.test(event.key)"
              type="number" maxlength="8" />
          </div>
          <h3 class="text-light">Venta</h3>
          <form action="" method="post" autocomplete="off" id="frm_reg_cliente">
            <label class="text-warning h3" id="lblMensaje"></label>
            <div class="form-group">
              <label for="ci" class="text-light">Numero de Venta:</label>
              <input class="form-control text-light" type="text" name="id_venta" id="idVenta"
                onkeypress="return /[0-9-]/i.test(event.key)" disabled>
            </div>
            <div class="form-group">
              <label for="nombre_empleado" class="text-light">Nombre Empleado</label>
              <input type="text" onkeypress="return /[a-z ]/i.test(event.key)" class="form-control text-light"
                name="nombre_empleado" id="nombre_empleado" disabled>
            </div>
            <div class="form-group">
              <label for="fecha_venta" class="text-light">Fecha</label>
              <input type="text" onkeypress="return /[a-z ]/i.test(event.key)" class="form-control text-light"
                name="fecha_venta" id="fecha_venta" disabled>
            </div>
            <div class="form-group">
              <label for="total_venta" class="text-light">Total</label>
              <input type="text" onkeypress="return /[a-z ]/i.test(event.key)" class="form-control text-light"
                name="total_venta" id="total_venta" disabled>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="card-header bg-primary text-white font-weight-bold">
    Productos de la venta:
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="table-responsive">
        <table class="table table-hover" id="Ventas_Todo">
          <thead class="thead-dark">
            <tr>
              <th>ID</th>
              <th>CATEGORIA</th>
              <th>MARCA</th>
              <th>NOMBRE</th>
              <th>CANTIDAD</th>
              <th>CANTIDAD A DEVOLVER</th>
              <th>PRECIO</th>
              <th hidden>ACCIÓN</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <div class="row mt-3 mb-3">
    <button data-toggle="modal" data-target=".bd-example-modal-xl-2" class="col-ml-2  ml-3 btn btn-info"
      id="btn_anular_venta">
      Seleccionar Productos
    </button>
    <div hidden class="col-sm-1 text-light">
      <h5>Total: </h5>
    </div>
    <div hidden class="col-sm-2">
      <input disabled class="text-light form-control" id="lbltotal" value="0">
    </div>
    <div hidden class="col-sm-1 text-light">Bs.</div>
    <div class="col-sm-1 text-light">
      <h5>Total: </h5>
    </div>
    <div class="col-sm-2">
      <input disabled class="text-light form-control" id="lblcambio" value="0">
    </div>
    <div class="col-sm-1 text-light">Bs.</div>
  </div>
  <label id="lblMensaje2" class="text-warning h3"><?= $mensaje ?></label>
  <div>
  </div>
  <!-- ================================================MODAL PRODUCTO================================================ -->
  <?php buscar_producto_modal(); ?>
  <div class="card-header bg-primary text-white font-weight-bold">
    Seleccione los productos a cambiar:
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="table-responsive">
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
              <th>CANTIDAD A CAMBIAR</th>
              <th>SUBTOTAL</th>
              <th>ACCIÒN</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <form action="">
    <div class="form-group">
      <button type="submit" value="insert" name="accion" id="btn_cambio" class="mt-3 btn btn-primary">Cambiar</button>
    </div>
  </form>
</div>
<!-- /.container-fluid -->
<?php include_once "includes/footer.php"; ?>
<!--HAY Q INCLUIR ESTA WEA SI O SI-->
<!-- Include sum ,permite sumar los valores de una tabla -->
<script src="https://cdn.datatables.net/plug-ins/1.10.25/api/sum().js"></script>
<script type="text/javascript">
  var datos2 = <?php echo json_encode($res2); ?> ;
  var sumaTotal = 0;
  var i = 1;
  var cantActual = 1;

  function sumar_total(valor) {
    console.log("SE LLAMA");
    valor = parseFloat(valor);
    sumaTotal = sumaTotal + valor;
    presio = document.getElementById('txt_campo_1').innerHTML;
    total = document.getElementById('lblcambio').innerHTML;
    if (total == null || total == undefined || total == "") {
      total = "0";
    }
    total = total + (parseInt(presio) * parseInt(valor));
    sumaTotal = sumaTotal - parseInt(document.getElementById("lblcambio").value);
    // console.log(sumaTotal);
    if (sumaTotal > 0) {
      document.getElementById("lblcambio").value = sumaTotal;
      document.getElementById("lblcambio").value = 0;
    } else {
      document.getElementById("lblcambio").value = 0;
      var cambioActual = parseInt(document.getElementById("lblcambio").value); //SAFO, corregir SILVAZANGA
      cambioActual = cambioActual + parseInt(sumaTotal);
      console.log(cambioActual);
      document.getElementById("lblcambio").value = cambioActual;
    }

    //document.getElementById('lbltotal').innerHTML = parseFloat(valor);
  }

  function restar_total(valor) {
    console.log("SE LLAMA");
    var lblcambio = $("#lblcambio").val();
    var resta = lblcambio - valor;
    $("#lblcambio").val(resta);
  }
  //CARGANDO TABLA AL TRAER DATOS
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
          if ($('#lblMensaje').text() == "Se registro correctamente" || $('#lblMensaje').text() ==
            "Se elimino correctamente") {
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
  var sumatoria
  var primeraVez = true;
  var id_venta;
  var urlAjax = `https://zapateriazan.ga/sistema/negocio/Bus_Venta_noex.php?id_venta=`;
  var misDatos;
  $('#num_venta').keydown(function(e) {
    var key = e.keyCode
    id_venta = $('#num_venta').val();
    if (key == 13) {
      //Limpieza malazooOoOooo
      if (typeof mitab.tabla_producto != 'undefined') {
        mitab.tabla_producto.clear().draw(); //Limpia modal
      }
      $("#tb_productos_agregados td").remove(); //Como no usa datatables...
      document.getElementById("lblcambio").value = 0;
      sumatoria = 0;
      // ==============
      //alert(id_venta);
      //console.log(id_venta);
      $.ajax({
        type: "GET",
        datatype: "json",
        url: "negocio/Bus_Venta.php?id_venta=" + id_venta, //direccion del php q vamos a usar
        data: id_venta,
        success: function(res) { //echo que devuelve el llamado al php
          var myObj = JSON.parse(res);
          if (myObj.length > 0) {
            $('#lblMensaje').text("Se encontro Venta"); //asignar la respuesta al l*abel mensaje
          } else {
            $.ajax({
              type: "GET",
              datatype: "json",
              url: "negocio/Bus_Venta_noex.php?id_venta=" + id_venta, //direccion del php q vamos a usar
              data: id_venta,
              success: function(res) {
                var myObj = JSON.parse(res);
                if (myObj.length > 0) {
                  $('#lblMensaje').text("Se encontro el Numero Venta, pero ya paso mas de 2 semanas");
                  document.getElementById("idVenta").value = "";
                  document.getElementById("nombre_empleado").value = "";
                  document.getElementById("fecha_venta").value = "";
                  document.getElementById("total_venta").value = "";
                } else {
                  $('#lblMensaje').text("No se encontro el Numero Venta");
                }
              }
            });
          }
          //populate("#frm_reg_cliente",res);
          document.getElementById("idVenta").value = myObj[0].id;
          document.getElementById("nombre_empleado").value = myObj[0].empleado;
          document.getElementById("fecha_venta").value = myObj[0].fecha;
          document.getElementById("total_venta").value = myObj[0].total;
          mitab.datos_tabla = myObj;
          // console.log(mitab.datos_tabla);
          var datos2 = <?php echo json_encode($res2); ?> ;
          mitab.borrarPresentes = function(datos2, datos_tabla) {
            for (let i = 0; i < datos2.length; i++) {
              for (let j = 0; j < datos_tabla.length; j++) {
                if (datos2[i].id == datos_tabla[j].id_producto) {
                  datos2.splice(i, 1);
                }
              }
            }
          }
          // console.log(datos2);
          // console.log(mitab.datos_tabla);
          mitab.borrarPresentes(datos2, mitab.datos_tabla);
          urlAjax = `https://zapateriazan.ga/sistema/negocio/Bus_Venta_noex.php?id_venta=${id_venta}`;
          if (typeof id_venta ===
            'undefined') { //Salta un error si el id es indefinido, por lo tanto return y chau
            return;
          }
          if (primeraVez) {
            cargarTabla();
            loadModal();
            primeraVez = false;
          }
          mitab.tablaxd.ajax.url(urlAjax).load(); //Cambia URL de los datos
          mitab.tablaxd.ajax.reload(); //Recarga
          mitab.tabla_producto.clear().rows.add(datos2).draw(); //Recargar datos a través de JS
        }
      });
    }
  });
  var mitab = {}; //Global
  mitab.datos_tabla = JSON.stringify();

  function cargarTabla() {
    mitab.tablaxd = $('#Ventas_Todo').DataTable({
      ajax: {
        url: urlAjax,
        dataSrc: "",
      },
      columns: [{
          data: 'id_producto',
          class: 'text-warning'
        },
        {
          data: 'categoria',
        },
        {
          data: 'marca',
        },
        {
          data: 'producto',
        },
        {
          data: 'cantidad',
          render: function(data, type, row, meta) {
            return `<p id="original${row.id_producto}">${data}</p>`;
          }
        },
        {
          data: null,
          render: function(data, type, row, meta) {
            return `<input type='text' onkeypress="return /[0-9]/i.test(event.key)" class="form-control text-light" id="aDevolver${row.id_producto}" onkeyup="compararCambio(${row.id_producto})" value ="0"></input>`;
          }
        },
        {
          data: 'precio',
        },
        //CREO QUE NO DEBERIA PODER QUITARSE
        {
          data: null,
          render: function() {
            return `<button hidden class="btn btn-danger">Quitar</button>`;
          }
        }
      ]
    });
  }

  $('#Ventas_Todo').on('click', '.btn-danger', function() { //BtnDanger porque no se si quieres meterle otro botón
    var data = mitab.tablaxd.row($(this).parents('tr')).data();
    console.log(data['id_producto'], data[
      'cantidad'
    ]); //El id del producto eliminado y su cantidad original, supongo que los podes retornar a la bda, no sé si devolverlo a seleccionar productos, no tiene sentido pero bueno
    var devolver = <?php echo json_encode($res2); ?> ;
    for (let i = 0; i < devolver.length; i++) {
      if (devolver[i].id == data['id_producto']) { //si coincide lo pushea a seleccionar productos
        mitab.tabla_producto.row.add(devolver[i]).draw(); //Añade a la tabla  
        break;
      }
    }
    mitab.tablaxd.row($(this).parents('tr')).remove().draw();
    //$(this).parent().parent().remove(); //Esto lo elimina pero si le das a sort denuevo reaparece
    //Ya no sé que más hacer, fuera malazo, mostrame tu BDAAAAAA
  });
  //MOSTRANDO PRODUCTOS EN LA TABLA DEL MODAL
  function eliminarFila(index) {
    var t = $('#table_id_pro').DataTable();
    var rowjQuery = $(index).closest("tr");
    var row_index = rowjQuery[0].rowIndex - 1;
    //var row_index = $(this).closest("tr").index();
    var datostabla = [];
    var k = 0;
    var i = 0;
    var filas = $('#tb_productos_agregados tr').length;
    var subt = [];
    $('#tb_productos_agregados tr').each(function(indice, tr) {
      //console.log("Entro");
      var tds = $(tr).find('td');
      //console.log(tds);
      if (tds.length > 1) {
        datostabla[k++] = {
          id: tds[0].textContent,
          nombre: tds[1].textContent,
          talla: tds[2].textContent,
          id_categoria: tds[5].textContent,
          id_marca: tds[6].textContent,
          id_color: tds[4].textContent,
          precio: tds[3].textContent,
          cantidad: tds[7].children[0].value
        }
        subt[i++] = {
          subtotal: tds[8].textContent
        }
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
    //restar_total(datostabla[row_index].precio);
    restar_total(parseInt(subt[row_index].subtotal));
    rowjQuery.remove();
  }

  function loadModal() {
    mitab.tabla_producto = $('#table_id_pro').DataTable({
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
            '</td><td id="txt_campo_1">' + aux[3] + '</td><td>' + aux[4] + '</td><td>' + aux[5] +
            '</td><td>' +
            aux[6] +
            '</td><td><input onkeyup="compararCambio(' + aux[0] +
            ')" onkeypress="return /[0-9]/i.test(event.key)" type="text"  class="text-light form-control" name="control_cantidad" value="1"></td>' +
            '<td>' + aux[3] + '</td>' +
            '<td><button type="button" name="remove" id="btnQuitar"' +
            'onclick="eliminarFila(this)" class="btn btn-danger btn_remove borrar">Quitar</button></td></tr>';
          i++;
          //console.log("algo", fila);
          $('#tb_productos_agregados tr:first').after(fila);
          sumar_total(aux[3]);
        }
      });
    });
    $('#tb_productos_agregados').keydown(function(e) {
      if (e.ctrlKey || e.altKey || e.keyCode == 13) {
        //console.log("presionaste " + e.keyCode);
        var trp = e.target.parentElement.parentElement;
        var precio = trp.children[3].textContent;
        var cant = trp.children[7].children[0].value;
        console.log("Subtotal:" + (precio * cant));
        if (cant == 0 || cant == "") {
          cant = 1;
          trp.children[7].children[0].value = 1;
          //console.log("cant"+cant);
        }
        var subtotal = cant * precio;
        trp.children[8].textContent = subtotal;
        CalcularTotal();
        e.preventDefault();
        return false;
      }
    });

    function CalcularTotal() {
      var datostabla = [];
      var k = 0;
      $('#tb_productos_agregados tr').each(function(indice, tr) {
        var tds = $(tr).find('td');
        if (tds.length > 1) {
          datostabla[k++] = {
            subtotal: tds[8].textContent
          }
        }
      });
      sumatoria = 0;
      console.log(datostabla);
      for (let index = 0; index < datostabla.length; index++) {
        sumatoria += parseInt(datostabla[index].subtotal);
      }
      console.log(sumatoria);
      $("#lblcambio").val(sumatoria);
    }
    $('#tb_productos_agregados').keypress(function(e) {
      if (e.ctrlKey || e.altKey || e.keyCode == 13) {
        e.preventDefault();
        return false;
      }
    });
  }
  //REGISTRANDO CAMBIO
  $(document).ready(function() {
    $('#btn_cambio').click(function() {
      var data = [];
      var k = 0;
      var h = 0;
      var filas = $('#tb_productos_agregados tr').length;
      var total = 0;
      var precios = [];
      var cantidades = [];
      var ids = [];
      var precios2 = [];
      var cantidades2 = [];
      var ids2 = [];
      var longitud_productos = 0;
      $('#tb_productos_agregados tr').each(function(index, tr) {
        //console.log("Entro");
        var tds = $(tr).find('td');
        longitud_productos = tds.length;
        //console.log(tds);
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
          //total = total + parseFloat(data[k].precio) * parseFloat(cantidades[k].cantidad);
          k++;
        }
        //console.log("TOTAL:", total);
      });
      $('#Ventas_Todo tr').each(function(index, tr) {
        //console.log("Entro");
        var tds = $(tr).find('td');
        longitud_productos = tds.length;
        //console.log(tds);
        if (tds.length > 1) {
          ids2[h] = {
            id: tds[0].textContent
          }
          precios2[h] = {
            precio: tds[6].textContent
          }
          cantidades2[h] = {
            cantidad: tds.find("input[type='text']").val()
          }
          //total = total + parseFloat(data[k].precio) * parseFloat(cantidades[k].cantidad);
          h++;
        }
        //console.log("TOTAL:", total);
      });
      var datos_venta = {
        //totalxD: total,
        id_venta: document.getElementById("num_venta").value,
        nombre_empleado: document.getElementById("nombre_empleado").value,
        cantidad: cantidades,
        precio: precios,
        contador: k,
        id_producto: ids,
        cantidades2: cantidades2,
        precios2: precios2,
        id_productos2: ids2
      };
      console.log(datos_venta);
      $.ajax({
        type: "POST",
        url: "negocio/Reg_Cambio.php",
        data: datos_venta,
        success: function(res) {
          $('#lblMensaje2').text(res);
          if ($('#lblMensaje2').text() == "Se registro correctamente") {
            document.getElementById("nombre_empleado").value = "";
            alert("Se registro correctamente.");
            $('#lblcambio').text("0");
            if (res == "Se registro correctamente") {
              location.reload();
            }
          }
        }
      });
      //NO TE OLVIDEFS BORRARLOA AA A A A 
      return false; //evitar q  se recargue la pagina

    });
  });

  function compararCambio(id) {
    var devolver = parseInt(document.getElementById("aDevolver" + id).value);
    var original = parseInt(document.getElementById("original" + id).innerHTML);
    // console.log(devolver);
    // console.log(original);
    if (devolver > original) {
      document.getElementById("lblMensaje2").innerHTML = "No puede devolver mas de lo que vendio";
      document.getElementById("btn_cambio").disabled = true;
    } else {
      document.getElementById("lblMensaje2").innerHTML = "";
      document.getElementById("btn_cambio").disabled = false;
      var total = 0;
      var datos = mitab.tablaxd.rows().data();
      datos.each(function(value) {
        total += parseInt(value.precio) * parseInt(document.getElementById("aDevolver" + value.id_producto).value);
      })
      total2 = total;
      total = total - parseInt(document.getElementById("lblcambio").value);
      if (total > 0) {
        document.getElementById("lblcambio").value = total;
      } else {
        document.getElementById("lblcambio").value = 0;
        var actualTotal = parseInt(document.getElementById("lblcambio").value);
        document.getElementById("lblcambio").value = actualTotal - total2;
      }
      console.log(total2);

    }

  }
</script>