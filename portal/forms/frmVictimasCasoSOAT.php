<form role="form" id="FrmVictimaCasoSOAT">
  <div class="box-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <input type="text" class="form-control" id="identificacionVictimaFrm" placeholder="Identificacion Victima">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <input type="text" name="0" readonly="" class="form-control" id="descripcionVictimaFrm" placeholder="NO HA SELECCIONADO VICTIMA">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Fecha de Ingreso</label>
          <input type="text" readonly="readonly" class="form-control formFechas" id="fechaIngresoVictimaFrm" placeholder="Fecha de Ingreso">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Fecha de Egreso</label>
          <input type="text" readonly="readonly" class="form-control formFechas" id="fechaEgresoVictimaFrm" placeholder="Fecha de Egreso">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>IPS</label>
          <select id="ipsVictimaFrm" style="width: 100%;" class="form-control select2" >
            <option value="0">SELECCIONE UN VALOR</option>
            <?php 
            mysqli_next_result($con);
            $consultarClinica="CALL consultasBasicas(7)";
            $verClinica=mysqli_query($con,$consultarClinica);
            while($resul2 = mysqli_fetch_assoc($verClinica)){?>
              <option value="<?php echo $resul2['id']; ?>">
                <?php echo $resul2['ips']; ?>               
              </option>
              <?php 
            }
            ?>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Condicion</label>
          <input type="text" class="form-control CampText" id="condicionVictimaFrm" placeholder="Condicion">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <div class="form-group">
          <label>Resultado:</label>
          <select id="resultadoVictimaFrm" class="form-control select2" style="width: 100%;">
          </select>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group">
          <label>Indicador Fraude:</label>
          <select id="indicadorFraudeVictimaFrm" class="form-control select2" style="width: 100%;">
          </select>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-group">
          <label>Observaciones:</label>
          <textarea class="form-control" rows="3" id="observacionesVictimaFrm"></textarea>
        </div>
      </div>
    </div>
    <input type="hidden" id="idRegistroInvestigacionVictimaSOAT">                         
    <input type="hidden" id="idPersonaVictima">                         
    <input type="hidden" id="exeVictima">   
  </div>
</form>