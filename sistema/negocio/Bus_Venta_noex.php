<?php
include "../../init.php";//SI O SI NECESITAMOS ESTA WEA

//$res = array();

    //$persona = new persona();
    $id = $_REQUEST['id_venta'];//get ci
    $res = venta::buscar_venta_id_noexistente($id);

    /*if(count($res)==0) echo 'No se encontro cliente';
    else */
    echo json_encode($res);//MENSAJE Q LE DEVOLVEMOS AL AJAX
?>