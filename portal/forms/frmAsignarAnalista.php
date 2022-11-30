    <?php
      include('conexion/conexion.php');
  
global $con;  
    ?>

 <form role="form" id="frmSeleccAsignarAnalista">
              <div class="box-body">


                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Analista</label>
                          <select id="analistaAsignarAnalista" style="width: 100%;" class="form-control select2" >
                                    <option value="0">SELECCIONE UNA OPCION</option>
                                                <?php 
                                     
                                                $consultarAnalistas="CALL consultasBasicas(13)";
                                                $verAnalista=mysqli_query($con,$consultarAnalistas);


                                                 while($resul = mysqli_fetch_assoc($verAnalista)){
                                                      ?>
                                                      <option value="<?php echo $resul['id']; ?>">
                                                            <?php echo $resul['nombre_usuario']; ?>                                               
                                                      </option>
                                                      
                                                      <?php 

                                                      }

                                                      ?>
                                                 
                                                
                                          </select>
                        </div>
                    </div>
                  </div>
                </div>

           
                <div class="col-md-6">
                        <div class="form-group">
                          <a  id="btnAsignarAnalista" class="btn btn-primary">Asignar</a>
                          <id id="idCasoSoatAnalista" type="hidden">
                          

                        </div>
                    </div>
                
              <!-- /.box-body -->

              </div>
          
            
            </form>