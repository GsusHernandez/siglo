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
	$header = $section->createHeader();
	$header->addImage( '../logo2.png',array('width' => 600,'height' => 180,'wrappingStyle' => 'behind'));
	//TERMINA ENCABEZADO
	//crear PIE DE PAGINA
	$estiloFuenteFooter=array('bold'=>true,'size'=>8,'name'=>'Arial');
	$estiloParrafoFooter=array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0);
	$footer = $section->createFooter();
	$footer->addText("Global Red  LTDA “Investigaciones Sin Fronteras”",$estiloFuenteFooter ,$estiloParrafoFooter);
	$footer->addText("CALLE 68B NO. 50 - 142 - ED. AVENIDA COLOMBIA APTO 1A", $estiloFuenteFooter ,$estiloParrafoFooter);

	$footer->addText("BARRANQUILLA - ATLANTICO", $estiloFuenteFooter ,$estiloParrafoFooter);
	$footer->addText("TEL: 3563397 - CEL: 3103229337", $estiloFuenteFooter ,$estiloParrafoFooter);
	$footer->addText("e-mail: jquijano@globalredltda.co.", $estiloFuenteFooter ,$estiloParrafoFooter);
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
	LEFT JOIN poliza_vehiculo i ON i.id_poliza=b.id_poliza
	LEFT JOIN polizas j ON j.id=i.id_poliza
	LEFT JOIN vehiculos k ON k.id=i.id_vehiculo
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
	c.descripcion2 AS tipo_identificacion_lesionado,b.identificacion AS no_identificacion_lesionado,CASE
	WHEN a.lugar_traslado IS NULL THEN 'N' 
	ELSE a.lugar_traslado END AS lugar_traslado,a.condicion,
	b.direccion_residencia,h.nombre_ips,b.edad,b.ocupacion
	FROM  personas_investigaciones_soat a 
	LEFT JOIN personas b ON a.id_persona=b.id
	LEFT JOIN definicion_tipos c ON c.id=b.tipo_identificacion 
	LEFT JOIN ciudades f ON f.id=b.ciudad_residencia
	LEFT JOIN departamentos g ON g.id=f.id_departamento
	LEFT JOIN ips h ON h.id=a.ips
	WHERE 
	a.tipo_persona=2 AND c.id_tipo=5  AND a.id_investigacion='".$id_caso."'";
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
	

	$styleCell = array('bgColor'=>'000080',  'borderColor' => '000000', 'borderSize' => 6,
	    'cellMargin' => 50,
		  'valign' => 'center',
	  	'align' => 'center');
			 
			$tableStyle=array('borderSize'=>6, 'borderColor'=>'000000',  'cellMargin' => 10,
		  'valign' => 'center',
	  	'align' => 'center');

	$colspanTitulo=array('gridSpan' => 2, 'valign' => 'center','bgColor'=>'000080',  'borderColor' => '000000', 'borderSize' => 6,
	    'cellMargin' => 50,
		  'align' => 'center');

	$estiloBarraTitulos=array('valign' => 'center','bgColor'=>'000080',  'borderColor' => '000000', 'borderSize' => 6,
	    'cellMargin' => 50,
		  'align' => 'center');
	$colspan=array('gridSpan' => 2, 'valign' => 'center',);
	$colspan2=array('gridSpan' => 5, 'valign' => 'center',);
	$section->addText("Nº Caso: ".$resInformacionCaso['codigo'],array('color'=>'red','bold'=>true,'name'=>'Arial','size'=>12),array('align'=>'right','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	
	$section->addText("Barranquilla, ".$resInformacionCaso['fecha_entrega'],$estiloNoBold,array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  		
	

//FIN CIUDAD Y FECHA

	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$section->addText("Señores:",$estiloNoBold,array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$section->addText($resInformacionCaso['aseguradora'],$estiloBold,array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$section->addText($resInformacionCaso['responsable'],$estiloBold,array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	if ($resInformacionCaso['cargo']!='N')
	{
		$section->addText($resInformacionCaso['cargo'],array('bold'=>TRUE,'size'=>11,'name'=>'Arial'),array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	}

	$section->addText("Bogotá D.C.",$estiloNoBold,array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

    $section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $table =$section->addTable('tableStyle');
    $PHPWord->addTableStyle('tableStyle',$tableStyle,$styleCell);
     
    $table->addRow();
	  
    $table->addCell(10000,$colspan)->addText('REFERENCIA: INFORME FINAL',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));  
		
    $table->addRow();
    $table->addCell(5000)->addText("LESIONADO:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText($resInformacionCaso["nombre_lesionado"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
    
    $table->addRow();
    $table->addCell(5000)->addText("PÓLIZA NO:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText($resInformacionCaso["numero_poliza"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  

    $table->addRow();
    $table->addCell(5000)->addText("TIPO DE VEHÍCULO:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText($resInformacionCaso["tipo_vehiculo"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
    
    $table->addRow();
    $table->addCell(5000)->addText("PLACA:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText($resInformacionCaso["placa"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  

    $table->addRow();
    $table->addCell(5000)->addText("CLÍNICA DONDE ES TRASLADADO:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText($resInformacionCaso["nombre_ips"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  


	$table->addRow();
    $table->addCell(5000)->addText("CIUDAD DE ATENCION:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText($resInformacionCaso["ciudad_ips"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  

    $table->addRow();
    $table->addCell(5000)->addText("FECHA DE ACCIDENTE:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText($resInformacionCaso["fecha_accidente"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  

    $table->addRow();
    $table->addCell(5000)->addText("FECHA DE INGRESO A LA CLÍNICA:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText($resInformacionCaso["fecha_ingreso"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  

    $table->addRow();
    $table->addCell(5000)->addText("FECHA DE EGRESO DE LA CLÍNICA:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText($resInformacionCaso["fecha_egreso"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
		
 	

    $table->addRow();
    $table->addCell(5000)->addText("CONCEPTO:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
    
    $table->addCell(5000)->addText($resResultado["resultado"]." - ".$resInformacionCaso["indicador_fraude"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0)); 

    $section->addTextBreak(2,null,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		
    $table =$section->addTable('tableStyle');
    $PHPWord->addTableStyle('tableStyle',$tableStyle,$styleCell);
     
    $table->addRow();
    $table->addCell(10000)->addText('ANALISIS DEL SINIESTRO',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0)); 
    $table->addRow();
    $cell = $table->addCell(1750);
    $textrun = $cell->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText('Por medio del presente nos permitimos informar el resultado final de la investigación de ',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
    $textrun->addText("ACCIDENTE DE TRANSITO",$estiloBold);
	$textrun->addText(' realizada ',$estiloNoBold); 
    if ($resInformacionCaso["edad"]<18 and $resInformacionCaso["sexo"]=="2")
	{
		$textrun->addText('a la joven ',$estiloNoBold);
	}
	else if ($resInformacionCaso["edad"]<18 and $resInformacionCaso["sexo"]=="1")
	{
		$textrun->addText('al joven ',$estiloNoBold);
	}
	else if ($resInformacionCaso["edad"]>18 and $resInformacionCaso["sexo"]=="2")
	{
		$textrun->addText('a la señora ',$estiloNoBold);
	}
	else if ($resInformacionCaso["edad"]>18 and $resInformacionCaso["sexo"]=="1")
	{
		$textrun->addText('al señor ',$estiloNoBold);
	}

	$textrun->addText($resInformacionCaso["nombre_lesionado"], $estiloBold, array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	if ($resInformacionCaso["sexo"]=="2")
	{
		$textrun->addText(', identificada con ',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	}
	else
	{
  		$textrun->addText(', identificado con ',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	}

	$textrun->addText($resInformacionCaso["tipo_identificacion_lesionado"]." No. ",$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$textrun->addText($resInformacionCaso["no_identificacion_lesionado"], $estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 

	if ($cont3==1)
	{
		while ($resVariosLesionados=mysql_fetch_array($verificarVariosLesionados))
		{

			$textrun->addText(', y ',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			
			if ($resVariosLesionados["edad"]>18 and $resVariosLesionados["sexo"]=="1")
			{
				$textrun->addText(' al señor ',$estiloNoBold);
			}
			else if ($resVariosLesionados["edad"]>18 and $resVariosLesionados["sexo"]=="2")
			{
				$textrun->addText(' a la señora ',$estiloNoBold);
			}
			else if ($resVariosLesionados["edad"]<18 and $resVariosLesionados["sexo"]=="2")
			{
				$textrun->addText(' a la joven ',$estiloNoBold);
			}
			else if ($resVariosLesionados["edad"]<18 and $resVariosLesionados["sexo"]=="1")
			{
				$textrun->addText(' al joven ',$estiloNoBold);
			}
			
			
			$textrun->addText($resVariosLesionados["nombre_lesionado"],$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			
			if ($resVariosLesionados["sexo"]=="2")
			{
				$textrun->addText(', identificada con ',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			}
			else
			{
				$textrun->addText(', identificado con ',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			}

			$textrun->addText($resVariosLesionados["tipo_identificacion_lesionado"]." ",$estiloNoBold); 
			$textrun->addText($resVariosLesionados["no_identificacion_lesionado"], $estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		}   
   		
   		$textrun->addText(', quienes refieren haber sufrido el siniestro el día ',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
  	}
	else
	{
    	if ($resInformacionCaso["edad"]!="")
		{
				$textrun->addText(', de '.$resInformacionCaso["edad"].' años de edad,',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    	}

			$textrun->addText(' quien refiere haber sufrido el siniestro el día ',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
  	}

  	$textrun->addText($resInformacionCaso["fecha_accidente2"], $estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));

  	if ($cont3==2)
	{
     	$textrun->addText(' y recibieron atención médica en la IPS ',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
   	}
   	else
	{
     	$textrun->addText(' y recibió atención médica en la IPS ',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
   	}

   	$textrun->addText($resInformacionCaso["nombre_ips"], $estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 

   	if ($resInformacionCaso["fecha_ingreso2"]==$resInformacionCaso["fecha_accidente3"])
	{
		$textrun->addText(' el mismo día',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
  	}
	else
	{

    	$textrun->addText(' el  día ',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
  		$textrun->addText($resInformacionCaso["fecha_ingreso3"], $estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
  	}
  	$textrun->addText(', pretendiendo afectar la Póliza de Seguro Obligatorio de Accidentes de Tránsito SOAT N° ',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$textrun->addText($resInformacionCaso["numero_poliza"], $estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$textrun->addText(' del vehículo tipo ',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$textrun->addText(strtoupper($resInformacionCaso["tipo_vehiculo"]), $estiloBold);
	$textrun->addText(' con placas ',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$textrun->addText($resInformacionCaso["placa"], $estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

	$textrun->addText(' en condición de ' ,$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

	$textrun->addText($resInformacionCaso["condicion"],$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));

	if ($cont3==1)
	{
	 	
		$textrun->addText($resVariosLesionados["condicion"],$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
   	}  

   	$textrun->addText(' por lo cual se cursa reclamación de Gastos Médicos;',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
   	$textrun->addText(' concluimos que después de adelantar todo el protocolo investigativo su resultado es: ',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
	$textrun->addText($resResultado["resultado"], $estiloBold);    

  	$section->addPageBreak();


    
    $table =$section->addTable('tableStyle');
    $PHPWord->addTableStyle('tableStyle',$tableStyle,$styleCell);
     
    $table->addRow();
	  
    $table->addCell(10000,$colspan)->addText('ANALISIS DE LA VICTIMA',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));  
		
    $table->addRow();
		
	$cell = $table->addCell(1750);
	$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$textrun->addText('NOMBRE: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$textrun->addText($resInformacionCaso["nombre_lesionado"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
				
	$cell = $table->addCell(1750);
	$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$textrun->addText('OCUPACION: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$textrun->addText($resInformacionCaso["ocupacion"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));

    
    $table->addRow();
    $cell = $table->addCell(1750);
    $textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText('IDENTIFICACION: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText($resInformacionCaso["identificacion_lesionado"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    
    $cell = $table->addCell(1750);
    $textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText('EDAD: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText($resInformacionCaso["edad"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  


	$table->addRow();
    $cell = $table->addCell(10000,$colspan);
    $textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText('DIRECCION DE RESIDENCIA: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText($resInformacionCaso["direccion_residencia"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  


	$table->addRow();
    $cell = $table->addCell(1750);
    $textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText('CIUDAD/MUNICIPIO: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText($resInformacionCaso["ciudad_residencia"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    
    $cell = $table->addCell(1750);
    $textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText('BARRIO: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText($resInformacionCaso["barrio"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

	$table->addRow();
    $cell = $table->addCell(1750);
    $textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText('TELEFONO: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText($resInformacionCaso["telefono"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    
    $cell = $table->addCell(1750);
    $textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText('CONDICION VICTIMA: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText($resInformacionCaso["condicion"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));


		
	$table->addRow();
	if ($resInformacionCaso["servicio_ambulancia"]=="s")
	{
		mysqli_next_result($con);
		$consultarTipoServicioAmbulancia=mysqli_query($con,"SELECT descripcion as tipo_servicio_ambulancia FROM definicion_tipos WHERE id_tipo=16 and id='".$resInformacionCaso["tipo_traslado_ambulancia"]."'");
		$resTipoServicioAmbulancia=mysqli_fetch_assoc($consultarTipoServicioAmbulancia);
		$cell = $table->addCell(5000);
		$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun->addText('VEHICULO DE TRASLADO: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun->addText("AMBULANCIA",$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 
		$cell = $table->addCell(5000);
		$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun->addText('TIPO DE TRASLADO: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun->addText($resTipoServicioAmbulancia["tipo_servicio_ambulancia"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 
			
	 	if ($resInformacionCaso["tipo_traslado_ambulancia"]==2)
	   	{
	   		$table->addRow();
		    $cell = $table->addCell(10000,$colspan);
		    $textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		    $textrun->addText('LUGAR DEL TRASLADO DE LA VICTIMA: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		    $textrun->addText($resInformacionCaso["lugar_traslado"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 
	   	}
    
	}
	else
	{
		mysqli_next_result($con);
		$consultarTipoVehiculoTraslado=mysqli_query($con,"SELECT descripcion as tipo_vehiculo FROM tipo_vehiculos WHERE id='".$resInformacionCaso["tipo_vehiculo_traslado"]."'");
		$resTipoVehiculoTraslado=mysqli_fetch_assoc($consultarTipoVehiculoTraslado);
		$cell = $table->addCell(5000);
		$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun->addText('VEHICULO DE TRASLADO: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$table->addCell(5000)->addText($resTipoVehiculoTraslado["tipo_vehiculo"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
			
			
    
	}


	$table->addRow();
	$cell = $table->addCell(10000,$colspan);
	$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$textrun->addText('LESIONES: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	
	if ($resInformacionCaso["id_indicador_fraude"]==30 || $resInformacionCaso["id_indicador_fraude"]==39)
	{
		$textrun->addText("SE DESCONOCE",$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 
	}
	else
	{
		$textrun->addText($resInformacionCaso["lesiones"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 
	}
				
	$table->addRow();
	$cell = $table->addCell(10000,$colspan);
	$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$textrun->addText('TRATAMIENTO: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	
	if ($resInformacionCaso["id_indicador_fraude"]==30 || $resInformacionCaso["id_indicador_fraude"]==39)
	{
		$textrun->addText("SE DESCONOCE",$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 
	}
	else
	{
		$textrun->addText($resInformacionCaso["tratamiento"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 
	}



	$table->addRow();
    $table->addCell(5000)->addText("CLINICA DONDE FUE ATENDIDO:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText($resInformacionCaso["nombre_ips"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  

	$table->addRow();
    $table->addCell(5000)->addText("AFILIACION AL SISTEMA DE SEGURIDAD SOCIAL: ",array('bold'=>true,'name'=>'Arial','size'=>9),array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
    if ($resInformacionCaso["id_seguridad_social"]==1)
    {
      	mysqli_next_result($con);
      	$consultarRegimenEPS=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=18 and id='".$resInformacionCaso["regimen"]."'");
      	$resRegimenEPS=mysqli_fetch_assoc($consultarRegimenEPS);

      	mysqli_next_result($con);
      	$consultarEstadoEPS=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=19 and id='".$resInformacionCaso["estado_eps"]."'");
      	$resEstadoEPS=mysqli_fetch_assoc($consultarEstadoEPS);

      	
    	$cell = $table->addCell(5000);
    	$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    	$textrun->addText('EPS: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    	$textrun->addText($resInformacionCaso["eps"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    	$textrun->addText(' - REGIMEN: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    	$textrun->addText($resRegimenEPS["descripcion"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    	$textrun->addText(' - ESTADO: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    	$textrun->addText($resEstadoEPS["descripcion"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));

    }
    else if ($resInformacionCaso["id_seguridad_social"]==2)
    {
     
	  	$seguridad_social=$resInformacionCaso["seguridad_social"];

	  	$table->addCell(5000)->addText($seguridad_social,$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));
    }
    else if ($resInformacionCaso["id_seguridad_social"]==3)
    {
      	mysqli_next_result($con);
      	$consultarCausalConsulta=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=20 and id='".$resInformacionCaso["causal_consulta"]."'");
      	$resCausalConsulta=mysqli_fetch_assoc($consultarCausalConsulta);


	  	$seguridad_social=$resInformacionCaso["seguridad_social"]." - ".$resCausalConsulta["descripcion"];
	  	$table->addCell(5000)->addText($seguridad_social,$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));
    }




	$consultarObservacionesNuevas=$consultarObservacionesInforme." AND id_seccion IN (3,4,6)";
	mysqli_next_result($con);
	$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas);

	if (mysqli_num_rows($queryObservaciones)>0)
	{
		$table->addRow();
		$cell = $table->addCell(10000,$colspan);
		$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun->addText('OBSERVACIONES: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
		$cont=0;
		while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones))
		{
			$cont++;
			$textrun->addText($resObservaciones["observacion"], array('bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));	
			if ($cont<mysqli_num_rows($queryObservaciones))
			{
				$textrun->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));	
			}
		}							
	}




	$table->addRow();
    $table->addCell(10000,$colspanTitulo)->addText('INVESTIGACION DE CAMPO',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0)); 



	$table->addRow();
    $cell = $table->addCell(10000,$colspan);
    $textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText('DIRECCION DE LOS HECHOS: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText($resInformacionCaso["lugar_accidente"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

	$table->addRow();
    $cell = $table->addCell(10000,$colspan);
    $textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText('PUNTOS DE REFERENCIA: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

	if ($resInformacionCaso["visita_lugar_hechos"]=="S")
	{
	 
		$textrun->addText($resInformacionCaso["punto_referencia"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	  
	}
	else if ($resInformacionCaso["visita_lugar_hechos"]=="N")
	{
		mysqli_next_result($con);
        $consultarDescripcionVisitaLugarHechos=mysqli_query($con,"SELECT descripcion as descripcion_visita_lugar_hechos FROM definicion_tipos WHERE id_tipo=35 and id=1");
        $resDescripcionVisitaLugarHechos=mysqli_fetch_assoc($consultarDescripcionVisitaLugarHechos);

		$textrun->addText($resDescripcionVisitaLugarHechos["descripcion_visita_lugar_hechos"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));    
	}
    
	mysqli_next_result($con);
	$consultarObservacionesNuevas1=$consultarObservacionesInforme." AND id_seccion IN (7,8)";
	$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas1);

	if (mysqli_num_rows($queryObservaciones)>0)
	{
		$table->addRow();
		$cell = $table->addCell(10000,$colspan);
		$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun->addText('OBSERVACIONES: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  	
		$textrun->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
		$cont=0;
		while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones))
		{				
			$textrun->addText($resObservaciones["observacion"], array('bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));	
			$cont++;
			if ($cont<mysql_num_rows($queryObservaciones))
			{
				$textrun->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));	
			}					
		}						
	}

  	$table->addRow();
    $table->addCell(10000,$colspanTitulo)->addText('OTRAS DILIGENCIAS ADELANTADAS',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0)); 


	$table->addRow();
    $cell = $table->addCell(10000,$colspan);
    $textrun = $cell->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText('REGISTRO DE LAS AUTORIDADES: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $consultarRegistroAutoridades="SELECT descripcion as descripcion_registro_autoridades FROM definicion_tipos WHERE id_tipo=35 and ";
    if ($resInformacionCaso["registro_autoridades"]=="S")
    {
    	$consultarRegistroAutoridades.=" id='2'";
    }
    else
    {
    	$consultarRegistroAutoridades.=" id='3'";
    }
    mysqli_next_result($con);
    $queryRegistroAutoridades=mysqli_query($con,$consultarRegistroAutoridades);
    $resRegistroAutoridades=mysqli_fetch_assoc($queryRegistroAutoridades);
    $textrun->addText($resRegistroAutoridades["descripcion_registro_autoridades"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

	$table->addRow();
  	$table->addCell(10000,$colspanTitulo)->addText('TESTIGOS',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0)); 
    if ($resInformacionCaso["visita_lugar_hechos"]=="S")
	{
 
  		$consultarTestigos="SELECT CONCAT(b.nombres,' ',b.apellidos) as nombre_testigo,concat(c.descripcion,' ',b.identificacion) as identificacion_testigo,b.telefono,b.direccion_residencia
  		FROM testigos a
  		LEFT JOIN personas b ON a.id_persona=b.id
  		LEFT JOIN definicion_tipos c ON c.id=b.tipo_identificacion
  		WHERE a.id_investigacion='".$resInformacionCaso["id_caso"]."' and c.id_tipo=5";
  		mysqli_next_result($con);
  		$queryTestigos=mysqli_query($con,$consultarTestigos);

  		if (mysqli_num_rows($queryTestigos)>0)
  		{
		
  			$table->addRow();
  			$table->addCell(10000,$colspan)->addText('Se indagó con los moradores del sector quienes confirman la real ocurrencia de los hechos, entre ellos:',$estiloNoBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0)); 

			while ($resTestigos=mysqli_fetch_assoc($queryTestigos))
  			{
  				$table->addRow();
				$cell = $table->addCell(5000);
				$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
				$textrun->addText('NOMBRE: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
				$textrun->addText($resTestigos["nombre_testigo"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
							
				$cell = $table->addCell(5000);
				$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
				$textrun->addText('IDENTIFICACION: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
				$textrun->addText($resTestigos["identificacion_testigo"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));

			    
			    $table->addRow();
			    $cell = $table->addCell(5000);
			    $textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			    $textrun->addText('TELEFONO: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			    $textrun->addText($resTestigos["telefono"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			    
			    $cell = $table->addCell(5000);
			    $textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			    $textrun->addText('DIRECCION: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			    $textrun->addText($resTestigos["direccion_residencia"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

  			}

  		}
  		else
  		{
    		


			$table->addRow();
  			$table->addCell(10000,$colspan)->addText('En el lugar de los hechos no se encontraron testigos, a pesar de la labor de campo realizada.',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0)); 
  		}
  
	}
	else
	{
		$table->addRow();
  		$table->addCell(10000,$colspan)->addText('No se aportan testigos ya que es una zona fuera del perímetro urbano autorizado.',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0)); 	
  
	}


    mysqli_next_result($con);
	$consultarObservacionesNuevas2=$consultarObservacionesInforme." AND id_seccion IN (10)";
	$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas2);

	if (mysqli_num_rows($queryObservaciones)>0)
	{
		$table->addRow();
		$cell = $table->addCell(10000,$colspan);
		$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun->addText('OBSERVACIONES: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
		$cont=0;
		while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones))
		{
			$textrun->addText($resObservaciones["observacion"], array('bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));	
			$cont++;
			if ($cont<mysqli_num_rows($queryObservaciones))
			{
				$textrun->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));	
			}
		}
	}


	$section->addTextBreak(2,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $table =$section->addTable('tableStyle');
    $PHPWord->addTableStyle('tableStyle',$tableStyle,$styleCell);
     
    $table->addRow();  
    $table->addCell(10000,$colspan)->addText('DILIGENCIAS ADELANTADAS',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));  

	$table->addRow();
	if ($resInformacionCaso["id_aseguradora"]==1)
	{
		$table->addCell(10000,$colspan)->addText('REGISTRO DOCUMENTAL DEL FURIPS/FURTRAN: FUENTE DE LA INFORMACION: FURIPS/FURTRAN/CENSO/OTROS',array('bold'=>true,'name'=>'Arial','size'=>9),array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	   	$table->addRow();
		$cell = $table->addCell(10000,$colspan);
	    $textrun = $cell->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	    $textrun->addText("Según registro del FURIPS/FURTRAN emitido por ",$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 	
	}
	else
	{
		$table->addCell(10000,$colspan)->addText('REGISTRO DOCUMENTAL DE LA HOJA DE INGRESO: FUENTE DE LA INFORMACION: HOJA DE INGRESO/CENSO/OTROS',array('bold'=>true,'name'=>'Arial','size'=>9),array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	   	$table->addRow();
		$cell = $table->addCell(10000,$colspan);
    	$textrun = $cell->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    	$textrun->addText("Según registro de la HOJA DE INGRESO emitido por ",$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 
	}
		
	$textrun->addText($resInformacionCaso["nombre_ips"]." ",$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 
	$textrun->addText($resInformacionCaso["furips"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 

	mysqli_next_result($con);
	$consultarObservacionesNuevas3=$consultarObservacionesInforme." AND id_seccion IN (1,2)";
	$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas3);

	if (mysqli_num_rows($queryObservaciones)>0)
	{
		$table->addRow();
		$cell = $table->addCell(10000,$colspan);
		$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun->addText('OBSERVACIONES: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
		$cont=0;
		while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones))
		{								
			$textrun->addText($resObservaciones["observacion"], array('bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));	
			$cont++;
			if ($cont<mysqli_num_rows($queryObservaciones))
			{
				$textrun->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));	
			}
		}
								
								
	}


	$table->addRow();
    $table->addCell(10000,$colspanTitulo)->addText('ENTREVISTA LESIONADO Y OTROS: Circunstancias de Modo, Tiempo y Lugar. ',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));  
		
	if ($resInformacionCaso["diligencia_formato_declaracion"]=="1")
	{
		$consultarInfoDiligencia="SELECT CONCAT(a.nombres,' ',a.apellidos) AS nombre_diligencia,
		concat(b.descripcion,' ',a.identificacion) as identificacion,'LESIONADO' as relacion
		FROM personas a 
		LEFT JOIN definicion_tipos b ON a.tipo_identificacion=b.id 
		WHERE b.id_tipo=5 AND a.id='".$resInformacionCaso["id_diligencia_formato_declaracion"]."'";
	}
	else if ($resInformacionCaso["diligencia_formato_declaracion"]=="3")
	{
				
		$consultarInfoDiligencia="SELECT CONCAT(a.nombres,' ',a.apellidos) AS nombre_diligencia,
		CONCAT(b.descripcion,' ',a.identificacion) AS identificacion, 'INVESTIGADOR' AS relacion
		FROM investigadores a 
		LEFT JOIN definicion_tipos b ON a.tipo_identificacion=b.id 	
		WHERE b.id_tipo=5 AND a.id='".$resInformacionCaso["id_diligencia_formato_declaracion"]."'";
		
	}
	else if ($resInformacionCaso["diligencia_formato_declaracion"]=="2")
	{

		$consultarInfoDiligencia="SELECT a.nombre AS nombre_diligencia,
		concat(b.descripcion,' ',a.identificacion) as identificacion,a.relacion
		FROM personas_diligencia_formato_declaracion a 
		LEFT JOIN definicion_tipos b ON a.tipo_identificacion=b.id  	
		WHERE b.id_tipo=5 AND a.id='".$resInformacionCaso["id_diligencia_formato_declaracion"]."'";
	}
	else 
	{
		$consultarInfoDiligencia="SELECT * FROM definicion_tipos WHERE id_tipo=36 and id='".$resInformacionCaso["diligencia_formato_declaracion"]."'";
	}

	mysqli_next_result($con);
	$queryDiligencia=mysqli_query($con,$consultarInfoDiligencia);
	$resDiligencia=mysqli_fetch_assoc($queryDiligencia);
	if ($resInformacionCaso["diligencia_formato_declaracion"]=="4" || $resInformacionCaso["diligencia_formato_declaracion"]=="5")
	{
		$table->addRow();		
    	$table->addCell(10000,$colspan)->addText("DILIGENCIA EL FORMATO DE DECLARACION: ",array('bold'=>true,'name'=>'Arial','size'=>9),array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	  	$table->addRow();
	  	$table->addCell(10000,$colspan)->addText($resInformacionCaso["observaciones_diligencia_tomador"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	
	}
	else
	{
		if ($resInformacionCaso["diligencia_formato_declaracion"]==1)
		{
			$consultarPersonaDiligencia="SELECT CONCAT(a.nombres,' ',a.apellidos) as nombre_diligencia_formato,CONCAT(b.descripcion,' ',a.identificacion) as identificacion_diligencia_formato,'LESIONADO' as relacion
			FROM personas a
			LEFT JOIN definicion_tipos b ON a.tipo_identificacion=b.id
			WHERE b.id_tipo=5 and a.id='".$resInformacionCaso["id_diligencia_formato_declaracion"]."'";
		}else if ($resInformacionCaso["diligencia_formato_declaracion"]==2)
		{
			$consultarPersonaDiligencia="SELECT a.nombre as nombre_diligencia_formato,CONCAT(b.descripcion,' ',a.identificacion) as identificacion_diligencia_formato,'ACOMPAÑANTE' as relacion
			FROM personas_diligencia_formato_declaracion a
			LEFT JOIN definicion_tipos b ON a.tipo_identificacion=b.id
			WHERE b.id_tipo=5 and a.id='".$resInformacionCaso["id_diligencia_formato_declaracion"]."'";
		}else if ($resInformacionCaso["diligencia_formato_declaracion"]==3)
		{
			$consultarPersonaDiligencia="SELECT  CONCAT(a.nombres,' ',a.apellidos) as nombre_diligencia_formato,CONCAT(b.descripcion,' ',a.identificacion) as identificacion_diligencia_formato,'INVESTIGADOR' as relacion
			FROM investigadores a
			LEFT JOIN definicion_tipos b ON a.tipo_identificacion=b.id
			WHERE b.id_tipo=5 and a.id='".$resInformacionCaso["id_diligencia_formato_declaracion"]."'";
		}
		mysqli_next_result($con);
		$queryConsultarPersonaDiligencia=mysqli_query($con,$consultarPersonaDiligencia);
		$resPersonaDiligencia=mysqli_fetch_assoc($queryConsultarPersonaDiligencia);
		$table->addRow();		
    	$table->addCell(5000)->addText("DILIGENCIA EL FORMATO DE DECLARACION: ",array('bold'=>true,'name'=>'Arial','size'=>9),array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	  	$table->addCell(5000)->addText($resPersonaDiligencia["nombre_diligencia_formato"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  

		$table->addRow();		
		$cell = $table->addCell(5000);
		$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    	$textrun->addText('IDENTIFICACION: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    	$textrun->addText($resPersonaDiligencia["identificacion_diligencia_formato"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  		

		$cell = $table->addCell(5000);
		$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    	$textrun->addText('RELACION CON LA VICTIMA: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    	$textrun->addText($resPersonaDiligencia["relacion"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
	}
		
	mysqli_next_result($con);
	$queryConsultarIndicadoresOcurrencia=mysqli_query($con,"SELECT * FROM definicion_tipos where id_tipo=37 and descripcion='".$resInformacionCaso["id_indicador_fraude"]."'");
	if (mysqli_num_rows($queryConsultarIndicadoresOcurrencia)>0)
	{
		$table->addRow();
		$table->addCell(10000,$colspanTitulo)->addText('LABOR REALIZADA:',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));  
		$table->addRow();
		$table->addCell(10000,$colspan)->addText($resInformacionCaso["relato"],$estiloNoBold,array('align'=> 'justify','spaceBefore'=>0,'spaceAfter'=>0));  
	}
	else
	{
		$table->addRow();
    	$table->addCell(10000,$colspanTitulo)->addText('RELATO DE LOS HECHOS:',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));  
    	$table->addRow();
		$table->addCell(10000,$colspan)->addText('"'.$resInformacionCaso["relato"].'"',$estiloNoBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
	}

	mysqli_next_result($con);
	$consultarObservacionesNuevas4=$consultarObservacionesInforme." AND id_seccion IN (20)";
	$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas4);
	if (mysqli_num_rows($queryObservaciones)>0)
	{
		$table->addRow();
		$cell = $table->addCell(10000,$colspan);
		$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun->addText('OBSERVACIONES: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
		$cont=0;
		while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones))
		{
			$textrun->addText($resObservaciones["descripcion"], array('bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));	
			$cont++;
			if ($cont<mysqli_num_rows($queryObservaciones))
			{
				$textrun->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));	
			}
		}
	}



			

	$section->addPageBreak();
    $table =$section->addTable('tableStyle');
    $PHPWord->addTableStyle('tableStyle',$tableStyle,$styleCell);
     
    $table->addRow();  
    $table->addCell(10000,$colspan)->addText('ANALISIS DE LA POLIZA',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));  

	$table->addRow();		
    $table->addCell(5000)->addText("POLIZA No. ",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText($resInformacionCaso["numero_poliza"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  

	$table->addRow();
    $table->addCell(10000,$colspanTitulo)->addText('VIGENCIA DE LA POLIZA',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));  

	$table->addRow();
	$cell = $table->addCell(5000);
	$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText('DESDE: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText($resInformacionCaso["inicio_vigencia"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  		

	$cell = $table->addCell(5000);
	$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText('HASTA: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText($resInformacionCaso["fin_vigencia"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));




	$table->addRow();
    $table->addCell(10000,$colspanTitulo)->addText('DATOS DEL TOMADOR',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));  
	
	$table->addRow();
	$cell = $table->addCell(5000);
	$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText('NOMBRE: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText($resInformacionCaso["nombre_tomador"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  		

	$cell = $table->addCell(5000);
	$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText('CEDULA: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText($resInformacionCaso["identificacion_tomador"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));

	$table->addRow();
	$cell = $table->addCell(5000);
	$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText('TELEFONO: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText($resInformacionCaso["telefono_tomador"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  		

	$cell = $table->addCell(5000);
	$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText('DIRECCION DEL TOMADOR: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText($resInformacionCaso["direccion_tomador"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));

	$table->addRow();
	$cell = $table->addCell(5000);
	$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText('CIUDAD RESIDENCIA TOMADOR: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText($resInformacionCaso["ciudad_tomador"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  		

	$cell = $table->addCell(5000);
	$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText('CIUDAD DE EXPEDICION: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText($resInformacionCaso["ciudad_expedicion_poliza"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));


	$table->addRow();
    $table->addCell(10000,$colspanTitulo)->addText('ENTREVISTA TOMADOR Y/O PROPIETARIO:',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));  



    
	if ($resInformacionCaso["resultado_diligencia_tomador"]<>4)
	{


		$table->addRow();
		$cell = $table->addCell(5000)->addText('RESULTADO: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
		mysqli_next_result($con);
		$consultarDescripcionDiligenciaTomador=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=38 and id='".$resInformacionCaso["resultado_diligencia_tomador"]."'");
		$resDescripcionDiligenciaTomador=mysqli_fetch_assoc($consultarDescripcionDiligenciaTomador);
		$cell = $table->addCell(5000)->addText($resDescripcionDiligenciaTomador["descripcion2"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
		

	
	}	
	else
	{


		$table->addRow();
		$cell = $table->addCell(10000,$colspan);
		$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun->addText('Expresa lo siguiente: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
		$textrun->addText($resInformacionCaso["observaciones_diligencia_tomador"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 

	

	}

	$table->addRow();  
    $table->addCell(10000,$colspanTitulo)->addText('INSPECCION TECNICA DEL VEHICULO',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));  
		
	$table->addRow();		
    $table->addCell(5000)->addText("PLACA:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText($resInformacionCaso["placa"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  





	$table->addRow();		
    $table->addCell(5000)->addText("MARCA:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText($resInformacionCaso["marca"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  

	$table->addRow();		
    $table->addCell(5000)->addText("TIPO DE VEHICULO:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText(strtoupper($resInformacionCaso["tipo_vehiculo"]),$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  


	$table->addRow();		
    $table->addCell(5000)->addText("LINEA:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText($resInformacionCaso["linea"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  


	$table->addRow();		
    $table->addCell(5000)->addText("COLOR:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText($resInformacionCaso["color"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0)); 


	$table->addRow();		
    $table->addCell(5000)->addText("MODELO:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText($resInformacionCaso["modelo"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0)); 


	$table->addRow();		
    $table->addCell(5000)->addText("NÚMERO DE VIN:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText($resInformacionCaso["numero_vin"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0)); 



	$table->addRow();		
    $table->addCell(5000)->addText("TIPO DE SERVICIO:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText($resInformacionCaso["tipo_servicio"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0)); 



	$table->addRow();		
    $table->addCell(5000)->addText("NÚMERO DE SERIE:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText($resInformacionCaso["numero_serie"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0)); 


	$table->addRow();		
    $table->addCell(5000)->addText("NÚMERO DE MOTOR:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText($resInformacionCaso["numero_motor"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0)); 


	$table->addRow();		
    $table->addCell(5000)->addText("NÚMERO DE CHASIS:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	$table->addCell(5000)->addText($resInformacionCaso["numero_chasis"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0)); 
	
	mysqli_next_result($con);
	$consultarObservacionesNuevas5=$consultarObservacionesInforme." AND id_seccion IN (12,11)";
	$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas5);
	if (mysqli_num_rows($queryObservaciones)>0)
	{
		$table->addRow();
		$cell = $table->addCell(10000,$colspan);
		$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun->addText('OBSERVACIONES: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
		$cont=0;
		while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones))
		{
			$cont++;
			$textrun->addText($resObservaciones["descripcion"], array('bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));	
			if ($cont<mysqli_num_rows($queryObservaciones))
			{
				$textrun->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));	
			}
		}
	}





		
	
	if ($cont3>0)
	{
		$section->addPageBreak();	
		$cont=0;$cont2=0;
		while ($resVariosLesionados=mysqli_fetch_assoc($verificarVariosLesionados))
		{
			if (($cont % 2 == 1) && $cont<$cont3 && $cont<>1)
			{
				$section->addPageBreak();	
			}
			$table =$section->addTable('tableStyle');
	    	$PHPWord->addTableStyle('tableStyle',$tableStyle,$styleCell);
			$table->addRow();
		    $table->addCell(10000,$colspanTitulo)->addText('ANALISIS DE LA VICTIMA '.($cont+2),$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));  
			$table->addRow();
			$cell = $table->addCell(1750);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('NOMBRE: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resVariosLesionados["nombre_lesionado"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			
			$cell = $table->addCell(1750);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('OCUPACION: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resVariosLesionados["ocupacion"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
						

			$table->addRow();
			$cell = $table->addCell(1750);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('IDENTIFICACION: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resVariosLesionados["identificacion_lesionado"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

			$cell = $table->addCell(1750);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('EDAD: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resVariosLesionados["edad"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

			$table->addRow();
			$cell = $table->addCell(10000,$colspan);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('DIRECCION DE RESIDENCIA: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resVariosLesionados["direccion"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  


			$table->addRow();
			$cell = $table->addCell(1750);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('CIUDAD/MUNICIPIO: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resVariosLesionados["ciudad_residencia"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

			$cell = $table->addCell(1750);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('BARRIO: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resVariosLesionados["barrio"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

			$table->addRow();
			$cell = $table->addCell(1750);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('TELEFONO: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resVariosLesionados["telefono"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

			$cell = $table->addCell(1750);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('CONDICION VICTIMA: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resVariosLesionados["condicion_lesionado"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 
					
			$table->addRow();
			$cell = $table->addCell(10000,$colspan);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('LESIONES: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resVariosLesionados["lesiones"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 

			$table->addRow();
			$cell = $table->addCell(10000,$colspan);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('TRATAMIENTO: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resVariosLesionados["tratamiento"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 

			$table->addRow();
			$table->addCell(5000)->addText("CLINICA DONDE FUE ATENDIDO:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
			$table->addCell(5000)->addText($resVariosLesionados["ips"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
				
			$table->addRow();
			$cell = $table->addCell(10000,$colspan);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('TRASLADO DE LA VICTIMA: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resVariosLesionados["traslado"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
				
			if ($resVariosLesionados["seguridad_social"]=="N")
			{
				$table->addRow();
				$table->addCell(5000)->addText("AFILIACION AL SISTEMA DE SEGURIDAD SOCIAL: ",array('bold'=>true,'name'=>'Arial','size'=>9),array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
				$table->addCell(5000)->addText("NO REGISTRA",$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
			}
			else if ($resVariosLesionados["seguridad_social"]=="I")
			{
				$afil_seguridad="";
				$afil_seguridad="NO SE PUDO CONSULTAR - ";
				if ($resVariosLesionados["causal_no_consulta"]==1)
				{
					$afil_seguridad=$afil_seguridad."PAGINA EN PROCESO DE ACTUALIZACION";
				}
				else if ($resVariosLesionados["causal_no_consulta"]==2)
				{
					$afil_seguridad=$afil_seguridad."IPS NO APORTA IDENTIFICACION";
				}
				$table->addRow();
				$table->addCell(5000)->addText("AFILIACION AL SISTEMA DE SEGURIDAD SOCIAL: ",array('bold'=>true,'name'=>'Arial','size'=>9),array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
				$table->addCell(5000)->addText($afil_seguridad,$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
			}
			else
			{
				$table->addRow();
				$table->addCell(5000)->addText("AFILIACION AL SISTEMA DE SEGURIDAD SOCIAL: ",array('bold'=>true,'name'=>'Arial','size'=>9),array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
				$table->addCell(5000)->addText("EPS: ".$resVariosLesionados["eps"]." - REGIMEN: ".$resVariosLesionados["regimen"]." - ESTADO: ".$resVariosLesionados["estado_seguridad_social"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  

			}
				$section->addTextBreak(2,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
				$cont++;
		}
	}



	$section->addPageBreak();	

	$table =$section->addTable('tableStyle');
    $PHPWord->addTableStyle('tableStyle',$tableStyle,$styleCell);


    $otrosIngresosPoliza=mysqli_query($con,"SELECT CONCAT(d.nombres,' ',d.apellidos) as nombre_lesionado,concat(e.descripcion,' ',d.identificacion) as identificacion_lesionado,f.nombre_ips,d.ocupacion,d.edad,d.direccion_residencia,concat(g.nombre,' - ',h.nombre) as ciudad,d.telefono,c.condicion,c.lesiones,c.tratamiento,f.nombre_ips,b.fecha_accidente,c.fecha_ingreso,c.fecha_egreso,a.codigo
    	FROM 
		investigaciones a
		LEFT JOIN detalle_investigaciones_soat b ON a.id=b.id_investigacion
		LEFT JOIN personas_investigaciones_soat c ON c.id_investigacion=a.id
		LEFT JOIN personas d ON d.id=c.id_persona
		LEFT JOIN definicion_tipos e ON e.id=d.tipo_identificacion
		LEFT JOIN ips f ON f.id=c.ips
		LEFT JOIN ciudades g ON g.id=d.ciudad_residencia
		LEFT JOIN departamentos h ON h.id=g.id_departamento
		WHERE e.id_tipo=5 and b.id_poliza='".$resInformacionCaso["id_poliza"]."' and a.id<>'".$resInformacionCaso["id_caso"]."'");

	if(mysqli_num_rows($otrosIngresosPoliza)>0)
	{
		while ($resIngresosPoliza=mysqli_fetch_assoc($otrosIngresosPoliza))
		{
			
			$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));     
			
   			$table =$section->addTable('tableStyle');
    		$PHPWord->addTableStyle('tableStyle',$tableStyle,$styleCell);
			$table->addRow();
			$table->addCell(10000,$colspanTitulo)->addText('HISTORIAL REGISTRO OTROS INGRESOS POLIZA No. '.$resIngresosPoliza["poliza"],$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));  
		
			$table->addRow();
			$cell = $table->addCell(5000);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('FECHA Y HORA DE ACCIDENTE: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resIngresosPoliza["fecha_accidente"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
				
			$cell = $table->addCell(5000);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('FECHA Y HORA DE INGRESO A LA CLINICA: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resIngresosPoliza["fecha_ingreso"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		
		
				
			$table->addRow();
			$table->addCell(5000)->addText("CLINICA DONDE FUE ATENDIDO:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
			$table->addCell(5000)->addText($resIngresosPoliza["nombre_ips"],$estiloNoBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));
					
				
			$table->addRow();
			$cell = $table->addCell(5000);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('CODIGO CASO: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resIngresosPoliza["consecutivo"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
				
			$cell = $table->addCell(5000);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('CONCEPTO: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resIngresosPoliza["concepto"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		
		
			$table->addRow();
			
			$cell = $table->addCell(10000,$colspan);
		
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('DIRECCION DE LOS HECHOS: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resIngresosPoliza["direccion"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 

			
		
			$table->addRow();
			$cell = $table->addCell(10000,$colspan);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('PUNTOS DE REFERENCIA: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resIngresosPoliza["punto_referencia"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  


			$table->addRow();
		  	$table->addCell(10000,$colspanTitulo)->addText('TESTIGOS',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0)); 
		    if ($resIngresosPoliza["visita_lugar_hechos"]=="S")
			{
		 
		  		$consultarTestigosOtrosIngresos="SELECT CONCAT(b.nombres,' ',b.apellidos) as nombre_testigo,concat(c.descripcion,' ',b.identificacion) as identificacion_testigo,b.telefono,b.direccion_residencia
		  		FROM testigos a
		  		LEFT JOIN personas b ON a.id_persona=b.id
		  		LEFT JOIN definicion_tipos c ON c.id=b.tipo_identificacion
		  		WHERE a.id_investigacion='".$resIngresosPoliza["id_caso"]."'";
		  		mysqli_next_result($con);
		  		$queryTestigosOtrosIngresos=mysqli_query($con,$consultarTestigosOtrosIngresos);

		  		if (mysql_num_rows($queryTestigosOtrosIngresos)>0)
		  		{

		  			
		  			$table->addRow();
		  			$table->addCell(10000,$estiloNoBold)->addText('Se indagó con los moradores del sector quienes confirman la real ocurrencia de los hechos, entre ellos:',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0)); 

		  			while ($resTestigosOtrosIngresos=mysqli_fetch_assoc($queryTestigosOtrosIngresos))
		  			{
		  				$table->addRow();
						$cell = $table->addCell(1750);
						$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
						$textrun->addText('NOMBRE: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
						$textrun->addText($resTestigos["nombre_testigo"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
									
						$cell = $table->addCell(1750);
						$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
						$textrun->addText('IDENTIFICACION: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
						$textrun->addText($resTestigosOtrosIngresos["identificacion_testigo"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));

					    
					    $table->addRow();
					    $cell = $table->addCell(1750);
					    $textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
					    $textrun->addText('TELEFONO: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
					    $textrun->addText($resTestigosOtrosIngresos["telefono"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
					    
					    $cell = $table->addCell(1750);
					    $textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
					    $textrun->addText('DIRECCION: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
					    $textrun->addText($resTestigosOtrosIngresos["direccion_residencia"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

		  			}
	    
		  		}
		  		else
		  		{
					
					$table->addRow();
					
		  			$table->addCell(10000,$colspan)->addText('En el lugar de los hechos no se encontraron testigos, a pesar de la labor de campo realizada.',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0)); 
		  		}
		  
			}
			else
			{
				$table->addRow();
		  		$table->addCell(10000,$estiloNoBold)->addText('No se aportan testigos ya que es una zona fuera del perímetro urbano autorizado.',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0)); 

				
		  
			}


			$table->addRow();
			$table->addCell(10000,$colspanTitulo)->addText('ANALISIS DE LA VICTIMA ',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));  
		
			$table->addRow();
			$cell = $table->addCell(1750);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('NOMBRE: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resIngresosPoliza["nombre_completo"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
				
			$cell = $table->addCell(1750);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('OCUPACION: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resIngresosPoliza["ocupacion"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
					

			$table->addRow();
			$cell = $table->addCell(1750);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('IDENTIFICACION: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resIngresosPoliza["identificacion"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

			$cell = $table->addCell(1750);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('EDAD: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resIngresosPoliza["edad"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  


			$table->addRow();
			$cell = $table->addCell(10000,$colspan);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('DIRECCION DE RESIDENCIA: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resIngresosPoliza["direccion"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  


			$table->addRow();
			$cell = $table->addCell(1750);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('CIUDAD/MUNICIPIO: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resIngresosPoliza["ciudad"]." - ".$resIngresosPoliza["departamento"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

			$cell = $table->addCell(1750);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('BARRIO: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resIngresosPoliza["barrio"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$table->addRow();
			$cell = $table->addCell(1750);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('TELEFONO: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resIngresosPoliza["telefono"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

			$cell = $table->addCell(1750);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('CONDICION VICTIMA: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resIngresosPoliza["condicion_lesionado"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 
				
				
			$table->addRow();
			$cell = $table->addCell(10000,$colspan);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('LESIONES: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resIngresosPoliza["lesiones"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 


			$table->addRow();

			$cell = $table->addCell(10000,$colspan);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('TRATAMIENTO: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resIngresosPoliza["tratamiento"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 
					
			$table->addRow();
	  		$table->addCell(10000,$colspanTitulo)->addText('ANALISIS DEL SINIESTRO',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));  
		
    
			$table->addRow();
      	  	$cell = $table->addCell(10000,$colspan);
			$textrun = $cell->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
					
		
			if ($resIngresosPoliza["id_aseguradora"]==1)
			{
					
				$textrun->addText("Según registro del FURIPS/FURTRAN emitido por ",$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 	
			}
			else
			{
					
				$textrun->addText("Según registro de la HOJA DE INGRESO emitido por ",$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 
			}
									
		
			$textrun->addText($resIngresosPoliza["clinica"]." ",$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 
			$textrun->addText($resIngresosPoliza["furips"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 
		
			$table->addRow();  
    		$table->addCell(10000,$colspanTitulo)->addText('INVESTIGADOR QUIEN VERIFICO EL CASO:',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));  

			$table->addRow();
			$cell = $table->addCell(5000);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('NOMBRE: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resIngresosPoliza["nombre_investigador"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  	


			$cell = $table->addCell(5000);
			$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText('IDENTIFICACION: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun->addText($resIngresosPoliza["identificacion_investigador"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  	



			$table->addRow();
			$table->addCell(5000)->addText("SUGERENCIA:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  

			$table->addCell(5000)->addText($resIngresosPoliza["concepto"],$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
					
			$section->addTextBreak(2,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));    
			
		}
					 
    }

    $section->addTextBreak(2,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));     

 	$table =$section->addTable('tableStyle');
    $PHPWord->addTableStyle('tableStyle',$tableStyle,$styleCell);
     
    $table->addRow();  
    $table->addCell(10000,$colspan)->addText('CONCLUSIONES:',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));  

	$table->addRow();
	$table->addCell(10000,$colspan)->addText($resInformacionCaso["conclusiones"],$estiloNoBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));  


	$table->addRow();  
    $table->addCell(10000,$colspanTitulo)->addText('INVESTIGADOR QUIEN VERIFICO EL CASO:',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));  

	$table->addRow();
	$cell = $table->addCell(5000);
	$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText('NOMBRE: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText($resInformacionInvestigador["nombre_investigador"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  	

    $cell = $table->addCell(5000);
	$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText('IDENTIFICACION: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addText($resInformacionInvestigador["identificacion_investigador"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  	
		


	$table->addRow();
	$table->addCell(5000)->addText("SUGERENCIA:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
		
	$table->addCell(5000)->addText($resResultado["resultado"],$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
		
	$section->addTextBreak(2,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$section->addText("Cordialmente,",$estiloNoBold,array('align'=> 'justify','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$section->addImage( '../firma.png',array('width' => 100,'height' => 100,'wrappingStyle' => 'behind','align'=>'left','marginLeft'=>0,'lineHeight'=>1));  
	$section->addText("JOSÉ M QUIJANO RODRIGUEZ",$estiloBold,array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$section->addText("GERENTE",$estiloBold,array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));


	$section->addTextBreak(2,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

	$table =$section->addTable('tableStyle');
	$PHPWord->addTableStyle('tableStyle',$tableStyle,$styleCell);
	$table->addRow();
	$table->addCell(10000,$colspan)->addText('FICHA TÉCNICA ANEXOS',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));  
		
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


	if ($cantidadImagenesPoliza>0)
	{
		$table->addRow();
		$table->addCell(10000,$colspan)->addText("ANEXO TÉCNICO N° 1 PÓLIZA NO. ".$resInformacionCaso["numero_poliza"],$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	}

	mysqli_next_result($con);
	$consultarImagenesTarjetaPropiedad=mysqli_query($con,"SELECT * FROM multimedia_investigacion WHERE id_multimedia='13' and id_investigacion='".$id_caso."' ORDER by id asc");
	$cantidadImagenesTarjetaPropiedad=mysqli_num_rows($consultarImagenesTarjetaPropiedad);

	if ($cantidadImagenesTarjetaPropiedad>0)
	{
		$table->addRow();
		$table->addCell(10000,$colspan)->addText("ANEXO TÉCNICO N° 2 TARJETA DE PROPIEDAD ",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	}
		
	if ($cantidadImagenesLesionados>0)
	{
		$table->addRow();
		$table->addCell(10000,$colspan)->addText("FOTOGRAFÍAS LESIONES",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	}


	if ($cantidadImagenesPunto>0)
	{
		$table->addRow();
		$table->addCell(10000,$colspan)->addText("PUNTOS DE REFERENCIA LUGAR DE LOS HECHOS",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	}

		
	if ($cantidadImagenesInspeccion>0)
	{
		$table->addRow();
		$table->addCell(10000,$colspan)->addText("INSPECCIÓN  TÉCNICA DEL VEHÍCULO",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	}

	if ($cantidadImagenesRegistroTelefonico>0)
	{
		$table->addRow();
		$table->addCell(10000,$colspan)->addText("REGISTRO TELEFONICO",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	}


	if ($cantidadImagenesRunt>0)
	{
		$table->addRow();
		$table->addCell(10000,$colspan)->addText("REGISTRO RUNT",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	}
			
	if ($cantidadImagenesSeguridadSocial>0)
	{
		$table->addRow();
		$table->addCell(10000,$colspan)->addText("AFILIACIÓN AL SISTEMA DE SEGURIDAD SOCIAL",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	}


	if ($cantidadImagenesForm>0)
	{
		$table->addRow();
		$table->addCell(10000,$colspan)->addText("ANEXO DECLARACIÓN ESCANEADA",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
	}


	$cont=0;
	if ($cantidadImagenesPoliza>0)
	{
		$section->addPageBreak();
		$section->addText("ANEXO TECNICO N° 1: POLIZA No. ".$resInformacionCaso["numero_poliza"],$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));
		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		while ($resImagenesPoliza=mysqli_fetch_assoc($consultarImagenesPoliza))
		{
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
		while ($resImagenesLesionados=mysqli_fetch_assoc($consultarImagenesLesionados))
		{
			$arrayImagenes[$cont]=$resImagenesLesionados["ruta"];
			$cont++;
		}  

		if (count($arrayImagenes)==1)
		{
			$section->addTextBreak(4,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
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
	if ($cantidadImagenesPunto>0)
	{
		$section->addPageBreak();
		$section->addText("PUNTOS DE REFERENCIA LUGAR DE LOS HECHOS:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));
		while ($resImagenesPunto=mysqli_fetch_assoc($consultarImagenesPunto))
		{

			$arrayImagenes[$cont]=$resImagenesPunto["ruta"];
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
	
		while ($resImagenesInspeeccion=mysql_fetch_array($consultarImagenesInspeccion))
		{
			$arrayImagenes[$cont]=$resImagenesInspeeccion[ruta];
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
			$textrun->addImage("../..".$arrayImagenes[0],  array(
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
					$textrun->addImage("../..".$arrayImagenes[$i],  array(
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
			$resDetalleImagenInspeccion=mysql_fetch_assoc($queryObservaciones);
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
		
		while ($resImagenesRegistroTelefonico=mysql_fetch_array($consultarImagenesRegistroTelefonico))
		{
			$arrayImagenes[$cont]=$resImagenesRegistroTelefonico[ruta];
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
		
		while ($resImagenesLugarResidencia=mysql_fetch_array($consultarImagenesLugarResidencia))
		{
			$arrayImagenes[$cont]=$resImagenesLugarResidencia[ruta];
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
			$textrun->addImage("../..".$arrayImagenes[0],  array(
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
	  		$section->addImage($resRunt[ruta],array('width' => 500,'height' => 400,'wrappingStyle' => 'behind','align'=>'center','marginLeft'=>0));  
		}
	   
	}


	unset($arrayImagenes);
	$cont=0;
	if ($cantidadImagenesForm>0)
	{
					
		while ($resImagenesForm=mysqli_fetch_assoc($consultarImagenesForm))
		{
			$section->addPageBreak();
			$section->addText("FOTOS FORMULARIO:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));
			$section->addImage($resImagenesForm[ruta],array('width' => 600,'height' => 650,'wrappingStyle' => 'behind','align'=>'center','marginLeft'=>0));  
			
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
	$nombre="INFORME ".$resInformacionCaso["nombre_lesionado"]." POLIZA No. ".$resInformacionCaso["numero_poliza"];
	$objWriter->save('Informe.docx');
	header('Content-Disposition: attachment; filename="'.$nombre.'.docx"');
	echo file_get_contents('Informe.docx');
?>