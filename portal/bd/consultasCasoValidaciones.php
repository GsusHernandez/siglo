<?php
include('../conexion/conexion.php');
include ('../plugins/mailer/send.php');



function modificarAsignacionInvestigacion($idInvestigacion,$fechaEntregaFrmAsignarInvestigacion,$motivoInvestigacionFrmAsignarInvestigacion,$soporteFile,$cartaPresentacionFile,$idUsuario)
{
  global $con;
    $data=array();
    $respuesta=array();

$insertarCasoSOATAsignacion = "CALL manejoInvestigacionesValidaciones (11,'','', '', '', '', '','','','','','','','','','".$idInvestigacion."','','','','','','".$fechaEntregaFrmAsignarInvestigacion."','".$motivoInvestigacionFrmAsignarInvestigacion."',@resp,@resp2,@resp3)";

if (mysqli_query($con,$insertarCasoSOATAsignacion))
      {
          mysqli_next_result($con);
          $consultaRespuestaInsertarCasoSOATAsignacion=mysqli_query($con,"SELECT @resp as resp,@resp2 as resp2, @resp3 as resp3");
          $respInsertarCasoSOAT=mysqli_fetch_assoc($consultaRespuestaInsertarCasoSOATAsignacion);

     

        

          $respuesta["codigo"]=$respInsertarCasoSOAT["resp3"];
          $respuesta["caso"]=$respInsertarCasoSOAT["resp2"];
          $respuesta["respuesta"]=$respInsertarCasoSOAT["resp"];  
      }
      else
      {
         $respuesta["respuesta"]=2;
      }
      

        if ($respInsertarCasoSOAT["resp"]==1)
        {


            if (!empty($soporteFile))
            {
                mysqli_next_result($con);
                $consultarSoporte=mysqli_query($con,"SELECT * FROM multimedia_investigacion WHERE id_investigacion='".$idInvestigacion."' and id_multimedia='10'");
                if (mysqli_num_rows($consultarSoporte)>0)
                {
                  $resSoporte=mysqli_fetch_assoc($consultarSoporte);
                  
                    $explode=explode("globalredltda.co/siglo/portal", $resSoporte["ruta"]);
                    unlink("..".$explode[1]);
                    mysqli_next_result($con);
                  $eliminarSoporte=mysqli_query($con,"CALL manejoMultimediaInvestigaciones (12,'','','','".$resSoporte["id"]."','',@resp)");
                }
                

                $extension=explode("/",$soporteFile['type']);
                $archivo=base64_encode("s-".$idInvestigacion.rand()).".".$extension[1];
                  
  
                      if ( move_uploaded_file($soporteFile['tmp_name'], "../data/soporte_asignacion_investigacion/".$archivo)) 
                      {
                          
                           $consultaSubirSoporte="CALL manejoMultimediaInvestigaciones (7,'".$archivo."','".$idInvestigacion."','','','".$idUsuario."',@resp)";

                            mysqli_next_result($con);
                              if (mysqli_query($con,$consultaSubirSoporte))
                              {
                                mysqli_next_result($con);
                                $consultaRespuestaSubirSoporte=mysqli_query($con,"SELECT @resp as resp");
                                $respSubirSoporte=mysqli_fetch_assoc($consultaRespuestaSubirSoporte);
                                $respuesta["respuesta_cargar_soporte"]=$respSubirSoporte["resp"];

                                
                              }else{
                                $respuesta["respuesta_cargar_soporte"]=2;
                              }
                                                          

                        }
                        else
                        {
                         $respuesta["respuesta_cargar_soporte"]=3;
                        } 

                       
              }else{
                $respuesta["respuesta_cargar_soporte"]=5;
              }



         
        }



              if (!empty($cartaPresentacionFile))
            {
              
                mysqli_next_result($con);
                $consultarCP=mysqli_query($con,"SELECT * FROM multimedia_investigacion WHERE id_investigacion='".$idInvestigacion."' and id_multimedia='11'");
                if (mysqli_num_rows($consultarCP)>0)
                {
                  $resCP=mysqli_fetch_assoc($consultarCP);

                    unlink("../data/soporte_asignacion_investigacion/".$resCP["ruta"]);
                     mysqli_next_result($con);
                  $eliminarCP=mysqli_query($con,"CALL manejoMultimediaInvestigaciones (12,'','','','".$resCP["id"]."','',@resp)");
                }

                $extension=explode("/",$cartaPresentacionFile['type']);
                $archivo=base64_encode("c-". $idInvestigacion.rand()).".".$extension[1];
                  $data["ruta"]="data/soporte_asignacion_investigacion/".$ruta;
  
                if ( move_uploaded_file($cartaPresentacionFile['tmp_name'], "../data/soporte_asignacion_investigacion/".$archivo)) 
                        {
                          
                           $consultaSubirCartaPresentacion="CALL manejoMultimediaInvestigaciones (8,'".$archivo."','".$idInvestigacion."','','','".$idUsuario."',@resp)";

                            mysqli_next_result($con);
                              if (mysqli_query($con,$consultaSubirCartaPresentacion))
                              {
                                mysqli_next_result($con);
                                $consultaRespuestaSubirCartaPresentacion=mysqli_query($con,"SELECT @resp as resp");
                                $respSubirCartaPresentacion=mysqli_fetch_assoc($consultaRespuestaSubirCartaPresentacion);
                                $respuesta["respuesta_cargar_carta"]=$respSubirCartaPresentacion["resp"];

                                
                              }else{
                                $respuesta["respuesta_cargar_carta"]=2;
                              }
                                                          

                        }
                        else
                        {
                         $respuesta["respuesta_cargar_carta"]=3;
                        } 

                       
              }else{
                $respuesta["respuesta_cargar_carta"]=5;
              }
              
   


      return json_encode($respuesta);
}

function registrarAsignacionInvestigacion($idAseguradoraFrmAsignarInvestigacion,$fechaEntregaFrmAsignarInvestigacion,$tipoCasoFrmAsignarInvestigacion,$motivoInvestigacionFrmAsignarInvestigacion,$soporteFile,$cartaPresentacionFile,$idUsuario)
{
  global $con;
    $data=array();
    $respuesta=array();

$insertarCasoSOATAsignacion = "CALL manejoInvestigacionesValidaciones (10,'".$idAseguradoraFrmAsignarInvestigacion."','', '', '', '', '','','','','".$idUsuario."','','','','".$idUsuario."','','','','','','','".$fechaEntregaFrmAsignarInvestigacion."','".$motivoInvestigacionFrmAsignarInvestigacion."',@resp,@resp2,@resp3)";

if (mysqli_query($con,$insertarCasoSOATAsignacion))
      {

          $consultaRespuestaInsertarCasoSOATAsignacion=mysqli_query($con,"SELECT @resp as resp,@resp2 as resp2, @resp3 as resp3");
          $respInsertarCasoSOAT=mysqli_fetch_assoc($consultaRespuestaInsertarCasoSOATAsignacion);

     

        

          $respuesta["codigo"]=$respInsertarCasoSOAT["resp3"];
          $respuesta["caso"]=$respInsertarCasoSOAT["resp2"];
          $respuesta["respuesta"]=$respInsertarCasoSOAT["resp"];  
      }
      else
      {
         $respuesta["respuesta"]=2;
      }
      

        if ($respInsertarCasoSOAT["resp"]==1)
        {


            if (!empty($soporteFile))
            {
              

                $extension=explode("/",$soporteFile['type']);
                $archivo=base64_encode("s-".$respuesta["caso"].rand()).".".$extension[1];
                  
  
                      if ( move_uploaded_file($soporteFile['tmp_name'], "../data/soporte_asignacion_investigacion/".$archivo)) 
                      {
                          
                           $consultaSubirSoporte="CALL manejoMultimediaInvestigaciones (7,'".$archivo."','".$respuesta["caso"]."','','','".$idUsuario."',@resp)";


                              if (mysqli_query($con,$consultaSubirSoporte))
                              {

                                $consultaRespuestaSubirSoporte=mysqli_query($con,"SELECT @resp as resp");
                                $respSubirSoporte=mysqli_fetch_assoc($consultaRespuestaSubirSoporte);
                                $respuesta["respuesta_cargar_soporte"]=$respSubirSoporte["resp"];

                                
                              }else{
                                $respuesta["respuesta_cargar_soporte"]=2;
                              }
                                                          

                        }
                        else
                        {
                         $respuesta["respuesta_cargar_soporte"]=3;
                        } 

                       
              }else{
                $respuesta["respuesta_cargar_soporte"]=5;
              }



         
        }



              if (!empty($cartaPresentacionFile))
            {
              

                $extension=explode("/",$cartaPresentacionFile['type']);
                $archivo=base64_encode("c-". $respuesta["caso"].rand()).".".$extension[1];
                  $data["ruta"]="data/soporte_asignacion_investigacion/".$archivo;
  
                if ( move_uploaded_file($cartaPresentacionFile['tmp_name'], "../data/soporte_asignacion_investigacion/".$archivo)) 
                        {
                          
                           $consultaSubirCartaPresentacion="CALL manejoMultimediaInvestigaciones (8,'".$archivo."','".$respuesta["caso"]."','','','".$idUsuario."',@resp)";


                              if (mysqli_query($con,$consultaSubirCartaPresentacion))
                              {

                                $consultaRespuestaSubirCartaPresentacion=mysqli_query($con,"SELECT @resp as resp");
                                $respSubirCartaPresentacion=mysqli_fetch_assoc($consultaRespuestaSubirCartaPresentacion);
                                $respuesta["respuesta_cargar_carta"]=$respSubirCartaPresentacion["resp"];

                                
                              }else{
                                $respuesta["respuesta_cargar_carta"]=2;
                              }
                                                          

                        }
                        else
                        {
                         $respuesta["respuesta_cargar_carta"]=3;
                        } 

                       
              }else{
                $respuesta["respuesta_cargar_carta"]=5;
              }
              
        if ($respuesta["respuesta"]==1)
        {
          $respuesta["respuesta_envio_correo"]=enviarEmail($respuesta["caso"],"1");
          
        }


      return json_encode($respuesta);
}


function registrarCasoValidaciones($aseguradoraFrmCasosValidaciones,$ciudadEntidadFrmCasosValidaciones,$nombreEntidadFrmCasosValidaciones,$identificacionEntidadFrmCasosValidaciones,$digVerEntidadFrmCasosValidaciones,$fechaMatriculaFrmCasosValidaciones,$direccionEntidadFrmCasosValidaciones,$telefonoEntidadFrmCasosValidaciones,$investigadorFrmCasosValidaciones,$actividadEconomicaFrmCasosValidaciones,$usuario,$identificadoresCaso)
{
     global $con;

     $respuesta=array();
    $insertarCasoValidaciones = "CALL manejoInvestigacionesValidaciones (1,'".$aseguradoraFrmCasosValidaciones."','".$ciudadEntidadFrmCasosValidaciones."', '".$nombreEntidadFrmCasosValidaciones."', '".$identificacionEntidadFrmCasosValidaciones."', '".$digVerEntidadFrmCasosValidaciones."', '".$direccionEntidadFrmCasosValidaciones."','".$telefonoEntidadFrmCasosValidaciones."','".$actividadEconomicaFrmCasosValidaciones."','".$investigadorFrmCasosValidaciones."','".$usuario."','','','','".$usuario."','','','','','','','".$fechaMatriculaFrmCasosValidaciones."','',@resp,@resp2,@resp3)";

      if (mysqli_query($con,$insertarCasoValidaciones))
      {

          $consultaRespuestaInsertarCasoValidaciones=mysqli_query($con,"SELECT @resp as resp,@resp2 as resp2, @resp3 as resp3");
          $respInsertarCasoValidaciones=mysqli_fetch_assoc($consultaRespuestaInsertarCasoValidaciones);

          $eliminarIdenticadoresCasoValidaciones="CALL manejoInvestigacionesValidaciones (2,'','', '', '', '', '','','','','','','','','','".$idCasoFrmCasosValidaciones."','','','','','','','',@resp,@resp2,@resp3)";
          mysqli_query($con,$eliminarIdenticadoresCasoValidaciones);
          
           $identificadoresCasosConvertidos=json_decode($identificadoresCaso);
           mysqli_next_result($con);
              foreach($identificadoresCasosConvertidos as $passIdentificadoresCasosConvertidos)
              {
                  $insertarIdenticadoresCasoValidaciones="CALL manejoInvestigacionesValidaciones (3,'','', '', '', '', '','','','','','".$passIdentificadoresCasosConvertidos->identificador."','".$passIdentificadoresCasosConvertidos->fecha_asignacion."','".$passIdentificadoresCasosConvertidos->fecha_entrega."','".$usuario."','".$idCasoFrmCasosValidaciones."','','','','','','','',@resp,@resp2,@resp3)";
                  
                  
                  mysqli_query($con,$insertarIdenticadoresCasoValidaciones);
                                  
              }

          $respuesta["codigo"]=$respInsertarCasoValidaciones["resp3"];
          $respuesta["caso"]=$respInsertarCasoValidaciones["resp2"];
          $respuesta["respuesta"]=$respInsertarCasoValidaciones["resp"];  
      }
      else
      {
         $respuesta["respuesta"]=2;
      }
      
     return json_encode($respuesta);

}


function consultarRepresentanteLegal($idInvestigacion)
{
	global $con;

     $respuesta=array();
    $consultaRepresentanteLegal = "CALL manejoInvestigacionesValidaciones (8,'','', '', '', '', '','','','','','','','','','".$idInvestigacion."','','','','','','','',@resp,@resp2,@resp3)";

      $queryRepresentanteLegal=mysqli_query($con,$consultaRepresentanteLegal);
      $respRepresentanteLegal=mysqli_fetch_assoc($queryRepresentanteLegal);


          $respuesta["nombre_representante"]=$respRepresentanteLegal["nombre_representante"];
          $respuesta["apellidos_representante"]=$respRepresentanteLegal["apellidos_representante"];  
          $respuesta["tipo_identificacion_representante"]=$respRepresentanteLegal["tipo_identificacion_representante"];  
          $respuesta["identificacion_representante"]=$respRepresentanteLegal["identificacion_representante"];  
          $respuesta["correo_representante"]=$respRepresentanteLegal["correo_representante"];  
          $respuesta["id_investigacion"]=$respRepresentanteLegal["id_investigacion"];  
          
      
     return json_encode($respuesta);
}


function modificarRepresentanteLegal($idInvestigacionFrmRepresentanteLegal,$nombresRepresentanteLegalFrm,$apellidosRepresentanteLegalFrm,$tipoIdentificacionRepresentanteLegalFrm,$identificacionRepresentanteLegalFrm,$correoRepresentanteLegalFrm)
{
		  global $con;

     $respuesta=array();
    $insertarRepresentanteLegal = "CALL manejoInvestigacionesValidaciones (9,'','', '', '', '', '','','','','','','','','','".$idInvestigacionFrmRepresentanteLegal."','".$nombresRepresentanteLegalFrm."','".$apellidosRepresentanteLegalFrm."','".$tipoIdentificacionRepresentanteLegalFrm."','".$identificacionRepresentanteLegalFrm."','".$correoRepresentanteLegalFrm."','','',@resp,@resp2,@resp3)";

      if (mysqli_query($con,$insertarRepresentanteLegal))
      {
      	 mysqli_next_result($con);
          $consultaRespuestaRepresentanteLegal=mysqli_query($con,"SELECT @resp as resp,@resp2 as resp2, @resp3 as resp3");
          $respInsertarRepresentanteLegal=mysqli_fetch_assoc($consultaRespuestaRepresentanteLegal);

          $variable=$respInsertarRepresentanteLegal["resp"];  
      }
      else
      {
         $variable=2;
      }
      
     return $variable;
	}


function eliminarCasoValidacion($idRegistro)
{
		global $con;

     $respuesta=array();
    $consultaEliminarCasoValidacion = "CALL manejoInvestigacionesValidaciones (7,'','', '', '', '', '','','','','','','','','','".$idRegistro."','','','','','','','',@resp,@resp2,@resp3)";

      if (mysqli_query($con,$consultaEliminarCasoValidacion))
      {
      	 mysqli_next_result($con);
          $consultaRespuestaEliminarCasoValidacion=mysqli_query($con,"SELECT @resp as resp,@resp2 as resp2, @resp3 as resp3");
          $respInsertarEliminarCasoValidacion=mysqli_fetch_assoc($consultaRespuestaEliminarCasoValidacion);

          $variable=$respInsertarEliminarCasoValidacion["resp"];  
      }
      else
      {
         $variable=2;
      }
      
     return $variable;
}


function consultarCasoValidaciones($idCaso)
{
     global $con;

     $respuesta=array();
    $consultarCasoValidaciones = "CALL manejoInvestigacionesValidaciones (4,'','', '', '', '', '','','','','','','','','','".$idCaso."','','','','','','','',@resp,@resp2,@resp3)";

      $queryCasoValidaciones=mysqli_query($con,$consultarCasoValidaciones);
      $respCasoValidaciones=mysqli_fetch_assoc($queryCasoValidaciones);


          $respuesta["id_investigacion"]=$respCasoValidaciones["id_investigacion"];
          $respuesta["tipo_caso"]=$respCasoValidaciones["tipo_caso"];  
          $respuesta["tipo_general_caso"]=$respCasoValidaciones["tipo_general_caso"];  
          $respuesta["id_aseguradora"]=$respCasoValidaciones["id_aseguradora"];  
          $respuesta["id_investigador"]=$respCasoValidaciones["id_investigador"];  
          $respuesta["nombre_entidad"]=$respCasoValidaciones["nombre_entidad"];  
          $respuesta["ciudad_entidad"]=$respCasoValidaciones["ciudad_entidad"];  
          $respuesta["identificacion_entidad"]=$respCasoValidaciones["identificacion_entidad"];  
          $respuesta["digver_entidad"]=$respCasoValidaciones["digver_entidad"];  
          $respuesta["direccion"]=$respCasoValidaciones["direccion"];  
          $respuesta["telefono"]=$respCasoValidaciones["telefono"];  
          $respuesta["actividad_economica"]=$respCasoValidaciones["actividad_economica"];  
          $respuesta["fecha_matricula"]=$respCasoValidaciones["fecha_matricula"];  
          $respuesta["id_usuario"]=$respCasoValidaciones["id_usuario"];  
          


     
      
     return json_encode($respuesta);

}


function modificarCasoValidaciones($aseguradoraFrmCasosValidaciones,$ciudadEntidadFrmCasosValidaciones,$nombreEntidadFrmCasosValidaciones,$identificacionEntidadFrmCasosValidaciones,$digVerEntidadFrmCasosValidaciones,$fechaMatriculaFrmCasosValidaciones,$direccionEntidadFrmCasosValidaciones,$telefonoEntidadFrmCasosValidaciones,$investigadorFrmCasosValidaciones,$actividadEconomicaFrmCasosValidaciones,$idCasoFrmCasosValidaciones,$identificadoresCaso,$usuario)
{

		global $con;

     $respuesta=array();
    $modificarCasoValidaciones = "CALL manejoInvestigacionesValidaciones (5,'".$aseguradoraFrmCasosValidaciones."','".$ciudadEntidadFrmCasosValidaciones."', '".$nombreEntidadFrmCasosValidaciones."', '".$identificacionEntidadFrmCasosValidaciones."', '".$digVerEntidadFrmCasosValidaciones."', '".$direccionEntidadFrmCasosValidaciones."','".$telefonoEntidadFrmCasosValidaciones."','".$actividadEconomicaFrmCasosValidaciones."','".$investigadorFrmCasosValidaciones."','','','','','','".$idCasoFrmCasosValidaciones."','','','','','','".$fechaMatriculaFrmCasosValidaciones."','',@resp,@resp2,@resp3)";

      if (mysqli_query($con,$modificarCasoValidaciones))
      {
      	 mysqli_next_result($con);
          $consultaRespuestaModificarCasoValidaciones=mysqli_query($con,"SELECT @resp as resp,@resp2 as resp2, @resp3 as resp3");
          $respModificarCasoValidaciones=mysqli_fetch_assoc($consultaRespuestaModificarCasoValidaciones);

          $eliminarIdenticadoresCasoValidaciones="CALL manejoInvestigacionesValidaciones (2,'','', '', '', '', '','','','','','','','','','".$idCasoFrmCasosValidaciones."','','','','','','','',@resp,@resp2,@resp3)";
          mysqli_query($con,$eliminarIdenticadoresCasoValidaciones);
          
           $identificadoresCasosConvertidos=json_decode($identificadoresCaso);
           mysqli_next_result($con);
              foreach($identificadoresCasosConvertidos as $passIdentificadoresCasosConvertidos)
              {
                  $insertarIdenticadoresCasoValidaciones="CALL manejoInvestigacionesValidaciones (3,'','', '', '', '', '','','','','','".$passIdentificadoresCasosConvertidos->identificador."','".$passIdentificadoresCasosConvertidos->fecha_asignacion."','".$passIdentificadoresCasosConvertidos->fecha_entrega."','".$usuario."','".$idCasoFrmCasosValidaciones."','','','','','','','',@resp,@resp2,@resp3)";
                  
                  
                  mysqli_query($con,$insertarIdenticadoresCasoValidaciones);
                                  
              }

          $respuesta["codigo"]=$respModificarCasoValidaciones["resp3"];
          $respuesta["caso"]=$respModificarCasoValidaciones["resp2"];
          $respuesta["respuesta"]=$respModificarCasoValidaciones["resp"];  
      }
      else
      {
         $respuesta["respuesta"]=2;
      }
      
     return json_encode($respuesta);

}

?>