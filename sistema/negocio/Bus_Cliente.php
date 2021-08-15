<?php
include "../../init.php";//SI O SI NECESITAMOS ESTA WEA

//$res = array();

    //$persona = new persona();
    $id = $_REQUEST['id_cliente'];//get ci
    $res = persona::buscar_persona_cliente($id);

    /*if(count($res)==0) echo 'No se encontro cliente';
    else */
    echo json_encode($res);//MENSAJE Q LE DEVOLVEMOS AL AJAX
?>