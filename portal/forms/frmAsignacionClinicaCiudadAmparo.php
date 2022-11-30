<div class="row">
        <!-- left column -->
<div class="col-md-12">

        <div class="box box-solid box-primary">
            
            <!-- /.box-header -->
            <!-- form start -->
             <div class="box-body">
          
                
                <div class="col-sm-5">
                  <div class="form-group">
                     <label>Ciudad</label>
                        <select id="ciudadAsigCiuClinicaFrm" style="width: 100%;" class="form-control select2" >
                          <?php 
                          mysqli_next_result($con);
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
                </div>
                <div class="col-sm-5">
                  <div class="form-group">
                         <label>Clinica</label>
                        <select id="clinicaAsigCiuClinicaFrm" style="width: 100%;" class="form-control select2" >
                          <?php 
                            mysqli_next_result($con);
                           $consultarClinica="CALL consultasBasicas(7)";
                              $verClinica=mysqli_query($con,$consultarClinica);
                           while($resul2 = mysqli_fetch_assoc($verClinica)){
                            ?>
                            <option value="<?php echo $resul2['id']; ?>">
                              <?php echo $resul2['ips']; ?>               
                            </option>
                            
                            <?php 

                            }

                            ?>
                           
                          
                        </select>
                  </div>
                </div>

                <div class="col-sm-2">
                     <a class="btn btn-block btn-primary"  id="btnAddClinicaCiudadAseg"><i class="glyphicon glyphicon-plus"></i></a>
                     <input type="hidden" id="idRegistroAseguradoraClinicaCiudad" class="idAmparoMetodoFact">
                </div>

          
                <br><br>
                
                    <div id="DivTablas6">
                       <table id="tablaClinicaCiudadesTarifaAmparo" class="display" cellspacing="0" width="100%">
                          <thead>
                              <tr>
                                  <th style="width:350px;" width="350px">Ciudad</th>
                                  <th style="width:200px;" width="300px">Clinica</th>
                                  <th style="width:300px;" width="300px">Opciones</th>
                                
                              </tr>
                          </thead>
                     
                      </table>
                    </div>
                
        
            </div>
    
        </div>

        </div>








      




</div>