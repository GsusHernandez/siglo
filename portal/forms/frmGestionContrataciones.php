<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrataciones</title>
</head>

<body>

</body>
<div class="row">
    <!-- left column -->
    <div class="col-md-12">

        <div class="box box-solid box-primary">
            <div class="box-header with-border">
                <h4 class="box-title">Gestion Contrataciones</h4>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">

                <div class="col-sm-2">
                    <a class="btn btn-block btn-primary" id="BtnAñadirContratacion" data-toggle="modal" data-target="#mdAñadirContratacion">
                        <i class="glyphicon glyphicon-plus"></i>
                    </a>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <input type="text" class="form-control" id="" placeholder="Nombre del Contratista">
                    </div>
                </div>

                <div class="col-sm-2">
                    <a class="btn btn-block btn-primary" id="BtnBuscarContratacion"><i class="glyphicon glyphicon-search"></i></a>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="mdAñadirContratacion" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h3 class="modal-title" id="">Añadir Contrataciones
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h3>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form id="frmNuevaContratacion" data-toggle="validator" method="POST">
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Tipo Identificación</label>
                                    <select id="ctTipo_id" name="ctTipo_id" class="form-control select2 selectRequerido" style="width: 100%;">
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
                                    <label for="">Identificación</label>
                                    <input type="text" id="ct_id" name="ct_id" placeholder="Identificación" class="form-control requerido">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Nombres</label>
                                    <input type="text" id="ctNombres" name="ctNombres" placeholder="Nombres" class="form-control requerido">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Apellidos</label>
                                    <input type="text" id="ctApellidos" name="ctApellidos" placeholder="Apellidos" class="form-control requerido">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Fecha Inicio</label>
                                    <input type="date" id="ctFechaInicio" name="ctFechaInicio" class="form-control requerido">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Fecha Fin</label>
                                    <input type="date" id="ctFechaFin" name="ctFechaFin" class="form-control requerido">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Tipo de Contrato</label>
                                    <select id="ctTipoContrato" name="ctTipoContrato" class="form-control select2 selectRequerido" style="width: 100%;">
                                        <option value="0">SELECCIONE</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Fecha Devolucion</label>
                                    <input type="date" id="ctFechaFin" name="ctFechaFin" class="form-control requerido">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Cargo</label>
                                    <select id="ctCargo" class="form-control select2 selectRequerido" style="width: 100%;">
                                        <option value="0">SELECCIONE</option>
                                        <?php
                                        $consultarTiposUsuarios = "CALL consultasBasicas(12)";
                                        $verTiposUsuarios = mysqli_query($con, $consultarTiposUsuarios);
                                        while ($resul = mysqli_fetch_assoc($verTiposUsuarios)) { ?>
                                            <option value="<?php echo $resul['id']; ?>">
                                                <?php echo $resul['descripcion']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ctSalario">Salario</label>
                                    <input type="text" id="ctSalario" name="ctSalario" placeholder="$0.000.000" class="form-control requerido">
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <button type="submit" id="btnGuardarContratacion" class="btn btn-primary">Guardar</button>
            </div>
        </form>
        </div>
    </div>
</div>

</html>