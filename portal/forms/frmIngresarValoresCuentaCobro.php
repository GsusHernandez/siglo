    <?php
      include('conexion/conexion.php');
  
global $con;  
    ?>
   <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li><a href="#tabValoresGenerales" class="active" data-toggle="tab">General</a></li>
              <li><a href="#tabValoresInvestigaciones" data-toggle="tab">Investigaciones</a></li>
              
              
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tabValoresGenerales">
                
 <form role="form" id="frmSeleccAsignarAnalista">
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
      

        <div class="col-md-6">
          <div class="form-group">
            <label for="exampleInputEmail1">Valor Biaticos</label>
            <input type="text" class="form-control CamNum" id="valorBiaticoFrmCuentaCobro" placeholder="Valor Viaticos">
              
          </div>
        </div>


       <div class="col-md-6">
          <div class="form-group">
            <label for="exampleInputEmail1">Valor Adicional</label>
              <input type="text" class="form-control CamNum" id="valorAdicionalFrmCuentaCobro" placeholder="Valor Adicional">
          </div>
        </div>


        <div class="col-md-12">
          <div class="form-group">
            <label for="exampleInputEmail1">Observaciones</label>
              <textarea type="text" class="form-control CampText" id="observacionesFrmCuentaCobro"></textarea>
          </div>
        </div>
      </div>
    </div>

           
                <div class="col-md-6">
                        <div class="form-group">
                          
                          <input id="idCasoSoatInvestigadorCuentaCobro" type="hidden">
                          

                        </div>
                    </div>
                
              <!-- /.box-body -->

              </div>
          
            
            </form>
                
                
              </div>

              <div class="tab-pane" id="tabValoresInvestigaciones">
                           <div id="divTablaIngresarValorCasosCuentaCobro">
                    <div id="DivTablasIngresarValorCasosCuentaCobro">
                <table id="tablaIngresarValorCasosCuentaCobro" class="display" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th style="width:400px;" width="200px">Aseguradora - Tipo Caso</th>
                          <th style="width:400px;" width="200px">Cantidad</th>
                          <th style="width:400px;" width="200px">Valor Unitario</th>
                          <th style="width:400px;" width="200px">Valor Total</th>
                          <th style="width:400px;" width="200px">Id Aseguradora</th>
                          <th style="width:400px;" width="200px">Id TipoCaso</th>
                          <th style="width:400px;" width="200px">Id Resultado</th>
                          <th style="width:400px;" width="200px">Id Tipo Zona</th>
                          <th style="width:400px;" width="200px">Id Tipo Auditoria</th>

                          

                          
                        </tr>
                      </thead>
                 
                    </table>
                    </div>
                    </div>

          
              </div>
              <!-- /.tab-pane -->
       
              <!-- /.tab-pane -->
      
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>

            <!-- /.box-header -->
      