<div>


	<form id="frmAseguradora">
		<div class="form-group">
			<label>Nombre Aseguradora</label>
			<input id="nombreFrmAsegurador" class="form-control CampText" type="text">
		</div>
		<div class="row">
			<div class="col-sm-4 form-group ">
				<label>No. Nit</label>
				<input id="nitFrmAseguradora" class="form-control CamNum" type="text">
			</div>
			<div class="col-sm-4 form-group ">
				<label>dígito Verificación</label>
				<input id="digverFrmAseguradora" class="form-control CamNum" type="text">
			</div>
			<div class="col-sm-4 form-group ">
				<label>Indicativo Aseguradora</label>
				<input id="indicativoFrmAseguradora" class="form-control CamNum" type="text">
			</div>

		</div>

		<div class="form-group">
			<label>Dirección</label>
			<input id="dirFrmAseguradora" class="form-control" type="text">
		</div>
		<div class="form-group">
			<label>Teléfono</label>
			<input id="telFrmAseguradora" class="form-control CamNum" type="text">
		</div>
		<div class="form-group">
			<label>Responsable</label>
			<input id="responsableFrmAseguradora" class="form-control CampText" type="text">
		</div>
		<div class="form-group">
			<label>Cargo</label>
			<input id="cargoFrmAseguradora" class="form-control CampText" type="text">
		</div>
		<div class="form-group">
			<input  id="exeAseguradora" class="form-control" type="hidden">
			<input  id="idRegistroAseguradora" class="form-control" type="hidden">
			
		</div>
		<div class="row">
						<div class="col-sm-6 form-group">
							<label>Resultado ATENDER</label>
							 <select id="atenderFrmAseg" style="width: 100%;" class="form-control select2" >
                    <?php 
                     $verAmparo =mysqli_query($con,"CALL consultasBasicas(2)");
                     while($resul = mysqli_fetch_assoc($verAmparo)){
                      ?>
                      <option value="<?php echo $resul['id']; ?>">
                        <?php echo $resul['descripcion2']; ?>               
                      </option>
                      
                      <?php 

                      }

                      ?>
                     
                    
                  </select>
							
						</div>
						<div class="col-sm-6 form-group">
							<label>Resultado NO ATENDER</label>

							 <select id="noAtenderFrmAseg" style="width: 100%;" class="form-control select2" >
                    <?php 
                     mysqli_next_result($con);
                     $verAmparo =mysqli_query($con,"CALL consultasBasicas(3)");
                     while($resul = mysqli_fetch_assoc($verAmparo)){
                      ?>
                      <option value="<?php echo $resul['id']; ?>">
                        <?php echo $resul['descripcion2']; ?>               
                      </option>
                      
                      <?php 

                      }

                      ?>
                     
                    
                  </select>
							
						</div>
					</div>


	</form>
	



</div>