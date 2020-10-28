<?php 
include '../global_settings/conexion_oracle.php';

$no_folio = $_POST['ide'];

$cadena_detalle = "SELECT
				INV_RENGLONES_TRANSFERENCIA.ARTC_ARTICULO,
				PV_ARTICULOS.ARTC_DESCRIPCION,
				INV_RENGLONES_TRANSFERENCIA.RTRN_CANTIDAD_SALIDA,
				INV_RENGLONES_TRANSFERENCIA.RTRN_CANTIDAD_ENTRADA 
			FROM
				INV_RENGLONES_TRANSFERENCIA
				INNER JOIN PV_ARTICULOS ON INV_RENGLONES_TRANSFERENCIA.ARTC_ARTICULO = PV_ARTICULOS.ARTC_ARTICULO 
			WHERE
				TRAN_ID_CONSECUTIVO = '$no_folio'";
$consulta_detalle = oci_parse($conexion_central, $cadena_detalle);
oci_execute($consulta_detalle);

//echo $cadena_detalle;
$body = "";
$encabezado = "
	<div class='table-responsive'>
        <table id='lista_modulos' class='table table-striped table-bordered' cellspacing='0' width='100%'>
	        <thead>
	            <tr>
	                <th>Artículo</th>
	                <th>Descripción</th>
	                <th>Cant. Salida</th>
	                <th>Cant. Entrada</th>
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
					</tr>";
					$body = $body.$fila;
				}
$footer = "
	        </tbody>  
		</table>
	</div>";

$tabla = $encabezado.$body.$footer;

echo $tabla;