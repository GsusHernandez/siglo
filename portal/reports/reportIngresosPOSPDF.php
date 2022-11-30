<?php
include_once('estilosReportes.php');
include('../conexion/conexion.php');
$pdf = new PDF('P','mm',array(150,76));
$pdf->AddPage();
   
      $y=8;
      $pdf->EstiloMulticellReciboIngresosPOS("B","10",$y,"55","2","JAIRO ZAPATA FANDIÑO","C");$y=$pdf->GetY();

      $pdf->EstiloCellReciboIngresosPOS("B","20",($y+0.5),"20","4","NIT: ","C");$y=$pdf->GetY();
      $pdf->EstiloCellReciboIngresosPOS("","26",($y),"30","4","1043932440","C");$y=$pdf->GetY();

      $pdf->EstiloCellReciboIngresosPOS("B","5",($y+7),"60","4","Direccion: ","L");$y=$pdf->GetY();
      $pdf->EstiloCellReciboIngresosPOS("","20",($y),"60","4","Calle 65B 24C 35","L");$y=$pdf->GetY();

      $pdf->EstiloCellReciboIngresosPOS("B","5",($y+3),"60","4","Telefono: ","L");$y=$pdf->GetY();
      $pdf->EstiloCellReciboIngresosPOS("","19",($y),"60","4","3650315","L");$y=$pdf->GetY();

      $pdf->EstiloCellReciboIngresosPOS("B","5",($y+3),"60","4","Fecha: ","L");$y=$pdf->GetY();
      $pdf->EstiloCellReciboIngresosPOS("","15",($y),"60","4","13/04/2018","L");$y=$pdf->GetY();

      $pdf->EstiloCellReciboIngresosPOS("B","5",($y+3),"60","4","Recibido Por: ","L");$y=$pdf->GetY();
      $pdf->EstiloCellReciboIngresosPOS("","24",($y),"60","4","JAIRO ZAPATA FANDIÑO","L");$y=$pdf->GetY();

      $pdf->EstiloCellReciboIngresosPOS("B","5",($y+3),"60","4","Codigo General: ","L");$y=$pdf->GetY();
      $pdf->EstiloCellReciboIngresosPOS("","28",($y),"60","4","JAIRO ZAPATA FANDIÑO","L");$y=$pdf->GetY();

      $pdf->EstiloCellReciboIngresosPOS("B","5",($y+3),"60","4","Fecha de Procedimiento: ","L");$y=$pdf->GetY();
      $pdf->EstiloCellReciboIngresosPOS("","40",($y),"60","4","14/04/2018","L");$y=$pdf->GetY();

      $pdf->EstiloCellReciboIngresosPOS("B","5",($y+3),"60","4","Fecha de Entrega: ","L");$y=$pdf->GetY();
      $pdf->EstiloCellReciboIngresosPOS("","30",($y),"60","4","14/04/2018","L");$y=$pdf->GetY();

      $pdf->EstiloCellReciboIngresosPOS("","5",($y+3),"60","4","------------------------------------------------------------------","L");$y=$pdf->GetY();
      $pdf->EstiloCellReciboIngresosPOS("B","5",($y+3),"60","4","INFORMACION PACIENTE","L");$y=$pdf->GetY();
      $pdf->EstiloCellReciboIngresosPOS("","5",($y+2),"60","4","------------------------------------------------------------------","L");$y=$pdf->GetY();
      $pdf->EstiloCellReciboIngresosPOS("B","5",($y+3),"60","4","Nombre: ","L");$y=$pdf->GetY();
      $pdf->EstiloCellReciboIngresosPOS("","18",($y),"60","4","Monica Marino","L");$y=$pdf->GetY();

      $pdf->EstiloCellReciboIngresosPOS("B","5",($y+3),"60","4","Identificacion: ","L");$y=$pdf->GetY();
      $pdf->EstiloCellReciboIngresosPOS("","25",($y),"60","4","CC 1231231","L");$y=$pdf->GetY();

      $pdf->EstiloCellReciboIngresosPOS("B","5",($y+3),"60","4","Entidad: ","L");$y=$pdf->GetY();
      $pdf->EstiloCellReciboIngresosPOS("","18",($y),"60","4","CLINICA LA VICTORIA","L");$y=$pdf->GetY();

      $pdf->EstiloCellReciboIngresosPOS("","5",($y+3),"60","4","------------------------------------------------------------------","L");$y=$pdf->GetY();
      $pdf->EstiloCellReciboIngresosPOS("B","5",($y+3),"60","4","CODIGO","L");$y=$pdf->GetY();
      $pdf->EstiloCellReciboIngresosPOS("B","28",($y),"60","4","DESCRIPCION","L");$y=$pdf->GetY();
      $pdf->EstiloCellReciboIngresosPOS("B","57",($y),"60","4","VALOR","L");$y=$pdf->GetY();
      $pdf->EstiloCellReciboIngresosPOS("","5",($y+2),"60","4","------------------------------------------------------------------","L");$y=$pdf->GetY();

      $pdf->EstiloCellReciboIngresosPOS("","5",($y+3),"60","4","01301232103210","L");$y=$pdf->GetY();
      $pdf->EstiloCellReciboIngresosPOS("","10",($y+3),"60","4","ELECTROCARDIOGRAMA","L");$y=$pdf->GetY();
      $pdf->EstiloCellReciboIngresosPOS("","50",($y),"18","4","55000.25","R");$y=$pdf->GetY();

      $pdf->EstiloCellReciboIngresosPOS("","5",($y+3),"60","4","------------------------------------------------------------------","L");$y=$pdf->GetY();
      $pdf->EstiloCellReciboIngresosPOS("B","20",($y+3),"60","4","SUBTOTAL/TOTAL","L");$y=$pdf->GetY();
      $pdf->EstiloCellReciboIngresosPOS("","48",($y),"20","4","100000.00","R");$y=$pdf->GetY();
      $pdf->EstiloCellReciboIngresosPOS("","5",($y+2),"60","4","------------------------------------------------------------------","L");$y=$pdf->GetY();

      $pdf->EstiloMulticellReciboIngresosPOS("","5",($y+6),"65","3","PUEDE CONSULTAR SU RESULTADO EN CONSULTARESULTADOS.MONICAMARINO.COM USANDO EL CODIGO PROCEDIMIENTO GENERAL Y/O CODIGO PROCEDIMIENTO ESPECIFICO","J");$y=$pdf->GetY();





     
    



$pdf->Output();
?>