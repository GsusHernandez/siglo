<?php
  $dia = date("Y-m-d");
  $usAseguradora = '';
  if($_SESSION['tipo_usuario'] == 4){
    $usAseguradora = 'disabled';
  }
?>
<style type="text/css">
  .dt-button {
    padding: 0 !important;
    border: none !important;
  }

  #periodoAsignarFacturar>span.select2>span.seletion>span.select2-container{
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
        <!--<li id="menu_1"><a href="#tab_1" data-toggle="tab" aria-expanded="true">NUEVA FACTURA <span class="fa fa-refresh" onclick="refreshTab('cuentaCobroInvTab1');" style="color: #ff5504; font-weight: bold; cursor: pointer; font-size: large;" title="Refrescar esta Pestaña"></span></a></li>-->
        <li id="menu_2" class="active"><a href="#tab_2" data-toggle="tab" aria-expanded="false">VER FACTURA <span class="fa fa-refresh" onclick="refreshTab('cuentaCobroInvTab2');" style="color: #ff5504; font-weight: bold; display: none; cursor: pointer; font-size: large;" title="Refrescar esta Pestaña"></span></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane" id="tab_1">
          <div class="item-wrap">

            <form id="formConsultaFacturar" data-toggle="validator" class="popup-form contactForm">
              <div class="row"> 

                <div class="col-md-3 col-sm-12 col-12">
                  <label for="">Aseguradora</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <select name="aseguradoraFacturar" id="aseguradoraFacturar" class="form-control">
                      <option value="">SELECCIONE</option>
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
                    <select style="height: 32px"  name="tipoCasoFacturar" id="tipoCasoFacturar" class="form-control">
                      <option value="">SELECCIONE</option>
                    </select>
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                  </div>
                </div>

                <div class="col-md-3 col-sm-12 col-12">
                  <label for="">F. Limite</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <input type="date" name="fLimiteFacturar" id="fLimiteFacturar" class="form-control">
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                  </div>
                </div>

                <div class="col-md-2 col-sm-12 col-12">
                  <label for="">Código</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <input type="text" name="codigoFacturar" id="codigoFacturar" class="form-control">
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                  </div>
                </div>

                <div class="col-md-1 col-sm-12 col-12">                            
                  <label style="color: white;">.</label>
                  <div class="form-group last">
                    <button type="submit" id="btnFacturar" class="btn btn-custom"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </form>

          </div>
          <table id="tablaCasosInvestigador" class="table table-striped display table table-hover" cellspacing="0" width="100%">
            <thead style="background-color: #188aff; color: white;">
            </thead>
            <tbody>
            </tbody>            s
          </table>
        </div>

        <div class="tab-pane active" id="tab_2">
          <div class="item-wrap">
            <form id="formVerFactura" data-toggle="validator" class="popup-form contactForm">
              <div class="row"> 
                <div class="col-md-3 col-sm-12 col-12">
                  <label for="">Aseguradora</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <select onchange="cargarPeriodosVerFactura();" name="aseguradoraVerFactura" id="aseguradoraVerFactura" class="form-control" <?=$usAseguradora?>>
                      <option value="">SELECCIONE</option>
                      <?php 
                      mysqli_next_result($con);
                      $verAmparo =mysqli_query($con,"SELECT * FROM aseguradoras WHERE vigente='s';");
                      while($resul = mysqli_fetch_assoc($verAmparo)){ 
                        if($_SESSION['id_aseguradora'] == $resul['id'] && $_SESSION['tipo_usuario'] == 4){ ?>
                          <option value="<?=$resul['id']; ?>" selected><?=$resul['nombre_aseguradora']; ?></option>
                        <?php }else{ ?>
                          <option value="<?=$resul['id']; ?>"><?=$resul['nombre_aseguradora']; ?></option>
                        <?php 
                        }
                      } ?>
                    </select>
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                  </div>
                </div>

                <div class="col-md-3 col-sm-12 col-12">
                  <label for="">Periodo</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <select style="height: 32px" onchange="cargarObservacionVerFactura();" name="periodoVerFactura" id="periodoVerFactura" class="form-control">
                      <option value="">SELECCIONE</option>
                    </select>
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                  </div>
                </div>

                <div class="col-md-3 col-sm-12 col-12">
                  <label for="">Tipo Caso</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <select style="height: 32px"  name="facturaVerFactura" id="facturaVerFactura" class="form-control">
                      <option value="">SELECCIONE</option>
                    </select>
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                  </div>
                </div>

                <div class="col-md-1 col-sm-12 col-12">                            
                  <label style="color: white;">.</label>
                  <div class="form-group last">
                    <button type="submit" id="btnFactura" class="btn btn-custom"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <table id="tablaVerFactura" class="table table-striped display table table-hover" cellspacing="0" width="100%">
            <thead style="background-color: #188aff; color: white;">
            </thead>
            <tbody>
            </tbody>            
          </table>
        </div>
      </div>
    </div>
  </div>
</div>