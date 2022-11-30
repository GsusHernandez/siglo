    <?php
      include('conexion/conexion.php');
  
global $con;  
    ?>

<div class="box-body">
  <form role="form" id="FrmPeriodoCuentaCobro">
    <div class="box-body">

      <div class="col-sm-6">
        <div class="form-group">
          <label for="exampleInputPassword1">Descripcion</label>
          <input type="text" class="form-control CampText" id="descripcionPeriodoCuentaCobroFrm" placeholder="Descripcion">
        </div>
      </div>
   

      <div class="col-md-6 form-group">
        <a id="btnSubmitFrmPeriodosCuentaCobroInvestigadores" class="btn btn-primary">Guardar</a>
        <input type="hidden" id="exeFrmPeriodosCuentaCobroInvestigadores" value='registrarPeriodosCuentaCobroInvestigadores'>
        <input type="hidden" id="idRegistroFrmPeriodosCuentaCobroInvestigadores">                        
      </div>

      <div id="divTablaPeriodosCuentaCobro">
        <div id="DivTablasPeriodoCuentaCobro">
          <table id="tablaPeriodosCuentaCobro" class="display" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th style="width:400px;" width="200px">Descripcion</th>
                <th style="width:400px;" width="200px">Opciones</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </form>
</div>




              
            
            <!-- /.box-body -->

    
    
