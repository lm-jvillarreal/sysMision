<?php 
include '../global_settings/conexion_oracle.php';
include '../global_settings/conexion.php';

$id_referencia = $_POST['id_referencia'];

$cadena_detalle = "SELECT
						id,
						codigo,
						descripcion,
						total,
						c_do,
						c_arb,
						c_vil,
						c_all,
						c_total,
						diferencia 
					FROM
						renglones_referencia 
						WHERE id_referencia = '$id_referencia'";
$consulta_detalle = mysqli_query($conexion, $cadena_detalle);

//echo $cadena_detalle;
$body = "";
$encabezado = "
	<div class='table-responsive'>
        <table id='lista_modulos' class='table table-striped table-bordered' cellspacing='0' width='95%'>
	        <thead>
	            <tr>
	                
	                <th width='5%'>Codigo</th>
	                <th>Descripcion</th>
	                <th width='5%'>DO</th>
	                <th width='5%'>Arb</th>
	                <th width='5%'>Vil</th>
	                <th width='5%'>All</th>
	                <th width='5%'>TS</th>
	                <th width='5%'>TC</th>
	                <th width='5%'>DIF</th>
	            </tr>
	        </thead>
	        <tbody>";
	        	while($row = mysqli_fetch_row($consulta_detalle))
				{
					$fila = "	
					<tr>
						<td>
							$row[1]
						</td>
						<td>
							$row[2]
						</td>
						<td>
							$row[4]
						</td>
						<td>$row[5]</td>
						<td>$row[6]</td>
						<td>$row[7]</td>
						<td>$row[8]</td>
						<td>$row[3]</td>
						<td>$row[9]</td>
					</tr>";
					$body = $body.$fila;
				}
$footer = "
	        </tbody>  
		</table>
	</div>";

$tabla = $encabezado.$body.$footer;

echo $tabla;