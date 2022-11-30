  <?php
  $consultarParametrosGenerales1="SELECT * FROM definicion_tipos WHERE id_tipo=6 and ";
  
  ?>
    <div class="col-md-6">
          <div class="box box-solid box-danger">
            <div class="box-header with-border">
              <h3 class="box-title"><b>Parametros Generales</b></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
                     <div class="form-horizontal">
                      <div class="form-group">
                      <?php 
                      $consultarParametrosGenerales=$consultarParametrosGenerales1."id=1";
                      $queryParametrosGenerales=mysql_query($consultarParametrosGenerales);
                      $nombreEmpresa=mysql_fetch_array($queryParametrosGenerales);
                      ?>

                          <label class="col-md-6 control-label">Nombre Empresa</label>
                        <div class="col-md-6">
                          
                            
                            <input type="text" class="form-control CamText" value="<?php echo $nombreEmpresa['descripcion'];?>"id="nombreEmpresaParametroGeneral" placeholder="Nombre Empresa">
                          </div>
                      </div>


                      <div class="form-group">
                      <?php 
                      $consultarParametrosGenerales=$consultarParametrosGenerales1."id=9";
                      $queryParametrosGenerales=mysql_query($consultarParametrosGenerales);
                      $codigoPrestador=mysql_fetch_array($queryParametrosGenerales);
                      ?>

                          <label class="col-md-6 control-label">Codigo Prestador</label>
                        <div class="col-md-6">
                          
                            
                            <input type="text" class="form-control CamNum" value="<?php echo $codigoPrestador['descripcion'];?>"id="codigoPrestadorParametroGeneral" placeholder="Codigo Prestador">
                          </div>
                      </div>


                      <div class="form-group">
                      <?php 
                      $consultarParametrosGenerales=$consultarParametrosGenerales1."id=10";
                      $queryParametrosGenerales=mysql_query($consultarParametrosGenerales);
                      $tipoIdentificacionEmpresa=mysql_fetch_array($queryParametrosGenerales);
                      ?>
                          <label class="col-md-6 control-label">Tipo Identificacion Empresa</label>
                        <div class="col-md-6">
                          
                            <select id="tipoIdentificacionParametroGeneral" class="form-control select2" style="width: 100%;">
                      <?php 
                      $consultarTipoIdentificacion=mysql_query("SELECT id,descripcion,descripcion2 FROM definicion_tipos WHERE id_tipo=5");


                      while ($resTipoIdentificacion=mysql_fetch_array($consultarTipoIdentificacion)){
                        if ($resTipoIdentificacion["id"]==$tipoIdentificacionEmpresa["descripcion"]){
                          ?>
                            <option selected value="<?php echo $resTipoIdentificacion["id"];?>"><?php echo $resTipoIdentificacion["descripcion"];?></option>
                        <?php

                        }else{
                          ?>
                            <option value="<?php echo $resTipoIdentificacion["id"];?>"><?php echo $resTipoIdentificacion["descripcion"];?></option>
                        <?php
                        }
                        
                      }
                      ?>
                      </select>



                            
                          </div>
                      </div>



                      <div class="form-group">
                      <?php 
                      $consultarParametrosGenerales=$consultarParametrosGenerales1."id=2";
                      $queryParametrosGenerales=mysql_query($consultarParametrosGenerales);
                      $identificacionEmpresa=mysql_fetch_array($queryParametrosGenerales);
                      ?>

                          <label class="col-md-6 control-label">Identificacion Empresa</label>
                        <div class="col-md-6">
                          
                            
                            <input type="text" class="form-control CamNum" id="identificacionEmpresaParametroGeneral" value="<?php echo $identificacionEmpresa['descripcion'];?>" placeholder="Identificacion Empresa">
                          </div>
                      </div>

                      <div class="form-group">
                      <?php 
                      $consultarParametrosGenerales=$consultarParametrosGenerales1."id=3";
                      $queryParametrosGenerales=mysql_query($consultarParametrosGenerales);
                      $telefonoEmpresa=mysql_fetch_array($queryParametrosGenerales);
                      ?>
                          <label class="col-md-6 control-label">Telefono Empresa</label>
                        <div class="col-md-6">
                          
                            
                            <input type="text" class="form-control CamNum" value="<?php echo $telefonoEmpresa['descripcion'];?>" id="telefonoEmpresaParametroGeneral" placeholder="Telefono Empresa" >
                          </div>
                      </div>

                      <div class="form-group">
                      <?php 
                      $consultarParametrosGenerales=$consultarParametrosGenerales1."id=4";
                      $queryParametrosGenerales=mysql_query($consultarParametrosGenerales);
                      $direccionEmpresa=mysql_fetch_array($queryParametrosGenerales);
                      ?>
                          <label class="col-md-6 control-label">Direccion Empresa</label>
                        <div class="col-md-6">
                          
                            
                            <input type="text" class="form-control CamText" value="<?php echo $direccionEmpresa['descripcion'];?>" id="direccionEmpresaParametroGeneral" placeholder="Direccion Empresa" >
                          </div>
                      </div>


                      <div class="form-group">
                      <?php 
                      $consultarParametrosGenerales=$consultarParametrosGenerales1."id=5";
                      $queryParametrosGenerales=mysql_query($consultarParametrosGenerales);
                      $ciudadEmpresa=mysql_fetch_array($queryParametrosGenerales);
                      ?>
                          <label class="col-md-6 control-label">Ciudad Empresa</label>
                        <div class="col-md-6">
                          
                            
                            <select id="municipioEmpresaParametroGeneral" class="form-control select2" style="width: 100%;">
                      <?php 
                      $consultarCiudades=mysql_query("SELECT a.id,CONCAT(a.nombre,' - ',b.nombre) as municipio FROM ciudades a LEFT JOIN departamentos b ON a.id_departamento=b.id");


                      while ($resCiudadUsuarios=mysql_fetch_array($consultarCiudades)){
                        if ($resCiudadUsuarios["id"]==$ciudadEmpresa["descripcion"]){
                          ?>
                            <option selected value="<?php echo $resCiudadUsuarios["id"];?>"><?php echo $resCiudadUsuarios["municipio"];?></option>
                        <?php

                        }else{
                          ?>
                            <option value="<?php echo $resCiudadUsuarios["id"];?>"><?php echo $resCiudadUsuarios["municipio"];?></option>
                        <?php
                        }
                        
                      }
                      ?>
                      </select>

                          </div>
                      </div>


                      <div class="form-group">
                      <?php 
                      $consultarParametrosGenerales=$consultarParametrosGenerales1."id=8";
                      $queryParametrosGenerales=mysql_query($consultarParametrosGenerales);
                      $valorIVA=mysql_fetch_array($queryParametrosGenerales);
                      ?>
                          <label class="col-md-6 control-label">IVA</label>
                        <div class="col-md-6">
                          
                            
                            <input type="text" class="form-control CamNum" value="<?php echo $valorIVA['descripcion'];?>" id="valorIVAParametroGeneral" placeholder="Valor IVA" >
                          </div>
                      </div>

                      

                      

            </div>

            <!-- /.box-body -->
           
          </div>


           <div class="box-footer">

                          <div class="col-md-6">
                            <div class="form-group">
                                <a id="btnSubmitFrmParametrosGenerales" class="btn btn-primary">Registrar</a>
                                
                            </div>
                        </div>
                      </div>
          <!-- /.box -->
  
       
          <!-- /.box -->
        </div>



      

                <div class="box box-solid box-danger">
            <div class="box-header with-border">
              <h3 class="box-title"><b>Parametros Clientes</b></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
                     <div class="form-horizontal">
                      <div class="form-group">
                      <?php 
                      $consultarParametrosGenerales=$consultarParametrosGenerales1."id=6";
                      $queryParametrosGenerales=mysql_query($consultarParametrosGenerales);
                      $clienteParticular=mysql_fetch_array($queryParametrosGenerales);
                      ?>
                          <label class="col-md-6 control-label">Cliente Particular</label>
                        <div class="col-md-6">
                          
                            
                            <select id="codClienteParticularParametroGeneral" class="form-control select2" style="width: 100%;">
                            <option value="0">SELECCIONE UN VALOR</option>
                            <?php 
                            $consultarClientes=mysql_query("SELECT id,nombre,codigo FROM clientes WHERE vigente='s'");
                            while ($resClientes=mysql_fetch_array($consultarClientes)){
                              if ($resClientes["id"]==$clienteParticular["descripcion"]){
                          ?>
                            <option selected value="<?php echo $resClientes["id"];?>"><?php echo $resClientes["nombre"]." - ".$resClientes["codigo"];?></option>
                        <?php

                        }else{
                          ?>
                            <option value="<?php echo $resClientes["id"];?>"><?php echo $resClientes["nombre"]." - ".$resClientes["codigo"];?></option>
                        <?php
                        }

                           
                            }
                            ?>
                            </select>
                          </div>
                      </div>

                      <div class="form-group">
                      <?php 
                      $consultarParametrosGenerales=$consultarParametrosGenerales1."id=7";
                      $queryParametrosGenerales=mysql_query($consultarParametrosGenerales);
                      $clienteCortesias=mysql_fetch_array($queryParametrosGenerales);
                      ?>
                          <label class="col-md-6 control-label">Cliente Cortesias</label>
                        <div class="col-md-6">
                          
                            
                            <select id="codClienteCortesiaParametroGeneral" class="form-control select2" style="width: 100%;">
                            <option value="0">SELECCIONE UN VALOR</option>
                            <?php 
                            $consultarClientes=mysql_query("SELECT id,nombre,codigo FROM clientes WHERE vigente='s'");
                            while ($resClientes=mysql_fetch_array($consultarClientes)){

                              if ($resClientes["id"]==$clienteCortesias["descripcion"]){
                          ?>
                            <option selected value="<?php echo $resClientes["id"];?>"><?php echo $resClientes["nombre"]." - ".$resClientes["codigo"];?></option>
                        <?php

                        }else{
                          ?>
                            <option value="<?php echo $resClientes["id"];?>"><?php echo $resClientes["nombre"]." - ".$resClientes["codigo"];?></option>
                        <?php
                        }

                          
                            }
                            ?>
                            </select>
                          </div>
                      </div>


            </div>

            <!-- /.box-body -->
           
          </div>

           <div class="box-footer">
                          <div class="col-md-6">
                            <div class="form-group">
                                <a id="btnSubmitFrmParametrosClientes" class="btn btn-primary">Registrar</a>
                                
                            </div>
                        </div>
                      </div>
          <!-- /.box -->
  
       
          <!-- /.box -->
        </div>  
        
          <!-- /.box -->

       
          <!-- /.box -->
        </div>


      










  <div class="col-md-6">
          <div class="box box-solid box-danger">
            <div class="box-header with-border">
              <h3 class="box-title"><b>Impresoras POS</b></h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
            <form id="frmImpresotasPOS">
             <div class="col-md-4">
                    <div class="form-group">
                      
                      <select id="usuariosImpresoraPOS" class="form-control select2" style="width: 100%;">
                      <?php 
                      $consultarUsuarios=mysql_query("SELECT id,CONCAT(nombre,' ',apellido) as nombre_usuario FROM usuarios WHERE vigente='s'");
                      while ($resUsuarios=mysql_fetch_array($consultarUsuarios)){
                        ?>
                        <option value="<?php echo $resUsuarios["id"];?>">
                        <?php echo $resUsuarios["nombre_usuario"];?>
                        </option>
                        <?php
                      }
                      ?>
                      
                      </select>
                    </div>
                </div>


                <div class="col-sm-4" >
                  <div class="form-group">

                      <input type="text" class="form-control" id="nombreImpresoraPOS" placeholder="Nombre Impresora">
                  </div>
                </div>

                <div class="col-sm-2">
                     <a class="btn btn-block btn-primary"  id="BtnAddImpresorasPOS">
                     <input type="hidden" class="form-control" id="exeFrmImpresorasPOS" value="registrarImpresoraPOS">
                     <input type="hidden" class="form-control" id="idRegistroImpresorasPOS">
                       <i id="iconoAddImpresorasPOS" class="glyphicon glyphicon-plus"></i>
                    </a>
                </div>
                </form>

                <div id="DivCancelarEditarImpresorasPOS" style="display:none;">
                <div class="col-sm-2">
                     <a class="btn btn-block btn-primary"  id="BtnCancelarEditarImpresorasPOS">
                       <i class="glyphicon glyphicon-remove"></i>
                    </a>
                </div>
                </div>
                <div id="divTablaImpresorasPOS">
                    <div id="DivTablas9">
                <table id="tablaImpresorasPOS" class="display" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th style="width:400px;" width="600px">Usuario</th>
                          <th style="width:400px;" width="200px">Impresora</th>
                          <th style="width:400px;" width="200px">Opciones</th>
                          

                          
                        </tr>
                      </thead>
                 
                    </table>
                    </div>
                    </div>
            </div>

            <!-- /.box-body -->
           
          </div>
          <!-- /.box -->
</div>
       
          <!-- /.box -->
        </div>