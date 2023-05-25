<?php
include '../global_settings/conexion.php';
$qry = "SELECT
				mapeo.id,
				mapeo.zona,
				mapeo.mueble,
				mapeo.cara,
				mapeo.fecha,
				mapeo.impreso,
				mapeo.id_sucursal,
				areas.nombre,
				sucursales.nombre
			FROM
				inv_mapeo mapeo 
			INNER JOIN sucursales ON sucursales.id = mapeo.id_sucursal
			INNER JOIN areas ON areas.id = mapeo.id_area
			
			WHERE mapeo.activo = 1
			AND mapeo.completo = 1
			AND mapeo.impreso = 1
			AND mapeo.id_sucursal = '$id_sede'";
$consulta = mysqli_query($conexion, $qry);
?>
<div class="table-responsive">
	<table id="impresos" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Sucursal</th>
				<th width='10%'>Area</th>
				<th>Zona</th>
				<th width='40%'>Mueble</th>
				<th width='40%'>Cara</th>
				<th width='45%'>Fecha</th>
				<th width='3%'></th>
				<th width='3%'></th>
				<th width='3%'></th>
			</tr>
		</thead>
		<tbody>
			<?php
			while ($row = mysqli_fetch_array($consulta)) {	?>
				<tr>
					<td><?php echo $row[8] ?></td>
					<td>
						<?php echo "$row[7]" ?>
					</td>
					<td>
						<center>
							<?php echo $row[1]; ?>
						</center>
					</td>
					<td>
						<?php echo "$row[2]"; ?>
					</td>
					<td>
						<?php echo "$row[3]"; ?>
					</td>
					<td>
						<?php echo "$row[4]"; ?>
					</td>
					<td align="center" width="5%">
						<a target="_blank" href="pdfEjemplo/index_reimpresion.php?id=<?php echo $row[0] ?>"><i class="fa fa-print fa-2x color-icono" aria-hidden="true"></i></a>
						</a>
					</td>
					<td align="center" width="5%">
						<a target="_blank" href="pdfEjemplo/index_revision.php?id=<?php echo $row[0] ?>"><i class="fa fa-print fa-2x color-icono" aria-hidden="true"></i></a>
						</a>
					</td>
					<td align="center">
						<div class="checkbox">
							<label><input id="impreso" <?php if ($row[5] == 1) {
																						echo "checked";
																					} else {
																					} ?> name="impreso" value="<?php echo $row[0]; ?>" type="checkbox" onclick="desmarcar(<?php echo $row[0]; ?>);"></label>
						</div>
					</td>
				</tr>
			<?php
			}
			?>
		</tbody>
	</table>
</div>