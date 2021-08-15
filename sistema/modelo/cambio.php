<?php
class cambio extends db_object{
  public static $db_tabla = "tcambio"; //Variable para manejar la tabla
  public static $db_campos_tabla = array('fecha', 'total', 'estado', 'id_venta', 'id_empleado'); // Referencia a los campos de la tabla
  public $id;
  public $fecha;
  public $total;
  public $id_venta;
  public $id_empleado;
  public $estado;
  public $id_producto;
  public $cantidad;

  public $marca;
  public $categoria;
  public $id_sucursal;
  public $producto;
  public $empleado;
  public $precio;
  public $talla;
  public $nombre;
  public $id_cliente;

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
    if($database->consulta($sql)){
      return true;
    }else{
      return false;
    }
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

  public function buscar_empleado_venta($nombre_empleado, $id_venta){
    $sql = "SELECT tventa.id_empleado as 'id' 
    FROM tventa 
    JOIN tpersona
    WHERE CONCAT(tpersona.nombre, ' ', tpersona.apPaterno, ' ', tpersona.apMaterno) = '".$nombre_empleado."' 
    AND tventa.id = ".$id_venta;
    //echo $sql;
    //return;
    return static::query($sql);
  }

  public function buscar_cliente_venta($id_venta){
    $sql = "SELECT id_cliente as 'id' 
    FROM tventa 
    WHERE tventa.id = ".$id_venta;
    //echo $sql;
    //return;
    return static::query($sql);
  }
}
