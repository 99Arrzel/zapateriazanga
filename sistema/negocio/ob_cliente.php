<?php
include "../../init.php";
$mensaje = "";
if(isset($_POST['ci'],$_POST['nombre'],$_POST['apPaterno'],$_POST['apMaterno'],$_POST['telefono'])){
    $v1 = array($_POST['ci'],$_POST['nombre'],$_POST['apPaterno'],$_POST['apMaterno'],$_POST['telefono']);
}
echo json_encode($v1);//MENSAJE Q LE DEVOLVEMOS AL AJAX
?>
