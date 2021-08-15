<?php
include "../../init.php";
$mensaje = "";

if($_POST['id_venta'] != ""){
  //if($_POST['totalxD'] == 0){
    $mensaje = "Ingrese los productos a cambiar Porfavor";
    
  //}else{
    //Registrando venta
    $venta = new venta();
    $cambio = new cambio();
    $detalle_cambio = new detalle_cambio();
    $detalle_venta = new detalle_venta();
    $bill = new movimiento();
    //CAMBIO
    $cambio->fecha = date('Y-m-d');
    $cambio->total = 0;
    $id_venta = $_POST['id_venta'];
    $aux_venta = $_POST['id_venta'];
    $id_empleado = $_POST['nombre_empleado'];
    $id_empleado = cambio::buscar_empleado_venta($id_empleado, $id_venta);
    $cambio->id_empleado = $id_empleado[0]->id;
    $cambio->id_venta = $_POST['id_venta'];
    //VENTA
    $venta->fecha = date('Y-m-d');
    $venta->total = 0;
    $id_venta = $_POST['id_venta'];
    $id_cliente = cambio::buscar_cliente_venta($id_venta);
    $venta->id_cliente = $id_cliente[0]->id;
    $venta->id_empleado = $id_empleado[0]->id;
    $venta->id_venta = $_POST['id_venta'];
    //Insertando en detalle cambio de la NUEVA venta
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $contador = intval($_POST['contador']);
    $id_producto = $_POST['id_producto'];
    //Insertando en detalle cambio de la ANTIGUA venta
    $cantidad2 = $_POST['cantidades2'];
    $precio2 = $_POST['precios2'];
    $id_producto2 = $_POST['id_productos2'];
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
      $cambio->create();
      $venta->create();
      $id_cambio = cambio::devolver_ultimoID();
      $id_venta = venta::devolver_ultimoID();
      $detalle_cambio->id_cambio = $id_cambio;
      $detalle_venta->id_venta = $id_venta;
      for($i=0; $i< count($id_producto); $i=$i+1){
        //DETALLE CAMBIO
        $detalle_cambio->id_producto = implode($id_producto[$i]);
        $detalle_cambio->cantidad = implode($cantidad[$i]);
        $detalle_cambio->precio = implode($precio[$i]);
        //DETALLE VENTA
        $detalle_venta->id_producto = implode($id_producto[$i]);
        $detalle_venta->cantidad = implode($cantidad[$i]);
        $detalle_venta->precio = implode($precio[$i]);
        producto_almacen::prReducirCantidad(implode($id_producto[$i]), implode($cantidad[$i]));
        $detalle_cambio->create();
        $detalle_venta->create();
      }
      for($i=0; $i< count($id_producto2); $i=$i+1){
        //DETALLE CAMBIO
        $detalle_cambio->id_producto = implode($id_producto2[$i]);
        $detalle_cambio->cantidad = implode($cantidad2[$i]);
        $detalle_cambio->precio = implode($precio2[$i]);
        //DETALLE VENTA
        $detalle_venta->id_producto = implode($id_producto2[$i]);
        $detalle_venta->cantidad = implode($cantidad2[$i]);
        $detalle_venta->precio = implode($precio2[$i]);
        producto_almacen::prAumentarCantidadDestino(implode($id_producto2[$i]), implode($cantidad2[$i]),  $_SESSION['id_sucursal']);
        $detalle_cambio->create();
        $detalle_venta->create();
      }
      $id_sucursal = $_SESSION['id_sucursal'];
      $bill::prInsertarMovimiento($id_sucursal, date('Y-m-d'), 'Cambio - Ingreso', 0, $id_empleado[0]->id, 1, 1, $id_venta, 0);
      venta::modificar($aux_venta);
      venta::modificar2($id_venta);
      $mensaje = "Se registro correctamente";
    }
  //}
}else{
  $mensaje = "Coloque el numero de la venta";
}

echo ($mensaje);
?>
