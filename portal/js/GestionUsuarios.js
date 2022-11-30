$("#tipoUserUsuarioFrm").change(function() {

	if ($('#tipoUserUsuarioFrm option:selected').val()==4){
		$('#divAseguradoraUsuario').show();
		$('#divInvestigadorUsuario').hide();
		$('#investigadorUsuarioFrm').val('0').change();
	}else if($('#tipoUserUsuarioFrm option:selected').val()==5){
		$('#divInvestigadorUsuario').show();
		$('#divAseguradoraUsuario').hide();
		$('#aseguradoraUsuarioFrm').val('0').change();
	}else{
		$('#divAseguradoraUsuario').hide();
		$('#divInvestigadorUsuario').hide();
		$('#aseguradoraUsuarioFrm').val('0').change();
		$('#investigadorUsuarioFrm').val('0').change();
	}
});

$('#BtnBuscarUsuarios').click(function(e){
	llenarTablaUsuarios();
	$('#DivTablaGestionUsuario').show();
});

$('#btnSubmitFrmUsuarios').click(function(e){
	loadingSiglo('show', 'Guardando Usuario...');
	var val1=1; var val2=1; var val3=1; var val4=1;
	var val5=1;var val6=1;var val7=1;var mensaje="";

	if ($('#nombresUsuarioFrm').val()==""){
		val1=2;
		mensaje+="Debe Ingresar Nombres<br>";
	}else{
		val1=1;
	}

	if ($('#userUsuarioFrm').val()==""){
		val2=2;
		mensaje+="Debe Ingresar Usuario<br>";
	}else{
		val2=1;
	}

	if ($('#correoUsuarioFrm').val()==""){
		val3=2;
		mensaje+="Debe Ingresar Correo<br>";
	}else{
		val3=1;
	}

	if ($('#exeFrmUsuarios').val()=="registrarUsuario") {
		if ($('#contrasenaUsuarioFrm').val()==""){
			val4=2;
			mensaje+="Debe Ingresar Contraseña<br>";
		}else{
			val4=1;
		}

		if ($('#contrasena2UsuarioFrm').val()==""){
			val5=2;
			mensaje+="Debe Confirmar Contraseña<br>";
		}else{
			val5=1;
		}

		if ($('#contrasenaUsuarioFrm').val()!=$('#contrasena2UsuarioFrm').val()){
			val6=2;
			mensaje+="Contraseña son ditintas<br>";
		}else{
			val6=1;
		}
	}

	if($('#tipoUserUsuarioFrm option:selected').val()=="5"){
		if($('#investigadorUsuarioFrm option:selected').val()=="0"){
			val7=2;
			mensaje+="Debe seleccionar un investigador<br>";
		}else{
			val7=1;
		}		
	}else{
		val7=1;
	}

	if (val1==2 || val2==2 || val3==2 || val4==2 || val5==2 || val6==2 || val7==2) {
		$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
		$("#ContenidoErrorNonActualizable").html(mensaje);
		$('#ErroresNonActualizable').modal('show');
		loadingSiglo('hide');
	}else{

		var form = "exe="+$('#exeFrmUsuarios').val()+"&nombresUsuarioFrm="+$('#nombresUsuarioFrm').val()+"&apellidoUsuarioFrm="+$('#apellidoUsuarioFrm').val()+"&userUsuarioFrm="+$('#userUsuarioFrm').val()+"&correoUsuarioFrm="+$('#correoUsuarioFrm').val()+"&contrasenaUsuarioFrm="+$('#contrasenaUsuarioFrm').val()+"&registroUsuario="+$('#idRegistroUsuario').val()+"&usuario="+$('#btnLogout').attr('name')+"&tipoUserUsuarioFrm="+$('#tipoUserUsuarioFrm option:selected').val()+"&aseguradoraUsuarioFrm="+$('#aseguradoraUsuarioFrm option:selected').val()+"&investigadorUsuarioFrm="+$('#investigadorUsuarioFrm option:selected').val();

		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoUsuarios.php',
			data: form,
			success: function(data) {
				if (data==1) {
					llenarTablaUsuarios();
					$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente");							
					limpiaForm("#frmUsuarios");
					$("#tipoUserUsuarioFrm").val('0').trigger('change');
					$("#aseguradoraUsuarioFrm").val('0').trigger('change');
					$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
					$('#FrmUsuarios').modal('hide');
					$('#ErroresNonActualizable').modal('show');
				} else if(data==3){
					$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});				
					$("#ContenidoErrorNonActualizable").html("El Número del NIT ya se encuentra registrado");
					$('#ErroresNonActualizable').modal('show');
				}else{
					alert("error");
				}
				loadingSiglo('hide');
			},error:function(data){
				loadingSiglo('hide');
			}
		});
	}
});

$("#DivTablas3").on('click','a',function(){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');
	loadingSiglo('show', 'Cargando...');
	if (action=="btnEditarUsuario")	{
		var form =  "exe=consultarUsuario&registroUsuario="+opcion;
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoUsuarios.php',
			data: form,
			success: function(data) {
				var json_obj = $.parseJSON(data);

				if (jQuery.isEmptyObject(json_obj)) {

					$("#ContenidoErrorNonActualizable").html("error al consultar");
					$('#ErroresNonActualizable').modal('show');
				} else {
					$("#tipoUserUsuarioFrm").val('0').trigger('change');
					$("#aseguradoraUsuarioFrm").val('0').trigger('change');

					limpiaForm("#frmUsuarios");

					$('#idRegistroUsuario').val(opcion);
					$('#exeFrmUsuarios').val('modificarUsuario');
					$("#nombresUsuarioFrm").val(json_obj.nombres);
					$("#apellidoUsuarioFrm").val(json_obj.apellidos);
					$("#userUsuarioFrm").val(json_obj.usuario);
					$("#correoUsuarioFrm").val(json_obj.correo);
					$("#tipoUserUsuarioFrm").val(json_obj.tipo_usuario).change();
					$("#aseguradoraUsuarioFrm").val(json_obj.id_aseguradora).change();
					$("#investigadorUsuarioFrm").val(json_obj.id_investigador).change();
					$('#FrmUsuarios').modal('show');
				}
				loadingSiglo('hide');
				return false;
			},error: function(data){
				loadingSiglo('hide');
			}
		});
	}else if (action=="btnOpcionesUsuario"){
		$('#idRegistroUsuarioOpcion').val(opcion);
		$('#modalOpcionesUsuarios').modal('show');
		loadingSiglo('hide');
		llenarTablaOpcionesUsuarios(opcion);
	}else if (action=="btnEliminarRegistroUsuario")	{
		loadingSiglo('hide');
		ModalRegistrosOut("Eliminar",opcion,"tablaGestionUsuarios","eliminarUsuario");
	}else if (action=="btnPermitirUsuario"){
		loadingSiglo('hide');
		ModalRegistrosOut("Permitir",opcion,"tablaGestionUsuarios","vigenciaUsuario");	
	}
});

$('#BtnAddUsuarios').click(function(e){
	$('#exeFrmUsuarios').val('registrarUsuario');
	limpiaForm("#frmUsuarios");
	$('#FrmUsuarios').modal('show');
	loadingSiglo('hide');
});

$('#btnGuardarAsignacionOpcionesUsuarios').click(function(e) {
	loadingSiglo('show', 'Guardando Opciones Usuarios...');
	var codigoOpcion=[];


	  var table = $('#tablaGestionOpcionesUsuarios').DataTable();
		var codigoOpcion=[];
		table.rows().every(function (rowIdx, tableLoop, rowLoop) {
			  var data = this.node();
			  if($(data).find('input').prop('checked')){
				  var data2={};
				  if(codigoOpcion.includes($(data).find('input').val())){

				  }
						data2.codigoOpcion=$(data).find('input').val();
						codigoOpcion.push(data2);
			  }
		});
		

		
		//alert(JSON.stringify(codigoOpcion));
	var frmAsignarOpcionesUsuarios =  "exe=asignarOpcionesUsuarios&idUsuarioOpcion="+$("#idRegistroUsuarioOpcion").val()+"&idUsuario="+$('#btnLogout').attr('name')+"&opcionesAsignar="+JSON.stringify(codigoOpcion);

	$.ajax({
		type: 'POST',
		url: 'class/consultasManejoUsuarios.php',
		data: frmAsignarOpcionesUsuarios,
		success: function(data) {
			if (data==2){
				$("#ContenidoErrorNonActualizable").html("Error al ejecutar Procedimiento");
				$('#ErroresNonActualizable').modal('show');
			}else{
				$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente");
				$('#modalOpcionesUsuarios').modal('hide');
				$('#ErroresNonActualizable').modal('show');
			}
			loadingSiglo('hide');
			return false;
		},error: function(data){
			loadingSiglo('hide');
		}
	});
});	

function llenarTablaOpcionesUsuarios(idUsuario){
	loadingSiglo('show', 'Cargando Opciones Usuarios...');
	$('#tablaGestionOpcionesUsuarios').DataTable( {
		"destroy": true,
		"select": false,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "consultarOpcionesUsuarios";
				d.userOpcionesUsuarios = idUsuario;
			}
		},
		initComplete: function(settings, json) {
            loadingSiglo('hide');
        },
		"paging":         true,
								"searching": true,
								"bProcessing": true,
								"pageLength": 6,
									"columns": [
		{ mData: 'seleccOpcion', "orderable": "true" } ,
		{ mData: 'codOpcion', "orderable": "true" } ,
		{ mData: 'descOpcion', "orderable": "false" }
		],
		"language": 
		{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}

function llenarTablaUsuarios(){
	loadingSiglo('show', 'Cargando Usuarios...');
	$('#tablaGestionUsuarios').DataTable( {
		"destroy": true,
		"select": true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "consultarUsuarios";
				d.userUsuarioBuscar = $('#userUsuarioBuscar').val();
				d.nombreUsuarioBuscar = $('#nombreUsuarioBuscar').val();
			}
		},
		initComplete: function(settings, json) {
            loadingSiglo('hide');
        },
		"bPaginate":true,
		"bProcessing": true,
		"pageLength": 6,
		"columns": [
		{ mData: 'nombreUsuarios', "orderable": "true" } ,
		{ mData: 'userUsuarios', "orderable": "true" } ,
		{ mData: 'opciones', "orderable": "false" }
		],
		"language": 
		{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}