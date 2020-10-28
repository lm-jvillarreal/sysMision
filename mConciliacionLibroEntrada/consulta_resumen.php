<?php
include '../global_seguridad/verificar_sesion.php';

//Fecha y hora actual
  date_default_timezone_set('America/Monterrey');
  $fecha=date("Y-m-d"); 
  $hora=date ("h:i:s");

$fecha_inicial = (!isset($_POST['fecha_inicio'])) ? $fecha : $_POST['fecha_inicio'];
$fecha_final = (!isset($_POST['fecha_fin'])) ? $fecha : $_POST['fecha_fin'];

$filtro_sucursal = ($solo_sucursal == '1') ? " AND le.sucursal = '$id_sede'" : "";

$cadena_ordenes = "SELECT numero_nota, id, activo, tipo, orden_compra FROM libro_diario as le WHERE (le.fecha >= '$fecha_inicial' AND le.fecha <= '$fecha_final')". $filtro_sucursal." ORDER BY le.numero_nota ASC";

//echo $cadena_ordenes;
$consulta_ordenes = mysqli_query($conexion, $cadena_ordenes);
$cuerpo = "";

while ($row_ordenes = mysqli_fetch_array($consulta_ordenes)) {
  $cadenaResumen = "SELECT  r.cve_proveedor,
                            r.proveedor, 
                            r.remision, 
                            r.total_remision, 
                            r.total_entrada, 
                            r.total_devoluciones, 
                            r.total_cf, 
                            r.total_dc, 
                            r.gran_total, 
                            r.diferencia,
                            u.nombre_usuario,
                            r.total_dc2 
                    FROM alb_resumenEntradas as r INNER JOIN usuarios as u ON r.usuario = u.id WHERE ficha_entrada = '$row_ordenes[0]'";
  $consultaResumen = mysqli_query($conexion, $cadenaResumen);
  $rowResumen = mysqli_fetch_array($consultaResumen);
  $diferencia = round($rowResumen[9],2);
  if($row_ordenes[2]=='5'){
    $consumo_interno = "<center><span class='label label-danger'>Cancelado</span></center>";
  }
  elseif($row_ordenes[2]!='5' && $rowResumen[0]==NULL && $row_ordenes[3]=='1'){
    $consumo_interno = "<div class='btn-group'><button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>Acciones<span class='caret'></span></button><ul class='dropdown-menu'><li><a href='#' onclick='marcar($row_ordenes[1])'>C. I.</a></li><li><a href='#' onclick='echori($row_ordenes[1])'>ECHORI</a></li><li><a href='#' onclick='sm($row_ordenes[1])'>S.M.</a></li><li><a href='#' onclick='escarg($row_ordenes[1])'>ESCARG</a></li></ul></div>";
    //$consumo_interno = "<center><a class='btn btn-success' onclick='marcar($row_ordenes[1])' target='blank'><i class='fa fa-share fa-lg' aria-hidden='true'></i></a></center>";
  }else{
    if($row_ordenes[3]=='2'){
      $consumo_interno = "<center><span class='label label-success'>C.I.</span></center>";
    }elseif($row_ordenes[3]=='3'){
      $consumo_interno = "<center><span class='label label-success'>ECHORI</span></center>";
    }elseif($row_ordenes[3]=='4'){
      $consumo_interno = "<center><span class='label label-success'>S.M.</span></center>";
    }elseif($row_ordenes[3]=='5'){
      $consumo_interno = "<center><span class='label label-success'>ESCARG</span></center>";
    }else{
      $consumo_interno = "<div class='btn-group'><button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>Acciones<span class='caret'></span></button><ul class='dropdown-menu'><li><a href='#' onclick='echori($row_ordenes[1])'>ECHORI</a></li><li><a href='#' onclick='sm($row_ordenes[1])'>S.M.</a></li><li><a href='#' onclick='escarg($row_ordenes[1])'>ESCARG</a></li></ul></div>";
    }
  }
  $entrada = "<a href='#' data-id = '$row_ordenes[0]' data-toggle = 'modal' data-target = '#modal-entradas'>$rowResumen[4]</a>";
  $ficha_entrada = "<center><a href='#' onclick='imp_ficha($row_ordenes[4])'>$row_ordenes[0]</a></center>";
	$renglon = "
		{
      \"ficha_entrada\": \"$ficha_entrada\",
      \"cve_prov\": \"$rowResumen[0]\",
      \"nombre_proveedor\": \"$rowResumen[1]\",
      \"remision\": \"$rowResumen[2]\",
      \"total_remision\": \"$rowResumen[3]\",
      \"total_entrada\": \"$entrada\",
      \"total_devoluciones\": \"$rowResumen[5]\",
      \"total_cf\": \"$rowResumen[6]\",
      \"total_dc\": \"$rowResumen[7]\",
      \"total_dc2\": \"$rowResumen[11]\",
      \"gran_total\": \"$rowResumen[8]\",
      \"diferencia\": \"$diferencia\",
      \"usuario_concilia\": \"$rowResumen[10]\",
      \"consumo_interno\": \"$consumo_interno\"
	  },";
	$cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');
$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
//echo $liberar;
