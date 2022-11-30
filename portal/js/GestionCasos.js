function llenarTablaGestionCensosInvestigador(){
	loadingSiglo('show', 'Buscando Casos...');
	$('#tablaGestionCensosInvestigador').DataTable( {
		"destroy": true,
		"select": true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "consultarCensoInv";
				d.ciBuscarCodigo = $('#ciBuscarCodigo').val();
				d.ciBuscarNombre = $('#ciBuscarNombre').val();
				d.ciBuscarIdentificacion = $('#ciBuscarIdentificacion').val();
				d.ciBuscarPlaca = $('#ciBuscarPlaca').val();
				d.ciBuscarPoliza = $('#ciBuscarPoliza').val();
				d.ciBuscarInvestigador = $('#ciBuscarInvestigador').val();
				d.usuario = $('#btnLogout').attr('name');
			}
		},
		initComplete: function(settings, json) {
			loadingSiglo('hide');
			if(json.aaData.length > 0){
				//$("#frmBuscarInvestigaciones").modal("hide");
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
		{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}

$('#btnBuscarCensoInv').click(function(e){
	var val1=1; var val2=1; var val3=1; var val4=1; var val5=1; var val6=1;

	if ($('#ciBuscarCodigo').val()==""){
		val1=2;
	}else{
		val1=1;
	}

	if ($('#ciBuscarNombre').val()==""){
		val2=2;
	}else{
		val2=1;
	}

	if ($('#ciBuscarIdentificacion').val()==""){
		val3=2;
	}else{
		val3=1;
	}

	if ($('#ciBuscarPlaca').val()==""){
		val4=2;
	}else{
		val4=1;
	}

	if ($('#ciBuscarPoliza').val()==""){
		val5=2;
	}else{
		val5=1;
	}

	if ($('#ciBuscarInvestigador').val()==""){
		val5=2;
	}else{
		val5=1;
	}

	if (val1==2 && val2==2 && val3==2 && val4==2 && val5==2 && val6==2){
		$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
		$("#ContenidoErrorNonActualizable").html("Debe ingresar alguno de los campos de filtro");
		$('#ErroresNonActualizable').modal('show');
	}
	else{

		llenarTablaGestionCensosInvestigador();
		$('#DivTablaGestionCensosInvestigador').show();
	}
});

$('#RegistrarCensoInvestigador').on("click", function(){
	$(".divOcultar").hide();
	$("#formularioCensoInv")[0].reset();
	$('#ciAseguradora').val('').trigger('change.select2');
	$('#ciCiudad').val('').trigger('change.select2');
	$('#ciIps').val('').trigger('change.select2');
	if ($("#ciTipoCaso").hasClass("select2-hidden-accessible")) {
		$("#ciTipoCaso").select2("destroy");
	}
	$("#ciTipoCaso").html("<option value=''>Seleccione</option>");
	$("#ciTipoCaso").val("");
	$("#ciTableLesionados").html("");
	$("#DivRegistrarCensoInvestigador").show();
});

$("#ciAseguradora").change(function() {

	var idAseguradora = $('#ciAseguradora option:selected').val();
	var tipoCasos = "Global";
	var selectUbicacion = "#ciTipoCaso";
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
				if(json_obj[i].descripcion2 != ''){
					options += '<option value="'+json_obj[i].valor+'-'+json_obj[i].descripcion2+'">' + json_obj[i].descripcion + '</option>';
				}else{
					options += '<option value="'+json_obj[i].valor+'">' + json_obj[i].descripcion + '</option>';
				}				
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

$("#ciServicioAmbulancia").change(function() {
	
	if($("#ciServicioAmbulancia").val() == "s"){
		$("#ciTipoTraslado").prop('disabled', false);
		$("#ciLugarTraslado").prop('disabled', false);
	}else{
		$("#ciTipoTraslado").val("");
		$("#ciLugarTraslado").val("");
		$("#ciTipoTraslado").prop('disabled', true);
		$("#ciLugarTraslado").prop('disabled', true);
	}
});

var trEnEdicion;

function ciAgregarLesionado(opcion){
	var error1 = error2 = error3 = error4 = false;

	if($("#ciLesIdentificacion").val() == ''){
    	$("#ciLesIdentificacion").parent().find(".input-group-icon").css("background-color","#e83838");
    	$("#ciLesIdentificacion").css("border", "1px solid #e83838");
    	error1 = true;
	}else{
		$("#ciLesIdentificacion").parent().find(".input-group-icon").css("background-color","#304f6f");
		$("#ciLesIdentificacion").css("border", "1px solid #304f6f");
		error1 = false;
	}

	if($("#ciLesNombre").val() == ''){
		$("#ciLesNombre").parent().find(".input-group-icon").css("background-color","#e83838");
    	$("#ciLesNombre").css("border", "1px solid #e83838");
    	error2 = true;
	}else{
		$("#ciLesNombre").parent().find(".input-group-icon").css("background-color","#304f6f");
    	$("#ciLesNombre").css("border", "1px solid #304f6f");
    	error3 = false;
	}

	if($("#ciLesApellidos").val() == ''){
		$("#ciLesApellidos").parent().find(".input-group-icon").css("background-color","#e83838");
    	$("#ciLesApellidos").css("border", "1px solid #e83838");
    	error3 = true;
	}else{
		$("#ciLesApellidos").parent().find(".input-group-icon").css("background-color","#304f6f");
    	$("#ciLesApellidos").css("border", "1px solid #304f6f");
    	error3 = false;
	}

	if($("#ciLesTipoIdentificacion").val() == '0'){
    	$("#ciLesTipoIdentificacion").parent().find(".input-group-icon").css("background-color","#e83838");
    	$("#ciLesTipoIdentificacion").css("border", "1px solid #e83838");
    	error4 = true;
	}else{
		$("#ciLesTipoIdentificacion").parent().find(".input-group-icon").css("background-color","#304f6f");
		$("#ciLesTipoIdentificacion").css("border", "1px solid #304f6f");
		error4 = false;
	}

	if(!error1 && !error2 && !error3){

		var error5 = false;
		
		$("#ciTableLesionados tr").each(function (index) {
			if($(this).find(".ciTdIdentificacionLes input.identificacion").val() == $("#ciLesIdentificacion").val().toUpperCase()){
				if(opcion ==  2){
					if($(this).attr('id') != trEnEdicion.attr('id')){
						error5 = true;
						return false;
					}
				}else{
					error5 = true;
					return false;					
				}
			}
		});

		var dataSelTipoId = $('#ciLesTipoIdentificacion').select2('data');
		var tipoIdVal = dataSelTipoId[0].id;
		var tipoIdTex = dataSelTipoId[0].text;
		var tempTipoId = tipoIdTex.split('-');
		
		tipoIdTex = tempTipoId[0];

		if(error5){
			$("#ciLesIdentificacion").parent().find(".input-group-icon").css("background-color","#e83838");
	    	$("#ciLesIdentificacion").css("border", "1px solid #e83838");
			Swal.fire(
		      '¡Ya Existe!',
		      'La identificación que intenta ingresar ya existe.',
		      'error'
		    );
		    $("#ciLesIdentificacion").focus();
			return false;
		}else if(opcion == 1){

			var filaPrincipal = "<tr id='"+$("#ciLesIdentificacion").val().toUpperCase()+"' class='principal'>"+
			  	"<td>"+
			    	"<div class='btn-group'>"+
			      	"<button type='button' class='btn btn-success dropdown-toggle' data-toggle='dropdown' aria-expanded='true'>"+
				       	"<span class='caret'></span>"+
				       	"<span class='sr-only'>Toggle Dropdown</span>"+
				    "</button>"+
				      	"<ul class='dropdown-menu' role='menu' style='background-color: #fbf0e4;'>"+
				        	"<li onclick='ciEditarLesionado(this);' class='ciBtnEditLesionado'><a>Editar</a></li>"+
				        	"<li class='divider'></li> "+
				        	"<li onclick='ciRemoverLesionado(this);'><a class='ciBtnRemLesionado'>Remover</a></li>"+
				    	"</ul>"+
				    "</div>"+
				"</td>"+
				"<td class='ciTdTipoIdentLes'>"+
					"<input class='tipoIdentificacion' type='hidden' name='ciTipoIdentLes[]' value='"+tipoIdVal+"'>"+
					tipoIdTex+
				"</td>"+	
				"<td class='ciTdIdentificacionLes'>"+
					"<input class='ciTipoLes' type='hidden' name='ciTipoLes[]' value='p'>"+
					"<input class='identificacion' type='hidden' name='ciIdentLes[]' value='"+$("#ciLesIdentificacion").val().toUpperCase()+"'>"+
				  $("#ciLesIdentificacion").val().toUpperCase()+"</td>"+
				"<td class='ciTdNombreLes'>"+
				  "<input type='hidden' name='ciNombreLes[]' value='"+$("#ciLesNombre").val().toUpperCase()+"'>"+
				  $("#ciLesNombre").val().toUpperCase()+"</td>"+
				  "<td class='ciTdApellidosLes'>"+
				  "<input type='hidden' name='ciApellidoLes[]' value='"+$("#ciLesApellidos").val().toUpperCase()+"'>"+
				  $("#ciLesApellidos").val().toUpperCase()+"</td>"+
				"</tr>";

			var filaSecundario = "<tr id='"+$("#ciLesIdentificacion").val().toUpperCase()+"'>"+
				  "<td>"+
				    "<div class='btn-group'>"+
				      "<button type='button' class='btn btn-warning dropdown-toggle' data-toggle='dropdown' aria-expanded='true'>"+
				        "<span class='caret'></span>"+
				        "<span class='sr-only'>Toggle Dropdown</span>"+
				      "</button>"+
				      "<ul class='dropdown-menu' role='menu' style='background-color: #fbf0e4;'>"+
				        "<li onclick='ciEditarLesionado(this);' class='ciBtnEditLesionado'><a>Editar</a></li>"+
				        "<li class='divider'></li> "+
				        "<li onclick='ciRemoverLesionado(this);'><a class='ciBtnRemLesionado'>Remover</a></li>"+
				        "<li class='divider'></li> "+
				        "<li onclick='ciMarcarLesionado(this);'><a class='ciBtnMarLesionado'>Marcar Principal</a></li>"+
				      "</ul>"+
				    "</div>"+
				  "</td>"+
				  "<td class='ciTdTipoIdentLes'>"+
					"<input class='tipoIdentificacion' type='hidden' name='ciTipoIdentLes[]' value='"+tipoIdVal+"'>"+
					tipoIdTex+
				  "</td>"+
				  "<td class='ciTdIdentificacionLes'>"+
				  "<input class='ciTipoLes' type='hidden' name='ciTipoLes[]' value='s'>"+
				  "<input class='identificacion' type='hidden' name='ciIdentLes[]' value='"+$("#ciLesIdentificacion").val().toUpperCase()+"'>"+
				  $("#ciLesIdentificacion").val().toUpperCase()+"</td>"+
				  "<td class='ciTdNombreLes'>"+
				  "<input type='hidden' name='ciNombreLes[]' value='"+$("#ciLesNombre").val().toUpperCase()+"'>"+
				  $("#ciLesNombre").val().toUpperCase()+"</td>"+
				  "<td class='ciTdApellidosLes'>"+
				  "<input type='hidden' name='ciApellidoLes[]' value='"+$("#ciLesApellidos").val().toUpperCase()+"'>"+
				  $("#ciLesApellidos").val().toUpperCase()+"</td>"+
				"</tr>";;
			
			if($("#ciTableLesionados tr").length <= 0){
				Swal.fire('¡Lesionado Principal! Podrá cambiarlo cuando haya más de uno en la tabla.');
				var fila = filaPrincipal;
			}else{			
				var fila = filaSecundario;
			}
			
			$("#ciTableLesionados").append(fila);
		}else{

			var filaPrincipal = "<td>"+
				"<div class='btn-group'>"+
				  "<button type='button' class='btn btn-success dropdown-toggle' data-toggle='dropdown' aria-expanded='true'>"+
				    "<span class='caret'></span>"+
				    "<span class='sr-only'>Toggle Dropdown</span>"+
				  "</button>"+
				  "<ul class='dropdown-menu' role='menu' style='background-color: #fbf0e4;'>"+
				    "<li onclick='ciEditarLesionado(this);' class='ciBtnEditLesionado'><a>Editar</a></li>"+
				    "<li class='divider'></li> "+
				    "<li onclick='ciRemoverLesionado(this);'><a class='ciBtnRemLesionado'>Remover</a></li>"+
				  "</ul>"+
				"</div>"+
				"</td>"+
				"<td  class='ciTdTipoIdentLes'>"+
					"<input class='tipoIdentificacion' type='hidden' name='ciTipoIdentLes[]' value='"+tipoIdVal+"'>"+
					tipoIdTex+
				"</td>"+
				"<td class='ciTdIdentificacionLes'>"+
				"<input class='ciTipoLes' type='hidden' name='ciTipoLes[]' value='p'>"+
				"<input class='identificacion' type='hidden' name='ciIdentLes[]' value='"+$("#ciLesIdentificacion").val().toUpperCase()+"'>"+
				$("#ciLesIdentificacion").val().toUpperCase()+"</td>"+
				"<td class='ciTdNombreLes'>"+
				"<input type='hidden' name='ciNombreLes[]' value='"+$("#ciLesNombre").val().toUpperCase()+"'>"+
				$("#ciLesNombre").val().toUpperCase()+"</td>"+
				"<td class='ciTdApellidosLes'>"+
				"<input type='hidden' name='ciApellidoLes[]' value='"+$("#ciLesApellidos").val().toUpperCase()+"'>"+
				$("#ciLesApellidos").val().toUpperCase()+"</td>";

			var filaSecundario = "<td>"+
				"<div class='btn-group'>"+
				  "<button type='button' class='btn btn-warning dropdown-toggle' data-toggle='dropdown' aria-expanded='true'>"+
				    "<span class='caret'></span>"+
				    "<span class='sr-only'>Toggle Dropdown</span>"+
				  "</button>"+
				  "<ul class='dropdown-menu' role='menu' style='background-color: #fbf0e4;'>"+
				    "<li onclick='ciEditarLesionado(this);' class='ciBtnEditLesionado'><a>Editar</a></li>"+
				    "<li class='divider'></li> "+
				    "<li onclick='ciRemoverLesionado(this);'><a class='ciBtnRemLesionado'>Remover</a></li>"+
			        "<li class='divider'></li> "+
			        "<li onclick='ciMarcarLesionado(this);'><a class='ciBtnMarLesionado'>Marcar Principal</a></li>"+
				  "</ul>"+
				"</div>"+
				"</td>"+
				"<td class='ciTdTipoIdentLes'>"+
					"<input class='tipoIdentificacion' type='hidden' name='ciTipoIdentLes[]' value='"+tipoIdVal+"'>"+
					tipoIdTex+
				"</td>"+
				"<td class='ciTdIdentificacionLes'>"+
				"<input class='ciTipoLes' type='hidden' name='ciTipoLes[]' value='s'>"+
				"<input class='identificacion' type='hidden' name='ciIdentLes[]' value='"+$("#ciLesIdentificacion").val().toUpperCase()+"'>"+
				$("#ciLesIdentificacion").val().toUpperCase()+"</td>"+
				"<td class='ciTdNombreLes'>"+
				"<input type='hidden' name='ciNombreLes[]' value='"+$("#ciLesNombre").val().toUpperCase()+"'>"+
				$("#ciLesNombre").val().toUpperCase()+"</td>"+
				"<td class='ciTdApellidosLes'>"+
				"<input type='hidden' name='ciApellidoLes[]' value='"+$("#ciLesApellidos").val().toUpperCase()+"'>"+
				$("#ciLesApellidos").val().toUpperCase()+"</td>";

			$("#ciBtnAddLesionado").attr("onclick","ciAgregarLesionado(1);");

			var fila = filaSecundario;
			
			if($(trEnEdicion).hasClass("principal")){
				fila = filaPrincipal;
			}

			$(trEnEdicion).html(fila);
		}

		if ($("#ciLesTipoIdentificacion").hasClass("select2-hidden-accessible")) {
			$("#ciLesTipoIdentificacion").select2("destroy");
		}

		$("#ciLesTipoIdentificacion").val(0);
		
		$("#ciLesTipoIdentificacion").select2();	

		$("#ciLesIdentificacion").val("");
		$("#ciLesNombre").val("");
		$("#ciLesApellidos").val("");

	}else{
		$("#ciLesIdentificacion").focus();
	}
}

function ciEditarLesionado(li){
	var element = $(li).parent().parent().parent().parent();

	if ($("#ciLesTipoIdentificacion").hasClass("select2-hidden-accessible")) {
		$("#ciLesTipoIdentificacion").select2("destroy");
	}

	$("#ciLesTipoIdentificacion").val($(element).find(".ciTdTipoIdentLes input.tipoIdentificacion").val());
	
	$("#ciLesTipoIdentificacion").select2();

	$("#ciLesIdentificacion").val($(element).find(".ciTdIdentificacionLes input.identificacion").val().toUpperCase());
	$("#ciLesNombre").val($(element).find(".ciTdNombreLes input").val().toUpperCase());
	$("#ciLesApellidos").val($(element).find(".ciTdApellidosLes input").val().toUpperCase());
	$("#ciBtnAddLesionado").attr("onclick","ciAgregarLesionado(2);");
	trEnEdicion = element;
}

function ciRemoverLesionado(li){
	var element = $(li).parent().parent().parent().parent();
	Swal.fire({
	  title: '¿DESEA REALIZAR ACCIÓN?',
	  text: "En caso de ser el PRINCIPAL. ¡Deberá volverl a seleccionarlo!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Eliminar',
	  confirmButtonCancel: 'Cancelar'
	}).then((result) => {
	  
	  if (result.value) {
	  	
	  	var texto = 'Eliminado correctamente.';
	  	
	  	if($(element).hasClass("principal")){
	  		texto = '¡Recuerde seleccionar el PRINCIPAL!';
	  	}
	    
	    Swal.fire(
	      'Eliminado',
	      texto,
	      'success'
	    );

		$(element).fadeOut(300, function(){
		  	if($(element).hasClass("principal")){
		  		ciRemoverLesPrincipales();
		  	}
			$(element).remove();
		});
	  }
	});
}

function ciMarcarLesionado(li){
	ciRemoverLesPrincipales();
	var element = $(li).parent().parent().parent().parent();
	$(element).addClass("principal");
	$(element).find(".ciTdIdentificacionLes input.ciTipoLes").val('p');
	$(element).find("button.dropdown-toggle").removeClass("btn-warning");
	$(element).find("button.dropdown-toggle").addClass("btn-success");
}

function ciRemoverLesPrincipales(){
	$("#ciTableLesionados tr").each(function (index) {
		$(this).removeClass("principal");
		$(this).find(".ciTdIdentificacionLes input.ciTipoLes").val('s');
		$(this).find("button.dropdown-toggle").removeClass("btn-success");
		$(this).find("button.dropdown-toggle").addClass("btn-warning");
	});
}

$('#formularioCensoInv').submit(function( event ) {

	if($("#ciServicioAmbulancia").val() == 's'){
		
		if($("#ciTipoTraslado").val() == '' || $("#lugar_raslado").val() == ''){
			Swal.fire({
			  icon: 'error',
			  title: 'Oops...',
			  text: '¡Debe llenar los campos de Traslado!'
			})
			return false;
		}
	}
	
	if($("#ciTableLesionados tr").length <= 0){
		Swal.fire({
		  icon: 'error',
		  title: 'Oops...',
		  text: '¡Debe agregar por lo menos un lesionado a la tabla!'
		});
		return false;
	}else{

		var cantLesPrin = 0;
		
		$("#ciTableLesionados tr").each(function (index) {
			if($(this).hasClass("principal")){
				cantLesPrin++;
			}
		});

		if(cantLesPrin == 0){
			Swal.fire({
			  icon: 'error',
			  title: 'Oops...',
			  text: '¡Debe escoger Lesionado Principal!'
			});

			return false;
		}	
	}	

	$('html, body').animate({scrollTop: 0}, 200);

	loadingSiglo('show','¡Enviando Caso De Censo!...');

	var formCensoInv = "exe=addCensoInvestigador&";
	formCensoInv += $("#formularioCensoInv").serialize();

	$.ajax({
		type: 'POST',
		url: 'class/consultasManejoCasoSOAT.php',
        data: formCensoInv,                           
        success: function(data) {
			
			if (data==1){

				$("#formularioCensoInv")[0].reset();
				$('#ciAseguradora').val('').trigger('change.select2');
				$('#ciCiudad').val('').trigger('change.select2');
				$('#ciIps').val('').trigger('change.select2');
				$("#ciTipoCaso").select2("destroy");
				$("#ciTipoCaso").html("<option value=''>Seleccione</option>");
				$("#ciTipoCaso").val("");
				$("#ciTableLesionados").html("");

				loadingSiglo('hide');
				
				Swal.fire({
				  position: 'top-end',
				  icon: 'success',
				  title: 'Censo Guardado y Enviado',
				  showConfirmButton: false,
				  timer: 1500
				});

			}else{ 
				loadingSiglo('hide');
				if (data==2){
					Swal.fire({
					  position: 'top-end',
					  icon: 'error',
					  title: 'Error, intente de Nuevo',
					  showConfirmButton: false,
					  timer: 1500
					});
				}			
			}
			return false;

		}, error: function(data){
			loadingSiglo('hide');

			Swal.fire({
			  position: 'top-end',
			  icon: 'error',
			  title: 'Upss! Algo salió Mal',
			  showConfirmButton: false,
			  timer: 1500
			});
			return false;
		}
	});

	return false;
});



$("#periodoAsignarInvestigadorCuentaCobroFrm").change(function(){

	//$('#categoriaFrmSolicitudesCotizaciones').val("n").change();

	//	alert($("#btnLogout").attr("name")+"-"+$("#categoriaFrmSolicitudesCotizaciones option:selected").val());
	//llenarSelect($("#periodoAsignarInvestigadorCuentaCobroFrm option:selected").val(),"#investigadorAsignarInvestigadorCuentaCobroFrm","consultarInvestigadoresPeriodos");

});


$('#btnSubmitAsignarInvestigadorCuentaCobro').click(function(e){

	var val1=1; var val2=1; var val3=1; var val4=1; var val5=1;  var val6=1; 
	var mensaje=""; 


	if ($('#investigadorAsignarInvestigadorCuentaCobroFrm option:selected').val()==0 || $('#investigadorAsignarInvestigadorCuentaCobroFrm option:selected').val()==""){
		val1=2;
		//alert(val1);
		mensaje+="Debe Seleccionar Investigador";
		$.notify(mensaje,{"globalPosition":"bottom left"});
	}else{
		val1=1;
	}

	if ($('#periodoAsignarInvestigadorCuentaCobroFrm option:selected').val()==0 || $('#periodoAsignarInvestigadorCuentaCobroFrm option:selected').val()==0){
		val2=2;
		//alert(val2);
		mensaje="Debe Seleccionar Periodo";
		
		$.notify(mensaje,{"globalPosition":"bottom left"});
	}else{
		val2=1;
	}



	if ($('#resultadoAsignarInvestigadorCuentaCobroFrm option:selected').val()==0 || $('#resultadoAsignarInvestigadorCuentaCobroFrm option:selected').val()==0){
		val3=2;
		//alert(val3);
		mensaje="Debe Seleccionar Resultado";
		
		$.notify(mensaje,{"globalPosition":"bottom left"});
	}else{
		val3=1;
	}



	if ($('#tipoAuditoriaAsignarInvestigadorCuentaCobroFrm option:selected').val()==0 || $('#tipoAuditoriaAsignarInvestigadorCuentaCobroFrm option:selected').val()==0){
		val4=2;
		//alert(val4);
		mensaje="Debe Seleccionar Tipo Auditoria";
		
		$.notify(mensaje,{"globalPosition":"bottom left"});
	}else{
		val4=1;
	}



	if ($('#tipoZonaAsignarInvestigadorCuentaCobroFrm option:selected').val()==0 || $('#tipoZonaAsignarInvestigadorCuentaCobroFrm option:selected').val()==0){
		val5=2;
		//alert(val5);
		mensaje="Debe Seleccionar Tipo Zona";
		
		$.notify(mensaje,{"globalPosition":"bottom left"});
	}else{
		val5=1;
	}



		if ($('#tipoCasoAsignarInvestigadorCuentaCobroFrm option:selected').val()==0 || $('#tipoCasoAsignarInvestigadorCuentaCobroFrm option:selected').val()==0){
		val6=2;
		//alert(val6);
		mensaje="Debe Seleccionar Tipo Caso";
		
		$.notify(mensaje,{"globalPosition":"bottom left"});
	}else{
		val6=1;
	}






	if (val1==2 || val2==2 || val3==2 || val4==2 || val5==2 || val6==2){
		
	}else{
		loadingSiglo('show','Asignando Cuenta Cobro Investigador...');
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoCasoSOAT.php',
			data: "exe=asignarInvestigadorCuentaCobro&idInvestigador="+$('#investigadorAsignarInvestigadorCuentaCobroFrm option:selected').val()
			+"&periodoAsignar="+$('#periodoAsignarInvestigadorCuentaCobroFrm option:selected').val()
			+"&resultadoAsignar="+$('#resultadoAsignarInvestigadorCuentaCobroFrm option:selected').val()
			+"&tipoAuditoriaAsignar="+$('#tipoAuditoriaAsignarInvestigadorCuentaCobroFrm option:selected').val()
			+"&tipoZonaAsignar="+$('#tipoZonaAsignarInvestigadorCuentaCobroFrm option:selected').val()
			+"&tipoCasoAsignar="+$('#tipoCasoAsignarInvestigadorCuentaCobroFrm option:selected').val()
			+"&idCaso="+$('#idCasoSoatInvestigadorCuentaCobro').val()
			+"&idUsuario="+$('#btnLogout').attr('name'),
			success: function(data) {
				//alert(data);
				loadingSiglo('hide');
				if (data==1) {
					$.ajax({
			type: 'POST',
			url: 'class/consultasManejoCasoSOAT.php',
			data: "exe=consultarInformacionAsignarInvestigadorCuentaCobro&idCaso="+$('#idCasoSoatInvestigadorCuentaCobro').val(),
			success: function(data) {

				//alert(data);
				var json_obj = $.parseJSON(data);
				
				
				if (json_obj.resultado==1)
				{
					$('#formSeleccionarInvestigadorCuentaCobro').show();	
					$('#divButtonAsignarInvestigadorCuentaCobro').show();

				}else if (json_obj.resultado==2){
					$('#formSeleccionarInvestigadorCuentaCobro').hide();
					$('#divButtonAsignarInvestigadorCuentaCobro').hide();	

				}
				$('#investigadorAsignarInvestigadorCuentaCobroFrm').val(json_obj.id_investigador).change();
				$('#periodoAsignarInvestigadorCuentaCobroFrm').val(json_obj.id_periodo).change();
				$('#resultadoAsignarInvestigadorCuentaCobroFrm').val(json_obj.id_resultado).change();
				$('#tipoAuditoriaAsignarInvestigadorCuentaCobroFrm').val(json_obj.id_tipo_auditoria).change();
				$('#tipoZonaAsignarInvestigadorCuentaCobroFrm').val(json_obj.tipo_zona).change();
				$('#tipoCasoAsignarInvestigadorCuentaCobroFrm').val(json_obj.tipo_caso).change();


				$('#idCasoSoatInvestigadorCuentaCobro').val($('#idCasoSoatInvestigadorCuentaCobro').val());
				$('#resultadoAsignacionInvestigadorCuentaCobro').html(json_obj.descripcion_resultado);
				$('#modalAsignarInvestigadorCuentaCobro').modal("show");			
			}
		});



					$.notify("Proceso ejecutado Satisfactoriamente",{"globalPosition":"bottom left",'className': 'success'});	
					
					//$('#modalAsignarInvestigadorCuentaCobro').modal('hide');
				}
				else if(data==2){
					$.notify("Error al asignar",{"globalPosition":"bottom left"});	
					//$('#ErroresNonActualizable').modal('show');
				}
				else{
					$.notify("Error",{"globalPosition":"bottom left"});	
				}
			},error: function(data){
				loadingSiglo('hide');
				alert("error");
			}
		});
	}
});



$("#DivTablas27").on('click','a',function(){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');
	if (action=="btnAutorizarCasoDuplicadoFacturacion"){
		llenarTablaDuplicadoCasosAutorizadosFacturacion(opcion);
	}
});


$('#btnConfirmarDuplicadosCasosAutorizadosFacturacion').click(function(e){
		$("#modalDuplicadoCasosAutorizadosFacturacion").modal("hide");
		ModalRegistrosOut("AutorizarFacturacion",$("#idDuplicadosAutorizacionFacturacion").val(),"tablaGestionCasosSOAT","autorizarFacturacionInvestigacion");
});


function llenarTablaDuplicadoCasosAutorizadosFacturacion(idInvestigacion){


	loadingSiglo('show', 'Buscando Casos...');
	$('#tablaDuplicadosAutorizacionFacturacion').DataTable( {
		"destroy": true,
		"select": 'multi',
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "consultarDuplicadoCasosAutorizadosFacturacion";
				d.idInvestigacion =idInvestigacion;
			}
		},
		initComplete: function(settings, json) {
			loadingSiglo('hide');
			if(json.aaData.length > 0){
				
				$("#idDuplicadosAutorizacionFacturacion").val(idInvestigacion);
				$("#modalDuplicadoCasosAutorizadosFacturacion").modal("show");
			}else{
				ModalRegistrosOut("AutorizarFacturacion",idInvestigacion,"tablaGestionCasosSOAT","autorizarFacturacionInvestigacion");
			}
		},
		"bPaginate":true,
		"bProcessing": true,
		"pageLength": 6,
		"columns": [
		{ mData: 'codigoCasoDuplicadoAutorizacionFacturacion', "orderable": "true" } ,
		{ mData: 'nombreUsuarioCasoDuplicadoAutorizacionFacturacion', "orderable": "true" } ,
		{ mData: 'fechaCasoDuplicadoAutorizacionFacturacion', "orderable": "true" } 
		],
		"language": 
		{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}



function llenarTablaEstadosCasosAutorizacionMultiple(dataset2){

	var dataSet1 = [];
	var dataSet3=[];
	//dataSet.push(JSON.stringify(dataset2));
	//alert(dataset2);
	var json_obj = $.parseJSON(dataset2);
	//alert(json_obj.length);
			for (var i = 0; i < json_obj.length; i++) {
				//alert(json_obj[i].codigoCasoDuplicadoAutorizacionFacturacion+"//"+json_obj[i].polizaCasoDuplicadoAutorizacionFacturacion+"//"+json_obj[i].nombreLesionadoDuplicadoAutorizacionFacturacion+"//"+json_obj[i].estadoDuplicadoAutorizacionFacturacion);
				dataSet1.push(json_obj[i].codigoCasoDuplicadoAutorizacionFacturacion,json_obj[i].polizaCasoDuplicadoAutorizacionFacturacion,json_obj[i].nombreLesionadoDuplicadoAutorizacionFacturacion,json_obj[i].estadoDuplicadoAutorizacionFacturacion,json_obj[i].opciones);
				
				dataSet3.push(dataSet1);	
				dataSet1=[];
			}
			
	//alert(dataSet3);
	loadingSiglo('show', 'Buscando Casos...');
	
	$('#tablaEstadosCasosAutorizacionMultiple').DataTable( {
		"destroy": true,
		"select": 'multi',
		"data":dataSet3,
		initComplete: function(settings, json) {
			loadingSiglo('hide');
			
		},

		"bPaginate":true,
		"bProcessing": true,
		"pageLength": 6,
	"columns": [
		 {"orderable": "true"  },
            { "orderable": "true"  },
            { "orderable": "true"  },
            { "orderable": "true"  },
            { "orderable": "true"  }
		],
		"language": 
		{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}



$('#btnAutorizarFacturacionCasos').click(function(e){	
	var table = $('#tablaGestionCasosSOAT').DataTable();
		var data=table.row('.selected').data();
		if ( !table.rows( '.selected' ).any() ) 
		{
    		$("#ContenidoErrorNonActualizable").html("No ha seleccionado ningun procedimiento para eliminar");
			$('#ErroresNonActualizable').modal('show');
		}
		else
		{
			
			//$('#tablaInfoProcedimientosAgendarCita').DataTable().row('.selected').remove().draw( false );
				var idInvestigaciones=[];
			table.rows('.selected').every(function(){
				var data=this.data();
				var data2={};									
				data2.idInvestigacion=data["idInvestigacion"];
				
				
				idInvestigaciones.push(data2);
			});

			//alert(JSON.stringify(idInvestigaciones));
			var form= "exe=autorizarFacturacionMultipleInvestigaciones"+
			"&idInvestigaciones="+JSON.stringify(idInvestigaciones)+
			"&idUsuario="+$('#btnLogout').attr('name');
	$.ajax({
			type: 'POST',
			url: 'class/consultasManejoCasoSOAT.php',
			data: form,
			success: function(data) {
				//alert(data);
					llenarTablaEstadosCasosAutorizacionMultiple(data);
					llenarTablaGestionCasosSOAT();
					loadingSiglo('hide', '');
					$('#modalEstadoCasosAutorizacionMultiple').modal('show');
				
				
						
			}, error: function(data){
				loadingSiglo('hide');
				alert("Upss! Algo salió Mal")
			}
		});

		}
});



$(".deshabilitarCopiado").on("drop", function(event) {
    event.preventDefault();  
   	event.stopPropagation();
    Swal.fire({
	  position: 'center',
	  type: 'error',
	  title: '¡No puede realizar esta acción! :(',
	  showConfirmButton: false,
	  timer: 1800
	});
});

$('.deshabilitarCopiado').bind("cut copy paste",function(e) {
	e.preventDefault();
	Swal.fire({
	  position: 'center',
	  type: 'error',
	  title: '¡No puede realizar esta acción! :(',
	  showConfirmButton: false,
	  timer: 1800
	});
});

$('#fileInformeFinal2').on("change", function(){ 
	var formArchivoInformeFinal = new FormData();
	formArchivoInformeFinal.append("exe","subirArchivoInformeFinal2");
	formArchivoInformeFinal.append("idInvestigacion",$("#fileInformeFinal2").attr("name"));
	formArchivoInformeFinal.append("idUsuario",$('#btnLogout').attr('name'));
	formArchivoInformeFinal.append("informeFinal2",this.files[0]);

	loadingSiglo('show', 'Subiendo Informe 2...');
	$.ajax({
		type: 'POST',
		url: 'class/consultasManejoCasoSOAT.php',
		data: formArchivoInformeFinal,
		cache: false,
		contentType: false,
		processData: false,
		success: function(data) {

			if (data==1){
				$('#fileInformeFinal2').val('');
				cargarOpcionesInformeFinal($("#fileInformeFinal2").attr("name"));
				loadingSiglo('hide', '');
				$("#ContenidoErrorNonActualizable").html("Informe Subido Satisfactoriamente");
				$('#ErroresNonActualizable').modal('show');
			}
			else if (data==2){
				loadingSiglo('hide', '');
				$("#ContenidoErrorNonActualizable").html("Error al Subir Anexo");
				$('#ErroresNonActualizable').modal('show');
			}
			else if (data==3){
				loadingSiglo('hide', '');
				$("#ContenidoErrorNonActualizable").html("No se pudo mover informe");
				$('#ErroresNonActualizable').modal('show');
			}
			else if (data==4){
				loadingSiglo('hide', '');
				$("#ContenidoErrorNonActualizable").html("Tipo de archivo no permitido");
				$('#ErroresNonActualizable').modal('show');
			}
			else if (data==5){
				loadingSiglo('hide', '');
				$("#ContenidoErrorNonActualizable").html("No ha seleccionado ningun archivo");
				$('#ErroresNonActualizable').modal('show');
			}
			else if (data==6){
				loadingSiglo('hide', '');
				cargarOpcionesInformeFinal($("#fileInformeFinal").attr("name"));
				$("#ContenidoErrorNonActualizable").html("Informe Subido Satisfactoriamente. Hubo error al enviar notificacion a la Aseguradora");
				$('#ErroresNonActualizable').modal('show');
			}
			return false;
		}, error: function(data){
			loadingSiglo('hide', '');
			$("#ContenidoErrorNonActualizable").html("Upss! Algo salió mal...");
			$('#ErroresNonActualizable').modal('show');
		}
	});
});

function llenarTablaGestionCasosSOATHistorico(){
	loadingSiglo('show', 'Buscando Casos...');
	$('#tablaGestionCasosSOATHistorico').DataTable( {
		"destroy": true,
		"select": true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "consultarCasosSOATHistorico";
				d.codigoFrmBuscarSOAT = $('#codigoFrmBuscarSOAT').val();
				d.nombresFrmBuscarSOAT = $('#nombresFrmBuscarSOAT').val();
				d.apellidosFrmBuscarSOAT = $('#apellidosFrmBuscarSOAT').val();
				d.identificacionFrmBuscarSOAT = $('#identificacionFrmBuscarSOAT').val();
				d.placaFrmBuscarSOAT = $('#placaFrmBuscarSOAT').val();
				d.polizaFrmBuscarSOAT = $('#polizaFrmBuscarSOAT').val();
				d.identificadorFrmBuscarSOAT = $('#identificadorFrmBuscarSOAT').val();
				d.tipoConsultaBuscar=$("#tipoConsultaBuscar").val();
				
				d.usuario = $('#btnLogout').attr('name');
			}
		},
		initComplete: function(settings, json) {
            loadingSiglo('hide');
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
		{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}

$('#btnSubmitFrmAsignarInvestigacion').click(function(e){
	loadingSiglo('show', 'Guardando Investigación...');
	var val1=1; var val2=1; var val3=1; var val4=1; var val5=1; 
	var mensaje=""; 

	if ($('#tipoCasoFrmAsignarInvestigacion option:selected').val()==0 || $('#tipoCasoFrmAsignarInvestigacion option:selected').val()==""){
		val1=2;
		mensaje+="Debe Seleccionar Tipo de Caso<br>";
	}else{
		val1=1;
	}

	if (($('#fechaEntregaFrmAsignarInvestigacion').val()=="")){
		val2=2;
		mensaje+="Debe Ingresar Fecha Entrega<br>";
	}else{
		val2=1;
	}

	if ($('#motivoInvestigacionFrmAsignarInvestigacion').val()==""){
		val3=2;
		mensaje+="Debe Ingresar Motivo Investigacion<br>";
	}else{
		val3=1;
	}

	if ($("#tipoCasoFrmAsignarInvestigacion option:selected").val()=="12"){
		if (($('#cartaPresentacionFile').val()=="")){
			val5=2;
			mensaje+="Debe Seleccionar Un Carta Presentacion<br>";
		}else{
			val5=1;
		}	
	}

	if (val1==2 || val2==2 || val3==2  || val5==2)	{
		$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
		$("#ContenidoErrorNonActualizable").html(mensaje);
		$('#ErroresNonActualizable').modal('show');
		loadingSiglo('hide');
	}else{

		var formAsignarInvestigacion = new FormData();
		formAsignarInvestigacion.append("exe",$('#exeFrmAsignarInvestigacion').val());
		formAsignarInvestigacion.append("idAseguradoraFrmAsignarInvestigacion",$("#idAseguradoraFrmAsignarInvestigacion").val());
		formAsignarInvestigacion.append("idInvestigacion",$("#idCasoFrmAsignarInvestigacion").val());
		formAsignarInvestigacion.append("fechaEntregaFrmAsignarInvestigacion",$("#fechaEntregaFrmAsignarInvestigacion").val());
		formAsignarInvestigacion.append("tipoCasoFrmAsignarInvestigacion",$("#tipoCasoFrmAsignarInvestigacion  option:selected").val());
		formAsignarInvestigacion.append("idUsuario",$('#btnLogout').attr('name'));
		formAsignarInvestigacion.append("motivoInvestigacionFrmAsignarInvestigacion",$('#motivoInvestigacionFrmAsignarInvestigacion').val());
		
		if ($('#soporteFile').val()!=""){
			formAsignarInvestigacion.append("soporteFile",$("#soporteFile").prop("files")[0]);
		}

		if ($("#tipoCasoFrmAsignarInvestigacion option:selected").val()=="12"){
			if ($('#cartaPresentacionFile').val()!=""){
				formAsignarInvestigacion.append("cartaPresentacionFile",$("#cartaPresentacionFile").prop("files")[0]);
			}
		}	

		var formDestino="";
		if ($("#tipoCasoFrmAsignarInvestigacion option:selected").val()=="12"){
			formDestino='class/consultasManejoCasoValidaciones.php';
		}else{
			formDestino='class/consultasManejoCasoSOAT.php';
		}

		$.ajax({
			type: 'POST',
			url: formDestino,
			data: formAsignarInvestigacion,
			cache: false,
			contentType: false,
			processData: false,
			success: function(data) {
				var arrayDatos = jQuery.parseJSON(data);
				var mensaje="";
				if (arrayDatos.respuesta=="1"){
					limpiaForm("#frmAsignarInvestigacion");
					$("#cartaPresentacionFile").val("");
					$("#soporteFile").val("");
					$("#tipoCasoFrmAsignarInvestigacion").val('0').trigger('change');
					mensaje+="Proceso Ejecutado Satisfactoriamente. Codigo caso: "+arrayDatos.codigo+"<br>";
				}
				else if (arrayDatos.respuesta=="2")	{
					mensaje+="Error al Crear Caso<br>";
				}
				if (arrayDatos.respuesta_cargar_soporte=="1"){
					$("#soporteFile").val("");
					mensaje+="Archivo de Soporte Cargado Satisfactoriamente<br>";
				}
				else if (arrayDatos.respuesta_cargar_soporte=="2"){
					mensaje+="Error al Cargar Archivo Soporte<br>";
				}	

				if (arrayDatos.respuesta_cargar_carta=="1")	{
					$("#cartaPresentacionFile").val("");
					mensaje+="Archivo de Carta de Presentacion Cargado Satisfactoriamente<br>";
				}
				else if (arrayDatos.respuesta_cargar_carta=="2"){
					$("#cartaPresentacionFile").val("");
					mensaje+="Error al Cargar Archivo Carta de Presentacion <br>";
				}

				if (arrayDatos.respuesta_envio_correo=="1")	{
					$("#cartaPresentacionFile").val("");
					mensaje+="Correo de Notificacion Enviado Satisfactoriamente<br>";

				}
				else if (arrayDatos.respuesta_envio_correo=="2"){
					mensaje+="Error al Enviar Correo de Notificacion<br>";
				}	

				$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
				$("#ContenidoErrorNonActualizable").html(mensaje);
				$('#ErroresNonActualizable').modal('show');
				$('#modalFrmAsignarInvestigacion').modal('hide');
				loadingSiglo('hide');

				return false;
			},error: function(data){
				loadingSiglo('hide');
			}
		});
	}
});

$('#btnCrearAmpliacionInvestigacion').click(function(e){

	var val1=1; var val2=1; var val3=1; var val4=1;var val5=1;
	var mensaje=""; 

	if ($('#investigadorFrmAmpliarInvestigacion option:selected').val()==""){
		val5=2;
		mensaje+="Debe Ingresar Investigador<br>";
	}
	else{
		val5=1;
	}

	if ($('#identificadorFrmAmpliarInvestigacion').val()==""){
		val1=2;
		mensaje+="Debe Ingresar Identificador<br>";
	}
	else{
		val1=1;
	}

	if ($('#fechaInicioFrmAmpliarInvestigacion').val()==""){
		val2=2;
		mensaje+="Debe Ingresar Fecha Inicio<br>";
	}
	else{
		val2=1;
	}

	if ($('#fechaEntregaFrmAmpliarInvestigacion').val()==""){
		val3=2;
		mensaje+="Debe Ingresar Fecha Final<br>";
	}
	else{
		val3=1;
	}

	if ($('#motivoInvestigacionFrmAmpliarInvestigacion').val()==""){
		val4=2;
		mensaje+="Debe Ingresar Motivo Ampliacion<br>";
	}
	else{
		val4=1;
	}

	if (val1==2 || val2==2 || val3==2 || val4==2)
	{
		$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
		$("#ContenidoErrorNonActualizable").html(mensaje);
		$('#ErroresNonActualizable').modal('show');

	}
	else{
		loadingSiglo('show', 'Creando Ampliación...');
		var form = "exe=crearAmpliacionInvestigacionSOAT"
		+"&identificadorFrmAmpliarInvestigacion="+$('#identificadorFrmAmpliarInvestigacion').val()
		+"&fechaInicioFrmAmpliarInvestigacion="+$('#fechaInicioFrmAmpliarInvestigacion').val()
		+"&fechaEntregaFrmAmpliarInvestigacion="+$('#fechaEntregaFrmAmpliarInvestigacion').val()
		+"&motivoInvestigacionFrmAmpliarInvestigacion="+$('#motivoInvestigacionFrmAmpliarInvestigacion').val()
		+"&idUsuario="+$('#btnLogout').attr('name')
		+"&investigadorFrmAmpliarInvestigacion="+$('#investigadorFrmAmpliarInvestigacion option:selected').val()
		+"&idCasoFrmAmpliarInvestigacion="+$('#idCasoFrmAmpliarInvestigacion').val();

		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoCasoSOAT.php',
			data: form,
			success: function(data) {
				loadingSiglo('hide', '');
				if (data==1) {
					$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente.");	
					limpiaForm("#frmAmpliarInvestigacion");					
					$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
					$('#FrmPolizas').modal('hide');
					$('#ErroresNonActualizable').modal('show');
					$('#modalAmpliacionCasoSOAT').modal('hide');
					
				}
				else if(data==2){
					$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});				
					$("#ContenidoErrorNonActualizable").html("Error al actualizar Caso");
					$('#ErroresNonActualizable').modal('show');
				}
				else{
					alert("error");
				}
			}, error: function(data) {
				loadingSiglo('hide', '');
			}
		});
	}
});

$('#BtnGuardarRepresentanteLegalFrm').click(function(e) {
	loadingSiglo('show','Guardando Representante...');

	var val1=1; var val2=1; var val3=1; var val4=1; var val5=1; 
	var mensaje=""; 

	if ($('#nombresRepresentanteLegalFrm').val()==""){
		val1=2;
		mensaje+="Debe Ingresar Nombres Representante Legal<br>";
	}else{
		val1=1;
	}

	if ($('#apellidosRepresentanteLegalFrm').val()==""){
		val2=2;
		mensaje+="Debe Ingresar Apellidos Representante Legal<br>";
	}else{
		val2=1;
	}

	if ($('#identificacionRepresentanteLegalFrm').val()==""){
		val3=2;
		mensaje+="Debe Ingresar Identificacion de Representante Legal<br>";
	}else{
		val3=1;
	}

	if ($('#tipoIdentificacionRepresentanteLegalFrm option:selected').val()=="" || $('#tipoIdentificacionRepresentanteLegalFrm option:selected').val()==0){
		val4=2;
		mensaje+="Debe Ingresar Tipo de Identificacion de Representante Legal<br>";
	}else{
		val4=1;
	}

	if ($('#correoRepresentanteLegalFrm').val()==""){
		val5=2;
		mensaje+="Debe Ingresar Correo Electronico de Representante Legal<br>";
	}else{
		val5=1;
	}

	if (val1==2 || val2==2 || val3==2 || val4==2 || val5==2){
		$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
		$("#ContenidoErrorNonActualizable").html(mensaje);
		$('#ErroresNonActualizable').modal('show');
		loadingSiglo('hide');
	}else{
		var form = "exe=modificarRepresentanteLegal"
		+"&tipoIdentificacionRepresentanteLegalFrm="+$('#tipoIdentificacionRepresentanteLegalFrm option:selected').val()
		+"&identificacionRepresentanteLegalFrm="+$('#identificacionRepresentanteLegalFrm').val()
		+"&apellidosRepresentanteLegalFrm="+$('#apellidosRepresentanteLegalFrm').val()
		+"&nombresRepresentanteLegalFrm="+$('#nombresRepresentanteLegalFrm').val()
		+"&correoRepresentanteLegalFrm="+$('#correoRepresentanteLegalFrm').val()
		+"&idInvestigacionFrmRepresentanteLegal="+$('#idInvestigacionFrmRepresentanteLegal').val();

		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoCasoValidaciones.php',
			data: form,
			success: function(data) {
				if (data==1) {
					$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente.");							
					$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
					$('#FrmPolizas').modal('hide');
					$('#ErroresNonActualizable').modal('show');
				}
				else if(data==2){
					$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});				
					$("#ContenidoErrorNonActualizable").html("Error al actualizar Caso");
					$('#ErroresNonActualizable').modal('show');
				}
				else{
					alert("error");
				}
				loadingSiglo('hide');
			},error: function(data){
				loadingSiglo('hide');
			}
		});
	}
});
///FALTA
$("#DivTablas23").on('click','a',function(){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');
	if (action=="btnEditarAsignacionCasoValidacion"){
		limpiaForm("#frmAsignarInvestigacion");
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoUsuarios.php',
			data:  "exe=consultarUsuario&registroUsuario="+$('#btnLogout').attr('name'),	
			success: function(data) {		
				var json_obj = $.parseJSON(data);
				
				if (jQuery.isEmptyObject(json_obj)) {
					$("#ContenidoErrorNonActualizable").html("error al consultar");
					$('#ErroresNonActualizable').modal('show');
				} 
				else {
					$('#idAseguradoraFrmAsignarInvestigacion').val(json_obj.id_aseguradora);
					mostrarTipoCasosAseguradora(json_obj.id_aseguradora,"#tipoCasoFrmAsignarInvestigacion","Asignado");
				}					
				return false;
			}
		});

		$('#tipoCasoFrmAsignarInvestigacion').attr("disabled",false);

		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoCasoSOAT.php',
			data:  "exe=consultarInformacionAsignacion&idInvestigacion="+opcion,	
			success: function(data) {		
				var json_obj = $.parseJSON(data);
				if (jQuery.isEmptyObject(json_obj)) {
					$("#ContenidoErrorNonActualizable").html("error al consultar");
					$('#ErroresNonActualizable').modal('show');
				} 
				else {
					destruirDaterangepicker('#fechaEntregaFrmAsignarInvestigacion');
					$('#fechaEntregaFrmAsignarInvestigacion').val(json_obj.fecha_entrega);
					convertirDaterangepicker('#fechaEntregaFrmAsignarInvestigacion');
					$('#tipoCasoFrmAsignarInvestigacion').val(json_obj.tipo_caso).change();
					$('#motivoInvestigacionFrmAsignarInvestigacion').val(json_obj.motivo_investigacion);
				}					
				return false;
			}
		});
		$('#tipoCasoFrmAsignarInvestigacion').attr("disabled",true);
		$('#idCasoFrmAsignarInvestigacion').val(opcion);
		$('#exeFrmAsignarInvestigacion').val("modificarAsignacionInvestigacion");
		$('#modalFrmAsignarInvestigacion').modal("show");
	}
	else if (action=="btnEditarCasoValidacion"){

		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoCasoValidaciones.php',
			data: "exe=consultarCasoValidaciones&idCaso="+opcion,
			success: function(data) {
				var json_obj = $.parseJSON(data);
				$("#aseguradoraFrmCasosValidaciones").val(json_obj.id_aseguradora).change();
				$("#ciudadEntidadFrmCasosValidaciones").val(json_obj.ciudad_entidad).change();
				$("#nombreEntidadFrmCasosValidaciones").val(json_obj.nombre_entidad);
				$("#identificacionEntidadFrmCasosValidaciones").val(json_obj.identificacion_entidad);
				$("#digVerEntidadFrmCasosValidaciones").val(json_obj.digver_entidad);
				destruirDaterangepicker('#fechaMatriculaFrmCasosValidaciones');
				$("#fechaMatriculaFrmCasosValidaciones").val(json_obj.fecha_matricula);
				convertirDaterangepicker('#fechaMatriculaFrmCasosValidaciones');
				$("#direccionEntidadFrmCasosValidaciones").val(json_obj.direccion);
				$("#telefonoEntidadFrmCasosValidaciones").val(json_obj.telefono);
				$("#investigadorFrmCasosValidaciones").val(json_obj.id_investigador).change();
				$("#actividadEconomicaFrmCasosValidaciones").val(json_obj.actividad_economica);
				$("#idCasoFrmCasosValidaciones").val(json_obj.id_investigacion);
				$("#exeFrmCasosValidaciones").val("modificarCasoValidaciones");

				tablaIndicativosAseguradoraValidaciones();
				$('#modalFrmCasosValidaciones').modal("show");
			}
		});
	}
	else if (action=="btnEliminarCasoValidacion"){
		ModalRegistrosOut("Eliminar",opcion,"tablaGestionCasosValidacionesIPS","eliminarCasoValidacion");
	}
	else if (action=="btnAsignarAnalistaCasoValidacion"){
		consultarAsignarAnalista(opcion);
	}
	else if (action=="btnGestionarCasoValidacion"){	
		gestionarInvestigacion(opcion);
	}else if (action=="btnAsignarInvestigadorCuentaCobroValidacion"){
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoCasoSOAT.php',
			data: "exe=consultarInformacionAsignarInvestigadorCuentaCobro&idCaso="+opcion,
			success: function(data) {
				var json_obj = $.parseJSON(data);
				
				
				if (json_obj.resultado==1)
				{
					$('#formSeleccionarInvestigadorCuentaCobro').show();	
					$('#divButtonAsignarInvestigadorCuentaCobro').show();

				}else if (json_obj.resultado==2){
					$('#formSeleccionarInvestigadorCuentaCobro').hide();
					$('#divButtonAsignarInvestigadorCuentaCobro').hide();	

				}
				$('#investigadorAsignarInvestigadorCuentaCobroFrm').val(json_obj.id_investigador).change();
				$('#periodoAsignarInvestigadorCuentaCobroFrm').val(json_obj.id_periodo).change();
				$('#resultadoAsignarInvestigadorCuentaCobroFrm').val(json_obj.id_resultado).change();
				$('#tipoAuditoriaAsignarInvestigadorCuentaCobroFrm').val(json_obj.id_tipo_auditoria).change();
				$('#tipoZonaAsignarInvestigadorCuentaCobroFrm').val(json_obj.tipo_zona).change();
				$('#tipoCasoAsignarInvestigadorCuentaCobroFrm').val(json_obj.tipo_caso).change();


				$('#idCasoSoatInvestigadorCuentaCobro').val(opcion);
				$('#resultadoAsignacionInvestigadorCuentaCobro').html(json_obj.descripcion_resultado);
				$('#modalAsignarInvestigadorCuentaCobro').modal("show");			
			}
		});		
	}
});

$("#DivTablas25").on('click','a',function(){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');

	if (action=="btnEliminarTestigoInformeInvestigacion"){
		ModalRegistrosOut("Eliminar",opcion,"tablaGestionTestigos","eliminarTestigoInformeInvestigacion");
	}
});

$('#btnGuardarDiligenciaFormato').click(function(e){
	loadingSiglo('show','Guardando Digiligenciador...');
	var formDiligenciaFormato="";
	if ($("#personaDiligenciaFormatoFrm option:selected").val()==2)	{
		formDiligenciaFormato="nombreAcompanante="+$("#nombreAcompananteDiligenciFormatoFrm").val()
		+"&tipoIdentificacionAcompanante="+$("#tipoIdentificacionAcompananteDiligenciFormatoFrm option:selected").val()
		+"&identificacionAcompanante="+$("#identificacionAcompananteDiligenciFormatoFrm").val()
		+"&telefonoAcompanante="+$("#telefonoAcompananteDiligenciFormatoFrm").val()
		+"&direccionAcompanante="+$("#direccionAcompananteDiligenciFormatoFrm").val()
		+"&relacionAcompanante="+$("#relacionAcompananteDiligenciFormatoFrm").val()
		+"&idUsuario="+$('#btnLogout').attr('name')
		+"&idInvestigacion="+$("#idInvestigacionFrmDiligencia").val()
		+"&opcionDiligenciaFormato="+$("#personaDiligenciaFormatoFrm option:selected").val()
		+"&fechaDiligenciaFormatoFrm="+$("#fechaDiligenciaFormatoFrm").val()
		+"&exe=guardarPersonaDiligenciaFormato";
	}
	else if ($("#personaDiligenciaFormatoFrm option:selected").val()==3){
		formDiligenciaFormato="idInvestigacion="+$("#idInvestigacionFrmDiligencia").val()
		+"&opcionDiligenciaFormato="+$("#personaDiligenciaFormatoFrm option:selected").val()
		+"&fechaDiligenciaFormatoFrm="+$("#fechaDiligenciaFormatoFrm").val()
		+"&exe=seleccionarInvestigadorDiligenciaFormato";
	}
	else if ($("#personaDiligenciaFormatoFrm option:selected").val()==4 || $("#personaDiligenciaFormatoFrm option:selected").val()==5){
		formDiligenciaFormato="idInvestigacion="+$("#idInvestigacionFrmDiligencia").val()
		+"&opcionDiligenciaFormato="+$("#personaDiligenciaFormatoFrm option:selected").val()
		+"&observacionDiligenciaFormato="+$("#observacionDiligenciaFormato").val()
		+"&fechaDiligenciaFormatoFrm="+$("#fechaDiligenciaFormatoFrm").val()
		+"&exe=guardarObservacionesDiligenciaFormato";
	}

	$.ajax({

		type: 'POST',
		url: 'class/consultasManejoCasoSOAT.php',
		data: formDiligenciaFormato,
		success: function(data) {
			if (data==1){
				$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente.");							
				$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
				$('#ErroresNonActualizable').modal('show');	
			}
			else{
				$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});				
				$("#ContenidoErrorNonActualizable").html("No Se ha Podido Seleccionar");
				$('#ErroresNonActualizable').modal('show');
			}
			loadingSiglo('hide');
		},error:function(data){
			loadingSiglo('hide');
		}
	});
});

$("#DivTablas26").on('click','a',function(){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');

	if (action=="btnSeleecionarLesionadoDiligencia"){
		loadingSiglo('show','Seleccionando Lesionado...');
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoCasoSOAT.php',
			data: "exe=seleccionarLesionadoDiligenciaFormato&idLesionado="+opcion+"&idInvestigacion="+$("#idInvestigacionFrmDiligencia").val()+"&fechaDiligenciaFormatoFrm="+$("#fechaDiligenciaFormatoFrm").val(),
			success: function(data) {
				if (data==1){	
					$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente.");							
					$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
					loadingSiglo('hide');
					llenarTablaGestionLesionadosDiligencia();
				}else{
					$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});				
					$("#ContenidoErrorNonActualizable").html("No Se ha Podido Seleccionar");
					$('#ErroresNonActualizable').modal('show');
					loadingSiglo('hide');
				}
			},error:function(data){
				loadingSiglo('hide');
			}
		});
	}
});

$("#DivTablas24").on('click','a',function(){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');

	if (action=="btnEditarObservacionInformeInvestigacion")	{
		loadingSiglo('show', 'Cargando Observación...');
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoCasoSOAT.php',
			data: "exe=consultarObservaciones&idObservacionInforme="+opcion,
			success: function(data) {
				var json_obj = $.parseJSON(data);

				$("#seccionInformeFrmObservaciones").val(json_obj.id_seccion).change();
				$("#observacionesFrmObservaciones").val(json_obj.observacion);

				$("#idInvestigacionFrmObservaciones").val(json_obj.id_investigacion);
				$("#idObservacionInforme").val(json_obj.id_observacion);
				$("#exeObservaciones").val("modificarObservaciones");

				$('#FrmObservacionesInforme').modal("show");
				loadingSiglo('hide');
				tablaIndicativosAseguradoraValidaciones();
			}, error: function (data){
				loadingSiglo('hide');
			}
		});
	}
	else if (action=="btnEliminarObservacionInformeInvestigacion"){
		ModalRegistrosOut("Eliminar",opcion,"tablaGestionObservaciones","eliminarObservacionInformeInvestigacion");
	}
});

function consultarAsignarAnalista(idCaso){
	loadingSiglo('show','Cargando Analista..');
	$.ajax({
		type: 'POST',
		url: 'class/consultasManejoCasoSOAT.php',
		data: "exe=consultarCasoSOAT&idCaso="+idCaso,
		success: function(data) {
			var json_obj = $.parseJSON(data);

			$("#analistaAsignarAnalista").val(json_obj.id_usuario).change();
			$("#idCasoSoatAnalista").val(idCaso);
			$('#modalAsignarAnalista').modal('show');
			loadingSiglo('hide');
		},
		error: function(data){
			loadingSiglo('hide');
		}
	});
}

function gestionarInvestigacion(idCaso){
	$("#fileInformeFinal").attr('name',idCaso);	

	cargarOpcionesInformeFinal(idCaso);

	loadingSiglo('show','Cargando Gestión...');

	$("#btnModuloGestionarRepresentanteLegal").attr('name',idCaso);
	$("#btnModuloGestionarLesionados").attr('name',idCaso);
	$("#btnModuloGestionarVehiculo").attr('name',idCaso);
	$("#btnModuloGestionarInforme").attr('name',idCaso);
	$("#btnModuloGestionarTomador").attr('name',idCaso);
	$("#btnModuloGestionarPersonas").attr('name',idCaso);
	$("#btnModuloGestionarTestigos").attr('name',idCaso);
	$("#btnModuloGestionarObservaciones").attr('name',idCaso);
	$("#btnModuloGestionarMultimedia").attr('name',idCaso);
	$("#btnModuloGestionarInformeMuerte").attr('name',idCaso);
	$("#btnDescargarInformeWord").attr('name',idCaso);
	$("#liTerminarPlanillarCaso").attr('name',idCaso);
	$("#btnModuloGestionarDiligenciaFormato").attr('name',idCaso);
	$("#liEstadosInvestigacion").attr('name',idCaso);
	$("#btnDescargarInformeWord").attr('idAseguradora',0);

	$.ajax({
		type: 'POST',
		url: 'class/consultasManejoCasoSOAT.php',
		data: "exe=consultarCasoSOAT&idCaso="+idCaso,
		success: function(data) {	
			if(data != ''){
				var json_obj = $.parseJSON(data);
				if (json_obj.tipo_caso_informe==1){
					$("#btnDescargarInformeWord").attr('idAseguradora',json_obj.id_aseguradora);
					$("#liModuloGestionarPersonas").hide();
					$("#liModuloGestionarLesionados").show();
					$("#liModuloGestionarVehiculo").show();
					$("#liModuloGestionarInforme").show();
					$("#liModuloGestionarInformeMuerte").hide();
					$("#liModuloGestionarTomador").show();
					$("#liModuloGestionarTestigos").show();
					$("#liModuloGestionarLesionados").show();
					$("#liModuloGestionarObservaciones").show();
					$("#liModuloGestionarMultimedia").show();
					$("#liModuloGestionarDiligenciaFormato").show();
					$("#liModuloGestionarRepresentanteLegal").hide();
					$("#liDescargarInformeWord").show();
					$("#liTerminarPlanillarCaso").show();
					$("#liEstadosInvestigacion").show();
				}
				else if (json_obj.tipo_caso_informe==2){
					$("#liModuloGestionarPersonas").show();
					$("#liModuloGestionarLesionados").hide();
					$("#liModuloGestionarVehiculo").show();
					$("#liModuloGestionarInforme").hide();
					$("#liModuloGestionarInformeMuerte").show();
					$("#liModuloGestionarTomador").hide();
					$("#liModuloGestionarTestigos").hide();
					$("#liModuloGestionarLesionados").hide();
					$("#liModuloGestionarObservaciones").hide();
					$("#liModuloGestionarMultimedia").hide();
					$("#btnModuloGestionarObservaciones").hide();
					$("#liModuloGestionarDiligenciaFormato").hide();
					$("#liModuloGestionarRepresentanteLegal").hide();
					$("#liDescargarInformeWord").hide();
					$("#liTerminarPlanillarCaso").show();
					$("#liEstadosInvestigacion").show();
				}
				else if(json_obj.tipo_caso_informe==3){
					$("#liModuloGestionarPersonas").hide();
					$("#liModuloGestionarLesionados").hide();
					$("#liModuloGestionarVehiculo").hide();
					$("#liModuloGestionarInforme").hide();
					$("#liModuloGestionarInformeMuerte").hide();
					$("#liModuloGestionarTomador").hide();
					$("#liModuloGestionarTestigos").hide();
					$("#liModuloGestionarLesionados").hide();
					$("#liModuloGestionarObservaciones").hide();
					$("#liModuloGestionarMultimedia").hide();
					$("#liModuloGestionarObservaciones").hide();
					$("#liModuloGestionarDiligenciaFormato").hide();
					$("#liModuloGestionarRepresentanteLegal").show();
					$("#liDescargarInformeWord").hide();
					$("#liTerminarPlanillarCaso").show();
					$("#liEstadosInvestigacion").show();
				}

				if(json_obj.placa_temp != null){
					$("#placa_temp_asig").html("/ PLACA: "+json_obj.placa_temp);
				}else{
					$("#placa_temp_asig").html("");
				}

				loadingSiglo('hide');

				$("#modalModuloInforme").find(".tab-pane").hide();

				$('#modalModuloInforme').modal('show');
			}else{
				loadingSiglo('hide');

				alert("Upss! Algo ocurrió")
			}
		}, error: function(data){
			loadingSiglo('hide');
			alert('Error');
		}
	});
}

$('#btnSubmitFrmCasosValidaciones').click(function(e){

	loadingSiglo('show','Guardando..');

	var val1=1; var val2=1; var val3=1; var val4=1; var val5=1; var val6=1; var val7=1; var val8=1; 
	var val9=1; var val10=1; 
	var mensaje=""; 

	if ($('#aseguradoraFrmCasosValidaciones option:selected').val()==0 || $('#aseguradoraFrmCasosValidaciones option:selected').val()==""){
		val1=2;
		mensaje+="Debe Seleccionar Una Aseguradora<br>";
	}else{
		val1=1;
	}

	if (($('#ciudadEntidadFrmCasosValidaciones option:selected').val()==0 || $('#ciudadEntidadFrmCasosValidaciones option:selected').val()=="") && $('#exeFrmCasosGM').val()=="registrarCasoSOAT"){
		val2=2;
		mensaje+="Debe Seleccionar Ciudad<br>";
	}else{
		val2=1;
	}

	if ($('#nombreEntidadFrmCasosValidaciones').val()==""){
		val3=2;
		mensaje+="Debe Ingresar Nombre Entidad<br>";
	}else{
		val3=1;
	}

	if ($('#identificacionEntidadFrmCasosValidaciones').val()==""){
		val4=2;
		mensaje+="Debe Ingresar Identificacion Entidad<br>";
	}else{
		val4=1;
	}

	if ($('#digVerEntidadFrmCasosValidaciones').val()==""){
		val5=2;
		mensaje+="Debe Ingresar Digito Verificacion<br>";
	}else{
		val5=1;
	}

	if ($('#fechaMatriculaFrmCasosValidaciones').val()==""){
		val6=2;
		mensaje+="Debe Ingresar Fecha Matricula<br>";
	}else{
		val6=1;
	}

	if ($('#direccionEntidadFrmCasosValidaciones').val()==""){
		val7=2;
		mensaje+="Debe Ingresar Direccion Entidad<br>";
	}else{
		val7=1;
	}

	if ($('#telefonoEntidadFrmCasosValidaciones').val()==""){
		val8=2;
		mensaje+="Debe Ingresar Telefono Entidad<br>";
	}else{
		val8=1;
	}

	if ($('#actividadEconomicaFrmCasosValidaciones').val()==""){
		val9=2;
		mensaje+="Debe Ingresar Actividad Ecomica<br>";
	}else{
		val9=1;
	}

	if ($('#investigadorFrmCasosValidaciones option:selected').val()==0 || $('#investigadorFrmCasosValidaciones option:selected').val()==""){
		val10=2;
		mensaje+="Debe Seleccionar Un Investigador<br>";
	}else{
		val10=1;
	}

	if (val1==2 || val2==2 || val3==2 || val4==2 || val5==2 || val6==2 || val7==2 || val8==2 || val9==2 || val10==2){
		$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
		$("#ContenidoErrorNonActualizable").html(mensaje);
		$('#ErroresNonActualizable').modal('show');
		loadingSiglo('hide');
	}
	else{
		var identificadoresCasoSOAT=[];

		$('#tablaIndicativosAseguradoraFrmCasosValidaciones').DataTable().rows().every(function(){
			var data=this.data();
			var data2={};									
			data2.identificador=data["indicativoCasosSOAT"];
			data2.fecha_asignacion=data["fechaInicioCasosSOAT"];
			data2.fecha_entrega=data["fechaEntregaCasosSOAT"];
			identificadoresCasoSOAT.push(data2);
		});

		var form = "exe="+$('#exeFrmCasosValidaciones').val()
		+"&aseguradoraFrmCasosValidaciones="+$('#aseguradoraFrmCasosValidaciones option:selected').val()
		+"&ciudadEntidadFrmCasosValidaciones="+$('#ciudadEntidadFrmCasosValidaciones option:selected').val()
		+"&nombreEntidadFrmCasosValidaciones="+$('#nombreEntidadFrmCasosValidaciones').val()
		+"&identificacionEntidadFrmCasosValidaciones="+$('#identificacionEntidadFrmCasosValidaciones').val()
		+"&digVerEntidadFrmCasosValidaciones="+$('#digVerEntidadFrmCasosValidaciones').val()
		+"&fechaMatriculaFrmCasosValidaciones="+$('#fechaMatriculaFrmCasosValidaciones').val()
		+"&direccionEntidadFrmCasosValidaciones="+$('#direccionEntidadFrmCasosValidaciones').val()
		+"&telefonoEntidadFrmCasosValidaciones="+$('#telefonoEntidadFrmCasosValidaciones').val()
		+"&investigadorFrmCasosValidaciones="+$('#investigadorFrmCasosValidaciones option:selected').val()
		+"&actividadEconomicaFrmCasosValidaciones="+$('#actividadEconomicaFrmCasosValidaciones').val()
		+"&idCasoFrmCasosValidaciones="+$('#idCasoFrmCasosValidaciones').val()
		+"&usuario="+$('#btnLogout').attr('name')
		+"&idCaso="+$('#idCasoFrmCasosValidaciones').val()
		+"&identificadoresCaso="+JSON.stringify(identificadoresCasoSOAT);


		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoCasoValidaciones.php',
			data: form,
			success: function(data) {
				if(data != ''){
					var json_obj = $.parseJSON(data);
					if (json_obj.respuesta==1) {
						$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente. Codigo caso: "+json_obj.codigo);							
						$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
						$('#modalFrmCasosGM').modal('hide');
						$('#ErroresNonActualizable').modal('show');
						loadingSiglo('hide');
						gestionarInvestigacion(json_obj.caso);
					}
					else if(json_obj.respuesta==3){
						$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente.");							
						$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
						$('#modalFrmCasosGM').modal('hide');
						$('#ErroresNonActualizable').modal('show');
						loadingSiglo('hide');
						gestionarInvestigacion(json_obj.caso);
					}
					else if (json_obj.respuesta==2) {
						$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente.");							
						$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
						$('#modalFrmCasosGM').modal('hide');
						$('#ErroresNonActualizable').modal('show');
						loadingSiglo('hide');
					}
				}else {
					alert("Upss! Algo salio Mal.");
					loadingSiglo('hide');
				}
			}, error: function(data){
				loadingSiglo('hide');
			}
		});
	}
});

$('#BtnGuardarMultimediaInvestigacionFrm').click(function(e){
	
	loadingSiglo('show', 'Guardando Multimedia');

	var val1=1; var val2=1;
	var mensaje=""; 

	if ($('#seccionMultimediaFrmMultimedia option:selected').val()==0 || $('#seccionMultimediaFrmMultimedia option:selected').val()==""){
		val1=2;
		mensaje+="Debe Seleccionar Una Seccion<br>";
	}else{
		val1=1;
	}

	if (($('#img1FrmMultimedia').val()=="" && $('#img2FrmMultimedia').val()=="")){
		val2=2;
		mensaje+="Debe Seleccionar Un Archivo<br>";
	}else{
		val2=1;	
	}

	/*if ($('#img1FrmMultimedia').val()!=""){

		var imgsize = $("#img1FrmMultimedia").prop("files")[0].size;

		if(imgsize > 2000000){
			val2=2;
			mensaje+="El archivo 1 supera los 2Mb.<br>";
		}
	}

	if ($('#img2FrmMultimedia').val()!=""){

		var imgsize = $("#img2FrmMultimedia").prop("files")[0].size;

		if(imgsize > 2000000){
			val2=2;
			mensaje+="El archivo 1 supera los 2Mb.<br>";
		}
	}*/

	if (val1==2 || val2==2)	{
		$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
		$("#ContenidoErrorNonActualizable").html(mensaje);
		$('#ErroresNonActualizable').modal('show');
		loadingSiglo('hide');
	}
	else{
		var formArchivoMultimedia = new FormData();
		formArchivoMultimedia.append("exe","subirArchivoMultimediaInvestigacion");
		formArchivoMultimedia.append("idInvestigacion",$("#idInvestigacionFrmMultimedia").val());
		formArchivoMultimedia.append("idUsuario",$('#btnLogout').attr('name'));
		formArchivoMultimedia.append("seccionMultimediaFrmMultimedia",$('#seccionMultimediaFrmMultimedia option:selected').val());
		
		if ($('#img1FrmMultimedia').val()!=""){
			formArchivoMultimedia.append("archivoMultimedia1",$("#img1FrmMultimedia").prop("files")[0]);
		}

		if ($('#img2FrmMultimedia').val()!=""){
			formArchivoMultimedia.append("archivoMultimedia2",$("#img2FrmMultimedia").prop("files")[0]);
		}

		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoCasoSOAT.php',
			data: formArchivoMultimedia,
			cache: false,
			contentType: false,
			processData: false,
			success: function(data) {
				var arrayDatos = jQuery.parseJSON(data);
				var mensaje="";
				if (arrayDatos.resultado1=="1"){
					$("#img1FrmMultimedia").val("");
					mensaje+="Imagen Numero 1 Cargada Satisfactoriamente<br>";
					loadingSiglo('hide');
					llenarTablaGestionMultimediaInvestigacion();
				}
				else if (arrayDatos.resultado1=="2"){
					mensaje+="Error al Crear Registro Numero 1 en BD<br>";
					loadingSiglo('hide');
				}
				else if (arrayDatos.resultado1=="3"){
					mensaje+="Imagen Numero 1 No Copiada<br>";
					loadingSiglo('hide');
				}
				else if (arrayDatos.resultado1=="4"){
					mensaje+="Tipo de Extencion de Imagen Numero 1, no permitido<br>";
					loadingSiglo('hide');
				}
				else if (arrayDatos.resultado1=="6"){
					mensaje+="No puede subir mas archivos para esta seccion<br>";
					loadingSiglo('hide');
				}
				else if (arrayDatos.resultado1=="7"){
					mensaje+="Audio Cargado Satisfactoriamente<br>";
					loadingSiglo('hide');
				}

				if (arrayDatos.resultado2=="1"){
					$("#img2FrmMultimedia").val("");
					mensaje+="Imagen Numero 2 Cargada Satisfactoriamente<br>";
					loadingSiglo('hide');
					llenarTablaGestionMultimediaInvestigacion();
				}
				else if (arrayDatos.resultado2=="2"){
					mensaje+="Error al Crear Registro Numero 2 en BD<br>";
					loadingSiglo('hide');
				}			
				else if (arrayDatos.resultado2=="3"){
					mensaje+="Imagen Numero 1 No Copiada<br>";
					loadingSiglo('hide');
				}		
				else if (arrayDatos.resultado2=="4"){
					mensaje+="Tipo de Extencion de Imagen Numero 2, no permitido<br>";
					loadingSiglo('hide');
				}
				else if (arrayDatos.resultado2=="5"){
					mensaje+="Solo se cargara primer archivo<br>";
					loadingSiglo('hide');
				}	

				if (
					(arrayDatos.resultado1=="1" && arrayDatos.resultado2=="1") || 
					(arrayDatos.resultado1=="5" && arrayDatos.resultado2=="1") || 
					(arrayDatos.resultado1=="1" && arrayDatos.resultado2=="5") || 
					(arrayDatos.resultado1=="5" && arrayDatos.resultado2=="5") 
					){

					$("#seccionMultimediaFrmMultimedia").val('0').trigger('change');
					loadingSiglo('hide');
				}


				$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
				$("#ContenidoErrorNonActualizable").html(mensaje);
				$('#ErroresNonActualizable').modal('show');
				return false;
			},error: function(data){
				loadingSiglo('hide');
			}
		});
	}
});

$("#contactoTomadorInformeFrm").change(function() {			
	if ($("#contactoTomadorInformeFrm option:selected").val()=="4")	{
		$("#divObservacionContactoTomador").show();			
	}
	else {
		$("#divObservacionContactoTomador").hide();
	}
});

$("#personaDiligenciaFormatoFrm").change(function() {			
	if ($("#personaDiligenciaFormatoFrm option:selected").val()=="1"){
		$("#divLesionadosInvestigacion").show();			
		$("#divAcompananteDiligenciaInvestigacion").hide();	
		$("#divObservacionDiligenciaInvestigacion").hide();	
		$("#divBtnDiligenciaFormato").hide();		
	}
	else if ($("#personaDiligenciaFormatoFrm option:selected").val()=="2")	{
		$("#divLesionadosInvestigacion").hide();			
		$("#divAcompananteDiligenciaInvestigacion").show();			
		$("#divObservacionDiligenciaInvestigacion").hide();	
		$("#divBtnDiligenciaFormato").show();			
	}
	else if ($("#personaDiligenciaFormatoFrm option:selected").val()=="3")	{
		$("#divLesionadosInvestigacion").hide();			
		$("#divAcompananteDiligenciaInvestigacion").hide();			
		$("#divObservacionDiligenciaInvestigacion").hide();	
		$("#divBtnDiligenciaFormato").show();			
	}
	else if ($("#personaDiligenciaFormatoFrm option:selected").val()=="4" || $("#personaDiligenciaFormatoFrm option:selected").val()=="5"){
		$("#divLesionadosInvestigacion").hide();			
		$("#divAcompananteDiligenciaInvestigacion").hide();			
		$("#divObservacionDiligenciaInvestigacion").show();	
		$("#divBtnDiligenciaFormato").show();			
	}
});

$("#tipoCasoFrmAsignarInvestigacion").change(function() {			
	if ($("#tipoCasoFrmAsignarInvestigacion option:selected").val()=="12"){
		$("#asignacionValidacionIPS").show();			
	}
	else {
		$("#asignacionValidacionIPS").hide();
	}
});

$("#visitaLugarHechosInformeFrm").change(function() {			
	if ($("#visitaLugarHechosInformeFrm option:selected").val()=="S"){
		$("#divPuntoReferencia").show();			
	}
	else {
		$("#divPuntoReferencia").hide();
	}
});

$("#ConsultaRUNTInformeFrm").change(function() {
	if ($("#ConsultaRUNTInformeFrm option:selected").val()=="N"){
		$("#divCausalNoConsultaRunt").show();
	}
	else{
		$("#causalNoConsultaRUNTInformeFrm").val('0').trigger('change');
		$("#divCausalNoConsultaRunt").hide();
	}
});

$('#BtnGuardarDetalleInvestigacionMuerteFrm').click(function(e){
	loadingSiglo('show', 'Guardando Detalle Invest...');
	var val1=1; var val2=1; var val3=1; var val4=1; var val5=1; var val6=1; var val7=1; var val8=1; var val9=1; var val10=1;
	var mensaje=""; 

	if ($('#fiscaliaCasoInformeMuerteFrm').val()==""){
		val1=2;
		mensaje+="Debe Ingresar Fiscalia<br>";
	}else{
		val1=1;
	}

	if ($('#procesoFiscaliaInformeMuerteFrm').val()==""){
		val2=2;
		mensaje+="Debe Ingresar Proceso de Fiscalia<br>";
	}else{
		val2=1;
	}

	if ($('#noCroquisInformeMuerteFrm').val()==""){
		val3=2;
		mensaje+="Debe Ingresar Numero de Croquis<br>";
	}else{
		val3=1;
	}

	if ($('#siniestroInformeMuerteFrm').val()==""){
		val4=2;
		mensaje+="Debe Ingresar Numero de Siniestro<br>";
	}else{
		val4=1;
	}

	if (val1==2 || val2==2 || val3==2 || val4==2){
		$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
		$("#ContenidoErrorNonActualizable").html(mensaje);
		$('#ErroresNonActualizable').modal('show');
		loadingSiglo('hide');
	}
	else{
		var form = "exe=modificarDetalleInvestigacionMuerte"
		+"&fiscaliaCasoInformeMuerteFrm="+$('#fiscaliaCasoInformeMuerteFrm').val()
		+"&procesoFiscaliaInformeMuerteFrm="+$('#procesoFiscaliaInformeMuerteFrm').val()
		+"&noCroquisInformeMuerteFrm="+$('#noCroquisInformeMuerteFrm').val()
		+"&siniestroInformeMuerteFrm="+$('#siniestroInformeMuerteFrm').val()
		+"&hechosInformeMuerteFrm="+$('#hechosInformeMuerteFrm').val()
		+"&conclusionesInformeMuerteFrm="+$('#conclusionesInformeMuerteFrm').val()
		+"&idInvestigacionFrmInformeMuerte="+$('#idInvestigacionFrmInformeMuerte').val()
		+"&idUsuario="+$('#btnLogout').attr('name');

		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoCasoSOAT.php',
			data: form,
			success: function(data) {
				if (data==1) {
					$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente.");							
					$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
					$('#FrmPolizas').modal('hide');
					$('#ErroresNonActualizable').modal('show');
				}
				else if(data==2){
					$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});				
					$("#ContenidoErrorNonActualizable").html("Error al actualizar Caso");
					$('#ErroresNonActualizable').modal('show');
				}
				else{
					alert("error");
				}
				loadingSiglo('hide');
			}, error: function(data){
				loadingSiglo('hide');
			}
		});
	}
});

$('#BtnGuardarDetalleInvestigacionFrm').click(function(e){

	loadingSiglo('show', 'Guardando Detalle Invest...');

	var val1=1; var val2=1; var val3=1; var val4=1; var val5=1; var val6=1; var val7=1; var val8=1; var val9=1; var val10=1;var val11=1;var val12=1;
	var val13=1;var val14=1;var val15=1; var val16=1;
	var mensaje=""; 

	if (($('#versionesHechosDiferenteInformeFrm option:selected').val()==0 || $('#versionesHechosDiferenteInformeFrm option:selected').val()=="")){
		val13=2;
		mensaje+="Debe Versiones Hechos Diferentes<br>";
	}else{
		val13=1;
	}

	if ($('#cantidadOcupantesInformeFrm').val()==""){
		val14=2;
		mensaje+="Debe Ingresar Cantidad Ocupantes Vehiculo<br>";
	}else{
		val14=1;
	}

	if ($('#cantidadPersonasTrasladoInformeFrm').val()==""){
		val15=2;
		mensaje+="Debe Ingresar Cantidad Personas Traslado<br>";
	}else{
		val15=1;
	}

	if ($('#visitaLugarHechosInformeFrm option:selected').val()==0 || $('#visitaLugarHechosInformeFrm option:selected').val()==""){
		val1=2;
		mensaje+="Debe Ingresar Lugar de los Hechos<br>";

		if ($('#puntoReferenciaInformeFrm').val()==""){
			val6=2;
			mensaje+="Debe Ingresar Punto De Referencia<br>";
		}else{
			val6=1;
		}
	}else{
		val1=1;
	}

	if ($('#contactoTomadorInformeFrm option:selected').val()==0 || $('#contactoTomadorInformeFrm option:selected').val()==""){
		val11=2;
		mensaje+="Debe Seleccionar Contacto Tomador<br>";
	}else{
		if ($('#contactoTomadorInformeFrm option:selected').val()==4 && $('#observacionContactoTomadorInformeFrm').val()==""){
			val11=2;
			mensaje+="Debe Agregar Observaciones Contacto Tomador<br>";
		}else{
			val11=1;
		}
	}

	if (($('#registroAutoridadesTecnicaInformeFrm option:selected').val()==0 || $('#registroAutoridadesTecnicaInformeFrm option:selected').val()=="") && $('#exeFrmCasosGM').val()=="registrarCasoSOAT"){
		val2=2;
		mensaje+="Debe Seleccionar Registro Autoridades<br>";
	}else{
		val2=1;
	}

	if (($('#inspeccionTecnicaInformeFrm option:selected').val()==0 || $('#inspeccionTecnicaInformeFrm option:selected').val()=="") && $('#exeFrmCasosGM').val()=="registrarCasoSOAT"){
		val3=2;
		mensaje+="Debe Seleccionar Inspeccion Tomador<br>";
	}else{
		val3=1;
	}

	if (($('#ConsultaRUNTInformeFrm option:selected').val()==0 || $('#ConsultaRUNTInformeFrm option:selected').val()=="") && $('#exeFrmCasosGM').val()=="registrarCasoSOAT"){
		val4=2;
		mensaje+="Debe Seleccionar Consulta RUNT<br>";
	}
	else{

		if (($('#ConsultaRUNTInformeFrm option:selected').val()=="N")){
			if (($('#causalNoConsultaRUNTInformeFrm option:selected').val()==0 || $('#causalNoConsultaRUNTInformeFrm option:selected').val()=="") && $('#exeFrmCasosGM').val()=="registrarCasoSOAT"){
				val5=2;
				mensaje+="Debe Seleccionar Causal Consulta RUNT<br>";
			}else{
				val5=1;
			}
		}else{
			val4=1;
		}
		val4=1;
	}

	if ($('#furipsInformeFrm').val()==""){
		val7=2;
		mensaje+="Debe Ingresar FURIPS<br>";
	}else{
		val7=1;
	}

	if ($('#conclusionesInformeFrm').val()==""){
		val8=2;
		mensaje+="Debe Ingresar Conclusiones<br>";
	}else{
		val8=1;
	}

	if ($("#aConsideracion").is(":visible") == true) {
		if($("#selectAConsideracion").val().length == 0){
			val12=2;
			mensaje+="Debe Seleccionar Motivos De Consideracion<br>";
		}else{
			val12=1;
		}
	}else{
		val12=1;
	}

	if ($("#divMotivoOcurrencia").is(":visible") == true) {
		if($('#selectMotivoOcurrencia option:selected').val()==0){
			val12=2;
			mensaje+="Debe Seleccionar Un Motivo De Ocurrencia<br>";
		}else{
			val12=1;
		}
	}else{
		val16=1;
	}

	if (val1==2 || val2==2 || val3==2 || val4==2 || val5==2 || val6==2 || val7==2 || val8==2 || val11==2 || val12==2 || val13==2 || val14==2 || val15==2 || val16==2){
		$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
		$("#ContenidoErrorNonActualizable").html(mensaje);
		$('#ErroresNonActualizable').modal('show');
		loadingSiglo('hide');
	}
	else{
		var form = "exe=modificarDetalleInvestigacion"
		+"&visitaLugarHechosInformeFrm="+$('#visitaLugarHechosInformeFrm option:selected').val()
		+"&versionesHechosDiferenteInformeFrm="+$('#versionesHechosDiferenteInformeFrm option:selected').val()
		+"&cantidadOcupantesInformeFrm="+$('#cantidadOcupantesInformeFrm').val()
		+"&cantidadPersonasTrasladoInformeFrm="+$('#cantidadPersonasTrasladoInformeFrm').val()
		+"&registroAutoridadesTecnicaInformeFrm="+$('#registroAutoridadesTecnicaInformeFrm option:selected').val()
		+"&inspeccionTecnicaInformeFrm="+$('#inspeccionTecnicaInformeFrm option:selected').val()
		+"&ConsultaRUNTInformeFrm="+$('#ConsultaRUNTInformeFrm option:selected').val()
		+"&causalNoConsultaRUNTInformeFrm="+$('#causalNoConsultaRUNTInformeFrm option:selected').val()
		+"&puntoReferenciaInformeFrm="+$('#puntoReferenciaInformeFrm').val()
		+"&furipsInformeFrm="+$('#furipsInformeFrm').val()
		+"&conclusionesInformeFrm="+$('#conclusionesInformeFrm').val()
		+"&idInvestigacionFrmInforme="+$('#idInvestigacionFrmInforme').val()
		+"&contactoTomadorInformeFrm="+$('#contactoTomadorInformeFrm option:selected').val()
		+"&observacionContactoTomadorInformeFrm="+$('#observacionContactoTomadorInformeFrm').val()
		+"&idUsuario="+$('#btnLogout').attr('name');

		if ($("#aConsideracion").is(":visible")) {
			form += "&aConsideracion="+$('#selectAConsideracion').val();
		}else{
			form += "&aConsideracion=0";
		}

		if($("#divMotivoOcurrencia").is(":visible")){
			form += "&motivoOcurrencia="+$('#selectMotivoOcurrencia option:selected').val()
		}else{
			form += "&motivoOcurrencia=0";
		}

		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoCasoSOAT.php',
			data: form,
			success: function(data) {
				if (data==1) {
					$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente.");							
					$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
					$('#FrmPolizas').modal('hide');
					$('#ErroresNonActualizable').modal('show');
					loadingSiglo('hide');
					llenarTablaPolizasVehiculos();
				}
				else if(data==2){
					$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});				
					$("#ContenidoErrorNonActualizable").html("Error al crear Caso");
					$('#ErroresNonActualizable').modal('show');
					loadingSiglo('hide');
				}
				else{
					alert("error");
					loadingSiglo('hide');
				}
			}, error: function(data){
				loadingSiglo('hide');
			}, error: function(data){
				loadingSiglo('hide');
			}
		});
	}
});

$('#btnGuardarPolizas').click(function(e){

	loadingSiglo('show', 'Guardando Poliza...');

	var val1=1; var val2=1; var val3=1; var val4=1; var val5=1; var val6=1; var val7=1; var val8=1; var val9=1; var val10=1;
	var mensaje=""; 

	if ($('#tipoIdentificacionTomadorPolizaFrm option:selected').val()==0 || $('#tipoIdentificacionTomadorPolizaFrm option:selected').val()==""){
		val1=2;
		mensaje+="Debe Seleccionar Un Tipo de Identificacion Tomador<br>";
	}else{
		val1=1;
	}

	if (($('#ciudadTomadorPolizaFrm option:selected').val()==0 || $('#ciudadTomadorPolizaFrm option:selected').val()=="") && $('#exeFrmCasosGM').val()=="registrarCasoSOAT"){
		val2=2;
		mensaje+="Debe Seleccionar Ciudad Tomador<br>";
	}else{
		val2=1;
	}

	if ($('#numeroPolizaFRM').val()==""){
		val3=2;
		mensaje+="Debe Ingresar Numero Poliza<br>";
	}else{
		val3=1;
	}

	if ($('#digVerPolizaFrm').val()==""){
		val4=2;
		mensaje+="Debe Ingresar Digito Verificacion Poliza<br>";
	}else{
		val4=1;
	}

	if ($('#vigenciaPolizaFrm').val()==""){
		val5=2;
		mensaje+="Debe Ingresar Vigencia Poliza<br>";
	}else{
		val5=1;
	}

	if ($('#identificacionTomadorPolizaFrm').val()==""){
		val6=2;
		mensaje+="Debe Ingresar Identificacion Tomador<br>";
	}else{
		val6=1;
	}

	if ($('#nombreTomadorPolizaFrm').val()==""){
		val7=2;
		mensaje+="Debe Ingresar Nombre Tomador<br>";
	}else{
		val7=1;
	}

	if ($('#direccionTomadorPolizaFrm').val()==""){
		val8=2;
		mensaje+="Debe Ingresar Direccion Tomador<br>";
	}else{
		val8=1;
	}

	if ($('#telefonoTomadorPolizaFrm').val()==""){
		val9=2;
		mensaje+="Debe Ingresar Telefono Tomador<br>";
	}else{
		val9=1;
	}

	if ($('#ciudadExpedicionPolizaFrm option:selected').val()==0 || $('#ciudadExpedicionPolizaFrm option:selected').val()==""){
		val10=2;
		mensaje+="Debe Seleccionar Una Ciudad Expedicion<br>";
	}else{
		val10=1;
	}

	if (val1==2 || val2==2 || val3==2 || val4==2 || val5==2 || val6==2 || val7==2 || val8==2 || val9==2 || val10==2){
		$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
		$("#ContenidoErrorNonActualizable").html(mensaje);
		$('#ErroresNonActualizable').modal('show');
		loadingSiglo('hide');
	}
	else{
		var form = "exe="+$('#exeFrmPolizas').val()
		+"&numeroPolizaFRM="+$('#numeroPolizaFRM').val()
		+"&digVerPolizaFrm="+$('#digVerPolizaFrm').val()
		+"&vigenciaPolizaFrm="+$('#vigenciaPolizaFrm').val()
		+"&tipoIdentificacionTomadorPolizaFrm="+$('#tipoIdentificacionTomadorPolizaFrm option:selected').val()
		+"&aseguradoraPolizaFrm="+$('#aseguradoraPolizaFrm option:selected').val()
		+"&codSucursalPolizaFrm="+$('#codSucursalPolizaFrm').val()
		+"&claveProductorPolizaFrm="+$('#claveProductorPolizaFrm').val()
		+"&identificacionTomadorPolizaFrm="+$('#identificacionTomadorPolizaFrm').val()
		+"&nombreTomadorPolizaFrm="+$('#nombreTomadorPolizaFrm').val()
		+"&direccionTomadorPolizaFrm="+$('#direccionTomadorPolizaFrm').val()
		+"&telefonoTomadorPolizaFrm="+$('#telefonoTomadorPolizaFrm').val()
		+"&ciudadTomadorPolizaFrm="+$('#ciudadTomadorPolizaFrm option:selected').val()
		+"&ciudadExpedicionPolizaFrm="+$('#ciudadExpedicionPolizaFrm option:selected').val()
		+"&usuario="+$('#btnLogout').attr('name')
		+"&idPolizas="+$('#idPolizas').val()
		+"&idVehiculo="+$('#idVehiculoFrmVehiculos').val()
		+"&idInvestigacionFrmVehiculos="+$('#idInvestigacionFrmVehiculos').val();

		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoVehiculosPoliza.php',
			data: form,
			success: function(data) {
				if (data==1) {
					$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente.");							
					$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
					$('#FrmPolizas').modal('hide');
					$('#ErroresNonActualizable').modal('show');
					loadingSiglo('hide');
					llenarTablaPolizasVehiculos();
				}
				else if(data==2){
					$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});				
					$("#ContenidoErrorNonActualizable").html("Error al crear Caso");
					$('#ErroresNonActualizable').modal('show');
					loadingSiglo('hide');
				}
				else{
					alert("error");
					loadingSiglo('hide');
				}
			}, error: function(data){
				loadingSiglo('hide');
			}
		});
	}
});

$('#BtnAddVehiculoCasoFrm').click(function(e){

	var val1=1; var val2=1; var val3=1; var val4=1; var val5=1; var val6=1; var val7=1; var val8=1; var val9=1; var val10=1;
	var mensaje=""; 

	if ($('#tipoVehiculoFrmVehiculoPoliza option:selected').val()==0 || $('#tipoVehiculoFrmVehiculoPoliza option:selected').val()==""){
		val1=2;
		mensaje+="Debe Seleccionar Un Tipo de Vehiculo<br>";
	}else{
		val1=1;
	}

	if ($('#tipoServicioVehiculoFrmVehiculoPoliza option:selected').val()==0 || $('#tipoServicioVehiculoFrmVehiculoPoliza option:selected').val()==""){
		val2=2;
		mensaje+="Debe Seleccionar Tipo de Servicio<br>";
	}else{
		val2=1;
	}

	if ($('#marcaVehiculoFrmVehiculoPoliza').val()==""){
		val3=2;
		mensaje+="Debe Ingresar Marca<br>";
	}else{
		val3=1;
	}

	if ($('#modeloVehiculoFrmVehiculoPoliza').val()==""){
		val4=2;
		mensaje+="Debe Ingresar Modelo<br>";
	}else{
		val4=1;
	}

	if ($('#lineaVehiculoFrmVehiculoPoliza').val()==""){
		val5=2;
		mensaje+="Debe Ingresar Linea<br>";
	}else{
		val5=1;
	}

	if ($('#colorVehiculoFrmVehiculoPoliza').val()==""){
		val6=2;
		mensaje+="Debe Ingresar Color<br>";
	}else{
		val6=1;
	}

	if ($('#numVinVehiculoFrmVehiculoPoliza').val()==""){
		val7=2;
		mensaje+="Debe Ingresar Numero VIN<br>";
	}else{
		val7=1;
	}

	if ($('#numSerieVehiculoFrmVehiculoPoliza').val()==""){
		val8=2;
		mensaje+="Debe Ingresar Numero Serie<br>";
	}else{
		val8=1;
	}

	if ($('#numChasisVehiculoFrmVehiculoPoliza').val()==""){
		val9=2;
		mensaje+="Debe Ingresar Numero Chasis<br>";
	}else{
		val9=1;
	}

	if ($('#numMotorVehiculoFrmVehiculoPoliza').val()==""){
		val10=2;
		mensaje+="Debe Seleccionar Una Numero Motor<br>";
	}else{
		val10=1;
	}


	if (val1==2 || val2==2 || val3==2 || val4==2 || val5==2 || val6==2 || val7==2 || val8==2 || val9==2 || val10==2){
		$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
		$("#ContenidoErrorNonActualizable").html(mensaje);
		$('#ErroresNonActualizable').modal('show');
		loadingSiglo('hide');
	}
	else{
		loadingSiglo('show', 'Guardando Vehiculo...');

		var form = "exe="+$('#exeFrmVehiculos').val()
		+"&tipoVehiculoFrmVehiculoPoliza="+$('#tipoVehiculoFrmVehiculoPoliza option:selected').val()
		+"&tipoServicioVehiculoFrmVehiculoPoliza="+$('#tipoServicioVehiculoFrmVehiculoPoliza option:selected').val()
		+"&placaVehiculoFrmVehiculoPoliza="+$('#placaVehiculoFrmVehiculoPoliza').val()
		+"&marcaVehiculoFrmVehiculoPoliza="+$('#marcaVehiculoFrmVehiculoPoliza').val()
		+"&modeloVehiculoFrmVehiculoPoliza="+$('#modeloVehiculoFrmVehiculoPoliza').val()
		+"&lineaVehiculoFrmVehiculoPoliza="+$('#lineaVehiculoFrmVehiculoPoliza').val()
		+"&colorVehiculoFrmVehiculoPoliza="+$('#colorVehiculoFrmVehiculoPoliza').val()
		+"&numVinVehiculoFrmVehiculoPoliza="+$('#numVinVehiculoFrmVehiculoPoliza').val()
		+"&numSerieVehiculoFrmVehiculoPoliza="+$('#numSerieVehiculoFrmVehiculoPoliza').val()
		+"&numChasisVehiculoFrmVehiculoPoliza="+$('#numChasisVehiculoFrmVehiculoPoliza').val()
		+"&numMotorVehiculoFrmVehiculoPoliza="+$('#numMotorVehiculoFrmVehiculoPoliza').val()
		+"&usuario="+$('#btnLogout').attr('name')
		+"&idVehiculoFrmVehiculos="+$('#idVehiculoFrmVehiculos').val();

		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoVehiculosPoliza.php',
			data: form,
			success: function(data) {

				var json_obj = $.parseJSON(data);
				if (json_obj.resultado==1) {

					$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente.");							
					$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
					$("#idVehiculoFrmVehiculos").val(json_obj.id_vehiculo);			
					$('#ErroresNonActualizable').modal('show');		
					$('#BtnAddPolizaVehiculoCasoFrm').css('display', 'block');		
				}
				else if(json_obj.resultado==2){

					$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});				
					$("#ContenidoErrorNonActualizable").html("Error al crear Caso");
					$('#ErroresNonActualizable').modal('show');
				}
				else{
					alert("error");
				}
				loadingSiglo('hide');
			}, error: function(data){
				loadingSiglo('hide');
			}
		});
	}
});

$('#placaVehiculoFrmVehiculoPoliza').on('keypress',function(e){
	if (e.which===13 || e.which===9){
		e.preventDefault();
		loadingSiglo('show', 'Cargando...');
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoVehiculosPoliza.php',
			data: "exe=consultarVehiculo&identificacionVehiculo="+$('#placaVehiculoFrmVehiculoPoliza').val()+"&tipoConsulta=2",
			success: function(data) {

				var arrayDatos = jQuery.parseJSON(data);
				if (arrayDatos.cantidad_registros_vehiculos==0)	{	
					limpiaForm("#frmVehiculosSOAT");
					$('.campFrmVehiculo').attr('disabled', false);
					$("#tipoServicioVehiculoFrmVehiculoPoliza").val('0').trigger('change');
					$("#tipoVehiculoFrmVehiculoPoliza").val('0').trigger('change');
					$('#placaVehiculoFrmVehiculoPoliza').attr('name', $('#placaVehiculoFrmVehiculoPoliza').val());
					$('#idVehiculoFrmVehiculos').val(0);
					$('#BtnAddPolizaVehiculoCasoFrm').css('display', 'none');

					loadingSiglo('hide');
					llenarTablaPolizasVehiculos();

					$('#exeFrmVehiculos').val('registrarVehiculos');
				}
				else if (arrayDatos.cantidad_registros_vehiculos==1){
					limpiaForm("#frmVehiculosSOAT");
					$("#tipoVehiculoFrmVehiculoPoliza").val(arrayDatos.tipo_vehiculo).change();
					$("#placaVehiculoFrmVehiculoPoliza").val(arrayDatos.placa);
					$("#marcaVehiculoFrmVehiculoPoliza").val(arrayDatos.marca);
					$("#modeloVehiculoFrmVehiculoPoliza").val(arrayDatos.modelo);
					$("#lineaVehiculoFrmVehiculoPoliza").val(arrayDatos.linea);
					$("#colorVehiculoFrmVehiculoPoliza").val(arrayDatos.color);
					$("#numVinVehiculoFrmVehiculoPoliza").val(arrayDatos.numero_vin);
					$("#numSerieVehiculoFrmVehiculoPoliza").val(arrayDatos.numero_serie);
					$("#tipoServicioVehiculoFrmVehiculoPoliza").val(arrayDatos.tipo_servicio).change();
					$("#numChasisVehiculoFrmVehiculoPoliza").val(arrayDatos.numero_chasis);
					$("#numMotorVehiculoFrmVehiculoPoliza").val(arrayDatos.numero_motor);
					$('.campFrmVehiculo').attr('disabled', false);
					$('#idVehiculoFrmVehiculos').val(arrayDatos.id_vehiculo);
					$('#BtnAddPolizaVehiculoCasoFrm').css('display', 'block');

					loadingSiglo('hide');
					llenarTablaPolizasVehiculos();

					$.ajax({
						type: 'POST',
						url: 'class/consultasManejoVehiculosPoliza.php',
						data: 'exe=consultarPolizasVehiculo&idVehiculo='+arrayDatos.id_vehiculo+'&idInvestigacion='+$('#idInvestigacionFrmVehiculos').val(),
						success: function(data) {
							var data = $.parseJSON(data);
							if(data.respuesta.length > 0){
								mostrarModalSeleccionarPolizas(data);
							}
						}
					});

					$('#exeFrmVehiculos').val('modificarVehiculos');	
				}
				else if (arrayDatos.cantidad_registros_vehiculos>1)	{
					loadingSiglo('hide');

					llenarTablaGestionVehiculos();
					$('#GestionVehiculos').modal('show');
				}

				return false;
			},error: function(data){
				loadingSiglo('hide');
			}
		});
	}   
});	

$('#btnGuardarBeneficiarioSoat').click(function(e){
	loadingSiglo('show', 'Guardando Beneficiario...');
	var val1=1; var val2=1; var mensaje ="";
	if ($('#descripcionBeneficiarioFrm').attr("name")=="0"){
		val1=2;
		mensaje+="Debe Seleccionar Persona<br>";
	}else{
		val1=1;
	}

	if ($('#parentescoBeneficiarioFrm').val()==""){
		val2=2;
		mensaje+="Debe Ingresar Fecha de ingreso<br>";
	}else{
		val2=1;
	}

	if (val1==2 || val2==2)	{
		$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
		$("#ContenidoErrorNonActualizable").html(mensaje);
		$('#ErroresNonActualizable').modal('show');
		loadingSiglo('hide');
	}else{
		var form = "exe="+$('#exeBeneficiario').val()
		+"&idBeneficiario="+$('#descripcionBeneficiarioFrm').attr("name")
		+"&parentescoBeneficiarioFrm="+$('#parentescoBeneficiarioFrm').val()
		+"&usuario="+$('#btnLogout').attr('name')
		+"&idRegistroInvestigacionBeneficiarioSOAT="+$('#idRegistroInvestigacionBeneficiarioSOAT').val()
		+"&idPersonaBeneficiario="+$('#idPersonaBeneficiario').val();

		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoLesionados.php',
			data: form,
			success: function(data) {

				if (data==1) {
					$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente.");							
					$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
					loadingSiglo('hide');
					llenarTablaGestionBeneficiarios();
					$('#modalAgregarBeneficiarios').modal('hide');
				}
				else if(data==2){
					$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});				
					$("#ContenidoErrorNonActualizable").html("Error al registrar");
					$('#ErroresNonActualizable').modal('show');
					loadingSiglo('hide');
				}
				else if(data==3){
					$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});				
					$("#ContenidoErrorNonActualizable").html("Ya Esta Persona Fue Agregada en este Siniestro");
					$('#ErroresNonActualizable').modal('show');
					loadingSiglo('hide');
				}
			}, error: function(data){
				loadingSiglo('hide');
			}
		});
	}
});

$('#BtnGuardarTestigoFrm').click(function(e){
	loadingSiglo('show', 'Guardando Testigo...');
	var val1=1;var mensaje ="";
	if ($('#descripcionTestigoFrm').attr("name")=="0"){
		val1=2;
		mensaje+="Debe Seleccionar Persona<br>";
	}else{
		val1=1;
	}

	if (val1==2){
		$("#ContenidoErrorNonActualizable").html(mensaje);							
		$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
		loadingSiglo('hide');
	}else{
		var form = "exe=registrarTestigoInforme"
		+"&idPersona="+$('#descripcionTestigoFrm').attr("name")
		+"&usuario="+$('#btnLogout').attr('name')
		+"&idInvestigacionTestigos="+$('#idInvestigacionTestigos').val();

		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoCasoSOAT.php',
			data: form,
			success: function(data) {

				if (data==1) {
					$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente.");							
					$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
					$('#FrmObservacionesInforme').modal('hide');
					
					loadingSiglo('hide');

					llenarTablaGestionTestigos();
				}
				else if(data==2){
					$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});				
					$("#ContenidoErrorNonActualizable").html("Ya Existe Este Testigo");
					$('#ErroresNonActualizable').modal('show');
					loadingSiglo('hide');
				}
			}, error: function(data){
				loadingSiglo('hide');
			}
		});
	}
});

$('#btnGuardarObservaciones').click(function(e){
	loadingSiglo('show', 'Guardando Observaciones...');
	var val1=1; var val2=1; var mensaje ="";

	if ($('#seccionInformeFrmObservaciones option:selected').val()==0 || $('#seccionInformeFrmObservaciones option:selected').val()==""){
		val1=2;
		mensaje+="Debe Seleccionar Seccion Informe<br>";
	}else{
		val1=1;
	}

	if ($('#observacionesFrmObservaciones').val()==""){
		val2=2;
		mensaje+="Debe Ingresar Observacion<br>";
	}else{
		val2=1;
	}

	if (val1==2 || val2==2)	{
		$("#ContenidoErrorNonActualizable").html(mensaje);							
		$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
		loadingSiglo('hide');
	}else{
		var form = "exe="+$('#exeObservaciones').val()
		+"&seccionInformeFrmObservaciones="+$('#seccionInformeFrmObservaciones option:selected').val()
		+"&observacionesFrmObservaciones="+$('#observacionesFrmObservaciones').val()
		+"&usuario="+$('#btnLogout').attr('name')
		+"&idInvestigacionFrmObservaciones="+$('#idInvestigacionFrmObservaciones').val()
		+"&idObservacionInforme="+$('#idObservacionInforme').val();

		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoCasoSOAT.php',
			data: form,
			success: function(data) {
				if (data==1) {
					$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente.");							
					$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
					$('#FrmObservacionesInforme').modal('hide');
					loadingSiglo('hide');
					llenarTablaGestionObservaciones();
				}
				else if(data==2){
					$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});				
					$("#ContenidoErrorNonActualizable").html("Ya Existe Observacion para esta seccion");
					$('#ErroresNonActualizable').modal('show');
					loadingSiglo('hide');
				}
			}
		});
	}
});

$('#btnGuardarVictimaSoat').click(function(e){
	loadingSiglo('show', 'Guardando Victima...');
	var val1=1; var val2=1; var val3=1; var val4=1; var val5=1; var val6=1; var val7=1;var mensaje ="";

	if ($('#descripcionVictimaFrm').attr("name")=="0"){
		val1=2;
		mensaje+="Debe Seleccionar Persona<br>";
	}else{
		val1=1;
	}

	if (($('#resultadoVictimaFrm option:selected').val()==0 || $('#resultadoVictimaFrm option:selected').val()=="")){
		val3=2;
		mensaje+="Debe Seleccionar Resultado<br>";
	}else{
		val3=1;
	}

	if (($('#indicadorFraudeVictimaFrm option:selected').val()==0 || $('#indicadorFraudeVictimaFrm option:selected').val()=="") && ($('#exeLesionados').val()=="registrarLesionados")){
		val4=2;
		mensaje+="Debe Seleccionar Un Indicador<br>";
	}else{
		val4=1;
	}

	if ($('#fechaIngresoVictimaFrm').val()==""){
		val5=2;
		mensaje+="Debe Ingresar Fecha de ingreso<br>";
	}else{
		val5=1;
	}

	if ($('#fechaEgresoVictimaFrm').val()==""){
		val6=2;
		mensaje+="Debe Ingresar Fecha de Egreso<br>";
	}else{
		val6=1;
	}

	if ($('#condicionVictimaFrm').val()==""){
		val7=2;
		mensaje+="Debe Ingresar Condicion<br>";
	}else{
		val7=1;
	}

	if (val1==2 || val2==2 || val3==2 || val4==2 || val5==2 || val6==2 || val7==2)	{
		$("#ContenidoErrorNonActualizable").html(mensaje);							
		$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
		loadingSiglo('hide');
	}else{
		var form = "exe="+$('#exeVictima').val()
		+"&idVictima="+$('#descripcionVictimaFrm').attr("name")
		+"&fechaIngresoVictimaFrm="+$('#fechaIngresoVictimaFrm').val()
		+"&fechaEgresoVictimaFrm="+$('#fechaEgresoVictimaFrm').val()
		+"&ipsVictimaFrm="+$('#ipsVictimaFrm option:selected').val()
		+"&condicionVictimaFrm="+$('#condicionVictimaFrm').val()
		+"&resultadoVictimaFrm="+$('#resultadoVictimaFrm option:selected').val()
		+"&indicadorFraudeVictimaFrm="+$('#indicadorFraudeVictimaFrm option:selected').val()
		+"&usuario="+$('#btnLogout').attr('name')
		+"&idRegistroInvestigacionVictimaSOAT="+$('#idRegistroInvestigacionVictimaSOAT').val()
		+"&idPersonaVictima="+$('#idPersonaVictima').val()
		+"&observacionesVictimaFrm="+$('#observacionesVictimaFrm').val();
		
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoLesionados.php',
			data: form,
			success: function(data) {
				var arrayDatos = jQuery.parseJSON(data);

				if (arrayDatos.resultado==1) {
					$('#descripcionVictimaPersonaFrm').attr("placeholder",arrayDatos.nombre_persona);
					$('#descripcionVictimaPersonaFrm').attr("name",arrayDatos.id_persona);
					$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente.");							
					$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
					$('#modalAgregarVictima').modal('hide');
				}
				else if(arrayDatos.resultado==2){

					$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});				
					$("#ContenidoErrorNonActualizable").html("Ya Esta Persona Fue Agregada en este Siniestro");
					$('#ErroresNonActualizable').modal('show');
				}
				loadingSiglo('hide');
			}, error: function(data){
				loadingSiglo('hide');
			}
		});
	}
});

function contarCaracterObserLesionado(){
	$('#contObservacionesLesionadoFrm').text($('#observacionesLesionadoFrm').val().length);
}

$('#btnGuardarLesionadoSoat').click(function(e){
	loadingSiglo('show', 'Guardando Lesionado...');
	var val1=1; var val2=1; var val3=1; var val4=1; var val5=1; var val6=1; var val7=1; var val8=1; var val9=1;
	var val10=1;  var val11=1;  var val12=1;  var val13=1;  var val14=1;  var val15=1;  var val16=1;  var val17=1;
	var val18=1;  var val19=1;  var val20=1;var val21=1;
	var mensaje=""; 

	if ($('#remitidoLesionadoFrm option:selected').val()==0 || $('#remitidoLesionadoFrm option:selected').val()==""){
		val21=2;
		mensaje+="Debe Seleccionar Tipo Remitido Lesionado<br>";
	}
	else{
		if ($('#remitidoLesionadoFrm option:selected').val()=="2"){

			if ($('#ipsRemitidoLesionadoFrm').val()==""){
				val21=2;
				mensaje+="Debe Seleccionar IPS remitido<br>";
			}else{
				val21=1;
			}
		}
		else{
			val21=1;
		}
	}

	if ($('#descripcionLesionadoFrm').attr("name")=="0"){
		val1=2;
		mensaje+="Debe Seleccionar Persona<br>";
	}else{
		val1=1;
	}

	if ($('#servicioAmbulanciaLesionadoFrm option:selected').val()==0 || $('#servicioAmbulanciaLesionadoFrm option:selected').val()==""){
		val2=2;
		mensaje+="Debe Seleccionar IPS<br>";
	}
	else{
		if ($('#servicioAmbulanciaLesionadoFrm option:selected').val()=="s"){

			if ($('#tipoServicioAmbulanciaLesionadoFrm option:selected').val()==0 || $('#tipoServicioAmbulanciaLesionadoFrm option:selected').val()==""){
				val3=2;
				mensaje+="Debe Seleccionar Tipo Servicio Ambulancia<br>";
			}
			else if($('#tipoServicioAmbulanciaLesionadoFrm option:selected').val()==2){
				
				if($('#lugarTrasladoAmbulanciaLesionadoFrm').val()==""){
					val4=2;
					mensaje+="Debe Ingresar Lugar de Traslado<br>";	
				}
				else{
					val4=1;
				}
			}
			else{
				val3=1;
			}
		}
		else if ($('#servicioAmbulanciaLesionadoFrm option:selected').val()=="n"){
			if ($('#tipoVehiculoTrasladoLesionadoFrm option:selected').val()==0 || $('#tipoVehiculoTrasladoLesionadoFrm option:selected').val()==""){
				val5=2;
				mensaje+="Debe Seleccionar Vehiculo de Traslado<br>";
			}
			else{
				val5=1;
			}
		}
	}

	if ($('#seguridadSocialLesionadoFrm option:selected').val()==0 || $('#seguridadSocialLesionadoFrm option:selected').val()==""){
		val6=2;
		mensaje+="Debe Seleccionar Seguridad Social<br>";
	}
	else{
		if ($('#seguridadSocialLesionadoFrm option:selected').val()=="1"){
			
			if ($('#regimenLesionadoFrm option:selected').val()==0 || $('#regimenLesionadoFrm option:selected').val()==""){
				val7=2;
				mensaje+="Debe Seleccionar Regimen Seguridad Social<br>";
			}
			else{
				val7=1;
			}


			if ($('#estadoSeguridadSocialLesionadoFrm option:selected').val()==0 || $('#estadoSeguridadSocialLesionadoFrm option:selected').val()==""){
				val8=2;
				mensaje+="Debe Seleccionar Regimen Seguridad Social<br>";
			}
			else{
				val8=1;
			}

			if ($('#epsLesionadoFrm').val()==""){
				val9=2;
				mensaje+="Debe Ingresar EPS<br>";
			}
			else{
				val9=1;
			}
		}
		else if ($('#servicioAmbulanciaLesionadoFrm option:selected').val()=="3"){
			
			if ($('#causalNoConsultaSeguridadSocialLesionadoFrm option:selected').val()==0 || $('#causalNoConsultaSeguridadSocialLesionadoFrm option:selected').val()==""){
				val10=2;
				mensaje+="Debe Seleccionar Causal de No Consulta Seguridad Social<br>";
			}
			else{
				val10=1;
			}
		}
		else{
			val6=1;
		}
	}

	if ($('#ipsLesionadoFrm option:selected').val()==0 || $('#ipsLesionadoFrm option:selected').val()==""){
		val11=2;
		mensaje+="Debe Seleccionar IPS<br>";
	}else{
		val11=1;
	}

	if (($('#resultadoLesionadoFrm option:selected').val()==0 || $('#resultadoLesionadoFrm option:selected').val()=="")){
		val12=2;
		mensaje+="Debe Seleccionar Resultado<br>";
	}else{
		val12=1;
	}

	if (($('#indicadorFraudeLesionadoFrm option:selected').val()==0 || $('#indicadorFraudeLesionadoFrm option:selected').val()=="") && ($('#exeLesionados').val()=="registrarLesionados")){
		val13=2;
		mensaje+="Debe Seleccionar Un Indicador<br>";
	}else{
		val13=1;
	}

	if ($('#fechaIngresoLesionadoFrm').val()==""){
		val14=2;
		mensaje+="Debe Ingresar Fecha de ingreso<br>";
	}else{
		val14=1;
	}

	if ($('#fechaEgresoLesionadoFrm').val()==""){
		val15=2;
		mensaje+="Debe Ingresar Fecha de Egreso<br>";
	}else{
		val15=1;
	}

	if ($('#condicionLesionadoFrm').val()==0){
		val16=2;
		mensaje+="Debe Ingresar Condicion<br>";
	}else{
		val16=1;
	}

	if ($('#lesionesLesionadoFrm').val()==""){
		val17=2;
		mensaje+="Debe Ingresar Lesiones<br>";
	}else{
		val17=1;
	}

	if ($('#tratamientoLesionadoFrm').val()==""){
		val18=2;
		mensaje+="Debe Ingresar Tratamiento<br>";
	}else{
		val18=1;
	}

	if ($('#relatoLesionadoFrm').val()==""){
		val19=2;
		mensaje+="Debe Ingresar Relato<br>";
	}else{
		val19=1;
	}

	if ($('#observacionesLesionadoFrm').val()==""){
		val20=2;
		mensaje+="Debe Ingresar Observaciones<br>";
	}else{
		if($('#observacionesLesionadoFrm').val().length < 254){
			val20=2;
			mensaje+="Ingresar Por lo menos 255 caracteres en Observaciones<br>";
		}else{
			val20=1;
		}
	}

	if (val1==2 || val2==2 || val3==2 || val4==2 || val5==2 || val6==2 || val7==2 || val8==2 || val9==2 || val10==2 || val11==2 || val12==2 || val13==2 || val14==2 || val15==2 || val16==2 || val17==2 || val18==2 || val19==2 || val20==2 || val21==2){
		$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
		$("#ContenidoErrorNonActualizable").html(mensaje);
		$('#ErroresNonActualizable').modal('show');
		loadingSiglo('hide');
	}
	else{
		var form = "exe="+$('#exeLesionados').val()
		+"&idLesionado="+$('#descripcionLesionadoFrm').attr("name")
		+"&fechaIngresoLesionadoFrm="+$('#fechaIngresoLesionadoFrm').val()
		+"&fechaEgresoLesionadoFrm="+$('#fechaEgresoLesionadoFrm').val()
		+"&ipsLesionadoFrm="+$('#ipsLesionadoFrm option:selected').val()
		+"&condicionLesionadoFrm="+$('#condicionLesionadoFrm').val()
		+"&resultadoLesionadoFrm="+$('#resultadoLesionadoFrm option:selected').val()
		+"&indicadorFraudeLesionadoFrm="+$('#indicadorFraudeLesionadoFrm option:selected').val()
		+"&servicioAmbulanciaLesionadoFrm="+$('#servicioAmbulanciaLesionadoFrm option:selected').val()
		+"&tipoServicioAmbulanciaLesionadoFrm="+$('#tipoServicioAmbulanciaLesionadoFrm option:selected').val()
		+"&lugarTrasladoAmbulanciaLesionadoFrm="+$('#lugarTrasladoAmbulanciaLesionadoFrm').val()
		+"&tipoVehiculoTrasladoLesionadoFrm="+$('#tipoVehiculoTrasladoLesionadoFrm option:selected').val()
		+"&seguridadSocialLesionadoFrm="+$('#seguridadSocialLesionadoFrm option:selected').val()
		+"&epsLesionadoFrm="+$('#epsLesionadoFrm').val()
		+"&regimenLesionadoFrm="+$('#regimenLesionadoFrm option:selected').val()
		+"&estadoSeguridadSocialLesionadoFrm="+$('#estadoSeguridadSocialLesionadoFrm option:selected').val()
		+"&causalNoConsultaSeguridadSocialLesionadoFrm="+$('#causalNoConsultaSeguridadSocialLesionadoFrm option:selected').val()
		+"&lesionesLesionadoFrm="+$('#lesionesLesionadoFrm').val()
		+"&tratamientoLesionadoFrm="+$('#tratamientoLesionadoFrm').val()
		+"&relatoLesionadoFrm="+$('#relatoLesionadoFrm').val()
		+"&observacionesLesionadoFrm="+$('#observacionesLesionadoFrm').val()
		+"&usuario="+$('#btnLogout').attr('name')
		+"&idRegistroInvestigacionLesionadoSOAT="+$('#idRegistroInvestigacionLesionadoSOAT').val()
		+"&idPersonaLesionado="+$('#idPersonaLesionado').val()
		+"&remitidoLesionadoFrm="+$('#remitidoLesionadoFrm option:selected').val()
		+"&ipsRemitidoLesionadoFrm="+$('#ipsRemitidoLesionadoFrm').val();

		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoLesionados.php',
			data: form,
			success: function(data) {
				if (data==1){
					$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente.");							
					$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
					$('#modalAgregarLesionados').modal('hide');
					loadingSiglo('hide');
					llenarTablaGestionLesionados();
				}
				else if(data==2){
					$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});				
					$("#ContenidoErrorNonActualizable").html("Ya Esta Persona Fue Agregada en este Siniestro");
					$('#ErroresNonActualizable').modal('show');
					loadingSiglo('hide');
				}
			}, error: function(data){
				loadingSiglo('hide');
			}
		});
	}
});

$("#DivTablas17").on('click','a',function(){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');

	loadingSiglo('show', 'Cargando...');

	if (action=="btnCambiarTPersonaLesionadoSoat"){
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoLesionados.php',
			data: "exe=cambiarTipoPersona&idPersona="+opcion,
			success: function(data) {
				if (data==1){
					$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente.");							
					$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
					$('#ErroresNonActualizable').modal('show');
					loadingSiglo('hide');
					llenarTablaGestionLesionados();
				}else{
					loadingSiglo('hide');
				}
				return false;
			}, error: function(data){
				loadingSiglo('hide');
			}
		});
	}else if (action=="btnEliminarLesionadoSOAT"){
		loadingSiglo('hide');
		ModalRegistrosOut("Eliminar",opcion,"tablaGestionLesionados","eliminarPersonaLesionadoSOAT");
	}
	else if (action=="btnEditarLesionadoSOAT"){
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoLesionados.php',
			data: "exe=consultarLesionado&idLesionado="+opcion,
			success: function(data) {
				var arrayDatos = jQuery.parseJSON(data);
				limpiaForm("#FrmLesionadoCasoSOAT");
				$("#identificacionLesionadoFrm").val(arrayDatos.identificacion);
				$("#descripcionLesionadoFrm").attr("placeholder",arrayDatos.nombre_persona);
				$("#descripcionLesionadoFrm").attr("name",arrayDatos.id_persona);

				destruirDaterangepicker("#fechaIngresoLesionadoFrm");
				destruirDaterangepicker("#fechaEgresoLesionadoFrm");

				$("#fechaIngresoLesionadoFrm").val(arrayDatos.fecha_ingreso);
				$("#fechaEgresoLesionadoFrm").val(arrayDatos.fecha_egreso);

				convertirDaterangepicker("#fechaIngresoLesionadoFrm", 2);
				convertirDaterangepicker("#fechaEgresoLesionadoFrm", 2);

				$("#condicionLesionadoFrm").val(arrayDatos.condicion).change();
				$("#ipsLesionadoFrm").val(arrayDatos.ips).change();
				$("#indicadorFraudeLesionadoFrm").attr('idactual', arrayDatos.indicador_fraude);
				$("#resultadoLesionadoFrm").val(arrayDatos.resultado).change();	
				$("#servicioAmbulanciaLesionadoFrm").val(arrayDatos.indicador_fraude).change();
				$("#servicioAmbulanciaLesionadoFrm").val(arrayDatos.servicio_ambulancia).change();

				if (arrayDatos.servicio_ambulancia=="s"){
					$("#tipoServicioAmbulanciaLesionadoFrm").val(arrayDatos.tipo_traslado_ambulancia).change();
				}else if (arrayDatos.servicio_ambulancia=="n"){
					$("#tipoVehiculoTrasladoLesionadoFrm").val(arrayDatos.tipo_vehiculo_traslado).change();
				}

				$("#lugarTrasladoAmbulanciaLesionadoFrm").val(arrayDatos.lugar_traslado);
				$("#seguridadSocialLesionadoFrm").val(arrayDatos.seguridad_social).change();
				$("#remitidoLesionadoFrm").val(arrayDatos.remitido).change();								
				
				if (arrayDatos.remitido=="2"){
					$("#ipsRemitidoLesionadoFrm").val(arrayDatos.ips_remitido);
				}

				if (arrayDatos.seguridad_social=="1"){
					$("#regimenLesionadoFrm").val(arrayDatos.regimen).change();
					$("#estadoSeguridadSocialLesionadoFrm").val(arrayDatos.estado).change();
					$("#epsLesionadoFrm").val(arrayDatos.eps);
				}else if (arrayDatos.seguridad_social=="3"){
					$("#causalNoConsultaSeguridadSocialLesionadoFrm").val(arrayDatos.causal_consulta).change();
				}

				$("#lesionesLesionadoFrm").val(arrayDatos.lesiones);
				$("#tratamientoLesionadoFrm").val(arrayDatos.tratamiento);
				$("#relatoLesionadoFrm").val(arrayDatos.relato);
				$("#observacionesLesionadoFrm").val(arrayDatos.observaciones);
				$('#idRegistroInvestigacionLesionadoSOAT').val(arrayDatos.id_investigacion);	
				$('#idPersonaLesionado').val(arrayDatos.id);	
				$('#exeLesionados').val('modificarLesionado');	
				$('#modalAgregarLesionados').modal('show');
				
				loadingSiglo('hide');
				
				return false;
			}, error: function(data){
				loadingSiglo('hide');
			}
		});
	}
});

$("#DivTablas21").on('click','a',function(){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');

	if (action=="btnEliminarBeneficiarioSOAT"){
		ModalRegistrosOut("Eliminar",opcion,"tablaGestionBeneficiarios","eliminarBeneficiariosCasoSOAT");
	}
	else if (action=="btnEditarBeneficiarioSOAT"){
		loadingSiglo('show','Editando Beneficiario...');
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoLesionados.php',
			data: "exe=consultarBeneficiario&idBeneficiario="+opcion,
			success: function(data) {
				var arrayDatos = jQuery.parseJSON(data);

				limpiaForm("#frmPolizas");

				$("#identificacionBeneficiarioFrm").val(arrayDatos.identificacion);
				$("#descripcionBeneficiarioFrm").attr("placeholder",arrayDatos.nombre_persona);
				$("#descripcionBeneficiarioFrm").attr("name",arrayDatos.id_persona);
				$("#parentescoBeneficiarioFrm").val(arrayDatos.parentesco);
				$("#exeBeneficiario").val("modificarBeneficiario");
				$("#observacioneBeneficiarioFrm").val(arrayDatos.observaciones);
				$('#idRegistroInvestigacionBeneficiarioSOAT').val(arrayDatos.id_investigacion);	
				$('#idPersonaBeneficiario').val(arrayDatos.id);	
				$('#modalAgregarBeneficiarios').modal('show');
				loadingSiglo('hide');
				return false;
			},error: function(data){
				loadingSiglo('hide');
			}
		});
	}
});

$("#DivTablas19").on('click','a',function(){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');

	if (action=="btnSeleccionarPolizaSOAT"){
		seleccionarPolizas(opcion);
	}
	else if (action=="btnEliminarPolizaSOAT"){
		ModalRegistrosOut("Eliminar",opcion,"tablaPolizasVehiculosFrmVehiculos","eliminarPolizaCasoSOAT");
	}
	else if (action=="btnEditarPolizaSOAT")	{
		loadingSiglo('show','Editar Poliza...');
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoVehiculosPoliza.php',
			data: "exe=consultarPoliza&idPoliza="+opcion,
			success: function(data) {
				var arrayDatos = jQuery.parseJSON(data);
				limpiaForm("#frmPolizas");

				$("#numeroPolizaFRM").val(arrayDatos.numero);
				$("#digVerPolizaFrm").val(arrayDatos.digito_verificacion);
				destruirDaterangepicker("#vigenciaPolizaFrm");
				$("#vigenciaPolizaFrm").val(arrayDatos.inicio_vigencia);
				convertirDaterangepicker("#vigenciaPolizaFrm");
				$("#tipoIdentificacionTomadorPolizaFrm").val(arrayDatos.tipo_identificacion_tomador).change();
				$("#identificacionTomadorPolizaFrm").val(arrayDatos.identificacion_tomador);
				$("#nombreTomadorPolizaFrm").val(arrayDatos.nombre_tomador);
				$("#direccionTomadorPolizaFrm").val(arrayDatos.direccion_tomador);
				$("#telefonoTomadorPolizaFrm").val(arrayDatos.telefono_tomador);
				$("#claveProductorPolizaFrm").val(arrayDatos.clave_productora);
				$("#ciudadTomadorPolizaFrm").val(arrayDatos.ciudad_tomador).change();
				$("#ciudadExpedicionPolizaFrm").val(arrayDatos.ciudad_expedicion).change();
				$("#codSucursalPolizaFrm").val(arrayDatos.cod_sucursal_exp);
				$("#aseguradoraPolizaFrm").val(arrayDatos.id_aseguradora).change();
				$('#idPolizas').val(arrayDatos.id_poliza);	
				$('#exeFrmPolizas').val('modificarPolizas');	
				$('#FrmPolizas').modal('show');

				loadingSiglo('hide');
				return false;
			}, error: function(){
				loadingSiglo('hide');
			}
		});
	}
});

$("#DivTablas18").on('click','a',function(){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');

	if (action=="btnSeleccionarVehiculo"){
		$('#GestionVehiculos').modal('hide');
		loadingSiglo('show','Seleccionando Vehiculo...');
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoVehiculosPoliza.php',
			data: "exe=consultarVehiculo&identificacionVehiculo="+opcion+"&tipoConsulta=1",
			success: function(data) {

				var arrayDatos = jQuery.parseJSON(data);
				limpiaForm("#frmVehiculosSOAT");

				$("#tipoVehiculoFrmVehiculoPoliza").val(arrayDatos.tipo_vehiculo).change();
				$("#placaVehiculoFrmVehiculoPoliza").val(arrayDatos.placa);
				$("#marcaVehiculoFrmVehiculoPoliza").val(arrayDatos.marca);
				$("#modeloVehiculoFrmVehiculoPoliza").val(arrayDatos.modelo);
				$("#lineaVehiculoFrmVehiculoPoliza").val(arrayDatos.linea);
				$("#colorVehiculoFrmVehiculoPoliza").val(arrayDatos.color);
				$("#numVinVehiculoFrmVehiculoPoliza").val(arrayDatos.numero_vin);
				$("#numSerieVehiculoFrmVehiculoPoliza").val(arrayDatos.numero_serie);
				$("#tipoServicioVehiculoFrmVehiculoPoliza").val(arrayDatos.tipo_servicio).change();
				$("#numChasisVehiculoFrmVehiculoPoliza").val(arrayDatos.numero_chasis);
				$("#numMotorVehiculoFrmVehiculoPoliza").val(arrayDatos.numero_motor);
				$('.campFrmVehiculo').attr('disabled', false);
				$('#idVehiculoFrmVehiculos').val(arrayDatos.id_vehiculo);	
				
				loadingSiglo('hide');
				llenarTablaPolizasVehiculos();

				$('#exeFrmVehiculos').val('modificarVehiculos');	

				
				return false;
			}, error: function(){
				loadingSiglo('hide');
			}
		});
	}
});

$("#DivTablas20").on('click','a',function(){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');

	if (action=="btnEliminarMultimedia"){
		ModalRegistrosOut("Eliminar",opcion,"tablaGestionMultimediaInvestigacion","eliminarMultimediaInvestigacion");
	}
});

$("#DivTablas16").on('click','a',function(){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');

	if (action=="btnSeleccionarPersona"){
		loadingSiglo('show','Seleccionando Persona...')
		$('#GestionPersonas').modal('hide');
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoPersonas.php',
			data: "exe=consultarPersonas&identificacionPersona="+opcion+"&tipoConsulta=1",
			success: function(data) {
				var arrayDatos = jQuery.parseJSON(data);

				limpiaForm("#frmPersonas");
				$("#identificacionPersonasFrm").val(arrayDatos.identificacion);
				$("#nombresPersonasFrm").val(arrayDatos.nombres);
				$("#apellidosPersonasFrm").val(arrayDatos.apellidos);
				$("#edadPersonasFrm").val(arrayDatos.edad);
				$("#ocupacionPersonasFrm").val(arrayDatos.ocupacion);
				$("#telefonoPersonasFrm").val(arrayDatos.telefono);
				$("#direccionPersonasFrm").val(arrayDatos.direccion_residencia);
				$("#barrioPersonasFrm").val(arrayDatos.barrio);
				$("#ciudadPersonasFrm").val(arrayDatos.ciudad_residencia).change();
				$("#sexoPersonasFrm").val(arrayDatos.sexo).change();
				$("#tipoIdentificacionPersonasFrm").val(arrayDatos.tipo_identificacion).change();
				$('#idPersonas').val(arrayDatos.id);	
				$('#exeFrmPersonas').val("modificarPersonas");	

				$('#FrmPersonas').modal('show');
				
				loadingSiglo('hide');
				return false;
			}, error: function(){
				loadingSiglo('hide');
			}
		});
	}
});

$('#btnGuardarPersona').click(function(e){

	var val1=1; var val2=1; var val3=1; var val4=1; var val5=1; var val6=1; var val7=1; var val8=1; var val9=1; var val10=1;
	var mensaje=""; 

	if ($('#tipoIdentificacionPersonasFrm option:selected').val()==0 || $('#tipoIdentificacionPersonasFrm option:selected').val()==""){
		val1=2;
		mensaje+="Debe Seleccionar Un Tipo de Identificacion<br>";
	}else{
		val1=1;
	}

	//if (($('#sexoPersonasFrm option:selected').val()==0 || $('#sexoPersonasFrm option:selected').val()=="") && $('#exeFrmCasosGM').val()=="registrarCasoSOAT"){
	if ($('#sexoPersonasFrm option:selected').val()==0 || $('#sexoPersonasFrm option:selected').val()==""){	
		val2=2;
		mensaje+="Debe Seleccionar Sexo<br>";
	}else{
		val2=1;
	}

	if ($('#nombresPersonasFrm').val()==""){
		val3=2;
		mensaje+="Debe Nombres de Persona<br>";
	}else{
		val3=1;
	}

	if ($('#apellidosPersonasFrm').val()==""){
		val4=2;
		mensaje+="Debe Ingresar Apellidos de Persona<br>";
	}else{
		val4=1;
	}

	if ($('#identificacionPersonasFrm').val()==""){
		val5=2;
		mensaje+="Debe Ingresar Identificacion<br>";
	}else{
		val5=1;
	}

	if ($('#edadPersonasFrm').val()==""){
		val6=2;
		mensaje+="Debe Ingresar Edad<br>";
	}else{
		val6=1;
	}

	if ($('#telefonoPersonasFrm').val()==""){
		val7=2;
		mensaje+="Debe Ingresar Telefono<br>";
	}else{
		val7=1;
	}

	if ($('#direccionPersonasFrm').val()==""){
		val8=2;
		mensaje+="Debe Ingresar Direccion<br>";
	}else{
		val8=1;
	}

	if ($('#barrioPersonasFrm').val()==""){
		val9=2;
		mensaje+="Debe Ingresar Barrio<br>";
	}else{
		val9=1;
	}

	if ($('#ciudadPersonasFrm option:selected').val()==0 || $('#ciudadPersonasFrm option:selected').val()==""){
		val10=2;
		mensaje+="Debe Seleccionar Una Ciudad<br>";
	}else{
		val10=1;
	}

	if (val1==2 || val2==2 || val3==2 || val4==2 || val5==2 || val6==2 || val7==2 || val8==2 || val9==2 || val10==2){
		$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
		$("#ContenidoErrorNonActualizable").html(mensaje);
		$('#ErroresNonActualizable').modal('show');
	}
	else{

		var form = "exe="+$('#exeFrmPersonas').val()
		+"&tipoIdentificacionPersonasFrm="+$('#tipoIdentificacionPersonasFrm option:selected').val()
		+"&sexoPersonasFrm="+$('#sexoPersonasFrm option:selected').val()
		+"&nombresPersonasFrm="+$('#nombresPersonasFrm').val()
		+"&apellidosPersonasFrm="+$('#apellidosPersonasFrm').val()
		+"&identificacionPersonasFrm="+$('#identificacionPersonasFrm').val()
		+"&edadPersonasFrm="+$('#edadPersonasFrm').val()
		+"&telefonoPersonasFrm="+$('#telefonoPersonasFrm').val()
		+"&direccionPersonasFrm="+$('#direccionPersonasFrm').val()
		+"&barrioPersonasFrm="+$('#barrioPersonasFrm').val()
		+"&ciudadPersonasFrm="+$('#ciudadPersonasFrm option:selected').val()
		+"&ocupacionPersonasFrm="+$('#ocupacionPersonasFrm').val()
		+"&usuario="+$('#btnLogout').attr('name')
		+"&idPersonas="+$('#idPersonas').val();

		loadingSiglo('show','Guardando Datos de Persona...');

		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoPersonas.php',
			data: form,
			success: function(data) {
				var json_obj = $.parseJSON(data);

				if (json_obj.resultado==1) {
					$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente.");							
					$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
					$('#FrmPersonas').modal('hide');
					if ($("#frmEnvia").val()=="moduloLesionados"){
						$("#descripcionLesionadoFrm").attr("placeholder",json_obj.nombre_persona);
						$("#descripcionLesionadoFrm").attr("name",json_obj.id);
					}
					else if ($("#frmEnvia").val()=="moduloVictima")	{
						$("#descripcionVictimaFrm").attr("placeholder",json_obj.nombre_persona);
						$("#descripcionVictimaFrm").attr("name",json_obj.id);
					}
					else if ($("#frmEnvia").val()=="moduloReclamante"){	
						seleccionarReclamante(json_obj.id);
						$("#descripcionReclamantePersonaFrm").attr("placeholder",json_obj.nombre_persona);
						$("#descripcionReclamantePersonaFrm").attr("name",json_obj.id);
					}
					else if ($("#frmEnvia").val()=="moduloBeneficiarios"){	
						$("#descripcionBeneficiarioFrm").attr("placeholder",json_obj.nombre_persona);
						$("#descripcionBeneficiarioFrm").attr("name",json_obj.id);
					}
					else if ($("#frmEnvia").val()=="moduloTestigos"){	
						$("#descripcionTestigoFrm").attr("placeholder",json_obj.nombre_persona);
						$("#descripcionTestigoFrm").attr("name",json_obj.id);
					}

					$('#ErroresNonActualizable').modal('show');
				}
				else if(json_obj.resultado==2){
					$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});				
					$("#ContenidoErrorNonActualizable").html("Error al crear Caso");
					$('#ErroresNonActualizable').modal('show');
				}
				else{
					alert("error");
				}

				loadingSiglo('hide');
			}, error: function(){
				loadingSiglo('hide');
			}
		});
	}
});

function seleccionarReclamante(idReclamantePersona){
	var data2;

	loadingSiglo('show','Seleccionando Reclamante...');

	$.ajax({
		type: 'POST',
		url: 'class/consultasManejoLesionados.php',
		data: "exe=seleccionarReclamante&idInvestigacion="+$("#idRegistroInvestigacionPersonasSOAT").val()+"&idReclamantePersona="+idReclamantePersona+"&usuario="+$('#btnLogout').attr('name'),
		success: function(data) {
			data2=data;

			loadingSiglo('hide');
			return false;
		}, error: function(){
			loadingSiglo('hide');
		}
	});

	return data2;
}

$('#identificacionBeneficiarioFrm').on('keypress',function(e){
	if (e.which===13 || e.which===9){
		e.preventDefault();
		loadingSiglo('show','Cargando Datos de Beneficiario...');
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoPersonas.php',
			data: "exe=consultarPersonas&identificacionPersona="+$('#identificacionBeneficiarioFrm').val()+"&tipoConsulta=2",
			success: function(data) {

				var arrayDatos = jQuery.parseJSON(data);

				if (arrayDatos.cantidad_registros_personas==0){
					$("#ciudadPersonasFrm").val('0').trigger('change');
					$("#sexoPersonasFrm").val('0').trigger('change');
					$("#tipoIdentificacionPersonasFrm").val('0').trigger('change');
					limpiaForm("#frmPersonas");

					$('#identificacionPersonasFrm').val($('#identificacionLesionadoFrm').val());	
					$('#exeFrmPersonas').val('registrarPersonas');	
					$('#frmEnvia').val('moduloBeneficiarios');	
					$('#FrmPersonas').modal('show');
					loadingSiglo('hide');
				}
				else if (arrayDatos.cantidad_registros_personas==1){
					limpiaForm("#frmPersonas");
					$("#identificacionPersonasFrm").val(arrayDatos.identificacion);
					$("#nombresPersonasFrm").val(arrayDatos.nombres);
					$("#apellidosPersonasFrm").val(arrayDatos.apellidos);
					$("#edadPersonasFrm").val(arrayDatos.edad);
					$("#ocupacionPersonasFrm").val(arrayDatos.ocupacion);
					$("#telefonoPersonasFrm").val(arrayDatos.telefono);
					$("#direccionPersonasFrm").val(arrayDatos.direccion_residencia);
					$("#barrioPersonasFrm").val(arrayDatos.barrio);
					$("#ciudadPersonasFrm").val(arrayDatos.ciudad_residencia).change();
					$("#sexoPersonasFrm").val(arrayDatos.sexo).change();
					$("#tipoIdentificacionPersonasFrm").val(arrayDatos.tipo_identificacion).change();
					$('#exeFrmPersonas').val('modificarPersonas');
					$('#idPersonas').val(arrayDatos.id);	
					$('#frmEnvia').val('moduloBeneficiarios');	
					$('#FrmPersonas').modal('show');
					loadingSiglo('hide');
				}
				else if (arrayDatos.cantidad_registros_personas>1){
					loadingSiglo('hide');
					llenarTablaGestionPersonas($("#identificacionBeneficiarioFrm").val());
					$('#GestionPersonas').modal('show');
					$('#frmEnvia').val('moduloBeneficiarios');	
				}
				
				return false;
			}, error: function(){
				loadingSiglo('hide');
			}
		});
	}   
});

$('#identificacionVictimaFrm').on('keypress',function(e){
	if (e.which===13 || e.which===9){
		e.preventDefault();
		loadingSiglo('show','Cargando Datos de Victima...')
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoPersonas.php',
			data: "exe=consultarPersonas&identificacionPersona="+$('#identificacionVictimaFrm').val()+"&tipoConsulta=2",
			success: function(data) {

				var arrayDatos = jQuery.parseJSON(data);

				if (arrayDatos.cantidad_registros_personas==0){
					$("#ciudadPersonasFrm").val('0').trigger('change');
					$("#sexoPersonasFrm").val('0').trigger('change');
					$("#tipoIdentificacionPersonasFrm").val('0').trigger('change');
					limpiaForm("#frmPersonas");

					$('#identificacionPersonasFrm').val($('#identificacionLesionadoFrm').val());	
					$('#exeFrmPersonas').val('registrarPersonas');	
					$('#frmEnvia').val('moduloVictima');	
					$('#FrmPersonas').modal('show');
					loadingSiglo('hide');
				}
				else if (arrayDatos.cantidad_registros_personas==1)	{
					limpiaForm("#frmPersonas");
					$('#exeFrmPersonas').val('modificarPersonas');	
					$("#identificacionPersonasFrm").val(arrayDatos.identificacion);
					$("#nombresPersonasFrm").val(arrayDatos.nombres);
					$("#apellidosPersonasFrm").val(arrayDatos.apellidos);
					$("#edadPersonasFrm").val(arrayDatos.edad);
					$("#ocupacionPersonasFrm").val(arrayDatos.ocupacion);
					$("#telefonoPersonasFrm").val(arrayDatos.telefono);
					$("#direccionPersonasFrm").val(arrayDatos.direccion_residencia);
					$("#barrioPersonasFrm").val(arrayDatos.barrio);
					$("#ciudadPersonasFrm").val(arrayDatos.ciudad_residencia).change();
					$("#sexoPersonasFrm").val(arrayDatos.sexo).change();
					$("#tipoIdentificacionPersonasFrm").val(arrayDatos.tipo_identificacion).change();

					$('#idPersonas').val(arrayDatos.id);	
					$('#frmEnvia').val('moduloVictima');	
					$('#FrmPersonas').modal('show');
					loadingSiglo('hide');
				}
				else if (arrayDatos.cantidad_registros_personas>1){
					loadingSiglo('hide');
					llenarTablaGestionPersonas($("#identificacionVictimaFrm").val());
					$('#GestionPersonas').modal('show');
					$('#frmEnvia').val('moduloVictima');	
				}

				return false;
			},error: function(){
				loadingSiglo('hide');
			}
		});
	}   
});

$('#identificacionReclamantePersonaFrm').on('keypress',function(e){
	if (e.which===13 || e.which===9){
		e.preventDefault();
		loadingSiglo('show','Cargando datos de Reclamante...');
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoPersonas.php',
			data: "exe=consultarPersonas&identificacionPersona="+$('#identificacionReclamantePersonaFrm').val()+"&tipoConsulta=2",
			success: function(data) {
				var arrayDatos = jQuery.parseJSON(data);
				if (arrayDatos.cantidad_registros_personas==0){
					$("#ciudadPersonasFrm").val('0').trigger('change');
					$("#sexoPersonasFrm").val('0').trigger('change');
					$("#tipoIdentificacionPersonasFrm").val('0').trigger('change');
					limpiaForm("#frmPersonas");

					$('#identificacionPersonasFrm').val($('#identificacionLesionadoFrm').val());	
					$('#exeFrmPersonas').val('registrarPersonas');	
					$('#frmEnvia').val('moduloReclamante');	
					$('#FrmPersonas').modal('show');
					loadingSiglo('hide');
				}
				else if (arrayDatos.cantidad_registros_personas==1)	{
					limpiaForm("#frmPersonas");
					$("#identificacionPersonasFrm").val(arrayDatos.identificacion);
					$("#nombresPersonasFrm").val(arrayDatos.nombres);
					$("#apellidosPersonasFrm").val(arrayDatos.apellidos);
					$("#edadPersonasFrm").val(arrayDatos.edad);
					$("#ocupacionPersonasFrm").val(arrayDatos.ocupacion);
					$("#telefonoPersonasFrm").val(arrayDatos.telefono);
					$("#direccionPersonasFrm").val(arrayDatos.direccion_residencia);
					$("#barrioPersonasFrm").val(arrayDatos.barrio);
					$("#ciudadPersonasFrm").val(arrayDatos.ciudad_residencia).change();
					$("#sexoPersonasFrm").val(arrayDatos.sexo).change();
					$("#tipoIdentificacionPersonasFrm").val(arrayDatos.tipo_identificacion).change();

					$('#exeFrmPersonas').val('modificarPersonas');	
					$('#idPersonas').val(arrayDatos.id);	
					$('#frmEnvia').val('moduloReclamante');
					$('#FrmPersonas').modal('show');
					loadingSiglo('hide');
				}
				else if (arrayDatos.cantidad_registros_personas>1){
					loadingSiglo('hide');
					llenarTablaGestionPersonas($("#identificacionReclamantePersonaFrm").val());

					$('#GestionPersonas').modal('show');
					$('#frmEnvia').val('moduloReclamante');
				}

				return false;
			}
		});
	}   
});

$('#identificacionTestigoFrm').on('keypress',function(e){
	if (e.which===13 || e.which===9){
		e.preventDefault();
		loadingSiglo('show','Cargando Datos de Testigo...');
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoPersonas.php',
			data: "exe=consultarPersonas&identificacionPersona="+$('#identificacionTestigoFrm').val()+"&tipoConsulta=2",
			success: function(data) {
				var arrayDatos = jQuery.parseJSON(data);

				if (arrayDatos.cantidad_registros_personas==0){

					$("#ciudadPersonasFrm").val('0').trigger('change');
					$("#sexoPersonasFrm").val('0').trigger('change');
					$("#tipoIdentificacionPersonasFrm").val('0').trigger('change');
					limpiaForm("#frmPersonas");

					$('#identificacionPersonasFrm').val($('#identificacionLesionadoFrm').val());	
					$('#exeFrmPersonas').val('registrarPersonas');	
					$('#frmEnvia').val('moduloLesionados');	

					$('#FrmPersonas').modal('show');
					loadingSiglo('hide');
				}
				else if (arrayDatos.cantidad_registros_personas==1)	{
					limpiaForm("#frmPersonas");
					$("#identificacionPersonasFrm").val(arrayDatos.identificacion);
					$("#nombresPersonasFrm").val(arrayDatos.nombres);
					$("#apellidosPersonasFrm").val(arrayDatos.apellidos);
					$("#edadPersonasFrm").val(arrayDatos.edad);
					$("#ocupacionPersonasFrm").val(arrayDatos.ocupacion);
					$("#telefonoPersonasFrm").val(arrayDatos.telefono);
					$("#direccionPersonasFrm").val(arrayDatos.direccion_residencia);
					$("#barrioPersonasFrm").val(arrayDatos.barrio);
					$("#ciudadPersonasFrm").val(arrayDatos.ciudad_residencia).change();
					$("#sexoPersonasFrm").val(arrayDatos.sexo).change();
					$("#tipoIdentificacionPersonasFrm").val(arrayDatos.tipo_identificacion).change();
					$('#idPersonas').val(arrayDatos.id);	
					$('#exeFrmPersonas').val('modificarPersonas');	
					$('#frmEnvia').val('moduloTestigos');	
					$('#FrmPersonas').modal('show');
					loadingSiglo('hide');
				}
				else if (arrayDatos.cantidad_registros_personas>1){
					loadingSiglo('hide');
					llenarTablaGestionPersonas($("#identificacionLesionadoFrm").val());

					$('#GestionPersonas').modal('show');
					$('#frmEnvia').val('moduloLesionados');	
					$('#exeFrmPersonas').val('moduloTestigos');
				}

				return false;
			}, error: function(){
				loadingSiglo('hide');
			}
		});
	}   
});

$('#identificacionLesionadoFrm').on('keypress',function(e){
	if (e.which===13 || e.which===9){
		e.preventDefault();
		loadingSiglo('show','Cargando datos de Lesionado...');
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoPersonas.php',
			data: "exe=consultarPersonas&identificacionPersona="+$('#identificacionLesionadoFrm').val()+"&tipoConsulta=2",
			success: function(data) {
				var arrayDatos = jQuery.parseJSON(data);

				if (arrayDatos.cantidad_registros_personas==0){
					$("#ciudadPersonasFrm").val('0').trigger('change');
					$("#sexoPersonasFrm").val('0').trigger('change');
					$("#tipoIdentificacionPersonasFrm").val('0').trigger('change');
					limpiaForm("#frmPersonas");

					$('#identificacionPersonasFrm').val($('#identificacionLesionadoFrm').val());	
					$('#exeFrmPersonas').val('registrarPersonas');	
					$('#frmEnvia').val('moduloLesionados');	

					$('#FrmPersonas').modal('show');
					loadingSiglo('hide');
				}
				else if (arrayDatos.cantidad_registros_personas==1)	{
					limpiaForm("#frmPersonas");
					$("#identificacionPersonasFrm").val(arrayDatos.identificacion);
					$("#nombresPersonasFrm").val(arrayDatos.nombres);
					$("#apellidosPersonasFrm").val(arrayDatos.apellidos);
					$("#edadPersonasFrm").val(arrayDatos.edad);
					$("#ocupacionPersonasFrm").val(arrayDatos.ocupacion);
					$("#telefonoPersonasFrm").val(arrayDatos.telefono);
					$("#direccionPersonasFrm").val(arrayDatos.direccion_residencia);
					$("#barrioPersonasFrm").val(arrayDatos.barrio);
					$("#ciudadPersonasFrm").val(arrayDatos.ciudad_residencia).change();
					$("#sexoPersonasFrm").val(arrayDatos.sexo).change();
					$("#tipoIdentificacionPersonasFrm").val(arrayDatos.tipo_identificacion).change();
					$('#idPersonas').val(arrayDatos.id);	
					$('#exeFrmPersonas').val('modificarPersonas');	
					$('#frmEnvia').val('moduloLesionados');	
					$('#FrmPersonas').modal('show');
					loadingSiglo('hide');
				}
				else if (arrayDatos.cantidad_registros_personas>1){
					loadingSiglo('hide');
					llenarTablaGestionPersonas($("#identificacionLesionadoFrm").val());

					$('#GestionPersonas').modal('show');
					$('#frmEnvia').val('moduloLesionados');	
					$('#exeFrmPersonas').val('modificarPersonas');	
				}
				return false;
			}, error: function(){
				loadingSiglo('hide');
			}
		});
	}   
});

$("#modalModuloInforme").on('hidden.bs.modal', function () {
	$('#ModuloGestionarDiligenciaFormato').hide();
	$('#ModuloGestionarLesionados').hide();
	$('#ModuloGestionarTestigos').hide();
	$('#ModuloGestionarObservaciones').hide();
	$('#ModuloGestionarVehiculo').hide();
	$('#ModuloGestionarInformeMuerte').hide();
	$('#ModuloGestionarMultimedia').hide();
	$('#ModuloGestionarInforme').hide();
	$('#ModuloGestionarPersonas').hide();
	$('#ModuloGestionarRepresentanteLegal').hide();
});

$("#modalAgregarVictima").on('hidden.bs.modal', function () {
	limpiaForm("#FrmVictimaCasoSOAT");
	$("#ipsVictimaFrm").val('0').trigger('change');
	$("#resultadoVictimaFrm").val('0').trigger('change');
	$("#indicadorFraudeVictimaFrm").val('0').trigger('change');
	$("#descripcionVictimaFrm").attr("placeholder","NO HA SELECCIONADO VICTIMA");
	$("#descripcionVictimaFrm").attr("name","0");   	
});

$("#modalAgregarLesionados").on('hidden.bs.modal', function () {
	limpiaForm("#FrmLesionadoCasoSOAT");
	$("#ipsLesionadoFrm").val('0').trigger('change');
	$("#indicadorFraudeLesionadoFrm").val('0').trigger('change');	
	$("#indicadorFraudeLesionadoFrm").attr('idActual','');
	$("#servicioAmbulanciaLesionadoFrm").val('0').trigger('change');
	$("#tipoServicioAmbulanciaLesionadoFrm").val('0').trigger('change');
	$("#tipoVehiculoTrasladoLesionadoFrm").val('0').trigger('change');
	$("#seguridadSocialLesionadoFrm").val('0').trigger('change');
	$("#regimenLesionadoFrm").val('0').trigger('change');
	$("#estadoSeguridadSocialLesionadoFrm").val('0').trigger('change');
	$("#causalNoConsultaSeguridadSocialLesionadoFrm").val('0').trigger('change');
	$("#resultadoLesionadoFrm").val('0').trigger('change');
	$("#descripcionLesionadoFrm").attr("placeholder","NO HA SELECCIONADO NINGUN LESIONADO");
	$("#descripcionLesionadoFrm").attr("name","0");
});

$("#indicadorFraudeLesionadoFrm option:selected").change(function(){
	if ($("#indicadorFraudeLesionadoFrm option:selected") == 13){
		$("#contactoTomadorInformeFrm").attr("disabled", "disabled")
		$("#contactoTomadorInformeFrm").val(4).change()
	}
});

$("#seguridadSocialLesionadoFrm").change(function() {

	if ($("#seguridadSocialLesionadoFrm option:selected").val()=="1"){
		$("#divSiSeguridadSocial").show();
		$("#divCausalNoConsulta").hide();
		$("#causalNoConsultaSeguridadSocialLesionadoFrm").val('0').trigger('change');
	}else if ($("#seguridadSocialLesionadoFrm option:selected").val()=="3"){
		$("#divSiSeguridadSocial").hide();
		$("#divCausalNoConsulta").show();
		$("#estadoSeguridadSocialLesionadoFrm").val('0').trigger('change');
		$("#regimenLesionadoFrm").val('0').trigger('change');
	}else{
		$("#divSiSeguridadSocial").hide();
		$("#divCausalNoConsulta").hide();
		$("#causalNoConsultaSeguridadSocialLesionadoFrm").val('0').trigger('change');
		$("#estadoSeguridadSocialLesionadoFrm").val('0').trigger('change');
		$("#regimenLesionadoFrm").val('0').trigger('change');
	}
});

$("#servicioAmbulanciaLesionadoFrm").change(function() {
	if ($("#servicioAmbulanciaLesionadoFrm option:selected").val()=="s"){
		$("#divTipoServicioAmbulancia").show();
		$("#divTipoVehiculoTraslado").hide();
		$("#divLugarTraslado").hide();
		$("#tipoVehiculoTrasladoLesionadoFrm").val('0').trigger('change');
	}else if ($("#servicioAmbulanciaLesionadoFrm option:selected").val()=="n"){
		$("#tipoVehiculoTrasladoLesionadoFrm").val('0').trigger('change');
		$("#tipoServicioAmbulanciaLesionadoFrm").val('0').trigger('change');
		$("#divTipoServicioAmbulancia").hide();
		$("#divTipoVehiculoTraslado").show();
		$("#divLugarTraslado").hide();
	}else{
		$("#divTipoServicioAmbulancia").hide();
		$("#divTipoVehiculoTraslado").hide();
		$("#divLugarTraslado").hide();	
		$("#tipoVehiculoTrasladoLesionadoFrm").val('0').trigger('change');
		$("#tipoVehiculoTrasladoLesionadoFrm").val('0').trigger('change');
		$("#tipoServicioAmbulanciaLesionadoFrm").val('0').trigger('change');
	}
});

$("#remitidoLesionadoFrm").change(function() {
	if ($("#remitidoLesionadoFrm option:selected").val()=="2"){
		$("#divIPSRemitido").show();
	}else{
		$("#divIPSRemitido").hide();
	}
});

$("#tipoServicioAmbulanciaLesionadoFrm").change(function() {

	if ($("#tipoServicioAmbulanciaLesionadoFrm option:selected").val()=="2"){
		$("#divLugarTraslado").show();
	}else{
		$("#divLugarTraslado").hide();
	}
});

$("#resultadoVictimaFrm").change(function(){
	var sel = $("#resultadoVictimaFrm").val();
	loadingSiglo('show','Cargando Indicador de Fraude...');
	$.ajax({
		type: 'POST',
		url: 'class/consultasBasicas.php',
		data: "exe=consultarIndicadorFraude&idCaso="+$("#idRegistroInvestigacionPersonasSOAT").val()+"&idResultado="+$('#resultadoVictimaFrm option:selected').val(),
		success: function(res) {
			var json_obj = $.parseJSON(res);
			var options = '';
			for (var i = 0; i < json_obj.length; i++) {
				if($("#resultadoVictimaFrm").val() != ''){
					if(json_obj[i].valor == sel){
						options += '<option selected="selected" value="' + json_obj[i].valor + '">' + json_obj[i].descripcion + '</option>';
					}else{
						options += '<option value="' + json_obj[i].valor + '">' + json_obj[i].descripcion + '</option>';
					}	
				}else{
					options += '<option value="' + json_obj[i].valor + '">' + json_obj[i].descripcion + '</option>';
				}
			}
			$("#indicadorFraudeVictimaFrm").html(options);
			loadingSiglo('hide');

			return false;
		},error: function(){
			loadingSiglo('hide');
		}
	});
});

$("#resultadoLesionadoFrm").change(function() {
	var idActual;
	if($("#indicadorFraudeLesionadoFrm").attr("idActual")){
		idActual = $("#indicadorFraudeLesionadoFrm").attr("idActual");
	}
	loadingSiglo('show','Cargando Indicador de Fraude...');
	$.ajax({
		type: 'POST',
		url: 'class/consultasBasicas.php',
		data: "exe=consultarIndicadorFraude&idCaso="+$("#idCasoLesionados").val()+"&idResultado="+$('#resultadoLesionadoFrm option:selected').val(),
		success: function(res){
			var json_obj = $.parseJSON(res);
			var options = '';
			for (var i = 0; i < json_obj.length; i++) {
				if(idActual != 0 && idActual != ""){
					if(json_obj[i].valor == idActual){
						options += '<option selected="selected" value="' + json_obj[i].valor + '">' + json_obj[i].descripcion + '</option>';
					}else{
						options += '<option value="' + json_obj[i].valor + '">' + json_obj[i].descripcion + '</option>';
					}
				}else{
					options += '<option value="' + json_obj[i].valor + '">' + json_obj[i].descripcion + '</option>';
				}
			}
			$("#indicadorFraudeLesionadoFrm").html(options);

			loadingSiglo('hide');
			return false;
		},error: function(){
			loadingSiglo('hide');
		}
	});
});

$('#btnSeleccionarVictima').click(function(e){
	loadingSiglo('hide');
	$.ajax({
		type: 'POST',
		url: 'class/consultasManejoLesionados.php',
		data: "exe=consultarVictima&idInvestigacion="+$("#btnModuloGestionarPersonas").attr("name"),
		success: function(data) {
			var arrayDatos = jQuery.parseJSON(data);

			if (arrayDatos.cantidad_registros_victima>0){

				limpiaForm("#FrmVictimaCasoSOAT");

				$("#descripcionVictimaPersonaFrm").attr("placeholder",arrayDatos.nombre_persona);
				$("#descripcionVictimaPersonaFrm").attr("name",arrayDatos.id_persona);
				$("#identificacionVictimaFrm").val(arrayDatos.identificacion);
				$("#descripcionVictimaFrm").attr("placeholder",arrayDatos.nombre_persona);
				$("#descripcionVictimaFrm").attr("name",arrayDatos.id_persona);
				destruirDaterangepicker("#fechaIngresoVictimaFrm");
				destruirDaterangepicker("#fechaEgresoVictimaFrm");
				$("#fechaIngresoVictimaFrm").val(arrayDatos.fecha_ingreso);
				$("#fechaEgresoVictimaFrm").val(arrayDatos.fecha_egreso);
				convertirDaterangepicker("#fechaIngresoVictimaFrm");
				convertirDaterangepicker("#fechaEgresoVictimaFrm");
				$("#condicionVictimaFrm").val(arrayDatos.condicion);
				$("#ipsVictimaFrm").val(arrayDatos.ips).change();
				$("#resultadoVictimaFrm").val(arrayDatos.resultado).change();
				$("#indicadorFraudeVictimaFrm").val(arrayDatos.indicador_fraude).change();
				$('#idRegistroInvestigacionVictimaSOAT').val(arrayDatos.id_investigacion);	
				$('#idPersonaVictima').val(arrayDatos.id);	
				$('#observacionesVictimaFrm').val(arrayDatos.observaciones);
				$('#exeVictima').val('modificarVictima');	
			}
			else{
				$("#descripcionVictimaPersonaFrm").attr("placeholder","NO HA SELECCIONADO NINGUNA VICTIMA");
				$("#descripcionVictimaPersonaFrm").attr("name","0");
				$('#idRegistroInvestigacionVictimaSOAT').val($("#btnModuloGestionarPersonas").attr("name"));	
				$('#idPersonaVictima').val("0");	
				$('#exeVictima').val("registrarVictima");
			}
			return false;
		}
	});

	$('#modalAgregarVictima').modal("show");
});

$('#btnAgregarBeneficiarios').click(function(e){	
	limpiaForm("#FrmBeneficiariosCasoSOAT");
	$('#descripcionBeneficiarioFrm').attr("placeholder","NO HA SELECCIONADO BENEFICIARIO");
	$('#descripcionBeneficiarioFrm').attr("name","0");
	$('#idRegistroInvestigacionBeneficiarioSOAT').val($("#idRegistroInvestigacionPersonasSOAT").val());
	$('#exeBeneficiario').val("registrarBeneficiario");
	$('#modalAgregarBeneficiarios').modal("show");
});

$('#btnAgregarObservaciones').click(function(e){
	limpiaForm("#frmObservacionesInvestigacion");
	$('#exeObservaciones').val("registrarObservaciones");
	$('#idInvestigacionFrmObservaciones').val($('#btnModuloGestionarObservaciones').attr("name"));
	$('#FrmObservacionesInforme').modal("show");
});

$('#btnAgregarLesionados').click(function(e){
	limpiaForm("#FrmLesionadoCasoSOAT"); 
	$('#idRegistroInvestigacionLesionadoSOAT').val($("#btnModuloGestionarLesionados").attr("name"));
	loadingSiglo('show','Agregar Lesionado...');

	$.ajax({
		type: 'POST',
		url: 'class/consultasManejoLesionados.php',
		data: "exe=consultarObservacionLesionadoPrincipal&idCaso="+$("#btnModuloGestionarLesionados").attr("name"),
		success: function(res) {
			var json_obj = $.parseJSON(res);
			$("#observacionesLesionadoFrm").val(json_obj.observaciones);
			loadingSiglo('hide','');
		}, error: function(res){
			loadingSiglo('hide','');
		}
	});

	$('#exeLesionados').val("registrarLesionados");
	$('#modalAgregarLesionados').modal("show");
});

function descargarInformeWord(conResultado = 'si'){
	var opcion = $("#btnDescargarInformeWord").attr("name");
	var aseguradora = $("#btnDescargarInformeWord").attr("idaseguradora");
	loadingSiglo('show','Cargando Link de Word...');
	$.ajax({
		type: 'POST',
		url: 'class/consultasBasicas.php',
		data: "exe=verificarDescargaInforme&idInvestigacion="+opcion+"&conResultado="+conResultado+"&aseguradora="+aseguradora,
		success: function(data)	{

			$("#modalConResultado").modal("hide");

			var arrayDatos = jQuery.parseJSON(data);
			var val1=1; var val2=1; var val3=1; var val4=1; var val5=1; var val6=1; var val7=1;
			var val8=1; var val9=1; var val10=1; var mensaje="";

			if (arrayDatos.validadorPoliza=="N"){
				val1=2;
				mensaje+="Debe Seleccionar Poliza<br>";
			}

			if (arrayDatos.validadorDiligenciaTomador=="N"){
				val2=2;
				mensaje+="Debe Ingresar Diligencia Tomador<br>";
			}

			if (arrayDatos.validadorConsultaRunt=="N"){
				val3=2;
				mensaje+="Debe Ingresar Consulta RUNT<br>";
			}

			if (arrayDatos.validadorInspeccion=="N"){
				val4=2;
				mensaje+="Debe Ingresar Inspeccion Vehiculo<br>";
			}

			if (arrayDatos.validadorRegistroAutoridades=="N"){
				val5=2;
				mensaje+="Debe Ingresar Registro Autoridades<br>";
			}

			if (arrayDatos.validadorVisitaLugarHechos=="N"){
				val6=2;
				mensaje+="Debe Ingresar Visita Lugar Hechos<br>";
			}

			if (arrayDatos.validadorFurips=="N"){
				val7=2;
				mensaje+="Debe Ingresar FURIPS<br>";
			}

			if (arrayDatos.validadorPuntoReferencia=="N"){
				val8=2;
				mensaje+="Debe Ingresar Punto Referencia<br>";
			}

			if (arrayDatos.validadorConclusiones=="N"){
				val9=2;
				mensaje+="Debe Ingresar Conclusiones<br>";
			}

			if (arrayDatos.validadorLesionados=="N"){
				val10=2;
				mensaje+="Debe Ingresar Lesionados<br>";
			}

			if (val1==2 || val2==2 || val3==2 || val4==2 || val5==2 || val6==2 || val7==2 || val8==2 || val9==2 || val10==2){
				$("#ContenidoErrorNonActualizable").html(mensaje);
				$('#ErroresNonActualizable').modal('show');
			}
			else{
				window.open(arrayDatos.ruta_informe, '_blank');
			}

			loadingSiglo('hide');
			return false;

		},  error: function(){
			$("#modalConResultado").modal("hide");
			loadingSiglo('hide');
		}
	});
}

$("#divModulosGestionar").on('click','a',function(){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');

	if (action=="btnDescargarInformeWord"){

		if($("#btnDescargarInformeWord").attr('idAseguradora') == 2 || $("#btnDescargarInformeWord").attr('idAseguradora') == 7){
			$("#modalConResultado").modal("show");
		}else{
			descargarInformeWord();
		}
	}
	else if (action=="btnModuloGestionarVehiculo"){

		loadingSiglo('show','Cargando Datos Vehiculo...');
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoVehiculosPoliza.php',
			data: "exe=consultarVehiculoInvestigacion&idCaso="+opcion,
			success: function(data){

				var arrayDatos = jQuery.parseJSON(data);

				if (arrayDatos.cantidad_registros_vehiculos>0){

					limpiaForm("#frmVehiculosSOAT");

					$('.campFrmVehiculo').attr('disabled', false);
					$("#tipoServicioVehiculoFrmVehiculoPoliza").val('0').trigger('change');
					$("#tipoVehiculoFrmVehiculoPoliza").val('0').trigger('change');
					$("#tipoVehiculoFrmVehiculoPoliza").val(arrayDatos.tipo_vehiculo).change();
					$("#placaVehiculoFrmVehiculoPoliza").val(arrayDatos.placa);
					$("#marcaVehiculoFrmVehiculoPoliza").val(arrayDatos.marca);
					$("#modeloVehiculoFrmVehiculoPoliza").val(arrayDatos.modelo);
					$("#lineaVehiculoFrmVehiculoPoliza").val(arrayDatos.linea);
					$("#colorVehiculoFrmVehiculoPoliza").val(arrayDatos.color);
					$("#numVinVehiculoFrmVehiculoPoliza").val(arrayDatos.numero_vin);
					$("#numSerieVehiculoFrmVehiculoPoliza").val(arrayDatos.numero_serie);
					$("#tipoServicioVehiculoFrmVehiculoPoliza").val(arrayDatos.tipo_servicio).change();
					$("#numChasisVehiculoFrmVehiculoPoliza").val(arrayDatos.numero_chasis);
					$("#numMotorVehiculoFrmVehiculoPoliza").val(arrayDatos.numero_motor);
					$('#idVehiculoFrmVehiculos').val(arrayDatos.id_vehiculo);
					
					loadingSiglo('hide');
					llenarTablaPolizasVehiculos();
					$('#exeFrmVehiculos').val('modificarVehiculos');
				}
				else{

					limpiaForm("#frmVehiculosSOAT");

					$('#idVehiculoFrmVehiculos').val('0');
					$("#tipoServicioVehiculoFrmVehiculoPoliza").val('0').trigger('change');
					$("#tipoVehiculoFrmVehiculoPoliza").val('0').trigger('change');
					$('#placaVehiculoFrmVehiculoPoliza').val("");
					$('#exeFrmVehiculos').val('NON');
					$('.campFrmVehiculo').attr('disabled', 'disabled');
					$('#BtnAddPolizaVehiculoCasoFrm').css('display', 'none');
					
					loadingSiglo('hide');
					llenarTablaGestionVehiculos();
					llenarTablaPolizasVehiculos();	
				}
				return false;
			}, error: function(){
				loadingSiglo('hide');
			}
		});

		$('#idInvestigacionFrmVehiculos').val(opcion);
		$('#ModuloGestionarLesionados').hide();
		$('#ModuloGestionarVehiculo').show();
		$('#ModuloGestionarInforme').hide();
		$('#ModuloGestionarMultimedia').hide();
		$('#ModuloGestionarInformeMuerte').hide();
		$('#ModuloGestionarPersonas').hide();
		$('#ModuloGestionarRepresentanteLegal').hide();
		$('#ModuloGestionarTestigos').hide();
		$('#ModuloGestionarDiligenciaFormato').hide();
		$('#ModuloGestionarObservaciones').hide();
		$('#ModuloEstadosInvestigacion').hide();
	}
	else{
		loadingSiglo('show','Esperando Autorización...');
		$.ajax({
			type: 'POST',
			url: 'class/consultasBasicas.php',
			data: "exe=consultarAutorizacion&idInvestigacion="+opcion,
			success: function(data){
				var arrayDatos = jQuery.parseJSON(data);

				if (arrayDatos.cantidad_autorizacion>0 && arrayDatos.autorizacion=="NR"){
					$("#ContenidoErrorNonActualizable").html("Requiere Autorizacion Para Poder Seguir Gestionando Esta Investigacion");
					$('#ErroresNonActualizable').modal('show');
					loadingSiglo('hide');
				}
				else{
					if (action=="btnModuloGestionarLesionados")	{
						loadingSiglo('show','Cargando Lesionados...');
						$.ajax({
							type: 'POST',
							url: 'class/consultasManejoVehiculosPoliza.php',
							data: "exe=consultarVehiculoInvestigacion&idCaso="+opcion,
							success: function(data)	{
								var arrayDatos = jQuery.parseJSON(data);

								$('#idCasoLesionados').val(opcion);
								loadingSiglo('hide');
								llenarTablaGestionLesionados();
								$('#ModuloGestionarInformeMuerte').hide();
								$('#ModuloGestionarLesionados').show();
								$('#ModuloGestionarVehiculo').hide();
								$('#ModuloGestionarInforme').hide();
								$('#ModuloGestionarMultimedia').hide();
								$('#ModuloGestionarPersonas').hide();
								$('#ModuloGestionarRepresentanteLegal').hide();
								$('#ModuloGestionarTestigos').hide();
								$('#ModuloGestionarDiligenciaFormato').hide();
								$('#ModuloGestionarObservaciones').hide();
								$('#ModuloEstadosInvestigacion').hide();
								loadingSiglo('show','Cargando Resultado Aseguradora...');
								$.ajax({
									type: 'POST',
									url: 'class/consultasBasicas.php',
									data: "exe=consultarResultadosAseguradora&idCaso="+opcion,
									success: function(res) {
										var json_obj = $.parseJSON(res);
										var options = '';
										for (var i = 0; i < json_obj.length; i++) {
											options += '<option value="' + json_obj[i].valor + '">' + json_obj[i].descripcion + '</option>';
										}
										$("#resultadoLesionadoFrm").html(options);
										loadingSiglo('hide');
										return false;
									}, error: function(){
										loadingSiglo('hide');
									}
								});

								return false;
							}, error: function(){
								loadingSiglo('hide');
							}
						});
					}
					else if (action=="btnModuloGestionarInforme"){

						$('#idInvestigacionFrmInforme').val(opcion);

						loadingSiglo('show','Cargando detalle de caso...');

						$.ajax({
							type: 'POST',
							url: 'class/consultasManejoVehiculosPoliza.php',
							data: "exe=consultarVehiculoInvestigacion&idCaso="+opcion,
							success: function(data)	{
								var arrayDatos = jQuery.parseJSON(data);

								if (arrayDatos.cantidad_registros_vehiculos>0){

									$.ajax({
										type: 'POST',
										url: 'class/consultasManejoCasoSOAT.php',
										data: "exe=consultarDetalleCasoSOAT&idCaso="+opcion,
										success: function(data) {

											var arrayDatos = jQuery.parseJSON(data);

											limpiaForm("#frmInformeSOAT");

											$("#selectMotivoOcurrencia").val('0').trigger('change');
											$("#visitaLugarHechosInformeFrm").val('0').trigger('change');
											$("#registroAutoridadesTecnicaInformeFrm").val('0').trigger('change');
											$("#inspeccionTecnicaInformeFrm").val('0').trigger('change');
											$("#ConsultaRUNTInformeFrm").val('0').trigger('change');
											$("#causalNoConsultaRUNTInformeFrm").val('0').trigger('change');
											$("#selectAConsideracion").val("").trigger("change");
											$("#versionesHechosDiferenteInformeFrm").val("").trigger("change");
											$("#versionesHechosDiferenteInformeFrm").val(arrayDatos.versiones_diferentes).change();
											$("#visitaLugarHechosInformeFrm").val(arrayDatos.visita_lugar_hechos).change();
											$("#contactoTomadorInformeFrm").val(arrayDatos.resultado_diligencia_tomador).change();
											$("#observacionContactoTomadorInformeFrm").val(arrayDatos.observaciones_diligencia_tomador);
											$("#registroAutoridadesTecnicaInformeFrm").val(arrayDatos.registro_autoridades).change();						
											$("#inspeccionTecnicaInformeFrm").val(arrayDatos.inspeccion_tecnica).change();						
											$("#ConsultaRUNTInformeFrm").val(arrayDatos.consulta_runt).change();						
											$("#causalNoConsultaRUNTInformeFrm").val(arrayDatos.causal_runt).change();							
											$("#puntoReferenciaInformeFrm").val(arrayDatos.punto_referencia);							
											$("#furipsInformeFrm").val(arrayDatos.furips);
											$("#conclusionesInformeFrm").val(arrayDatos.conclusiones);
											$("#cantidadOcupantesInformeFrm").val(arrayDatos.numero_ocupantes_vehiculo);		
											$("#cantidadPersonasTrasladoInformeFrm").val(arrayDatos.cantidad_personas_traslado);																									
											$('#idInvestigacionFrmInforme').val(arrayDatos.id_investigacion);
											$("#selectMotivoOcurrencia option[value="+ arrayDatos.motivo_ocurrencia +"]").prop("selected",true).trigger("change");

											if (arrayDatos.a_consideracion){
												$("#aConsideracion").css("display", "block");
												$("#divMotivoOcurrencia").css("display", "block");
												for (var i = 0; i < arrayDatos.resAconsideracion.length; i++){
													$("#selectAConsideracion option[value="+ arrayDatos.resAconsideracion[i] +"]").prop("selected",true).trigger("change");
												}
											}else{
												$("#aConsideracion").css("display", "none");
												$("#divMotivoOcurrencia").css("display", "none");
											}
											
											if(arrayDatos.ObsSMS){
												$("#contactoTomadorInformeFrm").val(4).change()
												$("#contactoTomadorInformeFrm").attr("disabled", true)
											}else{
												$("#contactoTomadorInformeFrm").val(arrayDatos.resultado_diligencia_tomador).change();
											}
											
											loadingSiglo('hide');

											return false;
										}, error: function(){
											loadingSiglo('hide');
										}
									});

									$('#ModuloGestionarInformeMuerte').hide();
									$('#ModuloGestionarLesionados').hide();
									$('#ModuloGestionarVehiculo').hide();
									$('#ModuloGestionarInforme').show();
									$('#ModuloGestionarMultimedia').hide();
									$('#ModuloGestionarPersonas').hide();
									$('#ModuloGestionarRepresentanteLegal').hide();
									$('#ModuloGestionarTestigos').hide();
									$('#ModuloGestionarDiligenciaFormato').hide();
									$('#ModuloGestionarObservaciones').hide();
									$('#ModuloEstadosInvestigacion').hide();									
								}
								else{
									$("#ContenidoErrorNonActualizable").html("Debe Completar Primero El Modulo Vehiculos");
									$('#ErroresNonActualizable').modal('show');
									loadingSiglo('hide');
								}

								return false;
							}, error: function(){
								loadingSiglo('hide');
							}
						});
					}
					else if (action=="btnModuloGestionarMultimedia") {

						$('#ModuloGestionarInformeMuerte').hide();
						$('#ModuloGestionarLesionados').hide();
						$('#ModuloGestionarVehiculo').hide();
						$('#ModuloGestionarInforme').hide();
						$('#ModuloGestionarMultimedia').show();
						$('#idInvestigacionFrmMultimedia').val(opcion);
						$('#ModuloGestionarPersonas').hide();
						$('#ModuloGestionarRepresentanteLegal').hide();
						$('#ModuloGestionarTestigos').hide();
						$('#ModuloGestionarDiligenciaFormato').hide();
						$('#ModuloGestionarObservaciones').hide();
						$('#ModuloEstadosInvestigacion').hide();

						loadingSiglo('hide');
						llenarTablaGestionMultimediaInvestigacion();
					}
					else if (action=="btnModuloGestionarInformeMuerte")	{

						$('#idInvestigacionFrmInformeMuerte').val(opcion);
						loadingSiglo('show','Cargando Información del Caso...');
						$.ajax({
							type: 'POST',
							url: 'class/consultasManejoCasoSOAT.php',
							data: "exe=consultarDetalleCasoSOAT&idCaso="+opcion,
							success: function(data)	{

								var arrayDatos = jQuery.parseJSON(data);

								limpiaForm("#frmInformeMuerteSOAT");
								$("#fiscaliaCasoInformeMuerteFrm").val(arrayDatos.fiscalia_lleva_caso);							
								$("#procesoFiscaliaInformeMuerteFrm").val(arrayDatos.proceso_fiscalia);
								$("#noCroquisInformeMuerteFrm").val(arrayDatos.croquis);							
								$('#siniestroInformeMuerteFrm').val(arrayDatos.no_siniestro);
								$('#hechosInformeMuerteFrm').val(arrayDatos.hechos);
								$('#conclusionesInformeMuerteFrm').val(arrayDatos.conclusiones);
								$('#idInvestigacionFrmInformeMuerte').val(arrayDatos.id_investigacion);

								loadingSiglo('hide');
								
								return false;
							}, error: function(){
								loadingSiglo('hide');
							}
						});

						$('#ModuloGestionarInformeMuerte').show();
						$('#ModuloGestionarLesionados').hide();
						$('#ModuloGestionarVehiculo').hide();
						$('#ModuloGestionarInforme').hide();
						$('#ModuloGestionarMultimedia').hide();
						$('#ModuloGestionarPersonas').hide();
						$('#ModuloGestionarRepresentanteLegal').hide();
						$('#ModuloGestionarTestigos').hide();
						$('#ModuloGestionarDiligenciaFormato').hide();
						$('#ModuloGestionarObservaciones').hide();
						$('#ModuloEstadosInvestigacion').hide();
					}
					else if (action=="btnModuloGestionarPersonas"){ /////FALTAAAAAAA

						loadingSiglo('show','Cargando Personas...');
						limpiaForm("#FrmPersonasCasoSOAT");

						$.ajax({
							type: 'POST',
							url: 'class/consultasManejoVehiculosPoliza.php',
							data: "exe=consultarVehiculoInvestigacion&idCaso="+opcion,
							success: function(data) {
								var arrayDatos = jQuery.parseJSON(data);

								if (arrayDatos.cantidad_registros_vehiculos>0) {
									$.ajax({
										type: 'POST',
										url: 'class/consultasBasicas.php',
										data: "exe=consultarResultadosAseguradora&idCaso="+opcion,
										success: function(res) {
											var json_obj = $.parseJSON(res);
											var options = '';
											for (var i = 0; i < json_obj.length; i++) {
												options += '<option value="' + json_obj[i].valor + '">' + json_obj[i].descripcion + '</option>';
											}
											$("#resultadoVictimaFrm").html(options);
											return false;
										}
									});

									$.ajax({
										type: 'POST',
										url: 'class/consultasManejoLesionados.php',
										data: "exe=consultarVictima&idInvestigacion="+opcion,
										success: function(data) {
											var arrayDatos = jQuery.parseJSON(data);

											if (arrayDatos.cantidad_registros_victima>0){
												limpiaForm("#FrmVictimaCasoSOAT");
												$("#descripcionVictimaPersonaFrm").attr("placeholder",arrayDatos.nombre_persona);
												$("#descripcionVictimaPersonaFrm").attr("name",arrayDatos.id_persona);
												$("#identificacionVictimaFrm").val(arrayDatos.identificacion);
												$("#descripcionVictimaFrm").attr("placeholder",arrayDatos.nombre_persona);
												$("#descripcionVictimaFrm").attr("name",arrayDatos.id_persona);
											}
											else{
												$("#descripcionVictimaPersonaFrm").attr("placeholder","NO HA SELECCIONADO NINGUNA VICTIMA");
												$("#descripcionVictimaPersonaFrm").attr("name","0");
											}

											return false;
										}
									});

									$.ajax({
										type: 'POST',
										url: 'class/consultasManejoLesionados.php',
										data: "exe=consultarReclamante&idInvestigacion="+opcion,
										success: function(data) {
											var arrayDatos = jQuery.parseJSON(data);

											if (arrayDatos.cantidad_registros_reclamante>0)	{
												$("#descripcionReclamantePersonaFrm").attr("placeholder",arrayDatos.nombre_persona);
												$("#descripcionReclamantePersonaFrm").attr("name",arrayDatos.id_persona);
												$("#identificacionReclamantePersonaFrm").val(arrayDatos.identificacion_persona);
											}
											else{
												$("#descripcionReclamantePersonaFrm").attr("placeholder","NO HA SELECCIONADO NINGUNA VICTIMA");
												$("#descripcionReclamantePersonaFrm").attr("name","0");
											}

											return false;
										}
									});

									$('#ModuloGestionarLesionados').hide();
									$('#ModuloGestionarVehiculo').hide();
									$('#ModuloGestionarInforme').hide();
									$('#ModuloGestionarMultimedia').hide();
									$('#ModuloGestionarPersonas').show();
									$('#ModuloGestionarRepresentanteLegal').hide();
									$('#ModuloGestionarTestigos').hide();
									$('#ModuloGestionarDiligenciaFormato').hide();
									$('#ModuloGestionarObservaciones').hide();
									$('#idRegistroInvestigacionPersonasSOAT').val(opcion);
									llenarTablaGestionBeneficiarios();
									$('#ModuloGestionarInformeMuerte').hide();
									$('#ModuloEstadosInvestigacion').hide();
								}
								else{
									$("#ContenidoErrorNonActualizable").html("Debe Completar Primero El Modulo Vehiculos");
									$('#ErroresNonActualizable').modal('show');
								}
								return false;
							}
						});

						loadingSiglo('hide');
					}
					else if (action=="btnSubirInformeFinalInvestigacion"){
						$('#fileInformeFinal').click();
						loadingSiglo('hide');
					}
					else if (action=="btnDeshabilitarInformeFinalInvestigacion"){
						loadingSiglo('show','Deshabilitando...');
						$.ajax({
							type: 'POST',
							url: 'class/consultasManejoCasoSOAT.php',
							data: "exe=deshabilitarInformeFinal&idInvestigacion="+opcion+"&idUsuario="+$('#btnLogout').attr('name'),				
							success: function(data) {
								if (data==1){
									cargarOpcionesInformeFinal($("#fileInformeFinal").attr("name"));
									loadingSiglo('hide');
									$("#ContenidoErrorNonActualizable").html("Informe Habilitado/Deshabilitado Satisfactoriamente");
									$('#ErroresNonActualizable').modal('show');
								}
								else if (data==2){
									loadingSiglo('hide');
									$("#ContenidoErrorNonActualizable").html("Error al ejecutar procedimiento");
									$('#ErroresNonActualizable').modal('show');
								}
							}, error: function(data){
								loadingSiglo('hide');
								$("#ContenidoErrorNonActualizable").html("Error al ejecutar procedimiento");
								$('#ErroresNonActualizable').modal('show');
							}
						});
					}
					else if (action=="btnModuloGestionarRepresentanteLegal"){
						loadingSiglo('show','Cargando Representante...');
						$.ajax({
							type: 'POST',
							url: 'class/consultasManejoCasoValidaciones.php',
							data: "exe=consultarRepresentanteLegal&idInvestigacion="+opcion,
							success: function(data) {
								var arrayDatos = jQuery.parseJSON(data);

								limpiaForm("#FrmVictimaCasoSOAT");

								$("#idInvestigacionFrmRepresentanteLegal").val(arrayDatos.id_investigacion);
								$("#correoRepresentanteLegalFrm").val(arrayDatos.correo_representante);
								$("#identificacionRepresentanteLegalFrm").val(arrayDatos.identificacion_representante);
								$("#tipoIdentificacionRepresentanteLegalFrm").val(arrayDatos.tipo_identificacion_representante).change();
								$("#apellidosRepresentanteLegalFrm").val(arrayDatos.apellidos_representante);
								$("#nombresRepresentanteLegalFrm").val(arrayDatos.nombre_representante);

								$('#ModuloGestionarInformeMuerte').hide();
								$('#ModuloGestionarLesionados').hide();
								$('#ModuloGestionarVehiculo').hide();
								$('#ModuloGestionarInforme').hide();
								$('#ModuloGestionarMultimedia').hide();
								$('#ModuloGestionarPersonas').hide();
								$('#ModuloGestionarRepresentanteLegal').show();
								$('#ModuloGestionarTestigos').hide();
								$('#ModuloGestionarDiligenciaFormato').hide();
								$('#ModuloGestionarObservaciones').hide();
								$('#ModuloEstadosInvestigacion').hide();
								$('#ModuloEstadosInvestigacion').hide();
								$('#idInvestigacionFrmRepresentanteLegal').val(opcion);

								loadingSiglo('hide');
								return false;
							},error: function(data){
								$('#ModuloGestionarInformeMuerte').hide();
								$('#ModuloGestionarLesionados').hide();
								$('#ModuloGestionarVehiculo').hide();
								$('#ModuloGestionarInforme').hide();
								$('#ModuloGestionarMultimedia').hide();
								$('#ModuloGestionarPersonas').hide();
								$('#ModuloGestionarRepresentanteLegal').show();
								$('#ModuloGestionarTestigos').hide();
								$('#ModuloGestionarDiligenciaFormato').hide();
								$('#ModuloGestionarObservaciones').hide();
								$('#ModuloEstadosInvestigacion').hide();
								$('#ModuloEstadosInvestigacion').hide();
								$('#idInvestigacionFrmRepresentanteLegal').val(opcion);
								loadingSiglo('hide');
							}
						});
					}
					else if(action=="btnModuloGestionarObservaciones"){
						loadingSiglo('show','Cargando Observaciones...');
						$.ajax({
							type: 'POST',
							url: 'class/consultasManejoVehiculosPoliza.php',
							data: "exe=consultarVehiculoInvestigacion&idCaso="+opcion,
							success: function(data)	{

								var arrayDatos = jQuery.parseJSON(data);

								if (arrayDatos.cantidad_registros_vehiculos>0){
									$("#idInvestigacionObservaciones").val($("#btnModuloGestionarObservaciones").attr("name"));
									loadingSiglo('hide');
									llenarTablaGestionObservaciones();
									$('#ModuloGestionarInformeMuerte').hide();
									$('#ModuloGestionarLesionados').hide();
									$('#ModuloGestionarVehiculo').hide();
									$('#ModuloGestionarInforme').hide();
									$('#ModuloGestionarMultimedia').hide();
									$('#ModuloGestionarPersonas').hide();
									$('#ModuloGestionarRepresentanteLegal').hide();
									$('#ModuloGestionarTestigos').hide();
									$('#ModuloGestionarDiligenciaFormato').hide();
									$('#ModuloGestionarObservaciones').show();
									$('#ModuloEstadosInvestigacion').hide();
								}
								else{
									loadingSiglo('hide');
									$("#ContenidoErrorNonActualizable").html("Debe Completar Primero El Modulo Vehiculos");
									$('#ErroresNonActualizable').modal('show');
								}

								return false;
							}, error: function(data){
								loadingSiglo('hide');
							}
						});
					}
					else if(action=="btnModuloGestionarTestigos"){
						loadingSiglo('show','Cargando Testigos...');
						$.ajax({
							type: 'POST',
							url: 'class/consultasManejoVehiculosPoliza.php',
							data: "exe=consultarVehiculoInvestigacion&idCaso="+opcion,
							success: function(data)	{

								var arrayDatos = jQuery.parseJSON(data);

								if (arrayDatos.cantidad_registros_vehiculos>0){
									$("#idInvestigacionTestigos").val($("#btnModuloGestionarTestigos").attr("name"));
									loadingSiglo('hide');
									llenarTablaGestionTestigos();
									$('#ModuloGestionarInformeMuerte').hide();
									$('#ModuloGestionarLesionados').hide();
									$('#ModuloGestionarVehiculo').hide();
									$('#ModuloGestionarInforme').hide();
									$('#ModuloGestionarMultimedia').hide();
									$('#ModuloGestionarPersonas').hide();
									$('#ModuloGestionarRepresentanteLegal').hide();
									$('#ModuloGestionarTestigos').show();
									$('#ModuloGestionarDiligenciaFormato').hide();
									$('#ModuloGestionarObservaciones').hide();
									$('#ModuloEstadosInvestigacion').hide();
								}
								else{
									loadingSiglo('hide');
									$("#ContenidoErrorNonActualizable").html("Debe Completar Primero El Modulo Vehiculos");
									$('#ErroresNonActualizable').modal('show');
								}

								return false;
							}, error: function(data){
								loadingSiglo('hide');
							}
						});
					}
					else if(action=="btnModuloGestionarDiligenciaFormato") {
						loadingSiglo('show','Cargando Diligenciamiento...');
						$.ajax({
							type: 'POST',
							url: 'class/consultasManejoVehiculosPoliza.php',
							data: "exe=consultarVehiculoInvestigacion&idCaso="+opcion,
							success: function(data)	{

								var arrayDatos = jQuery.parseJSON(data);

								if (arrayDatos.cantidad_registros_vehiculos>0){
									$("#idInvestigacionFrmDiligencia").val($("#btnModuloGestionarDiligenciaFormato").attr("name"));									

									$.ajax({
										type: 'POST',
										url: 'class/consultasManejoCasoSOAT.php',
										data: "exe=consultarPersonaDiligenciaFormato&idInvestigacion="+opcion,
										success: function(data) {

											var arrayDatos = jQuery.parseJSON(data);
											$("#personaDiligenciaFormatoFrm").val(arrayDatos.diligencia_formato_declaracion).change();
											destruirDaterangepicker("#fechaDiligenciaFormatoFrm");
											$("#fechaDiligenciaFormatoFrm").val(arrayDatos.fecha_diligencia_formato_declaracion);
											convertirDaterangepicker("#fechaDiligenciaFormatoFrm");
											if (arrayDatos.diligencia_formato_declaracion==2) {
												$("#nombreAcompananteDiligenciFormatoFrm").val(arrayDatos.nombre);
												$("#tipoIdentificacionAcompananteDiligenciFormatoFrm").val(arrayDatos.tipo_identificacion).change();
												$("#identificacionAcompananteDiligenciFormatoFrm").val(arrayDatos.identificacion);
												$("#telefonoAcompananteDiligenciFormatoFrm").val(arrayDatos.telefono);
												$("#direccionAcompananteDiligenciFormatoFrm").val(arrayDatos.direccion);
												$("#relacionAcompananteDiligenciFormatoFrm").val(arrayDatos.relacion);
											}
											else if (arrayDatos.diligencia_formato_declaracion==4 || arrayDatos.diligencia_formato_declaracion==5) {
												$("#observacionDiligenciaFormato").val(arrayDatos.observacion_diligencia_formato_declaracion);
											}

											loadingSiglo('hide');
											llenarTablaGestionLesionadosDiligencia();
											$('#ModuloGestionarInformeMuerte').hide();
											$('#ModuloGestionarLesionados').hide();
											$('#ModuloGestionarVehiculo').hide();
											$('#ModuloGestionarInforme').hide();
											$('#ModuloGestionarMultimedia').hide();
											$('#ModuloGestionarPersonas').hide();
											$('#ModuloGestionarRepresentanteLegal').hide();
											$('#ModuloGestionarTestigos').hide();
											$('#ModuloGestionarDiligenciaFormato').show();
											$('#ModuloGestionarObservaciones').hide();
											$('#ModuloEstadosInvestigacion').hide();

											return false;
										}, error: function(data){
											$('#ModuloGestionarInformeMuerte').hide();
											$('#ModuloGestionarLesionados').hide();
											$('#ModuloGestionarVehiculo').hide();
											$('#ModuloGestionarInforme').hide();
											$('#ModuloGestionarMultimedia').hide();
											$('#ModuloGestionarPersonas').hide();
											$('#ModuloGestionarRepresentanteLegal').hide();
											$('#ModuloGestionarTestigos').hide();
											$('#ModuloGestionarDiligenciaFormato').show();
											$('#ModuloGestionarObservaciones').hide();
											$('#ModuloEstadosInvestigacion').hide();
											loadingSiglo('hide');
										}
									});
								}
								else{
									loadingSiglo('hide');
									$("#ContenidoErrorNonActualizable").html("Debe Completar Primero El Modulo Vehiculos");
									$('#ErroresNonActualizable').modal('show');
								}

								return false;
							},error: function(data){
								loadingSiglo('hide');
							}
						});
					}
					else if (action=="btnTerminarPlanillarCaso"){

						loadingSiglo('show','Aplicando Estado...');
						var form = "exe=terminarPlanillarCaso&usuario="+$('#btnLogout').attr('name')+"&idCaso="+$("#liTerminarPlanillarCaso").attr('name');
						
						$.ajax({
							type: 'POST',
							url: 'class/consultasManejoCasoSOAT.php',
							data: form,
							success: function(data) {
								if (data==1) {
									$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente.");							
									$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
									loadingSiglo('hide');
									$('#modalFrmCasosGM').modal('hide');
									$('#ErroresNonActualizable').modal('show');
								}
								else if (data==3) {
									$("#ContenidoErrorNonActualizable").html("Error. Ya se creo este estado");							
									$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
									loadingSiglo('hide');
									$('#modalFrmCasosGM').modal('hide');
									$('#ErroresNonActualizable').modal('show');
								}
								else{
									loadingSiglo('hide');
									alert("Upss, Algo salió Mal");
								}
							}, error: function(data){
								loadingSiglo('hide');
								alert("Upss, Algo salió Mal");
							}
						});
					}
					else if (action=="btnEstadosInvestigacion")	{
						loadingSiglo('hide');
						llenarTablaEventosInvestigacion();
						$('#idInvestigacionEstado').val(opcion);
						$('#ModuloGestionarInformeMuerte').hide();
						$('#ModuloGestionarLesionados').hide();
						$('#ModuloGestionarVehiculo').hide();
						$('#ModuloGestionarInforme').hide();
						$('#ModuloGestionarMultimedia').hide();
						$('#ModuloGestionarPersonas').hide();
						$('#ModuloGestionarRepresentanteLegal').hide();
						$('#ModuloGestionarTestigos').hide();
						$('#ModuloGestionarDiligenciaFormato').hide();
						$('#ModuloGestionarObservaciones').hide();
						$('#ModuloEstadosInvestigacion').show();
					}else{
						loadingSiglo('hide');
					}
				}
				return false;
			}, error: function(data){
				loadingSiglo('hide');
				alert("Upss! Algo salió Mal");
			}
		});
	}
});

$('#fileInformeFinal').on("change", function(){ 
	loadingSiglo('show','Subiendo Informe...');
	var formArchivoInformeFinal = new FormData();
	formArchivoInformeFinal.append("exe","subirArchivoInformeFinal");
	formArchivoInformeFinal.append("idInvestigacion",$("#fileInformeFinal").attr("name"));
	formArchivoInformeFinal.append("idUsuario",$('#btnLogout').attr('name'));
	formArchivoInformeFinal.append("informeFinal",this.files[0]);

	$.ajax({
		type: 'POST',
		url: 'class/consultasManejoCasoSOAT.php',
		data: formArchivoInformeFinal,
		cache: false,
		contentType: false,
		processData: false,
		success: function(data) {
			
			if (data==1){
				$('#fileInformeFinal').val('');
				cargarOpcionesInformeFinal($("#fileInformeFinal").attr("name"));
				loadingSiglo('hide');
				//$("#ContenidoErrorNonActualizable").html("Informe Subido Satisfactoriamente");
				//$('#ErroresNonActualizable').modal('show');
				$("#btnTerminarPlanillarCaso").click();
			}else if (data==6){
				cargarOpcionesInformeFinal($("#fileInformeFinal").attr("name"));
				loadingSiglo('hide');
				$("#ContenidoErrorNonActualizable").html("Informe Subido Satisfactoriamente. Hubo error al enviar notificacion a la Aseguradora");
				$('#ErroresNonActualizable').modal('show');
			}else{ 
				loadingSiglo('hide');
				if (data==2){
					$("#ContenidoErrorNonActualizable").html("Error al Subir Anexo");
					$('#ErroresNonActualizable').modal('show');
				}
				else if (data==3){
					$("#ContenidoErrorNonActualizable").html("No se pudo mover informe");
					$('#ErroresNonActualizable').modal('show');
				}
				else if (data==4){
					$("#ContenidoErrorNonActualizable").html("Tipo de archivo no permitido");
					$('#ErroresNonActualizable').modal('show');
				}
				else if (data==5){
					$("#ContenidoErrorNonActualizable").html("No ha seleccionado ningun archivo");
					$('#ErroresNonActualizable').modal('show');
				}				
			}
			return false;
		}, error: function(data){
			loadingSiglo('hide');
			alert("Upss! Algo salió Mal");
		}
	});
});

$("#aseguradoraFrmCasosGM").change(function() {

	$("#tipoAuditoriaFrmCasosGM").prop('disabled', false);	
	$("#tipoAuditoriaFrmCasosGM").val(0);
	if($("#exeFrmCasosGM").val() == "registrarCasoSOAT" && $('#aseguradoraFrmCasosGM option:selected').val() == 1 && $("#btnLogout").attr('tp') != 2){
		$("#tipoAuditoriaFrmCasosGM").val(1);
		$("#tipoAuditoriaFrmCasosGM").prop('disabled', true);
	}

	$("#divFechaConocimientoFrmCasosGM").css('display', 'none');
	$("#divInvestigadorFrmCasosGM").removeClass('col-sm-12').addClass('col-sm-6');
	$("#fechaConocimientoFrmCasosGM").val('');
	if($('#aseguradoraFrmCasosGM option:selected').val() == 2 && $("#exeFrmCasosGM").val() == "registrarCasoSOAT"){
		$("#divFechaConocimientoFrmCasosGM").css('display', 'block');
		$("#divInvestigadorFrmCasosGM").removeClass('col-sm-6').addClass('col-sm-12');
	}

	mostrarTipoCasosAseguradora($('#aseguradoraFrmCasosGM option:selected').val(),"#tipoCasoFrmCasosGM","Global");
});

$("#DivTablas14").on('click','a',function(){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');
	//$(".divOcultar").hide();

	if (action=="btnCrearAmpliacionCasoSoat"){
		limpiaForm("#frmAmpliarInvestigacion");	
		$('#idCasoFrmAmpliarInvestigacion').val(opcion);
		$('#modalAmpliacionCasoSOAT').modal('show');
	}
	//else if (action=="btnDescargarAudioCasoSoat"){
	//	$.ajax({
	//		type: 'POST',
	//		url: 'class/forzarDescargaArchivos.php',
	//		data: "ruta="+opcion,					
	//		success: function(data) {
	//			
	//			
	//		}, error: function(data){
	//			loadingSiglo('hide');
	//			alert("Upss! Algo salió Mal")
	//		}
	//	});
	//}
	else if (action=="btnEditarCasoSoat"){
		loadingSiglo('show','Cargando Edición...');
		$("#tipoAuditoriaFrmCasosGM").prop('disabled', false);
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoCasoSOAT.php',
			data: "exe=consultarCasoSOAT&idCaso="+opcion,					
			success: function(data) {
				var json_obj = $.parseJSON(data);
				$("#aseguradoraFrmCasosGM").select2("destroy");
				$("#aseguradoraFrmCasosGM").val(json_obj.id_aseguradora);
				$("#aseguradoraFrmCasosGM").select2();	
				destruirDaterangepicker("#fechaAccidenteFrmCasosGM");
				$("#fechaAccidenteFrmCasosGM").val(json_obj.fecha_accidente);
				convertirDaterangepicker("#fechaAccidenteFrmCasosGM",2);
				$("#lugarAccidenteFrmCasosGM").val(json_obj.lugar_accidente);
				if(json_obj.ciudad_ocurrencia == null){
					$("#ciudadFrmCasosGM").val('0').trigger('change.select2');
				}else{
					$("#ciudadFrmCasosGM").val(json_obj.ciudad_ocurrencia).trigger('change.select2');
				}
				$("#investigadorFrmCasosGM").val(json_obj.id_investigador).change();
				if(json_obj.tipo_zona == null){
					$("#tipoZonaFrmCasosGM").val('0').trigger('change.select2');
				}else{
					$("#tipoZonaFrmCasosGM").val(json_obj.tipo_zona).trigger('change.select2');
				}
				$("#tipoAuditoriaFrmCasosGM").val(json_obj.id_tipo_auditoria).change();

				if(json_obj.id_aseguradora == 1 && $("#btnLogout").attr('tp') != 2){					
					$("#tipoAuditoriaFrmCasosGM").prop('disabled', true);	
				}

				$("#diasDeInvestigadorFrmCasosGM").val(json_obj.dias_investigador);
				$("#barrioAccidenteFrmCasosGM").val(json_obj.barrio_accidente);
				

				$("#divFechaConocimientoFrmCasosGM").css('display', 'none');
				$("#divInvestigadorFrmCasosGM").removeClass('col-sm-12').addClass('col-sm-6');
				$("#fechaConocimientoFrmCasosGM").val('');
				if($('#aseguradoraFrmCasosGM option:selected').val() == 2){
					$("#divFechaConocimientoFrmCasosGM").css('display', 'block');
					$("#divInvestigadorFrmCasosGM").removeClass('col-sm-6').addClass('col-sm-12');
					$("#fechaConocimientoFrmCasosGM").val(json_obj.fecha_conocimiento);
				}
				
				$("#idCasoFrmCasosGM").val(json_obj.id);
				$("#exeFrmCasosGM").val("modificarCasoSOAT");
				$("#tipoCasoFrmCasosGM").prop("disabled", true);

				loadingSiglo('show','Cargando Amparos...');
				$.ajax({
					type: 'POST',
					url: 'class/consultasBasicas.php',
					data: "exe=consultarAmparosAseguradora&idAseguradora="+json_obj.id_aseguradora+"&tipoCasos=Global",
					success: function(res) {
						$("#tipoCasoFrmCasosGM").select2("destroy");
						var json_obj_2 = $.parseJSON(res);
						var options = '';
						for (var i = 0; i < json_obj_2.length; i++) {
							if(json_obj.tipo_caso == json_obj_2[i].valor){
								$("#tipoCasoFrmCasosGM").prop("disabled", false);
								options += '<option selected="selected" value="' + json_obj_2[i].valor + '">' + json_obj_2[i].descripcion + '</option>';
							}else{
								options += '<option value="' + json_obj_2[i].valor + '">' + json_obj_2[i].descripcion + '</option>';
							}															   
						}
						$("#tipoCasoFrmCasosGM").html(options);
						$("#tipoCasoFrmCasosGM").select2();
						
						loadingSiglo('hide');

						tablaIndicativosAseguradoraGM();
						
						$('#modalFrmCasosGM').modal("show");
					}, error: function(data){
						loadingSiglo('hide');
						alert("Upss! Algo salió Mal")
					}
				});
			}, error: function(data){
				loadingSiglo('hide');
				alert("Upss! Algo salió Mal")
			}
		});
	}
	else if (action=="btnEliminarCasoSoat"){
		ModalRegistrosOut("Eliminar",opcion,"tablaGestionCasosSOAT","eliminarCasoSOAT");
	}
	else if (action=="btnAsignarAnalistaCasoSoat"){
		consultarAsignarAnalista(opcion);					
	}
	else if (action=="btnGestionarCasoSoat"){	
		gestionarInvestigacion(opcion);
	}
	else if (action=="btnCambiarEstado"){	
		$("div[name=divPlanoCambioEstado]").hide();
		$("#observacionCambioEstadoFrm").val('');
		$("#idCasoSoatCambioEstado").val(opcion);
		$('#modalCambioEstado').modal('show');
	}
	else if (action=="btnAutorizarInvestigacionSOAT"){	
		ModalRegistrosOut("Autorizar",opcion,"NR","autorizarCasoSOAT");
	}
	else if (action=="btnActualizarCargueCasoSoat"){
		loadingSiglo('show','Actualizando Cargue...');	
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoCasoSOAT.php',
			data:  "exe=actualizarCargueInvestigacionSOAT&idInvestigacion="+opcion+"&idUsuario="+$('#btnLogout').attr('name'),	
			success: function(data) {		

				var json_obj = $.parseJSON(data);
				if (data==1) {
					loadingSiglo('hide');	
					$("#ContenidoErrorNonActualizable").html("Proceso ejecutado Satisfactoriamente");
					$('#ErroresNonActualizable').modal('show');
				} 
				else {
					loadingSiglo('hide');	
					$("#ContenidoErrorNonActualizable").html("error al ejecutar proceso");
					$('#ErroresNonActualizable').modal('show');
				}					
				return false;
			}, error: function(data){
				loadingSiglo('hide');	
			}	
		});
	}
	else if (action=="btnEditarAsignacionCasoSOAT"){	
		
		limpiaForm("#frmAsignarInvestigacion");
		loadingSiglo('show','Mostrando Asignación...');

		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoUsuarios.php',
			data:  "exe=consultarUsuario&registroUsuario="+$('#btnLogout').attr('name'),	
			success: function(data) {		

				var json_obj = $.parseJSON(data);
				if (jQuery.isEmptyObject(json_obj)) {
					$("#ContenidoErrorNonActualizable").html("error al consultar");
					$('#ErroresNonActualizable').modal('show');
				} 
				else  {
					$('#idAseguradoraFrmAsignarInvestigacion').val(json_obj.id_aseguradora);
					mostrarTipoCasosAseguradora(json_obj.id_aseguradora,"#tipoCasoFrmAsignarInvestigacion","Asignado");
				}	

				$('#tipoCasoFrmAsignarInvestigacion').attr("disabled",false);
				$.ajax({
					type: 'POST',
					url: 'class/consultasManejoCasoSOAT.php',
					data:  "exe=consultarInformacionAsignacion&idInvestigacion="+opcion,	
					success: function(data) {		
						var json_obj = $.parseJSON(data);
						if (jQuery.isEmptyObject(json_obj)) {
							$("#ContenidoErrorNonActualizable").html("error al consultar");
							$('#ErroresNonActualizable').modal('show');
						} 
						else {
							destruirDaterangepicker('#fechaEntregaFrmAsignarInvestigacion');
							$('#fechaEntregaFrmAsignarInvestigacion').val(json_obj.fecha_entrega);
							convertirDaterangepicker('#fechaEntregaFrmAsignarInvestigacion');
							$('#tipoCasoFrmAsignarInvestigacion').val(json_obj.tipo_caso).change();
							$('#motivoInvestigacionFrmAsignarInvestigacion').val(json_obj.motivo_investigacion);							
						}			
						loadingSiglo('hide');		
						return false;
					}, error: function(data){
						loadingSiglo('hide');
						alert("Upss, Algo salió Mal");
					}
				});

				$('#tipoCasoFrmAsignarInvestigacion').attr("disabled",true);
				$('#idCasoFrmAsignarInvestigacion').val(opcion);
				$('#exeFrmAsignarInvestigacion').val("modificarAsignacionInvestigacion");
				$('#modalFrmAsignarInvestigacion').modal("show");

				return false;
			}, error: function(data){
				loadingSiglo('hide');
				alert("Upss, Algo salió Mal");
			}
		});
	}else if (action=="btnAutorizarFacturacionCasoSoat"){
		llenarTablaDuplicadoCasosAutorizadosFacturacion(opcion);
	}else if (action=="btnAsignarInvestigadorCuentaCobroSoat"){
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoCasoSOAT.php',
			data: "exe=consultarInformacionAsignarInvestigadorCuentaCobro&idCaso="+opcion,
			success: function(data) {
				alert(data);
				var json_obj = $.parseJSON(data);
				
				
				if (json_obj.resultado==1)
				{
					$('#formSeleccionarInvestigadorCuentaCobro').show();	
					$('#divButtonAsignarInvestigadorCuentaCobro').show();

				}else if (json_obj.resultado==2){
					$('#formSeleccionarInvestigadorCuentaCobro').hide();
					$('#divButtonAsignarInvestigadorCuentaCobro').hide();	

				}
				$('#investigadorAsignarInvestigadorCuentaCobroFrm').val(json_obj.id_investigador).change();
				$('#periodoAsignarInvestigadorCuentaCobroFrm').val(json_obj.id_periodo).change();
				$('#resultadoAsignarInvestigadorCuentaCobroFrm').val(json_obj.id_resultado).change();
				$('#tipoAuditoriaAsignarInvestigadorCuentaCobroFrm').val(json_obj.id_tipo_auditoria).change();
				$('#tipoZonaAsignarInvestigadorCuentaCobroFrm').val(json_obj.tipo_zona).change();

				$('#tipoCasoAsignarInvestigadorCuentaCobroFrm').val(json_obj.tipo_caso).change();
				$('#idCasoSoatInvestigadorCuentaCobro').val(opcion);
				$('#resultadoAsignacionInvestigadorCuentaCobro').html(json_obj.descripcion_resultado);
				$('#modalAsignarInvestigadorCuentaCobro').modal("show");			
			}
		});
	}		
});

function cargarOpcionesInformeFinal(idInvestigacion){
	loadingSiglo('show','Cargando opciones Informe...');
	$.ajax({
		type: 'POST',
		url: 'class/consultasManejoCasoSOAT.php',
		data: "exe=consultarInformeFinalInvestigacion&idInvestigacion="+idInvestigacion,
		success: function(data) {			
			var json_obj = $.parseJSON(data);

			if (json_obj.cantidad_informe2>0){
				if (json_obj.vigente=="s"){
					$("#btnDeshabilitarInformeFinalInvestigacion2").html("Deshabilitar");
				}else{
					$("#btnDeshabilitarInformeFinalInvestigacion2").html("Habilitar");
				}
				$("#btnDescargarInformeFinalInvestigacion2").attr('href','data/informes2/'+json_obj.ruta);	
				$("#btnDeshabilitarInformeFinalInvestigacion2").attr('name',idInvestigacion);	
				$('.divDeshabilitarInformeFinal2').show();	
			}else{
				$(".divDeshabilitarInformeFinal2").hide();	
			}

			if (json_obj.cantidad_informe>0){
				if (json_obj.vigente=="s"){
					$("#btnDeshabilitarInformeFinalInvestigacion").html("Deshabilitar");
				}else{
					$("#btnDeshabilitarInformeFinalInvestigacion").html("Habilitar");
				}
				$("#btnDescargarInformeFinalInvestigacion").attr('href','data/informes/'+json_obj.ruta);	
				$("#btnDeshabilitarInformeFinalInvestigacion").attr('name',idInvestigacion);	
				$('.divDeshabilitarInformeFinal').show();	
			}else{
				$(".divDeshabilitarInformeFinal").hide();	
			}

			if (json_obj.cantidad_soporte>0 || json_obj.cantidad_carta_presentacion>0){
				$('#archivosAnexosInvestigaciones').show();
				if (json_obj.cantidad_soporte>0 && json_obj.cantidad_carta_presentacion>0){
					$('#divDivisorAnexosInvestigacion').show();
					$("#btnDescargarSoporteInvestigacion").attr('href','data/soporte_asignacion_investigacion/'+json_obj.ruta2_soporte);	
					$('#divDescargarSoporteInvestigacion').show();
					$("#btnDescargarCartaPresentacionInvestigacion").attr('href','data/soporte_asignacion_investigacion/'+json_obj.ruta2_carta_presentacion);	
					$('#divDescargarCartaPresentacionInvestigacion').show();
				}else if (json_obj.cantidad_soporte>0 && json_obj.cantidad_carta_presentacion==0){
					$('#divDivisorAnexosInvestigacion').hide();
					$("#btnDescargarSoporteInvestigacion").attr('href','data/soporte_asignacion_investigacion/'+json_obj.ruta2_soporte);	
					$('#divDescargarSoporteInvestigacion').show();
					$('#divDescargarCartaPresentacionInvestigacion').hide();
				}else if (json_obj.cantidad_soporte==0 && json_obj.cantidad_carta_presentacion>0){
					$('#divDivisorAnexosInvestigacion').hide();
					$("#btnDescargarCartaPresentacionInvestigacion").attr('href','data/soporte_asignacion_investigacion/'+json_obj.ruta2_carta_presentacion);	
					$('#divDescargarSoporteInvestigacion').hide();
					$('#divDescargarCartaPresentacionInvestigacion').show();
				}
			}else{
				$('#archivosAnexosInvestigaciones').hide();	
			}
			loadingSiglo('hide');
		}, error: function(data){
			loadingSiglo('hide');
		}
	});
}

$("#DivTablas22").on('click','a',function(){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');

	if (action=="btnRemoverIndicativoValidaciones"){
		var table = $('#tablaIndicativosAseguradoraFrmCasosValidaciones').DataTable();
		var data=table.row('.selected').data();

		if ( !table.rows( '.selected' ).any() ) {
			$("#ContenidoErrorNonActualizable").html("No ha seleccionado ningun Indicativo para eliminar");
			$('#ErroresNonActualizable').modal('show');
		}else{
			$('#tablaIndicativosAseguradoraFrmCasosValidaciones').DataTable().row('.selected').remove().draw( false );
		}
	}
});

$("#DivTablas13").on('click','a',function(){
	var opcion=$(this).attr('name');
	var action=$(this).attr('id');

	if (action=="btnRemoverIndicativoGM"){

		var table = $('#tablaIndicativosAseguradoraFrmCasosGM').DataTable();
		var data=table.row('.selected').data();

		if ( !table.rows( '.selected' ).any() ) {
			$("#ContenidoErrorNonActualizable").html("No ha seleccionado ningun Indicativo para eliminar");
			$('#ErroresNonActualizable').modal('show');
		}else{
			$('#tablaIndicativosAseguradoraFrmCasosGM').DataTable().row('.selected').remove().draw( false );
		}
	}

	if (action=="btnEliminarIndicador"){
		ModalRegistrosOut("Eliminar",opcion,"tablaIndicativosAseguradoraFrmCasosGM","eliminarIndicadorCaso");
	};
});

$('#BtnAddIndicativosAseguradoraValidaciones').click(function(e){
	var val1=1; var val2=1; var val3=1; var val4=1; 
	var mensaje=""; 

	if ($('#indicativoAseguradoraFrmCasosValidaciones').val()==""){
		val1=2;
		mensaje+="Debe Ingresar Identificador<br>";
	}else{
		val1=1;
	}

	if ($('#fechaAsignacionFrmCasosValidaciones').val()==""){
		val2=2;
		mensaje+="Debe Ingresar Fecha Asignacion<br>";
	}else{
		val2=1;
	}

	if ($('#fechaEntregaFrmCasosValidaciones').val()==""){
		val3=2;
		mensaje+="Debe Ingresar Fecha Entrega<br>";
	}else{
		val3=1;
	}

	var table = $('#tablaIndicativosAseguradoraFrmCasosValidaciones').DataTable();
	var val2=1;
	table.rows().every(function(){
		var data=this.data();
		if (data["indicativoCasosSOAT"]==$('#indicativoAseguradoraFrmCasosValidaciones').val())	{
			val4=2;
		}
	});

	if (val4==2){
		mensaje+="Este Indicativo Ya Fue Agregado En Este Caso<br>";
	}

	if (val1==2 || val2==2 || val3==2 || val4==2){
		$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
		$("#ContenidoErrorNonActualizable").html(mensaje);
		$('#ErroresNonActualizable').modal('show');
	}
	else{
		table.row.add( {
			"indicativoCasosSOAT": $('#indicativoAseguradoraFrmCasosValidaciones').val(),
			"fechaInicioCasosSOAT": $('#fechaAsignacionFrmCasosValidaciones').val(),
			"fechaEntregaCasosSOAT": $('#fechaEntregaFrmCasosValidaciones').val(),
			"opcionesIndicativoCasosSOAT": "<a class='btn btn-success'  id='btnRemoverIndicativoValidaciones'>REMOVER</a>"
		} ).draw( false );
		$('#indicativoAseguradoraFrmCasosValidaciones').val("");
	}
});

$('#BtnAddIndicativosAseguradora').click(function(e){
	var val1=1; var val2=1; var val3=1; var val4=1; 
	var mensaje=""; 

	if ($('#indicativoAseguradoraFrmCasosGM').val()==""){
		val1=2;
		mensaje+="Debe Ingresar Identificador<br>";
	}else{
		val1=1;
	}

	if ($('#fechaAsignacionFrmCasosGM').val()==""){
		val2=2;
		mensaje+="Debe Ingresar Fecha Asignacion<br>";
	}else{
		val2=1;
	}

	if ($('#fechaEntregaFrmCasosGM').val()==""){
		val3=2;
		mensaje+="Debe Ingresar Fecha Entrega<br>";
	}else{
		val3=1;
	}

	var table = $('#tablaIndicativosAseguradoraFrmCasosGM').DataTable();
	var val2=1;
	table.rows().every(function(){
		var data=this.data();
		if (data["indicativoCasosSOAT"]==$('#indicativoAseguradoraFrmCasosGM').val()){
			val4=2;
		}
	});

	if (val4==2){
		mensaje+="Este Indicativo Ya Fue Agregado En Este Caso<br>";
	}

	if (val1==2 || val2==2 || val3==2 || val4==2){
		$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
		$("#ContenidoErrorNonActualizable").html(mensaje);
		$('#ErroresNonActualizable').modal('show');
	}
	else{
		table.row.add( {
			"indicativoCasosSOAT": $('#indicativoAseguradoraFrmCasosGM').val(),
			"fechaInicioCasosSOAT": $('#fechaAsignacionFrmCasosGM').val(),
			"fechaEntregaCasosSOAT": $('#fechaEntregaFrmCasosGM').val(),
			"opcionesIndicativoCasosSOAT": "<a class='btn btn-success'  id='btnRemoverIndicativoGM'>REMOVER</a>"
		} ).draw( false );
		$('#indicativoAseguradoraFrmCasosGM').val("");
	}
});

$('#btnSubmitFrmCasosGM').click(function(e){

	var val1=1; var val2=1; var val3=1; var val4=1; var val5=1; var val6=1; var val7=1; var val8=1; var val9=1; var val10=1; var val11=1;
	var mensaje=""; 

	if ($('#aseguradoraFrmCasosGM option:selected').val()==0 || $('#aseguradoraFrmCasosGM option:selected').val()==""){
		val1=2;
		mensaje+="Debe Seleccionar Una Aseguradora<br>";
	}else{
		val1=1;
	}

	if (($('#tipoCasoFrmCasosGM option:selected').val()==0 || $('#tipoCasoFrmCasosGM option:selected').val()=="") && $('#exeFrmCasosGM').val()=="registrarCasoSOAT"){
		val2=2;
		mensaje+="Debe Seleccionar Tipo de Caso<br>";
	}else{
		val2=1;
	}

	if ($('#tipoAuditoriaFrmCasosGM option:selected').val()==0 || $('#tipoAuditoriaFrmCasosGM option:selected').val()==""){
		val8=2;
		mensaje+="Debe Seleccionar Tipo de Auditoria<br>";
	}else{
		val8=1;
	}

	if ($('#fechaAccidenteFrmCasosGM').val()==""){
		val3=2;
		mensaje+="Debe Ingresar Fecha de Accidente<br>";
	}else{
		val3=1;
	}

	if ($('#lugarAccidenteFrmCasosGM').val()==""){
		val4=2;
		mensaje+="Debe Ingresar Lugar de Accidente<br>";
	}else{
		val4=1;
	}

	if ($('#ciudadFrmCasosGM option:selected').val()==0 || $('#ciudadFrmCasosGM option:selected').val()==""){
		val5=2;
		mensaje+="Debe Seleccionar Una Ciudad<br>";
	}else{
		val5=1;
	}

	if ($('#tipoZonaFrmCasosGM option:selected').val()==0 || $('#tipoZonaFrmCasosGM option:selected').val()==""){
		val6=2;
		mensaje+="Debe Seleccionar Un Tipo de Zona<br>";
	}else{
		val6=1;
	}

	if ($('#investigadorFrmCasosGM option:selected').val()==0 || $('#investigadorFrmCasosGM option:selected').val()==""){
		val7=2;
		mensaje+="Debe Seleccionar Un Investigador<br>";
	}else{
		val7=1;
	}

	if ($('#diasDeInvestigadorFrmCasosGM').val() < 0){
		val9=2;
		mensaje+="Días Que Duró la Investigación<br>";
	}else{
		val9=1;
	}

	if ($('#barrioAccidenteFrmCasosGM').val()==""){
		val10=2;
		mensaje+="Debe Ingresar Barrio de Accidente<br>";
	}else{
		val10=1;
	}

	if($('#fechaConocimientoFrmCasosGM').val()==""){
		if($('#aseguradoraFrmCasosGM option:selected').val() == 2){
			val11=2
			mensaje+="Debe Ingresar Fecha de Conocimiento<br>";
		}else{
			val1=1
		}
	}else{
		val11=1
	}

	if (val1==2 || val2==2 || val3==2 || val4==2 || val5==2 || val6==2 || val7==2 || val8==2 || val9==2 || val10==2 || val11==2){
		$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
		$("#ContenidoErrorNonActualizable").html(mensaje);
		$('#ErroresNonActualizable').modal('show');
	}
	else{
		loadingSiglo('show','Cargando Información...');
		var identificadoresCasoSOAT=[];

		$('#tablaIndicativosAseguradoraFrmCasosGM').DataTable().rows().every(function(){
			var data=this.data();
			var data2={};									
			data2.identificador=data["indicativoCasosSOAT"];
			data2.fecha_asignacion=data["fechaInicioCasosSOAT"];
			data2.fecha_entrega=data["fechaEntregaCasosSOAT"];
			identificadoresCasoSOAT.push(data2);
		});

		var form = "exe="+$('#exeFrmCasosGM').val()
		+"&aseguradoraFrmCasosGM="+$('#aseguradoraFrmCasosGM option:selected').val()
		+"&tipoCasoFrmCasosGM="+$('#tipoCasoFrmCasosGM option:selected').val()
		+"&tipoAuditoriaFrmCasosGM="+$('#tipoAuditoriaFrmCasosGM option:selected').val()
		+"&fechaAccidenteFrmCasosGM="+$('#fechaAccidenteFrmCasosGM').val()
		+"&lugarAccidenteFrmCasosGM="+$('#lugarAccidenteFrmCasosGM').val()
		+"&ciudadFrmCasosGM="+$('#ciudadFrmCasosGM option:selected').val()
		+"&tipoZonaFrmCasosGM="+$('#tipoZonaFrmCasosGM option:selected').val()
		+"&investigadorFrmCasosGM="+$('#investigadorFrmCasosGM option:selected').val()
		+"&diasDeInvestigadorFrmCasosGM="+$('#diasDeInvestigadorFrmCasosGM').val()
		+"&idCasoFrmCasosGM="+$('#idCasoFrmCasosGM').val()
		+"&barrioAccidenteFrmCasosGM="+$("#barrioAccidenteFrmCasosGM").val()
		+"&fechaConocimientoFrmCasosGM="+$("#fechaConocimientoFrmCasosGM").val()
		+"&usuario="+$('#btnLogout').attr('name')
		+"&idCaso="+$('#idCasoFrmCasosGM').val()
		+"&identificadoresCaso="+JSON.stringify(identificadoresCasoSOAT);

		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoCasoSOAT.php',
			data: form,
			success: function(data) {
				var json_obj = $.parseJSON(data);
				if (json_obj.respuesta==1) {
					$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente. Codigo caso: "+json_obj.codigo);							
					$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
					$('#modalFrmCasosGM').modal('hide');
					loadingSiglo('hide');
					$('#ErroresNonActualizable').modal('show');
					gestionarInvestigacion(json_obj.caso);
				}
				else if(json_obj.respuesta==3){
					loadingSiglo('hide');
					$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente.");							
					$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
					$('#modalFrmCasosGM').modal('hide');
					loadingSiglo('hide');
					$('#ErroresNonActualizable').modal('show');
					gestionarInvestigacion(json_obj.caso);
				}
				else if (json_obj.respuesta==2){
					$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente.");							
					$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
					$('#modalFrmCasosGM').modal('hide');
					loadingSiglo('hide');
					$('#ErroresNonActualizable').modal('show');
				}
				else{
					loadingSiglo('hide');
					alert("error");
				}
			}, error: function(data){
				loadingSiglo('hide');
			}
		});
	}
});

$('#btnAsignarAnalista').click(function(e){

	if ($('#analistaAsignarAnalista option:selected').val()==0){
		$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});				
		$("#ContenidoErrorNonActualizable").html("Debe seleccionar un analista");
		$('#ErroresNonActualizable').modal('show');
	}
	else{
		loadingSiglo('show','Asignando Análista...');
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoCasoSOAT.php',
			data: "exe=asignarAnalistaCaso&idAnalista="+$('#analistaAsignarAnalista option:selected').val()+"&idCasoSoat="+$('#idCasoSoatAnalista').val()+"&idUsuario="+$('#btnLogout').attr('name'),
			success: function(data) {
				if (data==1) {
					$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente.");							
					$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
					$('#modalAsignarAnalista').modal('hide');
					loadingSiglo('hide');
					llenarTablaGestionCasosSOAT();
					$('#ErroresNonActualizable').modal('show');
				}
				else if(data==2){
					$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});				
					$("#ContenidoErrorNonActualizable").html("Error al crear Caso");
					loadingSiglo('hide');
					$('#ErroresNonActualizable').modal('show');
				}
				else{
					loadingSiglo('hide');
					alert("error");
				}
			},error: function(data){
				loadingSiglo('hide');
				alert("error");
			}
		});
	}
});

$('#BtnAddPolizaVehiculoCasoFrm').click(function(e){

	$('#exeFrmPolizas').val("registrarPolizas");
	$("#tipoIdentificacionTomadorPolizaFrm").val('0').trigger('change');
	$("#ciudadTomadorPolizaFrm").val('0').trigger('change');
	$("#ciudadExpedicionPolizaFrm").val('0').trigger('change');
	$("#aseguradoraPolizaFrm").val('0').trigger('change');
	limpiaForm("#frmPolizas");
	$('#FrmPolizas').modal("show");
});

//Capturar enter en formularios de busquedas de casos
$("#frmBusqCasosSOAT").keypress(function(e) {
	var code = (e.keyCode ? e.keyCode : e.which);
	if(code==13){
 		$('#btnBuscarInvestigacionSOAT').click();
	}
});

$("#frmBusqCasosValidaciones").keypress(function(e) {
	var code = (e.keyCode ? e.keyCode : e.which);
	if(code==13){
		$('#btnBuscarInvestigacionValIPS').click();
	}
});

$('#AsignarCensosAnalista').on("click", function(){
	$(".divOcultar").hide();
	$("#formularioAsignarCensoAnlista")[0].reset();
	$("#DivAsignarCensosAnalista").show();
});


$('#btnAsignarCensoAnlistas').on("click", function(){
	if ($('#aseguradoraCensoAnalista').val()!="" && $('#fEntregaCensoAnalista').val()!="" && $('#excelCensoAnalista').val()!=""){
		loadingSiglo('show', 'Asignando Censos...');
		var formDataAsigAnalista = new FormData();
		formDataAsigAnalista.append("exe","subirAsignarCensosAnalistas");
		formDataAsigAnalista.append("idUsuario",$('#btnLogout').attr('name'));
		formDataAsigAnalista.append("idAseguradora",$("#aseguradoraCensoAnalista").val());
		formDataAsigAnalista.append("fechaEntrega",$("#fEntregaCensoAnalista").val());
		formDataAsigAnalista.append("excelCensoAnalista",$("#excelCensoAnalista").prop("files")[0]);
	
		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoCasoSOAT.php',
			data: formDataAsigAnalista,
			cache: false,
			contentType: false,
			processData: false,
			success: function(data) {

				$('#excelCensoAnalista').val("");

				loadingSiglo('hide');

				var datax = JSON.parse(data);

				if(datax.aaData.length > 0){
					var filas="";
					var n=1;
					datax.aaData.forEach( function(fila, indice, array) {
					    filas+="<tr>";
					    	filas+="<td>"+n+"</td>";
					    	filas+="<td><b>"+fila.Codigo+"</b></td>";
					    	filas+="<td>"+fila.Placa+"</td>";
					    	filas+="<td>"+fila.FechaAccidente+"</td>";
					    	filas+="<td>"+fila.Analista+"</td>";
					    	filas+="<td>"+fila.Aseguradora+"</td>";
					    filas+="</tr>";
					    n++;
					});

					$("#tablaCasosAsignarAnalista tbody").html(filas);

					window.showAlert = function(){
					    alertify.alert('Bien! Se han Procesado <strong>'+datax.aaData.length+'</strong> Registros');
					}

					window.showAlert();
				}
				else{

					window.showAlert = function(){
					    alertify.alert('Upss! Se Han Procesado <strong>0</strong> Registros');
					}

					window.showAlert();
				}
				
				return false;
			}
		});
	}
	else{

		window.showAlert = function(){
		    alertify.alert('Complete los campos');
		}

		window.showAlert();
	}

	return false;
});
$('#btnBuscarCasos').click(function(e){	
	$(".divOcultar").hide();
	$('#tipoConsultaBuscar').val("buscarCasosFiltros");
	limpiaForm("#frmBusqCasosSOAT");
	limpiaForm("#frmBusqCasosValidaciones");
	$('#frmBuscarInvestigaciones').modal("show");
});

$('#btnBuscarCasosHistorico').click(function(e){	
	$(".divOcultar").hide();
	$('#tipoConsultaBuscar').val("buscarCasosFiltrosHistorico");
	limpiaForm("#frmBusqCasosSOAT");
	limpiaForm("#frmBusqCasosValidaciones");
	$('#frmBuscarInvestigaciones').modal("show");
});

$('#btnBuscarCasosSinInformeValidaciones').click(function(e){	
	$(".divOcultar").hide();
	$('#tipoConsultaBuscar').val("buscarCasoSinInformeValidaciones");
	llenarTablaGestionCasosValidaciones();
	$('#DivTablaGestionCasosSOAT').hide();
	$('#DivTablaGestionCasosValidacionesIPS').show();
});

$('#btnBuscarCasosSinInformeSOAT').click(function(e){	
	$(".divOcultar").hide();
	$('#tipoConsultaBuscar').val("buscarCasoSinInformeSOAT");
	llenarTablaGestionCasosSOAT();
	$('#DivTablaGestionCasosSOAT').show();
	$('#DivTablaGestionCasosValidacionesIPS').hide();
});

$('#btnBuscarCasosAsignadosSOAT').click(function(e){
	$(".divOcultar").hide();	
	$('#tipoConsultaBuscar').val("buscarCasoAsignadosSOAT");
	llenarTablaGestionCasosSOAT();
	$('#DivTablaGestionCasosSOAT').show();
	$('#DivTablaGestionCasosValidacionesIPS').hide();
});

$('#btnBuscarCasosAsignadosValidaciones').click(function(e){	
	$(".divOcultar").hide();
	$('#tipoConsultaBuscar').val("buscarCasoAsignadosValidaciones");
	llenarTablaGestionCasosValidaciones();
	$('#DivTablaGestionCasosSOAT').hide();
	$('#DivTablaGestionCasosValidacionesIPS').show();
});

$('#btnBuscarCasosAsignadosAseguradoraSOAT').click(function(e){	
	$(".divOcultar").hide();
	$('#tipoConsultaBuscar').val("buscarCasoAsignadosAseguradoraSOAT");
	llenarTablaGestionCasosSOAT();
	$('#DivTablaGestionCasosSOAT').show();
	$('#DivTablaGestionCasosValidacionesIPS').hide();
});

$('#btnBuscarCasosAsignadosAseguradoraValidaciones').click(function(e){	
	$(".divOcultar").hide();
	$('#tipoConsultaBuscar').val("buscarCasoAsignadosAseguradoraValidaciones");
	llenarTablaGestionCasosValidaciones();
	$('#DivTablaGestionCasosSOAT').hide();
	$('#DivTablaGestionCasosValidacionesIPS').show();
});

$('#btnBuscarInvestigacionSOAT').click(function(e){
	$(".divOcultar").hide();
	var val1=1; var val2=1; var val3=1; var val4=1; var val5=1; var val6=1; var val7=1; 
	 var val8=1; var val9=1; var val10=1; 

	if ($('#codigoFrmBuscarSOAT').val()==""){
		val1=2;
	}else{
		val1=1;
	}

	if ($('#nombresFrmBuscarSOAT').val()==""){
		val2=2;
	}else{
		val2=1;
	}

	if ($('#apellidosFrmBuscarSOAT').val()==""){
		val3=2;
	}else{
		val3=1;
	}

	if ($('#identificacionFrmBuscarSOAT').val()==""){
		val4=2;
	}else{
		val4=1;
	}

	if ($('#placaFrmBuscarSOAT').val()==""){
		val5=2;
	}else{
		val5=1;
	}

	if ($('#polizaFrmBuscarSOAT').val()==""){
		val6=2;
	}else{
		val6=1;
	}

	if ($('#identificadorFrmBuscarSOAT').val()==""){
		val7=2;
	}else{
		val7=1;
	}


	if ($('#fechaAccidenteFrmBuscarSOAT').val()==""){
		val8=2;
	}else{
		val8=1;
	}


	if ($('#fechaDigitacionFrmBuscarSOAT').val()==""){
		val9=2;
	}else{
		val9=1;
	}


	if ($('#aseguradoraFrmBuscarSOAT option:selected').val()==""){
		val10=2;
	}else{
		val10=1;
	}

	if (val1==2 && val2==2 && val3==2 && val4==2 && val5==2 && val6==2 && val7==2 && val8==2 && val9==2 && val10==2){
		$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
		$("#ContenidoErrorNonActualizable").html("Debe ingresar alguno de los campos de filtro");
		$('#ErroresNonActualizable').modal('show');
	}
	else{

		if ($('#tipoConsultaBuscar').val()=="buscarCasosFiltrosHistorico"){

			llenarTablaGestionCasosSOATHistorico();
			$('#DivTablaGestionCasosSOAT').hide();
			$('#DivTablaGestionCasosValidacionesIPS').hide();
			$('#DivTablaGestionCasosValidacionesIPSHistorico').hide();
			$('#DivTablaGestionCasosSOATHistorico').show();

		}else if ($('#tipoConsultaBuscar').val()=="buscarCasosFiltros"){
			llenarTablaGestionCasosSOAT();
			$('#DivTablaGestionCasosSOATHistorico').hide();
			$('#DivTablaGestionCasosValidacionesIPSHistorico').hide();
			$('#DivTablaGestionCasosValidacionesIPS').hide();
			$('#DivTablaGestionCasosSOAT').show();
		}
	}
});

$('#btnBuscarInvestigacionValIPS').click(function(e){
	$(".divOcultar").hide();
	var val1=1; var val2=1; var val3=1; var val4=1; 

	if ($('#codigoFrmBuscarValIPS').val()==""){
		val1=2;
	}else{
		val1=1;
	}

	if ($('#identificacionFrmBuscarValIPS').val()==""){
		val2=2;
	}else{
		val2=1;
	}

	if ($('#razonSocialFrmBuscarValIPS').val()==""){
		val3=2;
	}else{
		val3=1;
	}

	if ($('#identificadorFrmBuscarValIPS').val()==""){
		val4=2;
	}else{
		val4=1;
	}

	if (val1==2 && val2==2 && val3==2 && val4==2){
		$( ".cambiaClassColor" ).css( {"background":"#DC143C","color":"white"});
		$("#ContenidoErrorNonActualizable").html("Debe ingresar alguno de los campos de filtro");
		$('#ErroresNonActualizable').modal('show');
	}
	else{
		if ($('#tipoConsultaBuscar').val()=="buscarCasosFiltrosHistorico"){			

			llenarTablaGestionCasosValidacionesHistorico();	

			$('#DivTablaGestionCasosSOATHistorico').hide();
			$('#DivTablaGestionCasosValidacionesIPSHistorico').show();

			$('#DivTablaGestionCasosSOAT').hide();
			$('#DivTablaGestionCasosValidacionesIPS').hide();				
		}else if ($('#tipoConsultaBuscar').val()=="buscarCasosFiltros"){
			llenarTablaGestionCasosValidaciones();
			$('#DivTablaGestionCasosSOATHistorico').hide();
			$('#DivTablaGestionCasosValidacionesIPSHistorico').hide();

			$('#DivTablaGestionCasosSOAT').hide();
			$('#DivTablaGestionCasosValidacionesIPS').show();	
		}
	}
});

$('#RegistrarValidacionIPS').click(function(e){
	$(".divOcultar").hide();
	limpiaForm("#frmCasosValidaciones");
	$("#aseguradoraFrmCasosValidaciones").val('0').trigger('change');

	$("#ciudadEntidadFrmCasosValidaciones").val('0').trigger('change');

	$("#investigadorFrmCasosValidaciones").val('0').trigger('change');

	$('#exeFrmCasosValidaciones').val("registrarCasoValidaciones");
	tablaIndicativosAseguradoraValidaciones();
	$('#modalFrmCasosValidaciones').modal("show");
});

$('#btnAsignarInvestigacion').click(function(e){
	loadingSiglo('show','Cargando...');
	limpiaForm("#frmAsignarInvestigacion");
	$('#tipoCasoFrmAsignarInvestigacion').attr("readonly",false);
	$.ajax({
		type: 'POST',
		url: 'class/consultasManejoUsuarios.php',
		data:  "exe=consultarUsuario&registroUsuario="+$('#btnLogout').attr('name'),	
		success: function(data) {		
			var json_obj = $.parseJSON(data);

			loadingSiglo('hide');

			if (jQuery.isEmptyObject(json_obj)) {
				$("#ContenidoErrorNonActualizable").html("error al consultar");
				$('#ErroresNonActualizable').modal('show');
			} 
			else {
				$('#idAseguradoraFrmAsignarInvestigacion').val(json_obj.id_aseguradora);
				mostrarTipoCasosAseguradora(json_obj.id_aseguradora,"#tipoCasoFrmAsignarInvestigacion","Asignado");
			}

			$('#tipoCasoFrmAsignarInvestigacion').attr("disabled",false);	
			$('#exeFrmAsignarInvestigacion').val("registrarAsignacionInvestigacion");
			$('#modalFrmAsignarInvestigacion').modal("show");
			return false;
		}, error(data){
			('#tipoCasoFrmAsignarInvestigacion').attr("disabled",false);	
			$('#exeFrmAsignarInvestigacion').val("registrarAsignacionInvestigacion");
			loadingSiglo('hide');
			alert("Upss! Algo salió Mal");
		}
	});
});

$('#RegistrarSOATGastosMedicos').click(function(e){
	$(".divOcultar").hide();
	limpiaForm("#frmCasosGM");
	$("#aseguradoraFrmCasosGM").val('0').trigger('change');
	$("#tipoCasoFrmCasosGM").val('0').trigger('change');
	$("#ciudadFrmCasosGM").val('0').trigger('change');
	$("#tipoZonaFrmCasosGM").val('0').trigger('change');
	$("#tipoAuditoriaFrmCasosGM").prop('disabled', false);
	$("#tipoAuditoriaFrmCasosGM").val('0').trigger('change');
	$("#diasDeInvestigadorFrmCasosGM").val('');
	$("#investigadorFrmCasosGM").val('0').trigger('change');
	$("#idCasoFrmCasosGM").val('idCasoFrmCasosGM');
	$('#exeFrmCasosGM').val("registrarCasoSOAT");
	tablaIndicativosAseguradoraGM();
	$('#modalFrmCasosGM').modal("show");
	$('#tablaIndicativosAseguradoraFrmCasosGM').DataTable().clear().draw();
});

function llenarTablaGestionCasosSOAT(){
	loadingSiglo('show', 'Buscando Casos...');
	$('#tablaGestionCasosSOAT').DataTable( {
		"destroy": true,
		"select": 'multi',
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "consultarCasosSOAT";
				d.codigoFrmBuscarSOAT = $('#codigoFrmBuscarSOAT').val();
				d.nombresFrmBuscarSOAT = $('#nombresFrmBuscarSOAT').val();
				d.apellidosFrmBuscarSOAT = $('#apellidosFrmBuscarSOAT').val();
				d.identificacionFrmBuscarSOAT = $('#identificacionFrmBuscarSOAT').val();
				d.placaFrmBuscarSOAT = $('#placaFrmBuscarSOAT').val();
				d.polizaFrmBuscarSOAT = $('#polizaFrmBuscarSOAT').val();
				d.identificadorFrmBuscarSOAT = $('#identificadorFrmBuscarSOAT').val();
				d.tipoConsultaBuscar=$("#tipoConsultaBuscar").val();
				d.fechaAccidenteFrmBuscarSOAT=$("#fechaAccidenteFrmBuscarSOAT").val();
				d.fechaDigitacionFrmBuscarSOAT=$("#fechaDigitacionFrmBuscarSOAT").val();
				d.aseguradoraFrmBuscarSOAT=$("#aseguradoraFrmBuscarSOAT option:selected").val();
				d.usuario = $('#btnLogout').attr('name');	}
		},
		initComplete: function(settings, json) {
			loadingSiglo('hide');
			if(json.aaData.length > 0){
				$("#frmBuscarInvestigaciones").modal("hide");
			}	
		},
		"bPaginate":true,
		"bProcessing": true,
		"pageLength": 6,
		"columns": [
		{ mData: 'GeneralCasosSoat', "orderable": "true" } ,
		{ mData: 'VictimaCasosSoat', "orderable": "true" } ,
		{ mData: 'SiniestroCasosSoat', "orderable": "true" } ,
		{ mData: 'opciones', "orderable": "false" },
		{ mData: 'idInvestigacion', "orderable": "false","visible":false}
		],
		"language": 
		{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}

function llenarTablaGestionCasosValidaciones(){
	loadingSiglo('show', 'Buscando Casos...');
	$('#tablaGestionCasosValidacionesIPS').DataTable( {
		"destroy": true,
		"select": 'multi',
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "consultarCasosValidaciones";
				d.codigoFrmBuscarValIPS = $('#codigoFrmBuscarValIPS').val();
				d.identificacionFrmBuscarValIPS = $('#identificacionFrmBuscarValIPS').val();
				d.razonSocialFrmBuscarValIPS = $('#razonSocialFrmBuscarValIPS').val();
				d.identificadorFrmBuscarValIPS = $('#identificadorFrmBuscarValIPS').val();
				d.tipoConsultaBuscar=$("#tipoConsultaBuscar").val();
				d.usuario = $('#btnLogout').attr('name');
			}
		},
		initComplete: function(settings, json) {
			loadingSiglo('hide');
		},
		"bPaginate":true,
		"bProcessing": true,
		"pageLength": 6,
		"columns": [
		{ mData: 'GeneralCasosValidaciones', "orderable": "true" } ,
		{ mData: 'IPSCasoValidaciones', "orderable": "true" } ,
		{ mData: 'RepLegalValidaciones', "orderable": "true" } ,
		{ mData: 'opciones', "orderable": "false" },
		{ mData: 'idInvestigacion', "orderable": "false","visible":false}
		],
		"language": 
		{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}

function llenarTablaGestionCasosValidacionesHistorico(){
	loadingSiglo('show', 'Buscando Casos...');
	$('#tablaGestionCasosValidacionesIPSHistorico').DataTable( {
		"destroy": true,
		"select": true,				
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {					
				d.exeTabla = "consultarCasosValidacionesHistorico";
				d.codigoFrmBuscarValIPS = $('#codigoFrmBuscarValIPS').val();
				d.identificacionFrmBuscarValIPS = $('#identificacionFrmBuscarValIPS').val();
				d.razonSocialFrmBuscarValIPS = $('#razonSocialFrmBuscarValIPS').val();
				d.identificadorFrmBuscarValIPS = $('#identificadorFrmBuscarValIPS').val();
				d.tipoConsultaBuscar=$("#tipoConsultaBuscar").val();
				d.usuario = $('#btnLogout').attr('name');					
			}					
		},
		initComplete: function(settings, json) {
			loadingSiglo('hide');
		},
		"bPaginate":true,
		"bProcessing": true,
		"pageLength": 6,
		"columns": [
		{ mData: 'GeneralCasosValidaciones', "orderable": "true" } ,
		{ mData: 'IPSCasoValidaciones', "orderable": "true" } ,
		{ mData: 'RepLegalValidaciones', "orderable": "true" } ,
		{ mData: 'opciones', "orderable": "false" }
		],
		"language": 
		{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}

function tablaIndicativosAseguradoraValidaciones(){
	if($('#idCasoFrmCasosValidaciones').val() != 'idCasoFrmCasosValidaciones'){
		loadingSiglo('show', 'Cargando Tabla...');
		$('#tablaIndicativosAseguradoraFrmCasosValidaciones').DataTable( {
			"destroy": true,
			"select": true,
			"ajax": {
				"url":"class/consultasTablas.php",
				"type":"POST",
				"data":
				function ( d ) {
					d.exeTabla = "consultarIndicativoCasosSOAT";
					d.idCaso = $('#idCasoFrmCasosValidaciones').val();
				}
			},
			initComplete: function(settings, json) {
				loadingSiglo('hide');
			},
			"bPaginate":false,
			"scrollY":"100px",
			"scrollX":false,
			"bProcessing": true,
			"columns": [
			{ mData: 'indicativoCasosSOAT', "orderable": "true" } ,
			{ mData: 'fechaInicioCasosSOAT', "orderable": "true" } ,
			{ mData: 'fechaEntregaCasosSOAT', "orderable": "true" } ,
			{ mData: 'opcionesIndicativoCasosSOAT', "orderable": "true" }
			],
			"language": 
			{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
		});
	}else{
		$('#tablaIndicativosAseguradoraFrmCasosValidaciones').DataTable( {
			"destroy": true,
			"select": true,
			"bPaginate":false,
			"scrollY":"100px",
			"scrollX":false,
			"bProcessing": true,
			"columns": [
			{ mData: 'indicativoCasosSOAT', "orderable": "true" } ,
			{ mData: 'fechaInicioCasosSOAT', "orderable": "true" } ,
			{ mData: 'fechaEntregaCasosSOAT', "orderable": "true" } ,
			{ mData: 'opcionesIndicativoCasosSOAT', "orderable": "true" }
			],
			"language": 
			{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
		});
	}
}

function tablaIndicativosAseguradoraGM(){
	if($('#idCasoFrmCasosGM').val() != 'idCasoFrmCasosGM'){
		loadingSiglo('show', 'Cargando Indicativos...');
		$('#tablaIndicativosAseguradoraFrmCasosGM').DataTable( {
			"destroy": true,
			"select": true,
			"ajax": {
				"url":"class/consultasTablas.php",
				"type":"POST",
				"data":
				function ( d ) {
					d.exeTabla = "consultarIndicativoCasosSOAT";
					d.idCaso = $('#idCasoFrmCasosGM').val();
				}
			},
			initComplete: function(settings, json) {
				loadingSiglo('hide');
			},
			"bPaginate":false,
			"scrollY":"100px",
			"scrollX":false,
			"bProcessing": true,
			"columns": [
			{ mData: 'indicativoCasosSOAT', "orderable": "true" } ,
			{ mData: 'fechaInicioCasosSOAT', "orderable": "true" } ,
			{ mData: 'fechaEntregaCasosSOAT', "orderable": "true" } ,
			{ mData: 'opcionesIndicativoCasosSOAT', "orderable": "true" }
			],
			"language": 
			{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
		});
	}else{
		$('#tablaIndicativosAseguradoraFrmCasosGM').DataTable( {
			"destroy": true,
			"select": true,
			"bPaginate":false,
			"scrollY":"100px",
			"scrollX":false,
			"bProcessing": true,
			"columns": [
			{ mData: 'indicativoCasosSOAT', "orderable": "true" } ,
			{ mData: 'fechaInicioCasosSOAT', "orderable": "true" } ,
			{ mData: 'fechaEntregaCasosSOAT', "orderable": "true" } ,
			{ mData: 'opcionesIndicativoCasosSOAT', "orderable": "true" }
			],
			"language": 
			{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
		});
	}
}

function llenarTablaGestionLesionados(){
	loadingSiglo('show', 'Cargando Lesionados...');
	$('#tablaGestionLesionados').DataTable( {
		"destroy": true,
		"select": true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "consultarLesionadosCasoSOAT";
				d.idCaso = $('#idCasoLesionados').val();
				loadingSiglo('hide');
			}
		},
		"bPaginate":false,
		"scrollY":"400px",
		"bProcessing": true,
		"columns": [
		{ mData: 'nombreLesionadoCasoSOAT', "orderable": "true" } ,
		{ mData: 'ipsLesionadoCasoSOAT', "orderable": "true" } ,
		{ mData: 'informacionLesionadoCasoSOAT', "orderable": "true" } ,
		{ mData: 'opcionesLesionadoCasoSOAT', "orderable": "true" }
		],
		"language": 
		{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}

function llenarTablaGestionPersonas(identificacionPersona){
	loadingSiglo('show', 'Cargando Personas...');
	$('#tablaGestionPersonas').DataTable( {
		"destroy": true,
		"select": true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "consultarPersonas";
				d.identificacionPersona = identificacionPersona;
			}
		},
		initComplete: function(settings, json) {
			loadingSiglo('hide');
		},
		"bPaginate":true,
		"bProcessing": true,
		"pageLength": 6,
		"columns": [
		{ mData: 'nombrePersona', "orderable": "true" } ,
		{ mData: 'identificacionPersona', "orderable": "true" } ,

		{ mData: 'opcionesPersona', "orderable": "true" }
		],
		"language": 
		{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}

function llenarTablaPolizasVehiculos(){
	loadingSiglo('show', 'Cargando Polizas...');
	$('#tablaPolizasVehiculosFrmVehiculos').DataTable( {
		"destroy": true,
		"select": true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "consultarPolizasVehiculos";
				d.idVehiculo = $('#idVehiculoFrmVehiculos').val();
				d.idInvestigacion = $('#idInvestigacionFrmVehiculos').val();
			}
		},
		initComplete: function(settings, json) {
			loadingSiglo('hide');
		},
		"bPaginate":false,
		"info":false,
		"scrollY":"100px",
		"bProcessing": true,
		"columns": [
		{ mData: 'noPolizaSOAT', "orderable": "true" } ,
		{ mData: 'companiaPolizaSOAT', "orderable": "true" } ,
		{ mData: 'opcionesPolizaSOAT', "orderable": "true" } ,
		],
		"language": 
		{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}

function llenarTablaGestionVehiculos(){
	if($("#placaVehiculoFrmVehiculoPoliza").val() != ""){
		loadingSiglo('show', 'Cargando Vehiculo...');
		$('#tablaGestionVehiculos').DataTable( {
			"destroy": true,
			"select": true,
			"ajax": {
				"url":"class/consultasTablas.php",
				"type":"POST",
				"data":
				function ( d ) {
					d.exeTabla = "consultarVehiculos";
					d.placaVehiculo = $('#placaVehiculoFrmVehiculoPoliza').val();
				}
			},
			initComplete: function(settings, json) {
				loadingSiglo('hide');
			},
			"bPaginate":true,
			"bProcessing": true,
			"pageLength": 6,
			"columns": [
			{ mData: 'placaVehiculo', "orderable": "true" } ,
			{ mData: 'tipoVehiculo', "orderable": "true" } ,
			{ mData: 'opcionesVehiculo', "orderable": "true" }],
			"language": 
			{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
		});
	}
}

function llenarTablaGestionMultimediaInvestigacion(){
	loadingSiglo('show', 'Cargando Multimedias...');
	$('#tablaGestionMultimediaInvestigacion').DataTable( {
		"destroy": true,
		"select": true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "consultarMultimediaInvestigacion";
				d.idInvestigacion = $('#idInvestigacionFrmMultimedia').val();
			}
		},
		initComplete: function(settings, json) {
			loadingSiglo('hide');
		},
		"bPaginate":true,
		"bProcessing": true,
		"pageLength": 3,
		"columns": [
		{ mData: 'codigoMultimedia', "orderable": "true" } ,
		{ mData: 'SeccionMultimedia', "orderable": "true" } ,
		{ mData: 'verMultimedia', "orderable": "true" } ,
		{ mData: 'eliminarMultimedia', "orderable": "true" }
		],
		"language": 
		{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}

function llenarTablaGestionBeneficiarios(){
	loadingSiglo('show', 'Cargando Beneficiarios...');
	$('#tablaGestionBeneficiarios').DataTable( {
		"destroy": true,
		"select": true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "consultarBeneficiariosInvestigacion";
				d.idInvestigacion = $('#idRegistroInvestigacionPersonasSOAT').val();
			}
		},
		initComplete: function(settings, json) {
			loadingSiglo('hide');
		},
		"bPaginate":true,
		"bProcessing": true,
		"pageLength": 3,
		"columns": [
		{ mData: 'nombreBeneficiario', "orderable": "true" } ,
		{ mData: 'identificacionBeneficiario', "orderable": "true" } ,
		{ mData: 'parentescoBeneficiario', "orderable": "true" } ,
		{ mData: 'opciones', "orderable": "true" }
		],
		"language": 
		{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}

function llenarTablaGestionTestigos(){
	loadingSiglo('show', 'Cargando Tertigos...');
	$('#tablaGestionTestigos').DataTable( {
		"destroy": true,
		"select": true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "consultarTestigosInformeInvestigacion";
				d.idInvestigacion = $('#idInvestigacionTestigos').val();
			}
		},
		initComplete: function(settings, json) {
			loadingSiglo('hide');
		},
		"bPaginate":true,
		"bProcessing": true,
		"pageLength": 5,
		"columns": [
		{ mData: 'nombreTestigo', "orderable": "true" } ,
		{ mData: 'identificacionTestigo', "orderable": "true" } ,
		{ mData: 'opciones', "orderable": "true" }
		],
		"language": 
		{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}

function llenarTablaGestionObservaciones(){
	loadingSiglo('show', 'Cargando Observaciones...');
	$('#tablaGestionObservaciones').DataTable( {
		"destroy": true,
		"select": true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "consultarObservacionesInformeInvestigacion";
				d.idInvestigacion = $('#idInvestigacionObservaciones').val();
			}
		},
		initComplete: function(settings, json) {
			loadingSiglo('hide');
		},
		"bPaginate":true,
		"bProcessing": true,
		"pageLength": 5,
		"columns": [
		{ mData: 'tipoSeccionObservaciones', "orderable": "true" } ,
		{ mData: 'descripcionObservacion', "orderable": "true" } ,
		{ mData: 'opciones', "orderable": "true" }
		],
		"language": 
		{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}

function llenarTablaGestionLesionadosDiligencia(){
	loadingSiglo('show', 'Cargando...');
	$('#tablaGestionLesionadosDiligencia').DataTable( {
		"destroy": true,
		"select": true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "consultarLesionadosDiligenciaInformeInvestigacion";
				d.idInvestigacion = $('#idInvestigacionFrmDiligencia').val();
			}
		},
		initComplete: function(settings, json) {
			loadingSiglo('hide');
		},
		"bPaginate":true,
		"bProcessing": true,
		"pageLength": 5,
		"columns": [
		{ mData: 'nombreLesionadoDiligencia', "orderable": "true" } ,
		{ mData: 'identificacionLesionadoDiligencia', "orderable": "true" } ,
		{ mData: 'opciones', "orderable": "true" }
		],
		"language": 
		{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}

$('#btnGuardarCambioEstado').click(function(e){
	loadingSiglo('show', 'Guardando Cambio de Estado...');

	$("div[name=divPlanoCambioEstado]").hide();
	$.ajax({
		type: 'POST',
		url: 'class/consultasManejoCasoSOAT.php',
		data: "exe=guardarCambioEstado&idInvestigacion="+$("#idCasoSoatCambioEstado").val()+"&observacionesCambioEstado="+$('#observacionCambioEstadoFrm').val()+"&idUsuario="+$('#btnLogout').attr('name'),
		success: function(data) {

			var arrayDatos = jQuery.parseJSON(data);
			loadingSiglo('hide');

			if (arrayDatos.resultado==1){
				eval(arrayDatos.nombre_funcion+"('"+$("#idCasoSoatCambioEstado").val()+"')");	
			}
			else if(arrayDatos.resultado==2){
				$("#ContenidoErrorNonActualizable").html("Error al Subir Anexo");
				$('#ErroresNonActualizable').modal('show');
			}
		}, error: function(data){			
			loadingSiglo('hide');
		}
	});
});

function llenarTablaArcPlanoCensoMundial(codigoCaso){
	loadingSiglo('show', 'Cargando Reporte...');

	$('#tablaPlanoCambioEstadoCensoMundial').DataTable( {
		"autoWidth": true,
		"scrollX": true,
		dom: 'Bfrtip',
		buttons: [ {	
			extend: 'excelHtml5',
			title: 'CENSO DIARIO'+codigoCaso,
			footer:false,
		}, {
			extend: 'csvHtml5',
			header:false,
			filename: 'CENSO DIARIO'+codigoCaso,
			extension: '.txt',
			fieldBoundary: false,
			fieldSeparator:'|'
		} ],
		"select": true,
		"destroy":true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "archivoPlanoCensosMundial";
				d.fechaInicioReporteBasico = codigoCaso;
				d.fechaFinReporteBasico = '';
				d.tipoGenerarArchivoPlano='codigoCaso';
			}
		},
		initComplete: function(settings, json) {
			loadingSiglo('hide');
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
		{ title: 'Ciudad Residencia Lesionado', mData: 'ciudad_residencia_lesionado', "orderable": "false"} ],
		"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});

	$('#divPlanoCambioEstadoCensoMundial').show();
}

function llenarTablaArcPlanoCensoEstado(codigoCaso){
	loadingSiglo('show', 'Cargando Reporte...');

	$('#tablaPlanoCambioEstadoCensoEstado').DataTable( {
		"scrollX": true,
		dom: 'Bfrtip',
		buttons: [{	
			extend: 'excelHtml5',
			title: 'CENSO DIARIO'+codigoCaso,
			footer:false,
		},{
			extend: 'csvHtml5',
			header:false,
			filename: 'CENSO DIARIO'+codigoCaso,
			extension: '.txt',
			fieldBoundary: false,
			fieldSeparator:'|'
		} ],
		"select": true,
		"destroy":true,
		"ajax": {
			"url":"class/consultasTablas.php",

			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "archivoPlanoCensosEstado";
				d.fechaInicioReporteBasico = codigoCaso;
				d.fechaFinReporteBasico = '';
				d.tipoGenerarArchivoPlano='codigoCaso';
			}
		},
		initComplete: function(settings, json) {
			loadingSiglo('hide');
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
		{ title: 'Ciudad IPS', mData: 'ciudad_ips', "orderable": "false"} ],
		"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});

	$('#divPlanoCambioEstadoCensoEstado').show();
}

function llenarTablaArcPlanoCensoEquidad(codigoCaso){
	loadingSiglo('show', 'Cargando Reporte...');

	$('#tablaPlanoCambioEstadoCensoEquidad').DataTable( {
		"scrollX": true,
		dom: 'Bfrtip',
		buttons: [{	
			extend: 'excelHtml5',
			title: 'CENSO DIARIO'+codigoCaso,
			footer:false,
		},{
			extend: 'csvHtml5',
			header:false,
			filename: 'CENSO DIARIO'+codigoCaso,
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
				d.fechaInicioReporteBasico = codigoCaso;
				d.fechaFinReporteBasico = '';
				d.tipoGenerarArchivoPlano='codigoCaso';
			}
		},
		initComplete: function(settings, json) {
			loadingSiglo('hide');
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

	$('#divPlanoCambioEstadoCensoEquidad').show();
}

function llenarTablaArcPlanoCensoSolidaria(codigoCaso){
	loadingSiglo('show', 'Cargando Reporte...');

	$('#tablaPlanoCambioEstadoCensoSolidaria').DataTable( {
		"scrollX": true,
		dom: 'Bfrtip',
		buttons: [{	
			extend: 'excelHtml5',
			title: 'CENSO DIARIO'+codigoCaso,
			footer:false,
		},{
			extend: 'csvHtml5',
			header:false,
			filename: 'CENSO DIARIO'+codigoCaso,
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
				d.fechaInicioReporteBasico = codigoCaso;
				d.fechaFinReporteBasico = '';
				d.tipoGenerarArchivoPlano='codigoCaso';
			}
		},
		initComplete: function(settings, json) {
			loadingSiglo('hide');
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
		{ title: 'Ciudad IPS', mData: 'ciudad_ips', "orderable": "false"} ],
		"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});

	$('#divPlanoCambioEstadoCensoSolidaria').show();
}

function llenarTablaArcPlanoGastosMedicosMundial(codigoCaso){
	loadingSiglo('show', 'Cargando Reporte...');

	$('#tablaPlanoCambioEstadoGastosMedicosMundial').DataTable( {
		"scrollX": true,
		dom: 'Bfrtip',
		buttons: [{	
			extend: 'excelHtml5',
			title: 'GASTOS MEDICOS'+codigoCaso,
			footer:false,
		},{
			extend: 'csvHtml5',
			header:false,
			filename: 'GASTOS MEDICOS'+codigoCaso,
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
				d.fechaInicioReporteBasico = codigoCaso;
				d.fechaFinReporteBasico = '';
				d.tipoGenerarArchivoPlano='codigoCaso';
			}

		},
		initComplete: function(settings, json) {
			loadingSiglo('hide');
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
		{ title: 'Fecha Plano', mData: 'fecha_plano', "orderable": "false"} ],
		"language": {"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});

	$('#divPlanoCambioEstadoGastosMedicosMundial').show();
}

function llenarTablaArcPlanoMuerteMundial(codigoCaso){
	loadingSiglo('show', 'Cargando Reporte...');

	$('#tablaPlanoCambioEstadoMuerteMundial').DataTable( {
		"scrollX": true,
		dom: 'Bfrtip',
		buttons: [{	
			extend: 'excelHtml5',
			title: 'MUERTE'+codigoCaso,
			footer:false,
		},{
			extend: 'csvHtml5',
			header:false,
			filename: 'MUERTE'+codigoCaso,
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
				d.fechaInicioReporteBasico = codigoCaso;
				d.fechaFinReporteBasico = '';
				d.tipoGenerarArchivoPlano='codigoCaso';
			}
		},
		initComplete: function(settings, json) {
			loadingSiglo('hide');
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

	$('#divPlanoCambioEstadoMuerteMundial').show();
}

function llenarTablaArcPlanoIncapacidadPermanenteMundial(codigoCaso){
	loadingSiglo('show', 'Cargando Reporte...');

	$('#tablaPlanoCambioEstadoIncapacidadPermanenteMundial').DataTable( {
		"scrollX": true,
		dom: 'Bfrtip',
		buttons: [{	
			extend: 'excelHtml5',
			title: 'MUERTE'+codigoCaso,
			footer:false,
		},{
			extend: 'csvHtml5',
			header:false,
			filename: 'MUERTE'+codigoCaso,
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
				d.fechaInicioReporteBasico = codigoCaso;
				d.fechaFinReporteBasico = '';
				d.tipoGenerarArchivoPlano='codigoCaso';
			}
		},
		initComplete: function(settings, json) {
			loadingSiglo('hide');
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

	$('#divPlanoCambioEstadoIncapacidadPermanenteMundial').show();
}

function llenarTablaEventosInvestigacion(){
	loadingSiglo('show', 'Cargando Estados...');

	$('#tablaEstadosInvestigacion').DataTable( {
		"destroy": true,
		"select": true,
		"ajax": {
			"url":"class/consultasTablas.php",
			"type":"POST",
			"data":
			function ( d ) {
				d.exeTabla = "consultarEstadosInvestigacion";
				d.idInvestigacion = $('#liEstadosInvestigacion').attr("name");
			}
		},
		initComplete: function(settings, json) {
			loadingSiglo('hide');
		},
		"bPaginate":true,
		"bProcessing": true,
		"pageLength": 6,
		"columns": [
		{ mData: 'descripcionEvento', "orderable": "true" } ,
		{ mData: 'usuarioInvestigacionEvento', "orderable": "true" } ,
		{ mData: 'fechaEvento', "orderable": "true" } 
		],
		"language": 
		{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
	});
}

function mostrarModalSeleccionarPolizas(data){
	var html ="";
	for(var i in data.respuesta){
		html += "<tr>";
		html += "<td>"+data.respuesta[i].numeroPoliza+"</td>";
		html += "<td>"+data.respuesta[i].aseguradora+"</td>";
		if(data.respuesta[i].seleccionada == "SI"){
			html += "<td class='text-center'><button name='"+data.respuesta[i].idPoliza+"' class='btn btn-primary'>Seleccionada</button></td>";
		}else{
			html += "<td class='text-center'><button name='"+data.respuesta[i].idPoliza+"' onclick='seleccionarPolizas("+data.respuesta[i].idPoliza+")' class='btn btn-success'>Seleccionar</button></td>";
		}
		html += "</tr>";
	}

	$("#tablaSeleccionarPoliza").html(html);
	$("#modalSeleccionarPoliza").modal('show');
}

function seleccionarPolizas(opcion){
	$('#modalSeleccionarPoliza').modal('hide');
	loadingSiglo('show','Seleccionando Poliza...');
	$.ajax({
		type: 'POST',
		url: 'class/consultasManejoVehiculosPoliza.php',
		data: "exe=seleccionarPolizaInvestigacion&idPoliza="+opcion+"&idInvestigacion="+$("#idInvestigacionFrmVehiculos").val()+"&idUsuario="+$('#btnLogout').attr('name'),
		success: function(data) {
			if (data==1){
				$("#ContenidoErrorNonActualizable").html("Proceso Ejecutado Satisfactoriamente.");							
				$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
				$('#ErroresNonActualizable').modal('show');
			}
			else if (data==2){
				$("#ContenidoErrorNonActualizable").html("Error al registrar informacion");							
				$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
				$('#ErroresNonActualizable').modal('show');
			}
			else if (data==3){
				$("#ContenidoErrorNonActualizable").html("Ya existe un siniestro registrado con esta poliza para esta fecha de accidente. Necesita autorizacion de coordinador(a)/personal administrativo para poder continuar");							
				$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
				$('#ErroresNonActualizable').modal('show');
			}
			else if (data==4){
				$("#ContenidoErrorNonActualizable").html("Ya existe un siniestro registrado con esta poliza para esta fecha de accidente.");							
				$( ".cambiaClassColor" ).css({"background":"#4682B4","color":"white"});
				$('#ErroresNonActualizable').modal('show');
			}

			$("#BtnAddPolizaVehiculoCasoFrm").css("display", "block");
			llenarTablaPolizasVehiculos();
			loadingSiglo('hide');

			return false;
		}, error: function(){
			loadingSiglo('hide');
		}
	});
}

$('#identificacionTomadorPolizaFrm').on('keypress',function(e){
	if (e.which===13 || e.which===9){
		e.preventDefault();
		
		if($("#tipoIdentificacionTomadorPolizaFrm").val() !=0){
			loadingSiglo('show', 'Consultando Identificación...');
			$.ajax({
				type: 'POST',
				url: 'class/consultasManejoCasoSOAT.php',
				data: "exe=consultarDatosPersona&tipoIdentificacion="+$('#tipoIdentificacionTomadorPolizaFrm').val()+"&identificacion="+$('#identificacionTomadorPolizaFrm').val(),
				success: function(data) {

					var arrayDatos = jQuery.parseJSON(data);
					if (arrayDatos.respuesta==1){
						$("#nombreTomadorPolizaFrm").val(arrayDatos.nombre);
						$("#telefonoTomadorPolizaFrm").val(arrayDatos.telefono);
						$("#direccionTomadorPolizaFrm").val(arrayDatos.direccion);
						$("#ciudadTomadorPolizaFrm").val(arrayDatos.ciudad_residencia).change();	

					}else if(arrayDatos.respuesta != 1 && arrayDatos.respuesta != 2){
						window.showAlert = function(){
						    alertify.alert('ocurrió Un Error al Consultar Persona');
						}
						window.showAlert();
					}
					loadingSiglo('hide');
				}
			});
		}else{
			window.showAlert = function(){
			    alertify.alert('Para consultar debe escoger Tipo Identificación');
			}
			window.showAlert();
		}
	}
});

//PROCESOS JURIDICOS

$('#RegistrarProcesosJuridicos').on("click", function(){
	$(".divOcultar").hide();
	$("#DivRegistrarProcesosJuridicos").show();
	$("#formularioRegistrarProcesoJuridico")[0].reset();
	$("#busquedaRapidaProcesosJuridicos").show();
	$("#lblTituloPj").html("REGISTRAR PROCESO JURIDICO");
	$("#btnEditarProcesoJuridico").hide();
	$("#btnRegistrarProcesoJuridico").show();
	$("#lblTituloPj").addClass("tituloPjRegistrar");
	$("#divInfoEditar").hide();
	$("#subirInformeProcesoJudicial").prop('required',true);
	$("#aseguradorasProcesoJudicial").change();
	$("#ciudadProcesoJudicial").val("").change();
	$("#btnCancelarEdicion").hide();
});

$("#aseguradorasProcesoJudicial").on('change', function () {
	if ($("#aseguradorasProcesoJudicial option:selected").val() != '') {
		loadingSiglo('show', 'Consultando tipos de caso...');

		var aseguradora = $("#aseguradorasProcesoJudicial option:selected").val();

		$.post("class/consultasBasicas.php", {
			exe: "ConsultarTipoCasoProcesoJuridico",
			aseguradora : aseguradora
		},
        function(data) {
        	var html = '<option value="">Seleccione</option>';

        	if($("#lblTituloPj").hasClass("tituloPjRegistrar")){
        		for(var i = 0; i < data.length; i++){
	            	html += '<option value="'+data[i].id+'">'+data[i].descripcion+'</option>';
	            }
        	}else{
        		for(var i = 0; i < data.length; i++){
        			if($("#idTipocasoEditar").val() == data[i].id){
        				html += '<option value="'+data[i].id+'" selected>'+data[i].descripcion+'</option>';
        			}else{
    					html += '<option value="'+data[i].id+'">'+data[i].descripcion+'</option>';
    				}
	            }
			}
            
            $("#tipoCasoProcesoJudicial").html(html).change();
            loadingSiglo('hide');
        }, 'json');
	}else{
		$("#tipoCasoProcesoJudicial").html('<option value="">Seleccione</option>').val("").change();
	}
});

$("#formularioRegistrarProcesoJuridico").on('submit', function (e) {

	var selectaseguradorasProcesoJudicial = $("#aseguradorasProcesoJudicial").val();
	var selecttipoCasoProcesoJudicial = $("#tipoCasoProcesoJudicial").val();
	var pjPoliza = $("#pjPoliza").val();
	var pjSiniestro = $("#pjSiniestro").val();
	var fecha_accidente_procesos = $("#fecha_accidente_procesos").val();
	var selectciudadProcesoJudicial = $("#ciudadProcesoJudicial").val();
	var pjPlaca = $("#pjPlaca").val();
	var selectpjTipoId = $("#pjTipoId").val();
	var pjId = $("#pjId").val();
	var pjNombres = $("#pjNombres").val();
	var pjApellidos = $("#pjApellidos").val();
	var subirInformeProcesoJudicial = $("#subirInformeProcesoJudicial").prop("files")[0];
	var articulo = $("#pjArticulo").val();

	if (
		selectaseguradorasProcesoJudicial != "" && 
		selecttipoCasoProcesoJudicial != "" &&
		pjPoliza != "" &&
		pjSiniestro != "" &&
		fecha_accidente_procesos != "" &&
		selectciudadProcesoJudicial != "" &&
		pjId != "" &&
		pjNombres != "" &&
		pjApellidos != ""
		)
	{
		e.preventDefault();
		var form = new FormData();
		var nuevoArchivo = "NO";
		if($("#idProcesoJuridico").val() == ""){
			loadingSiglo('show','Registrando Proceso Juridico...');
			form.append("exe","RegistrarProcesosJuridicos");
		}else{
			loadingSiglo('show','Editando Proceso Juridico...');
			form.append("exe","EditarProcesosJuridicos");
			form.append("idProcesoJuridico",$("#idProcesoJuridico").val());

			if(subirInformeProcesoJudicial != null){
				nuevoArchivo = "SI";
			}
			form.append("nombreArchivoActual", $("#nombreArchivoActual").val());
			form.append("nuevoArchivo",nuevoArchivo);
		}
		
		form.append("selectaseguradorasProcesoJudicial", $("#aseguradorasProcesoJudicial").val());
		form.append("selecttipoCasoProcesoJudicial", $("#tipoCasoProcesoJudicial").val());
		form.append("pjPoliza",$("#pjPoliza").val());
		form.append("pjSiniestro",$("#pjSiniestro").val());
		form.append("fecha_accidente_procesos",$("#fecha_accidente_procesos").val());
		form.append("selectciudadProcesoJudicial",$("#ciudadProcesoJudicial").val());
		form.append("pjPlaca",$("#pjPlaca").val());
		form.append("selectpjTipoId",$("#pjTipoId").val());
		form.append("pjId",$("#pjId").val());
		form.append("pjNombres",$("#pjNombres").val());
		form.append("pjApellidos",$("#pjApellidos").val());
		form.append("subirInformeProcesoJudicial",$("#subirInformeProcesoJudicial").prop("files")[0]);
		form.append("pjIdPersona", $("#pjIdPersona").val());
		form.append("pjArticulo", articulo);

		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoCasoSOAT.php',
			data: form,
			cache: false,
			contentType: false,
			processData: false,
			success: function(datos) {
				var arrayDatos = jQuery.parseJSON(datos);
				if($("#idProcesoJuridico").val() == ""){
					if (arrayDatos.respuesta){
						Swal.fire(
					      'Exitoso',
					      'Proceso registrado con exito, su codigo es: '+arrayDatos.codigo,
					      'success'
					    );
					    $("#formularioRegistrarProcesoJuridico")[0].reset();
					    $("#tipoProceso").change();
						$("#ciudadProcesoJudicial").val("").change();
					    loadingSiglo("hide");
					}else{
						if(arrayDatos.error == "Existe"){
							Swal.fire(
						      '¡Atención!',
						      'Ya existe un proceso con esta poliza y siniestro para esta fecha, codigo: '+arrayDatos.codigo,
						      'warning'
						    );
						    $("#formularioRegistrarProcesoJuridico")[0].reset();
						    $('#ciudadProcesoJudicial').val('').trigger('change.select2');    
						}else{
							Swal.fire(
						      'ERROR!',
						      'Ha ocurrido un error!',
						      'error'
						    );
						}
						loadingSiglo("hide");
					}
				}else{
					if(arrayDatos.respuesta){
						Swal.fire(
					      'Exitoso',
					      'Se ha actualizado exitosamente',
					      'success'
					    );
					    $(".divOcultar").hide();
					    $("#formularioRegistrarProcesoJuridico")[0].reset();
					    $("#aseguradorasProcesoJudicial").change();
						$("#ciudadProcesoJudicial").val("").change();
					}else{
						Swal.fire(
					      'ERROR!',
					      'Ha ocurrido un error!',
					      'error'
					    );
					}
					loadingSiglo("hide");
				}
				
			}
		});
	}
});

$("#pjId").on('blur', function () {
	var identificacion = $(this).val();
	var selectpjTipoId = $("#pjTipoId").val();
	if (identificacion != "" && identificacion.length > 5){
		$.post("class/consultasBasicas.php", {exe:"consultarPersonaPJ",identificacion:identificacion, selectpjTipoId:selectpjTipoId}, function (datos) {
			if (datos.length > 0){
				$("#pjIdPersona").val(datos[0].id);
				$("#pjNombres").val(datos[0].nombres);
				$("#pjApellidos").val(datos[0].apellidos);
			}else{
				$("#pjIdPersona").val("");
			}
		}, 'json');
	}else{
		$("#pjIdPersona").val("");
	}
});

$('#btnBuscarProcesoJuridico').click(function(e){	
	$(".divOcultar").hide();
	limpiaForm("#frmBusqCasosSOAT");
	limpiaForm("#frmBusqCasosValidaciones");
	$('#modalBuscarProcesosJudiciales').modal("show");
});

$("#btnBuscarProcesosJuridicosFiltros").click(function(e){
	var codigo = $("#txtCodigoBpj").val();
	var poliza = $("#txtPolizaBpj").val();
	var siniestro = $("#txtSiniestroBpj").val();
	var fecha_siniestro = $("#BpjFechaSiniestro").val();
	var identificacion = $("#txtIdentificaciónBpj").val();
	var nombre = $("#txtNombreBpj").val();
	var apellidos = $("#txtApellidosBpj").val();
	var placa = $("#txtPlacaBpj").val();
	var articulo = $("#txtArticuloBpj").val();

	if(codigo != "" || poliza != "" || siniestro != "" || fecha_siniestro != "" || identificacion!= "" || nombre != "" || apellidos != "" || placa != "" || articulo != ""){
		loadingSiglo("show", "Buscando casos con sus criterios de busqueda");
		$.post("class/consultasManejoCasoSOAT.php",
			{
				exe:"BuscarProcesosJuridicos",
				codigo:codigo,
				poliza:poliza,
				siniestro:siniestro,
				fecha_siniestro:fecha_siniestro,
				identificacion:identificacion,
				nombre:nombre,
				apellidos:apellidos,
				placa:placa,
				articulo:articulo
			}, 
		function(datos){
			$("#tablaProcesosJuridicos").DataTable().clear().destroy();
			$("#txtCodigoBpj").val("").focus();
			$("#txtPolizaBpj").val("");
			$("#txtSiniestroBpj").val("");
			$("#BpjFechaSiniestro").val("");
			$("#txtIdentificaciónBpj").val("");
			$("#txtNombreBpj").val("");
			$("#txtApellidosBpj").val("");
			$("#txtPlacaBpj").val("");
			$("#txtArticuloBpj").val("");

			if(datos.length > 0){

				var tr = "";

				for (var i = 0; i < datos.length; i++){
					tr += '<tr>';
					tr += '<td style="vertical-align:middle;">';
					tr += '<b>Tipo de caso: </b>'+datos[i].tipo_caso+'<br/>';
					tr += '<b>Aseguradora: </b>'+datos[i].aseguradora;
					tr += '</td>';
					tr += '<td style="vertical-align:middle;">';
					tr += '<b>Identificación: </b>'+datos[i].tipo_identificacion+'-'+datos[i].identificacion+'<br/>';
					tr += '<b>Nombre: </b>'+datos[i].nombres+' '+datos[i].apellidos;
					tr += '</td>';
					tr += '<td style="vertical-align:middle;">';
					tr += '<b>Siniestro: </b>'+datos[i].siniestro+'<br/>';
					tr += '<b>Fecha de siniestro: </b>'+datos[i].fecha_siniestro+'<br/>';
					tr += '<b>Poliza: </b>'+datos[i].poliza+'<br/>';
					if(datos[i].id_tipo_caso == 32 || datos[i].id_tipo_caso == 33){
						tr += '<b>Articulo: </b>'+datos[i].articulo+'<br/>';
					}else{
						tr += '<b>Placa: </b>'+datos[i].placa+'<br/>';
					}
					tr += '</td>';
					tr += '<td style="vertical-align:middle;" class="text-center">';
					tr += '<div class="btn-group">';
					tr += '<button type="button" class="btn btn-success">'+datos[i].codigo+'</button>';
					tr += '<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
					tr += '<span class="caret"></span>';
					tr += '<span class="sr-only">Lista</span>';
					tr += '</button>';
					tr += '<ul class="dropdown-menu">';
					tr += '<li><a onclick="CargarEditarProcesoJuridico('+datos[i].id+')">Editar</a></li>';
					tr += '<li><a target="_blank" href="https://globalredltda.co/siglo/portal/data/informes_procesos_judiciales/'+datos[i].informe+'?'+Math.floor(Math.random()*9999999999)+'">Informe</a></li>';
					tr += '</ul>';
					tr += '</div>';
					tr += '</td>';
					tr += '</tr>';
				}

				$("#cuerpoTablaProcesosJudiciales").html(tr);
				$('#modalBuscarProcesosJudiciales').modal("hide");
				$("#tablaProcesosJuridicos").DataTable({
					"destroy": true,
					"select": 'multi',
					"bPaginate":true,
					"bProcessing": true,
					"ordering": false,
					"language": 
					{"sProcessing":     "Procesando...","sLengthMenu":     "Mostrar _MENU_ registros","sZeroRecords":    "No se encontraron resultados","sEmptyTable":     "Ningún dato disponible en esta tabla","sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":   "(filtrado de un total de _MAX_ registros)","sInfoPostFix":    "","sSearch":         "Buscar:","sUrl":            "","sInfoThousands":  ",","sLoadingRecords": "Cargando...","oPaginate": {"sFirst":    "Primero","sLast":     "Último","sNext":     "Siguiente","sPrevious": "Anterior"},"oAria": {"sSortAscending":  ": Activar para ordenar la columna de manera ascendente","sSortDescending": ": Activar para ordenar la columna de manera descendente"}}
				});
				$("#DivTablaProcesosJuridicos").show();
			}else{
				Swal.fire(
			      '¡Atención!',
			      'No se han encontrado investigaciones con estos criterios de busqueda',
			      'error'
			    );
			}
			loadingSiglo("hide");
		}, 'json');
	}else{
		$(".buscarPJ1").addClass("has-error");
		setTimeout(function(){$(".buscarPJ2").addClass("has-error");}, 400);
		setTimeout(function(){$(".buscarPJ3").addClass("has-error");}, 800);
		setTimeout(function(){$(".buscarPJ4").addClass("has-error");}, 1200);
		setTimeout(function(){$(".buscarPJ5").addClass("has-error");}, 1600);
		setTimeout(function(){$(".buscarPJ6").addClass("has-error");}, 2000);
		setTimeout(function(){$(".buscarPJ7").addClass("has-error"); $(".buscarPJ1").removeClass("has-error");}, 2400);
		setTimeout(function(){$(".buscarPJ2").removeClass("has-error");}, 2800);
		setTimeout(function(){$(".buscarPJ3").removeClass("has-error");}, 3200);
		setTimeout(function(){$(".buscarPJ4").removeClass("has-error");}, 3600);
		setTimeout(function(){$(".buscarPJ5").removeClass("has-error");}, 4000);
		setTimeout(function(){$(".buscarPJ6").removeClass("has-error");}, 4400);
		setTimeout(function(){$(".buscarPJ7").removeClass("has-error");}, 4800);
	}
});

function CargarEditarProcesoJuridico(idPj) {
	$("#lblTituloPj").removeClass("tituloPjRegistrar");
	$(".divOcultar").hide();
	$("#DivRegistrarProcesosJuridicos").show();
	$("#formularioRegistrarProcesoJuridico")[0].reset();
	$("#busquedaRapidaProcesosJuridicos").show();
	$('body, html').animate({scrollTop: '0px'});
	$("#lblTituloPj").html("EDITAR PROCESO JURIDICO");
	$("#btnRegistrarProcesoJuridico").hide();
	$("#btnEditarProcesoJuridico").show();
	$("#divInfoEditar").show();
	$("#subirInformeProcesoJudicial").removeAttr('required');
	$("#btnCancelarEdicion").show();

	loadingSiglo("show", "Consultando datos de la investigación");

	$.post("class/consultasManejoCasoSOAT.php", {idPj:idPj, exe:"consultarProcesoJuridico"}, function(datos){

		$("#idProcesoJuridico").val(datos[0].id);
		$("#idAseguradoraEditar").val(datos[0].id_aseguradora);
		$("#idTipocasoEditar").val(datos[0].id_tipo_caso);
		$("#aseguradorasProcesoJudicial").val(datos[0].id_aseguradora).change();
		$("#pjPoliza").val(datos[0].poliza);
		$("#pjSiniestro").val(datos[0].siniestro);
		$("#fecha_accidente_procesos").val(datos[0].fecha_siniestro);
		$("#ciudadProcesoJudicial").val(datos[0].id_ciudad).change();
		$("#pjPlaca").val(datos[0].placa);
		$("#pjTipoId").val(datos[0].tipo_identificacion);
		$("#pjIdPersona").val(datos[0].id_persona);
		$("#pjId").val(datos[0].identificacion);
		$("#pjNombres").val(datos[0].nombres);
		$("#pjApellidos").val(datos[0].apellidos);
		$("#nombreArchivoActual").val(datos[0].informe);
		$("#pjArticulo").val(datos[0].articulo);

		loadingSiglo("hide");
	}, 'json');
}

$("#btnCancelarEdicion").on("click", function () {
	$(".divOcultar").hide();
	$("#DivTablaProcesosJuridicos").show();
});

$("#tipoCasoProcesoJudicial").on('change', function () {
	if($(this).val() == 32 || $(this).val() == 33){
		$("#divPjPlaca").hide();
		$("#divPjArticulo").show();
		$("#pjPlaca").val("");
	}else{
		$("#divPjArticulo").hide();
		$("#divPjPlaca").show();
		$("#pjArticulo").val("");
	}
});

$('#EntrevistaVirtual').on("click", function(){
	$(".divOcultar").hide();
	$("#DivEntrevistaVirtual").show();
});

$("#formularioEntrevistaVirtual").on('submit', function (e) {
	var placa = $('#EvPlaca').val();
	var poliza= $('#EvPoliza').val();
	var fecha_accidente= $('#fecha_accidente_entrevista').val();
	var codigo= $('#EvCodigo').val();
	var id_entrevistado= $('#evId').val();
	var nom_entrevistado= $('#evNombres').val();
	var id_lesionado= $('#evLId').val();
	var nom_lesionado= $('#evLNombres').val();
	var id_tomador= $('#evtId').val();
	var nom_tomador= $('#evtNombres').val();

	if (
		placa != "" && 
		poliza != "" &&
		fecha_accidente != "" &&
		codigo != "" &&
		id_entrevistado != "" &&
		nom_entrevistado != "" &&
		id_lesionado != "" &&
		nom_lesionado != "" &&
		id_tomador != "" &&
		nom_tomador != ""
		)
	{
		e.preventDefault();
		var form = new FormData();

		form.append("exe", "GuardarEntrevistaVirtual");
		form.append("placa", placa);
		form.append("poliza", poliza);
		form.append("fecha_accidente", fecha_accidente);
		form.append("codigo", codigo);
		form.append("id_entrevistado", id_entrevistado);
		form.append("nom_entrevistado", nom_entrevistado);
		form.append("id_lesionado", id_lesionado);
		form.append("nom_lesionado", nom_lesionado);
		form.append("id_tomador", id_tomador);
		form.append("nom_tomador", nom_tomador);

		$.ajax({
			type: 'POST',
			url: 'class/consultasManejoCasoSOAT.php',
			data: form,
			cache: false,
			contentType: false,
			processData: false,
			success: function(datos) {
				var arrayDatos = jQuery.parseJSON(datos);
				if(arrayDatos){
					Swal.fire(
				      '¡Creado!',
				      'link: https://www.globalredltda.co/siglo/portal/plugins/firmar/?ev='+arrayDatos,
				      'success'
				    );
				}
			}
		});

	}else{
		alert("todo mal");
	}
});

function abrirModalFirmas(){

	loadingSiglo("show", "Consultando datos");

	$.post("class/consultasManejoCasoSOAT.php", {exe:"consultarFirmas"}, function(datos){
		if(datos.length > 0){

			var tr = "";

			for (var i = 0; i < datos.length; i++){
				tr += '<tr>';
				tr += '<td>'+datos[i].id+'</td>';
				tr += '<td>'+datos[i].nom_entrevistado+'</td>';
				if(datos[i].firmado == 'n'){
					tr += '<td>SIN FIRMAR</td>';
					tr += '<td>SIN FIRMAR</td>';
					tr += '<td>https://www.globalredltda.co/siglo/portal/plugins/firmar/?ev='+datos[i].id+'</td>';
				}else{
					tr += '<td><span class="glyphicon glyphicon-ok"></span></td>';
					tr += '<td>'+datos[i].fecha_firma+'</td>';
					tr += '<td><span class="glyphicon glyphicon-eye-open" onclick="mostrarDocumentoFirmado('+datos[i].id+')"></span></td>';
				}
				tr += '</tr>';
			}

			$("#datosEntrevistaVirtual").html(tr);
			$("#modalEntrevistaVirtual").modal("show");
		}
		loadingSiglo("hide");
	}, 'json');
}

function mostrarDocumentoFirmado(id){
	window.open("https://www.globalredltda.co/siglo/portal/plugins/firmar/firmas.php?ev="+id, '_blank');
}