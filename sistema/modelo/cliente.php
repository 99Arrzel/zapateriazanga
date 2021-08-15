<?php
class cliente extends db_object{
    public static $db_tabla = "tcliente"; //Variable para manejar la tabla
    public static $db_campos_tabla = array('id', 'id_persona'); // Referencia a los campos de la tabla
    public $id;
    public $id_persona;

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

    public static function contar_clientes_habilitados(){
        $sql = ("SELECT COUNT(id) as id FROM ".static::$db_tabla." WHERE estado = 0 ");
        if($row = static::query($sql)){
            $id = trim($row[0]->id);
            return $id;
        }
    }

    public static function contar_clientes_deshabilitados(){
        $sql = ("SELECT COUNT(id) as id FROM ".static::$db_tabla." WHERE estado = 1 ");
        if($row = static::query($sql)){
            $id = trim($row[0]->id);
            return $id;
        }
    }

    public static function traer_clientes_habilitados(){
        return static::query("SELECT * FROM ".static::$db_tabla." WHERE estado = 0");
    }

    public static function traer_clientes_deshabilitados(){
        return static::query("SELECT * FROM ".static::$db_tabla." WHERE estado = 1");
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

}
