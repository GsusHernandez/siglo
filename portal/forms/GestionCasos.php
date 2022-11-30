<div class="row">
  <div class="col-md-12">
    <div class="box box-solid box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Gestión Investigaciones</h3>
      </div>
      <div class="box-body">
        <?php 
        $verOpcionesAnalistaRI =mysqli_query($con,"SELECT * FROM opciones a left join opciones_usuarios b on a.id=b.opcion where a.tipo_opcion=5 and a.opcion_padre='RI00' and b.usuario='".$idUsuario."'");
        $cont=0;
        $cantRegistros=mysqli_num_rows($verOpcionesAnalistaRI);
        if ($cantRegistros>0){
          ?>
          <div class='btn-group'>
            <button type='button' class='btn btn-warning'>Registrar</button>
            <button type='button' class='btn btn-warning dropdown-toggle' data-toggle='dropdown' aria-expanded='true'>
              <span class='caret'></span>
              <span class='sr-only'>Toggle Dropdown</span>
            </button>
            <ul class='dropdown-menu' role='menu'>
              <?php
              while($resul = mysqli_fetch_assoc($verOpcionesAnalistaRI)){
                $cont++;
                ?>
                <li><a name='<?php echo $resul["id"];?>' id='<?php echo $resul["ruta"];?>'><?php echo $resul["descripcion"];?></a></li>
                <?php
                if ($cont<>$cantRegistros){?>
                  <li class='divider'></li> 
                  <?php
                }
              }
              ?>
            </ul>
          </div>
          <?php
        }

        mysqli_next_result($con);
        $verOpcionesAnalistaBI =mysqli_query($con,"SELECT * FROM opciones a left join opciones_usuarios b on a.id=b.opcion where a.tipo_opcion=5 and a.opcion_padre='BI00' and b.usuario='".$idUsuario."'");
        $cont=0;
        $cantRegistros=mysqli_num_rows($verOpcionesAnalistaBI);
        if ($cantRegistros>0){
          ?>
          <div class='btn-group'>
            <input type="hidden" id="tipoConsultaBuscar">
            <button type='button' class='btn btn-warning'>Buscar</button>
            <button type='button' class='btn btn-warning dropdown-toggle' data-toggle='dropdown' aria-expanded='true'>
              <span class='caret'></span>
              <span class='sr-only'>Toggle Dropdown</span>
            </button>
            <ul class='dropdown-menu' role='menu'>
              <?php
              while($resul = mysqli_fetch_assoc($verOpcionesAnalistaBI)){
                $cont++;
                ?>
                <li><a name='<?php echo $resul["id"];?>' id='<?php echo $resul["ruta"];?>'><?php echo $resul["descripcion"];?></a></li>
                <?php
                if ($cont<>$cantRegistros){
                  ?>
                  <li class='divider'></li> 
                  <?php
                }
              }
              ?>
            </ul>
          </div>
          <?php
        }

        mysqli_next_result($con);
        $verOpcionesAnalistaAI =mysqli_query($con,"SELECT * FROM opciones a left join opciones_usuarios b on a.id=b.opcion where a.tipo_opcion=5 and a.opcion_padre='AI00' and b.usuario='".$idUsuario."'");
        $cont=0;
        $cantRegistros=mysqli_num_rows($verOpcionesAnalistaAI);
        if ($cantRegistros>0){
          ?>
          <div class='btn-group'>
            <input type="hidden" id="tipoConsultaBuscar">
            <button type='button' class='btn btn-warning'>Autorizar</button>
            <button type='button' class='btn btn-warning dropdown-toggle' data-toggle='dropdown' aria-expanded='true'>
              <span class='caret'></span>
              <span class='sr-only'>Toggle Dropdown</span>
            </button>
            <ul class='dropdown-menu' role='menu'>
              <?php
              while($resul = mysqli_fetch_assoc($verOpcionesAnalistaAI)){
                $cont++;
                ?>
                <li><a name='<?php echo $resul["id"];?>' id='<?php echo $resul["ruta"];?>'><?php echo $resul["descripcion"];?></a></li>
                <?php
                if ($cont<>$cantRegistros){
                  ?>
                  <li class='divider'></li> 
                  <?php
                }
              }
              ?>
            </ul>
          </div>
          <?php
        }
        ?>
        <br><br>
        <link rel="stylesheet" type="text/css" href="dist/css/contact-form.css">
        <div class="divOcultar" id="DivAsignarCensosAnalista" style="display: none;">
          <div class="row">
            <div class="tab-content">
              <div class="col-sm-12">
                <div class="item-wrap">
                  <div class="row">
                    
                    <div class="col-sm-12">
                      <div class="item-content colBottomMargin">
                        <div class="item-info">
                          <h2 class="item-title text-center">ASIGNAR CENSOS ANALISTA</h2>
                        </div>                    
                       </div>
                    </div>
                    <?php 
                    $hoy = date("Y-m-d");
                    $maxEntrega = date('Y-m-d', strtotime($hoy.'+ 15 days'));
                    
                    ?>
                    <div class="col-md-12">
                      <form id="formularioAsignarCensoAnlista" name="formularioAsignarCensoAnlista" data-toggle="validator" class="popup-form contactForm">
                        <div class="row"> 
                          <div class="col-sm-3">
                            <label for="">Aseguradora</label>
                            <div class="form-group">
                              <div class="help-block with-errors"></div>
                              <select name="aseguradoraCensoAnalista" id="aseguradoraCensoAnalista" class="form-control" required data-error="Seleccione aseguradora">
                                <option value="">Seleccione</option>
                                <?php 
                                mysqli_next_result($con);
                                $verAmparo =mysqli_query($con,"SELECT * FROM aseguradoras WHERE vigente='s';");
                                while($resul = mysqli_fetch_assoc($verAmparo)){ ?>
                                  <option value="<?php echo $resul['id']; ?>">
                                    <?php echo $resul['nombre_aseguradora']; ?>               
                                  </option>
                                  <?php 
                                } ?>
                              </select>
                              <div class="input-group-icon"><i class="fa fa-car"></i></div> 
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <label for="">F. Entrega/Cargue</label>
                            <div class="form-group">
                              <div class="help-block with-errors"></div>
                              <input type="date" name="fEntregaCensoAnalista" id="fEntregaCensoAnalista" class="form-control" value="<?=$hoy;?>" min="<?=$hoy;?>" max="<?=$maxEntrega;?>" required data-error="Escoja Fecha de Entrega">
                              <div class="input-group-icon"><i class="fa fa-calendar"></i></div> 
                            </div>
                          </div>

                          <div class="col-sm-3">
                            <label for="">Cargar Plantilla</label>
                            <div class="form-group">
                              <div class="help-block with-errors"></div>
                              <input name="excelCensoAnalista" id="excelCensoAnalista" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" type="file" size="150" class="form-control" required data-error="Por favor suba el Archivo">
                              <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                            </div>
                          </div>

                          <div class="col-sm-2">                            
                            <label for=""></label>
                            <div class="form-group last">
                              <button type="submit" id="btnAsignarCensoAnlistas" class="btn btn-custom"><i class='fa fa-envelope'></i> Asignar</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 table-responsive">
                      <table id="tablaCasosAsignarAnalista" class="table table-striped display table table-hover" cellspacing="0" width="100%">
                        <thead style="background-color: #193456; color: white;">
                          <tr>
                            <th>N°</th>
                            <th>Codigo</th>
                            <th>Placa</th>
                            <th>Fecha Accidente</th>
                            <th>Analista</th>
                            <th>Aseguradora</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="divOcultar" id="DivRegistrarCensoInvestigador" style="display: none;">
          <div class="row">
            <div class="tab-content">
              <div class="col-sm-12">
                <div class="item-wrap">
                  <div class="row">
                    
                    <div class="col-sm-12">
                      <div class="item-content colBottomMargin">
                        <div class="item-info">
                          <h2 class="item-title text-center">NUEVO CENSO INVESTIGADOR</h2>
                        </div>                    
                       </div>
                    </div>

                    <div class="col-md-12">
                      <form id="formularioCensoInv" name="formularioCensoInv" data-toggle="validator" class="popup-form contactForm">
                        <div class="row"> 
                          <div class="col-sm-4">
                            <input type="hidden" name="id_investigador" value="<?=$_SESSION ["id_relacionado"]?>">
                            <label for="">Aseguradora</label>
                            <div class="form-group ">
                              <div class="help-block with-errors"></div>
                              <select id="ciAseguradora" name="aseguradora" class="form-control select2" required data-error="Por favor Seleccione Aseguradora" style="width: 100%;">
                                <option value="">Seleccione</option>
                                <?php 
                                mysqli_next_result($con);
                                $verAmparo =mysqli_query($con,"SELECT * FROM aseguradoras WHERE vigente='s';");
                                while($resul = mysqli_fetch_assoc($verAmparo)){ ?>
                                  <option value="<?php echo $resul['id']; ?>">
                                    <?php echo $resul['nombre_aseguradora']; ?>               
                                  </option>
                                  <?php 
                                } ?>
                              </select>
                              <div class="input-group-icon"><i class="fa fa-user"></i></div>
                            </div>
                          </div>

                          <div class="col-sm-4">
                            <label for="">Tipo Caso</label>
                            <div class="form-group">
                              <div class="help-block with-errors"></div>
                              <select name="tipo_caso" id="ciTipoCaso" class="form-control" required data-error="Seleccione Tipo Caso" style="width: 100%;">
                                <option value="">Seleccione</option>
                              </select>
                              <div class="input-group-icon"><i class="fa fa-user"></i></div>
                            </div>
                          </div>

                          <div class="col-sm-4">
                            <label for="">Fecha Accidente</label>
                            <div class="form-group">
                              <div class="help-block with-errors"></div>
                              <input name="fecha_accidente" id="ciFechaAccidente" placeholder="Fecha Accidente*" class="form-control" type="date" required data-error="Por favor ingresa Fecha Accidente">
                              <div class="input-group-icon"><i class="fa fa-phone"></i></div> 
                            </div>
                          </div>

                          <div class="col-sm-3">
                            <label for="">Fecha Conocido</label>
                            <div class="form-group">
                              <div class="help-block with-errors"></div>
                              <input name="fecha_conocimiento" id="ciFechaConocimiento" placeholder="Fecha Conocimiento*" class="form-control" type="date" required data-error="Por favor ingresa Fecha Conocimiento">
                              <div class="input-group-icon"><i class="fa fa-phone"></i></div> 
                            </div>
                          </div>

                          <div class="col-sm-2">
                            <label for="">Placa</label>
                            <div class="form-group">
                              <div class="help-block with-errors"></div>
                              <input name="placa" id="ciPlaca" placeholder="Num Placa*" class="form-control" type="text" required data-error="Por favor ingrese la Placa"> 
                              <div class="input-group-icon"><i class="fa fa-user"></i></div>
                            </div>
                          </div>

                          <div class="col-sm-3">
                            <label for="">Poliza</label>
                            <div class="form-group">
                              <div class="help-block with-errors"></div>
                              <input name="poliza" id="ciPoliza" placeholder="Num Poliza*" class="form-control" type="text" required data-error="Por favor ingrese la Poliza"> 
                              <div class="input-group-icon"><i class="fa fa-user"></i></div>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <label for="">Ciudad</label>
                            <div class="form-group">
                              <div class="help-block with-errors"></div>
                              <select name="ciudad" id="ciCiudad" class="form-control select2" required data-error="Por favor Seleccione Ciudad" style="width: 100%;">
                                <option value="">Seleccione</option>
                                <?php 
                                mysqli_next_result($con);
                                $consultarCiudad="SELECT CONCAT(b.nombre,'-',a.nombre,' (',a.codigo_dane,')') AS ciudad, a.id FROM ciudades a LEFT JOIN departamentos b ON b.id = a.id_departamento";
                                $verCiudad=mysqli_query($con,$consultarCiudad);
                                while($resul = mysqli_fetch_assoc($verCiudad)){ ?>
                                  <option value="<?=$resul['id']; ?>"> <?=$resul['ciudad'];?> </option>
                                  <?php 
                                } ?>
                              </select>
                              <div class="input-group-icon"><i class="fa fa-user"></i></div>
                            </div>
                          </div>

                          <div class="col-sm-4">
                            <label for="">Lugar Accidente</label>
                            <div class="form-group">
                              <div class="help-block with-errors"></div>
                              <input name="lugar_accidente" id="ciLugarAccidente" placeholder="lugar Accidente*" class="form-control" type="text" required data-error="Por favor ingrese Lugar de Accidente"> 
                              <div class="input-group-icon"><i class="fa fa-user"></i></div>
                            </div>
                          </div>

                          <div class="col-sm-4">
                            <label for="">IPS/Clínica</label>
                            <div class="form-group">
                              <div class="help-block with-errors"></div>
                              <select name="ips" id="ciIps" class="form-control select2" required data-error="Por favor Seleccione IPS" style="width: 100%;">
                                <option value="0">Seleccione</option>
                                <?php 
                                mysqli_next_result($con);
                                $consultarClinica="SELECT CONCAT(nombre_ips,' (',identificacion,')') AS ips,id FROM ips WHERE vigente='s';";
                                $verClinica=mysqli_query($con,$consultarClinica);
                                while($resul2 = mysqli_fetch_assoc($verClinica)){?>
                                  <option value="<?=$resul2['id']?>"><?=$resul2['ips']?></option>
                                  <?php 
                                }?>
                              </select>
                              <div class="input-group-icon"><i class="fa fa-user"></i></div>
                            </div>
                          </div>

                          <div class="col-sm-2">
                            <label for="">Ambulancia</label>
                            <div class="form-group">
                              <div class="help-block with-errors"></div>
                              <select name="id_servicio_ambulancia" id="ciServicioAmbulancia" class="form-control" required data-error="Seleccione Si o No" style="width: 100%;">
                                <option value="">Seleccione</option>
                                <option value="s">SI</option>
                                <option value="n">NO</option>
                              </select>
                              <div class="input-group-icon"><i class="fa fa-user"></i></div>
                            </div>
                          </div>

                          <div class="col-sm-2">
                            <label for="">Traslado</label>
                            <div class="form-group">
                              <div class="help-block with-errors"></div>
                              <select disabled name="tipo_traslado" id="ciTipoTraslado" class="form-control" data-error="Seleccione Si o No" style="width: 100%;">
                                <option value="">Seleccione</option>
                                <option value="1">Primario</option>
                                <option value="2">Secundario</option>
                              </select>
                              <div class="input-group-icon"><i class="fa fa-user"></i></div>
                            </div>
                          </div>

                          <div class="col-sm-4">
                            <label for="">Lugar Traslado</label>
                            <div class="form-group">
                              <div class="help-block with-errors"></div>
                              <input disabled name="lugar_raslado" id="ciLugarTraslado" placeholder="lugar Traslado*" class="form-control" type="text" data-error="Por favor ingrese Lugar de Traslado"> 
                              <div class="input-group-icon"><i class="fa fa-user"></i></div>
                            </div>
                          </div>

                          <div class="col-sm-12">
                            <div class="panel panel-default">
                              <div class="panel-heading">INGRESAR LESIONADOS</div>
                              <div class="panel-body">
                                <div class="col-sm-2">
                                  <label for="">Tipo Doc:</label>
                                  <div class="form-group">
                                    <div class="help-block with-errors"></div>
                                    <select id="ciLesTipoIdentificacion" class="form-control select2" required data-error="Seleccione Tipo Doc" style="width: 100%;">
                                      <option value="0">Seleccione</option>
                                      <?php 
                                      mysqli_next_result($con);
                                      $consultarTipoDoc="SELECT id, descripcion, descripcion2 FROM definicion_tipos WHERE id_tipo=5";
                                      $filasTipoDoc=mysqli_query($con,$consultarTipoDoc);
                                      while($row = mysqli_fetch_assoc($filasTipoDoc)){?>
                                        <option value="<?=$row['id']?>"><?=$row['descripcion'].' - '.$row['descripcion2']?></option>
                                        <?php 
                                      }?>
                                    </select>
                                    <div class="input-group-icon"><i class="fa fa-user"></i></div>
                                  </div>
                                </div>

                                <div class="col-sm-3">
                                  <label for="">Identificación</label>
                                  <div class="form-group">
                                    <div class="help-block with-errors"></div>
                                    <input id="ciLesIdentificacion" placeholder="Identificación Lesionado*" class="form-control" type="text" data-error="Por favor ingresa tu Identificacion "> 
                                    <div class="input-group-icon"><i class="fa fa-user"></i></div>
                                  </div>
                                </div>

                                <div class="col-sm-3">
                                  <label for="">Nombre</label>
                                  <div class="form-group">
                                    <div class="help-block with-errors"></div>
                                    <input id="ciLesNombre" placeholder="Nombres Lesionado*" class="form-control" type="text" data-error="Por favor ingresa Nombres 1"> 
                                    <div class="input-group-icon"><i class="fa fa-user"></i></div>
                                  </div>
                                </div>

                                <div class="col-sm-3">
                                  <label for="">Apellidos</label>
                                  <div class="form-group">
                                    <div class="help-block with-errors"></div>
                                    <input id="ciLesApellidos" placeholder="Apellidos Lesionado*" class="form-control" type="text" data-error="Por favor ingresa Apellidos 1"> 
                                    <div class="input-group-icon"><i class="fa fa-user"></i></div>
                                  </div>
                                </div>
                                <div class="col-sm-1">
                                  <div class="form-group">
                                    <a onclick="ciAgregarLesionado(1);" class="btn btn-block btn-primary" id="ciBtnAddLesionado"><span class="fa fa-plus"></span></a>
                                  </div>
                                </div>

                                <table class="table col-sm-12" style="border-top: solid 1px #0f9c05">
                                  <thead class="thead-dark">
                                    <tr>
                                      <th colspan="5" class="text-center">LESIONADOS DEL ACCIDENTE</th>
                                    </tr>
                                    <tr>
                                      <th scope="col" width="10" class="text-center"><span class="fa fa-list"></span></th>
                                      <th scope="col">Tipo Id.</th>
                                      <th scope="col">Identif.</th>
                                      <th scope="col">Nombres</th>
                                      <th scope="col">Apellidos</th>
                                    </tr>
                                  </thead>
                                  <tbody id="ciTableLesionados">
                                    <!--<tr>
                                      <td>
                                        <div class='btn-group'>
                                          <button type='button' class='btn btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='true'>
                                            <span class='caret'></span>
                                            <span class='sr-only'>Toggle Dropdown</span>
                                          </button>
                                          <ul class='dropdown-menu' role='menu' style="background-color: #fbf0e4;">
                                            <li><a name='btnEditTablaLes' id='1'>Editar</a></li>
                                            <li class='divider'></li> 
                                            <li><a name='btnElimTablaLes' id='1'>Remover</a></li>
                                          </ul>
                                        </div>
                                      </td>
                                      <td>1046816737</td>
                                      <td>Andy José</td>
                                      <td>Peña</td>
                                    </tr>-->
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>

                          <!--<div class="form-group col-sm-6">
                            <div class="help-block with-errors"></div>
                            <input name="email" id="email" placeholder="Tu E-mail*" pattern=".*@\w{2,}\.\w{2,}" class="form-control" type="email" required data-error="Por favor ingresa un correo electrónico válido">
                            <div class="input-group-icon"><i class="fa fa-envelope"></i></div>
                          </div>-->

                          <div class="col-sm-12">
                            <label for="">Observaciones</label>
                            <div class="form-group">
                              <div class="help-block with-errors"></div>
                              <textarea rows="2" name="observaciones" id="ciObservaciones" placeholder="Escribe aquí las observaciones" class="form-control"></textarea>
                              <div class="textarea input-group-icon"><i class="fa fa-pencil"></i></div>
                            </div>
                          </div>

                          <div class="col-sm-12">
                            <div class="form-group last">
                              <button type="submit" id="btnEnviarCensoInvestigador" class="btn btn-custom"><i class='fa fa-envelope'></i> Enviar</button>
                            </div>
                          </div>
                      
                          <span class="sub-text">* Campos requeridos</span>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="divOcultar" id="DivBuscarCensoInvestigador" style="display: none;">
          <div class="row">
            <div class="tab-content">
              <div class="col-sm-12">
                <div class="item-wrap">
                  <div class="row">
                    
                    <div class="col-sm-12">
                      <div class="item-content colBottomMargin">
                        <div class="item-info">
                          <h2 class="item-title text-center">BUSCAR CENSO INVESTIGADOR</h2>
                        </div>                    
                       </div>
                    </div>

                    <div class="col-md-12">
                      <form role="form" id="frmBusqCensosInvestigador" class="popup-form contactForm">
                        <div class="row"> 

                          <div class="col-md-2">
                            <label for="ciBuscarCodigo">Codigo</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="ciBuscarCodigo" placeholder="Codigo">
                                <div class="input-group-icon"><i class="fa fa-user"></i></div>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <label for="ciBuscarPlaca">Placa</label>
                            <div class="form-group">
                              <input type="text" class="form-control" id="ciBuscarPlaca" placeholder="Placa">
                              <div class="input-group-icon"><i class="fa fa-user"></i></div>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <label for="ciBuscarPoliza">Poliza</label>
                            <div class="form-group">
                              <input type="text" class="form-control" id="ciBuscarPoliza" placeholder="Poliza">
                              <div class="input-group-icon"><i class="fa fa-user"></i></div>
                            </div>
                          </div>

                          <div class="col-md-4">
                            <label for="ciBuscarInvestigador">Investigador</label>
                            <div class="form-group">                              
                              <select id="ciBuscarInvestigador" style="width: 100%;" class="form-control select2" >
                                <option value="">SELECCIONE</option>
                                <?php 
                                mysqli_next_result($con);
                                $consultarInvestigador="SELECT id, CONCAT(nombres, ' ', apellidos) AS nombre_investigador, nombres, apellidos FROM investigadores WHERE vigente = 's'";
                                $verInvestigador=mysqli_query($con,$consultarInvestigador);
                                while($ri = mysqli_fetch_assoc($verInvestigador)){ ?>
                                  <option value="<?=$ri['id']?>">
                                    <?=$ri['nombre_investigador']. " (".$ri['id'].")"?>
                                  </option>
                                  <?php 
                                } ?>
                              </select>
                              <div class="input-group-icon"><i class="fa fa-user"></i></div>
                            </div>
                          </div>

                          <div class="col-md-4">
                            <label for="ciBuscarNombre">Nombre</label>
                            <div class="form-group">
                              <input type="text" class="form-control CampText" id="ciBuscarNombre" placeholder="Nombre">
                              <div class="input-group-icon"><i class="fa fa-user"></i></div>
                            </div>
                          </div>

                          <div class="col-md-4">
                            <label for="ciBuscarIdentificacion">Identificacion</label>
                            <div class="form-group">
                              <input type="text" class="form-control CampNum" id="ciBuscarIdentificacion" placeholder="Identificación">
                              <div class="input-group-icon"><i class="fa fa-user"></i></div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <a  id="btnBuscarCensoInv" class="btn btn-primary">Buscar</a>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="divOcultar" id="DivTablaGestionCensosInvestigador" style="display: none;">
          <div id="DivTablas100">
            <table id="tablaGestionCensosInvestigador" class="display" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th style="width:350px;" width="350px">General</th>
                  <th style="width:350px;" width="350px">Victima</th>
                  <th style="width:350px;" width="350px">Siniestro</th>
                  <th style="width:300px;" width="300px">Opciones</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>

        <div class="divOcultar" id="DivTablaGestionCasosSOAT" style="display: none;">
          <div id="DivTablas14">
            <table id="tablaGestionCasosSOAT" class="display" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th style="width:350px;" width="350px">General</th>
                  <th style="width:350px;" width="350px">Victima</th>
                  <th style="width:350px;" width="350px">Siniestro</th>
                  <th style="width:300px;" width="300px">Opciones</th>
                  <th style="width:300px;" width="300px">IdInvestigacion</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>

        <div class="divOcultar" id="DivTablaGestionCasosValidacionesIPS" style="display: none;">
          <div id="DivTablas23">
            <table id="tablaGestionCasosValidacionesIPS" class="display" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th style="width:350px;" width="350px">General</th>
                  <th style="width:350px;" width="350px">IPS</th>
                  <th style="width:350px;" width="350px">Representante Legal</th>
                  <th style="width:300px;" width="300px">Opciones</th>
                  <th style="width:300px;" width="300px">IdInvestigacion</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>

        <div class="divOcultar" id="DivTablaGestionCasosValidacionesIPSHistorico" style="display: none;">
          <div id="DivTablas23">
            <table id="tablaGestionCasosValidacionesIPSHistorico" class="display" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th style="width:350px;" width="350px">General</th>
                  <th style="width:350px;" width="350px">IPS</th>
                  <th style="width:350px;" width="350px">Representante Legal</th>
                  <th style="width:300px;" width="300px">Opciones</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>

        <div class="divOcultar" id="DivTablaGestionCasosSOATHistorico" style="display: none;">
          <div id="DivTablas14">
            <table id="tablaGestionCasosSOATHistorico" class="display" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th style="width:350px;" width="350px">General</th>
                  <th style="width:350px;" width="350px">Victima</th>
                  <th style="width:350px;" width="350px">Siniestro</th>
                  <th style="width:300px;" width="300px">Opciones</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>

        <div class="divOcultar" id="DivRegistrarProcesosJuridicos" style="display: none;">
          <div class="row">
            <div class="tab-content">
              <div class="col-sm-12">
                <div class="item-wrap">
                  <div class="row">
                            
                    <div class="col-sm-12">
                      <div class="item-content colBottomMargin">
                        <div class="item-info">
                          <h2 class="item-title text-center tituloPjRegistrar" id="lblTituloPj">REGISTRAR PROCESO JURIDICO</h2>
                        </div>                    
                      </div>
                    </div>
                    <div class="col-md-12">
                      <form id="formularioRegistrarProcesoJuridico" name="formularioRegistrarProcesoJuridico" data-toggle="validator" class="popup-form contactForm">
                        <input type="text" value="" id="idProcesoJuridico" style="display:none;">
                        <div class="row">
                          <div class="col-sm-3 divAseguradoraProcesos divOcultarProcesos" style="">
                            <label for="">Aseguradora</label>
                            <div class="form-group">
                              <input type="text" id="idAseguradoraEditar" style="display:none;">
                              <div class="help-block with-errors"></div>
                              <select name="aseguradorasProcesoJudicial" id="aseguradorasProcesoJudicial" class="form-control" required data-error="Seleccione aseguradora">
                                <option value="">Seleccione</option>
                                <?php 
                                mysqli_next_result($con);
                                $aseguradoras =mysqli_query($con,"SELECT a.id, a.nombre_aseguradora FROM aseguradoras a ORDER BY a.id DESC ");
                                while($resul = mysqli_fetch_assoc($aseguradoras)){ ?>
                                  <option value="<?php echo $resul['id']; ?>">
                                    <?php echo $resul['nombre_aseguradora']; ?>               
                                  </option>
                                  <?php 
                                } ?>
                              </select>
                              <div class="input-group-icon"><i class="fa fa-list"></i></div> 
                            </div>
                          </div>

                          <div class="col-sm-3 divTipoCasoProcesos divOcultarProcesos" style="">
                            <label for="">Tipo de caso</label>
                            <div class="form-group">
                              <input type="text" id="idTipocasoEditar" style="display:none;">
                              <div class="help-block with-errors"></div>
                              <select name="tipoCasoProcesoJudicial" id="tipoCasoProcesoJudicial" class="form-control" required data-error="Seleccione un tipo de caso">
                                <option value="">Seleccione</option>
                              </select>
                              <div class="input-group-icon"><i class="fa fa-list"></i></div> 
                            </div>
                          </div>

                          <div class="col-sm-3 divOcultarProcesos" style="">
                            <label for="">Poliza</label>
                            <div class="form-group">
                              <div class="help-block with-errors"></div>
                              <input type="text" placeholder="Ingrese la poliza" class="form-control" required data-error="Ingrese la poliza" id="pjPoliza">
                              <div class="input-group-icon"><i class="fa fa-car"></i></div> 
                            </div>
                          </div>

                          <div class="col-sm-3 divOcultarProcesos" style="">
                            <label for="">Siniestro</label>
                            <div class="form-group">
                              <div class="help-block with-errors"></div>
                              <input type="text" placeholder="Numero de siniestro" class="form-control" required data-error="Numero de siniestro" id="pjSiniestro">
                              <div class="input-group-icon"><i class="fa fa-car"></i></div> 
                            </div>
                          </div>

                          <div class="col-sm-3 divOcultarProcesos">
                            <label for="">Fecha Siniestro</label>
                            <div class="form-group">
                              <div class="help-block with-errors"></div>
                              <input name="fecha_accidente_procesos" id="fecha_accidente_procesos" placeholder="Fecha Siniestro" class="form-control" type="date" required data-error="Por favor ingresa Fecha Siniestro">
                              <div class="input-group-icon"><i class="fa fa-calendar"></i></div> 
                            </div>
                          </div>

                          <div class="col-sm-3 divOcultarProcesos" style="">
                            <label for="">Ciudad</label>
                            <div class="form-group">
                              <div class="help-block with-errors"></div>
                              <select name="ciudadProcesoJudicial" id="ciudadProcesoJudicial" class="form-control select2" required data-error="Seleccione una ciudad" style="width: 100%;">
                                <option value="">Seleccione</option>
                                <?php 
                                  mysqli_next_result($con);
                                  $CiudadProcesos =mysqli_query($con,"SELECT CONCAT(b.nombre,'-',a.nombre,' (',a.codigo_dane,')') AS ciudad,a.id FROM ciudades a LEFT JOIN departamentos b ON b.id = a.id_departamento;");
                                  while($resul = mysqli_fetch_assoc($CiudadProcesos)){ ?>
                                    <option value="<?=$resul['id']?>">
                                      <?=$resul['ciudad']?>
                                    </option>
                                    <?php 
                                  } 
                                ?>
                              </select>
                              <div class="input-group-icon"><i class="fa fa-list"></i></div> 
                            </div>
                          </div>

                          <div class="col-sm-3 divOcultarProcesos" style="" id="divPjPlaca">
                            <label for="">Placa</label>
                            <div class="form-group">
                              <div class="help-block with-errors"></div>
                              <input type="text" placeholder="Placa del vehiculo" class="form-control" data-error="Placa del vehiculo" id="pjPlaca" onkeyup="javascript:this.value=this.value.toUpperCase();">
                              <div class="input-group-icon"><i class="fa fa-car"></i></div> 
                            </div>
                          </div>

                          <div class="col-sm-3 divOcultarProcesos" style="display:none" id="divPjArticulo">
                            <label for="">Articulo</label>
                            <div class="form-group">
                              <div class="help-block with-errors"></div>
                              <input type="text" placeholder="Articulo de siniestro" class="form-control" data-error="Articulo de siniestro" id="pjArticulo">
                              <div class="input-group-icon"><i class="fa fa-car"></i></div> 
                            </div>
                          </div>

                          <div class="col-sm-12 divOcultarProcesos" style="">
                            <div class="panel panel-default">
                              <div class="panel-heading">ASEGURADO</div>
                                <div class="panel-body">
                                  <div class="row">

                                    <div class="col-sm-3">
                                      <label for="">Tipo identificación</label>
                                      <div class="form-group">
                                        <div class="help-block with-errors"></div>
                                        <select name="pjTipoId" id="pjTipoId" class="form-control" required data-error="Seleccione un tipo de identificación">
                                          <?php 
                                            mysqli_next_result($con);
                                            $tiposIdentificacion =mysqli_query($con,"SELECT * FROM definicion_tipos d WHERE d.id_tipo = 5");
                                            while($resul = mysqli_fetch_assoc($tiposIdentificacion)){ ?>
                                              <option value="<?=$resul['id']?>">
                                                <?=$resul['descripcion']?> - <?=$resul['descripcion2']?>
                                              </option>
                                              <?php 
                                            } 
                                          ?>
                                        </select>
                                        <div class="input-group-icon"><i class="fa fa-list"></i></div> 
                                      </div>
                                    </div>

                                    <div class="col-sm-3">
                                      <label for="">Identificación</label>
                                      <div class="form-group">
                                        <div class="help-block with-errors"></div>
                                        <input type="text" id="pjIdPersona" style="display:none;">
                                        <input type="text" placeholder="Numero de indentificación" class="form-control" required data-error="Digite el numero de indentificación" id="pjId">
                                        <div class="input-group-icon"><i class="fa fa-user"></i></div> 
                                      </div>
                                    </div>

                                    <div class="col-sm-3">
                                      <label for="">Nombres</label>
                                      <div class="form-group">
                                        <div class="help-block with-errors"></div>
                                        <input type="text" placeholder="Nombres del asegurado" class="form-control" required data-error="Digite el nombre del asegurado" id="pjNombres" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                        <div class="input-group-icon"><i class="fa fa-user"></i></div> 
                                      </div>
                                    </div>

                                    <div class="col-sm-3">
                                      <label for="">Apellidos</label>
                                      <div class="form-group">
                                        <div class="help-block with-errors"></div>
                                        <input type="text" placeholder="Apellidos del asegurado" class="form-control" required data-error="Digite los apellidos del asegurado" id="pjApellidos" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                        <div class="input-group-icon"><i class="fa fa-user"></i></div> 
                                      </div>
                                    </div>

                                  </div>
                                </div>
                              </div>
                          </div>

                          <div class="col-sm-12 divOcultarProcesos" style="">
                            <div class="panel panel-default">
                              <div class="panel-heading">INFORME</div>
                                <div class="panel-body">
                                  <div class="row">
                                    <div class="col-sm-5">
                                      <label for="">Cargar informe</label>
                                      <div class="form-group">
                                        <div class="help-block with-errors"></div>
                                        <input type="text" value="" id="nombreArchivoActual" style="display:none;">
                                        <input name="subirInformeProcesoJudicial" id="subirInformeProcesoJudicial" type="file" size="150" class="form-control" required data-error="Por favor suba el Archivo" value="">
                                        <div class="input-group-icon"><i class="fa  fa-file-pdf-o"></i></div> 
                                      </div>
                                    </div>
                                    <div class="col-sm-7" style="display:none;" id="divInfoEditar">
                                      <div class="alert alert-info alert-dismissible">
                                        <h4><i class="icon fa fa-info"></i> Importante!</h4>
                                        En caso de que no necesite cambiar el informe no seleccione ningun archivo.
                                      </div>
                                    </div>
                                  </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        
                        <div class="col-sm-3 col-xs-12 pull-left">                            
                          <label for=""></label>
                          <div class="form-group last">
                            <button type="button" id="btnCancelarEdicion" class="btn btn-custom" style="width: 100%;display: none;background-color: #fff;color:#000"><i class='fa fa-close'></i> Cancelar</button>
                          </div>
                        </div>

                        <div class="col-sm-3 col-xs-12 pull-right">                            
                          <label for=""></label>
                          <div class="form-group last">
                            <button type="submit" id="btnRegistrarProcesoJuridico" class="btn btn-custom" style="width: 100%;"><i class='fa fa-send'></i> Registrar</button>
                            <button type="submit" id="btnEditarProcesoJuridico" class="btn btn-custom" style="width: 100%;display: none;"><i class='fa fa-send'></i> Editar</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><!--fin divRegistrarProcesosJuridicos-->

        <div class="divOcultar" id="DivTablaProcesosJuridicos" style="display: none;">
          <div class="row">
            <div class="tab-content">
              <div class="col-sm-12">
                <div class="item-wrap">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="table-responsive">
                        <table id="tablaProcesosJuridicos" class="table table-striped display table table-hover" cellspacing="0" width="100%">
                          <thead style="background-color: #193456; color: white;">
                            <tr>
                              <th class="text-center" width="30%">General</th>
                              <th class="text-center" width="30%">Asegurado</th>
                              <th class="text-center" width="30%">Siniestro</th>
                              <th class="text-center" width="10%">Opciones</th>
                            </tr>
                          </thead>
                          <tbody id="cuerpoTablaProcesosJudiciales">
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><!--fin tabla procesos juridicos-->

        <!-- FIRMA AUDITORIAS TELEFONICAS-->

        <div class="divOcultar" id="DivEntrevistaVirtual" style="display: none;">
          <div class="row">
            <div class="tab-content">
              <div class="col-sm-12">
                <div class="item-wrap">
                  <div class="row">
                            
                    <div class="col-sm-12">
                      <div class="item-content colBottomMargin">
                        <div class="item-info">
                          <h2 class="item-title text-center">ENTREVISTA VIRTUAL</h2>
                        </div>                    
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <form id="formularioEntrevistaVirtual" name="formularioEntrevistaVirtual" data-toggle="validator" class="popup-form contactForm">
                        
                          
                        <div class="row">

                          <div class="col-sm-3 divOcultarProcesos" style="" id="divEvPlaca">
                            <label for="">Placa</label>
                            <div class="form-group">
                              <div class="help-block with-errors"></div>
                              <input type="text" placeholder="Placa del vehiculo" class="form-control" data-error="Placa del vehiculo" id="EvPlaca" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                              <div class="input-group-icon"><i class="fa fa-car"></i></div> 
                            </div>
                          </div>

                          <div class="col-sm-3 divOcultarProcesos" style="" id="divEvPoliza">
                            <label for="">Poliza</label>
                            <div class="form-group">
                              <div class="help-block with-errors"></div>
                              <input type="text" placeholder="Poliza del vehiculo" class="form-control" data-error="Poliza del vehiculo" id="EvPoliza" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                              <div class="input-group-icon"><i class="fa fa-car"></i></div> 
                            </div>
                          </div>

                          <div class="col-sm-3 divOcultarProcesos">
                            <label for="">Fecha Siniestro</label>
                            <div class="form-group">
                              <div class="help-block with-errors"></div>
                              <input name="fecha_accidente_entrevista" id="fecha_accidente_entrevista" placeholder="Fecha Accidente" class="form-control" type="date" required data-error="Por favor ingresa Fecha Accidente">
                              <div class="input-group-icon"><i class="fa fa-calendar"></i></div> 
                            </div>
                          </div>

                          <div class="col-sm-3 divOcultarProcesos">
                            <label for="">Codigo</label>
                            <div class="form-group">
                              <div class="help-block with-errors"></div>
                              <input type="text" required placeholder="Codigo Interno" class="form-control" data-error="Codigo Interno" id="EvCodigo" onkeyup="javascript:this.value=this.value.toUpperCase();">
                              <div class="input-group-icon"><i class="fa fa-car"></i></div> 
                            </div>
                          </div>
                        </div><!--FIN ROW-->


                        <div class="row">
                          <div class="col-sm-6 divOcultarProcesos" style="">
                            <div class="panel panel-default">
                              <div class="panel-heading">ENTREVISTADO</div>
                                <div class="panel-body">
                                  <div class="row">

                                    <div class="col-sm-6">
                                      <label for="">Identificación</label>
                                      <div class="form-group">
                                        <div class="help-block with-errors"></div>
                                        <input type="text" placeholder="Numero de indentificación" class="form-control" required data-error="Digite el numero de indentificación" id="evId">
                                        <div class="input-group-icon"><i class="fa fa-user"></i></div> 
                                      </div>
                                    </div>

                                    <div class="col-sm-6">
                                      <label for="">Nombre</label>
                                      <div class="form-group">
                                        <div class="help-block with-errors"></div>
                                        <input type="text" placeholder="Nombre del entrevistado" class="form-control" required data-error="Digite el nombre del entrevistado" id="evNombres" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                        <div class="input-group-icon"><i class="fa fa-user"></i></div> 
                                      </div>
                                    </div>

                                  </div>
                                </div>
                              </div>
                          </div><!--ENTREVISTADO-->

                          <!--LESIONADO-->
                          <div class="col-sm-6 divOcultarProcesos" style="">
                            <div class="panel panel-default">
                              <div class="panel-heading">LESIONADO</div>
                                <div class="panel-body">
                                  <div class="row">
                                    <div class="col-sm-6">
                                      <label for="">Identificación</label>
                                      <div class="form-group">
                                        <div class="help-block with-errors"></div>
                                        <input type="text" placeholder="Numero de indentificación" class="form-control" required data-error="Digite el numero de indentificación" id="evLId">
                                        <div class="input-group-icon"><i class="fa fa-user"></i></div> 
                                      </div>
                                    </div>

                                    <div class="col-sm-6">
                                      <label for="">Nombre</label>
                                      <div class="form-group">
                                        <div class="help-block with-errors"></div>
                                        <input type="text" placeholder="Nombres del asegurado" class="form-control" required data-error="Digite el nombre del lesionado" id="evLNombres" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                        <div class="input-group-icon"><i class="fa fa-user"></i></div> 
                                      </div>
                                    </div>

                                  </div>
                                </div>
                              </div>
                          </div><!-- fin lesionado-->

                          <!--TOMADOR-->
                          <div class="col-sm-6 divOcultarProcesos" style="">
                            <div class="panel panel-default">
                              <div class="panel-heading">TOMADOR</div>
                                <div class="panel-body">
                                  <div class="row">

                                    <div class="col-sm-6">
                                      <label for="">Identificación</label>
                                      <div class="form-group">
                                        <div class="help-block with-errors"></div>
                                        <input type="text" placeholder="Numero de indentificación" class="form-control" required data-error="Digite el numero de indentificación" id="evtId">
                                        <div class="input-group-icon"><i class="fa fa-user"></i></div> 
                                      </div>
                                    </div>

                                    <div class="col-sm-6">
                                      <label for="">Nombre</label>
                                      <div class="form-group">
                                        <div class="help-block with-errors"></div>
                                        <input type="text" placeholder="Nombres del tomador" class="form-control" required data-error="Digite el nombre del tomador" id="evtNombres" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                        <div class="input-group-icon"><i class="fa fa-user"></i></div> 
                                      </div>
                                    </div>

                                  </div>
                                </div>
                              </div>
                          </div><!-- fin tomador-->


                        </div>


                        <div class="col-sm-3 col-xs-12">                            
                          <label for=""></label>
                          <div class="form-group last">
                            <button type="reset" id="btnListarEntrevistas" class="btn btn-warning" style="width: 100%;" onclick="abrirModalFirmas()"><i class='fa fa-list-ul'></i> Firmas</button>
                          </div>
                        </div>

                        <div class="col-sm-3 col-xs-12 pull-right">                            
                          <label for=""></label>
                          <div class="form-group last">
                            <button type="submit" id="btnRegistrarEntrevista" class="btn btn-custom" style="width: 100%;"><i class='fa fa-send'></i> Registrar</button>
                          </div>
                        </div>
                      </form>  
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- FIN AUDITORIAS TELEFONICAS-->

        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modalEntrevistaVirtual">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="titulomodal">FIRMAS</h4>
              </div>
              <div class="modal-body">
                <input type="text" name="link" style="display: none;" id="LinkTemp">
                <table class="table table-striped table-hover table-bordered">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>ENTREVISTADO</th>
                      <th>FIRMADO</th>
                      <th>FECHA FIRMA</th>
                      <th><span class="glyphicon glyphicon-eye-open"></span></th>
                    </tr>
                  </thead>
                  <tbody id="datosEntrevistaVirtual">
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- fin modal entrevista virtual-->
        
      </div>
    </div>
  </div>
</div>