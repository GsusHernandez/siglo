<div class="box-body">
  <form role="form" id="frmDiligenciaFormato"> 
    <div class="row">
      <div class="form-group col-sm-6">
        <label>Fecha de Diligenciamiento</label>
        <input class="form-control formFechas" readonly="readonly" id="fechaDiligenciaFormatoFrm">
      </div>
      <div class="form-group col-sm-6">
        <label for="">Diligencia Formato Declacion:</label>
        <select  id="personaDiligenciaFormatoFrm" style="width: 100%;" class="form-control select2" >
          <option value="0">SELECCIONE UN VALOR</option>
          <?php 
          mysqli_next_result($con);
          $consultarPersonasDiligenciaFormato="CALL consultasBasicas(25)";
          $queryPersonaDiligenciaFormato=mysqli_query($con,$consultarPersonasDiligenciaFormato);
          while($resul = mysqli_fetch_assoc($queryPersonaDiligenciaFormato)){?>
            <option value="<?php echo $resul['id']; ?>">
              <?php echo $resul['descripcion']; ?>               
            </option>
            <?php 
          }?>
        </select>
      </div> 
    </div>
    <div id="divAcompananteDiligenciaInvestigacion" style="display:none;">
      <form id="formDiligenciaFormatoInvestigacion">
        <form role="form" id="frmPersonas">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Nombre</label>
                <input type="text" class="form-control CampText" id="nombreAcompananteDiligenciFormatoFrm" placeholder="Nombre">
              </div>
            </div>
            <div class="col-md-6 form-group">
              <label>Tipo Identificacion</label>
              <select id="tipoIdentificacionAcompananteDiligenciFormatoFrm" style="width: 100%;" class="form-control select2" >
                <option value="0">SELECCIONE UN VALOR</option>
                <?php 
                mysqli_next_result($con);
                $consultarTipoIdentificacion="CALL consultasBasicas(8)";
                $verTipoIdentificacion=mysqli_query($con,$consultarTipoIdentificacion);
                while($resul = mysqli_fetch_assoc($verTipoIdentificacion)){?>
                  <option value="<?php echo $resul['id']; ?>">
                    <?php echo $resul['descripcion']; ?>               
                  </option>
                  <?php 
                }?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Identificacion</label>
                <input type="text" class="form-control CampText" id="identificacionAcompananteDiligenciFormatoFrm" placeholder="Identificacion">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Telefono</label>
                <input type="text" class="form-control CampText" id="telefonoAcompananteDiligenciFormatoFrm" placeholder="Telefono">
              </div>
            </div>
          </div>  
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Direccion</label>
                <input type="text" class="form-control CampText" id="direccionAcompananteDiligenciFormatoFrm" placeholder="Direccion">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Relacion</label>
                <input type="text" class="form-control CampText" id="relacionAcompananteDiligenciFormatoFrm" placeholder="Relacion">
              </div>
            </div>
          </div>
        </form>
      </form>
    </div>    
    <div id="divObservacionDiligenciaInvestigacion" style="display:none;">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Observacion</label>
            <textarea class="form-control" rows="2" id="observacionDiligenciaFormato"></textarea>
          </div>
        </div>
      </div>            
    </div>
    <div id="divLesionadosInvestigacion" style="display:none;">
      <div id="DivTablas26">
        <table id="tablaGestionLesionadosDiligencia" class="display" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th style="width:350px;" width="350px">Nombre</th>
              <th style="width:350px;" width="350px">Identificacion</th>
              <th style="width:350px;" width="350px">Opciones</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
    <div style="display:none;" id="divBtnDiligenciaFormato">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <a class="btn  btn-primary" id="btnGuardarDiligenciaFormato">Guardar</a>
          </div>
        </div>
      </div>
    </div>
    <input type="hidden" id="idInvestigacionFrmDiligencia">
  </div>
</form>