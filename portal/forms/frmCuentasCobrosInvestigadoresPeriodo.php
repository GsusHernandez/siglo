<?php
include('conexion/conexion.php');

global $con; ?>
<div class="box-body">
  <div id="divTablaInvestigadoresCuentaCobroPeriodo">
    <div id="DivTablasInvestigadoresCuentaCobroPeriodo">
      <table id="tablaInvestigadoresCuentaCobroPeriodo" class="display" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th style="width:400px;" width="200px">Investigador</th>
            <th style="width:400px;" width="200px">Identificacion</th>
            <th style="width:400px;" width="200px">Cantidad Inv.</th>
            <th style="width:400px;" width="200px">Valor Inv.</th>
            <th style="width:400px;" width="200px">Valor Biaticos</th>
            <th style="width:400px;" width="200px">Valor Adicionales</th>
            <th style="width:400px;" width="200px">Valor Total</th>
            <th style="width:400px;" width="200px">Opciones</th>
          </tr>
        </thead>
      </table>
    </div>
    <input type="hidden" id="idPeriodoCuentaCobro">
  </div></div>