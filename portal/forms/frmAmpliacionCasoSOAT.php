<form role="form" id="frmAmpliarInvestigacion">
  <div class="box-body">
    <div class="row" >
      <div class="form-group col-sm-4">
        <label for="">Identificador</label>
        <input type="text" class="form-control" id="identificadorFrmAmpliarInvestigacion" placeholder="Identificador">
      </div>
      <div class="form-group col-sm-4">
        <label for="">Fecha de Inicio</label>
        <input type="text" class="form-control formFechas" id="fechaInicioFrmAmpliarInvestigacion" readonly="readonly" placeholder="Fecha de Entrega">
      </div>
      <div class="form-group col-sm-4">
        <label for="">Fecha de Entrega</label>
        <input type="text" class="form-control formFechas" id="fechaEntregaFrmAmpliarInvestigacion" readonly="readonly" placeholder="Fecha de Entrega">
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <div class="form-group">
          <label>Investigador:</label>
          <select id="investigadorFrmAmpliarInvestigacion" style="width: 100%;" class="form-control select2" >
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
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label>Motivo Investigacion</label>
          <textarea placeholder="Motivo Investigacion" class="form-control" rows="3" id="motivoInvestigacionFrmAmpliarInvestigacion"></textarea>
        </div>
      </div>
    </div>
    <input type="hidden" id="idCasoFrmAmpliarInvestigacion">
  </div>
</form>