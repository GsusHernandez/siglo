<!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li><a href="#tab_1" class="active" data-toggle="tab">Clínicas</a></li>
              <li><a href="#tab_2" data-toggle="tab">Amparos</a></li>
              <li><a href="#tab_3" data-toggle="tab">Motivos de Objeción</a></li>
              
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <?php 

                    include('frmAsignacionClinicaAseguradora.php');
                 ?>
                
                
              </div>

              <div class="tab-pane" id="tab_2">
                    <?php 

                    include('frmAsignacionAmparoAseguradora.php');
                 ?>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3" >
                 <?php 

                    include('frmAsignacionIndicadorAseguradora.php');
                 ?>
              </div>
              <!-- /.tab-pane -->
      
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->