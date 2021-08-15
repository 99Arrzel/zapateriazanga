<?php
class movimiento extends db_object{
  public static $db_tabla = "tmovimiento"; //Variable para manejar la tabla
  public static $db_campos_tabla = array('id_sucursal', 'fecha', 'descripcion', 'total', 'id_empleado', 'id_concepto', 'id_tipo_transaccion', 'id_venta', 'id_compra');
  public $id;
  public $fecha;
  public $descripcion;
  public $total;
  public $estado;
  public $id_empleado;
  public $id_concepto;
  public $id_tipo_transaccion;
  public $id_venta;
  public $id_compra;
  public $id_sucursal;
  public $tc_nombre;
  public $tt_nombre;
  public $id_producto;
  public $cantidad;
  public $categoria;
  public $marca;

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

  public static function devolver_ultimoID(){
    $sql = "SELECT id FROM ".self::$db_tabla." ORDER by id DESC LIMIT 1";
    if($row = static::query($sql)){
      $id = trim($row[0]->id);
      return $id;
    }
    return null;
  } 

  //CRUD
  public static function prInsertarMovimiento($vid_sucursal, $vfecha, $vdescripcion, $vtotal, $vid_empleado, $vid_concepto, $vid_tipo_transaccion, $vid_venta, $vid_compra){
    $sql = "CALL prInsertarMovimiento (".$vid_sucursal.",'".$vfecha."','".$vdescripcion."',".$vtotal.",".$vid_empleado.",".$vid_concepto.",".$vid_tipo_transaccion.",".$vid_venta.",".$vid_compra.")";
    //echo $sql;
    //return;
    return static::query($sql);    
  }

  public static function contar_movimientos_realizados(){
    $sql = ("SELECT COUNT(id) as id FROM ".static::$db_tabla." WHERE estado = 0 ");
    if($row = static::query($sql)){
      $id = trim($row[0]->id);
      return $id;
    }
  }

  public static function contar_movimientos_modificados(){
    $sql = ("SELECT COUNT(id) as id FROM ".static::$db_tabla." WHERE estado = 1 ");
    if($row = static::query($sql)){
      $id = trim($row[0]->id);
      return $id;
    }
  }

  public static function traer_movimientos_realizados(){
    return static::query("SELECT * FROM ".static::$db_tabla." WHERE estado = 0");
  }

  public static function traer_movimientos_modificados(){
    return static::query("SELECT * FROM ".static::$db_tabla." WHERE estado = 1");
  }

  public function buscar_empleado_movimiento($ci){
    $sql = "SELECT templeado.id as 'id' 
    FROM tpersona 
    JOIN templeado ON tpersona.id = templeado.idPersona
    WHERE ci ='".$ci."'";
    return static::query($sql);
  }

  public function traer_ultimos_movimientos_realizados(){
    $sql = "SELECT CONCAT(tpersona.nombre, ' ', tpersona.apPaterno, ' ', tpersona.apMaterno) AS 'id_empleado', 
    tmovimiento.fecha AS 'fecha', tconcepto.descripcion AS 'tc_nombre', ttipo_transaccion.descripcion AS 'tt_nombre',
    tmovimiento.descripcion AS 'descripcion',
    CONCAT(tmovimiento.total, 'Bs.') AS 'total'
    FROM tmovimiento
    JOIN tconcepto ON tmovimiento.id_concepto = tconcepto.id
    JOIN ttipo_transaccion ON tmovimiento.id_tipo_transaccion = ttipo_transaccion.id
    JOIN templeado ON tmovimiento.id_empleado = templeado.id
    JOIN tpersona ON templeado.idPersona = tpersona.id
    WHERE tmovimiento.estado = 0 AND tmovimiento.id_sucursal = ".$_SESSION['id_sucursal']." 
    ORDER BY tmovimiento.id DESC
    LIMIT 7";
    return static::query($sql);
  }

  public function traer_ultimos_movimientos_compras_fechas($vfecha_inicio, $vfecha_fin, $num_sucursal){
    if($num_sucursal == 0){
      $sql = "SELECT
      CONCAT(tpersona.nombre, ' ', tpersona.apPaterno, ' ', tpersona.apMaterno) AS 'id_empleado', 
      tmovimiento.fecha AS 'fecha', CONCAT(tmovimiento.total, 'Bs.') AS 'total', 
      CONCAT('Compra #', tdetalle_compra.id_compra) as 'id_compra', tproducto.nombre as 'id_producto', 
      tdetalle_compra.cantidad as 'cantidad', tcategoria.nombre as 'categoria', tmarca.nombre as 'marca', 
      tsucursal.nombre as 'id_sucursal'
      FROM tmovimiento
      JOIN templeado ON tmovimiento.id_empleado = templeado.id
      JOIN tpersona ON templeado.idPersona = tpersona.id
      JOIN tdetalle_compra ON tmovimiento.id_compra = tdetalle_compra.id_compra
      JOIN tproducto ON tdetalle_compra.id_producto = tproducto.id
      JOIN tcategoria ON tproducto.id_categoria = tcategoria.id
      JOIN tmarca ON tproducto.id_marca = tmarca.id
      JOIN tsucursal ON tmovimiento.id_sucursal = tsucursal.id
      WHERE tmovimiento.fecha BETWEEN '".$vfecha_inicio."' AND '".$vfecha_fin."'   
      AND tmovimiento.estado = 0 AND tmovimiento.descripcion = 'Compra' 
      ORDER BY tmovimiento.id";  
    }else{
      $sql = "SELECT 
      CONCAT(tpersona.nombre, ' ', tpersona.apPaterno, ' ', tpersona.apMaterno) AS 'id_empleado', 
      tmovimiento.fecha AS 'fecha', CONCAT(tmovimiento.total, 'Bs.') AS 'total', 
      CONCAT('Compra #',tdetalle_compra.id_compra) as 'id_compra', tproducto.nombre as 'id_producto', 
      tdetalle_compra.cantidad as 'cantidad', tcategoria.nombre as 'categoria', tmarca.nombre as 'marca'
      FROM tmovimiento
      JOIN templeado ON tmovimiento.id_empleado = templeado.id
      JOIN tpersona ON templeado.idPersona = tpersona.id
      JOIN tdetalle_compra ON tmovimiento.id_compra = tdetalle_compra.id_compra
      JOIN tproducto ON tdetalle_compra.id_producto = tproducto.id
      JOIN tcategoria ON tproducto.id_categoria = tcategoria.id
      JOIN tmarca ON tproducto.id_marca = tmarca.id
      WHERE tmovimiento.fecha BETWEEN '".$vfecha_inicio."' AND '".$vfecha_fin."'   
      AND tmovimiento.estado = 0 AND tmovimiento.descripcion = 'Compra' 
      AND tmovimiento.id_sucursal =".$num_sucursal." ORDER BY tmovimiento.id";  
    }
    //echo $sql;
    //return;
    return static::query($sql);
  }

  public function traer_ultimos_movimientos_extras_fechas($vfecha_inicio, $vfecha_fin, $num_sucursal){
    if($num_sucursal == 0){
      $sql = "SELECT CONCAT(tpersona.nombre, ' ', tpersona.apPaterno, ' ', tpersona.apMaterno) AS 'id_empleado', 
      tmovimiento.fecha AS 'fecha', tconcepto.descripcion AS 'tc_nombre', ttipo_transaccion.descripcion AS 'tt_nombre',
      CONCAT(tmovimiento.total, 'Bs.') AS 'total', tsucursal.nombre AS 'id_sucursal' 
      FROM tmovimiento
      JOIN tconcepto ON tmovimiento.id_concepto = tconcepto.id
      JOIN ttipo_transaccion ON tmovimiento.id_tipo_transaccion = ttipo_transaccion.id
      JOIN templeado ON tmovimiento.id_empleado = templeado.id
      JOIN tpersona ON templeado.idPersona = tpersona.id
      JOIN tsucursal ON tmovimiento.id_sucursal = tsucursal.id
      WHERE tmovimiento.fecha BETWEEN '".$vfecha_inicio."' AND '".$vfecha_fin."'   
      AND tmovimiento.estado = 0 AND tmovimiento.descripcion != 'Compra' AND tmovimiento.descripcion != 'Venta' 
      ORDER BY tmovimiento.id";  
    }else{
      $sql = "SELECT CONCAT(tpersona.nombre, ' ', tpersona.apPaterno, ' ', tpersona.apMaterno) AS 'id_empleado', 
      tmovimiento.fecha AS 'fecha', tconcepto.descripcion AS 'tc_nombre', ttipo_transaccion.descripcion AS 'tt_nombre',
      CONCAT(tmovimiento.total, 'Bs.') AS 'total', tsucursal.nombre AS 'id_sucursal' 
      FROM tmovimiento
      JOIN tconcepto ON tmovimiento.id_concepto = tconcepto.id
      JOIN ttipo_transaccion ON tmovimiento.id_tipo_transaccion = ttipo_transaccion.id
      JOIN templeado ON tmovimiento.id_empleado = templeado.id
      JOIN tpersona ON templeado.idPersona = tpersona.id
      JOIN tsucursal ON tmovimiento.id_sucursal = tsucursal.id
      WHERE tmovimiento.fecha BETWEEN '".$vfecha_inicio."' AND '".$vfecha_fin."'   
      AND tmovimiento.estado = 0 AND tmovimiento.descripcion != 'Compra' AND tmovimiento.descripcion != 'Venta' 
      AND tmovimiento.id_sucursal = ".$num_sucursal." ORDER BY tmovimiento.id";  
    }
    return static::query($sql);
  }

}