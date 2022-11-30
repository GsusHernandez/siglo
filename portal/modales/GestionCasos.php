<?php

$consultarProgramasModales=mysqli_query($con,"SELECT * FROM opciones a LEFT JOIN opciones_usuarios b ON a.id=b.opcion WHERE b.usuario='".$idUsuario."' and a.tipo_opcion in (5) and a.opcion_padre='RI00'");

if (mysqli_num_rows($consultarProgramasModales)>0){

  while ($resProgramasModales=mysqli_fetch_array($consultarProgramasModales,MYSQLI_ASSOC)){ ?>

    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="<?php echo $resProgramasModales["ruta"];?>" role="dialog" aria-labelledby="myModalLabel" >
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="overflow-y: auto; ">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="tituloModalDinamico"><?php echo $resProgramasModales["descripcion"];?></h4>
          </div>
          <div class="modal-body">
            <?php include("forms/".$resProgramasModales["ruta"].".php"); ?>
          </div>
        </div>
      </div>
    </div>
    <?php
  }
}
?>







<div class="modal fade" data-backdrop="static" data-keyboard="false" id="frmBuscarInvestigaciones" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="overflow-y: auto; ">
    <div class="modal-content">
        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="tituloModalDinamico">BUSCAR INVESTIGACIONES</h4>
        </div>
        <div class="modal-body">
          <?php include("forms/frmBuscarInvestigaciones.php"); ?>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalFrmCasosValidaciones" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog" style="overflow-y: auto; ">
    <div class="modal-content">
        <div class="modal-header rounded-top" style="background:#3c8dbc">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <a class="font-weight-bold" style="color:white">CASOS VALIDACIONES IPS</a>
        </div>
        <div>
          <?php include("forms/frmCasosValidaciones.php"); ?>
        </div>  
        <div class="modal-footer">
          <div class="p-3 text-center">
            <input id="btnSubmitFrmCasosValidaciones" class="btn btn-primary" type="submit" name="" value="Guardar">
          </div>
        </div>
    </div>
  </div>
</div> 

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalFrmCasosGM" role="dialog" aria-labelledby="myModalLabel" style="overflow-y: auto; ">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header rounded-top" style="background:#3c8dbc">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <a class="font-weight-bold" style="color:white">CASOS GASTOS MÉDICOS</a>
        </div>
        <div>
          <?php include("forms/frmCasosGM.php"); ?>
        </div>  
        <div class="modal-footer">
          <div class="p-3 text-center">
            <input id="btnSubmitFrmCasosGM" class="btn btn-primary" type="submit" name="" value="Guardar">
          </div>
        </div>
    </div>
  </div>
</div> 

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalFrmAsignarInvestigacion" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header rounded-top" style="background:#3c8dbc">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <a class="font-weight-bold" style="color:white">ASIGNAR INVESTIGACIÓN</a>
        </div>
        <div>
          <?php include("forms/frmAsignarInvestigacion.php"); ?>
        </div>  
        <div class="modal-footer">
          <div class="p-3 text-center">
            <input id="btnSubmitFrmAsignarInvestigacion" class="btn btn-primary" type="submit" name="" value="Guardar">
          </div>
        </div>
    </div>
  </div>
</div> 


<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalAsignarAnalista" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog modal-dialog-centered" role="document" style="overflow-y: auto; max-height: 90%; margin-top: 40px;">
    <div class="modal-content">
        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="tituloModalDinamico">ASIGNAR ANÁLISTA</h4>
        </div>
        <div class="modal-body">
          <?php include("forms/frmAsignarAnalista.php"); ?>
        </div>
    </div>
  </div>
</div>


<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalCambioEstado" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog modal-dialog-centered" role="document" style="overflow-y: auto; max-height: 90%; margin-bottom: 50px;">
    <div class="modal-content">
        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="tituloModalDinamico">CAMBIAR ESTADO</h4>
        </div>
        <div class="modal-body">
          <?php
          include("forms/frmCambioEstado.php");
          ?>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalAmpliacionCasoSOAT" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog modal-dialog-centered" role="document" style="overflow-y: auto; max-height: 90%; margin-bottom: 50px;">
    <div class="modal-content">
        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="tituloModalDinamico">CREAR AMPLIACIÓN</h4>
        </div>
        <div class="modal-body">
          <?php include("forms/frmAmpliacionCasoSOAT.php"); ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
          <button class="btn btn-primary" id="btnCrearAmpliacionInvestigacion">Guardar</button>
        </div>
    </div>
  </div>
</div>

<div  class="modal fade mt-5" data-backdrop="static" data-keyboard="false" id="modalModuloInforme"  tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">  
  <div class="modal-dialog modal-informe" style="width: 100% !important; padding: 20px 20px !important;" >
    <div class="modal-header rounded-top" style="background:#bc3c3c;">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <a class="font-weight-bold" style="color:white">MODULO INFORME <b id="placa_temp_asig"></b></a>
    </div>
    <div class="modal-content" >
      <div class="row" style="margin-left: 0px !important; margin-right: 0px !important;">
        <?php include("forms/frmModuloInforme.php"); ?>
      </div>  
    </div>
  </div>
</div> 


<div class="modal fade mt-5" data-backdrop="static" data-keyboard="false" id="modalAgregarLesionados" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-informe" style="overflow-y: auto; margin: 40px;">
    <div class="modal-header rounded-top" style="background:#3c8dbc;">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <a class="font-weight-bold" style="color:white">LESIONADOS</a>
    </div>
    <div class="modal-content">
      <div class="row" style="margin-left: 0px; margin-right: 0px;">
        <?php  include("forms/frmLesionados.php"); ?>
      </div>
    </div>
  </div>
</div> 


<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalAgregarVictima" role="dialog" >    
  <div class="modal-dialog" style="overflow-y: auto; margin-top: 40px;">
    <div class="modal-content">
      <div class="row" style="padding-left: 0px; padding-right: 0px;">
        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">REGISTRAR VICTIMA</h4>
        </div>
        <div class="modal-body">
          <?php  include("forms/frmVictimasCasoSOAT.php"); ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
          <button class="btn btn-primary" id="btnGuardarVictimaSoat">Guardar</button>
        </div>
      </div>
    </div>
  </div>
</div> 

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalAgregarBeneficiarios" role="dialog" >
  <div class="modal-dialog" style="overflow-y: auto;  margin-top: 40px;">
    <div class="modal-content">
      <div class="row" style="padding-left: 0px; padding-right: 0px;">
        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">REGISTRO DE BENEFICIARIO</h4>
        </div>
        <div class="modal-body">
          <?php  include("forms/frmBeneficiariosCasoSOAT.php"); ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
          <button class="btn btn-primary" id="btnGuardarBeneficiarioSoat">Guardar</button>
        </div>
      </div>
    </div>
  </div>
</div> 

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="FrmPersonas" role="dialog" >
  <div class="modal-dialog" style="overflow-y: auto; margin-top: 50px;">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">REGISTRO DE PERSONAS</h4>
      </div>
      <div class="modal-body">
        <?php  include("forms/frmPersonas.php"); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
        <button class="btn btn-primary" id="btnGuardarPersona">Guardar</button>
      </div>
    </div>
  </div>
</div> 

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="GestionPersonas" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog" style="overflow-y: auto; margin-top: 50px;">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="tituloFrmGestionPacientes">GESTIÓN DE PERSONAS</h4>  
      </div>
      <div class="modal-body">
        <?php
        include("forms/GestionPersonas.php");
        ?>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="GestionVehiculos" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog" style="overflow-y: auto; max-height: 90%; margin-bottom: 50px;">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="tituloFrmGestionPacientes">Gestion Vehiculos</h4>
      </div>
      <div class="modal-body">
        <?php
        include("forms/GestionVehiculos.php");
        ?>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="FrmPolizas" role="dialog" >
  <div class="modal-dialog" style="overflow-y: auto; max-height: 90%; margin-bottom: 50px;">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">REGISTRO DE PÓLIZAS</h4>
      </div>
      <div class="modal-body">
        <?php include("forms/frmPolizas.php"); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
        <button class="btn btn-primary" id="btnGuardarPolizas">Guardar</button>
      </div>
    </div>
  </div>
</div> 

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="FrmObservacionesInforme" role="dialog" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">OBSERVACIONES</h4>
      </div>
      <div class="modal-body">
        <?php include("forms/frmObservaciones.php"); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
        <button class="btn btn-primary" id="btnGuardarObservaciones">Guardar</button>
      </div>
    </div>
  </div>
</div> 



<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalEstadoCasosAutorizacionMultiple" role="dialog" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Estado Casos Autorizados Facturacion</h4>
      </div>
      <div class="modal-body">
        <?php include("forms/frmEstadoCasosAutorizadosFacturacionMultiple.php"); ?>
      </div>
    
    </div>
  </div>
</div> 









<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalDuplicadoCasosAutorizadosFacturacion" role="dialog" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Casos Autorizados Facturacion</h4>
      </div>
      <div class="modal-body">
        <?php include("forms/frmDuplicadosCasosAutorizadosFacturacion.php"); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
        <button class="btn btn-primary" id="btnConfirmarDuplicadosCasosAutorizadosFacturacion">Confirmar</button>
      </div>
    </div>
  </div>
</div> 





<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalAsignarInvestigadorCuentaCobro" role="dialog" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Asignar Investigador Cuenta Cobro</h4>
      </div>
      <div class="modal-body">
        <?php include("forms/frmAsignarInvestigadorCuentaCobro.php"); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
        <div id="divButtonAsignarInvestigadorCuentaCobro">
        <button class="btn btn-primary" id="btnSubmitAsignarInvestigadorCuentaCobro">Confirmar</button>
      </div>
      </div>
    </div>
  </div>
</div> 

<div class="modal fade" id="modalSeleccionarPoliza" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">¿Desea Seleccionar Poliza?</h4>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-hover table-borderer table-condensed center">
            <thead>
              <tr>
                <th class="text-center">Poliza</th>
                <th class="text-center">Compañia</th>
                <th class="text-center">Opcion</th>
              </tr>
            </thead>
            <tbody id="tablaSeleccionarPoliza">

            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalConResultado" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="tituloModalDinamico">ALERTA DE RESULTADO</h4>
      </div>
      <div class="modal-body">
        <h4>EL INFORME DEBERÁ IR SIN RESULTADO PARA:
          <br><ul><li>Seguros del ESTADO</li><li>Aseguradora SOLIDARIA</li></ul>
          <br><b>¿Desea Incluir el resultado?</b></h4>
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger pull-left btnConResultado" onclick="descargarInformeWord('si');">SI</button>
        <button class="btn btn-success pull-right btnConResultado" onclick="descargarInformeWord('no');">NO, CONTINUAR</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalBuscarProcesosJudiciales" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">BUSCAR PROCESOS JUDICIALES</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-4">
            <div class="form-group buscarPJ1">
              <label for="">Codigo</label>
              <input type="text" class="form-control" id="txtCodigoBpj" placeholder="Codigo">
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group buscarPJ1">
              <label for="">Placa</label>
              <input type="text" class="form-control" id="txtPlacaBpj" placeholder="Placa">
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group buscarPJ1">
              <label for="">Articulo</label>
              <input type="text" class="form-control" id="txtArticuloBpj" placeholder="Articulo">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4">
            <div class="form-group buscarPJ2">
              <label for="">Poliza</label>
              <input type="text" class="form-control" id="txtPolizaBpj" placeholder="Poliza">
            </div>                        
          </div>
          <div class="col-sm-4">
            <div class="form-group buscarPJ3">
              <label for="">Siniestro</label>
              <input type="text" class="form-control" id="txtSiniestroBpj" placeholder="Siniestro">
            </div>                        
          </div>
          <div class="col-sm-4">
            <div class="form-group buscarPJ4">
              <label for="">Fecha Siniestro</label>
              <input type="date" class="form-control" id="BpjFechaSiniestro" max="<?= date("Y-m-d")?>" min="2000-01-01">
            </div>                        
          </div>
          <div class="col-sm-4">
            <div class="form-group buscarPJ5">
              <label for="">Identificación</label>
              <input type="text" class="form-control" id="txtIdentificaciónBpj" placeholder="Identificación">
            </div>                        
          </div>
          <div class="col-sm-4">
            <div class="form-group buscarPJ6">
              <label for="">Nombre</label>
              <input type="text" class="form-control" id="txtNombreBpj" placeholder="Nombre">
            </div>                        
          </div>
          <div class="col-sm-4">
            <div class="form-group buscarPJ7">
              <label for="">Apellidos</label>
              <input type="text" class="form-control" id="txtApellidosBpj" placeholder="Apellidos">
            </div>                        
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnBuscarProcesosJuridicosFiltros">Buscar</button>
      </div>
    </div>
  </div>
</div>