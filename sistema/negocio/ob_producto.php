<?php
include "../../init.php";
$mensaje = "";
if(isset($_POST['id'],$_POST['nombre'],$_POST['talla'],$_POST['precio'])){
    $v1 = array($_POST['id'],$_POST['nombre'],$_POST['talla'],
    $_POST['precio'],$_POST['id_color'],$_POST['id_categoria'],$_POST['id_marca']);
}
echo json_encode($v1);//MENSAJE Q LE DEVOLVEMOS AL AJAX
?>
