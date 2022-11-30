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
	$footer->addText("CALLE 70 # 52 54 CC Gran Centro Local 115", $estiloFuenteFooter ,$estiloParrafoFooter);

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
	f.nombre_ips,f.identificacion as identificacion_ips,
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
	b.observaciones_diligencia_tomador,m.nombre_aseguradora,y.descripcion as tipo_caso,
	CONCAT(DAY(a.fecha_entrega), ' de ',CASE  WHEN MONTH(a.fecha_entrega)='01' THEN  'Enero' WHEN MONTH(a.fecha_entrega)='02' THEN  'Febrero' WHEN MONTH(a.fecha_entrega)='03' THEN  'Marzo' WHEN MONTH(a.fecha_entrega)='04' THEN  'Abril' WHEN MONTH(a.fecha_entrega)='05' THEN  'Mayo' WHEN MONTH(a.fecha_entrega)='06' THEN  'Junio' WHEN MONTH(a.fecha_entrega)='07' THEN  'Julio' WHEN MONTH(a.fecha_entrega)='08' THEN  'Agosto' WHEN MONTH(a.fecha_entrega)='09' THEN  'Septiembre' WHEN MONTH(a.fecha_entrega)='10' THEN  'Octubre' WHEN MONTH(a.fecha_entrega)='11' THEN  'Noviembre' WHEN MONTH(a.fecha_entrega)='12' THEN  'Diciembre' END,' de ',YEAR(a.fecha_entrega)) AS fecha_entrega,
	CONCAT(DAY(b.fecha_accidente), ' de ',CASE  WHEN MONTH(b.fecha_accidente)='01' THEN  'Enero' WHEN MONTH(b.fecha_accidente)='02' THEN  'Febrero' WHEN MONTH(b.fecha_accidente)='03' THEN  'Marzo' WHEN MONTH(b.fecha_accidente)='04' THEN  'Abril' WHEN MONTH(b.fecha_accidente)='05' THEN  'Mayo' WHEN MONTH(b.fecha_accidente)='06' THEN  'Junio' WHEN MONTH(b.fecha_accidente)='07' THEN  'Julio' WHEN MONTH(b.fecha_accidente)='08' THEN  'Agosto' WHEN MONTH(b.fecha_accidente)='09' THEN  'Septiembre' WHEN MONTH(b.fecha_accidente)='10' THEN  'Octubre' WHEN MONTH(b.fecha_accidente)='11' THEN  'Noviembre' WHEN MONTH(b.fecha_accidente)='12' THEN  'Diciembre' END,' de ',YEAR(b.fecha_accidente)) AS fecha_accidente2,
	CONCAT(DAY(c.fecha_ingreso), ' de ',CASE  WHEN MONTH(c.fecha_ingreso)='01' THEN  'Enero' WHEN MONTH(c.fecha_ingreso)='02' THEN  'Febrero' WHEN MONTH(c.fecha_ingreso)='03' THEN  'Marzo' WHEN MONTH(c.fecha_ingreso)='04' THEN  'Abril' WHEN MONTH(c.fecha_ingreso)='05' THEN  'Mayo' WHEN MONTH(c.fecha_ingreso)='06' THEN  'Junio' WHEN MONTH(c.fecha_ingreso)='07' THEN  'Julio' WHEN MONTH(c.fecha_ingreso)='08' THEN  'Agosto' WHEN MONTH(c.fecha_ingreso)='09' THEN  'Septiembre' WHEN MONTH(c.fecha_ingreso)='10' THEN  'Octubre' WHEN MONTH(c.fecha_ingreso)='11' THEN  'Noviembre' WHEN MONTH(c.fecha_ingreso)='12' THEN  'Diciembre' END,' de ',YEAR(c.fecha_ingreso)) AS fecha_ingreso3,
	CONCAT(DAY(a.fecha_inicio), ' de ',CASE  WHEN MONTH(a.fecha_inicio)='01' THEN  'Enero' WHEN MONTH(a.fecha_inicio)='02' THEN  'Febrero' WHEN MONTH(a.fecha_inicio)='03' THEN  'Marzo' WHEN MONTH(a.fecha_inicio)='04' THEN  'Abril' WHEN MONTH(a.fecha_inicio)='05' THEN  'Mayo' WHEN MONTH(a.fecha_inicio)='06' THEN  'Junio' WHEN MONTH(c.fecha_ingreso)='07' THEN  'Julio' WHEN MONTH(a.fecha_inicio)='08' THEN  'Agosto' WHEN MONTH(a.fecha_inicio)='09' THEN  'Septiembre' WHEN MONTH(a.fecha_inicio)='10' THEN  'Octubre' WHEN MONTH(a.fecha_inicio)='11' THEN  'Noviembre' WHEN MONTH(a.fecha_inicio)='12' THEN  'Diciembre' END,' de ',YEAR(a.fecha_inicio)) AS fecha_inicio3,
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
	LEFT JOIN definicion_tipos y ON a.tipo_caso=y.id
	WHERE y.id_tipo=8 and e.id_tipo=5 AND p.id_tipo=21 
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

	mysqli_next_result($con);
	$queryIdCasosAseguradora=mysqli_query($con,"SELECT CONCAT(DAY(fecha_inicio), ' de ',CASE  WHEN MONTH(fecha_inicio)='01' THEN  'Enero' WHEN MONTH(fecha_inicio)='02' THEN  'Febrero' WHEN MONTH(fecha_inicio)='03' THEN  'Marzo' WHEN MONTH(fecha_inicio)='04' THEN  'Abril' WHEN MONTH(fecha_inicio)='05' THEN  'Mayo' WHEN MONTH(fecha_inicio)='06' THEN  'Junio' WHEN MONTH(fecha_inicio)='07' THEN  'Julio' WHEN MONTH(fecha_inicio)='08' THEN  'Agosto' WHEN MONTH(fecha_inicio)='09' THEN  'Septiembre' WHEN MONTH(fecha_inicio)='10' THEN  'Octubre' WHEN MONTH(fecha_inicio)='11' THEN  'Noviembre' WHEN MONTH(fecha_inicio)='12' THEN  'Diciembre' END,' de ',YEAR(fecha_inicio)) AS fecha_asignacion, CONCAT(DAY(fecha_entrega), ' de ',CASE  WHEN MONTH(fecha_entrega)='01' THEN  'Enero' WHEN MONTH(fecha_entrega)='02' THEN  'Febrero' WHEN MONTH(fecha_entrega)='03' THEN  'Marzo' WHEN MONTH(fecha_entrega)='04' THEN  'Abril' WHEN MONTH(fecha_entrega)='05' THEN  'Mayo' WHEN MONTH(fecha_entrega)='06' THEN  'Junio' WHEN MONTH(fecha_entrega)='07' THEN  'Julio' WHEN MONTH(fecha_entrega)='08' THEN  'Agosto' WHEN MONTH(fecha_entrega)='09' THEN  'Septiembre' WHEN MONTH(fecha_entrega)='10' THEN  'Octubre' WHEN MONTH(fecha_entrega)='11' THEN  'Noviembre' WHEN MONTH(fecha_entrega)='12' THEN  'Diciembre' END,' de ',YEAR(fecha_entrega)) AS fecha_entrega,identificador FROM id_casos_aseguradora WHERE id_investigacion='".$id_caso."'");
	$resIdCasosAseguadora=mysqli_fetch_assoc($queryIdCasosAseguradora);

	if ($resInformacionCaso["resultado"]==1){
		$consultarResultado="SELECT b.descripcion2 as resultado from aseguradoras a left join definicion_tipos b on a.resultado_atender=b.id where b.id_tipo=10 and a.id='".$resInformacionCaso["id_aseguradora"]."'";
	}
	else if ($resInformacionCaso["resultado"]==2){
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


	$styleCell2 = array('bgColor'=>'FFFFFF',  'borderColor' => '000000', 'borderSize' => 6,
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

	

//FIN CIUDAD Y FECHA

	
	$table =$section->addTable('tableStyle');
    $PHPWord->addTableStyle('tableStyle',$tableStyle,$styleCell);
     
    $table->addRow();
	  
    $table->addCell(5000,$colspan)->addText('Dirección de Control y Calidad',$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0)); 

	$table->addCell(5000,$colspan)->addText('Informe No.'.$resInformacionCaso['codigo'],$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));  
	
	$section->addTextBreak(2,null,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	

	$table =$section->addTable('tableStyle');
    $PHPWord->addTableStyle('tableStyle',$tableStyle,$styleCell);    	
    $table->addRow();

    $table->addCell(5000)->addText("Ciudad, Fecha de Entrega Informe",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText("Ciudad, Fecha de Asignación Caso",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
    
    $table->addRow();
    $table->addCell(5000)->addText("Barranquilla, Atlántico. ".$resIdCasosAseguadora["fecha_entrega"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText("Bogotá D.C., ".$resIdCasosAseguadora["fecha_asignacion"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  

	$section->addTextBreak(2,null,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	
	$table =$section->addTable('tableStyle2');
    $PHPWord->addTableStyle('tableStyle2',$tableStyle,$styleCell2);

    $table->addRow();
    $table->addCell(3000)->addText("Aseguradora: ",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
    $table->addCell(7000)->addText($resInformacionCaso["nombre_aseguradora"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
    
    $table->addRow();
    $table->addCell(3000)->addText("Tipo de Investigación:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(7000)->addText($resInformacionCaso["tipo_caso"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  

    $table->addRow();
    $table->addCell(3000)->addText("Póliza Afectada:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(7000)->addText($resInformacionCaso["numero_poliza"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  


	$table->addRow();
    $table->addCell(3000)->addText("Tomador:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(7000)->addText($resInformacionCaso["nombre_tomador"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  

    $table->addRow();
    $table->addCell(3000)->addText("Placa:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(7000)->addText($resInformacionCaso["placa"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  

    $table->addRow();
    $table->addCell(3000)->addText("Reclamante/Identificación:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(7000)->addText($resInformacionCaso["nombre_ips"]." / ".$resInformacionCaso["identificacion_ips"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  


	$table->addRow();
    $table->addCell(3000)->addText("Victima/Identificación:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(7000)->addText($resInformacionCaso["nombre_lesionado"]." / ".$resInformacionCaso["identificacion_lesionado"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  

    $table->addRow();
    $table->addCell(3000)->addText("Resultado:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(7000)->addText($resResultado["resultado"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
		
 	

    $table->addRow();
    $table->addCell(3000)->addText("Tipología:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
    
    $table->addCell(7000)->addText($resInformacionCaso["indicador_fraude"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0)); 

    
  	$section->addPageBreak();

  	$table =$section->addTable('tableStyle');
    $PHPWord->addTableStyle('tableStyle',$tableStyle,$styleCell);    	
    $table->addRow();

    $table->addCell(10000)->addText("LESIONADOS",$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));  
	
	$section->addTextBreak(1,null,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

    
    $table =$section->addTable('tableStyle2');
    $PHPWord->addTableStyle('tableStyle2',$tableStyle,$styleCell2);

    $table->addRow();
    $table->addCell(3000)->addText("Nombre: ",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
    $table->addCell(7000)->addText($resInformacionCaso["nombre_lesionado"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
    
    $table->addRow();
    $table->addCell(3000)->addText("Identificación:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(7000)->addText($resInformacionCaso["identificacion_lesionado"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  

    $table->addRow();
    $table->addCell(3000)->addText("Lugar de Residencia:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(7000)->addText($resInformacionCaso["direccion_residencia"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  


	$table->addRow();
    $table->addCell(3000)->addText("IPS donde fue atendido:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(7000)->addText($resInformacionCaso["nombre_ips"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  

    $table->addRow();
    $table->addCell(3000)->addText("Fecha ingreso IPS:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(7000)->addText($resInformacionCaso["fecha_ingreso"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  

    $table->addRow();
    $table->addCell(3000)->addText("Tipo de traslado:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
    
    $cell = $table->addCell(3000);
    $textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		    
    if ($resInformacionCaso["servicio_ambulancia"]=="s"){
		$textrun->addText('AMBULANCIA. ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));   

	}else{
		$textrun->addText('PROPIOS MEDIOS. ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	}

	if ($resInformacionCaso["tipo_traslado_ambulancia"]==2){
	    $textrun->addText("Fue trasladado hasta el centro asistencial donde fue atendido desde ".$resInformacionCaso["lugar_traslado"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
   	}else{
   		$textrun->addText("Fue trasladado desde lugar de los hechos hasta el centro asistencial donde fue atendido.",$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 
   	}
	
    $table->addRow();
    $table->addCell(3000)->addText("Lesiones:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(7000)->addText($resInformacionCaso["lesiones"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
		
    $table->addRow();
    $table->addCell(3000)->addText("Tratamiento:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
    
    $table->addCell(7000)->addText($resInformacionCaso["tratamiento"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0)); 

	$table->addRow();
    $table->addCell(3000)->addText("Resultado:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
    
    $table->addCell(7000)->addText($resResultado["resultado"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0)); 

    $table->addRow();
    $table->addCell(3000)->addText("Tipología:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
    
    $table->addCell(7000)->addText($resInformacionCaso["indicador_fraude"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0)); 
	
    if ($cont3>0){

    	while ($resVariosLesionados=mysqli_fetch_assoc($verificarVariosLesionados)){
    		$section->addTextBreak(1,null,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

		    $table =$section->addTable('tableStyle2');
		    $PHPWord->addTableStyle('tableStyle2',$tableStyle,$styleCell2);

		    $table->addRow();
		    $table->addCell(3000)->addText("Nombre: ",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
		    $table->addCell(7000)->addText($resVariosLesionados["nombre_lesionado"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
		    
		    $table->addRow();
		    $table->addCell(3000)->addText("Identificación:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
			$table->addCell(7000)->addText($resVariosLesionados["identificacion_lesionado"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
		    $table->addRow();
		    $table->addCell(3000)->addText("Lugar de Residencia:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
			$table->addCell(7000)->addText($resVariosLesionados["direccion_residencia"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  

			$table->addRow();
		    $table->addCell(3000)->addText("IPS donde fue atendido:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
			$table->addCell(7000)->addText($resVariosLesionados["nombre_ips"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  

		    $table->addRow();
		    $table->addCell(3000)->addText("Fecha ingreso IPS:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
			$table->addCell(7000)->addText($resVariosLesionados["fecha_ingreso"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  

		    $table->addRow();
		    $table->addCell(3000)->addText("Tipo de traslado:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
		    
		    $cell = $table->addCell(3000);
		    $textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  		    
		    
		    if ($resVariosLesionados["servicio_ambulancia"]=="s"){
				$textrun->addText('AMBULANCIA. ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));   

			}else{
				$textrun->addText('PROPIOS MEDIOS. ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			}

			if ($resVariosLesionados["tipo_traslado_ambulancia"]==2){   		

			    $textrun->addText("Fue trasladado hasta el centro asistencial donde fue atendido desde ".$resVariosLesionados["lugar_traslado"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		   	}else{
		   		$textrun->addText("Fue trasladado desde lugar de los hechos hasta el centro asistencial donde fue atendido.",$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 
		   	}

		    $table->addRow();
		    $table->addCell(3000)->addText("Lesiones:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
			$table->addCell(7000)->addText($resVariosLesionados["lesiones"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
				
		    $table->addRow();
		    $table->addCell(3000)->addText("Tratamiento:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
		    
		    $table->addCell(7000)->addText($resVariosLesionados["tratamiento"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0)); 

			mysqli_next_result($con);
			if ($resVariosLesionados["resultado"]==1){
				$consultarResultado="SELECT b.descripcion2 as resultado from aseguradoras a left join definicion_tipos b on a.resultado_atender=b.id where b.id_tipo=10 and a.id='".$resInformacionCaso["id_aseguradora"]."'";
			}	
			else if ($resVariosLesionados["resultado"]==2){
				$consultarResultado="SELECT b.descripcion2 as resultado from aseguradoras a left join definicion_tipos b on a.resultado_no_atender=b.id where b.id_tipo=10 and a.id='".$resInformacionCaso["id_aseguradora"]."'";
			}

			mysqli_next_result($con);
			$queryResultado=mysqli_query($con,$consultarResultado);
			$resResultado=mysqli_fetch_assoc($queryResultado);

			$table->addRow();
		    $table->addCell(3000)->addText("Resultado:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
		    $table->addCell(7000)->addText($resResultado["resultado"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0)); 

		    $table->addRow();
		    $table->addCell(3000)->addText("Tipología:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
		    $table->addCell(7000)->addText($resVariosLesionados["indicador_fraude"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0)); 

    	}
    }

	$section->addTextBreak(2,null,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

    $table =$section->addTable('tableStyle');
    $PHPWord->addTableStyle('tableStyle',$tableStyle,$styleCell);
     
    $table->addRow();  
    $table->addCell(10000,$colspan)->addText('HECHOS',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0)); 

    if ($resInformacionCaso["id_aseguradora"]==1){
	   	$table->addRow();
		$cell = $table->addCell(10000,$colspan);
	    $textrun = $cell->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	    $textrun->addText("Según registro del FURIPS/FURTRAN emitido por ",$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 	
	}
	else{
	   	$table->addRow();
		$cell = $table->addCell(10000,$colspan);
    	$textrun = $cell->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    	$textrun->addText("Según registro de la HOJA DE INGRESO emitido por ",$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 
	}
		
	$textrun->addText($resInformacionCaso["nombre_ips"]." ",$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 
	$textrun->addText($resInformacionCaso["furips"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 

	$section->addPageBreak();

	$table =$section->addTable('tableStyle');
    $PHPWord->addTableStyle('tableStyle',$tableStyle,$styleCell);
     
    $table->addRow();  
    $table->addCell(10000,$colspan)->addText('DILIGENCIAS ADELANTADAS',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0)); 
    
    if ($resInformacionCaso["diligencia_formato_declaracion"]==1)	{
		//lesionado
		$consultarInfoDiligencia="SELECT CONCAT(a.nombres,' ',a.apellidos) AS nombre_diligencia,CONCAT(b.descripcion2,' ',a.identificacion) AS identificacion,a.sexo,a.edad FROM personas a LEFT JOIN definicion_tipos b ON a.tipo_identificacion=b.id WHERE b.id_tipo=5 AND a.id='".$resInformacionCaso["id_diligencia_formato_declaracion"]."'";
		mysqli_next_result($con);
		$queryInfoDiligencia=mysqli_query($con,$consultarInfoDiligencia);
		$cantidadInfoDiligencia=mysqli_num_rows($queryInfoDiligencia);
		$resInfoDiligencia=mysqli_fetch_assoc($queryInfoDiligencia);
		
		$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));  
		$textrun->addText('Quien diligencia el Formato de Declaración de Siniestros es ',$estiloNoBold);

		if($resInfoDiligencia["sexo"] == 1){
	
			if ($resInfoDiligencia["edad"]<18) {
				$textrun->addText('el menor ',$estiloNoBold);
			}else if($resInfoDiligencia["edad"] >= 18 && $resInfoDiligencia["edad"] <= 26){
				$textrun->addText('el joven ',$estiloNoBold);		
			}else{
				$textrun->addText('el señor ',$estiloNoBold);		
			}
		} elseif($resInfoDiligencia["sexo"] == 2){
			
			if ($resInfoDiligencia["edad"]<18) {
				$textrun->addText('la menor ',$estiloNoBold);
			}else if($resInfoDiligencia["edad"] >= 18 && $resInfoDiligencia["edad"] <= 26){
				$textrun->addText('la joven ',$estiloNoBold);	
			}else{
				$textrun->addText('la señora ',$estiloNoBold);		
			}
		}


		$textrun->addText($resInfoDiligencia["nombre_diligencia"],$estiloBold);
		$textrun->addText(', identificado con ',$estiloNoBold);
		$textrun->addText($resInfoDiligencia["identificacion"],$estiloBold);
		$textrun->addText(', quien figura dentro del proceso investigativo como uno de los lesionados, en entrevista realizada el dia '.$resInformacionCaso["fecha_diligencia_formato_declaracion"].', manifiesta lo siguiente:',$estiloNoBold);
	}
	else if ($resInformacionCaso["diligencia_formato_declaracion"]==2)
	{
		//acompañante
		$consultarInfoDiligencia="SELECT a.nombre AS nombre_diligencia,	CONCAT(b.descripcion,' ',a.identificacion) AS identificacion,a.relacion FROM personas_diligencia_formato_declaracion a LEFT JOIN definicion_tipos b ON a.tipo_identificacion=b.id WHERE b.id_tipo=5 AND a.id='".$resInformacionCaso["id_diligencia_formato_declaracion"]."'";
		mysqli_next_result($con);
		$queryInfoDiligencia=mysqli_query($con,$consultarInfoDiligencia);
		$resInfoDiligencia=mysqli_fetch_assoc($queryInfoDiligencia);

		$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));  
		$textrun->addText('Quien diligencia el Formato de Declaración de Siniestros es ',$estiloNoBold);
		

		$textrun->addText($resInfoDiligencia["nombre_diligencia"],$estiloBold);
		$textrun->addText(', identificado/a con ',$estiloNoBold);
		$textrun->addText($resInfoDiligencia["identificacion"],$estiloBold);
		$textrun->addText(', '.$resInfoDiligencia["relacion"],$estiloNoBold);
		if ($resInformacionCaso["sexo"]=="2")
		{
			$textrun->addText('de la lesionada, quien accede a diligenciar el Formato Declaración de Siniestros, manifestando lo siguiente:',$estiloNoBold);
		}
		else 
		{
			$textrun->addText(' del lesionado, quien accede a diligenciar el Formato Declaración de Siniestros, manifestando lo siguiente:',$estiloNoBold);
		}
	}
	else if ($resInformacionCaso["diligencia_formato_declaracion"]==3)
	{
		//investigador
		//acompañante
		$consultarInfoDiligencia="SELECT CONCAT(a.nombres,' ',a.apellidos) AS nombre_diligencia,
		CONCAT(b.descripcion,' ',a.identificacion) AS identificacion, 'INVESTIGADOR' AS relacion
		FROM investigadores a 
		LEFT JOIN definicion_tipos b ON a.tipo_identificacion=b.id 	
		WHERE b.id_tipo=5 AND a.id='".$resInformacionCaso["id_diligencia_formato_declaracion"]."'";
		mysqli_next_result($con);
		$queryInfoDiligencia=mysqli_query($con,$consultarInfoDiligencia);
		$resInfoDiligencia=mysqli_fetch_assoc($queryInfoDiligencia);
		$textrun->addText('Quien diligencia el Formato de Declaración de Siniestros por petición del lesionado, es ',$estiloNoBold);
		
		$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));  
		$textrun->addText($resInfoDiligencia["nombre_diligencia"],$estiloBold);
		$textrun->addText(', identificado/a con ',$estiloNoBold);
		$textrun->addText($resInfoDiligencia["identificacion"],$estiloBold);
		$textrun->addText(', investigador de la Compañía Global Red LTDA, el dia ',$estiloNoBold);
		$textrun->addText($resInformacionCaso["fecha_diligencia_formato_declaracion"].', manifiestando lo siguiente:',$estiloNoBold);
	
	}
	else if ($resInformacionCaso["diligencia_formato_declaracion"]==4)
	{
		//telefonicamente
		$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));  
		$textrun->addText('El lesionado manifiesta por via telefonica lo siguiente:',$estiloNoBold);
	}


	
	 
	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$section->addText('"'.$resInformacionCaso["relato"].'"',array('italic'=>true,'bold'=>true,'size'=>11,'name'=>'Arial'),array('align'=> 'justify','spaceBefore'=>0,'spaceAfter'=>0));
  

    $section->addTextBreak(2,null,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

    $table =$section->addTable('tableStyle');
    $PHPWord->addTableStyle('tableStyle',$tableStyle,$styleCell);
     
    $table->addRow();  
    $table->addCell(10000,$colspan)->addText('INFORMACION POLIZA / TOMADOR',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0)); 

     

	$table->addRow();		
    $table->addCell(5000)->addText("Numero de Póliza. ",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText($resInformacionCaso["numero_poliza"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  

	$table->addRow();		
    $table->addCell(5000)->addText("Vigencia: fecha desde- fecha hasta. ",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText($resInformacionCaso["inicio_vigencia"]." - ".$resInformacionCaso["fin_vigencia"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0)); 


	$table->addRow();		
    $table->addCell(5000)->addText("Nombre tomador. ",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText($resInformacionCaso["nombre_tomador"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0)); 


	$table->addRow();		
    $table->addCell(5000)->addText("Identificación tomador. ",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText($resInformacionCaso["identificacion_tomador"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0)); 


	$table->addRow();		
    $table->addCell(5000)->addText("Teléfono tomador. ",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText($resInformacionCaso["telefono_tomador"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0)); 


	$table->addRow();		
    $table->addCell(5000)->addText("Dirección Tomador. ",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText($resInformacionCaso["direccion_tomador"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0)); 
		
	
	$section->addTextBreak(2,null,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

    $table =$section->addTable('tableStyle');
    $PHPWord->addTableStyle('tableStyle',$tableStyle,$styleCell);
     
    $table->addRow();  
    $table->addCell(10000,$colspan)->addText('CONCLUSION',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0)); 

    $section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));   
	$section->addText($resInformacionCaso["conclusiones"],$estiloNoBold,array('align'=> 'justify','spaceBefore'=>0,'spaceAfter'=>0));
     

		
	$section->addTextBreak(2,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$section->addText("Cordialmente,",$estiloNoBold,array('align'=> 'justify','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$section->addImage( '../firma.png',array('width' => 100,'height' => 100,'wrappingStyle' => 'behind','align'=>'left','marginLeft'=>0,'lineHeight'=>1));  
	$section->addText("JOSÉ MARÍA QUIJANO RODRIGUEZ",$estiloBold,array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$section->addText("GERENTE",$estiloBold,array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));

	mysqli_next_result($con);
	$consultarImagenesLesionados=mysqli_query($con,"SELECT ruta FROM multimedia_investigacion WHERE id_multimedia='2' and id_investigacion='".$id_caso."'");
	$cantidadImagenesLesionados=mysqli_num_rows($consultarImagenesLesionados);

	mysqli_next_result($con);
	$consultarImagenesPunto=mysqli_query($con,"SELECT ruta FROM multimedia_investigacion WHERE id_multimedia='1' and id_investigacion='".$id_caso."'");
	$cantidadImagenesPunto=mysqli_num_rows($consultarImagenesPunto);

	mysqli_next_result($con);
	$consultarImagenesInspeccion=mysqli_query($con,"SELECT ruta FROM multimedia_investigacion WHERE id_multimedia='3' and id_investigacion='".$id_caso."'");
	$cantidadImagenesInspeccion=mysqli_num_rows($consultarImagenesInspeccion);
	
	mysqli_next_result($con);	
	$consultarRunt=mysqli_query($con,"SELECT * FROM multimedia_investigacion WHERE id_multimedia='4' and id_investigacion='".$id_caso."'");
	$cantidadImagenesRunt=mysqli_num_rows($consultarRunt);

	mysqli_next_result($con);
	$consultarSeguridadSocial=mysqli_query($con,"SELECT * FROM multimedia_investigacion WHERE id_investigacion='".$id_caso."' AND id_multimedia=5");
	$cantidadImagenesSeguridadSocial=mysqli_num_rows($consultarSeguridadSocial);

	mysqli_next_result($con);
	$consultarImagenesForm=mysqli_query($con,"SELECT * FROM multimedia_investigacion WHERE id_multimedia='6' and id_investigacion='".$id_caso."'");
	$cantidadImagenesForm=mysqli_num_rows($consultarImagenesForm);

	mysqli_next_result($con);
	$consultarImagenesRegistroTelefonico=mysqli_query($con,"SELECT * FROM multimedia_investigacion WHERE id_multimedia='7' and id_investigacion='".$id_caso."'");
	$cantidadImagenesRegistroTelefonico=mysqli_num_rows($consultarImagenesRegistroTelefonico);

	mysqli_next_result($con);
	$consultarImagenesLugarResidencia=mysqli_query($con,"SELECT * FROM multimedia_investigacion WHERE id_multimedia='8' and id_investigacion='".$id_caso."'");
	$cantidadImagenesLugarResidencia=mysqli_num_rows($consultarImagenesLugarResidencia);

	mysqli_next_result($con);
	$consultarImagenesPoliza=mysqli_query($con,"SELECT * FROM multimedia_investigacion WHERE id_multimedia='12' and id_investigacion='".$id_caso."' ORDER by id asc");
	$cantidadImagenesPoliza=mysqli_num_rows($consultarImagenesPoliza);

	mysqli_next_result($con);
	$consultarImagenesTarjetaPropiedad=mysqli_query($con,"SELECT * FROM multimedia_investigacion WHERE id_multimedia='13' and id_investigacion='".$id_caso."' ORDER by id asc");
	$cantidadImagenesTarjetaPropiedad=mysqli_num_rows($consultarImagenesTarjetaPropiedad);

	if ($cantidadImagenesPoliza>0){
		$table->addRow();
		$table->addCell(10000,$colspan)->addText("ANEXO TÉCNICO N° 1 PÓLIZA NO. ".$resInformacionVehiculo["numero_poliza"],$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	}


	$cont=0;
	if ($cantidadImagenesPoliza>0)
	{
		$section->addPageBreak();
		$section->addText("ANEXO TECNICO N° 1: POLIZA No. ".$resInformacionVehiculo["numero_poliza"],$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));
		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		while ($resImagenesPoliza=mysqli_fetch_assoc($consultarImagenesPoliza))
		{
			$resImagenesPoliza["ruta"] = str_replace('https://globalredltda.co/siglo/portal/data', '../../../data', $resImagenesPoliza["ruta"]);
			$arrayImagenes[$cont]=$resImagenesPoliza["ruta"];
			$cont++;
		}  


		if (count($arrayImagenes)==1)
		{
			$section->addImage($arrayImagenes["0"],array('width' => 580,'height' => 250,'wrappingStyle' => 'behind','align'=>'center','marginLeft'=>0));
		}
		else  if (count($arrayImagenes)==2)
		{
			$table = $section->addTable(array('width' => '5000', 'unit' => 'pct'));
			$table->addRow();
			$table->addCell(2000)->addImage($arrayImagenes["0"],array('width' => 290,'height' => 250,'align'=>'left')); // image1 with needed styles
			$table->addCell(2000)->addImage($arrayImagenes["1"],array('width' => 290,'height' => 250,'align'=>'right')); // image2 with needed styles 
		}
	}

	unset($arrayImagenes);
	$cont=0;
	if ($cantidadImagenesTarjetaPropiedad>0)
	{
		$section->addPageBreak();
		$section->addText("ANEXO TÉCNICO N° 2 TARJETA DE PROPIEDAD",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));
		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		while ($resImagenesTarjetaPropiedad=mysqli_fetch_assoc($consultarImagenesTarjetaPropiedad))
		{
			$resImagenesTarjetaPropiedad["ruta"] = str_replace('https://globalredltda.co/siglo/portal/data', '../../../data', $resImagenesTarjetaPropiedad["ruta"]);
			$arrayImagenes[$cont]=$resImagenesTarjetaPropiedad["ruta"];
			$cont++;
		}  


		if (count($arrayImagenes)==1)
		{
			$section->addImage($arrayImagenes["0"],array('width' => 580,'height' => 250,'wrappingStyle' => 'behind','align'=>'center','marginLeft'=>0));
		}
		else  if (count($arrayImagenes)==2)
		{
			$table = $section->addTable(array('width' => '5000', 'unit' => 'pct'));
			$table->addRow();
			$table->addCell(2000)->addImage($arrayImagenes["0"],array('width' => 290,'height' => 250,'align'=>'left')); // image1 with needed styles
			$table->addCell(2000)->addImage($arrayImagenes["1"],array('width' => 290,'height' => 250,'align'=>'right')); // image2 with needed styles 
		}
	}

	unset($arrayImagenes);
	$cont=0;
	if ($cantidadImagenesLesionados>0)
	{
		$section->addPageBreak();
		$section->addText("FOTOGRAFIAS LESIONES",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));

		while ($resImagenesLesionados=mysqli_fetch_assoc($consultarImagenesLesionados)){
			$resImagenesLesionados["ruta"] = str_replace('https://globalredltda.co/siglo/portal/data', '../../../data', $resImagenesLesionados["ruta"]);

			$arrayImagenes[$cont]=$resImagenesLesionados["ruta"];
			$cont++;
		}  

		if (count($arrayImagenes)==1)
		{
			$section->addTextBreak(4,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun = $section->createTextRun(array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));

			//var_dump($arrayImagenes[0]); die;
			$textrun->addImage($arrayImagenes[0],  array(
				'width' => 500,
				'height' => 400,
				'align'=>'left',
				'wrappingStyle' => 'tight'
			));
		}
		else  if (count($arrayImagenes)==2)
		{
			$textrun = $section->createTextRun(array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));
			$textrun->addImage($arrayImagenes[0],  array(
				'width' => 400,
				'height' => 320,
				'align'=>'left',
				'wrappingStyle' => 'tight'
			));
			$textrun->addText("    ",$estiloNoBold);
			$textrun->addImage($arrayImagenes[1],  array(
				'width' => 400,
				'height' => 320,
				'align'=>'center',
				'wrappingStyle' => 'tight'
			));  
		}
		else
		{

			$textrun = $section->createTextRun(array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));
			for ($i=0;$i<count($arrayImagenes);$i++)
			{
				if ($i==0 || $i==4 || $i==8 || $i==12 || $i==16)
				{
					$textrun->addTextBreak(2,null,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
					$textrun->addImage($arrayImagenes[$i],  array(
						'width' => 127.5525,
						'height' => 188.9763779528,
						'align'=>'center',
						'wrappingStyle' => 'tight'
					));
					$textrun->addText(" ",$estiloNoBold);
				}
				else
				{
					$textrun->addImage($arrayImagenes[$i],  array(
						'width' => 127.5525,
						'height' => 188.9763779528,
						'align'=>'center',
						'wrappingStyle' => 'tight'

					));
					$textrun->addText(" ",$estiloNoBold);
				}
			}
		}

		mysqli_next_result($con);
		$consultarDetalleImagenLesionado=mysqli_query($con,"SELECT observacion FROM observaciones_secciones_informe WHERE id_investigacion='".$id_caso."' and id_seccion='5'");
		if (mysqli_num_rows($consultarDetalleImagenLesionado)>0)
		{
			$resDetalleImagenLesionado=mysqli_fetch_assoc($consultarDetalleImagenLesionado);
			$section->addText($resDetalleImagenLesionado["descripcion"], array('italic'=>true,'bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
		}
		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	}

	unset($arrayImagenes);
	$cont=0;
	if ($cantidadImagenesPunto>0){
		$section->addPageBreak();
		$section->addText("PUNTOS DE REFERENCIA LUGAR DE LOS HECHOS:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));
		
		while ($resImagenesPunto=mysqli_fetch_assoc($consultarImagenesPunto)){
			$resImagenesPunto["ruta"] = str_replace('https://globalredltda.co/siglo/portal/data', '../../../data', $resImagenesPunto["ruta"]);
			$arrayImagenes[$cont]=$resImagenesPunto["ruta"];
			$cont++;
		}    

		if (count($arrayImagenes)==1){

			$textrun = $section->createTextRun(array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));
			$textrun->addImage($arrayImagenes[0],  array(
				'width' => 500,
				'height' => 400,
				'align'=>'left',
				'wrappingStyle' => 'tight'
			 ));
		}
		else  if (count($arrayImagenes)==2)
		{
			$textrun = $section->createTextRun(array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));
			$textrun->addImage($arrayImagenes[0],  array(
				'width' => 400,
				'height' => 320,
				'align'=>'left',
				'wrappingStyle' => 'tight'
			));

			$textrun->addText("    ",$estiloNoBold);
			$textrun->addImage($arrayImagenes[1],  array(
				'width' => 400,
				'height' => 320,
				'align'=>'center',
				'wrappingStyle' => 'tight'
			));  

		}
		else
		{

			$textrun = $section->createTextRun(array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));
			for ($i=0;$i<count($arrayImagenes);$i++)
			{

				if ($i==0 || $i==4 || $i==8 || $i==12 || $i==16)
				{
					$textrun->addTextBreak(2,null,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
					$textrun->addImage($arrayImagenes[$i],  array(
						'width' => 127.5525,
						'height' => 188.9763779528,
						'align'=>'center',
						'wrappingStyle' => 'tight'
					));
					$textrun->addText(" ",$estiloNoBold);
				}
				else
				{
					$textrun->addImage($arrayImagenes[$i],  array(
						'width' => 127.5525,
						'height' => 188.9763779528,
						'align'=>'center',
						'wrappingStyle' => 'tight'
					));
					$textrun->addText(" ",$estiloNoBold);
				}
			 }
		}

		mysqli_next_result($con);
		$consultarObservacionesFURIPSnew6=$consultarObservacionesInforme." AND id_seccion=17";

		$queryObservaciones=mysqli_query($con,$consultarObservacionesFURIPSnew6);

		if (mysqli_num_rows($queryObservaciones)>0)
		{
			$resDetalleImagenPunto=mysqli_fetch_assoc($queryObservaciones);
			$section->addText($resDetalleImagenPunto["descripcion"], array('italic'=>true,'bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
		}

		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

	}




	unset($arrayImagenes);
	$cont=0;
	if ($cantidadImagenesInspeccion>0)
	{
		$section->addPageBreak();
		$section->addText("INSPECCIÓN  TÉCNICA DEL VEHÍCULO:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));
	
		while ($resImagenesInspeeccion=mysqli_fetch_assoc($consultarImagenesInspeccion)){
			$resImagenesInspeeccion["ruta"] = str_replace('https://globalredltda.co/siglo/portal/data', '../../../data', $resImagenesInspeeccion["ruta"]);
			$arrayImagenes[$cont]=$resImagenesInspeeccion['ruta'];
			$cont++;
		}  

		if (count($arrayImagenes)==1)
		{
			$textrun = $section->createTextRun(array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));
			$textrun->addImage($arrayImagenes[0],  array(
				'width' => 500,
				'height' => 400,
				'align'=>'left',
				'wrappingStyle' => 'tight'
			));
		}
		else  if (count($arrayImagenes)==2)
		{
			$textrun = $section->createTextRun(array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));
			$textrun->addImage($arrayImagenes[0],  array(
				'width' => 400,
				'height' => 320,
				'align'=>'left',
				'wrappingStyle' => 'tight'
			));
			$textrun->addText("    ",$estiloNoBold);
			$textrun->addImage($arrayImagenes[1],  array(
				'width' => 227.1496062992,
				'height' => 188.9763779528,
				'align'=>'center',
				'wrappingStyle' => 'tight'
			));  
		}
		else
		{
			$textrun = $section->createTextRun(array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));
			for ($i=0;$i<count($arrayImagenes);$i++)
			{
				if ($i==0 || $i==4 || $i==8 || $i==12 || $i==16)
				{
					$textrun->addTextBreak(2,null,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
					$textrun->addImage($arrayImagenes[$i],  array(
						'width' => 127.5525,
						'height' => 188.9763779528,
						'align'=>'center',
						'wrappingStyle' => 'tight'
					));
					$textrun->addText(" ",$estiloNoBold);
				}
				else
				{
					$textrun->addImage($arrayImagenes[$i],  array(
						'width' => 127.5525,
						'height' => 188.9763779528,
						'align'=>'center',
						'wrappingStyle' => 'tight'
					));
	
					$textrun->addText(" ",$estiloNoBold);
				}
			}
		}

		mysqli_next_result($con);
		$consultarObservacionesNuevas6=$consultarObservacionesInforme." AND id_seccion=13";
		$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas6);
		if (mysqli_num_rows($queryObservaciones)>0)
		{
			$resDetalleImagenInspeccion=mysqli_fetch_assoc($queryObservaciones);
			$section->addText($resDetalleImagenInspeccion["observacion"], array('italic'=>true,'bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
		}
		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

	}





	unset($arrayImagenes);
	$cont=0;
	if ($cantidadImagenesRegistroTelefonico>0)
	{
		$section->addPageBreak();
		$section->addText("REGISTRO TELEFONICO:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));
		
		while ($resImagenesRegistroTelefonico=mysqli_fetch_array($consultarImagenesRegistroTelefonico))
		{
			$resImagenesRegistroTelefonico["ruta"] = str_replace('https://globalredltda.co/siglo/portal/data', '../../../data', $resImagenesRegistroTelefonico["ruta"]);
			$arrayImagenes[$cont]=$resImagenesRegistroTelefonico["ruta"];
			$cont++;
		}  
  
		if (count($arrayImagenes)==1)
		{
			$textrun = $section->createTextRun(array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));
		
			$textrun->addImage($arrayImagenes[0],  array(
				'width' => 500,
				'height' => 400,
				'align'=>'left',
				'wrappingStyle' => 'tight'
			));
		}
		else  if (count($arrayImagenes)==2)
		{
			$textrun = $section->createTextRun(array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));
			$textrun->addImage($arrayImagenes[0],  array(
				'width' => 400,
				'height' => 320,
				'align'=>'left',
				'wrappingStyle' => 'tight'
			));
			$textrun->addText("    ",$estiloNoBold);
			$textrun->addImage($arrayImagenes[1],  array(
				'width' => 400,
				'height' => 320,
				'align'=>'center',
				'wrappingStyle' => 'tight'
			));  

		}
		else
		{

			$textrun = $section->createTextRun(array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));
			for ($i=0;$i<count($arrayImagenes);$i++)
			{

				if ($i==0 || $i==4 || $i==8 || $i==12 || $i==16)
				{
					$textrun->addTextBreak(2,null,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
					$textrun->addImage($arrayImagenes[$i],  array(
						'width' => 127.5525,
						'height' => 188.9763779528,
						'align'=>'center',
						'wrappingStyle' => 'tight'
					));
					$textrun->addText(" ",$estiloNoBold);
				}
				else
				{

					$textrun->addImage($arrayImagenes[$i],  array(
						'width' => 127.5525,
						'height' => 188.9763779528,
						'align'=>'center',
						'wrappingStyle' => 'tight'
					));

					$textrun->addText(" ",$estiloNoBold);
				}
	 		}

		}
  		mysqli_next_result($con);
		$consultarObservacionesNuevas7=$consultarObservacionesInforme." AND id_seccion=18";
		$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas7);
  		
  		if (mysqli_num_rows($queryObservaciones)>0)
		{
    		$resDetalleImagenInspeccion=mysqli_fetch_assoc($queryObservaciones);
    		$section->addText($resDetalleImagenInspeccion["observacion"], array('italic'=>true,'bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
  		}
	  	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	}

	unset($arrayImagenes);
	$cont=0;
	if ($cantidadImagenesLugarResidencia>0)
	{
		$section->addPageBreak();
		$section->addText("LUGAR DE RESIDENCIA:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));
		
		while ($resImagenesLugarResidencia=mysqli_fetch_array($consultarImagenesLugarResidencia))
		{
			$resImagenesLugarResidencia["ruta"] = str_replace('https://globalredltda.co/siglo/portal/data', '../../../data', $resImagenesLugarResidencia["ruta"]);
			$arrayImagenes[$cont]=$resImagenesLugarResidencia['ruta'];
			$cont++;
		}  
  
		if (count($arrayImagenes)==1)
		{
			$textrun = $section->createTextRun(array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));
			$textrun->addImage($arrayImagenes[0],  array(
				'width' => 500,
				'height' => 400,
				'align'=>'left',
				'wrappingStyle' => 'tight'
			));
		}
		else  if (count($arrayImagenes)==2)
		{
			$textrun = $section->createTextRun(array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));
			$textrun->addImage($arrayImagenes[0],  array(
				'width' => 400,
				'height' => 320,
				'align'=>'left',
				'wrappingStyle' => 'tight'
			));
			$textrun->addText("    ",$estiloNoBold);
			$textrun->addImage($arrayImagenes[1],  array(
				'width' => 400,
				'height' => 320,
				'align'=>'center',
				'wrappingStyle' => 'tight'
			));  
		}
		else
		{
			$textrun = $section->createTextRun(array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));
			for ($i=0;$i<count($arrayImagenes);$i++)
			{
				if ($i==0 || $i==4 || $i==8 || $i==12 || $i==16)
				{
					$textrun->addTextBreak(2,null,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
					$textrun->addImage($arrayImagenes[$i],  array(
						'width' => 127.5525,
						'height' => 188.9763779528,
						'align'=>'center',
						'wrappingStyle' => 'tight'
					));
					$textrun->addText(" ",$estiloNoBold);
				}
				else
				{
					$textrun->addImage($arrayImagenes[$i],  array(
						'width' => 127.5525,
						'height' => 188.9763779528,
						'align'=>'center',
						'wrappingStyle' => 'tight'
					));
					$textrun->addText(" ",$estiloNoBold);
				}
	 		}
		}
  		mysqli_next_result($con);
		$consultarObservacionesNuevas8=$consultarObservacionesInforme." AND id_seccion=19";
		$queryObservaciones=mysqli_query($consultarObservacionesNuevas8);
  		if (mysqli_num_rows($queryObservaciones)>0)
		{
    		$resDetalleImagenInspeccion=mysqli_fetch_assoc($queryObservaciones);
    		$section->addText($resDetalleImagenInspeccion["observacion"], array('italic'=>true,'bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
  		}
	  	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

	}


	if ($cantidadImagenesRunt>0)
	{
	 	$section->addPageBreak();
		$section->addText("REGISTRO RUNT:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));
		 
		while ($resRunt=mysqli_fetch_assoc($consultarRunt))
		{
			$resRunt["ruta"] = str_replace('https://globalredltda.co/siglo/portal/data', '../../../data', $resRunt["ruta"]);
	  		$section->addImage($resRunt["ruta"],array('width' => 500,'height' => 400,'wrappingStyle' => 'behind','align'=>'center','marginLeft'=>0));  
		}
	   
	}

	//seguridad social
	unset($arrayImagenes);
	$cont=0;
	if ($cantidadImagenesSeguridadSocial>0)
	{
		$section->addPageBreak();
		$section->addText("AFILIACIÓN AL SISTEMA DE SEGURIDAD SOCIAL:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));
		
		while ($resImagenesSeguridadSocial=mysqli_fetch_assoc($consultarSeguridadSocial))
		{
			$resImagenesSeguridadSocial["ruta"] = str_replace('https://globalredltda.co/siglo/portal/data', '../../../data', $resImagenesSeguridadSocial["ruta"]);
			$arrayImagenes[$cont]=$resImagenesSeguridadSocial['ruta'];
			$cont++;
		}  
  
		if (count($arrayImagenes)==1)
		{
			$textrun = $section->createTextRun(array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));
			$textrun->addImage($arrayImagenes[0],  array(
				'width' => 500,
				'height' => 400,
				'align'=>'left',
				'wrappingStyle' => 'tight'
			));
		}
		else  if (count($arrayImagenes)==2)
		{
			$textrun = $section->createTextRun(array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));
			$textrun->addImage($arrayImagenes[0],  array(
				'width' => 400,
				'height' => 320,
				'align'=>'left',
				'wrappingStyle' => 'tight'
			));
			$textrun->addText("    ",$estiloNoBold);
			$textrun->addImage($arrayImagenes[1],  array(
				'width' => 400,
				'height' => 320,
				'align'=>'center',
				'wrappingStyle' => 'tight'
			));  
		}
		else
		{
			$textrun = $section->createTextRun(array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));
			for ($i=0;$i<count($arrayImagenes);$i++)
			{
				if ($i==0 || $i==4 || $i==8 || $i==12 || $i==16)
				{
					$textrun->addTextBreak(2,null,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
					$textrun->addImage($arrayImagenes[$i],  array(
						'width' => 127.5525,
						'height' => 188.9763779528,
						'align'=>'center',
						'wrappingStyle' => 'tight'
					));
					$textrun->addText(" ",$estiloNoBold);
				}
				else
				{
					$textrun->addImage($arrayImagenes[$i],  array(
						'width' => 127.5525,
						'height' => 188.9763779528,
						'align'=>'center',
						'wrappingStyle' => 'tight'
					));
					$textrun->addText(" ",$estiloNoBold);
				}
	 		}
		}
  		mysqli_next_result($con);
		$consultarObservacionesNuevas10=$consultarObservacionesInforme." AND id_seccion=5";
		$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas10);
  		if (mysqli_num_rows($queryObservaciones)>0)
		{
    		$resDetalleImagenSalud=mysqli_fetch_assoc($queryObservaciones);
    		$section->addText($resDetalleImagenSalud["observacion"], array('italic'=>true,'bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
  		}
	  	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

	}


	unset($arrayImagenes);
	$cont=0;
	if ($cantidadImagenesForm>0)
	{
					
		while ($resImagenesForm=mysqli_fetch_assoc($consultarImagenesForm))
		{
			$resImagenesForm["ruta"] = str_replace('https://globalredltda.co/siglo/portal/data', '../../../data', $resImagenesForm["ruta"]);
			$section->addPageBreak();
			$section->addText("FOTOS FORMULARIO:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));
			$section->addImage($resImagenesForm['ruta'],array('width' => 600,'height' => 650,'wrappingStyle' => 'behind','align'=>'center','marginLeft'=>0));  
			
			$cont++;
		}  
  
			
  		mysqli_next_result($con);
		$consultarObservacionesNuevas9=$consultarObservacionesInforme." AND id_seccion=15";
		$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas9);
	  	
	  	if (mysqli_num_rows($queryObservaciones)>0)
		{
	    	$resDetalleImagenInspeccion=mysqli_fetch_assoc($queryObservaciones);
	    	$section->addText($resDetalleImagenInspeccion["observacion"], array('italic'=>true,'bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
	  	}

		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	}

	$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($PHPWord, 'Word2007');
	$nombre="INFORME ".$resInformacionCaso["nombre_lesionado"]." POLIZA No. ".$resInformacionCaso["numero_poliza"]." - ".$resIdCasosAseguadora["identificador"];
	$objWriter->save('Informe.docx');
	header('Content-Disposition: attachment; filename="'.$nombre.'.docx"');
	echo file_get_contents('Informe.docx');
?>