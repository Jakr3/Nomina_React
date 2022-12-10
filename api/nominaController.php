<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('content-type: application/json; charset=utf-8');
require 'empleadoModel.php';
$empleadoModel = new empleadoModel();
switch($_SERVER['REQUEST_METHOD']){
    case 'GET';
    $respuesta =  $empleadoModel->getEmpleados();
    echo json_encode($respuesta);
    break;
    case 'POST';
    $_POST= json_decode(file_get_contents('php://input',true));
    if(!isset($_POST->cedula) || is_null($_POST->cedula) || empty(trim($_POST->cedula)) || strlen($_POST->cedula) > 12){
        $respuesta=['error','La cedula del empleado no debe estar vacia Y no debe tener mas de 12 caracteres'];
    }
    else if(!isset($_POST->nombre) || is_null($_POST->nombre) || empty(trim($_POST->nombre)) || strlen($_POST->nombre) > 80){
        $respuesta=['error','EL nombre del empleado no debe estar vacio Y no debe tener mas de 80 caracteres'];
    }
    else if(!isset($_POST->salario) || is_null($_POST->salario) || empty(trim($_POST->salario)) || !is_numeric($_POST->salario) > 20){
        $respuesta=['error','EL salario del empleado no debe estar vacio, debe ser numerico y menos de 20 digitos'];
    }
    else if(!isset($_POST->id_nomina) || is_null($_POST->id_nomina) || empty(trim($_POST->id_nomina))){
        $respuesta=['error','EL identificador de nomina del empleado no debe estar vacio'];
    }
    else {
        $respuesta = $empleadoModel->saveEmpleados($_POST->cedula,$_POST->nombre,$_POST->salario,$_POST->id_nomina);
    }
    echo json_encode($respuesta);

    break;
    case 'PUT';
    $_PUT= json_decode(file_get_contents('php://input',true));
    if(!isset($_PUT->id_empleado) || is_null($_PUT->id_empleado) || empty(trim($_PUT->id_empleado))){
        $respuesta=['error','El Id del empleado no debe estar vacio'];
    }
    else if(!isset($_PUT->cedula) || is_null($_PUT->cedula) || empty(trim($_PUT->cedula)) || strlen($_PUT->cedula) > 12){
        $respuesta=['error','La cedula del empleado no debe estar vacia Y no debe tener mas de 12 caracteres'];
    }
    else if(!isset($_PUT->nombre) || is_null($_PUT->nombre) || empty(trim($_PUT->nombre)) || strlen($_PUT->nombre) > 80){
        $respuesta=['error','El nombre del empleado no debe estar vacio y no debe tener mas de 80 caracteres'];
    }
    else if(!isset($_PUT->salario) || is_null($_PUT->salario) || empty(trim($_PUT->salario)) || !is_numeric($_PUT->salario) > 20){
        $respuesta=['error','El salario del empleado no debe estar vacio, debe ser numerico y menos de 20 digitos'];
    }
    else if(!isset($_PUT->id_nomina) || is_null($_PUT->id_nomina) || empty(trim($_PUT->id_nomina))){
        $respuesta=['error','El id_nomina del empleado no debe estar vacio'];
    }
    else {
        $respuesta = $empleadoModel->updateEmpleado($_PUT->id_empleado,$_PUT->cedula,$_PUT->nombre,$_PUT->salario,$_PUT->id_nomina);
    }
    echo json_encode($respuesta);
    
    break;
    case 'DELETE';
    $_DELETE= json_decode(file_get_contents('php://input',true));
    if(!isset($_DELETE->id_empleado) || is_null($_DELETE->id_empleado) || empty(trim($_DELETE->id_empleado))){
        $respuesta=['error','El Id del empleado no debe estar vacio'];
    }
    else {
        $respuesta = $empleadoModel->deleteEmpleado($_DELETE->id_empleado);
    }
    echo json_encode($respuesta);
    break;

}