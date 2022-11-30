<?php
$dia = date("Y-m-d");
//$dia = "2020-01-16";
$cuota = 9;
$cuotaGen = 135;

if (date("l") == "Saturday") {
  $cuota = 6;
  $cuotaGen = 90;
}

mysqli_next_result($con);
$totalInfo = 0;
$totalPorI = 0;
$arrayAnalistas = array();
$cant = 0;
?>
<style type="text/css">
  .dt-button {
    padding: 0 !important;
    border: none !important;
  }

  #periodoAsignarCuentaAnalista>span.select2>span.seletion>span.select2-container {
    background-color: #ff0000;
  }

  #tablaVerCasosInv_wrapper>div>div>div>table>thead>tr>th {
    /*border: black solid 1px;*/
  }

  .parpadea {

    animation-name: parpadeo;
    animation-duration: 1.5s;
    animation-timing-function: linear;
    animation-iteration-count: infinite;

    -webkit-animation-name: parpadeo;
    -webkit-animation-duration: 1.5s;
    -webkit-animation-timing-function: linear;
    -webkit-animation-iteration-count: infinite;
  }

  @-moz-keyframes parpadeo {
    0% {
      opacity: 1.0;
    }

    50% {
      opacity: 0.0;
    }

    100% {
      opacity: 1.0;
    }
  }

  @-webkit-keyframes parpadeo {
    0% {
      opacity: 1.0;
    }

    50% {
      opacity: 0.0;
    }

    100% {
      opacity: 1.0;
    }
  }

  @keyframes parpadeo {
    0% {
      opacity: 1.0;
    }

    50% {
      opacity: 0.0;
    }

    100% {
      opacity: 1.0;
    }
  }

  .chequeos+label:before {
    content: "";
    width: 17px;
    height: 17px;
    float: left;
    border: 2px solid #0fbf12;
    background: #fff;
  }

  .chequeos:checked+label:before {
    border-color: #0fbf12;
  }

  .chequeos:checked+label:after {
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

  .chequeos+label {
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
        <li id="menu_1" class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">GESTIONAR CUENTAS <span class="fa fa-refresh" onclick="refreshTab('cuentaCobroAnaTab3');" style="color: #ff5504; font-weight: bold; cursor: pointer; font-size: large;" title="Refrescar esta Pestaña"></span></a></li>
        <li id="menu_2"><a href="#tab_2" data-toggle="tab" aria-expanded="false">DETALLE CUENTA <span class="fa fa-refresh" onclick="refreshTab('cuentaCobroAnaTab2');" style="color: #ff5504; font-weight: bold; display: none; cursor: pointer; font-size: large;" title="Refrescar esta Pestaña"></span></a></li>
        <li id="menu_3"><a href="#tab_3" data-toggle="tab" aria-expanded="false">CREAR CUENTA</a></li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
          <div class="item-wrap">
            <form id="formVerGrupoCuentaAnalista" data-toggle="validator" class="popup-form contactForm">
              <div class="row">
                <div class="col-md-3 col-sm-12 col-12">
                  <label for="">Periodo</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <select name="periodoVerGrupoCuentasAna" id="periodoVerGrupoCuentasAna" class="form-control">
                      <option value="">TODOS</option>
                      <?php
                      mysqli_next_result($con);
                      $sqlperiodosAna = mysqli_query($con, "SELECT a.id, YEAR(a.periodo) AS anio, a.periodo, a.numero, CASE WHEN MONTH(a.periodo) = 1 THEN 'ENERO' WHEN MONTH(a.periodo) = 2 THEN 'FEBRERO' WHEN MONTH(a.periodo) = 3 THEN 'MARZO' WHEN MONTH(a.periodo) = 4 THEN 'ABRIL' WHEN MONTH(a.periodo) = 5 THEN 'MAYO' WHEN MONTH(a.periodo) = 6 THEN 'JUNIO' WHEN MONTH(a.periodo) = 7 THEN 'JULIO' WHEN MONTH(a.periodo) = 8 THEN 'AGOSTO' WHEN MONTH(a.periodo) = 9 THEN 'SEPTIEMBRE' WHEN MONTH(a.periodo) = 10 THEN 'OCTUBRE' WHEN MONTH(a.periodo) = 11 THEN 'NOVIEMBRE' WHEN MONTH(a.periodo) = 12 THEN 'DICIEMBRE' END AS nomMes, a.periodo FROM cuenta_cobro_analista a GROUP BY a.periodo, a.numero ORDER BY a.periodo DESC, a.numero DESC;");
                      while ($resul = mysqli_fetch_assoc($sqlperiodosAna)) { ?>
                        <option value="<?= $resul['periodo'] . "/" . $resul['numero']; ?>"><?= $resul['numero'] . " - " . $resul['nomMes'] . " " . $resul['anio']; ?></option>
                      <?php
                      } ?>
                    </select>
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div>
                  </div>
                </div>

                <div class="col-md-4 col-sm-12 col-12">
                  <label for="">ANALISTA</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <select style="height: 32px" name="analistaVerGrupoCuentaAna" id="analistaVerGrupoCuentaAna" class="form-control">
                      <option value="">TODOS</option>
                      <?php
                      mysqli_next_result($con);
                      $sqlAnalistas = mysqli_query($con, "SELECT b.id, b.nombres, b.apellidos
                        FROM cuenta_cobro_analista a
                        LEFT JOIN usuarios b ON a.id_analista = b.id
                        GROUP BY a.id_analista
                        ORDER BY b.nombres, b.apellidos;");
                      while ($resul = mysqli_fetch_assoc($sqlAnalistas)) { ?>
                        <option value="<?= $resul['id'] ?>"><?= $resul['nombres'] . " " . $resul['apellidos']; ?></option>
                      <?php } ?>
                    </select>
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div>
                  </div>
                </div>

                <div class="col-md-2 col-sm-12 col-12">
                  <label for="">ESTADO</label>
                  <div class="form-group">
                    <select style="height: 32px" name="estadoVerGrupoCuentaAna" id="estadoVerGrupoCuentaAna" class="form-control">
                      <option value="">TODOS</option>
                      <option value="2">CERRADA</option>
                      <option value="1">ENVIADA</option>
                      <option value="0">ABIERTA</option>
                    </select>
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div>
                  </div>
                </div>

                <div class="col-md-2 col-sm-12 col-12">
                  <label for="">N° CUENTA</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <input type="text" name="numeroVerGrupoCuentaAna" id="numeroVerGrupoCuentaAna" class="form-control">
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div>
                  </div>
                </div>

                <div class="col-md-1 col-sm-12 col-12">
                  <label style="color: white;">.</label>
                  <div class="form-group last">
                    <button type="submit" id="btnCuentasAnalista" class="btn btn-custom"><i class="fa fa-search"></i></button>
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
              <div class="row">

                <div class="col-md-4 col-sm-12 col-12">
                  <label for="">ANALISTA</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <select style="height: 32px;width: 100%" name="analistaVerCuentaAna" id="analistaVerCuentaAna" class="form-control">
                      <option value="">ESCOGER</option>
                      <?php
                      mysqli_next_result($con);
                      $sqlAnalistas = mysqli_query($con, "SELECT b.id, b.nombres, b.apellidos
                        FROM cuenta_cobro_analista a
                        LEFT JOIN usuarios b ON a.id_analista = b.id
                        GROUP BY a.id_analista
                        ORDER BY b.nombres, b.apellidos;");
                      while ($resul = mysqli_fetch_assoc($sqlAnalistas)) { ?>
                        <option value="<?= $resul['id'] ?>"><?= $resul['nombres'] . " " . $resul['apellidos']; ?></option>
                      <?php } ?>
                    </select>
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div>
                  </div>
                </div>

                <div class="col-md-4 col-sm-12 col-12">
                  <label for="">Periodo</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <select style="width: 100%" name="periodoVerCuentaAna" id="periodoVerCuentaAna" class="form-control">
                      <option value="">ESCOGER</option>
                      <?php
                      mysqli_next_result($con);
                      $verAmparo = mysqli_query($con, "SELECT a.id, YEAR(a.periodo) AS anio, a.periodo, a.numero, CASE WHEN MONTH(a.periodo) = 1 THEN 'ENERO' WHEN MONTH(a.periodo) = 2 THEN 'FEBRERO' WHEN MONTH(a.periodo) = 3 THEN 'MARZO' WHEN MONTH(a.periodo) = 4 THEN 'ABRIL' WHEN MONTH(a.periodo) = 5 THEN 'MAYO' WHEN MONTH(a.periodo) = 6 THEN 'JUNIO' WHEN MONTH(a.periodo) = 7 THEN 'JULIO' WHEN MONTH(a.periodo) = 8 THEN 'AGOSTO' WHEN MONTH(a.periodo) = 9 THEN 'SEPTIEMBRE' WHEN MONTH(a.periodo) = 10 THEN 'OCTUBRE' WHEN MONTH(a.periodo) = 11 THEN 'NOVIEMBRE' WHEN MONTH(a.periodo) = 12 THEN 'DICIEMBRE' END AS nomMes, a.periodo FROM cuenta_cobro_analista a GROUP BY a.periodo, a.numero ORDER BY a.periodo DESC, a.numero DESC;");
                      while ($resul = mysqli_fetch_assoc($verAmparo)) { ?>
                        <option value="<?= $resul['periodo'] . "/" . $resul['numero']; ?>"><?= $resul['numero'] . " - " . $resul['nomMes'] . " " . $resul['anio']; ?></option>
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

          <form id="formCerrarCuentaAnalista" onsubmit="return false;" style="display: none;" data-toggle="validator" class="popup-form contactForm">
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
                    <strong>Nombre: </strong><span id="nomInvVerCuentaAna"></span><br>
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
              <tbody disabled>
              </tbody>
            </table>

            <div class="row">
              <div class="col-xs-6">
                <table class="table table-condensed">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>ASEGURADORA</th>
                      <th style="width: 40px">CANT</th>
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
                          <textarea readonly name="observacionVerCasosAna" id="observacionVerCasosAna" style="width:100%;  resize:none;"></textarea>
                        </td>
                      </tr>
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>$ <span id="subtotalVerCasosAna"></span></td>
                      </tr>
                      <tr>
                        <th>Adicional:</th>
                        <td>$ <input readonly type="number" value="0" name="adicionalVerCasosAna" id="adicionalVerCasosAna"></td>
                      </tr>
                      <tr>
                        <th>Descuentos:</th>
                        <td> - <input readonly type="number" value="0" name="descuentoVerCasosAna" id="descuentoVerCasosAna"></td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td>$ <span id="totalVerCasosAna"></span></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </form>
        </div>

        <div class="tab-pane" id="tab_3">
          <div class="item-wrap">
            <form id="frmCrearCuentasAnalista" data-toggle="validator" class="popup-form contactForm">
              <div class="row">

                <div class="col-md-3">
                  <label for="">ANALISTA</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <select style="height: 32px;width: 100%" name="analistaCrearCuentaAna" id="analistaCrearCuentaAna" class="form-control select2">
                      <option value="">ESCOGER</option>
                      <?php
                      mysqli_next_result($con);
                      $sqlAnalistas = mysqli_query($con, "SELECT b.id, b.nombres, b.apellidos
                        FROM cuenta_cobro_analista a
                        LEFT JOIN usuarios b ON a.id_analista = b.id
                        GROUP BY a.id_analista
                        ORDER BY b.nombres, b.apellidos;");
                      while ($resul = mysqli_fetch_assoc($sqlAnalistas)) { ?>
                        <option value="<?= $resul['id'] ?>"><?= $resul['nombres'] . " " . $resul['apellidos']; ?></option>
                      <?php } ?>
                    </select>
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div>
                  </div>
                </div>

                <div class="col-md-2 col-sm-4">
                  <label for="">Periodo</label>
                  <div class="form-group">
                    <input type="month" id="periodoCrearCuentaAna" name="periodoCrearCuentaAna" style="text-transform:uppercase;" min="2020-11" max="2030-12" class="form-control CampText">
                    <div class="input-group-icon"><i class="fa fa-calendar-o"></i></div>
                  </div>
                </div>

                <div class="col-md-1 col-sm-4">
                  <label for="">Numero</label>
                  <div class="form-group">
                    <select id="numeroCrearCuentaAna" name="numeroCrearCuentaAna" style="width: 100%;" class="form-control select2">
                      <option value="1">1</option>
                      <option value="2">2</option>
                    </select>
                    <div class="input-group-icon"><i class="fa fa-user"></i></div>
                  </div>
                </div>

                <div class="col-md-4">
                  <label style="color: white;">.</label>
                  <div class="form-group last">
                    <button type="submit" id="btnCrearCuenta" class="btn btn-custom"><i class="fa fa-plus"></i></button>
                  </div>
                </div>

              </div>
            </form>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalCerrarCuentaAna" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" id="frmCerrarCuentasAnalista">
        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Cerrar Cuentas De Cobro</h4>
        </div>
        <div class="modal-body">
          <div class="col-md-12">
            <table id="tablaCuentasCerrarCuentaAna" class="table table-striped display table table-hover" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Análista</th>
                  <th>Periodo</th>
                  <th>Total</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
          <button class="btn btn-danger" type="submit">Cerrar Cuentas</button>
        </div>
    </div>
    </form>
  </div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalHabilitarCuentas" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" id="frmAbrirCuentasAnalista">
        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Habilitar Cuentas De Cobro</h4>
        </div>
        <div class="modal-body">
          <div class="col-md-12">
            <table id="tablaCuentasAbrirCuentaAna" class="table table-striped display table table-hover" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Análista</th>
                  <th>Periodo</th>
                  <th>Total</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
          <button class="btn btn-success" type="submit">Habilitar Cuentas</button>
        </div>
    </div>
    </form>
  </div>
</div>