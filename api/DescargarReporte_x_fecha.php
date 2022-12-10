<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> <!--Importante--->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descargar</title>
    <style>
    .color{
        background-color: #9BB;  
    }
</style>
</head>
<body>
    
<?php
include('modelos/config.php');
$fecha = date("d_m_Y");


/**PARA FORZAR LA DESCARGA DEL EXCEL */
header("Content-Type: text/html;charset=utf-8");
header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
$filename = "ReporteExcel_" .$fecha. ".xls";
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Disposition: attachment; filename=" . $filename . "");


/***RECIBIENDO LAS VARIABLE DE LA FECHA */
$fechaInit = $_POST['fecha'];
$fechaFin  = $_POST['fechaFin'];


/*
$sqlTrabajadores = ("select * from trabajadores where (fecha_ingreso>='$fechaInit' and fecha_ingreso<='$fechaFin') order by fecha_ingreso desc");
$sqlTrabajadores = ("SELECT * FROM trabajadores WHERE fecha_ingreso BETWEEN '$fechaInit' AND '$fechaFin' order by fecha_ingreso desc
$sqlTrabajadores = ("SELECT * FROM `trabajadores` WHERE fecha_ingreso BETWEEN '$fechaInit' AND '$fechaFin'
$sqlTrabajadores = ("select * from trabajadores where fecha_ingreso >= '$fechaInit' and fecha_ingreso < '$fechaFin';
$sqlTrabajadores = ("SELECT * FROM trabajadores WHERE fecha_ingreso BETWEEN '$fechaInit' AND '$fecha2' ORDER BY fecha_ingreso DESC
*/                       

$sqlTrabajadores = ("SELECT * FROM transacciones WHERE (fecha>='$fechaInit' and fecha<='$fechaFin') ORDER BY fecha ASC");
$query = mysqli_query($con, $sqlTrabajadores);
?>


<table style="text-align: center;" border='1' cellpadding=1 cellspacing=1>
<thead>
    <tr style="background: #D0CDCD;">
    <th scope="col">#</th>
                    <th scope="col">Id Empleado</th>
                    <th scope="col">Id Deduccion</th>
                    <th scope="col">Id ingreso</th>
                    <th scope="col">Tipo de transaccion</th>
                    <th scope="col">Fecha </th>
                    <th scope="col">monto </th>
                    <th scope="col">estado </th>
                    
    </tr>
</thead>
<?php
$sumador = 0;
$i =1;
    while ($dataRow = mysqli_fetch_array($query)) { ?>
    <tbody>
        <tr>
        <td><?php echo $i++; ?></td>
                    <td><?php echo $dataRow['id_empleado']; ?></td> 
                    <td><?php echo $dataRow['id_deducciones']; ?></td>
                    <td><?php echo $dataRow['id_ingreso'] ; ?></td>
                    <td><?php echo $dataRow['tipo_transaccion'] ; ?></td>
                    <td><?php echo $dataRow['fecha'] ; ?></td>
                    <td><?php echo $dataRow['monto'] ; ?></td>
                    <td><?php echo $dataRow['estado'] ; ?></td>
                    <td><?php $sumador = $sumador + $dataRow['monto'] ; ?></td>
        </tr>
    </tbody>
    
<?php } ?>
</table>
<div class="row container">
                <div class="col-md-4" >
                  
                </div>
                <div class="col-md-4" >
                   
                </div>
                <div class="col-md-4" >
                    <label for="" >Total || Monto</label>
                    <input type="text" value="<?php echo $sumador?>" class="form-control" disabled ></input>
                    <label><?php echo $sumador?></label>
                </div>
                 </div>

</body>
</html>