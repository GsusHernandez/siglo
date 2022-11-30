<div class="row">
  <div class="col-md-12">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a id="li-FacturasMasivasAseguradoras" href="#FacturasMasivasAseguradoras" data-toggle="tab">Generar Facturas Masivas</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="FacturasMasivasAseguradoras">
          <div class="box-body">
            <div class="col-md-6 col-md-offset-3">
              <div class="form-group">
                <label for="exampleInputPassword1">Aseguradora</label>
                <select id="idAseguradoraFacturaRangoFecha" class="form-control select2" style="width: 100%;">
                  <option value="0">SELECCIONE UN VALOR</option>
                  <?php 
                  mysqli_next_result($con);
                  $verAmparo =mysqli_query($con,"CALL manejoAseguradoras(6,'','','','','','','','','','','','',@resp)");
                  while($resul = mysqli_fetch_assoc($verAmparo)){
                    ?>
                    <option value="<?php echo $resul['id']; ?>">
                      <?php echo $resul['nombre_aseguradora']; ?>               
                    </option>
                    <?php 
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-md-6 col-md-offset-3">
              <div class="form-group">
                <label for="exampleInputPassword1">Tipo Caso</label>
                <select id="tipoCasoFacturaRangoFecha" class="form-control select2" style="width: 100%;">
                </select>
              </div>
            </div>
            <div class="col-md-3 col-md-offset-3">
              <div class="form-group">
                <label for="exampleInput">Fecha Inicio</label>
                <input readonly="readonly" type="text" class="form-control formFechas" id="fechaInicioFacturaRangoFecha" placeholder="Fecha Inicio">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="exampleInput">Fecha Fin</label>
                <input readonly="readonly" type="text" class="form-control formFechas" id="fechaFinFacturaRangoFecha" placeholder="Fecha Fin">
              </div>
            </div>
            <div class="col-md-3 col-md-offset-3">
              <div class="form-group">
                <label for="exampleInput">Año Factura</label>
                <select id="anoFacturaRangoFecha" class="form-control select2" style="width: 100%;">
                  <option value="0">SELECCIONE UN VALOR</option>
                  <?php 
                  mysqli_next_result($con);
                  $verAno =mysqli_query($con,"CALL consultasBasicas(28)");
                  while($resul = mysqli_fetch_assoc($verAno)){
                    ?>
                    <option value="<?php echo $resul['id']; ?>">
                      <?php echo $resul['descripcion']; ?>               
                    </option>
                    <?php 
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="exampleInput">Mes Factura</label>
                <select id="mesFacturaRangoFecha" class="form-control select2" style="width: 100%;">
                  <option value="0">SELECCIONE UN VALOR</option>
                  <?php 
                  mysqli_next_result($con);
                  $verMes =mysqli_query($con,"CALL consultasBasicas(27)");
                  while($resul = mysqli_fetch_assoc($verMes)){
                    ?>
                    <option value="<?php echo $resul['id']; ?>">
                      <?php echo $resul['descripcion']; ?>               
                    </option>
                    <?php 
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
      <a class="btn btn-success btn-block" id="btnGenerarFacturas">Generar Facturas</a>
      <input type="hidden" id="exeTabFactura" value="GenerarFacturaVentaMasivaAseguradora">
    </div>
  </div>
</div>