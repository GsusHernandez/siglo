<div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">SOAT</a></li>
              <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Validaciones IPS</a></li>
       
              
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
              <form role="form" id="frmBusqCasosSOAT">
              <div class="box-body">


                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Codigo</label>
                          <input type="text" class="form-control" id="codigoFrmBuscarSOAT" placeholder="Codigo">
                        </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nombres</label>
                      <input type="text" class="form-control CampText" id="nombresFrmBuscarSOAT" placeholder="Nombres">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Apellidos</label>
                      <input type="text" class="form-control CampText" id="apellidosFrmBuscarSOAT" placeholder="Apellidos">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Identificacion</label>
                      <input type="text" class="form-control CampNum" id="identificacionFrmBuscarSOAT" placeholder="Identificacion">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Placa</label>
                      <input type="text" class="form-control" id="placaFrmBuscarSOAT" placeholder="Placa">
                    </div>
                </div>

             

                <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Poliza</label>
                      <input type="text" class="form-control" id="polizaFrmBuscarSOAT" placeholder="Poliza">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Identificador</label>
                      <input type="text" class="form-control" id="identificadorFrmBuscarSOAT" placeholder="Identificador">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Fecha Accidente</label>
                      <input type="text" class="form-control formFechas" id="fechaAccidenteFrmBuscarSOAT" placeholder="Fecha Accidente">
                    </div>
                </div>
                <?php
                if ($tipoUsuario<>4)
                {
                  ?>
                    <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Fecha Digitacion</label>
                      <input type="text" class="form-control formFechas" id="fechaDigitacionFrmBuscarSOAT" placeholder="Fecha Digitacion">
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Aseguradora</label>
                      <select id="aseguradoraFrmBuscarSOAT" class="form-control select2" style="width: 100%;">
                        <option value="0">SELECCIONE UN VALOR</option>
                        <?php 
                        mysqli_next_result($con);
                        $verAmparo =mysqli_query($con,"CALL manejoAseguradoras(6,'','','','','','','','','','','','',@resp)");
                        while($resul = mysqli_fetch_assoc($verAmparo)){ ?>
                          <option value="<?= $resul['id'];?>"><?=$resul['nombre_aseguradora']; ?></option>
                          <?php 
                        } ?>
                      </select>
                    </div>
                </div>
                  <?php
                }
                ?>
              


               
                <div class="col-md-12">
                        <div class="form-group">
                          <a  id="btnBuscarInvestigacionSOAT" class="btn btn-primary">Buscar</a>
                          

                        </div>
                    </div>
                
              <!-- /.box-body -->

              </div>
          
            
            </form>

              

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                 <form role="form" id="frmBusqCasosValidaciones">
              <div class="box-body">


                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Codigo</label>
                          <input type="text" class="form-control" id="codigoFrmBuscarValIPS" placeholder="Codigo">
                        </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Identificacion</label>
                      <input type="text" class="form-control CampNum" id="identificacionFrmBuscarValIPS" placeholder="Identificacion">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Razon Social</label>
                      <input type="text" class="form-control CampText" id="razonSocialFrmBuscarValIPS" placeholder="Razon Social">
                    </div>
                </div>


                 <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Identificador</label>
                      <input type="text" class="form-control CampText" id="identificadorFrmBuscarValIPS" placeholder="Razon Social">
                    </div>
                </div>


                

                
                <div class="col-md-6">
                        <div class="form-group">
                          <a  id="btnBuscarInvestigacionValIPS" class="btn btn-primary">Buscar</a>
                          

                        </div>
                    </div>
                
              <!-- /.box-body -->

              </div>
          
            
            </form>
              </div>
              <!-- /.tab-pane -->
          
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>