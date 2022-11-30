<form role="form" id="frmPolizas">
  <div class="box-body">
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>Numero</label>
          <input type="text" class="form-control CamNum" id="numeroPolizaFRM" placeholder="Numero">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Digito Verificacion</label>
          <input type="text" class="form-control CamNum" id="digVerPolizaFrm" placeholder="Digito Verificacion">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Inicio Vigencia</label>
          <input readonly="readonly" class="form-control formFechas" id="vigenciaPolizaFrm" placeholder="Inicio Vigencia">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 form-group">
        <label>Tipo Identificacion Tomador</label>
        <select id="tipoIdentificacionTomadorPolizaFrm" style="width: 100%;" class="form-control select2" >
          <option value="0">SELECCIONE UN VALOR</option>
          <?php 
          mysqli_next_result($con);
          $consultarTipoIdentificacion="CALL consultasBasicas(8)";
          $verTipoIdentificacion=mysqli_query($con,$consultarTipoIdentificacion);
          while($resul = mysqli_fetch_assoc($verTipoIdentificacion)){
            ?>
            <option value="<?php echo $resul['id']; ?>">
              <?php echo $resul['descripcion']; ?>               
            </option>
            <?php 
          }
          ?>
        </select>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Identificacion Tomador</label>
          <input type="text" class="form-control CampText" id="identificacionTomadorPolizaFrm" placeholder="Identificacion Tomador">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Nombre Tomador </label>
          <input type="text" class="form-control CampText" id="nombreTomadorPolizaFrm" placeholder="Nombre Tomador">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Direccion Tomador</label>
          <input type="text" class="form-control CampText" id="direccionTomadorPolizaFrm" placeholder="Direccion Tomador">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Telefono Tomador</label>
          <input type="text" class="form-control CampText" id="telefonoTomadorPolizaFrm" placeholder="Telefono Tomador">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Ciudad Tomador</label>
          <select id="ciudadTomadorPolizaFrm" style="width: 100%;" class="form-control select2" >
            <option value="0">SELECCIONE UN VALOR</option>
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
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Ciudad Expedicion</label>
          <select id="ciudadExpedicionPolizaFrm" style="width: 100%;" class="form-control select2" >
            <option value="0">SELECCIONE UN VALOR</option>
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
      <div class="col-md-6">
        <div class="form-group">
          <label>Codigo Sucursal</label>
          <input type="text" class="form-control CampText" id="codSucursalPolizaFrm" placeholder="Codigo Sucursal">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="form-group col-sm-6">
        <label for="">Aseguradora:</label>
        <select id="aseguradoraPolizaFrm" class="form-control select2" style="width: 100%;">
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
      <div class="col-md-6">
        <div class="form-group">
          <label>Clave Productor</label>
          <input type="text" class="form-control CampText" id="claveProductorPolizaFrm" placeholder="Clave Productor">
        </div>
      </div>
    </div>
    <input type="hidden" id="exeFrmPolizas">
    <input type="hidden" id="idPolizas">
  </div>
</form>