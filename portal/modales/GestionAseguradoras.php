    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalCrearAseguradora" role="dialog" >
    
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Creación de Aseguradoras</h4>
              </div>
              <div class="modal-body">
                <?php 
                    

                    include("forms/frmCrearAseguradora.php");

                 ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary" id="btnguardarAseguradora">Guardar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
    </div> 



        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalParametrosAseguradora" role="dialog" >
    
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Creación Parámetros de Aseguradora</h4>
              </div>
              <div class="modal-body">
                <?php 
                    

                    include("forms/tabParametrosAseguradora.php");

                 ?>
              </div>
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
    </div>



    
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalValorCaso" role="dialog" >
    
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Asignar Valor por Caso Aseguradora</h4>
              </div>
              <div class="modal-body">
               <?php
               include ("forms/frmValorCasoUnico.php");
               ?>
              </div>
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
    </div>


    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalValorCasoResultado" role="dialog" >
    
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Asignar Valores y parametros por Resultados</h4>
              </div>
              <div class="modal-body">
               <?php
               include ("forms/frmValorCasoResultado.php");
               ?>
              </div>
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalValorCasoZona" role="dialog" >
    
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Asignar Valores y parametros por Zona</h4>
              </div>
              <div class="modal-body">
                
              
               <?php
               include ("forms/frmValorCasoZona.php");
               ?>

              </div>
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
    </div>  


    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalValorCasoCiudad" role="dialog" >
    
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header alert-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Asignar Clinicas - Ciudades</h4>
              </div>
              <div class="modal-body">

               <?php
               include ("forms/frmAsignacionClinicaCiudadAmparo.php");
               ?>
                

                    

              </div>
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
    </div> 


    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalAsignarRangoValor" role="dialog" >
    
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header alert-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Asignar Rangos - Valores</h4>
              </div>
              <div class="modal-body">

               <?php
               include ("forms/frmAsignarRangosValoresAmpTaf.php");
               ?>
                

                    

              </div>
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
    </div> 