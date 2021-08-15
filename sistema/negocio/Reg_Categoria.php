<?php
include "../../init.php";

if(isset($_POST['nombre'])){
  $aux = strtolower(trim($_POST['nombre']));
  $nombres = categoria::traer_nombre_categorias();
  foreach($nombres as  $key=>$datos2){
    if($aux == $datos2->nombre){
      $mensaje = "La categoria ya existe";
    }
  }
  if($mensaje != "La categoria ya existe"){
      $category = new categoria;
      //Nombre
      $nombre = ucwords(strtolower($_POST['nombre']));
      $nombre = preg_replace('/\s+/', ' ', $nombre);
      $nombre = ltrim(rtrim($nombre));
      if( trim($_POST['nombre']) == ""  ){
          $mensaje = "No deje espacios en blanco.";
      }else{
          $category->nombre = trim($_POST['nombre']);
          $category->create();
          $mensaje = "Se registro correctamente";
          unset($_POST);
      }
  }else{
      $mensaje = "La categoria ya existe";
  }
}
echo $mensaje;
?>
