<form role="form" id="FrmPersonasCasoSOAT">
  <div class="box-body">
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label for="exampleInputEmail1">Informacion Victima</label>
          <a class="btn  btn-primary" id="btnSeleccionarVictima">Seleccionar Victima</a>
        </div>
      </div>
      <div class="col-md-8">
        <div class="form-group">
          <label for="exampleInputEmail1">&nbsp;</label>
          <input type="text" name="0" readonly="" class="form-control" id="descripcionVictimaPersonaFrm" placeholder="NO HA SELECCIONADO NINGUNA VICTIMA">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label for="exampleInputEmail1">Inform. Reclamante</label>
          <input type="text" class="form-control" id="identificacionReclamantePersonaFrm" placeholder="Identificacion Reclamante">
        </div>
      </div>
      <div class="col-md-8">
        <div class="form-group">
          <label for="exampleInputEmail1">&nbsp;</label>
          <input type="text" name="0" readonly="" class="form-control" id="descripcionReclamantePersonaFrm" placeholder="NO HA SELECCIONADO NINGUN RECLAMANTE">
        </div>
      </div>
    </div> 
    <a class="btn  btn-primary" id="btnAgregarBeneficiarios">AGREGAR BENEFICIARIO</a><br><br> 
    <div class="row">
      <div class="col-md-12">
        <div id="DivTablas21">
          <table id="tablaGestionBeneficiarios" class="display" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th style="width:350px;" width="350px">Nombre</th>
                <th style="width:350px;" width="350px">Identificacion</th>
                <th style="width:350px;" width="350px">Parentesco</th>
                <th style="width:350px;" width="350px">Opciones</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="box-footer">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <input type="hidden" id="idRegistroInvestigacionPersonasSOAT">
        </div>
      </div>
    </div>
  </div>
</form>