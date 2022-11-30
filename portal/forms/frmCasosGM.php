<form role="form" id="frmCasosGM">
  <div class="box-body">
    <div class="row">
      <div class="form-group col-sm-6">
        <label for="">Aseguradora:</label>
        <select id="aseguradoraFrmCasosGM" class="form-control select2" style="width: 100%;">
          <option value="0">SELECCIONE UN VALOR</option>
          <?php 
          mysqli_next_result($con);
          $verAmparo =mysqli_query($con,"CALL manejoAseguradoras(6,'','','','','','','','','','','','',@resp)");
          while($resul = mysqli_fetch_assoc($verAmparo)){ ?>
            <option value="<?= $resul['id'];?>"><?=$resul['nombre_aseguradora']; ?></option>
            <?php 
          } ?>
        </select>
      </div>

      <div class="form-group col-sm-6">
        <label for="">Tipo de Caso</label>
        <select id="tipoCasoFrmCasosGM" class="form-control select2" style="width: 100%;">  
        </select>
      </div>
    </div>

    <div class="row">
      <div class="form-group col-sm-6">
        <label for="tipoAuditoriaFrmCasosGM">Tipo de Auditoria</label>
        <select id="tipoAuditoriaFrmCasosGM" style="width: 100%;" class="form-control">
          <option value="0">SELECCIONE</option>
          <option value="1">DECLARACIÓN</option>
          <option value="2">TELÉFONICA</option>
        </select>
      </div>

      <div class="form-group col-sm-6">
        <label>Fecha de Accidente</label>
        <input readonly="readonly" class="form-control formFechasHora"  id="fechaAccidenteFrmCasosGM">
      </div>
    </div>

    <div class="row">
      <div class="form-group col-sm-6">
        <label>Lugar del Accidente</label>
        <input id="lugarAccidenteFrmCasosGM" class="form-control CampText" type="text">
      </div>

      <div class="form-group col-sm-6">
        <label for="">Municipio:</label>
        <select id="ciudadFrmCasosGM" style="width: 100%;" class="form-control select2" >
          <option value="0">SELECCIONE UNA OPCION</option>
          <?php 
          mysqli_next_result($con);
          $consultarCiudad="CALL consultasBasicas(1)";
          $verCiudad=mysqli_query($con,$consultarCiudad);
          while($resul = mysqli_fetch_assoc($verCiudad)){ ?>
            <option value="<?php echo $resul['id']; ?>">
              <?php echo $resul['ciudad']; ?>                                               
            </option>
            <?php 
          } ?>
        </select>
      </div>
    </div>

    <div class="row">
      <div class="form-group col-sm-6">
        <label for="">Tipo de Zona</label>
        <select id="tipoZonaFrmCasosGM" style="width: 100%;" class="form-control select2" >
          <option value="0">SELECCIONE UNA OPCION</option>
          <?php 
          mysqli_next_result($con);
          $consultarTipoZona="CALL consultasBasicas(11)";
          $verTipoZona=mysqli_query($con,$consultarTipoZona);

          while($resul = mysqli_fetch_assoc($verTipoZona)){ ?>
            <option value="<?php echo $resul['id']; ?>">
              <?php echo $resul['descripcion']; ?>                                               
            </option>
            <?php
          } ?>
        </select>
      </div>

      <div class="form-group col-sm-6">
        <label>Barrio del Accidente</label>
        <input id="barrioAccidenteFrmCasosGM" class="form-control CampText" type="text">
      </div>

      <div class="form-group col-sm-6" style="display: none;" id="divFechaConocimientoFrmCasosGM">
        <label>Fecha de Conocimiento:</label>
        <input class="form-control"  id="fechaConocimientoFrmCasosGM" type="date">
      </div>

      <div class="form-group col-sm-6">
        <label>Días Investigador</label>
        <input id="diasDeInvestigadorFrmCasosGM" class="form-control CampText" type="number">
      </div>

      <div class="col-sm-6" id="divInvestigadorFrmCasosGM">
        <div class="form-group">
          <label>Investigador:</label>
          <select id="investigadorFrmCasosGM" style="width: 100%;" class="form-control select2" >
            <option value="0">SELECCIONE UNA OPCION</option>
            <?php 
            mysqli_next_result($con);
            $consultarInvestigador="CALL consultasBasicas(9)";
            $verInvestigador=mysqli_query($con,$consultarInvestigador);
            while($resul = mysqli_fetch_assoc($verInvestigador)){ ?>
              <option value="<?php echo $resul['id']; ?>">
                <?php echo $resul['nombre_investigador']. " (".$resul['id'].")"; ?>                                               
              </option>
              <?php 
            } ?>
          </select>
        </div>
      </div>
    </div>

    <div>
      <div class="box box-solid box-primary" style="border: 1px solid #38536b !important;">
        <div class="box-header with-border" style="background-color: #38536b !important;">
          <h3 class="box-title">Agregar Indicador</h3>
        </div>
        <div class="box-body">
          <div class="form-group col-sm-3">
            <label>Indicador</label>
            <input id="indicativoAseguradoraFrmCasosGM" class="form-control CampText" type="text">
          </div>

          <div class="col-sm-3">
            <div class="form-group">
              <label>Fecha Asign:</label>
              <input readonly="readonly" class="form-control formFechas"  id="fechaAsignacionFrmCasosGM">
            </div>
          </div>

          <div class="col-sm-3">
            <div class="form-group">
              <label>Fecha Entrega:</label>
              <input readonly="readonly" class="form-control formFechas"  id="fechaEntregaFrmCasosGM">
            </div>
          </div>

          <div class="col-sm-3">
            <div class="form-group">
              <label>&nbsp;</label>
              <a class="btn btn-block btn-primary" style="background-color: #38536b;" id="BtnAddIndicativosAseguradora">Agregar</a>
            </div>
          </div>

          <div id="DivTablas13">
            <table id="tablaIndicativosAseguradoraFrmCasosGM" class="display" cellspacing="0" width="100%">
              <thead  style="background: #38536b;  color: #fff;">
                <tr>
                  <th>Indicativo</th>
                  <th>Fecha Inicio</th>
                  <th>Fecha Entrega</th>
                  <th>Opciones</th>
                </tr>
              </thead>
            </table>
          </div>
          <input type="hidden" id="idCasoFrmCasosGM">
          <input type="hidden" id="exeFrmCasosGM">
        </div>
      </div>
    </div>
  </div>
</form> 