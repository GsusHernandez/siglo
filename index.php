<?php 
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Global Red LTDA | SIGLO</title>
  
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="portal/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="portal/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="portal/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="portal/dist/css/AdminLTE.css">
  <link rel="stylesheet" href="portal/dist/css/Style.css">
  <link rel="stylesheet" href="portal/dist/css/animate.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="portal/plugins/iCheck/minimal/minimal.css">

  <!-- Google Font -->
  <!------------------>
  <!----->
  <link rel="stylesheet" href="portal/dist/css/fonts/css.css">
  <link rel="stylesheet" type="text/css" href="portal/dist/css/estilos_index.css">

  <link rel="stylesheet" type="text/css" href="portal/plugins/sweetalert2/sweetalert2.min.css">
  <style type="text/css">
    .login-box{
      -webkit-box-shadow: 0px 0px 0px 8px rgba(51,47,51,1);
      -moz-box-shadow: 0px 0px 0px 8px rgba(51,47,51,1);
      box-shadow: 0px 0px 0px 8px rgba(51,47,51,1);
      margin-top: 11%;
    }

    .login select {
      box-sizing: border-box;
      display: block;
      margin-bottom: 10px;
      height: 40px;
      width: 100%;
      border: 1px solid #ddd;
      transition: border-width 0.2s ease;
      border-radius: 5px;
      border-color: #4898ff;
      color: #000000;
    }

    .login input {
      box-sizing: border-box;
      display: block;
      padding: 15px 10px;
      margin-bottom: 10px;
      height: 40px;
      width: 100%;
      border: 1px solid #ddd;
      transition: border-width 0.2s ease;
      border-radius: 5px;
      border-color: #4898ff;
      color: #000000;
    }
    .login input + i.fa, select + i.fa  {
      color: #fff;
      font-size: 1em;
      position: absolute;
      margin-top: -38px;
      margin-left: -17px;
      opacity: 0;
      left: 0;
      transition: all 0.1s ease-in;
    }
    .login input:focus, select:focus {
      outline: none;
      color: #444;
      border-color: #0170bbe3;
      box-shadow: 0 0 0px 1000px #a7ceff8c inset;
      border-left-width: 35px;
    }
    .login input:focus + i.fa, select:focus + i.fa {
      opacity: 1;
      left: 30px;
      transition: all 0.25s ease-out;
    }
    .btn_ingresar {
      background-color: #0170bbe3;
      border: 2px solid #0170bbe3;
      transition: 1s;
    }
    .btn_ingresar:hover {
      transition: 1s;
      border: 2px solid #0170bbe3;
      background-color: #fff;
      color: #0170bbe3;
    }
    .icheckbox_minimal {
      background-position: -20px 0;
    }
    .label-checkbox.hover {
      color: gray !important;
    }

    input:-webkit-autofill, select:-webkit-autofill {
        -webkit-box-shadow: 0 0 0px 1000px #a7ceff8c inset;
    }
  </style>

</head>
<body class="hold-transition login-page" id="login-img">
  <div class="login-box center-block">
   <div class="login-box-header text-center" style="height: 120px; background-color: #0170bbe3;  padding-top: 5px;">
      <div class="animated bounceInLeft" style="font-size: 70px; color:#fff; font-weight: bold; display: inline;" >SI</div>
      <div class="animated bounceInUp" style="font-size: 70px; color:#fff; font-weight: bold; display: inline;">GLO</div>
   </div>
   <div class="login-box-body">
      <p class="login-box-msg"></p>
      <form id="form-login" class="login" action="index.php" method="post">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="Usuario" id="usuario"  name="usuario" data-validacion-tipo="requerido">
          <i class="fa fa-user"></i>
          <!--<span class="glyphicon glyphicon-user form-control-feedback"></span>-->
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Contraseña" id="password" name="password" data-validacion-tipo="requerido" >
            <i class="fa fa-key"></i>
            <!--<span class="glyphicon glyphicon-lock form-control-feedback"></span>-->
        </div>
        <div class="row">
          <div class="col-xs-12">
            <div class="checkbox icheck pull-right">
              <label class="label-checkbox" style="color:black; font-weight: bold;">
                Mostrar Contraseña <input type="checkbox">
              </label>
            </div>
          </div>
        </div>
        <div class="row">        
          <div class="col-xs-12">
            <button type="button" id="btnLogin" data-loading-text="<i class='fa fa-spinner fa-spin '></i>  Iniciando..." class="btn btn-block btn-primary btn-lg btn_ingresar">INGRESAR</button>
          </div>
        </div>
      </form>
    </div>
  </div>            
  <!-- jQuery 3 -->
  <script src="portal/bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="portal/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- iCheck -->
  <script src="portal/plugins/iCheck/icheck.min.js"></script>
  <script src="portal/plugins/sweetalert2/sweetalert2.all.min.js"></script>
  <script>
    $(function () {
      $("#form-login").keypress(function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if(code==13){
          $('#btnLogin').click();
        }
      });

      $('input').iCheck({
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_minimal',
        increaseArea: '20%' // optional
      });

      $('input').on('ifChecked', function(event){
        $("#password").get(0).type = 'text';
      });

      $('input').on('ifUnchecked', function(event){
        $("#password").get(0).type = 'password';
      });

      // Validacion de los campos del login.
      $("#form-login").submit(function(){
        return $(this).validate();
      });

      $('#btnLogin').click(function(e) {
        var $this = $(this);
          if ($("#usuario").val()=="") {
            Swal.fire({
              position: 'top-end',
              type: 'warning',
              title: 'Por Favor Ingrese Usuario',
              showConfirmButton: false,
              timer: 1500
            });
          }else if ($("#password").val()=="") {
            Swal.fire({
              position: 'top-end',
              type: 'warning',
              title: 'Por Favor Ingrese Contraseña',
              showConfirmButton: false,
              timer: 1500
            });
          }else{

            var formLogin =  "exe=login&usuario="+$("#usuario").val()+"&password="+$("#password").val();   
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