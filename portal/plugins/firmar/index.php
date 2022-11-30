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
    }else{
      if($resEntrevista['firmado'] == 's'){
        header('Location: https://www.globalredltda.co/');
      }
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
  <link rel="stylesheet" href="../sweetalert2/sweetalert2.min.css">
  <script src="jquery.min.js"></script>
  <script src="signature_pad.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <script src="../sweetalert2/sweetalert2.all.min.js"></script>
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


    /*--------- LOANDING SIGLO ----------*/
        .content-wrapper-loading{
            height: 100%;
            width: 100%;
            position: fixed;
            z-index: 9999;
            margin-top: 0;
            top: 0;
            text-align: center;
            background-color: rgba(225, 225, 225,0.5);
        }

        .wrapper-loading{
            position: absolute;
            top: 50%; 
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 20000;
            min-width:400px;
        }

        .wrapper-loader {
            position: absolute;
            margin-left: 172px;
            margin-right: 172px;

            border-right: 10px solid #f5eded;
            border-left: 10px solid #f5eded;
            border-top: 10px solid #0F3BD2;
            border-bottom: 10px solid #0F3BD2;

            border-radius: 50%;

            width: 56px;
            height: 56px;

            -webkit-animation: spin 2s linear infinite; /* Safari */
            animation: spin 2s linear infinite;
        }

        .wrapper-text{
            font-weight: bold;
            font-size: 20px;
            margin-top: 70px;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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
    <p>Yo <b><?=$resEntrevista['nom_entrevistado']?></b> indentificado con C.C. No.<b><?=$resEntrevista['id_entrevistado']?></b> autorizo de forma expresa y voluntaria a Seguros Mundial para realizar tratamiento de mis datos personales para la gestión integral del siniestro. A si mismo autorizo a realizar el tratamiento de datos sensibles de acuerdo con lo estipulado en el artículo 6 y 7 de la Ley 1581 de 2012, en especial, aquellos datos realacionados con niños, niñas y adolescentes, en el evento que llegue a sumistrarlos. Seguros Mundial y Global Red Ltda. - garantizarán la confidencialidad, seguridad, veracidad, transparencia, acceso y circulación restringida de los datos personales. La insformación obtenida para el tratamiento de mis datos personales la he suministrado de forma voluntaria y es verídica.<p>

    <br/>
    <center>
      <label class="radio-inline">
        <input type="radio" name="optradio" value="1">Estoy de acuerdo
      </label>
      <label class="radio-inline">
        <input type="radio" name="optradio" value="0">No estoy de acuerdo
      </label>
    </center>
  </div>
  <br/>
  <div class="container">
  <!-- Contenedor y Elemento Canvas -->
    <div id="signature-pad" class="signature-pad" >
      <label>Firme aqui:</label>
      <div class="signature-pad--body">
        <canvas style="width: 100%; height: 250px; border: 1px black solid; " id="canvas"></canvas>
      </div>
    </div>
    <form id="form" method="post">
      <input type="hidden" name="id_firma" value="<?=$resEntrevista['id']?>" id="id_firma">
      <input type="hidden" name="base64" value="" id="base64">
      <div class="row">
        <div class="col-sm-6">
          <button id="reset" class="btn btn-default btn-block" type="reset" onclick="resizeCanvas()">Limpiar</button>
        </div>
        <div class="col-sm-6">
          <button id="saveandfinish" class="btn btn-primary btn-block">Guardar y Finalizar</button>
        </div>
      </div>
    </form>
  </div>
  <br>
  <br>
  <br>
  <!-- Formulario que recoge los datos y los enviara al servidor -->
 
  <div class="content-wrapper-loading" style="display: none;" >
    <div  class="wrapper-loading">
      <div class="wrapper-loader"></div>
      <div class="wrapper-text">Cargando informaci&oacute;n...</div>
    </div>
  </div>

<script type="text/javascript">

  var wrapper = document.getElementById("signature-pad");

  var canvas = wrapper.querySelector("canvas");
  var signaturePad = new SignaturePad(canvas, {
    backgroundColor: 'rgb(255, 255, 255)'
  });

  function resizeCanvas() {

    var ratio =  Math.max(window.devicePixelRatio || 1, 1);

    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);

    signaturePad.clear();
  }

  function loadingSiglo(action, message = ''){
    if(action == 'show'){
      $(".wrapper-text").text(message);
      $(".content-wrapper-loading").show();
    }else{
      $(".wrapper-text").text('');
      $(".content-wrapper-loading").hide();
    }
  }

  window.onresize = resizeCanvas;
  resizeCanvas();

</script>
<script>

  document.getElementById('form').addEventListener("submit",function(e){
    var ctx = document.getElementById("canvas");
      var image = ctx.toDataURL(); // data:image/png....
      document.getElementById('base64').value = image;
  },false);

</script>

    <script>
      $("#form").on('submit', function (e) {
        loadingSiglo('show', 'Verificando datos!');
        var base64 = $("#base64").val();
        var terminos = $('input:radio[name=optradio]:checked').val();
        var id_firma = $("#id_firma").val();

        if($('input:radio[name=optradio]:checked').val() != null){
          loadingSiglo('show', 'Registrando firma!');
          e.preventDefault();
          var form = new FormData();

          form.append("base64", base64);
          form.append("terminos", terminos);
          form.append("id_firma", id_firma);

          $.ajax({
            type: 'POST',
            url: './savedraw.php',
            data: form,
            cache: false,
            contentType: false,
            processData: false,
            success: function(datos) {
              if(datos == 1){
                loadingSiglo('hide');
                Swal.fire({
                  title: '¡Firmado!',
                  text: 'Documento firmado con exito!',
                  icon: 'success'
                }).then(function(){
                  window.location.href = 'https://www.globalredltda.co/';
                }, function(dismiss){
                  window.location.href = 'https://www.globalredltda.co/';
                });
              }
            }
          });
        }else{
          e.preventDefault();
          loadingSiglo('hide');
          Swal.fire(
            '¡Error!',
            'Debe seleccionar si esta o no de acuerdo con los terminos para el tratamiento de sus datos',
            'error'
          );
        }

      })
    </script>
  </body>
</html>

