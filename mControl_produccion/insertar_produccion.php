<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$cod_prod = $_POST['cod_prod'];
$cant_prod = $_POST['valor_prod'];
$cant_pedido = $_POST['valor_pedido'];

$conteo = count($cod_prod);

$folio = date("Y").date("m").date("d")-1;

for ($i=0; $i < $conteo; $i++) {

	$cadena_actualizar_pedido = "UPDATE cp_pedido_pan SET cantidad_realizada = '$cant_prod[$i]' WHERE cve_producto = '$cod_prod[$i]' AND folio_pedido = '$folio'";
	$actualizar_pedido = mysqli_query($conexion, $cadena_actualizar_pedido);

	$cad_ide = "SELECT MAX(id) FROM cp_historial_movimientos WHERE cve_producto = $cod_prod[$i]";
	$consulta_ide = mysqli_query($conexion, $cad_ide);
	$row_ide = mysqli_fetch_array($consulta_ide);

	$cadena_ultimo = "SELECT cve_producto, desc_producto, inv_arranque, baja_merma, baja_venta, inv_cierre, (inv_arranque - baja_merma - baja_venta) AS restante, sucursal, fecha_produccion FROM cp_historial_movimientos WHERE id = '$row_ide[0]'";
	$consulta_ultimo = mysqli_query($conexion, $cadena_ultimo);
	$row_ultimo = mysqli_fetch_array($consulta_ultimo);

	$fecha_inicio = $row_ultimo[8];
	$fecha_inicial = explode("-",$fecha_inicio);
	$prefijo_ini = implode("",$fecha_inicial);

	$prefijo_fin = $folio;

	$cadena_ventas = "SELECT SUM(ARTN_CANTIDAD) FROM PV_ARTICULOSTICKET 
						WHERE (ticn_aaaammddventa >= '$prefijo_ini' AND ticn_aaaammddventa <= '$prefijo_fin')
						AND artc_articulo = '$row_ultimo[0]' 
						AND ticc_sucursal = '$row_ultimo[7]'";
	$consulta_ventas = oci_parse($conexion_central, $cadena_ventas);
	oci_execute($consulta_ventas);
	$row_ventas=oci_fetch_row($consulta_ventas);

	//echo $cadena_ventas;

	$inv_cierre = $row_ultimo[2]-$row_ultimo[3]-$row_ventas[0];

	//echo $inv_cierre;

	$cadena_actualiza_inv = "UPDATE cp_historial_movimientos SET baja_venta = '$row_ventas[0]', inv_cierre = '$inv_cierre' WHERE id = '$row_ide[0]'";

	//echo $cadena_actualiza_inv;
	$actualiza_inv = mysqli_query($conexion, $cadena_actualiza_inv);

	$inv_arranque = $inv_cierre + $cant_prod[$i];

	$insertar_nuevo = "INSERT INTO cp_historial_movimientos (cve_producto, desc_producto, inv_arranque, baja_merma, baja_venta, inv_cierre, sucursal, fecha_produccion, fecha, hora, activo, usuario)VALUES('$row_ultimo[0]', '$row_ultimo[1]', '$inv_arranque', '0', '0', '0', '$id_sede', '$fecha', '$fecha', '$hora', '1', '$id_usuario')";
	$inserta_nuevo = mysqli_query($conexion, $insertar_nuevo);
}
echo "ok";
?>