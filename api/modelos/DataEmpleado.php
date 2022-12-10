<?php
sleep(1);
include('config.php');
date_default_timezone_set('America/Bogota');
$zonahoraria = date_default_timezone_get();

$id_transaccion         = $_POST['id_transaccion'];
$fechaInicio    = strtotime($_REQUEST['fechaInicio']);
$fechaFin       = strtotime($_REQUEST['fechaFin']);


$dia = 86400; # 24 horas * 60 minutos por hora * 60 segundos por minuto  (24*60*60)
for($i = $fechaInicio; $i<= $fechaFin; $i+=$dia){
    $fechaUno = date("d-m-Y", $i);
    $QueryInsert = ("SELECT * FROM transacciones(
        id_transaccion,
        fechaInicio,
        fechaFin
    )
    VALUES (
        '".$id_transaccion. "',
        '".$fechaUno."',
        '".$fechaUno."'
    )");
    $Insert = mysqli_query($con, $QueryInsert); 
}

 include('empleados.php');
?>