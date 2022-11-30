$( document ).ready(function() {
	$("#aseguradoraCuentaInv").select2();
	$("#tipoCasoCuentaInv").select();
	$("#investigadorCuentaInv").select2();

	$("#periodoVerCuentaInv").select2();
	$("#investigadorVerCuentaInv").select2();

	$(".nav-tabs-custom li").click(function(){ 
		$(this).find("span").css("display","inline");
		
		if($(this).attr("id") == "menu_1"){
			$("#menu_2").find("span").css("display","none");
		}else if($(this).attr("id") == "menu_2"){	
			$("#menu_1").find("span").css("display","none");
		}
	});
});

$("#formConsultaCuentaInvest").submit(function(){
	var formConsultaCuentaInvest = new FormData($("#formConsultaCuentaInvest")[0]);
	formConsultaCuentaInvest.append("exeTabla","consultaCasosCuentaCobroInv");
	loadingSiglo('show', 'Cargando Datos...');

	$.ajax({
		type: 'POST',
		url: 'class/consultasTablas.php',
		data: formConsultaCuentaInvest,
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
				{ title: 'Acción', mData: 'opciones', orderable: false},
				{ title: '<input id="checkMarcarTodas" onclick="marcarTodas();" type="checkbox" >', mData: 'marcar', orderable: false},
				{ title: 'Codigo', mData: 'codigo'},
				{ title: 'Investigador' , mData: 'investigador'},
				{ title: 'Placa', mData: 'placa'},
				{ title: 'Poliza', mData: 'poliza'},
				{ title: 'Lesionado', mData: 'lesionado'},
				{ title: 'Id Les', mData: 'identificacion'},
				{ title: 'Ciudad', mData: 'ciudad'},
				{ title: 'F. Ath', mData: 'fecha_accidente'},
				{ title: 'Resultado', mData: 'resultado'},
				{ title: 'Aseguradora', mData: 'aseguradora'},
				{ title: 'Tipo', mData: 'tipoCaso'}],
				"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
			});

			loadingSiglo('hide');
			return false;
		}
	});

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

$("#frmAsignarCasosCuentaInv").submit(function(){
	var formConsultaCuentaInvest = new FormData($("#frmAsignarCasosCuentaInv")[0]);
	formConsultaCuentaInvest.append("exe", "asignarCasosCuentaInv");
	formConsultaCuentaInvest.append("xd", $("#btnLogout").attr("name"));
	formConsultaCuentaInvest.append("periodoAsignarCuentaInv", $("#periodoAsignarCuentaInv").val()+"-00");

	if($("#periodoAsignarCuentaInv").val() == "" || $("#numeroAsignarCuentaInv").val() == "" || $("#investigadorAsignarCuentaInv").val() == ""){
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
		url: 'class/consultasManejoInvestigadores.php',
		data: formConsultaCuentaInvest,
		cache: false,
		contentType: false,
		processData: false,
		success: function(data) {
			
			switch (data) {
			    case 1:
					var tabla = $('#tablaCasosInvestigador').dataTable();
					$(nodeFilas).each(function (value, index) {
						tabla.fnDeleteRow($(this));		
					});

					nodeFilas.pop();
					$("#tablaCasosAsignarCuentaInv tbody").html("");				
					$("#modalAsignarACuentaInv").modal('hide');
					
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
						text: "No Existe Cuenta para este investigador en este periodo",
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Crear',
						confirmButtonCancel: 'Cancelar'
					}).then((result) => {

						if (result.value) {
							loadingSiglo('show', 'Creando a Cuenta...');
							var datosCrearCuenta = new FormData($("#frmAsignarCasosCuentaInv")[0]);
							datosCrearCuenta.append("exe","crearCuentaInv");
							datosCrearCuenta.append("periodoAsignarCuentaInv", $("#periodoAsignarCuentaInv").val()+"-00");
							datosCrearCuenta.append("xd", $("#btnLogout").attr("name"));
							
							$.ajax({
								type: 'POST',
								url: 'class/consultasManejoInvestigadores.php',
								data: datosCrearCuenta,
								cache: false,
								contentType: false,
								processData: false,
								success: function(dato) {

									if(dato == 1){

										var tabla = $('#tablaCasosInvestigador').dataTable();
										$(nodeFilas).each(function (value, index) {
											tabla.fnDeleteRow($(this));		
										});

										nodeFilas.pop();
										$("#tablaCasosAsignarCuentaInv tbody").html("");				
										$("#modalAsignarACuentaInv").modal('hide');	

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

$("#formVerCuentaInvest").submit(function(){

	if($("#numeroVerCuentaInv").val() != "" || ($("#investigadorVerCuentaInv").val() != '' && $("#periodoVerCuentaInv").val() != "")){
		$("#nomInvVerCuentaInv").attr("name", $("#investigadorVerCuentaInv").val());
		$("#perVerCuentaInv").attr("name", $("#periodoVerCuentaInv").val());

		verCuentaCobro($("#investigadorVerCuentaInv").val(), $("#periodoVerCuentaInv").val(), $("#numeroVerCuentaInv").val());
	}else{
		Swal.fire({
            type: 'error',
            title: 'Upps!',
            text: '¡Buscar Por: N° De cuenta Ó Investigador-Periodo!'
        });
	}

	return false;
});

function verCuentaCobro(investigadorVerCuentaInv, periodoVerCuentaInv, numeroVerCuentaInv){
	loadingSiglo('show', 'Cargando Datos...');
	
	var formConsultaCuentaInvest = new FormData();
		formConsultaCuentaInvest.append("exeTabla","verCasosCuentaCobroInv");
		formConsultaCuentaInvest.append("investigadorVerCuentaInv", investigadorVerCuentaInv);
		formConsultaCuentaInvest.append("periodoVerCuentaInv", periodoVerCuentaInv);
		formConsultaCuentaInvest.append("numeroVerCuentaInv", numeroVerCuentaInv);
	
	$.ajax({
		type: 'POST',
		url: 'class/consultasTablas.php',
		data: formConsultaCuentaInvest,
		cache: false,
		contentType: false,
		processData: false,
		success: function(data) {

			$("#formCerrarCuentaInvest").show();
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
			$("#totalVerCasosInv").text(totalFactura);
			$('#tablaVerCasosInv').DataTable({
				scrollX: true,
				buttons: false,
				"destroy": true,
				"data": arrayJSON.aaData,
				"bPaginate": true,
				"bFilter": true,
				"bProcessing": true,
				"pageLength": 10,
				"columns": [
				{ title: 'Acción', mData: 'opciones', orderable: false},{ title: 'Codigo', mData: 'codigo'},
				{ title: 'Lesionado', mData: 'lesionado'},
				{ title: 'Resultado', mData: 'resultado'},
				{ title: 'Aseguradora', mData: 'aseguradora'},
				{ title: 'Tipo', mData: 'tipoCasoCorto'},
				{ title: 'Valor', mData: 'valor'},
				{ title: 'Placa', mData: 'placa'},
				{ title: 'Poliza', mData: 'poliza'}],
				"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
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

function eliminarFilaCuentaInv(btn, id, idCuenta) {

	var rowNode = $('#tablaVerCasosInv').dataTable().fnGetNodes($(btn).parent().parent());

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

		loadingSiglo('show', 'Eliminando Caso...');
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoInvestigadores.php',
			data: "xd="+id+"&cuenta="+idCuenta+"&exe=eliminarCasoCuentaInv",
			success: function(data) {
				
				switch (data) {
				    case 1:

						var tabla = $('#tablaVerCasosInv').dataTable();
						tabla.fnDeleteRow($(rowNode));	

				    	calcularTotalesVerCuentaInv();
						
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

	});				
}

$("#cerrarCuentaInv").click(function() {

	var rows = $('#tablaVerCasosInv').dataTable().fnGetNodes();
	var error = false;

	let inputsValorCasos = [];
	let inputsTarifaCasos = [];
	let inputsIdCasos = [];

	$(rows).each(function (value, index) {
		if($(this).find('td input.valorCasos').val() < 15000){
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
	}else if($("#viaticosVerCasosInv").val() < 0){
		Swal.fire({
            type: 'error',
            title: 'Upps!',
            text: '¡Debe Completar Los Campos!'
        });
	}else if($("#adicionalVerCasosInv").val() < 0){
		Swal.fire({
            type: 'error',
            title: 'Upps!',
            text: '¡Debe Completar Los Campos!'
        });
	}else{

		var formConsultaCuentaInvest = new FormData();
		formConsultaCuentaInvest.append("exe","cerrarCuentaCobroInv");
		formConsultaCuentaInvest.append("numVerCuentaInv", $("#numVerCuentaInv").text());
		formConsultaCuentaInvest.append("subtotalVerCasosInv", $("#subtotalVerCasosInv").text());
		formConsultaCuentaInvest.append("viaticosVerCasosInv", $("#viaticosVerCasosInv").val());
		formConsultaCuentaInvest.append("adicionalVerCasosInv", $("#adicionalVerCasosInv").val());
		formConsultaCuentaInvest.append("observacionVerCasosInv", $("#observacionVerCasosInv").val());
		formConsultaCuentaInvest.append("totalVerCasosInv", $("#totalVerCasosInv").text());
		formConsultaCuentaInvest.append("id_usuario", $('#btnLogout').attr('name'));

		formConsultaCuentaInvest.append("valorCasos1", JSON.stringify(inputsValorCasos));
		formConsultaCuentaInvest.append("tarifaCasos1", JSON.stringify(inputsTarifaCasos));
		formConsultaCuentaInvest.append("idCasos1", JSON.stringify(inputsIdCasos));
		loadingSiglo('show', 'Cargando Datos...');

		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoInvestigadores.php',
			data: formConsultaCuentaInvest,
			cache: false,
			contentType: false,
			processData: false,
			success: function(data) {

				var arrayJSON=JSON.parse(data);

				if(data == 1){
					$(".valorCasos").prop("disabled","true");
					$("#viaticosVerCasosInv").prop("disabled","true");
					$("#adicionalVerCasosInv").prop("disabled","true");
					$("#observacionVerCasosInv").prop("disabled","true");
					$("#cerrarCuentaInv").css("display","none");
					$("#habilitarCuentaInv").css("display","block");
					$(".btns-eliminar").prop("disabled","true");

					$("#estVerCuentaInv").text('CERRADA');
					$("#estVerCuentaInv").removeClass("bg-green");
					$("#estVerCuentaInv").addClass("bg-red");

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

$("#habilitarCuentaInv").click(function() {
	
	loadingSiglo('show', 'Cargando Datos...');

	var formConsultaCuentaInvest = new FormData();
	formConsultaCuentaInvest.append("exe","habilitarCuentaCobroInv");
	formConsultaCuentaInvest.append("numVerCuentaInv", $("#numVerCuentaInv").text());
	loadingSiglo('show', 'Cargando Datos...');

	$.ajax({
		type: 'POST',
		url: 'class/consultasManejoInvestigadores.php',
		data: formConsultaCuentaInvest,
		cache: false,
		contentType: false,
		processData: false,
		success: function(data) {

			var arrayJSON=JSON.parse(data);

			if(data == 1){
				
				loadingSiglo('hide');
				
				verCuentaCobro($("#nomInvVerCuentaInv").attr("name"), $("#perVerCuentaInv").attr("name"));
				
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
		case 'cuentaCobroInvTab1':
			$("#investigadorCuentaInv").val('').trigger('change.select2');
			$("#aseguradoraCuentaInv").val('').trigger('change.select2');
			$("#tipoCasoCuentaInv").val('').trigger('change.select2');
			$("#fLimiteCuentaInv").val('');
			if ( $.fn.DataTable.isDataTable('#tablaCasosInvestigador') ) {
			  $('#tablaCasosInvestigador').DataTable().destroy();
			}
			$("#tablaCasosInvestigador").html('<thead style="background-color: #188aff; color: white;"></thead><tbody></tbody>');
		break;
		
		case 'cuentaCobroInvTab2':
			$("#investigadorVerCuentaInv").val('').trigger('change.select2');
			$("#periodoVerCuentaInv").val('').trigger('change.select2');
			cargarPeriodosCuenta();
			if ( $.fn.DataTable.isDataTable('#tablaVerCasosInv') ) {
			  $('#tablaVerCasosInv').DataTable().destroy();
			}
			$("#tablaVerCasosInv").html('<thead style="background-color: #188aff; color: white;"></thead><tbody></tbody>');
			$("#formCerrarCuentaInvest").hide();
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
		data: "exe=consultarPeriodosCuentasInv&parametro="+$("#nomInvVerCuentaInv").attr("name"),
		beforeSend: function() {
	        loadingSiglo('show', 'Cargando Datos...');
	    },
	    success: function(res) {
				
			if ($("#periodoVerCuentaInv").hasClass("select2-hidden-accessible")) {
				$("#periodoVerCuentaInv").select2("destroy");
			}
			var json_obj = $.parseJSON(res);
			var options = '<option value="">TODOS</option>';
			for (var i = 0; i < json_obj.length; i++) {
				if(json_obj[i].descripcion2 != ''){
					options += '<option value="'+json_obj[i].periodo+'/'+json_obj[i].numero+'">' + json_obj[i].numero + " - " + json_obj[i].nomMes + " " + json_obj[i].anio + '</option>';
				}				
			}
			$("#periodoVerCuentaInv").html(options);
			$("#periodoVerCuentaInv").select2();
	        loadingSiglo('hide');
			return false;
		}
	});				
}

function VerMiCuenta(id_investigador, periodo, numero){

	loadingSiglo('show', 'Cargando Datos...');

	$("#modalMirarCuentaCobro").modal('show');
	
	var formConsultaCuentaInvest = new FormData();
		formConsultaCuentaInvest.append("exeTabla","verCasosCuentaCobroInv");
		formConsultaCuentaInvest.append("investigadorVerCuentaInv", id_investigador);
		formConsultaCuentaInvest.append("periodoVerCuentaInv", periodo+'/'+numero);
	
	$.ajax({
		type: 'POST',
		url: 'class/consultasTablas.php',
		data: formConsultaCuentaInvest,
		cache: false,
		contentType: false,
		processData: false,
		success: function(data) {

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
			$("#viaticosVerCasosInv").text(viaticos);
			$("#adicionalVerCasosInv").text(adicional);
			$("#observacionVerCasosInv").text(arrayJSON.observacion);
			$("#totalVerCasosInv").text(totalFactura);
			$('#tablaVerCasosInv').DataTable({
				scrollX: true,
				buttons: false,
				"destroy": true,
				"data": arrayJSON.aaData,
				"bPaginate": true,
				"bFilter": true,
				"bProcessing": true,
				"pageLength": 10,
				"columns": [
				{ title: 'Codigo', mData: 'codigo'},
				{ title: 'Lesionado', mData: 'lesionado'},
				{ title: 'Resultado', mData: 'resultado'},
				{ title: 'Aseguradora', mData: 'aseguradora'},
				{ title: 'Tipo', mData: 'tipoCasoCorto'},
				{ title: 'Valor', mData: 'valor1'},
				{ title: 'Placa', mData: 'placa'},
				{ title: 'Poliza', mData: 'poliza'}],
				"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
			});
			
			loadingSiglo('hide');
			return false;
		}
	});
}