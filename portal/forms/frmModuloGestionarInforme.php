<div class="box-body">
    <form role="form" id="frmInformeSOAT">
        <div class="row">
            <div class="form-group col-lg-2 col-sm-2 col-md-6">
                <label for="">Visita Lugar de Los Hechos:</label>
                <select id="visitaLugarHechosInformeFrm" style="width: 100%;" class="form-control select2">
                    <option value="0">SELECCIONE UN VALOR</option>
                    <option value="S">SI</option>
                    <option value="N">NO</option>
                </select>
            </div>

            <div class="form-group col-lg-2 col-sm-2 col-md-6">
                <label for="">Registro Autoridades:</label>
                <select id="registroAutoridadesTecnicaInformeFrm" style="width: 100%;" class="form-control select2">
                    <option value="0">SELECCIONE UN VALOR</option>
                    <option value="S">SI</option>
                    <option value="N">NO</option>
                </select>
            </div>

            <div class="form-group col-lg-2 col-sm-2 col-md-6">
                <label for="">Inspeccion Tecnica:</label>
                <select id="inspeccionTecnicaInformeFrm" style="width: 100%;" class="form-control select2">
                    <option value="0">SELECCIONE UN VALOR</option>
                    <option value="S">SI</option>
                    <option value="N">NO</option>
                </select>
            </div>
            <div class="form-group col-lg-2 col-sm-2 col-md-6">
                <label for="">Consulta RUNT:</label>
                <select id="ConsultaRUNTInformeFrm" style="width: 100%;" class="form-control select2">
                    <option value="0">SELECCIONE UN VALOR</option>
                    <option value="S">SI</option>
                    <option value="N">NO</option>
                </select>
            </div>
            <div id="divCausalNoConsultaRunt" style="display:none;">
                <div class="form-group col-sm-4">
                    <label for="">Causal RUNT:</label>
                    <select id="causalNoConsultaRUNTInformeFrm" style="width: 100%;" class="form-control select2">
                        <option value="0">SELECCIONE UN VALOR</option>
                        <?php
                        mysqli_next_result($con);
                        $consultarCausalNoConsulta = "CALL consultasBasicas(22)";
                        $verCausalNoConsulta = mysqli_query($con, $consultarCausalNoConsulta);


                        while ($resul = mysqli_fetch_assoc($verCausalNoConsulta)) {
                        ?>
                            <option value="<?php echo $resul['id']; ?>">
                                <?php echo $resul['descripcion']; ?>
                            </option>

                        <?php

                        }

                        ?>

                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-3 col-sm-4 col-md-6">
                <label for="">Cantidad Ocupantes Vehiculo:</label>
                <input type="text" class="form-control CampText" id="cantidadOcupantesInformeFrm" placeholder="Cantidad Ocupantes">
            </div>

            <div class="form-group col-lg-2 col-sm-2 col-md-6">
                <label for="">Cantidad Personas Traslado:</label>
                <input type="text" class="form-control CampText" id="cantidadPersonasTrasladoInformeFrm" placeholder="Cantidad Personas Traslado">
            </div>

            <div class="form-group col-sm-4" id="divMotivoOcurrencia" style="display:none;">
                <label for="">Motivo de Ocurrencia:</label>
                <select id="selectMotivoOcurrencia" style="width: 100%;" class="form-control select2">
                    <option value="0">SELECCIONE UN VALOR</option>
                    <?php
                    mysqli_next_result($con);
                    $consultar_motivos = "SELECT * FROM motivos_ocurrencia";
                    $verMotivos = mysqli_query($con, $consultar_motivos);
                    while ($res = mysqli_fetch_assoc($verMotivos)) {
                    ?>
                        <option value="<?= $res['id'] ?>"><?= $res['descripcion'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        
            <div class="col-lg-3 col-sm-4 col-md-6">
                <div class="form-group">
                    <label>Contacto Tomador</label>
                    <select id="contactoTomadorInformeFrm" style="width: 100%;" class="form-control select2">
                        <option value="0">SELECCIONE UN VALOR</option>
                        <?php
                        mysqli_next_result($con);
                        $consultarRespuestasTomador = "CALL consultasBasicas(26)";
                        $verRespuestasTomador = mysqli_query($con, $consultarRespuestasTomador);


                        while ($resul = mysqli_fetch_assoc($verRespuestasTomador)) {
                        ?>
                            <option value="<?php echo $resul['id']; ?>">
                                <?php echo $resul['descripcion']; ?>
                            </option>

                        <?php

                        }

                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group col-lg-3 col-sm-2 col-md-4">
                <label for="">Versiones de los hechos diferentes:</label>
                <select id="versionesHechosDiferenteInformeFrm" style="width: 100%;" class="form-control select2">
                    <option value="0">SELECCIONE UN VALOR</option>
                    <option value="S">SI</option>
                    <option value="N">NO</option>
                </select>
            </div>
        </div>

        <div class="row" id="divObservacionContactoTomador" style="display:none;">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Observacion Contacto Tomador</label>
                    <textarea class="form-control" rows="1" id="observacionContactoTomadorInformeFrm"></textarea>
                </div>
            </div>
        </div>

        <div class="row" id="divPuntoReferencia" style="display:none;">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Punto de Referencia</label>
                    <textarea class="form-control" rows="2" id="puntoReferenciaInformeFrm"></textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>FURIPS</label>
                    <textarea class="form-control deshabilitarCopiado" rows="3" id="furipsInformeFrm"></textarea>
                </div>
            </div>
        </div>

        <div class="row" id="aConsideracion" style="display:none;">
            <div class="col-md-12">
                <div class="form-group">
                    <label>A Consideracion</label>
                    <select id="selectAConsideracion" style="width: 100%;" class="form-control select2" multiple>
                        <option value="0" disabled>SELECCIONE UN VALOR</option>
                        <?php
                        mysqli_next_result($con);
                        $consultar_inconsistencias = "SELECT * FROM conclusiones_inconsistencias c";
                        $verInconsistencias = mysqli_query($con, $consultar_inconsistencias);
                        while ($resul = mysqli_fetch_assoc($verInconsistencias)) {
                        ?>
                            <option value="<?= $resul['id'] ?>"><?= $resul['nombre'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Conclusiones</label>
                    <textarea class="form-control deshabilitarCopiado" rows="3" id="conclusionesInformeFrm"></textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <a class="btn btn-block btn-primary" id="BtnGuardarDetalleInvestigacionFrm">Guardar</a>
                </div>
            </div>
        </div>

        <input type="hidden" id="idTipoCaso">
        <input type="hidden" id="idInvestigacionFrmInforme">
    </form>
</div>