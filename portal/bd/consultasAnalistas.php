<?php
include('../conexion/conexion.php');
include '../bower_components/PHPExcel/Classes/PHPExcel/IOFactory.php';

function asignarCasosCuentaAna($periodo, $numero, $casos, $id_usuario)
{
  global $con;

  $queryCuenta = "SELECT id, estado FROM cuenta_cobro_analista WHERE id_analista = $id_usuario AND periodo = '$periodo' AND numero = '$numero'";
  $respCuenta = mysqli_query($con, $queryCuenta);

  if (mysqli_num_rows($respCuenta) > 0) {
    $datosCuenta = mysqli_fetch_assoc($respCuenta);
    if ($datosCuenta['estado'] != 2) {
      foreach ($casos as $caso) {
        $in = 0;
        mysqli_query($con, "INSERT INTO investigaciones_cuenta_analista(id_cuenta_cobro, id_investigacion) VALUES(" . $datosCuenta['id'] . ", " . intval($caso) . ");");
      }

      $variable = 1;
    } else {
      $variable = 3;
    }
  } else {
    $variable = 2;
  }

  return ($variable);
}

function crearCuentaAna($periodo, $numero, $casos, $id_usuario)
{
  global $con;

  $queryCuenta = "SELECT * FROM cuenta_cobro_analista WHERE id_analista = $id_usuario AND periodo = '$periodo' AND numero = '$numero'";
  $respCuenta = mysqli_query($con, $queryCuenta);

  if (mysqli_num_rows($respCuenta) == 0) {

    $queryInsertCuenta = "INSERT INTO cuenta_cobro_analista (id_analista, periodo, numero) VALUES($id_usuario, '$periodo', $numero);";

    if (mysqli_query($con, $queryInsertCuenta)) {
      $variable = asignarCasosCuentaAna($periodo, $numero, $casos, $id_usuario);
    } else {
      $variable = 2;
    }
  } else {
    $variable = 2;
  }

  return ($variable);
}

function eliminarCasoCuentaAna($id_investigacion, $id_cuenta, $origen)
{
  global $con;

  $queryCasoCuenta = "SELECT * FROM investigaciones_cuenta_analista WHERE id_cuenta_cobro = $id_cuenta AND id_investigacion = $id_investigacion AND origen = $origen";
  $respCasoCuenta = mysqli_query($con, $queryCasoCuenta);

  if (mysqli_num_rows($respCasoCuenta) > 0) {
    if (mysqli_query($con, "DELETE FROM investigaciones_cuenta_analista WHERE id_cuenta_cobro = $id_cuenta AND id_investigacion = $id_investigacion AND origen = $origen")) {
      $variable = 1;
    } else {
      $variable = 3;
    }
  } else {
    $variable = 2;
  }

  return ($variable);
}

function guardarCuentaCobroAna($id_cuenta, $descuentoVerCasosAna, $adicionalVerCasosAna, $subtotal, $total, $cantidad, $idCasos, $valorCasos, $tarifaCasos, $observacionVerCasosAna, $id_usuario, $origenCasos)
{
  global $con;

  $queryCuenta = "SELECT id FROM cuenta_cobro_analista WHERE id = '$id_cuenta' AND estado != 2";
  $respCuenta = mysqli_query($con, $queryCuenta);

  if (mysqli_num_rows($respCuenta) > 0) {
    $cont = 0;
    foreach ($idCasos as $id) {
      mysqli_query($con, "UPDATE investigaciones_cuenta_analista SET valor_pagado = " . intval($valorCasos[$cont]) . ", id_tarifa = " . intval($tarifaCasos[$cont]) . " WHERE id_cuenta_cobro = '$id_cuenta' AND id_investigacion = '$id' AND origen = " . intval($origenCasos[$cont]));
      $cont++;
    }

    $subtotal = str_replace('.', '', $subtotal);
    $total = str_replace('.', '', $total);

    if (mysqli_query($con, "UPDATE cuenta_cobro_analista SET cantidad_investigaciones = $cantidad, valor_descuento = $descuentoVerCasosAna, valor_adicional = $adicionalVerCasosAna, valor_total = $total, valor_investigaciones = $subtotal, estado = 1, observacion = '" . $observacionVerCasosAna . "' WHERE id = $id_cuenta")) {
      $variable = 1;
    } else {
      $variable = 2;
    }
  } else {
    $variable = 3;
  }

  return ($variable);
}

function cerrarCuentaCobroAna($id_cuenta, $viaticosVerCasosAna, $adicionalVerCasosAna, $subtotal, $total, $cantidad, $idCasos, $valorCasos, $tarifaCasos, $observacionVerCasosAna, $id_usuario)
{
  global $con;

  $queryCuenta = "SELECT id FROM cuenta_cobro_analista WHERE id = '$id_cuenta' AND estado != 2";
  $respCuenta = mysqli_query($con, $queryCuenta);

  if (mysqli_num_rows($respCuenta) > 0) {
    $cont = 0;
    foreach ($idCasos as $id) {
      mysqli_query($con, "UPDATE investigaciones_cuenta_analista SET valor_pagado = " . intval($valorCasos[$cont]) . ", id_tarifa = " . intval($tarifaCasos[$cont]) . " WHERE id_cuenta_cobro = '$id_cuenta' AND id_investigacion = '$id'");
      $cont++;
    }

    $subtotal = str_replace('.', '', $subtotal);
    $total = str_replace('.', '', $total);

    if (mysqli_query($con, "UPDATE cuenta_cobro_analista SET cantidad_investigaciones = $cantidad, valor_viaticos = $viaticosVerCasosAna, valor_adicional = $adicionalVerCasosAna, valor_total = $total, valor_investigaciones = $subtotal, estado = 2, fecha_cerrada = CURRENT_TIMESTAMP(), observacion = '" . $observacionVerCasosAna . "' WHERE id = $id_cuenta")) {
      $variable = 1;
    } else {
      $variable = 2;
    }
  } else {
    $variable = 3;
  }

  return ($variable);
}

function habilitarCuentaCobroAna($id_cuenta)
{
  global $con;

  $queryCuenta = "SELECT id FROM cuenta_cobro_analista WHERE id = '$id_cuenta'";
  $respCuenta = mysqli_query($con, $queryCuenta);

  if (mysqli_num_rows($respCuenta) > 0) {
    mysqli_query($con, "UPDATE cuenta_cobro_analista SET estado = 1 WHERE id = '$id_cuenta'");
    $variable = 1;
  } else {
    $variable = 2;
  }

  return ($variable);
}

function exportarCuentaCobroExcel($id_cuenta, $periodoTexto)
{
  global $con;

  $objPHPExcel = new PHPExcel();
  $objReader = PHPExcel_IOFactory::createReader('Excel2007');
  $objPHPExcel = $objReader->load('../bower_components/PHPExcel/plantillaCuentaCobroAnalista.xlsx');

  $objPHPExcel->setActiveSheetIndex(0);

  //---CABECERA CUENTA DE COBRO ------
  $sqlCabecera = "SELECT a.id, DATE_FORMAT(a.periodo,'%Y-%m') as periodo, a.numero, CONCAT(m.nombres, ' ', m.apellidos) AS analista , a.estado, a.cantidad_investigaciones, a.valor_descuento, a.valor_adicional, a.valor_total, a.fecha, a.fecha_cerrada, a.observacion FROM cuenta_cobro_analista a 
  LEFT JOIN usuarios m ON m.id = a.id_analista WHERE a.id = $id_cuenta";

  $analista = "";
  $estado = 0;
  $cuenta = 0;
  $totalCasos = 0;
  $valorAdicional = 0;
  $valorDescuento = 0;
  $fecha = "";
  $fechaCerrada = "";
  $observacion = "";
  $perido = "";
  $numero = "";
  $estado_texto = "";

  $queryCabecera = mysqli_query($con, $sqlCabecera);
  if (mysqli_num_rows($queryCabecera) > 0) {
    $respCabecera = mysqli_fetch_array($queryCabecera, MYSQLI_ASSOC);
    $cuenta = $respCabecera["id"];
    $analista = $respCabecera["analista"];
    $estado = $respCabecera["estado"];
    $valorDescuento = $respCabecera["valor_descuento"];
    $valorAdicional = $respCabecera["valor_adicional"];
    $fecha = $respCabecera["fecha"];
    $fechaCerrada = $respCabecera["fecha_cerrada"];
    $observacion = $respCabecera["observacion"];
    $periodo = $respCabecera["periodo"];
    $numero = $respCabecera["numero"];
  }

  if ($estado == 0) {
    $estado_texto = 'ABIERTA';
  } else if ($estado == 0) {
    $estado_texto = 'ENVIADA';
  } else {
    $estado_texto = 'CERRADA';
  }

  $objPHPExcel->getActiveSheet()->setCellValue('B3', '#' . $cuenta);
  $objPHPExcel->getActiveSheet()->setCellValue('D3', $analista);
  $objPHPExcel->getActiveSheet()->setCellValue('B4', $estado_texto);
  $objPHPExcel->getActiveSheet()->setCellValue('D4', $periodoTexto);

  //-----CASOS CUENTA COBRO-------
  $consultaCasosAna = "SELECT d.id_cuenta_cobro, a.id, a.codigo, a.id_aseguradora, j.nombre_corto AS aseguradora, a.tipo_caso, l.descripcion2 AS tipoCasoCorto, l.descripcion3 AS tipoCasoTarifa,  l.descripcion AS tipoCaso, f.fecha_accidente, CONCAT(c.nombres, ' ', c.apellidos) AS lesionado, b.resultado as id_resultado, b.indicador_fraude, d.valor_pagado, d.id_tarifa, mi.ruta, d.origen, IF(d.origen = 0, 'INFORME', 'PLANILLADO') AS origen_lt
    FROM investigaciones_cuenta_analista d
    LEFT JOIN investigaciones a ON a.id = d.id_investigacion
    LEFT JOIN personas_investigaciones_soat b ON b.id_investigacion = d.id_investigacion
    LEFT JOIN multimedia_investigacion mi ON mi.id_investigacion = a.id
    LEFT JOIN aseguradoras j ON j.id = a.id_aseguradora
    LEFT JOIN detalle_investigaciones_soat f ON f.id_investigacion = b.id_investigacion
    LEFT JOIN personas c ON b.id_persona = c.id
    LEFT JOIN definicion_tipos l ON l.id_tipo = 8 AND l.id = a.tipo_caso
    WHERE mi.id_multimedia = 9 AND b.tipo_persona = 1 AND d.id_cuenta_cobro = $cuenta ORDER BY a.tipo_caso, a.id;";

  $queryVerCasosCuentaInv = mysqli_query($con, $consultaCasosAna);

  $cantPositivos = 0;
  $cantAtender = 0;

  $fila = 7;

  $AseguradoraCasos = array();

  while ($repCasosAna = mysqli_fetch_array($queryVerCasosCuentaInv, MYSQLI_ASSOC)) {

    if (array_key_exists($repCasosAna["aseguradora"], $AseguradoraCasos)) {
      $casos = $AseguradoraCasos[$repCasosAna["aseguradora"]] + 1;
      $AseguradoraCasos[$repCasosAna["aseguradora"]] = $casos;
    } else {
      $AseguradoraCasos[$repCasosAna["aseguradora"]] = 1;
    }

    if ($repCasosAna["indicador_fraude"] == 13 || $repCasosAna["id_resultado"] == 3) {
      $repCasosAna["id_resultado"] = 3;
      $repCasosAna["resultado"] = 'OCURRENCIA';
      $cantAtender++;
    } else {
      if ($repCasosAna["id_resultado"] == 2) {
        $repCasosAna["resultado"] = 'NO ATENDER';
        $cantPositivos++;
      } else {
        $repCasosAna["resultado"] = 'ATENDER';
        $cantAtender++;
      }
    }

    $disabled = '';
    if ($estado < 2 && $repCasosAna["valor_pagado"] < 1500) {

      if ($repCasosAna["ruta"] != "") {
        $sqlValorv = "SELECT id, valor, descripcion FROM (
        SELECT 1 AS prioridad, id, descripcion, id_aseguradora, id_tipo_caso, id_departamento, id_tipo_zona, id_resultado, valor FROM tarifas WHERE id_tipo = 2 AND id_clase = 2 AND id_resultado = " . $repCasosAna['id_resultado'] . " AND id_aseguradora = " . $repCasosAna["id_aseguradora"] . " AND id_tipo_caso = " . $repCasosAna["tipoCasoTarifa"] . " UNION
        SELECT 2 AS prioridad, id, descripcion, id_aseguradora, id_tipo_caso, id_departamento, id_tipo_zona, id_resultado, valor FROM tarifas WHERE id_tipo = 2 AND id_clase = 2 AND id_resultado = 0 AND id_aseguradora = " . $repCasosAna["id_aseguradora"] . " AND id_tipo_caso = " . $repCasosAna["tipoCasoTarifa"] . " UNION
        SELECT 3 AS prioridad, id, descripcion, id_aseguradora, id_tipo_caso, id_departamento, id_tipo_zona, id_resultado, valor FROM tarifas WHERE id_tipo = 2 AND id_clase = 2 AND id_resultado = " . $repCasosAna['id_resultado'] . " AND id_aseguradora = " . $repCasosAna["id_aseguradora"] . " AND id_tipo_caso = 0 UNION
        SELECT 4 AS prioridad, id, descripcion, id_aseguradora, id_tipo_caso, id_departamento, id_tipo_zona, id_resultado, valor FROM tarifas WHERE id_tipo = 2 AND id_clase = 2 AND id_resultado = 0 AND id_aseguradora = " . $repCasosAna["id_aseguradora"] . " AND id_tipo_caso = 0) cte ORDER BY prioridad ASC LIMIT 1";
        $queryValor = mysqli_query($con, $sqlValorv);

        $id_tarifa = 0;
        $valorCaso = 0;

        if (mysqli_num_rows($queryValor) > 0) {
          $respValor = mysqli_fetch_array($queryValor, MYSQLI_ASSOC);

          if ($repCasosAna["id_aseguradora"] == 1) {
            $sqlSiPlanillado = "SELECT id_investigacion FROM investigaciones_cuenta_analista WHERE origen = 1 AND id_investigacion = " . $repCasosAna["id"];
            $querySiPlanillado = mysqli_query($con, $sqlSiPlanillado);

            if (mysqli_num_rows($querySiPlanillado) > 0) {
              if ($repCasosAna["id_resultado"] == 2) {
                $valorCaso = 6000;
              } else {
                $valorCaso = 5000;
              }
              $repCasosAna["origen_lt"] = 'PLN-INF';
              $id_tarifa = $respValor["id"];
            } else {
              $valorCaso = $respValor["valor"];
              $id_tarifa = $respValor["id"];
            }
          } else {
            $valorCaso = $respValor["valor"];
            $id_tarifa = $respValor["id"];
          }
        } else {
          $valorCaso = 2000;
          $id_tarifa = 319;
        }

        $totalCasos = $totalCasos + $valorCaso;
      } else {
        $valorCaso = 2000;
        $id_tarifa = 319;
        $totalCasos = $totalCasos + $valorCaso;
      }
    } else {
      $valorCaso = $repCasosAna["valor_pagado"];
      $totalCasos = $totalCasos + $valorCaso;
      $id_tarifa = $repCasosAna["id_tarifa"];
    }

    $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $repCasosAna["tipoCasoCorto"]);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $repCasosAna["codigo"]);
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $repCasosAna["origen_lt"]);
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $repCasosAna["aseguradora"]);
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $repCasosAna["resultado"]);
    $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $repCasosAna["lesionado"]);
    $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $valorCaso);

    $fila++;
  }

  $styleArray = array(
    'borders' => array(
      'allborders' => array(
        'style' => PHPExcel_Style_Border::BORDER_THIN
      )
    )
  );
  $temp = $fila - 1;
  $objPHPExcel->getActiveSheet()->getStyle('A7:G' . $temp)->applyFromArray($styleArray);
  unset($styleArray);

  $CantidadCasos = (intval($cantAtender) + intval($cantPositivos));
  $objPHPExcel->getActiveSheet()->setCellValue('G3', intval($cantAtender) . '/' . intval($cantPositivos));
  $objPHPExcel->getActiveSheet()->setCellValue('G4', $CantidadCasos);

  $fila++;
  $objPHPExcel->getActiveSheet()->mergeCells('A' . $fila . ':B' . $fila);
  $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, 'ASEGURADORA');
  $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, 'CANT');

  $temp = $fila + 1;

  foreach ($AseguradoraCasos as $aseguradora => $cant) {
    $objPHPExcel->getActiveSheet()->mergeCells('A' . $temp . ':B' . $temp);
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $temp, $aseguradora);
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $temp, $cant);
    $temp++;
  }

  $styleArray = array(
    'alignment' => array(
      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    ),
    'borders' => array(
      'allborders' => array(
        'style' => PHPExcel_Style_Border::BORDER_THIN
      )
    )
  );
  $temp--;
  $objPHPExcel->getActiveSheet()->getStyle('A' . $fila . ':C' . $temp)->applyFromArray($styleArray);
  unset($styleArray);

  $objPHPExcel->getActiveSheet()->mergeCells('E' . $fila . ':F' . $fila);
  $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, 'Observación');

  $fila++;
  $temp = $fila + 1;
  $objPHPExcel->getActiveSheet()->mergeCells('E' . $fila . ':F' . $temp);
  $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getAlignment()->setWrapText(true);
  $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $observacion);

  $fila = $temp + 2;
  $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, 'Subtotal:');
  $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, '$ ' . $totalCasos);

  $fila++;
  $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, 'Adicional:');
  $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, '$ ' . intval($valorAdicional));

  $fila++;
  $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, 'Descuentos:');
  $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, '$ ' . intval($valorDescuento));

  $fila = $fila + 2;
  $TotalCuenta = ($totalCasos + intval($valorAdicional)) + intval($valorDescuento);
  $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, 'Total:');
  $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, '$ ' . $TotalCuenta);

  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
  $nombreArchivo = "CUENTA DE COBRO " . $analista . ".xlsx";

  $objWriter->save("../bower_components/PHPExcel/informes/" . $nombreArchivo);

  return $nombreArchivo;
}

function cerrarCuentasAnalista($cuentas, $id_usuario)
{
  global $con;

  $idCuentas = implode(",", $cuentas);
  $queryCuenta = "SELECT id FROM cuenta_cobro_analista WHERE estado != 2 AND id IN($idCuentas)";
  $respCuenta = mysqli_query($con, $queryCuenta);

  if (mysqli_num_rows($respCuenta) > 0) {
    while ($ids = mysqli_fetch_assoc($respCuenta)) {
      $queryCuenta = "UPDATE cuenta_cobro_analista SET estado = 2, fecha_cerrada = CURRENT_TIMESTAMP() WHERE id = " . $ids['id'];
      if (mysqli_query($con, $queryCuenta)) {
        $variable = 1;
      } else {
        $variable = 3;
      }
    }
  } else {
    $variable = 2;
  }
  return ($variable);
}

function abrirCuentasAnalista($cuentas, $id)
{
  global $con;

  $idCuentas = implode(",", $cuentas);
  $queryCuenta = "SELECT id FROM cuenta_cobro_analista WHERE estado != 1 AND id IN($idCuentas)";
  $respCuenta = mysqli_query($con, $queryCuenta);

  if (mysqli_num_rows($respCuenta) > 0) {
    while ($ids = mysqli_fetch_assoc($respCuenta)) {
      $queryCuenta = "UPDATE cuenta_cobro_analista SET estado = 1 WHERE id = " . $ids['id'];
      if (mysqli_query($con, $queryCuenta)) {
        $variable = 1;
      } else {
        $variable = 3;
      }
    }
  } else {
    $variable = 2;
  }
  return ($variable);
}

function crearCuentaAnalista($id_analista, $periodo_ana, $numero)
{
  global $con;

  $sqlCuenta = "SELECT * FROM cuenta_cobro_analista WHERE id_analista = $id_analista AND periodo = '".$periodo_ana."' AND numero = '$numero'";
  $respSqlCuenta = mysqli_query($con, $sqlCuenta);

  if (mysqli_num_rows($respSqlCuenta) == 0) {
    $sqlCrearCuenta = "INSERT INTO cuenta_cobro_analista(id_analista, periodo, numero) VALUES ('$id_analista', '$periodo_ana', '$numero')";
    
    mysqli_query($con, $sqlCrearCuenta);
  }else{
    $variable = 1;
  }
  return ($variable);
}

