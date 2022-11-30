<?php 
    include('../conexion/conexion.php');
    global $con;
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Allow: GET, POST, OPTIONS, PUT, DELETE");

    $headers = apache_request_headers();
    $token1 = $headers['Authorization'];
    $explode=explode(" ",$token1);
    $token=$explode[1];
    
    if($token){
        
        mysqli_next_result($con);
        $sql = "SELECT u.passwd FROM usuarios u WHERE u.id = 597 AND u.tipo_usuario = 6 AND u.vigente = 's' AND u.empleado = 'n'";
        $tokenLocal = mysqli_query($con, $sql);

        if(mysqli_num_rows($tokenLocal)>0){

            $tokenLocal = mysqli_fetch_assoc($tokenLocal);

            if($tokenLocal['passwd'] == $token){

                $json = file_get_contents('php://input',true);
                $data=json_decode($json);
                $flowId=$data->data->flowId;
                $status=$data->data->status;
                /*$fecha=$data->data->finishedAt;
                $fecha=$data->data->sendToSignAt;
                $cadenaGuardar=trim($data);*/

                mysqli_next_result($con);

                $queryFlowId = "SELECT ap.id, ap.id_firma, ap.estado FROM au_personas ap WHERE ap.estado = 1 AND ap.id_firma = '".$flowId."'";

                $consultarRegistro = mysqli_query($con, $queryFlowId);

                if(mysqli_num_rows($consultarRegistro)>0){

                    $consultarRegistro = mysqli_fetch_assoc($consultarRegistro);

                    if($consultarRegistro['estado'] == 1 && $status == 'signed'){

                        $queryActualizarEstado = "UPDATE au_personas SET estado='2' WHERE  id_firma='".$flowId."'";

                        if(mysqli_query($con,$queryActualizarEstado)){
                            header("HTTP/2.0 200 OK");
                            $response = array( "code"=>"201","message"=>"Proceso ejecutado satisfactoriamente.");
                        }else{
                            header("HTTP/2.0 200 OK");
                            $response = array( "code"=>"204","message"=>"Recibido.");
                        }
                    }else{
                        header("HTTP/2.0 200 OK");
                        $response = array( "code"=>"204","message"=>"Estado sin firmar recibido");
                    }
                }else{
                    header("HTTP/2.0 200 OK");
                    $response = array( "code"=>"204","message"=>"No hay un proceso de firma para este flowId.");
                }
            }else{
                header("HTTP/2.0 400 BAD REQUEST");
                $response = array( "code"=>"406","message"=>"Token no valido.");
            }
        }else{
            header("HTTP/2.0 400 BAD REQUEST");
            $response = array( "code"=>"406","message"=>"Provedor inactivo."); 
        }
    }else{
        header("HTTP/2.0 400 BAD REQUEST");
        $response = array( "code"=>"406","message"=>"Solicitud sin token"); 
    }

    echo json_encode($response);