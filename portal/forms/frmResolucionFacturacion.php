<form role="form" id="FrmResolucionFacturacion">
  <div class="box-body">
    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputPassword1">Numero De Resolucion</label>
        <input type="text" class="form-control CamNum" id="numResResolucionFrm" placeholder="Numero Resolucion">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputPassword1">Fecha Inicio Vigencia</label>
        <input type="text" readonly="readonly" class="form-control formFechas CamNum" id="fechaInicialResolucionFrm" placeholder="Fecha Resolucion">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputPassword1">Numero Inicial</label>
        <input type="text" class="form-control CamNum" id="numInicialResolucionFrm" placeholder="Numero Inicial">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputPassword1">Numero Final</label>
        <input type="text" class="form-control CamNum" id="numFinalResolucionFrm" placeholder="Numero Final">
      </div>
    </div>
  </div>
  <div class="box-footer">
    <div class="col-md-6">
      <div class="form-group">
        <a id="btnSubmitFrmResoluciones" class="btn btn-primary">Submit</a>
        <input type="hidden" id="exeFrmResoluciones">
        <input type="hidden" id="idRegistroFrmResoluciones">
      </div>
    </div>
  </div>
</form>