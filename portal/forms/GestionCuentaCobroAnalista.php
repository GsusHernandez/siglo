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

  #periodoAsignarCuentaAnalista>span.select2>span.seletion>span.select2-container{
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

  .chequeos + label:before {
    content: "";
    width: 17px;
    height: 17px;
    float: left;
    border: 2px solid #0fbf12;
    background: #fff;
  }
  .chequeos:checked + label:before {
    border-color: #0fbf12;
  }
  .chequeos:checked + label:after {
    content: "";
    width: 10px;
    height: 5px;
    border: 3px solid #0fbf12;
    float: left;
    margin-left: -1em;
    border-right: 0;
    border-top: 0;
    margin-top: 0.37em;
    transform: rotate(-55deg);
  }
  .chequeos {
    display: none;
  }
  .chequeos + label {
    font-weight: bold;
    line-height: 3em;
    color: #0fbf12;
  }
</style>
<link rel="stylesheet" type="text/css" href="dist/css/contact-form.css">

<div class="row">
  <div class="col-md-12">
    <div class="nav-tabs-custom">
      <ul style="font-weight: bold;" class="nav nav-tabs">
        <li id="menu_1" class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">CREAR CUENTA <span class="fa fa-refresh" onclick="refreshTab('cuentaCobroAnaTab1');" style="color: #ff5504; font-weight: bold; cursor: pointer; font-size: large;" title="Refrescar esta Pestaña"></span></a></li>
        <li id="menu_2"><a href="#tab_2" data-toggle="tab" aria-expanded="false">VER CUENTAS <span class="fa fa-refresh" onclick="refreshTab('cuentaCobroAnaTab2');" style="color: #ff5504; font-weight: bold; display: none; cursor: pointer; font-size: large;" title="Refrescar esta Pestaña"></span></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
          <div class="item-wrap">
            <form id="formConsultaCuentaAnalista" data-toggle="validator" class="popup-form contactForm">
              <div class="row"> 
                <div class="col-md-3 col-sm-12 col-12">
                  <label for="">Aseguradora</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <select name="aseguradoraCuentaAna" id="aseguradoraCuentaAna" class="form-control">
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

                <div class="col-md-4 col-sm-12 col-12">
                  <label for="">Tipo Caso</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <select style="height: 32px"  name="tipoCasoCuentaAna" id="tipoCasoCuentaAna" class="form-control">
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
                  <label for="">F. LIMITE</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <input type="date" name="fLimiteCuentaAna" id="fLimiteCuentaAna" class="form-control">
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                  </div>
                </div>

                <div class="col-md-2 col-sm-12 col-12">
                  <label for="">CODIGO</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <input type="text" name="codigoCuentaAna" id="codigoCuentaAna" class="form-control">
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                  </div>
                </div>

                <div class="col-md-1 col-sm-12 col-12">                            
                  <label style="color: white;">.</label>
                  <div class="form-group last">
                    <button type="submit" id="btnReportePndteAnalista" class="btn btn-custom"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <table id="tablaCasosAnalista" class="table table-striped display table table-hover" cellspacing="0" width="100%">
            <thead style="background-color: #188aff; color: white;">
            </thead>
            <tbody>
            </tbody>            
          </table>
        </div>

        <div class="tab-pane" id="tab_2">
          <div class="item-wrap">
            <form id="formVerCuentaAnalista" data-toggle="validator" class="popup-form contactForm"> 
                <input type="hidden" name="analistaVerCuentaAna" id="analistaVerCuentaAna" value="<?=$_SESSION['id']?>">
              <div class="row"> 

                <div class="col-md-4 col-sm-12 col-12">
                  <label for="">Periodo</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <select style="width: 100%" name="periodoVerCuentaAna" id="periodoVerCuentaAna" class="form-control">
                      <option value="">TODOS</option>
                      <?php 
                      mysqli_next_result($con);
                      $verAmparo =mysqli_query($con,"SELECT a.id, YEAR(a.periodo) AS anio, a.periodo, a.numero, CASE WHEN MONTH(a.periodo) = 1 THEN 'ENERO' WHEN MONTH(a.periodo) = 2 THEN 'FEBRERO' WHEN MONTH(a.periodo) = 3 THEN 'MARZO' WHEN MONTH(a.periodo) = 4 THEN 'ABRIL' WHEN MONTH(a.periodo) = 5 THEN 'MAYO' WHEN MONTH(a.periodo) = 6 THEN 'JUNIO' WHEN MONTH(a.periodo) = 7 THEN 'JULIO' WHEN MONTH(a.periodo) = 8 THEN 'AGOSTO' WHEN MONTH(a.periodo) = 9 THEN 'SEPTIEMBRE' WHEN MONTH(a.periodo) = 10 THEN 'OCTUBRE' WHEN MONTH(a.periodo) = 11 THEN 'NOVIEMBRE' WHEN MONTH(a.periodo) = 12 THEN 'DICIEMBRE' END AS nomMes, a.periodo FROM cuenta_cobro_analista a WHERE a.id_analista = ".$_SESSION['id']." GROUP BY a.periodo, a.numero ORDER BY a.periodo DESC, a.numero DESC;");
                      while($resul = mysqli_fetch_assoc($verAmparo)){ ?>
                        <option value="<?=$resul['periodo']."/".$resul['numero']; ?>"><?=$resul['numero']." - ".$resul['nomMes']." ".$resul['anio']; ?></option>
                        <?php 
                      } ?>
                    </select>
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                  </div>
                </div>
                
                <div class="col-md-1 col-sm-12 col-12">                            
                  <label style="color: white;">.</label>
                  <div class="form-group last">
                    <button type="submit" id="btnVerCuentaAna" class="btn btn-custom"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </form>
          </div>

          <form id="formCerrarCuentaAnalista" style="display: none;" data-toggle="validator" class="popup-form contactForm">
            <div id="encabezado" class="box box-warning box-solid">
              <div class="box-header with-border">
                <h3 class="box-title">Datos Cuenta de Cobro</h3>
              </div>
              <div class="box-body">
                <div class="row invoice-info">
                  <div class="col-sm-4 invoice-col">            
                      <b>Cuenta #<span id="numVerCuentaAna"></span></b><br>
                      <b>Estado:</b><small id="estVerCuentaAna" class="label bg-red parpadea"></small>
                  </div>
                  <div class="col-sm-4 invoice-col">
                      <strong>Nombre: </strong><span id="nomAnaVerCuentaAna"></span><br>
                      <strong>Periodo: </strong><span id="perVerCuentaAna"></span>
                  </div>
                  <div class="col-sm-4 invoice-col">
                    <b>Atender/Positivo:</b> <span id="canResultVerCuentaAna">/</span><br>
                    <b>Cantidad:</b> <span id="cantidadVerCuentaAna"></span>
                  </div>
                </div>
              </div>
            </div>

            <table id="tablaVerCasosAna" class=" table table-striped display table table-hover" cellspacing="0" width="100%">
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
                  <tbody id="totalesAseguradoraVerCasosAna"></tbody>
                </table>
              </div>

              <div class="col-xs-6 pull-right">
                <div class="table-responsive">
                  <table class="table">
                    <tbody>
                      <tr>
                        <td colspan="2">
                          <b>Observación</b>
                          <textarea name="observacionVerCasosAna" id="observacionVerCasosAna" style="width:100%;  resize:none;"></textarea>
                        </td>
                      </tr>
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>$ <span id="subtotalVerCasosAna"></span></td>
                      </tr>
                      <tr>
                        <th>Adicional:</th>
                        <td>$ <input type="number" value="0" name="adicionalVerCasosAna" id="adicionalVerCasosAna"></td>
                      </tr>
                      <tr>
                        <th>Descuentos:</th>
                        <td> - <input readonly type="number" value="0" name="descuentoVerCasosAna" id="descuentoVerCasosAna"></td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td>$ <span id="totalVerCasosAna"></span></td>
                      </tr>
                      <tr>
                      <tr style="color: red; font-weight: bold; display:none;" id="trValorGuardado">
                        <th>Valor Guardado:</th>
                        <td>$ <span id="valorGuardadoCasosAna" data-toggle="tooltip" data-placement="left" title="Este es el valor a cobrar, haga clic en GUARDAR CUENTA para actualizar al valor total"></span></td>
                      </tr>
                        <td colspan="2">
                          <button type="button" id="guardarCuentaAna" style="font-weight:bold; margin-top: 5px; padding-top: 3px !important; border-radius: 5px;" class="btn btn-primary pull-right">GUARDAR CUENTA</button>

                          <!--<button type="button" id="cerrarCuentaAna" style="display: none; font-weight:bold; margin-top: 5px; padding-top: 3px !important; border-radius: 5px;" class="btn btn-danger pull-right">CERRAR CUENTA</button>
                          <button type="button" id="habilitarCuentaAna" style="display: none; font-weight:bold; margin-top: 5px; padding-top: 3px !important; border-radius: 5px;" class="btn btn-primary pull-right">HABILITAR CUENTA</button>-->
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

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalAsignarACuentaAna" role="dialog" >
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" id="frmAsignarCasosCuentaAna">
        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Asignar Cuenta De Cobro</h4>
        </div>
        <div class="modal-body">
          <div class="col-md-6">
            <div class="form-group">
              <label for="periodoAsignarCuentaAna">Periodo</label>
                <input style="text-transform:uppercase;" type="month"  min="2020-11" max="2030-12" class="form-control CampText" id="periodoAsignarCuentaAna">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="numeroAsignarCuentaAna">Número</label>
                <select id="numeroAsignarCuentaAna" name="numeroAsignarCuentaAna" style="width: 100%;" class="form-control select2" >
                  <option value="1">1</option>
                  <option value="2">2</option>
                </select>
            </div>
          </div>

          <div  class="col-md-2">
            <div  class="form-group">
              <label style="color: white; width: 100%">.</label>
              <button style="display: none;" class="btn btn-primary" onclick=""><span class="fa fa-plus"></span></button>
            </div>
          </div>
          
          <div class="col-md-12">
            <table id="tablaCasosAsignarCuentaAna" class="table table-striped display table table-hover" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Origen</th>
                  <th>Codigo</th>
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
          <input id="idCasoSoatAnalistaCuentaCobro" type="hidden">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
          <button class="btn btn-primary" type="submit">Asignar</button>
        </div>
      </div>
    </form>
  </div>
</div>