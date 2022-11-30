<div class="row">
  <!-- left column -->
  <div class="col-md-12">

    <div class="box box-solid box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Gestion Usuarios</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <div class="box-body">

        <div class="col-sm-2">
          <a class="btn btn-block btn-primary"  id="BtnAddUsuarios">
            <i class="glyphicon glyphicon-plus"></i>
          </a>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            <input type="text" class="form-control" id="userUsuarioBuscar" placeholder="Usuario">
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            <input type="text" class="form-control" id="nombreUsuarioBuscar" placeholder="Nombre">
          </div>
        </div>

        <div class="col-sm-2">
          <a class="btn btn-block btn-primary"  id="BtnBuscarUsuarios"><i class="glyphicon glyphicon-search"></i></a>
        </div>


        <br><br>
        <div id="DivTablaGestionUsuario" style="display: none;">
          <div id="DivTablas3">
            <table id="tablaGestionUsuarios" class="display" cellspacing="0" width="90%">
              <thead>
                <tr>
                  <th style="width:350px;" width="350px">Nombre</th>
                  <th style="width:350px;" width="350px">Usuario</th>                        
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