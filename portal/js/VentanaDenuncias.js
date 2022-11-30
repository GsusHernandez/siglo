$( document ).ready(function() {
	$("#aseguradoraDenuncias").select2();
	$("#tipoCasoDenuncias").select2();
	$("#aseguradoraRepDenuncias").select2();
	$("#dptoDenuncias").select2();
	$("#ipsDenuncias").select2();

	mostrarTipoCasosAseguradora($('#aseguradoraDenuncias option:selected').val(),"#tipoCasoDenuncias","Global");
});

$("#aseguradoraDenuncias").change(function() {
	mostrarTipoCasosAseguradora($('#aseguradoraDenuncias option:selected').val(),"#tipoCasoDenuncias","Global");
});

$("#aseguradoraDenuncias").change(function() {
	mostrarTipoCasosAseguradora($('#aseguradoraDenuncias option:selected').val(),"#tipoCasoDenuncias","Global");
});

$("#formBuscarDenuncias").submit(function(){
	var formBuscarDenuncias = new FormData($("#formBuscarDenuncias")[0]);
	formBuscarDenuncias.append("exeTabla","buscarDenuncias");
	loadingSiglo('show', 'Cargando Datos...');

	$.ajax({
		type: 'POST',
		url: 'class/consultasTablas.php',
		data: formBuscarDenuncias,
		cache: false,
		contentType: false,
		processData: false,
		success: function(data) {

			var arrayJSON=JSON.parse(data);
			$('#tablaCasosDenuncias').DataTable( {
				scrollX: true,
				dom: 'Bfrtip',
				buttons: [{
					extend: 'excelHtml5',
					exportOptions: {
						columns: ':visible'
					},
					title: 'Denuncias'
				},{
					extend: 'colvis'
				}],
				"select": true,
				"destroy":true,
				"data":arrayJSON.aaData,
				"bPaginate":true,
				"bFilter" : true,        
				"bProcessing": true,
				"pageLength": 5,
				"columns": [
				{ title: 'BTN', mData: 'opciones' },
				{ title: 'Codigo', mData: 'codigo' },
				{ title: 'F. Accidente', mData: 'fecha_accidente' },
				{ title: 'Placa', mData: 'placa' },
				{ title: 'Poliza', mData: 'poliza' },
				{ title: 'Departamento', mData: 'departamento_ips' },
				{ title: 'NIT IPS', mData: 'nit_ips' },
				{ title: 'IPS', mData: 'nombre_ips' },
				{ title: 'TP ID', mData: 'tipo_id_lesionado' },
				{ title: 'ID Lesionado', mData: 'identificacion' },
				{ title: 'Lesionado', mData: 'lesionado' },
				{ title: 'TP ID', mData: 'tipo_id_tomador' },
				{ title: 'ID Tomador', mData: 'identificacion_tomador' },
				{ title: 'Tomador', mData: 'nombre_tomador' },
				{ title: 'Dir. Tomador', mData: 'direccion_tomador' },
				{ title: 'Ciudad Tomador', mData: 'ciudad_tomador' },
				{ title: 'Tel. Tomador', mData: 'telefono_tomador' },
				{ title: 'Indicador Fraude', mData: 'indicador_fraude' },
				{ title: 'Tp Caso', mData: 'tipo_caso' }],
				"language": {"sProcessing": "Procesando...","sLengthMenu": "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
			});

			loadingSiglo('hide');
			return false;
		}
	});

	return false;
});

var nodeFilas = [];
function denunciarInvest(btn, id) {
	nodeFilas = [];
	var rowNode = $('#tablaCasosDenuncias').dataTable().fnGetNodes($(btn).parent().parent())
	nodeFilas.push(rowNode);

	$("#codigoDenuncia").text($(rowNode).find("td").eq(1).text());
	$("#lesionadoDenuncia").text($(rowNode).find("td").eq(10).text());
	$("#indicadorDenuncia").text($(rowNode).find("td").eq(17).text());
	$("#idInvestigacionDenuncia").val(id);
	$("#modalDenunciar").modal('show');
}

function noDenunciarInvest(btn, id){
	var rowNode = $('#tablaCasosDenuncias').dataTable().fnGetNodes($(btn).parent().parent());
	Swal.fire({
		title: '¿Estas seguro?',
		text: "¡No denunciar esta investigación!",
		type: 'warning',
		showCancelButton: true,
		cancelButtonText: "Cancelar",
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Sí, no denunciar'
	}).then((result) => {
		if (result.value) {
			$.ajax({
				type: "POST",
				url: "class/consultasManejoCasoSOAT.php",
				data: {exe: 'noDenunciarInvest', id: id},
				cache: false,
				success: function(datos){
					if(datos == 1){
						var tabla = $('#tablaCasosDenuncias').dataTable();
						$(rowNode).toggle(1500, function() {
							tabla.fnDeleteRow(rowNode);
						});

						Swal.fire({
							position: 'top-end',
							type: 'success',
							title: '¡La Denuncia Ha Sido Omitida!',
							showConfirmButton: false,
							timer: 2000
						});
					}else if(datos == 3){
						Swal.fire({
							position: 'top-end',
							type: 'error',
							title: '¡Error, Investigación NO encontrada!',
							showConfirmButton: true,
							text: 'Refresque la tabla y vuelva a intentarlo.'
						});
					}else{
						Swal.fire({
							position: 'top-end',
							type: 'error',
							title: '¡Error Al Denunciar!',
							showConfirmButton: true,
							text: 'Vuelva a intentarlo o contacte a Sistemas.'
						});
					}
				}
			});
		}
	});
}

$("#frmDenunciar").submit(function(){
	var formConsultasCasoSOAT = new FormData($("#frmDenunciar")[0]);
	formConsultasCasoSOAT.append("exe", "denunciarInvestigacion");
	formConsultasCasoSOAT.append("xd", $("#btnLogout").attr("name"));
	formConsultasCasoSOAT.append("id_investigacion", $("#idInvestigacionDenuncia").val());

	if($("#fechaDenuncia").val() == ""){
		Swal.fire({
            type: 'error',
            title: 'Upps!',
            text: '¡Ingrese Fecha de la Denuncia!'
        });
		return false;
	}
	
	loadingSiglo('show', 'Denunciando Investigación...');
	$.ajax({
		type: 'POST',
		url: 'class/consultasManejoCasoSOAT.php',
		data: formConsultasCasoSOAT,
		cache: false,
		contentType: false,
		processData: false,
		success: function(data) {

			var arrayJSON=JSON.parse(data);
			
			switch (arrayJSON) {
			    case 1:

					$("#codigoDenuncia").text("");
					$("#lesionadoDenuncia").text("");
					$("#indicadorDenuncia").text("");
					$("#fechaDenuncia").val("");
					$("#idInvestigacionDenuncia").val("");
					$("#modalDenunciar").modal('hide');

					loadingSiglo('hide');
			    	
			    	Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: '¡Denuncia Registrada Satisfactoriamente!',
						showConfirmButton: false,
						timer: 2000
					});

					var tabla = $('#tablaCasosDenuncias').dataTable();
					$(nodeFilas).each(function (value, index) {
						tabla.fnDeleteRow($(this));		
					});

					return false;
			    break;

			    case 2:
			    	loadingSiglo('hide');
					Swal.fire({
		                type: 'error',
		                title: 'Upps!',
		                text: 'Error Al Denunciar Investigación'
		            });

					return false;
			    break;

			    case 3:
			    	loadingSiglo('hide');
					Swal.fire({
		                type: 'error',
		                title: 'Upps!',
		                text: 'La Investigación Ya esta Denunciada'
		            });

					return false;
			    break;
			}
		},
		error: function(){
			loadingSiglo('hide');
			Swal.fire({
                type: 'error',
                title: 'Upps!',
                text: '¡Algo ha Salido Mal!'
            });

            return false;
		}
	});

	return false;
});

$("#formConsultaDenuncias").submit(function(){
	var formConsultaDenuncias = new FormData($("#formConsultaDenuncias")[0]);
	formConsultaDenuncias.append("exeTabla","consultaDenuncias");
	loadingSiglo('show', 'Cargando Datos...');

	$.ajax({
		type: 'POST',
		url: 'class/consultasTablas.php',
		data: formConsultaDenuncias,
		cache: false,
		contentType: false,
		processData: false,
		success: function(data) {

			if ($.fn.DataTable.isDataTable('#tablaDenunciasRealizadas')) {
				$('#tablaDenunciasRealizadas').DataTable().destroy();
				$('#tablaDenunciasRealizadas').html('<thead style="background-color: #217793; color: white;"></thead><tbody></tbody>')
			}

			switch($('#agruparDenuncias').val()){
				case '1':
					var arrayCol = [
						{ title: 'BTN', mData: 'opciones' },
						{ title: 'Codigo', mData: 'codigo' },
						{ title: 'F. Accidente', mData: 'fecha_accidente' },
						{ title: 'Placa', mData: 'placa' },
						{ title: 'Poliza', mData: 'poliza' },
						{ title: 'Departamento', mData: 'departamento_ips' },
						{ title: 'NIT IPS', mData: 'nit_ips' },
						{ title: 'IPS', mData: 'nombre_ips' },
						{ title: 'TP ID', mData: 'tipo_id_lesionado' },
						{ title: 'ID Lesionado', mData: 'identificacion' },
						{ title: 'Lesionado', mData: 'lesionado' },
						{ title: 'TP ID', mData: 'tipo_id_tomador' },
						{ title: 'ID Tomador', mData: 'identificacion_tomador' },
						{ title: 'Tomador', mData: 'nombre_tomador' },
						{ title: 'Dir. Tomador', mData: 'direccion_tomador' },
						{ title: 'Ciudad Tomador', mData: 'ciudad_tomador' },
						{ title: 'Tel. Tomador', mData: 'telefono_tomador' },
						{ title: 'Indicador Fraude', mData: 'indicador_fraude' },
						{ title: 'Tp Caso', mData: 'tipo_caso' }];
					break;

				case '2':
					var arrayCol = [
						{ title: 'Indicador Fraude', mData: 'indicador_fraude' },
						{ title: 'Cantidad', mData: 'cant' }];
					break;

				case '3':
					var arrayCol = [
						{ title: 'Departamento', mData: 'departamento_ips' },
						{ title: 'NIT IPS', mData: 'nit_ips' },
						{ title: 'IPS', mData: 'nombre_ips' },
						{ title: 'Indicador Fraude', mData: 'indicador_fraude' },
						{ title: 'Cantidad', mData: 'cant' }];
					break;

				case '4':
					var arrayCol = [
						{ title: 'Departamento', mData: 'departamento_ips' },
						{ title: 'Indicador Fraude', mData: 'indicador_fraude' },
						{ title: 'Cantidad', mData: 'cant' }];
					break;

			}

			var arrayJSON=JSON.parse(data);
			$('#tablaDenunciasRealizadas').DataTable( {
				scrollX: true,
				dom: 'Bfrtip',
				buttons: [{
					extend: 'excelHtml5',
					exportOptions: {
						columns: ':visible'
					},
					title: 'Denuncias'
				},{
					extend: 'colvis'
				}],
				"select": true,
				"destroy":true,
				"data":arrayJSON.aaData,
				"bPaginate":true,
				"bFilter" : true,        
				"bProcessing": true,
				"pageLength": 50,
				"columns": arrayCol,
				"language": {"sProcessing": "Procesando...","sLengthMenu": "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
			});

			loadingSiglo('hide');
			return false;
		}
	});

	return false;
});