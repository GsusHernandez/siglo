<?php
include('../conexion/conexion.php');

include "class.phpmailer.php";
include "class.smtp.php";

function emailAsignacionAmpliacionInvestigador($idInvestigacion)
{

	global $con;
	$data=array();
	mysqli_next_result($con);
	$queryInformacionAsignacion=mysqli_query($con,"SELECT j.nombres as nombre_lesionado,h.motivo_investigacion,CONCAT(g.nombres,' ',g.apellidos) AS nombre_investigador,CONCAT(e.nombres,' ',e.apellidos) AS nombre_usuario,g.correo as correo_investigador,b.nombre_aseguradora AS aseguradora,a.tipo_caso,c.descripcion AS desc_tipo_caso,a.codigo,a.id,DATE_ADD(a.fecha_inicio,INTERVAL -1 DAY) AS fecha_entrega,CURDATE() as fecha_asignacion_investigador
		FROM investigaciones a
		LEFT JOIN aseguradoras b ON a.id_aseguradora=b.id
		LEFT JOIN definicion_tipos c ON c.id=a.tipo_caso
		LEFT JOIN estado_investigaciones d ON d.id_investigacion=a.id
		LEFT JOIN usuarios e ON e.id=d.usuario
		LEFT JOIN investigadores g ON g.id=a.id_investigador
		LEFT JOIN detalle_investigaciones_soat h ON h.id_investigacion=a.id
		LEFT JOIN personas_investigaciones_soat i ON i.id_investigacion=a.id
		LEFT JOIN personas j ON j.id=i.id_persona
		WHERE d.estado=20 AND c.id_tipo=8 AND a.id='".$idInvestigacion."'");

		$resInformacionAsignacion=mysqli_fetch_assoc($queryInformacionAsignacion);
		
	


$tituloEmail="ASIGNACION DE AMPLIACION. CASO: ".$resInformacionAsignacion["codigo"];
$asuntoMensaje=$tituloEmail;

$correoEnviarA=$resInformacionAsignacion["correo_investigador"];

$enlaceSoporte='<table style="background-color: #D8D8D8; margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 100%;" cellspacing="0" cellpadding="0" border="0" bgcolor="#D8D8D8" width="100%">
			    <tr>
			      <td align="center" valign="top">
			        <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 800px;" width="800" cellspacing="0" cellpadding="0" border="0">
			          <tr>
			            <td style="background-color: #09358e;" align="center" valign="top" bgcolor="#09358e">
			              <!--[if gte mso 9]>
			                  <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:800px;">
			                  <v:fill type="frame" src="" color="#09358e" />
			                  <v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0">
			                  <![endif]-->
			              <table class="p90" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 600px;" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
			                <tr>
			                  <td style="font-size: 1px; height: 20px; line-height: 20px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
			                </tr>
			               
			                <tr>
			                  <td valign="top" align="left">
			                    <!--[if gte mso 9]>
			                        <table align="left" border="0" cellpadding="0" cellspacing="0" width="600">
			                        <tr>
			                        <td align="left" valign="top" width="45">
			                        <![endif]-->
			                   
			                    <!--[if gte mso 9]>
			                        </td>
			                        <td align="left" valign="top" width="25">
			                        <![endif]-->
			                    <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 25px;" width="25" cellspacing="0" cellpadding="0" border="0" align="left">
			                      <tr>
			                        <td valign="top" align="left" style="font-size: 1px;">&nbsp;</td>
			                      </tr>
			                    </table>
			                    <!--[if gte mso 9]>
			                        </td>
			                        <td align="left" valign="top" width="380">
			                        <![endif]-->
			                    <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 380px;" width="380" cellspacing="0" cellpadding="0" border="0" align="left">
			                      <tr>
			                        <td align="center" valign="top">
			                          <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 380px;" width="380" cellspacing="0" cellpadding="0" border="0" align="center">
			                            <tr>
			                              <td valign="middle" class="text center" style="color: #ffffff; font-family: Open Sans, sans-serif; font-size: 15px; text-align: left; mso-line-height-rule: exactly;" align="center">
			                                <!--===================================================-->
			                                <!--|                      TEXT                      |-->
			                                <!--===================================================-->
			                                <font face="Open Sans, sans-serif">POR MEDIO DEL SIGUIENTE ENLACE PODRA DESCARGAR EL SOPORTE DE ESTA AMPLIACION</font>
			                              </td>
			                            </tr>
			                            <tr>
			                              <td style="font-size: 1px; height: 5px; line-height: 5px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
			                            </tr>
			                          </table>
			                        </td>
			                      </tr>					
			                    </table>
			                    <!--[if gte mso 9]>
			                        </td>
			                        <td align="left" valign="top" width="150">
			                        <![endif]-->
			                    <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 136px;" width="136" cellspacing="0" cellpadding="0" border="0" align="right">
			                      <tr>
			                        <td style="font-size: 1px; height: 5px; line-height: 5px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
			                      </tr>
			                      <tr>
			                        <td align="center" valign="top">
			                          <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0;" cellspacing="0" cellpadding="0" border="0" align="center">
			                            <tr>
			                              <td align="center" valign="top">
			                                <!--===================================================-->
			                                <!--|                     BUTTON                     |-->
			                                <!--===================================================-->
			                                <table style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 100%;" cellspacing="0" cellpadding="0" border="0" width="100%">
			                                  <tr>';
			                                  mysqli_next_result($con);
			                                  $consultarSoportesAmpliacion="SELECT * FROM multimedia_investigacion where id_investigacion='".$idInvestigacion."' and id_multimedia=10";
			                                  $querySoporteAmpliacion=mysqli_query($con,$consultarSoportesAmpliacion);
			                                  while ($resSoporteAmplaicion=mysqli_fetch_assoc($querySoporteAmpliacion))
			                                  {
			                                  	$enlaceSoporte.='<td align="center" valign="top">
			                                      <table align="center" style="-moz-border-radius: 30px; -webkit-border-radius: 30px; background-color: transparent; border: 2px solid #ffffff; border-collapse: separate !important; border-radius: 30px; color: #979797; font-family: Open Sans, sans-serif; font-size: 13px; margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0;"
			                                      cellspacing="0" cellpadding="0" border="0" bgcolor="transparent">
			                                        <tr>
			                                          <td style="-moz-border-radius: 30px; -webkit-border-radius: 30px; border-radius: 30px; color: #B5B5B5; font-family: Open Sans, sans-serif; font-weight: 400; line-height: 100%; mso-line-height-rule: exactly; padding: 9px 20px; vertical-align: middle;"
			                                          align="center" valign="top">
			                                            <!--===================================================-->
			                                            <!--|                      LINK                      |-->
			                                            <!--===================================================-->
			                                            <a href="'.$resSoporteAmplaicion["ruta"].'?'.time().'" target="_blank" style="border: none; color: #ffffff; display: block; font-family: Open Sans, sans-serif; font-size: inherit; font-weight: 700; outline: none; text-decoration: none;">DESCARGAR</a>
			                                          </td>
			                                        </tr>
			                                      </table>
			                                    </td>';
			                                  }
			                                    
			                                     $enlaceSoporte.='
			                                  </tr>
			                                </table>
			                                <!--===================================================-->
			                                <!--|                  BUTTON - END                  |-->
			                                <!--===================================================-->
			                              </td>
			                            </tr>
			                          </table>
			                        </td>
			                      </tr>
			                    </table>
			                    <!--[if gte mso 9]>
			                        </td>
			                        </tr>
			                        </table>
			                        <![endif]-->
			                  </td>
			                </tr>
			                <tr>
			                  <td style="font-size: 1px; height: 20px; line-height: 20px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
			                </tr>
			               
			              </table>
			              <!--[if gte mso 9]>
			                  </v:textbox>
			                  </v:fill>
			                  </v:rect>
			                  <![endif]-->
			            </td>
			          </tr>
			        </table>
			      </td>
			    </tr>
			  </table>';

$data["cantidad_soporte"]=1;
$data["enlace_soporte"]=$enlaceSoporte;
$cuerpoMensaje='<tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #09358e; font-family: Open Sans, sans-serif;">ASEGURADORA</span><span style="font-family: Open Sans, sans-serif;">:&#xA0;</span><span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;">'.$resInformacionAsignacion["aseguradora"].'</span>
                              </td>
                            </tr>
                            <tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #09358e; font-family: Open Sans, sans-serif;">SOLICITADO POR</span><span style="font-family: Open Sans, sans-serif;">:&#xA0;</span><span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;">'.$resInformacionAsignacion["nombre_usuario"].'</span>
                              </td>
                            </tr>
                             <tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #09358e; font-family: Open Sans, sans-serif;">CODIGO</span><span style="font-family: Open Sans, sans-serif;">:&#xA0;</span><span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;">'.$resInformacionAsignacion["codigo"].'</span>
                              </td>
                            </tr>
                             <tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #09358e; font-family: Open Sans, sans-serif;">TIPO DE CASO</span><span style="font-family: Open Sans, sans-serif;">:&#xA0;</span><span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;">'.$resInformacionAsignacion["desc_tipo_caso"].'</span>
                              </td>
                            </tr>
                             <tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #09358e; font-family: Open Sans, sans-serif;">NOMBRE DE LESIONADO</span><span style="font-family: Open Sans, sans-serif;">:&#xA0;</span><span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;">'.$resInformacionAsignacion["nombre_lesionado"].'</span>
                              </td>
                            </tr>
                             <tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #09358e; font-family: Open Sans, sans-serif;">INVESTIGADOR ASIGNADO</span><span style="font-family: Open Sans, sans-serif;">:&#xA0;</span><span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;">'.$resInformacionAsignacion["nombre_investigador"].'</span>
                              </td>
                            </tr>
                             <tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #09358e; font-family: Open Sans, sans-serif;">FECHA DE ASIGNACION</span><span style="font-family: Open Sans, sans-serif;">:&#xA0;</span><span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;">'.$resInformacionAsignacion["fecha_asignacion_investigador"].'</span>
                              </td>
                            </tr>
                             <tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #09358e; font-family: Open Sans, sans-serif;">FECHA DE ENTREGA</span><span style="font-family: Open Sans, sans-serif;">:&#xA0;</span><span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;">'.$resInformacionAsignacion["fecha_entrega"].'</span>
                              </td>
                            </tr>


                            <tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #09358e; font-family: Open Sans, sans-serif;">MOTIVO</span><span style="font-family: Open Sans, sans-serif;">:&#xA0;</span><span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;">'.$resInformacionAsignacion["motivo_investigacion"].'</span>
                              </td>
                            </tr>
                            <br>
                                 <tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #09358e; font-family: Open Sans, sans-serif;">POR ORDEN DE LA COMPAÑÍA CASO QUE NO SEA ENTREGADO EN LA FECHA ESTABLECIDA NO SERA CANCELADO Y NOTIFICAR CON ANTICIPACIÓN CUALQUIER NOVEDAD DEBIDO A QUE NO SE ESTÁN OTORGANDO AMPLIACIONES.</span>
                              </td>
                            </tr>
                         	<br>
                         	<tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;"><b>NOTA: </b>ENVIAR ANEXOS CORRESPONDIENTE A ESTA INVESTIGACION SOBRE EL MISMO CORREO</span>
                              </td>
                            </tr>
                            <br><br><br>
                         	<tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;">Atentamente,</span>
                              </td>
                            </tr>
                            <br><br>
                         	<tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;">JOSE M QUIJANO RODRIGUEZ</span>
                              </td>
                            </tr>
                            <tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;"><b>GERENTE</b></span>
                              </td>
                            </tr>
                           ';


$data["titulo_mensaje"]=$tituloEmail;
$data["asunto_mensaje"]=$asuntoMensaje;
$data["enviar_a"]=$correoEnviarA;
$data["cuerpo_mensaje"]=$cuerpoMensaje;


return $data;

}

function emailAsignacionInvestigador($idInvestigacion)
{

	global $con;
	$data=array();
	mysqli_next_result($con);
	$queryInformacionAsignacion=mysqli_query($con,"SELECT j.nombres as nombre_lesionado,h.motivo_investigacion,CONCAT(g.nombres,' ',g.apellidos) AS nombre_investigador,f.ruta,CONCAT(e.nombres,' ',e.apellidos) AS nombre_usuario,g.correo as correo_investigador,b.nombre_aseguradora AS aseguradora,a.tipo_caso,c.descripcion AS desc_tipo_caso,a.codigo,a.id,DATE_ADD(a.fecha_inicio,INTERVAL -1 DAY) AS fecha_entrega,CURDATE() as fecha_asignacion_investigador
		FROM investigaciones a
		LEFT JOIN aseguradoras b ON a.id_aseguradora=b.id
		LEFT JOIN definicion_tipos c ON c.id=a.tipo_caso
		LEFT JOIN estado_investigaciones d ON d.id_investigacion=a.id
		LEFT JOIN usuarios e ON e.id=d.usuario
		LEFT JOIN multimedia_investigacion f ON f.id_investigacion=a.id
		LEFT JOIN investigadores g ON g.id=a.id_investigador
		LEFT JOIN detalle_investigaciones_soat h ON h.id_investigacion=a.id
		LEFT JOIN personas_investigaciones_soat i ON i.id_investigacion=a.id
		LEFT JOIN personas j ON j.id=i.id_persona
		WHERE d.estado=2 AND c.id_tipo=8 AND a.id='".$idInvestigacion."' AND f.id_multimedia=10");

		$resInformacionAsignacion=mysqli_fetch_assoc($queryInformacionAsignacion);
		
	


$tituloEmail="ASIGNACION DE INVESTIGACION. CASO: ".$resInformacionAsignacion["codigo"];
$asuntoMensaje=$tituloEmail;

$correoEnviarA=$resInformacionAsignacion["correo_investigador"];

$enlaceSoporte='<table style="background-color: #D8D8D8; margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 100%;" cellspacing="0" cellpadding="0" border="0" bgcolor="#D8D8D8" width="100%">
			    <tr>
			      <td align="center" valign="top">
			        <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 800px;" width="800" cellspacing="0" cellpadding="0" border="0">
			          <tr>
			            <td style="background-color: #09358e;" align="center" valign="top" bgcolor="#09358e">
			              <!--[if gte mso 9]>
			                  <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:800px;">
			                  <v:fill type="frame" src="" color="#09358e" />
			                  <v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0">
			                  <![endif]-->
			              <table class="p90" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 600px;" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
			                <tr>
			                  <td style="font-size: 1px; height: 20px; line-height: 20px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
			                </tr>
			               
			                <tr>
			                  <td valign="top" align="left">
			                    <!--[if gte mso 9]>
			                        <table align="left" border="0" cellpadding="0" cellspacing="0" width="600">
			                        <tr>
			                        <td align="left" valign="top" width="45">
			                        <![endif]-->
			                   
			                    <!--[if gte mso 9]>
			                        </td>
			                        <td align="left" valign="top" width="25">
			                        <![endif]-->
			                    <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 25px;" width="25" cellspacing="0" cellpadding="0" border="0" align="left">
			                      <tr>
			                        <td valign="top" align="left" style="font-size: 1px;">&nbsp;</td>
			                      </tr>
			                    </table>
			                    <!--[if gte mso 9]>
			                        </td>
			                        <td align="left" valign="top" width="380">
			                        <![endif]-->
			                    <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 380px;" width="380" cellspacing="0" cellpadding="0" border="0" align="left">
			                      <tr>
			                        <td align="center" valign="top">
			                          <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 380px;" width="380" cellspacing="0" cellpadding="0" border="0" align="center">
			                            <tr>
			                              <td valign="middle" class="text center" style="color: #ffffff; font-family: Open Sans, sans-serif; font-size: 15px; text-align: left; mso-line-height-rule: exactly;" align="center">
			                                <!--===================================================-->
			                                <!--|                      TEXT                      |-->
			                                <!--===================================================-->
			                                <font face="Open Sans, sans-serif">POR MEDIO DEL SIGUIENTE ENLACE PODRA DESCARGAR EL SOPORTE DE ESTA INVESTIGACION</font>
			                              </td>
			                            </tr>
			                            <tr>
			                              <td style="font-size: 1px; height: 5px; line-height: 5px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
			                            </tr>
			                          </table>
			                        </td>
			                      </tr>					
			                    </table>
			                    <!--[if gte mso 9]>
			                        </td>
			                        <td align="left" valign="top" width="150">
			                        <![endif]-->
			                    <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 136px;" width="136" cellspacing="0" cellpadding="0" border="0" align="right">
			                      <tr>
			                        <td style="font-size: 1px; height: 5px; line-height: 5px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
			                      </tr>
			                      <tr>
			                        <td align="center" valign="top">
			                          <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0;" cellspacing="0" cellpadding="0" border="0" align="center">
			                            <tr>
			                              <td align="center" valign="top">
			                                <!--===================================================-->
			                                <!--|                     BUTTON                     |-->
			                                <!--===================================================-->
			                                <table style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 100%;" cellspacing="0" cellpadding="0" border="0" width="100%">
			                                  <tr>
			                                    <td align="center" valign="top">
			                                      <table align="center" style="-moz-border-radius: 30px; -webkit-border-radius: 30px; background-color: transparent; border: 2px solid #ffffff; border-collapse: separate !important; border-radius: 30px; color: #979797; font-family: Open Sans, sans-serif; font-size: 13px; margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0;"
			                                      cellspacing="0" cellpadding="0" border="0" bgcolor="transparent">
			                                        <tr>
			                                          <td style="-moz-border-radius: 30px; -webkit-border-radius: 30px; border-radius: 30px; color: #B5B5B5; font-family: Open Sans, sans-serif; font-weight: 400; line-height: 100%; mso-line-height-rule: exactly; padding: 9px 20px; vertical-align: middle;"
			                                          align="center" valign="top">
			                                            <!--===================================================-->
			                                            <!--|                      LINK                      |-->
			                                            <!--===================================================-->
			                                            <a href="'.$resInformacionAsignacion["ruta"].'?'.time().'" target="_blank" style="border: none; color: #ffffff; display: block; font-family: Open Sans, sans-serif; font-size: inherit; font-weight: 700; outline: none; text-decoration: none;">DESCARGAR</a>
			                                          </td>
			                                        </tr>
			                                      </table>
			                                    </td>
			                                  </tr>
			                                </table>
			                                <!--===================================================-->
			                                <!--|                  BUTTON - END                  |-->
			                                <!--===================================================-->
			                              </td>
			                            </tr>
			                          </table>
			                        </td>
			                      </tr>
			                    </table>
			                    <!--[if gte mso 9]>
			                        </td>
			                        </tr>
			                        </table>
			                        <![endif]-->
			                  </td>
			                </tr>
			                <tr>
			                  <td style="font-size: 1px; height: 20px; line-height: 20px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
			                </tr>
			               
			              </table>
			              <!--[if gte mso 9]>
			                  </v:textbox>
			                  </v:fill>
			                  </v:rect>
			                  <![endif]-->
			            </td>
			          </tr>
			        </table>
			      </td>
			    </tr>
			  </table>';

$data["cantidad_soporte"]=1;
$data["enlace_soporte"]=$enlaceSoporte;
$cuerpoMensaje='<tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #09358e; font-family: Open Sans, sans-serif;">ASEGURADORA</span><span style="font-family: Open Sans, sans-serif;">:&#xA0;</span><span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;">'.$resInformacionAsignacion["aseguradora"].'</span>
                              </td>
                            </tr>
                            <tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #09358e; font-family: Open Sans, sans-serif;">SOLICITADO POR</span><span style="font-family: Open Sans, sans-serif;">:&#xA0;</span><span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;">'.$resInformacionAsignacion["nombre_usuario"].'</span>
                              </td>
                            </tr>
                             <tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #09358e; font-family: Open Sans, sans-serif;">CODIGO</span><span style="font-family: Open Sans, sans-serif;">:&#xA0;</span><span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;">'.$resInformacionAsignacion["codigo"].'</span>
                              </td>
                            </tr>
                             <tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #09358e; font-family: Open Sans, sans-serif;">TIPO DE CASO</span><span style="font-family: Open Sans, sans-serif;">:&#xA0;</span><span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;">'.$resInformacionAsignacion["desc_tipo_caso"].'</span>
                              </td>
                            </tr>
                             <tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #09358e; font-family: Open Sans, sans-serif;">NOMBRE DE LESIONADO</span><span style="font-family: Open Sans, sans-serif;">:&#xA0;</span><span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;">'.$resInformacionAsignacion["nombre_lesionado"].'</span>
                              </td>
                            </tr>
                             <tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #09358e; font-family: Open Sans, sans-serif;">INVESTIGADOR ASIGNADO</span><span style="font-family: Open Sans, sans-serif;">:&#xA0;</span><span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;">'.$resInformacionAsignacion["nombre_investigador"].'</span>
                              </td>
                            </tr>
                             <tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #09358e; font-family: Open Sans, sans-serif;">FECHA DE ASIGNACION</span><span style="font-family: Open Sans, sans-serif;">:&#xA0;</span><span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;">'.$resInformacionAsignacion["fecha_asignacion_investigador"].'</span>
                              </td>
                            </tr>
                             <tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #09358e; font-family: Open Sans, sans-serif;">FECHA DE ENTREGA</span><span style="font-family: Open Sans, sans-serif;">:&#xA0;</span><span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;">'.$resInformacionAsignacion["fecha_entrega"].'</span>
                              </td>
                            </tr>


                            <tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #09358e; font-family: Open Sans, sans-serif;">MOTIVO</span><span style="font-family: Open Sans, sans-serif;">:&#xA0;</span><span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;">'.$resInformacionAsignacion["motivo_investigacion"].'</span>
                              </td>
                            </tr>
                            <br>
                                 <tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #09358e; font-family: Open Sans, sans-serif;">POR ORDEN DE LA COMPAÑÍA CASO QUE NO SEA ENTREGADO EN LA FECHA ESTABLECIDA NO SERA CANCELADO Y NOTIFICAR CON ANTICIPACIÓN CUALQUIER NOVEDAD DEBIDO A QUE NO SE ESTÁN OTORGANDO AMPLIACIONES.</span>
                              </td>
                            </tr>
                         	<br>
                         	<tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;"><b>NOTA: </b>ENVIAR ANEXOS CORRESPONDIENTE A ESTA INVESTIGACION SOBRE EL MISMO CORREO</span>
                              </td>
                            </tr>
                            <br><br><br>
                         	<tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;">Atentamente,</span>
                              </td>
                            </tr>
                            <br><br>
                         	<tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;">JOSE M QUIJANO RODRIGUEZ</span>
                              </td>
                            </tr>
                            <tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;"><b>GERENTE</b></span>
                              </td>
                            </tr>
                           ';


$data["titulo_mensaje"]=$tituloEmail;
$data["asunto_mensaje"]=$asuntoMensaje;
$data["enviar_a"]=$correoEnviarA;
$data["cuerpo_mensaje"]=$cuerpoMensaje;


return $data;

}


function emailRespuestaAsignacionAseguradora($idInvestigacion){

	global $con;
	$data=array();
	mysqli_next_result($con);
	$queryInformacionAsignacion=mysqli_query($con,"SELECT f.ruta,CONCAT(e.nombres,' ',e.apellidos) AS nombre_usuario,e.correo,b.nombre_aseguradora AS aseguradora,a.tipo_caso,c.`descripcion` AS desc_tipo_caso,a.`codigo`,a.id,a.fecha_entrega
		FROM investigaciones a
		LEFT JOIN aseguradoras b ON a.id_aseguradora=b.id
		LEFT JOIN definicion_tipos c ON c.id=a.tipo_caso
		LEFT JOIN estado_investigaciones d ON d.id_investigacion=a.id
		LEFT JOIN usuarios e ON e.id=d.usuario
		LEFT JOIN multimedia_investigacion f ON f.id_investigacion=a.id
		WHERE d.estado=1 AND c.id_tipo=8 AND a.id='".$idInvestigacion."' and f.id_multimedia=9");

		$resInformacionAsignacion=mysqli_fetch_assoc($queryInformacionAsignacion);
		$data["tipo_caso"]=$resInformacionAsignacion["tipo_caso"];
		
	


$tituloEmail="RESULTADO DE ASIGNACION DE INVESTIGACION. CASO: ".$resInformacionAsignacion["codigo"];
$asuntoMensaje=$tituloEmail;

$correoEnviarA=$resInformacionAsignacion["correo"];

$data["cantidad_informe_final"]="1";
$enlaceInformeFinal='<table style="background-color: #D8D8D8; margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 100%;" cellspacing="0" cellpadding="0" border="0" bgcolor="#D8D8D8" width="100%">
			    <tr>
			      <td align="center" valign="top">
			        <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 800px;" width="800" cellspacing="0" cellpadding="0" border="0">
			          <tr>
			            <td style="background-color: #09358e;" align="center" valign="top" bgcolor="#09358e">
			              <!--[if gte mso 9]>
			                  <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:800px;">
			                  <v:fill type="frame" src="" color="#09358e" />
			                  <v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0">
			                  <![endif]-->
			              <table class="p90" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 600px;" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
			                <tr>
			                  <td style="font-size: 1px; height: 20px; line-height: 20px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
			                </tr>
			               
			                <tr>
			                  <td valign="top" align="left">
			                    <!--[if gte mso 9]>
			                        <table align="left" border="0" cellpadding="0" cellspacing="0" width="600">
			                        <tr>
			                        <td align="left" valign="top" width="45">
			                        <![endif]-->
			                   
			                    <!--[if gte mso 9]>
			                        </td>
			                        <td align="left" valign="top" width="25">
			                        <![endif]-->
			                    <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 25px;" width="25" cellspacing="0" cellpadding="0" border="0" align="left">
			                      <tr>
			                        <td valign="top" align="left" style="font-size: 1px;">&nbsp;</td>
			                      </tr>
			                    </table>
			                    <!--[if gte mso 9]>
			                        </td>
			                        <td align="left" valign="top" width="380">
			                        <![endif]-->
			                    <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 380px;" width="380" cellspacing="0" cellpadding="0" border="0" align="left">
			                      <tr>
			                        <td align="center" valign="top">
			                          <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 380px;" width="380" cellspacing="0" cellpadding="0" border="0" align="center">
			                            <tr>
			                              <td valign="middle" class="text center" style="color: #ffffff; font-family: Open Sans, sans-serif; font-size: 15px; text-align: left; mso-line-height-rule: exactly;" align="center">
			                                <!--===================================================-->
			                                <!--|                      TEXT                      |-->
			                                <!--===================================================-->
			                                <font face="Open Sans, sans-serif">POR MEDIO DEL SIGUIENTE ENLACE PODRA DESCARGAR EL INFORME FINAL DE LA INVESTIGACION</font>
			                              </td>
			                            </tr>
			                            <tr>
			                              <td style="font-size: 1px; height: 5px; line-height: 5px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
			                            </tr>
			                          </table>
			                        </td>
			                      </tr>					
			                    </table>
			                    <!--[if gte mso 9]>
			                        </td>
			                        <td align="left" valign="top" width="150">
			                        <![endif]-->
			                    <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 136px;" width="136" cellspacing="0" cellpadding="0" border="0" align="right">
			                      <tr>
			                        <td style="font-size: 1px; height: 5px; line-height: 5px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
			                      </tr>
			                      <tr>
			                        <td align="center" valign="top">
			                          <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0;" cellspacing="0" cellpadding="0" border="0" align="center">
			                            <tr>
			                              <td align="center" valign="top">
			                                <!--===================================================-->
			                                <!--|                     BUTTON                     |-->
			                                <!--===================================================-->
			                                <table style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 100%;" cellspacing="0" cellpadding="0" border="0" width="100%">
			                                  <tr>
			                                    <td align="center" valign="top">
			                                      <table align="center" style="-moz-border-radius: 30px; -webkit-border-radius: 30px; background-color: transparent; border: 2px solid #ffffff; border-collapse: separate !important; border-radius: 30px; color: #979797; font-family: Open Sans, sans-serif; font-size: 13px; margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0;"
			                                      cellspacing="0" cellpadding="0" border="0" bgcolor="transparent">
			                                        <tr>
			                                          <td style="-moz-border-radius: 30px; -webkit-border-radius: 30px; border-radius: 30px; color: #B5B5B5; font-family: Open Sans, sans-serif; font-weight: 400; line-height: 100%; mso-line-height-rule: exactly; padding: 9px 20px; vertical-align: middle;"
			                                          align="center" valign="top">
			                                            <!--===================================================-->
			                                            <!--|                      LINK                      |-->
			                                            <!--===================================================-->
			                                            <a href="'.$resInformacionAsignacion["ruta"].'?'.time().'" target="_blank" style="border: none; color: #ffffff; display: block; font-family: Open Sans, sans-serif; font-size: inherit; font-weight: 700; outline: none; text-decoration: none;">DESCARGAR</a>
			                                          </td>
			                                        </tr>
			                                      </table>
			                                    </td>
			                                  </tr>
			                                </table>
			                                <!--===================================================-->
			                                <!--|                  BUTTON - END                  |-->
			                                <!--===================================================-->
			                              </td>
			                            </tr>
			                          </table>
			                        </td>
			                      </tr>
			                    </table>
			                    <!--[if gte mso 9]>
			                        </td>
			                        </tr>
			                        </table>
			                        <![endif]-->
			                  </td>
			                </tr>
			                <tr>
			                  <td style="font-size: 1px; height: 20px; line-height: 20px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
			                </tr>
			               
			              </table>
			              <!--[if gte mso 9]>
			                  </v:textbox>
			                  </v:fill>
			                  </v:rect>
			                  <![endif]-->
			            </td>
			          </tr>
			        </table>
			      </td>
			    </tr>
			  </table>';

$data["enlace_informe_final"]=$enlaceInformeFinal;
$cuerpoMensaje='<tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #09358e; font-family: Open Sans, sans-serif;">ASEGURADORA</span><span style="font-family: Open Sans, sans-serif;">:&#xA0;</span><span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;">'.$resInformacionAsignacion["aseguradora"].'</span>
                              </td>
                            </tr>
                            <tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #09358e; font-family: Open Sans, sans-serif;">SOLICITADO POR</span><span style="font-family: Open Sans, sans-serif;">:&#xA0;</span><span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;">'.$resInformacionAsignacion["nombre_usuario"].'</span>
                              </td>
                            </tr>
                         
                           ';


$data["titulo_mensaje"]=$tituloEmail;
$data["asunto_mensaje"]=$asuntoMensaje;
$data["enviar_a"]=$correoEnviarA;
$data["cuerpo_mensaje"]=$cuerpoMensaje;


return $data;

}




function emailNotificacionAsignacionAseguradora($idInvestigacion){

	global $con;
	$data=array();
	mysqli_next_result($con);
	$queryInformacionAsignacion=mysqli_query($con,"SELECT CONCAT(e.nombres,' ',e.apellidos) AS nombre_usuario,e.correo,b.nombre_aseguradora AS aseguradora,a.tipo_caso,c.`descripcion` AS desc_tipo_caso,a.`codigo`,a.id,a.fecha_entrega
		FROM investigaciones a
		LEFT JOIN aseguradoras b ON a.id_aseguradora=b.id
		LEFT JOIN definicion_tipos c ON c.id=a.tipo_caso
		LEFT JOIN estado_investigaciones d ON d.id_investigacion=a.id
		LEFT JOIN usuarios e ON e.id=d.usuario
		WHERE d.estado=1 AND c.id_tipo=8 AND a.id='".$idInvestigacion."'");
		$resInformacionAsignacion=mysqli_fetch_assoc($queryInformacionAsignacion);
		$data["tipo_caso"]=$resInformacionAsignacion["tipo_caso"];
		if ($resInformacionAsignacion["tipo_caso"]==11 || $resInformacionAsignacion["tipo_caso"]==12)
		{
			
			$consultarDetalleAsignacion="SELECT * FROM detalle_investigaciones_validaciones WHERE id_investigacion='".$idInvestigacion."'";
			  mysqli_next_result($con);
			$queryCPAsignacion=mysqli_query($con,"SELECT * FROM multimedia_investigacion where id_investigacion='".$idInvestigacion."' and id_multimedia=11");
			$data["cantidad_carta_presentacion"]=mysqli_num_rows($queryCPAsignacion);
			if (mysqli_num_rows($queryCPAsignacion)>0){

				$resCTAsignacion=mysqli_fetch_assoc($queryCPAsignacion);


			$enlacesDescargaCartaPresentacionArchivos='<table style="background-color: #D8D8D8; margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 100%;" cellspacing="0" cellpadding="0" border="0" bgcolor="#D8D8D8" width="100%">
			    <tr>
			      <td align="center" valign="top">
			        <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 800px;" width="800" cellspacing="0" cellpadding="0" border="0">
			          <tr>
			            <td style="background-color: #09358e;" align="center" valign="top" bgcolor="#09358e">
			              <!--[if gte mso 9]>
			                  <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:800px;">
			                  <v:fill type="frame" src="" color="#09358e" />
			                  <v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0">
			                  <![endif]-->
			              <table class="p90" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 600px;" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
			                <tr>
			                  <td style="font-size: 1px; height: 20px; line-height: 20px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
			                </tr>
			               
			                <tr>
			                  <td valign="top" align="left">
			                    <!--[if gte mso 9]>
			                        <table align="left" border="0" cellpadding="0" cellspacing="0" width="600">
			                        <tr>
			                        <td align="left" valign="top" width="45">
			                        <![endif]-->
			                   
			                    <!--[if gte mso 9]>
			                        </td>
			                        <td align="left" valign="top" width="25">
			                        <![endif]-->
			                    <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 25px;" width="25" cellspacing="0" cellpadding="0" border="0" align="left">
			                      <tr>
			                        <td valign="top" align="left" style="font-size: 1px;">&nbsp;</td>
			                      </tr>
			                    </table>
			                    <!--[if gte mso 9]>
			                        </td>
			                        <td align="left" valign="top" width="380">
			                        <![endif]-->
			                    <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 380px;" width="380" cellspacing="0" cellpadding="0" border="0" align="left">
			                      <tr>
			                        <td align="center" valign="top">
			                          <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 380px;" width="380" cellspacing="0" cellpadding="0" border="0" align="center">
			                            <tr>
			                              <td valign="middle" class="text center" style="color: #ffffff; font-family: Open Sans, sans-serif; font-size: 15px; text-align: left; mso-line-height-rule: exactly;" align="center">
			                                <!--===================================================-->
			                                <!--|                      TEXT                      |-->
			                                <!--===================================================-->
			                                <font face="Open Sans, sans-serif">POR MEDIO DEL SIGUIENTE ENLACE PODRA DESCARGAR LA CARTA DE PRESENTACION DE ESTA ASIGNACION</font>
			                              </td>
			                            </tr>
			                            <tr>
			                              <td style="font-size: 1px; height: 5px; line-height: 5px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
			                            </tr>
			                          </table>
			                        </td>
			                      </tr>					
			                    </table>
			                    <!--[if gte mso 9]>
			                        </td>
			                        <td align="left" valign="top" width="150">
			                        <![endif]-->
			                    <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 136px;" width="136" cellspacing="0" cellpadding="0" border="0" align="right">
			                      <tr>
			                        <td style="font-size: 1px; height: 5px; line-height: 5px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
			                      </tr>
			                      <tr>
			                        <td align="center" valign="top">
			                          <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0;" cellspacing="0" cellpadding="0" border="0" align="center">
			                            <tr>
			                              <td align="center" valign="top">
			                                <!--===================================================-->
			                                <!--|                     BUTTON                     |-->
			                                <!--===================================================-->
			                                <table style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 100%;" cellspacing="0" cellpadding="0" border="0" width="100%">
			                                  <tr>
			                                    <td align="center" valign="top">
			                                      <table align="center" style="-moz-border-radius: 30px; -webkit-border-radius: 30px; background-color: transparent; border: 2px solid #ffffff; border-collapse: separate !important; border-radius: 30px; color: #979797; font-family: Open Sans, sans-serif; font-size: 13px; margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0;"
			                                      cellspacing="0" cellpadding="0" border="0" bgcolor="transparent">
			                                        <tr>
			                                          <td style="-moz-border-radius: 30px; -webkit-border-radius: 30px; border-radius: 30px; color: #B5B5B5; font-family: Open Sans, sans-serif; font-weight: 400; line-height: 100%; mso-line-height-rule: exactly; padding: 9px 20px; vertical-align: middle;"
			                                          align="center" valign="top">
			                                            <!--===================================================-->
			                                            <!--|                      LINK                      |-->
			                                            <!--===================================================-->
			                                            <a href="'.$resCTAsignacion["ruta"].'?'.time().'" target="_blank" style="border: none; color: #ffffff; display: block; font-family: Open Sans, sans-serif; font-size: inherit; font-weight: 700; outline: none; text-decoration: none;">DESCARGAR</a>
			                                          </td>
			                                        </tr>
			                                      </table>
			                                    </td>
			                                  </tr>
			                                </table>
			                                <!--===================================================-->
			                                <!--|                  BUTTON - END                  |-->
			                                <!--===================================================-->
			                              </td>
			                            </tr>
			                          </table>
			                        </td>
			                      </tr>
			                    </table>
			                    <!--[if gte mso 9]>
			                        </td>
			                        </tr>
			                        </table>
			                        <![endif]-->
			                  </td>
			                </tr>
			                <tr>
			                  <td style="font-size: 1px; height: 20px; line-height: 20px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
			                </tr>
			               
			              </table>
			              <!--[if gte mso 9]>
			                  </v:textbox>
			                  </v:fill>
			                  </v:rect>
			                  <![endif]-->
			            </td>
			          </tr>
			        </table>
			      </td>
			    </tr>
			  </table>';


			  $data["enlace_carta_presentacion"]=$enlacesDescargaCartaPresentacionArchivos;
			  }
		}
		else
		{
			$consultarDetalleAsignacion="SELECT * FROM detalle_investigaciones_soat WHERE id_investigacion='".$idInvestigacion."'";
			

		}
		  mysqli_next_result($con);
		$querySoporteAsignacion=mysqli_query($con,"SELECT * FROM multimedia_investigacion where id_investigacion='".$idInvestigacion."' and id_multimedia=10");
		$data["cantidad_soporte"]=mysqli_num_rows($querySoporteAsignacion);
		if (mysqli_num_rows($querySoporteAsignacion)>0){
				$resSoporteAsignacion=mysqli_fetch_assoc($querySoporteAsignacion);
		$enlacesDescargaSoporteArchivos='<table style="background-color: #D8D8D8; margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 100%;" cellspacing="0" cellpadding="0" border="0" bgcolor="#D8D8D8" width="100%">
    <tr>
      <td align="center" valign="top">
        <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 800px;" width="800" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td style="background-color: #09358e;" align="center" valign="top" bgcolor="#09358e">
              <!--[if gte mso 9]>
                  <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:800px;">
                  <v:fill type="frame" src="" color="#09358e" />
                  <v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0">
                  <![endif]-->
              <table class="p90" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 600px;" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
                <tr>
                  <td style="font-size: 1px; height: 20px; line-height: 20px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                </tr>
               
                <tr>
                  <td valign="top" align="left">
                    <!--[if gte mso 9]>
                        <table align="left" border="0" cellpadding="0" cellspacing="0" width="600">
                        <tr>
                        <td align="left" valign="top" width="45">
                        <![endif]-->
                   
                    <!--[if gte mso 9]>
                        </td>
                        <td align="left" valign="top" width="25">
                        <![endif]-->
                    <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 25px;" width="25" cellspacing="0" cellpadding="0" border="0" align="left">
                      <tr>
                        <td valign="top" align="left" style="font-size: 1px;">&nbsp;</td>
                      </tr>
                    </table>
                    <!--[if gte mso 9]>
                        </td>
                        <td align="left" valign="top" width="380">
                        <![endif]-->
                    <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 380px;" width="380" cellspacing="0" cellpadding="0" border="0" align="left">
                      <tr>
                        <td align="center" valign="top">
                          <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 380px;" width="380" cellspacing="0" cellpadding="0" border="0" align="center">
                            <tr>
                              <td valign="middle" class="text center" style="color: #ffffff; font-family: Open Sans, sans-serif; font-size: 15px; text-align: left; mso-line-height-rule: exactly;" align="center">
                                <!--===================================================-->
                                <!--|                      TEXT                      |-->
                                <!--===================================================-->
                                <font face="Open Sans, sans-serif">POR MEDIO DEL SIGUIENTE ENLACE PODRA DESCARGAR EL SOPORTE DE ESTA ASIGNACION</font>
                              </td>
                            </tr>
                            <tr>
                              <td style="font-size: 1px; height: 5px; line-height: 5px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                            </tr>
                          </table>
                        </td>
                      </tr>					
                    </table>
                    <!--[if gte mso 9]>
                        </td>
                        <td align="left" valign="top" width="150">
                        <![endif]-->
                    <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 136px;" width="136" cellspacing="0" cellpadding="0" border="0" align="right">
                      <tr>
                        <td style="font-size: 1px; height: 5px; line-height: 5px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="center" valign="top">
                          <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0;" cellspacing="0" cellpadding="0" border="0" align="center">
                            <tr>
                              <td align="center" valign="top">
                                <!--===================================================-->
                                <!--|                     BUTTON                     |-->
                                <!--===================================================-->
                                <table style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 100%;" cellspacing="0" cellpadding="0" border="0" width="100%">
                                  <tr>
                                    <td align="center" valign="top">
                                      <table align="center" style="-moz-border-radius: 30px; -webkit-border-radius: 30px; background-color: transparent; border: 2px solid #ffffff; border-collapse: separate !important; border-radius: 30px; color: #979797; font-family: Open Sans, sans-serif; font-size: 13px; margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0;"
                                      cellspacing="0" cellpadding="0" border="0" bgcolor="transparent">
                                        <tr>
                                          <td style="-moz-border-radius: 30px; -webkit-border-radius: 30px; border-radius: 30px; color: #B5B5B5; font-family: Open Sans, sans-serif; font-weight: 400; line-height: 100%; mso-line-height-rule: exactly; padding: 9px 20px; vertical-align: middle;"
                                          align="center" valign="top">
                                            <!--===================================================-->
                                            <!--|                      LINK                      |-->
                                            <!--===================================================-->
                                            <a href="'.$resSoporteAsignacion["ruta"].'?'.time().'" target="_blank" style="border: none; color: #ffffff; display: block; font-family: Open Sans, sans-serif; font-size: inherit; font-weight: 700; outline: none; text-decoration: none;">DESCARGAR</a>
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                </table>
                                <!--===================================================-->
                                <!--|                  BUTTON - END                  |-->
                                <!--===================================================-->
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                    <!--[if gte mso 9]>
                        </td>
                        </tr>
                        </table>
                        <![endif]-->
                  </td>
                </tr>
                <tr>
                  <td style="font-size: 1px; height: 20px; line-height: 20px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                </tr>
               
              </table>
              <!--[if gte mso 9]>
                  </v:textbox>
                  </v:fill>
                  </v:rect>
                  <![endif]-->
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>';
  $data["enlace_soporte"]=$enlacesDescargaSoporteArchivos;
}
	  mysqli_next_result($con);
		$queryDetalleAsignacion=mysqli_query($con,$consultarDetalleAsignacion);
		$resDetalleAsignacion=mysqli_fetch_assoc($queryDetalleAsignacion);


$tituloEmail="NOTIFICACION DE ASIGNACION. CASO: ".$resInformacionAsignacion["codigo"];
$asuntoMensaje=$tituloEmail;

$correoEnviarA=$resInformacionAsignacion["correo"];
$cuerpoMensaje='<tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #09358e; font-family: Open Sans, sans-serif;">ASEGURADORA</span><span style="font-family: Open Sans, sans-serif;">:&#xA0;</span><span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;">'.$resInformacionAsignacion["aseguradora"].'</span>
                              </td>
                            </tr>
                            <tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #09358e; font-family: Open Sans, sans-serif;">USUARIO</span><span style="font-family: Open Sans, sans-serif;">:&#xA0;</span><span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;">'.$resInformacionAsignacion["nombre_usuario"].'</span>
                              </td>
                            </tr>
                            <tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #09358e; font-family: Open Sans, sans-serif;">FECHA DE ENTREGA</span><span style="font-family: Open Sans, sans-serif;">:&#xA0;</span><span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;">'.$resInformacionAsignacion["fecha_entrega"].'</span>
                              </td>
                            </tr>
                            <tr class="bullet_box">
                              <td class="bullet" style="font-family: Open Sans, sans-serif; font-size: 14px; font-weight: 700; line-height: 23px; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   BRAND NAME                   |-->
                                <!--===================================================-->
                                <span style="color: #09358e; font-family: Open Sans, sans-serif;">MOTIVO INVESTIGACION</span><span style="font-family: Open Sans, sans-serif;">:&#xA0;</span><span style="color: #343434; font-family: Open Sans, sans-serif; letter-spacing: 0;">'.$resDetalleAsignacion["motivo_investigacion"].'</span>
                              </td>
                            </tr>';


$data["titulo_mensaje"]=$tituloEmail;
$data["asunto_mensaje"]=$asuntoMensaje;
$data["enviar_a"]=$correoEnviarA;
$data["cuerpo_mensaje"]=$cuerpoMensaje;


return $data;

}

function enviarEmail($idInvestigacion,$tipoMensaje)
{
	$address_to=array();
	$reply_to=array();
	$infoEmail= array();	
	if ($tipoMensaje==1)
	{
		//asignacion Caso
		$infoEmail=emailNotificacionAsignacionAseguradora($idInvestigacion);
		$from_name = $infoEmail["nombre_usuario"];
		$departeDe=	$infoEmail["enviar_a"];

		//$address_to[] = "drodriguez@globalredbucaramanga.com";
		$address_to[] = "jquijano@globalredltda.com";
		$address_to[] = "josemquijano@globalredltda.com";
		$address_to[] = "gestionoperativa@globalredltda.com";
		$address_to[] = "jdzapata@globalredltda.com";
		$address_to[] = $infoEmail["enviar_a"];
		//$address_to[] = "jdzapata1224@gmail.com";
		//$address_to[] = "hquijano@globalredbucaramanga.com";
		$reply_to[]=$departeDe;
	
	}
	else if ($tipoMensaje==2)
	{
		//asignacion Caso
		$infoEmail=emailRespuestaAsignacionAseguradora($idInvestigacion);
		$from_name = "Global Red LTDA";
		$departeDe=	"gestionoperativa@globalredltda.com";
		
		$address_to[] = $infoEmail["enviar_a"];
		//$address_to[] = "jquijano@globalredbucaramanga.com";
		$reply_to[] = "jdzapata@globalredltda.com";
		//$reply_to[] = "jdzapata1224@gmail.com";
		//$address_to[] = "hquijano@globalredbucaramanga.com";

	
	}
	else if ($tipoMensaje==3)
	{
		//asignacion Caso
		$infoEmail=emailAsignacionInvestigador($idInvestigacion);
		$from_name = "Global Red LTDA";
		$departeDe=	"globalredmundialseguros19@gmail.com";
		
		$address_to[] = $infoEmail["enviar_a"];
		$address_to[] = "globalredmundialseguros19@gmail.com";

		$reply_to[] = "globalredmundialseguros19@gmail.com";
		//$reply_to[] = "jdzapata1224@gmail.com";
		//$address_to[] = "hquijano@globalredbucaramanga.com";

	
	}
	else if ($tipoMensaje==4)
	{
		//asignacion Caso
		$infoEmail=emailAsignacionAmpliacionInvestigador($idInvestigacion);
		$from_name = "Global Red LTDA";
		$departeDe=	"globalredmundialseguros19@gmail.com";
		
		$address_to[] = $infoEmail["enviar_a"];
		$address_to[] = "globalredmundialseguros19@gmail.com";
		$reply_to[] = "globalredmundialseguros19@gmail.com";

		//$reply_to[] = "jdzapata1224@gmail.com";
		//$address_to[] = "hquijano@globalredbucaramanga.com";

	
	}

	$email_user = "no_reply@globalredltda.com";
	$email_password = "global123456";
	$the_subject = $infoEmail["asunto_mensaje"];


$phpmailer = new PHPMailer();
$phpmailer->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
// ---------- datos de la cuenta de Gmail -------------------------------
$phpmailer->Username = $email_user;
$phpmailer->Password = $email_password; 
//-----------------------------------------------------------------------
// $phpmailer->SMTPDebug = 1;
$phpmailer->IsSMTP(); // use SMTP


//$phpmailer->Host = "smtp.globalredltda.com"; // GMail
$phpmailer->Host = gethostbyname('tls://smtp.globalredltda.com');
$phpmailer->Port = 587;
$phpmailer->AddEmbeddedImage('../plugins/mailer/logoglobal.png','logo_globalred','logoglobal.png');
$phpmailer->SMTPAuth = true;

$phpmailer->setFrom($departeDe,$from_name);


foreach($address_to as $correos)
    {
    $phpmailer->AddAddress($correos);
    }


foreach($reply_to as $correos2)
    {
    $phpmailer->AddReplyTo($correos2);
    }

//$phpmailer->AddCC($departeDe,$from_name);
$phpmailer->Subject = $the_subject;	
$phpmailer->Body .='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta name="format-detection" content="telephone=no" />
  <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
  <title>Rigo - Responsive Email Template</title>
  <style type="text/css">
    body{ width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0; }
    .ReadMsgBody { width: 100%; }
    .ExternalClass {width:100%;}
    .backgroundTable {margin:0 auto; padding:0; width:100%!important;}
    .ExternalClass * {line-height: 115%;}
    p { margin: 0; }
    div.tpl-content { padding: 0 !important; }
    span.preheader{
        display: none;
        font-size: 1px;
        visibility: hidden;
        opacity: 0;
        color: transparent;
        height: 0;
        width: 0;
    }
    a {
        text-decoration: none;
        color: inherit;
    }
    table {
        border-collapse: collapse;
    }
    *[class="sm-show"], .sm-show {display:none; visibility: hidden}
    @media only screen and (max-width: 795px) {
        *[class="mobile-column"], .mobile-column {display: block;}
        *[class="mob-column"], .mob-column {float: none !important;width: 100% !important;}
        *[class="hide"], .hide {display:none !important;}
        *[class="condensed"], .condensed {padding-bottom:40px !important; display: block;}
        *[class="center"], .center {text-align:center !important; width:100% !important; height:auto !important;}
        *[class="100pad"] {width:100% !important; padding:20px;}
        *[class="100padleftright"] {width:100% !important; padding:0 20px 0 20px;}
        *[class="100padtopbottom"] {width:100% !important; padding:20px 0 20px 0;}
        *[class="hr"], .hr {width:100% !important;}
        *[class="p2"], .p2     {width:2% !important; height:auto !important;}
        *[class="p10"], .p10   {width:10% !important; height:auto !important;}
        *[class="p20"], .p20   {width:20% !important; height:auto !important;}
        *[class="p30"], .p30   {width:30% !important; height:auto !important;}
        *[class="p33"], .p33   {width:33.32% !important; height:auto !important;}
        *[class="p40"], .p40   {width:40% !important; height:auto !important;}
        *[class="p49"], .p49   {width:49% !important; height:auto !important;}
        *[class="p50"], .p50   {width:50% !important; height:auto !important;}
        *[class="p60"], .p60   {width:60% !important; height:auto !important;}
        *[class="p70"], .p70   {width:70% !important; height:auto !important;}
        *[class="p80"], .p80   {width:80% !important; height:auto !important;}
        *[class="p90"], .p90   {width:90% !important; height:auto !important;}
        *[class="p100"], .p100 {width:100% !important; height:auto !important;}
        *[class="p15"], .p15   {width:15% !important; height:auto !important;}
        *[class="p25"], .p25   {width:25% !important; height:auto !important;}
        *[class="p33"], .p33   {width:33% !important; height:auto !important;}
        *[class="p35"], .p35   {width:35% !important; height:auto !important;}
        *[class="p45"], .p45   {width:45% !important; height:auto !important;}
        *[class="p55"], .p55   {width:55% !important; height:auto !important;}
        *[class="p65"], .p65   {width:65% !important; height:auto !important;}
        *[class="p75"], .p75   {width:75% !important; height:auto !important;}
        *[class="p85"], .p85   {width:85% !important; height:auto !important;}
        *[class="p95"], .p95   {width:95% !important; height:auto !important;}
        *[class="alignleft"] {text-align: left !important;}
        *[class="100button"] {width:100% !important;}
        *[class="mob-auto"], .mob-auto {width:auto !important; height: auto !important;}
        *[class="sm-show"], .sm-show {display: block !important; visibility: visible !important;}
        *[class="sm-no-border"], .sm-no-border {
            border-left: 0 !important;
            border-top: 0 !important;
            border-bottom: 0 !important;
            border-right: 0 !important;
        }
    }
    @media only screen and (max-width: 450px) {
        *[class="xs-no-pad"], .xs-no-pad {padding: 0 !important;}
        *[class="xs-p25"], .xs-p25 {width:25% !important; height:auto !important;}
        *[class="xs-p50"], .xs-p50 {width:50% !important; height:auto !important;}
        *[class="xs-p75"], .xs-p75 {width:75% !important; height:auto !important;}
        *[class="xs-p100"], .xs-p100 {width:100% !important; height:auto !important;}
        *[class="xs-hide"], .xs-hide {display:none !important;}
        *[class="xs-header"], .xs-header {font-size: 45px !important}
    }
  </style>
</head>

<body style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; background-color: #D8D8D8; margin: 0; padding: 0; width: 100% !important;">
  <!--===================================================-->
  <!--|                    Preheader                    |-->
  <!--===================================================-->
  <span class="preheader" style="color: transparent; display: none; font-size: 1px; height: 0; opacity: 0; visibility: hidden; width: 0;">Preheader shows up in Gmail and other email clients, 75 chars limit...</span>
  <!--===================================================-->
  <!--|                    SECTION 1                    |-->
  <!--===================================================-->
  <table style="background-color: #D8D8D8; margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 100%;" cellspacing="0" cellpadding="0" border="0" bgcolor="#D8D8D8" width="100%">
    <tr>
      <td align="center" valign="top">
        <table class="p100" style="background-color: #FFFFFF; margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 800px;" width="800" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" align="center">
          <tr>
            <td align="center" valign="top">
              <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 800px;" width="800" cellspacing="0" cellpadding="0" border="0" align="left">
                <tr>
                  <td style="width: 30px; font-size: 1px;" width="30" valign="top" align="left">&nbsp;</td>
                  <td align="center" valign="top">
                    <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 600px; border-bottom:2px solid #09358e;" width="600" cellspacing="0" cellpadding="0" border="0" align="center" >
                      <tr>
                        <td style="font-size: 1px; height: 20px; line-height: 20px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                      </tr>
                      <tr>
                        <td  valign="top">
                          <!--===================================================-->
                          <!--|                   LOGO IMAGE                   |-->
                          <!--===================================================-->
                          <a href="#" style="border: none; color: inherit; display: block; font-family: Open Sans, sans-serif; font-size: inherit; outline: none; text-decoration: none; width: 220px;">
                            <img src="cid:logo_globalred" alt="logo" style="-ms-interpolation-mode: bicubic; border: 0; display: block; outline: 0; text-decoration: none; width: 600px;" width="220" border="0" />
                          </a>
                        </td>
                      </tr>
                      <tr>
                        <td style="font-size: 1px; height: 15px; line-height: 15px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                      </tr>
                    </table>
                  </td>
                  <td style="width: 30px; font-size: 1px;" width="30" valign="top" align="left">&nbsp;</td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  
 
  
  <!--===================================================-->
  <!--|                    SECTION 7                    |-->
  <!--===================================================-->
  <table style="background-color: #D8D8D8; margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 100%;" cellspacing="0" cellpadding="0" border="0" bgcolor="#D8D8D8" width="100%">
    <tr>
      <td align="center" valign="top">
        <table class="p100" style="background-color: #FFFFFF; margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 800px;" width="800" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF">
          <tr>
            <td style="width: 30px; font-size: 1px;" width="30" valign="top" align="left">&nbsp;</td>
            <td align="center" valign="top">
              <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 600px;" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
               
               
                <tr>
                  <td style="font-size: 1px; height: 10px; line-height: 10px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                </tr>
                <tr>   	
                  <td style="color: #343434; font-family: Open Sans, sans-serif; font-size: 15px; font-weight: 700; letter-spacing: 0.03em; line-height: 23px; mso-line-height-rule: exactly;" align="center" valign="top"><font face="Open Sans, sans-serif">'. $infoEmail["titulo_mensaje"].'</font>
                  </td>
                </tr>
                <tr>
                  <td style="font-size: 1px; height: 10px; line-height: 10px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top">
                    <table class="p100" style="border-bottom: 1px solid #DCDCDC; border-top: 1px solid #DCDCDC; margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 600px;" width="600" cellspacing="0" cellpadding="0" border="0">
                      <tr>
                        <td align="left" valign="top">
                          <!--[if gte mso 9]>
                              <table align="left" border="0" cellpadding="0" cellspacing="0" width="600">
                              <tr>
                              <td align="left" valign="top" width="300">
                              <![endif]-->
                          <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 600px;" width="600" cellspacing="0" cellpadding="0" border="0" align="left">
                            <tr>
                              <td style="font-size: 1px; height: 30px; line-height: 30px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                            </tr>
                            '.$infoEmail["cuerpo_mensaje"].'
                          
                            <tr>
                              <td class="hide" style="font-size: 1px; height: 30px; line-height: 30px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                            </tr>
                          </table>
                          <!--[if gte mso 9]>
                              </td>
                              <td align="left" valign="top" width="300">
                              <![endif]-->
                          
                          <!--[if gte mso 9]>
                              </td>
                              </tr>
                              </table>
                              <![endif]-->
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td style="font-size: 1px; height: 15px; line-height: 15px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                </tr>
                
              </table>
            </td>
            <td style="width: 30px; font-size: 1px;" width="30" valign="top" align="left">&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
 
 
  <!--===================================================-->
  <!--|                   SECTION 19                   |-->
  <!--===================================================-->
  
  ';
  if ($infoEmail["cantidad_soporte"]>0){
  		$phpmailer->Body .=$infoEmail["enlace_soporte"];
  }

  if ($infoEmail["cantidad_carta_presentacion"]>0){
  		$phpmailer->Body .=$infoEmail["enlace_carta_presentacion"];
  }

   if ($infoEmail["cantidad_informe_final"]>0){
  		$phpmailer->Body .=$infoEmail["enlace_informe_final"];
  }
  $phpmailer->Body .='
 
  
  <!--===================================================-->
  <!--|                   SECTION 29                   |-->
  <!--===================================================-->
 
  <!--===================================================-->
  <!--|               SECTION 30 - FOOTER               |-->
  <!--===================================================-->
  <table style="background-color: #D8D8D8; margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 100%;" cellspacing="0" cellpadding="0" border="0" bgcolor="#D8D8D8" width="100%">
    <tr>
      <td align="center" valign="top">
        <table class="p100" style="background-color: #1A191E; margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 800px;" width="800" cellspacing="0" cellpadding="0" border="0" bgcolor="#1A191E">
          <tr>
            <td align="center" valign="top">
              <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 660px;" width="660" cellspacing="0" cellpadding="0" border="0" align="center">
                <tr>
                  <td style="width: 30px; font-size: 1px;" width="30" valign="top" align="left">&nbsp;</td>
                  <td align="center" valign="top">
                    <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 600px;" width="600" cellspacing="0" cellpadding="0" border="0">
                      <tr>
                        <td class="space-top" style="font-size: 1px; height: 30px; line-height: 30px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="center" valign="top">
                          <!--[if gte mso 9]>
                              <table align="left" border="0" cellpadding="0" cellspacing="0" width="600">
                              <tr>
                              <td align="left" valign="top" width="450">
                              <![endif]-->
                          <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 450px;" width="450" cellspacing="0" cellpadding="0" border="0" align="left">
                            <tr>
                              <td style="color: #7E797D; font-family: Open Sans, sans-serif; font-size: 13px; font-weight: normal; letter-spacing: 0.02em; line-height: 20px; text-align: left; mso-line-height-rule: exactly;" valign="top" align="left">
                                <!--===================================================-->
                                <!--|                   FOOTER TEXT                   |-->
                                <!--===================================================-->
                                <font face="Open Sans, sans-serif">Correo enviado desde SIGLO. <br>Desarrollado por: Jairo Zapata Fandiño.</font>
                              </td>
                            </tr>
                            <tr>
                              <td style="font-size: 1px; height: 10px; line-height: 10px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                            </tr>
                          </table>
                          <!--[if gte mso 9]>
                              </td>
                              <td align="left" valign="top" width="150">
                              <![endif]-->
                     
                          <!--[if gte mso 9]>
                              </td>
                              </tr>
                              </table>
                              <![endif]-->
                        </td>
                      </tr>
                      <tr>
                        <td class="space-bottom" style="font-size: 1px; height: 30px; line-height: 30px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                      </tr>
                    </table>
                  </td>
                  <td style="width: 30px; font-size: 1px;" width="30" valign="top" align="left">&nbsp;</td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>

</html>';

$phpmailer->IsHTML(true);

if ($phpmailer->Send()){
	$variable=1;
}else{
	$variable=2;
}
 return $variable;
}

?>