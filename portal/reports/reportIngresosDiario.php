<?php
include('../conexion/conexion.php');
require_once ('../bower_components/PHPExcel/Classes/PHPExcel.php');
set_time_limit(0);
error_reporting(E_ALL);
ini_set('display_errors', '1');

$fechaInicioReportIngresoDiario=$_POST["fechaInicioReportIngresoDiario"];
$fechaFinReportIngresoDiario=$_POST["fechaFinReportIngresoDiario"];

$objPHPExcel = new PHPExcel();
$consultarProcedimientosDiario="SELECT h.valor_procedimiento,CONCAT(g.nombre,' ',g.apellido) as nombre_usuario,b.id as codigo_procedimiento_especifico,a.id as codigo_procedimiento_general,CONCAT_WS(' ',d.nombres,d.apellidos) as nombre_paciente,CONCAT_WS(' ',f.descripcion,d.identificacion) as identificacion_paciente,e.nombre as cliente,e.codigo as codigo_cliente,b.id,a.fecha_procedimiento,a.fecha_entrega,c.nombre as tipo_procedimiento,b.vigente
    FROM procedimientos_realizados a 
    LEFT JOIN detalle_procedimientos_realizados b ON a.id=b.id_procedimiento_realizado
    LEFT JOIN procedimientos c ON c.id=b.id_procedimiento
    LEFT JOIN pacientes d ON d.id=a.id_paciente
    LEFT JOIN clientes e ON e.id=a.id_cliente
    LEFT JOIN definicion_tipos f ON f.id=d.tipo_identificacion
    LEFT JOIN usuarios g ON g.id=b.usuario
    LEFT JOIN detalle_valor_procedimientos_realizados h on h.id_detalle_procedimiento_realizado=b.id
    WHERE f.id_tipo=5 AND a.fecha_procedimiento BETWEEN '".$fechaInicioReportIngresoDiario."' AND '".$fechaFinReportIngresoDiario."'";

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', 'Codigo General')
->setCellValue('B1', 'Codigo Especifico')
->setCellValue('C1', 'Nombre Paciente')
->setCellValue('D1', 'Identificacion Paciente')
->setCellValue('E1', 'Nombre Cliente')
->setCellValue('F1', 'Codigo Cliente')
->setCellValue('G1', 'Nombre Procedimiento')
->setCellValue('H1', 'Valor Procedimiento')
->setCellValue('I1', 'Fecha Procedimiento')
->setCellValue('J1', 'Fecha Entrega')
->setCellValue('K1', 'Registrado Por');



$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('30');
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('30');
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('30');
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('30');
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('30');
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('30');
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth('30');
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth('30');
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth('30');
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth('30');
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth('30');

$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold( true );
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(10);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');

$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('A1'), 'A1:K1'); 

$rowcount=2;

$queryProcedimientosDiario=mysql_query($consultarProcedimientosDiario);
while ($resProcedimientosDiario=mysql_fetch_array($queryProcedimientosDiario))
{
       $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowcount, $resProcedimientosDiario["codigo_procedimiento_general"]);
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowcount, $resProcedimientosDiario["codigo_procedimiento_especifico"]);
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowcount, $resProcedimientosDiario["nombre_paciente"]);
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowcount, $resProcedimientosDiario["identificacion_paciente"]);
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowcount, $resProcedimientosDiario["cliente"]);
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowcount, $resProcedimientosDiario["codigo_cliente"]);
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowcount, $resProcedimientosDiario["tipo_procedimiento"]);

        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowcount, $resProcedimientosDiario["valor_procedimiento"]);
        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowcount, $resProcedimientosDiario["fecha_procedimiento"]);
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowcount, $resProcedimientosDiario["fecha_entrega"]);
        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowcount, $resProcedimientosDiario["nombre_usuario"]);
        
        
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowcount)->getFont()->setName('Arial');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowcount)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowcount)->getFont()->setSize(10);                                   
        $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('A'.$rowcount), 'A'.$rowcount.':K'.$rowcount); 
                                                            
                                    

                              
        $rowcount++;

}
       
        
      
// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.30.
$objPHPExcel->setActiveSheetIndex(0);

 

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

header('Content-Disposition: attachment;filename="pruebaReal.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');


$objWriter->save('php://output');

exit;


    
?>