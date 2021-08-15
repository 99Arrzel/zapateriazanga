<?php
class detalle_cambio extends db_object{
  public static $db_tabla = "tdetalle_cambio"; //Variable para manejar la tabla
  public static $db_campos_tabla = array('id_cambio', 'id_producto', 'cantidad', 'precio'); // Referencia a los campos de la tabla
  public $id_cambio;
  public $id_venta;
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
}