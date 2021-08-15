<?php
include "../../init.php";
$mensaje = "";
$ids = producto::traer_compras_asignar();
//var_dump(count($ids));
//return;
if(isset($_POST['cantidad'])){
  if(trim($_POST['id_almacen']) == ""){
    $mensaje = "Rellene todos los espacios necesarios porfavor";
    }else{
    //Obteniendo datos para producto almacen
    $cantidad = $_POST['cantidad'];
    $cantidadaux = $_POST['cantidadaux'];
    $id_producto = $_POST['id_producto'];
    $contador = intval($_POST['contador']);
    $id_almacen = $_POST['id_almacen'];
    $id_compra = $_POST['id_compra'];
    //Verificar cantidad
    for($z=0; $z<$contador; $z=$z+1){
      if(intval(implode($cantidad[$z])) > intval(implode($cantidadaux[$z]))){
        $mensaje = "No hay stock suficiente del producto con ID #".implode($id_producto[$z]);
        $verificar = true;
        break;
      }
    }
    //Si hay suficiente cantidad, recien se registra a la compra y detalle compra
    if(!$verificar){
      //Creando compra e insertando en detalle compra    
      for($i=0; $i<$contador; $i=$i+1){
          if(empty(producto_almacen::EstaInsertado($id_almacen, implode($id_producto[$i])))){
          producto_almacen::prInsertarProductoAlmacen(implode($id_producto[$i]), $id_almacen, implode($cantidad[$i]));
          temporal::RestarProduco(implode($id_producto[$i]), implode($cantidad[$i]), implode($id_compra[$i]));
        }else{
          producto_almacen::prAumentarCantidad(implode($id_producto[$i]), implode($cantidad[$i]), $id_almacen);  
          temporal::RestarProduco(implode($id_producto[$i]), implode($cantidad[$i]), implode($id_compra[$i]));
        }
      }
      $mensaje = "Se registro correctamente";
    }

  }
}
echo ($mensaje);
?>