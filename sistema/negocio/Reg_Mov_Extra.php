<?php
include "../../init.php";
$mensaje = "";
if(isset($_POST['descripcion'], $_POST['total'])){
  if( trim($_POST['descripcion']) == "" || trim($_POST['total']) == ""){
    $mensaje = "No deje espacios en blanco";
  }else{
    //Registrando venta
    $bill = new movimiento();
    $id_empleado = $_SESSION['ci_empleado'];
    $id_empleado = movimiento::buscar_empleado_movimiento($id_empleado);
    $id_empleado = $id_empleado[0]->id;
    $id_sucursal = $_SESSION['id_sucursal'];
    $fecha = date('Y-m-d');
    $descripcion = $_POST['descripcion'];
    $total = $_POST['total'];
    $id_concepto = $_POST['id_concepto'];
    $id_tipo_transaccion = $_POST['id_tipo_transaccion'];
    $bill->id_sucursal = $id_sucursal;
    $bill->id_empleado = $id_empleado;
    $bill->fecha = $fecha;
    $bill->descripcion = $descripcion;
    $bill->total = $total;
    $bill->id_concepto = $id_concepto;
    $bill->id_tipo_transaccion = $id_tipo_transaccion;
    $bill->id_venta = 0;
    $bill->id_compra = 0;
    $bill->create();
    $mensaje= "Se registro correctamente";
  }
}
echo ($mensaje);
?>