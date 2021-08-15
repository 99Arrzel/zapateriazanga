<?php
include "../../init.php";
$mensaje = "";
if(isset($_POST['ci_cliente'],$_POST['ci_empleado'])){
  if( trim($_POST['ci_cliente']) == "" || trim($_POST['ci_empleado']) == ""){
    $mensaje = "Seleccione al cliente";
  }else{
    //Registrando venta
    $venta = new venta();
    $detalle_venta = new detalle_venta();
    $bill = new movimiento();
    $venta->fecha = date('Y-m-d');
    $venta->total = $_POST['totalxD'];
    $id_cliente = $_POST['ci_cliente'];
    $id_cliente = venta::buscar_cliente_venta($id_cliente);
    $venta->id_cliente = $id_cliente[0]->id;
    $id_empleado = $_POST['ci_empleado'];
    $id_empleado = venta::buscar_empleado_venta($id_empleado);
    $venta->id_empleado = $id_empleado[0]->id;
    //Insertando en detalle venta
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $contador = intval($_POST['contador']);
    $id_producto = $_POST['id_producto'];
    $verificar = false;
    //Verificar cantidad
    for($z=0; $z<$contador; $z=$z+1){
      $stock = producto_almacen::traer_cantidades_productos(implode($id_producto[$z]));
      $stock = intval($stock[0]->cantidad);    
      if(implode($cantidad[$z]) > $stock){
        $mensaje = "No hay stock suficiente del producto con ID #".implode($id_producto[$z]);
        $verificar = true;
        break;
      }
    }
    if(!$verificar){
      //Si hay suficiente cantidad, recien se registra la venta junto con el detalle
      $venta->create();
      $id_venta = venta::devolver_ultimoID();
      $detalle_venta->id_venta = $id_venta;
      for($i=0; $i<$contador; $i=$i+1){
        $detalle_venta->id_producto = implode($id_producto[$i]);
        $detalle_venta->cantidad = implode($cantidad[$i]);
        $detalle_venta->precio = implode($precio[$i]);
        producto_almacen::prReducirCantidad(implode($id_producto[$i]), implode($cantidad[$i]));
        $detalle_venta->create();
      }
      $id_sucursal = $_SESSION['id_sucursal'];
      $bill::prInsertarMovimiento($id_sucursal, date('Y-m-d'), 'Venta', $_POST['totalxD'], $id_empleado[0]->id, 1, 1, $id_venta, 0);
      $mensaje = "Se registro correctamente";
    }
  }
}
echo ($mensaje);
?>
