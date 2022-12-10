<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('content-type: application/json; charset=utf-8');
require 'ingresosModel.php';
$ingresosModel = new ingresosModel();
switch($_SERVER['REQUEST_METHOD']){
    case 'GET';
    $respuesta =  $ingresosModel->getIngresos();
    echo json_encode($respuesta);
    break;
    case 'POST';
    $_POST= json_decode(file_get_contents('php://input',true));
    if(!isset($_POST->nombre) || is_null($_POST->nombre) || empty(trim($_POST->nombre)) || strlen($_POST->nombre) > 50){
        $respuesta=['error','EL nombre del ingreso no debe estar vacio'];
    }
    else if(!isset($_POST->D_salario) || is_null($_POST->D_salario) || empty(trim($_POST->D_salario)) || strlen($_POST->D_salario) > 5){
        $respuesta=['error','Debe seleccionar si depende de salario'];
    }
    else if(!isset($_POST->estado) || is_null($_POST->estado) || empty(trim($_POST->estado)) || strlen($_POST->estado) > 50){
        $respuesta=['error','EL estado no debe estar vacio '];
    }
    else {
        $respuesta = $ingresosModel->saveIngresos($_POST->nombre,$_POST->D_salario,$_POST->estado);
    }
    echo json_encode($respuesta);

    break;
    case 'PUT';
    $_PUT= json_decode(file_get_contents('php://input',true));
    if(!isset($_PUT->id_ingreso) || is_null($_PUT->id_ingreso) || empty(trim($_PUT->id_ingreso))){
        $respuesta=['error','El Id del ingreso no debe estar vacio'];
    }
    else if(!isset($_PUT->nombre) || is_null($_PUT->nombre) || empty(trim($_PUT->nombre)) || strlen($_PUT->nombre) > 50){
        $respuesta=['error','El nombre del ingreso no debe estar vacio'];
    }
    else if(!isset($_PUT->D_salario) || is_null($_PUT->D_salario) || empty(trim($_PUT->D_salario))){
        $respuesta=['error','Debe seleccionar si depende de salario'];
    }
    else if(!isset($_PUT->estado) || is_null($_PUT->estado) || empty(trim($_PUT->estado))){
        $respuesta=['error','El estado no debe estar vacio'];
    }
    else {
        $respuesta = $ingresosModel->updateIngreso($_PUT->id_ingreso,$_PUT->nombre,$_PUT->D_salario,$_PUT->estado);
    }
    echo json_encode($respuesta);
    
    break;
    case 'DELETE';
    $_DELETE= json_decode(file_get_contents('php://input',true));
    if(!isset($_DELETE->id_ingreso) || is_null($_DELETE->id_ingreso) || empty(trim($_DELETE->id_ingreso))){
        $respuesta=['error','El Id del ingreso no debe estar vacio'];
    }
    else {
        $respuesta = $ingresosModel->deleteIngreso($_DELETE->id_ingreso);
    }
    echo json_encode($respuesta);
    break;

}