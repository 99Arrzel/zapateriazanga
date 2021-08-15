<?php
include "../../init.php";
$mensaje = "";
if(isset($_POST['nombre'], $_POST['telefono'])){
    $provider = new proveedor;
    $aux = strtolower(trim($_POST['nombre']));
    $aux = preg_replace('/\s+/', ' ', $aux);
    $aux = ltrim(rtrim($aux));
    $nombres = proveedor::traer_nombre_proveedores();
    foreach($nombres as  $key=>$datos2){
        if($aux == $datos2->nombre){
            $mensaje = "El proveedor ya existe";
        }
    }
    if($mensaje != "El proveedor ya existe"){
        //Nombre
        $nombre = ucwords(strtolower($_POST['nombre']));
        $nombre = preg_replace('/\s+/', ' ', $nombre);
        $nombre = ltrim(rtrim($nombre));
        //$mensaje = "";
        if( trim($_POST['nombre']) == ""        || trim($_POST['telefono']) == ""){
            $mensaje = "No deje espacios en blanco.";
        }else{
            if(strlen($_POST['telefono']) == 8){
                $provider->nombre = $nombre;
                //$provider->telefono = trim($_POST['telefono']);
                $provider->telefono = trim($_POST['telefono']);
                $provider->create();
                $mensaje = "Se registro correctamente";
                unset($_POST);
            }else{
                $mensaje = "Porfavor escriba un número valido";
            }
        }
    }else{
        $mensaje = "El proveedor ya existe";
    }
}
echo $mensaje;
?>
