<?php
include('../conexion/conexion.php');
include('consultasBasicas.php');


function GenerarFacturaAseguradora($idAseguradora,$anoFacturaRangoFecha,$mesFacturaRangoFecha,$tipoCasoFacturaRangoFecha,$fechaInicioFacturaRangoFecha,$fechaFinFacturaRangoFecha,$idUsuario)
{
  $data=array();
  
  if (validarVigenciaResolucion()==1)
  {
    if (validarNumeroFacturacion()==1)
    {
      $variable=ProcesoGenerarFacturaIndividualClientes($agruparFacturaRangoFecha,$fechaInicioFacturaRangoFecha,$fechaFinFacturaRangoFecha,$idCliente,$idUsuario);

     
      


    }else{
      $variable=2;
    }
  }else{
    $variable=3;
  }
  return (ProcesoGenerarFacturaIndividualClientes($agruparFacturaRangoFecha,$fechaInicioFacturaRangoFecha,$fechaFinFacturaRangoFecha,$idCliente,$idUsuario));
}





function vireRangoFacturas($tipoID,$numeroInicialViewFacturas,$numeroFinalViewFacturas)
{
  $data=array();
  $arrFacturas="";
  $cont=0;
  if ($tipoID=="facturasIDFactura")
  {
    $numeroInicial=consultarInformacionFactura($numeroInicialViewFacturas,"0","0");
    $numeroFinal=consultarInformacionFactura($numeroFinalViewFacturas,"0","0");


    if ($numeroInicial["cantidad"]==0){
        $consultaPrimeraFactura="SELECT min(id) as id_factura FROM facturas WHERE id>".$numeroInicialViewFacturas;
        $queryPrimeraFactura=mysql_query($consultaPrimeraFactura);
        $resPrimeraFactura=mysql_fetch_array($queryPrimeraFactura);
        $numero1=$resPrimeraFactura["id_factura"];  
    }else{
        $numero1=$numeroInicial["id_factura"];
    }

    if ($numeroFinal["cantidad"]==0)
    {
      $consultaUltimaFactura="SELECT max(id) as id_factura FROM facturas WHERE id<".$numeroFinalViewFacturas;
      $queryUltimaFactura=mysql_query($consultaUltimaFactura);
      $resUltimaFactura=mysql_fetch_array($queryUltimaFactura);
      $numero2=$resUltimaFactura["id_factura"];  

    }else{
      $numero2=$numeroFinal["id_factura"];  
    }

      $cont=$numero1;
  }
  else if ($tipoID=="facturasNumeroFactura")
  {
    $numeroInicial=consultarInformacionFactura("0","0",$numeroInicialViewFacturas);
    $numeroFinal=consultarInformacionFactura("0","0",$numeroFinalViewFacturas);
    
    if ($numeroInicial["cantidad"]==0){
        $consultaPrimeraFactura="SELECT min(id) as id_factura FROM facturas WHERE numero_factura>".$numeroInicialViewFacturas;
        $queryPrimeraFactura=mysql_query($consultaPrimeraFactura);
        $resPrimeraFactura=mysql_fetch_array($queryPrimeraFactura);
        $numero1=$resPrimeraFactura["id_factura"];  
    }else{
        $numero1=$numeroInicial["id_factura"];
    }


    if ($numeroFinal["cantidad"]==0)
    {
      $consultaUltimaFactura="SELECT max(id) as id_factura FROM facturas WHERE numero_factura<".$numeroFinalViewFacturas;
      $queryUltimaFactura=mysql_query($consultaUltimaFactura);
      $resUltimaFactura=mysql_fetch_array($queryUltimaFactura);
      $numero2=$resUltimaFactura["id_factura"];  

    }else{
      $numero2=$numeroFinal["id_factura"];  
    }
    
    $cont=$numero1;

  }
  while ($cont<=$numero2){
    $arrFacturas.=$cont;
            if ($cont!=$numero2){
              $arrFacturas.="-";  
            }    
            $cont++;
  }

$consultarFacturas="SELECT * FROM facturas WHERE id in (".str_replace("-",",",$arrFacturas).")";
$queryFactruas=mysql_query($consultarFacturas);
if (mysql_num_rows($queryFactruas)>0){
  $data["resultado"]=1;
  $data["ruta"]="reports/reportFactura.php?arrFacturas=".$arrFacturas;
}else{
  $data["resultado"]=2;
}

return ($data);

}

function eliminarFactura($factura,$usuarioActual){
  $resultadoInfoFactura=consultarInformacionFactura($factura,"0","0");
$consultarEliminarFactura="DELETE FROM facturas WHERE id='".$factura."'";
if (mysql_query($consultarEliminarFactura))
{
  $consultarEliminarProcedimientosFacturas="DELETE FROM procedimientos_facturas WHERE id_factura='".$factura."'";
  if (mysql_query($consultarEliminarProcedimientosFacturas))
  {
    if (guardarLogErrores($usuarioActual,"EVENTO: ELIMINAR REGISTRO TABLA FACTURAS. ID REGISTRO: ".$resultadoInfoFactura["id_factura"].". DESCRIPCION: NOMBRE CLIENTE: ".$resultadoInfoFactura["cliente"].". VALOR PROCEDIMIENTOS: ".$resultadoInfoFactura["valor_procedimientos"].". DESCUENTOS: ".$resultadoInfoFactura["descuento"].". SUBTOTAL: ".$resultadoInfoFactura["subtotal"].". IVA: ".$resultadoInfoFactura["iva"].". TOTAL: ".$resultadoInfoFactura["total"])==1){
    $variable=1;
  }else{
    $variable=3;
  }

  }
  
}else{
  $variable=2;
}
    
  
        
  
      return ($variable);
}






















function consultarValoresFacturas($tipoFactura,$valorExcedente,$valorProcedimientos,$valorPagoPaciente){
$data=array();
  

  $consultarIVA=mysql_query("SELECT * FROM definicion_tipos WHERE id_tipo=6 and id=8");
  $resIVA=mysql_fetch_array($consultarIVA);

  $valorPagoIVA=($valorExcedente*($resIVA["descripcion"]/100));
  $valorTotal=$valorExcedente+$valorPagoIVA;
  if ($tipoFactura=="p"){
    $valorDescuento=(float)$valorProcedimientos-(float)$valorPagoPaciente;  
  }else if ($tipoFactura=="t"){
    $valorDescuento=(float)$valorPagoPaciente;  
  }
  
  $data["valor_iva"]=$valorPagoIVA;
  $data["valor_total"]=$valorTotal;
  $data["valor_descuento"]=$valorDescuento;
  
  $data["valor_subtotal"]=$valorExcedente;
  $data["valor_procedimientos"]=$valorProcedimientos;

  return($data);

}



function ActualizarValoresFactura($idProcedimientoRealizado,$idFactura)
{
 $data=array();
 $consultarValoresCostosProcedimientos=mysql_query("SELECT * FROM pagos_procedimientos_realizados WHERE id_procedimiento_realizado='".$idProcedimientoRealizado."'");

  $resValoresCostosProcedimientos=mysql_fetch_array($consultarValoresCostosProcedimientos);

  $resValoresFacturas=consultarValoresFacturas("p",$resValoresCostosProcedimientos["valor_excedente"],$resValoresCostosProcedimientos["valor_procedimiento_realizado"],$resValoresCostosProcedimientos["valor_pago_paciente"]);


  $actualizarInformacionFactura="UPDATE facturas SET valor_procedimientos='".$resValoresFacturas["valor_procedimientos"]."',descuento='".$resValoresFacturas["valor_descuento"]."',subtotal='".$resValoresFacturas["valor_subtotal"]."',iva='".$resValoresFacturas["valor_iva"]."',total='".$resValoresFacturas["valor_total"]."' WHERE id='".$idFactura."'";

  if (mysql_query($actualizarInformacionFactura)){
    $data["resultado"]=1;
          $data["idFact"]=$idFactura;
  }else{
    $data["resultado"]=2;
  }
  return ($data);

}















function ProcesoGenerarFacturaIndividual($idProcedimiento,$idUsuario)
{

$data=array();
$consultarValoresCostosProcedimientos=mysql_query("SELECT a.id_cliente,b.valor_excedente,b.valor_procedimiento_realizado,b.valor_pago_paciente FROM procedimientos_realizados a LEFT JOIN pagos_procedimientos_realizados b ON a.id=b.id_procedimiento_Realizado WHERE b.id_procedimiento_realizado='".$idProcedimiento."'");

  $resValoresCostosProcedimientos=mysql_fetch_array($consultarValoresCostosProcedimientos);

  $resValoresFacturas=consultarValoresFacturas("p",$resValoresCostosProcedimientos["valor_excedente"],$resValoresCostosProcedimientos["valor_procedimiento_realizado"],$resValoresCostosProcedimientos["valor_pago_paciente"]);

  $resConsultarInformacionFactura=consultarUltimaFacturaResolucionVigente();
      $crearFactura="INSERT INTO facturas (id_cliente,numero_factura,resolucion,valor_procedimientos,descuento,subtotal,iva,total,fecha,usuario) VALUES ('".$resValoresCostosProcedimientos["id_cliente"]."','".($resConsultarInformacionFactura["numero_factura"])."','".$resConsultarInformacionFactura["id_resolucion_vigente"]."','".$resValoresFacturas["valor_procedimientos"]."','".$resValoresFacturas["valor_descuento"]."','".$resValoresFacturas["valor_subtotal"]."','".$resValoresFacturas["valor_iva"]."','".$resValoresFacturas["valor_total"]."',CURRENT_TIMESTAMP,'".$idUsuario."')";

      if (mysql_query($crearFactura)){
        $idUltimaFactura=mysql_insert_id();
        
        $consultaInsertarPagosFacturas="INSERT INTO detalle_pagos_facturas (id_factura,numero_pago_factura,valor_total,valor_pagado,valor_pendiente,metodo_pago,estado,usuario,fecha) VALUES ('".$idUltimaFactura."','1','".$resValoresFacturas["valor_total"]."','0','".$resValoresFacturas["valor_total"]."','0','1','".$idUsuario."',CURRENT_TIMESTAMP)";
            mysql_query($consultaInsertarPagosFacturas);

        $consultaFacturaProcedimientos="INSERT INTO procedimientos_facturas (id_factura,id_procedimiento_realizado,fecha,usuario) VALUES ('".$idUltimaFactura."','".$idProcedimiento."',CURRENT_TIMESTAMP,'".$idUsuario."')";
        if (mysql_query($consultaFacturaProcedimientos)){
          $data["resultado"]=1;
          $data["idFact"]=$idUltimaFactura;
        }else{
          $data["resultado"]=2;
        }
      }

return ($data);


}


function consultarUltimaFacturaResolucionVigente()
{
      $data=array();

    $consultarUltimaFacturaGenerada=mysql_query("SELECT * FROM facturas WHERE id=(SELECT MAX(id) as id_ultima_factura FROM facturas)");

      $consultarNumeroFacturacion=mysql_query("SELECT * FROM resoluciones_facturacion WHERE vigente='s'");
  $resNumeroFacturacion=mysql_fetch_array($consultarNumeroFacturacion);
$resUltimaFacturaGenerada=mysql_fetch_array($consultarUltimaFacturaGenerada);
    if (mysql_num_rows($consultarUltimaFacturaGenerada)>0 && $resUltimaFacturaGenerada["resolucion"]==$resNumeroFacturacion["id"]){
        
        $data["numero_factura"]=$resUltimaFacturaGenerada["numero_factura"]+1;
        $data["numero_inicial"]=$resNumeroFacturacion["numero_inicial"];
        $data["numero_final"]=$resNumeroFacturacion["numero_final"];


    }else{
        $data["numero_factura"]=$resNumeroFacturacion["numero_inicial"];
        $data["numero_inicial"]=$resNumeroFacturacion["numero_inicial"];
        $data["numero_final"]=$resNumeroFacturacion["numero_final"];


    }
    
    $data["id_resolucion_vigente"]=$resNumeroFacturacion["id"];

    return $data;

}

function validarNumeroFacturacion()
{
  $consultarUltimaFacturaGenerada=mysql_query("SELECT * FROM facturas WHERE id=(SELECT MAX(id) as id_ultima_factura FROM facturas)");
  $resUltimaFacturaGenerada=mysql_fetch_array($consultarUltimaFacturaGenerada);

  $consultarNumeroFacturacion=mysql_query("SELECT * FROM resoluciones_facturacion WHERE vigente='s'");
  $resNumeroFacturacion=mysql_fetch_array($consultarNumeroFacturacion);
  if (mysql_num_rows($consultarUltimaFacturaGenerada)==0){

    return "1";
  }else {

    if ($resNumeroFacturacion["numero_final"]==$resUltimaFacturaGenerada["numero_factura"]){
    return "2";
  }else{
    return "1";
  }

  }

}


function validarVigenciaResolucion()
{
  $consultarResolucionVigente=mysql_query("SELECT a.* FROM (

SELECT inicio_vigencia,fin_vigencia,CURRENT_DATE() AS fecha_actual FROM resoluciones_facturacion WHERE vigente='s'
    ) as a WHERE a.fecha_actual BETWEEN a.inicio_vigencia and a.fin_vigencia");
  
  if (mysql_num_rows($consultarResolucionVigente)>0){
    return "1";

  }else{
    return "2";    
  }
  

}















function consultarInformacionFactura($idFactura,$idProcedimiento,$numero_factura){
	  $data=array();

    $consultaInformacionFactura="SELECT b.id_procedimiento_realizado,a.id as id_factura,a.total,a.valor_procedimientos,a.descuento,a.subtotal,a.iva,c.nombre as cliente FROM facturas a LEFT JOIN procedimientos_facturas b ON a.id=b.id_factura LEFT JOIN clientes c ON c.id=a.id_cliente WHERE ";
    if ($idFactura!="0" && $idProcedimiento=="0" && $numero_factura=="0"){
      $consultaInformacionFactura.="a.id='".$idFactura."'";
    } 
    if ($idProcedimiento!="0" && $idFactura=="0" && $numero_factura=="0"){
      $consultaInformacionFactura.="b.id_procedimiento_realizado='".$idProcedimiento."'";
    }
    if ($idProcedimiento=="0" && $idFactura=="0" && $numero_factura!="0"){
      $consultaInformacionFactura.="a.numero_factura='".$numero_factura."'";
    }
	$consultarInformacionFactura=mysql_query($consultaInformacionFactura);
  $cantidadRegistrosFactura=mysql_num_rows($consultarInformacionFactura);
  
      $data["cantidad"]=$cantidadRegistrosFactura;

	if ($cantidadRegistrosFactura>0){
		$resInformacionFactura=mysql_fetch_array($consultarInformacionFactura);
		$data["id_factura"]=$resInformacionFactura["id_factura"];
    $data["id_procedimiento_realizado"]=$resInformacionFactura["id_procedimiento_realizado"];
    $data["cliente"]=$resInformacionFactura["cliente"];
    $data["valor_procedimientos"]=$resInformacionFactura["valor_procedimientos"];
    $data["subtotal"]=$resInformacionFactura["subtotal"];
    $data["descuento"]=$resInformacionFactura["descuento"];
    $data["iva"]=$resInformacionFactura["iva"];
    $data["total"]=$resInformacionFactura["total"];
	
    
	}
	return $data;
}



?>