<form role="form" id="FrmBeneficiariosCasoSOAT">
  <div class="box-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Parentesco</label>
          <input type="text" class="form-control CampText" id="parentescoBeneficiarioFrm" placeholder="Parentesco">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Identificación</label>
          <input type="text" class="form-control" id="identificacionBeneficiarioFrm" placeholder="Identificacion Beneficiario">
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          <label>Beneficiario</label>
          <input type="text" name="0" readonly="" class="form-control" id="descripcionBeneficiarioFrm" placeholder="NO HA SELECCIONADO BENEFICIARIO">
        </div>
      </div>
    </div>
    <input type="hidden" id="idRegistroInvestigacionBeneficiarioSOAT">                         
    <input type="hidden" id="idPersonaBeneficiario">                         
    <input type="hidden" id="exeBeneficiario">   
  </div>
</form>