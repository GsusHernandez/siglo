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
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Global Red LTDA | SIGLO</title>
  <!-- Tell the browser to be responsive to screen width -->
  <link rel="icon" href="../images/logo_ico.ico"/>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/daterangepicker-bs3.css">
  <link rel="stylesheet" type="text/css" href="bower_components/Print.js-1.0.40/print.min.css">
       
  <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">

  <link rel="stylesheet" type="text/css" href="bower_components/DataTables/datatables.min.css"/>
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/menuModuloInforme.css">
  <link href="plugins/lightbox/dist/css/lightbox.css" rel="stylesheet">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">


</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue-light layout-top-nav">

<div class="wrapper">

  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a href="index.php" class="navbar-brand"><b>SIGLO</b></a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
            


          </ul>
         
        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->
           
            <!-- /.messages-menu -->

            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a id="btnLogout" name="<?php echo $idUsuario; ?>" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs">Salida</span>
              </a>
             
            </li>
          </ul>
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>

  <div class="content-wrapper" style="padding-top:20px;">


    <div class="box box-solid box-primary" style="width: 75%;margin: auto;">

        <div class="box-header with-border">
          <h3 class="box-title">Buscador de Casos</h3>
        </div>

        <div class="box-body">

          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_01" data-toggle="tab" aria-expanded="true">SOAT</a></li>
              <li class=""><a href="#tab_02" data-toggle="tab" aria-expanded="false">Validaciones IPS</a></li>
       
              
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_01">
              <form role="form" id="frmBusqCasosSOAT">
              <div class="box-body">


                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label for="codigoFrmBuscarSOAT2">Codigo</label>
                          <input type="text" class="form-control" id="codigoFrmBuscarSOAT2" placeholder="Codigo">
                        </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                      <label for="nombresFrmBuscarSOAT2">Nombres</label>
                      <input type="text" class="form-control CampText" id="nombresFrmBuscarSOAT2" placeholder="Nombres">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                      <label for="apellidosFrmBuscarSOAT2">Apellidos</label>
                      <input type="text" class="form-control CampText" id="apellidosFrmBuscarSOAT2" placeholder="Apellidos">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                      <label for="identificacionFrmBuscarSOAT2">Identificacion</label>
                      <input type="text" class="form-control CampNum" id="identificacionFrmBuscarSOAT2" placeholder="Identificacion">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                      <label for="placaFrmBuscarSOAT2">Placa</label>
                      <input type="text" class="form-control" id="placaFrmBuscarSOAT2" placeholder="Placa">
                    </div>
                </div>

             

                <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Poliza</label>
                      <input type="text" class="form-control" id="polizaFrmBuscarSOAT2" placeholder="Poliza">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                      <label for="polizaFrmBuscarSOAT2">Identificador</label>
                      <input type="text" class="form-control" id="identificadorFrmBuscarSOAT" placeholder="Identificador">
                    </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                          <a  id="btnBuscarInvestigacionSOAT2" class="btn btn-primary">Buscar</a>
                          

                        </div>
                    </div>
                
              <!-- /.box-body -->

              </div>
          
            
            </form>

              

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_02">
                 <form role="form" id="frmBusqCasosValidaciones">
              <div class="box-body">


                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label for="codigoFrmBuscarValIPS2">Codigo</label>
                          <input type="text" class="form-control" id="codigoFrmBuscarValIPS2" placeholder="Codigo">
                        </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                      <label for="identificacionFrmBuscarValIPS2">Identificacion</label>
                      <input type="text" class="form-control CampNum" id="identificacionFrmBuscarValIPS2" placeholder="Identificacion">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                      <label for="razonSocialFrmBuscarValIPS2">Razon Social</label>
                      <input type="text" class="form-control CampText" id="razonSocialFrmBuscarValIPS2" placeholder="Razon Social">
                    </div>
                </div>


                 <div class="col-md-4">
                    <div class="form-group">
                      <label for="identificadorFrmBuscarValIPS2">Identificador</label>
                      <input type="text" class="form-control CampText" id="identificadorFrmBuscarValIPS2" placeholder="Razon Social">
                    </div>
                </div>

                
                <div class="col-md-6">
                        <div class="form-group">
                          <a  id="btnBuscarInvestigacionValIPS2" class="btn btn-primary">Buscar</a>
                          

                        </div>
                    </div>
                
              <!-- /.box-body -->

              </div>
          
            
            </form>
              </div>
              <!-- /.tab-pane -->
          
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
        </div><!-- /.box-body -->
    </div><!-- /.box -->

  </div>


  <footer class="main-footer alert-default">
    <div class="container">
      <div class="pull-right hidden-xs">
        <b>Version</b> 1.0.0
      </div>
      <strong>Copyright &copy; 2018 - Desarrollado por: Jairo Zapata Fandiño.</strong> 
    </div>
    <!-- /.container -->
  </footer>

</div>


<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script src="plugins/lightbox/dist/js/lightbox.js"></script>
<script type="text/javascript" src="bower_components/DataTables/datatables.min.js"></script>
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="bower_components/bootstrap-datepicker/moment.min.js"></script>

<script src="bower_components/bootstrap-datepicker/daterangepicker.js"></script>
<script src="bower_components/Print.js-1.0.40/print.min.js"></script>



<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script src="js/actionsPanel.js"></script>







</body>
</html>

<?php 
}
else
{
  header("Location: ../");
}
?>