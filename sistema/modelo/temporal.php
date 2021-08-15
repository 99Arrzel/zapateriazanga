<?php
class temporal extends db_object{
  public static $db_tabla = "ttemporal"; //Variable para manejar la tabla
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

  public static function RestaurarTemporal($vid_compra, $vid_producto){
    $sql = "UPDATE ttemporal SET estado = 0 WHERE id_compra = ".$vid_compra." AND id_producto = ".$vid_producto."";
    //echo $sql;
    //return;
    return static::query($sql);
  }

  public static function RestarProduco($vid_producto, $vcantidad, $vid_compra){
    $sql = "UPDATE ttemporal 
      SET cantidad = (cantidad - ".$vcantidad.") 
      WHERE id_compra = ".$vid_compra." AND id_producto = ".$vid_producto;
    //echo $sql;
    //return;
    return static::query($sql);
  }

}