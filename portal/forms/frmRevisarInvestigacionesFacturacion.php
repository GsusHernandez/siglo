<div class="row">
        <!-- left column -->

        <div class="col-sm-3">
        <div class="form-group">
           
        <select id="aseguradoraFrmRevisarFacturacion" class="form-control select2" style="width: 100%;">
          <option value="0">SELECCIONE UN VALOR</option>
          <?php 
          mysqli_next_result($con);
          $verAmparo =mysqli_query($con,"CALL manejoAseguradoras(6,'','','','','','','','','','','','',@resp)");
          while($resul = mysqli_fetch_assoc($verAmparo)){ ?>
            <option value="<?php echo $resul['id']; ?>">
              <?php echo $resul['nombre_aseguradora']; ?>               
            </option>
            <?php 
          } ?>
        </select>
        </div>
      </div>

 <div class="col-sm-3">
        <div class="form-group">
           
        <select id="tipoCasoFrmRevisarFacturacion" class="form-control select2" style="width: 100%;">
          
        </select>
        </div>
      </div>


       <div class="col-sm-3">
        <div class="form-group">
  
          <a class="btn btn-block btn-primary"  id="BtnAddIndicativosAseguradora">Consultar</a>
        </div>
      </div>
    



    <div class="col-md-12">
     
    	  <div id="divTablas">
                    <div id="DivTablas23">
                       <table id="tablaGestionRevisarInvestigacionesFacturacion" class="display" cellspacing="0" width="100%">
                          <thead>
                              <tr>
                              	<th style="width:350px;" width="350px">Inf. Investigacion</th>
                                  <th style="width:350px;" width="350px">Inf. Lesionado</th>
                                  
                                  <th style="width:350px;" width="350px">Resultado</th>
                                  <th style="width:350px;" width="350px">Observacion</th>
                                  <th style="width:300px;" width="300px">Opciones</th>
                                
                              </tr>
                          </thead>
                     
                      </table>
                    </div>
                </div>	
    </div>
</div>