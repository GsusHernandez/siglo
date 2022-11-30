<?php
//ini_set('display_errors', -1);
//error_reporting(E_ALL);

// add a header using WordFragments
require_once '../classes/CreateDocx.php';
include('../../../conexion/conexion.php');
global $con;
$id_caso=$_GET["idInv"];
$result='si';
if(isset($_GET["result"])){ $result = $_GET["result"]; }

ini_set('max_execution_time', '300'); //300 seconds = 5 minutes
set_time_limit(300);

mysqli_query($con,"SET SQL_BIG_SELECTS=1");

$consultarInformacionCaso="SELECT a.codigo,
        a.id AS id_caso,
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
        c.id_persona,
        b.id_poliza,
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
   
$consultarObservacionesInforme="SELECT * FROM observaciones_secciones_informe WHERE id_investigacion='".$id_caso."'";

mysqli_next_result($con);
$queryInformacionCaso=mysqli_query($con,$consultarInformacionCaso);
$resInformacionCaso=mysqli_fetch_assoc($queryInformacionCaso);

mysqli_next_result($con);
$consultarInformacionVehiculo="SELECT 
    k.placa,
    k.marca,
    k.modelo,
    k.linea,
    j.id_vehiculo,
    z.id_poliza,
    k.tipo_vehiculo as id_tipo_vehiculo,
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

$consultarResultado="SELECT b.descripcion2 as resultado from aseguradoras a left join definicion_tipos b on a.resultado_no_atender=b.id where b.id_tipo=10 and a.id='".$resInformacionCaso["id_aseguradora"]."'";

if($resInformacionCaso['id_aseguradora'] != 2){
    $docx = new CreateDocxFromTemplate('ModeloPositivo.docx');
}else{
    $docx = new CreateDocxFromTemplate('ModeloPositivoEstado.docx');
}

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
    $text[] = array('text' => ' Bajo los radicados ', 'bold' => false); 
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

//HOJA 2 - IMAGEN POLIZA
mysqli_next_result($con);
$consultarImagenesPoliza=mysqli_query($con,"SELECT * FROM multimedia_investigacion WHERE id_multimedia='12' and id_investigacion='".$id_caso."' ORDER by id asc");
$cantidadImagenesPoliza=mysqli_num_rows($consultarImagenesPoliza);
mysqli_next_result($con);
$consultarImagenesTarjetaPropiedad=mysqli_query($con,"SELECT * FROM multimedia_investigacion WHERE id_multimedia='13' and id_investigacion='".$id_caso."' ORDER by id asc");
$cantidadImagenesTarjetaPropiedad=mysqli_num_rows($consultarImagenesTarjetaPropiedad);

if ($cantidadImagenesTarjetaPropiedad>0 || $cantidadImagenesPoliza>0) {
    $cont=0;
    $imprimioPoliza = false;
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

        $anexosImagePol->addText("|imagenes_anexos_positivo|");

        $docx->replaceVariableByWordFragment(array('imagenes_anexos_positivo' => $anexosImagePol), array('type' => 'block'));
        $imprimioPoliza = true;
    }

    unset($arrayImagenes);
    $cont=0;
    if ($cantidadImagenesTarjetaPropiedad>0){
        $anexosImageTarj = new WordFragment($docx);
        if($imprimioPoliza){ $anexosImageTarj->addBreak(array('type' => 'page')); }
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

        $docx->replaceVariableByWordFragment(array('imagenes_anexos_positivo' => $anexosImageTarj), array('type' => 'block'));
    }else {

        $docx->removeTemplateVariable('imagenes_anexos_positivo', 'block');
    }
}
else {

    $docx->removeTemplateVariable('imagenes_anexos_positivo', 'block');
}

//DILEGENCIAS ADELANTADAS
if ($resInformacionCaso["furips"]!="N") {
    $text = array();
    $text[] = array('text' => "Según registro de la ", 'bold' => false);
    $text[] = array('text' => "HOJA DE INGRESO  ", 'bold' => true);
    $text[] = array('text' => "emitido por ", 'bold' => false);
    $text[] = array('text' => $resInformacionCaso["nombre_ips"].", ", 'bold' => true);
    $text[] = array('text' => $resInformacionCaso["furips"], 'bold' => false); 
    
    $wfDilencias = new WordFragment($docx, 'document');//fragmento de texto
    $paragraphOptions = array('font' => 'Calibri', 'jc' => 'both');
    $wfDilencias->addText($text, $paragraphOptions);
    $docx->replaceVariableByWordFragment(array('diligencias_adelantadas' => $wfDilencias), array('type' => 'block'));
    unset($text);
}else{
    $docx->replaceVariableByText(array('diligencias_adelantadas' => 'No se tiene información del item.'));
}

mysqli_next_result($con);
$consultarObservacionesFur=$consultarObservacionesInforme." AND id_seccion IN (1,2)";
$queryObservaciones=mysqli_query($con,$consultarObservacionesFur);
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

//ENTREVISTA LESIONADO Y OTROS
$text = array();
$text[] = array('text' => 'En el proceso materia de investigación figura como víctima ', 'bold' => false);

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

$text[] = array('text' => $resInformacionCaso["nombre_lesionado"], 'bold' => true); 
        
if ($resInformacionCaso["sexo"]=="2"){
    $text[] = array('text' => ', identificada con ', 'bold' => false);  
}
else{
    $text[] = array('text' => ', identificado con ', 'bold' => false);  
}

$text[] = array('text' => $resInformacionCaso["tipo_identificacion_lesionado"]." ", 'bold' => false);  
$text[] = array('text' => $resInformacionCaso["no_identificacion_lesionado"], 'bold' => true); 
$text[] = array('text' => ' de '.$resInformacionCaso["edad"].' años de edad, residente en '.$resInformacionCaso["direccion_residencia"].', '.$resInformacionCaso["ciudad_residencia"].', con Teléfono: '.$resInformacionCaso["telefono"].'.\n', 'bold' => false);

if ($resInformacionCaso["diligencia_formato_declaracion"]==1) {
    //lesionado
    $consultarInfoDiligencia="SELECT CONCAT(a.nombres,' ',a.apellidos) AS nombre_diligencia, CONCAT(LCASE(b.descripcion2),' No. ',a.identificacion) AS identificacion,a.sexo,a.edad FROM personas a LEFT JOIN definicion_tipos b ON a.tipo_identificacion=b.id WHERE b.id_tipo=5 AND a.id='".$resInformacionCaso["id_diligencia_formato_declaracion"]."'";
    mysqli_next_result($con);
    $queryInfoDiligencia=mysqli_query($con,$consultarInfoDiligencia);
    $cantidadInfoDiligencia=mysqli_num_rows($queryInfoDiligencia);
    $resInfoDiligencia=mysqli_fetch_assoc($queryInfoDiligencia);

    $text[] = array('text' => '\nQuien diligencia el Formato de Declaración de Siniestros es ', 'bold' => false); 
    
    if($resInfoDiligencia["sexo"] == 1){

        if ($resInfoDiligencia["edad"]<18) {
            $text[] = array('text' => 'el menor ', 'bold' => false); 
        }else if($resInfoDiligencia["edad"] >= 18 && $resInfoDiligencia["edad"] <= 26){
            $text[] = array('text' => 'la joven ', 'bold' => false);        
        }else{
            $text[] = array('text' => 'el señor ', 'bold' => false);        
        }

        $text[] = array('text' => $resInfoDiligencia["nombre_diligencia"], 'bold' => true);
        $text[] = array('text' => ', identificado con ', 'bold' => false); 
    } elseif($resInfoDiligencia["sexo"] == 2){
        
        if ($resInfoDiligencia["edad"]<18) {
            $text[] = array('text' => 'la menor ', 'bold' => false); 
        }else if($resInfoDiligencia["edad"] >= 18 && $resInfoDiligencia["edad"] <= 26){
            $text[] = array('text' => 'la joven ', 'bold' => false);    
        }else{
            $text[] = array('text' => 'la señora ', 'bold' => false);       
        }

        $text[] = array('text' => $resInfoDiligencia["nombre_diligencia"], 'bold' => true);
        $text[] = array('text' => ', identificada con ', 'bold' => false); 
    }

    $text[] = array('text' => $resInfoDiligencia["identificacion"], 'bold' => true);
    $text[] = array('text' => ', quien figura dentro del proceso investigativo como uno de los lesionados, en entrevista realizada el día '.$resInformacionCaso["fecha_diligencia_formato_declaracion"].', manifiesta lo siguiente:', 'bold' => false); 
}
else if ($resInformacionCaso["diligencia_formato_declaracion"]==2)  {
    //acompañante
    $consultarInfoDiligencia="SELECT a.nombre AS nombre_diligencia, CONCAT(LCASE(b.descripcion2),' No. ',a.identificacion) AS identificacion, a.relacion FROM personas_diligencia_formato_declaracion a LEFT JOIN definicion_tipos b ON a.tipo_identificacion=b.id WHERE b.id_tipo=5 AND a.id='".$resInformacionCaso["id_diligencia_formato_declaracion"]."'";
    mysqli_next_result($con);
    $queryInfoDiligencia=mysqli_query($con,$consultarInfoDiligencia);
    $resInfoDiligencia=mysqli_fetch_assoc($queryInfoDiligencia);

    $text[] = array('text' => '\nQuien diligencia el Formato de Declaración de Siniestros es ', 'bold' => false); 
    $text[] = array('text' => $resInfoDiligencia["nombre_diligencia"], 'bold' => true);
    $text[] = array('text' => ', identificado(a) con ', 'bold' => false); 
    $text[] = array('text' => $resInfoDiligencia["identificacion"], 'bold' => true);
    $text[] = array('text' => ', '.$resInfoDiligencia["relacion"], 'bold' => false); 
    $text[] = array('text' => ' del lesionado(a), el día '.$resInformacionCaso["fecha_diligencia_formato_declaracion"].', manifestando lo siguiente:', 'bold' => false); 
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

    $text[] = array('text' => '\nQuien diligencia el Formato de Declaración de Siniestros por petición del lesionado, es ', 'bold' => false); 
    $text[] = array('text' => $resInfoDiligencia["nombre_diligencia"], 'bold' => true);
    $text[] = array('text' => ', identificado(a) con ', 'bold' => false); 
    $text[] = array('text' => $resInfoDiligencia["identificacion"], 'bold' => true);
    $text[] = array('text' => ', investigador de la Compañía Global Red LTDA, el día ', 'bold' => false); 
    $text[] = array('text' => $resInformacionCaso["fecha_diligencia_formato_declaracion"].', manifiestando lo siguiente:', 'bold' => false);   
}
else if ($resInformacionCaso["diligencia_formato_declaracion"]==4) {
    //telefonicamente
    $text[] = array('text' => '\nEl lesionado manifiesta por via telefonica lo siguiente:', 'bold' => false);
}

$wfProceso = new WordFragment($docx, 'document');//fragmento de texto
$paragraphOptions = array('font' => 'Calibri', 'jc' => 'both', 'parseLineBreaks' => true);
$wfProceso->addText($text, $paragraphOptions);
$docx->replaceVariableByWordFragment(array('proceso' => $wfProceso), array('type' => 'block'));
unset($text);

//RELATO
$wfRelato = new WordFragment($docx, 'document');//fragmento de texto
$wfRelato->addText('"'.$resInformacionCaso["relato"].'"', array('italic' => true, 'jc' => 'both', 'font' => 'Calibri'));
$docx->replaceVariableByWordFragment(array('relato' => $wfRelato), array('type' => 'block'));

mysqli_next_result($con);
$consultarObservacionesNuevas=$consultarObservacionesInforme." AND id_seccion IN (2)";
$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas);
if (mysqli_num_rows($queryObservaciones)>0){
    $wfObsRelato = new WordFragment($docx, 'document');
    $wfObsRelato->addText('OBSERVACIONES: ', array('bold' => true, 'color' => 'AB1B0D'));
    $cont=0;
    while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones)){
        $cont++;
        $wfObsRelato->addText($resObservaciones["observacion"].'.', array('bold' => false)); 
    }
    $docx->replaceVariableByWordFragment(array('OBS_RELATO' => $wfObsRelato), array('type' => 'block'));
}else{
    $docx->removeTemplateVariable('OBS_RELATO', 'block');
}

//2.2.  TRASLADO DE LA VICTIMA
$text = array();
if ($resInformacionCaso["servicio_ambulancia"]=="s") {
    $text[] = array('text' => "El traslado del lesionado se realizó mediante el servicio de ambulancia desde ", 'bold' => false);
    if ($resInformacionCaso["tipo_traslado_ambulancia"]==1) {
        $text[] = array('text' => "el lugar de los hechos hasta ", 'bold' => false);
        $text[] = array('text' => $resInformacionCaso["nombre_ips"], 'bold' => true);
    }
    else if ($resInformacionCaso["tipo_traslado_ambulancia"]==2){
        $text[] = array('text' => $resInformacionCaso["lugar_traslado"]." hasta ",'bold' => false);
        $text[] = array('text' => $resInformacionCaso["nombre_ips"], 'bold' => true);
    }
}
else if ($resInformacionCaso["servicio_ambulancia"]=="n") {
    $text[] = array('text' => 'El traslado del lesionado se realizó por sus propios medios hasta ','bold' => false);
    $text[] = array('text' => $resInformacionCaso["nombre_ips"], 'bold' => true);
}

mysqli_next_result($con);
$verificarVariosLesionados=mysqli_query($con,$consultarLesionados); 
if (mysqli_num_rows($verificarVariosLesionados)==1){
    $trasladoLesionados=mysqli_fetch_assoc($verificarVariosLesionados);
    
    $text[] = array('text' => '\n','bold' => false);
    if ($trasladoLesionados["servicio_ambulancia"]=="s"){
        $text[] = array('text' => 'El traslado del lesionado se realizó mediante el servicio de ambulancia desde ','bold' => false);
        if ($trasladoLesionados["tipo_traslado_ambulancia"]==1){
            $text[] = array('text' => "el lugar de los hechos hasta ",'bold' => false);
            $text[] = array('text' => $trasladoLesionados["nombre_ips"], 'bold' => true);
        }
        else if ($trasladoLesionados["tipo_traslado_ambulancia"]==2){
            $text[] = array('text' => $trasladoLesionados["lugar_traslado"]." hasta ",'bold' => false);
            $text[] = array('text' => $trasladoLesionados["nombre_ips"], 'bold' => true);
        }
    }
    else if ($trasladoLesionados["servicio_ambulancia"]=="n"){
        $text[] = array('text' => 'El traslado del lesionado se realizó por sus propios medios hasta ','bold' => false);
        $text[] = array('text' => $trasladoLesionados["nombre_ips"], 'bold' => true);
    }
}

$wfTraslado = new WordFragment($docx, 'document');//fragmento de texto
$paragraphOptions = array('font' => 'Calibri', 'parseLineBreaks' => true);
$wfTraslado->addText($text, $paragraphOptions);
$docx->replaceVariableByWordFragment(array('traslado' => $wfTraslado), array('type' => 'block'));
unset($text);

mysqli_next_result($con);
$consultarObservacionesNuevas2=$consultarObservacionesInforme." AND id_seccion IN (3)";
$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas2);
if (mysqli_num_rows($queryObservaciones)>0){
    $wfObsTraslado = new WordFragment($docx, 'document');
    $wfObsTraslado->addText('OBSERVACIONES: ', array('bold' => true, 'color' => 'AB1B0D'));
    $cont=0;
    while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones)){
        $cont++;
        $wfObsTraslado->addText($resObservaciones["observacion"].'.', array('bold' => false)); 
    }
    $docx->replaceVariableByWordFragment(array('OBS_TRASLADO' => $wfObsTraslado), array('type' => 'block'));
}else{
    $docx->removeTemplateVariable('OBS_TRASLADO', 'block');
}

//LESIONES
$text = array();
if ($resInformacionCaso["sexo"]=="1") {
    $text[] = array('text' => "El lesionado ");   
}
else {
    $text[] = array('text' => "La lesionada ");   
}

$text[] = array('text' => $resInformacionCaso["nombre_lesionado"], 'bold' => true);  
$text[] = array('text' => " sufrió ".$resInformacionCaso["lesiones"]);   

mysqli_next_result($con);
$verificarVariosLesionados=mysqli_query($con,$consultarLesionados); 
if (mysqli_num_rows($verificarVariosLesionados)==1){
    $lesionesLesionados=mysqli_fetch_assoc($verificarVariosLesionados);
    $text[] = array('text' => '\n');
    if ($lesionesLesionados["sexo"]=="1"){
        $text[] = array('text' => "El lesionado ");   
    }
    else{
        $text[] = array('text' => "La lesionada ");   
    }

    $text[] = array('text' => $lesionesLesionados["nombre_lesionado"], 'bold' => true);  
    $text[] = array('text' => " sufrió ".$lesionesLesionados["lesiones"]);         
}

$wfLesiones = new WordFragment($docx, 'document');//fragmento de texto
$paragraphOptions = array('font' => 'Calibri', 'parseLineBreaks' => true);
$wfLesiones->addText($text, $paragraphOptions);
$docx->replaceVariableByWordFragment(array('lesiones' => $wfLesiones), array('type' => 'block'));
unset($text);

$consultarObservacionesNuevas3=$consultarObservacionesInforme." AND id_seccion=4";
mysqli_next_result($con);
$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas3);
if (mysqli_num_rows($queryObservaciones)>0){
    $wfObsLesion = new WordFragment($docx, 'document');
    $wfObsLesion->addText('OBSERVACIONES: ', array('bold' => true, 'color' => 'AB1B0D'));
    $cont=0;
    while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones)){
        $cont++;
        $wfObsLesion->addText($resObservaciones["observacion"].'.'); 
    }
    $docx->replaceVariableByWordFragment(array('OBS_LESIONES' => $wfObsLesion), array('type' => 'block'));
}else{
    $docx->removeTemplateVariable('OBS_LESIONES', 'block');
}


//TRATAMIENTO
$text = array();
if ($resInformacionCaso["sexo"]=="1") {
    $text[] = array('text' => "Al lesionado ");   
}
else {
    $text[] = array('text' => "A la lesionada ");   
}

$text[] = array('text' => $resInformacionCaso["nombre_lesionado"], 'bold' => true);  
$text[] = array('text' => " le realizan ".$resInformacionCaso["tratamiento"]);
    
mysqli_next_result($con);
$verificarVariosLesionados=mysqli_query($con,$consultarLesionados); 
if (mysqli_num_rows($verificarVariosLesionados)==1) {

    $tratamientoLesionados=mysqli_fetch_assoc($verificarVariosLesionados);
    if ($tratamientoLesionados["sexo"]=="1"){
        $text[] = array('text' => '\nAl lesionado ');  
    }
    else{
        $text[] = array('text' => '\nA la lesionada ');  
    }

    $text[] = array('text' => $tratamientoLesionados["nombre_lesionado"], 'bold' => true); 
    $text[] = array('text' => " le realizan ".$lesionesLesionados["tratamiento"]);        
}
$wfTratamiento = new WordFragment($docx, 'document');//fragmento de texto
$paragraphOptions = array('font' => 'Calibri', 'parseLineBreaks' => true);
$wfTratamiento->addText($text, $paragraphOptions);
$wfTratamiento->addText("|tratamiento|");
$docx->replaceVariableByWordFragment(array('tratamiento' => $wfTratamiento), array('type' => 'block'));
unset($text);

mysqli_next_result($con);
$consultarImagenesLesionados=mysqli_query($con,"SELECT ruta FROM multimedia_investigacion WHERE id_multimedia='2' and id_investigacion='".$id_caso."'");
$cantidadImagenesLesionados=mysqli_num_rows($consultarImagenesLesionados);

//IMAGENES DEL TRATAMIENTO O LESIONADOS
$cont=0;
$imprimioObsTrata = false;
$arrayImagenes = array();
if ($cantidadImagenesLesionados>0){

    while ($resImagenesLesionados=mysqli_fetch_assoc($consultarImagenesLesionados)){
        $resImagenesLesionados["ruta"] = '../../../data/multimedia/'.$resImagenesLesionados["ruta"];
        $arrayImagenes[$cont]=$resImagenesLesionados["ruta"];
        $cont++;
    }  

    $wfImgTratamiento = new WordFragment($docx, 'document');//fragmento de texto

    if (count($arrayImagenes)==1){
        $wfImgTratamiento->addBreak(array('type' => 'line', 'number' => 0));
        $foto = array('src' => $arrayImagenes[0], 'imageAlign' => 'center',
            'wrappingStyle' => 'tight', 'height' => 400, 'width' => 500,);
        $wfImgTratamiento->addImage($foto);
    }
    else  if (count($arrayImagenes)==2){
        $wfImgTratamiento->addBreak(array('type' => 'line', 'number' => 0));
        $foto = array('src' => $arrayImagenes[0], 'imageAlign' => 'center',
            'wrappingStyle' => 'tight', 'height' => 320, 'width' => 400,);
        $wfImgTratamiento->addImage($foto);
        $foto = array('src' => $arrayImagenes[1], 'imageAlign' => 'center',
            'wrappingStyle' => 'tight', 'height' => 320, 'width' => 400,);
        $wfImgTratamiento->addImage($foto);
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
                $wfImgTratamiento->addText($runsImgLesionados);
                $printLes = true;
            }        
        }

        if(!$printLes){ $wfImgTratamiento->addText($runsImgLesionados); }
    }
    
    mysqli_next_result($con);
    $consultarObservacionesNuevas4=$consultarObservacionesInforme." AND id_seccion=5";
    $queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas4);
    if (mysqli_num_rows($queryObservaciones)>0) {
        $resDetalleImagenSalud=mysqli_fetch_assoc($queryObservaciones);
        $wfImgTratamiento->addText($resDetalleImagenSalud["observacion"], array('italic'=>true,'bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
    }

    $wfImgTratamiento->addText("|tratamiento|");
    $docx->replaceVariableByWordFragment(array('tratamiento' => $wfImgTratamiento), array('type' => 'block'));
}

mysqli_next_result($con);
$verificarVariosLesionados=mysqli_query($con,$consultarLesionados);
$consultarObservacionesNuevas5=$consultarObservacionesInforme." AND id_seccion=6";
mysqli_next_result($con);
$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas5);

if (mysqli_num_rows($queryObservaciones)>0 || mysqli_num_rows($verificarVariosLesionados)>1){
    $wfObsTratam2 = new WordFragment($docx, 'document');
    $wfObsTratam2->addBreak(array('type' => 'line', 'number' => 0));
    $wfObsTratam2->addText('OBSERVACIONES: ', array('bold' => true, 'color' => 'AB1B0D'));

    if (mysqli_num_rows($queryObservaciones)>0) {
        $cont=0;
        while ($resObservacionesTratamiento=mysqli_fetch_assoc($queryObservaciones)){
            $cont++;
            $wfObsTratam2->addText($resObservacionesTratamiento["observacion"].'.', array('bold' => false)); 
        } 
    }

    $wfObsTratam2->addText("|tratamiento|");
    $docx->replaceVariableByWordFragment(array('tratamiento' => $wfObsTratam2), array('type' => 'block'));

    if (mysqli_num_rows($verificarVariosLesionados)>1)  {

        $wfObsTratam3 = new WordFragment($docx, 'document');
        $wfObsTratam3->addText("Logramos determinar en el proceso de investigación que en el siniestro materia de investigación existieron otros lesionados que a continuación detallamos:");
        $wfObsTratam3->addBreak(array('type' => 'line', 'number' => 0));

        $textTemp = array();
        $textThIngPol1 = new WordFragment($docx);
        $textTemp[] = array('text' => 'Nombre', 'bold' => true);
        $textThIngPol1->addText($textTemp);

        $textTemp = array();
        $textThIngPol2 = new WordFragment($docx);
        $textTemp[] = array('text' => 'Identificación', 'bold' => true);
        $textThIngPol2->addText($textTemp);

        $textTemp = array();
        $textThIngPol3 = new WordFragment($docx);
        $textTemp[] = array('text' => 'Teléfono', 'bold' => true);
        $textThIngPol3->addText($textTemp);

        $textTemp = array();
        $textThIngPol4 = new WordFragment($docx);
        $textTemp[] = array('text' => 'Condición', 'bold' => true);
        $textThIngPol4->addText($textTemp);

        $textTemp = array();
        $textThIngPol5 = new WordFragment($docx);
        $textTemp[] = array('text' => 'IPS', 'bold' => true);
        $textThIngPol5->addText($textTemp);

        $valuesTbIngPol = array(
            array(
                array(
                    'value' => $textThIngPol1, 
                    'backgroundColor' => 'FFEFC1'
                ),
                array(
                    'value' => $textThIngPol2, 
                    'backgroundColor' => 'FFEFC1'
                ),
                array(
                    'value' => $textThIngPol3, 
                    'backgroundColor' => 'FFEFC1'
                ),
                array(
                    'value' => $textThIngPol4, 
                    'backgroundColor' => 'FFEFC1'
                ),
                array(
                    'value' => $textThIngPol5, 
                    'backgroundColor' => 'FFEFC1'
                )
            )
        );

        while ($resTablasVariosLesionados=mysqli_fetch_assoc($verificarVariosLesionados)) {
            $valuesTbIngPol[] = array(
                $resTablasVariosLesionados['nombre_lesionado'],
                $resTablasVariosLesionados['identificacion_lesionado'],
                $resTablasVariosLesionados['telefono'],
                $resTablasVariosLesionados['condicion'],
                $resTablasVariosLesionados['nombre_ips']
            );
        }

        $paramTbIngPol = array(
            'border' => 'none',
            'tableAlign' => 'center',
            'textProperties' => array('font' => 'Calibri', 'fontSize' => 11)
        );

        $wfObsTratam3->addTable($valuesTbIngPol, $paramTbIngPol);
        $wfObsTratam3->addText("|tratamiento|");
        $docx->replaceVariableByWordFragment(array('tratamiento' => $wfObsTratam3), array('type' => 'block'));

        $wfObsTratam4 = new WordFragment($docx, 'document');
        $wfObsTratam4->addBreak(array('type' => 'line', 'number' => 0));
        $wfObsTratam4->addText('LESIONES OTROS LESIONADOS: ',array('bold' => true));  
        
        $a=0;        
        mysqli_next_result($con);
        $verificarVariosLesionadosLesiones=mysqli_query($con,$consultarLesionados); 
        $text[] = array();
        while ($lesionesOtrosLesionados=mysqli_fetch_assoc($verificarVariosLesionadosLesiones)) {
            $a++;
            
            if($a==1) {
                if ($lesionesOtrosLesionados["sexo"]=="1") {
                    $text[] = array('text' => 'El lesionado ');  
                }
                else {
                    $text[] = array('text' => 'La lesionada ');  
                }

                $text[] = array('text' => $lesionesOtrosLesionados["nombre_lesionado"],'bold' => true); 
                $text[] = array('text' => ' sufrió '.$lesionesOtrosLesionados["lesiones"],'bold' => true);  
            }
            else {                
                if ($lesionesOtrosLesionados["sexo"]=="1"){
                     $text[] = array('text' => '\nEl lesionado ');  
                }
                else{
                     $text[] = array('text' => '\nLa lesionada ');  
                }

                $text[] = array('text' => $lesionesOtrosLesionados["nombre_lesionado"],'bold' => true); 
                $text[] = array('text' => " sufrió ".$lesionesOtrosLesionados["lesiones"]);  
            }
        }   

        $paragraphOptions = array('font' => 'Calibri', 'parseLineBreaks' => true);
        $wfObsTratam4->addText($text, $paragraphOptions);
        $wfObsTratam4->addText("|tratamiento|");
        $docx->replaceVariableByWordFragment(array('tratamiento' => $wfObsTratam4), array('type' => 'block'));

        $wfObsTratam5 = new WordFragment($docx, 'document');
        $wfObsTratam5->addText('TRATAMIENTO OTROS LESIONADOS: ',array('bold' => true));  

        $a=0;        
        mysqli_next_result($con);
        $verificarVariosLesionados=mysqli_query($con,$consultarLesionados); 
        while ($tratamientosOtrosLesionados=mysqli_fetch_assoc($verificarVariosLesionados)) {

            $a++;
            if($a==1) {
                if ($tratamientosOtrosLesionados["sexo"]=="1") {
                    $textOtLes[] = array('text' => 'El lesionado ');  
                }
                else {
                    $textOtLes[] = array('text' => 'La lesionada ');  
                }
            }
            else {                
                if ($tratamientosOtrosLesionados["sexo"]=="1"){
                     $textOtLes[] = array('text' => '\nEl lesionado ');  
                }
                else{
                     $textOtLes[] = array('text' => '\nLa lesionada ');  
                }
            }
            $textOtLes[] = array('text' => $tratamientosOtrosLesionados["nombre_lesionado"],'bold' => true); 
            $textOtLes[] = array('text' => " sufrió ".$tratamientosOtrosLesionados["tratamiento"]);  
        } 
        $wfObsTratam5->addText($textOtLes, $paragraphOptions);
        $docx->replaceVariableByWordFragment(array('tratamiento' => $wfObsTratam5), array('type' => 'block'));
    } 
}else{
    $docx->removeTemplateVariable('tratamiento', 'block');
}

$direccionHechos="Los hechos ocurrieron en la ".$resInformacionCaso["lugar_accidente"]." en la ciudad de ".rtrim($resInformacionCaso["ciudad_ocurrencia"].'.');
$docx->replaceVariableByText(array('direccion_ic' => $direccionHechos));  

$anexosImagePRef = new WordFragment($docx, 'document');
if ($resInformacionCaso["visita_lugar_hechos"]=="N") {
     mysqli_next_result($con);
    $consultarDescripcionVisitaLugarHechos=mysqli_query($con,"SELECT descripcion as descripcion_visita_lugar_hechos FROM definicion_tipos WHERE id_tipo=35 and id=1");
    $visitaLugarHechos=mysqli_fetch_assoc($consultarDescripcionVisitaLugarHechos);
    $anexosImagePRef->addText($visitaLugarHechos["descripcion_visita_lugar_hechos"]);
}
else{
    $anexosImagePRef->addText($direccionHechos.", ".$resInformacionCaso["punto_referencia"]);
}

mysqli_next_result($con);
$consultarImagenesPunto=mysqli_query($con,"SELECT ruta FROM multimedia_investigacion WHERE id_multimedia='1' and id_investigacion='".$id_caso."'");
$cantidadImagenesPunto = mysqli_num_rows($consultarImagenesPunto);
unset($arrayImagenes);
$cont=0;

if ($cantidadImagenesPunto>0){
    
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
}
$docx->replaceVariableByWordFragment(array('punto_referencia_ic' => $anexosImagePRef), array('type' => 'block'));

$consultarObservacionesNuevas3=$consultarObservacionesInforme." AND id_seccion=8";
mysqli_next_result($con);
$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas3);
if (mysqli_num_rows($queryObservaciones)>0){
    $wfObsLesion = new WordFragment($docx, 'document');
    $wfObsLesion->addText('OBSERVACIONES: ', array('bold' => true, 'color' => 'AB1B0D'));
    $cont=0;
    while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones)){
        $cont++;
        $wfObsLesion->addText($resObservaciones["observacion"].'.'); 
    }
    $docx->replaceVariableByWordFragment(array('OBS_INV_CMP_REF' => $wfObsLesion), array('type' => 'block'));
}else{
    $docx->removeTemplateVariable('OBS_INV_CMP_REF', 'block');
}

//REGISTRO DE AUTORIDADES
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
$docx->replaceVariableByText(array("registro_autoridades_ic" => $resRegistroAutoridades["descripcion_registro_autoridades"]));

mysqli_next_result($con);
$consultarObservacionesNuevas10=$consultarObservacionesInforme." AND id_seccion=10";
$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas10);

if (mysqli_num_rows($queryObservaciones)>0){
    $resObservaciones=mysqli_fetch_assoc($queryObservaciones);
    $docx->replaceVariableByText(array("OBS_RGAU" => $resObservaciones["observacion"]));
}else{
    $docx->removeTemplateVariable('OBS_RGAU', 'block');
}

//TESTIGOS DEL CASO
$textoTestigo = new WordFragment($docx);
if ($resInformacionCaso["visita_lugar_hechos"]=="N"){
    $textoTestigo->addText("No se aportan testigos ya que es una zona fuera del perímetro urbano autorizado.");
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
        $paramTbOtroLes = array(
            'border' => 'none',
            'tableAlign' => 'center',
            'textProperties' => array('font' => 'Calibri', 'fontSize' => 11)
        );    
        
        $textoTestigo->addText('Se indagó con los moradores del sector quienes confirman la real ocurrencia de los hechos, entre ellos:'); 

        while ($resTestigos=mysqli_fetch_assoc($queryTestigos)){

            $textTemp = array();
            $textThLs1 = new WordFragment($docx);
            $textTemp[] = array('text' => 'NOMBRE:', 'bold' => true);
            $textThLs1->addText($textTemp);

            $textTemp = array();
            $textThLs2 = new WordFragment($docx);
            $textTemp[] = array('text' => "IDENTIFICACIÓN:", 'bold' => true);
            $textThLs2->addText($textTemp);

            $textTemp = array();
            $textThLs3 = new WordFragment($docx);
            $textTemp[] = array('text' => "TELÉFONO:", 'bold' => true);
            $textThLs3->addText($textTemp);

            $textTemp = array();
            $textThLs4 = new WordFragment($docx);
            $textTemp[] = array('text' => "DIRECCIÓN:", 'bold' => true);
            $textThLs4->addText($textTemp);

            $valuesTbOtroLes = array(
                array(
                    array(
                        'value' => $textThLs1, 
                        'backgroundColor' => 'E2EFD9'
                    ),
                    array(
                        'value' => $textThLs2, 
                        'backgroundColor' => 'E2EFD9'
                    ),
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
                    $resTestigos['nombre_testigo'],
                    $resTestigos['identificacion_testigo'],
                    $resTestigos['telefono'],
                    $resTestigos['direccion_residencia']
                )
            );

            $textoTestigo->addTable($valuesTbOtroLes, $paramTbOtroLes);
        }
    }
    else {
        $textoTestigo->addText("En el lugar de los hechos no se encontraron testigos, a pesar de la labor de campo realizada.");
    }
}

$docx->replaceVariableByWordFragment(array('testigos_ic' => $textoTestigo), array('type' => 'block'));

$consultarObservacionesNuevas9=$consultarObservacionesInforme." AND id_seccion=9";
mysqli_next_result($con);
$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas9);
if (mysqli_num_rows($queryObservaciones)>0){
    $wfObs3 = new WordFragment($docx, 'document');
    $wfObs3->addText('OBSERVACIONES: ', array('bold' => true, 'color' => 'AB1B0D'));
    $cont=0;
    while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones)){
        $cont++;
        $wfObs3->addText($resObservaciones["observacion"].'.'); 
    }
    $docx->replaceVariableByWordFragment(array('OBS_INV_CMP_TES' => $wfObs3), array('type' => 'block'));
}else{
    $docx->removeTemplateVariable('OBS_INV_CMP_TES', 'block');
}


//ENTREVISTA TOMADOR Y/O PROPIETARIO:
$textoEntrevista = new WordFragment($docx);
$text = array();

$text[] = array('text' => "El Tomador de la Póliza SOAT es ");
$text[] = array('text' => $resInformacionVehiculo["nombre_tomador"], 'bold' => true);
$text[] = array('text' => " identificado con ".$resInformacionVehiculo["tipo_identificacion_tomador"]." No. ");
$text[] = array('text' => $resInformacionVehiculo["no_identificacion_ltomador"], 'bold' => true);

if ($resInformacionVehiculo["direccion_tomador"]!=""){
    $text[] = array('text' => ", dirección: ".$resInformacionVehiculo["direccion_tomador"]);  
}

if ($resInformacionVehiculo["telefono_tomador"]!=""){
    $text[] = array('text' => ", teléfono: ".$resInformacionVehiculo["telefono_tomador"]);    
}
    
if ($resInformacionCaso["resultado_diligencia_tomador"]<>4) {
    mysqli_next_result($con);
    $consultarDescripcionDiligenciaTomador=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=38 and id='".$resInformacionCaso["resultado_diligencia_tomador"]."'");
    $resDescripcionDiligenciaTomador=mysqli_fetch_assoc($consultarDescripcionDiligenciaTomador);
    $text[] = array('text' => ", ".$resDescripcionDiligenciaTomador["descripcion2"]);

    $paragraphOptions = array('font' => 'Calibri', 'parseLineBreaks' => true);
    $textoEntrevista->addText($text, $paragraphOptions);
    $docx->replaceVariableByWordFragment(array('entrevista_tomador' => $textoEntrevista), array('type' => 'block'));
    unset($text);
}
else {
    $text[] = array('text' => ', quien expresa lo siguiente:'); 

    $paragraphOptions = array('font' => 'Calibri', 'parseLineBreaks' => true);   
    $textoEntrevista->addText($text, $paragraphOptions);
    $textoEntrevista->addText('"'.$resInformacionCaso["observaciones_diligencia_tomador"].'"', array('italic'=>true, 'jc' => 'both', 'bold'=>true));    
    $docx->replaceVariableByWordFragment(array('entrevista_tomador' => $textoEntrevista), array('type' => 'block'));
    unset($text);
}

$consultarObservacionesNuevas11=$consultarObservacionesInforme." AND id_seccion=11";
mysqli_next_result($con);
$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas11);
if (mysqli_num_rows($queryObservaciones)>0){
    $wfObs11 = new WordFragment($docx, 'document');
    $wfObs11->addText('OBSERVACIONES: ', array('bold' => true, 'color' => 'AB1B0D'));
    $cont=0;
    while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones)){
        $cont++;
        $wfObs11->addText($resObservaciones["observacion"].'.'); 
    }
    $docx->replaceVariableByWordFragment(array('OBS_ENT_TOMADOR' => $wfObs11), array('type' => 'block'));
}else{
    $docx->removeTemplateVariable('OBS_ENT_TOMADOR', 'block');
}


//INSPECCION DEL VEHICULO
$WFInspVehiculo = new WordFragment($docx, 'document');
if ($resInformacionCaso["inspeccion_tecnica"]=="S") {
    $WFInspVehiculo->addText("Se logra inspeccionar el vehículo implicado en el accidente de tránsito, se confirman sus características y vigencia según registro RUNT."); 
}
else {
    $WFInspVehiculo->addText("No se logra inspeccionar el vehículo implicado en el accidente de tránsito.");      
}
$WFInspVehiculo->addText("|inspecion_vehiculo|");
$docx->replaceVariableByWordFragment(array('inspecion_vehiculo' => $WFInspVehiculo), array('type' => 'block'));

mysqli_next_result($con);
$consultarImagenesInspeccion=mysqli_query($con,"SELECT ruta FROM multimedia_investigacion WHERE id_multimedia='3' and id_investigacion='".$id_caso."'");
$cantidadImagenesInspeccion=mysqli_num_rows($consultarImagenesInspeccion);
unset($arrayImagenes);
$cont=0;

if ($cantidadImagenesInspeccion>0) {

    while ($resImagenesLesionados=mysqli_fetch_assoc($consultarImagenesInspeccion)){
        $resImagenesLesionados["ruta"] = '../../../data/multimedia/'.$resImagenesLesionados["ruta"];

        $arrayImagenes[$cont]=$resImagenesLesionados["ruta"];
        $cont++;
    }  

    $wfImgInspVeh = new WordFragment($docx, 'document');//fragmento de texto

    if (count($arrayImagenes)==1){
        $foto = array('src' => $arrayImagenes[0], 'imageAlign' => 'center',
            'wrappingStyle' => 'tight', 'height' => 400, 'width' => 500,);
        $wfImgInspVeh->addImage($foto);
    }
    else  if (count($arrayImagenes)==2){
        $wfImgInspVeh->addBreak(array('type' => 'line', 'number' => 0));
        $foto = array('src' => $arrayImagenes[0], 'imageAlign' => 'center',
            'wrappingStyle' => 'tight', 'height' => 320, 'width' => 400,);
        $wfImgInspVeh->addImage($foto);
        $foto = array('src' => $arrayImagenes[1], 'imageAlign' => 'center',
            'wrappingStyle' => 'tight', 'height' => 320, 'width' => 400,);
        $wfImgInspVeh->addImage($foto);
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
                $wfImgInspVeh->addText($runsImgLesionados);
                $printLes = true;
            }        
        }

        if(!$printLes){ $wfImgInspVeh->addText($runsImgLesionados); }
    }
    
    mysqli_next_result($con);
    $consultarObservacionesNuevas12=$consultarObservacionesInforme." AND id_seccion=13";
    $queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas12);
    if (mysqli_num_rows($queryObservaciones)>0) {
        $resDetalleImagenSalud=mysqli_fetch_assoc($queryObservaciones);
        $wfImgInspVeh->addText($resDetalleImagenSalud["observacion"], array('italic'=>true,'bold'=>false,'size'=>11,'name'=>'Arial'),array('align'=> 'center','spaceBefore'=>0,'spaceAfter'=>0));
    }

    $docx->replaceVariableByWordFragment(array('inspecion_vehiculo' => $wfImgInspVeh), array('type' => 'block'));
}else{
    $docx->removeTemplateVariable('inspecion_vehiculo', 'block');
}
//OBSERVACIONES INSPECCION DEL VEHICULO
$consultarObservacionesNuevas13=$consultarObservacionesInforme." AND id_seccion=11";
mysqli_next_result($con);
$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas13);
if (mysqli_num_rows($queryObservaciones)>0){
    $wfObs13 = new WordFragment($docx, 'document');
    $wfObs13->addText('OBSERVACIONES: ', array('bold' => true, 'color' => 'AB1B0D'));
    $cont=0;
    while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones)){
        $cont++;
        $wfObs13->addText($resObservaciones["observacion"].'.'); 
    }
    $docx->replaceVariableByWordFragment(array('OBS_INSP_VEH' => $wfObs13), array('type' => 'block'));
}else{
    $docx->removeTemplateVariable('OBS_INSP_VEH', 'block');
}

//REGISTRO RUNT
if ($resInformacionCaso["consulta_runt"]=="N") {
    $WFRegRunt = new WordFragment($docx, 'document');    
    mysqli_next_result($con);
    $consultarCausalRunt=mysqli_query("SELECT b.descripcion2 as causal FROM definicion_tipos b WHERE b.id_tipo=22 and b.id='$resInformacionCaso[causal_runt]'");
    $resCausalRunt=mysqli_fetch_assoc($consultarCausalRunt);
    $WFRegRunt->addText($resCausalRunt['causal']);  
    $WFRegRunt->addText("|reg_runt|");
    $docx->replaceVariableByWordFragment(array('reg_runt' => $WFRegRunt), array('type' => 'block'));
}

mysqli_next_result($con);   
$consultarRunt=mysqli_query($con,"SELECT * FROM multimedia_investigacion WHERE id_multimedia='4' and id_investigacion='".$id_caso."'");
$cantidadImagenesRunt=mysqli_num_rows($consultarRunt);

if ($cantidadImagenesRunt>0) {      
    $imgRegRunt = new WordFragment($docx);       
    while ($resRunt=mysqli_fetch_assoc($consultarRunt)) {
        $resRunt["ruta"] = '../../../data/multimedia/'.$resRunt["ruta"];
        $foto = array('src' => $resRunt['ruta'], 'imageAlign' => 'center',
            'wrappingStyle' => 'tight', 'height' => 380, 'width' => 500,);
        $imgRegRunt->addImage($foto);
    }
    $docx->replaceVariableByWordFragment(array('reg_runt' => $imgRegRunt), array('type' => 'block'));
}else{
    $docx->removeTemplateVariable('reg_runt', 'block');
}

//OBSERVACIONES INSPECCION DEL VEHICULO
$consultarObservacionesNuevas14=$consultarObservacionesInforme." AND id_seccion=14";
mysqli_next_result($con);
$queryObservaciones=mysqli_query($con,$consultarObservacionesNuevas14);
if (mysqli_num_rows($queryObservaciones)>0){
    $wfObs14 = new WordFragment($docx, 'document');
    $wfObs14->addText('OBSERVACIONES: ', array('bold' => true, 'color' => 'AB1B0D'));
    $cont=0;
    while ($resObservaciones=mysqli_fetch_assoc($queryObservaciones)){
        $cont++;
        $wfObs14->addText($resObservaciones["observacion"].'.'); 
    }
    $docx->replaceVariableByWordFragment(array('OBS_RUNT' => $wfObs14), array('type' => 'block'));
}else{
    $docx->removeTemplateVariable('OBS_RUNT', 'block');
}

//SEGURIDAD SOCIAL
$text = array();
if ($resInformacionCaso["id_seguridad_social"]<>"3") {

    if ($resInformacionCaso["id_seguridad_social"]=="4") {

        if($resInformacionCaso["sexo"] == 1){

            if ($resInformacionCaso["edad"]<18) {
                $text[] = array('text' => 'El menor ');
            }else if($resInformacionCaso["edad"] >= 18 && $resInformacionCaso["edad"] <= 26){
                $text[] = array('text' => 'El joven ');       
            }else{
                $text[] = array('text' => 'El señor ');       
            }
        } elseif($resInformacionCaso["sexo"] == 2){
            
            if ($resInformacionCaso["edad"]<18) {
                $text[] = array('text' => 'La menor ');
            }else if($resInformacionCaso["edad"] >= 18 && $resInformacionCaso["edad"] <= 26){
                $text[] = array('text' => 'La joven ');   
            }else{
                $text[] = array('text' => 'La señora ');      
            }
        }
        
        $text[] = array('text' => $resInformacionCaso["nombre_lesionado"].", ", "bold" => true);  
    
    
        $text[] = array('text' => "reporta afiliación al sistema General de Seguridad Social en Salud con las Fuerzas Armadas de Colombia");
        $text[] = array('text' => ", según ficha técnica Anexa:");
    }
    else{
        if($resInformacionCaso["sexo"] == 1){

            if ($resInformacionCaso["edad"]<18) {
                $text[] = array('text' => 'El menor ');
            }else if($resInformacionCaso["edad"] >= 18 && $resInformacionCaso["edad"] <= 26){
                $text[] = array('text' => 'El joven ');       
            }else{
                $text[] = array('text' => 'El señor ');       
            }
        } elseif($resInformacionCaso["sexo"] == 2){
            
            if ($resInformacionCaso["edad"]<18) {
                $text[] = array('text' => 'La menor ');
            }else if($resInformacionCaso["edad"] >= 18 && $resInformacionCaso["edad"] <= 26){
                $text[] = array('text' => 'La joven ');   
            }else{
                $text[] = array('text' => 'La señora ');      
            }
        }
        
        $text[] = array('text' => $resInformacionCaso["nombre_lesionado"].", ", "bold" => true);  
    
        if ($resInformacionCaso["id_seguridad_social"]=="1"){

            $text[] = array('text' => "reporta afiliación al sistema General de Seguridad Social en Salud con ");
            $text[] = array('text' => $resInformacionCaso["eps"], "bold" => true);
            
            mysqli_next_result($con);
            $consultarRegimenEPS=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=18 and id='".$resInformacionCaso["regimen"]."'");
            $resRegimenEPS=mysqli_fetch_assoc($consultarRegimenEPS);

            mysqli_next_result($con);
            $consultarEstadoEPS=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=19 and id='".$resInformacionCaso["estado_eps"]."'");
            $resEstadoEPS=mysqli_fetch_assoc($consultarEstadoEPS);
            
            $text[] = array('text' => ", estado ");
            $text[] = array('text' => $resEstadoEPS["descripcion"], "bold" => true);
            $text[] = array('text' => ", régimen ");
            $text[] = array('text' => $resRegimenEPS["descripcion"], "bold" => true);
            $text[] = array('text' => ", según ficha técnica Anexa:");
        }
        else if ($resInformacionCaso["id_seguridad_social"]=="2") {
            $text[] = array('text' => "no reporta afiliación al sistema General de Seguridad Social en Salud, según ficha técnica Anexa:");
        }
    }   
}
else{

    $text[] = array('text' => 'No fue posible consultar la afiliación al Sistema de Seguridad Social ');

    if($resInformacionCaso["sexo"] == 1){

        if ($resInformacionCaso["edad"]<18) {
            $text[] = array('text' => 'del menor ');
        }else if($resInformacionCaso["edad"] >= 18 && $resInformacionCaso["edad"] <= 26){
            $text[] = array('text' => 'del joven ');      
        }else{
            $text[] = array('text' => 'del señor ');      
        }
    } elseif($resInformacionCaso["sexo"] == 2){
        
        if ($resInformacionCaso["edad"]<18) {
            $text[] = array('text' => 'de la menor ');
        }else if($resInformacionCaso["edad"] >= 18 && $resInformacionCaso["edad"] <= 26){
            $text[] = array('text' => 'de la joven ');    
        }else{
            $text[] = array('text' => 'de la señora ');       
        }
    }

    mysqli_next_result($con);
    $consultarCausalConsulta=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=20 and id='".$resInformacionCaso["causal_consulta"]."'");
    $resCausalConsulta=mysqli_fetch_assoc($consultarCausalConsulta);
    $text[] = array('text' => $resInformacionCaso["nombre_lesionado"].", ", "bold" => true);  
    $text[] = array('text' => 'por'.$resCausalConsulta["descripcion"].'.');
}

mysqli_next_result($con);
$verificarVariosLesionados=mysqli_query($con,$consultarLesionados);

if (mysqli_num_rows($verificarVariosLesionados)>0){
    while ($resVariosLesionados=mysqli_fetch_assoc($verificarVariosLesionados)) {
        $text[] = array('text' => '\n');

        if ($resVariosLesionados["id_seguridad_social"]<>"3"){
            
            if ($resVariosLesionados["id_seguridad_social"]=="4"){

                if($resVariosLesionados["sexo"] == 1){

                    if ($resVariosLesionados["edad"]<18) {
                        $text[] = array('text' => 'El menor ');
                    }else if($resVariosLesionados["edad"] >= 18 && $resVariosLesionados["edad"] <= 26){
                        $text[] = array('text' => 'El joven ');       
                    }else{
                        $text[] = array('text' => 'El señor ');       
                    }
                } elseif($resVariosLesionados["sexo"] == 2){
                    
                    if ($resVariosLesionados["edad"]<18) {
                        $text[] = array('text' => 'La menor ');
                    }else if($resVariosLesionados["edad"] >= 18 && $resVariosLesionados["edad"] <= 26){
                        $text[] = array('text' => 'La joven ');   
                    }else{
                        $text[] = array('text' => 'La señora ');      
                    }
                }
                
                $text[] = array('text' => $resVariosLesionados["nombre_lesionado"].", ", "bold" => true);               
                $text[] = array('text' => "reporta afiliación al sistema General de Seguridad Social en Salud con las Fuerzas Armadas de Colombia");
                $text[] = array('text' => ", según ficha técnica Anexa:");                
            }
            else{

                if($resVariosLesionados["sexo"] == 1){

                    if ($resVariosLesionados["edad"]<18) {
                        $text[] = array('text' => 'El menor ');
                    }else if($resVariosLesionados["edad"] >= 18 && $resVariosLesionados["edad"] <= 26){
                        $text[] = array('text' => 'El joven ');       
                    }else{
                        $text[] = array('text' => 'El señor ');       
                    }
                } elseif($resVariosLesionados["sexo"] == 2){
                    
                    if ($resVariosLesionados["edad"]<18) {
                        $text[] = array('text' => 'La menor ');
                    }else if($resVariosLesionados["edad"] >= 18 && $resVariosLesionados["edad"] <= 26){
                        $text[] = array('text' => 'La joven ');   
                    }else{
                        $text[] = array('text' => 'La señora ');      
                    }
                }
                
                $text[] = array('text' => $resVariosLesionados["nombre_lesionado"].", ", "bold" => true);  
            
                if ($resVariosLesionados["id_seguridad_social"]=="1"){
                    $text[] = array('text' => "reporta afiliación al sistema General de Seguridad Social en Salud con ");
                    $text[] = array('text' => $resVariosLesionados["eps"], "bold" => true);
                    
                    mysqli_next_result($con);
                    $consultarRegimenEPS=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=18 and id='".$resVariosLesionados["regimen"]."'");
                    $resRegimenEPS=mysqli_fetch_assoc($consultarRegimenEPS);

                    mysqli_next_result($con);
                    $consultarEstadoEPS=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=19 and id='".$resVariosLesionados["estado_eps"]."'");
                    $resEstadoEPS=mysqli_fetch_assoc($consultarEstadoEPS);
                    
                    $text[] = array('text' => ", estado ");
                    $text[] = array('text' => $resEstadoEPS["descripcion"], "bold" => true);
                    $text[] = array('text' => ", régimen ");
                    $text[] = array('text' => $resRegimenEPS["descripcion"], "bold" => true);
                    $text[] = array('text' => ", según ficha técnica Anexa:");
                }
                else if ($resVariosLesionados["id_seguridad_social"]=="2"){
                    $text[] = array('text' => "no reporta afiliación al sistema General de Seguridad Social en Salud, según ficha técnica Anexa:");
                }
            }
        }
        else{

            $text[] = array('text' => 'No fue posible consultar la afiliación al Sistema de Seguridad Social ');

            if($resVariosLesionados["sexo"] == 1){

                if ($resVariosLesionados["edad"]<18) {
                    $text[] = array('text' => 'del menor ');
                }else if($resVariosLesionados["edad"] >= 18 && $resVariosLesionados["edad"] <= 26){
                    $text[] = array('text' => 'del joven ');      
                }else{
                    $text[] = array('text' => 'del señor ');      
                }
            } elseif($resVariosLesionados["sexo"] == 2){
                
                if ($resVariosLesionados["edad"]<18) {
                    $text[] = array('text' => 'de la menor ');
                }else if($resVariosLesionados["edad"] >= 18 && $resVariosLesionados["edad"] <= 26){
                    $text[] = array('text' => 'de la joven ');    
                }else{
                    $text[] = array('text' => 'de la señora ');       
                }
            }

            mysqli_next_result($con);
            $consultarCausalConsulta=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=20 and id='".$resVariosLesionados["causal_consulta"]."'");
            $resCausalConsulta=mysqli_fetch_assoc($consultarCausalConsulta);
            $text[] = array('text' => $resVariosLesionados["nombre_lesionado"].", ", 'bold' => true);  
            $text[] = array('text' => 'por '.$resCausalConsulta["descripcion"].'.');          
        }           
    }
}

$wtSegSocial = new WordFragment($docx, 'document');
$paragraphOptions = array('font' => 'Calibri', 'parseLineBreaks' => true, 'jc' => 'both');   
$wtSegSocial->addText($text, $paragraphOptions);
$wtSegSocial->addText("|seguridad_social|");
$docx->replaceVariableByWordFragment(array('seguridad_social' => $wtSegSocial), array('type' => 'block'));
unset($text);

mysqli_next_result($con);
$consultarSeguridadSocial=mysqli_query($con,"SELECT * FROM multimedia_investigacion WHERE id_investigacion='".$id_caso."' AND id_multimedia=5");

if (mysqli_num_rows($consultarSeguridadSocial) > 0) {
    unset($arrayImagenes);
    $cont=0;
    $imgRegRunt = new WordFragment($docx, 'document');
    while ($resImagenesSeguridadSocial=mysqli_fetch_assoc($consultarSeguridadSocial)) {
        $resImagenesSeguridadSocial["ruta"] = '../../../data/multimedia/'.$resImagenesSeguridadSocial["ruta"];
        $arrayImagenes[$cont]=$resImagenesSeguridadSocial['ruta'];
        $foto = array('src' => $resImagenesSeguridadSocial['ruta'], 'imageAlign' => 'center',
            'wrappingStyle' => 'tight', 'height' => 380, 'width' => 500,);
        $imgRegRunt->addImage($foto);
        $cont++;
    }
    $docx->replaceVariableByWordFragment(array('seguridad_social' => $imgRegRunt), array('type' => 'block'));
}else{
    $docx->removeTemplateVariable('seguridad_social', 'block');
}

//HISTORIAL DE LA POLIZA
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

    $docx->replaceVariableByWordFragment(array('registros_poliza' => $tablaIngPol), array('type' => 'block'));
}else{
    $docx->removeTemplateVariable('TITULO_HISTORIAL', 'block');
    $docx->removeTemplateVariable('registros_poliza', 'block');
}

//CONCLUSIONES
$wfConclusion = new WordFragment($docx, 'document');//fragmento de texto
$paragraphOptions = array('jc' => 'both');
$wfConclusion->addText($resInformacionCaso["conclusiones"], $paragraphOptions);
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

$docx->replaceVariableByText(array("nombre_lesionado_ppal" => $resInformacionCaso["nombre_lesionado"]));
$docx->replaceVariableByText(array("poliza" => $resInformacionVehiculo["numero_poliza"]));
$docx->replaceVariableByText(array("tipo_vehiculo" => $resInformacionVehiculo["tipo_vehiculo"]));
$docx->replaceVariableByText(array("placa" => $resInformacionVehiculo["placa"]));

if($porcTendFraude >= 0 && $porcTendFraude <= 10){
    $docx->replaceVariableByText(array('1' => $porcTendFraude.'%'));
    $celdaImpresa = 1;
}elseif($porcTendFraude > 10 && $porcTendFraude <= 20){
    $docx->replaceVariableByText(array('2' => $porcTendFraude.'%'));
    $celdaImpresa = 2;
}elseif($porcTendFraude > 20 && $porcTendFraude <= 30){
    $docx->replaceVariableByText(array('3' => $porcTendFraude.'%'));
    $celdaImpresa = 3;
}elseif($porcTendFraude > 30 && $porcTendFraude <= 40){
    $docx->replaceVariableByText(array('4' => $porcTendFraude.'%'));
    $celdaImpresa = 4;
}elseif($porcTendFraude > 40 && $porcTendFraude <= 50){
    $docx->replaceVariableByText(array('5' => $porcTendFraude.'%'));
    $celdaImpresa = 5;
}elseif($porcTendFraude > 50 && $porcTendFraude <= 60){
    $docx->replaceVariableByText(array('6' => $porcTendFraude.'%'));
    $celdaImpresa = 6;
}elseif($porcTendFraude > 60 && $porcTendFraude <= 70){
    $docx->replaceVariableByText(array('7' => $porcTendFraude.'%'));
    $celdaImpresa = 7;
}elseif($porcTendFraude > 70 && $porcTendFraude <= 80){
    $docx->replaceVariableByText(array('8' => $porcTendFraude.'%'));
    $celdaImpresa = 8;
}elseif($porcTendFraude > 80 && $porcTendFraude <= 90){
    $docx->replaceVariableByText(array('9' => $porcTendFraude.'%'));
    $celdaImpresa = 9;
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
$consultarImagenesForm=mysqli_query($con,"SELECT * FROM multimedia_investigacion WHERE id_multimedia='6' and id_investigacion='".$id_caso."'");
$cantidadImagenesForm=mysqli_num_rows($consultarImagenesForm);

mysqli_next_result($con);
$consultarImagenesRegistroTelefonico=mysqli_query($con,"SELECT * FROM multimedia_investigacion WHERE id_multimedia='7' and id_investigacion='".$id_caso."'");
$cantidadImagenesRegistroTelefonico=mysqli_num_rows($consultarImagenesRegistroTelefonico);

//FOTOS FOMULARIO
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
        $anexosImageRegTel->addBreak(array('type' => 'line', 'number' => 2));
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
}else{
    $docx->removeTemplateVariable('imagenes_anexos', 'inline');
}

//SI ES DE LA ASEGURADORA -> ESTADO ADJUNTAR HOJA DE VIDA DE INVESTIGADOR
if($resInformacionCaso['id_aseguradora'] == 2){
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
    }
}

//GUARDAR Y DESCARGAR INFORME
$nombre="INFORME ".$resInformacionCaso["nombre_lesionado"]." POLIZA No. ".$resInformacionVehiculo["numero_poliza"];
$docx->createDocx('NuevoPositivo');
header('Content-Disposition: attachment; filename="'.$nombre.'.docx"');
echo file_get_contents('NuevoPositivo.docx');