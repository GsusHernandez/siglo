<div class="row">
        <!-- left column -->
        <div class="col-md-12">

        
            
            <!-- /.box-header -->
            <!-- form start -->
             <div class="box-body">


             <div class="col-sm-4" >
                  <div class="form-group">
                      <label for="exampleInputPassword1">Valor Pago Paciente</label>

                      <input type="text" class="form-control CamNum" id="valorEstadoPagosPacientes" readonly>
                  </div>
                </div>


                <div class="col-sm-4" >
                  <div class="form-group">
                      <label for="exampleInputPassword1">Valor Pagado</label>

                      <input type="text" class="form-control CamNum" id="valorEstadoPagadoPacientes" readonly>
                  </div>
                </div>


                <div class="col-sm-4" >
                  <div class="form-group">
                      <label for="exampleInputPassword1">Valor Pendiente</label>

                      <input type="text" class="form-control CamNum" id="valorEstadoPendientePacientes" readonly>
                  </div>
                </div>




                <div class="col-md-4">
                    <div class="form-group">
                      
                      <select id="metodoPagoPacientes" class="form-control select2" style="width: 100%;">
                            <?php 
                            $consultarMetodoPago=mysql_query("SELECT id,descripcion,descripcion2 FROM definicion_tipos WHERE id_tipo=2 and id!=0");
                            while ($resMetodoPago=mysql_fetch_array($consultarMetodoPago)){
                              ?>
                                  <option value="<?php echo $resMetodoPago["id"];?>"><?php echo $resMetodoPago["descripcion"];?></option>
                              <?php
                            }
                            ?>
                            
                      </select>
                    </div>
                </div>


                <div class="col-sm-4" >
                  <div class="form-group">

                      <input type="text" class="form-control" id="valorPagosPacientes" placeholder="Valor Pago">
                  </div>
                </div>

                <div class="col-sm-2">
                     <a class="btn btn-block btn-primary"  id="BtnAddPagosPacientes" name="BtnAddPagosPacientes">
                     <input type="hidden" class="form-control" id="exeFrmPagosPacientes">
                       <i id="iconoAddPagosPacientes" class="glyphicon glyphicon-plus"></i>
                       <input type="hidden" id="idRegistroPagoPaciente">

                    </a>
                </div>

                <div id="DivCancelarEditarPagosPacientes" style="display:none;">
                <div class="col-sm-2">
                     <a class="btn btn-block btn-primary"  id="BtnCancelarEditarPagosPacientes">
                       <i class="glyphicon glyphicon-remove"></i>
                    </a>
                </div>
                </div>

          
                <br><br>
                <div id="DivTablaGestionPagosPacientes">
                    <div id="DivTablas8">
                       <table id="tablaGestionPagosPacientes" class="display" cellspacing="0" width="100%">
                          <thead>
                              <tr>
                                  <th style="width:350px;" width="350px">Valor Total</th>
                                  <th style="width:350px;" width="350px">Valor Pago</th>
                                  <th style="width:350px;" width="350px">Valor Pendiente</th>
                                  <th style="width:300px;" width="300px">Metodo de Pago</th>
                                  <th style="width:300px;" width="300px">Fecha</th>
                                  <th style="width:300px;" width="300px">Opciones</th>
                                
                              </tr>
                          </thead>
                     
                      </table>
                    </div>
                </div>
        
            </div>
    
        

        </div>







</div>
