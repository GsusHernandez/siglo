$( document ).ready(function() {
	$("#aseguradoraCuentaAna").select2();
	$("#tipoCasoCuentaAna").select();
	$("#AnalistaCuentaAna").select2();

	$("#periodoVerGrupoCuentasAna").select2();
	$("#analistaVerGrupoCuentaAna").select2()

	$("#periodoVerCuentaAna").select2();

	if($("#analistaVerCuentaAna").attr('type') != 'hidden'){
		$("#analistaVerCuentaAna").select2();
	}

	$(".nav-tabs-custom li").click(function(){ 
		$(this).find("span").css("display","inline");
		
		if($(this).attr("id") == "menu_1"){
			$("#menu_2").find("span").css("display","none");
		}else if($(this).attr("id") == "menu_2"){	
			$("#menu_1").find("span").css("display","none");
		}
	});
});

$("#formConsultaCuentaAnalista").submit(function(){
	var formConsultaCuentaAnalista = new FormData($("#formConsultaCuentaAnalista")[0]);
	formConsultaCuentaAnalista.append("exeTabla","consultaCasosCuentaCobroAnalista");
	formConsultaCuentaAnalista.append("analistaCuentaAna", $("#btnLogout").attr("name"));
	loadingSiglo('show', 'Cargando Datos...');

	$.ajax({
		type: 'POST',
		url: 'class/consultasTablas.php',
		data: formConsultaCuentaAnalista,
		cache: false,
		contentType: false,
		processData: false,
		success: function(data) {

			var arrayJSON=JSON.parse(data);			
			$('#tablaCasosAnalista').DataTable( {
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
				{ title: 'Acción', mData: 'opciones', orderable: false},
				{ title: '<input id="checkMarcarTodas" class="chequeos" onclick="marcarTodas();" type="checkbox" ><label title="Marcar Todas" for="checkMarcarTodas"></label>', mData: 'marcar', orderable: false},
				{ title: 'Tipo', mData: 'tipoCaso'},
				{ title: 'Codigo', mData: 'codigo'},
				{ title: 'Origen', mData: 'origen'},
				{ title: 'Lesionado', mData: 'lesionado'},
				{ title: 'Entidad', mData: 'aseguradora'},
				{ title: 'Result', mData: 'resultado'},
				{ title: 'Fecha', mData: 'fecha'}],
				"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
			});

			$("#codigoCuentaAna").val('');

			loadingSiglo('hide');
			return false;
		}
	});

	return false;
});

function marcarTodas() {
	var data = $('#tablaCasosAnalista').dataTable().fnGetNodes();
	
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
	nodeFilas = [];
	var rows = $('#tablaCasosAnalista').dataTable().fnGetNodes();
	var fila = "";

	$(rows).each(function (value, index) {
		if($(this).find('td input.checkCasos').prop('checked')){
			var id = $(this).find('td input.checkCasos').val();
			nodeFilas.push($(this));

			fila += "<tr>"+
				"<td>"+$(this).find("td").eq(2).text()+"</td>"+
				"<td>"+$(this).find("td").eq(3).text()+"</td>"+
				"<td>"+$(this).find("td").eq(5).text()+"</td>"+
				"<td><input name='valores[]' value='"+id+"' type='hidden'></td>"+
			"</tr>";
		}
	});

	if(fila != ""){
		$("#tablaCasosAsignarCuentaAna tbody").html(fila);				
		$("#modalAsignarACuentaAna").modal('show');
	}else{
		Swal.fire({
            type: 'warning',
            title: '¡No Hay Filas Marcadas!',
            text: ''
        });
	}
}

function agregarFila(btn, id) {
	nodeFilas = [];
	var rowNode = $('#tablaCasosAnalista').dataTable().fnGetNodes($(btn).parent().parent())
	nodeFilas.push(rowNode);

	var fila = "<tr>"+
		"<td>"+$(rowNode).find("td").eq(2).text()+"</td>"+
		"<td>"+$(rowNode).find("td").eq(3).text()+"</td>"+
		"<td>"+$(rowNode).find("td").eq(5).text()+"</td>"+
		"<td><input name='valores[]' value='"+id+"' type='hidden'></td>"+
	"</tr>";

	$("#tablaCasosAsignarCuentaAna tbody").html(fila);				
	$("#modalAsignarACuentaAna").modal('show');
}

$("#frmAsignarCasosCuentaAna").submit(function(){
	var formConsultaCuentaAnalista = new FormData($("#frmAsignarCasosCuentaAna")[0]);
	formConsultaCuentaAnalista.append("exe", "asignarCasosCuentaAna");
	formConsultaCuentaAnalista.append("xd", $("#btnLogout").attr("name"));
	formConsultaCuentaAnalista.append("periodoAsignarCuentaAna", $("#periodoAsignarCuentaAna").val()+"-00");

	if($("#periodoAsignarCuentaAna").val() == "" || $("#numeroAsignarCuentaAna").val() == ""){
		Swal.fire({
            type: 'error',
            title: 'Upps!',
            text: '¡Los Campos están Incompletos!'
        });
		return false;
	}
	
	loadingSiglo('show', 'Asignando a Cuenta...');
	$.ajax({
		type: 'POST',
		url: 'class/consultasManejoAnalista.php',
		data: formConsultaCuentaAnalista,
		cache: false,
		contentType: false,
		processData: false,
		success: function(data) {
			
			switch (data) {
			    case 1:
					var tabla = $('#tablaCasosAnalista').dataTable();
					$(nodeFilas).each(function (value, index) {
						tabla.fnDeleteRow($(this));		
					});

					nodeFilas = [];
					$("#tablaCasosAsignarCuentaAna tbody").html("");				
					$("#modalAsignarACuentaAna").modal('hide');
					
					loadingSiglo('hide');
			    	
			    	Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: '¡Casos Agregados Satisfactoriamente!',
						showConfirmButton: false,
						timer: 1500
					});

					return false;
			    break;

			  	case 2:
					Swal.fire({
						title: '¿DESEA CREARLA AHORA?',
						text: "No Existe Cuenta para este periodo",
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Crear',
						confirmButtonCancel: 'Cancelar'
					}).then((result) => {

						if (result.value) {
							loadingSiglo('show', 'Creando a Cuenta...');
							var datosCrearCuenta = new FormData($("#frmAsignarCasosCuentaAna")[0]);
							datosCrearCuenta.append("exe","crearCuentaAnalista");
							datosCrearCuenta.append("periodoAsignarCuentaAna", $("#periodoAsignarCuentaAna").val()+"-00");
							datosCrearCuenta.append("xd", $("#btnLogout").attr("name"));
							
							$.ajax({
								type: 'POST',
								url: 'class/consultasManejoAnalista.php',
								data: datosCrearCuenta,
								cache: false,
								contentType: false,
								processData: false,
								success: function(dato) {

									if(dato == 1){

										var tabla = $('#tablaCasosAnalista').dataTable();
										$(nodeFilas).each(function (value, index) {
											tabla.fnDeleteRow($(this));		
										});

										nodeFilas = [];
										$("#tablaCasosAsignarCuentaAna tbody").html("");				
										$("#modalAsignarACuentaAna").modal('hide');	

										loadingSiglo('hide');

						                Swal.fire({
										  position: 'top-end',
										  icon: 'success',
										  title: '¡Casos Agregados Satisfactoriamente!',
										  showConfirmButton: false,
										  timer: 1500
										});
									}else if(dato == 3){
										loadingSiglo('hide');

						                Swal.fire({
										  position: 'top-end',
										  icon: 'error',
										  title: '¡Cuenta de Cobro CERRADA!',
										  showConfirmButton: false,
										  timer: 1500
										});
									}else {
										loadingSiglo('hide');

						                Swal.fire({
										  position: 'top-end',
										  icon: 'error',
										  title: '¡Error, Al crear casos!',
										  showConfirmButton: false,
										  timer: 1500
										});
									}

									loadingSiglo('hide');
									return false;
								},
								error: function(){
									loadingSiglo('hide');
									Swal.fire({
					                    type: 'error',
					                    title: 'Upps!',
					                    text: '¡Algo ha Salido Mal!'
					                });
								}
							}, 'json');
						}
					});
			    break;

			    case 3:
			    	Swal.fire({
	                    type: 'error',
	                    title: 'Upps!',
	                    text: '¡Cuenta de Cobro CERRADA!'
	                });
					loadingSiglo('hide');
					return false;
			    break;
			  	
			  	default:
					loadingSiglo('hide');
					Swal.fire({
	                    type: 'error',
	                    title: 'Upps!',
	                    text: '¡Algo ha Salido Mal!'
	                });
			    break;
			}

			loadingSiglo('hide');
			return false;
		},
		error: function(){
			loadingSiglo('hide');
			Swal.fire({
                type: 'error',
                title: 'Upps!',
                text: '¡Algo ha Salido Mal!'
            });
		}
	}, 'json');

	return false;
})

function removerItemArray(arr, item) {
    var i = arr.indexOf(item); 
    if ( i !== -1 ) {
        arr.splice( i, 1 );
    }
}

$("#formVerCuentaAnalista").submit(function(){

	if($("#AnalistaVerCuentaAna").val() == '' || $("#periodoVerCuentaAna").val() == ""){
		Swal.fire({
            type: 'error',
            title: 'Upps!',
            text: '¡Debe Completar Los Campos!'
        });
	}else{
		$("#nomAnaVerCuentaAna").attr("name", $("#analistaVerCuentaAna").val());
		$("#perVerCuentaAna").attr("name", $("#periodoVerCuentaAna").val());

		verCuentaCobro($("#analistaVerCuentaAna").val(), $("#periodoVerCuentaAna").val());
	}

	return false;
});

function verCuentaCobro(analistaVerCuentaAna, periodoVerCuentaAna){
	loadingSiglo('show', 'Cargando Datos...');
	
	var formConsultaCuentaAnalista = new FormData();
		formConsultaCuentaAnalista.append("exeTabla","verCasosCuentaCobroAna");
		formConsultaCuentaAnalista.append("analistaVerCuentaAna", analistaVerCuentaAna);
		formConsultaCuentaAnalista.append("periodoVerCuentaAna", periodoVerCuentaAna);
		
	$.ajax({
		type: 'POST',
		url: 'class/consultasTablas.php',
		data: formConsultaCuentaAnalista,
		cache: false,
		contentType: false,
		processData: false,
		success: function(data) {

			$("#formCerrarCuentaAnalista").show();
			var arrayJSON=JSON.parse(data);
			var totalCasos = 0;
			var valorGuardado = 0;
			var adicional = 0;
			var descuento = 0;
			var totalFactura = 0;
			adicional = parseInt(arrayJSON.totales.valorAdicional);
			descuento = parseInt(arrayJSON.totales.valorDescuento);
			
			if(arrayJSON.totales.totalCasos > 999){
				totalCasos = puntuarNumero(arrayJSON.totales.totalCasos);
			}

			totalFactura = arrayJSON.totales.totalCasos+adicional-descuento;

			if(totalFactura > 999){
				totalFactura = puntuarNumero(totalFactura);
			}
			
			if(arrayJSON.totales.valorGuardado > 999){
				valorGuardado = puntuarNumero(arrayJSON.totales.valorGuardado);
			}
			

			$("#numVerCuentaAna").text(arrayJSON.cuenta);

			if(arrayJSON.estado == 2){
				$("#estVerCuentaAna").text('CERRADA');
				$("#estVerCuentaAna").removeClass("bg-green");
				$("#estVerCuentaAna").removeClass("bg-light-blue");
				$("#estVerCuentaAna").addClass("bg-red");					
				$("#cerrarCuentaAna").css("display","none");
				$("#habilitarCuentaAna").css("display","block");
				$("#encabezado").removeClass("box-success");
				$("#encabezado").removeClass("box-warning");
				$("#encabezado").addClass("box-navy");
				$("#descuentoVerCasosAna").prop("disabled", true);
				$("#adicionalVerCasosAna").prop("disabled", true);
				$("#observacionVerCasosAna").prop("disabled", true);
			}else if(arrayJSON.estado == 1){
				$("#estVerCuentaAna").text('ENVIADA');
				$("#estVerCuentaAna").removeClass("bg-red");
				$("#estVerCuentaAna").removeClass("bg-green");
				$("#estVerCuentaAna").addClass("bg-light-blue");
				$("#encabezado").removeClass("box-navy");
				$("#encabezado").removeClass("box-warning");
				$("#encabezado").addClass("box-success");
				$("#descuentoVerCasosAna").prop("disabled", false);
				$("#adicionalVerCasosAna").prop("disabled", false);
				$("#observacionVerCasosAna").prop("disabled", false);
			}
			else{
				$("#estVerCuentaAna").text('ABIERTA');
				$("#estVerCuentaAna").removeClass("bg-red");
				$("#estVerCuentaAna").removeClass("bg-light-blue");
				$("#estVerCuentaAna").addClass("bg-green");
				$("#encabezado").removeClass("box-navy");
				$("#encabezado").removeClass("box-success");
				$("#encabezado").addClass("box-warning");
				$("#descuentoVerCasosAna").prop("disabled", false);
				$("#adicionalVerCasosAna").prop("disabled", false);
				$("#observacionVerCasosAna").prop("disabled", false);
				$("#cerrarCuentaAna").css("display","block");
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
			$("#totalesAseguradoraVerCasosAna").html(totaleAseguradoraText);
			
			$("#nomAnaVerCuentaAna").text(arrayJSON.analista);
			$("#perVerCuentaAna").text(periodoTexto(arrayJSON.periodo, arrayJSON.numero));
			$("#canResultVerCuentaAna").text(arrayJSON.totales.cantAtender+"/"+arrayJSON.totales.cantPositivos);
			$("#cantidadVerCuentaAna").text(arrayJSON.iTotalRecords);
			//========GestioncuentacobroAnalista====///
				$("#trValorGuardado").show();
				$("#valorGuardadoCasosAna").text(valorGuardado);
			//=========================================//
			$("#subtotalVerCasosAna").text(totalCasos);
			$("#adicionalVerCasosAna").val(adicional);
			$("#descuentoVerCasosAna").val(descuento);
			$("#observacionVerCasosAna").val(arrayJSON.observacion);
			$("#totalVerCasosAna").text(totalFactura);
			$('#tablaVerCasosAna').DataTable({
				scrollX: true,
				dom: 'Bfrtip',
				buttons:  [{
					text: '<button  class="btn btn-success" id="exportarCuentaCobroExcel">Descargar Cuenta</button>',
		            action: function ( e, dt, node, config ) {
		            	exportarCuentaCobroExcel(arrayJSON.cuenta)
		            }
		        }],
				"destroy": true,
				"data": arrayJSON.aaData,
				"bPaginate": true,
				"bFilter": true,
				"bProcessing": true,
				"pageLength": 10,
				"columns": [
				{ title: 'Acción', mData: 'opciones', orderable: false},
				{ title: 'Tipo', mData: 'tipoCasoCorto'},
				{ title: 'Codigo', mData: 'codigo'},
				{ title: 'Origen', mData: 'origen_lt'},
				{ title: 'Aseguradora', mData: 'aseguradora'},
				{ title: 'Resultado', mData: 'resultado'},
				{ title: 'Lesionado', mData: 'lesionado'},
				{ title: 'Valor', mData: 'valor'}],
				"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
			});

			loadingSiglo('hide');
			return false;
		}
	});
}

function calcularTotalesVerCuentaAna(){
	var totalFactura = 0;
	var totalFacturaText = 0;
	var rows = $('#tablaVerCasosAna').dataTable().fnGetNodes();
	var cant = 0;
	var cantAtender = 0;
	var cantPositivos = 0;

	let totaleAseguradora = new Map();
		
	$(rows).each(function (value, index) {
		cant++;
		totalFactura = totalFactura + parseInt($(this).find('td input.valorCasos').val());

		if($(this).find('td:eq(3)').text() == 'NO ATENDER'){
			cantPositivos++;
		}else{
			cantAtender++;
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
	$("#totalesAseguradoraVerCasosAna").html(totaleAseguradoraText);

	$("#canResultVerCuentaAna").text(cantAtender+"/"+cantPositivos);

	if(totalFactura > 999){
		totalFacturaText = puntuarNumero(totalFactura);
	}

	$("#subtotalVerCasosAna").text(totalFacturaText);

	totalFactura = parseInt(totalFactura) + parseInt($("#adicionalVerCasosAna").val()) - parseInt($("#descuentoVerCasosAna").val());

	if(totalFactura > 999){
		totalFacturaText = puntuarNumero(totalFactura);
	}

	$("#cantidadVerCuentaAna").text(cant);

	$("#totalVerCasosAna").text(totalFacturaText);
}

$("#adicionalVerCasosAna").blur(function(){
	calcularTotalesVerCuentaAna();
});

$("#descuentoVerCasosAna").blur(function(){
	calcularTotalesVerCuentaAna();
});

function eliminarFilaCuentaAna(btn, id, idCuenta, origen) {

	var rowNode = $('#tablaVerCasosAna').dataTable().fnGetNodes($(btn).parent().parent());

	var codigo = $(rowNode).find('td').eq(1).text();

	Swal.fire({
		title: 'EL '+codigo+' SERÁ ELIMINADO, ¿ESTÁ SEGURO?',
		text: "¡El caso "+codigo+" se eliminará de esta cuenta de Cobro!",
		icon: 'warning',
		showCancelButton: true,
		cancelButtonColor: '#d33',
		confirmButtonText: 'Eliminar',
		confirmButtonCancel: 'Cancelar'
	}).then((result) => {

		if(result.value){
			loadingSiglo('show', 'Eliminando Caso...');
			$.ajax({
				type: 'POST',
				url: 'class/consultasManejoAnalista.php',
				data: "xd="+id+"&cuenta="+idCuenta+"&exe=eliminarCasoCuentaAna&origen="+origen,
				success: function(data) {
					
					switch (data) {
					    case 1:

							var tabla = $('#tablaVerCasosAna').dataTable();
							tabla.fnDeleteRow($(rowNode));	

					    	calcularTotalesVerCuentaAna();
							
							loadingSiglo('hide');
					    	
					    	Swal.fire({
								position: 'top-end',
								icon: 'success',
								title: '¡Caso Eliminado Satisfactoriamente!',
								showConfirmButton: false,
								timer: 1500
							});

							return false;
					    break;

					    case 2:
					    	Swal.fire({
			                    type: 'error',
			                    title: 'Upps!',
			                    text: 'Error. ¡El caso ya No existe en la cuenta!'
			                });
							loadingSiglo('hide');
							return false;
					    break;
					  	
					  	default:
							loadingSiglo('hide');
							Swal.fire({
			                    type: 'error',
			                    title: 'Upps!',
			                    text: '¡Algo ha Salido Mal!'
			                });
					    break;
					}

					loadingSiglo('hide');
					return false;
				},
				error: function(){
					loadingSiglo('hide');
					Swal.fire({
		                type: 'error',
		                title: 'Upps!',
		                text: '¡Algo ha Salido Mal!'
		            });
				}
			}, 'json');
		}
	});				
}

$("#guardarCuentaAna").click(function() {

	var rows = $('#tablaVerCasosAna').dataTable().fnGetNodes();
	var error = false;

	let inputsValorCasos = [];
	let inputsTarifaCasos = [];
	let inputsIdCasos = [];
	let inputsOrigenCasos = [];

	$(rows).each(function (value, index) {
		if($(this).find('td input.valorCasos').val() < 1500){
			error = true;
		}

		inputsValorCasos.push($(this).find('td input.valorCasos').val());
		inputsTarifaCasos.push($(this).find('td input.tarifaCasos').val());
		inputsIdCasos.push($(this).find('td input.idCasos').val());
		inputsOrigenCasos.push($(this).find('td input.origenCasos').val());
	});

	if(error == true){
		Swal.fire({
            type: 'error',
            title: 'Upps!',
            text: '¡Hay valores fuera de las Tárifas!'
        });
	}else if($("#adicionalVerCasosAna").val() < 0){
		Swal.fire({
            type: 'error',
            title: 'Upps!',
            text: '¡Adicional debe  ser igual o mayor a 0!'
        });
	}else if($("#descuentoVerCasosAna").val() < 0){
		Swal.fire({
            type: 'error',
            title: 'Upps!',
            text: 'Descuento debe  ser igual o mayor a 0!'
        });
	}else{

		var formConsultaCuentaAnalista = new FormData();
		formConsultaCuentaAnalista.append("exe","guardarCuentaCobroAna");
		formConsultaCuentaAnalista.append("numVerCuentaAna", $("#numVerCuentaAna").text());
		formConsultaCuentaAnalista.append("subtotalVerCasosAna", $("#subtotalVerCasosAna").text());
		formConsultaCuentaAnalista.append("adicionalVerCasosAna", $("#adicionalVerCasosAna").val());
		formConsultaCuentaAnalista.append("descuentoVerCasosAna", $("#descuentoVerCasosAna").val());
		formConsultaCuentaAnalista.append("observacionVerCasosAna", $("#observacionVerCasosAna").val());
		formConsultaCuentaAnalista.append("totalVerCasosAna", $("#totalVerCasosAna").text());
		formConsultaCuentaAnalista.append("id_usuario", $('#btnLogout').attr('name'));

		formConsultaCuentaAnalista.append("valorCasos1", JSON.stringify(inputsValorCasos));
		formConsultaCuentaAnalista.append("tarifaCasos1", JSON.stringify(inputsTarifaCasos));
		formConsultaCuentaAnalista.append("idCasos1", JSON.stringify(inputsIdCasos));
		formConsultaCuentaAnalista.append("origenCasos1", JSON.stringify(inputsOrigenCasos));
		
		loadingSiglo('show', 'Cargando Datos...');

		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoAnalista.php',
			data: formConsultaCuentaAnalista,
			cache: false,
			contentType: false,
			processData: false,
			success: function(data) {

				var arrayJSON=JSON.parse(data);

				if(data == 1){
					$("#estVerCuentaAna").text('ENVIADA');
					$("#estVerCuentaAna").removeClass("bg-green");
					$("#estVerCuentaAna").addClass("bg-light-blue");

					$("#encabezado").removeClass("box-warning");
					$("#encabezado").addClass("box-success");

					loadingSiglo('hide');
					Swal.fire({
	                    type: 'success',
	                    title: 'ENVIADA!',
	                    text: '¡Cuenta Guardada y Enviada!'
	                });

	                $("#btnVerCuentaAna").click();
				}else if(data == 2){
					loadingSiglo('hide');
					Swal.fire({
	                    type: 'error',
	                    title: 'Upps!',
	                    text: '¡Algo ha Salido Mal!'
	                });
				}else if(data == 3){
					loadingSiglo('hide');
					Swal.fire({
	                    type: 'error',
	                    title: 'Upps!',
	                    text: '¡La Cuenta ya Estaba Cerrada!'
	                });
				}

				loadingSiglo('hide');
				return false;
			}
		});
	}
	return false;
});

$("#cerrarCuentaAna").click(function() {

	var rows = $('#tablaVerCasosAna').dataTable().fnGetNodes();
	var error = false;

	let inputsValorCasos = [];
	let inputsTarifaCasos = [];
	let inputsIdCasos = [];

	$(rows).each(function (value, index) {
		if($(this).find('td input.valorCasos').val() < 1500){
			error = true;
		}

		inputsValorCasos.push($(this).find('td input.valorCasos').val());
		inputsTarifaCasos.push($(this).find('td input.tarifaCasos').val());
		inputsIdCasos.push($(this).find('td input.idCasos').val());
	});

	if(error == true){
		Swal.fire({
            type: 'error',
            title: 'Upps!',
            text: '¡Hay valores fuera de las Tárifas!'
        });
	}else if($("#adicionalVerCasosAna").val() < 0){
		Swal.fire({
            type: 'error',
            title: 'Upps!',
            text: '¡Debe Completar Los Campos!'
        });
	}else{

		var formConsultaCuentaAnalista = new FormData();
		formConsultaCuentaAnalista.append("exe","cerrarCuentaCobroAna");
		formConsultaCuentaAnalista.append("numVerCuentaAna", $("#numVerCuentaAna").text());
		formConsultaCuentaAnalista.append("subtotalVerCasosAna", $("#subtotalVerCasosAna").text());
		formConsultaCuentaAnalista.append("adicionalVerCasosAna", $("#adicionalVerCasosAna").val());
		formConsultaCuentaAnalista.append("observacionVerCasosAna", $("#observacionVerCasosAna").val());
		formConsultaCuentaAnalista.append("totalVerCasosAna", $("#totalVerCasosAna").text());
		formConsultaCuentaAnalista.append("id_usuario", $('#btnLogout').attr('name'));

		formConsultaCuentaAnalista.append("valorCasos1", JSON.stringify(inputsValorCasos));
		formConsultaCuentaAnalista.append("tarifaCasos1", JSON.stringify(inputsTarifaCasos));
		formConsultaCuentaAnalista.append("idCasos1", JSON.stringify(inputsIdCasos));
		loadingSiglo('show', 'Cargando Datos...');

		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoAnalista.php',
			data: formConsultaCuentaAnalista,
			cache: false,
			contentType: false,
			processData: false,
			success: function(data) {

				var arrayJSON=JSON.parse(data);

				if(data == 1){
					$(".valorCasos").prop("disabled","true");
					$("#adicionalVerCasosAna").prop("disabled","true");
					$("#descuentoVerCasosAna").prop("disabled","true");
					$("#observacionVerCasosAna").prop("disabled","true");
					$("#cerrarCuentaAna").css("display","none");
					$("#habilitarCuentaAna").css("display","block");
					$(".btns-eliminar").prop("disabled","true");

					$("#estVerCuentaAna").text('CERRADA');
					$("#estVerCuentaAna").removeClass("bg-green");
					$("#estVerCuentaAna").addClass("bg-red");

					$(".btns-eliminar").removeClass("btn-warning");
					$(".btns-eliminar").addClass("btn-default");

					$("#encabezado").removeClass("box-warning");
					$("#encabezado").addClass("box-navy");
				}else if(data == 2){
					loadingSiglo('hide');
					Swal.fire({
	                    type: 'error',
	                    title: 'Upps!',
	                    text: '¡Algo ha Salido Mal!'
	                });
				}else if(data == 3){
					loadingSiglo('hide');
					Swal.fire({
	                    type: 'error',
	                    title: 'Upps!',
	                    text: '¡La Cuenta ya Estaba Cerrada!'
	                });
				}

				loadingSiglo('hide');
				return false;
			}
		});
	}

	return false;
});

$("#habilitarCuentaAna").click(function() {
	
	loadingSiglo('show', 'Cargando Datos...');

	var formConsultaCuentaAnalista = new FormData();
	formConsultaCuentaAnalista.append("exe","habilitarCuentaCobroAna");
	formConsultaCuentaAnalista.append("numVerCuentaAna", $("#numVerCuentaAna").text());
	loadingSiglo('show', 'Cargando Datos...');

	$.ajax({
		type: 'POST',
		url: 'class/consultasManejoAnalista.php',
		data: formConsultaCuentaAnalista,
		cache: false,
		contentType: false,
		processData: false,
		success: function(data) {

			var arrayJSON=JSON.parse(data);

			if(data == 1){
				
				loadingSiglo('hide');
				
				verCuentaCobro($("#nomAnaVerCuentaAna").attr("name"), $("#perVerCuentaAna").attr("name"));
				
				Swal.fire({
                    type: 'success',
                    title: 'Cuenta Habilitada!',
                    text: ''
                });
			}else {
				loadingSiglo('hide');
				Swal.fire({
                    type: 'error',
                    title: 'Upps!',
                    text: '¡Algo salio Mal!'
                });
			}
			return false;
		}
	});				
});

function refreshTab(divTab){
	switch (divTab){
		case 'cuentaCobroAnaTab1':
			$("#aseguradoraCuentaAna").val('').trigger('change.select2');
			$("#tipoCasoCuentaAna").val('').trigger('change.select2');
			$("#fLimiteCuentaAna").val('');
			if ( $.fn.DataTable.isDataTable('#tablaCasosAnalista') ) {
			  $('#tablaCasosAnalista').DataTable().destroy();
			}
			$("#tablaCasosAnalista").html('<thead style="background-color: #188aff; color: white;"></thead><tbody></tbody>');
		break;
		
		case 'cuentaCobroAnaTab2':
			$("#periodoVerCuentaAna").val('').trigger('change.select2');
			cargarPeriodosCuenta();
			if ( $.fn.DataTable.isDataTable('#tablaVerCasosAna') ) {
			  $('#tablaVerCasosAna').DataTable().destroy();
			}
			$("#tablaVerCasosAna").html('<thead style="background-color: #188aff; color: white;"></thead><tbody></tbody>');
			$("#formCerrarCuentaAnalista").hide();
		break;
		default:
    		//No coincide con el valor de la expresión
    	break;
	}
}

function cargarPeriodosCuenta(){
	loadingSiglo('show', 'Cargando Datos...');

	$.ajax({
		type: 'POST',
		url: 'class/consultasBasicas.php',
		data: "exe=consultarPeriodosCuentasAna&parametro="+$("#btnLogout").attr("name"),
		beforeSend: function() {
	        loadingSiglo('show', 'Cargando Datos...');
	    },
	    success: function(res) {
				
			if ($("#periodoVerCuentaAna").hasClass("select2-hidden-accessible")) {
				$("#periodoVerCuentaAna").select2("destroy");
			}
			var json_obj = $.parseJSON(res);
			var options = '<option value="">TODOS</option>';
			for (var i = 0; i < json_obj.length; i++) {
				if(json_obj[i].descripcion2 != ''){
					options += '<option value="'+json_obj[i].periodo+'/'+json_obj[i].numero+'">' + json_obj[i].numero + " - " + json_obj[i].nomMes + " " + json_obj[i].anio + '</option>';
				}				
			}
			$("#periodoVerCuentaAna").html(options);
			$("#periodoVerCuentaAna").select2();
	        loadingSiglo('hide');
			return false;
		}
	});
}

function exportarCuentaCobroExcel(id_cuenta){
	loadingSiglo('show', 'Generando Cuenta de Cobro...');
	var periodoTexto = $("#perVerCuentaAna").text();
	$.post("class/consultasManejoAnalista.php", {id_cuenta:id_cuenta, periodoTexto:periodoTexto, exe:"exportarCuentaCobroExcel"}, function(datos){
		window.open('https://www.globalredltda.co/siglo/portal/bower_components/PHPExcel/informes/'+datos, '_blank');
		loadingSiglo('hide');
	}, 'json');
};

$("#formVerGrupoCuentaAnalista").submit(function(){
	var formVerGrupoCuentaAnalista = new FormData($("#formVerGrupoCuentaAnalista")[0]);
	formVerGrupoCuentaAnalista.append("exeTabla","verGrupoCuentaCobroAnalista");
	formVerGrupoCuentaAnalista.append("periodoVerGrupoCuentasAna", $("#periodoVerGrupoCuentasAna").val());
	formVerGrupoCuentaAnalista.append("analistaVerGrupoCuentaAna", $("#analistaVerGrupoCuentaAna").val());
	formVerGrupoCuentaAnalista.append("estadoVerGrupoCuentaAna", $("#estadoVerGrupoCuentaAna").val());
	formVerGrupoCuentaAnalista.append("numeroVerGrupoCuentaAna", $("#numeroVerGrupoCuentaAna").val());

	if($("#periodoVerGrupoCuentasAna").val() != ""){
		loadingSiglo('show', 'Cargando Datos...');

		$.ajax({
			type: 'POST',
			url: 'class/consultasTablas.php',
			data: formVerGrupoCuentaAnalista,
			cache: false,
			contentType: false,
			processData: false,
			success: function(data) {

				var arrayJSON=JSON.parse(data);
				$('#tablaCasosAnalista').DataTable( {
					scrollX: true,
					dom: 'Bfrtip',
				 	buttons: [{
                        text: '<button class="btn btn-danger" id="btnHabilitarCuentas" onclick="cerrarMarcadas()" style="background-color:#9e174f;">Cerrar C. Marcadas</button> <button class="btn btn-info" onclick="habilitarCuentas()" style="background-color:#1572A1;">Habilitar C. Marcadas</button>',
                    }],
					"destroy":true,
					"data":arrayJSON.aaData,
					"bPaginate":true,
					"bFilter" : true,   
					"bProcessing": true,
					"pageLength": 40,
					"columns": [
					{ title: '<input id="checkMarcarTodas" class="chequeos" onclick="marcarTodas();" type="checkbox" ><label title="Marcar Todas" for="checkMarcarTodas"></label>', mData: 'marcar', orderable: false},
					{ title: 'N°', mData: 'id'},
					{ title: 'Periodo', mData: 'periodo'},
					{ title: 'Análista', mData: 'analista'},
					{ title: 'Estado', mData: 'estado'},
					{ title: 'Subtotal', mData: 'subtotal'},
					{ title: 'Adicional', mData: 'adicional'},
					{ title: 'Descuento', mData: 'descuento'},
					{ title: 'Total', mData: 'total_cuenta'}],
					"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
				});

				loadingSiglo('hide');
				return false;
			}
		});
	}else{
		Swal.fire({
            type: 'warning',
            title: '¡Debe Seleccionar Por lo Menos el PERIODO!',
            text: ''
        });
	}

	return false;

});


var nodeFilas = [];
function cerrarMarcadas() {
	nodeFilas.pop();
	var rows = $('#tablaCasosAnalista').dataTable().fnGetNodes();
	var fila = "";

	$(rows).each(function (value, index) {
		if($(this).find('td input.checkCasos').prop('checked')){
			var id = $(this).find('td input.checkCasos').val();
			nodeFilas.push($(this));
			fila += "<tr>"+
				"<td>"+$(this).find("td").eq(3).text()+"</td>"+
				"<td>"+$(this).find("td").eq(2).text()+"</td>"+
				"<td>"+$(this).find("td").eq(5).text()+"</td>"+
				"<td><input name='valores[]' value='"+id+"' type='hidden'></td>"+
			"</tr>";
		}
	});

	if(fila != ""){
		$("#tablaCuentasCerrarCuentaAna tbody").html(fila);				
		$("#modalCerrarCuentaAna").modal('show');
	}else{
		Swal.fire({
            type: 'warning',
            title: '¡No Hay Filas Marcadas!',
            text: ''
        });
	}
}

$("#frmCerrarCuentasAnalista").submit(function(){
	var frmCerrarCuentasAnalista = new FormData($("#frmCerrarCuentasAnalista")[0]);
	frmCerrarCuentasAnalista.append("exe", "cerrarCuentasAnalista");
	frmCerrarCuentasAnalista.append("xd", $("#btnLogout").attr("name"));
	
	loadingSiglo('show', 'Cerrando Cuentas...');
	$.ajax({
		type: 'POST',
		url: 'class/consultasManejoAnalista.php',
		data: frmCerrarCuentasAnalista,
		cache: false,
		contentType: false,
		processData: false,
		success: function(data) {
			
			if(data == 1){
				$("#tablaCuentasCerrarCuentaAna tbody").html("");				
				$("#modalCerrarCuentaAna").modal('hide');
				$("#btnCuentasAnalista").click();
				
				loadingSiglo('hide');
		    	
		    	Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: '¡Cuentas Cerradas Satisfactoriamente!',
					showConfirmButton: false,
					timer: 1500
				});
			}else{
				loadingSiglo('hide');
				Swal.fire({
                    type: 'error',
                    title: 'Upps!',
                    text: '¡Algo ha Salido Mal!'
                });
			}
			return false;
		}
	}, 'json');

	return false;
});

var nodeFilas2 = [];
function habilitarCuentas() {
	nodeFilas2.pop();
	var rows2 = $('#tablaCasosAnalista').dataTable().fnGetNodes();
	var fila2 = "";

	$(rows2).each(function () {
		if($(this).find('td input.checkCasos').prop('checked')){
			var id2 = $(this).find('td input.checkCasos').val();
			nodeFilas2.push($(this));
			fila2 += "<tr>"+
				"<td>"+$(this).find("td").eq(3).text()+"</td>"+
				"<td>"+$(this).find("td").eq(2).text()+"</td>"+
				"<td>"+$(this).find("td").eq(5).text()+"</td>"+
				"<td><input name='valores[]' value='"+id2+"' type='hidden'></td>"+
			"</tr>";
		}
	});

	if(fila2 != ""){
		$("#tablaCuentasAbrirCuentaAna tbody").html(fila2);				
		$("#modalHabilitarCuentas").modal('show');
	}else{
		Swal.fire({
            type: 'warning',
            title: 'No Hay Filas Marcadas!',
            text: ''
        });
	}
}

$("#frmAbrirCuentasAnalista").submit(function(){
	var frmAbrirCuentasAnalista = new FormData($("#frmAbrirCuentasAnalista")[0]);
	frmAbrirCuentasAnalista.append("exe", "abrirCuentasAnalista");
	frmAbrirCuentasAnalista.append("xd", $("#btnLogout").attr("name"));

	loadingSiglo('show', 'Cerrando Cuentas...');
	$.ajax({
		type: 'POST',
		url: 'class/consultasManejoAnalista.php',
		data: frmAbrirCuentasAnalista,
		cache: false,
		contentType: false,
		processData: false,
		success: function(data) {
			
			if(data == 1){
				loadingSiglo('hide');
		    	
		    	Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: 'Habilitadas Satisfactoriamente!',
					showConfirmButton: false,
					timer: 1500
				});
				$("#modalHabilitarCuentas").modal('hide');
				$("#btnCuentasAnalista").click()
			}else{
				loadingSiglo('hide');
				Swal.fire({
                    type: 'error',
                    title: 'Upps!',
                    text: 'Ya han sido Habilitadas!'
                });
			}
			return false;
		}
	});
	return false;
});

$("#frmCrearCuentasAnalista").submit(function(){
	var frmCrearCuentasAnalista = new FormData($("#frmCrearCuentasAnalista")[0]);
	frmCrearCuentasAnalista.append("exe", "crearCuentasAnalista");

	loadingSiglo('show', 'Creando Cuenta...');
	$.ajax({
		type: 'POST',
		url: 'class/consultasManejoAnalista.php',
		data: frmCrearCuentasAnalista,
		cache: false,
		contentType: false,
		processData: false,
		success: function(data) {
			
			if(data){
				loadingSiglo('hide');
		    	Swal.fire({
					position: 'top-end',
					type: 'success',
					title: 'Creada Satisfactoriamente!',
					showConfirmButton: false,
					timer: 1500
				});
			}else{
				loadingSiglo('hide');
				Swal.fire({
                    type: 'error',
                    title: 'Upps!',
                    text: 'Ya ha sido creada!'
                });
			}
			return false;
		}
	});
	return false;
})