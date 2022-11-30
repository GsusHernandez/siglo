$("#DivTablasIngresarValorCasosCuentaCobro").on('keypress','input',function(e){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');

	if (e.which===13 || e.which===9){	
		if (action=="valorCasoInvestigacionesAseguradoraCuentaCobro")
		{

			var celda = $(this).parent();

			var fila = celda.parent();
			var Campo1 = fila.find("#cantidadInvestigacionesAseguradoraCuentaCobro").val();
			var Campo2 = fila.find("#valorCasoInvestigacionesAseguradoraCuentaCobro").val();

			var total=(Campo1*Campo2);
			fila.find("#valorTotalInvestigacionesAseguradoraCuentaCobro").val(total);
		}

	}

});

function llenarTablaTipoCasosAseguradoraCuentaCobro(idCuentaCobroInv){	
	loadingSiglo('show', 'Cargando Resoluciones...');
	$('#tablaIngresarValorCasosCuentaCobro').DataTable( {
		"select": false,
		"destroy":true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "consultarTipoCasosAseguradoraCuentaCobro";
				d.idCuentaCobro = idCuentaCobroInv;
			}
		},
		initComplete: function(settings, json) {
			loadingSiglo('hide');
		},
		"bPaginate":true,
		"bProcessing": true,
		"pageLength": 6,
		"ordering": false,
		"bFilter" : true,               
		"bLengthChange": false,
		"columns": [
		{ mData: 'aseguradora_tipo_caso', "orderable": "false" } ,
		{ mData: 'cantidad_investigaciones', "orderable": "false" } ,
		{ mData: 'valor_caso', "orderable": "false" } ,
		{ mData: 'valor_total', "orderable": "false" },
		{ mData: 'id_aseguradora', "orderable": "false" ,"visible":false },
		{ mData: 'id_tipo_caso', "orderable": "false" ,"visible":false },
		{ mData: 'id_resultado', "orderable": "false" ,"visible":false },
		{ mData: 'id_tipo_zona', "orderable": "false" ,"visible":false },
		{ mData: 'id_tipo_auditoria', "orderable": "false" ,"visible":false }
		],
		"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}

function llenarSelect(parametro,selectUbicacion,tipoConsulta){
	$.ajax({
		type: 'POST',
		url: 'class/consultasBasicas.php',
		data: "exe="+tipoConsulta+"&parametro="+parametro,
		success: function(res) {

			var json_obj = $.parseJSON(res);
			var options = '';
			options += '<option value="0">SELECCIONE UN VALOR</option>';
			for (var i = 0; i < json_obj.length; i++) {
				options += '<option value="' + json_obj[i].valor + '">' + json_obj[i].descripcion + '</option>';
			}
			$(selectUbicacion).html(options);
			return false;
		}

	});
}

function llenarTablaRevisarInvestigacionesFacturacion(){
	loadingSiglo('show', 'Cargando Resoluciones...');
	$('#tablaGestionRevisarInvestigacionesFacturacion').DataTable( {
		"select": false,
		"destroy":true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "consultarInvestigacionesFacturacion";
			}
		},
		initComplete: function(settings, json) {
			loadingSiglo('hide');
		},
		"bPaginate":true,
		"bProcessing": true,
		"pageLength": 6,
		"ordering": false,
		"bFilter" : true,               
		"bLengthChange": false,
		"columns": [
		{ mData: 'infInvestigacion', "orderable": "false" } ,
		{ mData: 'infLesionado', "orderable": "false" } ,
		{ mData: 'infResultado', "orderable": "false" },
		{ mData: 'opciones', "orderable": "false" }
		],
		"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}

var flag = false;
var teclaAnterior = ""; 
$('input[type=text], textarea').keydown(function(event) {
	teclaAnterior = teclaAnterior + " " + event.keyCode;
	var arregloTA = teclaAnterior.split(" ");
	if (event.keyCode == 32 && arregloTA[arregloTA.length - 2] == 32) {
		event.preventDefault();
	}
});

cargarPush();

function cargarPush(){

	var formLogin =  "exe=consultarUsuario&registroUsuario="+$("#btnLogout").attr("name");
	$.ajax({
		type: 'POST',
		async:	true,
		url: 'class/consultasManejoUsuarios.php',
		data: formLogin,
		success: function(data) {
			var json_obj = $.parseJSON(data);
			if (jQuery.isEmptyObject(json_obj)) {
				alert("error");
			}
			else{
				if(json_obj.vigente=="n" || json_obj.empleado=="n"){
					window.location="https://globalredltda.co/siglo";						
				}
			}

			setTimeout('cargarPush()',7000);
			return false;
		}
	});
}

function loadingSiglo(action, message = ''){
	if(action == 'show'){
		$(".wrapper-text").text(message);
		$(".content-wrapper-loading").show();
	}else{
		$(".wrapper-text").text('');
		$(".content-wrapper-loading").hide();
	}
}

function mostrarLesionadosFotoSalud(idInvestigacion){
	$.ajax({
		type: 'POST',
		url: 'class/consultasBasicas.php',
		data: "exe=consultarLesionadosInvestiagcion&idInvestiagcion="+idAseguradora,
		beforeSend: function() {
			loadingSiglo('show', 'Cargando Fotos Lesionado...');
		},
		success: function(res) {
			var json_obj = $.parseJSON(res);
			var options = '';
			for (var i = 0; i < json_obj.length; i++) {
				options += '<option value="' + json_obj[i].valor + '">' + json_obj[i].descripcion + '</option>';
			}
			$(selectUbicacion).html(options);
			loadingSiglo('hide');
			return false;
		},
		error: function(data){
			loadingSiglo('hide');
		}
	});

	$.ajax({
		type: 'POST',
		url: 'class/consultasBasicas.php',
		data: "exe=consultarFotografiasSalud&idInvestiagcion="+idAseguradora,
		beforeSend: function() {
			loadingSiglo('show', 'Cargando Fotos Salud...');
		},
		success: function(res) {
			var json_obj = $.parseJSON(res);
			var options = '';
			for (var i = 0; i < json_obj.length; i++) {
				options += '<option value="' + json_obj[i].valor + '">' + json_obj[i].descripcion + '</option>';
			}
			$(selectUbicacion).html(options);
			loadingSiglo('hide');
			return false;
		},
		error: function(data){
			loadingSiglo('hide');
		}
	});
}

function mostrarTipoCasosAseguradora(idAseguradora,selectUbicacion,tipoCasos){
	$.ajax({
		type: 'POST',
		url: 'class/consultasBasicas.php',
		data: "exe=consultarAmparosAseguradora&idAseguradora="+idAseguradora+"&tipoCasos="+tipoCasos,
		beforeSend: function() {
			loadingSiglo('show', 'Cargando Tipos Aseguradora...');
		},
		success: function(res) {
			var json_obj = $.parseJSON(res);
			var options = '';

			for (var i = 0; i < json_obj.length; i++) {
				if(json_obj[i].valor == 0 && selectUbicacion == "#tipoCasoDenuncias" ){
					options += '<option value="' + json_obj[i].valor + '">TODOS</option>';
					/**************************** */
				}else{
					options += '<option value="' + json_obj[i].valor + '">' + json_obj[i].descripcion + '</option>';
				}
			}
			
			$(selectUbicacion).html(options);
			loadingSiglo('hide');
			return false;
		},
		error: function(data) {
			loadingSiglo('hide');
		}
	});
}

$('.formFechas').daterangepicker({
	singleDatePicker: true,
	showDropdowns: true,
	minYear: 1940,
	maxYear: 2030,
	locale: {
		format: 'YYYY-MM-DD'
	}
});

$('.formFechasHora').daterangepicker({
	singleDatePicker: true,
	showDropdowns: true,
	minYear: 1940,
	maxYear: 2030,
	locale: {
		format: 'YYYY-MM-DD HH:mm:ss'
	},
	timePicker: true,
	timePicker24Hour: true
});

function convertirDaterangepicker(referencia, tipo = 1){
	if(tipo == 1){
		if($(referencia).val() == '' || $(referencia).val() == '0000-00-00'){

			$(referencia).val('1940-01-01');

			$(referencia).daterangepicker({
				singleDatePicker: true,
				showDropdowns: true,
				minYear: 1940,
				maxYear: 2030,
				locale: {
					format: 'YYYY-MM-DD'
				}
			});
		}else{
			$(referencia).daterangepicker({
				singleDatePicker: true,
				showDropdowns: true,
				minYear: 1940,
				maxYear: 2030,
				locale: {
					format: 'YYYY-MM-DD'
				}
			});
		}
	}else{
		if($(referencia).val() == '' || $(referencia).val() == '0000-00-00 00:00:00'){

			$(referencia).val('1940-01-01 01:00:00');

			$(referencia).daterangepicker({
				singleDatePicker: true,
				showDropdowns: true,
				minYear: 1940,
				maxYear: 2030,
				locale: {
					format: 'YYYY-MM-DD HH:mm:ss'
				},
				timePicker: true,
				timePicker24Hour: true
			});
		}else{
			$(referencia).daterangepicker({
				singleDatePicker: true,
				showDropdowns: true,
				minYear: 1940,
				maxYear: 2030,
				locale: {
					format: 'YYYY-MM-DD HH:mm:ss'
				},
				timePicker: true,
				timePicker24Hour: true
			});
		}
	}
}

function destruirDaterangepicker(referencia){
	$(referencia).data('daterangepicker').remove();
}

function ModalRegistrosOut(tipoAccion,idRegistro,idTablaActualizar,exe){
	if (tipoAccion=="Eliminar"){
		$('#tituloModuloRegistrosOut').html("Eliminar Registros");	
		$('#textModuloRegistrosOut').html("Desea eliminar este registro?");	

	}else if (tipoAccion=="Permitir"){
		$('#tituloModuloRegistrosOut').html("Habilitar/Deshabilitar Registros");	
		$('#textModuloRegistrosOut').html("Desea habilitar/deshabilitar este registro?");	
	}
	else if (tipoAccion=="Autorizar"){
		$('#tituloModuloRegistrosOut').html("Autorizar");	
		$('#textModuloRegistrosOut').html("Desea autorizar esta investigacion?");	
	}
	else if (tipoAccion=="AutorizarFacturacion"){
		$('#tituloModuloRegistrosOut').html("Autorizar Facturacion");	
		$('#textModuloRegistrosOut').html("Desea autorizar/desautorizar la facturacion de esta investigacion?");	
	}

	$('#idModuloRegistrosOut').val(idRegistro);
	$('#idTablaActualizar').val(idTablaActualizar);
	$('#exeModuloRegistrosOut').val(exe);
	$('#ModuloRegistrosOut').modal('show');
}

$('#BtnConfirmarModuloRegistrosOut').click(function(e){
	var Ruta="";

	if ($('#exeModuloRegistrosOut').val()=="eliminarEmpleadosNomina"){
		Ruta="consultasManejoEmpleadosNomina";
	}else if ($('#exeModuloRegistrosOut').val()=="vigenciaEmpleadosNomina"){
		Ruta="consultasManejoEmpleadosNomina";
	}else if ($('#exeModuloRegistrosOut').val()=="eliminarAseguradoras"){
		Ruta="consultasManejoAseguradoras";
	}else if ($('#exeModuloRegistrosOut').val()=="vigenciaAseguradora"){
		Ruta="consultasManejoAseguradoras";
	}else if ($('#exeModuloRegistrosOut').val()=="eliminarClinicas"){
		Ruta="consultasManejoClinicas";
	}else if ($('#exeModuloRegistrosOut').val()=="permitirClinicas"){
		Ruta="consultasManejoClinicas";
	}else if ($('#exeModuloRegistrosOut').val()=="eliminarUsuario"){
		Ruta="consultasManejoUsuarios";
	}else if ($('#exeModuloRegistrosOut').val()=="vigenciaUsuario"){
		Ruta="consultasManejoUsuarios";
	}else if ($('#exeModuloRegistrosOut').val()=="eliminarAmparoAseguradora"){
		Ruta="consultasManejoAseguradoras";
	}else if ($('#exeModuloRegistrosOut').val()=="eliminarClinicaCiudadTarifaAmparo"){
		Ruta="consultasManejoAseguradoras";
	}else if ($('#exeModuloRegistrosOut').val()=="eliminarIndicadorAseguradora"){
		Ruta="consultasManejoAseguradoras";
	}else if ($('#exeModuloRegistrosOut').val()=="eliminarRangoValorTarifa"){
		Ruta="consultasManejoAseguradoras";
	}else if ($('#exeModuloRegistrosOut').val()=="eliminarResolucionFacturacion"){
		Ruta="consultasManejoResolucionFacturacion";
	}else if ($('#exeModuloRegistrosOut').val()=="eliminarInvestigador"){
		Ruta="consultasManejoInvestigadores";
	}else if ($('#exeModuloRegistrosOut').val()=="vigenciaInvestigador"){
		Ruta="consultasManejoInvestigadores";
	}else if ($('#exeModuloRegistrosOut').val()=="eliminarAsignacionInvestigadorIps"){
		Ruta="consultasManejoClinicas";
	}else if ($('#exeModuloRegistrosOut').val()=="eliminarCasoSOAT"){
		Ruta="consultasManejoCasoSOAT";
	}else if ($('#exeModuloRegistrosOut').val()=="eliminarPersonaLesionadoSOAT"){
		Ruta="consultasManejoLesionados";
	}else if ($('#exeModuloRegistrosOut').val()=="eliminarPolizaCasoSOAT"){
		Ruta="consultasManejoVehiculosPoliza";
	}else if ($('#exeModuloRegistrosOut').val()=="eliminarMultimediaInvestigacion"){
		Ruta="consultasManejoCasoSOAT";
	}else if ($('#exeModuloRegistrosOut').val()=="eliminarBeneficiariosCasoSOAT"){
		Ruta="consultasManejoLesionados";
	}else if ($('#exeModuloRegistrosOut').val()=="eliminarCasoValidacion"){
		Ruta="consultasManejoCasoValidaciones";
	}else if ($('#exeModuloRegistrosOut').val()=="autorizarCasoSOAT"){
		Ruta="consultasManejoCasoSOAT";
	}else if ($('#exeModuloRegistrosOut').val()=="eliminarObservacionInformeInvestigacion"){
		Ruta="consultasManejoCasoSOAT";
	}else if ($('#exeModuloRegistrosOut').val()=="eliminarTestigoInformeInvestigacion"){
		Ruta="consultasManejoCasoSOAT";
	}else if ($('#exeModuloRegistrosOut').val()=="eliminarIndicadorCaso"){
		Ruta="consultasManejoCasoSOAT";
	}else if ($('#exeModuloRegistrosOut').val()=="autorizarFacturacionInvestigacion"){
		Ruta="consultasManejoCasoSOAT";
	}else if ($('#exeModuloRegistrosOut').val()=="eliminarPeriodosCuentaCobroInvestigadores"){
		Ruta="consultasManejoPeriodosCuentaCobroInvestigadores";
	}else if ($('#exeModuloRegistrosOut').val()=="vigenciaPeriodosCuentaCobroInvestigadores"){
		Ruta="consultasManejoPeriodosCuentaCobroInvestigadores";
	}else if ($('#exeModuloRegistrosOut').val()=="vigenciaInvestigadoresCuentaCobroPeriodo"){
		Ruta="consultasManejoPeriodosCuentaCobroInvestigadores";
	}

	var form =  "exe="+$('#exeModuloRegistrosOut').val()+"&idRegistro="+$('#idModuloRegistrosOut').val()+"&idUsuario="+$('#btnLogout').attr('name')+"&idTablaActualizar="+$('#idTablaActualizar').val();

	$.ajax({
		type: 'POST',
		url: 'class/'+Ruta+'.php',
		data: form,
		beforeSend: function() {
			loadingSiglo('show', 'Cargando...');
		},
		success: function(data) {
			var variable=$.parseJSON(data);

			if (data==1){

				$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente");
				if ($('#idTablaActualizar').val()=="tablaGestionUsuarios"){
					llenarTablaUsuarios();
				}else if ($('#idTablaActualizar').val()=="tablaGestionAseguradora"){
					llenarTablaAseguradora();
				}else if ($('#idTablaActualizar').val()=="tablaGestionClinicas"){
					llenarTablaClinicas();
				}else if ($('#idTablaActualizar').val()=="tablaAsignacionAmparoAseguradora"){
					llenarTablaAsignacionAmparoAseguradora();
				}else if ($('#idTablaActualizar').val()=="tablaClinicaCiudadesTarifaAmparo"){
					llenarTablaClinicaCiudadesTarifaAmparo();
				}else if ($('#idTablaActualizar').val()=="tablaAsignacionIndicadorAseguradora"){
					llenarTablaAsignacionIndicadorAseguradora();
				}else if ($('#idTablaActualizar').val()=="tablaRangoValorTarifaAmparo"){
					llenarTablaRangoValorTarifaAmparo();
				}else if ($('#idTablaActualizar').val()=="tablaResolucionesFacturacion"){
					llenarTablaResolucionesFacturacion();
				}else if ($('#idTablaActualizar').val()=="tablaGestionInvestigadores"){
					llenarTablaInvestigadores();
				}else if ($('#idTablaActualizar').val()=="tablaAsignacionInvestigadorIps"){
					llenarTablaAsignacionInvestigadoresClinicas();
				}else if ($('#idTablaActualizar').val()=="tablaGestionCasosSOAT"){
					llenarTablaGestionCasosSOAT();
				}else if ($('#idTablaActualizar').val()=="tablaGestionLesionados"){
					llenarTablaGestionLesionados();
				}else if ($('#idTablaActualizar').val()=="tablaPolizasVehiculosFrmVehiculos"){
					llenarTablaPolizasVehiculos();
				}else if ($('#idTablaActualizar').val()=="tablaGestionMultimediaInvestigacion"){
					llenarTablaGestionMultimediaInvestigacion();
				}else if ($('#idTablaActualizar').val()=="tablaGestionBeneficiarios"){
					llenarTablaGestionBeneficiarios();
				}else if ($('#idTablaActualizar').val()=="tablaGestionCasosValidacionesIPS"){
					llenarTablaGestionCasosValidaciones();
				}else if ($('#idTablaActualizar').val()=="tablaGestionObservaciones"){
					llenarTablaGestionObservaciones();
				}else if ($('#idTablaActualizar').val()=="tablaGestionTestigos"){
					llenarTablaGestionTestigos();
				}else if ($('#idTablaActualizar').val()=="tablaIndicativosAseguradoraFrmCasosGM"){
					tablaIndicativosAseguradoraGM();
				}else if ($('#idTablaActualizar').val()=="tablaPeriodosCuentaCobro"){
					llenarTablaPeriodosCuentaCobroInvestigadores();
				}else if ($('#idTablaActualizar').val()=="tablaInvestigadoresCuentaCobroPeriodo"){
					llenarTablaCuentaCobroInvestigadores();
				}

				$('#ModuloRegistrosOut').modal('hide');
				$('#ErroresNonActualizable').modal('show');

			}else if(data==2){
				$("#ContenidoErrorNonActualizable").html("Error al Ejecutar Proceso. Contacte al administrador de sistema");
				$('#ErroresNonActualizable').modal('show');

			}else if(data==3){
				$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente. Error al Guardar Log de Eventos");
				$('#ErroresNonActualizable').modal('show');
			}else if(data==4){
				if($('#exeModuloRegistrosOut').val()=="eliminarPolizaCasoSOAT"){
					$("#ContenidoErrorNonActualizable").html("Error al eliminar, esta poliza esta asociada a otras investigaciones");
					$('#ErroresNonActualizable').modal('show');
					$('#ModuloRegistrosOut').modal('hide');
				}else{
					$("#ContenidoErrorNonActualizable").html("Error, Tomar Captura y contactar Al administrador. <br>"+data);
					$('#ErroresNonActualizable').modal('show');	
				}
			}else{
				$("#ContenidoErrorNonActualizable").html("Error, Tomar Captura y contactar Al administrador. <br>"+data);
				$('#ErroresNonActualizable').modal('show');
			}

			loadingSiglo('hide');
			return false;
		},error: function(data) {
			loadingSiglo('hide');
		}
	});

	return false;
});	

function limpiaForm(miForm) {
	$(miForm)[0].reset();
}

$(".CamNum").on('input', function () {
	$(this).val($(this).val().replace(/[^0-9]/g,''));
});

$(".CampText").on('keypress', function () {
	$input=$(this);
	setTimeout(function() {
		$input.val($input.val().toUpperCase());
	});
});

$(".CampTextNum").on('input', function () { 
	$(this).val($(this).val().replace(/[^0-9a-zA-Z]/g,''));
});

$(".form-control").on('input', function () {
	$(this).val($(this).val().replace(/['"]+/g, ''));
});

$(".select2").select2();

$( "#metodoPagoEmpleadoFrm" ).change(function() {
	if ($( "#metodoPagoEmpleadoFrm option:selected" ).val()!=4){
	}
});


$( "#aseguradoraFrmRevisarFacturacion" ).change(function() {
	mostrarTipoCasosAseguradora($("#aseguradoraFrmRevisarFacturacion option:selected").val(),"#tipoCasoFrmRevisarFacturacion","Plano");
});



$("#DivTablas1").on('click','a',function(){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');

	loadingSiglo('show', 'Cargando Fotos Salud...');

	if (action=="btnEditarEmpleado"){

		var form =  "exe=consultarEmpleados&idEmpleado="+opcion+"&identificacionEmpleado=0";
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoEmpleadosNomina.php',
			data: form,
			success: function(data) {
				var json_obj = $.parseJSON(data);
				if (jQuery.isEmptyObject(json_obj)) {
					$("#ContenidoErrorNonActualizable").html("error al consultar");
					$('#ErroresNonActualizable').modal('show');
				} else {
					limpiaForm("#FrmEmpleadosNomina");
					$('#idRegistroEmpleado').attr("name",opcion);
					$('#exeFrmEmpleado').val('modificarEmpleados');
					$("#apellidosEmpleadoFrm").val(json_obj.apellidos_empleado);
					$("#nombresEmpleadoFrm").val(json_obj.nombres_empleado);
					$("#identificacionEmpleadoFrm").val(json_obj.identificacion_empleado);
					$("#correoEmpleadoFrm").val(json_obj.correo_empleado);
					$("#telefonoEmpleadoFrm").val(json_obj.telefono_empleado);
					$("#direccionEmpleadoFrm").val(json_obj.direccion_empleado);
					$("#tipoEmpleadoFrm").val(json_obj.tipo_empleado).change();
					$("#tipoIdentificacionEmpleadoFrm").val(json_obj.tipo_idenificacion_empleado).change();
					$('#btnSubmitFrmEmpleado').html('Modificar');
					$('#FrmAddEmpleadosNomina').modal('show');
				}

				loadingSiglo('hide');

				return false;
			},error: function(data){
				loadingSiglo('hide');
			}
		});
	}
	else if (action=="btnEliminarEmpleado"){
		ModalRegistrosOut("Eliminar",opcion,"tablaGestionNomina","eliminarEmpleadosNomina");
		loadingSiglo('hide');
	}
	else if (action=="btnPermitirEmpleado"){
		ModalRegistrosOut("Permitir",opcion,"tablaGestionNomina","vigenciaEmpleadosNomina");
		loadingSiglo('hide');
	}
	else if (action=="GestionarInfoPagoEmpleado"){	

		var form =  "exe=consultarInformacionPagoEmpleado&idEmpleado="+opcion;

		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoEmpleadosNomina.php',
			data: form,
			success: function(data) {
				var json_obj = $.parseJSON(data);
				limpiaForm("#FrmMetodoPagoEmpleado");
				$("#idRegistroEmpleadoMetodoPago").val(opcion);

				if (json_obj.cantidadRegistrosInformacionPagoEmpleados==0) {
					$('#btnSubmitFrmMetodoPagoEmpleado').html('Registrar');
					$('#exeFrmMetodoPagoEmpleado').val('registrarMetodoPagoEmpleado');

				} else {

					$('#btnSubmitFrmMetodoPagoEmpleado').html('Modificar');
					$('#exeFrmMetodoPagoEmpleado').val('modificarMetodoPagoEmpleado');
					$('#idRegistroMetodoPagoEmpleado').val(json_obj.idMetodoPago);
					$("#metodoPagoEmpleadoFrm").val(json_obj.metodo_pago).change();
					$("#tipoProductoEmpleadoFrm").val(json_obj.tipo_producto).change();
					$("#numReferenciaEmpleadoFrm").val(json_obj.num_referencia);
				}

				$('#FrmMetodoPagoEmpleado').modal('show');
				loadingSiglo('hide');
				return false;
			},error: function(data){
				loadingSiglo('hide');
			}
		});
	}
});

$("#DivTablasPeriodoCuentaCobro").on('click','a',function(){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');

	if (action=="btnEliminarPeriodosCCInvestigadoress"){
		ModalRegistrosOut("Eliminar",opcion,"tablaPeriodosCuentaCobro","eliminarPeriodosCuentaCobroInvestigadores");
	}else if (action=="btnVigenciaPeriodosCCInvestigadoress"){
		ModalRegistrosOut("Permitir",opcion,"tablaPeriodosCuentaCobro","vigenciaPeriodosCuentaCobroInvestigadores");
	}else if (action=="btnModificarPeriodosCCInvestigadoress"){

		var form =  "exe=consultarPeriodoCCInvestigaciones&idRegistro="+opcion;
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoPeriodosCuentaCobroInvestigadores.php',
			data: form,
			success: function(data) {
				var json_obj = $.parseJSON(data);

				if (jQuery.isEmptyObject(json_obj)) {

					$("#ContenidoErrorNonActualizable").html("error al consultar");
					$('#ErroresNonActualizable').modal('show');
				} else {

					$("#descripcionPeriodoCuentaCobroFrm").val("");

					$('#idRegistroFrmPeriodosCuentaCobroInvestigadores').val(opcion);
					$('#exeFrmPeriodosCuentaCobroInvestigadores').val('modificarPeriodosCuentaCobroInvestigadores');
					$("#descripcionPeriodoCuentaCobroFrm").val(json_obj.descripcion);
				}
				loadingSiglo('hide');
				return false;
			},error: function(data){
				loadingSiglo('hide');
			}
		});
	}else if (action=="btnRevisarCCInvestigadoress"){
		$('#idPeriodoCuentaCobro').val(opcion);
		llenarTablaCuentaCobroInvestigadores();
		$('#modalCuentasCobrosInvestigadoresPeriodos').modal('show');
	}
});


$("#DivTablasInvestigadoresCuentaCobroPeriodo").on('click','a',function(){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');

	if (action=="btnIngresarValoresCuentaCobroInvestigadores")
	{
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoPeriodosCuentaCobroInvestigadores.php',
			data: "exe=consultarInformacionCuentaCobro&idCuentaCobro="+opcion,
			success: function(data) {
				var arrayDatos = jQuery.parseJSON(data);
				$('#idCuentaCobroInvestigador').val(opcion);
				$('#valorBiaticoFrmCuentaCobro').val(arrayDatos.valor_biaticos);
				$('#valorAdicionalFrmCuentaCobro').val(arrayDatos.valor_adicionales);
				$('#observacionesFrmCuentaCobro').val(arrayDatos.observacion);

				$('#modalIngresarValoresCuentaCobro').modal('show');
				llenarTablaTipoCasosAseguradoraCuentaCobro(opcion);
				loadingSiglo('hide');

				return false;
			}
		});	

	}else if (action=="btnCerrarCuentaCobroInvestigadores"){
		ModalRegistrosOut("Permitir",opcion,"tablaInvestigadoresCuentaCobroPeriodo","vigenciaInvestigadoresCuentaCobroPeriodo");
	}else if (action=="btnVerCuentaCobroInvestigadores"){
		printJS("plugins/cuenta_cobro/cuenta.php?idCuentaCobro="+opcion);
	}
});

$("#DivTablas9").on('click','a',function(){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');

	if (action=="btnEliminarResolucionesFacturacion"){
		$("#GestionResolucionesFacturacion").modal("hide");
		ModalRegistrosOut("Eliminar",opcion,"tablaResolucionesFacturacion","eliminarResolucionFacturacion");
	}
});

$('#btnSubmitFrmEmpleado').click(function(e){

	loadingSiglo('show','Guardando Rmpleado...');

	var val1=1; var val2=1; var val3=1;var mensaje="";

	if ($('#nombresEmpleadoFrm').val()==""){
		val1=2;
		mensaje+="Debe Ingresar Nombres de Empleado<br>";
	}else{
		val1=1;
	}

	if ($('#apellidosEmpleadoFrm').val()==""){
		val2=2;
		mensaje+="Debe Ingresar Apellidos de Empleado<br>";
	}else{
		val2=1;
	}

	if ($('#identificacionEmpleadoFrm').val()==""){
		val3=2;
		mensaje+="Debe Ingresar Identificacion de Empleado<br>";
	}else{
		val3=1;
	}

	if (val1==2 || val2==2 || val3==2){
		$("#ContenidoErrorNonActualizable").html(mensaje);
		$('#ErroresNonActualizable').modal('show');
		loadingSiglo('hide');
	}else{

		var formEmpleados  = "exe="+$('#exeFrmEmpleado').val()+"&nombresEmpleadoFrm="+$("#nombresEmpleadoFrm").val()+"&apellidosEmpleadoFrm="+$("#apellidosEmpleadoFrm").val()+"&tipoIdentificacionEmpleadoFrm="+$('#tipoIdentificacionEmpleadoFrm option:selected').val()+"&identificacionEmpleadoFrm="+$("#identificacionEmpleadoFrm").val()+"&tipoEmpleadoFrm="+$('#tipoEmpleadoFrm option:selected').val()+"&telefonoEmpleadoFrm="+$('#telefonoEmpleadoFrm').val()+"&direccionEmpleadoFrm="+$('#direccionEmpleadoFrm').val()+"&correoEmpleadoFrm="+$('#correoEmpleadoFrm').val()+"&idRegistroEmpleado="+$('#idRegistroEmpleado').attr("name")+"&idUsuario="+$('#btnLogout').attr('name');

		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoEmpleadosNomina.php',
			data: formEmpleados,
			success: function(data) {
				var arrayDatos = jQuery.parseJSON(data);

				if (arrayDatos.respuesta==1){
					$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente");
					$('#tablaGestionNomina').DataTable().ajax.reload();
					$('#FrmAddEmpleadosNomina').modal('hide');
					$('#ErroresNonActualizable').modal('show');

				}else if(arrayDatos.respuesta==2){
					$("#ContenidoErrorNonActualizable").html("Error al Ejecutar Proceso. Contacte al administrador de sistema");
					$('#ErroresNonActualizable').modal('show');

				}else if(arrayDatos.respuesta==3){
					$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente. Error al Guardar Log de Eventos");
					$('#ErroresNonActualizable').modal('show');

				}else if(arrayDatos.respuesta==4){
					$("#ContenidoErrorNonActualizable").html("Este Usuario ya Existe");
					$('#ErroresNonActualizable').modal('show');
				}

				loadingSiglo('hide');
				return false;
			},error: function(data){
				loadingSiglo('hide');
			}
		});
	}
});	


$('#BtnAddEmpleadosNomina').click(function(e){
	$('#btnSubmitFrmEmpleado').html('Registrar');
	$('#exeFrmEmpleado').val('registrarEmpleados');
	$('#tituloFrmEmpleadosNomina').html('Registrar Empleados');
	limpiaForm("#FrmEmpleadosNomina");
	$('#FrmAddEmpleadosNomina').modal('show');
});	

$('#btnFiltrarEmpleadosNomina').click(function(e){
	limpiaForm("#FormBusqEmpleadosNomina");
	$('#FrmBusqEmpleadosNomina').modal('show');
});	

$('#btnSubmitBuscarEmpleadosNomina').click(function(e){
	$('#tablaGestionNomina').DataTable().ajax.reload();
	$('#DivTablaGestionNomina').show();
});


$('#btnSubmitFrmPeriodosCuentaCobroInvestigadores').click(function(e){
	loadingSiglo('show', 'Guardando Resoluciones...');
	var val1=1; var val2=1; var val3=1; var val4=1; var val5=1; var mensaje="";

	if ($('#descripcionPeriodoCuentaCobroFrm').val()==""){
		val1=2;
		mensaje+="Debe Ingresar Descripcion del Periodo<br>";
	}else{
		val1=1;		
	}

	if (val1==2 || val2==2 || val3==2 || val4==2){
		$("#ContenidoErrorNonActualizable").html(mensaje);
		$('#ErroresNonActualizable').modal('show');
		loadingSiglo('hide');
	}else{
		var formCuentasCobroInvestigadores = "exe="+$('#exeFrmPeriodosCuentaCobroInvestigadores').val()+
		"&descripcion_periodo="+$('#descripcionPeriodoCuentaCobroFrm').val()+
		"&id_periodo="+$('#idRegistroFrmPeriodosCuentaCobroInvestigadores').val()+
		"&idUsuario="+$('#btnLogout').attr('name');

		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoPeriodosCuentaCobroInvestigadores.php',
			data: formCuentasCobroInvestigadores,
			success: function(data) {
				if (data==1){
					$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente");
					llenarTablaPeriodosCuentaCobroInvestigadores();
					$("#descripcionPeriodoCuentaCobroFrm").val("");

					$('#idRegistroFrmPeriodosCuentaCobroInvestigadores').val("idRegistroFrmPeriodosCuentaCobroInvestigadores");
					$('#exeFrmPeriodosCuentaCobroInvestigadores').val('registrarPeriodosCuentaCobroInvestigadores');
					$('#ErroresNonActualizable').modal('show');

				}else if(data==2){
					$("#ContenidoErrorNonActualizable").html("Error al Ejecutar Proceso. Contacte al administrador de sistema");
					$('#ErroresNonActualizable').modal('show');

				}else if(data==3){
					$("#ContenidoErrorNonActualizable").html("Actualmente existe una resolucion vigente");
					$('#ErroresNonActualizable').modal('show');

				}else if(data==4){
					$("#ContenidoErrorNonActualizable").html("Este registro ya Existe");
					$('#ErroresNonActualizable').modal('show');
				}
				loadingSiglo('hide');
				return false;
			},error: function(data){
				loadingSiglo('hide');
			}
		});
	}
});	

$('#btnSubmitFrmResoluciones').click(function(e){
	loadingSiglo('show', 'Guardando Resoluciones...');
	var val1=1; var val2=1; var val3=1; var val4=1; var val5=1; var mensaje="";

	if ($('#numResResolucionFrm').val()==""){
		val1=2;
		mensaje+="Debe Ingresar Nombres del Usuario<br>";
	}else{
		val1=1;		
	}

	if ($('#fechaInicialResolucionFrm').val()==""){
		val2=2;
		mensaje+="Debe Ingresar Apellidos del Usuario<br>";
	}else{
		val2=1;		
	}

	if ($('#numInicialResolucionFrm').val()==""){
		val3=2;
		mensaje+="Debe Ingresar usuario<br>";
	}else{
		val3=1;		
	}

	if ($('#numFinalResolucionFrm').val()==""){
		val4=2;
		mensaje+="Debe Ingresar usuario<br>";
	}else{
		val4=1;		
	}

	if (val1==2 || val2==2 || val3==2 || val4==2){
		$("#ContenidoErrorNonActualizable").html(mensaje);
		$('#ErroresNonActualizable').modal('show');
		loadingSiglo('hide');
	}else{
		var formResolucionFacturacion = "exe="+$('#exeFrmResoluciones').val()+
		"&numero_resolucion="+$('#numResResolucionFrm').val()+
		"&fecha_resolucion="+$('#fechaInicialResolucionFrm').val()+
		"&num_inicial_resolucion="+$('#numInicialResolucionFrm').val()+
		"&num_final_resolucion="+$('#numFinalResolucionFrm').val()+
		"&idUsuario="+$('#btnLogout').attr('name');

		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoResolucionFacturacion.php',
			data: formResolucionFacturacion,
			success: function(data) {

				if (data==1){
					$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente");
					llenarTablaResolucionesFacturacion();
					$('#frmResolucionFacturacion').modal('hide');
					$('#ErroresNonActualizable').modal('show');

				}else if(data==2){
					$("#ContenidoErrorNonActualizable").html("Error al Ejecutar Proceso. Contacte al administrador de sistema");
					$('#ErroresNonActualizable').modal('show');

				}else if(data==3){
					$("#ContenidoErrorNonActualizable").html("Actualmente existe una resolucion vigente");
					$('#ErroresNonActualizable').modal('show');

				}else if(data==4){
					$("#ContenidoErrorNonActualizable").html("Este registro ya Existe");
					$('#ErroresNonActualizable').modal('show');
				}
				loadingSiglo('hide');
				return false;
			},error: function(data){
				loadingSiglo('hide');
			}
		});
	}
});	

$('#BtnAddResolucionFacturacion').click(function(e){	
	$('#btnSubmitFrmResoluciones').html("Registrar");
	$('#exeFrmResoluciones').val("registrarResolucionesFacturacion");
	$('#frmResolucionFacturacion').modal('show');
});

$('a').click(function(e){

	var opcion=$(this).attr('name');
	var action=$(this).attr('id');
	var parametros="opcion="+opcion+"&action="+action;

	if (action=="btnProgramas"){
		window.location.href = "?opt="+opcion;
	}else if(action=="btnProfile"){
		window.location.href = "?opt=PROFILE";
	}else if (action=="btnProgramasModales"){
		loadingSiglo('show', 'Cargando...');
		var form =  "exe=consultarOpcion&idOpcion="+opcion;

		$.ajax({
			type: 'POST',
			url: 'class/consultasBasicas.php',
			data: form,
			success: function(data) {
				var arrayDatos = jQuery.parseJSON(data);
				$('#'+arrayDatos.ruta).modal('show');
				loadingSiglo('hide');
				return false;
			},error: function(data){
				loadingSiglo('hide');
			}
		});
	}
});	

$('#btnLogout').click(function(e) {
	var formLogin =  "exe=logout&usuario="+$(this).attr('name');
	loadingSiglo('show', 'Cerrando Sesión...');
	$.ajax({
		type: 'POST',
		url: 'class/login.php',
		data: formLogin,
		success: function(data) {

			if (data==2){
				alert("Error al cerrar sesion");
			}else{
				window.location="../";
			}

			loadingSiglo('hide');
			return false;
		},error: function(data){
			loadingSiglo('hide');
		}
	});

	return false;
});	

$("#GestionResolucionesFacturacion").on('shown.bs.modal', function () {
	llenarTablaResolucionesFacturacion();
});


$("#GestionPeriodosCuentaCobroInvestigadores").on('shown.bs.modal', function () {
	llenarTablaPeriodosCuentaCobroInvestigadores();
});

function llenarTablaPeriodosCuentaCobroInvestigadores(){
	loadingSiglo('show', 'Cargando Resoluciones...');
	$('#tablaPeriodosCuentaCobro').DataTable( {
		"select": true,
		"destroy":true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "consultarPeriodosCuentaCobroInvestigadores";
			}
		},
		initComplete: function(settings, json) {
			loadingSiglo('hide');
		},
		"bPaginate":true,
		"bProcessing": true,
		"pageLength": 6,
		"ordering": false,
		"bFilter" : true,               
		"bLengthChange": false,
		"columns": [
		{ mData: 'descripcion', "orderable": "false" } ,
		{ mData: 'opciones', "orderable": "false" }
		],
		"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}


function llenarTablaCuentaCobroInvestigadores(){	

	loadingSiglo('show', 'Cargando Resoluciones...');
	$('#tablaInvestigadoresCuentaCobroPeriodo').DataTable( {
		"select": false,
		"destroy":true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "consultarCuentaCobroInvestigadores";
				d.idPeriodo = $('#idPeriodoCuentaCobro').val();
			}
		},
		initComplete: function(settings, json) {
			loadingSiglo('hide');
		},
		"bPaginate":true,
		"bProcessing": true,
		"pageLength": 6,
		"ordering": false,
		"bFilter" : true,               
		"bLengthChange": false,
		"columns": [
		{ mData: 'nombre_investigador', "orderable": "false" } ,
		{ mData: 'identificacion_investigador', "orderable": "false" } ,
		{ mData: 'cantidad_investigaciones', "orderable": "false" } ,
		{ mData: 'valor_investigaciones', "orderable": "false" } ,
		{ mData: 'valor_biaticos', "orderable": "false" } ,
		{ mData: 'valor_adicionales', "orderable": "false" } ,
		{ mData: 'valor_total', "orderable": "false" } ,
		{ mData: 'opciones', "orderable": "false" }
		],
		"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}



function llenarTablaResolucionesFacturacion(){
	loadingSiglo('show', 'Cargando Resoluciones...');
	$('#tablaResolucionesFacturacion').DataTable( {
		"select": false,
		"destroy":true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "consultarResolucionesFacturacion";
			}
		},
		initComplete: function(settings, json) {
			loadingSiglo('hide');
		},
		"bPaginate":true,
		"bProcessing": true,
		"pageLength": 6,
		"ordering": false,
		"bFilter" : true,               
		"bLengthChange": false,
		"columns": [
		{ mData: 'resolucion', "orderable": "false" } ,
		{ mData: 'vigencia', "orderable": "false" } ,
		{ mData: 'rango_numeracion', "orderable": "false" },
		{ mData: 'opciones', "orderable": "false" }
		],
		"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}

function llenarTablaReporteDiarioValidacionesIPS(fechaInicio,fechaFin,idAseguradora,tipoCaso){
	loadingSiglo('show','Cargando Reporte Diario...');
	$('#tablaReporteDiarioValidacionesIPS').DataTable( {
		scrollX: true,
		dom: 'Bfrtip',
		buttons: [{
			extend: 'excelHtml5',
			exportOptions: {
				columns: ':visible'
			},
			title: 'Reporte Registro Diario Validaciones IPS'
		},{
			extend: 'colvis'
		}],
		"select": false,
		"destroy":true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "reportRegistroDiarioValidacionesIPS";
				d.fechaFinReporteBasico = fechaFin;
				d.fechaInicioReporteBasico = fechaInicio;
				d.aseguradoraReporteBasico = idAseguradora;
				d.tipoCasoReporteBasico = tipoCaso;
			}
		},
		initComplete: function(settings, json) {
			loadingSiglo('hide');
		},
		"bPaginate":true,
		"bFilter" : true,        
		"bProcessing": true,
		"pageLength": 10,
		"columns": [
		{ title: 'Codigo', mData: 'codigo', "orderable": "true" } ,
		{ title: 'Tipo De Caso', mData: 'tipo_caso', "orderable": "true" } ,
		{ title: 'Departamento Entidad', mData: 'departamento_entidad', "orderable": "true" } ,
		{ title: 'Nombre Entidad', mData: 'nombre_entidad', "orderable": "true" } ,
		{ title: 'Identificacion Entidad', mData: 'identificacion_entidad', "orderable": "true" } 
		],
		"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
	$('#DivReporteDiarioValidaciones').show();
}

$('#btnGuardarValoresCuentaCobroInvestigador').click(function(e) 
{
	var val1=0;var val2=0;

	var casosCuentaCobro=[];		
	$('#tablaIngresarValorCasosCuentaCobro').DataTable().rows().every(function(){
		var data=this.node();
		var data3=this.data();
		var data2={};		

		var val1=0;
		if ($(data).find("#valorCasoInvestigacionesAseguradoraCuentaCobro").val()!="")
		{
			data2.idAseguradoraInvestigacionesAseguradoraCuentaCobro=data3["id_aseguradora"];
			data2.cantidadInvestigacionesAseguradoraCuentaCobro=$(data).find("#cantidadInvestigacionesAseguradoraCuentaCobro").val();
			data2.valorCasoInvestigacionesAseguradoraCuentaCobro=$(data).find("#valorCasoInvestigacionesAseguradoraCuentaCobro").val();
			data2.tipoCasoInvestigacionesAseguradoraCuentaCobro=data3["id_tipo_caso"];

			data2.tipoZonaInvestigacionesAseguradoraCuentaCobro=data3["id_tipo_zona"];
			data2.tipoAuditoriaInvestigacionesAseguradoraCuentaCobro=data3["id_tipo_auditoria"];
			data2.resultadoInvestigacionesAseguradoraCuentaCobro=data3["id_resultado"];

			casosCuentaCobro.push(data2);

		}
	});

	if (casosCuentaCobro.length>0){

		loadingSiglo('show', 'Ejecutando Proceso');

		var formValoresCasosCuentaCobro = new FormData();
		formValoresCasosCuentaCobro.append("exe","guardarValoresCasosCuentaCobro");
		formValoresCasosCuentaCobro.append("idUsuario",$('#btnLogout').attr('name'));
		formValoresCasosCuentaCobro.append("idCuentaCobroInvestigador",$('#idCuentaCobroInvestigador').val());
		formValoresCasosCuentaCobro.append("valorBiaticoFrmCuentaCobro",$('#valorBiaticoFrmCuentaCobro').val());
		formValoresCasosCuentaCobro.append("valorAdicionalFrmCuentaCobro",$('#valorAdicionalFrmCuentaCobro').val());
		formValoresCasosCuentaCobro.append("observacionesFrmCuentaCobro",$('#observacionesFrmCuentaCobro').val());
		formValoresCasosCuentaCobro.append("casosCuentaCobro",JSON.stringify(casosCuentaCobro));

		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoPeriodosCuentaCobroInvestigadores.php',
			data: formValoresCasosCuentaCobro,
			cache: false,
			contentType: false,
			processData: false,
			success: function(data) {
				loadingSiglo('hide');

				if (data==1){	
					llenarTablaCuentaCobroInvestigadores()
					$.notify("Proceso ejecutado satisfactoriamente",{"globalPosition":"bottom left",'className': 'success'});
					$('#modalIngresarValoresCuentaCobro').modal('show');

				}else if (data==2){	
					$.notify("Error al ejecutar Proceso",{"globalPosition":"bottom left"});
				}else if (data==3){	
					$.notify("Debe cargar soporte",{"globalPosition":"bottom left"});
				}
				return false;
			}
		});	
	}
});	

function periodoTexto(valor, num){
	var valorTemp = valor.split("-");
	var anio = valorTemp[0];
	var mes = valorTemp[1];
	var descripcion = "";

	switch(mes) {
		case "01":
			descripcion = "ENERO "+anio+" - "+num;
		break;

		case "02":
			descripcion = "FEBRERO "+anio+" - "+num;
		break;

		case "03":
	    	descripcion = "MARZO "+anio+" - "+num;
	    break;

	    case "04":
	    	descripcion = "ABRIL "+anio+" - "+num;
	    break;

	    case "05":
	    	descripcion = "MAYO "+anio+" - "+num;
	    break;

	    case "06":
	    	descripcion = "JUNIO "+anio+" - "+num;
	    break;

	    case "07":
	    	descripcion = "JULIO "+anio+" - "+num;
	    break;

	    case "08":
	    	descripcion = "AGOSTO "+anio+" - "+num;
	    break;

	    case "09":
	    	descripcion = "SEPTIEMBRE "+anio+" - "+num;
	    break;

	    case "10":
	    	descripcion = "OCTUBRE "+anio+" - "+num;
	    break;

	    case "11":
	    	descripcion = "NOVIEMBRE "+anio+" - "+num;
	    break;

	    case "12":
	    	descripcion = "DICIEMBRE "+anio+" - "+num;
	    break;

		default:
			descripcion = "";
	}

	return descripcion;
}

function puntuarNumero(num) {
	if (!num || num == 'NaN') return '-';
	if (num == 'Infinity') return '&#x221e;';
	num = num.toString().replace(/\$|\,/g, '');

	if (isNaN(num))
		num = "0";

	sign = (num == (num = Math.abs(num)));
	num = Math.floor(num * 100 + 0.50000000001);
	cents = num % 100;
	num = Math.floor(num / 100).toString();

	if (cents < 10)
		cents = "0" + cents;

	for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3) ; i++)
		num = num.substring(0, num.length - (4 * i + 3)) + '.' + num.substring(num.length - (4 * i + 3));

	return (((sign) ? '' : '-') + num);
}