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
	<script>
		$(document).ready(function() {
			$('#example').dataTable({

				"lengthMenu":
					[[-1], [ "All"]],
				
				 "language": {
				"url": "../assets/js/Spanish.json"
				 }
			});
		});
	</script>
		<div class="table-responsive">
			<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>#</th>
						<th>Codigo del producto</th>
						<th>Descripcion</th>
						<th>Cantidad</th>
					</tr>
				</thead>
				<body>
					<?php
						$n=1; 
					while($row = mysqli_fetch_array($exQry))
					{
					?>
						<tr>
							<td>
								<?php echo "$n"; ?>
							</td>

							<td align="center">
								<?php echo "$row[0]"; ?>
							</td>
							<td align="center" width="60%">
								<?php echo "$row[1]"; ?>
							</td>
							<td align="center" width="5%">
								<input type="text" class="form-control" name="">
							</td>
						</tr>
					
						<?
					$n++;
				}
					?>
			</table>
		</div>
		</body>
