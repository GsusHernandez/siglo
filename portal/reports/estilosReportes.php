<?php
require('../bower_components/fpdf181/fpdf.php');
include('../conexion/conexion.php');
include('../bd/CifrasEnLetras.php');
setlocale(LC_MONETARY, 'en_US');

class PDF extends FPDF
{


  function CabeceraDocumentos()
  {
    $this->Image('logo3.jpg',0,3,215);
    $this->Image('footer.jpg',20,250,170);
  }

  

  function informacionFacturacionTotalRelacion($idFactura)
  {
    $contarPacientes=mysql_query("SELECT DISTINCT(c.id_paciente) FROM facturas a LEFT JOIN procedimientos_facturas b ON a.id=b.id_factura LEFT JOIN procedimientos_realizados c ON c.id=b.id_procedimiento_realizado WHERE a.id='".$idFactura."'");
    $cantidadPacientes=mysql_num_rows($contarPacientes);

    $consultarFactura=mysql_query("SELECT a.id,a.resolucion,a.numero_factura,a.valor_procedimientos,a.descuento,a.subtotal,a.iva,a.total,a.usuario,DATE_FORMAT(a.fecha, '%Y-%m-%d') as fecha_factura,b.nombre,b.codigo,b.identificacion,b.telefono,b.direccion FROM facturas a LEFT JOIN clientes b ON a.id_cliente=b.id WHERE a.id='".$idFactura."'");
    
    $resFactura=mysql_fetch_array($consultarFactura);

    $this->EstiloCellFactura(10,"",42,53,105,4,$resFactura["nombre"],"L");
    $this->EstiloCellFactura(10,"",55,59,92,4,$resFactura["identificacion"],"L");
    $this->EstiloCellFactura(10,"",47,65,100,4,$resFactura["direccion"],"L");
    $this->EstiloCellFactura(10,"",46,71,101,4,$resFactura["telefono"],"L");
    $this->EstiloCellFactura(10,"",155,67,45,9,$resFactura["fecha_factura"],"C");
  

    $this->EstiloCellFactura(10,"",40,120,107,4,"PROCEDIMIENTOS REALIZADOS A ".$cantidadPacientes." PACIENTE(S)","L");
    $this->EstiloCellFactura(10,"",155,120,45,4,money_format('%.2n',$resFactura["valor_procedimientos"]),"C");


    $this->EstiloCellFactura(10,"B",60,185,90,4,"DESCUENTOS:","L");
    $this->EstiloCellFactura(10,"B",155,185,45,4,money_format('%.2n',$resFactura["descuento"]),"C");


    $this->EstiloCellFactura(10,"B",155,190,45,8,money_format('%.2n',$resFactura["subtotal"]),"C");
    $this->EstiloCellFactura(10,"B",155,198,45,8,money_format('%.2n',$resFactura["iva"]),"C");
    $this->EstiloCellFactura(10,"B",155,206,45,8,money_format('%.2n',$resFactura["total"]),"C");

    $valorLetra=CifrasEnLetras::convertirNumeroEnLetras(str_replace(".",",",$resFactura["total"]));
    $this->EstiloMulticellFactura(10,"B",32,196,86,4,$valorLetra." Pesos Moneda Corriente","J");



    $this->EstiloCellFacturaColorRojo(12,"B",155,55,45,8,$resFactura["numero_factura"],"C");



  }


  function informacionFacturacionPaciente($idFactura)
  {

  	$consultarFactura=mysql_query("SELECT a.id,a.resolucion,a.numero_factura,a.valor_procedimientos,a.descuento,a.subtotal,a.iva,a.total,a.usuario,DATE_FORMAT(a.fecha, '%Y-%m-%d') as fecha_factura,b.nombre,b.codigo,b.identificacion,b.telefono,b.direccion FROM facturas a LEFT JOIN clientes b ON a.id_cliente=b.id WHERE a.id='".$idFactura."'");
  	
  	$resFactura=mysql_fetch_array($consultarFactura);

  	$consultarProcedimientoAsociado=mysql_query("SELECT * FROM procedimientos_facturas WHERE id_factura='".$idFactura."'");

  	$resProcedimientosAsociado=mysql_fetch_array($consultarProcedimientoAsociado);

  	$consultarInformacionEspecificaFactura=mysql_query("SELECT CONCAT(c.primer_nombre,' ',c.segundo_nombre,' ',c.primer_apellido,' ',c.segundo_apellido) as nombre_paciente,CONCAT(d.descripcion,' ',c.identificacion) as identificacion_paciente FROM procedimientos_realizados a LEFT JOIN pacientes c ON c.id=a.id_paciente LEFT JOIN definicion_tipos d ON d.id=c.tipo_identificacion WHERE d.id_tipo=5 and a.id='".$resProcedimientosAsociado["id_procedimiento_realizado"]."'");

  	$resInformacionEspecificaFactura=mysql_fetch_array($consultarInformacionEspecificaFactura);

  	$consultarProcedimientosDetalle=mysql_query("SELECT c.nombre as nombre_procedimiento, b.valor_procedimiento FROM detalle_procedimientos_realizados a LEFT JOIN detalle_valor_procedimientos_realizados b ON a.id=b.id_detalle_procedimiento_realizado LEFT JOIN procedimientos c ON c.id=a.id_procedimiento WHERE a.id_procedimiento_realizado='".$resProcedimientosAsociado["id_procedimiento_realizado"]."'");


  	$this->EstiloCellFactura(10,"",42,53,105,4,$resFactura["nombre"],"L");
    $this->EstiloCellFactura(10,"",55,59,92,4,$resFactura["identificacion"],"L");
    $this->EstiloCellFactura(10,"",47,65,100,4,$resFactura["direccion"],"L");
    $this->EstiloCellFactura(10,"",46,71,101,4,$resFactura["telefono"],"L");
    $this->EstiloCellFactura(10,"",155,67,45,9,$resFactura["fecha_factura"],"C");

    $this->EstiloCellFactura(10,"B",25,100,21,4,"PACIENTE: ","L");
    $this->EstiloCellFactura(10,"",47,100,100,4, $resInformacionEspecificaFactura["nombre_paciente"],"L");

    $this->EstiloCellFactura(10,"B",25,105,31,4,"IDENTIFICACION: ","L");
    $this->EstiloCellFactura(10,"",57,105,90,4,$resInformacionEspecificaFactura["identificacion_paciente"],"L");

    $this->EstiloCellFactura(10,"B",25,115,35,4,"PROCEDIMIENTOS: ","L");
    $y=115;
    while ($resProcedimientosDetalle=mysql_fetch_array($consultarProcedimientosDetalle))
    {
    	$y=$y+5;
    	$this->EstiloCellFactura(8,"",40,$y,107,4,$resProcedimientosDetalle["nombre_procedimiento"],"L");
    	$this->EstiloCellFactura(10,"",155,$y,45,4,money_format('%.2n',$resProcedimientosDetalle["valor_procedimiento"]),"C");

    }

    $this->EstiloCellFactura(10,"B",60,185,90,4,"DESCUENTOS:","L");
    $this->EstiloCellFactura(10,"B",155,185,45,4,money_format('%.2n',$resFactura["descuento"]),"C");


    $this->EstiloCellFactura(10,"B",155,190,45,8,money_format('%.2n',$resFactura["subtotal"]),"C");
    $this->EstiloCellFactura(10,"B",155,198,45,8,money_format('%.2n',$resFactura["iva"]),"C");
    $this->EstiloCellFactura(10,"B",155,206,45,8,money_format('%.2n',$resFactura["total"]),"C");

    $valorLetra=CifrasEnLetras::convertirNumeroEnLetras(str_replace(".",",",$resFactura["total"]));
    $this->EstiloMulticellFactura(10,"B",32,196,86,4,$valorLetra." Pesos Moneda Corriente","J");

    $this->EstiloCellFacturaColorRojo(12,"B",155,55,45,8,$resFactura["numero_factura"],"C");
  }


  function recuadrosFijosFacturacion($resolucion_dian,$numero_factura_inicial,$numero_factura_final,$fecha_resolucion,$nombre_empresa,$identificacion_empresa){
      $this->EstiloCellFactura(8,"B",110,35,100,5,"RESOLUCION DIAN No. ".$resolucion_dian." FECHA ".$fecha_resolucion,"C");
      $this->EstiloCellFactura(8,"B",110,38,100,5,"NUMERACION AUTORIZADA DESDE ".$numero_factura_inicial." AL ".$numero_factura_final,"C");
      $this->EstiloCellFactura(8,"B",20,32,80,5,$nombre_empresa,"C");
      $this->EstiloCellFactura(8,"B",20,36,80,5,$identificacion_empresa,"C");

      $this->EstiloCellFactura(10,"B",22,53,19,4,"CLIENTE: ","L");
      $this->EstiloCellFactura(10,"B",22,59,32,4,"IDENTIFICACION: ","L");
      $this->EstiloCellFactura(10,"B",22,65,24,4,"DIRECCION: ","L");
      $this->EstiloCellFactura(10,"B",22,71,23,4,"TELEFONO: ","L");
      $this->Line(20,50,150,50);
      $this->Line(20,50,20,77);
      $this->Line(20,77,150,77);
      $this->Line(150,50,150,77);

      $this->EstiloCellFactura(8,"B",155,50,40,4,"FACTURA DE VENTA No.: ","L");
      $this->Line(155,50,200,50);
      $this->EstiloCellFactura(8,"B",155,64,20,4,"FECHA: ","L");
      $this->Line(155,63.5,200,63.5);

      $this->Line(155,50,155,77);
      $this->Line(155,77,200,77);
      $this->Line(200,50,200,77);

      $this->Line(20,85,200,85);
      $this->EstiloCellFactura(10,"B",20,85,135,8,"DESCRIPCION","C");
      $this->EstiloCellFactura(10,"B",155,85,45,8,"VALOR","C");

      $this->Line(20,93,200,93);
      $this->Line(20,190,200,190);
      $this->EstiloCellFactura(10,"B",22,190,10,8,"SON:","C");
      $this->Line(20,85,20,214);
      $this->Line(200,85,200,214);
      $this->Line(155,85,155,214);
      $this->Line(120,190,120,214);
      $this->Line(120,198,200,198);
      $this->EstiloCellFactura(10,"B",120,190,35,8,"SUBTOTAL","C");
      $this->EstiloCellFactura(10,"B",120,198,35,8,"IVA","C");
      $this->EstiloCellFactura(10,"B",120,206,35,8,"TOTAL","C");
      $this->Line(120,206,200,206);
      $this->Line(20,214,200,214);
  }



	function EstiloMulticellReciboIngresosPOS($estilo,$valorX,$valorY,$ancho,$alto,$texto,$alineacion)
    {
      
      $this->SetFont('Arial',$estilo,8);
      $this->SetXY($valorX,$valorY);
      $this->Multicell($ancho,$alto, utf8_decode($texto),0, $alineacion);
    }

    function EstiloCellReciboIngresosPOS($estilo,$valorX,$valorY,$ancho,$alto,$texto,$alineacion)
    {
      
      $this->SetFont('Arial',$estilo,8);
      $this->SetXY($valorX,$valorY);
      $this->Cell($ancho,$alto, utf8_decode($texto),0,0,$alineacion);
    }


    function EstiloMulticellReciboIngresosPDF($estilo,$valorX,$valorY,$ancho,$alto,$texto,$alineacion)
    {
      
      $this->SetFont('Arial',$estilo,10);
      $this->SetXY($valorX,$valorY);
      $this->Multicell($ancho,$alto, utf8_decode($texto),0, $alineacion);
    }

    function EstiloCellReciboIngresosPDF($estilo,$valorX,$valorY,$ancho,$alto,$texto,$alineacion)
    {
      
      $this->SetFont('Arial',$estilo,10);
      $this->SetXY($valorX,$valorY);
      $this->Cell($ancho,$alto, utf8_decode($texto),0,0,$alineacion);
    }


     function EstiloCellFactura($tamanoLetra,$estilo,$valorX,$valorY,$ancho,$alto,$texto,$alineacion)
    {
      $this->SetTextColor(0,0,0);
      $this->SetFont('Arial',$estilo,$tamanoLetra);
      $this->SetXY($valorX,$valorY);
      $this->Cell($ancho,$alto, utf8_decode($texto),0,0,$alineacion);
    }


    function EstiloCellFacturaConBorde($tamanoLetra,$estilo,$valorX,$valorY,$ancho,$alto,$texto,$alineacion)
    {
      
      $this->SetFont('Arial',$estilo,$tamanoLetra);
      $this->SetXY($valorX,$valorY);
      $this->Cell($ancho,$alto, utf8_decode($texto),1,0,$alineacion);
    }


    function EstiloMulticellFactura($tamaño,$estilo,$valorX,$valorY,$ancho,$alto,$texto,$alineacion)
    {
      
      $this->SetFont('Arial',$estilo,$tamaño);
      $this->SetXY($valorX,$valorY);
      $this->Multicell($ancho,$alto, utf8_decode($texto),0, $alineacion);
    }


    function EstiloMulticellFacturaConBorde($tamaño,$estilo,$valorX,$valorY,$ancho,$alto,$texto,$alineacion)
    {
      
      $this->SetFont('Arial',$estilo,$tamaño);
      $this->SetTextColor(0,0,0);
      $this->SetXY($valorX,$valorY);

      $this->Multicell($ancho,$alto, utf8_decode($texto),1, $alineacion);
    }



    function EstiloCellFacturaColorRojo($tamanoLetra,$estilo,$valorX,$valorY,$ancho,$alto,$texto,$alineacion)
    {
      $this->SetTextColor(255,0,0);

      $this->SetFont('Arial',$estilo,$tamanoLetra);
      $this->SetXY($valorX,$valorY);
      $this->Cell($ancho,$alto, utf8_decode($texto),0,0,$alineacion);
    }


    function EstiloCellFacturaColorFondo($texto,$valorX,$valorY,$ancho)
    {
      
      $this->SetXY($valorX,$valorY);
      $this->SetFont('Arial','B',10);
      $this->SetFillColor(193, 38, 38);
      $this->SetTextColor(0, 0, 0);
      //$this->SetDrawColor(0, 8, 118);
      $this->SetDrawColor(0, 0, 0);
      $this->Cell($ancho,6, utf8_decode($texto),0, 0 , 'C', true);
     
    }



    function EstiloMultiCellFacturaColorFondo($texto,$valorX,$valorY,$ancho)
    {
      
      $this->SetXY($valorX,$valorY);
      $this->SetFont('Arial','B',10);
      $this->SetFillColor(255, 25, 25);
      $this->SetTextColor(0, 0, 0);
      $this->SetDrawColor(0, 8, 118);
      //$this->SetDrawColor(0, 0, 0);

      $this->Multicell($ancho,6, utf8_decode($texto),1 , 'C', true);
     
    }


    function RecuadrosReciboIngresosPDF()
    {
      $this->EstiloCellReciboIngresosPDF("B","15","20","25","6","Ingresado Por: ","L");
      $this->EstiloCellReciboIngresosPDF("B","148","20","40","6","Fecha: ","L");

      $this->EstiloCellReciboIngresosPDF("B","15","25","180","5","INFORMACION GENERAL ","C");
      $this->EstiloCellReciboIngresosPDF("B","15","30","31","6","Nombre Paciente: ","L");
      $this->EstiloCellReciboIngresosPDF("B","15","35","40","6","Identificacion Paciente: ","L");
      $this->EstiloCellReciboIngresosPDF("B","15","40","15","6","Entidad:","L");
      $this->EstiloCellReciboIngresosPDF("B","132","40","30","6","Codigo General: ","L");
      $this->EstiloCellReciboIngresosPDF("B","15","52","180","5","SERVICIOS CONTRATADOS ","C");
      
      
      
      


      $this->Line(15,25,195,25);
      $this->Line(15,30,195,30);
      $this->Line(15,46,195,46);

      $this->Line(15,25,15,46);
      $this->Line(195,25,195,46);

      $this->Line(15,52,195,52);
      $this->Line(15,57,195,57);
      
    }

}
?>