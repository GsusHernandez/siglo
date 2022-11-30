    <?php
      include('conexion/conexion.php');
  
global $con;  
    ?>

    <div class="box box-primary box-solid">

            <div class="box-header with-border">
              <h4 class="box-title">Asignar Amparos a Aseguradora</h4>
            </div>
            <!-- /.box-header -->
            <div class="box-body">


              <form  role="form" id="frmAsignacionAmparoAseguradora" name="frmAsignacionAmparoAseguradora">

                <div class="col-sm-6 form-group">
                  <label>Amparo</label>
                  <select id="amparoFrmAmpAseg" style="width: 100%;" class="form-control select2" >
                    <?php 
                     $verAmparo =mysqli_query($con,"CALL consultasBasicas(4)");
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
                  <label>Metodo Facturacion</label>
                  <select id="metodoPagFrmAmpAseg" style="width: 100%;" class="form-control select2" >
                    <?php 
                    mysqli_next_result($con);
                     $verMetFact =mysqli_query($con,"CALL consultasBasicas(5)");
                     while($resul2 = mysqli_fetch_assoc($verMetFact)){
                      ?>
                      <option  value="<?php echo $resul2['id']; ?>">
                        <?php echo $resul2['descripcion']; ?>               
                      </option>
                      
                      <?php 

                      }

                      ?>
                     
                    
                  </select>
                  
                </div>

                <div class="col-md-6">
                        <div class="form-group">
                          <a  id="btnGuardarAsignacionAmparoAseguradora" class="btn btn-primary">Guardar</a>
                          <input type="hidden" id="idRegistroAsignacionAmparoAseguradora">                         

                        </div>
                    </div>

                    <div id="DivTablaAsignacionAmparoAseguradora">
                        <div id="DivTablas5">
                           <table id="tablaAsignacionAmparoAseguradora" class="display" cellspacing="0" width="100%">
                              <thead>
                                  <tr>
                                    
                                    <th>Amparo</th>
                                    <th>Metodo Facturacion</th>
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

    
    



  