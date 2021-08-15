<?php
class marca extends db_object{
    public static $db_tabla = "tmarca"; //Variable para manejar la tabla
    public static $db_campos_tabla = array('id', 'nombre'); // Referencia a los campos de la tabla
    public $id;
    public $nombre;
    
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
    
    public static function traer_nombre_marcas(){
        return static::query("SELECT LOWER(nombre) as nombre FROM ".static::$db_tabla);    
    }

    public static function traer_marcas_habilitadas(){
        return static::query("SELECT * FROM ".static::$db_tabla. " WHERE estado = 0;");
    }

    public static function traer_marcas_deshabilitadas(){
        return static::query("SELECT * FROM ".static::$db_tabla. " WHERE estado = 1;");
    }

    public static function contar_marcas_habilitadas(){
        $sql = ("SELECT COUNT(id) as id FROM ".static::$db_tabla." WHERE estado = 0");
        if($row = static::query($sql)){
            $id = trim($row[0]->id);
            return $id;
        }
    }
    
    public static function contar_marcas_deshabilitadas(){
        $sql = ("SELECT COUNT(id) as id FROM ".static::$db_tabla." WHERE estado = 1");
        if($row = static::query($sql)){
            $id = trim($row[0]->id);
            return $id;
        }
    }

    public function update(){
        global $database;
        $propiedades = $this->propiedades();
        $propiedades_pares = array();
        foreach($propiedades as $key => $value){
            $propiedades_pares[] = "{$key} = '{$value}'";
        }
        $sql = "UPDATE ".static::$db_tabla." SET ";
        $sql .= implode(", ", $propiedades_pares);
        $sql .= " WHERE id= ".$database->formato_string($this->id);
        //var_dump($sql);
        $database->consulta($sql);
        return (mysqli_affected_rows($database->connection))?true:false;
    }

    public function delete_logico(){
        global $database;
        $sql = "UPDATE ".static::$db_tabla." SET ";
        $sql .= "estado = 1 ";
        $sql .= "WHERE id= ".$database->formato_string($this->id);
        //echo($sql);
        $database->consulta($sql);
        return (mysqli_affected_rows($database->connection))?true:false;
    }

    public function restaurar(){
        global $database;
        $sql = "UPDATE ".static::$db_tabla." SET ";
        $sql .= "estado = 0 ";
        $sql .= "WHERE id= ".$database->formato_string($this->id);
        //echo($sql);
        $database->consulta($sql);
        return (mysqli_affected_rows($database->connection))?true:false;
    }

    public static function buscar_marcas_habilitadas($word){
        return static::query("SELECT * FROM ".static::$db_tabla. " WHERE id LIKE '%".$word."%' 
        OR nombre LIKE '%".$word."%' AND estado = 0");
    }

    public static function buscar_marcas_deshabilitadas($word){
        return static::query("SELECT * FROM ".static::$db_tabla. " WHERE id LIKE '%".$word."%' 
        OR nombre LIKE '%".$word."%' AND estado = 1");
    }

    
}
