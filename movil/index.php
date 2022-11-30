<?php
session_start();

if (isset($_SESSION["s_id"]))
{
  include('conexion/conexion.php');
  $idUsuario=$_SESSION["s_id"];
  global $con;  

?>

<!DOCTYPE html>
<html>
<head>
  <title>Global Red | Inicio</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <link rel="stylesheet" href="themes/global.min.css" />
  <link rel="stylesheet" href="themes/jquery.mobile.icons.min.css" />
  <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
  <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
  <script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>

<div data-role="page" class="ui-page-theme-c" style="background-image:url('img/logoAzulGlobal2.png');background-repeat: no-repeat;margin: auto;background-position: 50% 50%;background-attachment:fixed;">

  <div data-role="header"  data-theme="c" data-position="fixed">
    
    
    <h1>Global Red</h1>

    
  </div><!-- /header -->

  <div role="main" class="ui-content" style="">

    
    

  </div><!-- /content -->
  
  <div data-role="footer"  data-position="fixed" >
    <div data-role="navbar">
      <ul><li><a href="#login" data-rel="dialog" data-role="button" data-inline="true" class="ui-page-theme-c" data-icon="user" data-transition="pop">Comenzar</a></li></ul>
    </div>
    
  </div>


  
  
</div><!-- /page -->

 <?php include('login.php'); ?>
 <?php include('panel/inicio.php');?>
 <?php include('panel/buscar.php');?>
  <?php include('panel/registrar.php');?>





<script src="js/GestionCasos.js"></script>
<script src="js/actions.js"></script>
</body>
</html>

<?php 
}
else
{
   header("Location: ../movil/");
}
?> 