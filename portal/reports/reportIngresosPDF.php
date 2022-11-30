<?php
include_once('estilosReportes.php');
include('../conexion/conexion.php');

$pdf = new PDF('P','mm','Letter');
$pdf->AddPage();

$idProcedimiento=$_GET["idProc"];

$consultaNombreEmpresa="SELECT * FROM definicion_tipos WHERE id_tipo=6 AND id=1";
$queryNombreEmpresa=mysql_query($consultaNombreEmpresa);
$resNombreEmpresa=mysql_fetch_array($queryNombreEmpresa);


$consultaIdentificacionEmpresa="SELECT * FROM definicion_tipos WHERE id_tipo=6 AND id=2";
$queryIdentificacionEmpresa=mysql_query($consultaIdentificacionEmpresa);
$resIdentificacionEmpresa=mysql_fetch_array($queryIdentificacionEmpresa);


$consultarInformacionGeneral="SELECT CONCAT(c.primer_nombre,' ',c.segundo_nombre,' ',c.primer_apellido,' ',c.segundo_apellido) AS nombre_paciente,CONCAT(e.descripcion,' ',c.identificacion) as identificacion_paciente,a.fecha,CONCAT(d.nombre,' ',d.apellido) as nombre_usuario,CONCAT(b.nombre,' - ',b.codigo) as cliente,a.id as codigo_general FROM procedimientos_realizados a LEFT JOIN clientes b ON a.id_cliente=b.id LEFT JOIN pacientes c ON c.id=a.id_paciente LEFT JOIN usuarios d ON d.id=a.usuario LEFT JOIN definicion_tipos e ON e.id=c.tipo_identificacion WHERE e.id_tipo=5 AND a.id='".$idProcedimiento."'";
$queryInformacionGeneral=mysql_query($consultarInformacionGeneral);
$resInformacionGeneral=mysql_fetch_array($queryInformacionGeneral);


$consultaDetalleProcedimientos="SELECT b.nombre as nombre_procedimiento,a.id as codigo_procedimiento_especifico,c.valor_procedimiento,a.fecha_entrega FROM detalle_procedimientos_realizados a LEFT JOIN procedimientos b ON a.id_procedimiento=b.id LEFT JOIN detalle_valor_procedimientos_realizados c ON c.id_detalle_procedimiento_realizado=a.id WHERE a.id_procedimiento_realizado='".$idProcedimiento."' ORDER BY codigo_procedimiento_especifico";
$queryDetalleProcedimientos=mysql_query($consultaDetalleProcedimientos);



$consultaValorTotalProcedimientos="SELECT SUM(valor_procedimiento) as valor_total_procedimientos FROM detalle_valor_procedimientos_realizados WHERE id_procedimiento_realizado='".$idProcedimiento."'";
$queryValorTotalProcedimientos=mysql_query($consultaValorTotalProcedimientos);
$resValorTotalProcedimientos=mysql_fetch_array($queryValorTotalProcedimientos);


$consultaValorPagoPaciente="SELECT * FROM pagos_procedimientos_realizados WHERE id_procedimiento_realizado='".$idProcedimiento."'";
$queryValorPagoPaciente=mysql_query($consultaValorPagoPaciente);
$resValorPagoPaciente=mysql_fetch_array($queryValorPagoPaciente);


  $consultaValorPagadoPaciente="SELECT SUM(valor_pagado) as valor_pagado FROM detalle_valor_pago_paciente WHERE id_procedimiento_realizado='".$idProcedimiento."'";
$queryValorPagadoPaciente=mysql_query($consultaValorPagadoPaciente);
$resValorPagadoPaciente=mysql_fetch_array($queryValorPagadoPaciente);


  $consultaValorPendientePaciente="SELECT valor_excedente as valor_pendiente FROM detalle_valor_pago_paciente WHERE id=(SELECT MAX(id) FROM detalle_valor_pago_paciente WHERE id_procedimiento_realizado='".$idProcedimiento."')";
  $queryValorPendientePaciente=mysql_query($consultaValorPendientePaciente);
$resValorPendientePaciente=mysql_fetch_array($queryValorPendientePaciente);

   
      $y=8;
      $pdf->EstiloMulticellReciboIngresosPDF("B","15",$y,"180","4",$resNombreEmpresa["descripcion"],"C");$y=$pdf->GetY();
      $pdf->EstiloCellReciboIngresosPDF("B","15",($y),"180","6",$resIdentificacionEmpresa["descripcion"],"C");$y=$pdf->GetY();

      $pdf->EstiloCellReciboIngresosPDF("","41","20","60","6",$resInformacionGeneral["nombre_usuario"],"L");

      $pdf->EstiloCellReciboIngresosPDF("","160","20","35","6",$resInformacionGeneral["fecha"],"L");


      
      $pdf->EstiloCellReciboIngresosPDF("","46","30","149","6",$resInformacionGeneral["nombre_paciente"],"L");

      $pdf->EstiloCellReciboIngresosPDF("","55","35","43","6",$resInformacionGeneral["identificacion_paciente"],"L");

      
      $pdf->EstiloCellReciboIngresosPDF("","30","40","86","6",$resInformacionGeneral["cliente"],"L");

      
      $pdf->EstiloCellReciboIngresosPDF("","162","40","33","6",$resInformacionGeneral["codigo_general"],"L");
      $y="52";

      setlocale(LC_MONETARY, 'en_US');
      while ($resDetalleProcedimientos=mysql_fetch_array($queryDetalleProcedimientos))
      {
            $pdf->EstiloCellReciboIngresosPDF("B","15",($y+6),"39","6","FECHA DE ENTREGA:","L");
            $pdf->EstiloCellReciboIngresosPDF("B","78",($y+6),"15","6","VALOR: ","L");
            $pdf->EstiloCellReciboIngresosPDF("B","123",($y+6),"32","6","COD ESPECIFICO:","L");
            $pdf->EstiloCellReciboIngresosPDF("B","15",($y+11),"27","6","DESCRIPCION: ","L");

            $pdf->EstiloCellReciboIngresosPDF("","155",($y+6),"40","6",$resDetalleProcedimientos["codigo_procedimiento_especifico"],"L");
            
            $pdf->EstiloCellReciboIngresosPDF("","54",($y+6),"20","6",$resDetalleProcedimientos["fecha_entrega"],"L");
            $pdf->EstiloCellReciboIngresosPDF("","93",($y+6),"30","6",money_format('%.2n',$resDetalleProcedimientos["valor_procedimiento"]),"L");$y=$pdf->GetY();
            $pdf->EstiloCellReciboIngresosPDF("","42",($y+5),"153","6",$resDetalleProcedimientos["nombre_procedimiento"],"L");
            $y=$pdf->GetY();
            $pdf->Line(15,($y+6),195,($y+6));$y=$pdf->GetY();
      }

      
      $pdf->EstiloCellReciboIngresosPDF("B","105",($y+6),"45","6","VALOR TOTAL ESTUDIOS","C");
      $pdf->EstiloCellReciboIngresosPDF("","150",($y+6),"45","6",money_format('%.2n',$resValorTotalProcedimientos["valor_total_procedimientos"]),"C");$y=$pdf->GetY();
      
      $pdf->Line(15,($y+6),195,($y+6));$y=$pdf->GetY();
      $pdf->Line(15,52,15,($y+6));
      $pdf->Line(195,52,195,($y+6));
      

      
      
      
      $pdf->Line(90,($y+12),195,($y+12));$y=$pdf->GetY();
      $pdf->EstiloCellReciboIngresosPDF("B","105",($y+12),"45","6","VALOR A PAGAR PACIENTE","C");
      $pdf->EstiloCellReciboIngresosPDF("","150",($y+12),"45","6",money_format('%.2n',$resValorPagoPaciente["valor_pago_paciente"]),"C");$y=$pdf->GetY();

      $pdf->EstiloCellReciboIngresosPDF("B","105",($y+5),"45","6","VALOR PAGADO","C");
      $pdf->EstiloCellReciboIngresosPDF("","150",($y+5),"45","6",money_format('%.2n',$resValorPagadoPaciente["valor_pagado"]),"C");$y=$pdf->GetY();

      $pdf->EstiloCellReciboIngresosPDF("B","105",($y+5),"45","6","VALOR PENDIENTE","C");
      $pdf->EstiloCellReciboIngresosPDF("","150",($y+5),"45","6",money_format('%.2n',$resValorPendientePaciente["valor_pendiente"]),"C");$y=$pdf->GetY();
      $pdf->Line(90,($y+6),195,($y+6));$y=$pdf->GetY();
      $pdf->Line(195,($y-10),195,($y+6));
      $pdf->Line(90,($y-10),90,($y+6));

      $pdf->EstiloMulticellReciboIngresosPDF("B","15",$y+8,"180","4","CONSULTE SU RESULTADO EN CONSULTARESULTADOS.MONICAMARINO.COM","C");$y=$pdf->GetY();



      $pdf->RecuadrosReciboIngresosPDF();


     
    



$pdf->Output();
?>