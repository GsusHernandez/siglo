<?php
// add a header using WordFragments

require_once '../classes/CreateDocx.php';
include('../../../conexion/conexion.php');
global $con;
$id_caso=$_GET["idInv"];
$result='si';
if(isset($_GET["result"])){ $result = $_GET["result"]; }

ini_set('max_execution_time', '300'); //300 seconds = 5 minutes
ini_set('memory_limit', '256M');
set_time_limit(300);

mysqli_query($con,"SET SQL_BIG_SELECTS=1");

$consultarInformacionBasicaCaso="SELECT a.codigo,
    a.id AS id_caso, a.tipo_caso,
    CONCAT(d.nombres,' ',d.apellidos) AS nombre_lesionado,
    CONCAT(e.descripcion,' ',d.identificacion) AS identificacion_lesionado,
    f.nombre_ips,
    f.identificacion AS nit_ips,
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
    CONCAT(CONCAT(UPPER(LEFT(g1.nombre, 1)), LOWER(SUBSTRING(g1.nombre, 2))),' - ', 
    CONCAT(UPPER(LEFT(h1.nombre, 1)), LOWER(SUBSTRING(h1.nombre, 2)))) AS ciudad_residencia,
    d.barrio,
    d.telefono,d.sexo,e.descripcion2 AS tipo_identificacion_lesionado,d.identificacion AS no_identificacion_lesionado,
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
    c.id_persona,
    b.lugar_accidente,
    b.visita_lugar_hechos,
    b.punto_referencia,
    b.registro_autoridades,
    b.diligencia_formato_declaracion,
    b.id_diligencia_formato_declaracion,b.observacion_diligencia_formato_declaracion,
    b.furips,   
    CONCAT(zb.nombre,' - ',zc.nombre) AS ciudad_ocurrencia,
    b.resultado_diligencia_tomador,
    b.observaciones_diligencia_tomador,
    CONCAT(DAY(a.fecha_entrega), ' de ',CASE  WHEN MONTH(a.fecha_entrega)='01' THEN  'Enero' WHEN MONTH(a.fecha_entrega)='02' THEN  'Febrero' WHEN MONTH(a.fecha_entrega)='03' THEN  'Marzo' WHEN MONTH(a.fecha_entrega)='04' THEN  'Abril' WHEN MONTH(a.fecha_entrega)='05' THEN  'Mayo' WHEN MONTH(a.fecha_entrega)='06' THEN  'Junio' WHEN MONTH(a.fecha_entrega)='07' THEN  'Julio' WHEN MONTH(a.fecha_entrega)='08' THEN  'Agosto' WHEN MONTH(a.fecha_entrega)='09' THEN  'Septiembre' WHEN MONTH(a.fecha_entrega)='10' THEN  'Octubre' WHEN MONTH(a.fecha_entrega)='11' THEN  'Noviembre' WHEN MONTH(a.fecha_entrega)='12' THEN  'Diciembre' END,' de ',YEAR(a.fecha_entrega)) AS fecha_entrega,
    CONCAT(DAY(b.fecha_accidente), ' de ',CASE  WHEN MONTH(b.fecha_accidente)='01' THEN  'Enero' WHEN MONTH(b.fecha_accidente)='02' THEN  'Febrero' WHEN MONTH(b.fecha_accidente)='03' THEN  'Marzo' WHEN MONTH(b.fecha_accidente)='04' THEN  'Abril' WHEN MONTH(b.fecha_accidente)='05' THEN  'Mayo' WHEN MONTH(b.fecha_accidente)='06' THEN  'Junio' WHEN MONTH(b.fecha_accidente)='07' THEN  'Julio' WHEN MONTH(b.fecha_accidente)='08' THEN  'Agosto' WHEN MONTH(b.fecha_accidente)='09' THEN  'Septiembre' WHEN MONTH(b.fecha_accidente)='10' THEN  'Octubre' WHEN MONTH(b.fecha_accidente)='11' THEN  'Noviembre' WHEN MONTH(b.fecha_accidente)='12' THEN  'Diciembre' END,' de ',YEAR(b.fecha_accidente)) AS fecha_accidente2,
    CONCAT(DAY(c.fecha_ingreso), ' de ',CASE  WHEN MONTH(c.fecha_ingreso)='01' THEN  'Enero' WHEN MONTH(c.fecha_ingreso)='02' THEN  'Febrero' WHEN MONTH(c.fecha_ingreso)='03' THEN  'Marzo' WHEN MONTH(c.fecha_ingreso)='04' THEN  'Abril' WHEN MONTH(c.fecha_ingreso)='05' THEN  'Mayo' WHEN MONTH(c.fecha_ingreso)='06' THEN  'Junio' WHEN MONTH(c.fecha_ingreso)='07' THEN  'Julio' WHEN MONTH(c.fecha_ingreso)='08' THEN  'Agosto' WHEN MONTH(c.fecha_ingreso)='09' THEN  'Septiembre' WHEN MONTH(c.fecha_ingreso)='10' THEN  'Octubre' WHEN MONTH(c.fecha_ingreso)='11' THEN  'Noviembre' WHEN MONTH(c.fecha_ingreso)='12' THEN  'Diciembre' END,' de ',YEAR(c.fecha_ingreso)) AS fecha_ingreso3,
    c.resultado,a.id_aseguradora,b.conclusiones,a.id_investigador,b.id_poliza
    FROM investigaciones a
    LEFT JOIN detalle_investigaciones_soat b ON a.id=b.id_investigacion
    LEFT JOIN personas_investigaciones_soat c ON c.id_investigacion=a.id
    LEFT JOIN personas d ON d.id=c.id_persona
    LEFT JOIN definicion_tipos e ON e.id=d.tipo_identificacion AND e.id_tipo=5 
    LEFT JOIN ips f ON f.id=c.ips
    LEFT JOIN ciudades g ON g.id=f.ciudad
    LEFT JOIN departamentos h ON h.id=g.id_departamento
    LEFT JOIN ciudades g1 ON g1.id=d.ciudad_residencia
    LEFT JOIN departamentos h1 ON h1.id=g1.id_departamento
    LEFT JOIN aseguradoras m ON m.id=a.id_aseguradora
    LEFT JOIN ciudades n ON n.id=d.ciudad_residencia
    LEFT JOIN departamentos o ON o.id=n.id_departamento
    LEFT JOIN definicion_tipos q ON q.id=c.indicador_fraude AND q.id_tipo=12  
    LEFT JOIN definicion_tipos r ON r.id=c.seguridad_social AND r.id_tipo=17
    LEFT JOIN ciudades zb ON zb.id=b.ciudad_ocurrencia
    LEFT JOIN departamentos zc ON zc.id=zb.id_departamento
    WHERE c.tipo_persona=1  AND a.id='".$id_caso."'";
   
$consultarObservacionesInforme="SELECT * FROM observaciones_secciones_informe WHERE id_investigacion='".$id_caso."'";

$consultarLesionados="SELECT 
    CONCAT(b.nombres,' ',b.apellidos) AS nombre_lesionado,
    CONCAT(c.descripcion,' ',b.identificacion) AS identificacion_lesionado,b.sexo,
    c.descripcion2 AS tipo_identificacion_lesionado,b.identificacion AS no_identificacion_lesionado,a.lugar_traslado, CASE WHEN a.servicio_ambulancia = 's' THEN (SELECT CONCAT(c1.descripcion, ' - AMBULANCIA') FROM definicion_tipos c1 WHERE a.tipo_traslado_ambulancia = c1.id AND c1.id_tipo = 16) ELSE (SELECT CONCAT(c2.descripcion) FROM tipo_vehiculos c2 WHERE a.tipo_vehiculo_traslado = c2.id) END traslado,
    a.condicion,b.direccion_residencia,h.nombre_ips,b.edad,b.ocupacion, CONCAT(g.nombre,' - ',f.nombre) as ciudad_residencia,
    a.causal_consulta,
    b.barrio,b.edad,b.telefono,a.condicion,a.lesiones,a.tratamiento,h.nombre_ips,a.seguridad_social as id_seguridad_social,
    r.descripcion2 AS seguridad_social,
    a.regimen,a.eps,a.estado as estado_eps
    FROM  personas_investigaciones_soat a 
    LEFT JOIN personas b ON a.id_persona=b.id
    LEFT JOIN definicion_tipos c ON c.id=b.tipo_identificacion 
    LEFT JOIN ciudades f ON f.id = b.ciudad_residencia
    LEFT JOIN departamentos g ON g.id=f.id_departamento
    LEFT JOIN definicion_tipos r ON r.id = a.seguridad_social AND r.id_tipo=17  
    LEFT JOIN ips h ON h.id = a.ips
    WHERE a.tipo_persona=2 AND c.id_tipo = 5 AND a.id_investigacion='".$id_caso."'";

mysqli_next_result($con);
$verificarVariosLesionados=mysqli_query($con,$consultarLesionados);
$cont3= mysqli_num_rows($verificarVariosLesionados);

mysqli_next_result($con);
$queryInformacionCaso=mysqli_query($con,$consultarInformacionBasicaCaso);
$resInformacionCaso=mysqli_fetch_assoc($queryInformacionCaso);
mysqli_next_result($con);
$consultarInformacionVehiculo="SELECT
    c.placa,
    b.id_vehiculo,
    k.id_poliza,
    c.tipo_vehiculo as id_tipo_vehiculo,
    c.marca,
    c.modelo,
    c.linea,
    c.color,
    c.numero_vin,
    c.numero_serie,
    c.numero_motor,
    c.numero_chasis,
    e.descripcion AS tipo_servicio,
    b.numero AS numero_poliza,
    b.inicio_vigencia,
    b.fin_vigencia,
    d.descripcion AS tipo_vehiculo,
    b.nombre_tomador,b.id AS id_poliza,
    CONCAT(f.descripcion,' ',b.identificacion_tomador) AS identificacion_tomador,
    b.telefono_tomador,
    b.direccion_tomador,
    CONCAT(g.nombre,' - ',h.nombre) AS ciudad_tomador,
    CONCAT(i.nombre,' - ',j.nombre) AS ciudad_expedicion_poliza
    FROM polizas b 
    LEFT JOIN vehiculos c ON c.id=b.id_vehiculo
    LEFT JOIN tipo_vehiculos d ON d.id=c.tipo_vehiculo
    LEFT JOIN definicion_tipos e ON e.id=c.tipo_servicio
    LEFT JOIN definicion_tipos f ON f.id=b.tipo_identificacion_tomador
    LEFT JOIN ciudades g ON g.id=b.ciudad_tomador
    LEFT JOIN departamentos h ON h.id=g.id_departamento
    LEFT JOIN ciudades i ON i.id=b.ciudad_expedicion
    LEFT JOIN departamentos j ON j.id=i.id_departamento
    LEFT JOIN detalle_investigaciones_soat k ON k.id_poliza=b.id
    WHERE  e.id_tipo=21  AND f.id_tipo=5 
    AND k.id_investigacion='".$id_caso."'";
$queryInformacionVehiculo=mysqli_query($con,$consultarInformacionVehiculo);
$resInformacionVehiculo=mysqli_fetch_assoc($queryInformacionVehiculo);  

if($resInformacionCaso['id_aseguradora'] != 2){
    $docx = new CreateDocxFromTemplate('ModeloAtender.docx');
}else{
    $docx = new CreateDocxFromTemplate('ModeloAtenderEstado.docx');
}

$consultarResultado="SELECT b.descripcion2 as resultado from aseguradoras a left join definicion_tipos b on a.resultado_atender=b.id where b.id_tipo=10 and a.id='".$resInformacionCaso["id_aseguradora"]."'";  

mysqli_next_result($con);
$consultarInformacionInvestigador=mysqli_query($con,"SELECT CONCAT(b.descripcion,' ',a.identificacion) as identificacion_investigador,CONCAT(a.nombres,' ',a.apellidos) as nombre_investigador FROM investigadores a LEFT JOIN definicion_tipos b ON a.tipo_identificacion=b.id AND b.id_tipo=5 WHERE a.id='".$resInformacionCaso["id_investigador"]."'");
$resInformacionInvestigador=mysqli_fetch_assoc($consultarInformacionInvestigador);
mysqli_next_result($con);

$queryResultado=mysqli_query($con,$consultarResultado); 
$resResultado=mysqli_fetch_assoc($queryResultado);
mysqli_next_result($con); 

//INICIAMOS CON EL INFORME - RERENCIA DE REMPLAZO |
$docx->setTemplateSymbol('|');
//INICIO INFORME
$docx->replaceVariableByText(array('fecha_informe' => $resInformacionCaso['fecha_entrega']));
$docx->replaceVariableByText(array('nombre_aseguradora' => $resInformacionCaso["aseguradora"]));
$docx->replaceVariableByText(array('responsable' => $resInformacionCaso["responsable"]));
if ($resInformacionCaso['cargo']!='N'){
    $docx->replaceVariableByText(array('cargo' => $resInformacionCaso["cargo"])); 
}else{
    $docx->replaceVariableByText(array('cargo' => '')); 
}
$docx->replaceVariableByText(array('codigo' => $resInformacionCaso["codigo"]));

//RADICADOS DEL INFORME
mysqli_next_result($con);
$textoRadicados = "";
$consultarRadicados=mysqli_query($con,"SELECT identificador FROM id_casos_aseguradora WHERE id_investigacion = ".$resInformacionCaso["id_caso"]." ORDER BY fecha_entrega DESC");

if (mysqli_num_rows($consultarRadicados)>0) {    
    $wfTextRadicados = new WordFragment($docx, 'document');
    $wfTextRadicados->addText('N° RADICADO: ', array('bold' => true, 'color' => 'AB1B0D'));
    $cont=0;
    while ($resRadicados=mysqli_fetch_assoc($consultarRadicados)) {
        $cont++;
        $wfTextRadicados->addText($resRadicados["identificador"], array('bold' => true)); 
        $textoRadicados .= $resRadicados["identificador"].", ";
    }
    $textoRadicados = substr($textoRadicados,0,-1);
    $docx->replaceVariableByWordFragment(array('radicados' => $wfTextRadicados), array('type' => 'block'));
}else{
    $docx->removeTemplateVariable('radicados', 'inline');
}

//REFERENCIA INFORME FINAL
$docx->replaceVariableByText(array('nombre_lesionado_ppal' => $resInformacionCaso["nombre_lesionado"]));
$docx->replaceVariableByText(array('poliza' => $resInformacionVehiculo["numero_poliza"]));
$docx->replaceVariableByText(array('tipo_vehiculo' => $resInformacionVehiculo["tipo_vehiculo"]));
$docx->replaceVariableByText(array('placa' => $resInformacionVehiculo["placa"]));
$docx->replaceVariableByText(array('ips' => $resInformacionCaso["nombre_ips"]));
$docx->replaceVariableByText(array('ciudad_ath' => $resInformacionCaso["ciudad_ips"]));
$docx->replaceVariableByText(array('fecha_accidente' => $resInformacionCaso["fecha_accidente"]));
$docx->replaceVariableByText(array('fecha_ingreso_ips' => $resInformacionCaso["fecha_ingreso"]));
$docx->replaceVariableByText(array('fecha_egreso_ips' => $resInformacionCaso["fecha_egreso"]));
if($result != "no"){
    $docx->replaceVariableByText(array('resultado' => $resResultado["resultado"]));
    $docx->replaceVariableByText(array('indicador' => $resInformacionCaso["indicador_fraude"]));
}else{
    $docx->replaceVariableByText(array('resultado' => ''));
    $docx->replaceVariableByText(array('indicador' => ''));
}
//ANALISIS DEL SINIESTRO
$text[] = array('text' => 'Por medio del presente nos permitimos informar el resultado final de la investigación de ACCIDENTE DE TRANSITO realizada ', 'bold' => false);

if($resInformacionCaso["sexo"] == 1){

    if ($resInformacionCaso["edad"]<18) {
        $text[] = array('text' => 'al menor ', 'bold' => false);
    }else if($resInformacionCaso["edad"] >= 18 && $resInformacionCaso["edad"] <= 26){
        $text[] = array('text' => 'al joven ', 'bold' => false); 
    }else{
        $text[] = array('text' => 'al señor ', 'bold' => false); 
    }
} elseif($resInformacionCaso["sexo"] == 2){
    
    if ($resInformacionCaso["edad"]<18) {
        $text[] = array('text' => 'a la menor ', 'bold' => false);
    }else if($resInformacionCaso["edad"] >= 18 && $resInformacionCaso["edad"] <= 26){
        $text[] = array('text' => 'a la joven ', 'bold' => false); 
    }else{
        $text[] = array('text' => 'a la señora ', 'bold' => false);        
    }
}

$text[] = array('text' => $resInformacionCaso["nombre_lesionado"].', ', 'bold' => true);

$resInformacionCaso["tipo_identificacion_lesionado"] = ucwords(mb_strtolower($resInformacionCaso["tipo_identificacion_lesionado"]));
if ($resInformacionCaso["sexo"]=="2") {

    $text[] = array('text' => 'identificada con '.$resInformacionCaso["tipo_identificacion_lesionado"]." No. ", 'bold' => false);
}else{
    $text[] = array('text' => 'identificado con '.$resInformacionCaso["tipo_identificacion_lesionado"]." No. ", 'bold' => false);
}
$text[] = array('text' => $resInformacionCaso["no_identificacion_lesionado"], 'bold' => true);

$arrayVariosLesionados = array();
if ($cont3==1) {

    while ($resVariosLesionados=mysqli_fetch_array($verificarVariosLesionados)){

        $arrayVariosLesionados[] = $resVariosLesionados;

        $text[] = array('text' => ', y ', 'bold' => false);  

        if($resVariosLesionados["sexo"] == 1){

            if ($resVariosLesionados["edad"]<18) {
                $text[] = array('text' => 'al menor ', 'bold' => false);
            }else if($resVariosLesionados["edad"] >= 18 && $resVariosLesionados["edad"] <= 26){
                $text[] = array('text' => 'al joven ', 'bold' => false); 
            }else{
                $text[] = array('text' => 'al señor ', 'bold' => false); 
            }
        } elseif($resVariosLesionados["sexo"] == 2){
            
            if ($resVariosLesionados["edad"]<18) {
                $text[] = array('text' => 'a la menor ', 'bold' => false);
            }else if($resVariosLesionados["edad"] >= 18 && $resVariosLesionados["edad"] <= 26){
                $text[] = array('text' => 'a la joven ', 'bold' => false); 
            }else{
                $text[] = array('text' => 'a la señora ', 'bold' => false);        
            }
        }
        
        $text[] = array('text' => $resVariosLesionados["nombre_lesionado"], 'bold' => true); 
        
        if ($resVariosLesionados["sexo"]=="2"){
            $text[] = array('text' => ', identificada con ', 'bold' => false);  
        }
        else{
            $text[] = array('text' => ', identificado con ', 'bold' => false);  
        }
        $resVariosLesionados["tipo_identificacion_lesionado"] = ucwords(mb_strtolower($resVariosLesionados["tipo_identificacion_lesionado"]));
        $text[] = array('text' => $resVariosLesionados["tipo_identificacion_lesionado"]." ", 'bold' => false);  
        $text[] = array('text' => $resVariosLesionados["no_identificacion_lesionado"], 'bold' => true); 
    }   
    
    $text[] = array('text' => ', quienes refieren haber sufrido el siniestro el día ', 'bold' => false);  

    $cont3=1;
}
else {
    if ($resInformacionCaso["edad"] == "") {
        $text[] = array('text' => ', quien refiere haber sufrido el siniestro el día ', 'bold' => false);  
    }else{
        $text[] = array('text' => ', de '.$resInformacionCaso["edad"].' años de edad, quien refiere haber sufrido el siniestro el día ', 'bold' => false); 
    } 

    if ($cont3>1){
        while ($resVariosLesionados=mysqli_fetch_array($verificarVariosLesionados)){
            $arrayVariosLesionados[] = $resVariosLesionados;
        }
    }
}

$text[] = array('text' => $resInformacionCaso["fecha_accidente2"], 'bold' => true);

if ($cont3==1){
    $text[] = array('text' => ' y recibieron atención médica en la IPS ', 'bold' => false);   
}
else{
    $text[] = array('text' => ' y recibió atención médica en la IPS ', 'bold' => false);   
}

$text[] = array('text' => $resInformacionCaso["nombre_ips"], 'bold' => true); 
$text[] = array('text' => ' con Nit: ', 'bold' => false);
$text[] = array('text' => $resInformacionCaso["nit_ips"], 'bold' => true);

if ($resInformacionCaso["fecha_ingreso3"]==$resInformacionCaso["fecha_accidente2"]){
    $text[] = array('text' => ', el mismo día', 'bold' => false);   
}
else{

    $text[] = array('text' => ', el  día ', 'bold' => false);   
    $text[] = array('text' => $resInformacionCaso["fecha_ingreso3"], 'bold' => true);  
}

$text[] = array('text' => ', pretendiendo afectar la Póliza de Seguro Obligatorio de Accidentes de Tránsito SOAT N° ', 'bold' => false);  
$text[] = array('text' => $resInformacionVehiculo["numero_poliza"], 'bold' => true);  
$text[] = array('text' => ' del vehículo tipo ', 'bold' => false);  
$text[] = array('text' => strtoupper($resInformacionVehiculo["tipo_vehiculo"]), 'bold' => true);
$text[] = array('text' => ' con placas ', 'bold' => false);  
$text[] = array('text' => $resInformacionVehiculo["placa"], 'bold' => true);
$text[] = array('text' => ' en condición de ' , 'bold' => false);
$text[] = array('text' => $resInformacionCaso["condicion"], 'bold' => true);

if ($cont3==1){

    if($arrayVariosLesionados[0]["condicion"] != ''){
        $condicionVariosLesionados = ' y '.$arrayVariosLesionados[0]["condicion"].',';
    }else{
        $condicionVariosLesionados = ' y NO REGISTRA CONDICIÓN 2,';
    }

    $text[] = array('text' => $condicionVariosLesionados, 'bold' => true);
}  

$text[] = array('text' => ' por lo cual se cursa reclamación de Gastos Médicos.', 'bold' => false);

if($textoRadicados != ""){
    $text[] = array('text' => ' bajo los radicados ', 'bold' => false); 
    $text[] = array('text' => $textoRadicados.'.', 'bold' => true);
}

if($result != 'no'){
    $text[] = array('text' => ' Concluimos que después de adelantar todo el protocolo investigativo su resultado es: ', 'bold' => false);
    $text[] = array('text' => $resResultado["resultado"], 'bold' => true); 
}

$wf = new WordFragment($docx, 'document');//fragmento de texto
$paragraphOptions = array('font' => 'Arial', 'jc' => 'both');
$wf->addText($text, $paragraphOptions);
$docx->replaceVariableByWordFragment(array('analisis_siniestro' => $wf), array('type' => 'block'));
//unset($wf);
unset($text);

$docx->replaceVariableByWordFragment(array('analisis_siniestro' => $wf), array('type' => 'block'));
//ANALISIS DE VICTIMA
$docx->replaceVariableByText(array('ocupacion_av' => $resInformacionCaso["ocupacion"]));
$docx->replaceVariableByText(array('id_av' => $resInformacionCaso["identificacion_lesionado"]));
$docx->replaceVariableByText(array('edad_av' => $resInformacionCaso["edad"].' AÑOS'));
$docx->replaceVariableByText(array('ciudad_av' => $resInformacionCaso["ciudad_residencia"]));
$docx->replaceVariableByText(array('telefono_av' => $resInformacionCaso["telefono"]));
$docx->replaceVariableByText(array('direccion_av' => $resInformacionCaso["direccion_residencia"]));
$docx->replaceVariableByText(array('barrio_av' => $resInformacionCaso["barrio"]));

if ($resInformacionCaso["servicio_ambulancia"]=="s") {
    mysqli_next_result($con);
    $consultarTipoServicioAmbulancia=mysqli_query($con,"SELECT descripcion as tipo_servicio_ambulancia FROM definicion_tipos WHERE id_tipo=16 and id='".$resInformacionCaso["tipo_traslado_ambulancia"]."'");
    $resTipoServAmb=mysqli_fetch_assoc($consultarTipoServicioAmbulancia);
    
    $docx->replaceVariableByText(array('vehiculo_traslado_av' => 'AMBULANCIA'));
    $docx->replaceVariableByText(array('tipo_traslado_av' => $resTipoServAmb["tipo_servicio_ambulancia"]));
    
    if ($resInformacionCaso["tipo_traslado_ambulancia"]==2){
        $docx->replaceVariableByText(array('ips_atentido_av' => $resInformacionCaso["lugar_traslado"]));
    }else{
        $docx->replaceVariableByText(array('ips_atentido_av' => $resInformacionCaso["nombre_ips"]));
    }
}else{
    mysqli_next_result($con);
    $consultarTipoVehiculoTraslado=mysqli_query($con,"SELECT descripcion as tipo_vehiculo FROM tipo_vehiculos WHERE id='".$resInformacionCaso["tipo_vehiculo_traslado"]."'");
    $resTipoVehiculoTraslado=mysqli_fetch_assoc($consultarTipoVehiculoTraslado);
    $docx->replaceVariableByText(array('vehiculo_traslado_av' => $resTipoVehiculoTraslado["tipo_vehiculo"]));    
    $docx->replaceVariableByText(array('tipo_traslado_av' => ''));

    $docx->replaceVariableByText(array('ips_atentido_av' => $resInformacionCaso["nombre_ips"]));
}

$docx->replaceVariableByText(array('condicion_av' => $resInformacionCaso["condicion"]));

if ($resInformacionCaso["id_indicador_fraude"]==30 || $resInformacionCaso["id_indicador_fraude"]==39){
    $docx->replaceVariableByText(array('lesiones_av' => "SE DESCONOCE"));
    $docx->replaceVariableByText(array('tratamiento_av' => "SE DESCONOCE"));
}
else{
    $docx->replaceVariableByText(array('lesiones_av' => $resInformacionCaso["lesiones"])); 
    $docx->replaceVariableByText(array('tratamiento_av' => $resInformacionCaso["tratamiento"]));
}

$textoSegSocialLesPpl = "";
$wfSegSocial = new WordFragment($docx, 'document');
if ($resInformacionCaso["id_seguridad_social"]==1){
    mysqli_next_result($con);
    $consultarRegimenEPS=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=18 and id='".$resInformacionCaso["regimen"]."'");
    $resRegimenEPS=mysqli_fetch_assoc($consultarRegimenEPS);

    mysqli_next_result($con);
    $consultarEstadoEPS=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=19 and id='".$resInformacionCaso["estado_eps"]."'");
    $resEstadoEPS=mysqli_fetch_assoc($consultarEstadoEPS);

    $textoSegSocialLesPpl = "EPS: ".$resInformacionCaso["eps"]." - REGIMEN: ".$resRegimenEPS["descripcion"]." - ESTADO: ".$resEstadoEPS["descripcion"];
    $wfSegSocial->addText($textoSegSocialLesPpl, array('bold' => false));
}
else if ($resInformacionCaso["id_seguridad_social"]==2){
    $textoSegSocialLesPpl = $resInformacionCaso["seguridad_social"];
    $wfSegSocial->addText($textoSegSocialLesPpl, array('bold' => false));
}
else if ($resInformacionCaso["id_seguridad_social"]==3){
    mysqli_next_result($con);
    $consultarCausalConsulta=mysqli_query($con, "SELECT * FROM definicion_tipos WHERE id_tipo=20 and id='".$resInformacionCaso["causal_consulta"]."'");
    $resCausalConsulta=mysqli_fetch_assoc($consultarCausalConsulta);

    $textoSegSocialLesPpl = $resInformacionCaso["seguridad_social"]." - ".$resCausalConsulta["descripcion"];
    $wfSegSocial->addText($textoSegSocialLesPpl, array('bold' => false));
}

//OBSERVACION SEGURIDAD SOCIAL
$consultarObservacionesNuevas=$consultarObservacionesInforme." AND id_seccion IN (3,4,6)";
    mysqli_next_result($con);
$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas);

if (mysqli_num_rows($queryObservaciones)>0){
    $wfSegSocial->addText('OBSERVACIONES: ', array('bold' => true, 'color' => 'AB1B0D'));
    $cont=0;
    while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones)){
        $cont++;
        $wfSegSocial->addText($resObservaciones["observacion"].'.', array('bold' => false)); 
    }                           
}
$docx->replaceVariableByWordFragment(array('seguridad_social' => $wfSegSocial));

//INVESTIGACIÓN DE CAMPO
$docx->replaceVariableByText(array('direccion_ic' => $resInformacionCaso["lugar_accidente"]));
$docx->replaceVariableByText(array('ciudad_ic' => $resInformacionCaso["ciudad_ocurrencia"]));

if ($resInformacionCaso["visita_lugar_hechos"]=="S"){ 
    $docx->replaceVariableByText(array('punto_referencia_ic' => $resInformacionCaso["punto_referencia"]));
}
else if ($resInformacionCaso["visita_lugar_hechos"]=="N"){
    mysqli_next_result($con);
    $consultarDescripcionVisitaLugarHechos=mysqli_query($con,"SELECT descripcion as descripcion_visita_lugar_hechos FROM definicion_tipos WHERE id_tipo=35 and id=1");
    $visitaLugarHechos=mysqli_fetch_assoc($consultarDescripcionVisitaLugarHechos);
    $docx->replaceVariableByText(array('punto_referencia_ic' => $visitaLugarHechos["descripcion_visita_lugar_hechos"]));
}

mysqli_next_result($con);
$consultarObservacionesNuevas1=$consultarObservacionesInforme." AND id_seccion IN (7,8)";
$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas1);
if (mysqli_num_rows($queryObservaciones)>0){
    $wfObsInvCampo = new WordFragment($docx, 'document');
    $wfObsInvCampo->addText('OBSERVACIONES: ', array('bold' => true, 'color' => 'AB1B0D'));
    $cont=0;
    while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones)){
        $cont++;
        $wfObsInvCampo->addText($resObservaciones["observacion"].'.', array('bold' => false)); 
    }
    $docx->replaceVariableByWordFragment(array('OBS_INV_CMP_REF' => $wfObsInvCampo), array('type' => 'block'));
}else{
    $docx->removeTemplateVariable('OBS_INV_CMP_REF', 'block');
} 

$consultarRegistroAutoridades="SELECT descripcion as descripcion_registro_autoridades FROM definicion_tipos WHERE id_tipo=35 and ";
if ($resInformacionCaso["registro_autoridades"]=="S"){
    $consultarRegistroAutoridades.=" id='2'";
}
else{
    $consultarRegistroAutoridades.=" id='3'";
}
mysqli_next_result($con);
$queryRegistroAutoridades=mysqli_query($con,$consultarRegistroAutoridades);
$resRegistroAutoridades=mysqli_fetch_assoc($queryRegistroAutoridades);

$docx->replaceVariableByText(array('registro_autoridades_ic' => $resRegistroAutoridades["descripcion_registro_autoridades"]));
if ($resInformacionCaso["visita_lugar_hechos"]=="S"){
 
    $consultarTestigos="SELECT CONCAT(b.nombres,' ',b.apellidos) as nombre_testigo,concat(c.descripcion,' ',b.identificacion) as identificacion_testigo,b.telefono,b.direccion_residencia
    FROM testigos a
    LEFT JOIN personas b ON a.id_persona=b.id
    LEFT JOIN definicion_tipos c ON c.id=b.tipo_identificacion
    WHERE a.id_investigacion='".$resInformacionCaso["id_caso"]."' and c.id_tipo=5";
    mysqli_next_result($con);
    $queryTestigos=mysqli_query($con,$consultarTestigos);

    if (mysqli_num_rows($queryTestigos)>0){
        
        $infoTestigos = new WordFragment($docx);
        $infoTestigos->addText("TESTIGOS: Se indagó con los moradores del sector quienes confirman la real ocurrencia de los hechos, entre ellos:", array('bold' => true)); 

        $textTemp = array();
        $textThTest2 = new WordFragment($docx);
        $textTemp[] = array('text' => 'IDENTIFICACIÓN:', 'bold' => true);
        $textThTest2->addText($textTemp);

        $textTemp = array();
        $textThTest3 = new WordFragment($docx);
        $textTemp[] = array('text' => "TELÉFONO:", 'bold' => true);
        $textThTest3->addText($textTemp);

        $textTemp = array();
        $textThTest4 = new WordFragment($docx);
        $textTemp[] = array('text' => "DIRECCIÓN:", 'bold' => true);
        $textThTest4->addText($textTemp);

        $rowsTBTest = array();
        $i = 1;
        while ($resTestigos=mysqli_fetch_assoc($queryTestigos)){

            $textTemp = array();
            $textThTest1 = new WordFragment($docx);
            $textTemp[] = array('text' => 'TESTIGO #'.$i.':', 'bold' => true);
            $textThTest1->addText($textTemp);

            $rowsTBTest[] = array(array(
                    'value' => $textThTest1, 
                    'backgroundColor' => '8EAADB'
                ),
                array(
                    'value' => $textThTest2, 
                    'backgroundColor' => 'D7E4CF'
                )
            );

            $rowsTBTest[] = array(
                "    ".$resTestigos['nombre_testigo'],
                "    ".$resTestigos['identificacion_testigo']
            );

            $rowsTBTest[] = array(array(
                    'value' => $textThTest3, 
                    'backgroundColor' => 'D7E4CF'
                ),
                array(
                    'value' => $textThTest4, 
                    'backgroundColor' => 'D7E4CF'
                )
            );

            $rowsTBTest[] = array(
                "    ".$resTestigos['telefono'],
                "    ".$resTestigos['direccion_residencia']
            );

            $i++;
        }

        $paramTbOtroLes = array(
            'border' => 'none',
            'tableAlign' => 'center',
            'textProperties' => array('font' => 'Calibri', 'fontSize' => 11)
        );
        $infoTestigos->addTable($rowsTBTest, $paramTbOtroLes);
        $docx->replaceVariableByWordFragment(array('testigos_ic' => $infoTestigos), array('type' => 'block'));
    }
    else {
        $docx->replaceVariableByText(array('testigos_ic' => "En el lugar de los hechos no se encontraron testigos, a pesar de la labor de campo realizada.")); 
    }
}
else{   
    $docx->replaceVariableByText(array('testigos_ic' => "No se aportan testigos ya que es una zona fuera del perímetro urbano autorizado."));
}

mysqli_next_result($con);
$consultarObservacionesNuevas2=$consultarObservacionesInforme." AND id_seccion IN (10)";
$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas2);
if (mysqli_num_rows($queryObservaciones)>0){
    $wfObsInvCampo = new WordFragment($docx, 'document');
    $wfObsInvCampo->addText('OBSERVACIONES: ', array('bold' => true, 'color' => 'AB1B0D'));
    $cont=0;
    while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones)){
        $cont++;
        $wfObsInvCampo->addText($resObservaciones["observacion"].'.', array('bold' => false)); 
    }
    $docx->replaceVariableByWordFragment(array('OBS_INV_CMP_TES' => $wfObsInvCampo), array('type' => 'block'));
}else{
    $docx->removeTemplateVariable('OBS_INV_CMP_TES', 'block');
} 

//DILIGENCIAS ADELANTAS
if ($resInformacionCaso["id_aseguradora"]==1){
    $text[] = array('text' => 'Según registro del FURIPS/FURTRAN emitido por ', 'bold' => false);
}
else{ 
    $text[] = array('text' => 'Según registro de la HOJA DE INGRESO emitido por ', 'bold' => false);
}

$text[] = array('text' => $resInformacionCaso["nombre_ips"]." ", 'bold' => true);
$text[] = array('text' => $resInformacionCaso["furips"], 'bold' => false);

$wf_diligencias_adelantadas = new WordFragment($docx, 'document');//fragmento de texto
$wf_diligencias_adelantadas->addText($text, $paragraphOptions);
$docx->replaceVariableByWordFragment(array('diligencias_adelantadas' => $wf_diligencias_adelantadas, ), array('type' => 'block'));

mysqli_next_result($con);
$consultarObservacionesNuevas3=$consultarObservacionesInforme." AND id_seccion IN (1,2)";
$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas3);
if (mysqli_num_rows($queryObservaciones)>0){
    $wfObsInvCampo = new WordFragment($docx, 'document');
    $wfObsInvCampo->addText('OBSERVACIONES: ', array('bold' => true, 'color' => 'AB1B0D'));
    $cont=0;
    while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones)){
        $cont++;
        $wfObsInvCampo->addText($resObservaciones["observacion"].'.', array('bold' => false)); 
    }
    $docx->replaceVariableByWordFragment(array('OBS_FURIPS' => $wfObsInvCampo), array('type' => 'block'));
}else{
    $docx->removeTemplateVariable('OBS_FURIPS', 'block');
}

//DILIGENCIA FORMATO DE DECLARACION
if ($resInformacionCaso["diligencia_formato_declaracion"]=="1"){

    $consultarInfoDiligencia="SELECT CONCAT(a.nombres,' ',a.apellidos) AS nombre_diligencia,
    concat(b.descripcion,' ',a.identificacion) as identificacion,'LESIONADO' as relacion
    FROM personas a 
    LEFT JOIN definicion_tipos b ON a.tipo_identificacion=b.id 
    WHERE b.id_tipo=5 AND a.id='".$resInformacionCaso["id_diligencia_formato_declaracion"]."'";
}
else if ($resInformacionCaso["diligencia_formato_declaracion"]=="3"){
            
    $consultarInfoDiligencia="SELECT CONCAT(a.nombres,' ',a.apellidos) AS nombre_diligencia,
    CONCAT(b.descripcion,' ',a.identificacion) AS identificacion, 'INVESTIGADOR' AS relacion
    FROM investigadores a 
    LEFT JOIN definicion_tipos b ON a.tipo_identificacion=b.id  
    WHERE b.id_tipo=5 AND a.id='".$resInformacionCaso["id_diligencia_formato_declaracion"]."'";
}
else if ($resInformacionCaso["diligencia_formato_declaracion"]=="2"){

    $consultarInfoDiligencia="SELECT a.nombre AS nombre_diligencia,
    concat(b.descripcion,' ',a.identificacion) as identificacion,a.relacion
    FROM personas_diligencia_formato_declaracion a 
    LEFT JOIN definicion_tipos b ON a.tipo_identificacion=b.id      
    WHERE b.id_tipo=5 AND a.id='".$resInformacionCaso["id_diligencia_formato_declaracion"]."'";
}
else {
    $consultarInfoDiligencia="SELECT * FROM definicion_tipos WHERE id_tipo=36 and id='".$resInformacionCaso["diligencia_formato_declaracion"]."'";
}

mysqli_next_result($con);
$queryDiligencia=mysqli_query($con,$consultarInfoDiligencia);
$resDiligencia=mysqli_fetch_assoc($queryDiligencia);

$tablaDilDecla = new WordFragment($docx);
if ($resInformacionCaso["diligencia_formato_declaracion"]=="4" || $resInformacionCaso["diligencia_formato_declaracion"]=="5"){

    $textTemp = array();
    $textTemp[] = array('text' => "DILIGENCIA EL FORMATO DE DECLARACION: ", 'bold' => true);

    if($resInformacionCaso["diligencia_formato_declaracion"] == 4){
        $textTemp[] = array('text' => "CONTACTADO VIA TELÉFONICA.", 'bold' => false);
    }else{
        $textTemp[] = array('text' => "NO SE PUDO CONTACTAR.", 'bold' => false);
    }

    $tablaDilDecla->addText($textTemp);
}
else{
    if ($resInformacionCaso["diligencia_formato_declaracion"]==1) {

        $consultarPersonaDiligencia="SELECT CONCAT(a.nombres,' ',a.apellidos) as nombre_diligencia_formato,CONCAT(b.descripcion,' ',a.identificacion) as identificacion_diligencia_formato,'LESIONADO' as relacion
        FROM personas a
        LEFT JOIN definicion_tipos b ON a.tipo_identificacion=b.id
        WHERE b.id_tipo=5 and a.id='".$resInformacionCaso["id_diligencia_formato_declaracion"]."'";
    }
    else if ($resInformacionCaso["diligencia_formato_declaracion"]==2){

        $consultarPersonaDiligencia="SELECT a.nombre as nombre_diligencia_formato,CONCAT(b.descripcion,' ',a.identificacion) as identificacion_diligencia_formato, a.relacion
        FROM personas_diligencia_formato_declaracion a
        LEFT JOIN definicion_tipos b ON a.tipo_identificacion=b.id
        WHERE b.id_tipo=5 and a.id='".$resInformacionCaso["id_diligencia_formato_declaracion"]."'";
    }
    else if ($resInformacionCaso["diligencia_formato_declaracion"]==3) {
        
        $consultarPersonaDiligencia="SELECT  CONCAT(a.nombres,' ',a.apellidos) as nombre_diligencia_formato,CONCAT(b.descripcion,' ',a.identificacion) as identificacion_diligencia_formato,'INVESTIGADOR' as relacion
        FROM investigadores a
        LEFT JOIN definicion_tipos b ON a.tipo_identificacion=b.id
        WHERE b.id_tipo=5 and a.id='".$resInformacionCaso["id_diligencia_formato_declaracion"]."'";
    }

    mysqli_next_result($con);
    $queryConsultarPersonaDiligencia=mysqli_query($con,$consultarPersonaDiligencia);
    $resPersonaDiligencia=mysqli_fetch_assoc($queryConsultarPersonaDiligencia);

    $textTemp = array();
    $textThDilDecla1 = new WordFragment($docx);
    $textTemp[] = array('text' => 'DILIGENCIA EL FORMATO DE DECLARACION: ', 'bold' => true);
    $textThDilDecla1->addText($textTemp);

    $textTemp = array();
    $textThDilDecla2 = new WordFragment($docx);
    $textTemp[] = array('text' => 'IDENTIFICACION:', 'bold' => true);
    $textThDilDecla2->addText($textTemp);

    $textTemp = array();
    $textThDilDecla3 = new WordFragment($docx);
    $textTemp[] = array('text' => 'RELACION CON LA VICTIMA:', 'bold' => true);
    $textThDilDecla3->addText($textTemp);

    $valuesTbDilDecla = array(
        array(
            array(
                'value' => $textThDilDecla1, 
                'backgroundColor' => 'FFEFC1',
                'colspan' => 2
            )
        ),
        array(
            "    ".$resPersonaDiligencia['nombre_diligencia_formato']
        ),
        array(
            array(
                'value' => $textThDilDecla2, 
                'backgroundColor' => 'FFEFC1'
            ),
            array(
                'value' => $textThDilDecla3, 
                'backgroundColor' => 'FFEFC1'
            )
        ),
        array(
            "    ".$resPersonaDiligencia['identificacion_diligencia_formato'],
            "    ".$resPersonaDiligencia['relacion']
        )
    );

    $paramTbDilDecla = array(
        'border' => 'none',
        'tableAlign' => 'center',
        'textProperties' => array('font' => 'Calibri', 'fontSize' => 11)
    );

    $tablaDilDecla->addTable($valuesTbDilDecla, $paramTbDilDecla);
}

$docx->replaceVariableByWordFragment(array('diligencia_formato' => $tablaDilDecla), array('type' => 'block'));

//RELATO DE LOS HECHOS O LABOR REALIZADA
mysqli_next_result($con);
$queryConsultarIndicadoresOcurrencia=mysqli_query($con,"SELECT * FROM definicion_tipos where id_tipo=37 and descripcion='".$resInformacionCaso["id_indicador_fraude"]."'");

if (mysqli_num_rows($queryConsultarIndicadoresOcurrencia)>0){
    $docx->replaceVariableByText(array('titulo_relato' => 'LABOR REALIZADA:'));
}
else{
    $docx->replaceVariableByText(array('titulo_relato' => 'RELATO DE LOS HECHOS:'));
}
//RELATO
$wfRelato = new WordFragment($docx, 'document');//fragmento de texto
$wfRelato->addText('"'.$resInformacionCaso["relato"].'"', array('italic' => true, 'bold' => true, 'jc' => 'both', 'font' => 'Calibri'));
$docx->replaceVariableByWordFragment(array('relato' => $wfRelato), array('type' => 'block'));

mysqli_next_result($con);
$consultarObservacionesNuevas4=$consultarObservacionesInforme." AND id_seccion IN (20)";
$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas4);
if (mysqli_num_rows($queryObservaciones)>0){
    $wfObsInvCampo = new WordFragment($docx, 'document');
    $wfObsInvCampo->addText('OBSERVACIONES: ', array('bold' => true, 'color' => 'AB1B0D'));
    $cont=0;
    while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones)){
        $cont++;
        $wfObsInvCampo->addText($resObservaciones["observacion"].'.', array('bold' => false)); 
    }
    $docx->replaceVariableByWordFragment(array('OBS_RELATO' => $wfObsInvCampo), array('type' => 'block'));
}else{
    $docx->removeTemplateVariable('OBS_RELATO', 'block');
}

//ANÁLISIS DE POLIZA
$docx->replaceVariableByText(array('inicio_poliza' => $resInformacionVehiculo["inicio_vigencia"]));
$docx->replaceVariableByText(array('fin_poliza' => $resInformacionVehiculo["fin_vigencia"]));
$docx->replaceVariableByText(array('nombre_tomador' => $resInformacionVehiculo["nombre_tomador"]));
$docx->replaceVariableByText(array('id_tomador' => $resInformacionVehiculo["identificacion_tomador"]));
$docx->replaceVariableByText(array('telefono_tomador' => $resInformacionVehiculo["telefono_tomador"]));
$docx->replaceVariableByText(array('direccion_tomador' => $resInformacionVehiculo["direccion_tomador"]));
$docx->replaceVariableByText(array('ciudad_tomador' => $resInformacionVehiculo["ciudad_tomador"]));
$docx->replaceVariableByText(array('ciudad_poliza' => $resInformacionVehiculo["ciudad_expedicion_poliza"]));
//ENTREVISTA A TOMADOR O PROPIETARIO
if ($resInformacionCaso["resultado_diligencia_tomador"]<>4) {
    mysqli_next_result($con);
    $consultarDescripcionDiligenciaTomador=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=38 and id='".$resInformacionCaso["resultado_diligencia_tomador"]."'");
    $resDescripcionDiligenciaTomador=mysqli_fetch_assoc($consultarDescripcionDiligenciaTomador);
    $docx->replaceVariableByText(array('pre_entrevista' => 'RESULTADO'));
    $docx->replaceVariableByText(array('entrevista_tomador' => $resDescripcionDiligenciaTomador["descripcion2"]));
}   
else{
    $docx->replaceVariableByText(array('pre_entrevista' => 'Expresa lo siguiente'));
    $docx->replaceVariableByText(array('entrevista_tomador' => $resInformacionCaso["observaciones_diligencia_tomador"]));
}
//INSPECCION DEL VEHICULO
$docx->replaceVariableByText(array('marca_vh' => $resInformacionVehiculo["marca"]));
$docx->replaceVariableByText(array('linea_vh' => $resInformacionVehiculo["linea"]));
$docx->replaceVariableByText(array('color_vh' => $resInformacionVehiculo["color"]));
$docx->replaceVariableByText(array('modelo_vh' => $resInformacionVehiculo["modelo"]));
$docx->replaceVariableByText(array('vin_vh' => $resInformacionVehiculo["numero_vin"]));
$docx->replaceVariableByText(array('tipo_servicio_vh' => $resInformacionVehiculo["tipo_servicio"]));
$docx->replaceVariableByText(array('serie_vh' => $resInformacionVehiculo["numero_serie"]));
$docx->replaceVariableByText(array('motor_vh' => $resInformacionVehiculo["numero_motor"]));
$docx->replaceVariableByText(array('chasis_vh' => $resInformacionVehiculo["numero_chasis"]));

mysqli_next_result($con);
$consultarObservacionesNuevas5=$consultarObservacionesInforme." AND id_seccion IN (12,11)";
$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas5);
if (mysqli_num_rows($queryObservaciones)>0){
    $wfObsInvCampo = new WordFragment($docx, 'document');
    $wfObsInvCampo->addText('OBSERVACIONES: ', array('bold' => true, 'color' => 'AB1B0D'));
    $cont=0;
    while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones)){
        $cont++;
        $wfObsInvCampo->addText($resObservaciones["observacion"].'.', array('bold' => false)); 
    }
    $docx->replaceVariableByWordFragment(array('OBS_VEHICULO' => $wfObsInvCampo), array('type' => 'block'));
}else{
    $docx->removeTemplateVariable('OBS_VEHICULO', 'block');
}

//ANÁLISIS OTROS LESIONADOS
if ($cont3>0){  

    $paramTbOtroLes = array(
        'border' => 'none',
        'tableAlign' => 'center',
        'textProperties' => array('font' => 'Calibri', 'fontSize' => 11)
    );        
    $tablaOtroLes = new WordFragment($docx);
    $docx->replaceVariableByText(array('TITULO_OTRAS_VIC' => 'ANÁLISIS DE LAS OTRAS VICTIMAS:'));
    foreach ($arrayVariosLesionados as $resVariosLesionados) {
        $textTemp = array();
        $textThLs1 = new WordFragment($docx);
        $textTemp[] = array('text' => 'NOMBRE VÍCTIMA:', 'bold' => true);
        $textThLs1->addText($textTemp);

        $textTemp = array();
        $textThLs2 = new WordFragment($docx);
        $textTemp[] = array('text' => 'OCUPACIÓN:', 'bold' => true);
        $textThLs2->addText($textTemp);

        $textTemp = array();
        $textThLs3 = new WordFragment($docx);
        $textTemp[] = array('text' => "IDENTIFICACIÓN:", 'bold' => true);
        $textThLs3->addText($textTemp);

        $textTemp = array();
        $textThLs4 = new WordFragment($docx);
        $textTemp[] = array('text' => "EDAD:", 'bold' => true);
        $textThLs4->addText($textTemp);

        $textTemp = array();
        $textThLs5 = new WordFragment($docx);
        $textTemp[] = array('text' => "CIUDAD/MUNICIPIO:", 'bold' => true);
        $textThLs5->addText($textTemp);

        $textTemp = array();
        $textThLs6 = new WordFragment($docx);
        $textTemp[] = array('text' => "TELÉFONO:", 'bold' => true);
        $textThLs6->addText($textTemp);

        $textTemp = array();
        $textThLs7 = new WordFragment($docx);
        $textTemp[] = array('text' => "DIRECCIÓN:", 'bold' => true);
        $textThLs7->addText($textTemp);

        $textTemp = array();
        $textThLs8 = new WordFragment($docx);
        $textTemp[] = array('text' => "BARRIO:", 'bold' => true);
        $textThLs8->addText($textTemp);

        $textTemp = array();
        $textThLs9 = new WordFragment($docx);
        $textTemp[] = array('text' => "VEHICULO DE TRASLADO:", 'bold' => true);
        $textThLs9->addText($textTemp);

        $textTemp = array();
        $textThLs10 = new WordFragment($docx);
        $textTemp[] = array('text' => "TIPO DE TRASLADO:", 'bold' => true);
        $textThLs10->addText($textTemp);

        $textTemp = array();
        $textThLs11 = new WordFragment($docx);
        $textTemp[] = array('text' => "CLINICA DONDE FUE ATENDIDO:", 'bold' => true);
        $textThLs11->addText($textTemp);

        $textTemp = array();
        $textThLs12 = new WordFragment($docx);
        $textTemp[] = array('text' => "CONDICION VÍCTIMA:", 'bold' => true);
        $textThLs12->addText($textTemp);

        $textTemp = array();
        $textThLs13 = new WordFragment($docx);
        $textTemp[] = array('text' => "LESIONES:", 'bold' => true);
        $textThLs13->addText($textTemp);

        $textTemp = array();
        $textThLs14 = new WordFragment($docx);
        $textTemp[] = array('text' => "TRATAMIENTO:", 'bold' => true);
        $textThLs14->addText($textTemp);

        $textTemp = array();
        $textThLs15 = new WordFragment($docx);
        $textTemp[] = array('text' => "AFILIACION AL SISTEMA DE SEGURIDAD SOCIAL:", 'bold' => true);
        $textThLs15->addText($textTemp);

        $textoSegSocialLes = "";
        if ($resVariosLesionados["id_seguridad_social"]==1){
            mysqli_next_result($con);
            $consultarRegimenEPS=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=18 and id='".$resVariosLesionados["regimen"]."'");
            $resRegimenEPS=mysqli_fetch_assoc($consultarRegimenEPS);

            mysqli_next_result($con);
            $consultarEstadoEPS=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=19 and id='".$resVariosLesionados["estado_eps"]."'");
            $resEstadoEPS=mysqli_fetch_assoc($consultarEstadoEPS);
            
            $textoSegSocialLes = 'EPS: '.$resVariosLesionados["eps"].' - REGIMEN: '.$resRegimenEPS["descripcion"].' - ESTADO: '.$resEstadoEPS["descripcion"];
        }
        else if ($resVariosLesionados["id_seguridad_social"]==2){         
            $textoSegSocialLes = $resVariosLesionados["seguridad_social"];
        }
        else if ($resVariosLesionados["id_seguridad_social"]==3){
            mysqli_next_result($con);
            $consultarCausalConsulta=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=20 and id='".$resVariosLesionados["causal_consulta"]."'");
            $resCausalConsulta=mysqli_fetch_assoc($consultarCausalConsulta);
            $textoSegSocialLes = $resVariosLesionados["seguridad_social"]." - ".$resCausalConsulta["descripcion"];
        }

        $valuesTbOtroLes = array(
            array(
                array(
                    'value' => $textThLs1, 
                    'backgroundColor' => 'E2EFD9'
                ),
                array(
                    'value' => $textThLs2, 
                    'backgroundColor' => 'E2EFD9'
                )
            ),
            array(
                "    ".$resVariosLesionados['nombre_lesionado'],
                "    ".$resVariosLesionados['ocupacion']
            ),
            array(
                array(
                    'value' => $textThLs3, 
                    'backgroundColor' => 'E2EFD9'
                ),
                array(
                    'value' => $textThLs4, 
                    'backgroundColor' => 'E2EFD9'
                )
            ),
            array(
                "    ".$resVariosLesionados['identificacion_lesionado'],
                "    ".$resVariosLesionados['edad'].' Años'
            ),
            array(
                array(
                    'value' => $textThLs5, 
                    'backgroundColor' => 'E2EFD9'
                ),
                array(
                    'value' => $textThLs6, 
                    'backgroundColor' => 'E2EFD9'
                )
            ),
            array(
                "    ".$resVariosLesionados['ciudad_residencia'],
                "    ".$resVariosLesionados['telefono']
            ),
            array(
                array(
                    'value' => $textThLs7, 
                    'backgroundColor' => 'E2EFD9'
                ),
                array(
                    'value' => $textThLs8, 
                    'backgroundColor' => 'E2EFD9'
                )
            ),
            array(
                "    ".$resVariosLesionados['direccion_residencia'],
                "    ".$resVariosLesionados['barrio']
            ),
            array(
                array(
                    'value' => $textThLs9, 
                    'colspan' => 2,
                    'backgroundColor' => 'E2EFD9'
                )
            ),
            array(
                "    ".$resVariosLesionados['traslado']
            ),
            array(
                array(
                    'value' => $textThLs11, 
                    'backgroundColor' => 'E2EFD9'
                ),
                array(
                    'value' => $textThLs12, 
                    'backgroundColor' => 'E2EFD9'
                )
            ),
            array(
                "    ".$resVariosLesionados['nombre_ips'],
                "    ".$resVariosLesionados['condicion']
            ),
            array(
                array(
                    'value' => $textThLs13, 
                    'colspan' => 2,
                    'backgroundColor' => 'E2EFD9'
                )
            ),
            array(
                array(
                    'value' => $resVariosLesionados['lesiones'], 
                    'colspan' => 2
                )
            ),
            array(
                array(
                    'value' => $textThLs14, 
                    'colspan' => 2,
                    'backgroundColor' => 'E2EFD9'
                )
            ),
            array(
                array(
                    'value' => $resVariosLesionados['tratamiento'], 
                    'colspan' => 2
                )
            ),
            array(
                array(
                    'value' => $textThLs15, 
                    'colspan' => 2,
                    'backgroundColor' => 'E2EFD9'
                )
            ),
            array(
                array(
                    'value' => $textoSegSocialLes, 
                    'colspan' => 2
                )
            )
        );

        $tablaOtroLes->addTable($valuesTbOtroLes, $paramTbOtroLes);
    }
     
    $docx->replaceVariableByWordFragment(array('analisis_otras_vic' => $tablaOtroLes), array('type' => 'block'));
}else{
    $docx->removeTemplateVariable('TITULO_OTRAS_VIC', 'block');
    $docx->removeTemplateVariable('analisis_otras_vic', 'block');
}

$otrosIngresosPoliza=mysqli_query($con,"SELECT c.resultado, a.id, CONCAT(d.nombres,' ',d.apellidos) AS nombre_lesionado,CONCAT(e.descripcion,' ',d.identificacion) AS identificacion_lesionado, f.nombre_ips,d.ocupacion,d.edad,d.direccion_residencia, d.barrio, b.lugar_accidente, b.punto_referencia,CONCAT(g.nombre,' - ',h.nombre) AS ciudad,d.telefono,c.condicion,c.lesiones,c.tratamiento,f.nombre_ips,b.fecha_accidente,c.fecha_ingreso,c.fecha_egreso,a.codigo, (SELECT a1.descripcion2 FROM definicion_tipos a1 LEFT JOIN aseguradoras b1 ON (a1.id = b1.resultado_atender OR a1.id = b1.resultado_no_atender) WHERE a1.id_tipo = 10 AND b1.id = a.id_aseguradora AND a1.descripcion = c.resultado) AS concepto, UPPER(CONCAT(i.nombres,' ',i.apellidos)) AS nombres_investigador, i.identificacion AS identificacion_investigador, b.furips
        FROM detalle_investigaciones_soat b
        LEFT JOIN investigaciones a ON a.id=b.id_investigacion
        LEFT JOIN personas_investigaciones_soat c ON c.id_investigacion=a.id
        LEFT JOIN personas d ON d.id=c.id_persona
        LEFT JOIN definicion_tipos e ON e.id=d.tipo_identificacion AND e.id_tipo=5
        LEFT JOIN ips f ON f.id=c.ips
        LEFT JOIN ciudades g ON g.id=d.ciudad_residencia
        LEFT JOIN departamentos h ON h.id=g.id_departamento
        LEFT JOIN investigadores i ON i.id = a.id_investigador
        WHERE b.id_poliza='".$resInformacionCaso["id_poliza"]."' and b.id_investigacion<>'".$resInformacionCaso["id_caso"]."'");

//contador de siniestros para Tendencia de Fraude y contamos este caso como el primero
$ctp = 1;
$ctl = 1; $cnl = 2; $cal = 3;
$ctv = 1; $cnv = 8; $cav = 9;
$ctt = 1; $cnt = 11; $cat = 12;
if($resInformacionCaso['resultado'] == 1){
    $cnp = 0; $cap = 1;
    $cnl = 0; $cal = 1;
    $cnv = 0; $cav = 1;
    $cnt = 0; $cat = 1;
}else{
    $cnp = 1; $cap = 0;
    $cnl = 1; $cal = 0;
    $cnv = 1; $cav = 0;
    $cnt = 1; $cat = 0;
}

if(mysqli_num_rows($otrosIngresosPoliza)>0){

    $tablaIngPol = new WordFragment($docx);

    $docx->replaceVariableByText(array('TITULO_HISTORIAL' => 'HISTORIAL DE SINIESTROS PARA LA PÓLIZA:'));
    
    while ($resIngresosPoliza=mysqli_fetch_assoc($otrosIngresosPoliza)) {
        //contador de siniestros por polizas
        $ctp++;
        if($resIngresosPoliza['resultado']==1){
            $cap++;
        }else{
            $cnp++;
        }

        $textTemp = array();
        $textThIngPolTit = new WordFragment($docx);
        $textTemp[] = array('text' => "HISTORIAL REGISTRO OTROS INGRESOS POLIZA No. ".$resInformacionVehiculo["numero_poliza"], 'bold' => true, 'color' => 'FFFFFF');
        $textThIngPolTit->addText($textTemp);

        $textTemp = array();
        $textThIngPol1 = new WordFragment($docx);
        $textTemp[] = array('text' => 'FECHA DE ACCIDENTE', 'bold' => true);
        $textThIngPol1->addText($textTemp);

        $textTemp = array();
        $textThIngPol2 = new WordFragment($docx);
        $textTemp[] = array('text' => 'FECHA DE INGRESO A CLINICA', 'bold' => true);
        $textThIngPol2->addText($textTemp);

        $textTemp = array();
        $textThIngPol3 = new WordFragment($docx);
        $textTemp[] = array('text' => 'CLINICA DONDE FUE ATENDIDO', 'bold' => true);
        $textThIngPol3->addText($textTemp);

        $textTemp = array();
        $textThIngPol4 = new WordFragment($docx);
        $textTemp[] = array('text' => 'CODIGO CASO: ', 'bold' => true);
        $textThIngPol4->addText($textTemp);

        $textTemp = array();
        $textThIngPol5 = new WordFragment($docx);
        $textTemp[] = array('text' => 'CONCEPTO: ', 'bold' => true);
        $textThIngPol5->addText($textTemp);

        $textTemp = array();
        $textThIngPol6 = new WordFragment($docx);
        $textTemp[] = array('text' => 'DIRECCION DE LOS HECHOS: ', 'bold' => true);
        $textThIngPol6->addText($textTemp);

        //TERCERA PARTE
        $textTemp = array();
        $textThIngPol7 = new WordFragment($docx);
        $textTemp[] = array('text' => 'ANÁLISIS DE LA VÍCTIMA', 'bold' => true);
        $textThIngPol7->addText($textTemp);

        $textTemp = array();
        $textThIngPol8 = new WordFragment($docx);
        $textTemp[] = array('text' => 'NOMBRE: ', 'bold' => true);
        $textThIngPol8->addText($textTemp);

        $textTemp = array();
        $textThIngPol9 = new WordFragment($docx);
        $textTemp[] = array('text' => 'IDENTIFICACION: ', 'bold' => true);
        $textThIngPol9->addText($textTemp);

        $valuesTbIngPol = array(
            array(
                array(
                    'value' => $textThIngPolTit, 
                    'backgroundColor' => '1d3654',
                    'colspan' => 2
                )
            ),
            array(
                array(
                    'value' => $textThIngPol1, 
                    'backgroundColor' => 'FFEFC1'
                ),
                array(
                    'value' => $textThIngPol2, 
                    'backgroundColor' => 'FFEFC1'
                )
            ),
            array(
                "    ".$resIngresosPoliza['fecha_accidente'],
                "    ".$resIngresosPoliza['fecha_ingreso']
            ),
            array(
                array(
                    'value' => $textThIngPol3, 
                    'backgroundColor' => 'FFEFC1',
                    'colspan' => 2
                )
            ),
            array(
                "    ".$resIngresosPoliza['nombre_ips']
            ),
            array(
                array(
                    'value' => $textThIngPol4, 
                    'backgroundColor' => 'FFEFC1'
                ),
                array(
                    'value' => $textThIngPol5, 
                    'backgroundColor' => 'FFEFC1'
                )
            ),
            array(
                "    ".$resIngresosPoliza['codigo'],
                "    ".$resIngresosPoliza['concepto']
            ),
            array(
                array(
                    'value' => $textThIngPol6, 
                    'backgroundColor' => 'FFEFC1',
                    'colspan' => 2
                )
            ),
            array(
                "    ".$resIngresosPoliza['lugar_accidente']
            ),
            array(
                array(
                    'value' => $textThIngPol8, 
                    'backgroundColor' => 'FFEFC1'
                ),
                array(
                    'value' => $textThIngPol9, 
                    'backgroundColor' => 'FFEFC1'
                )
            ),
            array(
                "    ".$resIngresosPoliza['nombre_lesionado'],
                "    ".$resIngresosPoliza['identificacion_lesionado']
            )
        );

        $paramTbIngPol = array(
            'border' => 'none',
            'tableAlign' => 'center',
            'textProperties' => array('font' => 'Calibri', 'fontSize' => 11)
        );

        $tablaIngPol->addTable($valuesTbIngPol, $paramTbIngPol);
    }
    
    $tablaIngPol->addBreak(array('type' => 'line', 'number' => 2));

    $docx->replaceVariableByWordFragment(array('registros_poliza' => $tablaIngPol), array('type' => 'block'));
}else{
    $docx->removeTemplateVariable('TITULO_HISTORIAL', 'block');
    $docx->removeTemplateVariable('registros_poliza', 'block');
}

//CONCLUSIONES
$wfConclusion = new WordFragment($docx, 'document');//fragmento de texto
$paragraphOptions = array('jc' => 'both');
$wfConclusion->addText($resInformacionCaso["conclusiones"], $paragraphOptions);

//RESULTADO A CONSIDERACION
$query = "SELECT ps.resultado, ps.indicador_fraude
    FROM personas_investigaciones_soat ps
    WHERE ps.tipo_persona = 1 AND ps.resultado = 1 AND ps.indicador_fraude = 13 AND ps.id_investigacion = ".$id_caso;

mysqli_next_result($con);
$resConclusiones=mysqli_query($con,$query);
if(!empty($resConclusiones) AND mysqli_num_rows($resConclusiones) > 0){

    $queryTraerSeleccion = "SELECT ps.resultado, ps.indicador_fraude, ci.id_conclusion, c.descripcion
      FROM personas_investigaciones_soat ps
      LEFT JOIN conclusiones_inconsistencias_investigaciones ci ON ci.id_investigacion = ps.id_investigacion
      LEFT JOIN conclusiones_inconsistencias c ON c.id = ci.id_conclusion
      WHERE ps.tipo_persona = 1 AND ps.resultado = 1 AND ps.id_investigacion = ".$id_caso." AND ci.activo = 's'";
    mysqli_next_result($con);
    $resQuerySeleccion = mysqli_query($con, $queryTraerSeleccion);

    if(!empty($resQuerySeleccion) AND mysqli_num_rows($resQuerySeleccion) > 0){

        $aplica = 1;

        if (mysqli_num_rows($resQuerySeleccion) == 1) {
            $res=mysqli_fetch_array($resQuerySeleccion,MYSQLI_ASSOC);
            if($res['id_conclusion'] == '7'){
                $aplica = 2;
            }else{
                $aplica = 1;
            }
        }

        if ($aplica == 1) {
            $wfConclusion->addText('RESULTADO A CONSIDERACION: ', array('bold' => true, 'color' => 'AB1B0D'));

            $wfConclusion->addText("Se deja a consideración de la compañía el resultado final de la investigación, debido a inconsistencias que se evidencian en el proceso, las cuales se describen a continuación:", array('bold' => false, 'jc' => 'both'));

            mysqli_next_result($con);
            $resQueryAConsideracion = mysqli_query($con, $queryTraerSeleccion);
            $itemListOcu = array();

            while ($res=mysqli_fetch_array($resQueryAConsideracion,MYSQLI_ASSOC)){
                
                if($res['id_conclusion']!=1){
                    $itemListOcu[] = $res['descripcion'];
                }
            }
            //$wfConclusion->addText($res['descripcion'], array('bold' => false, 'jc' => 'both'));
            $wfConclusion->addList($itemListOcu, 1);
        }
    }
}

$docx->replaceVariableByWordFragment(array('conclusiones' => $wfConclusion));


//TENDENCIA A FRAUDE
mysqli_next_result($con);
$sqlTenFraude=mysqli_query($con,"CALL consultaSQL(4,'".$resInformacionCaso["id_caso"]."','','','','')");
$resTenFraude=mysqli_fetch_assoc($sqlTenFraude);

$porcTendFraude = floatval($resTenFraude['porc_fraude']);
if($porcTendFraude > 0){
    $porcTendFraude = number_format($porcTendFraude, 1);
}

mysqli_next_result($con);
$sqlCantPerTenFraude=mysqli_query($con,'SELECT COUNT(a.id) AS cantidad, sum(if(b.resultado = 1, 1, 0)) AS atender, sum(if(b.resultado = 2, 1, 0)) AS no_atender
    FROM investigaciones a LEFT JOIN personas_investigaciones_soat b ON a.id=b.id_investigacion 
    WHERE b.tipo_persona=1 AND b.id_persona='.$resInformacionCaso["id_persona"]);

if(mysqli_num_rows($sqlCantPerTenFraude) > 0){
    $resCantPerTenFraude=mysqli_fetch_assoc($sqlCantPerTenFraude);
    $ctl = $resCantPerTenFraude['cantidad'];
    $cal = $resCantPerTenFraude['atender'];
    $cnl = $resCantPerTenFraude['no_atender'];
}

mysqli_next_result($con);
$sqlCantVehTenFraude=mysqli_query($con,'SELECT COUNT(a.id) AS cantidad, sum(if(b.resultado = 1, 1, 0)) AS atender, sum(if(b.resultado = 2, 1, 0)) AS no_atender
    FROM investigaciones a 
    LEFT JOIN personas_investigaciones_soat b ON a.id=b.id_investigacion
    LEFT JOIN detalle_investigaciones_soat c ON a.id=c.id_investigacion
    LEFT JOIN polizas d ON d.id = c.id_poliza
    WHERE b.tipo_persona=1 AND d.id_vehiculo='.$resInformacionVehiculo["id_vehiculo"]);

if(mysqli_num_rows($sqlCantVehTenFraude) > 0){
    $resCantVehTenFraude=mysqli_fetch_assoc($sqlCantVehTenFraude);
    $ctv = $resCantVehTenFraude['cantidad'];
    $cav = $resCantVehTenFraude['atender'];
    $cnv = $resCantVehTenFraude['no_atender'];
}

mysqli_next_result($con);
$sqlCantTipVehTenFraude=mysqli_query($con,'SELECT COUNT(a.id) AS cantidad, sum(if(b.resultado = 1, 1, 0)) AS atender, sum(if(b.resultado = 2, 1, 0)) AS no_atender
    FROM investigaciones a 
    LEFT JOIN personas_investigaciones_soat b ON a.id=b.id_investigacion
    LEFT JOIN detalle_investigaciones_soat c ON a.id=c.id_investigacion
    LEFT JOIN polizas d ON d.id = c.id_poliza
    LEFT JOIN vehiculos e ON e.id = d.id_vehiculo
    WHERE b.tipo_persona=1 AND e.tipo_vehiculo ='.$resInformacionVehiculo["id_tipo_vehiculo"]);

if(mysqli_num_rows($sqlCantTipVehTenFraude) > 0){
    $resCantTipVehTenFraude=mysqli_fetch_assoc($sqlCantTipVehTenFraude);
    $ctt = $resCantTipVehTenFraude['cantidad'];
    $cat = $resCantTipVehTenFraude['atender'];
    $cnt = $resCantTipVehTenFraude['no_atender'];
}

if($porcTendFraude >= 0 && $porcTendFraude <= 10){
    $docx->replaceVariableByText(array('1' => $porcTendFraude.'%'));
}elseif($porcTendFraude > 10 && $porcTendFraude <= 20){
    $docx->replaceVariableByText(array('2' => $porcTendFraude.'%'));
}elseif($porcTendFraude > 20 && $porcTendFraude <= 30){
    $docx->replaceVariableByText(array('3' => $porcTendFraude.'%'));
}elseif($porcTendFraude > 30 && $porcTendFraude <= 40){
    $docx->replaceVariableByText(array('4' => $porcTendFraude.'%'));
}elseif($porcTendFraude > 40 && $porcTendFraude <= 50){
    $docx->replaceVariableByText(array('5' => $porcTendFraude.'%'));
}elseif($porcTendFraude > 50 && $porcTendFraude <= 60){
    $docx->replaceVariableByText(array('6' => $porcTendFraude.'%'));
}elseif($porcTendFraude > 60 && $porcTendFraude <= 70){
    $docx->replaceVariableByText(array('7' => $porcTendFraude.'%'));
}elseif($porcTendFraude > 70 && $porcTendFraude <= 80){
    $docx->replaceVariableByText(array('8' => $porcTendFraude.'%'));
}elseif($porcTendFraude > 80 && $porcTendFraude <= 90){
    $docx->replaceVariableByText(array('9' => $porcTendFraude.'%'));
}elseif($porcTendFraude > 90){
    $docx->replaceVariableByText(array('o' => $porcTendFraude.'%'));
}

$docx->replaceVariableByText(array("1" => ''));
$docx->replaceVariableByText(array("2" => ''));
$docx->replaceVariableByText(array("3" => ''));
$docx->replaceVariableByText(array("4" => ''));
$docx->replaceVariableByText(array("5" => ''));
$docx->replaceVariableByText(array("6" => ''));
$docx->replaceVariableByText(array("7" => ''));
$docx->replaceVariableByText(array("8" => ''));
$docx->replaceVariableByText(array("9" => ''));
$docx->replaceVariableByText(array("o" => ''));

$docx->replaceVariableByText(array('ctl' => $ctl));
$docx->replaceVariableByText(array('cnl' => $cnl));
$docx->replaceVariableByText(array('cal' => $cal));
$docx->replaceVariableByText(array('ctv' => $ctv));
$docx->replaceVariableByText(array('cnv' => $cnv));
$docx->replaceVariableByText(array('cav' => $cav));
$docx->replaceVariableByText(array('ctp' => $ctp));
$docx->replaceVariableByText(array('cnp' => $cnp));
$docx->replaceVariableByText(array('cap' => $cap));
$docx->replaceVariableByText(array('ctt' => $ctt));
$docx->replaceVariableByText(array('cnt' => $cnt));
$docx->replaceVariableByText(array('cat' => $cat));

//INVESTIGADOR
$docx->replaceVariableByText(array('nombre_inv' => $resInformacionInvestigador["nombre_investigador"]));
$docx->replaceVariableByText(array('id_inv' => $resInformacionInvestigador["identificacion_investigador"]));

//FICHA DE ANEXOS
$itemList = array();

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
    $itemList[] = "ANEXO TÉCNICO N° 1 PÓLIZA NO. ".$resInformacionVehiculo["numero_poliza"];  
}
if ($cantidadImagenesTarjetaPropiedad>0){
    $itemList[] = "ANEXO TÉCNICO N° 2 TARJETA DE PROPIEDAD";  
}    
if ($cantidadImagenesLesionados>0){
    $itemList[] = "FOTOGRAFÍAS LESIONES";  
}
if ($cantidadImagenesPunto>0){
     $itemList[] = "PUNTOS DE REFERENCIA LUGAR DE LOS HECHOS";  
}    
if ($cantidadImagenesInspeccion>0)  {
    $itemList[] = "INSPECCIÓN  TÉCNICA DEL VEHÍCULO";
}
if ($cantidadImagenesRegistroTelefonico>0)  {
    $itemList[] = "REGISTRO TELEFONICO";  
}
if ($cantidadImagenesRunt>0){
    $itemList[] = "REGISTRO RUNT";  
}        
if ($cantidadImagenesSeguridadSocial>0){
    $$itemList[] = "AFILIACIÓN AL SISTEMA DE SEGURIDAD SOCIAL";  
}
if ($cantidadImagenesForm>0){
    $itemList[] = "ANEXO DECLARACIÓN ESCANEADA";  
}
if(count($itemList) == 0){ 
    $itemList[] = "NO EXISTEN ANEXOS";
}

$docx->replaceListVariable('ficha_anexos', $itemList);

$cont=0;
if ($cantidadImagenesPoliza>0){
    $anexosImagePol = new WordFragment($docx);
    $anexosImagePol->addBreak(array('type' => 'page'));
    $anexosImagePol->addText("ANEXO TECNICO N° 1: POLIZA No. ".$resInformacionVehiculo["numero_poliza"], array('bold' => true));

    while ($resImagenesPoliza=mysqli_fetch_assoc($consultarImagenesPoliza)){
        $resImagenesPoliza["ruta"] = '../../../data/multimedia/'.$resImagenesPoliza["ruta"];
        $arrayImagenes[$cont]=$resImagenesPoliza["ruta"];
        $cont++;
    }

    $foto = array('src' => $arrayImagenes["0"], 'imageAlign' => 'center', 'height' => 360, 'width' => 590,);
    $anexosImagePol->addImage($foto);
    if (count($arrayImagenes)==2){
        $foto2 = array('src' => $arrayImagenes["1"], 'spacingTop' => 12, 'imageAlign' => 'center', 'height' => 360, 'width' => 590,);
        $anexosImagePol->addImage($foto2);
    }

    $anexosImagePol->addText("|imagenes_anexos|");

    $docx->replaceVariableByWordFragment(array('imagenes_anexos' => $anexosImagePol), array('type' => 'block'));
}

unset($arrayImagenes);
$cont=0;
if ($cantidadImagenesTarjetaPropiedad>0){
    $anexosImageTarj = new WordFragment($docx);
    $anexosImageTarj->addBreak(array('type' => 'page'));
    $anexosImageTarj->addText("ANEXO TÉCNICO N° 2 TARJETA DE PROPIEDAD", array('bold' => true));  
    
    while ($resImagenesTarjetaPropiedad=mysqli_fetch_assoc($consultarImagenesTarjetaPropiedad)){
        $resImagenesTarjetaPropiedad["ruta"] = '../../../data/multimedia/'.$resImagenesTarjetaPropiedad["ruta"];
        $arrayImagenes[$cont]=$resImagenesTarjetaPropiedad["ruta"];
        $cont++;
    }

    if (count($arrayImagenes)==1){
        $foto = array('src' => $arrayImagenes["0"], 'imageAlign' => 'center', 'height' => 280, 'width' => 500,);
        $anexosImageTarj->addImage($foto);
    }
    else  if (count($arrayImagenes)==2){
        $foto = array('src' => $arrayImagenes["0"], 'imageAlign' => 'center', 'height' => 260, 'width' => 500,);
        $anexosImageTarj->addImage($foto);
        $foto1 = array('src' => $arrayImagenes["1"], 'imageAlign' => 'center', 'height' => 280, 'width' => 500,);
        $anexosImageTarj->addImage($foto1);
    }
    $anexosImageTarj->addText("|imagenes_anexos|");

    $docx->replaceVariableByWordFragment(array('imagenes_anexos' => $anexosImageTarj), array('type' => 'block'));
}

//AGREGAMOS FOTOS FORMULARIOS PARA ESTADO
if($resInformacionCaso['id_aseguradora'] == 2){
    unset($arrayImagenes);
    $cont=0;
    
    if ($cantidadImagenesForm>0){
        $anexosImageForm = new WordFragment($docx);

        while ($resImagenesForm=mysqli_fetch_assoc($consultarImagenesForm)){
            
            $resImagenesForm["ruta"] = '../../../data/multimedia/'.$resImagenesForm["ruta"];
            $anexosImageForm->addBreak(array('type' => 'page'));
            $anexosImageForm->addText("FOTOS FORMULARIO:", array('bold' => true));  
            $foto = array('src' => $resImagenesForm['ruta'], 'imageAlign' => 'center', 'height' => 2000, 'width' => 1800,'dpi' => 300,);
            $anexosImageForm->addImage($foto);
            
            $cont++;
        }   
            
        mysqli_next_result($con);
        $consultarObservacionesNuevas9=$consultarObservacionesInforme." AND id_seccion=15";
        $queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas9);
        
        if (mysqli_num_rows($queryObservaciones)>0){
            $resDetalleImagenInspeccion=mysqli_fetch_assoc($queryObservaciones);
            $anexosImageForm->addText($resDetalleImagenInspeccion["observacion"], array('italic'=>true,'bold'=>false,'fontSize'=>11,'font'=>'Arial', 'align'=> 'center'));
        }  
        
        $anexosImageForm->addText("|imagenes_anexos|");

        $docx->replaceVariableByWordFragment(array('imagenes_anexos' => $anexosImageForm), array('type' => 'block'));
    }
}

unset($arrayImagenes);
$cont=0;
if ($cantidadImagenesLesionados>0){
    $anexosImageLes = new WordFragment($docx);
    $anexosImageLes->addBreak(array('type' => 'page'));
    $anexosImageLes->addText("FOTOGRAFIAS LESIONES", array('bold' => true));  

    while ($resImagenesLesionados=mysqli_fetch_assoc($consultarImagenesLesionados)){
        $resImagenesLesionados["ruta"] = '../../../data/multimedia/'.$resImagenesLesionados["ruta"];

        $arrayImagenes[$cont]=$resImagenesLesionados["ruta"];
        $cont++;
    }  

    if (count($arrayImagenes)==1){
        $foto = array('src' => $arrayImagenes[0], 'imageAlign' => 'center',
            'wrappingStyle' => 'tight', 'height' => 400, 'width' => 500,);
        $anexosImageLes->addImage($foto);
    }
    else  if (count($arrayImagenes)==2){
        $foto = array('src' => $arrayImagenes[0], 'imageAlign' => 'center',
            'wrappingStyle' => 'tight', 'height' => 320, 'width' => 400,);
        $anexosImageLes->addImage($foto);
        $foto = array('src' => $arrayImagenes[1], 'imageAlign' => 'center',
            'wrappingStyle' => 'tight', 'height' => 320, 'width' => 400,);
        $anexosImageLes->addImage($foto);
    }
    else{
        $runsImgLesionados = array();
        $printLes = false;
        for ($i=0;$i<count($arrayImagenes);$i++){
            if ($i==3 || $i==6 || $i==9 || $i==12 || $i==15) {
                $runsImgLesionados = array();
                $printLes = false;
            }
            $imgLesionadosTemp = new WordFragment($docx);
            if ($i==2 || $i==5 || $i==8 || $i==11 || $i==14) {
                $foto = array('src' => $arrayImagenes[$i], 'imageAlign' => 'center', 'wrappingStyle' => 'tight', 'height' => 200, 'width' => 190,);
            }else{
                $foto = array('src' => $arrayImagenes[$i], 'spacingRight' => 2, 'imageAlign' => 'center', 'wrappingStyle' => 'tight', 'height' => 200, 'width' => 197,);
            }
            
            $imgLesionadosTemp->addImage($foto);
            $runsImgLesionados[] = $imgLesionadosTemp;
            if ($i==2 || $i==5 || $i==8 || $i==11 || $i==14) {
                $anexosImageLes->addText($runsImgLesionados);
                $printLes = true;
            }        
        }

        if(!$printLes){ $anexosImageLes->addText($runsImgLesionados); }
    }

    mysqli_next_result($con);
    $consultarDetalleImagenLesionado=mysqli_query($con,"SELECT observacion FROM observaciones_secciones_informe WHERE id_investigacion='".$id_caso."' and id_seccion='5'");
    if (mysqli_num_rows($consultarDetalleImagenLesionado)>0){
        $resDetalleImagenLesionado=mysqli_fetch_assoc($consultarDetalleImagenLesionado);
        $anexosImageLes->addText($resDetalleImagenLesionado["descripcion"], array('italic'=>true,'bold'=>false,'fontSize'=>11,'font'=>'Arial', 'align'=> 'center'));
    }
    $anexosImageLes->addText("|imagenes_anexos|");
    $docx->replaceVariableByWordFragment(array('imagenes_anexos' => $anexosImageLes), array('type' => 'block'));
}

unset($arrayImagenes);
$cont=0;
if ($cantidadImagenesPunto>0){
    $anexosImagePRef = new WordFragment($docx);
    $anexosImagePRef->addBreak(array('type' => 'page'));
    $anexosImagePRef->addText("PUNTOS DE REFERENCIA LUGAR DE LOS HECHOS:", array('bold' => true));
    
    while ($resImagenesPunto=mysqli_fetch_assoc($consultarImagenesPunto)){
        $resImagenesPunto["ruta"] = '../../../data/multimedia/'.$resImagenesPunto["ruta"];
        $arrayImagenes[$cont]=$resImagenesPunto["ruta"];
        $cont++;
    }    

    if (count($arrayImagenes)==1){
        $foto = array('src' => $arrayImagenes[0], 'imageAlign' => 'center',
            'wrappingStyle' => 'tight', 'height' => 400, 'width' => 500,);
        $anexosImagePRef->addImage($foto);
    }
    else  if (count($arrayImagenes)==2){
        $foto = array('src' => $arrayImagenes[0], 'imageAlign' => 'center',
            'wrappingStyle' => 'tight', 'height' => 320, 'width' => 400,);
        $anexosImagePRef->addImage($foto);
        $foto = array('src' => $arrayImagenes[1], 'imageAlign' => 'center',
            'wrappingStyle' => 'tight', 'height' => 320, 'width' => 400,);
        $anexosImagePRef->addImage($foto);
    }
    else{

        $runsImgPRef = array();
        $printPRef = false;
        for ($i=0;$i<count($arrayImagenes);$i++){
            if ($i==3 || $i==6 || $i==9 || $i==12 || $i==15) {
                $runsImgPRef = array();
                $printPRef = false;
            }
            $imgPRefTemp = new WordFragment($docx);
            if ($i==2 || $i==5 || $i==8 || $i==11 || $i==14) {
                $foto = array('src' => $arrayImagenes[$i], 'imageAlign' => 'center', 'wrappingStyle' => 'tight', 'height' => 200, 'width' => 190,);
            }else{
                $foto = array('src' => $arrayImagenes[$i], 'spacingRight' => 2, 'imageAlign' => 'center', 'wrappingStyle' => 'tight', 'height' => 200, 'width' => 197,);
            }
            
            $imgPRefTemp->addImage($foto);
            $runsImgPRef[] = $imgPRefTemp;
            if ($i==2 || $i==5 || $i==8 || $i==11 || $i==14) {
                $anexosImagePRef->addText($runsImgPRef);
                $printPRef = true;
            }        
        }
        if(!$printPRef){ $anexosImagePRef->addText($runsImgPRef); }
    }

    mysqli_next_result($con);
    $consultarObservacionesFURIPSnew6=$consultarObservacionesInforme." AND id_seccion=17";

    $queryObservaciones=mysqli_query($con,$consultarObservacionesFURIPSnew6);

    if (mysqli_num_rows($queryObservaciones)>0){
        $resDetalleImagenPunto=mysqli_fetch_assoc($queryObservaciones);
        $anexosImagePRef->addText($resDetalleImagenPunto["descripcion"], array('italic'=>true,'bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
    } 
    $anexosImagePRef->addText("|imagenes_anexos|");
    $docx->replaceVariableByWordFragment(array('imagenes_anexos' => $anexosImagePRef), array('type' => 'block'));
}

unset($arrayImagenes);
$cont=0;
if ($cantidadImagenesInspeccion>0){
    $anexosImageInsp = new WordFragment($docx);
    $anexosImageInsp->addBreak(array('type' => 'page'));
    $anexosImageInsp->addText("INSPECCIÓN  TÉCNICA DEL VEHÍCULO:", array('bold' => true)); 

    while ($resImagenesInspeccion=mysqli_fetch_assoc($consultarImagenesInspeccion)){
        $resImagenesInspeccion["ruta"] = '../../../data/multimedia/'.$resImagenesInspeccion["ruta"];
        $arrayImagenes[$cont]=$resImagenesInspeccion['ruta'];
        $cont++;
    }  

    if (count($arrayImagenes)==1){
        $foto = array('src' => $arrayImagenes[0], 'imageAlign' => 'center',
            'wrappingStyle' => 'tight', 'height' => 400, 'width' => 500,);
        $anexosImageInsp->addImage($foto);
    }
    else  if (count($arrayImagenes)==2){
        $foto = array('src' => $arrayImagenes[0], 'imageAlign' => 'center',
            'wrappingStyle' => 'tight', 'height' => 320, 'width' => 400,);
        $anexosImageInsp->addImage($foto);
        $foto = array('src' => $arrayImagenes[1], 'imageAlign' => 'center',
            'wrappingStyle' => 'tight', 'height' => 320, 'width' => 400,);
        $anexosImageInsp->addImage($foto);
    }
    else{

        $runsImgInsp = array();
        $printInsp = false;
        for ($i=0;$i<count($arrayImagenes);$i++){
            if ($i==3 || $i==6 || $i==9 || $i==12 || $i==15) {
                $runsImgInsp = array();
                $printInsp = false;
            }
            $imgInspTemp = new WordFragment($docx);
            if ($i==2 || $i==5 || $i==8 || $i==11 || $i==14) {
                $foto = array('src' => $arrayImagenes[$i], 'imageAlign' => 'center', 'wrappingStyle' => 'tight', 'height' => 200, 'width' => 190,);
            }else{
                $foto = array('src' => $arrayImagenes[$i], 'spacingRight' => 2, 'imageAlign' => 'center', 'wrappingStyle' => 'tight', 'height' => 200, 'width' => 197,);
            }
            
            $imgInspTemp->addImage($foto);
            $runsImgInsp[] = $imgInspTemp;
            if ($i==2 || $i==5 || $i==8 || $i==11 || $i==14) {
                $anexosImageInsp->addText($runsImgInsp);
                $printInsp = true;
            }        
        }
        if(!$printInsp){ $anexosImageInsp->addText($runsImgInsp); }
    }

    mysqli_next_result($con);
    $consultarObservacionesNuevas6=$consultarObservacionesInforme." AND id_seccion=13";
    $queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas6);
    if (mysqli_num_rows($queryObservaciones)>0){
        $resDetalleImagenInspeccion=mysqli_fetch_assoc($queryObservaciones);
        $anexosImageInsp->addText($resDetalleImagenInspeccion["observacion"], array('italic'=>true,'bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
    }
    $anexosImageInsp->addText("|imagenes_anexos|");
    $docx->replaceVariableByWordFragment(array('imagenes_anexos' => $anexosImageInsp), array('type' => 'block'));
}

unset($arrayImagenes);
$cont=0;
if ($cantidadImagenesRegistroTelefonico>0){
    $anexosImageRegTel = new WordFragment($docx);
    $anexosImageRegTel->addBreak(array('type' => 'page'));
    $anexosImageRegTel->addText("REGISTRO TELÉFONICO:", array('bold' => true)); 
    
    while ($resImagenesRegistroTelefonico=mysqli_fetch_array($consultarImagenesRegistroTelefonico))    {
        $resImagenesRegistroTelefonico["ruta"] = '../../../data/multimedia/'.$resImagenesRegistroTelefonico["ruta"];
        $arrayImagenes[$cont]=$resImagenesRegistroTelefonico["ruta"];
        $cont++;
    }  

    if (count($arrayImagenes)==1){
        $foto = array('src' => $arrayImagenes[0], 'imageAlign' => 'center',
            'wrappingStyle' => 'tight', 'height' => 400, 'width' => 500,);
        $anexosImageRegTel->addImage($foto);
    }
    else  if (count($arrayImagenes)==2){
        $foto = array('src' => $arrayImagenes[0], 'imageAlign' => 'center',
            'wrappingStyle' => 'tight', 'height' => 320, 'width' => 400,);
        $anexosImageRegTel->addImage($foto);
        $foto = array('src' => $arrayImagenes[1], 'imageAlign' => 'center',
            'wrappingStyle' => 'tight', 'height' => 320, 'width' => 400,);
        $anexosImageRegTel->addImage($foto);
    }
    else{

        $runsImgRegTel = array();
        $printRegTel = false;
        for ($i=0;$i<count($arrayImagenes);$i++){
            if ($i==3 || $i==6 || $i==9 || $i==12 || $i==15) {
                $runsImgRegTel = array();
                $printRegTel = false;
            }
            $imgRegTelTemp = new WordFragment($docx);
            if ($i==2 || $i==5 || $i==8 || $i==11 || $i==14) {
                $foto = array('src' => $arrayImagenes[$i], 'imageAlign' => 'center', 'wrappingStyle' => 'tight', 'height' => 200, 'width' => 190,);
            }else{
                $foto = array('src' => $arrayImagenes[$i], 'spacingRight' => 2, 'imageAlign' => 'center', 'wrappingStyle' => 'tight', 'height' => 200, 'width' => 197,);
            }
            
            $imgRegTelTemp->addImage($foto);
            $runsImgRegTel[] = $imgRegTelTemp;
            if ($i==2 || $i==5 || $i==8 || $i==11 || $i==14) {
                $anexosImageRegTel->addText($runsImgRegTel);
                $printRegTel = true;
            }        
        }
        if(!$printRegTel){ $anexosImageRegTel->addText($runsImgRegTel); }
    }

    mysqli_next_result($con);
    $consultarObservacionesNuevas7=$consultarObservacionesInforme." AND id_seccion=18";
    $queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas7);
    
    if (mysqli_num_rows($queryObservaciones)>0) {
        $resDetalleImagenInspeccion=mysqli_fetch_assoc($queryObservaciones);
        $anexosImageRegTel->addText($resDetalleImagenInspeccion["observacion"], array('italic'=>true,'bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
    }
    $anexosImageRegTel->addText("|imagenes_anexos|");
    $docx->replaceVariableByWordFragment(array('imagenes_anexos' => $anexosImageRegTel), array('type' => 'block'));
}

unset($arrayImagenes);
$cont=0;
if ($cantidadImagenesLugarResidencia>0){
    $anexosImageLugRes = new WordFragment($docx);
    $anexosImageLugRes->addBreak(array('type' => 'page'));
    $anexosImageLugRes->addText("LUGAR DE RESIDENCIA:", array('bold' => true)); 
    
    while ($resImagenesLugarResidencia=mysqli_fetch_array($consultarImagenesLugarResidencia)){
        $resImagenesLugarResidencia["ruta"] = '../../../data/multimedia/'.$resImagenesLugarResidencia["ruta"];
        $arrayImagenes[$cont]=$resImagenesLugarResidencia['ruta'];
        $cont++;
    } 

    if (count($arrayImagenes)==1){
        $foto = array('src' => $arrayImagenes[0], 'imageAlign' => 'center',
            'wrappingStyle' => 'tight', 'height' => 400, 'width' => 500,);
        $anexosImageLugRes->addImage($foto);
    }
    else  if (count($arrayImagenes)==2){
        $anexosImageLugRes->addBreak(array('type' => 'line', 'number' => 0));
        $foto = array('src' => $arrayImagenes[0], 'imageAlign' => 'center',
            'wrappingStyle' => 'tight', 'height' => 320, 'width' => 400,);
        $anexosImageLugRes->addImage($foto);
        $foto = array('src' => $arrayImagenes[1], 'imageAlign' => 'center',
            'wrappingStyle' => 'tight', 'height' => 320, 'width' => 400,);
        $anexosImageLugRes->addImage($foto);
    }
    else{

        $runsImgLugRes = array();
        $printLugRes = false;
        for ($i=0;$i<count($arrayImagenes);$i++){
            if ($i==3 || $i==6 || $i==9 || $i==12 || $i==15) {
                $runsImgLugRes = array();
                $printLugRes = false;
            }
            $imgLugResTemp = new WordFragment($docx);
            if ($i==2 || $i==5 || $i==8 || $i==11 || $i==14) {
                $foto = array('src' => $arrayImagenes[$i], 'imageAlign' => 'center', 'wrappingStyle' => 'tight', 'height' => 200, 'width' => 190,);
            }else{
                $foto = array('src' => $arrayImagenes[$i], 'spacingRight' => 2, 'imageAlign' => 'center', 'wrappingStyle' => 'tight', 'height' => 200, 'width' => 197,);
            }
            
            $imgLugResTemp->addImage($foto);
            $runsImgLugRes[] = $imgLugResTemp;
            if ($i==2 || $i==5 || $i==8 || $i==11 || $i==14) {
                $anexosImageLugRes->addText($runsImgLugRes);
                $printLugRes = true;
            }        
        }
        if(!$printLugRes){ $anexosImageLugRes->addText($runsImgLugRes); }
    }

    mysqli_next_result($con);
    $consultarObservacionesNuevas8=$consultarObservacionesInforme." AND id_seccion=19";
    $queryObservaciones=mysqli_query($con, $consultarObservacionesNuevas8);
    if (mysqli_num_rows($queryObservaciones)>0) {
        $resDetalleImagenInspeccion=mysqli_fetch_assoc($queryObservaciones);
        $anexosImageLugRes->addText($resDetalleImagenInspeccion["observacion"], array('italic'=>true,'bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
    }
    $anexosImageLugRes->addText("|imagenes_anexos|");
    $docx->replaceVariableByWordFragment(array('imagenes_anexos' => $anexosImageLugRes), array('type' => 'block'));
}

if ($cantidadImagenesRunt>0){
    $anexosImageRunt = new WordFragment($docx);
    $anexosImageRunt->addBreak(array('type' => 'page'));
    $anexosImageRunt->addText("REGISTRO RUNT:", array('bold' => true));
     
    while ($resRunt=mysqli_fetch_assoc($consultarRunt)){
        $resRunt["ruta"] = '../../../data/multimedia/'.$resRunt["ruta"];
        $foto = array('src' => $resRunt["ruta"], 'imageAlign' => 'center',
            'wrappingStyle' => 'tight', 'height' => 380, 'width' => 500,);
        $anexosImageRunt->addImage($foto); 
    }
    $anexosImageRunt->addText("|imagenes_anexos|");
    $docx->replaceVariableByWordFragment(array('imagenes_anexos' => $anexosImageRunt), array('type' => 'block'));
}

unset($arrayImagenes);
$cont=0;
if ($cantidadImagenesSeguridadSocial>0){
    $anexosImageSegSoc = new WordFragment($docx);
    $anexosImageSegSoc->addBreak(array('type' => 'page'));
    $anexosImageSegSoc->addText("AFILIACIÓN AL SISTEMA DE SEGURIDAD SOCIAL:", array('bold' => true));
    
    while ($resImagenesSeguridadSocial=mysqli_fetch_assoc($consultarSeguridadSocial)) {
        $resImagenesSeguridadSocial["ruta"] = '../../../data/multimedia/'.$resImagenesSeguridadSocial["ruta"];
        $arrayImagenes[$cont]=$resImagenesSeguridadSocial['ruta'];
        $cont++;
    }  

    if (count($arrayImagenes)==1){
        $foto = array('src' => $arrayImagenes[0], 'imageAlign' => 'center',
            'wrappingStyle' => 'tight', 'height' => 400, 'width' => 500,);
        $anexosImageSegSoc->addImage($foto);
    }
    else  if (count($arrayImagenes)==2){
        $anexosImageSegSoc->addBreak(array('type' => 'line', 'number' => 0));
        $foto = array('src' => $arrayImagenes[0], 'imageAlign' => 'center',
            'wrappingStyle' => 'tight', 'height' => 320, 'width' => 400,);
        $anexosImageSegSoc->addImage($foto);
        $foto = array('src' => $arrayImagenes[1], 'imageAlign' => 'center',
            'wrappingStyle' => 'tight', 'height' => 320, 'width' => 400,);
        $anexosImageSegSoc->addImage($foto);
    }
    else{

        $runsImgSegSoc = array();
        $printSegSoc = false;
        for ($i=0;$i<count($arrayImagenes);$i++){
            if ($i==3 || $i==6 || $i==9 || $i==12 || $i==15) {
                $runsImgSegSoc = array();
                $printSegSoc = false;
            }
            $imgSegSocTemp = new WordFragment($docx);
            if ($i==2 || $i==5 || $i==8 || $i==11 || $i==14) {
                $foto = array('src' => $arrayImagenes[$i], 'imageAlign' => 'center', 'wrappingStyle' => 'tight', 'height' => 200, 'width' => 190,);
            }else{
                $foto = array('src' => $arrayImagenes[$i], 'spacingRight' => 2, 'imageAlign' => 'center', 'wrappingStyle' => 'tight', 'height' => 200, 'width' => 197,);
            }
            
            $imgSegSocTemp->addImage($foto);
            $runsImgSegSoc[] = $imgSegSocTemp;
            if ($i==2 || $i==5 || $i==8 || $i==11 || $i==14) {
                $anexosImageSegSoc->addText($runsImgSegSoc);
                $printSegSoc = true;
            }        
        }
        if(!$printSegSoc){ $anexosImageSegSoc->addText($runsImgSegSoc); }
    }

    mysqli_next_result($con);
    $consultarObservacionesNuevas10=$consultarObservacionesInforme." AND id_seccion=5";
    $queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas10);
    if (mysqli_num_rows($queryObservaciones)>0) {
        $resDetalleImagenSalud=mysqli_fetch_assoc($queryObservaciones);
        $anexosImageSegSoc->addText($resDetalleImagenSalud["observacion"], array('italic'=>true,'bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
    }
    $anexosImageSegSoc->addText("|imagenes_anexos|");
    $docx->replaceVariableByWordFragment(array('imagenes_anexos' => $anexosImageSegSoc), array('type' => 'block'));
}

//AGREGAMOS FOTOS FORMULARIOS A DIFERENCIA DE ESTADO
if($resInformacionCaso['id_aseguradora'] != 2){
    unset($arrayImagenes);
    $cont=0;
    
    if ($cantidadImagenesForm>0){
        $anexosImageForm = new WordFragment($docx);

        while ($resImagenesForm=mysqli_fetch_assoc($consultarImagenesForm)){
            
            $resImagenesForm["ruta"] = '../../../data/multimedia/'.$resImagenesForm["ruta"];
            $anexosImageForm->addBreak(array('type' => 'page'));
            $anexosImageForm->addText("FOTOS FORMULARIO:", array('bold' => true));  
            $foto = array('src' => $resImagenesForm['ruta'], 'imageAlign' => 'center', 'height' => 2000, 'width' => 1800,'dpi' => 300,);
            $anexosImageForm->addImage($foto);            
            $cont++;
        }   
            
        mysqli_next_result($con);
        $consultarObservacionesNuevas9=$consultarObservacionesInforme." AND id_seccion=15";
        $queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas9);
        
        if (mysqli_num_rows($queryObservaciones)>0){
            $resDetalleImagenInspeccion=mysqli_fetch_assoc($queryObservaciones);
            $anexosImageForm->addText($resDetalleImagenInspeccion["observacion"], array('italic'=>true,'bold'=>false,'fontSize'=>11,'font'=>'Arial', 'align'=> 'center'));
        }  

        $docx->replaceVariableByWordFragment(array('imagenes_anexos' => $anexosImageForm), array('type' => 'block'));
    }else{
        $docx->removeTemplateVariable('imagenes_anexos', 'inline');
    }
}else{
    $docx->removeTemplateVariable('imagenes_anexos', 'inline');
    
    //SI ES DE LA ASEGURADORA -> ESTADO ADJUNTAR HOJA DE VIDA DE INVESTIGADOR
    mysqli_next_result($con);
    $consultarInformacionInvestigador="SELECT i.lugar_expedicion, i.estudios, i.experiencia, i.foto, dt.descripcion2 FROM investigadores i LEFT JOIN definicion_tipos dt ON dt.id = i.tipo_identificacion AND dt.id_tipo = 5 WHERE i.id='".$resInformacionCaso['id_investigador']."'";
    $queryInformacionInvestigador=mysqli_query($con,$consultarInformacionInvestigador);

    if(mysqli_num_rows($queryInformacionInvestigador)){
        $respSQLInvestigador=mysqli_fetch_assoc($queryInformacionInvestigador);


        $docx->replaceVariableByText(array('ciudad_exp_inv' => ' De '.$respSQLInvestigador['lugar_expedicion']));

        if($respSQLInvestigador['foto'] != ''){
            $fotoInv = new WordFragment($docx);
            $imageOptions = array('src' => "../../../data/fotos_perfil/".$respSQLInvestigador['foto'], 'imageAlign' => 'center', 'height' => 420, 'width' => 340,'dpi' => 300,);
            $fotoInv->addImage($imageOptions);
            $docx->replaceVariableByWordFragment(array('foto_inv' => $fotoInv));
        }else{
            $docx->removeTemplateVariable('foto_inv', 'inline');
        }

        $itemListEst = array();
        if($respSQLInvestigador['estudios'] != ''){
            $estudios = explode('|', $respSQLInvestigador['estudios']);
            if(count($estudios)>0){
                foreach ($estudios as $llave => $valor) {
                    $itemListEst[] = $valor;
                }
            }else{
                $itemListEst[] = $respSQLInvestigador['estudios'];
            }
            $docx->replaceListVariable('estudios_inv', $itemListEst);
        }else{
            $docx->removeTemplateVariable('estudios_inv', 'inline');
        }

        $itemListEst = array();
        if($respSQLInvestigador['experiencia'] != ''){
            $experiencia = explode('|', $respSQLInvestigador['experiencia']);
            if(count($experiencia)>0){
                foreach ($experiencia as $llave => $valor) {
                    $itemListEst[] = $valor;
                }
            }else{
                $itemListEst[] = $respSQLInvestigador['experiencia'];
            }
            $docx->replaceListVariable('experiencia_inv', $itemListEst);
        }else{
            $docx->removeTemplateVariable('experiencia_inv', 'inline');
        }
    }else{
        $docx->removeTemplateVariable('ciudad_exp_inv', 'inline');
        $docx->removeTemplateVariable('estudios_inv', 'inline');
        $docx->removeTemplateVariable('experiencia_inv', 'inline');
        $docx->removeTemplateVariable('foto_inv', 'inline');
    }
}

//GUARDAR Y DESCARGAR INFORME
$nombre="INFORME ".$resInformacionCaso["nombre_lesionado"]." POLIZA No. ".$resInformacionVehiculo["numero_poliza"];
header('Content-Disposition: attachment; filename="'.$nombre.'.docx"');
$docx->createDocx('Informe');
echo file_get_contents('Informe.docx');