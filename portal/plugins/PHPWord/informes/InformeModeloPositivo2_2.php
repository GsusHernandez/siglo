<?php 
	ini_set('display_errors', 0);
	error_reporting(E_ERROR | E_WARNING | E_PARSE); 
	include('../../../conexion/conexion.php');
	global $con;
	$id_caso=$_GET["idInv"];$result='si';
	if(isset($_GET["result"])){ $result = $_GET["result"]; }
	mysqli_query($con,"SET SQL_BIG_SELECTS=1");
	require_once '../PHPWord-master/src/PhpWord/Autoloader.php';
	\PhpOffice\PhpWord\Autoloader::register();

	use PhpOffice\PhpWord\PhpWord;
	use PhpOffice\PhpWord\Style\Font;

	$PHPWord = new PhpWord();
	$section = $PHPWord->createSection();

	$estiloBold= array('bold'=>true,'name'=>'Arial','size'=>11);
	$estiloNoBold= array('bold'=>false,'name'=>'Arial','size'=>11);
	//crear ENCABEZADO CON IMAGEN
	$header = $section->createHeader();
	$header->addImage( '../logo2.png',array('width' => 600,'height' => 180,'wrappingStyle' => 'behind'));
	//TERMINA ENCABEZADO
	//crear PIE DE PAGINA
	$estiloFuenteFooter=array('bold'=>true,'size'=>8,'name'=>'Arial');
	$estiloParrafoFooter=array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0);
	$footer = $section->createFooter();
	$footer->addText("Global Red  LTDA “Investigaciones Sin Fronteras”",$estiloFuenteFooter ,$estiloParrafoFooter);
	$footer->addText("CALLE 70 NO. 52 - 54 - Centro Comercial Gran Centro Local 1-115", $estiloFuenteFooter ,$estiloParrafoFooter);
	$footer->addText("BARRANQUILLA - ATLANTICO", $estiloFuenteFooter ,$estiloParrafoFooter);
	$footer->addText("TEL: 3563397 - CEL: 3103229337", $estiloFuenteFooter ,$estiloParrafoFooter);
	$footer->addText("e-mail: josemquijano@globalredltda.co.", $estiloFuenteFooter ,$estiloParrafoFooter);
	$footer->addText("www.globalredltda.co",$estiloFuenteFooter ,$estiloParrafoFooter);
	//TERMINA PIE DE PAGINA
	//INTRODUCCION DOCUMENTO
	$consultarInformacionCaso="SELECT a.codigo,
	a.id AS id_caso,
	CONCAT(d.nombres,' ',d.apellidos) AS nombre_lesionado,
	CONCAT(e.descripcion,' ',d.identificacion) AS identificacion_lesionado,
	f.nombre_ips,
	
	c.resultado,
	CONCAT(UPPER(LEFT(h.nombre, 1)), LOWER(SUBSTRING(h.nombre, 2))) AS departamento_ips,
	CONCAT(UPPER(LEFT(g.nombre, 1)), LOWER(SUBSTRING(g.nombre, 2))) AS ciudad_ips,
	m.responsable,
	m.nombre_aseguradora as aseguradora,
	b.fecha_accidente,
	c.fecha_ingreso,
	DATE_FORMAT('%Y-%m-%d',c.fecha_ingreso) AS fecha_ingreso2,
	DATE_FORMAT('%Y-%m-%d',b.fecha_accidente) AS fecha_accidente3,
	c.fecha_egreso,
	q.descripcion AS indicador_fraude,
	m.id AS id_aseguradora,
	c.indicador_fraude AS id_indicador_fraude,
	CASE 
	WHEN m.cargo IS NULL THEN 'N' ELSE m.cargo END AS cargo,
	d.ocupacion,
	d.edad,
	d.direccion_residencia,
	CONCAT(CONCAT(UPPER(LEFT(n.nombre, 1)), LOWER(SUBSTRING(n.nombre, 2))),' - ', 
	CONCAT(UPPER(LEFT(o.nombre, 1)), LOWER(SUBSTRING(o.nombre, 2)))) AS ciudad_residencia,
	d.barrio,
	d.telefono,d.sexo,e.descripcion2 AS tipo_identificacion_lesionado,d.identificacion AS no_identificacion_lesionado,
	c.condicion,
	c.servicio_ambulancia,
	c.tipo_traslado_ambulancia,b.consulta_runt,b.causal_runt,
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
	b.id_diligencia_formato_declaracion,b.observacion_diligencia_formato_declaracion,b.inspeccion_tecnica,
	b.furips,
	CONCAT(zb.nombre,' - ',zc.nombre) AS ciudad_ocurrencia,
	b.resultado_diligencia_tomador,
	b.observaciones_diligencia_tomador,
	CONCAT(DAY(b.fecha_diligencia_formato_declaracion), ' de ',CASE  WHEN MONTH(b.fecha_diligencia_formato_declaracion)='01' THEN  'Enero' WHEN MONTH(b.fecha_diligencia_formato_declaracion)='02' THEN  'Febrero' WHEN MONTH(b.fecha_diligencia_formato_declaracion)='03' THEN  'Marzo' WHEN MONTH(b.fecha_diligencia_formato_declaracion)='04' THEN  'Abril' WHEN MONTH(b.fecha_diligencia_formato_declaracion)='05' THEN  'Mayo' WHEN MONTH(b.fecha_diligencia_formato_declaracion)='06' THEN  'Junio' WHEN MONTH(b.fecha_diligencia_formato_declaracion)='07' THEN  'Julio' WHEN MONTH(b.fecha_diligencia_formato_declaracion)='08' THEN  'Agosto' WHEN MONTH(b.fecha_diligencia_formato_declaracion)='09' THEN  'Septiembre' WHEN MONTH(b.fecha_diligencia_formato_declaracion)='10' THEN  'Octubre' WHEN MONTH(b.fecha_diligencia_formato_declaracion)='11' THEN  'Noviembre' WHEN MONTH(b.fecha_diligencia_formato_declaracion)='12' THEN  'Diciembre' END,' de ',YEAR(b.fecha_diligencia_formato_declaracion)) AS fecha_diligencia_formato_declaracion,
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
	LEFT JOIN aseguradoras m ON m.id=a.id_aseguradora
	LEFT JOIN ciudades n ON n.id=d.ciudad_residencia
	LEFT JOIN departamentos o ON o.id=n.id_departamento
	LEFT JOIN definicion_tipos q ON q.id=c.indicador_fraude
	LEFT JOIN definicion_tipos r ON r.id=c.seguridad_social
	LEFT JOIN ciudades zb ON zb.id=b.ciudad_ocurrencia
	LEFT JOIN departamentos zc ON zc.id=zb.id_departamento
	WHERE  e.id_tipo=5  AND q.id_tipo=12 AND r.id_tipo=17  AND c.tipo_persona=1  AND a.id='".$id_caso."'";

	mysqli_next_result($con);
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
		WHERE e.id_tipo=5 and b.id_poliza='".$resInformacionCaso["id_poliza"]."' and a.id<>'".$id_caso."'");

	mysqli_next_result($con);
	$consultarInformacionVehiculo="SELECT 
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
	j.numero AS numero_poliza,
	j.inicio_vigencia,
	j.fin_vigencia,
	l.descripcion AS tipo_vehiculo,
	j.nombre_tomador,j.id AS id_poliza,
	CONCAT(s.descripcion,' ',j.identificacion_tomador) AS identificacion_tomador,
	s.descripcion2 AS tipo_identificacion_tomador,j.identificacion_tomador AS no_identificacion_ltomador,
	j.telefono_tomador,
	j.direccion_tomador,
	CONCAT(u.nombre,' - ',t.nombre) AS ciudad_tomador,
	CONCAT(v.nombre,' - ',w.nombre) AS ciudad_expedicion_poliza
	from polizas j 
	LEFT JOIN vehiculos k ON k.id=j.id_vehiculo
	LEFT JOIN tipo_vehiculos l ON l.id=k.tipo_vehiculo
	LEFT JOIN definicion_tipos p ON p.id=k.tipo_servicio
	LEFT JOIN definicion_tipos s ON s.id=j.tipo_identificacion_tomador
	LEFT JOIN ciudades t ON t.id=j.ciudad_tomador
	LEFT JOIN departamentos u ON u.id=t.id_departamento
	LEFT JOIN ciudades v ON v.id=j.ciudad_expedicion
	LEFT JOIN departamentos w ON w.id=v.id_departamento
	LEFT JOIN detalle_investigaciones_soat z ON z.id_poliza=j.id
	WHERE p.id_tipo=21 
	AND s.id_tipo=5 AND z.id_investigacion='".$id_caso."'";
	$queryInformacionVehiculo=mysqli_query($con,$consultarInformacionVehiculo);
	$resInformacionVehiculo=mysqli_fetch_assoc($queryInformacionVehiculo);


 	$consultarLesionados="SELECT 
	CONCAT(b.nombres,' ',b.apellidos) AS nombre_lesionado,
	CONCAT(c.descripcion,' ',b.identificacion) AS identificacion_lesionado, b.sexo,
	c.descripcion2 AS tipo_identificacion_lesionado, b.identificacion AS no_identificacion_lesionado,CASE
	WHEN a.lugar_traslado IS NULL THEN 'N' 
	ELSE a.lugar_traslado END AS lugar_traslado,a.condicion,
	b.direccion_residencia, b.telefono, h.nombre_ips,b.edad,b.ocupacion, a.lesiones, a.tratamiento,
	i.descripcion2 AS seguridad_social,
	a.seguridad_social AS id_seguridad_social,
	a.eps,
	a.regimen,
	a.estado AS estado_eps,
	a.causal_consulta
	FROM  personas_investigaciones_soat a 
	LEFT JOIN personas b ON a.id_persona=b.id
	LEFT JOIN definicion_tipos c ON c.id=b.tipo_identificacion AND c.id_tipo = 5
	LEFT JOIN definicion_tipos d ON d.id=a.regimen AND d.id_tipo = 18
	LEFT JOIN definicion_tipos e ON e.id=a.estado AND e.id_tipo = 23
	LEFT JOIN ciudades f ON f.id=b.ciudad_residencia
	LEFT JOIN departamentos g ON g.id=f.id_departamento
	LEFT JOIN ips h ON h.id=a.ips
	LEFT JOIN definicion_tipos i ON i.id=a.seguridad_social
	WHERE a.tipo_persona=2 AND i.id_tipo=17 AND a.id_investigacion='".$id_caso."'";
	mysqli_next_result($con);
	$verificarVariosLesionados=mysqli_query($con,$consultarLesionados);
	$cont3=mysqli_num_rows($verificarVariosLesionados);

	$consultarObservacionesInforme="SELECT * FROM observaciones_secciones_informe WHERE id_investigacion='".$id_caso."'";
	mysqli_next_result($con);
	$queryInformacionCaso=mysqli_query($con,$consultarInformacionCaso);
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
	
	$queryResultado=mysqli_query($con,$consultarResultado);
	
	$resResultado=mysqli_fetch_assoc($queryResultado);


	$section->addText("No. Caso: ".$resInformacionCaso['codigo'],array('color'=>'red','bold'=>true,'name'=>'Arial','size'=>12),array('align'=>'right','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
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
	$section->addText("Respetados señores:",$estiloNoBold,array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  



	$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$textrun->addText('Por medio del presente nos permitimos informar el resultado final de la investigación de ',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$textrun->addText("ACCIDENTE DE TRANSITO",$estiloBold);
	$textrun->addText(' realizada ',$estiloNoBold);

	if($resInformacionCaso["sexo"] == 1){
	
		if ($resInformacionCaso["edad"]<18) {
			$textrun->addText('al menor ',$estiloNoBold);
		}else if($resInformacionCaso["edad"] >= 18 && $resInformacionCaso["edad"] <= 26){
			$textrun->addText('al joven ',$estiloNoBold);		
		}else{
			$textrun->addText('al señor ',$estiloNoBold);		
		}
	} elseif($resInformacionCaso["sexo"] == 2){
		
		if ($resInformacionCaso["edad"]<18) {
			$textrun->addText('a la menor ',$estiloNoBold);
		}else if($resInformacionCaso["edad"] >= 18 && $resInformacionCaso["edad"] <= 26){
			$textrun->addText('a la joven ',$estiloNoBold);	
		}else{
			$textrun->addText('a la señora ',$estiloNoBold);		
		}
	}

	$textrun->addText($resInformacionCaso["nombre_lesionado"], $estiloBold, array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	
	if ($resInformacionCaso["sexo"]=="2"){
		$textrun->addText(', identificada con ',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	}else {
  		$textrun->addText(', identificado con ',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	}

	$textrun->addText($resInformacionCaso["tipo_identificacion_lesionado"]." No. ",$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$textrun->addText($resInformacionCaso["no_identificacion_lesionado"], $estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 
  
  	$arrayVariosLesionados = array();
	if ($cont3==1){
		
		while ($resVariosLesionados=mysqli_fetch_assoc($verificarVariosLesionados)){

			$arrayVariosLesionados[] = $resVariosLesionados;

			$textrun->addText(', y ',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			
			if($resVariosLesionados["sexo"] == 1){
	
				if ($resVariosLesionados["edad"]<18) {
					$textrun->addText(' al menor ',$estiloNoBold);
				}else if($resVariosLesionados["edad"] >= 18 && $resVariosLesionados["edad"] <= 26){
					$textrun->addText(' al joven ',$estiloNoBold);		
				}else{
					$textrun->addText(' al señor ',$estiloNoBold);		
				}
			} elseif($resVariosLesionados["sexo"] == 2){
				
				if ($resVariosLesionados["edad"]<18) {
					$textrun->addText(' a la menor ',$estiloNoBold);
				}else if($resVariosLesionados["edad"] >= 18 && $resVariosLesionados["edad"] <= 26){
					$textrun->addText(' a la joven ',$estiloNoBold);	
				}else{
					$textrun->addText(' a la señora ',$estiloNoBold);		
				}
			}
			
			$textrun->addText($resVariosLesionados["nombre_lesionado"],$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			
			if ($resVariosLesionados["sexo"]=="2"){
				$textrun->addText(', identificada con ',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			}
			else{
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
  //FIN VARIOS LESIONADOS
  
	$textrun->addText($resInformacionCaso["fecha_accidente2"], $estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));

  	if ($cont3==1) {
     	$textrun->addText(' y recibieron atención médica en la IPS ',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
   	}
   	else {
     	$textrun->addText(' y recibió atención médica en la IPS ',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
   	}


	$textrun->addText($resInformacionCaso["nombre_ips"], $estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 

   	if ($resInformacionCaso["fecha_ingreso3"]==$resInformacionCaso["fecha_accidente2"]) {
		$textrun->addText(' el mismo día',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
  	}
	else {

    	$textrun->addText(' el  día ',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
  		$textrun->addText($resInformacionCaso["fecha_ingreso3"], $estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
  	}

  	$textrun->addText(', pretendiendo afectar la Póliza de Seguro Obligatorio de Accidentes de Tránsito SOAT N° ',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$textrun->addText($resInformacionVehiculo["numero_poliza"], $estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$textrun->addText(' del vehículo tipo ',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$textrun->addText(strtoupper($resInformacionVehiculo["tipo_vehiculo"]), $estiloBold);
	$textrun->addText(' con placas ',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$textrun->addText($resInformacionVehiculo["placa"], $estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

	$textrun->addText(' en condición de ' ,$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

	$textrun->addText($resInformacionCaso["condicion"],$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));

	if ($cont3==1){

		if($arrayVariosLesionados[0]["condicion"] != ''){
			$condicionVariosLesionados = ' y '.$arrayVariosLesionados[0]["condicion"].',';
		}else{
			$condicionVariosLesionados = ' y NO REGISTRA CONDICIÓN 2,';
		}

		$textrun->addText($condicionVariosLesionados,$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
   	} 

   	$textrun->addText(' por lo cual se cursa reclamación de Gastos Médicos.',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));

   	$textoRadicados = "";//texto de radicados para Análisi del siniestro
	//if($resInformacionCaso["tipo_caso"] == 2 || $resInformacionCaso["tipo_caso"] == 4){//CA y GA

   		mysqli_next_result($con);
      	$consultarRadicados=mysqli_query($con,"SELECT identificador FROM id_casos_aseguradora WHERE id_investigacion = ".$resInformacionCaso["id_caso"]);
      	$primerRadicado = "";
      	if (mysqli_num_rows($consultarRadicados)>0) {
      		while ($resRadicados=mysqli_fetch_assoc($consultarRadicados)) {
      			if($primerRadicado == ''){
      				$primerRadicado = $resRadicados["identificador"];
      			}
      			$textoRadicados .= $resRadicados["identificador"].", ";
      		}
      		$textoRadicados = substr($textoRadicados,0,-1);
	   	}
	//}

   	//if(($resInformacionCaso["tipo_caso"] == 2 || $resInformacionCaso["tipo_caso"] == 4) && $textoRadicados != ''){//CA y GA
   	if($textoRadicados != ''){
   		$textrun->addText(' bajo los radicados ' ,$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 
   		$textrun->addText($textoRadicados,$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
   	}
   	if($result != 'no'){
	   	$textrun->addText(' concluimos que después de adelantar todo el protocolo investigativo su resultado es: ',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
		$textrun->addText($resResultado["resultado"], $estiloBold); 
	}    

	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$section->addText("Para un análisis más detallado del caso, anexo al presente envío, informe de todas las gestiones adelantadas en el asunto de la referencia.",$estiloNoBold,array('align'=> 'justify','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$section->addText("Con un cordial saludo, y dando respuesta a su requerimiento me suscribo,",$estiloNoBold,array('align'=> 'justify','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$section->addText("Cordialmente,",$estiloNoBold,array('align'=> 'justify','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$section->addImage( '../firmas/firma_representante.jpeg',array('width' => 100,'height' => 100,'wrappingStyle' => 'behind','align'=>'left','marginLeft'=>0,'lineHeight'=>1));  
	$section->addText("HERNANDO ARTURO QUIJANO RUIZ",$estiloBold,array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$section->addText("REPRESENTANTE LEGAL",$estiloBold,array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  


	//SEGUNDA PAGINA
	mysqli_next_result($con);
	$consultarImagenesPoliza=mysqli_query($con,"SELECT * FROM multimedia_investigacion WHERE id_multimedia='12' and id_investigacion='".$id_caso."' ORDER by id asc");
	$cantidadImagenesPoliza=mysqli_num_rows($consultarImagenesPoliza);


	mysqli_next_result($con);
	$consultarImagenesTarjetaPropiedad=mysqli_query($con,"SELECT * FROM multimedia_investigacion WHERE id_multimedia='13' and id_investigacion='".$id_caso."' ORDER by id asc");
	$cantidadImagenesTarjetaPropiedad=mysqli_num_rows($consultarImagenesTarjetaPropiedad);

	if ($cantidadImagenesTarjetaPropiedad>0 || $cantidadImagenesPoliza>0) {
		$section->addPageBreak();
		$cont=0;
		if ($cantidadImagenesPoliza>0) {
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
		
		$section->addTextBreak(2);
		unset($arrayImagenes);
		$cont=0;
		if ($cantidadImagenesTarjetaPropiedad>0) {
			
			$section->addText("ANEXO TÉCNICO N° 2 TARJETA DE PROPIEDAD",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));
			$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			while ($resImagenesTarjetaPropiedad=mysqli_fetch_assoc($consultarImagenesTarjetaPropiedad))
			{
				$resImagenesTarjetaPropiedad["ruta"] = str_replace('https://globalredltda.co/siglo/portal/data', '../../../data', $resImagenesTarjetaPropiedad["ruta"]);
				$arrayImagenes[$cont]=$resImagenesTarjetaPropiedad["ruta"];
				$cont++;
			}  


			if (count($arrayImagenes)==1) {
				$section->addImage($arrayImagenes["0"],array('width' => 580,'height' => 250,'wrappingStyle' => 'behind','align'=>'center','marginLeft'=>0));
			}
			else if (count($arrayImagenes)==2) {
				$table = $section->addTable(array('width' => '5000', 'unit' => 'pct'));
				$table->addRow();
				$table->addCell(2000)->addImage($arrayImagenes["0"],array('width' => 290,'height' => 250,'align'=>'left')); // image1 with needed styles
				$table->addCell(2000)->addImage($arrayImagenes["1"],array('width' => 290,'height' => 250,'align'=>'right')); // image2 with needed styles 
			}
		}
	}
	else {
		$section->addPageBreak();
		$section->addText("ANEXO TECNICO N° 1: POLIZA No.". $resInformacionCaso["poliza"],$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));
  		$section->addTextBreak(20,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$section->addText("ANEXO TECNICO N° 2 TARJETA DE PROPIEDAD",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));
		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	}




	//TERCERA PAGINA
  	$section->addPageBreak();
  	$section->addText("DILIGENCIAS ADELANTADAS",$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

	if ($resInformacionCaso["furips"]!="N") {

		$section->addText("1. REGISTRO DOCUMENTAL DE LA HOJA DE INGRESO:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$section->addText("FUENTE DE LA INFORMACION: HOJA DE INGRESO/ CENSO/ OTROS:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun->addText("Según registro de la ", $estiloNoBold);
		$textrun->addText("HOJA DE INGRESO  ", $estiloBold);
		$textrun->addText("emitido por ", $estiloNoBold);

		$textrun->addText($resInformacionCaso["nombre_ips"].", ", $estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun->addText($resInformacionCaso["furips"], $estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	}


	$section->addText("2. ENTREVISTA LESIONADO Y OTROS:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));
	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$section->addText("2.1.	Circunstancias de Modo, Tiempo y Lugar. ",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));
	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  


	$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));  
	$textrun->addText('En el proceso materia de investigación figura como víctima ',$estiloNoBold);

	if($resInformacionCaso["sexo"] == 1){
	
		if ($resInformacionCaso["edad"]<18) {
			$textrun->addText('el menor ',$estiloNoBold);
		}else if($resInformacionCaso["edad"] >= 18 && $resInformacionCaso["edad"] <= 26){
			$textrun->addText('el joven ',$estiloNoBold);		
		}else{
			$textrun->addText('el señor ',$estiloNoBold);		
		}
	} elseif($resInformacionCaso["sexo"] == 2){
		
		if ($resInformacionCaso["edad"]<18) {
			$textrun->addText('la menor ',$estiloNoBold);
		}else if($resInformacionCaso["edad"] >= 18 && $resInformacionCaso["edad"] <= 26){
			$textrun->addText('la joven ',$estiloNoBold);	
		}else{
			$textrun->addText('la señora ',$estiloNoBold);		
		}
	}

	$textrun->addText($resInformacionCaso["nombre_lesionado"], $estiloBold, array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	if ($resInformacionCaso["sexo"]=="2"){
		$textrun->addText(', identificada con ',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	}else {
  		$textrun->addText(', identificado con ',$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	}

	$textrun->addText($resInformacionCaso["tipo_identificacion_lesionado"]." No. ",$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$textrun->addText($resInformacionCaso["no_identificacion_lesionado"], $estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 

	$textrun->addText(' de '.$resInformacionCaso["edad"].' años de edad, residente en '.$resInformacionCaso["direccion_residencia"].', '.$resInformacionCaso["ciudad_residencia"].', con Teléfono: '.$resInformacionCaso["telefono"],$estiloNoBold);
	
	if ($resInformacionCaso["diligencia_formato_declaracion"]==1) {
		//lesionado
		$consultarInfoDiligencia="SELECT CONCAT(a.nombres,' ',a.apellidos) AS nombre_diligencia, CONCAT(LCASE(b.descripcion2),' No. ',a.identificacion) AS identificacion,a.sexo,a.edad FROM personas a LEFT JOIN definicion_tipos b ON a.tipo_identificacion=b.id WHERE b.id_tipo=5 AND a.id='".$resInformacionCaso["id_diligencia_formato_declaracion"]."'";
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
				$textrun->addText('la joven ',$estiloNoBold);		
			}else{
				$textrun->addText('el señor ',$estiloNoBold);		
			}

			$textrun->addText($resInfoDiligencia["nombre_diligencia"],$estiloBold);
			$textrun->addText(', identificado con ',$estiloNoBold);
		} elseif($resInfoDiligencia["sexo"] == 2){
			
			if ($resInfoDiligencia["edad"]<18) {
				$textrun->addText('la menor ',$estiloNoBold);
			}else if($resInfoDiligencia["edad"] >= 18 && $resInfoDiligencia["edad"] <= 26){
				$textrun->addText('la joven ',$estiloNoBold);	
			}else{
				$textrun->addText('la señora ',$estiloNoBold);		
			}

			$textrun->addText($resInfoDiligencia["nombre_diligencia"],$estiloBold);
			$textrun->addText(', identificada con ',$estiloNoBold);
		}

		$textrun->addText($resInfoDiligencia["identificacion"],$estiloBold);
		$textrun->addText(', quien figura dentro del proceso investigativo como uno de los lesionados, en entrevista realizada el día '.$resInformacionCaso["fecha_diligencia_formato_declaracion"].', manifiesta lo siguiente:',$estiloNoBold);
	}
	else if ($resInformacionCaso["diligencia_formato_declaracion"]==2)	{
		//acompañante
		$consultarInfoDiligencia="SELECT a.nombre AS nombre_diligencia,	CONCAT(LCASE(b.descripcion2),' No. ',a.identificacion) AS identificacion, a.relacion FROM personas_diligencia_formato_declaracion a LEFT JOIN definicion_tipos b ON a.tipo_identificacion=b.id WHERE b.id_tipo=5 AND a.id='".$resInformacionCaso["id_diligencia_formato_declaracion"]."'";
		mysqli_next_result($con);
		$queryInfoDiligencia=mysqli_query($con,$consultarInfoDiligencia);
		$resInfoDiligencia=mysqli_fetch_assoc($queryInfoDiligencia);

		$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));  
		$textrun->addText('Quien diligencia el Formato de Declaración de Siniestros es ',$estiloNoBold);

		$textrun->addText($resInfoDiligencia["nombre_diligencia"],$estiloBold);
		$textrun->addText(', identificado(a) con ',$estiloNoBold);
		$textrun->addText($resInfoDiligencia["identificacion"],$estiloBold);
		$textrun->addText(', '.$resInfoDiligencia["relacion"],$estiloNoBold);
		$textrun->addText(' del lesionado(a), el día '.$resInformacionCaso["fecha_diligencia_formato_declaracion"].', manifestando lo siguiente:',$estiloNoBold);
	}
	else if ($resInformacionCaso["diligencia_formato_declaracion"]==3) {
		//Investigador
		$consultarInfoDiligencia="SELECT CONCAT(a.nombres,' ',a.apellidos) AS nombre_diligencia,
		 CONCAT(LCASE(b.descripcion2),' No. ',a.identificacion) AS identificacion, 'INVESTIGADOR' AS relacion
		FROM investigadores a 
		LEFT JOIN definicion_tipos b ON a.tipo_identificacion=b.id 	
		WHERE b.id_tipo=5 AND a.id='".$resInformacionCaso["id_diligencia_formato_declaracion"]."'";
		mysqli_next_result($con);
		$queryInfoDiligencia=mysqli_query($con,$consultarInfoDiligencia);
		$resInfoDiligencia=mysqli_fetch_assoc($queryInfoDiligencia);
		$textrun->addText('Quien diligencia el Formato de Declaración de Siniestros por petición del lesionado, es ',$estiloNoBold);
		
		$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));  
		$textrun->addText($resInfoDiligencia["nombre_diligencia"],$estiloBold);
		$textrun->addText(', identificado(a) con ',$estiloNoBold);
		$textrun->addText($resInfoDiligencia["identificacion"],$estiloBold);
		$textrun->addText(', investigador de la Compañía Global Red LTDA, el día ',$estiloNoBold);
		$textrun->addText($resInformacionCaso["fecha_diligencia_formato_declaracion"].', manifiestando lo siguiente:',$estiloNoBold);	
	}
	else if ($resInformacionCaso["diligencia_formato_declaracion"]==4) {
		//telefonicamente
		$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));  
		$textrun->addText('El lesionado manifiesta por via telefonica lo siguiente:',$estiloNoBold);
	}	
	 
	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$section->addText('"'.$resInformacionCaso["relato"].'"',array('italic'=>true,'bold'=>true,'size'=>11,'name'=>'Arial'),array('align'=> 'justify','spaceBefore'=>0,'spaceAfter'=>0));
  
	$consultarObservacionesNuevas1=$consultarObservacionesInforme." AND id_seccion=2";
	mysqli_next_result($con);
	$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas1);	

	if (mysqli_num_rows($queryObservaciones)>0)	{
		$cont=0;
		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));
		$textrun->addText("OBSERVACIONES: ", array('bold'=>true,'name'=>'Arial','size'=>11,'underline'=>'single'));
		while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones)){	
			
			$textrun->addText($resObservaciones["observacion"], array('bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
			$cont++;
			if ($cont<mysqli_num_rows($queryObservaciones)){
				$textrun->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));	
			}
		}
	}

	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
	$textrun->addText('2.2.	TRASLADO DE LA VICTIMA: ',$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

	if ($resInformacionCaso["servicio_ambulancia"]=="s") {
		$textrun->addText("El traslado del lesionado se realizó mediante el servicio de ambulancia desde ",$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
		if ($resInformacionCaso["tipo_traslado_ambulancia"]==1)
		{
			$textrun->addText("el lugar de los hechos hasta ",$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
			$textrun->addText($resInformacionCaso["nombre_ips"],$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
		}
		else if ($resInformacionCaso["tipo_traslado_ambulancia"]==2)
		{
			$textrun->addText($resInformacionCaso["lugar_traslado"]." hasta ",$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
			$textrun->addText($resInformacionCaso["nombre_ips"],$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
		}
	}
	else if ($resInformacionCaso["servicio_ambulancia"]=="n") {
		$textrun->addText("El traslado del lesionado se realizó por sus propios medios hasta ",$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
		$textrun->addText($resInformacionCaso["nombre_ips"],$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
	}
	
	mysqli_next_result($con);
	$verificarVariosLesionados=mysqli_query($con,$consultarLesionados);	
	
	if (mysqli_num_rows($verificarVariosLesionados)==1){
		$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
		$trasladoLesionados=mysqli_fetch_assoc($verificarVariosLesionados);
		if ($trasladoLesionados["servicio_ambulancia"]=="s")
		{
			$textrun->addText("El traslado del lesionado se realizó mediante el servicio de ambulancia desde ",$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
			if ($trasladoLesionados["tipo_traslado_ambulancia"]==1)
			{
				$textrun->addText("el lugar de los hechos hasta ",$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
				$textrun->addText($trasladoLesionados["nombre_ips"],$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
			}
			else if ($trasladoLesionados["tipo_traslado_ambulancia"]==2)
			{
				$textrun->addText($trasladoLesionados["lugar_traslado"]." hasta ",$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
				$textrun->addText($trasladoLesionados["nombre_ips"],$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
			}
		}
		else if ($trasladoLesionados["servicio_ambulancia"]=="n")
		{
			$textrun->addText("El traslado del lesionado se realizó por sus propios medios hasta ",$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
			$textrun->addText($trasladoLesionados["nombre_ips"],$estiloBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
		}
  	}

	$consultarObservacionesNuevas2=$consultarObservacionesInforme." AND id_seccion=3";
	mysqli_next_result($con);
	$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas2);	

	if (mysqli_num_rows($queryObservaciones)>0)	{
		$cont=0;
		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));
		$textrun->addText("OBSERVACIONES: ", array('bold'=>true,'name'=>'Arial','size'=>11,'underline'=>'single'));
		
		while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones)){	
			
			$textrun->addText($resObservaciones["observacion"], array('bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
			$cont++;
			
			if ($cont<mysqli_num_rows($queryObservaciones)) {
				$textrun->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));	
			}
		}
	}

	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

	$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));
	$textrun->addText('2.3.	LESIONES: ',$estiloBold);  
	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));      
	$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));

	if ($resInformacionCaso["sexo"]=="1") {
      	$textrun->addText("El lesionado ",$estiloNoBold);  
    }
	else {
    	$textrun->addText("La lesionada ",$estiloNoBold);  
    }

    $textrun->addText($resInformacionCaso["nombre_lesionado"],$estiloBold); 
    $textrun->addText(" sufrió ".$resInformacionCaso["lesiones"],$estiloNoBold);  
  	
  	mysqli_next_result($con);
	$verificarVariosLesionados=mysqli_query($con,$consultarLesionados);	
	if (mysqli_num_rows($verificarVariosLesionados)==1)
	{
		$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
		$lesionesLesionados=mysqli_fetch_assoc($verificarVariosLesionados);
		if ($lesionesLesionados["sexo"]=="1")
		{
	      	$textrun->addText("El lesionado ",$estiloNoBold);  
	    }
		else
		{
	    	$textrun->addText("La lesionada ",$estiloNoBold);  
	    }

	    $textrun->addText($lesionesLesionados["nombre_lesionado"],$estiloBold); 
	    $textrun->addText(" sufrió ".$lesionesLesionados["lesiones"],$estiloNoBold);  		
  	}
    
	$consultarObservacionesNuevas3=$consultarObservacionesInforme." AND id_seccion=4";
	mysqli_next_result($con);
	$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas3);

	if (mysqli_num_rows($queryObservaciones)>0)	{

		$cont=0;
		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));
		$textrun->addText("OBSERVACIONES: ", array('bold'=>true,'name'=>'Arial','size'=>11,'underline'=>'single'));
		
		while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones)) {	
			
			$textrun->addText($resObservaciones["observacion"], array('bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
			$cont++;
			
			if ($cont<mysqli_num_rows($queryObservaciones)) {
				$textrun->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));	
			}
		}						
	}

  	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));

  	$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));
	$textrun->addText('2.4.	TRATAMIENTO: ',$estiloBold);  
  	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));    
  	$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));
  	if ($resInformacionCaso["sexo"]=="1") {
    	$textrun->addText("Al lesionado ",$estiloNoBold);  
  	}
	else {
      	$textrun->addText("A la lesionada ",$estiloNoBold);  
  	}

    $textrun->addText($resInformacionCaso["nombre_lesionado"],$estiloBold); 
    $textrun->addText(" le realizan ".$resInformacionCaso["tratamiento"],$estiloNoBold);  
	
	mysqli_next_result($con);
	$verificarVariosLesionados=mysqli_query($con,$consultarLesionados);	

	if (mysqli_num_rows($verificarVariosLesionados)==1)	{
		$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
		$tratamientoLesionados=mysqli_fetch_assoc($verificarVariosLesionados);
		if ($tratamientoLesionados["sexo"]=="1"){
	      	$textrun->addText("Al lesionado ",$estiloNoBold);  
	    }
		else{
	    	$textrun->addText("A la lesionada ",$estiloNoBold);  
	    }

	    $textrun->addText($tratamientoLesionados["nombre_lesionado"],$estiloBold); 
	    $textrun->addText(" le realizan ".$lesionesLesionados["tratamiento"],$estiloNoBold);  		
  	}
    
    //FIN TEXTO LESIONADOS SI SON 2     
  	mysqli_next_result($con);
	$consultarImagenesLesionados=mysqli_query($con,"SELECT ruta FROM multimedia_investigacion WHERE id_multimedia='2' and id_investigacion='".$id_caso."'");
	$cantidadImagenesLesionados=mysqli_num_rows($consultarImagenesLesionados);

	$cont=0;
	if ($cantidadImagenesLesionados>0){

		while ($resImagenesLesionados=mysqli_fetch_assoc($consultarImagenesLesionados))	{
			$resImagenesLesionados["ruta"] = str_replace('https://globalredltda.co/siglo/portal/data', '../../../data', $resImagenesLesionados["ruta"]);
			$arrayImagenes[$cont]=$resImagenesLesionados["ruta"];
			$cont++;
		}
  
		if (count($arrayImagenes)==1) {
			$section->addTextBreak(4,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun = $section->createTextRun(array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));
			$textrun->addImage($arrayImagenes[0],  array(
				'width' => 500,
				'height' => 400,
				'align'=>'left',
				'wrappingStyle' => 'tight'
			));
		}
		else  if (count($arrayImagenes)==2)	{

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
		else {

			$textrun = $section->createTextRun(array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));

			for ($i=0;$i<count($arrayImagenes);$i++) {

				if ($i==0 || $i==4 || $i==8 || $i==12 || $i==16) {

					$textrun->addTextBreak(2,null,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
					$textrun->addImage($arrayImagenes[$i],  array(
						'width' => 127.5525,
						'height' => 188.9763779528,
						'align'=>'center',
						'wrappingStyle' => 'tight'
					));
					$textrun->addText(" ",$estiloNoBold);
				}
				else {
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
  
	  	$consultarObservacionesNuevas4=$consultarObservacionesInforme." AND id_seccion=5";
		mysqli_next_result($con);
		$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas4);

		if (mysqli_num_rows($queryObservaciones)>0)	{
			
			while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones)) {

				$section->addText($resObservaciones["observacion"], array('italic'=>true,'bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
			}							
		}
 
    	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
    }

	mysqli_next_result($con);
	$verificarVariosLesionados=mysqli_query($con,$consultarLesionados);
  	$consultarObservacionesNuevas5=$consultarObservacionesInforme." AND id_seccion=6";
  	mysqli_next_result($con);
  	$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas5);

	if (mysqli_num_rows($queryObservaciones)>0 || mysqli_num_rows($verificarVariosLesionados)>1 || mysqli_num_rows($otrosIngresosPoliza)>0)	{
  
		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));
		$textrun->addText("OBSERVACIONES: ", array('bold'=>true,'name'=>'Arial','size'=>11,'underline'=>'single'));
	}

	if (mysqli_num_rows($queryObservaciones)>0)	{

		$resObservacionesTratamiento=mysqli_fetch_assoc($queryObservaciones);
		$textrun->addText($resObservacionesTratamiento["observacion"], $estiloNoBold);
		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	}
  
  	if (mysqli_num_rows($verificarVariosLesionados)>1)	{

    	$section->addText("Logramos determinar en el proceso de investigación que en el siniestro materia de investigación existieron otros lesionados que a continuación detallamos:",$estiloNoBold);
		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    	//HACER TABLA VARIOS LESIONADOS
    	$styleCell = array('bgColor'=>'000080',  'borderColor' => '000000', 'borderSize' => 6,
    		'cellMargin' => 50,
	  		'valign' => 'center',
  			'align' => 'center');
		 
		$tableStyle=array('borderSize'=>6, 'borderColor'=>'000000',  'cellMargin' => 10,
	  		'valign' => 'center',
  			'align' => 'center');
		
		$PHPWord->addTableStyle('tableStyle',$tableStyle,$styleCell);
    
		$table =$section->addTable('tableStyle');
	  	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		//CABEZERA TABLA VARIOS LESIONADOS
		$table->addRow();
    	$table->addCell(2000)->addText('Nombre',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));  
		$table->addCell(2000)->addText('Identificación',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
	  	$table->addCell(2000)->addText('Teléfono',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
    	$table->addCell(2000)->addText('Condición',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
    	$table->addCell(2000)->addText('IPS',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
    	//$table->addCell(2000)->addText('EPS',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
    	//FIN CABECERA

    	while ($resTablasVariosLesionados=mysqli_fetch_assoc($verificarVariosLesionados)) {
		   	$table->addRow();
		   	$table->addCell(2000)->addText($resTablasVariosLesionados["nombre_lesionado"],$estiloNoBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));  
		 	$table->addCell(2000)->addText($resTablasVariosLesionados["identificacion_lesionado"],$estiloNoBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
    	 	$table->addCell(2000)->addText($resTablasVariosLesionados["telefono"],$estiloNoBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
	 	   	$table->addCell(2000)->addText($resTablasVariosLesionados["condicion"],$estiloNoBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
       		$table->addCell(2000)->addText($resTablasVariosLesionados["nombre_ips"],$estiloNoBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
    	}

		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));     
    
    	$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));
		$textrun->addText('LESIONES OTROS LESIONADOS: ',$estiloBold);  
    	$a=0;
		
		mysqli_next_result($con);
		$verificarVariosLesionadosLesiones=mysqli_query($con,$consultarLesionados);	
		while ($lesionesOtrosLesionados=mysqli_fetch_assoc($verificarVariosLesionadosLesiones))	{
			$a++;
			
			if($a==1) {
				if ($lesionesOtrosLesionados["sexo"]=="1") {
					$textrun->addText("El lesionado ",$estiloNoBold);  
				}
				else {
					$textrun->addText("La lesionada ",$estiloNoBold);  
				}

				$textrun->addText($lesionesOtrosLesionados["nombre_lesionado"],$estiloBold); 
				$textrun->addText(" sufrió ".$lesionesOtrosLesionados["lesiones"],$estiloNoBold);  
			}
			else {

				$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));      
				$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));
				
				if ($lesionesOtrosLesionados["sexo"]=="1"){
					$textrun->addText("El lesionado ",$estiloNoBold);  
				}
				else{
					$textrun->addText("La lesionada ",$estiloNoBold);  
				}

				$textrun->addText($lesionesOtrosLesionados["nombre_lesionado"],$estiloBold); 
				$textrun->addText(" sufrió ".$lesionesOtrosLesionados["lesiones"],$estiloNoBold);  
			}
		} 
    
    	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));    
    
    	$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));
		$textrun->addText('TRATAMIENTO OTROS LESIONADOS: ',$estiloBold);  
    	$a=0;
		
		mysqli_next_result($con);
		$verificarVariosLesionados=mysqli_query($con,$consultarLesionados);	
		while ($tratamientosOtrosLesionados=mysqli_fetch_assoc($verificarVariosLesionados))	{

			$a++;
			if($a==1){

				if ($tratamientosOtrosLesionados["sexo"]=="MASCULINO") {
					$textrun->addText("Al lesionado ",$estiloNoBold);  
				}
				else {
					$textrun->addText("A la lesionada ",$estiloNoBold); 
				}

				$textrun->addText($tratamientosOtrosLesionados["nombre_lesionado"],$estiloBold); 
				$textrun->addText(" le realizan ".$tratamientosOtrosLesionados["tratamiento"],$estiloNoBold);  
			}
			else {

				$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));      
				$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));
				if ($tratamientosOtrosLesionados["sexo"]=="MASCULINO")
				{
					$textrun->addText("Al lesionado ",$estiloNoBold);  
				}
				else
				{
					$textrun->addText("A la lesionada ",$estiloNoBold);  
				}
				$textrun->addText($tratamientosOtrosLesionados["nombre_lesionado"],$estiloBold); 
				$textrun->addText(" le realizan ".$tratamientosOtrosLesionados["tratamiento"],$estiloNoBold);  
			}
		} 
  	}	

	if(mysqli_num_rows($otrosIngresosPoliza)>0) {

		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));     
		$section->addText("La póliza SOAT reporta los siguientes ingresos:",$estiloNoBold);	
      	$styleCell = array('bgColor'=>'000080',  'borderColor' => '000000', 'borderSize' => 6,
	    'cellMargin' => 50,
  		'align' => 'center');
		
		$tableStyle=array('borderSize'=>6,'valign' => 'center', 'align' => 'center');
		$PHPWord->addTableStyle('tableStyle',$tableStyle,$styleCell);
      	$table =$section->addTable('tableStyle');
    
		$table->addRow();
	   	$table->addCell(2000)->addText('Nombre',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));  
		$table->addCell(2000)->addText('Identificación',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
	  	$table->addCell(2000)->addText('IPS',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
  	  	$table->addCell(2000)->addText('Concepto',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
      	$table->addCell(2000)->addText('Fecha de Accidente',$estiloBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
    
		while ($resCantidadPoliza=mysqli_fetch_assoc($otrosIngresosPoliza)) {
       		$table->addRow();
       		$table->addCell(2000)->addText($resCantidadPoliza["nombre_lesionado"],$estiloNoBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));  
			$table->addCell(2000)->addText($resCantidadPoliza["identificacion"],$estiloNoBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
       		$table->addCell(2000)->addText($resCantidadPoliza["nombre_ips"],$estiloNoBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
	     	$table->addCell(2000)->addText($resCantidadPoliza["resultado"],$estiloNoBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
       		$table->addCell(2000)->addText($resCantidadPoliza["fecha_accidente"],$estiloNoBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));  
     	}
    }

	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$section->addText("3.	INVESTIGACION DE CAMPO",array('bold'=>true,'size'=>11,'name'=>'Arial'),array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));
	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0)); 
	$textrun->addText('3.1. DIRECCION DE LOS HECHOS: ',$estiloBold);  
	$direccionHechos="la ".$resInformacionCaso["lugar_accidente"]." en la ciudad de ".rtrim($resInformacionCaso["ciudad_ocurrencia"]);  
	$textrun->addText('Los hechos ocurrieron en '.$direccionHechos.'.',$estiloNoBold);  

	mysqli_next_result($con);
	$consultarObservacionesNuevas6=$consultarObservacionesInforme." AND id_seccion=7";
	$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas6);

	if (mysqli_num_rows($queryObservaciones)>0) {	
		$cont=0;
		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));
		$textrun->addText("OBSERVACIONES: ", array('bold'=>true,'name'=>'Arial','size'=>11,'underline'=>'single'));

		while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones)) {	
				
			$textrun->addText($resObservaciones["observacion"], array('bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
			$cont++;
			if ($cont<mysqli_num_rows($queryObservaciones)) {
				$textrun->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
			}
		}
	}	

	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0)); 
	$textrun->addText('3.2.	PUNTOS DE REFERENCIA: ',$estiloBold);  

	if ($resInformacionCaso["visita_lugar_hechos"]=="N") {

		$textrun->addText($resInformacionCaso["descripcion_visita_lugar_hechos"],$estiloNoBold);
		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	}
	else{

		$textrun->addText("En ".$direccionHechos.", ".$resInformacionCaso["punto_referencia"],$estiloNoBold);  
		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	} 

	mysqli_next_result($con);
	$consultarImagenesPunto=mysqli_query($con,"SELECT ruta FROM multimedia_investigacion WHERE id_multimedia='1' and id_investigacion='".$id_caso."'");

	$cantidadImagenesPunto=mysqli_num_rows($consultarImagenesPunto);
	unset($arrayImagenes);
	$cont=0;
	if ($cantidadImagenesPunto>0)
	{
		while ($resImagenesPunto=mysqli_fetch_assoc($consultarImagenesPunto))
		{
			$resImagenesPunto["ruta"] = str_replace('https://globalredltda.co/siglo/portal/data', '../../../data', $resImagenesPunto["ruta"]);
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
		$consultarObservacionesNuevas7=$consultarObservacionesInforme." AND id_seccion=17";
		$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas7);

		if (mysqli_num_rows($queryObservaciones)>0)
		{
			$resDetalleImagenPunto=mysqli_fetch_assoc($queryObservaciones);
			 $section->addText($resDetalleImagenPunto["descripcion"], array('italic'=>true,'bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
		}
				
		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

	}



	$consultarObservacionesNuevas8=$consultarObservacionesInforme." AND id_seccion=8";
	mysqli_next_result($con);
	$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas8);
	if (mysqli_num_rows($queryObservaciones)>0)
	{	
		$cont=0;
		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));
		$textrun->addText("OBSERVACIONES: ", array('bold'=>true,'name'=>'Arial','size'=>11,'underline'=>'single'));
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

	$section->addText("4.	OTRAS DILIGENCIAS ADELANTADAS",array('bold'=>true,'size'=>11,'name'=>'Arial'),array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));
	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

	$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0)); 
	$textrun->addText('4.1.	TESTIGOS: ',$estiloBold);  


	if ($resInformacionCaso["visita_lugar_hechos"]=="N"){

  		$textrun->addText("No se aportan testigos ya que es una zona fuera del perímetro urbano autorizado.",$estiloNoBold);
	}
	else {
		
		$consultarTestigos="SELECT CONCAT(b.nombres,' ',b.apellidos) as nombre_testigo,concat(c.descripcion,' ',b.identificacion) as identificacion_testigo,b.telefono,b.direccion_residencia
  		FROM testigos a
  		LEFT JOIN personas b ON a.id_persona=b.id
  		LEFT JOIN definicion_tipos c ON c.id=b.tipo_identificacion
  		WHERE a.id_investigacion='".$id_caso."' and c.id_tipo=5";
  		mysqli_next_result($con);
  		$queryTestigos=mysqli_query($con,$consultarTestigos);
  		$cantidadTestigos=mysqli_num_rows($queryTestigos);
		
		if ($cantidadTestigos>0) {
		
  			$table->addRow();
  			$table->addCell(10000,$colspan)->addText('Se indagó con los moradores del sector quienes confirman la real ocurrencia de los hechos, entre ellos:',$estiloNoBold,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0)); 

			while ($resTestigos=mysqli_fetch_assoc($queryTestigos)){
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
		else {

  			$textrun->addText("En el lugar de los hechos no se encontraron testigos, a pesar de la labor de campo realizada.",$estiloNoBold);
		}		 
	}

	$consultarObservacionesNuevas9=$consultarObservacionesInforme." AND id_seccion=9";
	mysqli_next_result($con);
	$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas9);
	
	if (mysqli_num_rows($queryObservaciones)>0) {
		
		$cont=0;
		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));
		$textrun->addText("OBSERVACIONES: ", array('bold'=>true,'name'=>'Arial','size'=>11,'underline'=>'single'));
		
		while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones)) {	
			
			$textrun->addText($resObservaciones["observacion"], array('bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
			$cont++;
			
			if ($cont<mysqli_num_rows($queryObservaciones)) {
				$textrun->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));	
			}
		}			 
	}

	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0)); 
	$textrun->addText('4.2.	REGISTRO DE LAS AUTORIDADES: ',$estiloBold);  
	$consultarRegistroAutoridades="SELECT descripcion as descripcion_registro_autoridades FROM definicion_tipos WHERE id_tipo=35 and ";

    if ($resInformacionCaso["registro_autoridades"]=="S") {
    	$consultarRegistroAutoridades.=" id='2'";
    }
    else {
    	$consultarRegistroAutoridades.=" id='3'";
    }

    mysqli_next_result($con);
    $queryRegistroAutoridades=mysqli_query($con,$consultarRegistroAutoridades);
    $resRegistroAutoridades=mysqli_fetch_assoc($queryRegistroAutoridades);
    $textrun->addText($resRegistroAutoridades["descripcion_registro_autoridades"],$estiloNoBold,array('spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

    mysqli_next_result($con);
	$consultarObservacionesNuevas10=$consultarObservacionesInforme." AND id_seccion=10";
	$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas10);
	
	if (mysqli_num_rows($queryObservaciones)>0) {
	
		$cont=0;
		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));
		$textrun->addText("OBSERVACIONES: ", array('bold'=>true,'name'=>'Arial','size'=>11,'underline'=>'single'));
		
		while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones)) {	
				
			$textrun->addText($resObservaciones["observacion"], array('bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
			$cont++;

			if ($cont<mysqli_num_rows($queryObservaciones)) {
				$textrun->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));	
			}
		}			
	} 

	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$section->addText("5.	ENTREVISTA TOMADOR Y/O PROPIETARIO:",array('bold'=>true,'size'=>11,'name'=>'Arial'),array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));
	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 
	
	$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));
	$textrun->addText("El Tomador de la Póliza SOAT es ", $estiloNoBold);
	$textrun->addText($resInformacionVehiculo["nombre_tomador"],$estiloBold);
	$textrun->addText(" identificado con ".$resInformacionVehiculo["tipo_identificacion_tomador"]." No. ",$estiloNoBold);
	$textrun->addText($resInformacionVehiculo["no_identificacion_ltomador"],$estiloBold);
	
	if ($resInformacionVehiculo["direccion_tomador"]!=""){
		$textrun->addText(", dirección: ".$resInformacionVehiculo["direccion_tomador"],$estiloNoBold);	
	}

	if ($resInformacionVehiculo["telefono_tomador"]!=""){
		$textrun->addText(", teléfono: ".$resInformacionVehiculo["telefono_tomador"],$estiloNoBold);	
	}
		
	if ($resInformacionCaso["resultado_diligencia_tomador"]<>4)	{
		mysqli_next_result($con);
		$consultarDescripcionDiligenciaTomador=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=38 and id='".$resInformacionCaso["resultado_diligencia_tomador"]."'");
		$resDescripcionDiligenciaTomador=mysqli_fetch_assoc($consultarDescripcionDiligenciaTomador);

		$textrun->addText(", ".$resDescripcionDiligenciaTomador["descripcion2"],$estiloNoBold);		
	}
	else {
		$textrun->addText(", quien expresa lo siguiente:",$estiloNoBold);		
		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$section->addText('"'.$resInformacionCaso["observaciones_diligencia_tomador"].'"',array('italic'=>true,'bold'=>true,'size'=>11,'name'=>'Arial'),array('align'=> 'justify','spaceBefore'=>0,'spaceAfter'=>0));
	}
	
	mysqli_next_result($con);
	$consultarObservacionesNuevas11=$consultarObservacionesInforme." AND id_seccion=11";
	$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas11);
	
	if (mysqli_num_rows($queryObservaciones)>0) {
		$cont=0;
		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));
		$textrun->addText("OBSERVACIONES: ", array('bold'=>true,'name'=>'Arial','size'=>11,'underline'=>'single'));
		
		while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones)) {	
			$textrun->addText($resObservaciones["observacion"], array('bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
			$cont++;
			
			if ($cont<mysqli_num_rows($queryObservaciones)) {
				$textrun->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));	
			}
		}			
	} 

	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$section->addText("6.	INSPECCION  TECNICA DEL VEHICULO:",array('bold'=>true,'size'=>11,'name'=>'Arial'),array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));
	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

	if ($resInformacionCaso["inspeccion_tecnica"]=="S") {
		$section->addText("Se logra inspeccionar el vehículo implicado en el accidente de tránsito, se confirman sus características y vigencia según registro RUNT.",array('size'=>11,'name'=>'Arial'),array('align'=> 'justify','spaceBefore'=>0,'spaceAfter'=>0)); 
	}
	else {
		$section->addText("No se logra inspeccionar el vehículo implicado en el accidente de tránsito.",array('size'=>11,'name'=>'Arial'),array('align'=> 'justify','spaceBefore'=>0,'spaceAfter'=>0)); 	
	}

	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

	mysqli_next_result($con);
	$consultarImagenesInspeccion=mysqli_query($con,"SELECT ruta FROM multimedia_investigacion WHERE id_multimedia='3' and id_investigacion='".$id_caso."'");
	$cantidadImagenesInspeccion=mysqli_num_rows($consultarImagenesInspeccion);
	
	unset($arrayImagenes);
	$cont=0;

	if ($cantidadImagenesInspeccion>0) {
		
		while ($resImagenesInspeeccion=mysqli_fetch_assoc($consultarImagenesInspeccion)) {
			$resImagenesInspeeccion["ruta"] = str_replace('https://globalredltda.co/siglo/portal/data', '../../../data', $resImagenesInspeeccion["ruta"]);
			$arrayImagenes[$cont]=$resImagenesInspeeccion['ruta'];
			$cont++;
		}  

		if (count($arrayImagenes)==1) {
			$textrun = $section->createTextRun(array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));
			$textrun->addImage($arrayImagenes[0],  array(
				'width' => 500,
				'height' => 400,
				'align'=>'left',
				'wrappingStyle' => 'tight'
			));
		}
		else  if (count($arrayImagenes)==2) {
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
		else {
			$textrun = $section->createTextRun(array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));
			
			for ($i=0;$i<count($arrayImagenes);$i++) {
				
				if ($i==0 || $i==4 || $i==8 || $i==12 || $i==16) {
					$textrun->addTextBreak(2,null,array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
					$textrun->addImage($arrayImagenes[$i],  array(
						'width' => 127.5525,
						'height' => 188.9763779528,
						'align'=>'center',
						'wrappingStyle' => 'tight'
					));
					$textrun->addText(" ",$estiloNoBold);
				}
				else {
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
		$consultarObservacionesNuevas12=$consultarObservacionesInforme." AND id_seccion=13";
		$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas12);
		
		if (mysqli_num_rows($queryObservaciones)>0) {
			$resDetalleImagenInspeccion=mysqli_fetch_assoc($queryObservaciones);
			$section->addText($resDetalleImagenInspeccion["observacion"], array('italic'=>true,'bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
		}
		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	}

	mysqli_next_result($con);
	$consultarObservacionesNuevas13=$consultarObservacionesInforme." AND id_seccion=11";
	$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas13);
	
	if (mysqli_num_rows($queryObservaciones)>0) {
		$cont=0;
		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));
		$textrun->addText("OBSERVACIONES: ", array('bold'=>true,'name'=>'Arial','size'=>11,'underline'=>'single'));
		
		while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones)) {	
			$textrun->addText($resObservaciones["observacion"], array('bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
			$cont++;
			
			if ($cont<mysqli_num_rows($queryObservaciones)) {
				$textrun->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));	
			}
		}
			
	} 

	$section->addText("7.	REGISTRO RUNT:",array('bold'=>true,'size'=>11,'name'=>'Arial'),array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));
	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1)); 

	if ($resInformacionCaso["consulta_runt"]=="N") {	
		mysqli_next_result($con);
		$consultarCausalRunt=mysqli_query("SELECT b.descripcion2 as causal FROM definicion_tipos b WHERE b.id_tipo=22 and b.id='$resInformacionCaso[causal_runt]'");
		$resCausalRunt=mysqli_fetch_assoc($consultarCausalRunt);
		$section->addText($resCausalRunt[causal],array('size'=>11,'name'=>'Arial'),array('align'=> 'justify','spaceBefore'=>0,'spaceAfter'=>0)); 	
	}

	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	
	mysqli_next_result($con);	
	$consultarRunt=mysqli_query($con,"SELECT * FROM multimedia_investigacion WHERE id_multimedia='4' and id_investigacion='".$id_caso."'");
	$cantidadImagenesRunt=mysqli_num_rows($consultarRunt);
 	
 	if ($cantidadImagenesRunt>0) {
	 	$section->addPageBreak();
				 
		while ($resRunt=mysqli_fetch_assoc($consultarRunt)) {
			
			$resRunt["ruta"] = str_replace('https://globalredltda.co/siglo/portal/data', '../../../data', $resRunt["ruta"]);
	  		$section->addImage($resRunt['ruta'],array('width' => 500,'height' => 400,'wrappingStyle' => 'behind','align'=>'center','marginLeft'=>0));  
		}	   
	}

	mysqli_next_result($con);
	$consultarObservacionesNuevas14=$consultarObservacionesInforme." AND id_seccion=14";
	$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas13);
	
	if (mysqli_num_rows($queryObservaciones)>0) {
		$cont=0;
		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));
		$textrun->addText("OBSERVACIONES: ", array('bold'=>true,'name'=>'Arial','size'=>11,'underline'=>'single'));
		
		while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones)) {	
			$textrun->addText($resObservaciones["observacion"], array('bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
			$cont++;
			
			if ($cont<mysqli_num_rows($queryObservaciones)) {
				$textrun->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));	
			}
		}			
	} 

	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));   
   	$section->addText("8.	AFILIACION AL SISTEMA DE SEGURIDAD SOCIAL",array('bold'=>true,'size'=>11,'name'=>'Arial'),array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));
   	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));  
	
	if ($resInformacionCaso["id_seguridad_social"]<>"3") {

		if ($resInformacionCaso["id_seguridad_social"]=="4") {

			if($resInformacionCaso["sexo"] == 1){
	
				if ($resInformacionCaso["edad"]<18) {
					$textrun->addText('El menor ',$estiloNoBold);
				}else if($resInformacionCaso["edad"] >= 18 && $resInformacionCaso["edad"] <= 26){
					$textrun->addText('El joven ',$estiloNoBold);		
				}else{
					$textrun->addText('El señor ',$estiloNoBold);		
				}
			} elseif($resInformacionCaso["sexo"] == 2){
				
				if ($resInformacionCaso["edad"]<18) {
					$textrun->addText('La menor ',$estiloNoBold);
				}else if($resInformacionCaso["edad"] >= 18 && $resInformacionCaso["edad"] <= 26){
					$textrun->addText('La joven ',$estiloNoBold);	
				}else{
					$textrun->addText('La señora ',$estiloNoBold);		
				}
			}
			
			$textrun->addText($resInformacionCaso["nombre_lesionado"].", ",$estiloBold);  
		
		
			$textrun->addText("reporta afiliación al sistema General de Seguridad Social en Salud con las Fuerzas Armadas de Colombia",$estiloNoBold);
			$textrun->addText(", según ficha técnica Anexa:",$estiloNoBold);
		}
		else{
			if($resInformacionCaso["sexo"] == 1){
	
				if ($resInformacionCaso["edad"]<18) {
					$textrun->addText('El menor ',$estiloNoBold);
				}else if($resInformacionCaso["edad"] >= 18 && $resInformacionCaso["edad"] <= 26){
					$textrun->addText('El joven ',$estiloNoBold);		
				}else{
					$textrun->addText('El señor ',$estiloNoBold);		
				}
			} elseif($resInformacionCaso["sexo"] == 2){
				
				if ($resInformacionCaso["edad"]<18) {
					$textrun->addText('La menor ',$estiloNoBold);
				}else if($resInformacionCaso["edad"] >= 18 && $resInformacionCaso["edad"] <= 26){
					$textrun->addText('La joven ',$estiloNoBold);	
				}else{
					$textrun->addText('La señora ',$estiloNoBold);		
				}
			}
			
			$textrun->addText($resInformacionCaso["nombre_lesionado"].", ",$estiloBold);  
		
			if ($resInformacionCaso["id_seguridad_social"]=="1"){

				$textrun->addText("reporta afiliación al sistema General de Seguridad Social en Salud con ",$estiloNoBold);
				$textrun->addText($resInformacionCaso["eps"],$estiloBold);
				
				mysqli_next_result($con);
		      	$consultarRegimenEPS=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=18 and id='".$resInformacionCaso["regimen"]."'");
		      	$resRegimenEPS=mysqli_fetch_assoc($consultarRegimenEPS);

		      	mysqli_next_result($con);
		      	$consultarEstadoEPS=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=19 and id='".$resInformacionCaso["estado_eps"]."'");
		      	$resEstadoEPS=mysqli_fetch_assoc($consultarEstadoEPS);
				
				$textrun->addText(", estado ",$estiloNoBold);
				$textrun->addText($resEstadoEPS["descripcion"],$estiloBold);
				$textrun->addText(", régimen ",$estiloNoBold);
				$textrun->addText($resRegimenEPS["descripcion"],$estiloBold);
				$textrun->addText(", según ficha técnica Anexa:",$estiloNoBold);
			}
			else if ($resInformacionCaso["id_seguridad_social"]=="2") {
				$textrun->addText("no reporta afiliación al sistema General de Seguridad Social en Salud, según ficha técnica Anexa:",$estiloNoBold);
			}
		}	
	}
	else{

		$textrun->addText('No fue posible consultar la afiliación al Sistema de Seguridad Social ',$estiloNoBold);

		if($resInformacionCaso["sexo"] == 1){
	
			if ($resInformacionCaso["edad"]<18) {
				$textrun->addText('del menor ',$estiloNoBold);
			}else if($resInformacionCaso["edad"] >= 18 && $resInformacionCaso["edad"] <= 26){
				$textrun->addText('del joven ',$estiloNoBold);		
			}else{
				$textrun->addText('del señor ',$estiloNoBold);		
			}
		} elseif($resInformacionCaso["sexo"] == 2){
			
			if ($resInformacionCaso["edad"]<18) {
				$textrun->addText('de la menor ',$estiloNoBold);
			}else if($resInformacionCaso["edad"] >= 18 && $resInformacionCaso["edad"] <= 26){
				$textrun->addText('de la joven ',$estiloNoBold);	
			}else{
				$textrun->addText('de la señora ',$estiloNoBold);		
			}
		}

		mysqli_next_result($con);
      	$consultarCausalConsulta=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=20 and id='".$resInformacionCaso["causal_consulta"]."'");
      	$resCausalConsulta=mysqli_fetch_assoc($consultarCausalConsulta);
		$textrun->addText($resInformacionCaso["nombre_lesionado"].", ",$estiloBold);  
		$textrun->addText('por'.$resCausalConsulta["descripcion"],$estiloNoBold);		
	}
	
	mysqli_next_result($con);
	$verificarVariosLesionados=mysqli_query($con,$consultarLesionados);
  	
  	if (mysqli_num_rows($verificarVariosLesionados)>0){
		 
		while ($resVariosLesionados=mysqli_fetch_assoc($verificarVariosLesionados))	{

			$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
			$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0)); 

			if ($resVariosLesionados["id_seguridad_social"]<>"3"){
				
				if ($resVariosLesionados["id_seguridad_social"]=="4"){

					if($resVariosLesionados["sexo"] == 1){
	
						if ($resVariosLesionados["edad"]<18) {
							$textrun->addText('El menor ',$estiloNoBold);
						}else if($resVariosLesionados["edad"] >= 18 && $resVariosLesionados["edad"] <= 26){
							$textrun->addText('El joven ',$estiloNoBold);		
						}else{
							$textrun->addText('El señor ',$estiloNoBold);		
						}
					} elseif($resVariosLesionados["sexo"] == 2){
						
						if ($resVariosLesionados["edad"]<18) {
							$textrun->addText('La menor ',$estiloNoBold);
						}else if($resVariosLesionados["edad"] >= 18 && $resVariosLesionados["edad"] <= 26){
							$textrun->addText('La joven ',$estiloNoBold);	
						}else{
							$textrun->addText('La señora ',$estiloNoBold);		
						}
					}
					
					$textrun->addText($resVariosLesionados["nombre_lesionado"].", ",$estiloBold);  				
					$textrun->addText("reporta afiliación al sistema General de Seguridad Social en Salud con las Fuerzas Armadas de Colombia",$estiloNoBold);
					$textrun->addText(", según ficha técnica Anexa:",$estiloNoBold);				
				}
				else{

					if($resVariosLesionados["sexo"] == 1){
	
						if ($resVariosLesionados["edad"]<18) {
							$textrun->addText('El menor ',$estiloNoBold);
						}else if($resVariosLesionados["edad"] >= 18 && $resVariosLesionados["edad"] <= 26){
							$textrun->addText('El joven ',$estiloNoBold);		
						}else{
							$textrun->addText('El señor ',$estiloNoBold);		
						}
					} elseif($resVariosLesionados["sexo"] == 2){
						
						if ($resVariosLesionados["edad"]<18) {
							$textrun->addText('La menor ',$estiloNoBold);
						}else if($resVariosLesionados["edad"] >= 18 && $resVariosLesionados["edad"] <= 26){
							$textrun->addText('La joven ',$estiloNoBold);	
						}else{
							$textrun->addText('La señora ',$estiloNoBold);		
						}
					}
					
					$textrun->addText($resVariosLesionados["nombre_lesionado"].", ",$estiloBold);  
				
					if ($resVariosLesionados["id_seguridad_social"]=="1"){
						$textrun->addText("reporta afiliación al sistema General de Seguridad Social en Salud con ",$estiloNoBold);
						$textrun->addText($resVariosLesionados["eps"],$estiloBold);
						
						mysqli_next_result($con);
				      	$consultarRegimenEPS=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=18 and id='".$resVariosLesionados["regimen"]."'");
				      	$resRegimenEPS=mysqli_fetch_assoc($consultarRegimenEPS);

				      	mysqli_next_result($con);
				      	$consultarEstadoEPS=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=19 and id='".$resVariosLesionados["estado_eps"]."'");
				      	$resEstadoEPS=mysqli_fetch_assoc($consultarEstadoEPS);
						
						$textrun->addText(", estado ",$estiloNoBold);
						$textrun->addText($resEstadoEPS["descripcion"],$estiloBold);
						$textrun->addText(", régimen ",$estiloNoBold);
						$textrun->addText($resRegimenEPS["descripcion"],$estiloBold);
						$textrun->addText(", según ficha técnica Anexa:",$estiloNoBold);
					}
					else if ($resVariosLesionados["id_seguridad_social"]=="2"){
						$textrun->addText("no reporta afiliación al sistema General de Seguridad Social en Salud, según ficha técnica Anexa:",$estiloNoBold);
					}
				}
			}
			else{

				$textrun->addText('No fue posible consultar la afiliación al Sistema de Seguridad Social ',$estiloNoBold);

				if($resVariosLesionados["sexo"] == 1){
	
					if ($resVariosLesionados["edad"]<18) {
						$textrun->addText('El menor ',$estiloNoBold);
					}else if($resVariosLesionados["edad"] >= 18 && $resVariosLesionados["edad"] <= 26){
						$textrun->addText('del joven ',$estiloNoBold);		
					}else{
						$textrun->addText('del señor ',$estiloNoBold);		
					}
				} elseif($resVariosLesionados["sexo"] == 2){
					
					if ($resVariosLesionados["edad"]<18) {
						$textrun->addText('de la menor ',$estiloNoBold);
					}else if($resVariosLesionados["edad"] >= 18 && $resVariosLesionados["edad"] <= 26){
						$textrun->addText('de la joven ',$estiloNoBold);	
					}else{
						$textrun->addText('de la señora ',$estiloNoBold);		
					}
				}

				mysqli_next_result($con);
		      	$consultarCausalConsulta=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=20 and id='".$resVariosLesionados["causal_consulta"]."'");
		      	$resCausalConsulta=mysqli_fetch_assoc($consultarCausalConsulta);
				$textrun->addText($resVariosLesionados["nombre_lesionado"].", ",$estiloBold);  
				$textrun->addText('por '.$resCausalConsulta["descripcion"].'.',$estiloNoBold);			
			}			 
			 	
			$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  			
		}
	}


	mysqli_next_result($con);
	$consultarSeguridadSocial=mysqli_query($con,"SELECT * FROM multimedia_investigacion WHERE id_investigacion='".$id_caso."' AND id_multimedia=5");

	if (mysqli_num_rows($consultarSeguridadSocial) > 0) {
		unset($arrayImagenes);
		$cont=0;
	
		while ($resImagenesSeguridadSocial=mysqli_fetch_assoc($consultarSeguridadSocial)) {
			$resImagenesSeguridadSocial["ruta"] = str_replace('https://globalredltda.co/siglo/portal/data', '../../../data', $resImagenesSeguridadSocial["ruta"]);
			$arrayImagenes[$cont]=$resImagenesSeguridadSocial['ruta'];

			$textrun = $section->createTextRun(array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));
			$textrun->addImage($resImagenesSeguridadSocial['ruta'],  array(
				'width' => 500,
				'height' => 400,
				'align'=>'left',
				'wrappingStyle' => 'tight'
			));
			$cont++;
		}
	}
	
	mysqli_next_result($con);
	$consultarObservacionesNuevas15=$consultarObservacionesInforme." AND id_seccion=15";
	$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas15);

	if (mysqli_num_rows($queryObservaciones)>0) {
		$cont=0;
		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));
		$textrun->addText("OBSERVACIONES: ", array('bold'=>true,'name'=>'Arial','size'=>11,'underline'=>'single'));
		
		while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones)){	
			$textrun->addText($resObservaciones["observacion"], array('bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
			$cont++;
			if ($cont<mysqli_num_rows($queryObservaciones))
			{
				$textrun->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));	
			}
		}			
	} 

	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));   
	$section->addText("9.	CONCLUSIONES:",array('bold'=>true,'size'=>11,'name'=>'Arial'),array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));
	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));   
	$section->addText($resInformacionCaso["conclusiones"],$estiloNoBold,array('align'=> 'justify','spaceBefore'=>0,'spaceAfter'=>0));    

	//$consultarObservacionesFURIPSnew15=$consultarObservacionesFURIPS." AND id_seccion=13";
	//$queryObservaciones=mysql_query($consultarObservacionesFURIPSnew15);

	//if (mysql_num_rows($queryObservaciones)>0)
	//{
		//$resObservacionesInspeccion=mysql_fetch_array($queryObservaciones);
		//$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));
		//$textrun->addText("OBSERVACIONES: ", array('bold'=>true,'name'=>'Arial','size'=>11,'underline'=>'single'));
		//$textrun->addText($resObservacionesInspeccion["descripcion"], $estiloNoBold);
		//$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	//} 

	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

	if($result != "no"){

		$section->addText("10. SUGERENCIAS:",array('bold'=>true,'size'=>11,'name'=>'Arial'),array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));

		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));
		$textrun->addText("El caso sugiere ", $estiloNoBold);

		$textrun->addText($resResultado["resultado"], $estiloBold);

	}

	mysqli_next_result($con);
	$consultarObservacionesNuevas16=$consultarObservacionesInforme." AND id_seccion=16";
	$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas16);

	if (mysqli_num_rows($queryObservaciones)>0)	{
		$cont=0;
		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
		$textrun = $section->createTextRun(array('align'=>'justify','spaceBefore'=>0,'spaceAfter'=>0));
		$textrun->addText("OBSERVACIONES: ", array('bold'=>true,'name'=>'Arial','size'=>11,'underline'=>'single'));

		while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones)){	

			$textrun->addText($resObservaciones["observacion"], array('bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
			$cont++;
			if ($cont<mysqli_num_rows($queryObservaciones))	{
				$textrun->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));	
			}
		}			
	} 

	$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
	$section->addText("Cordialmente,",$estiloBold,array('align'=> 'justify','spaceBefore'=>0,'spaceAfter'=>0));
	$section->addTextBreak(2,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));

	$table =$section->addTable('firmas');

	$table->addRow();
	$cell = $table->addCell(6000);
	$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  
    $textrun->addImage( '../firmas/firma_representante.jpeg',array('width' => 100,'height' => 100,'wrappingStyle' => 'behind','align'=>'left','marginLeft'=>0,'lineHeight'=>1));

    $cell = $table->addCell(4000);
	$textrun = $cell->createTextRun(array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
	$textrun->addImage( '../firmas/firma_gerente.jpg',array('width' => 100,'height' => 100,'wrappingStyle' => 'behind','align'=>'left','marginLeft'=>0,'lineHeight'=>1));

	$table->addRow();
	$table->addCell(6000)->addText("HERNANDO ARTURO QUIJANO RUIZ\nREPRESENTANTE LEGAL",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));  
		
	$table->addCell(4000)->addText("JOSE MIGUEL QUIJANO RUIZ\nGERENTE OPERATIVO",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));
	mysqli_next_result($con);
	$consultarImagenesForm=mysqli_query($con,"SELECT * FROM multimedia_investigacion WHERE id_multimedia='6' and id_investigacion='".$id_caso."'");
	$cantidadImagenesForm=mysqli_num_rows($consultarImagenesForm);

	unset($arrayImagenes);
	$cont=0;
	if ($cantidadImagenesForm>0) {
					
		while ($resImagenesForm=mysqli_fetch_assoc($consultarImagenesForm))	{
			$section->addPageBreak();
			$section->addText("FOTOS FORMULARIO:",$estiloBold,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0));
			$resImagenesForm["ruta"] = str_replace('https://globalredltda.co/siglo/portal/data', '../../../data', $resImagenesForm["ruta"]);
			$section->addImage($resImagenesForm['ruta'],array('width' => 600,'height' => 650,'wrappingStyle' => 'behind','align'=>'center','marginLeft'=>0));  
			
			$cont++;
		}

  		mysqli_next_result($con);
		$consultarObservacionesNuevas9=$consultarObservacionesInforme." AND id_seccion=15";
		$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas9);
	  	
	  	if (mysqli_num_rows($queryObservaciones)>0)	{
	    	$resDetalleImagenInspeccion=mysqli_fetch_assoc($queryObservaciones);
	    	$section->addText($resDetalleImagenInspeccion["observacion"], array('italic'=>true,'bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
	  	}

		$section->addTextBreak(1,null,array('align'=> 'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
	}

	//SI ES DE LA ASEGURADORA -> ESTADO ADJUNTAR HOJA DE VIDA DE INVEST y GERENTE
	if($resInformacionCaso['id_aseguradora'] == 2){
		
		$consultarInformacionInvestigador="SELECT i.*, dt.descripcion2 FROM investigadores i LEFT JOIN definicion_tipos dt ON dt.id = i.tipo_identificacion AND dt.id_tipo = 5 WHERE i.id='".$resInformacionCaso['id_investigador']."'";
		$queryInformacionInvestigador=mysqli_query($con,$consultarInformacionInvestigador);

		if(mysqli_num_rows($queryInformacionInvestigador)){

			$section->addPageBreak();

			$respSQLInvestigador=mysqli_fetch_assoc($queryInformacionInvestigador);

			$section->addText("INFORMACIÓN DEL VERFICADOR DEL CASO",array('color'=>'black','bold'=>true,'name'=>'Arial','size'=>12),array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

			$section->addTextBreak(1);
			
			$section->addText($respSQLInvestigador['nombres'].' '.$respSQLInvestigador['apellidos'],$estiloNoBold,array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

			$section->addText($respSQLInvestigador['descripcion2'].' '.$respSQLInvestigador['identificacion'].' De '.$respSQLInvestigador['lugar_expedicion'],$estiloNoBold,array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));

			if($respSQLInvestigador['foto'] != ''){
				if(file_exists($ruta = "../../../data/fotos_perfil/".$respSQLInvestigador['foto'])){
					$ruta = "../../../data/fotos_perfil/".$respSQLInvestigador['foto'];
					$section->addTextBreak(1);
					$section->addImage($ruta,array('width' => 128,'height' => 160,'wrappingStyle' => 'behind','align'=>'center','marginLeft'=>0));
				}
			}

			$section->addText("Estudios Realizados:",$estiloBold,array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));

			if($respSQLInvestigador['estudios'] != ''){
				$estudios = explode('|', $respSQLInvestigador['estudios']);
				if(count($estudios)>0){
					foreach ($estudios as $llave => $valor) {
						$section->addText("- ".$valor,$estiloNoBold,array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
					}
				}else{
					$section->addText("- ".$respSQLInvestigador['estudios'],$estiloNoBold,array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
				}
			}

			$section->addTextBreak(1);

			$section->addText("Experiencias Laborales Relacionadas:",$estiloBold,array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));

			if($respSQLInvestigador['experiencia'] != ''){
				$experiencia = explode('|', $respSQLInvestigador['experiencia']);
				if(count($experiencia)>0){
					foreach ($experiencia as $llave => $valor) {
						$section->addText("- ".$valor,$estiloNoBold,array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
					}
				}else{
					$section->addText("- ".$respSQLInvestigador['experiencia'],$estiloNoBold,array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
				}
			}
		}

		mysqli_next_result($con);	

		$consultarInformacionGerente="SELECT g.*, dt.descripcion2 FROM gerentes g LEFT JOIN definicion_tipos dt ON dt.id = g.tipo_identificacion AND dt.id_tipo = 5 WHERE g.id='3'";
		$queryInformacionGerente=mysqli_query($con,$consultarInformacionGerente);
		
		if(mysqli_num_rows($queryInformacionGerente)){

			$section->addPageBreak();

			$respSQLGerente=mysqli_fetch_assoc($queryInformacionGerente);

			$section->addText("INFORMACIÓN DEL REPRESENTANTE",array('color'=>'black','bold'=>true,'name'=>'Arial','size'=>12),array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  

			$section->addTextBreak(1);
			
			$section->addText($respSQLGerente['nombres'].' '.$respSQLGerente['apellidos'],$estiloNoBold,array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));  	

			$section->addText($respSQLInvestigador['descripcion2'].' '.$respSQLGerente['identificacion'].' de '.$respSQLGerente['lugar_expedicion'],$estiloNoBold,array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));

			if($respSQLGerente['foto'] != ''){
				if(file_exists($ruta = "../../../data/fotos_perfil/".$respSQLGerente['foto'])){
					$ruta = "../../../data/fotos_perfil/".$respSQLGerente['foto'];
					$section->addTextBreak(1);
					$section->addImage($ruta,array('width' => 128,'height' => 160,'wrappingStyle' => 'behind','align'=>'center','marginLeft'=>0));
				}
			}

			$section->addText("Estudios Realizados:",$estiloBold,array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));

			if($respSQLGerente['estudios'] != ''){
				$estudios = explode('|', $respSQLGerente['estudios']);
				if(count($estudios)>0){
					foreach ($estudios as $llave => $valor) {
						$section->addText("- ".$valor,$estiloNoBold,array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
					}
				}else{
					$section->addText("- ".$respSQLGerente['estudios'],$estiloNoBold,array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
				}
			}

			$section->addTextBreak(1);

			$section->addText("Experiencias Laborales Relacionadas:",$estiloBold,array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));

			if($respSQLGerente['experiencia'] != ''){
				$experiencia = explode('|', $respSQLGerente['experiencia']);
				if(count($experiencia)>0){
					foreach ($experiencia as $llave => $valor) {
						$section->addText("- ".$valor,$estiloNoBold,array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
					}
				}else{
					$section->addText("- ".$respSQLGerente['experiencia'],$estiloNoBold,array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'lineHeight'=>1));
				}
			}
		}

		mysqli_next_result($con);
	}

	$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($PHPWord, 'Word2007');
	$nombre="INFORME ".$resInformacionCaso["nombre_lesionado"]." POLIZA No. ".$resInformacionVehiculo["numero_poliza"];

	$objWriter->save('Informe.docx');
	header('Content-Disposition: attachment; filename="'.$nombre.'.docx"');
	echo file_get_contents('Informe.docx');
?>