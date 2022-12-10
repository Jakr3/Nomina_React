<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('content-type: application/json; charset=utf-8');
require 'deduccionModel.php';
$deduccionModel = new deduccionModel();
switch($_SERVER['REQUEST_METHOD']){
    case 'GET';
    $respuesta = $deduccionModel->getDeduccion();
    echo json_encode($respuesta);
    break;
    case 'POST';
    $_POST= json_decode(file_get_contents('php://input',true));
    if(!isset($_POST->nombre) || is_null($_POST->nombre) || empty(trim($_POST->nombre))){
        $respuesta=['error','EL nombre del empleado no debe estar vacia Y no debe tener mas de 12 caracteres'];
    }
    else if(!isset($_POST->D_salario) || is_null($_POST->D_salario) || empty(trim($_POST->D_salario))){
        $respuesta=['error','EL salario del empleado no debe estar vacio Y no debe tener mas de 5 caracteres'];
    }
    else if(!isset($_POST->estado) || is_null($_POST->estado) || empty(trim($_POST->estado))){
        $respuesta=['error','EL espacio no debe estar vacio '];
    }
    else {
        $respuesta = $deduccionModel->saveDeduccion($_POST->nombre,$_POST->D_salario,$_POST->estado);
    }
    echo json_encode($respuesta);

    break;
    case 'PUT';
    $_PUT= json_decode(file_get_contents('php://input',true));
    if(!isset($_PUT->id_deducciones) || is_null($_PUT->id_deducciones) || empty(trim($_PUT->id_deducciones))){
        $respuesta=['error','El Id del ingreso no debe estar vacio'];
    }
    else if(!isset($_PUT->nombre) || is_null($_PUT->nombre) || empty(trim($_PUT->nombre)) || strlen($_PUT->nombre) > 50){
        $respuesta=['error','El nombre del ingreso no debe estar vacio y no debe tener mas de 50 caracteres'];
    }
    else if(!isset($_PUT->D_salario) || is_null($_PUT->D_salario) || empty(trim($_PUT->D_salario)) || strlen($_PUT->D_salario) > 5){
        $respuesta=['error','El espacio no debe estar vacio'];
    }
    else if(!isset($_PUT->estado) || is_null($_PUT->estado) || empty(trim($_PUT->estado))){
        $respuesta=['error','El espacio no debe estar vacio'];
    }
    else {
        $respuesta = $deduccionModel->updateDeduccion($_PUT->id_deducciones,$_PUT->nombre,$_PUT->D_salario,$_PUT->estado);
    }
    echo json_encode($respuesta);
    
    break;
    case 'DELETE';
    $_DELETE= json_decode(file_get_contents('php://input',true));
    if(!isset($_DELETE->id_deducciones) || is_null($_DELETE->id_deducciones) || empty(trim($_DELETE->id_deducciones))){
        $respuesta=['error','El Id del ingreso no debe estar vacio'];
    }
    else {
        $respuesta = $deduccionModel->deleteDeduccion($_DELETE->id_deducciones);
    }
    echo json_encode($respuesta);
    break;

}