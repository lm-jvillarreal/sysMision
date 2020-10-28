<?php
		include '../global_settings/conexion.php';
		error_reporting(E_ALL ^ E_NOTICE);
		//include'../global_seguridad/verificar_sesion.php';
		session_start();
		ob_start();
		$s_idPerfil = $_SESSION["sTipoUsuario"];
		$s_idUsuario = $_SESSION["s_IdUser"];
		$id_sucursal = $_POST['id_sucursal'];
		$qry = "SELECT
					id,
					folio_mov,
					tipo_mov,
					id_sucursal,
					total_entrada,
					total_factura,
					diferencia,
					factura,
					ruta_carta,
					proveedor,
					fecha,
					marcado
				FROM
					notas_entrada
				WHERE id_sucursal = '$id_sucursal'
				AND marcado = 0";
				//echo "$qry";
		$exQry = mysqli_query($conexion, $qry);
		date_default_timezone_set('America/Monterrey');
		$fecha = date('Y-m-d');
 ?>
	<script>
		$(document).ready(function() {
			$('#example').dataTable({
				"language": {
					"url": "../assets/js/Spanish.json"
				},
				"lengthMenu":
          			[
          				[-1], [ "All"]
      				]
			});
		});
	</script>
		<div class="table-responsive">
			<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Fecha</th>
						<th>Sucursal</th>
						<th>Folio</th>
						<th>Proveedor</th>
						<th>Factura</th>
						<th>Total entrada</th>
						<th>Total Factura</th>
						<th>Diferencia</th>
						<th>Carta faltante</th>
						<th>Dif. en costos</th>
						<th>Eliminar</th>
						<th>M</th>
					</tr>
				</thead>
				<body>
					<?php
					$n = 1;
					while($row = mysqli_fetch_array($exQry))
					{
						if ($row[3] == '1') {
							$sucursal = "Diaz Ordaz";
						}elseif ($row[3] == '2') {
							$sucursal = "Arboledas";
						}elseif ($row[3] == '3') {
							$sucursal = "Villegas";
						}
						elseif ($row[3] == '4'){
							$sucursal = "Allende";
						}
					?>
						<tr>
							<td><?php echo $row[10] ?></td>
							<td>
								<?php echo "$sucursal"; ?>
							</td>
							<td align="center">
								<?php echo $row[1]; ?>
							</td>
							<td align="center">
								<?php echo $row[9] ?>
							</td>
							<td align="center">
								<?php echo "$row[7]"; ?>
							</td>
							<td>
								<?php echo "$row[4]" ?>
							</td>
							<td>
								<?php echo $row[5] ?>
							</td>
							<td align="center">
								<?php echo $row[6] ?>
							</td>
							<td align="center">
							<a href="<?php echo $row[8] ?>"><i class='btn btn-danger' aria-hidden='true'><span class="fa fa-file-text"></span>
								</i>
							</a>
							</td>
							<td align="center"><a href="pdfEjemplo/index.php?id=<?php echo $row[0] ?>" target="_blank"><i class="btn btn-danger "><span class="fa fa-file-pdf-o"></span></i>
							</a></td>
							<td align="center">
								<a onclick="javascript:eliminar_dif(<?php echo $row[0] ?>)" class="btn btn-danger">Eliminar dif</a>
							</td>
							<td align="center">
								<input type="checkbox"

								<?php if ($row[11]==1) {
									echo "checked";
								} ?> onchange="javascript:marcar(<?php echo $row[0] ?>)">
							</td>
						</tr>
						<?php
					$n++;}
					?>
			</table>
		</div>
	</body>
