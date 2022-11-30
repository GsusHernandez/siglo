
	$('#btnLoginMovil').click(function(e) 
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
				
						if (data==1){
							window.location.hash="panel.php";
						
						}else{
							alert("Error en usuario y/o contraseña");

						}


					return false;
				}


			});
   		}
   
      return false;
	});	


	