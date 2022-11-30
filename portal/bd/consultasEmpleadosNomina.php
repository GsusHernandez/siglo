<?php
include('../conexion/conexion.php');
include('consultasBasicas.php');


function crearEmpleado($nombres,$apellidos,$tipo_identificacion,$identificacion,$tipo_empleado,$telefono,$direccion,$correo,$id_usuario){
  $resultadoInfoEmpleado=consultarInformacionEmpleados($identificacionEmpleado,"0");
  if ($resultadoInfoEmpleado["cantidadRegistrosEmpleados"]==0){
    $data=array();
    $consultaInsertarEmpleados="INSERT INTO empleados_nomina (nombres,apellidos,tipo_identificacion,identificacion,telefono,direccion,correo,tipo_empleado,vigente,id_usuario,fecha) VALUES ('".$nombres."','".$apellidos."','".$tipo_identificacion."','".$identificacion."','".$telefono."','".$direccion."','".$correo."','".$tipo_empleado."','s','".$id_usuario."',CURRENT_TIMESTAMP)";
    if (mysql_query($consultaInsertarEmpleados)){
      $idUltimoEmpleado=mysql_insert_id();
                  $data["idRegistro"]=$idUltimoEmpleado;

              $data["respuesta"]=1;
            
          }else{
            $data["respuesta"]=2;
            
          }
    
  }else{
    $data["respuesta"]=3;
    
  }
  

      return ($data);
}


function editarEmpleado($nombres,$apellidos,$tipo_identificacion,$identificacion,$tipo_empleado,$telefono,$direccion,$correo,$idRegistroEmpleado){

  $resultadoInfoEmpleado=consultarInformacionEmpleados("0",$idRegistroEmpleado);
  if ($resultadoInfoEmpleado["cantidadRegistrosEmpleados"]==1){
    $data=array();
    $consultaModificarEmpleado="UPDATE empleados_nomina SET nombres='".$nombres."',apellidos='".$apellidos."',telefono='".$telefono."',identificacion='".$identificacion."',tipo_identificacion='".$tipo_identificacion."',correo='".$correo."',telefono='".$telefono."',direccion='".$direccion."' WHERE id='".$idRegistroEmpleado."'";
    if (mysql_query($consultaModificarEmpleado)){
                  
                  $data["idRegistro"]=$resultadoInfoEmpleado["idEmpleado"];

              $data["respuesta"]=1;
    
          }else{
            $data["respuesta"]=2;
            
          }
    
  }else{
    $data["respuesta"]=3;
    
  }
  

      return ($data);
}


function eliminarEmpleadosNomina($empleado){
$consultarEliminarEmpleado="DELETE FROM empleados_nomina WHERE id='".$empleado."'";
if (mysql_query($consultarEliminarEmpleado)){

    $variable=1;

}else{
  $variable=2;
}
    
  
        
  
      return ($variable);
}

function vigenciaEmpleadosNomina($empleado){
  $resultadoInfoEmpleado=consultarInformacionEmpleados("0",$empleado);

$consultarVigenciaEmpleados="UPDATE empleados_nomina SET ";
if ($resultadoInfoEmpleado["vigente"]=="s"){
  $consultarVigenciaEmpleados.="vigente='n'";
}else{
  $consultarVigenciaEmpleados.="vigente='s'";
}
$consultarVigenciaEmpleados.=" WHERE id='".$empleado."'";
if (mysql_query($consultarVigenciaEmpleados)){
    $variable=1;

}else{
  $variable=2;
}
    
  
        
  
      return ($variable);
}



function consultarInformacionPagoEmpleado($idRegistroEmpleado)
{
  $data=array();
  $consultaInformacionPagoEmpleados="SELECT * FROM informacion_pagos WHERE usuario_pago='".$idRegistroEmpleado."'";

  $consultarInformacionPagoEmpleados=mysql_query($consultaInformacionPagoEmpleados);
  $cantidadInformacionPagoEmpleados=mysql_num_rows($consultarInformacionPagoEmpleados);
  $data["cantidadRegistrosInformacionPagoEmpleados"]=$cantidadInformacionPagoEmpleados;
  if ($cantidadInformacionPagoEmpleados>0){
    $resInformacionPagoEmpleados=mysql_fetch_array($consultarInformacionPagoEmpleados);
      $data["idMetodoPago"]=$resInformacionPagoEmpleados["id"];
      $data["usuario_pago"]=$resInformacionPagoEmpleados["usuario_pago"];
      $data["metodo_pago"]=$resInformacionPagoEmpleados["metodo_pago"];
      $data["tipo_producto"]=$resInformacionPagoEmpleados["tipo_producto"];
      $data["num_referencia"]=$resInformacionPagoEmpleados["num_referencia"];
      
      
    
    
  }
  return $data;
}




function consultarInformacionEmpleados($identificacionEmpleado,$idEmpleado){
	  $data=array();
    $consultaInformacionEmpleados="SELECT * FROM empleados_nomina WHERE";

    if ($identificacionEmpleado=="0" && $idEmpleado!="0"){
      $consultaInformacionEmpleados.=" id='".$idEmpleado."'";
    }else if ($identificacionEmpleado!="0" && $idEmpleado=="0"){
      $consultaInformacionEmpleados.=" identificacion='".$identificacionEmpleado."'";
    }
    


	$consultarInformacionEmpleados=mysql_query($consultaInformacionEmpleados);
  $cantidadRegistrosEmpleados=mysql_num_rows($consultarInformacionEmpleados);
  $data["cantidadRegistrosEmpleados"]=$cantidadRegistrosEmpleados;
	if ($cantidadRegistrosEmpleados>0){
		$resInformacionEmpleado=mysql_fetch_array($consultarInformacionEmpleados);
		
		  $data["nombres_empleado"]=$resInformacionEmpleado["nombres"];
      $data["apellidos_empleado"]=$resInformacionEmpleado["apellidos"];
    	$data["tipo_idenificacion_empleado"]=$resInformacionEmpleado["tipo_identificacion"];
      $data["identificacion_empleado"]=$resInformacionEmpleado["identificacion"];
    	$data["correo_empleado"]=$resInformacionEmpleado["correo"];
      $data["telefono_empleado"]=$resInformacionEmpleado["telefono"];
      $data["direccion_empleado"]=$resInformacionEmpleado["direccion"];
      $data["tipo_empleado"]=$resInformacionEmpleado["tipo_empleado"];
      $data["vigente"]=$resInformacionEmpleado["vigente"];
      $data["idEmpleado"]=$resInformacionEmpleado["id"];

    	
    
    
	}
	return $data;
}




?>