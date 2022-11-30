
		<div class="box-body">
		<form role="form" id="frmMultimediaInvestigacion"> 
              <div class="row">
                  
                       <div class="col-md-6">
                        <div class="form-group">
                            <input name="img1FrmMultimedia" id="img1FrmMultimedia" type="file" size="150" class="btn btn-block btn-success" required="">
                          
                        </div>
                 		</div>  


                 		<div class="col-md-6">
                        <div class="form-group">
                            <input name="img2FrmMultimedia" id="img2FrmMultimedia" type="file" size="150" class="btn btn-block btn-success" required="">
                          
                        </div>
                 		</div> 


            </div>
               <div class="row">

                 		 <div class="form-group col-sm-6">
                            <label for="">Seccion Informe:</label>
                       <select  id="seccionMultimediaFrmMultimedia" style="width: 100%;" class="form-control select2" >
                        <option value="0">SELECCIONE UN VALOR</option>
                           <?php 
                        mysqli_next_result($con);
                $consultarSeccionInforme="CALL consultasBasicas(23)";
                $verSeccionInforme=mysqli_query($con,$consultarSeccionInforme);


                 while($resul = mysqli_fetch_assoc($verSeccionInforme)){
                  ?>
                  <option value="<?php echo $resul['id']; ?>">
                    <?php echo $resul['descripcion']; ?>               
                  </option>
                  
                  <?php 

                  }

                  ?>
                                  
                        </select>
                              
                        </div> 


                        <div class="col-sm-6">
                 <div class="form-group">
                 	<label>&nbsp;</label>
                    <a  class="btn btn-block btn-primary"  id="BtnGuardarMultimediaInvestigacionFrm">Guardar</a>
                   </div>
              </div>
            </div>

            <input type="hidden" id="idInvestigacionFrmMultimedia">
            
	</form>
        
  <div id="DivTablas20">
    <table id="tablaGestionMultimediaInvestigacion" class="display" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th style="width:350px;" width="350px">Codigo</th>
          <th style="width:350px;" width="350px">Seccion</th>
          <th style="width:350px;" width="350px">Ver Imagen</th>
          <th style="width:350px;" width="350px">Eliminar</th>
        </tr>
      </thead>
    </table>
  </div>
         
            
            
          
           
                 
           
            
   

       
                 
                 
		</div>

		