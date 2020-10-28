<?php
include '../global_settings/conexion.php';
//$id_mapeo = $_POST['id_mapeo'];
$qry = "SELECT
					inv_mapeo.id,
					sucursales.nombre,
					areas.nombre,
					zona,
					mueble,
					cara,
					inv_mapeo.fecha 
				FROM
					inv_mapeo 
				INNER JOIN sucursales ON sucursales.id= inv_mapeo.id_sucursal
				INNER JOIN areas ON areas.id = inv_mapeo.id_area
				WHERE inv_mapeo.activo = 1
				and inv_mapeo.completo = 1
				";
//echo "$qry";
$exQry = mysqli_query($conexion, $qry);
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
?>
<div class="table-responsive">
	<table id="lista_mapeos" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Sucursal</th>
				<th>Area</th>
				<th>Zona</th>
				<th>Mueble</th>
				<th>Cara</th>
				<th>Fecha</th>
				<th>Capturar</th>
			</tr>
		</thead>
		<body>
			<?php
			while ($row = mysqli_fetch_array($exQry)) {
				?>
				<tr>
					<td>
						<?php echo "$row[1]"; ?>
					</td>
					<td>
						<?php echo "$row[2]"; ?>
					</td>

					<td align="center">
						<?php echo "$row[3]"; ?>
					</td>
					<td align="center" width="60%">
						<?php echo "$row[4]"; ?>
					</td>

					<td><?php echo $row[5] ?></td>
					<td><?php echo $row[6] ?></td>
					<td align="center" width="5%"><a href="javascript:buscar(<?php echo $row[0] ?>, '<?php echo $row[3] ?>', '<?php echo $row[4] ?>', '<?php echo $row[5] ?>')"><i class="fa fa-eye fa-2x color-icono" aria-hidden="true"></i></a></td>
				</tr>
			<?php
			}
			?>
	</table>
</div>
</body>