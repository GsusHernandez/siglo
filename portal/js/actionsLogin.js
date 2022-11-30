
$(document).ready(function() {
	$('#btnLogin').click(function(e) {

   		if ($("#user").val()=="") {
			alert("Por Favor Ingrese Usuario");
   		}else if ($("#pass").val()=="") {
			alert("Por Favor Ingrese Contraseña");
   		}else{
   			var formLogin =  "exe=login&usuario="+$("#user").val()+"&password="+$("#pass").val();   

			$.ajax({
				type: 'POST',
				url: 'portal/class/login.php',
				data: formLogin,
				beforeSend: function() {
			       
			    },			
				success: function(data) {
				//alert(data);			
					if (data==1){
						window.location="portal/";						
					}else{
						alert("Error en usuario y/o contraseña");
					}
					return false;
				},
				error: function(data) {
					
			    }
			});
   		}
   		return false;
	});
});