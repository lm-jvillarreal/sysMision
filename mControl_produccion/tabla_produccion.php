<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$no_catalogo = $_POST['num_catalogo'];

$filtro_ss = (!empty($solo_sucursal) == '1') ? " AND sucursal = '$id_sede'" : " AND sucursal = '$id_sede'";

$folio = date("Y").date("m").date("d")-1;

$cadena_productos = "SELECT id, cve_producto, desc_producto FROM cp_catalogos WHERE no_catalogo = '$no_catalogo'".$filtro_ss;

$consulta_productos = mysqli_query($conexion, $cadena_productos);

$cuerpo ="";

while ($row_productos = mysqli_fetch_array($consulta_productos)) {

	$cadena_pedido = "SELECT cantidad_pedido FROM cp_pedido_pan WHERE cve_producto = '$row_productos[1]' AND folio_pedido = '$folio'";
	$consulta_pedido = mysqli_query($conexion, $cadena_pedido);
	$row_pedido = mysqli_fetch_array($consulta_pedido);
	$pedido = $row_pedido[0];

	$valor_pedido = "<input type='number' name='valor_pedido[]' class='form-control' readonly='true' value='$pedido'>";
	$valor_prod = "<input type='number' name='valor_prod[]' class='form-control'>";
	$cod_prod = "<input type='hidden' name='cod_prod[]' id='codigoss' value='$row_productos[1]'>".$row_productos[1];
	$desc_prod = "<input type='hidden' name='desc_prod[]' id='descripcionn' value='$row_productos[2]'>".$row_productos[2];
	$renglon = "
		{
		\"id\": \"$row_productos[0]\",
		\"cve_producto\": \"$cod_prod\",
		\"desc_producto\": \"$desc_prod\",
		\"valor_pedido\": \"$valor_pedido\",
		\"valor_prod\": \"$valor_prod\"
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