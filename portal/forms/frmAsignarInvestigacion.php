<form role="form" id="frmAsignarInvestigacion">
  <div class="box-body">
    <input type="hidden" id="idAseguradoraFrmAsignarInvestigacion">
    <div class="row" >
      <div class="form-group col-sm-6">
        <label for="">Tipo de Caso</label>
        <select id="tipoCasoFrmAsignarInvestigacion" class="form-control select2" style="width: 100%;">
        </select>
      </div>
      <div class="form-group col-sm-6">
        <label for="">Fecha de Entrega</label>
        <input readonly="readonly" type="text" class="form-control formFechas" id="fechaEntregaFrmAsignarInvestigacion" placeholder="Fecha de Entrega">
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label>Motivo Investigacion</label>
          <textarea class="form-control" rows="3" id="motivoInvestigacionFrmAsignarInvestigacion"></textarea>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Soporte</label>
          <input name="soporteFile" id="soporteFile" type="file" size="150" class="btn btn-block btn-success" required="">
        </div>
      </div>  
      <div id="asignacionValidacionIPS" style="display:none;">
        <div class="col-md-6">
          <div class="form-group">
            <label>Carta Presentacion</label>
            <input name="cartaPresentacionFile" id="cartaPresentacionFile" type="file" size="150" class="btn btn-block btn-success" required="">
          </div>
        </div>
      </div>
    </div>
    <input type="hidden" id="idCasoFrmAsignarInvestigacion">
    <input type="hidden" id="exeFrmAsignarInvestigacion">
  </div>
</form>