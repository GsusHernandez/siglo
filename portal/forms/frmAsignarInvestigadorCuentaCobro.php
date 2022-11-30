    <?php
      include('conexion/conexion.php');
  
global $con;  
    ?>

 
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <div class="col-md-12">
          <div class="form-group">
            <div id="resultadoAsignacionInvestigadorCuentaCobro"></div>
          </div>
        </div>
        <div id="formSeleccionarInvestigadorCuentaCobro">
        <form role="form" id="frmSeleccAsignarAnalista">
        <div class="col-md-12">
          <div class="form-group">
            <label for="exampleInputEmail1">Periodo</label>
              <select id="periodoAsignarInvestigadorCuentaCobroFrm" style="width: 100%;" class="form-control select2" >
              <option value="0">SELECCIONE UNA OPCION</option>
              <?php 
              mysqli_next_result($con);
              $consultarPeriodos="CALL consultasBasicas(30)";
              $verPeriodos=mysqli_query($con,$consultarPeriodos);
              while($resul = mysqli_fetch_assoc($verPeriodos)){
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


        <div class="col-md-12">
          <div class="form-group">
            <label for="exampleInputEmail1">Investigador</label>
              <select id="investigadorAsignarInvestigadorCuentaCobroFrm" style="width: 100%;" class="form-control select2" >
                   <option value="0">SELECCIONE UNA OPCION</option>
              <?php 
              mysqli_next_result($con);
              $consultarInvestigadores="CALL consultasBasicas(9)";
              $verInvestigadores=mysqli_query($con,$consultarInvestigadores);
              while($resul2 = mysqli_fetch_assoc($verInvestigadores)){
              ?>
              <option value="<?php echo $resul2['id']; ?>">
              <?php echo $resul2['nombre_investigador']; ?>                                               
              </option>
              <?php 
              }
              ?>
              </select>                   
          </div>
        </div>



        <div class="col-md-12">
          <div class="form-group">
            <label for="exampleInputEmail1">Tipo Caso</label>
              <select id="tipoCasoAsignarInvestigadorCuentaCobroFrm" style="width: 100%;" class="form-control select2" >
              <option value="0">SELECCIONE UNA OPCION</option>
              <?php 
              mysqli_next_result($con);
              $consultarPeriodos="SELECT * FROM definicion_tipos where id_tipo=42";
              $verPeriodos=mysqli_query($con,$consultarPeriodos);
              while($resul = mysqli_fetch_assoc($verPeriodos)){
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


         <div class="col-md-12">
          <div class="form-group">
            <label for="exampleInputEmail1">Resultado</label>
              <select id="resultadoAsignarInvestigadorCuentaCobroFrm" style="width: 100%;" class="form-control select2" >
              <option value="0">SELECCIONE UNA OPCION</option>
              <?php 
              mysqli_next_result($con);
              $consultarPeriodos="SELECT * FROM definicion_tipos where id_tipo=44";
              $verPeriodos=mysqli_query($con,$consultarPeriodos);
              while($resul = mysqli_fetch_assoc($verPeriodos)){
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



         <div class="col-md-12">
          <div class="form-group">
            <label for="exampleInputEmail1">Tipo Auditoria</label>
              <select id="tipoAuditoriaAsignarInvestigadorCuentaCobroFrm" style="width: 100%;" class="form-control select2" >
              <option value="0">SELECCIONE UNA OPCION</option>
              <?php 
              mysqli_next_result($con);
              $consultarPeriodos="SELECT * FROM definicion_tipos where id_tipo=45";
              $verPeriodos=mysqli_query($con,$consultarPeriodos);
              while($resul = mysqli_fetch_assoc($verPeriodos)){
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


        <div class="col-md-12">
          <div class="form-group">
            <label for="exampleInputEmail1">Tipo Zona</label>
              <select id="tipoZonaAsignarInvestigadorCuentaCobroFrm" style="width: 100%;" class="form-control select2" >
              <option value="0">SELECCIONE UNA OPCION</option>
              <?php 
              mysqli_next_result($con);
              $consultarPeriodos="SELECT * FROM definicion_tipos where id_tipo=46";
              $verPeriodos=mysqli_query($con,$consultarPeriodos);
              while($resul = mysqli_fetch_assoc($verPeriodos)){
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
      <div class="col-md-6">
                        <div class="form-group">
                          
                          <input id="idCasoSoatInvestigadorCuentaCobro" type="hidden">
                          

                        </div>
                    </div>
</form>
</div>

      </div>
    </div>

           
          
                
              <!-- /.box-body -->

              </div>
          
            
            