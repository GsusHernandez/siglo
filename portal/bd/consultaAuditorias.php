<?php
include('../conexion/conexion.php');

function solicitarGuardarFirma($idUsuario, $aseguradora, $tipo_caso, $placa, $poliza, $fecha_accidente, $tipo_doc, $identificacion, $nombre, $apellido, $tp_entrevistado, $email, $telefono, $nombre_lesionado, $condicion, $ciudad_ocurrencia, $tipo_notificacion)
{
    global $con;

    $sqlVerificarAuditoria = "SELECT id, id_aseguradora, tipo_caso, placa, poliza, fecha_accidente FROM auditorias 
    WHERE id_aseguradora = '" . $aseguradora . "' AND tipo_caso = '" . $tipo_caso . "' AND placa = '" . $placa . "' 
    AND poliza = '" . $poliza . "' AND fecha_accidente = '" . $fecha_accidente . "' ";

    $VerificarAuditoria = mysqli_query($con, $sqlVerificarAuditoria);

    if (mysqli_num_rows($VerificarAuditoria) == 0) {
        $sqlGuardarAuditoria = "INSERT INTO auditorias(id_aseguradora, tipo_caso, placa, poliza, fecha_accidente, id_usuario, fecha, nombre_lesionado, condicion, ciudad_ocurrencia) 
        VALUES('" . $aseguradora . "', '" . $tipo_caso . "',UPPER('" . $placa . "'), '" . $poliza . "', '" . $fecha_accidente . "', '" . $idUsuario . "', NOW(), UPPER('" . $nombre_lesionado . "'), '" . $condicion . "', '" . $ciudad_ocurrencia . "')";

        if (mysqli_query($con, $sqlGuardarAuditoria)) {
            $id_auditoria = mysqli_insert_id($con);
        } else {
            $id_auditoria = 0;
        }
    } else {
        $respVerificarAuditoria = mysqli_fetch_assoc($VerificarAuditoria);
        $id_auditoria = $respVerificarAuditoria["id"];
    }

    if ($id_auditoria != 0) {
        mysqli_next_result($con);

        $sqlVerificarPersona  = "SELECT id_auditoria, tipo_id, identificacion FROM au_personas
        WHERE id_auditoria='" . $id_auditoria . "' AND tipo_id = '" . $tipo_doc . "' AND identificacion = '" . $identificacion . "' ";

        $verificarPersona = mysqli_query($con, $sqlVerificarPersona);

        if (mysqli_num_rows($verificarPersona) == 0) {
            $sqlGuardarPersona = "INSERT INTO au_personas(id_auditoria, tipo_id, identificacion, nombres, apellidos, telefono, correo, tipo_entrevistado, tipo_notificacion, id_usuario, fecha) 
            VALUES('" . $id_auditoria . "','" . $tipo_doc . "','" . $identificacion . "',UPPER('" . $nombre . "'), UPPER('" . $apellido . "'),'" . $telefono . "',LOWER('" . $email . "'),'" . $tp_entrevistado . "', '" . $tipo_notificacion . "', '" . $idUsuario . "', NOW() )";

            if (mysqli_query($con, $sqlGuardarPersona)) {
                $resp = array("respuesta" => 1, "dato" => mysqli_insert_id($con));
            } else {
                $resp = array("respuesta" => 2, "mensaje" => "Error al Registar la Persona");
            }
        } else {
            $resp = array("respuesta" => 3, "mensaje" => "Error ya existe un proceso de firma para esta persona en esta fecha");
        }
    } else {
        $resp = array("respuesta" => 4, "mensaje" => "Error al registrar auditoria");
    }
    echo json_encode($resp);
}

function consultarAuditorias($id_auditora, $identificacion, $nombre, $apellido, $placa, $poliza, $aseguradora, $tipo_caso, $estado, $fecha_creacion)
{
    global $con;
    session_start();
    $data = array();
    $where = "";
    //$id_usuario = $_SESSION['id'];

    if ($id_auditora != 0) {
        $where .= "AND au.id_usuario = '" . $id_auditora . "' ";
    }

    if ($identificacion != "") {
        $where .= " AND pe.identificacion = '$identificacion'";
    } else if ($nombre != "" || $apellido != "") {
        if ($nombre != "") {
            $where .= " AND pe.nombres like '%$nombre%'";
        }
        if ($apellido != "") {
            $where .= " AND pe.apellidos like '%$apellido%'";
        }
    }
    if ($placa != "") {
        $where .= "AND au.placa = '" . $placa . "'";
    }
    if ($poliza != "") {
        $where .= "AND au.poliza = '" . $poliza . "'";
    }
    if ($aseguradora != 0) {
        $where .= "AND au.id_aseguradora = '" . $aseguradora . "'";
    } else if ($tipo_caso != 0) {
        $where .= "AND au.tipo_caso = '" . $tipo_caso . "'";
    }
    if ($estado != "") {
        $where .= "AND pe.estado = '" . $estado . "'";
    }
    if ($fecha_creacion != "") {
        $where .= "AND au.fecha = '" . $fecha_creacion . "'";
    }
    $sqlConsultarAuditoria = "SELECT au.id AS id_auditoria, pe.id AS id_persona, pe.id, pe.identificacion, pe.nombres, pe.apellidos, a.nombre_aseguradora AS aseguradora, dt.descripcion AS tipo_caso, au.placa, au.poliza, pe.correo, pe.telefono, pe.estado, pe.tipo_notificacion, pe.tipo_entrevistado, au.id_usuario, au.fecha 
    FROM auditorias au
    LEFT JOIN au_personas pe ON au.id = pe.id_auditoria
    LEFT JOIN aseguradoras a ON a.id = au.id_aseguradora
    LEFT JOIN definicion_tipos dt ON dt.id = au.tipo_caso
    WHERE dt.id_tipo = 8 $where
    ORDER BY au.fecha DESC";

    $ConsultarAuditoria = mysqli_query($con, $sqlConsultarAuditoria);

    while ($resAuditoria = mysqli_fetch_array($ConsultarAuditoria, MYSQLI_ASSOC)) {

        $btnAuditorias = "";
        if ($resAuditoria["estado"] == 0) {
            $estado = '<span class="label label-success">CREADA</span>';
        } elseif ($resAuditoria["estado"] == 1) {
            $estado = '<span class="label label-info">ENVIADA</span>';
        } elseif ($resAuditoria["estado"] == 2) {
            $estado = '<span class="label label-warning">FIRMADA</span>';
        }

        if ($resAuditoria["tipo_notificacion"] == 1) {
            $tipo_notificacion = '<span class="label label-success">CORREO</span>';
            $contacto = $resAuditoria["correo"];
        } elseif ($resAuditoria["tipo_notificacion"] == 2) {
            $tipo_notificacion = '<span class="label label-success">MENSAJE</span>';
            $contacto = $resAuditoria["telefono"];
        }

        $data[] = array(
            "btn" => $btnAuditorias . '<button onclick="mostrarAuditoria(' . $resAuditoria['id_auditoria'] . ',' . $resAuditoria['id_persona'] . ')" type="button" class="btn btn-block btn btn-primary btn-sm"><span class="fa fa-pencil"></span></button>
            <button onclick="descargarInformeFirma()" type="button" class="btn btn-block btn-danger"><span class="fa fa-download"></span></button>',
            "id_auditoria" => $resAuditoria["id_auditoria"],
            "id_persona" => $resAuditoria["id_persona"],
            "identificacion" => $resAuditoria["identificacion"],
            "nombre" => $resAuditoria["nombres"],
            "apellido" => $resAuditoria["apellidos"],
            "placa" =>  $resAuditoria["placa"],
            "poliza" => $resAuditoria["poliza"],
            "contacto" => $contacto,
            "estado" => $estado,
            "tipo_notificacion" => $tipo_notificacion,
            "aseguradora" => $resAuditoria["aseguradora"],
            "tipo_caso" => $resAuditoria["tipo_caso"],
            "fecha_creacion" => $resAuditoria["fecha"],
        );
    }
    $results = array(
        "sEcho" => 1,
        "iTotalRecords" => count($data),
        "iTotalDisplayRecords" => count($data),
        "aaData" => $data
    );
    return json_encode($results);
}

function consultarEditarAuditoria($id_auditoria, $id_persona)
{
    global $con;
    $datos = array();
    $sqlMostrarAuditoria = "SELECT au.id AS id_auditoria, pe.id AS id_persona, dt2.id AS tipo_doc ,pe.identificacion, pe.nombres, pe.apellidos, a.id AS aseguradora, dt.id AS tipo_caso, au.placa, au.poliza, pe.correo, pe.telefono, pe.tipo_entrevistado, au.condicion, au.nombre_lesionado, au.ciudad_ocurrencia, au.fecha_accidente AS fecha_accidente, pe.estado
    FROM auditorias au
    LEFT JOIN au_personas pe ON au.id = pe.id_auditoria
    LEFT JOIN aseguradoras a ON a.id = au.id_aseguradora
    LEFT JOIN definicion_tipos dt ON dt.id = au.tipo_caso
    LEFT JOIN definicion_tipos dt2 ON dt2.id = pe.tipo_id
    WHERE au.id = $id_auditoria AND pe.id = $id_persona AND dt.id_tipo = 8 AND dt2.id_tipo = 5";

    $mostrarAuditoria = mysqli_query($con, $sqlMostrarAuditoria);

    $resMostrarAuditoria = mysqli_fetch_assoc($mostrarAuditoria);
    $datos['id_auditoria'] = $resMostrarAuditoria["id_auditoria"];
    $datos['id_persona'] = $resMostrarAuditoria["id_persona"];
    $datos['tipo_id'] = $resMostrarAuditoria["tipo_doc"];
    $datos['identificacion'] = $resMostrarAuditoria["identificacion"];
    $datos['nombres'] = $resMostrarAuditoria["nombres"];
    $datos['apellidos'] = $resMostrarAuditoria["apellidos"];
    $datos['telefono'] = $resMostrarAuditoria["telefono"];
    $datos['placa'] = $resMostrarAuditoria["placa"];
    $datos['poliza'] = $resMostrarAuditoria["poliza"];
    $datos['correo'] = $resMostrarAuditoria["correo"];
    $datos['aseguradora'] = $resMostrarAuditoria["aseguradora"];
    $datos['tipo_caso'] = $resMostrarAuditoria["tipo_caso"];
    $datos['fecha_accidente'] = $resMostrarAuditoria["fecha_accidente"];
    $datos['estado'] = $resMostrarAuditoria["estado"];
    $datos['tipo_entrevistado'] = $resMostrarAuditoria["tipo_entrevistado"];
    $datos['nombre_lesionado'] = $resMostrarAuditoria["nombre_lesionado"];
    $datos['ciudad_ocurrencia'] = $resMostrarAuditoria["ciudad_ocurrencia"];
    $datos['condicion'] = $resMostrarAuditoria["condicion"];

    return json_encode($datos);
}
function consultarEditarModalAu($mid_auditoria, $mid_persona, $mAseguradora, $mTipo_caso, $mPlaca, $mPoliza, $mFecha_accidente, $mTipo_doc, $mIdentificacion, $mNombre, $mApellido, $mTp_entrevistado, $mEmail, $mTelefono, $mLesionado, $mCondicion, $mCiudadOcurrencia, $idUsuario)
{
    global $con;

    $verificarAuditoriaModal = "SELECT a.id_aseguradora, a.tipo_caso, a.placa, a.poliza, a.fecha_accidente, a.nombre_lesionado, a.condicion, p.tipo_id, p.nombres, p.apellidos
    FROM auditorias a
    LEFT JOIN au_personas p ON a.id = p.id_auditoria
    WHERE a.id_aseguradora = '" . $mAseguradora . "' AND a.tipo_caso = '" . $mTipo_caso . "' AND a.placa = '" . $mPlaca . "' AND a.poliza = '" . $mPoliza . "' AND a.fecha_accidente = '" . $mFecha_accidente . "' AND a.nombre_lesionado = '" . $mLesionado . "' AND a.condicion = '" . $mCondicion . "' AND p.tipo_id = '" . $mTipo_doc . "' AND p.nombres = '" . $mNombre . "' AND p.apellidos = '" . $mApellido . "' ";

    $VerificarModal = mysqli_query($con, $verificarAuditoriaModal);

    if (mysqli_num_rows($VerificarModal) == 0) {
        $sqlModalEditarAuditoria = "UPDATE au_auditorias
        SET id_aseguradora= '$mAseguradora', tipo_caso='$mTipo_caso', placa=UPPER('$mPlaca'), poliza='$mPoliza',fecha_accidente='$mFecha_accidente', nombre_lesionado='$mLesionado',condicion='$mCondicion',ciudad_ocurrencia='$mCiudadOcurrencia',id_usuario='$idUsuario'
        WHERE id = $mid_auditoria";

        $sqlModalEditarPersona = "UPDATE au_personas
        SET tipo_id='$mTipo_doc', identificacion='$mIdentificacion', nombres=UPPER('$mNombre'), apellidos=UPPER('$mApellido'), telefono='$mTelefono', correo='$mEmail', tipo_entrevistado='$mTp_entrevistado', id_usuario='$idUsuario'
        WHERE id = $mid_persona";

        if (mysqli_query($con, $sqlModalEditarAuditoria) && mysqli_query($con, $sqlModalEditarPersona)) {
            $resp = array("respuesta" => 1, "mensaje" => "Editado Correctamente");
        }
    }
}
