<?php
class db_object{

    public static function query($q){
        global $database;
        $res = $database->consulta($q);
        $array_objeto = array();
        while($row=mysqli_fetch_array($res)){
            $array_objeto[] = static :: instanciacion($row);
        }
        return $array_objeto;
    }

    private function tiene_atributos($atributo){
        $prop = get_object_vars($this);
        return array_key_exists($atributo, $prop);
    }

    public static function instanciacion($registro){
        $llamando = get_called_class();
        $objeto = new $llamando;
        foreach($registro as $atributo => $valor){
            if($objeto->tiene_atributos($atributo)){
                $objeto->$atributo = $valor;
            }
        }
        return $objeto;
    }

    public function propiedades(){
        $propiedades = array();
        foreach(static::$db_campos_tabla as $campo){ 
            if(property_exists($this, $campo)){
                $aux = $this->$campo;
                if(strcmp($aux,"") !== 0 && !is_null($aux)){
                    $propiedades[$campo] = $this->$campo; 
                }
            }
        }
        return $propiedades;
    }

}
