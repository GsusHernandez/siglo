<form role="form" id="frmInvestigadores">
  <div class="box-body">
    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputEmail1">Nombres</label>
        <input type="text" class="form-control CampText" id="nombresInvestigadoresFrm" placeholder="Nombres">
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputPassword1">Apellidos</label>
        <input type="text" class="form-control CampText" id="apellidoInvestigadoresFrm" placeholder="Apellidos">
      </div>
    </div>

    <div class="col-sm-6 form-group">
      <label>Tipo Identificacion</label>
			<select id="tipoIdentificacionInvestigadoresFrm" style="width: 100%;" class="form-control select2" >
		    <?php 
				$consultarTipoIdentificacion="CALL consultasBasicas(8)";
				$verTipoIdentificacion=mysqli_query($con,$consultarTipoIdentificacion);

        while($resul = mysqli_fetch_assoc($verTipoIdentificacion)){ ?>
					<option value="<?php echo $resul['id']; ?>">
						<?php echo $resul['descripcion2']; ?>
					</option>
				<?php } ?>
			</select>
		</div>

    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputPassword1">Identificacion</label>
        <input type="text" class="form-control" id="identificacionInvestigadoresFrm" placeholder="Identificacion">
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputPassword1">Lugar de expedición</label>
        <input type="text" class="form-control" id="lugarExpedicionInvestigadoresFrm" placeholder="Lugar de expedición">
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputPassword1">Telefono</label>
        <input type="text" class="form-control" id="telefonoInvestigadoresFrm" placeholder="Telefono">
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputPassword1">Correo</label>
        <input type="text" class="form-control" id="correoInvestigadoresFrm" placeholder="Correo">
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputPassword1">Direccion</label>
        <input type="text" class="form-control" id="direccionInvestigadoresFrm" placeholder="Direccion">
      </div>
    </div>

    <div class="col-md-12">
      <label>Si desea agrergar mas de un estudio o experiencia debe separarlos por el signo |.</label>
    </div>

    <div class="col-md-12">
      <div class="form-group">
        <label for="exampleInputPassword1">Estudios realizados</label>
        <textarea class="form-control" id="estudiosInvestigadoresFrm" placeholder="Estudios realizados" rows="3"></textarea>
      </div>
    </div>

    <div class="col-md-12">
      <div class="form-group">
        <label for="exampleInputPassword1">Experiencia laboral</label>
        <textarea class="form-control" id="experienciaInvestigadoresFrm" placeholder="Experiencia laboral" rows="3"></textarea>
      </div>
    </div>

    <div class="col-md-12">
      <div class="form-group">
        <label for="exampleInputPassword1">Foto de perfil</label>
        <input type="file" id="imagenInvestigadoresFrm" class="form-control" onchange="validarArchivo(this);" accept="image/png, image/jpeg">
      </div>
    </div>
  </div><!-- /.box-body -->

  <div class="box-footer" style="display:none;">
    <div class="col-md-6">
      <div class="form-group">
        <input type="hidden" id="exeFrmInvestigadores">
        <input type="hidden" id="idRegistroInvestigador">
      </div>
    </div>
  </div>
</form>

              