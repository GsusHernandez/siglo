$('#BtnBuscarInvestigadores').click(function(e){
	llenarTablaInvestigadores();
	$('#DivTablaGestionInvestigadores').show();
});

$('#btnSubmitFrmInvestigadores').click(function(e){

	var val1=1; var val2=1; var val3=1; var val4=1;
	var val5=1;var val6=1;var mensaje="";

	if ($('#nombresInvestigadoresFrm').val()==""){
		val1=2;
		mensaje+="Debe Ingresar Nombres<br>";
	}else{
		val1=1;
	}

	if ($('#apellidoInvestigadoresFrm').val()==""){
		val2=2;
		mensaje+="Debe Ingresar Apellidos<br>";
	}else{
		val2=1;
	}

	if ($('#identificacionInvestigadoresFrm').val()==""){
		val3=2;
		mensaje+="Debe Ingresar Identificacion<br>";
	}else{
		val3=1;
	}

	if ($('#telefonoInvestigadoresFrm').val()==""){
		val4=2;
		mensaje+="Debe Ingresar Telefono<br>";
	}else{
		val4=1;
	}

	if ($('#correoInvestigadoresFrm').val()==""){
		val5=2;
		mensaje+="Debe Ingresar Correo<br>";
	}else{
		val5=1;
	}

	if ($('#direccionInvestigadoresFrm').val()==""){
		val6=2;
		mensaje+="Debe Ingresar Direccion<br>";
	}else{
		val6=1;
	}

	if (val1==2 || val2==2 || val3==2 || val4==2 || val5==2 || val6==2){
		$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
		$("#ContenidoErrorNonActualizable").html(mensaje);
		$('#ErroresNonActualizable').modal('show');
	}
	else{
		/*var form = "exe="+$('#exeFrmInvestigadores').val()
		+"&nombresInvestigadoresFrm="+$('#nombresInvestigadoresFrm').val()
		+"&apellidoInvestigadoresFrm="+$('#apellidoInvestigadoresFrm').val()
		+"&tipoIdentificacionInvestigadoresFrm="+$('#tipoIdentificacionInvestigadoresFrm option:selected').val()
		+"&identificacionInvestigadoresFrm="+$('#identificacionInvestigadoresFrm').val()
		+"&telefonoInvestigadoresFrm="+$('#telefonoInvestigadoresFrm').val()
		+"&correoInvestigadoresFrm="+$('#correoInvestigadoresFrm').val()
		+"&direccionInvestigadoresFrm="+$('#direccionInvestigadoresFrm').val()
		+"&idRegistroInvestigador="+$('#idRegistroInvestigador').val()
		+"&usuario="+$('#btnLogout').attr('name');*/
		var form = new FormData();

		var imagen = "NO";
		form.append("exe", $('#exeFrmInvestigadores').val());
		form.append("nombresInvestigadoresFrm",$('#nombresInvestigadoresFrm').val());
		form.append("apellidoInvestigadoresFrm",$('#apellidoInvestigadoresFrm').val());
		form.append("tipoIdentificacionInvestigadoresFrm",$('#tipoIdentificacionInvestigadoresFrm option:selected').val());
		form.append("identificacionInvestigadoresFrm",$('#identificacionInvestigadoresFrm').val());
		form.append("lugarExpedicionInvestigadoresFrm",$('#lugarExpedicionInvestigadoresFrm').val());
		form.append("telefonoInvestigadoresFrm",$('#telefonoInvestigadoresFrm').val());
		form.append("correoInvestigadoresFrm",$('#correoInvestigadoresFrm').val());
		form.append("direccionInvestigadoresFrm",$('#direccionInvestigadoresFrm').val());
		form.append("estudiosInvestigadoresFrm",$('#estudiosInvestigadoresFrm').val());
		form.append("experienciaInvestigadoresFrm",$('#experienciaInvestigadoresFrm').val());
		if($("#imagenInvestigadoresFrm").prop("files")[0] != null ){
			imagen = "SI";
		}
		form.append("imagen", imagen);
		form.append("imagenInvestigadoresFrm",$("#imagenInvestigadoresFrm").prop("files")[0]);
		form.append("idRegistroInvestigador",$('#idRegistroInvestigador').val());
		form.append("usuario",$('#btnLogout').attr('name'));

		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoInvestigadores.php',
			data: form,
			cache: false,
			contentType: false,
			processData: false,
			success: function(data) {
				if (data==1) {
					llenarTablaInvestigadores();
					$('#DivTablaGestionInvestigadores').show();
					Swal.fire({
					  type: 'success',
					  title: 'Correcto',
					  text: 'Proceso ejecutado satisfactoriamente.'
					});							
					limpiaForm("#frmInvestigadores");
					$('#FrmInvestigadores').modal('hide');
				}else if(data==2){
					Swal.fire({
					  type: 'error',
					  title: 'Oops...',
					  text: 'Parece que ya se ha registrado este investigador.'
					});
				}else{
					Swal.fire({
					  type: 'error',
					  title: 'Oops...',
					  text: 'Ha ocurrido un error inesperado.'
					});
				}
			}
		});
	}
});

$("#DivTablas9").on('click','a',function(){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');

	if (action=="btnEditarInvestigador"){
		var form =  "exe=consultarInvestigador&registroInvestigador="+opcion;
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoInvestigadores.php',
			data: form,
			success: function(data) {
				var json_obj = $.parseJSON(data);
				if (jQuery.isEmptyObject(json_obj)) {
					$("#ContenidoErrorNonActualizable").html("error al consultar");
					$('#ErroresNonActualizable').modal('show');
				} 
				else {
					limpiaForm("#frmInvestigadores");
					$('#idRegistroInvestigador').val(opcion);
					$('#exeFrmInvestigadores').val('modificarInvestigador');
					$("#nombresInvestigadoresFrm").val(json_obj.nombres);
					$("#apellidoInvestigadoresFrm").val(json_obj.apellidos);
					$("#tipoIdentificacionInvestigadoresFrm").val(json_obj.tipo_identificacion);
					$("#identificacionInvestigadoresFrm").val(json_obj.identificacion);
					$("#lugarExpedicionInvestigadoresFrm").val(json_obj.lugar_expedicion);
					$("#telefonoInvestigadoresFrm").val(json_obj.telefono);
					$("#correoInvestigadoresFrm").val(json_obj.correo);
					$("#direccionInvestigadoresFrm").val(json_obj.direccion);
					$("#estudiosInvestigadoresFrm").val(json_obj.estudios);
					$("#experienciaInvestigadoresFrm").val(json_obj.experiencia);
					$('#FrmInvestigadores').modal('show');
				}
				return false;
			}
		});

	}else if (action=="btnEliminarRegistroInvestigador"){
		ModalRegistrosOut("Eliminar",opcion,"tablaGestionInvestigadores","eliminarInvestigador");
	}else if (action=="btnPermitirInvestigador"){
		ModalRegistrosOut("Permitir",opcion,"tablaGestionInvestigadores","vigenciaInvestigador");	
	}
});

$('#BtnAddInvestigadores').click(function(e){
	$('#exeFrmInvestigadores').val('registrarInvestigador');
	$('#FrmInvestigadores').modal('show');
});

function llenarTablaInvestigadores(){
	$('#tablaGestionInvestigadores').DataTable( {
		"destroy": true,
		"select": true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "consultarInvestigadores";
				d.nombreInvestigadorBuscar = $('#nombreInvestigadorBuscar').val();
				d.identificacionInvestigadorBuscar = $('#identificacionInvestigadorBuscar').val();
			}
		},
		"bPaginate":true,
		"bProcessing": true,
		"pageLength": 6,
		"columns": [
		{ mData: 'nombreInvestigador', "orderable": "true" } ,
		{ mData: 'identificacionInvestigador', "orderable": "true" } ,
		{ mData: 'correoInvestigador', "orderable": "true" } ,

		{ mData: 'opciones', "orderable": "false" }
		],
		"language": 
		{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}

function validarArchivo(archivo){
    //EXTENSIONES
    var extensiones_permitidas = [".png", ".jpg", ".jpeg"];
    var rutayarchivo = archivo.value;
    var ultimo_punto = archivo.value.lastIndexOf(".");
    var extension = rutayarchivo.slice(ultimo_punto, rutayarchivo.length);
    if(extensiones_permitidas.indexOf(extension) == -1){
        alertify.error("Extensión de archivo no valida");
        $(archivo).val("");
        return;
    }
}