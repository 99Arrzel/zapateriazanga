<?php
include "../../init.php";//SI O SI NECESITAMOS ESTA WEA

$mensaje = "";
//if(isset($_POST["accion"])) $mensaje = $_POST["accion"];


if(isset($_POST['ci'],$_POST['nombre'],$_POST['apPaterno'],$_POST['apMaterno'],$_POST['telefono'])){
    $persona = new persona();
    $cliente = new cliente();
    $idCliente = (isset($_POST['id']))?$_POST['id']:"";
    $persona->ci = trim($_POST['ci']);//get ci
    
    // $cis = Persona::traer_ci();//traer todos los ci de la bd
    // foreach($cis as  $key=>$datos2){//comparar el ci ingresado con los de la bd
    //     if(trim($_POST['ci']) == $datos2->ci){
    //         $mensaje = "El cliente ya existe";
    //     }
    // }
    //Nombre
    $nombre = ucwords(strtolower($_POST['nombre']));
    $nombre = preg_replace('/\s+/', ' ', $nombre);
    $nombre = ltrim(rtrim($nombre));
    //ApellidoP
    $apPaterno = ucwords(strtolower($_POST['apPaterno']));
    $apPaterno = preg_replace('/\s+/', ' ', $apPaterno);
    $apPaterno = ltrim(rtrim($apPaterno));
    //ApellidoM
    $apMaterno = ucwords(strtolower($_POST['apMaterno']));
    $apMaterno = preg_replace('/\s+/', ' ', $apMaterno);
    $apMaterno = ltrim(rtrim($apMaterno));
    //Insertando
    $persona->ci        = trim($_POST['ci']);
    $persona->nombre    = $nombre;
    $persona->apPaterno = $apPaterno;
    $persona->apMaterno = $apMaterno;
    $persona->telefono  = trim($_POST['telefono']);
    $persona->direccion = "N/A";
    $accion = $_POST["accion"];//obtener la accion del boton
    //$mensaje = "";
    //VALIDAR ESPACIOS EN BLANCO
    if( trim($_POST['ci']) == ""        || trim($_POST['nombre']) == ""     ||
        trim($_POST['apPaterno']) == "" || trim($_POST['apMaterno'])== ""   ||
        trim($_POST['telefono']) == ""  ){
        $mensaje = "No deje espacios en blanco";
    }else{
        switch($accion){
            case "insert":
                $cis = Persona::traer_ci_entero();
                foreach($cis as  $key=>$datos2){//comparar el ci ingresado con los de la bd
                    if(trim($_POST['ci']) == $datos2->ci){
                        $mensaje = "El cliente ya existe";
                        break;
                    }
                }
                if($mensaje != "El cliente ya existe"){
                    if(strlen($_POST['telefono']) == 8){
                        $persona->create();
                        $per_id = persona::devolver_ultimoID();
                        $client = new cliente();
                        $client->id_persona = $per_id;
                        $client->create();
                        $mensaje = "Se registro correctamente";
                        unset($_POST);
                    }else{
                        $mensaje = "Porfavor escriba un número valido";
                    }
                }
            break;
            case "update":
                if ($idCliente!="") {
                    $per_id = persona::devolver_personaID_cliente($idCliente);
                    $persona->id=$per_id;
                    $persona->update();
                    $mensaje = "Se actualizo correctamente";
                    unset($_POST);
                }else{
                    $mensaje = "Ingrese una ID";
                }
                
            break;
            case "delete":
                if($idCliente!=""){
                    $cliente->id=$idCliente;
                    $cliente->delete_logico();
                    $mensaje = "Se elimino correctamente";
                    unset($_POST);
                }else{
                    $mensaje = "Ingrese una ID";
                }
                
            break;
        }
        
    }
}
echo $mensaje;//MENSAJE Q LE DEVOLVEMOS AL AJAX
?>