<div class="row">
  <div class="nav-tabs-custom">
    <div class="col-md-4">
      <div id="tabModuloReportes">
        <div class="btn-group-vertical">
          <?php
          mysqli_next_result($con);
          $verOpcionesAnalistaVR =mysqli_query($con,"SELECT * FROM opciones a left join opciones_usuarios b on a.id=b.opcion where a.tipo_opcion=5 and a.opcion_padre='VR00' and b.usuario='".$idUsuario."'");
          $cont=0;
          $cantRegistros=mysqli_num_rows($verOpcionesAnalistaVR);
          if ($cantRegistros>0){
            while($resul = mysqli_fetch_assoc($verOpcionesAnalistaVR)){
              $cont++;?>
              <a id="<?php echo $resul['ruta'];?>" class="btn btn-primary"><?php echo $resul["descripcion"];?></a>
              <?php
            }
          }?>
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="tab-content">
        <div  style="display:none;" id="div-btnCargarConsolidados" name="divBtnModuloReportes">
          <div class="box-body">
            <div class="form-group col-sm-9  col-sm-offset-1">
              <div class="row">
                <div class="col-md-9 col-sm-offset-1">
                  <div class="form-group">
                    <label for="exampleInput">Fecha Entrega</label>
                    <input type="text" readonly="readonly" class="form-control formFechas CamNum" id="fechaEntregaCargarConsolidados" placeholder="Fecha Entrega">
                  </div>
                </div>
                <div class="col-md-9 col-sm-offset-1">
                  <div class="form-group">
                    <input name="consolidadoMultimedia" id="consolidadoMultimedia" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" type="file" size="150" class="btn btn-block btn-success" required="">
                  </div>
                </div>  
                <div class="col-md-9 col-sm-offset-1" id="divOpcionesTipoCargue">
                  <div class="box box-solid box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Tipo de Cargue</h3>
                    </div>
                    <div class="box-body">
                      <div class="row">
                        <div class="form-group col-sm-9">
                          <?php
                          mysqli_next_result($con);
                          $verOpcionesAnalistaTR =mysqli_query($con,"SELECT * FROM opciones a left join opciones_usuarios b on a.id=b.opcion where a.tipo_opcion=5 and a.opcion_padre='CS00' and b.usuario='".$idUsuario."'");
                          $cont=0;
                          $cantRegistrosTR=mysqli_num_rows($verOpcionesAnalistaTR);

                          if ($cantRegistrosTR>0){

                            while($resul = mysqli_fetch_assoc($verOpcionesAnalistaTR)){
                              $cont++;
                              ?>
                              <label>
                                <input type="radio" name="radioCargueConsolidados" id="<?php echo $resul['ruta'];?>" value="<?php echo $resul['ruta'];?>">
                                <?php echo $resul["descripcion"];?>
                              </label>
                              <?php
                            }
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group col-sm-9 col-sm-offset-1">
                  <a class="btn btn-success btn-block" id="btnSubirConsolidados">Cargar Consolidados</a>
                  <input type="hidden" id="exeTab">
                </div>
              </div>  
            </div>
          </div>
        </div>
        <div  style="display:none;" id="div-btnReporteInvestigaciones" name="divBtnModuloReportes">
          <div class="box-body">
            <div class="form-group col-sm-9  col-sm-offset-1">
              <div class="row">
                <div class="form-group col-sm-12">
                  <label for="">Aseguradora:</label>
                  <select id="idAseguradoraReporteBasico" class="form-control select2" style="width: 100%;">
                    <option value="0">SELECCIONE UN VALOR</option>
                    <?php 
                    mysqli_next_result($con);
                    $verAmparo =mysqli_query($con,"CALL manejoAseguradoras(6,'','','','','','','','','','','','',@resp)");
                    while($resul = mysqli_fetch_assoc($verAmparo)){
                      ?>
                      <option value="<?php echo $resul['id']; ?>">
                        <?php echo $resul['nombre_aseguradora']; ?>               
                      </option>
                      <?php 
                    }
                    ?>
                  </select>
                </div>  
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInput">Fecha Inicio</label>
                    <input type="text" readonly="readonly" class="form-control formFechas CamNum" id="fechaInicioReporteBasico" placeholder="Fecha Inicio">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInput">Fecha Fin</label>
                    <input type="text" readonly="readonly" class="form-control formFechas CamNum" id="fechaFinReporteBasico" placeholder="Fecha Fin">
                  </div>
                </div>
                <div class="col-md-12" id="divOpcionesTipoReporte">
                  <div class="box box-solid box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Tipo de Reporte</h3>
                    </div>
                    <div class="box-body">
                      <div class="row">
                        <div class="form-group col-sm-6">
                          <?php
                          mysqli_next_result($con);
                          $verOpcionesAnalistaTR =mysqli_query($con,"SELECT * FROM opciones a left join opciones_usuarios b on a.id=b.opcion where a.tipo_opcion=5 and a.opcion_padre='TR00' and b.usuario='".$idUsuario."'");
                          $cont=0;
                          $cantRegistrosTR=mysqli_num_rows($verOpcionesAnalistaTR);

                          if ($cantRegistrosTR>0){
                            while($resul = mysqli_fetch_assoc($verOpcionesAnalistaTR)){
                              $cont++;?>
                              <label>
                                <input type="radio" name="radioReportsBasicos" id="<?php echo $resul['ruta'];?>" value="<?php echo $resul['ruta'];?>">
                                <?php echo $resul["descripcion"];?>
                              </label>
                              <br>
                              <?php
                            }
                          }
                          ?>
                        </div>
                        <div class="form-group col-sm-6">
                          <div id="selectTipoCasoRegistroDiario" style="display:none;">
                            <label for="">Tipo de Caso:</label>
                            <select id="tipoCasoReporteBasico" class="form-control select2" style="width: 100%;">
                            </select>
                          </div>
                        </div>
                        <div id="selectAnalistasVigentes" style="display:none;">
                          <div class="form-group col-sm-6">
                            <label for="">Analistas:</label>
                            <select id="analistaReporteBasico" class="form-control select2" style="width: 100%;">
                              <option value="0">TODOS LOS ANALISTAS</option>
                              <?php 
                              mysqli_next_result($con);
                              $consultarAnalistas="CALL consultasBasicas(13)";
                              $verAnalista=mysqli_query($con,$consultarAnalistas);
                              while($resul = mysqli_fetch_assoc($verAnalista)){?>
                                <option value="<?php echo $resul['id']; ?>">
                                  <?php echo $resul['nombre_usuario']; ?>                                               
                                </option>
                                <?php 
                              }?>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group col-sm-12">
                  <button class="btn btn-success btn-block" id="btnGenerarReportes">Generar Reporte</button>
                  <button class="btn btn-danger btn-block" id="btnCorregirErrores" style="display:none">Corregir Errores</button>
                  <input type="hidden" id="exeTab">
                </div>
              </div>  
            </div>

          </div>
        </div>
        <div  style="display:none;" id="div-btnReporteInvestigacionesAseguradora" name="divBtnModuloReportes">
          <div class="box-body">
            <?php
            mysqli_next_result($con);
            $consultarUsuarioAseguradora="SELECT * FROM usuarios WHERE id='".$idUsuario."' and tipo_usuario=4";
            $queryTipoUsuarioAseguradora =mysqli_query($con,$consultarUsuarioAseguradora);
            if (mysqli_num_rows($queryTipoUsuarioAseguradora)>0)
            {
              $resTipoUsuarioAseguradora = mysqli_fetch_assoc($queryTipoUsuarioAseguradora);
              $idAseguradora=$resTipoUsuarioAseguradora['id_aseguradora'];
              ?>
              <input type="hidden" class="form-control" id="inputIdAseguradoraReporteBasico" value="<?php echo $idAseguradora;?>">
              <?php
            }?>
            <div class="col-md-3 col-md-offset-3">
              <div class="form-group">
                <label for="exampleInput">Fecha Inicio</label>
                <input readonly="readonly" type="text" class="form-control formFechas CamNum" id="fechaInicioReporteBasicoAseguradora" placeholder="Fecha Inicio">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="exampleInput">Fecha Fin</label>
                <input type="text" readonly="readonly" class="form-control formFechas CamNum" id="fechaFinReporteBasicoAseguradora" placeholder="Fecha Fin">
              </div>
            </div>
            <div class="col-md-6 col-md-offset-3" id="divOpcionesTipoReporteAseguradora">
              <div class="box box-solid box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Tipo de Reporte</h3>
                </div>
                <div class="box-body">
                  <div class="row">
                    <div class="form-group col-sm-6">
                      <?php
                      mysqli_next_result($con);
                      $sqlAseguradoraUsu="SELECT * FROM usuarios WHERE id =".$_SESSION['id'];
                      $obtenerAseguradoraUsu =mysqli_query($con,$sqlAseguradoraUsu);
                      $datosAseguradoraUsu = mysqli_fetch_assoc($obtenerAseguradoraUsu);
                      $idAseguradora = $datosAseguradoraUsu['id_aseguradora'];

                      $consultarReporteBasicoAseguradora="CALL manejoAseguradoraAmparoTarifas (17,'".$idAseguradora."','','','','','','','','','','','',@resp)";
                      $queryReporteBasicoAseguradora =mysqli_query($con,$consultarReporteBasicoAseguradora);
                      if (mysqli_num_rows($queryReporteBasicoAseguradora)>0){?>
                        <label>
                          <input type="radio" name="radioReportsBasicosAseguradora" id="radioReportRegistroDiarioAseguradora" value="radioReportRegistroDiarioAseguradora">
                          REGISTRO DIARIO
                        </label>
                        <br>
                        <?php    
                      }
                      mysqli_next_result($con);
                      $consultarReporteArcPlanoAseguradora="CALL manejoAseguradoraAmparoTarifas (18,'".$idAseguradora."','','','','','','','','','','','',@resp)";
                      $queryReporteArcPlanoAseguradora =mysqli_query($con,$consultarReporteArcPlanoAseguradora);
                      if (mysqli_num_rows($queryReporteArcPlanoAseguradora)>0){?>
                        <label>
                          <input type="radio" name="radioReportsBasicosAseguradora" id="radioReportArchivoPlanoAseguradora" value="radioReportArchivoPlanoAseguradora">
                          ARCHIVO PLANO
                        </label>
                        <br>
                        <?php    
                      }
                      ?>
                    </div>
                    <div class="form-group col-sm-6">
                      <div id="selectTipoCasoRegistroDiarioAseguradora" style="display:none;">
                        <label for="">Tipo de Caso:</label>
                        <select id="tipoCasoReporteBasicoAseguradora" class="form-control select2" style="width: 100%;">
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group col-sm-6 col-sm-offset-3">
              <a class="btn btn-success btn-block" id="btnGenerarReportesAseguradora">Generar Reporte</a>
              <input type="hidden" id="exeTab">
            </div>
          </div>
        </div>

        <div  style="display:none;" id="div-btnDescargaMasivaInformes" name="divBtnModuloReportes">
          <div class="box-body">
            <div class="form-group col-sm-9  col-sm-offset-1">
              <div class="row">
                <div class="form-group col-sm-12">
                  <label for="">Aseguradora:</label>
                  <select id="idAseguradoraDescargaInformes" class="form-control select2" style="width: 100%;">
                    <option value="0">SELECCIONE UN VALOR</option>
                    <?php 
                    mysqli_next_result($con);
                    $verAmparo =mysqli_query($con,"CALL manejoAseguradoras(6,'','','','','','','','','','','','',@resp)");
                    while($resul = mysqli_fetch_assoc($verAmparo)){?>
                      <option value="<?php echo $resul['id']; ?>">
                        <?php echo $resul['nombre_aseguradora']; ?>               
                      </option>
                      <?php 
                    }
                    ?>
                  </select>
                </div>  

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInput">Fecha Inicio</label>

                    <input type="text" readonly="readonly" class="form-control formFechas CamNum" id="fechaInicioDescargaInformes" placeholder="Fecha Inicio">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInput">Fecha Fin</label>
                    <input type="text" readonly="readonly" class="form-control formFechas CamNum" id="fechaFinDescargaInformes" placeholder="Fecha Fin">
                  </div>
                </div>

                <div class="col-md-12" id="divOpcionesTipoReporte">
                  <div class="box box-solid box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Parametros</h3>
                    </div>
                    <div class="box-body">
                      <div class="row">
                        <div id="selectTipoCasoRegistroDiario">
                          <div class="form-group col-sm-6">
                            <label for="">Tipo de Caso:</label>
                            <select id="tipoCasoDescargaInformes" class="form-control select2" style="width: 100%;">
                            </select>
                          </div>
                        </div>
                        <div class="form-group col-sm-4">
                          <label for="">Opciones:</label>
                          <select id="opcionesDescargaInformes" class="form-control select2" style="width: 100%;">
                            <option value="0">TODOS</option>
                            <option value="1">ATENDER</option>
                            <option value="2">NO ATENDER</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group col-sm-12">
                  <a class="btn btn-success btn-block" id="btnDescargarInformes">Descargar Informes</a>
                  <input type="hidden" id="exeTab">
                </div>
              </div>  
            </div>
          </div>
        </div>
        <div  style="display:none;" id="div-btnDescargaMasivaInformesAseguradora" name="divBtnModuloReportes">
          <div class="box-body">
            <div class="form-group col-sm-9  col-sm-offset-1">
              <div class="row">
                <?php
                mysqli_next_result($con);
                $consultarUsuarioAseguradora="SELECT * FROM usuarios WHERE id='".$idUsuario."' and tipo_usuario=4";
                $queryTipoUsuarioAseguradora =mysqli_query($con,$consultarUsuarioAseguradora);
                if (mysqli_num_rows($queryTipoUsuarioAseguradora)>0)
                {
                  $resTipoUsuarioAseguradora = mysqli_fetch_assoc($queryTipoUsuarioAseguradora);
                  $idAseguradora=$resTipoUsuarioAseguradora['id_aseguradora'];
                  ?>
                  <input type="hidden" class="form-control" id="inputIdAseguradoraReporteBasico" value="<?php echo $idAseguradora;?>">
                  <?php    
                }
                ?>
                <div class="col-md-3 col-md-offset-3">
                  <div class="form-group">
                    <label for="exampleInput">Fecha Inicio</label>
                    <input type="text" readonly="readonly" class="form-control formFechas CamNum" id="fechaInicioDescargaInformesAseguradora" placeholder="Fecha Inicio">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="exampleInput">Fecha Fin</label>
                    <input type="text" readonly="readonly" class="form-control formFechas CamNum" id="fechaFinDescargaInformesAseguradora" placeholder="Fecha Fin">
                  </div>
                </div>
                <div class="col-md-12" id="divOpcionesTipoReporte">
                  <div class="box box-solid box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Parametros</h3>
                    </div>
                    <div class="box-body">                        
                      <div class="row">
                        <div id="selectTipoCasoRegistroDiario">
                          <div class="form-group col-sm-6">
                            <label for="">Tipo de Caso:</label>
                            <label for="">Tipo de Caso:</label>
                            <select id="tipoCasoDescargaInformesAseguradora" class="form-control select2" style="width: 100%;">
                              <option value="0">SELECCIONE UN VALOR</option>
                              <?php
                              mysqli_next_result($con);
                              $consultarTipoCasos="CALL manejoAseguradoraAmparoTarifas (17,'".$idAseguradora."','','','','','','','','','','','',@resp)";
                              $queryTipoCasos=mysqli_query($con,$consultarTipoCasos);
                              while ($resTipoCasos=mysqli_fetch_assoc($queryTipoCasos))
                              {
                                ?>
                                <option value='<?php echo $resTipoCasos['id'];?>'><?php echo $resTipoCasos["descripcion"];?></option>
                                <?php
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group col-sm-4">
                          <label for="">Opciones:</label>
                          <select id="opcionesDescargaInformesAseguradora" class="form-control select2" style="width: 100%;">
                            <option value="0">TODOS</option>
                            <option value="1">ATENDER</option>
                            <option value="2">NO ATENDER</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group col-sm-12">
                  <a class="btn btn-success btn-block" id="btnDescargarInformesAseguradora">Descargar Informes</a>
                  <input type="hidden" id="exeTab">
                </div>

              </div>
            </div>
          </div>
        </div>
        
        <div  style="display:none;" id="div-btnReportarCargue" name="divBtnModuloReportes">
          <div class="box-body">
            <div class="form-group col-sm-9  col-sm-offset-1">
              <div class="row">
                
                <div class="col-md-9 col-sm-offset-1">
                  <div class="form-group">
                    <input name="planoReporteCargue" id="planoReporteCargue" accept="text/plain" type="file" size="150" class="btn btn-block btn-success" required="">
                  </div>
                </div>

                <div class="form-group col-sm-9 col-sm-offset-1">
                  <a class="btn btn-success btn-block" id="btnSubirReportarCargue">REPORTAR CARGUE</a>
                </div>
              </div>  
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div id="DivReporteDiarioSOAT" name="divReportes" style="display:none;">
      <div id="DivTablas4">
        <table id="tablaReporteDiarioSOAT" class="display" cellspacing="0" width="100%">
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div id="DivReporteDiarioValidaciones" name="divReportes" style="display:none;">
      <div id="DivTablas4">
        <table id="tablaReporteDiarioValidacionesIPS" class="display" cellspacing="0" width="100%">
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div id="DivbtnReporteInvestigaciones" name="divReportes" style="display:none;">
      <div id="DivTablas4">
        <table id="tablaReporteCargueInformes" class="display" cellspacing="0" width="100%">
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div id="DivbtnReporteArcPlanoCensoMundial" name="divReportes" style="display:none;">
      <div id="DivTablas4">
        <table id="tablaArcPlanoCensoMundial" class="display" cellspacing="0" width="100%">
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div id="DivbtnReporteArcPlanoCensoMundialAmpliacion" name="divReportes" style="display:none;">
      <div id="DivTablas4">
        <table id="tablaArcPlanoCensoMundialAmpliacion" class="display" cellspacing="0" width="100%">
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div id="DivbtnReporteArcPlanoCensoAsignadoMundial" name="divReportes" style="display:none;">
      <div id="DivTablas4">
        <table id="tablaArcPlanoCensoAsignadoMundial" class="display" cellspacing="0" width="100%">
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div id="DivbtnReporteArcPlanoCensoEstado" name="divReportes" style="display:none;">
      <div id="DivTablas4">
        <table id="tablaArcPlanoCensoEstado" class="display" cellspacing="0" width="100%">
        </table>
      </div>
    </div>
  </div>


  <div class="col-md-12">
    <div id="DivbtnReporteArcPlanoSIRASEstado" name="divReportes" style="display:none;">
      <div id="DivTablas4">
        <table id="tablaArcPlanoSIRASEstado" class="display" cellspacing="0" width="100%">
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div id="DivbtnReporteArcPlanoCensoEquidad" name="divReportes" style="display:none;">
      <div id="DivTablas4">
        <table id="tablaArcPlanoCensoEquidad" class="display" cellspacing="0" width="100%">
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div id="DivbtnReporteArcPlanoCensoSolidaria" name="divReportes" style="display:none;">
      <div id="DivTablas4">
        <table id="tablaArcPlanoCensoSolidaria" class="display" cellspacing="0" width="100%">
        </table>
      </div>
    </div>
  </div>


   <div class="col-md-12">
    <div id="DivbtnReporteArcPlanoCensoAsignadoSolidaria" name="divReportes" style="display:none;">
      <div id="DivTablas4">
        <table id="tablaArcPlanoCensoAsignadoSolidaria" class="display" cellspacing="0" width="100%">
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div id="DivbtnReporteArcPlanoGastosMedicosMundial" name="divReportes" style="display:none;">
      <div id="DivTablas4">
        <table id="tablaArcPlanoGastosMedicosMundial" class="display" cellspacing="0" width="100%">
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div id="DivbtnReporteArcPlanoGastosMedicosMundialAmpliacion" name="divReportes" style="display:none;">
      <div id="DivTablas4">
        <table id="tablaArcPlanoGastosMedicosMundialAmpliacion" class="display" cellspacing="0" width="100%">
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div id="DivbtnReporteArcPlanoMuerteMundial" name="divReportes" style="display:none;">
      <div id="DivTablas4">
        <table id="tablaArcPlanoMuerteMundial" class="display" cellspacing="0" width="100%">
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div id="DivbtnReporteArcPlanoMuerteMundialAmpliacion" name="divReportes" style="display:none;">
      <div id="DivTablas4">
        <table id="tablaArcPlanoMuerteMundialAmpliacion" class="display" cellspacing="0" width="100%">
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div id="DivbtnReporteArcPlanoIncapacidadPermanenteMundial" name="divReportes" style="display:none;">
      <div id="DivTablas4">
        <table id="tablaArcPlanoIncapacidadPermanenteMundial" class="display" cellspacing="0" width="100%">
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div id="DivbtnReporteAsignacionInvestigador" name="divReportes" style="display:none;">
      <div id="DivTablas4">
        <table id="tablaReporteAsignacionInvestigador" class="display" cellspacing="0" width="100%">
        </table>
      </div>
    </div>
  </div>


  <div class="col-md-12">
    <div id="DivbtnReporteAsignacionInvestigadorMok" name="divReportes" style="display:none;">
      <div id="DivTablas4">
        <table id="tablaReporteAsignacionInvestigadorMok" class="display" cellspacing="0" width="100%">
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div id="DivbtnReporteAsignacionAnalistas" name="divReportes" style="display:none;">
      <div id="DivTablas4">
        <table id="tablaReporteAsignacionAnalistas" class="display" cellspacing="0" width="100%">
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div id="DivbtnReporteRegistroCasosSIRAS" name="divReportes" style="display:none;">
      <div id="DivTablas4">
        <table id="tablaRegistroCasosSIRAS" class="display" cellspacing="0" width="100%">
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div id="DivbtnReporteCasosDiariosAnalista" name="divReportes" style="display:none;">
      <div id="DivTablas4">
        <table id="tablaReporteCasosDiariosAnalista" class="display" cellspacing="0" width="100%">
        </table>
      </div>
    </div>
  </div>
</div>

 <div class="col-md-12">
    <div id="DivbtnReporteArcPlanoCensoSolidaria2" name="divReportes" style="display:none;">
      <div id="DivTablas4">
        <table id="tablaArcPlanoCensoSolidaria2" class="display" cellspacing="0" width="100%">
        </table>
      </div>
    </div>
  </div>


   <div class="col-md-12">
    <div id="DivbtnReporteArcPlanoCensoAsignadoSolidaria2" name="divReportes" style="display:none;">
      <div id="DivTablas4">
        <table id="tablaArcPlanoCensoAsignadoSolidaria2" class="display" cellspacing="0" width="100%">
        </table>
      </div>
    </div>
  </div>



     <div class="col-md-12">
    <div id="DivbtnReporteArcPlanoGastosMedicosSolidaria" name="divReportes" style="display:none;">
      <div id="DivTablas4">
        <table id="tablaArcPlanoGastosMedicosSolidaria" class="display" cellspacing="0" width="100%">
        </table>
      </div>
    </div>
  </div>





     <div class="col-md-12">
    <div id="DivbtnReporteArcPlanoMuerteSolidaria" name="divReportes" style="display:none;">
      <div id="DivTablas4">
        <table id="tablaArcPlanoMuerteSolidaria" class="display" cellspacing="0" width="100%">
        </table>
      </div>
    </div>
  </div>



   <div class="col-md-12">
    <div id="DivbtnReporteArcPlanoIncapacidadesSolidaria" name="divReportes" style="display:none;">
      <div id="DivTablas4">
        <table id="tablaArcPlanoIncapacidadesSolidaria" class="display" cellspacing="0" width="100%">
        </table>
      </div>
    </div>
  </div>


<div class="col-md-12">
    <div id="DivbtnReporteInvestigacionesAutorizadasFacturacion" name="divReportes" style="display:none;">
      <div id="DivTablas4">
        <table id="tablaReporteInvestigacionesAutorizadasFacturacion" class="display" cellspacing="0" width="100%">
        </table>
      </div>
    </div>
  </div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalMostrarErrores" role="dialog" >

  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary" style="background: rgb(220, 20, 60); color: white;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Hay Errores</h4>
      </div>
      <div class="modal-body">
        <div class="callout callout-warning disabled" id="calloutSimilitud" style="display: none">
          <h4 id="textoSimilitud"></h4>
        </div>
        <div class="table-responsive">
         <table class="table table-hover table-borderer table-condensed center" id="tablaCorregirErrores">
          <thead>
            <tr>
              <th class="text-center">Codigo</th>
              <th class="text-center">EPS</th>
            </tr>
          </thead>
          <tbody id="tablaMostrarErrores">
           
          </tbody>
        </table>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" id="btnActualizarEps">Guardar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>