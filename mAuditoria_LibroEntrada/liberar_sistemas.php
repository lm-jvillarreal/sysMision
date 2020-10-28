<?php
include '../global_seguridad/verificar_sesion.php';
include "../global_settings/conexion_oracle.php";

//Fecha y hora actual
 date_default_timezone_set('America/Monterrey');
 $fecha=date("Y-m-d"); 
 $hora=date ("H:i:s");

$id_registro = $_POST['id_libroDiario'];
$folio = $_POST['folio'];

$cadena_consultaTipo = "SELECT orden_compra.id, orden_compra.tipo, libro_diario.id_proveedor FROM orden_compra INNER JOIN libro_diario ON orden_compra.orden_compra = libro_diario.orden_compra AND libro_diario.id = '$id_registro'";

$consulta_consultaTipo = mysqli_query($conexion, $cadena_consultaTipo);
$row_tipo = mysqli_fetch_array($consulta_consultaTipo);
$tipo_entrada = $row_tipo[1];
$tipo_entradaReal = ($tipo_entrada == '1') ? "ENTCOC" : "ENTSOC";
$clave_prov = trim($row_tipo['2']);

$cadena_Movimiento = "SELECT SUM(RMON_COSTO_RENGLON_MB) FROM INV_RENGLONES_MOVIMIENTOS
						WHERE MODC_TIPOMOV = '$tipo_entradaReal' 
						AND MODN_FOLIO = '$folio' 
						AND ALMN_ALMACEN = '$id_sede'";

$consulta_movimiento = oci_parse($conexion_central, $cadena_Movimiento);
oci_execute($consulta_movimiento);
oci_fetch($consulta_movimiento);
$conteo_movimiento = oci_num_rows($consulta_movimiento);

if ($conteo_movimiento==0) {
	echo "no_existe";
}else{

	$cadena_proveedorInfoFin = "SELECT MOVC_CVEPROVEEDOR FROM INV_MOVIMIENTOS
								WHERE MODC_TIPOMOV = '$tipo_entradaReal' 
								AND MODN_FOLIO = '$folio' 
								AND ALMN_ALMACEN = '$id_sede'
								AND MOVC_CVEPROVEEDOR = '$clave_prov'";

	$consulta_provInfo = oci_parse($conexion_central, $cadena_proveedorInfoFin);
	oci_execute($consulta_provInfo);
	oci_fetch($consulta_provInfo);
	$conteo_proveedorInfoFin = oci_num_rows($consulta_provInfo);

	if ($conteo_proveedorInfoFin==0) {
		echo "no_coincide";
	}else{
		$total_entrada = $row_movimiento[0];
		$cadena_libroDiario = "SELECT id_proveedor, numero_nota, numero_factura, total, orden_compra, sucursal FROM libro_diario WHERE id = '$id_registro'";
		$consulta_libroDiario = mysqli_query($conexion, $cadena_libroDiario);

		$row_libroDiario = mysqli_fetch_array($consulta_libroDiario);

		$cve_proveedor = $row_libroDiario[0];
		$no_nota = $row_libroDiario[1];
		$numero_factura = $row_libroDiario[2];
		$total_factura = $row_libroDiario[3];
		$orden_compra = $row_libroDiario[4];
		$sucursal = $row_libroDiario[5];

		$cadena_validaExiste = "SELECT id FROM auditoria_libroDiario WHERE folio_entrada = '$folio' AND sucursal = '$sucursal'";
		$consulta_validaExiste = mysqli_query($conexion, $cadena_validaExiste);
		$row_validaExiste = mysqli_fetch_array($consulta_validaExiste);

		if (count($row_validaExiste)>0) {
			echo "repetido";
		}else{

			$cadena_cartaFaltante = "SELECT id, total_diferencia FROM carta_faltante 
										WHERE no_orden = '$orden_compra' 
										AND numero_proveedor = '$cve_proveedor'
										AND no_factura = '$numero_factura' 
										AND id_sucursal = '$sucursal'";
			$consulta_cartaFaltante = mysqli_query($conexion, $cadena_cartaFaltante);
			$row_cartaFaltante = mysqli_fetch_array($consulta_cartaFaltante);

			if ($total_factura>$total_entrada) {
				$diferencia = $total_factura-$total_entrada;
			}elseif($total_factura<$total_entrada){
				$diferencia = $total_entrada-$total_factura;
			}elseif($total_factura==$total_entrada){
				$diferencia = 0;
			}

			$cadena_liberar = "INSERT INTO auditoria_libroDiario (id_libroDiario, sucursal, no_nota, no_factura, cve_proveedor, total_factura, folio_entrada, total_entrada, orden_compra, diferencia, carta_faltante, total_cartaFaltante, usuario_autoriza, comentario_autoriza, fecha, hora, activo, usuario)VALUES('$id_registro', '$sucursal', '$no_nota', '$numero_factura', '$cve_proveedor','$total_factura', '$folio', '$total_entrada', '$orden_compra', '$diferencia', '$row_cartaFaltante[0]', '$row_cartaFaltante[1]', '$nombre_persona', '', '$fecha', '$hora', '1', '$id_usuario')";

			$consulta_liberar = mysqli_query($conexion, $cadena_liberar);

			$cadena_actualizar = "UPDATE libro_diario SET autorizado = '1' WHERE id = '$id_registro'";
			$consulta_actualizar = mysqli_query($conexion, $cadena_actualizar);
			echo "ok";
		}
	}
}
?>