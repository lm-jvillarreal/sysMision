<?php
		include '../global_settings/conexion_oracle.php';
		error_reporting(E_ALL ^ E_NOTICE);
		//include'../global_seguridad/verificar_sesion.php';
		session_start();
		ob_start();
		$s_idPerfil = $_SESSION["sTipoUsuario"];
		$s_idUsuario = $_SESSION["s_IdUser"];
		$factura = $_POST['factura'];
		$proveedor = $_POST['proveedor'];
		$proveedor = trim($proveedor);
		$tipo = $_POST['tipo'];
		$qry = "SELECT ALMN_ALMACEN, MODN_FOLIO, MOVD_FECHAAFECTACION 
				FROM INV_MOVIMIENTOS 
				WHERE 
				    MODC_TIPOMOV = '$tipo' 
				AND 
				    MOVC_CVEPROVEEDOR = '$proveedor' 
				AND 
				    MOVC_CXP_REMISION = '$factura'";

	    $st = oci_parse($conexion_central, $qry);
	    oci_execute($st);
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
          			[[-1], [ "All"]]
			});
		});
	</script>
		<div class="table-responsive">
			<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>#</th>
						<th>Sucursal</th>
						<th>Folio</th>
						<th>Fecha</th>
					</tr>
				</thead>
				<body>
					<?php
					$n = 1;
					while($row = oci_fetch_row($st))
					{
						if ($row[0] == 1) {
							$sucursal = "Diaz Ordaz";
						}elseif ($row[0] == 2) {
							$sucursal = "Arboledas";
						}elseif ($row[0] == 3) {
							$sucursal = "Villegas";
						}elseif($row[0] == 4){
							$sucursal = "Allende";
						}
					?>
						<tr>
							<td>
								<?php echo $n; ?>
							</td>
							<td align="center">
								<?php echo "$sucursal"; ?>
							</td>
							<td align="center" width="60%">
								<?php echo "$row[1]"; ?>
							</td>
							<td>
								<?php echo $row[2] ?>
							</td>
						</tr>
						<?
					$n++;}
					?>
			</table>
		</div>
		</body>
