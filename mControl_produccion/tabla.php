<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$no_catalogo = $_POST['num_catalogo'];

$filtro_ss = (!empty($solo_sucursal) == '1') ? " AND sucursal = '$id_sede'" : " AND sucursal = '$id_sede'";

$cadena_productos = "SELECT id, cve_producto, desc_producto FROM cp_catalogos WHERE no_catalogo = '$no_catalogo'".$filtro_ss;

$consulta_productos = mysqli_query($conexion, $cadena_productos);

$cuerpo ="";

while ($row_productos = mysqli_fetch_array($consulta_productos)) {

	$cadena_existencias = "SELECT MAX(id), inv_arranque FROM cp_historial_movimientos WHERE cve_producto = '$row_productos[1]' ORDER BY id DESC LIMIT 1";
	$consulta_existencias = mysqli_query($conexion, $cadena_existencias);
	$row_existencias = mysqli_fetch_array($consulta_existencias);
	$existencias = $row_existencias[1];

	$inv_inicial = "<input type='number' name='inv_inicial[]' class='form-control' readonly='true' value='$existencias'>";
	$cant_merma = "<input type='number' name='cant_merma[]' class='form-control'>";
	$cod_prod = "<input type='hidden' name='cod_prod[]' id='codigoss' value='$row_productos[1]'>".$row_productos[1];
	$desc_prod = "<input type='hidden' name='desc_prod[]' id='descripcionn' value='$row_productos[2]'>".$row_productos[2];
	$renglon = "
		{
		\"id\": \"$row_productos[0]\",
		\"cve_producto\": \"$cod_prod\",
		\"desc_producto\": \"$desc_prod\",
		\"inv_inicial\": \"$inv_inicial\",
		\"cant_merma\": \"$cant_merma\"
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