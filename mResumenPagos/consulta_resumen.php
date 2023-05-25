<?php
include '../global_seguridad/verificar_sesion.php';

//Fecha y hora actual
  date_default_timezone_set('America/Monterrey');
  $fecha=date("Y-m-d"); 
  $hora=date ("h:i:s");

$fecha_inicial = (!isset($_POST['fecha_inicio'])) ? $fecha : $_POST['fecha_inicio'];
$fecha_final = (!isset($_POST['fecha_fin'])) ? $fecha : $_POST['fecha_fin'];
$proveedor= $_POST['proveedor'];

$filtro_sucursal = ($solo_sucursal == '1') ? " AND le.sucursal = '$id_sede'" : "";

$cadena_ordenes = "SELECT numero_nota, id, activo, tipo, orden_compra FROM libro_diario as le WHERE (le.fecha >= '$fecha_inicial' AND le.fecha <= '$fecha_final')". $filtro_sucursal." AND id_proveedor='$proveedor' ORDER BY le.numero_nota ASC";

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
                            r.total_dc2,
                            IF(r.escaneada='1','SI','NO'),
                            ( SELECT c.TIPO_PROVEEDOR FROM categorias_proveedor AS c INNER JOIN proveedores AS p ON c.ID = p.tipo_proveedor WHERE TRIM(p.numero_proveedor) = TRIM(r.cve_proveedor) ),
                            (SELECT dificultad FROM proveedores WHERE TRIM(numero_proveedor)=TRIM(r.cve_proveedor))
                    FROM alb_resumenEntradas as r INNER JOIN usuarios as u ON r.usuario = u.id WHERE ficha_entrada = '$row_ordenes[0]'";
  $consultaResumen = mysqli_query($conexion, $cadenaResumen);
  $rowResumen = mysqli_fetch_array($consultaResumen);
  $diferencia = round($rowResumen[9],2);
  if($row_ordenes[2]=='5'){
    $consumo_interno = "<center><span class='label label-danger'>Cancelado</span></center>";
  }
  elseif($row_ordenes[2]!='5' && $rowResumen[0]==NULL && $row_ordenes[3]=='1'){
    $consumo_interno = "";
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
    }elseif($row_ordenes[3]=='6'){
      $consumo_interno = "<center><span class='label label-success'>ROP-VAR</span></center>";
    }else{
      $consumo_interno = "";
    }
  }
  $entrada = "<a href='#' data-id = '$row_ordenes[0]' data-toggle = 'modal' data-target = '#modal-entradas'>$rowResumen[4]</a>";
  $ficha_entrada = "<center><a href='#' onclick='imp_ficha($row_ordenes[4])'>$row_ordenes[0]</a></center>";
  $total_cf = "<a href='#' data-id = '$row_ordenes[0]' data-toggle = 'modal' data-target = '#modal-faltante'>$rowResumen[6]</a>";
  $total_dc2 = "<a href='#' data-id = '$row_ordenes[0]' data-toggle = 'modal' data-target = '#modal-difmas'>$rowResumen[11]</a>";
  $total_dc = "<a href='#' data-id = '$row_ordenes[0]' data-toggle = 'modal' data-target = '#modal-difmenos'>$rowResumen[7]</a>";
	$renglon = "
		{
      \"ficha_entrada\": \"$ficha_entrada\",
      \"cve_prov\": \"$rowResumen[0]\",
      \"nombre_proveedor\": \"$rowResumen[1]\",
      \"tipo_proveedor\": \"$rowResumen[13]\",
      \"remision\": \"$rowResumen[2]\",
      \"total_remision\": \"$rowResumen[3]\",
      \"total_entrada\": \"$entrada\",
      \"total_devoluciones\": \"$rowResumen[5]\",
      \"total_cf\": \"$total_cf\",
      \"total_dc\": \"$total_dc\",
      \"total_dc2\": \"$total_dc2\",
      \"gran_total\": \"$rowResumen[8]\",
      \"diferencia\": \"$diferencia\",
      \"escaneada\": \"$rowResumen[12]\",
      \"usuario_concilia\": \"$rowResumen[10]\",
      \"consumo_interno\": \"$consumo_interno\",
      \"dificultad\": \"$rowResumen[14]\"
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
