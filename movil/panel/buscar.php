


	<div id="formBuscar" data-role="page" class="ui-page-theme-c">

		<div data-role="header"  data-position="fixed" data-theme="c" data-position="fixed" data-id="cabezal">			
			<h1>GLOBAL RED</h1>		
		</div>

		<div data-role="header" data-position="fixed" style="margin-top:45.3px">				
				<a data-rel="back" class="ui-btn ui-btn-b ui-shadow ui-corner-all ui-icon-carat-l ui-btn-icon-notext"></a>

				<h2>Buscar</h2>

				<a href="../login.php" class="ui-btn ui-btn-b ui-shadow ui-corner-all ui-icon-arrow-u-l ui-btn-icon-notext">        
      			</a>			
					    
		</div>
		

		<div role="main" class="ui-content" style="margin-top:30px;">
		
			
				<label for="codigo">codigo:</label>
				<input id="codigo" type="text">

				<label for="fechaAccidente">fecha de Accidente:</label>
				<input id="fechaAccidente" type="text">
				
				<label for="nombres">Nombres:</label>
				<input id="nombres" type="text">

				<label for="apellidos">Apellidos:</label>
				<input id="apellidos" type="text">

				<label for="id">Identificación:</label>
				<input id="id" type="text">

				<label for="poliza">póliza:</label>
				<input id="poliza" type="text">

				<label for="placa">Placa:</label>
				<input id="placa" type="text">	

				<label for="indicativo">Indictivo:</label>
				<input id="indicativo" type="text">				
				
				
			
			<div class="">

				<!-- <a id="btnBuscarCaso" class="ui-shadow ui-btn ui-corner-all ui-btn-inline">BUSCAR</a>
 -->
				

				<button id="btnBuscarCaso" class="ui-shadow ui-btn ui-btn-b ui-corner-all ui-mini" >Buscar</button>
				
			</div>
			
			
		</div>

			<div id="win" data-role="popup" data-position-to="window" 
				data-theme="a" data-overlay-theme="b" 
				data-dismissible="false">

		        <div data-role="header">
		          <a data-rel="back" class="ui-btn ui-btn-b ui-shadow ui-corner-all ui-icon-delete ui-btn-icon-notext">       
		          </a>
		          
		        </div>

		        <div role="main" class="ui-content">
		          <div id="msn">
		            
		          </div>
		         
		        </div>
		    </div> 
  	</div> 
			
