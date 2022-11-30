	$('a').click(function(e)
	{

		var opcion=$(this).attr('name');
		var action=$(this).attr('id');
		var parametros="opcion="+opcion+"&action="+action;
		alert(action);
		if (action=="btnLoginMovil")
		{
			if ($("#userMovil").val()=="")
		{
			alert("Por Favor Ingrese Usuario");
   		}
   		else if ($("#passMovil").val()=="")
		{
			alert("Por Favor Ingrese Contraseña");
   		}
   		else
   		{

   			var formLoginMovil =  "exe=loginMovil&usuario="+$("#userMovil").val()+"&password="+$("#passMovil").val();
   			
   			
			$.ajax({
				type: 'POST',
				url: 'class/login.php',
				data: formLoginMovil,

			
				success: function(data) {
					alert(data);
						if (data==1){
							window.location.replace("panel.php");
						
						}else{
							alert("Error en usuario y/o contraseña");

						}


					return false;
				}


			});
   		}
		}
	});	

		

	