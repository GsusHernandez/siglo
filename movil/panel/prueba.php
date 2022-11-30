
<?php
session_start();

if (isset($_SESSION["s_id"]))
{
  include('../conexion/conexion.php');
  $idUsuario=$_SESSION["s_id"];
  global $con;  

?>

<!DOCTYPE html>
<html>
<head>
  <title>Global Red |Prueba</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="../themes/global.min.css" />
  <link rel="stylesheet" href="../themes/jquery.mobile.icons.min.css" />
  <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
  <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
  <script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>


<div data-role="page" class="ui-page-theme-c">
  
  <div id="msn"  data-theme="a" data-overlay-theme="b" data-dismissible="false" style="max-width:400px;">

        <div data-role="header">
          <a data-rel="back" href="panel1.php" class="ui-btn ui-btn-b ui-shadow ui-corner-all ui-icon-carat-l ui-btn-icon-notext">        
          </a>
          <h1>DATOS ENCONTRADOS</h1>
        </div>

        <div role="main" class="ui-content">
          <table id="tablaGestionCasosSOATmovil">
            <thead>
              <tr>
                <td>Codigo</td>
                <td>fecha Accidente</td>
                <td>nombres</td>
                <td>Apellidos</td>
                <td>identificacion</td>
                <td>poliza</td>
                <td>placa</td>
                <td>indicativo</td>
              </tr>
            </thead>

          </table>
        </div>
  </div>
  
</div>
  

  




<script src="../js/GestionCasos.js"></script>
</body>
</html>

<?php 
}
else
{
   header("Location: ../");
}
?> 
