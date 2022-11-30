<?php
  $dia = date("Y-m-d");
  //$dia = "2020-01-16";
  $cuota = 9;
  $cuotaGen = 135;

  if(date("l") == "Saturday"){
    $cuota=6;
    $cuotaGen = 90;
  }

  mysqli_next_result($con);
  $totalInfo = 0;
  $totalPorI = 0;
  $arrayAnalistas = array();
  $cant= 0;

  /*$consultaCasosAnalista =mysqli_query($con,"SELECT a.id_usuario, a.id, a.codigo, d.placa, e.fecha_accidente, CONCAT(c.nombres, ' ', c.apellidos) AS analista, b.nombre_aseguradora AS aseguradora, a.fecha_inicio, a.fecha_entrega, a.fecha_cargue
FROM investigaciones a
LEFT JOIN aseguradoras b ON a.id_aseguradora = b.id
LEFT JOIN detalle_investigaciones_soat e ON e.id_investigacion = a.id
LEFT JOIN asignar_censo_analista_temp d ON d.id_investigacion = a.id
LEFT JOIN usuarios c ON c.id = a.id_usuario
WHERE a.id_usuario!=56 ORDER BY a.id_aseguradora DESC, a.id ASC");

  if($consultaCasosAnalista){
    if (mysqli_num_rows($consultaCasosAnalista)>0){
      $row = 0;
      while($rowAnalista = mysqli_fetch_assoc($consultaCasosAnalista)){
        
        $row = $rowAnalista["id"];
        $arrayAnalistas[$row]["id_usuario"] = $rowAnalista["id_usuario"];
        $arrayAnalistas[$row]["codigo"] = $rowAnalista["codigo"];
        $arrayAnalistas[$row]["placa"] = $rowAnalista["placa"];
        $arrayAnalistas[$row]["aseguradora"] = $rowAnalista["aseguradora"];
        $arrayAnalistas[$row]["analista"] = $rowAnalista["analista"];
        $arrayAnalistas[$row]["fecha_accidente"] = $rowAnalista["fecha_accidente"];
        $arrayAnalistas[$row]["fecha_inicio"] = $rowAnalista["fecha_inicio"];
        $arrayAnalistas[$row]["fecha_entrega"] = $rowAnalista["fecha_entrega"];
        $arrayAnalistas[$row]["fecha_cargue"] = $rowAnalista["fecha_cargue"];
        $cant++;
      }
    }
  }*/
?>
<link rel="stylesheet" type="text/css" href="dist/css/contact-form.css">

<div class="row">
  <div class="col-md-12">
    <div class="box box-solid ">
      <div class="box-body">
        <div class="item-wrap">
          <form id="formConsultaPendAnalistas" data-toggle="validator" class="popup-form contactForm">
            <div class="row"> 
              <div class="col-md-3 col-sm-12 col-12">
                <label for="">Aseguradora</label>
                <div class="form-group">
                  <div class="help-block with-errors"></div>
                  <select name="aseguradoraCensoAnalista" id="aseguradoraCensoAnalista" class="form-control">
                    <option value="">TODAS</option>
                    <?php 
                    mysqli_next_result($con);
                    $verAmparo =mysqli_query($con,"SELECT * FROM aseguradoras WHERE vigente='s';");
                    while($resul = mysqli_fetch_assoc($verAmparo)){ ?>
                      <option value="<?=$resul['id']; ?>"><?=$resul['nombre_aseguradora']; ?></option>
                      <?php 
                    } ?>
                  </select>
                  <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                </div>
              </div>

              <div class="col-md-2 col-sm-12 col-12">
                <label for="">Tipo Caso</label>
                <div class="form-group">
                  <div class="help-block with-errors"></div>
                  <select name="tipoCasoCensoAnalista" id="tipoCasoCensoAnalista" class="form-control">
                    <option value="">TODOS</option>
                  </select>
                  <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                </div>
              </div>

              <div class="col-md-3 col-sm-12 col-12">
                <label for="">Analista</label>
                <div class="form-group">
                  <div class="help-block with-errors"></div>
                  <select name="analistaCensoAnalista" id="analistaCensoAnalista" class="form-control">
                    <option value="">TODOS</option>
                    <?php 
                    mysqli_next_result($con);
                    $verAmparo =mysqli_query($con,"SELECT id, CONCAT(nombres, ' ', apellidos) AS nombre FROM usuarios WHERE id not in(56, 500) AND vigente='s' AND empleado='s' AND tipo_usuario NOT IN(4,5)  ORDER BY CONCAT(nombres, ' ', apellidos);");
                    while($resul = mysqli_fetch_assoc($verAmparo)){ ?>
                      <option value="<?=$resul['id']; ?>"><?=trim($resul['nombre']); ?></option>
                      <?php 
                    } ?>
                  </select>
                  <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                </div>
              </div>

              <div class="col-md-3 col-sm-12 col-12">
                <label for="">F. Cargue</label>
                <div class="form-group">
                  <div class="help-block with-errors"></div>
                  <input type="date" name="fCargueCensoAnalista" id="fCargueCensoAnalista" class="form-control">
                  <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                </div>
              </div>

              <div class="col-md-1 col-sm-12 col-12">                            
                <label for="">.</label>
                <div class="form-group last">
                  <button type="submit" id="btnReportePndteAnlista" class="btn btn-custom"><i class="fa fa-search"></i> VER</button>
                </div>
              </div>
            </div>
          </form>
        </div>
        <table id="tablaCasosPendAnalistas" class="table table-striped display table table-hover" cellspacing="0" width="100%">
          <thead style="background-color: #f39c12; color: white;">
          </thead>
          <tbody>
          </tbody>            
        </table>
      </div>
    </div>
  </div>
</div>