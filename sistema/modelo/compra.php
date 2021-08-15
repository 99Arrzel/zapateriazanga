<?php
class compra extends db_object{
  public static $db_tabla = "tcompra"; //Variable para manejar la tabla
  public static $db_campos_tabla = array('fecha', 'total', 'estado'); // Referencia a los campos de la tabla
  public $id;
  public $fecha;
  public $total;
  public $id_empleado;
  public $estado;
  public $categoria;
  public $marca;
  public $cantidad;
  public $proveedor;
  public $id_producto;

  public static function devolver_ultimoID(){
    $sql = "SELECT id FROM ".self::$db_tabla." ORDER by id DESC LIMIT 1";
    if($row = static::query($sql)){
      $id = trim($row[0]->id);
      return $id;
    }
    return null;
  } 

  //CRUD
  public function create(){
    global $database;
    $propiedades = $this->propiedades();
    $sql = "INSERT INTO ".self::$db_tabla."(".implode(", ", array_keys($propiedades)).")";
    $sql .= " VALUES ('".implode("','", array_values($propiedades))."')";
    //echo $sql;
    //return;
    if($database->consulta($sql)){
      return true;
    }else{
      return false;
    }
  }

  public static function contar_compras_realizadas(){
    $sql = ("SELECT COUNT(id) as id FROM ".static::$db_tabla." WHERE estado = 0 ");
    if($row = static::query($sql)){
      $id = trim($row[0]->id);
      return $id;
    }
  }

  public static function contar_compras_modificadas(){
    $sql = ("SELECT COUNT(id) as id FROM ".static::$db_tabla." WHERE estado = 1 ");
    if($row = static::query($sql)){
      $id = trim($row[0]->id);
      return $id;
    }
  }

  public static function traer_compras_realizadas(){
    return static::query("SELECT * FROM ".static::$db_tabla." WHERE estado = 0");
  }

  public static function traer_compras_modificadas(){
    return static::query("SELECT * FROM ".static::$db_tabla." WHERE estado = 1");
  }

  public function modificar(){
    global $database;
    $sql = "UPDATE ".static::$db_tabla." SET ";
    $sql .= "estado = 1 ";
    $sql .= "WHERE id= ".$database->formato_string($this->id);
    //echo($sql);
    $database->consulta($sql);
    return (mysqli_affected_rows($database->connection))?true:false;
  }

  public function buscar_empleado_compra($ci){
    return static::query("SELECT templeado.id as 'id' 
    FROM tpersona 
    JOIN templeado ON tpersona.id = templeado.idPersona
    WHERE ci ='".$ci."'");
  }

  public static function traer_ventas_realizadas_fechas($vfecha_inicio, $vfecha_fin){
    $sql = "SELECT * FROM ".static::$db_tabla." WHERE fecha BETWEEN '".$vfecha_inicio."' AND '".$vfecha_fin."' AND estado = 0";
    //echo $sql;
    //return;
    return static::query($sql);
  }
}