<?php
include "../../init.php";
$mensaje = "";
if(isset($_POST['ci_empleado'])){
  if(trim($_POST['ci_empleado']) == ""){
    $mensaje = "Rellene todos los espacios necesarios porfavor";
  }else{
    //Registrando compra
    $buy = new compra();
    $detalle_compra = new detalle_compra();
    $temporal = new temporal();
    $bill = new movimiento();
    $buy->fecha = date('Y-m-d');
    $buy->total = $_POST['totalxD'];
    $id_empleado = $_POST['ci_empleado'];
    $id_empleado = compra::buscar_empleado_compra($id_empleado);
    $buy->id_empleado = $id_empleado[0]->id;
    $buy->estado = 0;
    //Obteniendo datos para detalle compra
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $contador = intval($_POST['contador']);
    $id_producto = $_POST['id_producto'];
    //Creando compra e insertando en detalle compra    
    $buy->create();
    $id_compra = compra::devolver_ultimoID();
    $detalle_compra->id_compra = $id_compra;
    $temporal->id_compra = $id_compra;
    for($i=0; $i<$contador; $i=$i+1){
      //DETALLE_COMPRA
      $detalle_compra->id_producto = implode($id_producto[$i]);
      $detalle_compra->cantidad = implode($cantidad[$i]);
      $detalle_compra->precio = implode($precio[$i]);
      $detalle_compra->create();
      //TEMPORAL
      $temporal->id_producto = implode($id_producto[$i]);
      $temporal->cantidad = implode($cantidad[$i]);
      $temporal->precio = implode($precio[$i]);
      $temporal->create();
    }
    $id_sucursal = $_SESSION['id_sucursal'];
    $bill::prInsertarMovimiento($id_sucursal, date('Y-m-d'), 'Compra', $_POST['totalxD'], $id_empleado[0]->id, 2, 2, 0, $id_compra);
    $mensaje = "Se registro correctamente";
  }
}
echo ($mensaje);
?>