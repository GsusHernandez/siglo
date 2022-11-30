<?php 

if(!isset($_GET['ev'])){
  header('Location: https://www.globalredltda.co/');
}else{
  $idEntrevistaVirtual = $_GET['ev'];
  if($idEntrevistaVirtual != null && $idEntrevistaVirtual != ''){
    include('../../conexion/conexion.php');
    global $con;

    $consultaRegistro = "SELECT * FROM entrevista_virtual ev WHERE ev.id = '".$idEntrevistaVirtual."'";
    $consultaRegistroEntrevista=mysqli_query($con,$consultaRegistro);
    $cont= mysqli_num_rows($consultaRegistroEntrevista);
    $resEntrevista=mysqli_fetch_assoc($consultaRegistroEntrevista);

    if($cont < 1){
      header('Location: https://www.globalredltda.co/');
    }
  }else{
    header('Location: https://www.globalredltda.co/');
  }
}
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dibujar Canvas HTML5 - Evilnapsis</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="./jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <style>
      body{
        font-family: 'Roboto', sans-serif;
      }

      h1 {
        color: white;
        margin: 0;
      }
          
      header {
        background: #193456;
        padding-top: 5px;
        padding-bottom: 5px;
      }

      .contenido{
        padding-top: 20px;
      }
    </style>
  <body>
    <header class="main-header text-center">
      <h1>GLOBAL RED</h1>
    </header>

    <div class="container contenido">
      <div class="row">
        <div class="col-sm-12">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <th colspan="4" class="text-center" >DATOS DEL SINIESTRO</th>
              </thead>
              <tbody class="text-left">
                <tr>
                  <td>LESIONADO</td>
                  <td><strong><?=$resEntrevista['nom_lesionado']?></strong></td>
                  <td>TOMADOR</td>
                  <td><strong><?=$resEntrevista['nom_tomador']?></strong></td>
                </tr>
                <tr>
                  <td>ID. LESIONADO</td>
                  <td><strong><?=$resEntrevista['id_lesionado']?></strong></td>
                  <td>ID. TOMADOR</td>
                  <td><strong><?=$resEntrevista['id_tomador']?></strong></td>
                </tr>
                <tr>
                  <td>PLACA</td>
                  <td><strong><?=$resEntrevista['placa']?></strong></td>
                  <td>F. ACCIDENTE</td>
                  <td><strong><?=$resEntrevista['fecha_accidente']?></strong></td>
                </tr>
                <tr>
                  <td>POLIZA</td>
                  <td><strong><?=$resEntrevista['poliza']?></strong></td>
                  <td>CODIGO INTERNO</td>
                  <td><strong><?=$resEntrevista['codigo']?></strong></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <br/>
    <div class="container" style="text-align: justify;">
      <p>Yo <b><?=$resEntrevista['nom_entrevistado']?></b> indentificado con C.C. No.<b><?=$resEntrevista['id_entrevistado']?></b> autorizo de forma expresa y voluntaria a Seguros Mundial para realizar tratamiento de mis datos personales para la gestión integral del siniestro. A si mismo autorizo a realizar el tratamiento de datos sensibles de acuerdo con lo estipulado en el artículo 6 y 7 de la Ley 1581 de 2012, en especial, aquellos datos realacionados con niños, niñas y adolescentes, en el evento que llegue a sumistrarlos. Seguros Mundial y Global Red Ltda. - garantizarán la confidencialidad, seguridad, veracidad, transparencia, acceso y circulación restringida de los datos personales. La información obtenida para el tratamiento de mis datos personales la he suministrado de forma voluntaria y es verídica.<p>

      <br/>
      <center>
        <?php if($resEntrevista['consentimiento_firma'] == 1){ ?>
          <label class="radio-inline">
            <input type="radio" name="optradio" value="1" checked>Estoy de acuerdo
          </label>
        <?php }else{ ?>
          <label class="radio-inline">
            <input type="radio" name="optradio" value="0" checked>No estoy de acuerdo
          </label>
        <?php } ?>
      </center>
    </div>
    <br/>
    <div class="container">
    <!-- Contenedor y Elemento Canvas -->
      <div id="signature-pad" class="signature-pad" >
        <div class="signature-pad--body">
          <img src="https://www.globalredltda.co/siglo/portal/plugins/firmar/firmas/<?=$resEntrevista['firma']?>" alt="" style="width: 100%; height: 250px; border: 1px black solid; ">
          
          <?php

            $fecha = strtotime($resEntrevista['fecha_firma']); 
            $dia = date("d", $fecha);
            $año = date("Y", $fecha);
            $hora = date("g:i A", $fecha);

           ?>
          <label>Firmado el <?=$dia?> de Mayo de <?=$año?> a las <?=$hora?></label>
        </div>
      </div>
  </div>
  </body>
</html>
