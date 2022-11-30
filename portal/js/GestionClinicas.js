
	$('#BtnBuscarClinica').click(function(e)
		{

			llenarTablaClinicas();
			$('#DivTablaGestionClinica').show();


		});


	$('#btnGuardarAsignacionInvestigadorIps').click(function(e)
		{

			var form = "idRegistroClinica="+$('#idRegistroAsignacionInvestigadorIps').val()+"&exe=asignarInvestigadorClinica&idInvestigador="+$('#InvestigadorFrmInvIps option:selected').val()+"&usuario="+$('#btnLogout').attr('name');

			$.ajax({

					type: 'POST',
					url: 'class/consultasManejoClinicas.php',
					data: form,
					
					success: function(data) {
						
						if (data==1) {
							
								$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente");							
								$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
								llenarTablaAsignacionInvestigadoresClinicas();
								$('#ErroresNonActualizable').modal('show');

								
									

							}
							else if(data==2){

								$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});				
								$("#ContenidoErrorNonActualizable").html("Este Investigador Ya Se encuentra Asignado a esta IPS");
								$('#ErroresNonActualizable').modal('show');
							}
							



					}

			});


		});



	$('#BtnAddClinica').click(function(e){

		$('#exeClinicas').val('registrarClinicas');

		$('#modalCrearClinica').modal('show');

		});




	function llenarTablaClinicas(){



			$('#tablaGestionClinicas').DataTable( {
								"select": true,
								"destroy": true,
								"ajax": {
									"url":"class/consultasTablas.php",
									"type":"POST",
									"data":
									function ( d ) {
									
									d.exeTabla = "consultarClinicas";
									d.nombreBuscarClinica = $('#nombreBuscarClinica').val();
									d.identificacionBuscarClinica = $('#identificacionBuscarClinica').val();
									
									}
									
								},
								"bPaginate":true,
								"bProcessing": true,
								"pageLength": 6,
								"columns": [
								{ mData: 'nombreClinica', "orderable": "true" } ,
								{ mData: 'identificacionClinica', "orderable": "true" } ,
								{ mData: 'ciudadClinica', "orderable": "true" } ,
								
								{ mData: 'opciones', "orderable": "false" }
								],
								"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
								});
			

	}



	function llenarTablaAsignacionInvestigadoresClinicas(){



			$('#tablaAsignacionInvestigadorIps').DataTable( {
								"select": true,
								"destroy": true,
								"ajax": {
									"url":"class/consultasTablas.php",
									"type":"POST",
									"data":
									function ( d ) {
									
									d.exeTabla = "consultarAsignacionInvestigadoresClinicas";
									d.idClinica = $('#idRegistroAsignacionInvestigadorIps').val();
									
									
									}
									
								},
								"bPaginate":true,
								"bProcessing": true,
								"pageLength": 6,
								"columns": [
								{ mData: 'nombreInvestigadorIPS', "orderable": "true" } ,
								{ mData: 'identificacionInvestigadorIPS', "orderable": "true" } ,
								{ mData: 'telefonoInvestigadorIPS', "orderable": "true" } ,
								
								{ mData: 'opciones', "orderable": "false" }
								],
								"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
								});
			

	}



	$('#btnGuardarClinica').click(function(e){

		var val1=1; var val2=1; var val3=1; var val4=1;
		var val5=1;var val6=1; var mensaje="";

		if ($('#nombreFrmClinica').val()==""){
			val1=2;
			mensaje+="Debe ingresar Nombre de la Clínica<br>";
		}else{
			val1=1;
		}

		if ($('#nitFrmClinica').val()==""){
			val2=2;
			mensaje+="Debe ingresar Nit de la Clínica<br>";
		}else{
			val2=1;
		}

		if ($('#DigFrmVerificacion2').val()==""){
			val3=2;
			mensaje+="Debe ingresar Digito de verificación del Nit de la Clínica<br>";
		}else{
			val3=1;
		}


		if ($('#telefonoFrmIps').val()==""){
			val5=2;
			mensaje+="Debe ingresar el Teléfono de la Clínica<br>";
		}else{
			val5=1;
		}

		if ($('#direccionFrmIps').val()==""){
			val6=2;
			mensaje+="Debe ingresar la Dirección de la Clínica<br>";
		}else{
			val6=1;
		}

		if (val1==2 || val2==2 || val3==2 || val5==2 || val6==2)
		{
			$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
			$("#ContenidoErrorNonActualizable").html(mensaje);
			$('#ErroresNonActualizable').modal('show');

		}
		else
		{

			var form = "idRegistroClinica="+$('#idRegistroClinica').val()+"&exe="+$('#exeClinicas').val()+"&nombreClinica="+$('#nombreFrmClinica').val()+"&nitClinica="+$('#nitFrmClinica').val()+"&digVerNitClinica="+$('#DigFrmVerificacion2').val()+"&CiudadClinica="+$('#ciudadFrmIps option:selected').val()+"&telClinica="+$('#telefonoFrmIps').val()+"&dirClinica="+$('#direccionFrmIps').val()+"&usuario="+$('#btnLogout').attr('name');
			$.ajax({

					type: 'POST',
					url: 'class/consultasManejoClinicas.php',
					data: form,
					
					success: function(data) {
						if (data==1) {

								$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente");							
								limpiaForm("#frmClinicas");
								$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
								$('#modalCrearClinica').modal('hide');
								$('#ErroresNonActualizable').modal('show');
								llenarTablaClinicas();
									

							}
							else if(data==2){

								$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});				
								$("#ContenidoErrorNonActualizable").html("El Número del NIT ya se encuentra registrado");
								$('#ErroresNonActualizable').modal('show');
							}
							



					}

			});
		}


	});



	$("#DivTablas2").on('click','a',function(){
		var opcion=$(this).attr('name');
		var action=$(this).attr('id');


		if (action=="btnEliminarRegistroClinica")
		{
			
		ModalRegistrosOut("Eliminar",opcion,"tablaGestionClinicas","eliminarClinicas");
		

		}
		else if (action=="btnPermitirClinica")
		{
			
		ModalRegistrosOut("Permitir",opcion,"tablaGestionClinicas","permitirClinicas");
		}

				
		else if (action=="btnEditarClinica")
		{
		var form =  "exe=consultarClinicas&registroClinica="+opcion;
				$.ajax({
						type: 'POST',
						url: 'class/consultasManejoClinicas.php',
						data: form,

				
						success: function(data) {
							
							var json_obj = $.parseJSON(data);
					if (jQuery.isEmptyObject(json_obj)) 
					{

						$("#ContenidoErrorNonActualizable").html("error al consultar");
						$('#ErroresNonActualizable').modal('show');
					} 
					else 
					{
							limpiaForm("#frmClinicas");


						$('#idRegistroClinica').val(opcion);
						
						$('#exeClinicas').val('editarClinicas');


						
						$("#nombreFrmClinica").val(json_obj.nombre_ips);
						$("#nitFrmClinica").val(json_obj.identificacion);
						$("#DigFrmVerificacion2").val(json_obj.dig_ver);
						$("#direccionFrmIps").val(json_obj.direccion);
						$("#telefonoFrmIps").val(json_obj.telefono);
						$("#ciudadFrmIps").val(json_obj.ciudad).change();
						
						
						$('#modalCrearClinica').modal('show');

						
						
					}
								
							

							return false;
						}


					});
				
		
		

		}
		else if (action=="btnAsignarInvestigadoresClinica")
		{
			
			$('#idRegistroAsignacionInvestigadorIps').val(opcion);
			llenarTablaAsignacionInvestigadoresClinicas();
			$('#modalAsignacionInvestigadorIps').modal('show');
			

		}
	
		
		
		
	});



$("#DivTablas10").on('click','a',function(){
		var opcion=$(this).attr('name');
		var action=$(this).attr('id');


		if (action=="btnEliminarInvestigadorIPS")
		{
			
		ModalRegistrosOut("Eliminar",opcion,"tablaAsignacionInvestigadorIps","eliminarAsignacionInvestigadorIps");
		

		}
		
		
		
	});