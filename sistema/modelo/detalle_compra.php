<?php
class detalle_compra extends db_object{
  public static $db_tabla = "tdetalle_compra"; //Variable para manejar la tabla
  public static $db_campos_tabla = array('id_compra', 'id_producto', 'cantidad', 'precio'); // Referencia a los campos de la tabla
  public $id_producto;
  public $id_compra;
  public $cantidad;
  public $precio;
  
  //CRUD
  public function create(){
    global $database;
    $propiedades = $this->propiedades();
    $sql = "INSERT INTO ".self::$db_tabla."(".implode(", ", array_keys($propiedades)).")";
    $sql .= " VALUES ('".implode("','", array_values($propiedades))."')";
    if($database->consulta($sql)){
      return true;
    }else{
      return false;
    }
  }

  public static function RestaurarDetalleCompra($vid_compra, $vid_producto){
    $sql = "UPDATE tdetalle_compra 
      SET tdetalle_compra.estado = 0
      WHERE tdetalle_compra.id_compra = ".$vid_compra." 
      AND tdetalle_compra.id_producto = ".$vid_producto;
    //echo $sql;
    //return;
    return static::query($sql);
  }

}