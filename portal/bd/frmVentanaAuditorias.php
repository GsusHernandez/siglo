<link rel="stylesheet" type="text/css" href="dist/css/contact-form.css">
<div class="row">

  <div class="col-md-12">
    <div class="nav-tabs-custom">
      <ul style="font-weight: bold;" class="nav nav-tabs">
        <li id="tabNuevaAuditoria" class="active"><a href="#tab_1_nueva" data-toggle="tab">NUEVA AUDITORIA</a></li>
        <li id="tabReportesAuditorias"><a href="#tab_2_reportes" data-toggle="tab">REPORTES</a></li>
      </ul>

      <!----INICIO--->
      <div class="tab-content">
        <div class="tab-pane active" id="tab_1_nueva">
          <div class="item-wrap">
            <form id="frmNuevaAuditoria" data-toggle="validator" class="popup-form contactForm">
              <input type="hidden" value="<?=$_SESSION['id']?>">
              <div class="row">
                <div class="col-md-2 col-sm-3">
                  <label for="">Tipo Doc</label>
                  <div class="form-group">
                    <select id="au_tipoDoc" name="au_tipoDoc" class="form-control selectRequerido" data-error="Seleccione Tipo Doc" style="width: 100%;">
                      <option value="0">Seleccione</option>
                      <?php
                      mysqli_next_result($con);
                      $consultarTipoDoc = "SELECT id, descripcion, descripcion2 FROM definicion_tipos WHERE id_tipo=5";
                      $filasTipoDoc = mysqli_query($con, $consultarTipoDoc);
                      while ($row = mysqli_fetch_assoc($filasTipoDoc)) { ?>
                        <option value="<?= $row['id'] ?>"><?= $row['descripcion'] . ' - ' . $row['descripcion2'] ?></option>
                      <?php
                      } ?>
                    </select>
                    <div class="input-group-icon"><i class="fa fa-user"></i></div>
                  </div>
                </div>

                <div class="col-md-2 col-sm-3">
                  <label for="">Identificación</label>
                  <div class="form-group">
                    <input id="au_identificacion" name="au_identificacion" placeholder="Identificación" class="form-control requerido" type="text" maxlength="11">
                    <div class="input-group-icon"><i class="fa fa-user"></i></div>
                  </div>
                </div>

                <div class="col-md-2 col-sm-3">
                  <label for="">Nombres</label>
                  <div class="form-group">
                    <input id="au_nombre" name="au_nombre" placeholder="Nombres" class="form-control requerido" type="text" data-error="Por favor ingresa Nombres">
                    <div class="input-group-icon"><i class="fa fa-user"></i></div>
                  </div>
                </div>

                <div class="col-md-2 col-sm-3">
                  <label for="">Apellidos</label>
                  <div class="form-group">
                    <input id="au_apellidos" name="au_apellidos" placeholder="Apellidos" class="form-control requerido" type="text">
                    <div class="input-group-icon"><i class="fa fa-user"></i></div>
                  </div>
                </div>

                <div class="col-md-2 col-sm-3">
                  <label for="">Correo</label>
                  <div class="form-group">
                    <input id="au_email" name="au_email" placeholder="Correo Electronico" class="form-control requerido" type="email" style="width: 100%;">
                    <div class="input-group-icon"><i class="fa fa-user"></i></div>
                  </div>
                </div>

                <div class="col-md-2 col-sm-3">
                  <label for="">Telefono</label>
                  <div class="form-group">
                    <input id="au_telefono" name="au_telefono" placeholder="Telefono" class="form-control requerido" type="text" style="width: 100%;">
                    <div class="input-group-icon"><i class="fa fa-user"></i></div>
                  </div>
                </div>

                <div class="col-md-2 col-sm-3">
                  <label for="">Placa</label>
                  <div class="form-group">
                    <input name="au_placa" id="au_placa" placeholder="Placa" class="form-control requerido" type="text">
                    <div class="input-group-icon"><i class="fa fa-user"></i></div>
                  </div>
                </div>

                <div class="col-md-2 col-sm-3">
                  <label for="">Poliza</label>
                  <div class="form-group">
                    <input name="au_poliza" id="au_poliza" placeholder="Poliza" class="form-control requerido" type="text">
                    <div class="input-group-icon"><i class="fa fa-user"></i></div>
                  </div>
                </div>

                <div class="col-md-2 col-sm-3">
                  <label for="">Aseguradora</label>
                  <div class="form-group">
                    <select name="au_aseguradora" id="au_aseguradora" class="form-control selectRequerido" style="width: 100%;">
                      <option value="0">Seleccione</option>
                      <?php
                      mysqli_next_result($con);
                      $verAmparo = mysqli_query($con, "SELECT * FROM aseguradoras WHERE vigente='s';");
                      while ($resul = mysqli_fetch_assoc($verAmparo)) { ?>
                        <option value="<?php echo $resul['id']; ?>">
                          <?php echo $resul['nombre_aseguradora']; ?>
                        </option>
                      <?php
                      } ?>
                    </select>
                    <div class="input-group-icon"><i class="fa fa-car"></i></div>
                  </div>
                </div>

                <div class="col-md-2 col-sm-3">
                  <label for="">Tipo Caso</label>
                  <div class="form-group">
                    <select name="au_tipocaso" id="au_tipocaso" class="form-control selectRequerido select2" style="width: 100%;">
                      <option value="0">Seleccione</option>
                    </select>
                    <div class="input-group-icon"><i class="fa fa-user"></i></div>
                  </div>
                </div>

                <div class="col-md-2 col-sm-3">
                  <label for="">Fecha Accidente</label>
                  <div class="form-group">
                    <input name="au_fAccidente" id="au_fAccidente" class="form-control requerido" type="date" data-error="Ingresar Fecha Accidente">
                    <div class="input-group-icon"><i class="fa fa-calendar-o"></i></div>
                  </div>
                </div>

                <div class="col-md-2 col-sm-3">
                  <label for="">Tipo Entrevistado</label>
                  <div class="form-group">
                    <select name="au_tpEntrevistado" id="au_tpEntrevistado" class="form-control selectRequerido" style="width: 100%;">
                      <option value="0">Seleccione</option>
                      <option value="1">TOMADOR</option>
                      <option value="2">LESIONADO</option>
                      <option value="3">FAMILIAR</option>
                      <option value="4">CONDUCTOR</option>
                      <option value="5">PROPIETARIO</option>
                    </select>
                    <div class="input-group-icon"><i class="fa fa-globe"></i></div>
                  </div>
                </div>

                <div class="col-md-2 col-sm-3">
                  <label for="">Lesionado</label>
                  <div class="form-group">
                    <input name="au_lesionado" id="au_lesionado" placeholder="Nombre del Lesionado" class="form-control requerido" type="text">
                    <div class="input-group-icon"><i class="fa fa-user"></i></div>
                  </div>
                </div>

                <div class="col-md-2 col-sm-3">
                  <label for="">Condicion</label>
                  <div class="form-group">
                    <input name="au_condicion" id="au_condicion" placeholder="Condicion" class="form-control requerido" type="text">
                    <div class="input-group-icon"><i class="fa fa-user"></i></div>
                  </div>
                </div>


                <div class="col-md-2 col-sm-3">
                  <label for="">Ciudad Ocurrencia</label>
                  <div class="form-group">
                    <select name="au_ciudad_ocurrencia" id="au_ciudad_ocurrencia" class="form-control selectRequerido" style="width: 100%;">
                      <option value="0">Seleccione</option>
                      <?php
                      mysqli_next_result($con);
                      $consultarCiudad = "CALL consultasBasicas(1)";
                      $verCiudad = mysqli_query($con, $consultarCiudad);
                      while ($resul = mysqli_fetch_assoc($verCiudad)) { ?>
                        <option value="<?php echo $resul['id']; ?>">
                          <?php echo $resul['ciudad']; ?>
                        </option>
                      <?php
                      } ?>
                    </select>
                    <div class="input-group-icon"><i class="fa fa-car"></i></div>
                  </div>
                </div>

                <div class="col-md-2 col-sm-4">
                  <label for=""> </label>
                  <button type="submit" class="btn btn-block btn-success" id="au_solicitarFirma">Firmar <span class="fa fa-edit"></span></a></button>
                </div>

                <div class="col-md-2 col-sm-4">
                  <label for=""> </label>
                  <button type="button" class="btn btn-block btn-primary" id="au_limpiar">Limpiar <span class="fa fa-eraser"></span></a></button>
                </div>

            </form>
          </div>
        </div>
      </div>


      <div class="tab-pane" id="tab_2_reportes">
        <div class="item-wrap">
          <form id="formConsultarAuditorias" data-toggle="validator" class="popup-form contactForm">
            <div class="row">

              <div class="col-sm-2">
                <label for="">Identificación</label>
                <div class="form-group">
                  <div class="help-block with-errors"></div>
                  <input id="auc_identificacion" name="auc_identificacion" placeholder="Identificación" class="form-control requerido" type="text" maxlength="15">
                  <div class="input-group-icon"><i class="fa fa-user"></i></div>
                </div>
              </div>

              <div class="col-sm-2">
                <label for="">Nombre</label>
                <div class="form-group">
                  <div class="help-block with-errors"></div>
                  <input id="auc_nombre" name="auc_nombre" placeholder="Nombres" class="form-control requerido" type="text" data-error="Por favor ingresa Nombres">
                  <div class="input-group-icon"><i class="fa fa-user"></i></div>
                </div>
              </div>

              <div class="col-sm-2">
                <label for="">Apellidos</label>
                <div class="form-group">
                  <div class="help-block with-errors"></div>
                  <input id="auc_apellidos" name="auc_apellidos" placeholder="Apellidos" class="form-control requerido" type="text">
                  <div class="input-group-icon"><i class="fa fa-user"></i></div>
                </div>
              </div>

              <div class="col-sm-2">
                <label for="">Placa</label>
                <div class="form-group">
                  <div class="help-block with-errors"></div>
                  <input name="auc_placa" id="auc_placa" placeholder="Placa" class="form-control requerido" type="text">
                  <div class="input-group-icon"><i class="fa fa-user"></i></div>
                </div>
              </div>

              <div class="col-sm-2">
                <label for="">Poliza</label>
                <div class="form-group">
                  <div class="help-block with-errors"></div>
                  <input name="auc_poliza" id="auc_poliza" placeholder="Poliza" class="form-control requerido" type="text">
                  <div class="input-group-icon"><i class="fa fa-user"></i></div>
                </div>
              </div>

              <div class="col-sm-2">
                <label for="">Aseguradora</label>
                <div class="form-group">
                  <div class="help-block with-errors"></div>
                  <select name="auc_aseguradora" id="auc_aseguradora" class="form-control selectRequerido">
                    <option value="0">Seleccione</option>
                    <?php
                    mysqli_next_result($con);
                    $verAmparo = mysqli_query($con, "SELECT * FROM aseguradoras WHERE vigente='s';");
                    while ($resul = mysqli_fetch_assoc($verAmparo)) { ?>
                      <option value="<?php echo $resul['id']; ?>">
                        <?php echo $resul['nombre_aseguradora']; ?>
                      </option>
                    <?php
                    } ?>
                  </select>
                  <div class="input-group-icon"><i class="fa fa-car"></i></div>
                </div>
              </div>

              <div class="col-md-2">
                <label for="">Tipo Caso</label>
                <div class="form-group">
                  <div class="help-block with-errors"></div>
                  <select name="auc_tipocaso" id="auc_tipocaso" class="form-control selectRequerido select2" style="width: 100%;">
                    <option value="0">TODOS</option>
                  </select>
                  <div class="input-group-icon"><i class="fa fa-user"></i></div>
                </div>
              </div>

              <div class="col-md-2">
                <label for="">Estado</label>
                <div class="form-group">
                  <div class="help-block with-errors"></div>
                  <select name="auc_estado" id="auc_estado" class="form-control selectRequerido select2" style="width: 100%;">
                    <option value="">TODOS</option>
                    <option value="0">CREADA</option>
                    <option value="1">CORREO ENVIADO</option>
                    <option value="2">FIRMADA</option>
                  </select>
                  <div class="input-group-icon"><i class="fa fa-user"></i></div>
                </div>
              </div>

              <div class="col-md-2">
                <label for="">Fecha de Creacion</label>
                <div class="form-group">
                  <div class="help-block with-errors"></div>
                  <input name="auc_fechaCreacion" id="auc_fechaCreacion" class="form-control requerido" type="date" data-error="Ingresar Fecha Accidente">
                  <div class="input-group-icon"><i class="fa fa-calendar-o"></i></div>
                </div>
              </div>

              <div class="col-md-2">
                <label for="">Usuarios</label>
                <div class="form-group">
                  <div class="help-block with-errors"></div>
                  <select name="auc_usuario" id="auc_usuario" class="form-control selectRequerido select2" style="width: 100%;">
                    <option value="0">TODOS</option>
                    <?php
                    mysqli_next_result($con);
                    $verAuditoras = mysqli_query($con, "SELECT a.id_usuario AS id_auditora, CONCAT(u.nombres, ' ', u.apellidos) AS nombre_auditoras
                    FROM auditorias a
                    LEFT JOIN usuarios u ON a.id_usuario = u.id
                    GROUP BY a.id_usuario");
                    while ($resul = mysqli_fetch_assoc($verAuditoras)) { 
                      if($resul['id_auditora'] == $_SESSION['id']){ ?>
                        <option value="<?php echo $resul['id_auditora']; ?>" selected><?php echo $resul['nombre_auditoras']; ?></option>
                      <?php } else{ ?>
                        <option value="<?php echo $resul['id_auditora']; ?>"><?php echo $resul['nombre_auditoras']; ?></option>
                    <?php
                      }
                    } ?>
                  </select>
                  <div class="input-group-icon"><i class="fa fa-calendar-o"></i></div>
                </div>
              </div>

              <div class="col-md-2">
                <label for=""> </label>
                <button type="submit" id="verMisAuditorias" class="btn btn-block btn bg-navy">VER MIS AUDITORIAS <span class="fa fa-search"></span></a>
              </div>

              <div id="tabla_oculta">
                <div class="col-md-12">
                  <table id="tb_AuditoriasRealizadas" class="table table-striped display table table-hover" cellspacing="0" width="100%">
                    <thead style="background-color: #217793; color: white;"></thead>
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

  <!-- Modal -->
  <div class="modal fade" id="modalMostrarAuditoria" tabindex="-1" role="dialog" aria-labelledby="editarAuditoria" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content modal-lg">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLongTitle">EDITAR AUDITORIA</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <form id="frmEditarAuditoria" data-toggle="validator" method="POST">
              <div class="row">

                <input type="hidden" id="mau_id_auditoria" name="mau_id_auditoria">
                <input type="hidden" id="mau_id_persona" name="mau_id_persona">

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Tipo Identificacion<span class="error">*</span></label>
                    <select id="mau_tipoDoc" name="mau_tipoDoc" class="form-control selectRequerido" data-error="Seleccione Tipo Doc" style="width: 100%;">
                      <option value="0">SELECCIONE</option>
                      <?php
                      mysqli_next_result($con);
                      $consultarTipoDoc = "SELECT id, descripcion, descripcion2 FROM definicion_tipos WHERE id_tipo=5";
                      $filasTipoDoc = mysqli_query($con, $consultarTipoDoc);
                      while ($row = mysqli_fetch_assoc($filasTipoDoc)) { ?>
                        <option value="<?= $row['id'] ?>"><?= $row['descripcion'] . ' - ' . $row['descripcion2'] ?></option>
                      <?php
                      } ?>
                    </select>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Identificación<span class="error">*</label>
                    <input id="mau_identificacion" name="mau_identificacion" placeholder="Identificación" class="form-control requerido" type="text" maxlength="11">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Nombres<span class="error">*</span></label>
                    <input id="mau_nombre" name="mau_nombre" placeholder="Nombres" class="form-control requerido" type="text">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Apellidos<span class="error">*</span></label>
                    <input id="mau_apellidos" name="mau_apellidos" placeholder="Apellidos" class="form-control requerido" type="text">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Correo electrónico<span class="error">*</span></label>
                    <input id="mau_email" name="mau_email" placeholder="Correo Electronico" class="form-control requerido" type="email" style="width: 100%;">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Telefono<span class="error">*</span></label>
                    <input id="mau_telefono" name="mau_telefono" placeholder="Telefono" class="form-control requerido" type="text">
                  </div>
                </div>


                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Placa<span class="error">*</span></label>
                    <input name="mau_placa" id="mau_placa" placeholder="Placa" class="form-control requerido" type="text">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Poliza<span class="error">*</span></label>
                    <input name="mau_poliza" id="mau_poliza" placeholder="Poliza" class="form-control requerido" type="text">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Aseguradora<span class="error">*</span></label>
                    <select name="mau_aseguradora" id="mau_aseguradora" class="form-control selectRequerido" style="width: 100%">
                      <option value="0">Seleccione</option>
                      <?php
                      mysqli_next_result($con);
                      $verAmparo = mysqli_query($con, "SELECT * FROM aseguradoras WHERE vigente='s';");
                      while ($resul = mysqli_fetch_assoc($verAmparo)) { ?>
                        <option value="<?php echo $resul['id']; ?>">
                          <?php echo $resul['nombre_aseguradora']; ?>
                        </option>
                      <?php
                      } ?>
                    </select>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Tipo Caso<span class="error">*</span></label>
                    <select name="mau_tipocaso" id="mau_tipocaso" class="form-control selectRequerido select2" style="width: 100%">
                      <option value="0">SELECCIONE</option>
                    </select>
                  </div>
                </div>


                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Fecha Accidente<span class="error">*</span></label>
                    <input name="mau_fAccidente" id="mau_fAccidente" class="form-control requerido" type="date" data-error="Ingresar Fecha Accidente">
                  </div>
                </div>


                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Tipo de Entrevistado<span class="error">*</span></label>
                    <select name="mau_tpEntrevistado" id="mau_tpEntrevistado" class="form-control selectRequerido" style="width: 100%;">
                      <option value="0">SELECCIONE</option>
                      <option value="1">TOMADOR</option>
                      <option value="2">LESIONADO</option>
                      <option value="3">FAMILIAR</option>
                      <option value="4">CONDUCTOR</option>
                      <option value="4">PROPIETARIO</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Nombre Lesionado<span class="error">*</span></label>
                    <input name="mau_lesionado" id="mau_lesionado" placeholder="Nombre del Lesionado" class="form-control requerido" type="text">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Condicion<span class="error">*</span></label>
                    <input name="mau_condicion" id="mau_condicion" placeholder="Nombre del Lesionado" class="form-control requerido" type="text">
                  </div>
                </div>


                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Ciudad Ocurrencia<span class="error">*</span></label>
                    <select name="mau_ciudad_ocurrencia" id="mau_ciudad_ocurrencia" class="form-control selectRequerido" style="width: 100%;">
                      <option value="0">SELECCIONE</option>
                      <?php
                      mysqli_next_result($con);
                      $consultarCiudad = "CALL consultasBasicas(1)";
                      $verCiudad = mysqli_query($con, $consultarCiudad);
                      while ($resul = mysqli_fetch_assoc($verCiudad)) { ?>
                        <option value="<?php echo $resul['id']; ?>">
                          <?php echo $resul['ciudad']; ?>
                        </option>
                      <?php
                      } ?>
                    </select>
                  </div>
                </div>


              </div>
            </form>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" onclick="limpiarCamposModal()" class="btn btn-info">Limpiar</button>
          <button type="button" onclick="editarModalAuditoria()" class="btn btn-primary" id="btnEditarAuditoria">Editar</button>
        </div>
      </div>
    </div>
  </div>