
	<div id="formRegistrar" data-role="page" class="ui-page-theme-c">

		<div data-role="header"  data-theme="c" data-position="fixed" data-id="cabezal">			
			<h1>GLOBAL RED</h1>			
		</div>

		<div data-role="header" data-position="fixed" style="margin-top:45.3px">
				
					<a data-rel="back" class="ui-btn ui-btn-b ui-shadow ui-corner-all ui-icon-carat-l ui-btn-icon-notext"></a>
					<h2>Registrar Caso</h2>	
					<a href="login.php" class="ui-btn ui-btn-b ui-shadow ui-corner-all ui-icon-arrow-u-l ui-btn-icon-notext">        
      			</a>				
					    
		

		</div>

		

		<div data-role="content" style="margin-top:30px;">

			<div data-role="collapsibleset">
				<div data-role="collapsible" data-theme="c">
					<h2>Datos lesionado</h2>
					<ul data-role="listview">
						
						<li>
														
							<label for="nombres">Nombres:</label>
							<input id="nombres" type="text">

							<label for="apellidos">Apellidos:</label>
							<input id="apellidos" type="text">

							<label for="ocupacion">Ocupación:</label>
							<input id="ocupacion" type="text">	


							<label for="tipoId">tipo Identificación:</label>
							<input id="tipoId" type="text">

							<label for="id">Identificación:</label>
							<input id="id" type="text" name="" >							

							<label for="edad">Edad:</label>
							<input id="edad" type="text" name="" >

							<label for="sexo">Sexo:</label>
							<input id="sexo" type="text" name="" >

							<label for="direccion">Dirección residencia:</label>
							<input id="direccion" type="text">	

							<label for="telefono">Teléfono Contacto:</label>
							<input id="telefono" type="text">	

							<label for="barrrio">Barrio:</label>
							<input id="barrio" type="text">	

							<label for="ciudad">Ciudad:</label>
							<input id="ciudad" type="text">	

							
						</li>
						
						
					</ul>
				</div>

				<div data-role="collapsible" data-theme="c">
					<h2>Datos Póliza</h2>
					<ul data-role="listview">
						
						<li>
							<label for="poliza">póliza:</label>
							<input id="poliza" type="text" name="" >

							<label for="aseguradora">Aseguradora:</label>
							<input id="aseguradora" type="text">

							<label for="tipoVehiculo">Tipo Vehículo:</label>
							<input id="tipoVehiculo" type="text">

							<label for="tipoServicio">Tipo servicio Vehiculo:</label>
							<input id="tipoServicio" type="text" name="" >

							<label for="placa">Placa:</label>
							<input id="placa" type="text" name="" >


						</li>
						
					</ul>

					
				</div>

				<div data-role="collapsible" data-theme="c">
					<h2>Datos Accidente</h2>
						<ul data-role="listview">
							
							<li>
								<label for="fechaAccidente">fecha de Accidente:</label>
								<input id="fechaAccidente" type="text">

								<label for="lugarAccidente">Lugar Accidente:</label>
								<input id="lugarAccidente" type="text">

								<label for="serviAmbulancia">Servicio de Ambulacia:</label>
								<input id="serviAmbulancia" type="text">

								<label for="fechaIngreso">Fecha ingreso:</label>
								<input id="fechaIngreso" type="text">

								<label for="fechaEgreso">Fecha egreso:</label>
								<input id="fechaEgreso" type="text">

								<label for="ciudadOcurrencia">Ciudad ocurrencia:</label>
								<input id="ciudadOcurrencia" type="text">


							</li>
							
						</ul>
					</div>
			</div>
			<div>
				<button class="ui-btn ui-btn-b ui-shadow ui-corner-all ui-btn-inline">enviar</button>
			</div>

			

		</div>
	</div>



</body>
</html>