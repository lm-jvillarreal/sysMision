<script>
	$(document).ready(function() {
		$('#example').dataTable({
			"language": {
				"url": "../assets/js/Spanish.json"
			},
			"lengthMenu": [
				[-1],
				["All"]
			]
		});
	});
</script>
<?php
error_reporting(E_ALL ^ E_NOTICE);
//include '../../configuracion/conexion.php';
//include '../global_settings/conexion_pruebas.php';
include "../global_seguridad/verificar_sesion.php";
$s_idPerfil = $_SESSION["sTipoUsuario"];
$sucursal = $_POST['id_sucursal'];
$qry = "SELECT
					inv_mapeo.fecha_conteo,
					sucursales.nombre,
					inv_mapeo.id_sucursal,
                    fm.nombre
				FROM
					inv_mapeo
				INNER JOIN sucursales ON sucursales.id = inv_mapeo.id_sucursal
                LEFT JOIN fechas_mapeo fm ON fm.fecha = inv_mapeo.fecha_conteo AND inv_mapeo.id_sucursal = fm.sucursal 
				WHERE
					inv_mapeo.activo = 0
				AND inv_mapeo.fecha_conteo IS NOT NULL
				GROUP BY inv_mapeo.fecha_conteo, inv_mapeo.id_sucursal;";
$consulta = mysqli_query($conexion, $qry);
?>
<div class="table-responsive">
	<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Fecha</th>
				<th>Sucursal</th>
				<th>Reporte</th>
				<th>Reporte Detallado</th>
				<th>Reporte mas Detallado</th>
				<th>Nombre</th>
			</tr>
		</thead>
		<tbody>
			<?php
			while ($row = mysqli_fetch_array($consulta)) { ?>
				<tr>
					<td>
						<center>
							<?php echo $row[0]; ?>
						</center>
					</td>
					<td>
						<?php echo "$row[1]"; ?>
					</td>
					<td align="center"><a href="reportes_conteo.php?fecha=<?php echo $row[0] ?>&sucursal=<?php echo $row[2] ?>">Generar reporte</a>
						<?php
						//echo "<a href='../reportes/reportes_conteo.php?fecha=$row[0]&sucursal=$row[2]'><i class='fas fa-file-excel fa-2x color-icono' aria-hidden='true'></i></a>"; 
						?>
					</td>
					<td align="center">
						<a href="reporte_detallado.php?fecha=<?php echo $row[0] ?>&sucursal=<?php echo $row[2] ?>">Generar reporte</a>
						<?php
						//echo "<a href='../reportes/reporte_detalle.php?fecha=$row[0]&sucursal=$row[2]'><i class='fas fa-file-excel fa-2x color-icono' aria-hidden='true'></i></a>";
						?>
					</td>
					<td align="center">
						<?php
						//echo "<a href='../reportes/reporte_detalle_detalle.php?fecha=$row[0]&sucursal=$row[2]'><i class='fas fa-file-excel fa-2x color-icono' aria-hidden='true'></i></a>";
						?>
					</td>
					<td><input type="text" class="form-control" value="<?php echo $row[3] ?>" onchange="javascript:insert_name('<?php echo $row[0] ?>', $(this).val(), <?php echo $row[2] ?>)" name=""></td>
				</tr>
			<?php
			}
			?>
		</tbody>
	</table>