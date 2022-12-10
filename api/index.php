<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link type="text/css" rel="shortcut icon" href="img/logo-mywebsite-urian-viera.svg"/>
  <title>Consulta</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
  <style>
  h4{
      padding: 0px !important;
      color: crimson;
      margin-bottom: 35px;
  }
  </style>
</head>
    <body>
        <header>
          <div class="contenedor_header">
              <ul class="flex-container">
              <h1> Consulta de Transacciones</h1>
              </ul>
          </div>
        </header>

        <div id="demo-content">
          <div id="loader-wrapper">
            <div id="loader"></div>
            <div class="loader-section section-left"></div>
                <div class="loader-section section-right"></div>
            </div>
          <div id="content"> </div>
        </div>


        <div class="container">
          <div class="row">
            <div class="col-md-12 text-center" style="padding:100px 0px;">
              <h3 class="text-center" style="color:#333; font-weight:900;">
                Filtrar Transacciones con Rango de Fechas Inicio y Final
              </h3>
              <h3 style="color:#D90E1D !important; font-weight:bold;">
                
              </h3>
            </div>
          </div>
        </div>


      <section>
          <div class="container">
            <div class="row">
              
              <div class="col-md-12 text-center mt-5">
                <form action="DescargarReporte_x_fecha.php" method="post" accept-charset="utf-8">
                  <div class="row">
                    <div class="col">
                      <input type="date" name="fecha" class="form-control"  placeholder="Fecha de Inicio" required>
                    </div>
                    <div class="col">
                      <input type="date" name="fechaFin" class="form-control" placeholder="Fecha Final" required>
                    </div>
                    <div class="col">
                      <span class="btn btn-dark mb-2" id="filtro">Filtrar</span>
                      <button type="submit" class="btn btn-danger mb-2">Descargar Reporte</button>
                      
                    </div>
                  </div>
                </form>
              </div>

              <div class="col-md-12 text-center mt-5">     
                <span id="loaderFiltro">  </span>
              </div>
              
              
            <div class="table-responsive resultadoFiltro">
              <table class="table table-hover" id="tableEmpleados">
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
                    <th scope="col">Id Asiento</th>
                  </tr>
                </thead>
              <?php
               
              
              include('modelos/config.php');


              $sumador = 0;
              
              
              $sqlTrabajadores = ('SELECT * FROM transacciones ORDER BY fecha ASC');
              $query = mysqli_query($con, $sqlTrabajadores);
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
                    <td><?php echo $dataRow['id_asiento'] ; ?></td>
                    <td><?php $sumador = $sumador + $dataRow['monto'] ; ?></td>
                    
                </tr>
                
                </tbody>
                
                
              <?php }
              
               
              
              ?>
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
            </div>

            </div>
          </div>
      </section>



    



  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="assets/js/material.min.js"></script>
  <script>
  $(function() {
      setTimeout(function(){
        $('body').addClass('loaded');
      }, 1000);


//FILTRANDO REGISTROS
$("#filtro").on("click", function(e){ 
  e.preventDefault();
  
  loaderF(true);

  var fecha = $('input[name=fecha]').val();
  var f_fin = $('input[name=fechaFin]').val();
  console.log(fecha + '' + f_fin);

  if(fecha !="" && f_fin !=""){
    $.post("modelos/empleados.php", {fecha, f_fin}, function (data) {
      $("#tableEmpleados").hide();
      $(".resultadoFiltro").html(data);
      loaderF(false);
    });  
  }else{
    $("#loaderFiltro").html('<p style="color:red;  font-weight:bold;">Debe seleccionar ambas fechas</p>');
  }
} );


function loaderF(statusLoader){
    console.log(statusLoader);
    if(statusLoader){
      $("#loaderFiltro").show();
      $("#loaderFiltro").html('<img class="img-fluid" src="assets/img/cargando.svg" style="left:50%; right: 50%; width:50px;">');
    }else{
      $("#loaderFiltro").hide();
    }
  }
});
</script>

</body>
</html>