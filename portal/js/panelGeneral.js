/*$(function() {
	if(tipo_usuario_session == 1){
		ConsultarOcurrenciasInicio();
	}
	if(tipo_usuario_session == 2 || tipo_usuario_session == 3 || tipo_usuario_session == 4){
		TopMayoresIncidencias();
	}
	if(tipo_usuario_session == 3 || tipo_usuario_session == 2){
		DatosMensuales();
	}
}); */

function ConsultarOcurrenciasInicio(){
	var tipo_usuario = $("#btnLogout").attr("tp");
	var id_usuario = $("#btnLogout").attr("name");

	if(tipo_usuario == 1){
		$.ajax({
			type: 'POST',
			url: 'class/consultasBasicas.php',
			data: "exe=ConsultarOcurrenciasInicio&tipo_usuario="+tipo_usuario+"&id_usuario="+id_usuario,
			success: function(data) {
				data = jQuery.parseJSON(data);
				if (data){
					if (data.length > 0){		
						if(tipo_usuario == 1){
							$("#misCasos").html(data[0].misCasos);
							$(".miC").html('<i class="ion ion-android-alert"></i>');

							$("#misCasosSinPDF").html(data[0].misCasosSinPDF);
							$(".miCSinPDF").html('<i class="ion ion-android-alert"></i>');
						}
					}
				}
			}
		});
	}
}

function MostrarCarguesHoy(){
	$("#ReportesCargues").html("");
	loadingSiglo('show', 'Cargando información de cargues...');
	$.ajax({
		type: 'POST',
		url: 'class/consultasBasicas.php',
		data: "exe=consultarReportesInvesticaciones",
		success: function(data) {
			loadingSiglo('hide');
			data = jQuery.parseJSON(data);
			if (data){
				if (data.length > 0){
					$("#modalMostrarCargues").modal('show');
					var html ="";
					for(var i in data){
						html += "<tr>";
						html += "<td class='text-center'>"+data[i].codigo+"</td>";
						html += "<td class='text-center'>"+data[i].conteo_cargue+"</td>";
						html += "<td class='text-center'>"+data[i].hora+"</td>";
						html += "</tr>";
						$("#tablaCargados").append(html);
						html ="";
					}
				}else{
					Swal.fire(
				      '¡Upss. Algo Está Mal!',
				      'Vuelva a intentarlo o Comuniquese con el Aministrador',
				      'error'
				    );
				}
			}else{
				Swal.fire(
			      '¡Sin Datos!',
			      'No se encontraron Datos',
			      'warning'
			    );
			}
		}
	});
}

function mostrarMisCasosPdte(){
	loadingSiglo('show', 'Cargando Casos Pendientes...');
	var id_usuario = $("#btnLogout").attr("name");
	var html ="";
	$("#tablaMisCasosPdte tbody").html(html);
	$.ajax({
		type: 'POST',
		url: 'class/consultasBasicas.php',
		data: "exe=consultarMisCasosPendientes&id_usuario="+id_usuario,
		success: function(data) {
			
			data = jQuery.parseJSON(data);	
			if (data){		
				if (data.length > 0){		
					var cont = 1;
					for(var i in data){
						var classColor1 = '';
						var classColor2 = '';
						var classColor3 = '';

						if(data[i].diff_cargue < 2){
							classColor1 = "rojoCargue";
						}

						if(data[i].diff_entrega < 2){
							classColor2 = "rojoEntrega";
						}

						if(data[i].tipo_caso == 1 || data[i].tipo_caso == 17){

							if(data[i].diff_accidente > 5 && data[i].diff_accidente <= 15){
								classColor3 = "amarilloAccidente";
							}

							if(data[i].diff_accidente > 16){
								classColor3 = "rojoAccidente";
							}
						}

						html += "<tr class='"+data[i].id+"'>";
						html += "<td class='text-center'>"+cont+"</td>";
						html += "<td class='text-center'>"+data[i].codigo+"</td>";
						html += "<td class='text-center'>"+data[i].aseguradora+"</td>";
						html += "<td class='text-center "+classColor3+"'>"+data[i].fecha_accidente+"</td>";
						html += "<td class='text-center'>"+data[i].fecha_inicio+"</td>";
						html += "<td class='text-center "+classColor2+"'>"+data[i].fecha_entrega+"</td>";
						html += "<td class='text-center "+classColor1+"'>"+data[i].fecha_cargue+"</td>";
						html += "</tr>";
						cont++;
					}

					$("#tablaMisCasosPdte tbody").html(html);
					$("#modalCasosPdte").modal('show');				
					loadingSiglo('hide');
				}else{
					loadingSiglo('hide');
					Swal.fire(
				      '¡Upss. Algo Está Mal!',
				      'Vuelva a intentarlo o Comuniquese con el Aministrador',
				      'error'
				    );
				}
			}else{
				loadingSiglo('hide');
				Swal.fire(
			      '¡Sin Datos!',
			      'No se encontraron datos',
			      'warning'
			    );
			}
		}
	});
}

function mostrarMisCasosSinPDF(){
	loadingSiglo('show', 'Cargando Casos Sin PDFs...');
	var id_usuario = $("#btnLogout").attr("name");
	var html ="";
	$("#tablaMisCasosSinPDF tbody").html(html);
	$.ajax({
		type: 'POST',
		url: 'class/consultasBasicas.php',
		data: "exe=consultarMisCasosSinPDF&id_usuario="+id_usuario,
		success: function(data) {
			
			data = jQuery.parseJSON(data);	
			if (data){		
				if (data.length > 0){		
					var cont = 1;
					for(var i in data){
						var classColor3 = '';

						if(data[i].tipo_caso == 1 || data[i].tipo_caso == 17){

							if(data[i].diff_accidente > 5 && data[i].diff_accidente <= 15){
								classColor3 = "amarilloAccidente";
							}

							if(data[i].diff_accidente > 16){
								classColor3 = "rojoAccidente";
							}
						}

						html += "<tr class='"+data[i].id+"'>";
						html += "<td class='text-center'>"+cont+"</td>";
						html += "<td class='text-center'>"+data[i].codigo+"</td>";
						html += "<td class='text-center'>"+data[i].identificador+"</td>";
						html += "<td class='text-center'>"+data[i].placa+"</td>";
						html += "<td class='text-center'>"+data[i].lesionado+"</td>";
						html += "<td class='text-center "+classColor3+"'>"+data[i].fecha_accidente+"</td>";
						html += "</tr>";
						cont++;
					}

					$("#tablaMisCasosSinPDF tbody").html(html);
					$("#modalCasosSinPDF").modal('show');				
					loadingSiglo('hide');
				}else{
					loadingSiglo('hide');
					Swal.fire(
				      '¡Upss. Algo Está Mal!',
				      'Vuelva a intentarlo o Comuniquese con el Aministrador',
				      'error'
				    );
				}
			}else{
				loadingSiglo('hide');
				Swal.fire(
			      '¡Sin Datos!',
			      'No se encontraron datos',
			      'warning'
			    );
			}
		}
	});
}

function TopMayoresIncidencias() {
	var tipo_usuario = $("#btnLogout").attr("tp");
	var htmlPlacas = '';
	var htmlMarcas = '';
	var htmlPersonas = '';

	if(tipo_usuario == 2 || tipo_usuario == 3 || tipo_usuario == 4){
		$.ajax({
			type: 'POST',
			url: 'class/consultasBasicas.php',
			data: "exe=consultarTopMayoresIncidencias&tipo_usuario="+tipo_usuario,
			success: function(data) {
				data = jQuery.parseJSON(data);
				data.forEach( function(row) {
					if(row.placas){
						row.placas.forEach ( function(a, i) {
							if (i == 0) {
								htmlPlacas += '<tr>';
								htmlPlacas += '<td>'+a.placa+'</td>';
								htmlPlacas += '<td><span class="label label-danger">'+a.casos+'</span></td>';
								htmlPlacas += '</tr>';
							}else{
								htmlPlacas += '<tr>';
								htmlPlacas += '<td>'+a.placa+'</td>';
								htmlPlacas += '<td><span class="label label-warning">'+a.casos+'</span></td>';
								htmlPlacas += '</tr>';
							}
						});
					}

					if (row.marcas) {
						row.marcas.forEach ( function (b, j) {
							if (j == 0) {
								htmlMarcas += '<tr>';
								htmlMarcas += '<td>'+b.marca+'</td>';
								htmlMarcas += '<td>'+b.modelo+'</td>';
								htmlMarcas += '<td><span class="label label-danger">'+b.casos+'</span></td>';
								htmlMarcas += '</tr>';
							}else{
								htmlMarcas += '<tr>';
								htmlMarcas += '<td>'+b.marca+'</td>';
								htmlMarcas += '<td>'+b.modelo+'</td>';
								htmlMarcas += '<td><span class="label label-warning">'+b.casos+'</span></td>';
								htmlMarcas += '</tr>';
							}
						});
					}

					if (row.personas) {
						row.personas.forEach ( function (c, k) {
							if (k == 0) {
								htmlPersonas += '<tr>';
								htmlPersonas += '<td>'+c.persona+'</td>';
								htmlPersonas += '<td class="text-center"><span class="label label-danger">'+c.casos+'</span></td>';
								htmlPersonas += '</tr>';
							}else{
								htmlPersonas += '<tr>';
								htmlPersonas += '<td>'+c.persona+'</td>';
								htmlPersonas += '<td class="text-center"><span class="label label-warning">'+c.casos+'</span></td>';
								htmlPersonas += '</tr>';
							}
						});
					}
				});

				$("#tablaPlacasIncidencias").html(htmlPlacas);
				$(".overlay-placas").css("display", "none");
				$("#tablaMarcasIncidencias").html(htmlMarcas);
				$(".overlay-marcas").css("display", "none");
				$("#tablaPersonasIncidencias").html(htmlPersonas);
				$(".overlay-personas").css("display", "none");
			}
		});
	}
}

function DatosMensuales(){
	//ocurrencias
	$.ajax({
		type: 'POST',
		url: 'class/consultasBasicas.php',
		data: "exe=ConsultarDatosMensuales",
		success: function(data) {
			data = jQuery.parseJSON(data);
			var colores = ["#f56954","#00a65a","#f39c12","#00c0ef","#3c8dbc","#d2d6de"];
		  	var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
		  	var pieChart = new Chart(pieChartCanvas);
			var PieData = [];
			for(var i in data){
				if(data[i].cantOcurrencias > 0){
					PieData.push(
						{
							"value": data[i].cantOcurrencias,
							"color": colores[i],
							"highlight": colores[i],
							"label": data[i].aseguradora
						}
					);
					$("#nombresAseguradoras").append('<li onclick="modalOcurrenciasAseguradoras('+data[i].id_aseguradora+','+data[i].cantOcurrencias+')" style="cursor:pointer;"><i class="fa fa-circle-o" style="color:'+colores[i]+'"></i> '+data[i].aseguradora+':<b>'+data[i].cantCasos+' / '+data[i].cantOcurrencias+'</b></li>');
				}
			}
			$(".overlay-ocurrencias").css("display", "none");
			var pieOptions     = {
			    segmentShowStroke    : true,
			    segmentStrokeColor   : '#fff',
			    segmentStrokeWidth   : 1,
			    percentageInnerCutout: 50,
			    animationSteps       : 100,
			    animationEasing      : 'easeOutBounce',
			    animateRotate        : true,
			    animateScale         : false,
			    responsive           : true,
			    maintainAspectRatio  : false,
			    legendTemplate       : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
		  	};
		  	pieChart.Doughnut(PieData, pieOptions);
		}
	});
}

function modalOcurrenciasAseguradoras(id_aseguradora, cantCasos){
	loadingSiglo('show', 'Consultado Datos...');
	$.post("class/consultasBasicas.php", {id_aseguradora:id_aseguradora, exe:"consultarOcurrenciasAseguradoras"}, function(datos){
		$("#tituloModalOcurrencias").html(datos[0].aseguradora+": "+cantCasos);
		var trs = "";
		for(var i in datos){
			if(datos[i].ocurrencias > 0){
				porcenjate = Math.round((datos[i].ocurrencias*100)/datos[i].total);
				trs += "<tr>";
				trs += "<td>"+datos[i].departamento+"</td>";
				trs += "<td class='text-center'>"+datos[i].ocurrencias+"</td>";
				trs += "<td class='text-center'>"+datos[i].total+"</td>";
				trs += "<td class='text-center'>"+porcenjate+"%</td>";
				trs += "</tr>";
			}
		}
		$("#tablaDepartamentoOcurrencias tbody").html(trs);
		$("#modalOcurrenciasAseguradoras").modal("show");
		loadingSiglo('hide');
	}, 'json');
}