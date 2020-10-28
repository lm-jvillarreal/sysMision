<?php 
include '../global_seguridad/verificar_sesion.php';

$id_paciente = $_POST['ide'];

$cadena_detalle = "SELECT c.id, c.malestar, c.diagnostico, DATE_FORMAT(c.fecha,'%d/%m/%Y') from consulta as c where id_pacientes = '$id_paciente'";
$consulta_paciente = mysqli_query($conexion, $cadena_detalle);

//echo $cadena_detalle;
$body = "";
$encabezado = "
	<div class='table-responsive'>
        <table id='lista_consultas' class='table table-striped table-bordered' cellspacing='0' width='100%'>
	        <thead>
	            <tr>
	                <th>Malestar</th>
					<th>Diagnóstico</th>
					<th>Medicamento</th>
	                <th>Fecha</th>
	            </tr>
	        </thead>
	        <tbody>";
	        	while($row = mysqli_fetch_array($consulta_paciente))
				{
					$cadena_medicamento = "SELECT nombre_generico FROM receta WHERE id_consulta = '$row[0]'";
					$consulta_medicamento = mysqli_query($conexion,$cadena_medicamento);
					$lista = "";
					while($row_medic=mysqli_fetch_array($consulta_medicamento)){
						$lista = $lista.$row_medic[0].', ';
					}
					$lista2 = trim($lista, ',');
					$fila = "	
					<tr>
						<td>
							$row[1]
						</td>
						<td>
							$row[2]
						</td>
						<td>
							$lista2
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