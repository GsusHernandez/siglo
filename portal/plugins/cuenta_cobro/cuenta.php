<html>
	<head>
		<meta charset="utf-8">
		<title>Invoice</title>
		<link rel="stylesheet" href="cuenta.css?<?php echo rand();?>">
		<link rel="license" href="https://www.opensource.org/licenses/mit-license/">
		
	</head>
	<body>
        <?php
        include('../../conexion/conexion.php');
        $idCuentaCobro=$_GET["idCuentaCobro"];
        
        $informacionCuentaCobro="SELECT a.id as id_cuenta_cobro,a.fecha,concat(d.descripcion,' ',b.identificacion) as identificacion_investigador,
        c.descripcion as periodo,concat(b.nombres,' ',b.apellidos) as investigador,a.valor_investigaciones,a.valor_biaticos,a.valor_total,a.valor_adicionales 
        FROM cuenta_cobro_investigadores a 
        LEFT JOIN investigadores b on a.id_investigador=b.id 
        LEFT JOIN periodos_cuenta_cobro_investigadores c on a.id_periodo=c.id 
        LEFT JOIN definicion_tipos d on d.id=b.tipo_identificacion
        WHERE d.id_tipo=5 and a.id='".$idCuentaCobro."'";

        $queryCuentaCobro=mysqli_query($con,$informacionCuentaCobro);
        $resCuentaCobro=mysqli_fetch_assoc($queryCuentaCobro);
        ?>
		<header>
			<h1>CUENTA DE COBRO</h1>
			<address>
				<p>Global Red LTDA</p>
				<p>NIT 890008939-3</p><br><br>
				<p>Debe a:</p>
			</address>
		</header>
		<article>
			
			<address >
				<p><?php echo $resCuentaCobro["investigador"];?><br><?php echo $resCuentaCobro["identificacion_investigador"];?><br><br> Por concepto de investigaciones realizadas en el <BR>periodo corresponde a <?php echo $resCuentaCobro["periodo"];?></p>


			</address>
			<table class="meta">
				<tr>
					<th><span >Cuenta de Cobro #</span></th>
					<td><span ><?php echo $resCuentaCobro["id_cuenta_cobro"];?></span></td>
				</tr>
				<tr>
					<th><span >Fecha</span></th>
					<td><span ><?php echo $resCuentaCobro["fecha"];?></span></td>
				</tr>
				<tr>
					<th><span >Valor</span></th>
					<td><span id="prefix" >$</span><span><?php echo number_format($resCuentaCobro["valor_total"],0);?></span></td>
				</tr>
			</table>
			<table class="inventory">
				<thead>
					<tr>
						<th><span >Descripcion</span></th>
						<th><span >Valor</span></th>
						<th><span >Cantidad</span></th>
						<th><span >Total</span></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$consultarInformacionDetalleCuentaCobro="SELECT CONCAT(b.nombre_aseguradora,'-',d.descripcion,'-',g.descripcion) AS aseguradora_tipo_caso,COUNT(a.id) AS cantidad_investigaciones,CASE WHEN e.valor_investigacion IS NULL THEN '0' ELSE e.valor_investigacion END AS valor_investigacion,e.tipo_caso,e.id_aseguradora,e.tipo_perimetro,e.tipo_auditoria,e.resultado
						  FROM 
						  investigaciones a 
						  LEFT JOIN aseguradoras b ON a.id_aseguradora=b.id 
						  LEFT JOIN definicion_tipos c ON c.descripcion2=a.tipo_caso 
						  LEFT JOIN definicion_tipos d ON d.id=c.descripcion
						  LEFT JOIN detalle_cuenta_cobro_investigadores e ON e.id_investigacion=a.id
						  LEFT JOIN cuenta_cobro_investigadores f ON f.id=e.id_cuenta_cobro
						  LEFT JOIN definicion_tipos g ON g.id=e.resultado
						  WHERE g.id_tipo=44 AND c.id_tipo=43 AND d.id_tipo=42 AND f.id='".$idCuentaCobro."' AND e.resultado=3
						  GROUP BY b.id,d.id,g.id
						  
						  UNION
						  
						  SELECT CONCAT(b.nombre_aseguradora,'-',d.descripcion,'-',g.descripcion,'-',h.descripcion,'-',i.descripcion) AS aseguradora_tipo_caso,COUNT(a.id) AS cantidad_investigaciones,CASE WHEN e.valor_investigacion IS NULL THEN '0' ELSE e.valor_investigacion END AS valor_investigacion,e.tipo_caso,e.id_aseguradora,e.tipo_perimetro,e.tipo_auditoria,e.resultado
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
						  GROUP BY b.id,d.id,g.id,h.id,i.id";
					  mysqli_next_result($con);
					  $queryInformacionDetalleCuentaCobro=mysqli_query($con,$consultarInformacionDetalleCuentaCobro);
					  while ($resInformacionDetalleCuentaCobro=mysqli_fetch_assoc($queryInformacionDetalleCuentaCobro))
					  {
						?>
						  <tr>
						<td><span ><?php echo $resInformacionDetalleCuentaCobro["aseguradora_tipo_caso"];?></span></td>
						<td><span data-prefix>$</span><span ><?php echo number_format($resInformacionDetalleCuentaCobro["valor_investigacion"],0);?></span></td>
						<td><span ><?php echo $resInformacionDetalleCuentaCobro["cantidad_investigaciones"];?></span></td>
						<td><span data-prefix>$</span><span><?php echo number_format(($resInformacionDetalleCuentaCobro["cantidad_investigaciones"]*$resInformacionDetalleCuentaCobro["valor_investigacion"]),0);?></span></td>
					</tr>
						<?php
					  }
					?>
			
                    
                  
				</tbody>
			</table>
			
			<table class="balance">
				<tr>
					<th><span >Investigaciones</span></th>
					<td><span data-prefix>$</span><span><?php echo number_format($resCuentaCobro["valor_investigaciones"],0);?></span></td>
				</tr>
				<tr>
					<th><span >Biaticos</span></th>
					<td><span data-prefix>$</span><span ><?php echo number_format($resCuentaCobro["valor_biaticos"],0);?></span></td>
                </tr>
                
                <tr>
					<th><span >Adicionales</span></th>
					<td><span data-prefix>$</span><span ><?php echo number_format($resCuentaCobro["valor_adicionales"],0);?></span></td>
				</tr>
				<tr>
					<th><span >Total</span></th>
					<td><span data-prefix>$</span><span><?php echo number_format($resCuentaCobro["valor_total"],0);?></span></td>
				</tr>
			</table>
			</article>
			<br><br><br><br><br><br><br><br><br><br>
			<br><br><br><br><br><br><br><br><br><br><br><br>
			<article>
			<table class="inventory2">
				<thead>
					<tr>
						<th><span >Informacion</span></th>
						<th><span >Lesionado</span></th>
						<th><span >Identificacion</span></th>
						<th><span >Placa</span></th>
						<th><span >Poliza</span></th>
						
						<th><span >Perimetro</span></th>
						<th><span >Valor</span></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$consultarCasosDetalleCuentaCobro="SELECT b.nombre_aseguradora,d.descripcion AS tipo_caso,g.descripcion AS resultado,'' AS tipo_auditoria,'' AS tipo_perimetro,a.id,
					  CASE WHEN e.valor_investigacion IS NULL THEN '0' ELSE e.valor_investigacion END AS valor_investigacion,n.numero AS numero_poliza,
					  CONCAT(k.nombres,' ',k.apellidos) AS nombre_persona,CONCAT(l.descripcion,' ',k.identificacion) AS identificacion_persona,o.placa 
					  FROM 
					  investigaciones a 
					  LEFT JOIN aseguradoras b ON a.id_aseguradora=b.id 
					  LEFT JOIN definicion_tipos c ON c.descripcion2=a.tipo_caso 
					  LEFT JOIN definicion_tipos d ON d.id=c.descripcion
					  LEFT JOIN detalle_cuenta_cobro_investigadores e ON e.id_investigacion=a.id
					  LEFT JOIN cuenta_cobro_investigadores f ON f.id=e.id_cuenta_cobro
					  LEFT JOIN definicion_tipos g ON g.id=e.resultado
					  LEFT JOIN personas_investigaciones_soat j ON j.id_investigacion=a.id 
					  LEFT JOIN personas k ON k.id=j.id_persona
					  LEFT JOIN definicion_tipos l ON l.id=k.tipo_identificacion 
					  LEFT JOIN detalle_investigaciones_soat m ON m.id_investigacion=a.id 
					  LEFT JOIN polizas n ON n.id=m.id_poliza 
					  LEFT JOIN vehiculos o ON o.id=n.id_vehiculo
					  WHERE l.id_tipo=5 AND g.id_tipo=44 AND c.id_tipo=43 AND d.id_tipo=42 AND f.id='".$idCuentaCobro."' AND e.resultado=3					  
					  UNION
					  SELECT b.nombre_aseguradora,d.descripcion AS tipo_caso,g.descripcion AS resultado,
					  h.descripcion AS tipo_auditoria,i.descripcion AS tipo_perimetro,a.id,
					  CASE WHEN e.valor_investigacion IS NULL THEN '0' ELSE e.valor_investigacion END AS valor_investigacion
					  ,n.numero AS numero_poliza,
				      CONCAT(k.nombres,' ',k.apellidos) AS nombre_persona,CONCAT(l.descripcion,' ',k.identificacion) AS identificacion_persona,o.placa 
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
					  LEFT JOIN personas_investigaciones_soat j ON j.id_investigacion=a.id 
					  LEFT JOIN personas k ON k.id=j.id_persona
					  LEFT JOIN definicion_tipos l ON l.id=k.tipo_identificacion 
					  LEFT JOIN detalle_investigaciones_soat m ON m.id_investigacion=a.id 
					  LEFT JOIN polizas n ON n.id=m.id_poliza 
					  LEFT JOIN vehiculos o ON o.id=n.id_vehiculo
					  WHERE l.id_tipo=5 AND i.id_tipo=46 AND h.id_tipo=45 AND g.id_tipo=44 AND c.id_tipo=43 AND d.id_tipo=42 AND f.id='".$idCuentaCobro."' AND e.resultado<>3";
					  mysqli_next_result($con);
					  
					  $queryCasosDetalleCuentaCobro=mysqli_query($con,$consultarCasosDetalleCuentaCobro);
					  while ($resCasosDetalleCuentaCobro=mysqli_fetch_assoc($queryCasosDetalleCuentaCobro))
					  {
					  	?>
					  	<tr>
					  	<td><span ><?php echo $resCasosDetalleCuentaCobro["nombre_aseguradora"]."<br>".$resCasosDetalleCuentaCobro["tipo_caso"]."<br>".$resCasosDetalleCuentaCobro["resultado"]."<br>".$resCasosDetalleCuentaCobro["tipo_auditoria"];?></span></td>
					  	<td data-prefix><span ><?php echo $resCasosDetalleCuentaCobro["nombre_persona"];?></span></td>
					  	<td><span ><?php echo $resCasosDetalleCuentaCobro["identificacion_persona"];?></span></td>
					  	<td data-prefix><span ><?php echo $resCasosDetalleCuentaCobro["placa"];?></span></td>
					  	<td><span ><?php echo $resCasosDetalleCuentaCobro["numero_poliza"];?></span></td>
					  	
					  	<td><span ><?php echo $resCasosDetalleCuentaCobro["tipo_perimetro"];?></span></td>
					  	<td data-prefix><span ><?php echo "$".number_format($resCasosDetalleCuentaCobro["valor_investigacion"],0);?></span></td>
					  </tr>
					  	<?php
					  }
					?>
				</tbody>
			</table>
		</article>
		
			
		
		<!-- AdminLTE for demo purposes<aside>
			<h1><span >Additional Notes</span></h1>
			<div >
				<p>A finance charge of 1.5% will be made on unpaid balances after 30 days.</p>
			</div>
		</aside> -->
	</body>
</html>