<?php
include '../global_settings/conexion_oracle.php';

$fecha_inicial = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];

$cadena_detalle = "SELECT ALMN_ALMACEN, modc_tipomov, MODN_FOLIO, movd_fechaelaboracion, MOVC_CVEPROVEEDOR
						FROM INV_MOVIMIENTOS
						WHERE (modc_tipomov = 'ENTSOC' OR modc_tipomov = 'ENTCOC')
						AND movd_fechaafectacion IS NULL
						AND movd_fechaelaboracion >= trunc(TO_DATE ('$fecha_inicial', 'YYYY/MM/DD'))
						AND movd_fechaelaboracion < trunc(TO_DATE ('$fecha_final', 'YYYY/MM/DD'))+1";
$consulta_detalle = oci_parse($conexion_central, $cadena_detalle);
oci_execute($consulta_detalle);

//echo $cadena_detalle;
$body = "";
//echo $cadena_detalle;
$encabezado = "
	<div class='table-responsive'>
        <table id='lista_detalle' class='table table-striped table-bordered' cellspacing='0' width='100%'>
	        <thead>
	            <tr>
	                <th>Sucursal</th>
	                <th>Movimiento</th>
	                <th>Folio</th>
	                <th>Fecha</th>
	                <th>Proveedor</th>
	            </tr>
	        </thead>
	        <tbody>";
while ($row = oci_fetch_row($consulta_detalle)) {
	switch ($row[0]) {
		case '1':
			$sucursal = 'Díaz Ordaz';
			break;
		case '2':
			$sucursal = 'Arboledas';
			break;
		case '3':
			$sucursal = 'Villegas';
			break;
		case '4':
			$sucursal = 'Allende';
			break;
		case '5':
			$sucursal = 'La Petaca';
			break;
		case '99':
			$sucursal = 'CEDIS LINARES';
			break;
		default:
			$sucursal = '';
			break;
	}

	$cadena_proveedor = "SELECT PROC_NOMBRE FROM CXP_PROVEEDORES WHERE PROC_CVEPROVEEDOR = '$row[4]'";
	$consulta_proveedor = oci_parse($conexion_central, $cadena_proveedor);
	oci_execute($consulta_proveedor);
	$row_proveedor = oci_fetch_row($consulta_proveedor);
	$fila = "	
					<tr>
						<td>
							$sucursal
						</td>
						<td>
							$row[1]
						</td>
						<td>
							$row[2]
						</td>
						<td>
							$row[3]
						</td>
						<td>
							$row_proveedor[0]
						</td>
					</tr>";
	$body = $body . $fila;
}
$footer = "
	        </tbody>  
		</table>
	</div>";

$tabla1 = $encabezado . $body . $footer;


$cadena_detalle = "SELECT ALMN_ALMACEN, ENTN_ENTRADA, PROC_CVEPROVEEDOR, ENTD_FECHA, ENTC_FACTURA, ORDN_ORDEN FROM COM_ENTRADAS WHERE ENTN_ESTATUS = '1'";
$consulta_detalle = oci_parse($conexion_central, $cadena_detalle);
oci_execute($consulta_detalle);

$body = "";
//echo $cadena_detalle;
$encabezado = "
<br><hr><br>
	<div class='table-responsive'>
        <table id='lista_detalle2' class='table table-striped table-bordered' cellspacing='0' width='100%'>
	        <thead>
	            <tr>
	                <th>Sucursal</th>
	                <th>Movimiento</th>
	                <th>Folio</th>
	                <th>Fecha</th>
	                <th>Proveedor</th>
	            </tr>
	        </thead>
	        <tbody>";
while ($row = oci_fetch_row($consulta_detalle)) {
	switch ($row[0]) {
		case '1':
			$sucursal = 'Díaz Ordaz';
			break;
		case '2':
			$sucursal = 'Arboledas';
			break;
		case '3':
			$sucursal = 'Villegas';
			break;
		case '4':
			$sucursal = 'Allende';
			break;
		case '5':
			$sucursal = 'La Petaca';
			break;
		case '99':
			$sucursal = 'CEDIS LINARES';
			break;
		default:
			$sucursal = '';
			break;
	}

	$cadena_proveedor = "SELECT PROC_NOMBRE FROM CXP_PROVEEDORES WHERE PROC_CVEPROVEEDOR = '$row[2]'";
	$consulta_proveedor = oci_parse($conexion_central, $cadena_proveedor);
	oci_execute($consulta_proveedor);
	$row_proveedor = oci_fetch_row($consulta_proveedor);
	$fila = "	
					<tr>
						<td>
							$sucursal
						</td>
						<td>
							$row[1]
						</td>
						<td>
							$row[2]
						</td>
						<td>
							$row[3]
						</td>
						<td>
							$row_proveedor[0]
						</td>
					</tr>";
	$body = $body . $fila;
}
$footer = "
	        </tbody>  
		</table>
	</div>";

$tabla2 = $encabezado . $body . $footer;

$tabla = $tabla1 . $tabla2;
echo $tabla;
?>
