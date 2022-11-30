$('#btnDescargarInformesAseguradora').click(function(e){

	var val1=1; var val2=1 ;
	var mensaje=""; 

	if ($('#fechaInicioDescargaInformesAseguradora').val()==""){
		val1=2;
		mensaje+="Debe Ingresar Fecha Inicio<br>";
	}else{
		val1=1;
	}


	if ($('#fechaFinDescargaInformesAseguradora').val()==""){
		val2=2;
		mensaje+="Debe Ingresar Fecha Fin<br>";
	}else{
		val2=1;
	}



	if (val1==2 || val2==2)	{
		$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
		$("#ContenidoErrorNonActualizable").html(mensaje);
		$('#ErroresNonActualizable').modal('show');
	}
	else{

		$("div[name=divReportes]").hide();
		$.ajax({
			type: 'POST',
			url: 'class/consultasBasicas.php',
			data: "exe=descargarInformesMasivo&idAseguradora="+$("#inputIdAseguradoraReporteBasico").val()+"&fechaInicioDescargaInformes="+$("#fechaInicioDescargaInformesAseguradora").val()+"&fechaFinDescargaInformes="+$("#fechaFinDescargaInformesAseguradora").val()+"&tipoCasoDescargaInformes="+$("#tipoCasoDescargaInformesAseguradora option:selected").val()+"&opcionesDescargaInformes="+$("#opcionesDescargaInformesAseguradora option:selected").val(),
			success: function(data) {
				if (data=="NR"){
					$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
					$("#ContenidoErrorNonActualizable").html("NO HAY INFORMES PARA DESCARGAR");
					$('#ErroresNonActualizable').modal('show');
				}else{
					window.location.href = data;	
				}
			}
		});
	}
});

$('#btnDescargarInformes').click(function(e){

	var val1=1; var val2=1 ; var val3=1;
	var mensaje=""; 

	if ($('#fechaInicioDescargaInformes').val()==""){
		val1=2;
		mensaje+="Debe Ingresar Fecha Inicio<br>";
	}else{
		val1=1;
	}

	if ($('#fechaFinDescargaInformes').val()==""){
		val2=2;
		mensaje+="Debe Ingresar Fecha Fin<br>";
	}else{
		val2=1;
	}

	if ($("#idAseguradoraDescargaInformes option:selected").val()==0 || $("#idAseguradoraDescargaInformes option:selected").val()=="")	{
		val3=2;
		mensaje+="Debe Seleccionar Aseguradora Para Descargar Informes<br>";
	}else{
		val3=1;
	}

	if (val1==2 || val2==2 || val3==2){
		$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
		$("#ContenidoErrorNonActualizable").html(mensaje);
		$('#ErroresNonActualizable').modal('show');
	}
	else {

		$("div[name=divReportes]").hide();
		$.ajax({
			type: 'POST',
			url: 'class/consultasBasicas.php',
			data: "exe=descargarInformesMasivo&idAseguradora="+$("#idAseguradoraDescargaInformes option:selected").val()+"&fechaInicioDescargaInformes="+$("#fechaInicioDescargaInformes").val()+"&fechaFinDescargaInformes="+$("#fechaFinDescargaInformes").val()+"&tipoCasoDescargaInformes="+$("#tipoCasoDescargaInformes option:selected").val()+"&opcionesDescargaInformes="+$("#opcionesDescargaInformes option:selected").val(),
			success: function(data) {
				if (data=="NR"){
					$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
					$("#ContenidoErrorNonActualizable").html("NO HAY INFORMES PARA DESCARGAR");
					$('#ErroresNonActualizable').modal('show');

				}else{
					window.location.href = data;	
				}
			}
		});
	}
});

$("#idAseguradoraReporteBasico").change(function() {			
	$("input[name=radioReportsBasicos]").prop( "checked", false );
	$('#selectTipoCasoRegistroDiario').hide();
});

$("#idAseguradoraDescargaInformes").change(function() {			
	mostrarTipoCasosAseguradora($("#idAseguradoraDescargaInformes").val(),"#tipoCasoDescargaInformes","Reportes");
});

$("#tabModuloReportes").on('click','a',function(){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');

	$("div[name=divReportes]").hide();
	$("div[name=divBtnModuloReportes]").hide();
	$('#div-'+action).show();	
	$('#exeTab').val(action);	
});

$("#divOpcionesTipoReporte").on('click','input[name=radioReportsBasicos]',function(){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');

	if(action=="radioReportRegistroDiario") 	{ 
		mostrarTipoCasosAseguradora($("#idAseguradoraReporteBasico option:selected").val(),"#tipoCasoReporteBasico","Reportes");
		$('#selectTipoCasoRegistroDiario').show();
		$('#selectAnalistasVigentes').hide();
	} 
	else if (action=="radioReportArchivoPlano")	{  
		mostrarTipoCasosAseguradora($("#idAseguradoraReporteBasico option:selected").val(),"#tipoCasoReporteBasico","Plano");
		$('#selectTipoCasoRegistroDiario').show();
		$('#selectAnalistasVigentes').hide();
	}
	else if (action=="radioReportCargueInformes")	{
		$('#selectTipoCasoRegistroDiario').hide();
		$('#selectAnalistasVigentes').hide();
	}
	else if (action=="radioReportCasosAnalistaDiario")	{
		$('#selectTipoCasoRegistroDiario').hide();
		$('#selectAnalistasVigentes').show();
	}
});

$("#divOpcionesTipoReporteAseguradora").on('click','input[name=radioReportsBasicosAseguradora]',function(){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');

	if(action=="radioReportRegistroDiarioAseguradora"){ 
		mostrarTipoCasosAseguradora($("#inputIdAseguradoraReporteBasico").val(),"#tipoCasoReporteBasicoAseguradora","Reportes");
		$('#selectTipoCasoRegistroDiarioAseguradora').show();
	} 
	else if (action=="radioReportArchivoPlanoAseguradora") {  
		mostrarTipoCasosAseguradora($("#inputIdAseguradoraReporteBasico").val(),"#tipoCasoReporteBasicoAseguradora","Plano");
		$('#selectTipoCasoRegistroDiarioAseguradora').show();
	}
	else {
		$('#selectTipoCasoRegistroDiarioAseguradora').hide();
	}
});

$('#btnSubirConsolidados').click(function(e) {

	var val1=1; var val2=1 ; var val3=1 ;
	var mensaje=""; 
	if($("input[name=radioCargueConsolidados]:checked").val()=="btnAsignarMasivoInvestigadoresMundial")	{
		if ($('#fechaEntregaCargarConsolidados').val()==""){
			val1=2;
			mensaje+="Debe Ingresar Fecha Entrega<br>";
		}else{
			val1=1;
		}
	}else{
		val1=1;
	}

	if (($('#consolidadoMultimedia').val()=="" && $('#consolidadoMultimedia').val()=="")){
		val2=2;
		mensaje+="Debe Seleccionar Un Archivo<br>";
	}else{
		val2=1;
	}

	if (val1==2 || val2==2)	{
		$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
		$("#ContenidoErrorNonActualizable").html(mensaje);
		$('#ErroresNonActualizable').modal('show');
	}else {

		$("div[name=divReportes]").hide();

		if($("input[name=radioCargueConsolidados]:checked").val()=="btnAsignarMasivoInvestigadoresMundial")	{

			var formAsignarInvestigadores = new FormData();
			formAsignarInvestigadores.append("exe","subirConsolidadoAsignarInvestigadoresMundial");
			formAsignarInvestigadores.append("fechaEntrega",$('#fechaEntregaCargarConsolidados').val());
			formAsignarInvestigadores.append("idUsuario",$('#btnLogout').attr('name'));

			if ($('#consolidadoMultimedia').val()!="")
			{
				formAsignarInvestigadores.append("arcConsolidadoMultimedia",$("#consolidadoMultimedia").prop("files")[0]);
			}

			$.ajax({
				type: 'POST',
				url: 'class/consultasManejoCasoSOAT.php',
				data: formAsignarInvestigadores,
				cache: false,
				contentType: false,
				processData: false,

				success: function(data) {

					llenarTablaAsignacionInvestigador(data);
					return false;
				}
			});
		}
		else if($("input[name=radioCargueConsolidados]:checked").val()=="btnAsignarMasivoAnalistasMundial") {
			var formAsignarAnalistas = new FormData();
			formAsignarAnalistas.append("exe","subirConsolidadoAsignarAnalistasMundial");
			formAsignarAnalistas.append("idUsuario",$('#btnLogout').attr('name'));

			if ($('#consolidadoMultimedia').val()!="")	{
				formAsignarAnalistas.append("arcConsolidadoMultimedia",$("#consolidadoMultimedia").prop("files")[0]);
			}

			$.ajax({
				type: 'POST',
				url: 'class/consultasManejoCasoSOAT.php',
				data: formAsignarAnalistas,
				cache: false,
				contentType: false,
				processData: false,
				success: function(data) {
					llenarTablaAsignacionAnalista(data);
					return false;
				}
			});
		}
	}
});

$('#btnGenerarReportesAseguradora').click(function(e) {

	var val1=1; var val2=1 ;
	var mensaje=""; 

	if ($('#fechaInicioReporteBasicoAseguradora').val()==""){
		val1=2;
		mensaje+="Debe Ingresar Fecha Inicio<br>";
	}else{
		val1=1;
	}

	if ($('#fechaFinReporteBasicoAseguradora').val()==""){
		val2=2;
		mensaje+="Debe Ingresar Fecha Fin<br>";
	}else{
		val2=1;
	}

	if (val1==2 || val2==2)	{
		$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
		$("#ContenidoErrorNonActualizable").html(mensaje);
		$('#ErroresNonActualizable').modal('show');
	}else{

		$("div[name=divReportes]").hide();

		if($("input[name=radioReportsBasicosAseguradora]:checked").val()=="radioReportRegistroDiarioAseguradora"){

			if ($('#tipoCasoReporteBasicoAseguradora option:selected').val()==5){

				llenarTablaReporteDiarioValidacionesIPS($('#fechaInicioReporteBasicoAseguradora').val(),$('#fechaFinReporteBasicoAseguradora').val(),$('#inputIdAseguradoraReporteBasico').val(),$('#tipoCasoReporteBasicoAseguradora option:selected').val());
			}else {
				llenarTablaReporteDiarioSOAT($('#fechaInicioReporteBasicoAseguradora').val(),$('#fechaFinReporteBasicoAseguradora').val(),$('#inputIdAseguradoraReporteBasico').val(),$('#tipoCasoReporteBasicoAseguradora option:selected').val());
			}
		}
		else if($("input[name=radioReportsBasicosAseguradora]:checked").val()=="radioReportArchivoPlanoAseguradora"){

			$.ajax({
				type: 'POST',
				url: 'class/consultasBasicas.php',
				data: "exe=consultarFuncionReporte&idRegistro="+$("#tipoCasoReporteBasicoAseguradora option:selected").val(),
				success: function(data) {
					var arrayDatos = jQuery.parseJSON(data);
					eval(arrayDatos.nombre_funcion+"('"+$("#fechaInicioReporteBasicoAseguradora").val()+"','"+$("#fechaFinReporteBasicoAseguradora").val()+"')");
				}
			});
		}	
	}
});

$('#btnGenerarReportes').click(function(e) {

	var val1=1; var val2=1 ; var val3=1;
	var mensaje=""; 

	if ($('#fechaInicioReporteBasico').val()==""){
		val1=2;
		mensaje+="Debe Ingresar Fecha Inicio<br>";
	}else{
		val1=1;
	}

	if ($('#fechaFinReporteBasico').val()==""){
		val2=2;
		mensaje+="Debe Ingresar Fecha Fin<br>";
	}else{
		val2=1;
	}

	if($("input[name=radioReportsBasicos]:checked").val()=="radioReportRegistroDiario" || $("input[name=radioReportsBasicos]:checked").val()=="radioReportArchivoPlano") { 
		
		if ($("#idAseguradoraReporteBasico option:selected").val()==0 || $("#idAseguradoraReporteBasico option:selected").val()==""){
			val3=2;
			mensaje+="Debe Seleccionar Aseguradora Para este Tipo de Reporte<br>";
		}else{
			val3=1;
		}
	}

	if (val1==2 || val2==2 || val3==2) {
		$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
		$("#ContenidoErrorNonActualizable").html(mensaje);
		$('#ErroresNonActualizable').modal('show');
	}else{		
		$("div[name=divReportes]").hide();

		if($("input[name=radioReportsBasicos]:checked").val()=="radioReportCargueInformes")	{
			llenarTablaCargueInformes($('#fechaInicioReporteBasico').val(),$('#fechaFinReporteBasico').val(),$('#idAseguradoraReporteBasico option:selected').val());
		
		}else if($("input[name=radioReportsBasicos]:checked").val()=="radioReportRegistroDiario"){

			if ($('#tipoCasoReporteBasico option:selected').val()==5) {
				llenarTablaReporteDiarioValidacionesIPS($('#fechaInicioReporteBasico').val(),$('#fechaFinReporteBasico').val(),$('#idAseguradoraReporteBasico option:selected').val(),$('#tipoCasoReporteBasico option:selected').val());
			}else {
				llenarTablaReporteDiarioSOAT($('#fechaInicioReporteBasico').val(),$('#fechaFinReporteBasico').val(),$('#idAseguradoraReporteBasico option:selected').val(),$('#tipoCasoReporteBasico option:selected').val());
			}
		}
		else if($("input[name=radioReportsBasicos]:checked").val()=="radioReportArchivoPlano") {

			$.ajax({
				type: 'POST',
				url: 'class/consultasBasicas.php',
				data: "exe=consultarFuncionReporte&idRegistro="+$("#tipoCasoReporteBasico option:selected").val(),
				success: function(data) {
					var arrayDatos = jQuery.parseJSON(data);
					eval(arrayDatos.nombre_funcion+"('"+$("#fechaInicioReporteBasico").val()+"','"+$("#fechaFinReporteBasico").val()+"')");
				}
			});
		}
		else if($("input[name=radioReportsBasicos]:checked").val()=="radioReportCasosAnalistaDiario") {
			llenarTablaReporteCasosDiariosAnalista($('#fechaInicioReporteBasico').val(),$('#fechaFinReporteBasico').val(),$('#selectAnalistasVigentes option:selected').val());
		}
	}
});

function llenarTablaAsignacionAnalista(datosReporte){
	var arrayJSON=JSON.parse(datosReporte);

	$('#tablaReporteAsignacionAnalistas').DataTable( {
		scrollX: true,
		dom: 'Bfrtip',
		buttons: [{
			extend: 'excelHtml5',
			exportOptions: {
				columns: ':visible'
			},
			title: 'Reporte Asignacion Analistas'
		},{
			extend: 'colvis'
		}],
		"select": true,
		"destroy":true,
		"data":arrayJSON,
		"bPaginate":true,
		"bFilter" : false,        
		"bProcessing": true,
		"pageLength": 10,
		"columns": [
			{ title: 'Codigo', mData: 'codigo'} ,
			{ title: 'Radicado' , mData: 'radicado'} ,
			{ title: 'Analista', mData: 'analista'} ],
		"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
	$('#DivbtnReporteAsignacionAnalistas').show();
}

function llenarTablaAsignacionInvestigador(datosReporte){
	var arrayJSON=JSON.parse(datosReporte);

	$('#tablaReporteAsignacionInvestigador').DataTable( {
		scrollX: true,
		dom: 'Bfrtip',
		buttons: [{
			extend: 'excelHtml5',
			exportOptions: {
				columns: ':visible'
			},
			title: 'Reporte Asignacion Investigadores'
		},{
			extend: 'colvis'
		}],
		"select": true,
		"destroy":true,
		"data":arrayJSON,
		"bPaginate":true,
		"bFilter" : false,        
		"bProcessing": true,
		"pageLength": 10,
		"columns": [
		{ title: 'Codigo', mData: 'codigo'} ,
		{ title: 'Radicado' , mData: 'radicado'} ,
		{ title: 'Investigador', mData: 'investigador'} ,
		{ title: 'Respuesta Envio Email', mData: 'respuesta_email' }],
		"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
	$('#DivbtnReporteAsignacionInvestigador').show();
}

function llenarTablaCargueInformes(fechaInicio,fechaFin,idAseguradora){

	$('#tablaReporteCargueInformes').DataTable( {
		scrollX: true,
		dom: 'Bfrtip',
		buttons: [{
			extend: 'excelHtml5',
			exportOptions: {
				columns: ':visible'
			},
			title: 'Reporte Informes Diario'
		},{
			extend: 'colvis'
		}],
		"select": true,
		"destroy":true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "reportCargueInformes";
				d.fechaFinReporteBasico = fechaFin;
				d.fechaInicioReporteBasico = fechaInicio;
				d.aseguradoraReporteBasico = idAseguradora;
			}
		},
		"bPaginate":true,
		"bFilter" : false,        
		"bProcessing": true,
		"pageLength": 10,
		"columns": [
			{ title: 'Codigo', mData: 'codigo', "orderable": "true" } ,
			{ title: 'Aseguradora', mData: 'aseguradora', "orderable": "true" } ,
			{ title: 'Tipo Caso', mData: 'tipo_caso', "orderable": "true" } ,
			{ title: 'Analista', mData: 'nombre_analista', "orderable": "true" } ,
			{ title: 'F. Inicio', mData: 'fecha_inicio', "orderable": "true" } ,
			{ title: 'F. Entrega', mData: 'fecha_entrega', "orderable": "false" },
			{ title: 'Informe', mData: 'informe', "orderable": "false" }],
		"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
	$('#DivbtnReporteInvestigaciones').show();
}

function llenarTablaReporteDiarioSOAT(fechaInicio,fechaFin,idAseguradora,tipoCaso){

	$('#tablaReporteDiarioSOAT').DataTable( {
		scrollX: true,
		dom: 'Bfrtip',
		buttons: [{
			extend: 'excelHtml5',
			exportOptions: {
				columns: ':visible'
			},
			title: 'Reporte Registro Diario SOAT'
		},{
			extend: 'colvis'
		}],
		"select": true,
		"destroy":true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "reportRegistroDiarioSOAT";
				d.fechaFinReporteBasico = fechaFin;
				d.fechaInicioReporteBasico = fechaInicio;
				d.aseguradoraReporteBasico = idAseguradora;
				d.tipoCasoReporteBasico = tipoCaso;
			}
		},
		"bPaginate":true,
		"bFilter" : true,        
		"bProcessing": true,
		"pageLength": 10,
		"columns": [
			{ title: 'Codigo', mData: 'codigo', "orderable": "true" } ,
			{ title: 'Tipo De Caso', mData: 'tipo_caso', "orderable": "true" } ,
			{ title: 'Fecha Accidente', mData: 'fecha_accidente', "orderable": "true" } ,
			{ title: 'Placa', mData: 'placa', "orderable": "true" } ,
			{ title: 'No. Poliza', mData: 'poliza', "orderable": "true" } ,
			{ title: 'Ciudad Ocurrencia', mData: 'ciudad_ocurrencia', "orderable": "true" } ,
			{ title: 'Departamento Ocurrencia', mData: 'departamento_ocurrencia', "orderable": "true" } ,
			{ title: 'Tipo Identificacion Reclamante', mData: 'tipo_identificacion_reclamante', "orderable": "true" } ,
			{ title: 'Identificacion Reclamante', mData: 'identifidad_reclamante', "orderable": "true" } ,
			{ title: 'Nombre Reclamante', mData: 'nombre_reclamante', "orderable": "true" } ,
			{ title: 'Tipo Identificacion Victima', mData: 'tipo_identificacion_victima', "orderable": "true" } ,
			{ title: 'Identificacion Victima', mData: 'identificacion_victima', "orderable": "true" } ,
			{ title: 'Nombre Victima', mData: 'nombre_victima', "orderable": "true" } ,
			{ title: 'Resultado De Investigacion', mData: 'resultado_investigacion', "orderable": "true" } ,
			{ title: 'Tipologia De Hallazgo', mData: 'tipologia_hallazgo', "orderable": "true" } ,
			{ title: 'Perimetro', mData: 'perimetro', "orderable": "true"},
			{ title: 'Observaciones', mData: 'observaciones', "orderable": "true"},
			{ title: 'Usuario Actual', mData: 'usuarioActual', "orderable": "true"},
			{ title: 'Usuario Crear', mData: 'usuarioCrear', "orderable": "true"}],
		"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
	$('#DivReporteDiarioSOAT').show();
}

function llenarTablaArcPlanoCensoMundial(fechaInicio,fechaFin){

	$('#tablaArcPlanoCensoMundial').DataTable( {
		"autoWidth": true,
		"scrollX": true,
		dom: 'Bfrtip',
		buttons: [{	
			extend: 'excelHtml5',
			title: 'CENSO DIARIO'+fechaInicio+'_A_'+fechaFin,
			footer:false,},
		{
			extend: 'csvHtml5',
			header:false,
			filename: 'CENSO DIARIO'+fechaInicio+'_A_'+fechaFin,
			extension: '.txt',
			fieldBoundary: false,
			fieldSeparator:'|'
		}],
		"select": true,
		"destroy":true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "archivoPlanoCensosMundial";
				d.fechaInicioReporteBasico = fechaInicio;
				d.fechaFinReporteBasico = fechaFin;
				d.tipoGenerarArchivoPlano='rangoFecha';
			}
		},
		"bPaginate":true,
		"bFilter" : false,        
		"bProcessing": true,
		"pageLength": 2,       
		"columns": [
			{ title: 'Consecutivo', mData: 'codigo', "orderable": "true" } ,
			{ title: 'Ciudad Caso Conocido', mData: 'ciudad_conocido', "orderable": "true" } ,
			{ title: 'Fecha Visita', mData: 'fecha_visita', "orderable": "true" } ,
			{ title: 'Hora Visita', mData: 'hora_visita', "orderable": "true" } ,
			{ title: 'Tipo Vehiculo', mData: 'tipo_vehiculo', "orderable": "true" } ,
			{ title: 'Aseguradora', mData: 'aseguradora', "orderable": "true" } ,
			{ title: 'Numero Poliza', mData: 'numero_poliza', "orderable": "false" },
			{ title: 'Dig Ver Poliza', mData: 'digver_poliza', "orderable": "false" },
			{ title: 'Vigencia Desde', mData: 'vigencia_desde', "orderable": "false" },
			{ title: 'Vigencia Hasta', mData: 'vigencia_hasta', "orderable": "true" } ,
			{ title: 'Placa', mData: 'placa', "orderable": "false" },
			{ title: 'Nit IPS', mData: 'nit_ips', "orderable": "false" },
			{ title: 'Fecha Ingreso IPS', mData: 'fecha_ingreso_ips', "orderable": "false" },
			{ title: 'Hora Ingreso IPS', mData: 'hora_ingreso_ips', "orderable": "false"},
			{ title: 'Nombre Lesionado', mData: 'nombres_lesionado', "orderable": "false"},
			{ title: 'Apellido Lesionado', mData: 'apellidos_lesionado', "orderable": "false"},
			{ title: 'Tipo Identificacion Lesionado', mData: 'tipo_identificacion_lesionado', "orderable": "false"},
			{ title: 'Identificacion Lesionado', mData: 'identificacion_lesionado', "orderable": "false"},
			{ title: 'Edad Lesionado', mData: 'edad_lesionado', "orderable": "false"},
			{ title: 'Seguridad Social', mData: 'seguridad_social_lesionado', "orderable": "false"},
			{ title: 'Lugar Accidente', mData: 'lugar_accidente', "orderable": "false"},
			{ title: 'Fecha Accidente', mData: 'fecha_accidente', "orderable": "false"},
			{ title: 'Hora Accidente', mData: 'hora_accidente', "orderable": "false"},
			{ title: 'Condicion Lesionado', mData: 'condicion_lesionado', "orderable": "false"},
			{ title: 'Pruebas', mData: 'pruebas', "orderable": "false"},
			{ title: 'Resultado', mData: 'resultado_lesionado', "orderable": "false"},
			{ title: 'Motivo Objecion', mData: 'indicador_fraude', "orderable": "false"},
			{ title: 'Investigador', mData: 'nombre_investigador', "orderable": "false"},
			{ title: 'Observaciones', mData: 'observaciones', "orderable": "false"},
			{ title: 'Fecha Plano', mData: 'fecha_plano', "orderable": "false"},
			{ title: 'EPS', mData: 'nombre_eps', "orderable": "false"},
			{ title: 'Genero', mData: 'sexo', "orderable": "false"},
			{ title: 'Ciudad Ocurrencia', mData: 'ciudad_ocurrencia', "orderable": "false"},
			{ title: 'Telefono', mData: 'telefono', "orderable": "false"},
			{ title: 'IPS', mData: 'nombre_ips', "orderable": "false"},
			{ title: 'Ciudad IPS', mData: 'ciudad_ips', "orderable": "false"},
			{ title: 'Tipo Remitido', mData: 'remitido', "orderable": "false"},
			{ title: 'IPS Remitido', mData: 'ips_remitido', "orderable": "false"},
			{ title: 'Ciudad Remitido', mData: 'ciudad_remitido', "orderable": "false"},
			{ title: 'Control Transporte', mData: 'servicio_ambulancia', "orderable": "false"},
			{ title: 'Ciudad Residencia Lesionado', mData: 'ciudad_residencia_lesionado', "orderable": "false"}],
		"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});

	$('#DivbtnReporteArcPlanoCensoMundial').show();
}

function llenarTablaArcPlanoCensoEstado(fechaInicio,fechaFin){

	$('#tablaArcPlanoCensoEstado').DataTable( {
		"scrollX": true,
		dom: 'Bfrtip',
		buttons: [{	
			extend: 'excelHtml5',
			title: 'CENSO DIARIO'+fechaInicio+'_A_'+fechaFin,
			footer:false,
		},{
			extend: 'csvHtml5',
			header:false,
			filename: 'CENSO DIARIO'+fechaInicio+'_A_'+fechaFin,
			extension: '.txt',
			fieldBoundary: false,
			fieldSeparator:'|'
		}],
		"select": true,
		"destroy":true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "archivoPlanoCensosEstado";
				d.fechaInicioReporteBasico = fechaInicio;
				d.fechaFinReporteBasico = fechaFin;
				d.tipoGenerarArchivoPlano='rangoFecha';
			}
		},
		"bPaginate":true,
		"bFilter" : false,        
		"bProcessing": true,
		"pageLength": 2,       
		"columns": [
			{ title: 'Consecutivo', mData: 'codigo', "orderable": "true" } ,
			{ title: 'Ciudad Caso Conocido', mData: 'ciudad_conocido', "orderable": "true" } ,
			{ title: 'Fecha Visita', mData: 'fecha_visita', "orderable": "true" } ,
			{ title: 'Hora Visita', mData: 'hora_visita', "orderable": "true" } ,
			{ title: 'Tipo Vehiculo', mData: 'tipo_vehiculo', "orderable": "true" } ,
			{ title: 'Aseguradora', mData: 'aseguradora', "orderable": "true" } ,
			{ title: 'Numero Poliza', mData: 'numero_poliza', "orderable": "false" },
			{ title: 'Dig Ver Poliza', mData: 'digver_poliza', "orderable": "false" },
			{ title: 'Vigencia Desde', mData: 'vigencia_desde', "orderable": "false" },
			{ title: 'Vigencia Hasta', mData: 'vigencia_hasta', "orderable": "true" } ,
			{ title: 'Placa', mData: 'placa', "orderable": "false" },
			{ title: 'Nit IPS', mData: 'nit_ips', "orderable": "false" },
			{ title: 'Fecha Ingreso IPS', mData: 'fecha_ingreso_ips', "orderable": "false" },
			{ title: 'Hora Ingreso IPS', mData: 'hora_ingreso_ips', "orderable": "false"},
			{ title: 'Nombre Lesionado', mData: 'nombres_lesionado', "orderable": "false"},
			{ title: 'Apellido Lesionado', mData: 'apellidos_lesionado', "orderable": "false"},
			{ title: 'Tipo Identificacion Lesionado', mData: 'tipo_identificacion_lesionado', "orderable": "false"},
			{ title: 'Identificacion Lesionado', mData: 'identificacion_lesionado', "orderable": "false"},
			{ title: 'Edad Lesionado', mData: 'edad_lesionado', "orderable": "false"},
			{ title: 'Seguridad Social', mData: 'seguridad_social_lesionado', "orderable": "false"},
			{ title: 'Aseguradora', mData: 'aseguradora2', "orderable": "true" } ,
			{ title: 'Ingreso Fosyga', mData: 'ingreso_fosyga', "orderable": "true" } ,
			{ title: 'Lugar Accidente', mData: 'lugar_accidente', "orderable": "false"},
			{ title: 'Fecha Accidente', mData: 'fecha_accidente', "orderable": "false"},
			{ title: 'Hora Accidente', mData: 'hora_accidente', "orderable": "false"},
			{ title: 'Caracteristicas', mData: 'pruebas', "orderable": "false"},
			{ title: 'Condicion Lesionado', mData: 'condicion_lesionado', "orderable": "false"},
			{ title: 'Otros Diagnosticos', mData: 'otros_diagnosticos', "orderable": "false"},
			{ title: 'Costos', mData: 'costo', "orderable": "false"},
			{ title: 'Visita Sitio', mData: 'visita_sitio', "orderable": "false"},
			{ title: 'Pruebas', mData: 'pruebas2', "orderable": "false"},
			{ title: 'Resultado', mData: 'resultado_lesionado', "orderable": "false"},
			{ title: 'Motivo Objecion', mData: 'indicador_fraude', "orderable": "false"},
			{ title: 'Valor Fraude', mData: 'valor_fraude', "orderable": "false"},
			{ title: 'Investigador', mData: 'nombre_investigador', "orderable": "false"},
			{ title: 'Observaciones', mData: 'observaciones', "orderable": "false"},
			{ title: 'Fecha Plano', mData: 'fecha_plano', "orderable": "false"},
			{ title: 'EPS', mData: 'nombre_eps', "orderable": "false"},
			
			{ title: 'Genero', mData: 'sexo', "orderable": "false"},
			{ title: 'Ciudad Ocurrencia', mData: 'ciudad_ocurrencia', "orderable": "false"},
			{ title: 'Telefono', mData: 'telefono', "orderable": "false"},
			{ title: 'IPS', mData: 'nombre_ips', "orderable": "false"},
			{ title: 'Ciudad IPS', mData: 'ciudad_ips', "orderable": "false"}],
		"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});

	$('#DivbtnReporteArcPlanoCensoEstado').show();
}

function llenarTablaArcPlanoCensoEquidad(fechaInicio,fechaFin){

	$('#tablaArcPlanoCensoEquidad').DataTable( {
		"scrollX": true,
		dom: 'Bfrtip',
		buttons: [{	
			extend: 'excelHtml5',
			title: 'CENSO DIARIO'+fechaInicio+'_A_'+fechaFin,
			footer:false,
		},{
			extend: 'csvHtml5',
			header:false,
			filename: 'CENSO DIARIO'+fechaInicio+'_A_'+fechaFin,
			extension: '.txt',
			fieldBoundary: false,
			fieldSeparator:'|'
		}],
		"select": true,
		"destroy":true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "archivoPlanoCensosEquidad";
				d.fechaInicioReporteBasico = fechaInicio;
				d.fechaFinReporteBasico = fechaFin;
				d.tipoGenerarArchivoPlano='rangoFecha';
			}
		},
		"bPaginate":true,
		"bFilter" : false,        
		"bProcessing": true,
		"pageLength": 2,       
		"columns": [
			{ title: 'Consecutivo', mData: 'codigo', "orderable": "true" } ,
			{ title: 'Ciudad Caso Conocido', mData: 'ciudad_conocido', "orderable": "true" } ,
			{ title: 'Fecha Visita', mData: 'fecha_visita', "orderable": "true" } ,
			{ title: 'Hora Visita', mData: 'hora_visita', "orderable": "true" } ,
			{ title: 'Tipo Vehiculo', mData: 'tipo_vehiculo', "orderable": "true" } ,
			{ title: 'Aseguradora', mData: 'aseguradora', "orderable": "true" } ,
			{ title: 'Numero Poliza', mData: 'numero_poliza', "orderable": "false" },
			{ title: 'Dig Ver Poliza', mData: 'digver_poliza', "orderable": "false" },
			{ title: 'Vigencia Desde', mData: 'vigencia_desde', "orderable": "false" },
			{ title: 'Vigencia Hasta', mData: 'vigencia_hasta', "orderable": "true" } ,
			{ title: 'Placa', mData: 'placa', "orderable": "false" },
			{ title: 'Nit IPS', mData: 'nit_ips', "orderable": "false" },
			{ title: 'Fecha Ingreso IPS', mData: 'fecha_ingreso_ips', "orderable": "false" },
			{ title: 'Hora Ingreso IPS', mData: 'hora_ingreso_ips', "orderable": "false"},
			{ title: 'Nombre Lesionado', mData: 'nombres_lesionado', "orderable": "false"},
			{ title: 'Apellido Lesionado', mData: 'apellidos_lesionado', "orderable": "false"},
			{ title: 'Tipo Identificacion Lesionado', mData: 'tipo_identificacion_lesionado', "orderable": "false"},
			{ title: 'Identificacion Lesionado', mData: 'identificacion_lesionado', "orderable": "false"},
			{ title: 'Edad Lesionado', mData: 'edad_lesionado', "orderable": "false"},
			{ title: 'Seguridad Social', mData: 'seguridad_social_lesionado', "orderable": "false"},
			{ title: 'Aseguradora', mData: 'aseguradora2', "orderable": "true" } ,
			{ title: 'Ingreso Fosyga', mData: 'ingreso_fosyga', "orderable": "true" } ,
			{ title: 'Lugar Accidente', mData: 'lugar_accidente', "orderable": "false"},
			{ title: 'Fecha Accidente', mData: 'fecha_accidente', "orderable": "false"},
			{ title: 'Hora Accidente', mData: 'hora_accidente', "orderable": "false"},
			{ title: 'Caracteristicas', mData: 'pruebas', "orderable": "false"},
			{ title: 'Condicion Lesionado', mData: 'condicion_lesionado', "orderable": "false"},
			{ title: 'Otros Diagnosticos', mData: 'otros_diagnosticos', "orderable": "false"},
			{ title: 'Costos', mData: 'costo', "orderable": "false"},
			{ title: 'Visita Sitio', mData: 'visita_sitio', "orderable": "false"},
			{ title: 'Pruebas', mData: 'pruebas2', "orderable": "false"},
			{ title: 'Resultado', mData: 'resultado_lesionado', "orderable": "false"},
			{ title: 'Motivo Objecion', mData: 'indicador_fraude', "orderable": "false"},
			{ title: 'Valor Fraude', mData: 'valor_fraude', "orderable": "false"},
			{ title: 'Investigador', mData: 'nombre_investigador', "orderable": "false"},
			{ title: 'Observaciones', mData: 'observaciones', "orderable": "false"},
			{ title: 'EPS', mData: 'nombre_eps', "orderable": "false"},
			{ title: 'Fecha Plano', mData: 'fecha_plano', "orderable": "false"},
			{ title: 'Genero', mData: 'sexo', "orderable": "false"},
			{ title: 'Ciudad Ocurrencia', mData: 'ciudad_ocurrencia', "orderable": "false"},
			{ title: 'Telefono', mData: 'telefono', "orderable": "false"},
			{ title: 'IPS', mData: 'nombre_ips', "orderable": "false"},
			{ title: 'Ciudad IPS', mData: 'ciudad_ips', "orderable": "false"}
		],
		"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});

	$('#DivbtnReporteArcPlanoCensoEquidad').show();
}

function llenarTablaArcPlanoCensoSolidaria(fechaInicio,fechaFin){

	$('#tablaArcPlanoCensoSolidaria').DataTable( {
		"scrollX": true,
		dom: 'Bfrtip',
		buttons: [{	
			extend: 'excelHtml5',
			title: 'CENSO DIARIO'+fechaInicio+'_A_'+fechaFin,
			footer:false,
		},{
			extend: 'csvHtml5',

			header:false,
			filename: 'CENSO DIARIO'+fechaInicio+'_A_'+fechaFin,
			extension: '.txt',
			fieldBoundary: false,
			fieldSeparator:'|'
		}],
		"select": true,
		"destroy":true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "archivoPlanoCensosSolidaria";
				d.fechaInicioReporteBasico = fechaInicio;
				d.fechaFinReporteBasico = fechaFin;
				d.tipoGenerarArchivoPlano='rangoFecha';
			}
		},
		"bPaginate":true,
		"bFilter" : false,        
		"bProcessing": true,
		"pageLength": 2,       
		"columns": [
			{ title: 'Consecutivo', mData: 'codigo', "orderable": "true" } ,
			{ title: 'Ciudad Caso Conocido', mData: 'ciudad_conocido', "orderable": "true" } ,
			{ title: 'Fecha Visita', mData: 'fecha_visita', "orderable": "true" } ,
			{ title: 'Hora Visita', mData: 'hora_visita', "orderable": "true" } ,
			{ title: 'Tipo Vehiculo', mData: 'tipo_vehiculo', "orderable": "true" } ,
			{ title: 'Aseguradora', mData: 'aseguradora', "orderable": "true" } ,
			{ title: 'Numero Poliza', mData: 'numero_poliza', "orderable": "false" },
			{ title: 'Dig Ver Poliza', mData: 'digver_poliza', "orderable": "false" },
			{ title: 'Vigencia Desde', mData: 'vigencia_desde', "orderable": "false" },
			{ title: 'Vigencia Hasta', mData: 'vigencia_hasta', "orderable": "true" } ,
			{ title: 'Placa', mData: 'placa', "orderable": "false" },
			{ title: 'Nit IPS', mData: 'nit_ips', "orderable": "false" },
			{ title: 'Fecha Ingreso IPS', mData: 'fecha_ingreso_ips', "orderable": "false" },
			{ title: 'Hora Ingreso IPS', mData: 'hora_ingreso_ips', "orderable": "false"},
			{ title: 'Nombre Lesionado', mData: 'nombres_lesionado', "orderable": "false"},
			{ title: 'Apellido Lesionado', mData: 'apellidos_lesionado', "orderable": "false"},
			{ title: 'Tipo Identificacion Lesionado', mData: 'tipo_identificacion_lesionado', "orderable": "false"},
			{ title: 'Identificacion Lesionado', mData: 'identificacion_lesionado', "orderable": "false"},
			{ title: 'Edad Lesionado', mData: 'edad_lesionado', "orderable": "false"},
			{ title: 'Seguridad Social', mData: 'seguridad_social_lesionado', "orderable": "false"},
			{ title: 'Aseguradora', mData: 'aseguradora2', "orderable": "true" } ,
			{ title: 'Ingreso Fosyga', mData: 'ingreso_fosyga', "orderable": "true" } ,
			{ title: 'Lugar Accidente', mData: 'lugar_accidente', "orderable": "false"},
			{ title: 'Fecha Accidente', mData: 'fecha_accidente', "orderable": "false"},
			{ title: 'Hora Accidente', mData: 'hora_accidente', "orderable": "false"},
			{ title: 'Caracteristicas', mData: 'pruebas', "orderable": "false"},
			{ title: 'Condicion Lesionado', mData: 'condicion_lesionado', "orderable": "false"},
			{ title: 'Otros Diagnosticos', mData: 'otros_diagnosticos', "orderable": "false"},
			{ title: 'Costos', mData: 'costo', "orderable": "false"},
			{ title: 'Visita Sitio', mData: 'visita_sitio', "orderable": "false"},
			{ title: 'Pruebas', mData: 'pruebas2', "orderable": "false"},
			{ title: 'Resultado', mData: 'resultado_lesionado', "orderable": "false"},
			{ title: 'Motivo Objecion', mData: 'indicador_fraude', "orderable": "false"},
			{ title: 'Valor Fraude', mData: 'valor_fraude', "orderable": "false"},
			{ title: 'Investigador', mData: 'nombre_investigador', "orderable": "false"},
			{ title: 'Observaciones', mData: 'observaciones', "orderable": "false"},
			{ title: 'EPS', mData: 'nombre_eps', "orderable": "false"},
			{ title: 'Fecha Plano', mData: 'fecha_plano', "orderable": "false"},
			{ title: 'Genero', mData: 'sexo', "orderable": "false"},
			{ title: 'Ciudad Ocurrencia', mData: 'ciudad_ocurrencia', "orderable": "false"},
			{ title: 'Telefono', mData: 'telefono', "orderable": "false"},
			{ title: 'IPS', mData: 'nombre_ips', "orderable": "false"},
			{ title: 'Ciudad IPS', mData: 'ciudad_ips', "orderable": "false"}],
		"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});

	$('#DivbtnReporteArcPlanoCensoSolidaria').show();
}

function llenarTablaArcPlanoGastosMedicosMundial(fechaInicio,fechaFin){

	$('#tablaArcPlanoGastosMedicosMundial').DataTable( {
		"scrollX": true,
		dom: 'Bfrtip',
		buttons: [{	
			extend: 'excelHtml5',
			title: 'GASTOS MEDICOS'+fechaInicio+'_A_'+fechaFin,
			footer:false,
		},{
			extend: 'csvHtml5',
			header:false,
			filename: 'GASTOS MEDICOS'+fechaInicio+'_A_'+fechaFin,
			extension: '.txt',
			fieldBoundary: false,
			fieldSeparator:'|'
		}],
		"select": true,
		"destroy":true,
		"ajax": {
			"url":"class/consultasTablas.php",

			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "archivoPlanoGastosMedicosMundial";
				d.fechaInicioReporteBasico = fechaInicio;
				d.fechaFinReporteBasico = fechaFin;
				d.tipoGenerarArchivoPlano='rangoFecha';
			}
		},
		"bPaginate":true,
		"bFilter" : false,        
		"bProcessing": true,
		"pageLength": 2,       
		"columns": [
			{ title: 'Consecutivo', mData: 'codigo', "orderable": "true" } ,
			{ title: 'Amparo Afectado', mData: 'tipo_caso', "orderable": "true" } ,
			{ title: 'Fecha Asignacion', mData: 'fecha_asignacion', "orderable": "true" } ,
			{ title: 'Siniestro', mData: 'siniestro', "orderable": "true" } ,
			{ title: 'Fecha Entrega', mData: 'fecha_entrega', "orderable": "true" } ,
			{ title: 'Ciudad Ocurrencia', mData: 'codigo_ciudad_ocurrencia', "orderable": "true" } ,
			{ title: 'Lugar Accidente', mData: 'lugar_accidente', "orderable": "false" },
			{ title: 'Tipo Identificacion Lesionado', mData: 'tipo_identificacion_lesionado', "orderable": "false" },
			{ title: 'Identificacion Lesionado', mData: 'identificacion_lesionado', "orderable": "false" },
			{ title: 'Nombres Lesionado', mData: 'nombres_lesionado', "orderable": "true" } ,
			{ title: 'Apellidos Lesionado', mData: 'apellidos_lesionado', "orderable": "false" },
			{ title: 'Departamento Residencia', mData: 'departamento_residencia', "orderable": "false" },
			{ title: 'Ciudad Residencia', mData: 'ciudad_residencia', "orderable": "false" },
			{ title: 'Fecha Accidente', mData: 'fecha_accidente', "orderable": "false"},
			{ title: 'Hora Accidente', mData: 'hora_accidente', "orderable": "false"},
			{ title: 'Tipo Identificacion Reclamante', mData: 'tipo_identificacion_reclamante', "orderable": "false"},
			{ title: 'Identificacion Reclamante', mData: 'identificacion_reclamante', "orderable": "false"},
			{ title: 'Nombres Reclamante', mData: 'nombre_reclamante', "orderable": "true" } ,
			{ title: 'Apellidos Reclamante', mData: 'apellido_reclamante', "orderable": "false" },
			{ title: 'Direccion Reclamante', mData: 'direccion_reclamante', "orderable": "false"},
			{ title: 'Departamento Reclamante', mData: 'departamento_reclamante', "orderable": "true" } ,
			{ title: 'Ciudad Reclamante', mData: 'ciudad_reclamante', "orderable": "true" } ,
			{ title: 'Ramo', mData: 'ramo', "orderable": "false"},
			{ title: 'Aseguradora', mData: 'aseguradora', "orderable": "false"},
			{ title: 'Poliza', mData: 'poliza', "orderable": "false"},
			{ title: 'Digito Verificacion', mData: 'dig_ver_poliza', "orderable": "false"},
			{ title: 'Placa', mData: 'placa', "orderable": "false"},
			{ title: 'Inicio Vigencia', mData: 'inicio_vigencia', "orderable": "false"},
			{ title: 'Fin Vigencia', mData: 'fin_vigencia', "orderable": "false"},
			{ title: 'Fiscalia Lleva Caso', mData: 'fiscalia_lleva_caso', "orderable": "false"},
			{ title: 'Informe Accidente', mData: 'informe_accidente', "orderable": "false"},
			{ title: 'Numero Proceso', mData: 'no_proceso', "orderable": "false"},
			{ title: 'Hechos', mData: 'hechos', "orderable": "false"},
			{ title: 'Tipo Identificacion Beneficiario', mData: 'tipo_identificacion_beneficiario', "orderable": "false"},
			{ title: 'Identificacion Beneficiario', mData: 'identificacion_beneficiario', "orderable": "false"},
			{ title: 'Nombres Beneficiario', mData: 'nombres_beneficiario', "orderable": "false"},
			{ title: 'Apellidos Beneficiario', mData: 'apellidos_beneficiario', "orderable": "false"},
			{ title: 'Parentesco Beneficiario', mData: 'parentesco_beneficiario', "orderable": "false"},
			{ title: 'Telefono Beneficiario', mData: 'telefono_beneficiario', "orderable": "false"},
			{ title: 'Conclusiones', mData: 'conclusiones', "orderable": "false"},
			{ title: 'Resultado Lesionado', mData: 'resultado_lesionado', "orderable": "false"},
			{ title: 'Investigador', mData: 'nombre_investigador', "orderable": "false"},
			{ title: 'Indicador Fraude', mData: 'indicador_fraude', "orderable": "false"},
			{ title: 'Fecha Plano', mData: 'fecha_plano', "orderable": "false"}],
		"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});

	$('#DivbtnReporteArcPlanoGastosMedicosMundial').show();
}

function llenarTablaArcPlanoMuerteMundial(fechaInicio,fechaFin){

	$('#tablaArcPlanoMuerteMundial').DataTable( {
		"scrollX": true,
		dom: 'Bfrtip',
		buttons: [{	
			extend: 'excelHtml5',
			title: 'MUERTE'+fechaInicio+'_A_'+fechaFin,
			footer:false,
		},{
			extend: 'csvHtml5',
			header:false,
			filename: 'MUERTE'+fechaInicio+'_A_'+fechaFin,
			extension: '.txt',
			fieldBoundary: false,
			fieldSeparator:'|'
		}],
		"select": true,
		"destroy":true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "archivoPlanoMuerteMundial";
				d.fechaInicioReporteBasico = fechaInicio;
				d.fechaFinReporteBasico = fechaFin;
				d.tipoGenerarArchivoPlano='rangoFecha';
			}
		},
		"bPaginate":true,
		"bFilter" : false,        
		"bProcessing": true,
		"pageLength": 2,       
		"columns": [
			{ title: 'Consecutivo', mData: 'codigo', "orderable": "true" } ,
			{ title: 'Amparo Afectado', mData: 'tipo_caso', "orderable": "true" } ,
			{ title: 'Fecha Asignacion', mData: 'fecha_asignacion', "orderable": "true" } ,
			{ title: 'Siniestro', mData: 'siniestro', "orderable": "true" } ,
			{ title: 'Fecha Entrega', mData: 'fecha_entrega', "orderable": "true" } ,
			{ title: 'Ciudad Ocurrencia', mData: 'codigo_ciudad_ocurrencia', "orderable": "true" } ,
			{ title: 'Lugar Accidente', mData: 'lugar_accidente', "orderable": "false" },
			{ title: 'Tipo Identificacion Lesionado', mData: 'tipo_identificacion_lesionado', "orderable": "false" },
			{ title: 'Identificacion Lesionado', mData: 'identificacion_lesionado', "orderable": "false" },
			{ title: 'Nombres Lesionado', mData: 'nombres_lesionado', "orderable": "true" } ,
			{ title: 'Apellidos Lesionado', mData: 'apellidos_lesionado', "orderable": "false" },
			{ title: 'Departamento Residencia', mData: 'departamento_residencia', "orderable": "false" },
			{ title: 'Ciudad Residencia', mData: 'ciudad_residencia', "orderable": "false" },
			{ title: 'Fecha Accidente', mData: 'fecha_accidente', "orderable": "false"},
			{ title: 'Hora Accidente', mData: 'hora_accidente', "orderable": "false"},
			{ title: 'Tipo Identificacion Reclamante', mData: 'tipo_identificacion_reclamante', "orderable": "false"},
			{ title: 'Identificacion Reclamante', mData: 'identificacion_reclamante', "orderable": "false"},
			{ title: 'Nombres Reclamante', mData: 'nombre_reclamante', "orderable": "true" } ,
			{ title: 'Apellidos Reclamante', mData: 'apellido_reclamante', "orderable": "false" },
			{ title: 'Direccion Reclamante', mData: 'direccion_reclamante', "orderable": "false"},
			{ title: 'Departamento Reclamante', mData: 'departamento_reclamante', "orderable": "true" } ,
			{ title: 'Ciudad Reclamante', mData: 'ciudad_reclamante', "orderable": "true" } ,
			{ title: 'Ramo', mData: 'ramo', "orderable": "false"},
			{ title: 'Aseguradora', mData: 'aseguradora', "orderable": "false"},
			{ title: 'Poliza', mData: 'poliza', "orderable": "false"},
			{ title: 'Digito Verificacion', mData: 'dig_ver_poliza', "orderable": "false"},
			{ title: 'Placa', mData: 'placa', "orderable": "false"},
			{ title: 'Inicio Vigencia', mData: 'inicio_vigencia', "orderable": "false"},
			{ title: 'Fin Vigencia', mData: 'fin_vigencia', "orderable": "false"},
			{ title: 'Fiscalia Lleva Caso', mData: 'fiscalia_lleva_caso', "orderable": "false"},
			{ title: 'Informe Accidente', mData: 'informe_accidente', "orderable": "false"},
			{ title: 'Numero Proceso', mData: 'no_proceso', "orderable": "false"},
			{ title: 'Hechos', mData: 'hechos', "orderable": "false"},
			{ title: 'Tipo Identificacion Beneficiario', mData: 'tipo_identificacion_beneficiario', "orderable": "false"},
			{ title: 'Identificacion Beneficiario', mData: 'identificacion_beneficiario', "orderable": "false"},
			{ title: 'Nombres Beneficiario', mData: 'nombres_beneficiario', "orderable": "false"},
			{ title: 'Apellidos Beneficiario', mData: 'apellidos_beneficiario', "orderable": "false"},
			{ title: 'Parentesco Beneficiario', mData: 'parentesco_beneficiario', "orderable": "false"},
			{ title: 'Telefono Beneficiario', mData: 'telefono_beneficiario', "orderable": "false"},
			{ title: 'Conclusiones', mData: 'conclusiones', "orderable": "false"},
			{ title: 'Resultado Lesionado', mData: 'resultado_lesionado', "orderable": "false"},
			{ title: 'Investigador', mData: 'nombre_investigador', "orderable": "false"},
			{ title: 'Indicador Fraude', mData: 'indicador_fraude', "orderable": "false"},
			{ title: 'Fecha Plano', mData: 'fecha_plano', "orderable": "false"}],
		"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});

	$('#DivbtnReporteArcPlanoMuerteMundial').show();
}

function llenarTablaArcPlanoIncapacidadPermanenteMundial(fechaInicio,fechaFin){

	$('#tablaArcPlanoIncapacidadPermanenteMundial').DataTable( {
		"scrollX": true,
		dom: 'Bfrtip',
		buttons: [{	
			extend: 'excelHtml5',
			title: 'MUERTE'+fechaInicio+'_A_'+fechaFin,
			footer:false,
		},{
			extend: 'csvHtml5',
			header:false,
			filename: 'MUERTE'+fechaInicio+'_A_'+fechaFin,
			extension: '.txt',
			fieldBoundary: false,
			fieldSeparator:'|'
		}],
		"select": true,
		"destroy":true,
		"ajax": {
			"url":"class/consultasTablas.php",

			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "archivoPlanoIncapacidadPermanenteMundial";
				d.fechaInicioReporteBasico = fechaInicio;
				d.fechaFinReporteBasico = fechaFin;
				d.tipoGenerarArchivoPlano='rangoFecha';
			}
		},
		"bPaginate":true,
		"bFilter" : false,        
		"bProcessing": true,
		"pageLength": 2,       
		"columns": [
			{ title: 'Consecutivo', mData: 'codigo', "orderable": "true" } ,
			{ title: 'Amparo Afectado', mData: 'tipo_caso', "orderable": "true" } ,
			{ title: 'Fecha Asignacion', mData: 'fecha_asignacion', "orderable": "true" } ,
			{ title: 'Siniestro', mData: 'siniestro', "orderable": "true" } ,
			{ title: 'Fecha Entrega', mData: 'fecha_entrega', "orderable": "true" } ,
			{ title: 'Ciudad Ocurrencia', mData: 'codigo_ciudad_ocurrencia', "orderable": "true" } ,
			{ title: 'Lugar Accidente', mData: 'lugar_accidente', "orderable": "false" },
			{ title: 'Tipo Identificacion Lesionado', mData: 'tipo_identificacion_lesionado', "orderable": "false" },
			{ title: 'Identificacion Lesionado', mData: 'identificacion_lesionado', "orderable": "false" },
			{ title: 'Nombres Lesionado', mData: 'nombres_lesionado', "orderable": "true" } ,
			{ title: 'Apellidos Lesionado', mData: 'apellidos_lesionado', "orderable": "false" },
			{ title: 'Departamento Residencia', mData: 'departamento_residencia', "orderable": "false" },
			{ title: 'Ciudad Residencia', mData: 'ciudad_residencia', "orderable": "false" },
			{ title: 'Fecha Accidente', mData: 'fecha_accidente', "orderable": "false"},
			{ title: 'Hora Accidente', mData: 'hora_accidente', "orderable": "false"},
			{ title: 'Tipo Identificacion Reclamante', mData: 'tipo_identificacion_reclamante', "orderable": "false"},
			{ title: 'Identificacion Reclamante', mData: 'identificacion_reclamante', "orderable": "false"},
			{ title: 'Nombres Reclamante', mData: 'nombre_reclamante', "orderable": "true" } ,
			{ title: 'Apellidos Reclamante', mData: 'apellido_reclamante', "orderable": "false" },
			{ title: 'Direccion Reclamante', mData: 'direccion_reclamante', "orderable": "false"},
			{ title: 'Departamento Reclamante', mData: 'departamento_reclamante', "orderable": "true" } ,
			{ title: 'Ciudad Reclamante', mData: 'ciudad_reclamante', "orderable": "true" } ,
			{ title: 'Ramo', mData: 'ramo', "orderable": "false"},
			{ title: 'Aseguradora', mData: 'aseguradora', "orderable": "false"},
			{ title: 'Poliza', mData: 'poliza', "orderable": "false"},
			{ title: 'Digito Verificacion', mData: 'dig_ver_poliza', "orderable": "false"},
			{ title: 'Placa', mData: 'placa', "orderable": "false"},
			{ title: 'Inicio Vigencia', mData: 'inicio_vigencia', "orderable": "false"},
			{ title: 'Fin Vigencia', mData: 'fin_vigencia', "orderable": "false"},
			{ title: 'Fiscalia Lleva Caso', mData: 'fiscalia_lleva_caso', "orderable": "false"},
			{ title: 'Informe Accidente', mData: 'informe_accidente', "orderable": "false"},
			{ title: 'Numero Proceso', mData: 'no_proceso', "orderable": "false"},
			{ title: 'Hechos', mData: 'hechos', "orderable": "false"},
			{ title: 'Tipo Identificacion Beneficiario', mData: 'tipo_identificacion_beneficiario', "orderable": "false"},
			{ title: 'Identificacion Beneficiario', mData: 'identificacion_beneficiario', "orderable": "false"},
			{ title: 'Nombres Beneficiario', mData: 'nombres_beneficiario', "orderable": "false"},
			{ title: 'Apellidos Beneficiario', mData: 'apellidos_beneficiario', "orderable": "false"},
			{ title: 'Parentesco Beneficiario', mData: 'parentesco_beneficiario', "orderable": "false"},
			{ title: 'Telefono Beneficiario', mData: 'telefono_beneficiario', "orderable": "false"},
			{ title: 'Conclusiones', mData: 'conclusiones', "orderable": "false"},
			{ title: 'Resultado Lesionado', mData: 'resultado_lesionado', "orderable": "false"},
			{ title: 'Investigador', mData: 'nombre_investigador', "orderable": "false"},
			{ title: 'Indicador Fraude', mData: 'indicador_fraude', "orderable": "false"},
			{ title: 'Fecha Plano', mData: 'fecha_plano', "orderable": "false"}],
		"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});

	$('#DivbtnReporteArcPlanoIncapacidadPermanenteMundial').show();
}

function llenarTablaReporteCasosDiariosAnalista(fechaInicio,fechaFin,idAnalista){

	$('#tablaReporteCasosDiariosAnalista').DataTable( {
		scrollX: true,
		dom: 'Bfrtip',
		buttons: [{
			extend: 'excelHtml5',
			exportOptions: {
				columns: ':visible'
			},
			title: 'Reporte Casos Diarios Analista'
		},{
			extend: 'colvis'
		}],
		"select": true,
		"destroy":true,
		"ajax": {
			"url":"class/consultasTablas.php",

			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "reportCasosDiariosAnalista";
				d.fechaFinCasosDiarioAnalista = fechaFin;
				d.fechaInicioCasosDiarioAnalista = fechaInicio;
				d.idAnalistaCasosDiarioAnalista = idAnalista;
			}
		},
		"bPaginate":true,
		"bFilter" : true,        
		"bProcessing": true,
		"pageLength": 10,
		"columns": [
			{ title: 'Origen', mData: 'origen', "orderable": "true" } ,
			{ title: 'Codigo', mData: 'codigo', "orderable": "true" } ,
			{ title: 'Analista', mData: 'analista', "orderable": "true" } ,
			{ title: 'Fecha Registro', mData: 'fecha', "orderable": "true" }
		],
		"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});

	$('#DivbtnReporteCasosDiariosAnalista').show();
}