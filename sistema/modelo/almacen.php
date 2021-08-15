<?php
class almacen extends db_object{
  public static $db_tabla = "talmacen"; //Variable para manejar la tabla
  public static $db_campos_tabla = array('id', 'nombre', 'id_sucursal'); // Referencia a los campos de la tabla
  public $id;
  public $nombre;
  public $id_sucursal;

  //public $telefono;
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

  public static function traer_almacenes(){
    return static::query("SELECT * FROM ".static::$db_tabla);    
  }

}
