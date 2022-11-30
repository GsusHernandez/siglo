<?php
  if(isset($_GET["fInicio"]) && isset($_GET['fFin'])){
    $fInicio = $_GET["fInicio"];
    $fFin = $_GET['fFin'];
  }else{
    $fInicio = date("Y-m-d");
    $fFin = $fInicio;
  }

  //$dia = "2020-01-16";
  $cuota = 9;
  $cuotaGen = 135;

  if(date("l") == "Saturday"){
    $cuota=6;
    $cuotaGen = 90;
  }

  mysqli_next_result($con);

  $totalPlan = 0;
  $totalInfo = 0;
  $totalGene = 0;
  $totalPorP = 0;
  $totalPorI = 0;
  $totalPorG = 0;

  $consultaCasosAnalista =mysqli_query($con,"WITH cte AS (SELECT ei.usuario, 'INFORME' AS origen, CONCAT(u.nombres, ' ', u.apellidos) AS analista, COUNT(i.id) AS cant
    FROM investigaciones i
    LEFT JOIN estado_investigaciones ei ON i.id=ei.id_investigacion
    LEFT JOIN usuarios u ON u.id = ei.usuario
    WHERE ei.estado=11 AND DATE_FORMAT(ei.fecha, '%Y-%m-%d') BETWEEN '$fInicio' AND '$fFin'
    GROUP BY ei.usuario 
    UNION
    SELECT ei.usuario, 'PLANILLADO' AS origen, CONCAT(u.nombres, ' ', u.apellidos) AS analista, COUNT(i.id) AS cant
    FROM investigaciones i 
    LEFT JOIN estado_investigaciones ei ON ei.id_investigacion = i.id  AND ei.estado = 19
    LEFT JOIN usuarios u ON u.id = ei.usuario 
    WHERE DATE_FORMAT(ei.fecha, '%Y-%m-%d') BETWEEN '$fInicio' AND '$fFin' AND ei.inicial = 's' AND i.id NOT IN (SELECT ei1.id_investigacion FROM estado_investigaciones ei1  WHERE DATE_FORMAT(ei1.fecha, '%Y-%m-%d') BETWEEN '$fInicio' AND '$fFin' AND ei1.estado = 11 ) GROUP BY ei.usuario)
    SELECT *
    FROM cte
    ORDER BY analista;");

  $arrayAnalistas = array();

  if (mysqli_num_rows($consultaCasosAnalista)>0){
    $row = 0;
    while($rowAnalista = mysqli_fetch_assoc($consultaCasosAnalista)){

      $color = "progress-bar-red";
      $porcentaje = 0;
      $cant = $rowAnalista["cant"];
      $row = $rowAnalista["usuario"];

      $arrayAnalistas[$row]["analista"] = $rowAnalista["analista"];
      $arrayAnalistas[$row]["id"] = $rowAnalista["usuario"];
      $porcentaje = $cant*100/$cuota;

      if($porcentaje > 60 && $porcentaje < 99){ $color = "progress-bar-yellow"; }
      elseif($porcentaje == 100){ $color = "progress-bar-green"; }
      elseif($porcentaje > 100){ $color = "bg-light-blue color-palette"; $porcentaje = 100; }

      if($rowAnalista["origen"] == "PLANILLADO"){
        $arrayAnalistas[$row]["planillado"] = $cant;
        $totalPlan += $cant;
      }else{
        $porcentaje = $cant*100/$cuota;
        if($porcentaje > 60 && $porcentaje < 99){ $color = "progress-bar-yellow"; }
        elseif($porcentaje == 100){ $color = "progress-bar-green"; }
        elseif($porcentaje > 100){ $color = "bg-light-blue color-palette"; $porcentaje = 100; }

        $arrayAnalistas[$row]["informe"] = $cant;
        $arrayAnalistas[$row]["colorInforme"] = $color;
        $arrayAnalistas[$row]["porcentInforme"] = $porcentaje;
        $totalInfo += $cant;
      }
    }

    if($totalPlan > 3){
      $totalGene = ceil($totalPlan/3) + $totalInfo;
    }else{
      $totalGene = $totalInfo;
    }

    $totalPorP = $totalPlan*100/$cuotaGen;
    $totalPorI = $totalInfo*100/$cuotaGen;
    $totalPorG = $totalGene*100/$cuotaGen;
  }
?>
<link rel="stylesheet" type="text/css" href="dist/css/contact-form.css">
<div class="box-body">
  <!--FORMULARIO RANGO DE FECHAS-->
  <div class="row">
    <div class="col-md-6">
      <div class="box box-solid ">
        <div class="box-body">
          <div class="item-wrap">
            <form id="formCuotaAnalista" data-toggle="validator" class="popup-form contactForm">
              <div class="row">
                <div class="col-md-4 col-sm-12 col-12">
                  <label for="">Fecha Inicio</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <input type="date" name="fInicio" id="fInicio" class="form-control" value="<?=$fInicio?>">
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                  </div>
                </div>
                <div class="col-md-4 col-sm-12 col-12">
                  <label for="">Fecha Fin</label>
                  <div class="form-group">
                    <div class="help-block with-errors"></div>
                    <input type="date" name="fFin" id="fFin" class="form-control" value="<?=$fFin?>">
                    <div class="input-group-icon"><i class="fa fa-file-excel-o"></i></div> 
                  </div>
                </div>

                <div class="col-md-3 col-sm-12 col-12">                            
                  <label for="" class="hidden-xs">.</label>
                  <div class="form-group last">
                    <button type="submit" id="btnConsultarCuotaAnalista" class="btn btn-custom btn-block"><i class="fa fa-search"></i> VER</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box bg-navy">
        <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">CUOTA DIARIA</span>
          <span class="info-box-number"><?=$totalGene?>/<?=$cuotaGen?></span>

          <div class="progress">
            <div class="progress-bar" style="width: <?=$totalPorG?>0%"></div>
          </div>
              <span class="progress-description">
                <?=intval($totalPorG)?>% Logrado
              </span>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box bg-yellow" style="background-color: #decd00 !important;">
        <span class="info-box-icon"><i class="fa  fa-list"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">PLANILLADOS</span>
          <span class="info-box-number"><?=$totalPlan?>/<?=$cuotaGen?></span>

          <div class="progress">
            <div class="progress-bar" style="width: <?=$totalPorP?>%"></div>
          </div>
              <span class="progress-description">
                <?=intval($totalPorP)?>% Logrado
              </span>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box bg-red" style="background-color: #bb1500 !important;">
        <span class="info-box-icon"><i class="fa fa-file-pdf-o"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">INFORMES</span>
          <span class="info-box-number"><?=$totalInfo?>/<?=$cuotaGen?></span>

          <div class="progress">
            <div class="progress-bar" style="width: <?=$totalPorI?>%"></div>
          </div>
              <span class="progress-description">
                <?=intval($totalPorI)?>% Logrado
              </span>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box bg-green" style="background-color: #50ad82 !important;">
        <span class="info-box-icon"><i class="fa fa-user-plus"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">A. EFICIENTE</span>
          <span class="info-box-number">0</span>

          <div class="progress">
            <div class="progress-bar" style="width: 100%"></div>
          </div>
              <span class="progress-description">
                100% CON MÁS CASOS
              </span>
        </div>
      </div>
    </div>
  </div>
  <table id="tabla_asistencias" class="table table-bordered table-condensed table-hover responsive box" cellspacing="0" width="100%">
      <thead  style="background-color: #3c8dbc; color: #fff; font-weight: bold;">
        <tr>
          <th class="text-center">#</th>
          <th class="text-center">ANALISTA</th>
          <th class="text-center">PLANILLADOS</th>
          <th class="text-center">CON INFORME</th>
          <th class="text-center">TOTAL</th>
       </tr>
    </thead>
    <tbody>
      <?php              
        $conId = 1;
        foreach ($arrayAnalistas as $key => $regAnalista){ 
          $total = 0;
          (isset($regAnalista["planillado"]))? $planillados =  $regAnalista["planillado"]: $planillados = 0;
          (isset($regAnalista["informe"]))? $informes =  $regAnalista["informe"]: $informes = 0;

          //$planillados = $planillados - $informes;
          $porcPlanilla = 0;
          $porcPlanilla = $planillados*100/$cuota;
          $colorPlanilla = "progress-bar-red";
          $colorTotal = "bg-red color-palette";

          if($planillados > 0){
            if($porcPlanilla > 60 && $porcPlanilla < 99){ $colorPlanilla = "progress-bar-yellow"; }
            elseif($porcPlanilla == 100){ $colorPlanilla = "progress-bar-green"; }
            elseif($porcPlanilla > 100){ 
              $colorPlanilla = "bg-light-blue color-palette"; $porcPlanilla = 100; 
            }

            if($planillados < 3){
              $total = $informes;
            }else{
              $total = ceil($planillados/3) + $informes;
            }
          }else{
            $planillados = 0;
            $total = $informes;
          }

          $porcTotal = $total*100/$cuota;

          if($porcTotal > 60 && $porcTotal < 99){ $colorTotal = "bg-yellow color-palette"; }
          elseif($porcTotal == 100){ $colorTotal = "bg-green color-palette"; }
          elseif($porcTotal > 100){ 
            $colorTotal = "bg-light-blue color-palette"; $porcTotal = 100; 
          }
        ?>
          <tr id="<?=$regAnalista["id"]?>">
            <td style="line-height: 40px;" class="text-center"><?=$conId?></td>
            <td style="line-height: 40px;"><?=$regAnalista["analista"]?></td>
            <td>
              <div class="progress-group">
                <span class="progress-text">#</span>
                <span class="progress-number"><b><?=@$planillados?></b>/<?=$cuota?></span>

                <div class="progress sm">
                  <div class="progress-bar progress-bar-striped <?=@$colorPlanilla?>" style="width: <?=@$porcPlanilla?>%"></div>
                </div>
              </div>
            </td>
            <td>
              <div class="progress-group">
                <span class="progress-text">#</span>
                <span class="progress-number"><b><?=@$informes?></b>/<?=$cuota?></span>

                <div class="progress sm">
                  <div class="progress-bar progress-bar-striped <?=@$regAnalista["colorInforme"]?>" style="width: <?=@$regAnalista["porcentInforme"]?>%"></div>
                </div>
              </div>
            </td>
            <td class="text-center <?=$colorTotal?>" style="color: #fff; font-weight: bold; line-height: 40px;"><?=$total?></td>
          </tr>
          <?php
          $conId++;
        }
      ?>
    </tbody>            
  </table>
</div>