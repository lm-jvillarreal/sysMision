<?php
$qry = "SELECT
				mapeo.id,
				mapeo.zona,
				mapeo.mueble,
				mapeo.cara,
				mapeo.fecha,
				mapeo.impreso,
				mapeo.id_sucursal,
				areas.nombre
			FROM
				inv_mapeo mapeo 
			INNER JOIN areas ON areas.id = mapeo.id_area
			
			WHERE mapeo.activo = 1
			AND mapeo.completo = 1
			AND mapeo.impreso = 0
			AND mapeo.id_sucursal = '$id_sede'";
$consulta = mysqli_query($conexion, $qry);
?>
<div class="table-responsive">
	<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th width='5%'>Area</th>
				<th>Zona</th>
				<th>Mueble</th>
				<th>Cara</th>
				<th>Fecha</th>
				<th>PDF</th>
				<th>Excel</th>
				<th>Revision</th>
				<th width='5%'>Status</th>
			</tr>
		</thead>
		<tbody>
			<?php
			while ($row = mysqli_fetch_array($consulta)) {	?>
				<tr>
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
						<a target="_blank" href="pdfEjemplo/index.php?id=<?php echo $row[0] ?>"><i class="fa fa-print fa-2x color-icono" aria-hidden="true"></i></a>
						</a>
					</td>
					<td align="center" width="5%">
						<a target="_blank" href="pdfEjemplo/index_revision.php?id=<?php echo $row[0] ?>"><i class="fa fa-print fa-2x color-icono" aria-hidden="true"></i></a>
						</a>
					</td>
					<td align="center" width="5%">
						<a target="_blank" href="rpt_mapeos.php?id=<?php echo $row[0] ?>"><i class="fa fa-file-excel-o fa-2x color-icono" aria-hidden="true"></i></a>
						</a>
					</td>
					<td align="center">
						<div class="checkbox">
							<label><input id="impreso" <?php if ($row[5] == 1) {
																							echo "checked";
																						} else { } ?> name="impreso" value="<?php echo $row[0]; ?>" type="checkbox" onclick="cambiar_estado(<?php echo $row[0]; ?>);"></label>
						</div>
					</td>
				</tr>
			<?php
			}
			?>
		</tbody>
	</table>
</div>