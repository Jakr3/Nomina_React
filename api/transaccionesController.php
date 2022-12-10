<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('content-type: application/json; charset=utf-8');
require 'transaccionesModel.php';
$transaccionesModel = new transaccionesModel();
switch($_SERVER['REQUEST_METHOD']){
    case 'GET';
    $respuesta =  $transaccionesModel->getTrasaccion();
    echo json_encode($respuesta);
    break;
    case 'POST';
    $_POST= json_decode(file_get_contents('php://input',true));
    if(!isset($_POST->id_empleado) || is_null($_POST->id_empleado) || empty(trim($_POST->id_empleado))){
        $respuesta=['error','EL Id del empleado no debe estar vacio'];
    }
    else if(!isset($_POST->id_deducciones) || is_null($_POST->id_deducciones) || empty(trim($_POST->id_deducciones))) {
        $respuesta=['error','EL Id de la deduccion no debe estar vacio'];
    }
    else if(!isset($_POST->id_ingreso) || is_null($_POST->id_ingreso) || empty(trim($_POST->id_ingreso))){
        $respuesta=['error','EL Id del ingreso no debe estar vacio'];
    }
    else if(!isset($_POST->tipo_transaccion) || is_null($_POST->tipo_transaccion) || empty(trim($_POST->tipo_transaccion))){
        $respuesta=['error','EL tipo de transaccion no debe estar vacio'];
    }
    else if(!isset($_POST->fecha) || is_null($_POST->fecha) || empty(trim($_POST->fecha))){
        $respuesta=['error','La fecha de la transaccion no debe estar vacio'];
    }
    else if(!isset($_POST->monto) || is_null($_POST->monto) || empty(trim($_POST->monto))){
        $respuesta=['error','EL monto de la transaccion no debe estar vacio'];
    }
    else if(!isset($_POST->estado) || is_null($_POST->estado) || empty(trim($_POST->estado))){
        $respuesta=['error','EL estado  de transaccion no debe estar vacio'];
    }
    
    else {
        $respuesta = $transaccionesModel->savetransacciones($_POST->id_empleado,$_POST->id_deducciones,$_POST->id_ingreso,$_POST->tipo_transaccion,$_POST->fecha,$_POST->monto,$_POST->estado,$_POST->id_asiento);
    }
    echo json_encode($respuesta);

    break;
    case 'PUT';
    $_PUT= json_decode(file_get_contents('php://input',true));
    if(!isset($_PUT->id_transaccion) || is_null($_PUT->id_transaccion) || empty(trim($_PUT->id_transaccion))){
        $respuesta=['error','El Id de la transaccion no debe estar vacia'];
    }
    if(!isset($_PUT->id_empleado) || is_null($_PUT->id_empleado) || empty(trim($_PUT->id_empleado))){
        $respuesta=['error','EL Id del empleado no debe estar vacio'];
    }
    else if(!isset($_PUT->id_deducciones) || is_null($_PUT->id_deducciones) || empty(trim($_PUT->id_deducciones)) || strlen($_PUT->id_deducciones) > 80){
        $respuesta=['error','EL Id de la deduccion no debe estar vacio'];
    }
    else if(!isset($_PUT->id_ingreso) || is_null($_PUT->id_ingreso) || empty(trim($_PUT->id_ingreso)) || !is_numeric($_PUT->id_ingreso) > 20){
        $respuesta=['error','EL Id del ingreso no debe estar vacio'];
    }
    else if(!isset($_PUT->tipo_transaccion) || is_null($_PUT->tipo_transaccion) || empty(trim($_PUT->tipo_transaccion))){
        $respuesta=['error','EL tipo de transaccion no debe estar vacio'];
    }
    else if(!isset($_PUT->fecha) || is_null($_PUT->fecha) || empty(trim($_PUT->fecha))){
        $respuesta=['error','La fecha de la transaccion no debe estar vacio'];
    }
    else if(!isset($_PUT->monto) || is_null($_PUT->monto) || empty(trim($_PUT->monto))){
        $respuesta=['error','EL monto de la transaccion no debe estar vacio'];
    }
    else if(!isset($_PUT->estado) || is_null($_PUT->estado) || empty(trim($_PUT->estado))){
        $respuesta=['error','EL estado  de transaccion no debe estar vacio'];
    }
    
    else {
        $respuesta = $transaccionesModel->updatetransacciones($_PUT->id_transaccion,$_PUT->id_empleado,$_PUT->id_deducciones,$_PUT->id_ingreso,$_PUT->tipo_transaccion,$_PUT->fecha,$_PUT->monto,$_PUT->estado,$_PUT->id_asiento);
    }
    echo json_encode($respuesta);
    
    break;
    case 'DELETE';
    $_DELETE= json_decode(file_get_contents('php://input',true));
    if(!isset($_DELETE->id_transaccion) || is_null($_DELETE->id_transaccion) || empty(trim($_DELETE->id_transaccion))){
        $respuesta=['error','El Id del empleado no debe estar vacio'];
    }
    else {
        $respuesta = $transaccionesModel->deletetransacciones($_DELETE->id_transaccion);
    }
    echo json_encode($respuesta);
    break;

}