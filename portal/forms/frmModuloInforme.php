<div class="container-fluit">
	<aside class="col-xs-5 col-sm-3" style="background-color:#222d32; z-index: 2; height: 650px;">
		<div id="divModulosGestionar">
			<section class="" style="width:100%;">
				<ul class="" >
					<li class="menu" id="liModuloGestionarLesionados" style="display: none;"><a id="btnModuloGestionarLesionados" data-togle="tab" aria-expanded="false">LESIONADOS</a></li>
					<li class="menu" id="liModuloGestionarPersonas" style="display: none;"><a id="btnModuloGestionarPersonas" data-togle="tab" aria-expanded="false">PERSONAS</a></li>
					<li class="menu" id="liModuloGestionarVehiculo" style="display: none;"><a id="btnModuloGestionarVehiculo" data-togle="tab" aria-expanded="false">VEHICULO</a></li>
					<li class="menu" id="liModuloGestionarInforme" style="display: none;"><a id="btnModuloGestionarInforme" data-togle="tab" aria-expanded="false">INFORME</a></li>
					<li class="menu" id="liModuloGestionarInformeMuerte" style="display: none;"><a id="btnModuloGestionarInformeMuerte" data-togle="tab" aria-expanded="false">INFORME</a></li>
					<li class="menu" id="liModuloGestionarRepresentanteLegal" style="display: none;"><a id="btnModuloGestionarRepresentanteLegal" data-togle="tab" aria-expanded="false">REPRESENTANTE LEGAL</a></li>
					<li class="menu" id="liModuloGestionarDiligenciaFormato" style="display: none;"><a id="btnModuloGestionarDiligenciaFormato" data-togle="tab" aria-expanded="false">DILIGENCIA FORMATO</a></li>
					<li class="menu" id="liModuloGestionarTestigos" style="display: none;"><a id="btnModuloGestionarTestigos" data-togle="tab" aria-expanded="false">TESTIGOS</a></li>
					<li class="menu" id="liModuloGestionarObservaciones" style="display: none;"><a id="btnModuloGestionarObservaciones" data-togle="tab" aria-expanded="false">OBSERVACIONES</a></li>
					<li class="menu" id="liModuloGestionarMultimedia" style="display: none;"><a id="btnModuloGestionarMultimedia" data-togle="tab" aria-expanded="false">MULTIMEDIA</a></li>
					<li class="menu" id="liDescargarInformeWord" style="display: none;"><a id="btnDescargarInformeWord" data-togle="tab" aria-expanded="false">DESCARGAR</a></li>
				</ul>
				<div class="text-center">
					<ul>
					<li class="menu">
					<div class='btn-group'>
					<button type='button' class='btn btn-default' name='".$resPolizas["id_poliza"]."' id=''>PDF</button>
			        <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resPolizas["id_poliza"]."'><span class='caret'></span>
			        <span class='sr-only'>Toggle Dropdown</span>
			        </button>
			        <ul class='dropdown-menu' id='menuInformeFinal' role='menu'>
			        
			        	<li><input type="file" id="fileInformeFinal" accept=".pdf" style="width:100%;"/></li>			     
                      	<li class='divider divDeshabilitarInformeFinal'></li>
                      	<li><a target="_blank" class="divDeshabilitarInformeFinal" id='btnDescargarInformeFinalInvestigacion'>Ver Informe</a></li>
                      	<li class='divider divDeshabilitarInformeFinal'></li>
				        <li><a class="divDeshabilitarInformeFinal" id='btnDeshabilitarInformeFinalInvestigacion'>Eliminar</a></li>
				    </ul>
					</div>
				    </li>
			    	</ul>
			    </div>
			    <div class="text-center">
			    	<ul>
						<li class="menu">
							<div class='btn-group'>
								<button type='button' class='btn btn-default' name='".$resPolizas["id_poliza"]."' id=''>PDF 2</button>
								<button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resPolizas["id_poliza"]."'>
									<span class='caret'></span>
									<span class='sr-only'>Toggle Dropdown</span>
								</button>
								<ul class='dropdown-menu' id='menuInformeFinal2' role='menu'>
									<li><input type="file" id="fileInformeFinal2" accept=".pdf" style="width:100%;"/></li>
						        	<li class='divider divDeshabilitarInformeFinal2'></li>
			                      	<li><a target="_blank" class="divDeshabilitarInformeFinal2" id='btnDescargarInformeFinalInvestigacion2'>Ver Informe</a></li>
			                      	<li class='divider divDeshabilitarInformeFinal2'></li>
							        <li><a class="divDeshabilitarInformeFinal2" id='btnDeshabilitarInformeFinalInvestigacion2'>Eliminar</a></li>
							    </ul>
							</div>
					    </li>
			    	</ul>
			    </div>

				<div id="archivosAnexosInvestigaciones" style="display:none;">
					<div class="text-center">
						<ul>
							<li>
								<div class='btn-group'>
								<button type='button' class='btn btn-default' name='".$resPolizas["id_poliza"]."' id=''>
								  ANEXOS
								</button>

						        <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resPolizas["id_poliza"]."'><span class='caret'></span>
						        <span class='sr-only'>Toggle Dropdown</span>
						        </button>

						        <ul class='dropdown-menu' id='menuInformeFinal' role='menu'>
						        	<div id="divDescargarSoporteInvestigacion">
							        	<li>
							        		<a  target="_blank" id='btnDescargarSoporteInvestigacion'>Soporte</a>
							        	</li>
							        </div>
							        <div id="divDivisorAnexosInvestigacion">
				                    	
				                      	<div id="divDescargarCartaPresentacionInvestigacion">
				                      		<li class>
				                      			<a  target="_blank" id='btnDescargarCartaPresentacionInvestigacion'>
				                      				Carta Presentacion
				                      			</a>
				                      		</li>
				                      	</div>
				                    </div>			                 	
							    </ul>
							</li>
					    </ul>
					</div>
				</div>

				<ul class="" >
					<li class="menu" id="liTerminarPlanillarCaso" style="display: none;"><a id="btnTerminarPlanillarCaso" data-togle="tab" aria-expanded="false">PLANILLAR/TERMINAR</a></li>
					<li class="menu" id="liEstadosInvestigacion" style="display: none;"><a id="btnEstadosInvestigacion" data-togle="tab" aria-expanded="false">ESTADOS</a></li>
				</ul>
			</section>
		</div>
	</aside>
	<div class="col-xs-7 col-sm-9" >
		<div  id="ModuloGestionarDiligenciaFormato" style="display:none;" class="tab-pane" style="width: 100%;z-index: 1;">
			<?php include('forms/frmModuloGestionarDiligenciaFormato.php'); ?>
		</div>
		<div  id="ModuloGestionarTestigos" style="display:none;" class="tab-pane" style="width: 100%;z-index: 1;">
			<?php include('forms/frmModuloGestionarTestigos.php'); ?>
		</div>
		<div  id="ModuloGestionarObservaciones" style="display:none;" class="tab-pane" style="width: 100%;z-index: 1;">
			<?php include('forms/frmModuloGestionarObservaciones.php'); ?>
		</div>
		<div  id="ModuloGestionarLesionados" style="display:none;" class="tab-pane" style="width: 100%;z-index: 1;">
			<?php include('forms/frmModuloGestionarLesionados.php'); ?>
		</div>
		<div  id="ModuloGestionarVehiculo" style="display:none;" class="tab-pane" style="width: 100%;z-index: 1;">
			<?php include('forms/frmModuloGestionarVehiculos.php'); ?>
		</div>
		<div  id="ModuloGestionarInforme" style="display:none;" class="tab-pane" style="width: 100%;z-index: 1;">
			<?php include('forms/frmModuloGestionarInforme.php'); ?>
		</div>
		<div  id="ModuloGestionarMultimedia" style="display:none;" class="tab-pane" style="width: 100%;z-index: 1;">
			<?php include('forms/frmModuloGestionarMultimedia.php'); ?>
		</div>
		<div  id="ModuloGestionarPersonas" style="display:none;" class="tab-pane" style="width: 100%;z-index: 1;">
			<?php include('forms/frmModuloGestionarPersonas.php'); ?>
		</div>
		<div  id="ModuloGestionarInformeMuerte" style="display:none;" class="tab-pane" style="width: 100%;z-index: 1;">
			<?php include('forms/frmModuloGestionarInformeMuerte.php'); ?>
		</div>
		<div  id="ModuloGestionarRepresentanteLegal" style="display:none;" class="tab-pane" style="width: 100%;z-index: 1;">
			<?php include('forms/frmModuloGestionarRepresentanteLegal.php'); ?>
		</div>
		<div  id="ModuloEstadosInvestigacion" style="display:none;" class="tab-pane" style="width: 100%;z-index: 1;">
			<?php include('forms/frmModuloEstadosInvestigacion.php'); ?>
		</div>
	</div>
</div>

