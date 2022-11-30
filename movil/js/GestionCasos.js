
	$(document).ready(function() {

	 function llenarTablaGestionCasosSOAT()
	{

			$('#tablaGestionCasosSOATmovil').DataTable({
				"destroy": true,
								"select": true,
								
								"ajax": {
									"url":"../class/consultasTablas.php",
									"type":"POST",
									"data":
									function ( d ) {
									
									d.exeTabla = "consultarCasosSOAT";
									d.codigoFrmBuscarSOAT = $('#codigo').val();
									d.nombresFrmBuscarSOAT = $('#nombres').val();
									d.apellidosFrmBuscarSOAT = $('#apellidos').val();
									d.identificacionFrmBuscarSOAT = $('#id').val();
									d.placaFrmBuscarSOAT = $('#placa').val();
									d.polizaFrmBuscarSOAT = $('#poliza').val();
									d.identificadorFrmBuscarSOAT = $('#indicativo').val();
									d.fechaAccideneteBuscar=$("#fechaAccidente").val();
									d.tipoConsultaBuscar=$("#tipoConsultaBuscar").val();
									d.usuario = $('#user').val();//.attr('name');
									
									}
									
								},
								"bPaginate":true,
								"bProcessing": true,
								"pageLength": 6,
								"columns": [
								{ mData: 'GeneralCasosSoat', "orderable": "true" } ,
								{ mData: 'VictimaCasosSoat', "orderable": "true" } ,
								{ mData: 'SiniestroCasosSoat', "orderable": "true" } ,
								{ mData: 'opciones', "orderable": "false" }
								],
								"language": 
								{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"} }
			});

	}
				
	

	$('#btnBuscarCaso').click(function(e)
	{
		

		var val1=1; var val2=1; var val3=1; var val4=1; var val5=1; var val6=1; var val7=1; 
			
			

			if ($('#nombres').val()==""){
				val1=2;
			}else{
				val1=1;
			}

			if ($('#apellidos').val()==""){
				val2=2;
			}else{
				val2=1;
			}
			

			if ($('#id').val()==""){
				val3=2;
			}else{
				val3=1;
			}


			if ($('#poliza').val()==""){
				val4=2;
			}else{
				val4=1;
			}

			if ($('#placa').val()==""){
				val5=2;
			}else{
				val5=1;
			}

			if ($('#indicativo').val()==""){
				val6=2;
			}else{
				val6=1;
			}	

			if ($('#fechaAccidente').val()==""){
				val7=2;
			}else{
				val7=1;
			}
			

	

		if (val1==2 && val2==2 && val3==2 && val4==2 && val5==2 && val6==2 && val7==2)
		{
			

			$('#msn').html("<h5>DATOS FALTANTES</h5>");
						
			$( "#win" ).popup( "open");



		}
		else
		{
			

		  window.location.href = "panel/inicio.php";
		  llenarTablaGestionCasosSOAT();
		 
		}
			
	});

});