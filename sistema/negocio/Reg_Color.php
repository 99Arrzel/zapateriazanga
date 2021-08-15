<?php
include "../../init.php";

$mensaje = "";
if(isset($_POST['nombre'])){
	$aux = strtolower(trim($_POST['nombre']));
  $nombres = color::traer_nombre_colores();
  foreach($nombres as  $key=>$datos2){
    if($aux == $datos2->nombre){
        $mensaje = "El color ya existe";
    }
  }
  if($mensaje != "El color ya existe"){
    $color = new color;
    //Nombre
    $nombre = ucwords(strtolower($_POST['nombre']));
    $nombre = preg_replace('/\s+/', ' ', $nombre);
    $nombre = ltrim(rtrim($nombre));
    if( trim($_POST['nombre']) == ""  ){
      $mensaje = "No deje espacios en blanco.";
    }else{
      $color->nombre = $nombre;
      $color->create();
      $mensaje = "Se registro correctamente";
      unset($_POST);
    }
  }else{
    $mensaje = "El color ya existe";
  }
}
echo $mensaje;
?>
