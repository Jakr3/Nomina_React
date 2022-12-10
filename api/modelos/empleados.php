<?php
sleep(1);
include('config.php');
date_default_timezone_set('America/Bogota');
$zonahoraria = date_default_timezone_get();

/**
 * Nota: Es recomendable guardar la fecha en formato año - mes y dia (2022-08-25)
 * No es tan importante que el tipo de fecha sea date, puede ser varchar
 * La funcion strtotime:sirve para cambiar el forma a una fecha,
 * esta espera que se proporcione una cadena que contenga un formato de fecha en Inglés US,
 * es decir año-mes-dia e intentará convertir ese formato a una fecha Unix dia - mes - año.
*/

$fechaInit = $_POST['fecha'];
$fechaFin  = $_POST['f_fin'];



              
              
$sqlTrabajadores = ("SELECT * FROM transacciones WHERE  `fecha` BETWEEN '$fechaInit' AND '$fechaFin'  ORDER BY fecha ASC");
$query = mysqli_query($con, $sqlTrabajadores);
//print_r($sqlTrabajadores);
$total   = mysqli_num_rows($query);
echo '<strong>Total: </strong> ('. $total .')';


?>

<table class="table table-hover">
    <thead>
        <tr>
        <th scope="col">#</th>
                    <th scope="col">Id Empleado</th>
                    <th scope="col">Id Deduccion</th>
                    <th scope="col">Id ingreso</th>
                    <th scope="col">Tipo de transaccion</th>
                    <th scope="col">Fecha </th>
                    <th scope="col">Monto </th>
                    <th scope="col">Estado </th>
                    <th scope="col">Id Asiento </th>
        </tr>
    </thead>
    <?php
    $sumador=0;
    $i = 1;
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
                    <td><?php echo $dataRow['id_asiento'] ; ?></td>
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
                </div>
                 </div>