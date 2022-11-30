<?php
include('../conexion/conexion.php');
include('consultasBasicas.php');
function guardarValoresCasosCuentaCobro($casosCuentaCobro,$valorBiaticoFrmCuentaCobro,$valorAdicionalFrmCuentaCobro,$observacionesFrmCuentaCobro,$idCuentaCobroInvestigador,$idUsuario)
{
    $data2=array();
    global $con;
    $cadena="";


    $val=0;
   

    mysqli_next_result($con);

      $detalleCasosCuentaCobro=json_decode($casosCuentaCobro);
      foreach($detalleCasosCuentaCobro as $passDetalleCasosCuentaCobro)
      {
        if ($passDetalleCasosCuentaCobro->resultadoInvestigacionesAseguradoraCuentaCobro==3)
        {
          $consultaInvestigacionesTipoCasoAseguradora="CALL manejoCuentasCobroInvestigadores(12,'','".$idCuentaCobroInvestigador."','".$passDetalleCasosCuentaCobro->idAseguradoraInvestigacionesAseguradoraCuentaCobro."','','".$passDetalleCasosCuentaCobro->tipoCasoInvestigacionesAseguradoraCuentaCobro."','','','',@resp)";  


       
        }else{
           $consultaInvestigacionesTipoCasoAseguradora="CALL manejoCuentasCobroInvestigadores(8,'".$passDetalleCasosCuentaCobro->tipoZonaInvestigacionesAseguradoraCuentaCobro."','".$idCuentaCobroInvestigador."','".$passDetalleCasosCuentaCobro->idAseguradoraInvestigacionesAseguradoraCuentaCobro."','','".$passDetalleCasosCuentaCobro->tipoCasoInvestigacionesAseguradoraCuentaCobro."','".$passDetalleCasosCuentaCobro->resultadoInvestigacionesAseguradoraCuentaCobro."','".$passDetalleCasosCuentaCobro->tipoAuditoriaInvestigacionesAseguradoraCuentaCobro."','',@resp)";     
        }
        
        mysqli_next_result($con);
        $queryInvestigacionesTipoCasoAseguradora=mysqli_query($con,$consultaInvestigacionesTipoCasoAseguradora);
        $cadena.=$consultaInvestigacionesTipoCasoAseguradora;
        while ($resInvestigacionesTipoCasoAseguradora=mysqli_fetch_assoc($queryInvestigacionesTipoCasoAseguradora))
        {

           $consultaGuardarValoresCasosCuentaCobro="CALL manejoCuentasCobroInvestigadores(7,'','','','".$passDetalleCasosCuentaCobro->valorCasoInvestigacionesAseguradoraCuentaCobro."','','','".$resInvestigacionesTipoCasoAseguradora["id_investigacion"]."','',@resp)";

            //$cadena.=$consultaGuardarValoresCasosCuentaCobro;
            mysqli_next_result($con);
            $queryGuardarValoresCasosCuentaCobro=mysqli_query($con,$consultaGuardarValoresCasosCuentaCobro);        
                          
            mysqli_next_result($con);
            $queryRespuestaRegistrarValoresCasosCuentaCobro=mysqli_query($con,"SELECT @resp as resp,@resp2 as resp2");
            $resRespuestaRegistrarValoresCasosCuentaCobro=mysqli_fetch_assoc($queryRespuestaRegistrarValoresCasosCuentaCobro);  
            $variable=$resRespuestaRegistrarValoresCasosCuentaCobro["resp"];
            array_push($data2,$variable);
        }

       
        
      }

      if (in_array("2",$data2))
      {

        $variable=2;
                
      }else{
        $variable=1;
         $consultaGuardarValorInvestigacionesCuentaCobro="CALL manejoCuentasCobroInvestigadores(9,'".$observacionesFrmCuentaCobro."','".$idCuentaCobroInvestigador."','".$valorBiaticoFrmCuentaCobro."','".$valorAdicionalFrmCuentaCobro."','','','','',@resp)";

            //$cadena.=$consultaGuardarValorInvestigacionesCuentaCobro;
            mysqli_next_result($con);
            $queryGuardarValorInvestigacionesCuentaCobro=mysqli_query($con,$consultaGuardarValorInvestigacionesCuentaCobro);        
                          
            mysqli_next_result($con);
            $queryRespuestaRegistrarValorInvestigacionesCuentaCobro=mysqli_query($con,"SELECT @resp as resp,@resp2 as resp2");
            $resRespuestaRegistrarValorInvestigacionesCuentaCobro=mysqli_fetch_assoc($queryRespuestaRegistrarValorInvestigacionesCuentaCobro);  
            $variable=$resRespuestaRegistrarValorInvestigacionesCuentaCobro["resp"];
      }
 

    return $variable;

}

function registrarPeriodosCuentaCobroInvestigadores($descripcion_periodo,$idUsuario)
{

  global $con;

  $consultarPeriodosCuentaCobroInvestigadores="CALL manejoCuentasCobroInvestigadores(1,'".$descripcion_periodo."','','','','','','','".$idUsuario."',@resp)";

  if (mysqli_query($con,$consultarPeriodosCuentaCobroInvestigadores))
  {

    $consultaRespuestaCrearPeriodoCCInvestigadores=mysqli_query($con,"SELECT @resp as resp");
    $respCrearPeriodoCCInvestigadores=mysqli_fetch_assoc($consultaRespuestaCrearPeriodoCCInvestigadores);
    $variable=$respCrearPeriodoCCInvestigadores["resp"];

    
  }else{
    $variable=2;
  }
      return ($variable);
}


function modificarPeriodosCuentaCobroInvestigadores($descripcion_periodo,$id_periodo)
{

  global $con;

  $consultarModificarPeriodosCuentaCobroInvestigadores="CALL manejoCuentasCobroInvestigadores(2,'".$descripcion_periodo."','','','','','','".$id_periodo."','',@resp)";

  if (mysqli_query($con,$consultarModificarPeriodosCuentaCobroInvestigadores))
  {

    $consultaRespuestaModificarPeriodoCCInvestigadores=mysqli_query($con,"SELECT @resp as resp");
    $respModificarPeriodoCCInvestigadores=mysqli_fetch_assoc($consultaRespuestaModificarPeriodoCCInvestigadores);
    $variable=$respModificarPeriodoCCInvestigadores["resp"];

    
  }else{
    $variable=2;
  }
      return ($variable);
}




function eliminarPeriodosCuentaCobroInvestigadores($idRegistro)
{

  global $con;

$consultaEliminarPeriodosCuentaCobroInvestigadores="CALL manejoCuentasCobroInvestigadores(4,'','','','','','','".$idRegistro."','',@resp)";

if (mysqli_query($con,$consultaEliminarPeriodosCuentaCobroInvestigadores))
{

  $consultaRespEliminarPeriodosCuentaCobroInvestigadores=mysqli_query($con,"SELECT @resp as resp");
  $respEliminarPeriodosCuentaCobroInvestigadores=mysqli_fetch_assoc($consultaRespEliminarPeriodosCuentaCobroInvestigadores);
  $variable=$respEliminarPeriodosCuentaCobroInvestigadores["resp"];

  
}else{
  $variable=2;
}
      return ($variable);
}



function vigenciaPeriodosCuentaCobroInvestigadores($idRegistro)
{

  global $con;

  $consultaVigenciaPeriodosCuentaCobroInvestigadores="CALL manejoCuentasCobroInvestigadores(3,'','','','','','','".$idRegistro."','',@resp)";

  if (mysqli_query($con,$consultaVigenciaPeriodosCuentaCobroInvestigadores))
  {

    $consultaRespVigenciaPeriodosCuentaCobroInvestigadores=mysqli_query($con,"SELECT @resp as resp");
    $respVigenciaPeriodosCuentaCobroInvestigadores=mysqli_fetch_assoc($consultaRespVigenciaPeriodosCuentaCobroInvestigadores);
    $variable=$respVigenciaPeriodosCuentaCobroInvestigadores["resp"];

    
  }else{
    $variable=2;
  }
        return ($variable);
}


function consultarPeriodoCCInvestigaciones($idRegistro)
{
  global $con;
 $data=array();
$consultaPeriodosCuentaCobroInvestigadores="CALL manejoCuentasCobroInvestigadores(5,'','','','','','','".$idRegistro."','',@resp)";

$queryPeriodosCuentaCobroInvestigadores=mysqli_query($con,$consultaPeriodosCuentaCobroInvestigadores);
while ($resPeriodosCuentaCobroInvestigadores=mysqli_fetch_assoc($queryPeriodosCuentaCobroInvestigadores))
{
    $data["descripcion"]=$resPeriodosCuentaCobroInvestigadores["descripcion"];
 
    $data["id"]=$resPeriodosCuentaCobroInvestigadores["id"];

}
      return json_encode($data);

}



function consultarInformacionCuentaCobro($idCuentaCobro)
{
  global $con;
 $data=array();
$consultaCuentaCobroInvestigadores="CALL manejoCuentasCobroInvestigadores(10,'','','','','','','".$idCuentaCobro."','',@resp)";

$queryCuentaCobroInvestigadores=mysqli_query($con,$consultaCuentaCobroInvestigadores);
while ($resCuentaCobroInvestigadores=mysqli_fetch_assoc($queryCuentaCobroInvestigadores))
{
    $data["valor_total"]=$resCuentaCobroInvestigadores["valor_total"];
    $data["valor_biaticos"]=$resCuentaCobroInvestigadores["valor_biaticos"];
    $data["valor_adicionales"]=$resCuentaCobroInvestigadores["valor_adicionales"];
    $data["observacion"]=$resCuentaCobroInvestigadores["observacion"];
 
    $data["id"]=$resCuentaCobroInvestigadores["id"];

}
      return json_encode($data);

}


function vigenciaInvestigadoresCuentaCobroPeriodo($idRegistro)
{

  global $con;

  $consultaVigenciaPeriodosCuentaCobroInvestigadores="CALL manejoCuentasCobroInvestigadores(11,'','','','','','','".$idRegistro."','',@resp)";

  if (mysqli_query($con,$consultaVigenciaPeriodosCuentaCobroInvestigadores))
  {

    $consultaRespVigenciaPeriodosCuentaCobroInvestigadores=mysqli_query($con,"SELECT @resp as resp");
    $respVigenciaPeriodosCuentaCobroInvestigadores=mysqli_fetch_assoc($consultaRespVigenciaPeriodosCuentaCobroInvestigadores);
    $variable=$respVigenciaPeriodosCuentaCobroInvestigadores["resp"];

    
  }else{
    $variable=2;
  }
        return ($variable);

}
?>