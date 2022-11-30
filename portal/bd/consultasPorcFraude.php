<?php
    ini_set('display_errors');

    error_reporting(-1); 
    include('../conexion/conexion.php');
    global $con;
    $porcFraudeVehiculo=0;$porcVehiculo=0.30;
    $porcFraudeLesionado=0;$porcLesionado=0.20;
    $porcFraudeDepartamento=0;$porcDepartamento=0.10;
    $porcFraudeIPS=0;$porcIPS=0.30;
    $porcFraudeTipoVehiculo=0;$porcTipoVehiculo=0.10;
    $idVehiculo=$_GET["idVehiculo"];
    $idPersona=$_GET["idPersona"];
    $idDepartamento=$_GET["idDepartamento"];
    $idIPS=$_GET["idIPS"];
    $idTipoVehiculo=$_GET["idTipoVehiculo"];

    //FRAUDE VEHICULO
    $consultaVehiculosStand="SELECT COUNT(a.id)
	FROM 
	personas_investigaciones_soat a 
	LEFT JOIN detalle_investigaciones_soat b ON a.id_investigacion=b.id_investigacion
	LEFT JOIN polizas c ON b.id_poliza= c.id 
	LEFT JOIN vehiculos d ON d.id=c.id_vehiculo 
	WHERE a.tipo_persona=1 AND d.id='".$idVehiculo."'"; 

    $consultaVehiculosPositivos=$consultaVehiculosStand." and a.resultado=2";
    $queryVehiculosPositivos=mysqli_query($con,$consultaVehiculosPositivos);
    if (mysqli_num_rows($queryVehiculosPositivos)>0){
        $porcFraudeVehiculo=100;
    }else{
        mysqli_next_result($con);
        $consultaVehiculosAtender=$consultaVehiculosStand." and a.resultado=1";
        $queryVehiculosStand=mysqli_query($con,$consultaVehiculosAtender);
        $cantidadVehiculosStand=mysqli_num_rows($queryVehiculosStand);
        if ($cantidadVehiculosStand==1){
            $porcFraudeVehiculo=40;
        }
        else if($cantidadVehiculosStand>1){
            $porcFraudeVehiculo=60;
        }
    }



    //FRAUDE LESIONADO
    $consultaLesionadoStand="SELECT COUNT(a.id)
	FROM 
	personas_investigaciones_soat a 
	LEFT JOIN detalle_investigaciones_soat b ON a.`id_investigacion`=b.`id_investigacion` 
	WHERE a.tipo_persona=1 AND a.id='".$idPersona."'"; 

    $consultaLesionadoPositivos=$consultaLesionadoStand." and a.resultado=2";
    $queryLesionadoPositivos=mysqli_query($con,$consultaLesionadoPositivos);
    if (mysqli_num_rows($queryLesionadoPositivos)>0){
        $porcFraudeLesionado=100;
    }else{
        mysqli_next_result($con);
        $consultaLesionadoAtender=$consultaLesionadoStand." and a.resultado=1";
        $queryLesionadoStand=mysqli_query($con,$consultaLesionadoAtender);
        $cantidadLesionadoStand=mysqli_num_rows($queryLesionadoStand);
        if ($cantidadLesionadoStand==1)
        {
            $porcFraudeLesionado=40;
        }
        else if($cantidadLesionadoStand>1)
        {
            $porcFraudeLesionado=60;
        }
    }

    mysqli_next_result($con);
    $consultaPositivosStand="SELECT COUNT(a.id) as cantidad_positivos
	FROM 
	personas_investigaciones_soat a 
	LEFT JOIN detalle_investigaciones_soat b ON a.id_investigacion=b.id_investigacion";

    $consultaPositivosTotal=$consultaPositivosStand."   WHERE a.tipo_persona=1 AND a.resultado=2";
    $queryPositivosStand=mysqli_query($con,$consultaPositivosTotal);
    $resPositivosStand=mysqli_fetch_assoc($queryPositivosStand);

    //FRAUDE DEPARTAMENTO
    mysqli_next_result($con);
    $consultaPositivosDepartamento=$consultaPositivosStand." LET JOIN ciudades c ON c.id=b.ciudad_ocurrencia 
    WHERE a.tipo_persona=1 AND a.resultado=2 AND c.id_departamento='".$idDepartamento."'";
    $queryPositivosDepartamento=mysqli_query($con,$consultaPositivosDepartamento);
    $resPositivosDepartamento=mysqli_fetch_assoc($queryPositivosDepartamento);
    $porcTotalDepartamento=($resPositivosDepartamento["cantidad_positivos"]/$resPositivosStand["cantidad_positivos"])*100;

    if ($porcTotalDepartamento<30){
        $porcFraudeDepartamento=30;
    }else if($porcTotalDepartamento>=30 && $porctotalDepartamento<70){
        $porcFraudeDepartamento=50;
    }else if($porcTotalDepartamento>=70){
        $porcFraudeDepartamento=100;
    }

    //FREUDE IPS
    mysqli_next_result($con);
    $consultaPositivosIPS=$consultaPositivosStand." WHERE a.tipo_persona=1 AND a.resultado=2 AND a.ips='".$idIPS."'";
    echo $consultaPositivosIPS;
    $queryPositivosIPS=mysqli_query($con,$consultaPositivosIPS);
    $resPositivosIPS=mysqli_fetch_assoc($queryPositivosIPS);
    $porcTotalIPS=($resPositivosIPS["cantidad_positivos"]/$resPositivosStand["cantidad_positivos"])*100;

    if ($porcTotalIPS<30){
        $porcFraudeIPS=30;
    }else if($porcTotalIPS>=40 && $porcTotalIPS<80){
        $porcFraudeIPS=50;
    }else if($porcTotalIPS>=80){
        $porcFraudeIPS=100;
    }


     //FREUDE TIPO DE VEHICULO
    mysqli_next_result($con);
    $consultaPositivosTipoVehiculo=$consultaPositivosStand." LEFT JOIN polizas c ON c.id=b.id_poliza LEFT JOIN vehiculos d ON d.id=c.id_vehiculo WHERE a.tipo_persona=1 AND a.resultado=2 AND a.tipo_vehiculo='".$idTipoVehiculo."'";
    $queryPositivosTipoVehiculo=mysqli_query($con,$consultaPositivosTipoVehiculo);
    $resPositivosTipoVehiculo=mysqli_fetch_assoc($queryPositivosTipoVehiculo);
    $porcTotalTipoVehiculo=($resPositivosTipoVehiculo["cantidad_positivos"]/$resPositivosStand["cantidad_positivos"])*100;

    if ($porcTotalTipoVehiculo>=0 && $porcTotalTipoVehiculo<10){
        $porcFraudeTipoVehiculo=10;
    }else if ($porcTotalTipoVehiculo>=10 && $porcTotalTipoVehiculo<20){
        $porcFraudeTipoVehiculo=20;
    }else if ($porcTotalTipoVehiculo>=20 && $porcTotalTipoVehiculo<30){
        $porcFraudeTipoVehiculo=30;
    }else if($porcTotalTipoVehiculo>=30 && $porcTotalTipoVehiculo<60){
        $porcFraudeTipoVehiculo=50;
    }else if($porcTotalTipoVehiculo>=60){
        $porcFraudeTipoVehiculo=100;
    }

    
    //FRAUDE TOTAL
    $porcFinalFraude=($porcFraudeDepartamento*$porcDepartamento)+($porcFraudeIPS*$porcIPS)+($porcFraudeLesionado*$porcLesionado)+($porcFraudeVehiculo*$porcVehiculo)+($porcFraudeTipoVehiculo*$porcTipoVehiculo);
    
    $data[]=array("porcFraudeDepartamento"=>$porcFraudeDepartamento,
    "porcFraudeIPS"=>$porcFraudeIPS,
    "porcFraudeLesionado"=>$porcFraudeLesionado,
    "porcFraudeVehiculo"=>$porcFraudeVehiculo,
    "porcFraudeTipoVehiculo"=>$porcFraudeTipoVehiculo,
    "porcFinalFraude"=>$porcFinalFraude
    );
    echo json_encode($data);
    ?>
    