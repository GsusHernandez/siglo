<link rel="stylesheet" type="text/css" href="dist/css/contact-form.css">
<div class="row">
  <div class="col-md-12">
    <div class="nav-tabs-custom">
      <ul style="font-weight: bold;" class="nav nav-tabs">
        <li id="menu_1" class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">DENUNCIAR</a></li>
        <li id="menu_2"><a href="#tab_2" data-toggle="tab" aria-expanded="false">REPORTES</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
          <div class="item-wrap">
            <form id="formBuscarDenuncias" data-toggle="validator" class="popup-form contactForm">
              <div class="row"> 
                <div class="col-md-3 col-sm-12 col-12">
                  <label for="">Aseguradora</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <select name="aseguradoraDenuncias" id="aseguradoraDenuncias" class="form-control">
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
                    <select name="tipoCasoDenuncias" id="tipoCasoDenuncias" class="form-control">
                      <option value="">TODOS</option>
                    </select>
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                  </div>
                </div>

                <div class="col-md-2 col-sm-12 col-12">
                  <label for="">FCH. LIMITE</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <input type="date" value="<?=date('Y-m-d')?>" min="<?=date('Y-m-d',strtotime(date('Y-m-d').'- 6 month'));?>" max="<?=date('Y-m-d')?>" name="fLimiteDenuncias" id="fLimiteDenuncias" class="form-control">
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                  </div>
                </div>

                <div class="col-md-1 col-sm-12 col-12">                            
                  <label for="">.</label>
                  <div class="form-group last">
                    <button type="submit" id="btnDenuncias" class="btn btn-custom"><i class="fa fa-search"></i> VER</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <table id="tablaCasosDenuncias" class="table table-striped display table table-hover" cellspacing="0" width="100%">
            <thead style="background-color: #217793; color: white;">
            </thead>
            <tbody>
            </tbody>            
          </table>
        </div>

        <div class="tab-pane" id="tab_2">
          <div class="item-wrap">
            <form id="formConsultaDenuncias" data-toggle="validator" class="popup-form contactForm">
              <div class="row"> 

                <div class="col-md-3 col-sm-12 col-12">
                  <label for="">Agrupar Por</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <select style="width:100%;" name="agruparDenuncias" id="agruparDenuncias" class="form-control">
                      <option value="1">INVESTIGACIÓN (Por Defecto)</option>
                      <option value="2">INDICADOR FRAUDE</option>
                      <option value="3">IPS</option>
                      <option value="4">DEPARTAMENTO</option>
                      <!---<option value="5">MES</option>-->
                    </select>
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                  </div>
                </div>
                
                <div class="col-md-3 col-sm-12 col-12">
                  <label for="">Aseguradora</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <select style="width:100%;" name="aseguradoraRepDenuncias" id="aseguradoraRepDenuncias" class="form-control">
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
                  <label for="">Departamento</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <select style="width:100%;" name="dptoDenuncias" id="dptoDenuncias" class="form-control">
                      <option value="">TODOS</option>
                      <?php 
                      mysqli_next_result($con);
                      $verAmparo =mysqli_query($con,"SELECT id, nombre FROM departamentos;");
                      while($resul = mysqli_fetch_assoc($verAmparo)){ ?>
                        <option value="<?=$resul['id']; ?>"><?=$resul['nombre']; ?></option>
                        <?php 
                      } ?>
                    </select>
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                  </div>
                </div>

                <div class="col-md-3 col-sm-12 col-12">
                  <label for="">IPS</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <select style="width:100%;" name="ipsDenuncias" id="ipsDenuncias" class="form-control">
                      <option value="">TODOS</option>
                      <?php 
                      mysqli_next_result($con);
                      $verAmparo =mysqli_query($con,"SELECT id, nombre_ips FROM ips;");
                      while($resul = mysqli_fetch_assoc($verAmparo)){ ?>
                        <option value="<?=$resul['id']; ?>"><?=$resul['nombre_ips']; ?></option>
                        <?php 
                      } ?>
                    </select>
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                  </div>
                </div>

                <div class="col-md-3 col-sm-12 col-12">
                  <label for="">Indicador</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <select name="indicadorDenuncias" id="indicadorDenuncias" class="form-control">
                      <option value="">TODOS</option>
                      <?php 
                      mysqli_next_result($con);
                      $verAmparo =mysqli_query($con,"SELECT id, descripcion FROM definicion_tipos a WHERE a.id IN (3,23) AND a.id_tipo = 12;");
                      while($resul = mysqli_fetch_assoc($verAmparo)){ ?>
                        <option value="<?=$resul['id']; ?>"><?=$resul['descripcion']; ?></option>
                        <?php 
                      } ?>
                    </select>
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                  </div>
                </div>

                <div class="col-md-2 col-sm-12 col-12">
                  <label for="">Fecha Inicio</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <input type="date" value="<?=date('Y-m-d',strtotime(date('Y-m-d').'- 1 month'));?>" min="2021-05-01" max="<?=date('Y-m-d')?>" name="fechaInicioDenuncias" id="fechaInicioDenuncias" class="form-control"/>
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                  </div>
                </div>

                <div class="col-md-2 col-sm-12 col-12">
                  <label for="">Fecha Fin</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <input type="date" value="<?=date('Y-m-d')?>" min="2021-05-01" max="<?=date('Y-m-d')?>" name="fechaFinDenuncias" id="fechaFinDenuncias" class="form-control"/>
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                  </div>
                </div>

                <div class="col-md-1 col-sm-12 col-12">                            
                  <label for="">.</label>
                  <div class="form-group last">
                    <button type="submit" id="btnDenuncias" class="btn btn-custom"><i class="fa fa-search"></i> VER</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <table id="tablaDenunciasRealizadas" class="table table-striped display table table-hover" cellspacing="0" width="100%">
            <thead style="background-color: #217793; color: white;">
            </thead>
            <tbody>
            </tbody>            
          </table>
        </div>        
      </div>
    </div>
  </div>
</div>


<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalDenunciar" role="dialog" >
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" id="frmDenunciar">
        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Denunciar Investigación</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="col-md-12">
                <strong>Codigó</strong>
                <div class="form-group">
                  <p id="codigoDenuncia"></p>
                </div>
              </div>

              <div class="col-md-12">
                <strong>Nombre Lesionado</strong>
                <div class="form-group">
                  <p id="lesionadoDenuncia"></p>
                </div>
              </div>

              <div class="col-md-6">
                <strong>Indicador Fraude</strong>
                <div class="form-group">
                  <p id="indicadorDenuncia"></p>
                </div>
              </div>

              <div class="col-md-6">
                <strong>Fecha Denuncia</strong>
                <div class="form-group">
                  <input type="date" name="fechaDenuncia" id="fechaDenuncia" class="form-control">
                </div>
              </div>

              <div  class="col-md-12">
                <strong>Observación</strong>
                <div  class="form-group">
                  <textarea class="form-control" rows="3" name="observacion" id="observacion"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input id="idInvestigacionDenuncia" type="hidden">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
          <button class="btn btn-primary" type="submit">Denunciar</button>
        </div>
      </div>
    </form>
  </div>
</div>