<?php
		include '../global_settings/conexion_supsys.php';
		error_reporting(E_ALL ^ E_NOTICE);
	    date_default_timezone_set("America/Monterrey");
	    $fecha = date('Y-m-d');		
		//include'../global_seguridad/verificar_sesion.php';
		session_start();
		ob_start();
		$s_idPerfil = $_SESSION["sTipoUsuario"];
		$s_idUsuario = $_SESSION["s_IdUser"];
		$var = $_POST['id_mapeo'];
		$qry = "SELECT
					pedido_artc.id,
					pedido_artc.fecha_pedido,
					sucursales.nombre,
					catalogos_pedidos.nombre,
					catalogos_pedidos.id
				FROM
					pedido_artc
				INNER JOIN sucursales ON sucursales.id = pedido_artc.id_sucursal
				INNER JOIN catalogos_pedidos ON catalogos_pedidos.id = pedido_artc.id_catalogo
				-- WHERE pedido_artc.fecha_pedido >= '$fecha'
				GROUP BY catalogos_pedidos.id
				AND pedido_artc.fecha_pedido";
		$exQry = mysqli_query($conexion, $qry);
		date_default_timezone_set('America/Monterrey');
		$fecha = date('Y-m-d');
 ?>
		<div class="table-responsive">
			<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>#</th>
						<th>Catalogo</th>
						<th>Fecha de pedido</th>
						<th>Ver</th>
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
								<?php echo "$row[3]"; ?>
							</td>
							<td align="center">
								<?php echo $row[1] ?>
							</td>
							<td>
								<a href="javascript:pedidos(<?php echo $row[4] ?>, '<?php echo $row[1] ?>')">Ver</a>
							</td>
						</tr>
						<?
					$n++;}
					?>
			</table>
		</div>
		</body>
