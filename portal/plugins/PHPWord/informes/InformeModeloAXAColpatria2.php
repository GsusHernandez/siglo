<?php 
	ini_set('display_errors', 0);
	error_reporting(E_ERROR | E_WARNING | E_PARSE); 
	include('../../../conexion/conexion.php');
	global $con;
	$id_caso=$_GET["idInv"];
	mysqli_query($con,"SET SQL_BIG_SELECTS=1");
	require_once '../PHPWord-master/src/PhpWord/Autoloader.php';
	\PhpOffice\PhpWord\Autoloader::register();


	use PhpOffice\PhpWord\PhpWord;
	use PhpOffice\PhpWord\Style\Font;

	$PHPWord = new PhpWord();
	$section = $PHPWord->createSection();

	$estiloBold= array('bold'=>true,'name'=>'Arial','size'=>10);
	$estiloBoldTitulos= array('bold'=>true,'name'=>'Arial','size'=>11,'bgColor'=>'000080',  'borderColor' => '000000','align'=>'center','valign'=>'center');
	$estiloNoBold= array('bold'=>false,'name'=>'Arial','size'=>10);
	//crear ENCABEZADO CON IMAGEN
	//TERMINA ENCABEZADO
	//crear PIE DE PAGINA
	$estiloFuenteFooter=array('bold'=>true,'size'=>8,'name'=>'Arial');
	$estiloParrafoFooter=array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0);
	$footer = $section->createFooter();
	$footer->addText("Global Red  LTDA “Investigaciones Sin Fronteras”",$estiloFuenteFooter ,$estiloParrafoFooter);
	$footer->addText("CALLE 70 No. 54 CC Gran Centro Local 115", $estiloFuenteFooter ,$estiloParrafoFooter);

	$footer->addText("BARRANQUILLA - ATLANTICO", $estiloFuenteFooter ,$estiloParrafoFooter);
	$footer->addText("TEL: 3563397 - CEL: 3103229337", $estiloFuenteFooter ,$estiloParrafoFooter);
	$footer->addText("e-mail: josemquijano@globalredltda.co", $estiloFuenteFooter ,$estiloParrafoFooter);
	$footer->addText("www.globalredltda.co",$estiloFuenteFooter ,$estiloParrafoFooter);
	//TERMINA PIE DE PAGINA
	//INTRODUCCION DOCUMENTO

	$consultarInformacionBasicaCaso="SELECT a.codigo,
	a.id AS id_caso,
	CONCAT(d.nombres,' ',d.apellidos) AS nombre_lesionado,
	CONCAT(e.descripcion,' ',d.identificacion) AS identificacion_lesionado,
	f.nombre_ips,
	k.placa,
	k.marca,
	k.modelo,
	k.linea,
	k.color,
	k.numero_vin,
	k.numero_serie,
	k.numero_motor,
	k.numero_chasis,
	l.descripcion AS tipo_servicio,
	c.resultado,
	CONCAT(UPPER(LEFT(h.nombre, 1)), LOWER(SUBSTRING(h.nombre, 2))) AS departamento_ips,
	CONCAT(UPPER(LEFT(g.nombre, 1)), LOWER(SUBSTRING(g.nombre, 2))) AS ciudad_ips,
	m.responsable,
	j.numero AS numero_poliza,
	j.inicio_vigencia,
	j.fin_vigencia,
	l.descripcion AS tipo_vehiculo,
	b.fecha_accidente,
	c.fecha_ingreso,
	DATE_FORMAT('%Y-%m-%d',c.fecha_ingreso) as fecha_ingreso2,
	DATE_FORMAT('%Y-%m-%d',b.fecha_accidente) as fecha_accidente3,
	c.fecha_egreso,
	q.descripcion AS indicador_fraude,
	m.id AS id_aseguradora,
	c.indicador_fraude AS id_indicador_fraude,
	CASE 
	WHEN m.cargo IS NULL THEN 'N' ELSE m.cargo END AS cargo,
	d.ocupacion,
	d.edad,
	d.direccion_residencia,
	CONCAT(CONCAT(UPPER(LEFT(h.nombre, 1)), LOWER(SUBSTRING(h.nombre, 2))),' - ',
	CONCAT(UPPER(LEFT(g.nombre, 1)), LOWER(SUBSTRING(g.nombre, 2)))) AS ciudad_residencia,
	d.barrio,
	d.telefono,d.sexo,e.descripcion2 as tipo_identificacion_lesionado,d.identificacion as no_identificacion_lesionado,
	c.condicion,
	c.servicio_ambulancia,
	c.tipo_traslado_ambulancia,
	c.lugar_traslado,
	c.tipo_vehiculo_traslado,
	c.lesiones,c.tratamiento,
	c.relato,
	r.descripcion2 AS seguridad_social,
	c.seguridad_social AS id_seguridad_social,
	c.eps,
	c.regimen,
	c.estado AS estado_eps,
	c.causal_consulta,
	b.lugar_accidente,
	b.visita_lugar_hechos,
	b.punto_referencia,
	b.registro_autoridades,
	b.diligencia_formato_declaracion,
	b.id_diligencia_formato_declaracion,b.observacion_diligencia_formato_declaracion,
	b.furips,
	j.nombre_tomador,j.id as id_poliza,
	CONCAT(s.descripcion,' ',j.identificacion_tomador) AS identificacion_tomador,
	j.telefono_tomador,
	j.direccion_tomador,
	CONCAT(u.nombre,' - ',t.nombre) AS ciudad_tomador,
	CONCAT(v.nombre,' - ',w.nombre) AS ciudad_expedicion_poliza,
	b.resultado_diligencia_tomador,
	b.observaciones_diligencia_tomador,
	CONCAT(DAY(a.fecha_entrega), ' de ',CASE  WHEN MONTH(a.fecha_entrega)='01' THEN  'Enero' WHEN MONTH(a.fecha_entrega)='02' THEN  'Febrero' WHEN MONTH(a.fecha_entrega)='03' THEN  'Marzo' WHEN MONTH(a.fecha_entrega)='04' THEN  'Abril' WHEN MONTH(a.fecha_entrega)='05' THEN  'Mayo' WHEN MONTH(a.fecha_entrega)='06' THEN  'Junio' WHEN MONTH(a.fecha_entrega)='07' THEN  'Julio' WHEN MONTH(a.fecha_entrega)='08' THEN  'Agosto' WHEN MONTH(a.fecha_entrega)='09' THEN  'Septiembre' WHEN MONTH(a.fecha_entrega)='10' THEN  'Octubre' WHEN MONTH(a.fecha_entrega)='11' THEN  'Noviembre' WHEN MONTH(a.fecha_entrega)='12' THEN  'Diciembre' END,' de ',YEAR(a.fecha_entrega)) AS fecha_entrega,
	CONCAT(DAY(b.fecha_accidente), ' de ',CASE  WHEN MONTH(b.fecha_accidente)='01' THEN  'Enero' WHEN MONTH(b.fecha_accidente)='02' THEN  'Febrero' WHEN MONTH(b.fecha_accidente)='03' THEN  'Marzo' WHEN MONTH(b.fecha_accidente)='04' THEN  'Abril' WHEN MONTH(b.fecha_accidente)='05' THEN  'Mayo' WHEN MONTH(b.fecha_accidente)='06' THEN  'Junio' WHEN MONTH(b.fecha_accidente)='07' THEN  'Julio' WHEN MONTH(b.fecha_accidente)='08' THEN  'Agosto' WHEN MONTH(b.fecha_accidente)='09' THEN  'Septiembre' WHEN MONTH(b.fecha_accidente)='10' THEN  'Octubre' WHEN MONTH(b.fecha_accidente)='11' THEN  'Noviembre' WHEN MONTH(b.fecha_accidente)='12' THEN  'Diciembre' END,' de ',YEAR(b.fecha_accidente)) AS fecha_accidente2,
	CONCAT(DAY(c.fecha_ingreso), ' de ',CASE  WHEN MONTH(c.fecha_ingreso)='01' THEN  'Enero' WHEN MONTH(c.fecha_ingreso)='02' THEN  'Febrero' WHEN MONTH(c.fecha_ingreso)='03' THEN  'Marzo' WHEN MONTH(c.fecha_ingreso)='04' THEN  'Abril' WHEN MONTH(c.fecha_ingreso)='05' THEN  'Mayo' WHEN MONTH(c.fecha_ingreso)='06' THEN  'Junio' WHEN MONTH(c.fecha_ingreso)='07' THEN  'Julio' WHEN MONTH(c.fecha_ingreso)='08' THEN  'Agosto' WHEN MONTH(c.fecha_ingreso)='09' THEN  'Septiembre' WHEN MONTH(c.fecha_ingreso)='10' THEN  'Octubre' WHEN MONTH(c.fecha_ingreso)='11' THEN  'Noviembre' WHEN MONTH(c.fecha_ingreso)='12' THEN  'Diciembre' END,' de ',YEAR(c.fecha_ingreso)) AS fecha_ingreso3,
	c.resultado,a.id_aseguradora,b.conclusiones,a.id_investigador
	FROM investigaciones a
	LEFT JOIN detalle_investigaciones_soat b ON a.id=b.id_investigacion
	LEFT JOIN personas_investigaciones_soat c ON c.id_investigacion=a.id
	LEFT JOIN personas d ON d.id=c.id_persona
	LEFT JOIN definicion_tipos e ON e.id=d.tipo_identificacion
	LEFT JOIN ips f ON f.id=c.ips
	LEFT JOIN ciudades g ON g.id=f.ciudad
	LEFT JOIN departamentos h ON h.id=g.id_departamento
	LEFT JOIN polizas j ON j.id=b.id_poliza
	LEFT JOIN vehiculos k ON k.id=j.id_vehiculo
	LEFT JOIN tipo_vehiculos l ON l.id=k.tipo_vehiculo
	LEFT JOIN aseguradoras m ON m.id=a.id_aseguradora
	LEFT JOIN ciudades n ON n.id=d.ciudad_residencia
	LEFT JOIN departamentos o ON o.id=n.id_departamento
	LEFT JOIN definicion_tipos p ON p.id=k.tipo_servicio
	LEFT JOIN definicion_tipos q ON q.id=c.indicador_fraude
	LEFT JOIN definicion_tipos r ON r.id=c.seguridad_social
	LEFT JOIN definicion_tipos s ON s.id=j.tipo_identificacion_tomador
	LEFT JOIN ciudades t ON r.id=j.ciudad_tomador
	LEFT JOIN departamentos u ON u.id=t.id_departamento
	LEFT JOIN ciudades v ON v.id=j.ciudad_expedicion
	LEFT JOIN departamentos w ON w.id=v.id_departamento
	WHERE e.id_tipo=5 AND p.id_tipo=21 
	AND q.id_tipo=12 AND r.id_tipo=17 AND s.id_tipo=5  
	AND c.tipo_persona=1  AND a.id='".$id_caso."'";


	$consultarObservacionesInforme="SELECT * FROM observaciones_secciones_informe WHERE id_investigacion='".$id_caso."'";

	$consultarLesionados="SELECT 
	CONCAT(b.nombres,' ',b.apellidos) AS nombre_lesionado,
	CONCAT(c.descripcion,' ',b.identificacion) AS identificacion_lesionado,b.sexo,
	c.descripcion2 AS tipo_identificacion_lesionado,b.identificacion AS no_identificacion_lesionado,
	CASE WHEN a.lugar_traslado IS NULL THEN 'N' ELSE a.lugar_traslado END AS lugar_traslado,
	a.servicio_ambulancia, a.tipo_traslado_ambulancia, a.tipo_vehiculo_traslado, a.fecha_ingreso, a.condicion, b.direccion_residencia, 
	h.nombre_ips, b.edad, b.ocupacion, a.lesiones, a.tratamiento,	q.descripcion AS indicador_fraude
	FROM  personas_investigaciones_soat a 
	LEFT JOIN personas b ON a.id_persona=b.id
	LEFT JOIN definicion_tipos c ON c.id=b.tipo_identificacion 
	LEFT JOIN ciudades f ON f.id=b.ciudad_residencia
	LEFT JOIN departamentos g ON g.id=f.id_departamento
	LEFT JOIN ips h ON h.id=a.ips
	LEFT JOIN definicion_tipos q ON q.id=a.indicador_fraude
	WHERE a.tipo_persona=2 AND q.id_tipo=12 AND c.id_tipo=5  AND a.id_investigacion ='".$id_caso."'";
	mysqli_next_result($con);
	$verificarVariosLesionados=mysqli_query($con,$consultarLesionados);
	$cont3=mysqli_num_rows($verificarVariosLesionados);

	mysqli_next_result($con);
	$queryInformacionCaso=mysqli_query($con,$consultarInformacionBasicaCaso);
	$resInformacionCaso=mysqli_fetch_assoc($queryInformacionCaso);

	if ($resInformacionCaso["resultado"]==1)
	{
		$consultarResultado="SELECT b.descripcion2 as resultado from aseguradoras a left join definicion_tipos b on a.resultado_atender=b.id where b.id_tipo=10 and a.id='".$resInformacionCaso["id_aseguradora"]."'";
		
	}
	else if ($resInformacionCaso["resultado"]==2)
	{
		$consultarResultado="SELECT b.descripcion2 as resultado from aseguradoras a left join definicion_tipos b on a.resultado_no_atender=b.id where b.id_tipo=10 and a.id='".$resInformacionCaso["id_aseguradora"]."'";
	}
	mysqli_next_result($con);
	$consultarInformacionInvestigador=mysqli_query($con,"SELECT CONCAT(b.descripcion,' ',a.identificacion) as identificacion_investigador,CONCAT(a.nombres,' ',a.apellidos) as nombre_investigador FROM investigadores a LEFT JOIN definicion_tipos b ON a.tipo_identificacion=b.id WHERE b.id_tipo=5 and a.id='".$resInformacionCaso["id_investigador"]."'");
	$resInformacionInvestigador=mysqli_fetch_assoc($consultarInformacionInvestigador);
	mysqli_next_result($con);
	
	$queryResultado=mysqli_query($con,$consultarResultado);
	
	$resResultado=mysqli_fetch_assoc($queryResultado);
	
	mysqli_next_result($con);  
	

	$styleCell = array('bgColor'=>'DEE0E1',  'borderColor' => '000000', 'borderSize' => 6,
	    'cellMargin' => 50,
		  'valign' => 'center',
	  	'align' => 'center');

			 
			$tableStyle=array('borderSize'=>6, 'borderColor'=>'000000',  'cellMargin' => 10,
		  'valign' => 'center',
	  	'align' => 'center');


			
	$colspanTitulo=array('gridSpan' => 2, 'valign' => 'center','bgColor'=>'DEE0E1',  'borderColor' => '000000', 'borderSize' => 6,
	    'cellMargin' => 50,
		  'align' => 'center');

	$estiloBarraTitulos=array('valign' => 'center','bgColor'=>'DEE0E1',  'borderColor' => '000000', 'borderSize' => 6,
	    'cellMargin' => 50,
		  'align' => 'center');


	$colspan=array('gridSpan' => 2, 'valign' => 'center',);
	$colspan2=array('gridSpan' => 5, 'valign' => 'center',);

	

	$table =$section->addTable('tableStyle');
    $PHPWord->addTableStyle('tableStyle',$tableStyle,$styleCell);
     
    $table->addRow();
	  
    $table->addCell(5000,$colspan)->addText('Direccion de Control y Calidad',$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0)); 

	$table->addCell(5000,$colspan)->addText('Informe No.'.$resInformacionCaso['codigo'],$estiloBold,array('align'=> 'right','spaceBefore'=>0,'spaceAfter'=>0));  
	

	$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($PHPWord, 'Word2007');
	$nombre="INFORME ".$resInformacionCaso["nombre_lesionado"]." POLIZA No. ".$resInformacionCaso["numero_poliza"];
	$objWriter->save('Informe.docx');
	header('Content-Disposition: attachment; filename="'.$nombre.'.docx"');
	echo file_get_contents('Informe.docx');
?>