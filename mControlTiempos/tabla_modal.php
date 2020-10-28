<?php 
include '../global_settings/conexion_oracle.php';

$no_folio = $_POST['ide'];
$movimiento = $_POST['movi'];
$suc = $_POST['suc'];

$cadena_detalle = "SELECT 
					ALMN_ALMACEN, 
					MODC_TIPOMOV, 
					MODN_FOLIO, 
					ARTC_ARTICULO, 
					ARTC_DESCRIPCION, 
					RMOC_UNIMEDIDA, 
					RMON_CANTSURTIDA, 
					RMON_ESTATUS, 
					TO_CHAR(RMON_COSTO_RENGLON_MB,'L99G999D99MI') 
FROM INV_MOVIMIENTO_DESC_ARTC 
WHERE MODC_TIPOMOV = '$movimiento' 
AND MODN_FOLIO = '$no_folio'
AND almn_almacen = '$suc'";
$consulta_detalle = oci_parse($conexion_central, $cadena_detalle);
oci_execute($consulta_detalle);

//echo $cadena_detalle;
$body = "";
$encabezado = "
	<div class='table-responsive'>
        <table id='lista_modulos' class='table table-striped table-bordered' cellspacing='0' width='95%'>
	        <thead>
	            <tr>
	                <th>Sucursal</th>
	                <th>Movimiento</th>
	                <th>Folio</th>
	                <th>Artículo</th>
	                <th>Descripción</th>
	                <th>U.M</th>
	                <th>Cantidad</th>
	                <th>Costo</th>
	            </tr>
	        </thead>
	        <tbody>";
	        	while($row = oci_fetch_row($consulta_detalle))
				{
					$fila = "	
					<tr>
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
							$row[3]
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
							$row[8]
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