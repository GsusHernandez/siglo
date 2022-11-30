    <?php
      include('conexion/conexion.php');
  
global $con;  
    ?>
              <form  role="form" id="frmAsignacionInvestigadorClinica" name="frmAsignacionInvestigadorClinica">

                <div class="col-sm-12 form-group">
                  <label>Investigador</label>
                  <select id="InvestigadorFrmInvIps" style="width: 100%;" class="form-control select2" >
                    <?php 
                     $verInve =mysqli_query($con,"CALL consultasBasicas(9)");
                     while($resul = mysqli_fetch_assoc($verInve)){
                      ?>
                      <option value="<?php echo $resul['id']; ?>">
                        <?php echo $resul['nombre_investigador']." - ".$resul['identificacion_investigador']; ?>               
                      </option>
                      
                      <?php 

                      }

                      ?>
                     
                    
                  </select>
                  
                </div>


                

                <div class="col-md-6">
                        <div class="form-group">
                          <a  id="btnGuardarAsignacionInvestigadorIps" class="btn btn-primary">Guardar</a>
                          <input type="hidden" id="idRegistroAsignacionInvestigadorIps">                         

                        </div>
                    </div>

                    <div id="DivTablaAsignacionInvestigadorIps">
                        <div id="DivTablas10">
                           <table id="tablaAsignacionInvestigadorIps" class="display" cellspacing="0" width="100%">
                              <thead>
                                  <tr>
                                    
                                    <th>Nombre</th>
                                    <th>Identificacion</th>
                                    <th>Telefono</th>
                                    <th>Opciones</th>
                                                                   
                                  </tr>
                              </thead>
                         
                          </table>
                        </div>
                    </div>

                    <div class="box-footer">
                      
                  </div>
              </form>