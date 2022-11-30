            <form role="form" id="FrmMetodoPagoEmpleado">
              <div class="box-body">
               
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Sueldo Completo</label>
                      <input type="text" class="form-control CamNum" id="sueldoCompletoEmpleadoFrm" placeholder="Sueldo Completo">
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Numero de Pagos Sueldo</label>
                      <input type="text" class="form-control CamNum" id="cantidadPagosSueldoEmpleadoFrm" placeholder="Numero Pagos Sueldo">
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Descuentos Salud</label>
                      <input type="text" class="form-control CamNum" id="descuentoSaludEmpleadoFrm" placeholder="Sueldo Completo">
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Numero de Descuentos Salud</label>
                      <input type="text" class="form-control CamNum" id="cantidadDescuentsSaludEmpleadoFrm" placeholder="Numero Descuentos Salud">
                    </div>
                </div>




               <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Metodo de Pago</label>
                      <select id="metodoPagoEmpleadoFrm" class="form-control select2" style="width: 100%;">
                      <?php 
                      $consultarMetodoPago=mysql_query("SELECT id,descripcion,descripcion2 FROM definicion_tipos WHERE id_tipo=6 order by id asc");
                      while ($resMetodoPago=mysql_fetch_array($consultarMetodoPago)){
                        ?>
                            <option value="<?php echo $resMetodoPago["id"];?>"><?php echo $resMetodoPago["descripcion"];?></option>
                        <?php
                      }
                      ?>
                      </select>
                    </div>
                </div>

                
               <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Tipo de Producto</label>
                      <select id="tipoProductoEmpleadoFrm" class="form-control select2" style="width: 100%;">
                      <?php 
                      $consultarTipoProducto=mysql_query("SELECT id,descripcion,descripcion2 FROM definicion_tipos WHERE id_tipo=7");
                      while ($resTipoProducto=mysql_fetch_array($consultarTipoProducto)){
                        ?>
                            <option value="<?php echo $resTipoProducto["id"];?>"><?php echo $resTipoProducto["descripcion"];?></option>
                        <?php
                      }
                      ?>
                      </select>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Numero de Referencia</label>
                      <input type="text" class="form-control CamNum" id="numReferenciaEmpleadoFrm" placeholder="Numero de Referencia">
                    </div>
                </div>



              

                
                
              <!-- /.box-body -->

              </div>
              <div class="box-footer">
                  <div class="col-md-6">
                    <div class="form-group">
                        <a id="btnSubmitFrmMetodoPagoEmpleado" class="btn btn-primary">Submit</a>
                        <input type="hidden" id="exeFrmMetodoPagoEmpleado">
                        <input type="hidden" id="idRegistroMetodoPagoEmpleado">
                        <input type="hidden" id="idRegistroEmpleadoMetodoPago">
                    </div>
                </div>
              </div>
            
            </form>

              