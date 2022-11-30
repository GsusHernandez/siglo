    <?php
      include('conexion/conexion.php');
  
global $con;  
    ?>

    <div class="box box-primary box-solid">

            <div class="box-header with-border">
              <h4 class="box-title">Asignar Indicador a Aseguradora</h4>
            </div>
            <!-- /.box-header -->
            <div class="box-body">


              <form  role="form" id="frmAsignacionIndicadorAseguradora" name="frmAsignacionIndicadorAseguradora">

                <div class="row">
						<div class="col-sm-6 form-group">
							<label>Resultado ATENDER</label>
							 <select id="indicadorAtenderAseg" style="width: 100%;" class="form-control select2" >
                    <?php 
                     $verAmparo =mysqli_query($con,"CALL consultasBasicas(6)");
                     while($resul = mysqli_fetch_assoc($verAmparo)){
                      ?>
                      <option value="<?php echo $resul['id']; ?>">
                        <?php echo $resul['descripcion']; ?>               
                      </option>
                      
                      <?php 

                      }

                      ?>
                     
                    
                  </select>
							
						</div>
					<div class="col-sm-6 form-group">
												<label>Resultado NO ATENDER</label>
												 <select id="indicadorNoAtenderAseg" style="width: 100%;" class="form-control select2" >
					                    <?php 
					                    mysqli_next_result($con);
					                     $verAmparo =mysqli_query($con,"CALL consultasBasicas(6)");
					                     while($resul = mysqli_fetch_assoc($verAmparo)){
					                      ?>
					                      <option value="<?php echo $resul['id']; ?>">
					                        <?php echo $resul['descripcion']; ?>               
					                      </option>
					                      
					                      <?php 

					                      }

					                      ?>
					                     
					                    
					                  </select>
							
						</div>

						
						<input type="hidden" id="idRegistroAsignacionIndicadorAseguradora">                         
					</div>


					<div class="row">
						<div class="col-sm-6 form-group">
							<label>Codigo Indicador</label>
							<input id="codigoAtenderAseg" class="form-control CamNum" type="text">
							
						</div>

						<div class="col-sm-6 form-group">
							<label>Codigo Indicador</label>
							<input id="codigoNoAtenderAseg" class="form-control CamNum" type="text">						
										
						</div>

									
						</div>

               <div class="row">
						    <div class="col-md-6 form-group">
                        <div class="form-group">
                          <a  id="btnGuardarIndicadorAtenderAseg" class="btn btn-primary">Guardar</a>
                          

                        </div>
                    </div>


						    <div class="col-md-6 form-group">
                        <div class="form-group">
                          <a  id="btnGuardarIndicadorNoAtenderAseg" class="btn btn-primary">Guardar</a>
                          

                        </div>
                    </div>
						
					</div>
                    <div id="DivTablaAsignacionIndicadorAseguradora">
                        <div id="DivTablas7">
                           <table id="tablaAsignacionIndicadorAseguradora" class="display" cellspacing="0" width="100%">
                              <thead>
                                  <tr>
                                    
                                    <th>Resultado</th>
                                    <th>Indicador</th>
                                    <th>Codigo</th>
                                    <th>Opciones</th>
                                                                   
                                  </tr>
                              </thead>
                         
                          </table>
                        </div>
                    </div>

                    <div class="box-footer">
                      
                  </div>
              </form>





              
            </div>
            <!-- /.box-body -->
      </div>

    
    



  