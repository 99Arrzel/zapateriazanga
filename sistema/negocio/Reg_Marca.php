<?php
include "../../init.php";

$mensaje = "";
if(isset($_POST['nombre'])){
  $aux = strtolower(trim($_POST['nombre']));
  $nombres = marca::traer_nombre_marcas();
  foreach($nombres as  $key=>$datos2){
    if($aux == $datos2->nombre){
        $mensaje = "La marca ya existe";
    }
  }
  if($mensaje != "La marca ya existe"){
    $brand = new marca;
    //Nombre
    $nombre = ucwords(strtolower($_POST['nombre']));
    $nombre = preg_replace('/\s+/', ' ', $nombre);
    $nombre = ltrim(rtrim($nombre));
    if( trim($_POST['nombre']) == ""  ){
      $mensaje = "No deje espacios en blanco.";
    }else{
      $brand->nombre = $nombre;
      $brand->create();
      $mensaje = "Se registro correctamente";
      unset($_POST);
    }
  }else{
    $mensaje = "La marca ya existe";
  }
}
echo $mensaje;
?>
