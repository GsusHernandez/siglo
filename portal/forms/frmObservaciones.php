	<form role="form" id="frmObservacionesInvestigacion"> 
    <div class="row">
      <div class="form-group col-sm-12">
        <label for="">Seccion Informe:</label>
          <select  id="seccionInformeFrmObservaciones" style="width: 100%;" class="form-control select2" >
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



                 	

                      
            </div>


            <div class="row">
            		 <div class="form-group col-sm-12">
                    <label for="">Observacion:</label>
                      <textarea class="form-control" rows="3" id="observacionesFrmObservaciones"></textarea>
                  </div> 

                 		

           
            </div>

            <input type="hidden" id="idInvestigacionFrmObservaciones">
            <input type="hidden" id="exeObservaciones">
            <input type="hidden" id="idObservacionInforme">                         
                       
            
            
	</form>