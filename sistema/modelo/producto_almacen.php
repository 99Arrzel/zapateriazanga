<?php
class producto_almacen extends db_object{
  public static $db_tabla = "tproducto_almacen"; //Variable para manejar la tabla
  public static $db_campos_tabla = array('id_producto', 'id_almacen', 'cantidad', 'ubicacion'); // Referencia a los campos de la tabla
  public $id_producto;
  public $id_almacen;
  public $cantidad;
  public $ubicacion;

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

  public static function traer_cantidades_productos($id){
    return static::query("SELECT cantidad FROM ".static::$db_tabla." WHERE id_producto = ".$id);    
  }

  public static function prReducirCantidad($vid, $vcantidad){
    $sql = "CALL prReducirCantidad (".$vid.",".$vcantidad.")";
    return static::query($sql);    
  }

  public static function prAumentarCantidad($vid, $vcantidad, $vid_almacen){
    $sql = "CALL prAumentarCantidad (".$vid.",".$vcantidad.",".$vid_almacen.")";
    return static::query($sql);    
  }

  public static function EstaInsertado($vid_almacen, $vid_producto){
    $sql = "SELECT * FROM ".static::$db_tabla." WHERE id_almacen = ".$vid_almacen." AND id_producto = ".$vid_producto;
    //echo var_dump($sql);
    //return;
    return static::query($sql);    
  }

  public static function prInsertarProductoAlmacen($vid_producto, $vid_almacen, $vcantidad){
    $sql = "CALL prInsertarProductoAlmacen (".$vid_producto.",".$vid_almacen.",".$vcantidad.")";
    return static::query($sql);    
  }

  public static function RestaurarCompra($vid_compra){
    $sql = "UPDATE tcompra 
      SET tcompra.estado = 0
      WHERE tcompra.id = ".$vid_compra;
    //echo $sql;
    //return;
    return static::query($sql);
  }

  public static function RestarProduco($vid_producto, $vcantidad, $vid_almacen){
    $sql = "UPDATE tproducto_almacen SET cantidad = (cantidad - ".$vcantidad.") WHERE id_almacen = ".$vid_almacen." AND id_producto = ".$vid_producto.";";
    //echo $sql;
    //return;
    return static::query($sql);
  }
  
  public static function prAumentarCantidadDestino($vid_producto, $vcantidad, $vid_almacen){
    $sql = "CALL prAumentarCantidadDestino (".$vid_producto.",".$vcantidad.",".$vid_almacen.")";
    //echo $sql;
    //return;
    return static::query($sql); 
  }
}
