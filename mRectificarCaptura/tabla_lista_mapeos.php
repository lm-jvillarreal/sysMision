
<?php
	error_reporting(E_ALL);
//include '../global_settings/conexion_pruebas.php';
include '../global_seguridad/verificar_sesion.php';
//$id_mapeo = $_POST['id_mapeo'];
$tipo = $_POST['tipo'];
$sucursal = $_POST['sucursal'];
$area = $_POST['area'];
$p_fecha = $_POST['fecha'];

if(empty($sucursal)){
	$filtroSucursal = "";
}else{
	$filtroSucursal = " AND mapeo.id_sucursal = '$sucursal'";
}
if(empty($area)){
	$filtroArea = "";
}else{
	$filtroArea = " AND mapeo.id_area = '$area'";
}

if(empty($p_fecha)){
	$filtroFecha = "";
}else{
	$filtroFecha = " AND mapeo.fecha_conteo = '$p_fecha'";
}

date_default_timezone_set('America/Monterrey');
$fecha = date("Y-m-d");
$hora = date("H:i:s");
if ($tipo == 1) {
	//Directos
	$qry = "SELECT
					mapeo.id,
					mapeo.zona,
					mapeo.mueble,
					mapeo.cara,
					mapeo.fecha_conteo,
					usuarios.nombre_usuario,
					areas.nombre,
					sucursales.nombre,
					mapeo.auditado,
					mapeo.usuario_audita,
					(SELECT u.nombre_usuario FROM inv_captura ic INNER JOIN usuarios u ON u.id = ic.usuario WHERE ic.id_mapeo = mapeo.id LIMIT 1),
					mapeo.id_area,
					mapeo.id_sucursal,
					auditado,
					CASE contador WHEN 2 THEN 'Directos Supervisados' WHEN 6 THEN 'Capturados' WHEN 9 THEN 'Directos' END
				FROM
					inv_mapeo mapeo
				INNER JOIN sucursales ON sucursales.id = mapeo.id_sucursal
				INNER JOIN usuarios ON usuarios.id = mapeo.usuario
				INNER JOIN areas ON areas.id = mapeo.id_area
				WHERE
					mapeo.activo = 0
				AND mapeo.asignado = 0
				AND mapeo.completo = 1
				AND mapeo.contador = 9
				AND mapeo.fecha_conteo IS NOT NULL
				AND (mapeo.fecha_conteo > '2019-01-01' OR (mapeo.fecha_conteo = '0000-00-00'))".$filtroSucursal.$filtroArea.$filtroFecha;
} elseif ($tipo == 2) {
	//Directos Supervisados
	$qry = "SELECT
						mapeo.id,
						mapeo.zona,
						mapeo.mueble,
						mapeo.cara,
						mapeo.fecha_conteo,
						usuarios.nombre_usuario,
						areas.nombre,
						sucursales.nombre,
						mapeo.auditado,
						mapeo.usuario_audita,
						(SELECT u.nombre_usuario FROM inv_captura ic INNER JOIN usuarios u ON u.id = ic.usuario WHERE ic.id_mapeo = mapeo.id LIMIT 1),
						mapeo.id_area,
						mapeo.id_sucursal,
						auditado,
						CASE contador WHEN 2 THEN 'Directos Supervisados' WHEN 6 THEN 'Capturados' WHEN 9 THEN 'Directos' END
					FROM
						inv_mapeo mapeo
					INNER JOIN sucursales ON sucursales.id = mapeo.id_sucursal
					INNER JOIN usuarios ON usuarios.id = mapeo.usuario
					INNER JOIN areas ON areas.id = mapeo.id_area
					WHERE 
						mapeo.activo = 0
						and mapeo.completo = 1
					AND mapeo.fecha_conteo IS NOT NULL
					AND mapeo.fecha_conteo > '2019-01-01'
					AND mapeo.asignado = 0
					AND mapeo.contador = 6
						".$filtroSucursal.$filtroArea.$filtroFecha;
} elseif ($tipo == 3) {
	//Capturados
	$qry = "SELECT
					mapeo.id,
					mapeo.zona,
					mapeo.mueble,
					mapeo.cara,
					mapeo.fecha_conteo,
					usuarios.nombre_usuario,
					areas.nombre,
					sucursales.nombre,
					mapeo.auditado,
					mapeo.usuario_audita,
					(SELECT u.nombre_usuario FROM inv_captura ic INNER JOIN usuarios u ON u.id = ic.usuario WHERE ic.id_mapeo = mapeo.id LIMIT 1),
					mapeo.id_area,
					mapeo.id_sucursal,
					auditado,
					CASE contador WHEN 2 THEN 'Directos Supervisados' WHEN 6 THEN 'Capturados' WHEN 9 THEN 'Directos' END
				FROM
					inv_mapeo mapeo
				INNER JOIN sucursales ON sucursales.id = mapeo.id_sucursal
				INNER JOIN usuarios ON usuarios.id = mapeo.usuario
				INNER JOIN areas ON areas.id = mapeo.id_area
				WHERE
					mapeo.activo = 0
					AND mapeo.asignado = 0
					AND mapeo.completo = 1
				AND mapeo.contador = 2
				AND mapeo.fecha_conteo IS NOT NULL
				AND (mapeo.fecha_conteo > '2019-01-01') OR (mapeo.fecha_conteo <> '0000-00-00')
				".$filtroSucursal.$filtroArea.$filtroFecha;
}

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
				<th>Mapeo</th>
				<th>Captura</th>
				<th>Tipo</th>
				<th>Imprimir</th>
				<th>Editar</th>
				<th>Eliminar</th>
				<th>Auditar</th>
			</tr>
		</thead>

		<body>
			<?php
			while ($row = mysqli_fetch_array($exQry)) {
				?>
				<tr>
					<td>
						<?php echo "$row[7]"; ?>
					</td>
					<td>
						<?php echo "$row[6]"; ?>
					</td>

					<td align="center">
						<?php echo "$row[1]"; ?>
					</td>
					<td align="center">
						<?php echo "$row[2]"; ?>
					</td>

					<td><?php echo $row[3] ?></td>
					<td><?php echo $row[4] ?></td>
					<td><?php echo $row[5] ?></td>
					<td><?php echo $row[10] ?></td>
					<td><?php echo $row[14] ?></td>
					<td align="center"><a href="../mImpresion/pdfEjemplo/index_capturados.php?id=<?php echo $row[0] ?>" target="_blank"><i class="fa fa-print fa-2x color-icono" aria-hidden="true"></i></a></td>
					<td align="center" width="5%"><a href="javascript:buscar(<?php echo $row[0] ?>, '<?php echo $row[1] ?>', '<?php echo $row[2] ?>', '<?php echo $row[3] ?>', <?php echo $row[11] ?>, '<?php echo $row[4] ?>', <?php echo $row[12] ?>)"><i class="fa fa-eye fa-2x color-icono" aria-hidden="true"></i></a></td>
					<td><a href="#" onclick="javascript:eliminar_captura(<?php echo $row[0] ?>)"><i class="fa fa-trash fa-2x color-icono" aria-hidden="true"></i></a></td>
					<?php if ($row[13] == 0) {
						$v = "";
					}else{
						$v = "checked";
					} ?>
					<td><input type="checkbox" onchange="javascript:auditar(<?php echo $row[0] ?>)" name="" <?php echo $v ?>></td>
				</tr>
			<?php
			}
			?>
	</table>
</div>