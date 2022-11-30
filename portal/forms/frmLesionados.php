<form role="form" id="FrmLesionadoCasoSOAT">
  <div class="box-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <input type="text" class="form-control CampTextNum" id="identificacionLesionadoFrm" placeholder="Identificacion Lesionado">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <input type="text" name="0" readonly="" class="form-control" id="descripcionLesionadoFrm" placeholder="NO HA SELECCIONADO NINGUN LESIONADO">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>Fecha de Ingreso</label>
          <input readonly="readonly" type="text" class="form-control formFechasHora" id="fechaIngresoLesionadoFrm" placeholder="Fecha de Ingreso">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Fecha de Egreso</label>
          <input readonly="readonly" type="text" class="form-control formFechasHora" id="fechaEgresoLesionadoFrm" placeholder="Fecha de Egreso">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>IPS</label>
          <select id="ipsLesionadoFrm" style="width: 100%;" class="form-control select2" >
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
            }?>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>Condicion</label>
          <select id="condicionLesionadoFrm" style="width: 100%;" class="form-control select2" >
            <option value="0">SELECCIONE UN VALOR</option>
            <?php 
            mysqli_next_result($con);
            $consultarCondicion="SELECT nombre_condicion from persona_condicion";
            $verCondicion=mysqli_query($con,$consultarCondicion);
            while($resul2 = mysqli_fetch_assoc($verCondicion)){?>
              <option text="<?php echo $resul2['nombre_condicion']; ?>">
                <?php echo $resul2['nombre_condicion']; ?>               
              </option>
              <?php 
            }?>
          </select>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="form-group">
          <label>Resultado:</label>
          <select id="resultadoLesionadoFrm" class="form-control select2" style="width: 100%;"> 
          </select>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="form-group">
          <label>Indicador Fraude:</label>
          <select id="indicadorFraudeLesionadoFrm" class="form-control select2" style="width: 100%;">
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>Servicio de Ambulancia</label>
          <select id="servicioAmbulanciaLesionadoFrm" style="width: 100%;" class="form-control select2" >
            <option value="0">SELECCIONE UN VALOR</option>
            <option value="s">SI</option>
            <option value="n">NO</option>
          </select>
        </div>
      </div>
      <div class="col-md-4" id="divTipoServicioAmbulancia" style="display:none;">
        <div class="form-group">
          <div>
            <label>Tipo Servicio Ambulancia</label>
            <select id="tipoServicioAmbulanciaLesionadoFrm" style="width: 100%;" class="form-control select2" >
              <option value="0">SELECCIONE UN VALOR</option>
              <?php 
              mysqli_next_result($con);
              $consultarTipoVehiculos="CALL consultasBasicas(15)";
              $verTipoVehiculos=mysqli_query($con,$consultarTipoVehiculos);
              while($resul = mysqli_fetch_assoc($verTipoVehiculos)){ 
                if($resul['id'] != 14){ ?>
                  <option value="<?=$resul['id']?>"><?=$resul['descripcion']?></option>
                <?php }
              } ?>
            </select>
          </div>
        </div>
      </div>
      <div class="col-md-4" id="divLugarTraslado" style="display:none;">
        <div class="form-group">
          <div>
            <label>Lugar de Traslado</label>
            <input type="text" class="form-control CampText" id="lugarTrasladoAmbulanciaLesionadoFrm" placeholder="Lugar de Traslado">
          </div>
        </div>
      </div>
      <div class="col-md-4" id="divTipoVehiculoTraslado" style="display:none;">
        <div class="form-group">
          <div >
            <label>Tipo Vehiculo Traslado</label>
            <select id="tipoVehiculoTrasladoLesionadoFrm" style="width: 100%;" class="form-control select2" >
              <option value="0">SELECCIONE UN VALOR</option>
              <?php 
              mysqli_next_result($con);
              $consultarTipoVehiculos="CALL consultasBasicas(14)";
              $verTipoVehiculos=mysqli_query($con,$consultarTipoVehiculos);
              while($resul = mysqli_fetch_assoc($verTipoVehiculos)){?>
                <option value="<?php echo $resul['id']; ?>">
                  <?php echo $resul['descripcion']; ?>               
                </option>
                <?php 
              }?>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>Remitido</label>
          <select id="remitidoLesionadoFrm" style="width: 100%;" class="form-control select2" >
            <option value="0">SELECCIONE UN VALOR</option>
            <?php 
            mysqli_next_result($con);
            $consultarRemitido="CALL consultasBasicas(24)";
            $verRemitido=mysqli_query($con,$consultarRemitido);
            while($resul = mysqli_fetch_assoc($verRemitido)){?>
              <option value="<?php echo $resul['id']; ?>">
                <?php echo $resul['descripcion']; ?>               
              </option>
              <?php 
            }?>
          </select>
        </div>
      </div>
      <div id="divIPSRemitido" style="display:none;">
        <div class="col-md-4">
          <div class="form-group">
            <label>IPS Remitido</label>
            <input type="text" id="ipsRemitidoLesionadoFrm" class="form-control" >
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label>Seguridad Social</label>
          <select id="seguridadSocialLesionadoFrm" style="width: 100%;" class="form-control select2" >
            <option value="0">SELECCIONE UN VALOR</option>
            <?php 
            mysqli_next_result($con);
            $consultarSeguridadSocial="CALL consultasBasicas(16)";
            $verTipoSeguridadSocial=mysqli_query($con,$consultarSeguridadSocial);
            while($resul = mysqli_fetch_assoc($verTipoSeguridadSocial)){?>
              <option value="<?php echo $resul['id']; ?>">
                <?php echo $resul['descripcion']; ?>               
              </option>
              <?php 
            }?>
          </select>
        </div>
      </div>
      <div id="divSiSeguridadSocial" style="display:none;">
        <div class="col-md-3">
          <div class="form-group">
            <label>EPS</label>
            <input type="text" class="form-control" id="epsLesionadoFrm" placeholder="EPS" maxlength="50">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Regimen</label>
            <select id="regimenLesionadoFrm" style="width: 100%;" class="form-control select2" >
              <option value="0">SELECCIONE UN VALOR</option>
              <?php 
              mysqli_next_result($con);
              $consultarRegimen="CALL consultasBasicas(17)";
              $verRegimen=mysqli_query($con,$consultarRegimen);
              while($resul = mysqli_fetch_assoc($verRegimen)){?>
                <option value="<?php echo $resul['id']; ?>">
                  <?php echo $resul['descripcion']; ?>               
                </option>
                <?php 
              }
              ?>
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Estado Seguridad Social</label>
            <select id="estadoSeguridadSocialLesionadoFrm" style="width: 100%;" class="form-control select2" >
              <option value="0">SELECCIONE UN VALOR</option>
              <?php 
              mysqli_next_result($con);
              $consultarEstadoSeguridadSocial="CALL consultasBasicas(18)";
              $verEstadoSeguridadSocial=mysqli_query($con,$consultarEstadoSeguridadSocial);
              while($resul = mysqli_fetch_assoc($verEstadoSeguridadSocial)){?>
                <option value="<?php echo $resul['id']; ?>">
                  <?php echo $resul['descripcion']; ?>               
                </option>
                <?php 
              }
              ?>
            </select>
          </div>
        </div>
      </div>
      <div id="divCausalNoConsulta" style="display:none;">
        <div class="col-md-4">
          <div class="form-group">
            <label>Causal No Consulta</label>
            <select id="causalNoConsultaSeguridadSocialLesionadoFrm" style="width: 100%;" class="form-control select2" >
              <option value="0">SELECCIONE UN VALOR</option>
              <?php 
              mysqli_next_result($con);
              $consultarCausalNoConsulta="CALL consultasBasicas(19)";
              $verCausalNoConsulta=mysqli_query($con,$consultarCausalNoConsulta);
              while($resul = mysqli_fetch_assoc($verCausalNoConsulta)){?>
                <option value="<?php echo $resul['id']; ?>">
                  <?php echo $resul['descripcion']; ?>               
                </option>
                <?php 
              }
              ?>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Lesiones</label>
          <textarea class="form-control deshabilitarCopiado" rows="3" id="lesionesLesionadoFrm"></textarea>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Tratamiento</label>
          <textarea class="form-control deshabilitarCopiado" rows="3" id="tratamientoLesionadoFrm"></textarea>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Relato</label>
          <textarea class="form-control deshabilitarCopiado" rows="3" id="relatoLesionadoFrm"></textarea>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Observaciones <span>(<span id="contObservacionesLesionadoFrm" style="color: darkred;">#</span> letras)</span></label>
          <textarea onkeyup="contarCaracterObserLesionado()" onkeydown="contarCaracterObserLesionado()" class="form-control deshabilitarCopiado" rows="3" id="observacionesLesionadoFrm"></textarea>
        </div>
      </div>
    </div>
  </div>
  <div class="box-footer">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <a  id="btnGuardarLesionadoSoat" class="btn btn-primary">Guardar</a>
          <input type="hidden" id="idRegistroInvestigacionLesionadoSOAT">                         
          <input type="hidden" id="idPersonaLesionado">                         
          <input type="hidden" id="exeLesionados">                         
        </div>
      </div>
    </div>
  </div>
</form>