<!DOCTYPE html>
<html lang="en">
<head>
	<title>Global Red LTDA | SIGLO</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" href="images/logo_ico.ico"/>	
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap1.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">	
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="portal/plugins/sweetalert2/sweetalert2.min.css">
</head>
<body style="background-color: #666666;">	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form">
					<span class="login100-form-title p-b-43">
						Inicio De Sesión
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Debe ingresar usuario">
						<input class="input100" type="text" name="user" id="user">
						<span class="focus-input100"></span>
						<span class="label-input100">Usuario</span>
					</div>					
					
					<div class="wrap-input100 validate-input" data-validate="Debe ingresar contraseña">
						<input class="input100" type="password" name="pass" id="pass">
						<span class="focus-input100"></span>
						<span class="label-input100">Contraseña</span>
					</div>

					<div class="container-login100-form-btn">
						<button type="button" class="login100-form-btn " id="btnLogin" data-loading-text="<i class='fa fa-spinner fa-spin '></i>  Iniciando...">
							Ingresar
						</button>
					</div>
				</form>
				
				<div class="login100-more" style="background-image: url('images/fondo2.jpg');"></div>
			</div>
		</div>
	</div>

	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="vendor/animsition/js/animsition.min.js"></script>
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap1.min.js"></script>
	<script src="js/main.js"></script>
  	<script src="portal/plugins/sweetalert2/sweetalert2.all.min.js"></script>

	<script>
		$(document).ready(function() {
			$('#btnLogin').click(function(e) {
				var $this = $(this);
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
					        $this.button('loading');
					    },			
						success: function(data) {	
							$this.button('reset');		
							if (data==1){
								window.location="portal/";						
							}else{
								Swal.fire({
								  type: 'error',
								  title: 'Oops...',
								  text: 'Digitó mal usuario y/o contraseña'
								});
							}
							return false;
						},
						error: function(data){
							$this.button('reset');
						}
					});
		   		}
		   		return false;
			});
		});
	</script>
</body>
</html>