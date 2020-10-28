<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

$cadena_articulos = "SELECT id, departamento, artc_articulo, artc_descripcion, costo_um, um, costo_unitario, impuesto, costo_total FROM cp_productos";
$consulta_articulos = mysqli_query($conexion, $cadena_articulos);

$cuerpo ="";

while ($row_articulos = mysqli_fetch_array($consulta_articulos)) {
  $link = "<center><a href='#' class='btn btn-danger' onclick='eliminar($row_articulos[0])'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a></center>";
  $ver = "<center><a href='#' data-folio = '$row_articulos[0]' data-toggle = 'modal' data-target = '#modal-teoricos' class='btn btn-primary' target='blank'><i class='fa fa-search fa-lg' aria-hidden='true'></i></a></center>";
  $codigo = "<div class='input-group' style='width:100%''><input type='text' id='id_$row_articulos[0]' class='form-control' value='$row_articulos[2]'><span class='input-group-btn'><button onclick='cambiar_codigo($row_articulos[0])' class='btn btn-danger' type='button'><i class='fa fa-save fa-lg' aria-hidden='true'></i></button></span></div>";
  $um = "<div class='input-group' style='width:100%''><input type='text' id='um_$row_articulos[0]' class='form-control' value='$row_articulos[5]'><span class='input-group-btn'><button onclick='cambiar_um($row_articulos[0])' class='btn btn-danger' type='button'><i class='fa fa-save fa-lg' aria-hidden='true'></i></button></span></div>";
  $escape_desc=mysqli_real_escape_string($conexion,$row_articulos[3]);
  $renglon = "
		{
    \"departamento\": \"$row_articulos[1]\",
    \"cod\": \"$row_articulos[2]\",
		\"codigo\": \"$codigo\",
		\"descripcion\": \"$escape_desc\",
    \"costo_um\": \"$row_articulos[4]\",
    \"um\": \"$um\",
    \"costo_unitario\": \"$row_articulos[6]\",
    \"impuesto\": \"$row_articulos[7]\",
    \"total\": \"$row_articulos[8]\"
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
?>