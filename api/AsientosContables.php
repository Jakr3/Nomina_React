<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('content-type: application/json; charset=utf-8');
require 'AsientosContableMod.php';
$AsientosContableMod = new AsientosContableMod();
switch($_SERVER['REQUEST_METHOD']){
    case 'GET';
    $respuesta =  $AsientosContableMod->getAsientos();
    echo json_encode($respuesta);
    break;
    case 'POST';
    $_POST= json_decode(file_get_contents('php://input',true));
    if(!isset($_POST->descripcion) || is_null($_POST->descripcion) || empty(trim($_POST->descripcion)) || strlen($_POST->descripcion) > 150){
        $respuesta=['error','La cedula del empleado no debe estar vacia Y no debe tener mas de 12 caracteres'];
    }
    else if(!isset($_POST->id_empleado) || is_null($_POST->id_empleado) || empty(trim($_POST->id_empleado)) || strlen($_POST->id_empleado) > 80){
        $respuesta=['error','EL nombre del empleado no debe estar vacio Y no debe tener mas de 80 caracteres'];
    }
    else if(!isset($_POST->cuenta) || is_null($_POST->cuenta) || empty(trim($_POST->cuenta)) || !is_numeric($_POST->cuenta) > 20){
        $respuesta=['error','EL salario del empleado no debe estar vacio, debe ser numerico y menos de 20 digitos'];
    }
    else if(!isset($_POST->tipo_movimiento) || is_null($_POST->tipo_movimiento) || empty(trim($_POST->tipo_movimiento))){
        $respuesta=['error','EL identificador de nomina del empleado no debe estar vacio'];
    }
    else if(!isset($_POST->fecha)){
        $respuesta=['error','EL identificador de nomina del empleado no debe estar vacio'];
    }
    else if(!isset($_POST->monto) || is_null($_POST->monto) || empty(trim($_POST->monto))){
        $respuesta=['error','EL identificador de nomina del empleado no debe estar vacio'];
    }
    else if(!isset($_POST->estado)){
        $respuesta=['error','EL identificador de nomina del empleado no debe estar vacio'];
    }
    else {
        $respuesta = $AsientosContableMod->saveAsiento($_POST->descripcion,$_POST->id_empleado,$_POST->cuenta,$_POST->tipo_movimiento,$_POST->fecha,$_POST->monto,$_POST->estado);
    }
    echo json_encode($respuesta);

    break;
    case 'PUT';
    $_PUT= json_decode(file_get_contents('php://input',true));
    if(!isset($_PUT->id_asiento) || is_null($_PUT->id_asiento) || empty(trim($_PUT->id_asiento))){
        $respuesta=['error','La cedula del empleado no debe estar vacia Y no debe tener mas de 12 caracteres'];
    }
    if(!isset($_PUT->descripcion) || is_null($_PUT->descripcion) || empty(trim($_PUT->descripcion)) || strlen($_PUT->descripcion) > 150){
        $respuesta=['error','La cedula del empleado no debe estar vacia Y no debe tener mas de 12 caracteres'];
    }
    else if(!isset($_PUT->id_empleado) || is_null($_PUT->id_empleado) || empty(trim($_PUT->id_empleado)) || strlen($_PUT->id_empleado) > 80){
        $respuesta=['error','EL nombre del empleado no debe estar vacio Y no debe tener mas de 80 caracteres'];
    }
    else if(!isset($_PUT->cuenta) || is_null($_PUT->cuenta) || empty(trim($_PUT->cuenta)) || !is_numeric($_PUT->cuenta) > 20){
        $respuesta=['error','EL salario del empleado no debe estar vacio, debe ser numerico y menos de 20 digitos'];
    }
    else if(!isset($_PUT->tipo_movimiento) || is_null($_PUT->tipo_movimiento) || empty(trim($_PUT->tipo_movimiento))){
        $respuesta=['error','EL identificador de nomina del empleado no debe estar vacio'];
    }
    else if(!isset($_PUT->fecha)){
        $respuesta=['error','EL identificador de nomina del empleado no debe estar vacio'];
    }
    else if(!isset($_PUT->monto) || is_null($_PUT->monto) || empty(trim($_PUT->monto))){
        $respuesta=['error','EL identificador de nomina del empleado no debe estar vacio'];
    }
    else if(!isset($_PUT->estado)){
        $respuesta=['error','EL identificador de nomina del empleado no debe estar vacio'];
    }
    else {
        $respuesta = $AsientosContableMod->updateAsiento($_PUT->id_asiento,$_PUT->descripcion,$_PUT->id_empleado,$_PUT->cuenta,$_PUT->tipo_movimiento,$_PUT->fecha,$_PUT->monto,$_PUT->estado);
    }
    echo json_encode($respuesta);
    
    break;
    case 'DELETE';
    $_DELETE= json_decode(file_get_contents('php://input',true));
    if(!isset($_DELETE->id_asiento) || is_null($_DELETE->id_asiento) || empty(trim($_DELETE->id_asiento))){
        $respuesta=['error','El Id del empleado no debe estar vacio'];
    }
    else {
        $respuesta = $AsientosContableMod->deleteAsiento($_DELETE->id_asiento);
    }
    echo json_encode($respuesta);
    break;

}