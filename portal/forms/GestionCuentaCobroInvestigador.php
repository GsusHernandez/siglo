<?php
  $dia = date("Y-m-d");
  //$dia = "2020-01-16";
  $cuota = 9;
  $cuotaGen = 135;

  if(date("l") == "Saturday"){
    $cuota=6;
    $cuotaGen = 90;
  }

  mysqli_next_result($con);
  $totalInfo = 0;
  $totalPorI = 0;
  $arrayAnalistas = array();
  $cant= 0;
?>
<style type="text/css">
  .dt-button {
    padding: 0 !important;
    border: none !important;
  }

  #periodoAsignarCuentaInv>span.select2>span.seletion>span.select2-container{
    background-color: #ff0000;
  }

  #tablaVerCasosInv_wrapper>div>div>div>table>thead>tr>th{
    /*border: black solid 1px;*/
  }

  .parpadea {
  
    animation-name: parpadeo;
    animation-duration: 1.5s;
    animation-timing-function: linear;
    animation-iteration-count: infinite;

    -webkit-animation-name:parpadeo;
    -webkit-animation-duration: 1.5s;
    -webkit-animation-timing-function: linear;
    -webkit-animation-iteration-count: infinite;
  }

  @-moz-keyframes parpadeo{  
    0% { opacity: 1.0; }
    50% { opacity: 0.0; }
    100% { opacity: 1.0; }
  }

  @-webkit-keyframes parpadeo {  
    0% { opacity: 1.0; }
    50% { opacity: 0.0; }
     100% { opacity: 1.0; }
  }

  @keyframes parpadeo {  
    0% { opacity: 1.0; }
     50% { opacity: 0.0; }
    100% { opacity: 1.0; }
  }
</style>
<link rel="stylesheet" type="text/css" href="dist/css/contact-form.css">
<!-- iCheck 
<link rel="stylesheet" href="plugins/iCheck/minimal/minimal.css">
<script src="plugins/iCheck/icheck.min.js"></script>-->

<div class="row">
  <div class="col-md-12">

    <div class="nav-tabs-custom">
      <ul style="font-weight: bold;" class="nav nav-tabs">
        <li id="menu_1" class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">CREAR CUENTA <span class="fa fa-refresh" onclick="refreshTab('cuentaCobroInvTab1');" style="color: #ff5504; font-weight: bold; cursor: pointer; font-size: large;" title="Refrescar esta Pestaña"></span></a></li>
        <li id="menu_2"><a href="#tab_2" data-toggle="tab" aria-expanded="false">VER CUENTAS <span class="fa fa-refresh" onclick="refreshTab('cuentaCobroInvTab2');" style="color: #ff5504; font-weight: bold; display: none; cursor: pointer; font-size: large;" title="Refrescar esta Pestaña"></span></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
          <div class="item-wrap">
            <form id="formConsultaCuentaInvest" data-toggle="validator" class="popup-form contactForm">
              <div class="row"> 

                <div class="col-md-3 col-sm-12 col-12">
                  <label for="">Investigador</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <select name="investigadorCuentaInv" id="investigadorCuentaInv" class="form-control">
                      <option value="">TODOS</option>
                      <?php 
                      mysqli_next_result($con);
                      $verAmparo =mysqli_query($con,"SELECT id, CONCAT(nombres, ' ', apellidos) AS nombre FROM investigadores WHERE vigente='s' and id <> 30 ORDER BY CONCAT(nombres, ' ', apellidos);");
                      while($resul = mysqli_fetch_assoc($verAmparo)){ ?>
                        <option value="<?=$resul['id']; ?>"><?=trim($resul['nombre']); ?></option>
                        <?php 
                      } ?>
                    </select>
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                  </div>
                </div>

                <div class="col-md-3 col-sm-12 col-12">
                  <label for="">Aseguradora</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <select name="aseguradoraCuentaInv" id="aseguradoraCuentaInv" class="form-control">
                      <option value="">TODAS</option>
                      <?php 
                      mysqli_next_result($con);
                      $verAmparo =mysqli_query($con,"SELECT * FROM aseguradoras WHERE vigente='s';");
                      while($resul = mysqli_fetch_assoc($verAmparo)){ ?>
                        <option value="<?=$resul['id']; ?>"><?=$resul['nombre_aseguradora']; ?></option>
                        <?php 
                      } ?>
                    </select>
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                  </div>
                </div>

                <div class="col-md-3 col-sm-12 col-12">
                  <label for="">Tipo Caso</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <!--multiple="multiple"-->
                    <select style="height: 32px"  name="tipoCasoCuentaInv" id="tipoCasoCuentaInv" class="form-control">
                      <option value="">TODOS</option>
                      <?php 
                      mysqli_next_result($con);
                      $verAmparo =mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo = 8;");
                      while($resul = mysqli_fetch_assoc($verAmparo)){ ?>
                        <option value="<?=$resul['id']; ?>"><?=$resul['descripcion']; ?></option>
                        <?php 
                      } ?>
                    </select>
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                  </div>
                </div>

                <div class="col-md-2 col-sm-12 col-12">
                  <label for="">F. Limite</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <input type="date" name="fLimiteCuentaInv" id="fLimiteCuentaInv" class="form-control">
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                  </div>
                </div>

                <div class="col-md-1 col-sm-12 col-12">                            
                  <label style="color: white;">.</label>
                  <div class="form-group last">
                    <button type="submit" id="btnReportePndteAnlista" class="btn btn-custom"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <table id="tablaCasosInvestigador" class="table table-striped display table table-hover" cellspacing="0" width="100%">
            <thead style="background-color: #188aff; color: white;">
            </thead>
            <tbody>
            </tbody>            
          </table>
        </div>

        <div class="tab-pane" id="tab_2">
          <div class="item-wrap">
            <form id="formVerCuentaInvest" data-toggle="validator" class="popup-form contactForm">
              <div class="row"> 

                <div class="col-md-3 col-sm-12 col-12">
                  <label for="">Investigador</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <select style="width: 100%" name="investigadorVerCuentaInv" id="investigadorVerCuentaInv" class="form-control">
                      <option value="">TODOS</option>
                      <?php 
                      mysqli_next_result($con);
                      $verAmparo =mysqli_query($con,"SELECT id, CONCAT(nombres, ' ', apellidos) AS nombre FROM investigadores WHERE vigente='s' and id <> 30 ORDER BY CONCAT(nombres, ' ', apellidos);");
                      while($resul = mysqli_fetch_assoc($verAmparo)){ ?>
                        <option value="<?=$resul['id']; ?>"><?=trim($resul['nombre']); ?></option>
                        <?php 
                      } ?>
                    </select>
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                  </div>
                </div>

                <div class="col-md-4 col-sm-12 col-12">
                  <label for="">Periodo</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <select style="width: 100%" name="periodoVerCuentaInv" id="periodoVerCuentaInv" class="form-control">
                      <option value="">TODOS</option>
                      <?php 
                      mysqli_next_result($con);
                      $verAmparo =mysqli_query($con,"SELECT a.id, YEAR(a.periodo) AS anio,
                       a.periodo, a.numero, CASE WHEN MONTH(a.periodo) = 1 THEN 'ENERO' WHEN MONTH(a.periodo) = 2 THEN 'FEBRERO' WHEN MONTH(a.periodo) = 3 THEN 'MARZO' WHEN MONTH(a.periodo) = 4 THEN 'ABRIL' WHEN MONTH(a.periodo) = 5 THEN 'MAYO' WHEN MONTH(a.periodo) = 6 THEN 'JUNIO' WHEN MONTH(a.periodo) = 7 THEN 'JULIO' WHEN MONTH(a.periodo) = 8 THEN 'AGOSTO' WHEN MONTH(a.periodo) = 9 THEN 'SEPTIEMBRE' WHEN MONTH(a.periodo) = 10 THEN 'OCTUBRE' WHEN MONTH(a.periodo) = 11 THEN 'NOVIEMBRE' WHEN MONTH(a.periodo) = 12 THEN 'DICIEMBRE' END AS nomMes, a.periodo FROM cuenta_cobro_investigador a GROUP BY a.periodo, a.numero ORDER BY a.periodo DESC, a.numero DESC;");
                      while($resul = mysqli_fetch_assoc($verAmparo)){ ?>
                        <option value="<?=$resul['periodo']."/".$resul['numero']; ?>"><?=$resul['numero']." - ".$resul['nomMes']." ".$resul['anio']; ?></option>
                        <?php 
                      } ?>
                    </select>
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                  </div>
                </div>

                <div class="col-md-2 col-sm-12 col-12">
                  <label for="">N° CUENTA</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <input type="text" name="numeroVerCuentaInv" id="numeroVerCuentaInv" class="form-control">
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                  </div>
                </div>
                
                <div class="col-md-1 col-sm-12 col-12">                            
                  <label style="color: white;">.</label>
                  <div class="form-group last">
                    <button type="submit" id="btnVerCuentaInv" class="btn btn-custom"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </form>
          </div>

          <form id="formCerrarCuentaInvest" style="display: none;" data-toggle="validator" class="popup-form contactForm">

            <div id="encabezado" class="box box-warning box-solid">
              <div class="box-header with-border">
                <h3 class="box-title">Datos Cuenta de Cobro</h3>
              </div>
              <div class="box-body">
                <div class="row invoice-info">
                  <div class="col-sm-4 invoice-col">            
                      <b>Cuenta #<span id="numVerCuentaInv"></span></b><br>
                      <b>Estado:</b><small id="estVerCuentaInv" class="label bg-red parpadea"></small>
                  </div>

                  <div class="col-sm-4 invoice-col">
                      <strong>Nombre: </strong><span id="nomInvVerCuentaInv"></span><br>
                      <strong>Periodo: </strong><span id="perVerCuentaInv"></span>
                  </div>

                  <div class="col-sm-4 invoice-col">
                    <b>Atender/Positivo:</b> <span id="canResultVerCuentaInv">/</span><br>
                    <b>Cantidad:</b> <span id="cantidadVerCuentaInv"></span>
                  </div>
                </div>
              </div>
            </div>

            <table id="tablaVerCasosInv" class=" table table-striped display table table-hover" cellspacing="0" width="100%">
              <thead style="background-color: #193456; color:#fff;">
              </thead>
              <tbody>
              </tbody>            
            </table>
            
            <div class="row">
              <div class="col-xs-6">
                <table class="table table-condensed">
                  <thead>
                    <tr>
                      <th>#</th><th>ASEGURADORA</th><th style="width: 40px">CANT</th>
                    </tr>
                  </thead>
                  <tbody id="totalesAseguradoraVerCasosInv"></tbody>
                </table>
              </div>

              <div class="col-xs-6 pull-right">
                <div class="table-responsive">
                  <table class="table">
                    <tbody>
                      <tr>
                        <td colspan="2">
                          <b>Observación</b>
                          <textarea name="observacionVerCasosInv" id="observacionVerCasosInv"  rows="5" style="width:100%; resize:vertical;"></textarea></td>
                      </tr>
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>$ <span id="subtotalVerCasosInv"></span></td>
                      </tr>
                      <tr>
                        <th>Viaticos:</th>
                        <td>$ <input type="number" value="0" name="viaticosVerCasosInv" id="viaticosVerCasosInv"></td>
                      </tr>
                      <tr>
                        <th>Adicional:</th>
                        <td>$ <input type="number" value="0" name="adicionalVerCasosInv" id="adicionalVerCasosInv"></td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td>$ <span id="totalVerCasosInv"></span></td>
                      </tr>
                      <tr>
                        <td colspan="2">
                          <button type="button" id="cerrarCuentaInv" style="font-weight:bold; margin-top: 5px; padding-top: 3px !important; border-radius: 5px;" class="btn btn-danger pull-right">CERRAR CUENTA</button>
                          <button type="button" id="habilitarCuentaInv" style="display: none; font-weight:bold; margin-top: 5px; padding-top: 3px !important; border-radius: 5px;" class="btn btn-primary pull-right">HABILITAR CUENTA</button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalAsignarACuentaInv" role="dialog" >
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" id="frmAsignarCasosCuentaInv">
        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Asignar Cuenta De investigador</h4>
        </div>
        <div class="modal-body">
          <div class="col-md-12">
            <div class="form-group">
              <label for="investigadorAsignarCuentaInv">Investigador</label>
                <select name="investigadorAsignarCuentaInv" id="investigadorAsignarCuentaInv" style="width: 100%;" class="form-control select2" >
                    <option value="">SELECCIONE UNA OPCION</option>
                    <?php 
                    mysqli_next_result($con);
                    $consultarInvestigadores="CALL consultasBasicas(9)";
                    $verInvestigadores=mysqli_query($con,$consultarInvestigadores);
                    while($resul2 = mysqli_fetch_assoc($verInvestigadores)){
                    ?>
                    <option value="<?=$resul2['id']; ?>">
                    <?=$resul2['nombre_investigador']; ?>                                              
                    </option>
                    <?php 
                    }
                    ?>
                </select>                   
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="periodoAsignarCuentaInv">Periodo</label>
                <input style="text-transform:uppercase;" type="month" min="2020-11" max="2030-12" class="form-control CampText" id="periodoAsignarCuentaInv">
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label for="numeroAsignarCuentaInv">Número</label>
                <select id="numeroAsignarCuentaInv" name="numeroAsignarCuentaInv" style="width: 100%;" class="form-control select2" >
                  <option value="1">1</option>
                  <option value="2">2</option>
                </select>
            </div>
          </div>

          <div class="col-md-2">
            <div class="form-group">
              <label style="color: white; width: 100%">.</label>
              <button class="btn btn-primary" onclick=""><span class="fa fa-plus"></span></button>
            </div>
          </div>
          
          <div class="col-md-12">
            <table id="tablaCasosAsignarCuentaInv" class="table table-striped display table table-hover" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Codigo</th>
                  <th>Placa</th>
                  <th>Poliza</th>
                  <th>Resultado</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <input id="idCasoSoatInvestigadorCuentaCobro" type="hidden">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
          <button class="btn btn-primary" type="submit">Asignar</button>
        </div>
      </div>
    </form>
  </div>
</div>