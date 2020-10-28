<?php
		include '../global_settings/conexion_oracle.php';
    	include '../global_settings/conexion_supsys.php';
		error_reporting(E_ALL ^ E_NOTICE);
		//include'../global_seguridad/verificar_sesion.php';
		session_start();
		ob_start();
		date_default_timezone_set('America/Monterrey');
		$fecha = date('Y-m-d');
		$s_idPerfil = $_SESSION["sTipoUsuario"];
		$s_idUsuario = $_SESSION["s_IdUser"];
		$id_sucursal = $_POST['id_sucursal'];
		$sql = "SELECT
					id,
					folio_mov,
					diferencia,
					diferencia_restante,
					factura
				FROM
					notas_entrada
				WHERE
					diferencia_restante > 0
				AND id_sucursal = '$id_sucursal'";
				// echo "$sql";
		$exQry = mysqli_query($conexion, $sql);
 ?>
	<script>
		$(document).ready(function() {
			$('#example').dataTable({
				"language": {
					"url": "../assets/js/Spanish.json"
				},
				"lengthMenu":
          			[[-1], [ "All"]]
			});
		});
	</script>
		<div class="table-responsive">
			<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>#</th>
						<th>Folio</th>
						<th>Diferencia</th>
						<th>Diferencia restante</th>
						<th>Factura</th>
						<th>Subir carta</th>
					</tr>
				</thead>
				<body>
					<?php
					$n = 1;
					while($row = mysqli_fetch_array($exQry))
					{
					?>
						<tr>
							<td>
								<?php echo "$n"; ?>
							</td>
							<td align="center">
								<?php echo "$row[1]"; ?>
							</td>
							<td align="center" width="60%">
								<?php echo "$row[2]"; ?>
							</td>
							<td>
								<?php echo $row[3] ?>
							</td>
							<td align="center">
								<?php echo $row[4] ?>
							</td>
							<td align="center">
								<a href="javascript:modal(<?php echo $row[0] ?>)">Subir Carta</a>
							</td>
						</tr>
						<?
					$n++;}
					?>
			</table>
		</div>
		</body>
