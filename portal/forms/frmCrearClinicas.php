<div>

	
	            <form id="frmClinicas">
					<div class="form-group">
						<label>Nombre Clínica</label>
						<input id="nombreFrmClinica" class="form-control CampText" type="text" name="">
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label>No. Nit</label>
							<input id="nitFrmClinica" class="form-control CamNum" type="text">
						</div>
						<div class="col-sm-6 form-group">
							<label>dígito Verificación</label>
							<input id="DigFrmVerificacion2" class="form-control CamNum" type="text">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label>Ciudad</label>
							<select id="ciudadFrmIps" style="width: 100%;" class="form-control select2" >
								<?php 
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
						<div class="col-sm-6 form-group">
							<label>Teléfono</label>
							<input id="telefonoFrmIps" class="form-control CamNum" type="text">
						</div>
					</div>
					<div class="form-group">
						<label>Dirección</label>
						<input id="direccionFrmIps" class="form-control text-uppercase" type="text">
					</div>
					<div class="form-group">
						<input  id="exeClinicas" class="form-control" type="hidden">
						<input  id="idRegistroClinica" class="form-control" type="hidden">
						
					</div>

								
					


				</form>
	
              

</div>