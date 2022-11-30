  <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalCrearClinica" role="dialog" >
    
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Creación de Clinicas</h4>
              </div>
              <div class="modal-body">
                <?php 
                    

                    include("forms/frmCrearClinicas.php");

                 ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary" id="btnGuardarClinica">Guardar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
    </div> 




        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalAsignacionInvestigadorIps" role="dialog" >
    
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Asignar Investigador a IPS</h4>
              </div>
              <div class="modal-body">
                <?php 
                    

                    include("forms/frmAsignacionInvestigadorClinica.php");

                 ?>
              </div>
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
    </div>
