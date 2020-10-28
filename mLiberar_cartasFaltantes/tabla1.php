<?php 
include '../global_settings/conexion.php';

$fecha_inicial = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];

$cadena_detalle = "SELECT
	carta_faltante.id,
	carta_faltante.id_orden,
	carta_faltante.no_orden,
	carta_faltante.tipo_orden,
	carta_faltante.numero_proveedor,
	proveedores.proveedor,
	carta_faltante.no_factura,
	sucursales.nombre
FROM
	carta_faltante
	INNER JOIN proveedores ON carta_faltante.id_proveedor = proveedores.id
	INNER JOIN sucursales ON carta_faltante.id_sucursal = sucursales.id
	WHERE carta_faltante.activo = '1'
	AND (carta_faltante.fecha_elaboracion >= '$fecha_inicial' AND carta_faltante.fecha_elaboracion <= '$fecha_final')
	".$filtro_sucursal.$filtro_proveedor;
	$consulta_detalle = mysqli_query($conexion, $cadena_detalle);

//echo $cadena_detalle;
$body = "";
//echo $cadena_detalle;
$encabezado = "
	<div class='table-responsive'>
        <table id='lista_detalle' class='table table-striped table-bordered' cellspacing='0' width='100%'>
	        <thead>
	            <tr>
	                <th width=\"5%\">Folio</th>
	                <th width=\"10%\">No. O. C.</th>
	                <th width=\"10%\">Cve. Proveedor</th>
	                <th>Proveedor</th>
	                <th width=\"15%\">No. Factura</th>
	                <th width=\"10%\">Sucursal</th>
	                <th width=\"8%\">Ver</th>
	                <th width=\"10%\">Modificar</th>
	                <th width=\"10%\">Totales</th>
	            </tr>
	        </thead>
	        <tbody>";
	        	while($row = mysqli_fetch_array($consulta_detalle))
				{
					$fila = "	
					<tr>
						<td>
							$row[0] 
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
						<td align=\"center\">
							<a href=\"carta_faltante_pdf.php?id=$row[0]\" class=\"btn btn-warning text-center\" target=\"blank\">Ver</a>
						</td>
						<td align=\"center\">
							<a href=\"carta_faltante.php?id=$row[0]\" class=\"btn btn-success text-center\">Modificar</a>
						</td>
						<td align=\"center\">
							<a href=\"#\" class=\"btn btn-danger text-center\">Agregar</a>
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
