<div class="row">
        <!-- left column -->
        <div class="col-md-12">

        
            
            <!-- /.box-header -->
            <!-- form start -->
             <div class="box-body">


             <div class="col-sm-4" >
                  <div class="form-group">
                      <label for="exampleInputPassword1">Valor Factura</label>

                      <input type="text" class="form-control CamNum" id="valorEstadoPagosFacturas" readonly>
                  </div>
                </div>


                <div class="col-sm-4" >
                  <div class="form-group">
                      <label for="exampleInputPassword1">Valor Pagado</label>

                      <input type="text" class="form-control CamNum" id="valorEstadoPagadoFacturas" readonly>
                  </div>
                </div>


                <div class="col-sm-4" >
                  <div class="form-group">
                      <label for="exampleInputPassword1">Valor Pendiente</label>

                      <input type="text" class="form-control CamNum" id="valorEstadoPendienteFacturas" readonly>
                  </div>
                </div>




                <div class="col-md-4">
                    <div class="form-group">
                      
                      <select id="metodoPagoFacturas" class="form-control select2" style="width: 100%;">
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

                      <input type="text" class="form-control" id="valorPagosFacturas" placeholder="Valor Pago">
                  </div>
                </div>

                <div class="col-sm-2">
                     <a class="btn btn-block btn-primary"  id="BtnAddPagosFacturas" name="BtnAddPagosFacturas">
                     <input type="hidden" class="form-control" id="exeFrmPagosFacturas">
                       <i id="iconoAddPagosFacturas" class="glyphicon glyphicon-plus"></i>
                       <input type="hidden" id="idRegistroPagoFactura">

                    </a>
                </div>

                <div id="DivCancelarEditarPagosFacturas" style="display:none;">
                <div class="col-sm-2">
                     <a class="btn btn-block btn-primary"  id="BtnCancelarEditarPagosFacturas">
                       <i class="glyphicon glyphicon-remove"></i>
                    </a>
                </div>
                </div>

          
                <br><br>
                <div id="DivTablaGestionPagosFacturas">
                    <div id="DivTablas11">
                       <table id="tablaGestionPagosFacturas" class="display" cellspacing="0" width="100%">
                          <thead>
                              <tr>
                                  <th style="width:350px;" width="350px">Valor Total</th>
                                  <th style="width:350px;" width="350px">Valor Pago</th>
                                  <th style="width:350px;" width="350px">Valor Pendiente</th>
                                  <th style="width:300px;" width="300px">Metodo de Pago</th>
                                  <th style="width:300px;" width="300px">Estado</th>
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
