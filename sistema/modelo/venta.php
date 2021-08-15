<?php
class venta extends db_object{
  public static $db_tabla = "tventa"; //Variable para manejar la tabla
  public static $db_campos_tabla = array('fecha', 'total', 'id_cliente', 'id_empleado'); // Referencia a los campos de la tabla
  public $id;
  public $fecha;
  public $total;
  public $id_cliente;
  public $id_empleado;
  public $estado;
  public $id_venta;
  public $id_producto;
  public $cantidad;

  public $marca;
  public $categoria;
  public $id_sucursal;
  public $producto;
  public $empleado;
  public $precio;
  public $talla;

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

  public static function contar_ventas_realizadas(){
    $sql = ("SELECT COUNT(id) as id FROM ".static::$db_tabla." WHERE estado = 0 ");
    if($row = static::query($sql)){
      $id = trim($row[0]->id);
      return $id;
    }
  }

  public static function contar_ventas_modificadas(){
    $sql = ("SELECT COUNT(id) as id FROM ".static::$db_tabla." WHERE estado = 1 ");
    if($row = static::query($sql)){
      $id = trim($row[0]->id);
      return $id;
    }
  }

  public static function traer_ventas_realizadas(){
    return static::query("SELECT * FROM ".static::$db_tabla." WHERE estado = 0");
  }

  public static function traer_ventas_modificadas(){
    return static::query("SELECT * FROM ".static::$db_tabla." WHERE estado = 1");
  }

  public function modificar($vid_venta){
    global $database;
    $sql = "UPDATE ".static::$db_tabla." SET ";
    $sql .= "estado = 1 ";
    $sql .= "WHERE id= ".$vid_venta;
    //echo($sql);
    static::query($sql);
  }

  public function modificar2($vid_venta){
    global $database;
    $sql = "UPDATE ".static::$db_tabla." SET ";
    $sql .= "estado = 2 ";
    $sql .= "WHERE id= ".$vid_venta;
    //echo($sql);
    static::query($sql);
  }

  public function buscar_cliente_venta($ci){
    return static::query("SELECT tcliente.id as 'id' 
    FROM tpersona 
    JOIN tcliente ON tpersona.id = tcliente.id_persona
    WHERE ci ='".$ci."'");
  }

  public function buscar_empleado_venta($ci){
    return static::query("SELECT templeado.id as 'id' 
    FROM tpersona 
    JOIN templeado ON tpersona.id = templeado.idPersona
    WHERE ci ='".$ci."'");
  }

  public static function traer_ventas_realizadas_fechas($vfecha_inicio, $vfecha_fin, $num_sucursal){
    if($num_sucursal == 0){
      $sql = "SELECT CONCAT('Venta #', tventa.id) as 'id_venta', tventa.fecha AS 'fecha', tpersona.nombre as 'id_empleado', 
      tcategoria.nombre as 'categoria', tmarca.nombre as 'marca',
      tproducto.nombre as 'id_producto', tdetalle_venta.cantidad as 'cantidad',
      CONCAT(tventa.total, 'Bs.') as 'total', tsucursal.nombre AS 'id_sucursal'
      FROM tventa 
      JOIN tdetalle_venta ON tdetalle_venta.id_venta = tventa.id
      JOIN templeado ON tventa.id_empleado = templeado.id
      JOIN tpersona ON templeado.idPersona = tpersona.id
      JOIN tproducto ON tdetalle_venta.id_producto = tproducto.id
      JOIN tcategoria ON tproducto.id_categoria = tcategoria.id
      JOIN tmarca ON tproducto.id_marca = tmarca.id
      JOIN tmovimiento ON tventa.id = tmovimiento.id_venta
      JOIN tsucursal ON tmovimiento.id_sucursal = tsucursal.id
      WHERE tventa.fecha BETWEEN '".$vfecha_inicio."' AND '".$vfecha_fin."' AND tventa.estado = 0";
    }else{
      $sql = "SELECT CONCAT('Venta #', tventa.id) as 'id_venta', tventa.fecha AS 'fecha', tpersona.nombre as 'id_empleado', 
      tcategoria.nombre as 'categoria', tmarca.nombre as 'marca',
      tproducto.nombre as 'id_producto', tdetalle_venta.cantidad as 'cantidad',
      CONCAT(tventa.total, 'Bs.') as 'total'
      FROM tventa 
      JOIN tdetalle_venta ON tdetalle_venta.id_venta = tventa.id
      JOIN templeado ON tventa.id_empleado = templeado.id
      JOIN tpersona ON templeado.idPersona = tpersona.id
      JOIN tproducto ON tdetalle_venta.id_producto = tproducto.id
      JOIN tcategoria ON tproducto.id_categoria = tcategoria.id
      JOIN tmarca ON tproducto.id_marca = tmarca.id
      JOIN tmovimiento ON tventa.id = tmovimiento.id_venta
      WHERE tventa.fecha BETWEEN '".$vfecha_inicio."' AND '".$vfecha_fin."' AND tventa.estado = 0 
      AND tmovimiento.id_sucursal = ".$num_sucursal;  
    }
    //echo $sql;
    //return;
    return static::query($sql);
  }

  public static function Ventas_DosSemanas(){
    $sql = "SELECT CONCAT('Venta #', tventa.id) as 'id_venta', tventa.fecha AS 'fecha', tpersona.nombre as 'id_empleado', 
    tcategoria.nombre as 'categoria', tmarca.nombre as 'marca',
    tproducto.nombre as 'id_producto', tdetalle_venta.cantidad as 'cantidad',
    CONCAT(tventa.total, 'Bs.') as 'total', tsucursal.nombre AS 'id_sucursal'
    FROM tventa 
    JOIN tdetalle_venta ON tdetalle_venta.id_venta = tventa.id
    JOIN templeado ON tventa.id_empleado = templeado.id
    JOIN tpersona ON templeado.idPersona = tpersona.id
    JOIN tproducto ON tdetalle_venta.id_producto = tproducto.id
    JOIN tcategoria ON tproducto.id_categoria = tcategoria.id
    JOIN tmarca ON tproducto.id_marca = tmarca.id
    JOIN tmovimiento ON tventa.id = tmovimiento.id_venta
    JOIN tsucursal ON tmovimiento.id_sucursal = tsucursal.id
    WHERE tventa.fecha >= (CURDATE()-INTERVAL 2 WEEK) AND tventa.estado = 0";
    return static::query($sql);
  }
//SELECT * from tventa WHERE fecha >= (CURDATE() - INTERVAL 2 WEEK)
  public static function buscar_venta_id($id){
    return static::query("SELECT tventa.id, tventa.fecha, 
    CONCAT(tventa.total,' Bs.') AS 'total', CONCAT(tpersona.nombre, ' ', tpersona.apPaterno, ' ', tpersona.apMaterno) as 'empleado', 
    tproducto.id as 'id_producto', tproducto.talla, 
    tproducto.nombre as 'producto', tdetalle_venta.cantidad, 
    tdetalle_venta.precio, tmarca.nombre as 'marca',
    tcategoria.nombre as 'categoria'
    FROM tventa
    JOIN tdetalle_venta on tventa.id = tdetalle_venta.id_venta
    JOIN tproducto on tdetalle_venta.id_producto = tproducto.id
    JOIN tmarca ON tproducto.id_marca = tmarca.id
    JOIN tcategoria ON tproducto.id_categoria = tcategoria.id
    JOIN tcliente ON tventa.id_cliente = tcliente.id
    JOIN templeado ON tventa.id_empleado = templeado.id
    JOIN tpersona ON templeado.idPersona = tpersona.id
    WHERE tventa.id = ".$id." AND tventa.fecha >= (CURDATE()-INTERVAL 2 WEEK)");    
  }

  public static function buscar_venta_id_noexistente($id){
    return static::query("SELECT tventa.id, tventa.fecha, 
    CONCAT(tventa.total,' Bs.') AS 'total', 
    CONCAT(tpersona.nombre, ' ', tpersona.apPaterno, ' ', tpersona.apMaterno) as 'empleado', 
    tproducto.id as 'id_producto',
    tproducto.nombre as 'producto', tdetalle_venta.cantidad, 
    tproducto.precio as 'precio', tmarca.nombre as 'marca',
    tcategoria.nombre as 'categoria'
    FROM tventa
    JOIN tdetalle_venta on tventa.id = tdetalle_venta.id_venta
    JOIN tproducto on tdetalle_venta.id_producto = tproducto.id
    JOIN tmarca ON tproducto.id_marca = tmarca.id
    JOIN tcategoria ON tproducto.id_categoria = tcategoria.id
    JOIN tcliente ON tventa.id_cliente = tcliente.id
    JOIN templeado ON tventa.id_empleado = templeado.id
    JOIN tpersona ON templeado.idPersona = tpersona.id
    WHERE tventa.id = ".$id);    
  }

}
