<?php
		include '../global_settings/conexion_supsys.php';
		error_reporting(E_ALL ^ E_NOTICE);
		//include'../global_seguridad/verificar_sesion.php';
		session_start();
		ob_start();
		$s_idPerfil = $_SESSION["sTipoUsuario"];
		$s_idUsuario = $_SESSION["s_IdUser"];
		$id_catalogo = $_POST['id_catalogo'];
		$qry = "SELECT
					codigo,
					descripcion
				FROM
					detalle_catalogo
				WHERE
					id_catalogo = '$id_catalogo'";
		$exQry = mysqli_query($conexion, $qry);
		date_default_timezone_set('America/Monterrey');
		$fecha = date('Y-m-d');
 ?>

		<div class="table-responsive">
			<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Codigo</th>
						<th>Descripcion</th>
						<th>Cantidad</th>
					</tr>
				</thead>
				<body>
					<?php
					$n = 1;
					while($row = mysqli_fetch_array($exQry))
					{
					?>
						<tr>
							<td align="center">
								<?php echo "$row[0]"; ?>
							</td>
							<td align="center">
							<?php echo "$row[1]";?>
							<input type="hidden" value="<?php echo $row[0] ?>" name="codigo[]">
							<input type="hidden" value="<?php echo $id_catalogo ?>" name="id_catalogo">
							</td>
							<td>
								<input type="text" name="cantidad[]" id="cantidad_<?php echo "$row[0]"?>" class="form-control" value="0">
							</td>
						</tr>
						<?
					$n++;}
					?>
			</table>
		</div>
		</body>
