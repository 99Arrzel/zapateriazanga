<?php
class tipo_transaccion extends db_object{
    public static $db_tabla = "ttipo_transaccion"; 
    public static $db_campos_tabla = array('id', 'descripcion');
    public $id;
    public $descripcion;
    
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
    
    public static function traer_nombre_transacciones(){
      return static::query("SELECT * FROM ".static::$db_tabla);    
    }    
}
