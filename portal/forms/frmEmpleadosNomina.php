            <form role="form" id="FrmEmpleadosNomina">
              <div class="box-body">
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nombres</label>
                      <input type="text" class="form-control CampText" id="nombresEmpleadoFrm" placeholder="Nombres">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Apellidos</label>
                      <input type="text" class="form-control CampText" id="apellidosEmpleadoFrm" placeholder="Apellidos">
                    </div>
                </div>

                 <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Tipo Identificacion</label>
                      <select id="tipoIdentificacionEmpleadoFrm" class="form-control select2" style="width: 100%;">
                      <?php 
                      $consultarTipoIdentificacion=mysql_query("SELECT id,descripcion,descripcion2 FROM definicion_tipos WHERE id_tipo=5");
                      while ($resTipoIdentificacion=mysql_fetch_array($consultarTipoIdentificacion)){
                        ?>
                            <option value="<?php echo $resTipoIdentificacion["id"];?>"><?php echo $resTipoIdentificacion["descripcion2"];?></option>
                        <?php
                      }
                      ?>
                      </select>
                    </div>
                </div>



                <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Identificacion</label>
                      <input type="text" class="form-control CamNum" id="identificacionEmpleadoFrm" placeholder="Identificacion">
                    </div>
                </div>



                 <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Tipo Empleado</label>
                      <select id="tipoEmpleadoFrm" class="form-control select2" style="width: 100%;">
                      <?php 
                      $consultarTipoEmpleado=mysql_query("SELECT id,descripcion,descripcion2 FROM definicion_tipos WHERE id_tipo=28");
                      while ($resTipoEmpleado=mysql_fetch_array($consultarTipoEmpleado)){
                        ?>
                            <option value="<?php echo $resTipoEmpleado["id"];?>"><?php echo $resTipoEmpleado["descripcion"];?></option>
                        <?php
                      }
                      ?>
                      </select>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Correo</label>
                      <input type="text" class="form-control" id="correoEmpleadoFrm" placeholder="Correo">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Telefono</label>
                      <input type="text" class="form-control CamNum" id="telefonoEmpleadoFrm" placeholder="Telefono">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Direccion</label>
                      <input type="text" class="form-control CampText" id="direccionEmpleadoFrm" placeholder="Direccion">
                    </div>
                </div>

                
                
              <!-- /.box-body -->

              </div>
              <div class="box-footer">
                  <div class="col-md-6">
                    <div class="form-group">
                        <a id="btnSubmitFrmEmpleado" class="btn btn-primary">Submit</a>
                        <input type="hidden" id="exeFrmEmpleado">
                        <input type="hidden" id="idRegistroEmpleado">
                    </div>
                </div>
              </div>
            
            </form>

              