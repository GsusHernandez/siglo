<?php
include('../conexion/conexion.php');
include('consultasBasicas.php');


function consultarInfoEstadoPagosFacturas($idFactura){
	$data=array();

  $consultaValorFactura=mysql_query("SELECT * FROM facturas WHERE id='".$idFactura."'");
  $resValorFactura=mysql_fetch_array($consultaValorFactura);

  $consultaValorPagadoFactura=mysql_query("SELECT SUM(valor_pagado) as valor_pagado FROM detalle_pagos_facturas WHERE id_factura='".$idFactura."'");
  $resValorPagadoFactura=mysql_fetch_array($consultaValorPagadoFactura);


  $consultaValorPendienteFactura=mysql_query("SELECT valor_pendiente FROM detalle_pagos_facturas WHERE id=(SELECT MAX(id) FROM detalle_pagos_facturas WHERE id_factura='".$idFactura."')");
  $resValorPendienteFactura=mysql_fetch_array($consultaValorPendienteFactura);

  $data["valor_factura"]=$resValorFactura["total"];
  $data["valor_pagado"]=$resValorPagadoFactura["valor_pagado"];
  $data["valor_pendiente"]=$resValorPendienteFactura["valor_pendiente"];
        

  return ($data); 

}


function actualizarRegistrosTablaPagosFacturas($idFactura,$id_usuario)
{
  $num_valor_pago=0;$consulta="";
  $resEstadoPago=consultarInfoEstadoPagosFacturas($idFactura);
  $valorExcedentePagoFactura=0;$valorTotalPagoFactura=0;
  $consultaPagosFacturas="SELECT * FROM detalle_pagos_facturas WHERE id_factura='".$idFactura."' ORDER BY id ASC";
    $consultarPagosFacturas=mysql_query($consultaPagosFacturas);
    $cantidadRegistros=mysql_num_rows($consultarPagosFacturas);
    if($cantidadRegistros>0){
    while ($resPagosFacturas=mysql_fetch_array($consultarPagosFacturas))
    {
      $num_valor_pago=$num_valor_pago+1;
      if ($num_valor_pago==1)
      {
        $valorTotalPagoFactura=$resEstadoPago["valor_factura"];
        $estado=1;


      }else if ($num_valor_pago>1 && $num_valor_pago<$cantidadRegistros){
        $valorTotalPagoFactura=$valorExcedentePagoFactura;
        $estado=2;

      }else if ($num_valor_pago==$cantidadRegistros){
        $valorTotalPagoFactura=$valorExcedentePagoFactura;
        if (($valorTotalPagoFactura-$resPagosFacturas["valor_pagado"])==0){
          $estado=3;
        }else{
          $estado=2;
        }

      }


      $valorExcedentePagoFactura=$valorTotalPagoFactura-$resPagosFacturas["valor_pagado"];

      $consultaActualizarPagosPacientes="UPDATE detalle_pagos_facturas SET estado='".$estado."',valor_total='".$valorTotalPagoFactura."',valor_pagado='".$resPagosFacturas["valor_pagado"]."',valor_pendiente='".$valorExcedentePagoFactura."',numero_pago_factura='".($num_valor_pago)."' WHERE id='".$resPagosFacturas["id"]."'";
      mysql_query($consultaActualizarPagosPacientes);
  }
}else{
    registrarPagoFactura($idFactura,"0","0",$id_usuario);
}
}



function eliminarPagosPacientes($codigo_pago,$usuarioActual){
  $resultadoInfoPagoPaciente=consultarInformacionPagosFac($codigo_pago);
$consultarEliminarPagosPacientes="DELETE FROM detalle_valor_pago_paciente WHERE id='".$codigo_pago."'";
if (mysql_query($consultarEliminarPagosPacientes)){
  actualizarRegistrosTablaPagosPacientes($resultadoInfoPagoPaciente["id_procedimiento_realizado"],$usuarioActual);
  
  
  if (guardarLogErrores($usuarioActual,"EVENTO: CREAR REGISTRO TABLA PAGOS PACIENTES. ID REGISTRO: ".$resultadoInfoPagoPaciente["codigo_pago"].". DESCRIPCION: METODO PAGO: ".$resultadoInfoPagoPaciente["metodo_pago"].". ID PROCEDIMIENTO GENERAL: ".$resultadoInfoPagoPaciente["id_procedimiento_realizado"].". VALOR PAGADO:".$resultadoInfoPagoPaciente["valor_pagado"])==1){
    $variable=1;
  }else{
    $variable=3;
  }
}else{
  $variable=2;
}
    return ($variable);
}





function registrarPagoFactura($idFactura,$metodoPago,$valorPago,$idUsuario){

  $resultadoInfoUltimoPago=consultarUltimoPagoFactura($idFactura);
  $numero_pago_factura=$resultadoInfoUltimoPago["numero_pago_factura"]+1;
  $valorPendiente=$resultadoInfoUltimoPago["valor_pendiente"]-$valorPago;
  if ($valorPago==$resultadoInfoUltimoPago["valor_pendiente"]){
    $estado=3;
  }else{
    $estado=2;
  }

  $consultaInsertarPagoFactura="INSERT INTO detalle_pagos_facturas (id_factura,numero_pago_factura,valor_total,valor_pagado,valor_pendiente,metodo_pago,estado,fecha,usuario) VALUES ('".$idFactura."','".$numero_pago_factura."','".$resultadoInfoUltimoPago["valor_pendiente"]."','".$valorPago."','".$valorPendiente."','".$metodoPago."','".$estado."',CURRENT_TIMESTAMP,'".$idUsuario."')";

    if (mysql_query($consultaInsertarPagoFactura)){
      $idPagoFactura=mysql_insert_id();
        $resultadoInfoPagoFactura=consultarInformacionPagosFacturas($idPagoFactura);  
            if (guardarLogErrores($idUsuario,"EVENTO: CREAR REGISTRO TABLA PAGOS FACTURAS. ID REGISTRO: ".$resultadoInfoPagoFactura["codigo_pago"].". DESCRIPCION: METODO PAGO: ".$resultadoInfoPagoFactura["metodo_pago"].". ID FACTURA: ".$resultadoInfoPagoFactura["id_factura"].". VALOR PAGADO:".$resultadoInfoPagoFactura["valor_pagado"])==1){
              $variable=1;
            }else{
              $variable=3;
            }
          }else{
            $variable=2;
          }
      return ($variable);
}


function editarPagoFacturas($idPagoFactura,$metodoPago,$valorPago,$idUsuario){
   $resultadoInfoPagoFactura=consultarInformacionPagosFacturas($idPagoFactura);
$consultarModificarPagosFacturas="UPDATE detalle_pagos_facturas SET valor_pagado='".$valorPago."',metodo_pago='".$metodoPago."' WHERE id='".$idPagoFactura."'";
if (mysql_query($consultarModificarPagosFacturas)){
  actualizarRegistrosTablaPagosFacturas($resultadoInfoPagoFactura["id_factura"],$idUsuario);
  
  
  if (guardarLogErrores($idUsuario,"EVENTO: MODIFICAR REGISTRO TABLA PAGOS FACTURAS. ID REGISTRO: ".$resultadoInfoPagoFactura["codigo_pago"].". DESCRIPCION: METODO PAGO: ".$resultadoInfoPagoFactura["metodo_pago"].". ID FACTURA: ".$resultadoInfoPagoFactura["id_factura"].". VALOR PAGADO:".$resultadoInfoPagoFactura["valor_pagado"])==1){
    $variable=1;
  }else{
    $variable=3;
  }
}else{
  $variable=2;
}
    return ($variable);
}


function consultarUltimoPagoFactura($idFactura){
  $data=array();
  $consultaInformacionUltimoPagoFactura="SELECT * FROM detalle_pagos_facturas WHERE id=(SELECT MAX(id) FROM detalle_pagos_facturas WHERE id_factura='".$idFactura."')";

    $consultarInformacionUltimoPagoFactura=mysql_query($consultaInformacionUltimoPagoFactura);

  if (mysql_num_rows($consultarInformacionUltimoPagoFactura)>0){
    $resInformacionUltimoPagoFactura=mysql_fetch_array($consultarInformacionUltimoPagoFactura);
    
    $data["codigo_pago"]=$resInformacionUltimoPagoFactura["id"];
    $data["id_factura"]=$resInformacionUltimoPagoFactura["id_factura"];
    $data["numero_pago_factura"]=$resInformacionUltimoPagoFactura["numero_pago_factura"];
    $data["valor_total"]=$resInformacionUltimoPagoFactura["valor_total"];
    $data["valor_pendiente"]=$resInformacionUltimoPagoFactura["valor_pendiente"];
    $data["valor_pagado"]=$resInformacionUltimoPagoFactura["valor_pagado"];
    $data["metodo_pago"]=$resInformacionUltimoPagoFactura["metodo_pago"];
    $data["estado"]=$resInformacionUltimoPagoFactura["estado"];
    
    
  }else{
    $resEstadoPagos=consultarInfoEstadoPagosFacturas($idFactura);
    $data["codigo_pago"]="0";
    $data["id_factura"]=$idFactura;
    $data["numero_pago_factura"]="0";
    $data["valor_total"]=$resEstadoPagos["valor_pago"];
    $data["valor_pendiente"]=$resEstadoPagos["valor_pago"];
    $data["metodo_pago"]="0";
    $data["estado"]="1";

  }

    return $data;


}


function consultarInformacionPagosFacturas($idPagoFactura){
	  $data=array();
    $consultaInformacionPagosFacturas="SELECT a.id as codigo_pago,a.id_factura,a.valor_total,a.valor_pagado,a.valor_pendiente,a.metodo_pago as codigo_forma_pago,a.estado as codigo_estado_transaccion, b.descripcion as metodo_pago,c.descripcion as estado FROM detalle_pagos_facturas a LEFT JOIN definicion_tipos b on a.metodo_pago=b.id LEFT JOIN definicion_tipos c ON c.id=a.estado WHERE b.id_tipo=2 and c.id_tipo=9 and a.id='".$idPagoFactura."'";
    
	$consultarInformacionPagoFactura=mysql_query($consultaInformacionPagosFacturas);
	if (mysql_num_rows($consultarInformacionPagoFactura)>0){
		$resInformacionRegistroPagoFactura=mysql_fetch_array($consultarInformacionPagoFactura);
		
		$data["id_factura"]=$resInformacionRegistroPagoFactura["id_factura"];
    $data["codigo_pago"]=$resInformacionRegistroPagoFactura["codigo_pago"];
    $data["valor_total"]=$resInformacionRegistroPagoFactura["valor_total"];
    $data["valor_pagado"]=$resInformacionRegistroPagoFactura["valor_pagado"];
    $data["valor_pendiente"]=$resInformacionRegistroPagoFactura["valor_pendiente"];
    $data["codigo_forma_pago"]=$resInformacionRegistroPagoFactura["codigo_forma_pago"];
    $data["codigo_estado"]=$resInformacionRegistroPagoFactura["codigo_estado"];
    $data["metodo_pago"]=$resInformacionRegistroPagoFactura["metodo_pago"];
    $data["estado"]=$resInformacionRegistroPagoFactura["estado"];
    

    
	}
	return $data;
}




?>