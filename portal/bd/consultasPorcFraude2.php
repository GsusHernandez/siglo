<?php
    ini_set('display_errors');

    error_reporting(-1); 
    include('../conexion/conexion.php');
    header("Content-Type: application/json; charset=utf-8");
    header("HTTP/2.0 200 OK");
    global $con;
    $porcFraudeVehiculo=0;$porcVehiculo=0.30;
    $porcFraudeLesionado=0;$porcLesionado=0.20;
    $porcFraudeDepartamento=0;$porcDepartamento=0.10;
    $porcFraudeIPS=0;$porcIPS=0.30;
    $porcFraudeTipoVehiculo=0;$porcTipoVehiculo=0.10;
    $porcFraudeCapacidadVehiculo=0;$porcCapacidadVehiculo=0;
    $porcFraudeCantidadPersonasTraslado=0;$porcCantidadPersonasTraslado=0;
    $porcFraudeVersionesDiferentes=0;$porcVersionesDiferentes=0;
 

    $idVehiculo=$_POST["idVehiculo"];
    $idPersona=$_POST["idPersona"];
    $idDepartamento=$_GET["idDepartamento"];
    $idIPS=$_GET["idIPS"];
    $idTipoVehiculo=$_GET["idTipoVehiculo"];
    $idInvestigacion=$_GET["idInvestigacion"];


       //FRAUDE VEHICULO
       $consultaVehiculosStand="SELECT COUNT(a.id) as cantidad
       FROM 
       personas_investigaciones_soat a 
       LEFT JOIN detalle_investigaciones_soat b ON a.id_investigacion=b.id_investigacion
       LEFT JOIN polizas c ON b.id_poliza= c.id 
       LEFT JOIN vehiculos d ON d.id=c.id_vehiculo 
       LEFT JOIN investigaciones e ON e.id=b.id_investigacion
       WHERE e.tipo_caso in (1,2,3,4,5,6,13,14,15,16,17) and a.tipo_persona=1 AND d.id='".$idVehiculo."'"; 
   
       $consultaVehiculosPositivos=$consultaVehiculosStand." and a.resultado=2";
       $queryVehiculosPositivos=mysqli_query($con,$consultaVehiculosPositivos);
       $cantidadVehiculosStand=mysqli_fetch_assoc($queryVehiculosPositivos);
       if ($cantidadVehiculosStand["cantidad"]>0){
           $porcFraudeVehiculo=100;
       }else{
           mysqli_next_result($con);
           $consultaVehiculosAtender=$consultaVehiculosStand." and a.resultado=1";
           $queryVehiculosStand=mysqli_query($con,$consultaVehiculosAtender);
           $cantidadVehiculosStand=mysqli_fetch_assoc($queryVehiculosStand);
           if ($cantidadVehiculosStand["cantidad"]==1){
               $porcFraudeVehiculo=40;
           }
           else if($cantidadVehiculosStand>1){
               $porcFraudeVehiculo=60;
           }
       }

    $queryDetalleInvestigacion=mysqli_query($con,"SELECT * FROM detalle_investigaciones_soat WHERE id_investigacion='".$idInvestigacion."'");
    $resDetalleInvestigacion=mysqli_fetch_assoc($queryDetalleInvestigacion);
    mysqli_next_result($con);
    $queryTipoVehiculo=mysqli_query($con,"SELECT * FROM tipo_vehiculos WHERE id='".$idTipoVehiculo."'");
    $resTipoVehiculo=mysqli_fetch_assoc($queryTipoVehiculo);

    if ($resDetalleInvestigacion["versiones_diferentes"]=="S")
    {
        $porcVehiculo=0.25;
        $porcVersionesDiferentes=0.05;
        $porcFraudeVersionesDiferentes=100;
      
    }else{
        $porcVehiculo=0.25;
        $porcVersionesDiferentes=0.05;
        $porcFraudeVersionesDiferentes=0;
    }
    

    if ($resDetalleInvestigacion["numero_ocupantes_vehiculo"]>$resTipoVehiculo["capacidad"])
    {
        $porcTipoVehiculo=0.05;   
        $porcCapacidadVehiculo=0.05; 
        $porcFraudeCapacidadVehiculo=100;

    }else {
        $porcTipoVehiculo=0.05;   
        $porcCapacidadVehiculo=0.05; 
        $porcFraudeCapacidadVehiculo=0;

    }

    if ($resDetalleInvestigacion["cantidad_personas_traslado"]>1)
    {
        $porcTipoVehiculo=0.05;   
        $porcDepartamento=0.05;   
        $porcFraudeCantidadPersonasTraslado=100;
    }else {
        $porcTipoVehiculo=0.05;   
        $porcCapacidadVehiculo=0.05; 
        $porcFraudeCapacidadVehiculo=0;

    }


    mysqli_next_result($con);

 



    //FRAUDE LESIONADO
    $consultaLesionadoStand="SELECT COUNT(a.id)
	FROM 
	personas_investigaciones_soat a 
	LEFT JOIN detalle_investigaciones_soat b ON a.`id_investigacion`=b.`id_investigacion` 
    LEFT JOIN investigaciones c ON c.id=b.id_investigacion
	WHERE c.tipo_caso in (1,2,3,4,5,6,13,14,15,16,17) and a.id_persona='".$idPersona."'"; 

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
	LEFT JOIN detalle_investigaciones_soat b ON a.id_investigacion=b.id_investigacion 
    LEFT JOIN investigaciones c ON c.id=b.id_investigacion";

    $consultaPositivosTotal=$consultaPositivosStand."   WHERE c.tipo_caso in (1,2,3,4,5,6,13,14,15,16,17) and a.tipo_persona=1 AND a.resultado=2";
    $queryPositivosStand=mysqli_query($con,$consultaPositivosTotal);
    $resPositivosStand=mysqli_fetch_assoc($queryPositivosStand);

    //FRAUDE DEPARTAMENTO
    mysqli_next_result($con);
    $consultaPositivosDepartamento=$consultaPositivosStand." LEFT JOIN ciudades d ON d.id=b.ciudad_ocurrencia 
    WHERE c.tipo_caso in (1,2,3,4,5,6,13,14,15,16,17) and a.tipo_persona=1 AND a.resultado=2 AND d.id_departamento='".$idDepartamento."'";
    $queryPositivosDepartamento=mysqli_query($con,$consultaPositivosDepartamento);
    $resPositivosDepartamento=mysqli_fetch_assoc($queryPositivosDepartamento);
    $porcTotalDepartamento=($resPositivosDepartamento["cantidad_positivos"]/$resPositivosStand["cantidad_positivos"])*100;

    if ($porcTotalDepartamento<10){
        $porcFraudeDepartamento=10;
    }else if($porcTotalDepartamento>=10 && $porctotalDepartamento<20){
        $porcFraudeDepartamento=20;
    }else if($porcTotalDepartamento>=20 && $porctotalDepartamento<30){
        $porcFraudeDepartamento=30;
    }else if($porcTotalDepartamento>=30 && $porctotalDepartamento<40){
        $porcFraudeDepartamento=40;
    }else if($porcTotalDepartamento>=40 && $porctotalDepartamento<50){
        $porcFraudeDepartamento=50;
    }else if($porcTotalDepartamento>=50 && $porctotalDepartamento<60){
        $porcFraudeDepartamento=60;
    }else if($porcTotalDepartamento>=60 && $porctotalDepartamento<70){
        $porcFraudeDepartamento=70;
    }else if($porcTotalDepartamento>=70 && $porctotalDepartamento<80){
        $porcFraudeDepartamento=80;
    }else if($porcTotalDepartamento>=80 && $porctotalDepartamento<90){
        $porcFraudeDepartamento=90;
    }else if($porcTotalDepartamento>=90){
        $porcFraudeDepartamento=100;
    }

    //FREUDE IPS
    mysqli_next_result($con);
    $consultaPositivosIPS=$consultaPositivosStand." WHERE c.tipo_caso in (1,2,3,4,5,6,13,14,15,16,17) and a.tipo_persona=1 AND a.resultado=2 AND a.ips='".$idIPS."'";
    //echo $consultaPositivosIPS;
    $queryPositivosIPS=mysqli_query($con,$consultaPositivosIPS);
    $resPositivosIPS=mysqli_fetch_assoc($queryPositivosIPS);
    $porcTotalIPS=($resPositivosIPS["cantidad_positivos"]/$resPositivosStand["cantidad_positivos"])*100;

    if ($porcTotalIPS<10){
        $porcFraudeIPS=10;
    }else if($porcTotalIPS>=10 && $porcTotalIPS<20){
        $porcFraudeIPS=20;
    }else if($porcTotalIPS>=20 && $porcTotalIPS<30){
        $porcFraudeIPS=30;
    }else if($porcTotalIPS>=30 && $porcTotalIPS<40){
        $porcFraudeIPS=40;
    }else if($porcTotalIPS>=40 && $porcTotalIPS<50){
        $porcFraudeIPS=50;
    }else if($porcTotalIPS>=50 && $porcTotalIPS<60){
        $porcFraudeIPS=60;
    }else if($porcTotalIPS>=60 && $porcTotalIPS<70){
        $porcFraudeIPS=70;
    }else if($porcTotalIPS>=70 && $porcTotalIPS<80){
        $porcFraudeIPS=80;
    }else if($porcTotalIPS>=80 && $porcTotalIPS<90){
        $porcFraudeIPS=90;
    }else if($porcTotalIPS>=90){
        $porcFraudeIPS=100;
    }


     //FREUDE TIPO DE VEHICULO
    mysqli_next_result($con);
    $consultaPositivosTipoVehiculo=$consultaPositivosStand." LEFT JOIN polizas c ON c.id=b.id_poliza LEFT JOIN vehiculos d ON d.id=c.id_vehiculo 
    WHERE c.tipo_caso in (1,2,3,4,5,6,13,14,15,16,17) and a.tipo_persona=1 AND a.resultado=2 AND a.tipo_vehiculo='".$idTipoVehiculo."'";
    $queryPositivosTipoVehiculo=mysqli_query($con,$consultaPositivosTipoVehiculo);
    $resPositivosTipoVehiculo=mysqli_fetch_assoc($queryPositivosTipoVehiculo);
    $porcTotalTipoVehiculo=($resPositivosTipoVehiculo["cantidad_positivos"]/$resPositivosStand["cantidad_positivos"])*100;


    if ($porcTotalTipoVehiculo<10){
        $porcFraudeTipoVehiculo=10;
    }else if($porcTotalTipoVehiculo>=10 && $porcTotalTipoVehiculo<20){
        $porcFraudeTipoVehiculo=20;
    }else if($porcTotalIPS>=20 && $porcTotalTipoVehiculo<30){
        $porcFraudeTipoVehiculo=30;
    }else if($porcTotalTipoVehiculo>=30 && $porcTotalTipoVehiculo<40){
        $porcFraudeTipoVehiculo=40;
    }else if($porcTotalTipoVehiculo>=40 && $porcTotalTipoVehiculo<50){
        $porcFraudeTipoVehiculo=50;
    }else if($porcTotalTipoVehiculo>=50 && $porcTotalTipoVehiculo<60){
        $porcFraudeTipoVehiculo=60;
    }else if($porcTotalTipoVehiculo>=60 && $porcTotalTipoVehiculo<70){
        $porcFraudeTipoVehiculo=70;
    }else if($porcTotalTipoVehiculo>=70 && $porcTotalTipoVehiculo<80){
        $porcFraudeTipoVehiculo=80;
    }else if($porcTotalTipoVehiculo>=80 && $porcTotalTipoVehiculo<90){
        $porcFraudeTipoVehiculo=90;
    }else if($porcTotalTipoVehiculo>=90){
        $porcFraudeTipoVehiculo=100;
    }
    
    //FRAUDE TOTAL
    $porcFinalFraude=($porcFraudeCapacidadVehiculo*$porcCapacidadVehiculo)+($porcFraudeCantidadPersonasTraslado*$porcCantidadPersonasTraslado)+($porcFraudeVersionesDiferentes*$porcVersionesDiferentes)+($porcFraudeDepartamento*$porcDepartamento)+($porcFraudeIPS*$porcIPS)+($porcFraudeLesionado*$porcLesionado)+($porcFraudeVehiculo*$porcVehiculo)+($porcFraudeTipoVehiculo*$porcTipoVehiculo);


    
    $data[]=array("consultaVehiculosStand"=>$consultaVehiculosStand,
    "porcFraudeDepartamento"=>$porcFraudeDepartamento,
    "porcFraudeIPS"=>$porcFraudeIPS,
    "porcFraudeLesionado"=>$porcFraudeLesionado,
    "porcFraudeVehiculo"=>$porcFraudeVehiculo,
    "porcFraudeTipoVehiculo"=>$porcFraudeTipoVehiculo,
    "porcFraudeVersionesDiferentes"=>$porcFraudeVersionesDiferentes,
    "porcFraudeCantidadPersonasTraslado"=>$porcFraudeCantidadPersonasTraslado,
    "porcFraudeCapacidadVehiculo"=>$porcFraudeCapacidadVehiculo,
    "porcFinalFraude"=>$porcFinalFraude
    );
    echo json_encode($data);
    ?>
    