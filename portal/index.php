<?php
session_start();

if (isset($_SESSION["id"])){

    include('conexion/conexion.php');
    $idUsuario=$_SESSION["id"];
    $tipoUsuario=$_SESSION["tipo_usuario"];
    global $con;  


    //codigo generado aleatorio para pasarlo como parametros 
    //a los archivos js para que siempre deben cargarse aunque 
    //se guarden en la cache del navegador
    $alpha = "123qwertyuiopa456sdfghjklzxcvbnm789";
    $code = "";
    for($i=0;$i<6;$i++){
        $code .= $alpha[rand(0, strlen($alpha)-1)];
    }


    function getRealIP(){

        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];
           
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
       
        return $_SERVER['REMOTE_ADDR'];
    }
?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Global Red LTDA | SIGLO</title>
    <link rel="icon" href="../images/logo_ico.ico"/>

    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap1.min.css">
    <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="plugins/daterangepicker/daterangepicker.css"/>
    <link rel="stylesheet" type="text/css" href="bower_components/Print.js-1.0.40/print.min.css">
    <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="bower_components/DataTables/datatables.min.css"/>
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="dist/css/menuModuloInforme.css">
    <link rel="stylesheet" href="plugins/lightbox/dist/css/lightbox.css">
    <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">
    <link rel="stylesheet" href="dist/css/fonts/css.css">
    <link rel="stylesheet" type="text/css" href="plugins/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="plugins/alertify/css/alertify.min.css">

    <link href="https://fonts.googleapis.com/icon?cc=12&family=Material+Icons" rel="stylesheet">
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type='text/css' />
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    <style type="text/css">

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

        .breadcrumb {
            padding: 10px 10px 10px 20px;
            margin-bottom: 0;
            list-style: none;
            border-radius: 0;
            -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
            box-shadow: 0 1px 1px rgba(0,0,0,.05);
            background: transparent;
            line-height: 20px;
            font-size: 13px;
            margin-left: 14px;
        }

    </style>
</head>
<!--<body class="skin-blue sidebar-collapse">-->
<body class="skin-blue sidebar-mini sidebar-collapse">
    <!---------------------LOADING WRAPPER------------------------>
    <div class="content-wrapper-loading" style="display: none;" >
        <div  class="wrapper-loading">
            <div class="wrapper-loader"></div>
            <div class="wrapper-text">Cargando informaci&oacute;n...</div>
        </div>
    </div>

    <div id="wrapper">

        <header class="main-header">

            <a class="navbar-brand waves-effect waves-dark logo" href="index.php"><i class="large material-icons">track_changes</i> <strong>SIGLO</strong></a>

            <nav class="navbar navbar-static-top" role="navigation" >
                <a id="sideNav" href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope  fa-fw"></i>
                            </a>

                            <ul class="dropdown-content w250 dropdown-menu">
                                <li style="display: none;">
                                    <a href="#">
                                        <div>
                                            <i class="fa fa-tasks fa-fw"></i> Nueva Tarea
                                            <span class="pull-right text-muted small">4 min</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div>
                                            <i class="fa fa-tasks fa-fw"></i> No Tienes Notificaciones
                                        </div>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a class="text-center" href="#">
                                        <strong>Ver todas...</strong>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </li>
                            </ul> 
                        </li>

                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell fa-fw"></i>
                                <!--<span class="label label-warning">10</span>-->
                            </a>
                            <ul class="dropdown-content dropdown-tasks w250 taskList dropdown-menu">
                                <li>
                                    <a>
                                        <div>
                                            <strong><?=$_SESSION["nombres"]?></strong>
                                            <span class="pull-right text-muted">
                                                <em>Hoy</em>
                                            </span>
                                        </div>
                                        <p>No tiene alertas pendientes...</p>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a class="text-center" href="#">
                                        <strong>Ver todas...</strong>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </li>
                            </ul>  
                        </li>

                        <li class="dropdown user-menu">
                            <a class="dropdown-button waves-effect waves-dark" href="#!" data-activates="dropdown" data-toggle="dropdown">
                                <i class="fa fa-user fa-fw"></i> 
                                <span style="font-weight: 700;" class="hidden-xs"><?=$_SESSION["nombres"]?></span> 
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><i class="fa fa-user fa-fw"></i> Mi Perfil</a></li>
                                <li id="btnCambiarContrasenaUser"><a href="#"><i class="fa fa-gear fa-fw"></i> Editar Contraseña</a></li> 
                                <li id="btnLogout" name="<?=$idUsuario; ?>" tp="<?=$_SESSION["tipo_usuario"]?>"><a href="#"><i class="fa fa-sign-out fa-fw"></i> Cerrar Sesión</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header> 

        <aside class="main-sidebar">
            <section class="sidebar">
                <ul class="sidebar-menu" id="main-menu" data-widget="tree">
                    <li class="header">MENÚ</li>
                    <?php
                    $opcionUsuarioUno = array();//Se guargan las opciones de tipo: 1 y 3;
                    $opcionUsuarioDos = array();//Se guargan las opciones de tipo: 2 y 4;
                    $opcionUsuarioTres = array();//Se guargan las opciones de tipo: 3 y 4;

                    foreach ($_SESSION['opciones']['tipo'] as $key => $value) {
                      if($key == 1 || $key == 3){
                        foreach ($_SESSION['opciones']['tipo'][$key] as $key2 => $value2) {
                          $opcionUsuarioUno[] = $value2;
                          if($key == 3){
                            $opcionUsuarioTres[] = $value2;
                          }
                        }
                      }
                      if($key == 2 || $key == 4){
                        foreach ($_SESSION['opciones']['tipo'][$key] as $key2 => $value2) {
                          $opcionUsuarioDos[] = $value2;
                          if($key == 4){
                            $opcionUsuarioTres[] = $value2;
                          }
                        }
                      }
                    }

                    foreach ($opcionUsuarioUno as $opUno) {?>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa <?=$opUno['icono']?>"></i> 
                            <span><?=$opUno["descripcion"]?></span>
                            <!--<span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>-->
                        </a>
                        <ul class="treeview-menu">
                            <?php foreach ($opcionUsuarioDos as $key => $opSecundaria) {
                                if($opSecundaria['opcion_padre'] == $opUno['opcion_padre']){                       
                                    if ($opSecundaria["tipo_opcion"]==2){ ?>
                                        <li><a name="<?=$opSecundaria["codigo"]?>" id='btnProgramas'><?=$opSecundaria["descripcion"]?></a></li> <?php
                                    }else if ($opSecundaria["tipo_opcion"]==4){?>
                                        <li><a name="<?=$opSecundaria["codigo"]?>" id='btnProgramasModales'><?=$opSecundaria["descripcion"]?></a></li><?php
                                    }
                                }
                            }?>
                        </ul>
                    </li>
                <?php } ?>   
                </ul>
            </section>
        </aside>

        <div class="content-wrapper"  style="padding-top: 44px;">
            <section class="content-header"> 
                <!--<ol class=" breadcrumb">
                    <li class="active">Inicio</li>
                </ol> -->

                <h1 id="title-inner">
                  <?php if (isset($_GET["opt"])){ 
                    if(isset($_SESSION['opciones']['codigo'][$_GET["opt"]])){
                       echo $_SESSION['opciones']['codigo'][$_GET["opt"]]["descripcion"];
                    }
                  } ?>          
                </h1>  
            </section>

            <section id="content" style="padding-left: 15px; padding-top: 5px; padding-right: 15px;"> 
                <?php
                if (isset($_GET["opt"])){
                  if(isset($_SESSION['opciones']['codigo'][$_GET["opt"]])){
                    include ($_SESSION['opciones']['codigo'][$_GET["opt"]]["ruta"]);
                  }
                }else{
                  include ("forms/panelGeneral.php");
                } ?>
                <!-- /.CONTENIDO VENTANA PRINCIPAL -->
            </section>

            <?php
            if (!isset($_GET["opt"])){
                include ("modales/panelGeneral.php");
            }else{
                if(isset($_SESSION['opciones']['codigo'][$_GET["opt"]])){
                    if($_SESSION['opciones']['codigo'][$_GET["opt"]]["ruta_modales"] != ''){
                        include ($_SESSION['opciones']['codigo'][$_GET["opt"]]["ruta_modales"]);
                    }
                }
            }?>

            

            <?php
            foreach ($opcionUsuarioTres as $opTres) { ?>
                <div class="modal fade" data-backdrop="static" data-keyboard="false" id="<?php echo $opTres["ruta"];?>" role="dialog" aria-labelledby="myModalLabel" >
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="overflow-y: auto; max-height: 90%; margin-bottom: 50px;">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title" id="tituloModalDinamico"><?php echo $opTres["descripcion"];?></h4>
                            </div>
                            <div class="modal-body">
                                <?php include("forms/".$opTres["ruta"].".php");?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            } ?>

            <div class="modal fade" data-backdrop="static" data-keyboard="false" id="frmResolucionFacturacion" role="dialog" >
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header alert-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Resoluciones De Facturacion</h4>
                        </div>
                        <div class="modal-body">
                            <?php include ("forms/frmResolucionFacturacion.php"); ?>
                        </div>              
                    </div>
                </div>
            </div> 

        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalCuentasCobrosInvestigadoresPeriodos" role="dialog" >
          <div class="modal-dialog modal-informe" style="width: 100% !important; padding: 20px 20px !important;" >
            <div class="modal-content">
              <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Cuenta Cobro Investigadores</h4>
              </div>
              <div class="modal-body">
                <?php include("forms/frmCuentasCobrosInvestigadoresPeriodo.php"); ?>
              </div>
             
            </div>
          </div>
        </div> 


           <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalIngresarValoresCuentaCobro" role="dialog" >
          <div class="modal-dialog  modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Ingresar Valores Cuenta Cobro</h4>
              </div>
              <div class="modal-body">
                <?php include("forms/frmIngresarValoresCuentaCobro.php"); ?>
              </div>
               <div class="modal-footer">
                <input type="hidden" id="idCuentaCobroInvestigador" value="idCuentaCobroInvestigador" name="idCuentaCobroInvestigador">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
        <button class="btn btn-primary" id="btnGuardarValoresCuentaCobroInvestigador">Confirmar</button>
      </div>
            </div>
          </div>
        </div> 




           <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalPagosCuentaCobroInvestigadores" role="dialog" >
          <div class="modal-dialog  modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Pagos Cuenta Cobro</h4>
              </div>
              <div class="modal-body">
                <?php include("forms/frmIngresarPagosCuentaCobro.php"); ?>
              </div>
               <div class="modal-footer">
                <input type="hidden" id="idCuentaCobroInvestigadorPagos" value="idCuentaCobroInvestigadorPagos" name="idCuentaCobroInvestigadorPagos">
        
      </div>
            </div>
          </div>
        </div> 





            <div class="modal fade" data-backdrop="static" data-keyboard="false" id="procesoEjecucion" role="dialog" >
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" id="BotonCerrar">&times;</button>
                            <h4 class="modal-title">Notificacion</h4>
                        </div>
                        <div class="modal-body">
                            Proceso en ejecucion
                        </div>
                    </div>
                </div>
            </div> 

                 <div class="modal fade" data-backdrop="static" data-keyboard="false" id="ErroresNonActualizable" role="dialog" >
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header cambiaClassColor">
                            <button type="button" class="close" data-dismiss="modal" id="BotonCerrar">&times;</button>
                            <h4 class="modal-title">Notificacion</h4>
                        </div>
                        <div class="modal-body"  id="ContenidoErrorNonActualizable">
                        </div>
                    </div>
                </div>
            </div>

       

            <div class="modal fade" data-backdrop="static" data-keyboard="false" id="CambiarPassword" role="dialog" aria-labelledby="myModalLabel" >
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header alert-danger">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Cambio Contraseña</h4>
                  </div>
                  <?php include("forms/frmCambiarPassword.php"); ?>
                </div>
              </div>
            </div>


              <div class="modal fade" data-backdrop="static" data-keyboard="false" id="ModuloRegistrosOut" role="dialog" >
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header alert-danger">
                            <button type="button" class="close" data-dismiss="modal" id="BotonCerrar">&times;</button>
                            <h4 class="modal-title" id="tituloModuloRegistrosOut">Eliminar Registro</h4>
                        </div>
                        <div class="modal-body" id="textModuloRegistrosOut">
                            <p>¿Desea borrar este registro?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success pull-left" data-dismiss="modal" id="BtnConfirmarModuloRegistrosOut">Si</button>
                            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" id="BtnCancelarModuloRegistrosOut">No</button>
                            <input type="hidden" id="exeModuloRegistrosOut" value="exe" name="exe">
                            <input type="hidden" id="idModuloRegistrosOut" value="idModuloRegistrosOut" name="idModuloRegistrosOut">
                            <input type="hidden" id="idTablaActualizar" value="idTablaActualizar" name="idTablaActualizar">
                        </div>
                    </div>
                </div>
            </div> 





            <!--<footer class="main-footer alert-default">
                <div class="container">
                    <div class="pull-right hidden-xs">
                        <b>Version</b> 1.0.0
                    </div>
                    <strong>Copyright &copy; 2018 - Desarrollado por: Jairo Zapata Fandiño.</strong> 
                </div>
            </footer>-->
        </div>

        <script src="bower_components/jquery/dist/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap1.min.js"></script>
        <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="bower_components/fastclick/lib/fastclick.js"></script>
        <script src="dist/js/adminlte.min.js"></script>
        <script src="plugins/lightbox/dist/js/lightbox.js"></script>
        <script type="text/javascript" src="bower_components/DataTables/datatables.min.js"></script>
        <script src="bower_components/select2/dist/js/select2.full.min.js"></script>
        <script type="text/javascript" src="plugins/daterangepicker/moment.min.js"></script>
        <script type="text/javascript" src="plugins/daterangepicker/daterangepicker.min.js"></script>
        <script src="bower_components/Print.js-1.0.40/print.min.js"></script>
        <script src="dist/js/demo.js"></script>
        <script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
        <script src="../js/notify.js"></script>
        <script src="js/actionsPanel.js<?="?".$code?>"></script>
        <script src="plugins/alertify/alertify.min.js"></script>
        <script src="bower_components/chart.js/Chart.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
        <script type="text/javascript">
            $('#btnCambiarContrasenaUser').click(function(e){
                $('#CambiarPassword').modal('show');
            });

            $('#btnCambiarPassowrdForm').click(function(e){

                loadingSiglo('show', 'Guardando Contraseña...');

                if ($('#confirmarContrasenaFrmCPass').val()==$('#nuevaContrasenaFrmCPass').val()){

                    var form =  "exe=cambiarPaswordUsuario&idUsuario="+$('#btnLogout').attr('name')+"&actualContrasenaFrmCPass="+$('#actualContrasenaFrmCPass').val()+"&nuevaContrasenaFrmCPass="+$('#nuevaContrasenaFrmCPass').val();

                    $.ajax({
                        type: 'POST',
                        url: 'class/consultasManejoUsuarios.php',
                        data: form,
                        success: function(data) {
                            if (data==1){
                                limpiaForm("#frmCambioPassowrd");
                                $('#CambiarPassword').modal('hide');    
                                $("#ContenidoErrorNonActualizable").html("Se ha cambiado su Contraseña Satisfactoriamente");
                                $('#ErroresNonActualizable').modal('show'); 
                            }else if(data==2){
                                $("#ContenidoErrorNonActualizable").html("Errr al ejecutar Proceso");
                                $('#ErroresNonActualizable').modal('show');
                            }else   if (data==3){
                                $("#ContenidoErrorNonActualizable").html("Contraseña actual no coincide. Vuelva a Intentarlo");
                                $('#ErroresNonActualizable').modal('show');
                            }   

                            loadingSiglo('hide');
                            return false;
                        }, error: function(data){
                            loadingSiglo('hide');
                        }
                    });
                }else{
                    $("#ContenidoErrorNonActualizable").html("Contraseña Son distintas. Vuelva a Intentarlo");
                    $('#ErroresNonActualizable').modal('show');
                    loadingSiglo('hide');           
                }
            });
        </script>
     
</body>
</html>
<?php
if (!isset($_GET["opt"])){ ?>
    <script src="js/panelGeneral.js<?="?".$code?>"></script>
    <?php
}else{
    if(isset($_SESSION['opciones']['codigo'][$_GET["opt"]])){
        if($_SESSION['opciones']['codigo'][$_GET["opt"]]["ruta_script"] != ''){?>
            <script src="<?=$_SESSION['opciones']['codigo'][$_GET["opt"]]["ruta_script"]."?".$code; ?>"></script>
            <?php
        }
    }
} ?>
</html>
<?php   } else { header("Location: ../"); }?>