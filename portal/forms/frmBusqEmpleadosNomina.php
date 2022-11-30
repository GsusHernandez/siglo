
									


            <form role="form" id="FormBusqEmpleadosNomina">
              <div class="box-body">
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nombres</label>
                      <input type="text" class="form-control CampText" id="nombreEmpleadoNomina" placeholder="Nombres">
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Apellidos</label>
                      <input type="text" class="form-control CampText" id="apellidoEmpleadoNomina" placeholder="Apellidos">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Identificacion</label>
                      <input type="text" class="form-control" id="identificacionEmpleadoNomina" placeholder="Identificacion">
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Tipo Empleado</label>
                      <select id="tipoEmpleadoNomina" class="form-control select2" style="width: 100%;">
                      <option value="0">NINGUNO</option>
                      <?php 
                      $consultarTiposEmpleado=mysql_query("SELECT * FROM definicion_tipos WHERE id_tipo=28");
                      while ($resTipoEmpleados=mysql_fetch_array($consultarTiposEmpleado)){
                        ?>
                            <option value="<?php echo $resTipoEmpleados["id"];?>"><?php echo $resTipoEmpleados["descripcion"];?></option>
                        <?php
                      }
                      ?>
                      </select>
                    </div>
                </div>


        



                

                
                
              <!-- /.box-body -->

              </div>
              <div class="box-footer">
                  <div class="col-md-6">
                    <div class="form-group">
                        <a id="btnSubmitBuscarEmpleadosNomina" class="btn btn-primary">Buscar</a>
                        <input type="hidden" id="exeFrmBusqEmpleadosNomina">
                    </div>
                </div>
              </div>
            
            </form>

              