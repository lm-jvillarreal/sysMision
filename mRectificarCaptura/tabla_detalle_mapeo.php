<?php
include '../global_settings/conexion_pruebas.php';
session_name("login_supsys");
session_start();
$id_mapeo = $_POST['id_mapeo'];
$qry = "SELECT
					inv_detalle_mapeo.codigo_producto,
					inv_detalle_mapeo.descripcion,
					inv_detalle_mapeo.id,
					inv_detalle_mapeo.consecutivo_mueble,
					inv_detalle_mapeo.estante 
				FROM
					inv_detalle_mapeo
					
				WHERE
					inv_detalle_mapeo.id_mapeo = '$id_mapeo' 
				ORDER BY
					inv_detalle_mapeo.id";
//echo "$qry";
$exQry = mysqli_query($conexion, $qry);
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
?>
<div class="table-responsive">
	<table id="lista_mapeos" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Nivel</th>
				<th>Consecutivo</th>
				<th>Codigo del producto</th>
				<th>Descripcion</th>
				<th>Eliminar</th>
			</tr>
		</thead>

		<body>
			<?php
			while ($row = mysqli_fetch_array($exQry)) {
				?>
				<tr>
					<td>
						<?php echo "$row[4]"; ?>
					</td>
					<td>
						<?php echo "$row[3]"; ?>
					</td>

					<td align="center">
						<?php echo "$row[0]"; ?>
					</td>
					<td align="center" width="60%">
						<?php echo "$row[1]"; ?>
					</td>
					<td align="center" width="5%"><a href="javascript:eliminar(<?php echo "$row[2]"; ?>, <?php echo "$row[3]"; ?>, <?php echo "$row[4]"; ?>);"><i class="fa fa-ban fa-2x color-icono" aria-hidden="true"></i></a></td>
				</tr>
			<?php
			}
			?>
	</table>
</div>
</body>