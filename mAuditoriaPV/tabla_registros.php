<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");

$cadenaRegistros = "SELECT * FROM auditoria_pv WHERE activo = '1' AND usuario = '$id_usuario'";
$consultaRegistros = mysqli_query($conexion, $cadenaRegistros);

$cuerpo ="";

while ($rowRegistros = mysqli_fetch_array($consultaRegistros)) {
  
  $link_detalle = "<center><a href='#' data-id = '$rowRegistros[0]' data-toggle = 'modal' data-target = '#modal-default' class='btn btn-success' target='blank'>$rowRegistros[3]</a></center>";

  $escapeDescripcion = mysqli_real_escape_string($conexion, $rowRegistros[4]);
  $escapeProveedor = mysqli_real_escape_string($conexion, $rowRegistros[10]);
  $escapeDepto = mysqli_real_escape_string($conexion, $rowRegistros[11]);
  $escapeFamilia = mysqli_real_escape_string($conexion, $rowRegistros[12]);
  $check = "<div class='checkbox'><label><input type='checkbox' name='liberar[]' value='$rowRegistros[0]'></label></div>";
  if($rowRegistros[9]=='0'|| $rowRegistros[9]==NULL||$rowRegistros[15]=='0'||$rowRegistros[15]==NULL){
    $porcentaje='0';
  }else{
    $porcentaje = $porcentaje = (1-($rowRegistros[9]/$rowRegistros[15]))*100;
    $porcentaje = round($porcentaje,2);
  }
  $fecha_termina = strtotime($fecha."+ $rowRegistros[19] days");
  $fecha_termina = date("d/m/Y",$fecha_termina);
	$renglon = "
		{
    \"no\": \"$check\",
		\"codigo\": \"$link_detalle\",
		\"descripcion\": \"$escapeDescripcion\",
		\"existencia\": \"$rowRegistros[5]\",
		\"ultima_entrada\": \"$rowRegistros[6]\",
		\"tipo_mov\": \"$rowRegistros[7]\",
		\"folio_mov\": \"$rowRegistros[8]\",
		\"cantidad_mov\": \"$rowRegistros[9]\",
    \"proveedor\": \"$escapeProveedor\",
    \"departamento\": \"$escapeDepto\",
    \"familia\": \"$escapeFamilia\",
    \"ultimo_costo\": \"$rowRegistros[13]\",
    \"unidad_empaque\": \"$rowRegistros[14]\",
    \"ventas\": \"$rowRegistros[15]\",
    \"porcentaje\": \"$porcentaje\",
    \"teorico\": \"$rowRegistros[16]\",
    \"faltante\": \"$rowRegistros[17]\",
    \"faltante_cajas\": \"$rowRegistros[18]\",
    \"dias_inv\": \"$rowRegistros[19]\",
    \"meses_inv\": \"$rowRegistros[20]\",
    \"fecha_termina\": \"$fecha_termina\",
    \"comentario\": \"$rowRegistros[26]\"
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
