<style type="text/css">
.bg-default:hover{
  color: #333 !important;
}

.loader{
  width: 70px;
  height: 70px;
  border-radius: 100%;
  position: relative;
  margin: 0 auto;
}

#loader-1:before, #loader-1:after{
  content: "";
  position: absolute;
  width: 100%;
  height: 100%;
  border-radius: 100%;
  border: 10px solid transparent;
  border-top-color: #3498db;
}

#loader-1:before{
  z-index: 100;
  animation: spin 1s infinite;
}

#loader-1:after{
  border: 10px solid #ccc;
}

#loader-2:before, #loader-2:after{
  content: "";
  position: absolute;
  width: 100%;
  height: 100%;
  border-radius: 100%;
  border: 10px solid transparent;
  border-top-color: #3498db;
}

#loader-2:before{
  z-index: 100;
  animation: spin 1s infinite;
}

#loader-2:after{
  border: 10px solid #ccc;
}

@keyframes spin{
  0%{
    -webkit-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }

  100%{
    -webkit-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
.small-box{
  cursor: pointer;
}

.rojoCargue{
  background-color: #ff2e2e;
}
.rojoEntrega{
  background-color: #ff2e2e;
}
.amarilloAccidente{
  background-color: yellow;
}
.rojoAccidente{
  background-color: #ff2e2e;
}
</style>

<?php
$consultarInformacionUsuario=mysqli_query($con,"SELECT CONCAT(CONCAT_WS('','',a.nombres),' ',CONCAT_WS('','',a.apellidos)) as nombre_usuario,a.usuario FROM usuarios a WHERE a.id='".$idUsuario."'");
$resInformacionUsuario=mysqli_fetch_array($consultarInformacionUsuario,MYSQLI_ASSOC);

$consultarInformacionUltimoAccesoUsuario=mysqli_query($con,"SELECT fecha,direccion_acceso FROM log_sesion WHERE id_usuario='".$idUsuario."' AND descripcion=1  AND id< (SELECT id FROM log_sesion WHERE id_usuario='".$idUsuario."' AND descripcion=1 ORDER BY fecha DESC LIMIT 1) ORDER BY fecha DESC LIMIT 1");
$resInformacionUltimoAccesoUsuario=mysqli_fetch_array($consultarInformacionUltimoAccesoUsuario,MYSQLI_ASSOC);

 $tipo_usuario=$_SESSION['tipo_usuario'];
?>
<script type="text/javascript">
  var tipo_usuario_session='<?php echo $tipo_usuario;?>';
</script>
<?php if($_SESSION['tipo_usuario'] == 3 || $_SESSION['tipo_usuario'] == 2){ ?>
  <div class="row">

    <section class="content-header">
      <h1>
        ESTADISTICAS MENSUALES
      </h1>
    </section>

    <br>

    <div class="col-md-6">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">OCURRENCIAS NO CONFIRMADAS</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-8">
              <div class="chart-responsive">
                <canvas id="pieChart" height="144" width="224" style="width: 280px; height: 180px;">
                </canvas>
              </div>
            </div>
            <div class="col-md-4">
              <ul class="chart-legend clearfix" id="nombresAseguradoras"></ul>
            </div>
          </div>
        </div>
        <div class="overlay overlay-ocurrencias">
          <i class="fa fa-refresh fa-spin"></i>
        </div>
      </div>
    </div>
  </div>
<?php }

if($_SESSION['tipo_usuario'] == 2 || $_SESSION['tipo_usuario'] == 3 || $_SESSION['tipo_usuario'] == 4){ ?>
<div class="row">

  <section class="content-header">
    <h1>
      TOP 10 DE MAYORES INCIDENCIAS <?=date("Y")?>
    </h1>
  </section>

  <br>

  <div class="col-md-3">
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title" style="font-weight: bold">PLACAS</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <table class="table no-margin text-center">
            <thead>
              <tr>
                <th>PLACA</th>
                <th>CASOS</th>
              </tr>
            </thead>
            <tbody id="tablaPlacasIncidencias">
             
            </tbody>
          </table>
        </div>
      </div>

      <div class="overlay overlay-placas">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="box box-danger">
      <div class="box-header with-border">
        <h3 class="box-title" style="font-weight: bold">MARCAS</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <table class="table no-margin text-center">
            <thead>
              <tr>
                <th>MARCA</th>
                <th>MOD</th>
                <th>CASOS</th>
              </tr>
            </thead>
            <tbody id="tablaMarcasIncidencias">
             
            </tbody>
          </table>
        </div>
      </div>

      <div class="overlay overlay-marcas">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title" style="font-weight: bold">PERSONAS</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <table class="table no-margin">
            <thead>
              <tr>
                <th class="text-center">NOMBRE</th>
                <th class="text-center">CASOS</th>
              </tr>
            </thead>
            <tbody id="tablaPersonasIncidencias">
             
            </tbody>
          </table>
        </div>
      </div>

      <div class="overlay overlay-personas">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    </div>
  </div>
</div>
<?php }

echo '<div class="row" id="rowIformacion">';
if($_SESSION['tipo_usuario'] == 2 || $_SESSION['tipo_usuario'] == 3){

  $consultarCargueHoy = mysqli_query($con, "SELECT COUNT(c.id) AS can_cargues FROM control_cargue c WHERE DATE_FORMAT(c.fecha,'%Y-%m-%d') = Date_format(now(),'%Y-%m-%d') AND c.id_usuario = ".$_SESSION['id']." GROUP BY c.id_usuario");

  $consultarCargueHoy=mysqli_fetch_array($consultarCargueHoy,MYSQLI_ASSOC);
  if(isset($consultarCargueHoy['can_cargues']) && $consultarCargueHoy['can_cargues'] > 0){ 
  ?>
    <div class="col-md-3">
      <div class="small-box bg-aqua" onclick="MostrarCarguesHoy()">
        <div class="inner">
          <h3><?= $consultarCargueHoy['can_cargues'] ?></h3>

          <p><?= $consultarCargueHoy['can_cargues'] == 1 ? 'Cargue Reportado' : 'Cargues Reportados' ?></p>
        </div>
        <div class="icon">
          <i class="ion ion-android-cloud-done"></i>
        </div>
      </div>
    </div>
  <?php
  }
}
?>
<?php
if($_SESSION['tipo_usuario'] == 1){ ?>
    <div onclick="mostrarMisCasosPdte(); return false;" class="col-md-3">
      <div class="small-box bg-default">
        <div class="inner">
          <h3 id="misCasos">0</h3>
          <p>Mis Casos Pdte.</p>
        </div>
        <div class="icon miC">
          <i class="ion"><div class="loader" id="loader-1"></div></i>
        </div>
      </div>
    </div>


    <div onclick="mostrarMisCasosSinPDF(); return false;" class="col-md-3">
      <div class="small-box bg-red">
        <div class="inner">
          <h3 id="misCasosSinPDF">0</h3>
          <p>Sin Informe PDF</p>
        </div>
        <div class="icon miCSinPDF">
          <i class="ion"><div class="loader" id="loader-2"></div></i>
        </div>
      </div>
    </div>
<?php } ?>

</div>

<!--Emmanuel Martinez Carrillo | 2021-02-22-->
  <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalMostrarCargues" role="dialog" aria-labelledby="myModalLabel" >
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document" style="overflow-y: auto; ">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Cargues Hoy</h4>
        </div>
        <div class="modal-body">
          <div calss="table-responsive">
            <table class="table table-hover table-condensed" id="tablaCargados">
              <thead>
                <tr>
                  <th class="text-center">Codigo</th>
                  <th class="text-center">Cargues</th>
                  <th class="text-center">Hora</th>
                </tr>
              </thead>
              <tbody id="ReportesCargues">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalCasosPdte" role="dialog" aria-labelledby="myModalLabel" >
    <div style="width: 80%;" class="modal-dialog modal-dialog-centered" role="document" style="overflow-y: auto; ">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Mis Casos Pendientes</h4>
        </div>
        <div class="modal-body">
          <div calss="table-responsive">
            <table class="table table-hover table-condensed" id="tablaMisCasosPdte">
              <thead>
                <tr>
                  <th>N°</th>
                  <th class="text-center">Codigo</th>
                  <th class="text-center">Aseguradora</th>
                  <th class="text-center">F. Accidente</th>
                  <th class="text-center">F. Inicio</th>
                  <th class="text-center">F. Entrega</th>
                  <th class="text-center">F. Cargue</th>
                </tr>
              </thead>
              <tbody >
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalCasosSinPDF" role="dialog" aria-labelledby="myModalLabel" >
    <div style="width: 80%;" class="modal-dialog modal-dialog-centered" role="document" style="overflow-y: auto; ">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Mis Casos Sin PDFS</h4>
        </div>
        <div class="modal-body">
          <div calss="table-responsive">
            <table class="table table-hover table-condensed" id="tablaMisCasosSinPDF">
              <thead>
                <tr>
                  <th>N°</th>
                  <th class="text-center">Codigo</th>
                  <th class="text-center">Radicado</th>
                  <th class="text-center">Placa</th>
                  <th class="text-center">Lesionado</th>
                  <th class="text-center">F. Accidente</th>
                </tr>
              </thead>
              <tbody >
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalOcurrenciasAseguradoras" role="dialog" aria-labelledby="myModalLabel" >
    <div class="modal-dialog modal-dialog-centered" role="document" >
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="tituloModalOcurrencias">OCURRENCIAS NO CONFIRMADAS</h4>
        </div>
        <div class="modal-body">
          <div calss="table-responsive">
            <table class="table table-hover table-condensed table-bordered" id="tablaDepartamentoOcurrencias">
              <thead>
                <tr>
                  <th class="text-center">DEPARTAMENTO</th>
                  <th class="text-center">OCURRENCIAS</th>
                  <th class="text-center">TOTAL</th>
                  <th class="text-center">%</th>
                </tr>
              </thead>
              <tbody >

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>