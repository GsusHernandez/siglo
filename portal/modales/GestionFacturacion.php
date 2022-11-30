
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="frmVisualizarFacturas" role="dialog" aria-labelledby="myModalLabel" >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header alert-primary">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" id="tituloFrmProcedimientos">Visualizar Facturas</h4>
                
            </div>
            <div class="modal-body">
                <?php
                include("forms/frmViewRangoFacturas.php");
                  ?>
            </div>
        </div>
      </div>
  </div>


<div class="modal fade" data-backdrop="static" data-keyboard="false" id="frmGenerarFacturas" role="dialog" aria-labelledby="myModalLabel" >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header alert-primary">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" id="tituloFrmProcedimientos">Generar Facturas</h4>
                
            </div>
            <div class="modal-body">
                <?php
                include("forms/frmGenerarFacturas.php");
                  ?>
            </div>
        </div>
      </div>
  </div>
    
  



  <div class="modal fade" data-backdrop="static" data-keyboard="false" id="frmModalFacturasGeneradas" role="dialog" aria-labelledby="myModalLabel" >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header alert-primary">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" id="tituloFrmProcedimientos">Facturas Generadas</h4>
                
            </div>
            <div class="modal-body">
                <?php
                include("forms/reportFacturasGeneradas.php");
                  ?>
            </div>
        </div>
      </div>
  </div>


  <div class="modal fade" data-backdrop="static" data-keyboard="false" id="FrmBusqFacturas" role="dialog" aria-labelledby="myModalLabel" >
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header alert-primary">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" id="tituloBusqProcedimientosRealizados">Buscar Facturas</h4>
                
            </div>
            <div class="modal-body">
                <?php
                include("forms/frmBusqFacturas.php");
                  ?>
            </div>
        </div>
      </div>
  </div>


    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="GestionPagosFacturas" role="dialog" aria-labelledby="myModalLabel" >
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header alert-primary">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" id="tituloFrmPagos">Gestion Pagos Facturas</h4>
                
            </div>
            <div class="modal-body">
                <?php
                include("forms/GestionPagosFacturas.php");
                  ?>
            </div>
        </div>
      </div>
  </div>