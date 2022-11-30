$('#BtnBuscarAseguradora').click(function(e){
	llenarTablaAseguradora();
	$('#DivTablaGestionAseguradora').show();
});

$("#DivTablas7").on('click','a',function(){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');
	if (action=="btnEliminarIndicador"){
		ModalRegistrosOut("Eliminar",opcion,"tablaAsignacionIndicadorAseguradora","eliminarIndicadorAseguradora");
	}
});

$("#DivTablas8").on('click','a',function(){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');
	if (action=="btnEliminarRangoValorTarifaAmparo"){
		ModalRegistrosOut("Eliminar",opcion,"tablaRangoValorTarifaAmparo","eliminarRangoValorTarifa");
	}
});

$("#DivTablas6").on('click','a',function(){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');
	if (action=="btnEliminarClinicaCiudadesTarAmp"){
		ModalRegistrosOut("Eliminar",opcion,"tablaClinicaCiudadesTarifaAmparo","eliminarClinicaCiudadTarifaAmparo");
	}
	else if (action=="btnAsignarTarifasClinicaCiudadesTarAmp") {
		limpiaForm("#frmAsignarRangosValoresTarifa");
		$('#idRegistroCiudadValorTarifa').val(opcion);
		$('#idRegistroAsegAmparoValorTarifa').val($('#idRegistroAseguradoraClinicaCiudad').val());
		llenarTablaRangoValorTarifaAmparo();
		$('#modalAsignarRangoValor').modal('show');
	}
});

$("#DivTablas5").on('click','a',function(){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');

	if (action=="btnEliminarAmparoAseguradora"){
		ModalRegistrosOut("Eliminar",opcion,"tablaAsignacionAmparoAseguradora","eliminarAmparoAseguradora");
	}
	else if (action=="btnAsignarTarifasAmparo"){

		var form="exe=consultarParametroAmparo&idAmparo="+opcion;
		$.ajax({
			type: 'POST',
			url: 'class/consultasBasicas.php',
			data: form,
			success: function(data) {
				var json_obj = $.parseJSON(data);

				if (jQuery.isEmptyObject(json_obj)) {
					$("#ContenidoErrorNonActualizable").html("error al consultar");
					$('#ErroresNonActualizable').modal('show');
				}else{

					$('.idAmparoMetodoFact').val(opcion);

					if (json_obj.rutaModal=="modalValorCaso"){
						limpiaForm("#formValorCasoUnico");
						var formValorCaso =  "exe=consultarTarifaValorCaso&idAmparoMetodoFact="+opcion;
						$.ajax({
							type: 'POST',
							url: 'class/consultasManejoAseguradoras.php',
							data: formValorCaso,
							success: function(data) {
								var arrayDatos = jQuery.parseJSON(data);
								$('#valorCasoUnico').val(arrayDatos.valor_caso);
								$('#'+json_obj.rutaModal).modal('show');
								return false;
							}
						});
					}
					else if (json_obj.rutaModal=="modalValorCasoCiudad"){
						llenarTablaClinicaCiudadesTarifaAmparo();
						$('#'+json_obj.rutaModal).modal('show');
					}
					else if (json_obj.rutaModal=="modalValorCasoResultado"){
						limpiaForm("#frmValorCasoResultado");
						var formValorCasoResultado =  "exe=consultarTarifaValorCasoResultado&idAmparoMetodoFact="+opcion;
						$.ajax({
							type: 'POST',
							url: 'class/consultasManejoAseguradoras.php',
							data: formValorCasoResultado,
							success: function(data) {
								var arrayDatos = jQuery.parseJSON(data);

								$('#valorCasoAtender').val(arrayDatos.valor_caso_atender);
								$('#valorCasoNoAtender').val(arrayDatos.valor_caso_no_atender);
								$('#'+json_obj.rutaModal).modal('show');
								return false;
							}
						});
					}
					else if (json_obj.rutaModal=="modalValorCasoZona"){
						limpiaForm("#frmValorCasoResultado");
						var formValorCasoZona =  "exe=consultarTarifaValorCasoZona&idAmparoMetodoFact="+opcion;

						$.ajax({
							type: 'POST',
							url: 'class/consultasManejoAseguradoras.php',
							data: formValorCasoZona,
							success: function(data) {
								var arrayDatos = jQuery.parseJSON(data);

								$('#valorCasoRural').val(arrayDatos.valor_caso_rural);
								$('#ValorCasoUrbano').val(arrayDatos.valor_caso_urbano);
								$('#'+json_obj.rutaModal).modal('show');
								return false;
							}
						});
					}
					else if (json_obj.rutaModal=="modalValorCasoCiudad"){
						var formValorCasoZona =  "exe=consultarClinicaCiudadesAmparo&idAmparoMetodoFact="+opcion;
						$.ajax({
							type: 'POST',
							url: 'class/consultasManejoAseguradoras.php',
							data: formValorCasoZona,
							success: function(data) {
								var arrayDatos = jQuery.parseJSON(data);
								$('#valorCasoRural').val(arrayDatos.valor_caso_rural);
								$('#ValorCasoUrbano').val(arrayDatos.valor_caso_urbano);
								$('#'+json_obj.rutaModal).modal('show');
								return false;
							}
						});
					}
					return false;
				}
			}
		});
	}
});

$("#DivTablas").on('click','a',function(){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');
	if (action=="btnEditarAseguradora"){
		var form =  "exe=consultarAseguradora&registroAseguradora="+opcion;
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoAseguradoras.php',
			data: form,
			success: function(data) {
				var json_obj = $.parseJSON(data);
				if (jQuery.isEmptyObject(json_obj)) {

					$("#ContenidoErrorNonActualizable").html("error al consultar");
					$('#ErroresNonActualizable').modal('show');
				} 
				else {
					limpiaForm("#frmAseguradora");
					$('#idRegistroAseguradora').val(opcion);
					$('#exeAseguradora').val('modificarAseguradora');
					$("#nombreFrmAsegurador").val(json_obj.nombre);
					$("#nitFrmAseguradora").val(json_obj.identificacion);
					$("#digverFrmAseguradora").val(json_obj.dig_ver);
					$("#dirFrmAseguradora").val(json_obj.direccion);
					$("#telFrmAseguradora").val(json_obj.telefono);
					$("#responsableFrmAseguradora").val(json_obj.responsable);
					$("#cargoFrmAseguradora").val(json_obj.cargo);
					$("#indicativoFrmAseguradora").val(json_obj.indicativo);
					$("#atenderFrmAseg").val(json_obj.resultado_atender).change();
					$("#noAtenderFrmAseg").val(json_obj.resultado_no_atender).change();

					$('#modalCrearAseguradora').modal('show');
				}
				return false;
			}
		});
	}
	else if (action=="btnEliminarRegistroAseguradora"){
		ModalRegistrosOut("Eliminar",opcion,"tablaGestionAseguradora","eliminarAseguradoras");
	}
	else if (action=="btnPermitirAseguradora"){
		ModalRegistrosOut("Permitir",opcion,"tablaGestionAseguradora","vigenciaAseguradora");	
	}
	else if (action=="btnParametrosAseguradora"){
		$('#idRegistroAsignacionClinicaAseguradora').val(opcion);
		$('#idRegistroAsignacionAmparoAseguradora').val(opcion);
		$('#idRegistroAsignacionIndicadorAseguradora').val(opcion);
		llenarTablaAsignacionAmparoAseguradora();
		llenarTablaAsignacionClinicaAseguradora();
		llenarTablaAsignacionIndicadorAseguradora();
		$('#modalParametrosAseguradora').modal('show');
	}
});

$('#BtnAddAseguradora').click(function(e){

	$('#exeAseguradora').val('registrarAseguradora');

	$('#modalCrearAseguradora').modal('show');
});

$('#btnGuardarAsignacionClinicaAseguradora').click(function(e) {

	var filas = $("#tablaAsignacionClinicaAseguradora").find("tr");
	var codigosClinica=[];
	for(i=1; i<filas.length; i++){ 
		var celdas = $(filas[i]).find("td"); 

		if ($($(celdas[0]).children("input")[0]).prop('checked')){
			var opcion = $($(celdas[0]).children("input")[0]).val();
			var data2={};
			data2.codigoClinica=opcion;
			codigosClinica.push(data2);
		}
	}
	var frmAsignarClinica =  "exe=asignarClinicaAseguradora&idAseguradora="+$("#idRegistroAsignacionClinicaAseguradora").val()+"&idUsuario="+$('#btnLogout').attr('name')+"&clinicasAsignar="+JSON.stringify(codigosClinica);
	$.ajax({
		type: 'POST',
		url: 'class/consultasManejoAseguradoras.php',
		data: frmAsignarClinica,
		success: function(data) {
			if (data==2){
				$("#ContenidoErrorNonActualizable").html("Error al ejecutar Procedimiento");
				$('#ErroresNonActualizable').modal('show');
			}else{
				$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente");
				$('#ErroresNonActualizable').modal('show');
			}
			return false;
		}
	});
});	

$('#btnSubmitValorCasoUnico').click(function(e) {
	var formValorCaso =  "exe=registrarTarifaValorCaso&valorCasoUnico="+$("#valorCasoUnico").val()+"&idAmparoMetodoFact="+$("#idAmparoAsegCasoUnico").val()+"&idUsuario="+$('#btnLogout').attr('name');
	$.ajax({
		type: 'POST',
		url: 'class/consultasManejoAseguradoras.php',
		data: formValorCaso,
		success: function(data) {
			if (data==2){
				$("#ContenidoErrorNonActualizable").html("Error al ejecutar Procedimiento");
				$('#ErroresNonActualizable').modal('show');
			}else{
				$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente");
				$('#modalValorCaso').modal('hide');
				$('#ErroresNonActualizable').modal('show');
			}
			return false;
		}
	});
	return false;
});	

$('#btnSubmitValorCasoResultado').click(function(e) {
	var formValorCasoResultado =  "exe=registrarTarifaValorCasoResultado&valorCasoAtender="+$("#valorCasoAtender").val()+"&valorCasoNoAtender="+$("#valorCasoNoAtender").val()+"&idAmparoMetodoFact="+$("#idAmparoAsegCasoResultado").val()+"&idUsuario="+$('#btnLogout').attr('name');
	$.ajax({
		type: 'POST',
		url: 'class/consultasManejoAseguradoras.php',
		data: formValorCasoResultado,
		success: function(data) {
			if (data==2){
				$("#ContenidoErrorNonActualizable").html("Error al ejecutar Procedimiento");
				$('#ErroresNonActualizable').modal('show');
			}else{
				$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente");
				$('#modalValorCasoResultado').modal('hide');
				$('#ErroresNonActualizable').modal('show');
			}

			return false;
		}
	});

	return false;
});	

$('#btnSubmitValorCasoZona').click(function(e) {
	var formValorCasoResultado =  "exe=registrarTarifaValorCasoZona&valorCasoUrbano="+$("#ValorCasoUrbano").val()+"&valorCasoRural="+$("#valorCasoRural").val()+"&idAmparoMetodoFact="+$("#idAmparoAsegCasoResultado").val()+"&idUsuario="+$('#btnLogout').attr('name');
	$.ajax({
		type: 'POST',
		url: 'class/consultasManejoAseguradoras.php',
		data: formValorCasoResultado,
		success: function(data) {
			if (data==2){
				$("#ContenidoErrorNonActualizable").html("Error al ejecutar Procedimiento");
				$('#ErroresNonActualizable').modal('show');

			}else{
				$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente");
				$('#modalValorCasoZona').modal('hide');
				$('#ErroresNonActualizable').modal('show');
			}

			return false;
		}
	});

	return false;
	return false;
});	

function llenarTablaAseguradora(){

	$('#tablaGestionAseguradora').DataTable( {
		"destroy": true,
		"select": true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "consultarAseguradoras";
				d.nombreBuscarAseguradora = $('#nombreBuscarAseguradora').val();
				d.identificacionBuscarAseguradora = $('#identificacionBuscarAseguradora').val();
			}
		},
		"bPaginate":true,
		"bProcessing": true,
		"pageLength": 6,
		"columns": [
		{ mData: 'nombreAseguradora', "orderable": "true" } ,
		{ mData: 'identificacionAseguradora', "orderable": "true" } ,
		{ mData: 'opciones', "orderable": "false" }
		],
		"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}

function llenarTablaAsignacionAmparoAseguradora(){
	$('#tablaAsignacionAmparoAseguradora').DataTable( {
		"destroy": true,
		"select": true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "consultarAmparosAseguradoras";
				d.idAsignacionAmparo = $('#idRegistroAsignacionAmparoAseguradora').val();
			}
		},
		"bPaginate":true,
		"bProcessing": true,
		"pageLength": 3,
		"columns": [
		{ mData: 'amparoAseguradora', "orderable": "true" } ,
		{ mData: 'metodFacturacion', "orderable": "true" } ,

		{ mData: 'opcionesAmparo', "orderable": "false" }

		],
		"language": 
		{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}

function llenarTablaAsignacionIndicadorAseguradora(){

	$('#tablaAsignacionIndicadorAseguradora').DataTable( {
		"destroy": true,
		"select": true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {

				d.exeTabla = "consultarIndicadorAseguradoras";
				d.idAsignacionIndicador = $('#idRegistroAsignacionIndicadorAseguradora').val();
			}
		},
		"bPaginate":true,
		"bProcessing": true,
		"pageLength": 3,
		"columns": [
		{ mData: 'resultadoAseguradora', "orderable": "true" } ,
		{ mData: 'descripcionIndicador', "orderable": "true" } ,
		{ mData: 'codigoIndicador', "orderable": "true" } ,

		{ mData: 'opcionesIndicador', "orderable": "false" }

		],
		"language": 
		{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}

function llenarTablaClinicaCiudadesTarifaAmparo(){

	$('#tablaClinicaCiudadesTarifaAmparo').DataTable( {
		"destroy": true,
		"select": true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "consultarClinicaCiudadesAseguradoras";
				d.idAsegAmparo = $('#idRegistroAseguradoraClinicaCiudad').val();

			}
		},
		"bPaginate":true,
		"bProcessing": true,
		"pageLength": 6,
		"columns": [
		{ mData: 'nomCiudad', "orderable": "true" } ,
		{ mData: 'nomClinica', "orderable": "true" } ,

		{ mData: 'opciones', "orderable": "false" }

		],
		"language": 
		{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}

function llenarTablaRangoValorTarifaAmparo(){

	$('#tablaRangoValorTarifaAmparo').DataTable( {
		"destroy": true,
		"select": true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {

				d.exeTabla = "consultarRangoValorTarifaAmparo";
				d.idAsegAmparo = $('#idRegistroAsegAmparoValorTarifa').val();
				d.idCiudad = $('#idRegistroCiudadValorTarifa').val();
			}
		},
		"bPaginate":true,
		"bProcessing": true,
		"pageLength": 6,
		"columns": [
		{ mData: 'rangoDesdeValorTarifa', "orderable": "true" } ,
		{ mData: 'rangoHastaValorTarifa', "orderable": "true" } ,

		{ mData: 'costoValorTarifa', "orderable": "false" },
		{ mData: 'opciones', "orderable": "false" }
		],
		"language": 
		{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}

function llenarTablaAsignacionClinicaAseguradora(){
	$('#tablaAsignacionClinicaAseguradora').DataTable( {
		"destroy": true,
		"select": true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {

				d.exeTabla = "consultarClinicasAseguradoras";
				d.idAsignacionClinica = $('#idRegistroAsignacionClinicaAseguradora').val();
			}
		},
		"bPaginate":false,
		"bProcessing": true,
		"scrollY": "250px",
		"columns": [
		{ mData: 'seleccClinica', "orderable": "true" } ,
		{ mData: 'nomClinica', "orderable": "true" } ,

		{ mData: 'nitClinica', "orderable": "false" },
		{ mData: 'ciudadClinica', "orderable": "false" }
		],
		"language": 
		{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}

$('#btnguardarAseguradora').click(function(e){

	var val1=1; var val2=1; var val3=1; var val4=1;var val8=1;
	var val5=1;var val6=1; var val7=1;var mensaje="";

	if ($('#nombreFrmAsegurador').val()==""){
		val1=2;
		mensaje+="Debe Ingresar Nombres de la Aseguradora<br>";
	}else{
		val1=1;
	}

	if ($('#nitFrmAseguradora').val()==""){
		val2=2;
		mensaje+="Debe Ingresar El Nit de la Aseguradora<br>";
	}else{
		val2=1;
	}

	if ($('#digverFrmAseguradora').val()==""){
		val3=2;
		mensaje+="Debe Ingresar el DV del Nit de la Aseguradora<br>";
	}else{
		val3=1;
	}

	if ($('#dirFrmAseguradora').val()==""){
		val4=2;
		mensaje+="Debe Ingresar La direccioón de la Aseguradora<br>";
	}else{
		val4=1;
	}

	if ($('#telFrmAseguradora').val()==""){
		val5=2;
		mensaje+="Debe Ingresar el Teléfono de la Aseguradora<br>";
	}else{
		val5=1;
	}

	if ($('#responsableFrmAseguradora').val()==""){
		val6=2;
		mensaje+="Debe Ingresar el Responsable de la Aseguradora<br>";
	}else{
		val6=1;
	}

	if ($('#cargoFrmAseguradora').val()==""){
		val7=2;
		mensaje+="Debe Ingresar el Cargo del Responsable de la Aseguradora<br>";
	}else{
		val7=1;
	}

	if ($('#indicativoFrmAseguradora').val()==""){
		val8=2;
		mensaje+="Debe Ingresar el indicativo de la Aseguradora<br>";
	}else{
		val8=1;
	}

	if (val1==2 || val2==2 || val3==2 || val4==2 || val5==2 || val6==2 || val7==2 || val8==2){
		$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
		$("#ContenidoErrorNonActualizable").html(mensaje);
		$('#ErroresNonActualizable').modal('show');
	}
	else{
		var form = "exe="+$('#exeAseguradora').val()+"&nombreAseguradora="+$('#nombreFrmAsegurador').val()+"&nitAseguradora="+$('#nitFrmAseguradora').val()+"&digVerAseguradora="+$('#digverFrmAseguradora').val()+"&dirAseguradora="+$('#dirFrmAseguradora').val()+"&telAseguradora="+$('#telFrmAseguradora').val()+"&responsableAseguradora="+$('#responsableFrmAseguradora').val()+"&cargoAseguradora="+$('#cargoFrmAseguradora').val()+"&registroAseguradora="+$('#idRegistroAseguradora').val()+"&usuario="+$('#btnLogout').attr('name')+"&indicativoAseguradora="+$('#indicativoFrmAseguradora').val()+"&atenderFrmAseg="+$('#atenderFrmAseg option:selected').val()+"&noAtenderFrmAseg="+$('#noAtenderFrmAseg option:selected').val();
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoAseguradoras.php',
			data: form,
			success: function(data) {

				if (data==1) {
					llenarTablaAseguradora();

					$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente");							
					limpiaForm("#frmAseguradora");
					$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
					$('#modalCrearAseguradora').modal('hide');
					$('#ErroresNonActualizable').modal('show');
				}
				else if(data==3){

					$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});				
					$("#ContenidoErrorNonActualizable").html("El Número del NIT ya se encuentra registrado");
					$('#ErroresNonActualizable').modal('show');
				}
				else{
					alert("error");
				}
			}
		});
	}
});


$('#btnAddRangoValorTarifaAmparo').click(function(e){
	var form = "exe=agregarRangoValorTarifa&idRegistroCiudadValorTarifa="+$("#idRegistroCiudadValorTarifa").val()+"&idRegistroAsegAmparoValorTarifa="+$('#idRegistroAsegAmparoValorTarifa').val()+"&valorRangoDesde="+$('#rangoDesdeFrmValorTarifa').val()+"&valorRangoHasta="+$('#rangoHastaFrmValorTarifa').val()+"&valorCaso="+$('#valorFrmValorTarifa').val()+"&usuario="+$('#btnLogout').attr('name');
	$.ajax({
		type: 'POST',
		url: 'class/consultasManejoAseguradoras.php',
		data: form,
		success: function(data) {

			if (data==1) {
				llenarTablaRangoValorTarifaAmparo();
				$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente");							

				$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});							
				$('#ErroresNonActualizable').modal('show');
			}else if (data==2){
				$("#ContenidoErrorNonActualizable").html("Ya Esta Asignado este amparo para esta aseguradora");							
				$('#ErroresNonActualizable').modal('show');
			}
		}
	});
});


$('#btnAddClinicaCiudadAseg').click(function(e){

	var form = "exe=asignarClinicaCiudadesAmpAseg&idAsegAmparo="+$("#idRegistroAseguradoraClinicaCiudad").val()+"&idClinica="+$('#clinicaAsigCiuClinicaFrm option:selected').val()+"&idCiudad="+$('#ciudadAsigCiuClinicaFrm option:selected').val()+"&usuario="+$('#btnLogout').attr('name');
	$.ajax({
		type: 'POST',
		url: 'class/consultasManejoAseguradoras.php',
		data: form,
		success: function(data) {
			if (data==1) {
				llenarTablaClinicaCiudadesTarifaAmparo();
				$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente");							

				$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});							
				$('#ErroresNonActualizable').modal('show');
			}else if (data==2){
				$("#ContenidoErrorNonActualizable").html("Ya Esta Asignado este amparo para esta aseguradora");							
				$('#ErroresNonActualizable').modal('show');
			}
		}
	});
});


$('#btnGuardarAsignacionAmparoAseguradora').click(function(e){

	var idAmparo = $("#amparoFrmAmpAseg option:selected").val();
	var idModoFact=$('#metodoPagFrmAmpAseg option:selected').val();
	var idAseguradora=$('#idRegistroAsignacionAmparoAseguradora').val();
	var form = "idAseguradora="+idAseguradora+"&exe=asignarAmparosAseguradora&idAmparoMetodo="+idAmparo+"&idMetodoFact="+idModoFact+"&usuario="+$('#btnLogout').attr('name');

	$.ajax({

		type: 'POST',
		url: 'class/consultasManejoAseguradoras.php',
		data: form,
		success: function(data) {
			if (data==1) {
				llenarTablaAsignacionAmparoAseguradora();
				$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente");							
				limpiaForm("#frmAsignacionAmparoAseguradora");
				$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});							
				$('#ErroresNonActualizable').modal('show');
			}else if (data==2){
				$("#ContenidoErrorNonActualizable").html("Ya Esta Asignado este amparo para esta aseguradora");							
				$('#ErroresNonActualizable').modal('show');
			}
		}
	});
});

$('#btnGuardarIndicadorAtenderAseg').click(function(e){
	var idIndicador = $("#indicadorAtenderAseg option:selected").val();
	var idAseguradora=$('#idRegistroAsignacionIndicadorAseguradora').val();
	var codigoAtender=$('#codigoAtenderAseg').val();
	var form = "idAseguradora="+idAseguradora+"&codigoAtender="+codigoAtender+"&exe=asignarIndicadorAtenderAseg&idIndicador="+idIndicador+"&usuario="+$('#btnLogout').attr('name');

	$.ajax({
		type: 'POST',
		url: 'class/consultasManejoAseguradoras.php',
		data: form,
		success: function(data) {
			if (data==1) {
				llenarTablaAsignacionIndicadorAseguradora();
				$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente");							
				limpiaForm("#frmAsignacionAmparoAseguradora");
				$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});							
				$('#ErroresNonActualizable').modal('show');
			}else if (data==2){
				$("#ContenidoErrorNonActualizable").html("Ya Esta Asignado este Indicador para esta aseguradora");							
				$('#ErroresNonActualizable').modal('show');
			}
		}
	});
});

$('#btnGuardarIndicadorNoAtenderAseg').click(function(e){

	var idIndicador = $("#indicadorNoAtenderAseg option:selected").val();
	var idAseguradora=$('#idRegistroAsignacionIndicadorAseguradora').val();
	var codigoNoAtender=$('#codigoNoAtenderAseg').val();
	var form = "idAseguradora="+idAseguradora+"&codigoNoAtender="+codigoNoAtender+"&exe=asignarIndicadorNoAtenderAseg&idIndicador="+idIndicador+"&usuario="+$('#btnLogout').attr('name');
	$.ajax({
		type: 'POST',
		url: 'class/consultasManejoAseguradoras.php',
		data: form,
		success: function(data) {
			if (data==1) {
				llenarTablaAsignacionIndicadorAseguradora();
				$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente");							
				limpiaForm("#frmAsignacionIndicadorAseguradora");
				$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});							
				$('#ErroresNonActualizable').modal('show');
			}else if (data==2){
				$("#ContenidoErrorNonActualizable").html("Ya Esta Asignado este Indicador para esta aseguradora");							
				$('#ErroresNonActualizable').modal('show');
			}
		}
	});
});