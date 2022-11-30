<?php
include('../conexion/conexion.php');
global $con;
$idCuentaCobro=29;
$consultaTipoCasoAseguradoraCuentaCobro="(SELECT CONCAT(b.nombre_aseguradora,'-',d.descripcion,'-',g.descripcion) AS aseguradora_tipo_caso,COUNT(a.id) AS cantidad_investigaciones,CASE WHEN e.valor_investigacion IS NULL THEN '0' ELSE e.valor_investigacion END AS valor_investigacion,e.tipo_caso,e.id_aseguradora,e.tipo_perimetro,e.tipo_auditoria,e.resultado
  FROM 
  investigaciones a 
  LEFT JOIN aseguradoras b ON a.id_aseguradora=b.id 
  LEFT JOIN definicion_tipos c ON c.descripcion2=a.tipo_caso 
  LEFT JOIN definicion_tipos d ON d.id=c.descripcion
  LEFT JOIN detalle_cuenta_cobro_investigadores e ON e.id_investigacion=a.id
  LEFT JOIN cuenta_cobro_investigadores f ON f.id=e.id_cuenta_cobro
  LEFT JOIN definicion_tipos g ON g.id=e.resultado
  WHERE g.id_tipo=44 AND c.id_tipo=43 AND d.id_tipo=42 AND f.id='".$idCuentaCobro."' AND e.resultado=3
  GROUP BY b.id,d.id,g.id)
  
  UNION
  
  (SELECT CONCAT(b.nombre_aseguradora,'-',d.descripcion,'-',g.descripcion,'-',h.descripcion,'-',i.descripcion) AS aseguradora_tipo_caso,COUNT(a.id) AS cantidad_investigaciones,CASE WHEN e.valor_investigacion IS NULL THEN '0' ELSE e.valor_investigacion END AS valor_investigacion,e.tipo_caso,e.id_aseguradora,e.tipo_perimetro,e.tipo_auditoria,e.resultado
  FROM 
  investigaciones a 
  LEFT JOIN aseguradoras b ON a.id_aseguradora=b.id 
  LEFT JOIN definicion_tipos c ON c.descripcion2=a.tipo_caso 
  LEFT JOIN definicion_tipos d ON d.id=c.descripcion
  LEFT JOIN detalle_cuenta_cobro_investigadores e ON e.id_investigacion=a.id
  LEFT JOIN cuenta_cobro_investigadores f ON f.id=e.id_cuenta_cobro
  LEFT JOIN definicion_tipos g ON g.id=e.resultado
  LEFT JOIN definicion_tipos h ON h.id=e.tipo_auditoria
  LEFT JOIN definicion_tipos i ON i.id=e.tipo_perimetro
  WHERE i.id_tipo=46 AND h.id_tipo=45 AND g.id_tipo=44 AND c.id_tipo=43 AND d.id_tipo=42 AND f.id='".$idCuentaCobro."' AND e.resultado<>3
  GROUP BY b.id,d.id,g.id,h.id,i.id)";

  $queryTipoCasoAseguradoraCuentaCobro=mysqli_query($con,$consultaTipoCasoAseguradoraCuentaCobro);
    $data=array();

    while ($resTipoCasoAseguradoraCuentaCobro=mysqli_fetch_array($queryTipoCasoAseguradoraCuentaCobro,MYSQLI_ASSOC))   {
      
    $data[]=array("aseguradora_tipo_caso"=>$resTipoCasoAseguradoraCuentaCobro["aseguradora_tipo_caso"],
      "cantidad_investigaciones"=>"<input disabled class='CamNum input-sm form-control-sm form-control'  type='text' id='cantidadInvestigacionesAseguradoraCuentaCobro' value='".$resTipoCasoAseguradoraCuentaCobro["cantidad_investigaciones"]."' name='".$resTipoCasoAseguradoraCuentaCobro["tipo_caso_general"]."'>",
      "valor_caso"=>"<input class='CamNum input-sm form-control-sm form-control'  type='text' id='valorCasoInvestigacionesAseguradoraCuentaCobro' value='".$resTipoCasoAseguradoraCuentaCobro["valor_investigacion"]."' name='".$resTipoCasoAseguradoraCuentaCobro["tipo_caso_general"]."'>",
      "valor_total"=>"<input disabled class='CamNum input-sm form-control-sm form-control'  type='text' id='valorTotalInvestigacionesAseguradoraCuentaCobro' value='".($resTipoCasoAseguradoraCuentaCobro["cantidad_investigaciones"]*$resTipoCasoAseguradoraCuentaCobro["valor_investigacion"])."' name='".$resTipoCasoAseguradoraCuentaCobro["tipo_caso_general"]."'>",
      "id_aseguradora"=>$resTipoCasoAseguradoraCuentaCobro["id_aseguradora"],
      "id_tipo_caso"=>$resTipoCasoAseguradoraCuentaCobro["tipo_caso"],
      "id_resultado"=>$resTipoCasoAseguradoraCuentaCobro["resultado"],
      "id_tipo_zona"=>$resTipoCasoAseguradoraCuentaCobro["tipo_perimetro"],
      "id_tipo_auditoria"=>$resTipoCasoAseguradoraCuentaCobro["tipo_auditoria"]
      
      
      );
    }

      $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
    );

    
    echo json_encode($data); 
    
?>
