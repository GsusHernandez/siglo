<form role="form" id="frmUsuarios">
  <div class="box-body">
    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputEmail1">Nombres</label>
        <input type="text" class="form-control CampText" id="nombresUsuarioFrm" placeholder="Nombres">
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputPassword1">Apellidos</label>
        <input type="text" class="form-control CampText" id="apellidoUsuarioFrm" placeholder="Apellidos">
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputPassword1">Usuario</label>
        <input type="text" class="form-control" id="userUsuarioFrm" placeholder="Usuario">
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputPassword1">Correo</label>
        <input type="text" class="form-control" id="correoUsuarioFrm" placeholder="Correo">
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputPassword1">Contraseña</label>
        <input type="password" class="form-control" id="contrasenaUsuarioFrm" placeholder="Contraseña">
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputPassword1">Confirmar Contraseña</label>
        <input type="password" class="form-control" id="contrasena2UsuarioFrm" placeholder="Confirmar Contraseña">
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputPassword1">Tipo Usuario</label>
        <select id="tipoUserUsuarioFrm" style="width: 100%;" class="form-control select2" >
          <option value="0">SELECCIONE UNA OPCION</option>
          <?php 
            $consultarTiposUsuarios="CALL consultasBasicas(12)";
            $verTiposUsuarios=mysqli_query($con,$consultarTiposUsuarios);
            while($resul = mysqli_fetch_assoc($verTiposUsuarios)){ ?>
              <option value="<?php echo $resul['id']; ?>">
                <?php echo $resul['descripcion']; ?>               
              </option>
          <?php } ?>
        </select>
      </div>
    </div>

    <div id="divAseguradoraUsuario" style="display: none;">
      <div class="col-md-6">
        <div class="form-group">
          <label for="exampleInputPassword1">Aseguradora</label>
          <select id="aseguradoraUsuarioFrm" style="width: 100%;" class="form-control select2" >
            <option value="0">SELECCIONE UNA OPCION</option>
            <?php 
              mysqli_next_result($con);
              $consultarAseguradoras="CALL consultasBasicas(10)";
              $verAseguradoras=mysqli_query($con,$consultarAseguradoras);
              while($resul = mysqli_fetch_assoc($verAseguradoras)){ ?>
                <option value="<?php echo $resul['id']; ?>">
                  <?php echo $resul['nombre_aseguradora']; ?>               
                </option>
            <?php } ?>
          </select>
        </div>
      </div>
    </div>

    <div id="divInvestigadorUsuario" style="display: none;">
      <div class="col-md-6">
        <div class="form-group">
          <label for="exampleInputPassword1">Investigador</label>
          <select id="investigadorUsuarioFrm" style="width: 100%;" class="form-control select2" >
            <option value="0">SELECCIONE UNA OPCION</option>
            <?php 
            mysqli_next_result($con);
            $consultarInvestigadores="CALL consultasBasicas(31)";
            $verInvestigadores=mysqli_query($con,$consultarInvestigadores);

            while($resul = mysqli_fetch_assoc($verInvestigadores)){ ?>
              <option value="<?=$resul['id']?>">
                <?=$resul['nombres']?> <?=$resul['apellidos']?> (<?=$resul['id']?>)
              </option>
            <?php } ?>
          </select>
        </div>
      </div>
    </div>
  </div><!-- /.box-body -->

  <div class="box-footer" style="display:none;">
    <div class="col-md-6">
      <div class="form-group">
        <input type="hidden" id="exeFrmUsuarios">
        <input type="hidden" id="idRegistroUsuario">
      </div>
    </div>
  </div>
</form>           