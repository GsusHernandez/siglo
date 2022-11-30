
	
		<div class="box-body">
			<form role="form" id="frmRepresentanteLegalIPS"> 

				<div class="row">
			             <div class="col-md-6 form-group ">
							<label>Nombres</label>
							<input id="nombresRepresentanteLegalFrm" placeholder="NOMBRES REPRESENTANTE LEGAL" class="form-control CampText" type="text">
						</div>

						 <div class="col-md-6 form-group ">
							<label>Apellidos</label>
							<input id="apellidosRepresentanteLegalFrm" placeholder="APELLIDOS REPRESENTANTE LEGAL" class="form-control CampText" type="text">
						</div>
	              </div>


	              <div class="row">
			             <div class="col-md-6 form-group ">
							<label>Tipo Identificacion</label>
							<select id="tipoIdentificacionRepresentanteLegalFrm" style="width: 100%;" class="form-control select2" >
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


						<div class="col-md-6 form-group ">
							<label>Identificacion</label>
							<input id="identificacionRepresentanteLegalFrm" placeholder="IDENTIFICACION REPRESENTANTE LEGAL" class="form-control" type="text">
						</div>

						
	              </div>
		      
			     <div class="row">
			             <div class="col-md-12">
			              <div class="form-group">
			                <label>Correo Electronico</label>
			                <input id="correoRepresentanteLegalFrm" placeholder="CORREO ELECTRONICO REPRESENTANTE LEGAL" class="form-control" type="text">
			              </div>
			            </div>
	              </div>
	     

          

     
        <div class="row">
              <div class="col-sm-3">
                 <div class="form-group">
                    <a  class="btn btn-block btn-primary"  id="BtnGuardarRepresentanteLegalFrm">Guardar</a>
                   </div>
              </div>
        </div>
            
            <input type="hidden" id="idInvestigacionFrmRepresentanteLegal">
            
          
           
                 
           
            
   

       
                 
                 
		</div>
	</form>