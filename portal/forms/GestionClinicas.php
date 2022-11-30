<div class="row">
  <div class="col-md-12">
    <div class="box box-solid box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Gestión Clínicas</h3>
      </div>
      <div class="box-body">
        <div class="col-sm-2">
          <a class="btn btn-block btn-primary"  id="BtnAddClinica">
            <i class="glyphicon glyphicon-plus"></i>
          </a>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            <input type="text" class="form-control" id="nombreBuscarClinica" placeholder="nombre Clínica">
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            <input type="text" class="form-control" id="identificacionBuscarClinica" placeholder="Identificación Clínica">
          </div>
        </div>
        <div class="col-sm-2">
          <a class="btn btn-block btn-primary"  id="BtnBuscarClinica"><i class="glyphicon glyphicon-search"></i></a>
        </div>
        <br><br>
        <div id="DivTablaGestionClinica" style="display: none;">
          <div id="DivTablas2">
            <table id="tablaGestionClinicas" class="display" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th style="width:350px;" width="350px">Nombre</th>
                  <th style="width:350px;" width="350px">Identificacion</th>
                  <th style="width:350px;" width="350px">Ciudad</th>
                  <th style="width:300px;" width="300px">Opciones</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>