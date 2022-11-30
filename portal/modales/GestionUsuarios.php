<div class="modal fade" data-backdrop="static" data-keyboard="false" id="FrmUsuarios" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Creación de Usuarios</h4>
      </div>
      <div class="modal-body">
        <?php include("forms/frmUsers.php"); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
        <button class="btn btn-primary" id="btnSubmitFrmUsuarios">Guardar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div> 

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalOpcionesUsuarios" role="dialog" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Asignar Opciones a Usuarios</h4>
      </div>
      <div class="modal-body">
        <?php include("forms/frmOpcionesUsuarios.php"); ?>
      </div>     
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div> 