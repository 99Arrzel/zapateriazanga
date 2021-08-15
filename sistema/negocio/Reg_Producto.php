<?php
include "../../init.php";

$mensaje = "";
if(isset($_POST['nombre'],$_POST['talla'],$_POST['precio'])){
  if(trim($_POST['nombre']) == "" || trim($_POST['talla']) == "" || trim($_POST['precio']) == ""){
    $mensaje = "No deje espacios en blanco";
  }else{
    //Guardando imagen
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];   
    $folder = "image/".$filename;
    var_dump($filename);
    
    //Instanciando
    $product = new producto;
    //Corrigiendo Nombre
    $nombre = ucwords(strtolower($_POST['nombre']));
    $nombre = preg_replace('/\s+/', ' ', $nombre);
    $nombre = ltrim(rtrim($nombre));
    
    $product->nombre = $nombre;
    $product->talla = $_POST['talla'];
    $product->foto = $filename;
    
    $product->precio = $_POST['precio'];
    $product->id_marca = $_POST['id_marca'];
    $product->id_categoria = $_POST['id_categoria'];
    $product->id_color = $_POST['id_color'];
    $product->id_proveedor = $_POST['id_proveedor'];

    $product->create();
    unset($_POST);
  }
}
echo $mensaje;
?>