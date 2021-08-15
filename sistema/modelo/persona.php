<?php
class persona extends db_object{
    public static $db_tabla = "tpersona"; //Variable para manejar la tabla
    public static $db_campos_tabla = array('ci', 'nombre', 'apPaterno', 'apMaterno','telefono', 'direccion'); // Referencia a los campos de la tabla
    public $id;
    public $ci;
    public $nombre;
    public $apPaterno;
    public $apMaterno;
    public $telefono;
    public $direccion;
    public $estado;
    public $sueldo;

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
    
    public static function devolver_ultimoID(){
        $sql = "SELECT id FROM ".self::$db_tabla." ORDER by id DESC LIMIT 1";
        if($row = static::query($sql)){
            $id = trim($row[0]->id);
            return $id;
        }
        return null;
    }

    public static function devolver_personaID_cliente($id){
        $sql = "SELECT tpersona.id FROM ".self::$db_tabla." ";
        $sql.= "join tcliente on tcliente.id_persona=tpersona.id where tcliente.id=".$id;
        if($row = static::query($sql)){
            $id = trim($row[0]->id);
            return $id;
        }
        return null;
    }

    public static function traer_ci(){
        //SQL GOZU para detectar si el CI es igual a uno ya existente, esto usando la
        //EXTENSION. 
        //$sql = "SELECT "."SUBSTRING(ci, 1, CHAR_LENGTH(ci)-2) as ci FROM ".static::$db_tabla;
        return static::query("SELECT ci FROM ".static::$db_tabla);
    }
    
    public static function traer_ci_entero(){
        return static::query("SELECT ci FROM ".static::$db_tabla);
    }

    public static function traer_todo_persona_cliente_habilitados(){
        return static::query("SELECT tpersona.ci, tcliente.id, tpersona.nombre,
        tpersona.apPaterno,tpersona.apMaterno, tpersona.telefono, tpersona.direccion
        FROM tpersona
        JOIN tcliente on tpersona.id = tcliente.id_persona 
        WHERE tcliente.estado = 0 
        ORDER BY tpersona.id");    
    }

    public static function traer_todo_persona_cliente_deshabilitados(){
        return static::query("SELECT tpersona.ci, tcliente.id, tpersona.nombre,
        tpersona.apPaterno,tpersona.apMaterno, tpersona.telefono, tpersona.direccion
        FROM tpersona
        JOIN tcliente on tpersona.id = tcliente.id_persona 
        WHERE tcliente.estado = 1 
        ORDER BY tpersona.id");    
    }

    public static function traer_todo_persona_empleado_habilitados(){
        return static::query("SELECT tpersona.ci, templeado.id, tpersona.nombre,
        tpersona.apPaterno,tpersona.apMaterno, tpersona.telefono, tpersona.direccion , templeado.sueldo 
        FROM tpersona
        JOIN templeado on tpersona.id = templeado.idPersona 
        WHERE templeado.estado = 0 
        ORDER BY tpersona.id");    
    }

    public static function traer_todo_persona_empleado_deshabilitados(){
        return static::query("SELECT tpersona.ci, templeado.id, tpersona.nombre,
        tpersona.apPaterno,tpersona.apMaterno, tpersona.telefono, tpersona.direccion, templeado.sueldo
        FROM tpersona
        JOIN templeado on tpersona.id = templeado.idPersona 
        WHERE templeado.estado = 1 
        ORDER BY tpersona.id");    
    }

    public static function buscar_persona_cliente($id){
        return static::query("SELECT tpersona.ci, tcliente.id, tpersona.nombre,
        tpersona.apPaterno,tpersona.apMaterno, tpersona.telefono, tpersona.direccion
        FROM tpersona
        JOIN tcliente on tpersona.id = tcliente.id_persona 
        WHERE tcliente.id = $id ");    
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
        //return;
        $database->consulta($sql);
        return (mysqli_affected_rows($database->connection))?true:false;
    }

    /*
        public static function traer_clientes(){
            return static::query("SELECT * FROM ".static::$db_tabla." 
            JOIN cliente ON ".static::$db_tabla.".id = cliente.persona_id WHERE cliente.estado=0");
        }

        public static function buscar($id){
            $sql = "SELECT * FROM ".static::$db_tabla." WHERE id = ".$id;
            return static::query($sql);
        }

        public static function traer_todo_persona(){
            return static::query("SELECT * FROM ".static::$db_tabla);    
        }

    */

}