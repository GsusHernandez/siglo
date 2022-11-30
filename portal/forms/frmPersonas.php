<form role="form" id="frmPersonas">
  <div class="box-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Nombres</label>
          <input type="text" class="form-control CampText" id="nombresPersonasFrm" placeholder="Nombres">
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label>Apellidos</label>
          <input type="text" class="form-control CampText" id="apellidosPersonasFrm" placeholder="Apellidos">
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-6 form-group">
        <label>Tipo Identificacion</label>
        <select id="tipoIdentificacionPersonasFrm" style="width: 100%;" class="form-control select2" >
          <option value="0">SELECCIONE UN VALOR</option>
          <?php 
          mysqli_next_result($con);
          $consultarTipoIdentificacion="CALL consultasBasicas(8)";
          $verTipoIdentificacion=mysqli_query($con,$consultarTipoIdentificacion);
          while($resul = mysqli_fetch_assoc($verTipoIdentificacion)){?>
            <option value="<?php echo $resul['id']; ?>">
              <?php echo $resul['descripcion']; ?>               
            </option>
          <?php }?>
        </select>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Identificacion</label>
          <input type="text" class="form-control CampTextNum" id="identificacionPersonasFrm" placeholder="Identificacion">
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>Sexo</label>
          <select id="sexoPersonasFrm" style="width: 100%;" class="form-control select2" >
            <option value="0">SELECCIONE UN VALOR</option>
            <?php 
            mysqli_next_result($con);
            $consultarSexo="CALL consultasBasicas(20)";
            $verSexo=mysqli_query($con,$consultarSexo);
            while($resul = mysqli_fetch_assoc($verSexo)){ ?>
              <option value="<?php echo $resul['id']; ?>">
                <?php echo $resul['descripcion']; ?>               
              </option>

            <?php }  ?>
          </select>
        </div>
      </div>

      <div class="col-md-4">
        <div class="form-group">
          <label>Edad</label>
          <input type="text" class="form-control CamNum" id="edadPersonasFrm" placeholder="Edad">
        </div>
      </div>

      <div class="col-md-4">
        <div class="form-group">
          <label>Ocupacion</label>
          <input type="text" class="form-control CampText" id="ocupacionPersonasFrm" placeholder="Ocupacion">
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Telefono</label>
          <input type="text" class="form-control CampText" id="telefonoPersonasFrm" placeholder="Telefono">
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label>Direccion</label>
          <input type="text" class="form-control CampText" id="direccionPersonasFrm" placeholder="Direccion">
        </div>
      </div>
    </div>


    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Barrio</label>
          <input type="text" class="form-control CampText" id="barrioPersonasFrm" placeholder="Barrio">
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label>Ciudad</label>
          <select id="ciudadPersonasFrm" style="width: 100%;" class="form-control select2" >
            <option value="0">SELECCIONE UN VALOR</option>
            <?php 
            mysqli_next_result($con);
            $consultarCiudad="CALL consultasBasicas(1)";
            $verCiudad=mysqli_query($con,$consultarCiudad);
            while($resul = mysqli_fetch_assoc($verCiudad)){ ?>
              <option value="<?php echo $resul['id']; ?>">
                <?php echo $resul['ciudad']; ?>               
              </option>
            <?php } ?>
          </select>
        </div>
      </div>
    </div>
    <input type="hidden" id="exeFrmPersonas">
    <input type="hidden" id="frmEnvia">
    <input type="hidden" id="idPersonas">
  </div>
</form>