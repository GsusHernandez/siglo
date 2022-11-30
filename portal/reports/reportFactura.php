<?php
include_once('estilosReportes.php');
include('../conexion/conexion.php');

$pdf = new PDF('P','mm','Letter');

$consultaBasicaDatosEmpresa="SELECT * FROM definicion_tipos WHERE id_tipo=6 and ";
$consultaNombreEmpresa=mysql_query($consultaBasicaDatosEmpresa."id='1'");
$consultaIdentificacionEmpresa=mysql_query($consultaBasicaDatosEmpresa."id='2'");

$resNombreEmpresa=mysql_fetch_array($consultaNombreEmpresa);
$resIdentificacionEmpresa=mysql_fetch_array($consultaIdentificacionEmpresa);

$consultarInformacionFacturacion=mysql_query("SELECT numero_resolucion,DATE_FORMAT(inicio_vigencia,'%d-%m-%Y') as fecha_resolucion,numero_inicial,numero_final FROM resoluciones_facturacion WHERE vigente='s'");
$resInformacionFacturacion=mysql_fetch_array($consultarInformacionFacturacion);



if (isset($_GET["idFact"]))
{
	$consultarCantidadProcedimientosFactura=mysql_query("SELECT * FROM procedimientos_facturas WHERE id_factura='".$_GET["idFact"]."'");


	if (mysql_num_rows($consultarCantidadProcedimientosFactura)==1)
	{
		//NUMERO DE FACTURA, UNA SOLA FACTURA SIN RELACION

		$pdf->AddPage();
		$pdf->CabeceraDocumentos();
		$pdf->recuadrosFijosFacturacion($resInformacionFacturacion["numero_resolucion"],$resInformacionFacturacion["numero_inicial"],$resInformacionFacturacion["numero_final"],$resInformacionFacturacion["fecha_resolucion"],$resNombreEmpresa["descripcion"],$resIdentificacionEmpresa["descripcion"]);
		$pdf->informacionFacturacionPaciente($_GET["idFact"]);


	}
	else if (mysql_num_rows($consultarCantidadProcedimientosFactura)>1)
	{
		//NUMERO DE FACTURA, UNA SOLA FACTURA CON RELACION
		$pdf->AddPage();
		$pdf->CabeceraDocumentos();
		$pdf->recuadrosFijosFacturacion($resInformacionFacturacion["numero_resolucion"],$resInformacionFacturacion["numero_inicial"],$resInformacionFacturacion["numero_final"],$resInformacionFacturacion["fecha_resolucion"],$resNombreEmpresa["descripcion"],$resIdentificacionEmpresa["descripcion"]);
		$pdf->informacionFacturacionTotalRelacion($_GET["idFact"]);
		
	}



}else if (isset($_GET["arrFacturas"])){
	//RANGO DE FECHA, VARIAS FACTURAS
	$separarFacturas=explode("-",$_GET["arrFacturas"]);
	foreach ($separarFacturas as $idFact)
	{
		$consultarCantidadProcedimientosFactura=mysql_query("SELECT * FROM procedimientos_facturas WHERE id_factura='".$idFact."'");

		if (mysql_num_rows($consultarCantidadProcedimientosFactura)==1)
		{

			$pdf->AddPage();
			$pdf->CabeceraDocumentos();
			$pdf->recuadrosFijosFacturacion($resInformacionFacturacion["numero_resolucion"],$resInformacionFacturacion["numero_inicial"],$resInformacionFacturacion["numero_final"],$resInformacionFacturacion["fecha_resolucion"],$resNombreEmpresa["descripcion"],$resIdentificacionEmpresa["descripcion"]);
			$pdf->informacionFacturacionPaciente($idFact);

		}
		else if (mysql_num_rows($consultarCantidadProcedimientosFactura)>1)
		{
			$pdf->AddPage();
			$pdf->CabeceraDocumentos();
			$pdf->recuadrosFijosFacturacion($resInformacionFacturacion["numero_resolucion"],$resInformacionFacturacion["numero_inicial"],$resInformacionFacturacion["numero_final"],$resInformacionFacturacion["fecha_resolucion"],$resNombreEmpresa["descripcion"],$resIdentificacionEmpresa["descripcion"]);
			$pdf->informacionFacturacionTotalRelacion($idFact);

		}

		

	}

}








$pdf->Output();
?>