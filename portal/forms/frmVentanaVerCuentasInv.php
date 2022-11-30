<link rel="stylesheet" type="text/css" href="dist/css/contact-form.css">

<?php
global $con;

$sql = "SELECT a.id, a.id_investigador, CONCAT(a.numero, ' - ',CASE WHEN MONTH(a.periodo) = 1 THEN 'ENERO' WHEN MONTH(a.periodo) = 2 THEN 'FEBRERO' WHEN MONTH(a.periodo) = 3 THEN 'MARZO' WHEN MONTH(a.periodo) = 4 THEN 'ABRIL' WHEN MONTH(a.periodo) = 5 THEN 'MAYO' WHEN MONTH(a.periodo) = 6 THEN 'JUNIO' WHEN MONTH(a.periodo) = 7 THEN 'JULIO' WHEN MONTH(a.periodo) = 8 THEN 'AGOSTO' WHEN MONTH(a.periodo) = 9 THEN 'SEPTIEMBRE' WHEN MONTH(a.periodo) = 10 THEN 'OCTUBRE' WHEN MONTH(a.periodo) = 11 THEN 'NOVIEMBRE' WHEN MONTH(a.periodo) = 12 THEN 'DICIEMBRE' END, ' ', YEAR(a.periodo)) AS periodoA, a.periodo, a.numero, a.cantidad_investigaciones, a.valor_investigaciones, a.valor_viaticos, a.valor_adicional, a.valor_total, a.fecha_cerrada, a.estado FROM cuenta_cobro_investigador a WHERE a.id_investigador = ( SELECT i.id FROM investigadores i WHERE i.usuario_siglo = ".$_SESSION['id'].")";
?>

<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table id="tblVerCuentasCobro" class="table table-striped table-hover" cellspacing="0" width="100%">
				<thead style="background-color: #193456; color: white;">
					<tr>
						<th class="text-center">Periodo</th>
						<th class="text-center">Inv.</th>
						<th class="text-center">Valor Inv.</th>
						<th class="text-center">Viaticos</th>
						<th class="text-center">V. Adicional</th>
						<th class="text-center">Total</th>
						<th class="text-center">Estado</th>
						<th class="text-center">Opciones</th>
					</tr>
				</thead>
				<tbody>
					<?php
					mysqli_next_result($con);
					$misCuentas = mysqli_query($con, $sql);
					while($res = mysqli_fetch_assoc($misCuentas)){ ?>
					<tr class="text-center">
						<td><?=$res['periodoA']?></td>
						<td><?=$res['cantidad_investigaciones']?></td>
						<td>$ <?=number_format($res['valor_investigaciones'])?></td>
						<td>$ <?=number_format($res['valor_viaticos'])?></td>
						<td>$ <?=number_format($res['valor_adicional'])?></td>
						<td>$ <?=number_format($res['valor_total'])?></td>
						<td>
							<?php if($res['estado']==2){ ?>
							<small class="label bg-red">Cerrada</small>
							<?php }else{ ?>
							<small class="label bg-green">Abierta</small>	
							<?php } ?>
						</td>
						<td>
							<button class="btn" onclick="VerMiCuenta(<?=$res['id_investigador']?>,'<?=$res['periodo']?>',<?=$res['numero']?>)">
              	<i class="fa fa-eye"></i> Ver
            	</button>
          	</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="modal fade" id="modalMirarCuentaCobro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Mis Cuentas</h4>
      </div>
      <div class="modal-body">
        
      	<div id="encabezado" class="box box-warning box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">Datos Cuenta de Cobro</h3>
          </div>
          <div class="box-body">
            <div class="row invoice-info">
              <div class="col-sm-4 invoice-col">            
                  <b>Cuenta #<span id="numVerCuentaInv"></span></b><br>
                  <b>Estado:</b><small id="estVerCuentaInv" class="label bg-red parpadea"></small>
              </div>

              <div class="col-sm-4 invoice-col">
                  <strong>Nombre: </strong><span id="nomInvVerCuentaInv"></span><br>
                  <strong>Periodo: </strong><span id="perVerCuentaInv"></span>
              </div>

              <div class="col-sm-4 invoice-col">
                <b>Atender/Positivo:</b> <span id="canResultVerCuentaInv">/</span><br>
                <b>Cantidad:</b> <span id="cantidadVerCuentaInv"></span>
              </div>
            </div>
          </div>
        </div>

        <table id="tablaVerCasosInv" class=" table table-striped display table table-hover" cellspacing="0" width="100%">
          <thead style="background-color: #193456; color:#fff;">
          </thead>
          <tbody>
          </tbody>            
        </table>
        
        <div class="row">
          <div class="col-xs-6">
            <table class="table table-condensed">
              <thead>
                <tr>
                  <th>#</th><th>ASEGURADORA</th><th style="width: 40px">CANT</th>
                </tr>
              </thead>
              <tbody id="totalesAseguradoraVerCasosInv"></tbody>
            </table>
          </div>

          <div class="col-xs-6 pull-right">
            <div class="table-responsive">
              <table class="table">
                <tbody>
                  <tr>
                    <td colspan="2">
                      <b>Observación</b>
                      <p id="observacionVerCasosInv"></p></td>
                  </tr>
                  <tr>
                    <th style="width:50%">Subtotal:</th>
                    <td>$ <span id="subtotalVerCasosInv"></span></td>
                  </tr>
                  <tr>
                    <th>Viaticos:</th>
                    <td>$ <span id="viaticosVerCasosInv"></span></td>
                  </tr>
                  <tr>
                    <th>Adicional:</th>
                    <td>$ <span id="adicionalVerCasosInv"></span></td>
                  </tr>
                  <tr>
                    <th>Total:</th>
                    <td>$ <span id="totalVerCasosInv"></span></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>