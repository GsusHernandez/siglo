<form role="form" id="frmCasosValidaciones">
  <div class="box-body">
    <div class="row">
      <div class="form-group col-sm-6">
        <label for="">Aseguradora:</label>
        <select id="aseguradoraFrmCasosValidaciones" class="form-control select2" style="width: 100%;">
          <option value="0">SELECCIONE UN VALOR</option>
          <?php 
          mysqli_next_result($con);
          $verAmparo =mysqli_query($con,"CALL manejoAseguradoras(6,'','','','','','','','','','','','',@resp)");
          while($resul = mysqli_fetch_assoc($verAmparo)){
            ?>
            <option value="<?php echo $resul['id']; ?>">
              <?php echo $resul['nombre_aseguradora']; ?>               
            </option>
            <?php 
          }
          ?>
        </select>
      </div>
      <div class="form-group col-sm-6">
        <label for="">Municipio:</label>
        <select id="ciudadEntidadFrmCasosValidaciones" style="width: 100%;" class="form-control select2" >
          <option value="0">SELECCIONE UNA OPCION</option>
          <?php 
          mysqli_next_result($con);
          $consultarCiudad="CALL consultasBasicas(1)";
          $verCiudad=mysqli_query($con,$consultarCiudad);
          while($resul = mysqli_fetch_assoc($verCiudad)){
            ?>
            <option value="<?php echo $resul['id']; ?>">
              <?php echo $resul['ciudad']; ?>                                               
            </option>
            <?php 
          }
          ?>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="form-group col-sm-4">
        <label>Nombre Entidad</label>
        <input id="nombreEntidadFrmCasosValidaciones" class="form-control CampText" type="text">
      </div>  
      <div class="form-group col-sm-4">
        <label>Identificacion</label>
        <input id="identificacionEntidadFrmCasosValidaciones" class="form-control CamNum" type="text">
      </div>
      <div class="form-group col-sm-4">
        <label>Digito Verificacion</label>
        <input id="digVerEntidadFrmCasosValidaciones" class="form-control CamNum" type="text">
      </div>
    </div>
    <div class="row">
    </div>
    <div class="row">
      <div class="col-sm-4">
        <div class="form-group">
          <label>Fecha Matricula:</label>
          <input class="form-control formFechas" readonly="readonly" id="fechaMatriculaFrmCasosValidaciones">
        </div>
      </div>
      <div class="form-group col-sm-4">
        <label>Direccion</label>
        <input id="direccionEntidadFrmCasosValidaciones" class="form-control CampText" type="text">
      </div>
      <div class="form-group col-sm-4">
        <label>Telefono</label>
        <input id="telefonoEntidadFrmCasosValidaciones" class="form-control CampText" type="text">
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <div class="form-group">
          <label>Investigador:</label>
          <select id="investigadorFrmCasosValidaciones" style="width: 100%;" class="form-control select2" >
            <option value="0">SELECCIONE UNA OPCION</option>
            <?php 
            mysqli_next_result($con);
            $consultarInvestigador="CALL consultasBasicas(9)";
            $verInvestigador=mysqli_query($con,$consultarInvestigador);
            while($resul = mysqli_fetch_assoc($verInvestigador)){
              ?>
              <option value="<?php echo $resul['id']; ?>">
                <?php echo $resul['nombre_investigador']; ?>                                               
              </option>
              <?php 
            }
            ?>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Actividad Economica</label>
          <textarea class="form-control" rows="3" id="actividadEconomicaFrmCasosValidaciones"></textarea>
        </div>
      </div>
    </div>
    <div class="row">
    </div>

    <div>
      <div class="box box-solid box-primary" style="border: 1px solid #38536b !important;">
        <div class="box-header with-border" style="background-color: #38536b !important;">
          <h3 class="box-title">Agregar Indicador</h3>
        </div>
        <div class="box-body">
          <div class="form-group col-sm-3">
            <label>Indicador</label>
            <input id="indicativoAseguradoraFrmCasosValidaciones" class="form-control CampText" type="text">
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <label>Fecha Asign:</label>
              <input class="form-control formFechas" readonly="readonly" id="fechaAsignacionFrmCasosValidaciones">
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <label>Fecha Entrega:</label>
              <input class="form-control formFechas" readonly="readonly" id="fechaEntregaFrmCasosValidaciones">
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <label>&nbsp;</label>
              <a class="btn btn-block btn-primary"  id="BtnAddIndicativosAseguradoraValidaciones" style="background-color: #38536b;">Agregar</a>
            </div>
          </div>

          <div id="DivTablas22">
            <table id="tablaIndicativosAseguradoraFrmCasosValidaciones" class="display" cellspacing="0" width="100%">
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
          <input type="hidden" id="idCasoFrmCasosValidaciones">
          <input type="hidden" id="exeFrmCasosValidaciones">
        </div>
      </div>
    </div>
  </div>
</form>