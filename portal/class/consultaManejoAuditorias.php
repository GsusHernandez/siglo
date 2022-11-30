<?php
//cg114194
include("../bd/consultaAuditorias.php");

if ($_POST["exe"] == "solicitarGuardarFirma") {

	$idUsuario = $_POST["id_auditora"];
	$aseguradora = $_POST["au_aseguradora"];
	$tipo_caso = $_POST["au_tipocaso"];
	$placa = $_POST["au_placa"];
	$poliza = $_POST["au_poliza"];
	$fecha_accidente = $_POST["au_fAccidente"];
	$tipo_doc = $_POST["au_tipoDoc"];
	$identificacion = $_POST["au_identificacion"];
	$nombre = $_POST["au_nombre"];
	$apellido = $_POST["au_apellidos"];
	$tp_entrevistado = $_POST["au_tpEntrevistado"];
	$email = $_POST["au_email"];
	$telefono = $_POST["au_telefono"];
	$nombre_lesionado  = $_POST["au_lesionado"];
	$condicion = $_POST["au_condicion"];
	$ciudad_ocurrencia = $_POST["au_ciudad_ocurrencia"];
	$tipo_notificacion = $_POST["au_tpNotificacion"];

	$variable = solicitarGuardarFirma($idUsuario, $aseguradora, $tipo_caso, $placa, $poliza, $fecha_accidente, $tipo_doc, $identificacion, $nombre, $apellido, $tp_entrevistado, $email, $telefono, $nombre_lesionado, $condicion, $ciudad_ocurrencia, $tipo_notificacion);
	echo $variable;
} else if ($_POST["exe"] == "consultarAuditorias") {

	$id_usuario = $_POST["idUsuario"];
	$identificacion = $_POST["auc_identificacion"];
	$nombre = $_POST["auc_nombre"];
	$apellido = $_POST["auc_apellidos"];
	$placa = $_POST["auc_placa"];
	$poliza = $_POST["auc_poliza"];
	$aseguradora = $_POST["auc_aseguradora"];
	$tipo_caso = $_POST["auc_tipocaso"];
	$estado = $_POST["auc_estado"];
	$fecha_creacion = $_POST["auc_fechaCreacion"];
	$variable = consultarAuditorias($id_usuario, $identificacion, $nombre, $apellido, $placa, $poliza, $aseguradora, $tipo_caso, $estado, $fecha_creacion);
	echo $variable;
} else if ($_POST["exe"] == "consultarEditarAuditoria") {
	$id_auditoria = $_POST["auditoria"];
	$id_persona = $_POST["persona"];

	$variable = consultarEditarAuditoria($id_auditoria, $id_persona);

	echo $variable;
} else if ($_POST["exe"] == "consultarEditarModalAu") {
	$mid_auditoria = $_POST["id_auditoria"];
	$mid_persona = $_POST["id_persona"];
	$mAseguradora = $_POST["aseguradora"];
	$mTipo_caso = $_POST["tipo_caso"];
	$mPlaca = $_POST["placa"];
	$mPoliza = $_POST["poliza"];
	$mFecha_accidente = $_POST["fAccidente"];
	$mTipo_doc = $_POST["tipo_id"];
	$mIdentificacion = $_POST["ident"];
	$mNombre = $_POST["nombres"];
	$mApellido = $_POST["apellidos"];
	$mTp_entrevistado = $_POST["tp_entrevistado"];
	$mEmail = $_POST["correo"];
	$mTelefono = $_POST["tel"];
	$mLesionado = $_POST["nombre_lesionado"];
	$mCondicion = $_POST["condicion"];
	$mCiudadOcurrencia = $_POST["ciudad_ocurrencia"];
	$idUsuario = $_POST["idUsuario"];

	$variable = consultarEditarModalAu($mid_auditoria, $mid_persona, $mAseguradora, $mTipo_caso, $mPlaca, $mPoliza, $mFecha_accidente, $mTipo_doc, $mIdentificacion, $mNombre, $mApellido, $mTp_entrevistado, $mEmail, $mTelefono, $mLesionado, $mCondicion, $mCiudadOcurrencia, $idUsuario);
	echo $variable;
}