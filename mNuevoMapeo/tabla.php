<?php 
include '../global_seguridad/verificar_sesion.php';


//Filtro por sucursal en caso que aplique
if ($solo_sucursal == '1') {
	$filtro_sucursal = "AND orden_compra.id_sucursal = '$id_sede'";
}elseif($solo_sucursal == '0'){
	$filtro_sucursal = "";
}
$fecha_inicial = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];

$cadena_detalle = "SELECT
			proveedores.numero_proveedor,
			proveedores.proveedor,
			orden_compra.fecha_final,
			libro_diario.numero_nota,
			libro_diario.numero_factura,
			libro_diario.total,
			orden_compra.hora_inicio,
			orden_compra.hora_final,
			TIMEDIFF(orden_compra.hora_final, orden_compra.hora_inicio),
			libro_diario.observaciones,
			sucursales.nombre
		FROM
			libro_diario
			INNER JOIN proveedores ON libro_diario.id_proveedor = proveedores.numero_proveedor
			INNER JOIN orden_compra ON libro_diario.orden_compra = orden_compra.orden_compra
			INNER JOIN sucursales ON libro_diario.sucursal = sucursales.id
			WHERE orden_compra.activo = '0'
			AND orden_compra.status = '3'
			AND orden_compra.fecha_final >= '$fecha_inicial'
			AND orden_compra.fecha_final <= '$fecha_final'".
	        $filtro_sucursal.
			"ORDER BY libro_diario.numero_nota ASC";
$consulta_detalle = mysqli_query($conexion, $cadena_detalle);

//echo $cadena_detalle;
$body = "";
//echo $cadena_detalle;
$encabezado = "
	<div class='table-responsive'>
        <table id='lista_detalle' class='table table-striped table-bordered' cellspacing='0' width='100%'>
	        <thead>
	            <tr>
	            	<th>Folio Entrada</th>
	                <th>Cve. Proveedor</th>
	                <th>Proveedor</th>
	                <th>Fecha Entrada</th>
	                <th>Factura</th>
	                <th>Total</th>
	                <th>Hora Inicio</th>
	                <th>Hora Final</th>
	                <th>Tiempo Total</th>
	                <th>Observaciones</th>
	                <th>Sucursal</th>

	            </tr>
	        </thead>
	        <tbody>";
	        	while($row = mysqli_fetch_array($consulta_detalle))
				{
					$fila = "	
					<tr>
						<td>
							$row[3]
						</td>
						<td>
							$row[0]
						</td>
						<td>
							$row[1]
						</td>
						<td>
							$row[2]
						</td>
						<td>
							$row[4]
						</td>
						<td>
							$row[5]
						</td>
						<td>
							$row[6]
						</td>
						<td>
							$row[7]
						</td>
						<td>
							$row[8]
						</td>
						<td>
							$row[9]
						</td>
						<td>
							$row[10]
						</td>
					</tr>";
					$body = $body.$fila;
				}
$footer = "
	        </tbody>  
		</table>
	</div>";
$tabla = $encabezado.$body.$footer;
echo $tabla;