<?php
//UPDATE tproducto_almacen SET cantidad = 1000 WHERE id_producto = 3 and id_almacen = 1
include "../../init.php";
$mensaje = "";
if(isset($_POST['cantidad'])){
  if(trim($_POST['id_almacen']) == trim($_POST['id_almacenaux'])){
    $mensaje = "Seleccione almacenes distintos";
  }else{
    //Obteniendo datos para producto almacen
    $cantidad = $_POST['cantidad'];
    $cantidadaux = $_POST['cantidadaux'];
    $id_producto = $_POST['id_producto'];
    $contador = intval($_POST['contador']);
    $id_almacen = $_POST['id_almacen'];
    $id_almacenaux = $_POST['id_almacenaux'];
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
        if(empty(producto_almacen::EstaInsertado($id_almacenaux, implode($id_producto[$i])))){
          producto_almacen::prInsertarProductoAlmacen(implode($id_producto[$i]), $id_almacenaux, implode($cantidad[$i]));
          producto_almacen::RestarProduco(implode($id_producto[$i]), implode($cantidad[$i]), $id_almacen);
        }else{
          producto_almacen::prAumentarCantidadDestino(implode($id_producto[$i]), implode($cantidad[$i]), $id_almacenaux);  
          producto_almacen::RestarProduco(implode($id_producto[$i]), implode($cantidad[$i]), $id_almacen);
        }
      } 
      $mensaje = "Se movio correctamente";
    }
  }
}
echo ($mensaje);
?>