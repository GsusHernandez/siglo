<div class="box-body">
  <div class="row">
    <div class="form-group col-sm-6">
      <label>Placa</label>
      <input class="form-control CampTextNum" maxlength="7" id="placaVehiculoFrmVehiculoPoliza">
    </div>
    <form role="form" id="frmVehiculosSOAT">
      <div class="form-group col-sm-6">
        <label for="">Tipo Vehiculo:</label>
        <select  id="tipoVehiculoFrmVehiculoPoliza" style="width: 100%;" class="form-control select2 campFrmVehiculo" >
          <option value="0">SELECCIONE UN VALOR</option>
          <?php 
          mysqli_next_result($con);
          $consultarTipoVehiculos="CALL consultasBasicas(14)";
          $verTipoVehiculos=mysqli_query($con,$consultarTipoVehiculos);
          while($resul = mysqli_fetch_assoc($verTipoVehiculos)){ ?>
            <option value="<?php echo $resul['id']; ?>">
              <?php echo $resul['descripcion']; ?>               
            </option>
          <?php } ?>
        </select>
      </div>       
    </div>

    <div class="row">
      <div class="form-group col-sm-6">
        <label>Marca</label>
        <input  class="form-control CampText campFrmVehiculo"  id="marcaVehiculoFrmVehiculoPoliza">
      </div>

      <div class="form-group col-sm-6">
        <label>Modelo</label>
        <input  class="form-control CampTextNum campFrmVehiculo" maxlength="4"  id="modeloVehiculoFrmVehiculoPoliza">
      </div>     
    </div>

    <div class="row">
      <div class="form-group col-sm-6">
        <label>Linea</label>
        <input  class="form-control CampText campFrmVehiculo"  id="lineaVehiculoFrmVehiculoPoliza">
      </div>

      <div class="form-group col-sm-6">
        <label>Color</label>
        <input  class="form-control CampText campFrmVehiculo"  id="colorVehiculoFrmVehiculoPoliza">
      </div>     
    </div>

    <div class="row">
      <div class="form-group col-sm-6">
        <label>Numero VIN</label>
        <input  class="form-control CampTextNum campFrmVehiculo" id="numVinVehiculoFrmVehiculoPoliza">
      </div>
      <div class="form-group col-sm-6">
        <label>Numero Serie</label>
        <input  class="form-control CampTextNum campFrmVehiculo" id="numSerieVehiculoFrmVehiculoPoliza">
      </div>     
    </div>

    <div class="row">
      <div class="form-group col-sm-6">
        <label>Numero Chasis</label>
        <input  class="form-control CampTextNum campFrmVehiculo" id="numChasisVehiculoFrmVehiculoPoliza">
      </div>
      <div class="form-group col-sm-6">
        <label>Numero Motor</label>
        <input  class="form-control CampTextNum campFrmVehiculo" id="numMotorVehiculoFrmVehiculoPoliza">
      </div>     
    </div>

    <div class="row">
      <div class="form-group col-sm-6">
        <label for="">Tipo de Servicio:</label>
        <select  id="tipoServicioVehiculoFrmVehiculoPoliza" style="width: 100%;" class="form-control select2 campFrmVehiculo" >
          <option value="0">SELECCIONE UN VALOR</option>
          <?php 
          mysqli_next_result($con);
          $consultarTipoServicio="CALL consultasBasicas(21)";
          $verTipoServicio=mysqli_query($con,$consultarTipoServicio);
          while($resul = mysqli_fetch_assoc($verTipoServicio)){ ?>
            <option value="<?php echo $resul['id']; ?>">
              <?php echo $resul['descripcion']; ?>               
            </option>
          <?php } ?>
        </select>
      </div>   
      <div class="col-sm-3">
        <div class="form-group">
          <label>&nbsp;</label>
          <a  class="btn btn-block btn-primary campFrmVehiculo"  id="BtnAddVehiculoCasoFrm">Guardar</a>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="form-group">
          <label>&nbsp;</label>
          <a  class="btn btn-block btn-primary campFrmVehiculo"  id="BtnAddPolizaVehiculoCasoFrm">Add Poliza</a>
        </div>
      </div>
    </div>

    <div id="DivTablas19">
      <table id="tablaPolizasVehiculosFrmVehiculos" class="display" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Poliza</th>
            <th>Compañia</th>
            <th>Opciones</th>
          </tr>
        </thead>
      </table>
    </div>
    <input type="hidden" id="idVehiculoFrmVehiculos">
    <input type="hidden" id="idInvestigacionFrmVehiculos">
    <input type="hidden" id="exeFrmVehiculos">
  </div>
</form>