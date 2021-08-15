<?php
    class usuario extends db_object{
        public static $db_tabla = "tusuario";
        public static $db_campos_tabla = array('usuario', 'password', 'estado', 'idEmpleado','id_tipo_usuario'); // Referencia a los campos de la tabla
        public $id;
        public $usuario;
        public $password;
        public $confpass;
        public $idEmpleado;
        public $id_tipo_usuario;
        public $estado;
        public $nombre;
        public $ci;
        public $id_sucursal;

        public static function verificar_usuario($vusuario, $vpassword){
            global $database;
            $vusuario = $database->formato_string($vusuario);
            $vpassword = $database->formato_string($vpassword);
            $sql = "SELECT tusuario.id, tusuario.usuario, tusuario.password, 
            tusuario.id_tipo_usuario, tpersona.ci, templeado.id_sucursal, 
            CONCAT(tpersona.nombre, ' ',tpersona.apPaterno, ' ',tpersona.apMaterno) as nombre 
            FROM tusuario ";
            $sql.="JOIN templeado ";
            $sql.="ON tusuario.idEmpleado = templeado.id ";
            $sql.="JOIN tpersona ";
            $sql.="ON templeado.idPersona = tpersona.id ";
            $sql.="WHERE usuario='{$vusuario}' ";
            $sql.="and tusuario.estado = 0 and templeado.estado=0 ";
            $sql.="LIMIT 1";
            $resultado = self::query($sql);
            if(!empty($resultado) || is_null($resultado)){
                if(password_verify($vpassword, $resultado[0]->password)){
                    return array_shift($resultado);
                }else{
                    return false;
                }
            }
            return false;
        }

        //CRUD

        public function create_user(){
            global $database;
            $propiedades = $this->propiedades();
            $sql = "INSERT INTO ".self::$db_tabla."(".implode(", ", array_keys($propiedades)).")";
            $sql .= " VALUES ('".implode("','", array_values($propiedades))."')";
            if($database->consulta($sql)){
                //var_dump($sql);
                return true;
            }else{
                return false;
            }
        }

        public function verificar_password($vusuario, $vpassword){
            global $database;
            $vusuario = $database->formato_string($vusuario);
            $vpassword = $database->formato_string($vpassword);
            $sql ="SELECT password FROM tusuario ";
            $sql.="WHERE usuario='{$vusuario}' ";
            $sql.="and tusuario.estado = 0 ";
            $sql.="LIMIT 1";
            $resultado = self::query($sql);
            if(!empty($resultado) || is_null($resultado)){
                if(password_verify($vpassword, $resultado[0]->password)){
                    return true;
                }else{
                    return false;
                }
            }
            return false;
        }

        public function update_password(){
            global $database;
            $propiedades = $this->propiedades();
            $propiedades_pares = array();
            foreach($propiedades as $key => $value){
                $propiedades_pares[] = "{$key} = '{$value}'";
            }
            $sql = "UPDATE ".static::$db_tabla." SET ";
            $sql .= implode(", ", $propiedades_pares);
            $sql .= " WHERE usuario= '".$database->formato_string($this->usuario)."'";
            //var_dump($sql);
            $database->consulta($sql);
            return (mysqli_affected_rows($database->connection))?true:false;
        }

        public function delete_logico(){
            global $database;
            $sql = "UPDATE ".static::$db_tabla." SET ";
            $sql .= "estado = 1 ";
            $sql .= "WHERE idEmpleado= ".$database->formato_string($this->idEmpleado);
            //echo($sql);
            $database->consulta($sql);
            return (mysqli_affected_rows($database->connection))?true:false;
        }
        public function restaurar(){
            global $database;
            $sql = "UPDATE ".static::$db_tabla." SET ";
            $sql .= "estado = 0 ";
            $sql .= "WHERE idEmpleado= ".$database->formato_string($this->idEmpleado);
            //echo($sql);
            $database->consulta($sql);
            return (mysqli_affected_rows($database->connection))?true:false;
        }

    }
