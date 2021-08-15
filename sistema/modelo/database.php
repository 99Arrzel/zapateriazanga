<?php
//EL INIT ESTABA EN CONTROL, PORSIACASO ACORDATE 🤡.
//require_once("../conexion.php");
class database{
    public $connection;
    function __construct()
    {
        $this->conectar();
    }

    public function conectar(){
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if($this->connection-> connect_errno){ 
            die("Error de conexion".$this->connection);
        }
    }

    public function consulta($sql){ 
        $resultado=$this->connection->query($sql);
        $this->confirmar_consulta($resultado);
        return $resultado;
    }

    private function confirmar_consulta($resultado){
        if(!$resultado){
            die("Error de consulta ".$this->connection->error);
        }
    }

    public function formato_string($string){
        return $consulta_formateada=$this->connection->real_escape_string($string);
    }

    public function ultima_id(){
        return mysqli_insert_id($this->connection);
    }
}

$database = new database();
