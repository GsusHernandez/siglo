<?php  

include('../conexion/conexion.php'); 

function consultarCasosSOAT($codigoFrmBuscarSOAT,$nombresFrmBuscarSOAT,$apellidosFrmBuscarSOAT,$identificacionFrmBuscarSOAT,$placaFrmBuscarSOAT,$polizaFrmBuscarSOAT,$identificadorFrmBuscarSOAT) //,$tipoConsultaBuscar,$usuario
{
  global $con;
   $consultarTipoUsuario=mysqli_query($con,"SELECT * FROM usuarios WHERE id='".$usuario."'");
   $resTipoUsuario=mysqli_fetch_array($consultarTipoUsuario,MYSQLI_ASSOC);

   mysqli_next_result($con);
           $regs="";
           $data=array();
  if ($tipoConsultaBuscar=="buscarCasoFiltros")
      {

     

           $consultarFiltrosSOAT="SELECT distinct a.id,a.tipo_caso
           FROM investigaciones a
           LEFT JOIN detalle_investigaciones_soat b ON a.id=b.id_investigacion
           LEFT JOIN personas_investigaciones_soat c ON c.id_investigacion=a.id
           LEFT JOIN personas d ON d.id=c.id_persona
           LEFT JOIN poliza_vehiculo e ON e.id_poliza=b.id_poliza
           LEFT JOIN vehiculos f ON f.id=e.id_vehiculo
           LEFT JOIN polizas g ON g.id=e.id_poliza
           LEFT JOIN id_casos_aseguradora h ON h.id_investigacion=a.id ";
           $cont=0;
            if ($resTipoUsuario["tipo_usuario"]==4){
                if ($cont==0){
                $consultarFiltrosSOAT.=" WHERE ";
                }else{
                  $consultarFiltrosSOAT.=" AND ";
                }
                  $consultarFiltrosSOAT.=" a.id_aseguradora='".$resTipoUsuario["id_aseguradora"]."'";
                  $cont++;
            }

           
           if ($codigoFrmBuscarSOAT!=""){
            if ($cont==0){
              $consultarFiltrosSOAT.=" WHERE ";
            }else{
              $consultarFiltrosSOAT.=" AND ";
            }
              $consultarFiltrosSOAT.=" a.codigo='".$codigoFrmBuscarSOAT."'";
              $cont++;
            }
           else
           {
              if ($nombresFrmBuscarSOAT!="")
              {
                if ($cont==0)
                {
                  $consultarFiltrosSOAT.=" WHERE ";
                }else{
                  $consultarFiltrosSOAT.=" AND ";
                }
                  $consultarFiltrosSOAT.=" d.nombres='".$nombresFrmBuscarSOAT."'";
                   $cont++;
              }else if ($apellidosFrmBuscarSOAT!=""){
                if ($cont==0){
                  $consultarFiltrosSOAT.=" WHERE ";
                }else{
                  $consultarFiltrosSOAT.=" AND ";
                }
                  $consultarFiltrosSOAT.=" d.apellidos='".$apellidosFrmBuscarSOAT."'";
                  $cont++;
              }else if ($identificacionFrmBuscarSOAT!=""){
                if ($cont==0){
                  $consultarFiltrosSOAT.=" WHERE ";
                }else{
                  $consultarFiltrosSOAT.=" AND ";
                }
                  $consultarFiltrosSOAT.=" d.identificacion='".$identificacionFrmBuscarSOAT."'";
                  $cont++;
              }else if ($placaFrmBuscarSOAT!=""){
                if ($cont==0){
                  $consultarFiltrosSOAT.=" WHERE ";
                }else{
                  $consultarFiltrosSOAT.=" AND ";
                }
                  $consultarFiltrosSOAT.=" h.placa='".$placaFrmBuscarSOAT."'";            
                  $cont++;
              }else if ($polizaFrmBuscarSOAT!=""){
                if ($cont==0){
                  $consultarFiltrosSOAT.=" WHERE ";
                }else{
                  $consultarFiltrosSOAT.=" AND ";
                }
                  $consultarFiltrosSOAT.=" i.numero='".$polizaFrmBuscarSOAT."'";            
                  $cont++;
              }else if ($identificadorFrmBuscarSOAT!="")
              {
                if ($cont==0){
                  $consultarFiltrosSOAT.=" WHERE ";
                }else{
                  $consultarFiltrosSOAT.=" AND ";
                }
                  $consultarFiltrosSOAT.=" m.identificador='".$identificadorFrmBuscarSOAT."'";            
                  $cont++;
                  
              }
           }
      }
      else if ($tipoConsultaBuscar=="buscarCasoSinInformeSOAT")
      {
          $consultarFiltrosSOAT="SELECT a.id,a.tipo_caso,b.ruta,b.id_multimedia
           FROM investigaciones a
           LEFT JOIN multimedia_investigacion b ON a.id=b.id_investigacion
           WHERE b.id_multimedia=9 AND b.vigente='c' and a.id_usuario='".$usuario."'";

      }
      else if ($tipoConsultaBuscar=="buscarCasoAsignadosSOAT")
      {
          $consultarFiltrosSOAT="SELECT a.id,a.tipo_caso
           FROM investigaciones a
           LEFT JOIN estado_investigaciones b ON a.id=b.id_investigacion
           WHERE b.estado=18 AND b.vigente='s' and a.id_usuario='".$usuario."'";

      }
      else if ($tipoConsultaBuscar=="buscarCasoAsignadosAseguradoraSOAT")
      {
          $consultarFiltrosSOAT="SELECT a.id,a.tipo_caso
           FROM investigaciones a
           LEFT JOIN estado_investigaciones b ON a.id=b.id_investigacion
           WHERE b.estado in (1,12) AND b.vigente='s'";

      }

         $queryCasosFiltrosSOAT=mysqli_query($con,$consultarFiltrosSOAT);
       $GMTrans = array("1","2","3","4","5","6","13","14");
       $MuerteIncapacidad = array("7","8","9","10");


       while ($resCasosFiltrosSOAT=mysqli_fetch_array($queryCasosFiltrosSOAT,MYSQLI_ASSOC))
       {
             $consultarInformacionBasica="SELECT e.descripcion as tipo_caso,g.nombre_aseguradora as aseguradora,a.codigo,a.id,
                 CASE 
                    WHEN i.placa IS NULL THEN 'NO REGISTRA'
                    ELSE i.placa END AS placa_vehiculo,
                    CASE 
                    WHEN CONCAT(f.nombres,' ',f.apellidos) IS NULL THEN 'NO REGISTRA'
                    ELSE CONCAT(f.nombres,' ',f.apellidos) END AS nombre_investigador,
                    CASE 
                    WHEN j.numero IS NULL THEN 'NO REGISTRA'
                    ELSE j.numero END AS poliza,
                  CONCAT(d.nombres,' ',d.apellidos) as nombre_usuario,
                   CASE 
                    WHEN  b.fecha_accidente IS NULL THEN 'NO REGISTRA'
                    ELSE  b.fecha_accidente END AS fecha_accidente
                 ,c.descripcion AS tipo_solicitud,a.id_usuario
                  FROM investigaciones a
                  LEFT JOIN detalle_investigaciones_soat b ON a.id=b.id_investigacion
                  LEFT JOIN definicion_tipos c ON c.id=a.tipo_solicitud
                  LEFT JOIN usuarios d ON d.id=a.id_usuario
                  LEFT JOIN definicion_tipos e ON e.id=a.tipo_caso
                  LEFT JOIN investigadores f ON f.id=a.id_investigador
                  LEFT JOIN aseguradoras g ON g.id=a.id_aseguradora
                  LEFT JOIN poliza_vehiculo h ON h.id_poliza=b.id_poliza
                  LEFT JOIN vehiculos i ON i.id=h.id_vehiculo
                  LEFT JOIN polizas j ON j.id=h.id_poliza
                  where c.id_tipo=14 and e.id_tipo=8 and a.id='".$resCasosFiltrosSOAT["id"]."'";
                   mysqli_next_result($con);
                    $queryInformacionBasica=mysqli_query($con,$consultarInformacionBasica);
                    $resInformacionBasica=mysqli_fetch_array($queryInformacionBasica,MYSQLI_ASSOC);

                       mysqli_next_result($con);
                  $consultarInforme=mysqli_query($con,"SELECT * FROM multimedia_investigacion WHERE id_investigacion='".$resInformacionBasica["id"]."' and id_multimedia=9 and vigente<>'c'");
                  $resInforme=mysqli_fetch_array($consultarInforme,MYSQLI_ASSOC);
                  $cantidadInformes=mysqli_num_rows($consultarInforme);
 
            if (in_array($resCasosFiltrosSOAT["tipo_caso"], $GMTrans))
            {
             
               
                  $consultarInformacionPersonas="SELECT a.id_investigacion,CONCAT(b.nombres,' ',b.apellidos) as nombre_lesionado,concat(c.descripcion,' ',b.identificacion) as identificacion_lesionado,d.nombre_ips as nombre_reclamante
                  FROM personas_investigaciones_soat a
                  left join personas b on b.id=a.id_persona
                  left join definicion_tipos c on c.id=b.tipo_identificacion
                  left join ips d on d.id=a.ips
                  where c.id_tipo=5 and a.id_investigacion='".$resCasosFiltrosSOAT["id"]."'";
                  mysqli_next_result($con);
                  $queryInformacionPersonas=mysqli_query($con,$consultarInformacionPersonas);

                 


           

                  $informacionGeneral="";
                  $opciones="";
                 $opciones.="<div class='btn-group'>";
              
                $opciones.="<button type='button' class='btn btn-success' name='".$resInformacionBasica["id"]."'>";

                if ($cantidadInformes>0)
                 {
                  $opciones.="<span class='fa fa-file-pdf-o'></span>";
                 }

                $opciones.=$resInformacionBasica["codigo"]."</button>
                <button type='button' class='btn btn-success dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resInformacionBasica["id"]."'>";
               

                $opciones.="<span class='caret'></span>
                <span class='sr-only'>Toggle Dropdown</span>
                </button>
                <ul class='dropdown-menu' role='menu'>";

                if ($cantidadInformes>0)
                {
                $opciones.="<li><a target='_blank' href='".$resInforme["ruta"].'?'.time()."'>Ver Informe</a></li><li class='divider'></li>";  
                }
                
                

                
                
                if ($resTipoUsuario["tipo_usuario"]==1)
                {

                     if ($resInformacionBasica["id_usuario"]==$usuario)
                    {
                      $opciones.="
                      
                      <li><a name='".$resInformacionBasica["id"]."' id='btnEditarCasoSoat'>Editar</a></li>
                      <li class='divider'></li>
                      <li><a name='".$resInformacionBasica["id"]."' id='btnGestionarCasoSoat'>Gestionar</a></li>";
                      }

                }
                else  if ($resTipoUsuario["tipo_usuario"]==2)
                {
                    mysqli_next_result($con);
                    $consultarAutorizacion=mysqli_query($con,"SELECT id, CASE
                    WHEN autorizacion is null then 'NR'
                    ELSE autorizacion end as autorizacion,id,usuario_permiso,fecha_permiso FROM autorizacion_investigacion where id_investigacion='".$resInformacionBasica["id"]."'");
                     $resAutorizacion=mysqli_fetch_array($consultarAutorizacion);
                    if (mysqli_num_rows($consultarAutorizacion)>0 && $resAutorizacion["autorizacion"]=="NR")
                    {
                      $opciones.="<li><a name='".$resInformacionBasica["id"]."' id='btnAutorizarInvestigacionSOAT'>Autorizar Investigacion</a></li>
                      <li class='divider'></li>";
                    }
                    $opciones.="
                    <li><a name='".$resInformacionBasica["id"]."' id='btnEditarCasoSoat'>Editar</a></li>
                      <li class='divider'></li>
                      <li><a name='".$resInformacionBasica["id"]."' id='btnGestionarCasoSoat'>Gestionar</a></li>
                    <li class='divider'></li>
                      <li><a name='".$resInformacionBasica["id"]."' id='btnAsignarAnalistaCasoSoat'>Asignar Analista</a></li>
                      <li class='divider'></li>
                      <li><a name='".$resInformacionBasica["id"]."' id='btnEliminarCasoSoat'>Eliminar</a></li></ul></div>";
                    
                }
                else  if ($resTipoUsuario["tipo_usuario"]==3)
                {
                  mysqli_next_result($con);
                    $consultarAutorizacion=mysqli_query($con,"SELECT id, CASE
                    WHEN autorizacion is null then 'NR'
                    ELSE autorizacion end as autorizacion,id,usuario_permiso,fecha_permiso FROM autorizacion_investigacion where id_investigacion='".$resInformacionBasica["id"]."'");
                     $resAutorizacion=mysqli_fetch_array($consultarAutorizacion);
                    if (mysqli_num_rows($consultarAutorizacion)>0 && $resAutorizacion["autorizacion"]=="NR")
                    {
                      $opciones.="<li><a name='".$resInformacionBasica["id"]."' id='btnAutorizarInvestigacionSOAT'>Autorizar Investigacion</a></li>
                      <li class='divider'></li>";
                    }

                    $opciones.="
                   
                    <li><a name='".$resInformacionBasica["id"]."' id='btnEditarCasoSoat'>Editar</a></li>
                      <li class='divider'></li>
                      <li><a name='".$resInformacionBasica["id"]."' id='btnGestionarCasoSoat'>Gestionar</a></li>
                    <li class='divider'></li>
                      <li><a name='".$resInformacionBasica["id"]."' id='btnAsignarAnalistaCasoSoat'>Asignar Analista</a></li>
                      <li class='divider'></li>
                      <li><a name='".$resInformacionBasica["id"]."' id='btnEliminarCasoSoat'>Eliminar</a></li></ul></div>";

                }
                else if ($resTipoUsuario["tipo_usuario"]==4)
                {
                  $opciones.="
                   
                    <li><a name='".$resInformacionBasica["id"]."' id='btnEditarCasoSoat'>Solicitar Ampliacion</a></li>";


                }
                


                
                    if ($resTipoUsuario["tipo_usuario"]<>4)
                    {

                      $informacionGeneral.="<b>Usuario: </b>".$resInformacionBasica["nombre_usuario"]."<br>";

                    }  
                    $informacionGeneral.="<b>Aseguradora: </b>".$resInformacionBasica["aseguradora"]."<br><b>Tipo de Caso: </b>".$resInformacionBasica["tipo_caso"]."<br><b>Tipo de Solicitud: </b>".$resInformacionBasica["tipo_solicitud"];  
                    
                
               


                   if ($resTipoUsuario["tipo_usuario"]==4)
                   {
                      mysqli_next_result($con);
                      $consultarCasoAsignado=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=13 and descripcion=2 and descripcion2='".$resCasosFiltrosSOAT["tipo_caso"]."'");

                      if ($cantidadInformes>0 || mysqli_num_rows($consultarCasoAsignado)>0)
                      {
                        if (mysqli_num_rows($queryInformacionPersonas)==0)
                        {

                             $data[]=array("GeneralCasosSoat"=>$informacionGeneral,
                              "VictimaCasosSoat"=>"<b>Nombre: </b>NO REGISTRA<br>"."<b>Identificacion: </b>NO REGISTRA<br><b>Reclamante: </b>NO REGISTRA",
                              "SiniestroCasosSoat"=>"<b>Fecha de Accidente: </b>".$resInformacionBasica["fecha_accidente"]."<br>"."<b>Placa Vehiculo: </b>".$resInformacionBasica["placa_vehiculo"]."<br>"."<b>Poliza: </b>".$resInformacionBasica["poliza"],
                              "opciones"=>$opciones); 

                        }
                        else
                        {
                            while ($resInformacionPersona=mysqli_fetch_array($queryInformacionPersonas,MYSQLI_ASSOC)){


                                  $data[]=array("GeneralCasosSoat"=>$informacionGeneral,
                                  "VictimaCasosSoat"=>"<b>Nombre: </b>".$resInformacionPersona["nombre_lesionado"]."<br>"."<b>Identificacion: </b>".$resInformacionPersona["identificacion_lesionado"]."<br><b>Reclamante: </b>".$resInformacionPersona["nombre_reclamante"],
                                  "SiniestroCasosSoat"=>"<b>Fecha de Accidente: </b>".$resInformacionBasica["fecha_accidente"]."<br>"."<b>Placa Vehiculo: </b>".$resInformacionBasica["placa_vehiculo"]."<br>"."<b>Poliza: </b>".$resInformacionBasica["poliza"],
                                  "opciones"=>$opciones); 

                              }
                        }
                      }
                   }
                   else
                   {
                      if (mysqli_num_rows($queryInformacionPersonas)==0)
                      {

                           $data[]=array("GeneralCasosSoat"=>$informacionGeneral,
                            "VictimaCasosSoat"=>"<b>Nombre: </b>NO REGISTRA<br>"."<b>Identificacion: </b>NO REGISTRA<br><b>Reclamante: </b>NO REGISTRA",
                            "SiniestroCasosSoat"=>"<b>Fecha de Accidente: </b>".$resInformacionBasica["fecha_accidente"]."<br>"."<b>Placa Vehiculo: </b>".$resInformacionBasica["placa_vehiculo"]."<br>"."<b>Poliza: </b>".$resInformacionBasica["poliza"],
                            "opciones"=>$opciones); 

                      }
                      else
                      {
                          while ($resInformacionPersona=mysqli_fetch_array($queryInformacionPersonas,MYSQLI_ASSOC)){


                                $data[]=array("GeneralCasosSoat"=>$informacionGeneral,
                                "VictimaCasosSoat"=>"<b>Nombre: </b>".$resInformacionPersona["nombre_lesionado"]."<br>"."<b>Identificacion: </b>".$resInformacionPersona["identificacion_lesionado"]."<br><b>Reclamante: </b>".$resInformacionPersona["nombre_reclamante"],
                                "SiniestroCasosSoat"=>"<b>Fecha de Accidente: </b>".$resInformacionBasica["fecha_accidente"]."<br>"."<b>Placa Vehiculo: </b>".$resInformacionBasica["placa_vehiculo"]."<br>"."<b>Poliza: </b>".$resInformacionBasica["poliza"],
                                "opciones"=>$opciones); 

                            }
                      }
                   } 

                  


                     

              }
              else if (in_array($resCasosFiltrosSOAT["tipo_caso"], $MuerteIncapacidad))
              {
                

                   
                   $consultarInformacionPersonas="SELECT CONCAT(b.nombres,' ',b.apellidos) as nombre_lesionado,concat(c.descripcion,' ',b.identificacion) as identificacion_lesionado
                  FROM personas_investigaciones_soat a
                  left join personas b on b.id=a.id_persona
                  left join definicion_tipos c on c.id=b.tipo_identificacion
                  where a.tipo_persona=1 and c.id_tipo=5 and a.id_investigacion='".$resCasosFiltrosSOAT["id"]."'";

                      mysqli_next_result($con);
                      $queryInformacionPersonas=mysqli_query($con,$consultarInformacionPersonas);
                      $informacionGeneral="";
                       $opciones="";
                     $opciones.="<div class='btn-group'>";
                  
                    $opciones.="<button type='button' class='btn btn-success' name='".$resInformacionBasica["id"]."'>";
                     if ($cantidadInformes>0)
                     {
                      $opciones.="<span class='fa fa-file-pdf-o'></span>";
                     }


                    $opciones.=$resInformacionBasica["codigo"]."</button>
                    <button type='button' class='btn btn-success dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resInformacionBasica["id"]."'>";
                   

                    $opciones.="<span class='caret'></span>
                    <span class='sr-only'>Toggle Dropdown</span>
                    </button>
                    <ul class='dropdown-menu' role='menu'>";
                    if ($cantidadInformes>0)
                     {
                      $opciones.="<li><a target='_blank' href='".$resInforme["ruta"].'?'.time()."'>Ver Informe</a></li><li class='divider'></li>";
                     }
                    


                if ($resTipoUsuario["tipo_usuario"]==1)
                {

                     if ($resInformacionBasica["id_usuario"]==$usuario)
                    {
                      $opciones.="

                      
                      <li><a name='".$resInformacionBasica["id"]."' id='btnEditarCasoSoat'>Editar</a></li>
                      <li class='divider'></li>
                      <li><a name='".$resInformacionBasica["id"]."' id='btnGestionarCasoSoat'>Gestionar</a></li>";
                      }

                }
                else  if ($resTipoUsuario["tipo_usuario"]==2)
                {
                    $opciones.="
                 
                    <li><a name='".$resInformacionBasica["id"]."' id='btnEditarCasoSoat'>Editar</a></li>
                      <li class='divider'></li>
                      <li><a name='".$resInformacionBasica["id"]."' id='btnGestionarCasoSoat'>Gestionar</a></li>
                    <li class='divider'></li>
                      <li><a name='".$resInformacionBasica["id"]."' id='btnAsignarAnalistaCasoSoat'>Asignar Analista</a></li>
                      <li class='divider'></li>
                      <li><a name='".$resInformacionBasica["id"]."' id='btnEliminarCasoSoat'>Eliminar</a></li></ul></div>";
                    
                }
                else  if ($resTipoUsuario["tipo_usuario"]==3)
                {

                    $opciones.="
                   
                    <li><a name='".$resInformacionBasica["id"]."' id='btnEditarCasoSoat'>Editar</a></li>
                      <li class='divider'></li>
                      <li><a name='".$resInformacionBasica["id"]."' id='btnGestionarCasoSoat'>Gestionar</a></li>
                    <li class='divider'></li>
                      <li><a name='".$resInformacionBasica["id"]."' id='btnAsignarAnalistaCasoSoat'>Asignar Analista</a></li>
                      <li class='divider'></li>
                      <li><a name='".$resInformacionBasica["id"]."' id='btnEliminarCasoSoat'>Eliminar</a></li></ul></div>";

                }
                else  if ($resTipoUsuario["tipo_usuario"]==4)
                {
                  $opciones.="
                   
                    <li><a name='".$resInformacionBasica["id"]."' id='btnEditarCasoSoat'>Solicitar Ampliacion</a></li>";


                }
                


                
                    if ($resTipoUsuario["tipo_usuario"]<>4)
                    {

                      $informacionGeneral.="<b>Usuario: </b>".$resInformacionBasica["nombre_usuario"]."<br>";

                    }  
                    $informacionGeneral.="<b>Aseguradora: </b>".$resInformacionBasica["aseguradora"]."<br><b>Tipo de Caso: </b>".$resInformacionBasica["tipo_caso"]."<br><b>Tipo de Solicitud: </b>".$resInformacionBasica["tipo_solicitud"];  



                      if ($resTipoUsuario["tipo_usuario"]==4)
                      {
                          mysqli_next_result($con);
                          $consultarCasoAsignado=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=13 and descripcion=2 and descripcion2='".$resCasosFiltrosSOAT["tipo_caso"]."'");

                         if ($cantidadInformes>0 || mysqli_num_rows($consultarCasoAsignado)>0)
                         {
                            if (mysqli_num_rows($queryInformacionPersonas)==0)
                            {

                                 $data[]=array("GeneralCasosSoat"=>$informacionGeneral,
                                  "VictimaCasosSoat"=>"<b>Nombre: </b>NO REGISTRA<br>"."<b>Identificacion: </b>NO REGISTRA<br><b>Reclamante: </b>NO REGISTRA",
                                  "SiniestroCasosSoat"=>"<b>Fecha de Accidente: </b>".$resInformacionBasica["fecha_accidente"]."<br>"."<b>Placa Vehiculo: </b>".$resInformacionBasica["placa_vehiculo"]."<br>"."<b>Poliza: </b>".$resInformacionBasica["poliza"],
                                  "opciones"=>$opciones); 

                            }
                            else
                            {

                               $consultarReclamante="SELECT CONCAT(b.nombres,' ',b.apellidos) as nombre_lesionado,concat(c.descripcion2,' ',b.identificacion) as identificacion_lesionado
                            FROM personas_investigaciones_soat a
                            left join personas b on b.id=a.id_persona
                            left join definicion_tipos c on c.id=b.tipo_identificacion
                            where a.tipo_persona=3 and c.id_tipo=5 and a.id_investigacion='".$resCasosFiltrosSOAT["id"]."'";

                              mysqli_next_result($con);
                            $queryReclamante=mysqli_query($con,$consultarReclamante);
                            if (mysqli_num_rows($queryReclamante)>0){
                              $nombreReclamante="NO REGISTRA";

                            }else{
                              $resReclamante=mysqli_fetch_array($queryReclamante,MYSQLI_ASSOC);  
                              $nombreReclamante=$resReclamante["nombre_lesionado"];
                            }
                            

                                while ($resInformacionPersona=mysqli_fetch_array($queryInformacionPersonas,MYSQLI_ASSOC))
                                {


                                      $data[]=array("GeneralCasosSoat"=>$informacionGeneral,
                                      "VictimaCasosSoat"=>"<b>Nombre: </b>".$resInformacionPersona["nombre_lesionado"]."<br>"."<b>Identificacion: </b>".$resInformacionPersona["identificacion_lesionado"]."<br><b>Reclamante: </b>".$nombreReclamante,
                                      "SiniestroCasosSoat"=>"<b>Fecha de Accidente: </b>".$resInformacionBasica["fecha_accidente"]."<br>"."<b>Placa Vehiculo: </b>".$resInformacionBasica["placa_vehiculo"]."<br>"."<b>Poliza: </b>".$resInformacionBasica["poliza"],
                                      "opciones"=>$opciones); 

                                  }
                            }
                         }
                      }
                      else
                      {
                        if (mysqli_num_rows($queryInformacionPersonas)==0)
                        {

                             $data[]=array("GeneralCasosSoat"=>$informacionGeneral,
                              "VictimaCasosSoat"=>"<b>Nombre: </b>NO REGISTRA<br>"."<b>Identificacion: </b>NO REGISTRA<br><b>Reclamante: </b>NO REGISTRA",
                              "SiniestroCasosSoat"=>"<b>Fecha de Accidente: </b>".$resInformacionBasica["fecha_accidente"]."<br>"."<b>Placa Vehiculo: </b>".$resInformacionBasica["placa_vehiculo"]."<br>"."<b>Poliza: </b>".$resInformacionBasica["poliza"],
                              "opciones"=>$opciones); 

                        }
                        else
                        {

                           $consultarReclamante="SELECT CONCAT(b.nombres,' ',b.apellidos) as nombre_lesionado,concat(c.descripcion2,' ',b.identificacion) as identificacion_lesionado
                        FROM personas_investigaciones_soat a
                        left join personas b on b.id=a.id_persona
                        left join definicion_tipos c on c.id=b.tipo_identificacion
                        where a.tipo_persona=3 and c.id_tipo=5 and a.id_investigacion='".$resCasosFiltrosSOAT["id"]."'";

                          mysqli_next_result($con);
                        $queryReclamante=mysqli_query($con,$consultarReclamante);
                        if (mysqli_num_rows($queryReclamante)>0){
                          $nombreReclamante="NO REGISTRA";

                        }else{
                          $resReclamante=mysqli_fetch_array($queryReclamante,MYSQLI_ASSOC);  
                          $nombreReclamante=$resReclamante["nombre_lesionado"];
                        }
                        

                            while ($resInformacionPersona=mysqli_fetch_array($queryInformacionPersonas,MYSQLI_ASSOC))
                            {


                                  $data[]=array("GeneralCasosSoat"=>$informacionGeneral,
                                  "VictimaCasosSoat"=>"<b>Nombre: </b>".$resInformacionPersona["nombre_lesionado"]."<br>"."<b>Identificacion: </b>".$resInformacionPersona["identificacion_lesionado"]."<br><b>Reclamante: </b>".$nombreReclamante,
                                  "SiniestroCasosSoat"=>"<b>Fecha de Accidente: </b>".$resInformacionBasica["fecha_accidente"]."<br>"."<b>Placa Vehiculo: </b>".$resInformacionBasica["placa_vehiculo"]."<br>"."<b>Poliza: </b>".$resInformacionBasica["poliza"],
                                  "opciones"=>$opciones); 

                              }
                        }
                      }
                  
                      
                   
                  



                    

              }
           

               
        


             
            
        }

      



          

     
       $results = array(
      "sEcho" => 1,
      "iTotalRecords" => count($data),
      "iTotalDisplayRecords" => count($data),
      "aaData" => $data
      );
      return json_encode($results);

}







?>