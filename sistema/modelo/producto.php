<?php
class producto extends db_object{
    public static $db_tabla = "tproducto"; //Variable para manejar la tabla
    public static $db_campos_tabla = array('nombre', 'talla', 'foto', 'precio', 'id_marca', 'id_categoria', 'id_color', 'id_proveedor'); // Referencia a los campos de la tabla
    public $id;
    public $nombre;
    public $id_color;
    public $talla;
    public $precio;
    public $foto;
    public $id_marca;
    public $id_categoria;
    public $id_proveedor;
    public $estado;
    public $cantidad;
    public $id_sucursal;
    public $id_almacen;
    public $nombre_sucursal;
    public $id_compra;

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

    public static function traer_nombre_productos(){
        return static::query("SELECT nombre FROM ".static::$db_tabla);    
    }
    
    public static function contar_productos(){
        $sql = ("SELECT COUNT(id) as id FROM ".static::$db_tabla);
        if($row = static::query($sql)){
            $id = trim($row[0]->id);
            return $id;
        }
    }
    //USADO EN EL REGISTRAR VENTA
    public function traer_productos_stock($vid_sucursal){
        return static::query("SELECT tproducto.id, tproducto.nombre, tproducto.talla, 
        tproducto.precio, tmarca.nombre as 'id_marca', 
        tcolor.nombre as 'id_color', tcategoria.nombre as 'id_categoria'  
        FROM tproducto
        JOIN tmarca ON tproducto.id_marca = tmarca.id 
        JOIN tcategoria ON tproducto.id_categoria = tcategoria.id 
        JOIN tcolor ON tproducto.id_color = tcolor.id 
        JOIN tproducto_almacen ON tproducto.id = tproducto_almacen.id_producto 
        JOIN talmacen ON tproducto_almacen.id_almacen = talmacen.id
        WHERE tmarca.estado = 0 AND tcategoria.estado = 0 AND tcolor.estado = 0
        AND talmacen.id_sucursal = $vid_sucursal 
        AND tproducto_almacen.cantidad > 0  
        ORDER BY tproducto.id");    
    }
    //USADO PARA MOSTRAR TODOS LOS PRODUCTOS DIVIDIDO POR SUCURSALES
    public function traer_productos_stock_sucursales(){
        return static::query("SELECT tproducto.id, tproducto.nombre, tproducto.talla, 
        CONCAT(tproducto.precio, 'Bs.') as 'precio', tmarca.nombre as 'id_marca', 
        tsucursal.nombre as 'nombre_sucursal', tproducto_almacen.cantidad as 'cantidad',
        tcolor.nombre as 'id_color', tcategoria.nombre as 'id_categoria'  
        FROM tproducto
        JOIN tmarca ON tproducto.id_marca = tmarca.id 
        JOIN tcategoria ON tproducto.id_categoria = tcategoria.id 
        JOIN tcolor ON tproducto.id_color = tcolor.id 
        JOIN tproducto_almacen ON tproducto.id = tproducto_almacen.id_producto 
        JOIN talmacen ON tproducto_almacen.id_almacen = talmacen.id
        JOIN tsucursal ON talmacen.id_sucursal = tsucursal.id
        WHERE tmarca.estado = 0 AND tcategoria.estado = 0 AND tcolor.estado = 0
        AND tproducto_almacen.cantidad > 0  
        ORDER BY tproducto.id");    
    }
    //USADO PARA REGISTRAR COMPRA
    public function traer_productos_nostock(){
        return static::query("SELECT DISTINCT tproducto.id, tproducto.nombre, tproducto.talla, 
        tproducto.precio, tmarca.nombre as 'id_marca', 
        tcolor.nombre as 'id_color', tcategoria.nombre as 'id_categoria'  
        FROM tproducto
        JOIN tmarca ON tproducto.id_marca = tmarca.id 
        JOIN tcategoria ON tproducto.id_categoria = tcategoria.id 
        JOIN tcolor ON tproducto.id_color = tcolor.id 
    
    
        WHERE tmarca.estado = 0 AND tcategoria.estado = 0 AND tcolor.estado = 0
        ORDER BY tproducto.id");    
        //JOIN tproducto_almacen ON tproducto.id = tproducto_almacen.id_producto 
        //JOIN talmacen ON tproducto_almacen.id_almacen = talmacen.id
    }
    //USADO PARA ASIGNAR PRODUCTOS SIN ALMACEN
    public function traer_productos_asignar(){
        return static::query("SELECT tproducto.id,
        tproducto.nombre, tproducto.talla, tcolor.nombre as 'id_color',
        tcategoria.nombre as 'id_categoria', tmarca.nombre as 'id_marca', ttemporal.cantidad as 'cantidad', 
        ttemporal.id_compra as 'id_compra'
        FROM tproducto
        JOIN tmarca ON tproducto.id_marca = tmarca.id 
        JOIN tcategoria ON tproducto.id_categoria = tcategoria.id 
        JOIN tcolor ON tproducto.id_color = tcolor.id 
        JOIN ttemporal ON ttemporal.id_producto = tproducto.id
        JOIN tcompra ON ttemporal.id_compra = tcompra.id
        WHERE tmarca.estado = 0 AND tcategoria.estado = 0 AND tcolor.estado = 0 AND ttemporal.cantidad > 0
        ORDER BY ttemporal.cantidad DESC");    
    }
    //OBSOLETO PERO PORSIACA NO BORRAR
    public function traer_compras_asignar(){
        return static::query("SELECT tcompra.id
        FROM tproducto
        JOIN tmarca ON tproducto.id_marca = tmarca.id 
        JOIN tcategoria ON tproducto.id_categoria = tcategoria.id 
        JOIN tcolor ON tproducto.id_color = tcolor.id 
        JOIN ttemporal ON ttemporal.id_producto = tproducto.id
        JOIN tcompra ON ttemporal.id_compra = tcompra.id
        WHERE tmarca.estado = 0 AND tcategoria.estado = 0 AND tcolor.estado = 0
        AND ttemporal.estado = 1
        ORDER BY tproducto.id");    
    }
    //USADO PARA MOVER PRODUCTOS ENTRE ALMACENES
    public function traer_productos_almacen($vid_almacen){
        $sql = "SELECT tproducto.id, tproducto.nombre, tproducto.talla, 
        tmarca.nombre as 'id_marca', tproducto_almacen.cantidad as 'cantidad',
        tcolor.nombre as 'id_color', tcategoria.nombre as 'id_categoria'  
        FROM tproducto
        JOIN tmarca ON tproducto.id_marca = tmarca.id 
        JOIN tcategoria ON tproducto.id_categoria = tcategoria.id 
        JOIN tcolor ON tproducto.id_color = tcolor.id 
        JOIN tproducto_almacen ON tproducto.id = tproducto_almacen.id_producto 
        WHERE tmarca.estado = 0 AND tcategoria.estado = 0 AND tcolor.estado = 0
        AND tproducto_almacen.cantidad > 0  AND tproducto_almacen.id_almacen = $vid_almacen
        ORDER BY tproducto.id";
        //echo $sql;
        //return;
        return static::query($sql);    
    }
    
}