$( document ).ready(function() {
	$("#aseguradoraformConsultaFacturar").select2();
	$("#tipoCasoformConsultaFacturar").select();

	$("#aseguradoraVerFactura").select2().change();

	$("#periodoVerformConsultaFacturar").select2();
	$("#investigadorVerformConsultaFacturar").select2();

	$(".nav-tabs-custom li").click(function(){ 
		$(this).find("span").css("display","inline");
		
		if($(this).attr("id") == "menu_1"){
			$("#menu_2").find("span").css("display","none");
		}else if($(this).attr("id") == "menu_2"){	
			$("#menu_1").find("span").css("display","none");
		}
	});
});

$("#formConsultaFacturar").submit(function(){

	if($("#aseguradoraFacturar").val() != ''){

		var formConsultaFacturar = new FormData($("#formConsultaFacturar")[0]);
		formConsultaFacturar.append("exeTabla","consultaCasosAFacturar");
		loadingSiglo('show', 'Cargando Datos...');

		$.ajax({
			type: 'POST',
			url: 'class/consultasTablas.php',
			data: formConsultaFacturar,
			cache: false,
			contentType: false,
			processData: false,
			success: function(data) {

				var arrayJSON=JSON.parse(data);
				$('#tablaCasosInvestigador').DataTable( {
					scrollX: true,
					dom: 'Bfrtip',
					buttons: [{
						text: '<button  class="btn btn-danger" style="background-color:#9e174f;">Agregar Marcadas</button>',
			            action: function ( e, dt, node, config ) {
			               agregarMarcadas()
			            }
			        }],
					"destroy":true,
					"data":arrayJSON.aaData,
					"bPaginate":true,
					"bFilter" : true,   
					"bProcessing": true,
					"pageLength": 40,
					"columns": [
					{ title: '<>', mData: 'opciones', orderable: false},
					{ title: '<input id="checkMarcarTodas" onclick="marcarTodas();" type="checkbox" >', mData: 'marcar', orderable: false},
					{ title: 'Codigo', mData: 'codigo'},
					{ title: 'Fecha', mData: 'fecha'},
					{ title: 'Radicado', mData: 'radicado'},
					{ title: 'Placa', mData: 'placa'},
					{ title: 'Poliza', mData: 'poliza'},
					{ title: 'Dpto. IPS', mData: 'departamento_ips'},
					{ title: 'IPS', mData: 'nombre_ips'},
					{ title: 'Id Les', mData: 'id_lesionado'},
					{ title: 'Lesionado', mData: 'nombre_lesionado'},
					{ title: 'Resultado', mData: 'resultado'},
					{ title: 'Causal', mData: 'causal'},
					{ title: 'Cargó?', mData: 'cargado'},
					{ title: 'FechaCargue', mData: 'fecha_cargue'},
					{ title: 'Auditoria', mData: 'auditoria'}],
					"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
				});

				loadingSiglo('hide');
				return false;
			}
		});
	}else{
		Swal.fire({
            type: 'error',
            title: 'Upps!',
            text: '¡Puede Buscar por: Aseguradora o Codigó!'
        });
	}

	return false;
});

function marcarTodas() {
	var data = $('#tablaCasosInvestigador').dataTable().fnGetNodes();
	
	if($("#checkMarcarTodas").prop('checked') == true){	
		$(data).each(function (value, index) {
			$(this).find('td input.checkCasos').prop('checked', true);
		});
	}else{
		$(data).each(function (value, index) {
			$(this).find('td input.checkCasos').prop('checked', false);
		});
	}
}

var nodeFilas = [];
function agregarMarcadas() {
	nodeFilas.pop();
	var rows = $('#tablaCasosInvestigador').dataTable().fnGetNodes();
	var fila = "";

	$('#investigadorAsignarCuentaInv').val($('#investigadorCuentaInv').val()).change();

	$(rows).each(function (value, index) {
		if($(this).find('td input.checkCasos').prop('checked')){
			var id = $(this).find('td input.checkCasos').val();
			nodeFilas.push($(this));

			fila += "<tr>"+
				"<td>"+$(this).find("td").eq(2).text()+"</td>"+
				"<td>"+$(this).find("td").eq(4).text()+"</td>"+
				"<td>"+$(this).find("td").eq(5).text()+"</td>"+
				"<td>"+$(this).find("td").eq(11).text()+"</td>"+
				"<td><input name='valores[]' value='"+id+"' type='hidden'></td>"+
			"</tr>";
		}
	});

	if(fila != ""){
		$("#tablaCasosAsignarCuentaInv tbody").html(fila);				
		$("#modalAsignarACuentaInv").modal('show');
	}else{
		Swal.fire({
            type: 'warning',
            title: '¡No Hay Filas Marcadas!',
            text: ''
        });
	}
}

function agregarFila(btn, id) {
	nodeFilas.pop();
	var rowNode = $('#tablaCasosInvestigador').dataTable().fnGetNodes($(btn).parent().parent())
	nodeFilas.push(rowNode);

	$('#investigadorAsignarCuentaInv').val($('#investigadorCuentaInv').val()).change();

	var fila = "<tr>"+
		"<td>"+$(rowNode).find("td").eq(2).text()+"</td>"+
		"<td>"+$(rowNode).find("td").eq(4).text()+"</td>"+
		"<td>"+$(rowNode).find("td").eq(5).text()+"</td>"+
		"<td>"+$(rowNode).find("td").eq(11).text()+"</td>"+
		"<td><input name='valores[]' value='"+id+"' type='hidden'></td>"+
	"</tr>";

	$("#tablaCasosAsignarCuentaInv tbody").html(fila);				
	$("#modalAsignarACuentaInv").modal('show');
}

function removerItemArray(arr, item) {
    var i = arr.indexOf(item); 
    if ( i !== -1 ) {
        arr.splice( i, 1 );
    }
}

$("#formVerFactura").submit(function(){

	if($("#aseguradoraVerFactura").val() == '' || $("#periodoVerFactura").val() == "" || $("#facturaVerFactura").val() == ""){
		Swal.fire({
            type: 'error',
            title: 'Upps!',
            text: '¡Debe Completar Los Campos!'
        });
	}else{

		verFactura($("#facturaVerFactura").val());
	}

	return false;
});

function verFactura(facturaVerFactura){
	loadingSiglo('show', 'Cargando Datos...');
	
	var formConsultaFacturar = new FormData();
		formConsultaFacturar.append("exeTabla","verFactura");
		formConsultaFacturar.append("facturaVerFactura", facturaVerFactura);

	var aseguradora = $("#aseguradoraVerFactura option:selected").text();
	var periodo = $("#periodoVerFactura option:selected").text();
	
	$.ajax({
		type: 'POST',
		url: 'class/consultasTablas.php',
		data: formConsultaFacturar,
		cache: false,
		contentType: false,
		processData: false,
		success: function(data) {
			var arrayJSON=JSON.parse(data);
			/*$("#formCerrarFacturar").show();
			var arrayJSON=JSON.parse(data);

			var totalCasos = 0;
			var adicional = 0;
			var viaticos = 0;
			var totalFactura = 0;

			adicional = parseInt(arrayJSON.totales.valorAdicional);
			viaticos = parseInt(arrayJSON.totales.valorViaticos);
			
			if(arrayJSON.totales.totalCasos > 999){
				totalCasos = puntuarNumero(arrayJSON.totales.totalCasos);
			}

			totalFactura = arrayJSON.totales.totalCasos+adicional+viaticos;

			if(totalFactura > 999){
				totalFactura = puntuarNumero(totalFactura);
			}

			$("#numVerCuentaInv").text(arrayJSON.cuenta);
			
			if(arrayJSON.estado == 2){
				$("#estVerCuentaInv").text('CERRADA');
				$("#estVerCuentaInv").removeClass("bg-green");
				$("#estVerCuentaInv").addClass("bg-red");					
				$("#cerrarCuentaInv").css("display","none");
				$("#habilitarCuentaInv").css("display","block");
				$("#encabezado").removeClass("box-warning");
				$("#encabezado").addClass("box-navy");
				$("#viaticosVerCasosInv").prop("disabled", true);
				$("#adicionalVerCasosInv").prop("disabled", true);
				$("#observacionVerCasosInv").prop("disabled", true);
			}else{
				$("#estVerCuentaInv").text('ABIERTA');
				$("#estVerCuentaInv").removeClass("bg-red");
				$("#estVerCuentaInv").addClass("bg-green");
				$("#encabezado").removeClass("box-navy");
				$("#encabezado").addClass("box-warning");
				$("#cerrarCuentaInv").css("display","block");
				$("#habilitarCuentaInv").css("display","none");
				$("#viaticosVerCasosInv").prop("disabled", false);
				$("#adicionalVerCasosInv").prop("disabled", false);
				$("#observacionVerCasosInv").prop("disabled", false);
			}

			let totaleAseguradora = new Map();
		
			$(arrayJSON.aaData).each(function (value, index) {
				if(totaleAseguradora.get(index.aseguradora)){
					totaleAseguradora.set(index.aseguradora, totaleAseguradora.get(index.aseguradora) + 1);
				}else{
					totaleAseguradora.set(index.aseguradora, 1);
				}
			});

			var totaleAseguradoraText = '';
			for (let [key, value] of totaleAseguradora) {
				totaleAseguradoraText += '<tr><td>*</td><td>'+key+'</td><td><span class="pull-right badge bg-blue">'+value+'</span></td></tr>'; 
			}
			$("#totalesAseguradoraVerCasosInv").html(totaleAseguradoraText);
			
			$("#nomInvVerCuentaInv").text(arrayJSON.investigador);
			$("#perVerCuentaInv").text(periodoTexto(arrayJSON.periodo, arrayJSON.numero));
			$("#canResultVerCuentaInv").text(arrayJSON.totales.cantAtender+"/"+arrayJSON.totales.cantPositivos);
			$("#cantidadVerCuentaInv").text(arrayJSON.iTotalRecords);
			$("#subtotalVerCasosInv").text(totalCasos);
			$("#viaticosVerCasosInv").val(viaticos);
			$("#adicionalVerCasosInv").val(adicional);
			$("#observacionVerCasosInv").val(arrayJSON.observacion);
			$("#totalVerCasosInv").text(totalFactura);*/

			if(arrayJSON.id_tipo_caso == 3 || arrayJSON.id_tipo_caso == 4){//muerte e incapacidad 

				var arrayCol = [
				{ title: 'Tiene PDF?', mData: 'informe'},
				{ title: 'Codigo', mData: 'codigo'},
				{ title: 'F. Accidente', mData: 'fecha_accidente'},
				{ title: 'Placa', mData: 'placa'},
				{ title: 'Poliza', mData: 'poliza'},
				{ title: 'Dpto', mData: 'departamento_ips'},
				{ title: 'Radicado', mData: 'identificador'},
				{ title: 'Tipo Id', mData: 'tipo_identificacion'},
				{ title: 'Identificacion', mData: 'identificacion'},
				{ title: 'Lesionado', mData: 'nombre_lesionado'},
				{ title: 'Resultado', mData: 'resultado'},
				{ title: 'Tipologia', mData: 'tipologia'},
				{ title: 'Perimetro', mData: 'perimetro'},
				{ title: 'Fecha Conocimiento', mData: 'fecha_inicio'},
				{ title: 'Fecha Cargue', mData: 'fecha_cargue'},
				{ title: 'Cambio Estado', mData: 'cambio_estado'},
				{ title: 'Fecha Cambio Estado', mData: 'fecha_cambio_estado'},
				{ title: 'Facturado', mData: 'facturado'},
				{ title: 'Motivo Rechazo', mData: 'motivo_rechazo'}];

			}else if(arrayJSON.id_tipo_caso == 5){//Validaciones

				var arrayCol = [
				{ title: 'Tiene PDF?', mData: 'informe'},
				{ title: 'Codigo', mData: 'codigo'},
				{ title: 'Dpto', mData: 'departamento_ips'},
				{ title: 'Nombre IPS', mData: 'nombre_ips'},
				{ title: 'Nit IPS', mData: 'nit_ips'},
				{ title: 'Fecha Conocimiento', mData: 'fecha_inicio'},
				{ title: 'Fecha Cargue', mData: 'fecha_cargue'},
				{ title: 'Facturado', mData: 'facturado'},
				{ title: 'Motivo Rechazo', mData: 'motivo_rechazo'}];

			}else{
				var arrayCol = [
				{ title: 'Tiene PDF?', mData: 'informe'},
				{ title: 'Tp Investigacion', mData: 'tipoa'},
				{ title: 'Tp Caso', mData: 'tipoCasoCorto'},
				{ title: 'Codigo', mData: 'codigo'},
				{ title: 'F. Accidente', mData: 'fecha_accidente'},
				{ title: 'Placa', mData: 'placa'},
				{ title: 'Poliza', mData: 'poliza'},
				{ title: 'Dpto IPS', mData: 'departamento_ips'},
				{ title: 'Nombre IPS', mData: 'nombre_ips'},
				{ title: 'Nit IPS', mData: 'nit_ips'},
				{ title: 'Radicado', mData: 'identificador'},
				{ title: 'Tipo Id', mData: 'tipo_identificacion'},
				{ title: 'Identificacion', mData: 'identificacion'},
				{ title: 'Lesionado', mData: 'nombre_lesionado'},
				{ title: 'Resultado', mData: 'resultado'},
				{ title: 'Tipologia', mData: 'tipologia'},
				{ title: 'Perimetro', mData: 'perimetro'},
				{ title: 'Fecha Conocimiento', mData: 'fecha_inicio'},
				{ title: 'Fecha Cargue', mData: 'fecha_cargue'},
				{ title: 'Cambio Estado', mData: 'cambio_estado'},
				{ title: 'Fecha Cambio Estado', mData: 'fecha_cambio_estado'},
				{ title: 'Facturado', mData: 'facturado'},
				{ title: 'Motivo Rechazo', mData: 'motivo_rechazo'}];
			}

			if ($.fn.DataTable.isDataTable('#tablaVerFactura')) {
				$('#tablaVerFactura').DataTable().destroy();
				$('#tablaVerFactura').html('<thead style="background-color: #217793; color: white;"></thead><tbody></tbody>')
			}

			$('#tablaVerFactura').DataTable({
				scrollX: true,
				dom: 'Bflrtip',
				buttons: [{	
					extend: 'excelHtml5',
					footer:false,
					filename:'FACTURACION '+aseguradora+' - '+periodo,
		 			title:''
				}],
				"destroy": true,
				"select": true,
				"destroy":true,
				"data":arrayJSON.aaData,
				"bPaginate":true,
				"bFilter" : true,        
				"bProcessing": true,
				"pageLength": 10,
				"columns": arrayCol,
				"language": {"sProcessing": "Procesando...","sLengthMenu": "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
			});			

			loadingSiglo('hide');
			return false;
		}
	});
}

function calcularTotalesVerCuentaInv(){
	var totalFactura = 0;
	var totalFacturaText = 0;
	var rows = $('#tablaVerCasosInv').dataTable().fnGetNodes();
	var cant = 0;
	var cantAtender = 0;
	var cantPositivos = 0;

	let totaleAseguradora = new Map();
		
	$(rows).each(function (value, index) {
		cant++;
		totalFactura = totalFactura + parseInt($(this).find('td input.valorCasos').val());

		if($(this).find('td:eq(3)').text() == 'ATENDER'){
			cantAtender++;
		}else{
			cantPositivos++;
		}

		if(totaleAseguradora.get($(this).find('td:eq(4)').text())){
			totaleAseguradora.set($(this).find('td:eq(4)').text(), totaleAseguradora.get($(this).find('td:eq(4)').text()) + 1);
		}else{
			totaleAseguradora.set($(this).find('td:eq(4)').text(), 1);
		}
	});

	var totaleAseguradoraText = '';
	for (let [key, value] of totaleAseguradora) {
		totaleAseguradoraText += '<tr><td>*</td><td>'+key+'</td><td><span class="pull-right badge bg-blue">'+value+'</span></td></tr>'; 
	}
	$("#totalesAseguradoraVerCasosInv").html(totaleAseguradoraText);

	$("#canResultVerCuentaInv").text(cantAtender+"/"+cantPositivos);

	if(totalFactura > 999){
		totalFacturaText = puntuarNumero(totalFactura);
	}

	$("#subtotalVerCasosInv").text(totalFacturaText);

	totalFactura = parseInt(totalFactura) + parseInt($("#adicionalVerCasosInv").val()) + parseInt($("#viaticosVerCasosInv").val());

	if(totalFactura > 999){
		totalFacturaText = puntuarNumero(totalFactura);
	}

	$("#cantidadVerCuentaInv").text(cant);

	$("#totalVerCasosInv").text(totalFacturaText);
}

$("#adicionalVerCasosInv").blur(function(){
	calcularTotalesVerCuentaInv();
});

$("#viaticosVerCasosInv").blur(function(){
	calcularTotalesVerCuentaInv();
});

$("#aseguradoraFacturar").change(function() {

	var idAseguradora = $('#aseguradoraFacturar option:selected').val();
	var tipoCasos = "Global";
	var selectUbicacion = "#tipoCasoFacturar";
	var optionVacio = 1;

	$.ajax({
		type: 'POST',
		url: 'class/consultasBasicas.php',
		data: "exe=consultarAmparosAseguradora&idAseguradora="+idAseguradora+"&tipoCasos="+tipoCasos+"&optionVacio="+optionVacio,
		beforeSend: function() {
	        loadingSiglo('show', 'Cargando Tipos Aseguradora...');
	    },
		success: function(res) {
			if ($(selectUbicacion).hasClass("select2-hidden-accessible")) {
				$(selectUbicacion).select2("destroy");
			}
			var json_obj = $.parseJSON(res);
			var options = '';
			for (var i = 0; i < json_obj.length; i++) {
				options += '<option value="'+json_obj[i].valor+'">' + json_obj[i].descripcion + '</option>';			
			}
			$(selectUbicacion).html(options);
			$(selectUbicacion).select2();
	        loadingSiglo('hide');
			return false;
		},
		error: function(data) {
	        loadingSiglo('hide');
	    }
	});
});

function cargarPeriodosVerFactura(){
	if($("#aseguradoraVerFactura").val() != ''){
		loadingSiglo('show', 'Cargando Datos...');

		$.ajax({
			type: 'POST',
			url: 'class/consultasBasicas.php',
			data: "exe=consultarPeriodosFacturas&parametro="+$("#aseguradoraVerFactura").val(),
			beforeSend: function() {
		        loadingSiglo('show', 'Cargando Datos...');
		    },
		    success: function(res) {
					
				if ($("#periodoVerFactura").hasClass("select2-hidden-accessible")) {
					$("#periodoVerFactura").select2("destroy");
				}
				var json_obj = $.parseJSON(res);
				var options = '<option value=""></option>';
				for (var i = 0; i < json_obj.length; i++) {
					if(json_obj[i].descripcion2 != ''){
						options += '<option value="'+json_obj[i].periodo+'">' + json_obj[i].nomMes + '</option>';
					}				
				}
				$("#periodoVerFactura").html(options);
				$("#periodoVerFactura").select2();
		        loadingSiglo('hide');
				return false;
			}
		});
	}		
}

function cargarObservacionVerFactura(){
	if($("#periodoVerFactura").val() != ''){
		loadingSiglo('show', 'Cargando Datos...');

		$.ajax({
			type: 'POST',
			url: 'class/consultasBasicas.php',
			data: "exe=consultarNombreFacturas&parametro="+$("#periodoVerFactura").val()+"&parametro2="+$("#aseguradoraVerFactura").val(),
			beforeSend: function() {
		        loadingSiglo('show', 'Cargando Datos...');
		    },
		    success: function(res) {
					
				if ($("#facturaVerFactura").hasClass("select2-hidden-accessible")) {
					$("#facturaVerFactura").select2("destroy");
				}
				var json_obj = $.parseJSON(res);
				var options = '<option value=""></option>';
				for (var i = 0; i < json_obj.length; i++) {
					if(json_obj[i].descripcion2 != ''){
						options += '<option value="'+json_obj[i].id+'">' + json_obj[i].observacion + '</option>';
					}				
				}
				$("#facturaVerFactura").html(options);
				$("#facturaVerFactura").select2();
		        loadingSiglo('hide');
				return false;
			}
		});
	}		
}