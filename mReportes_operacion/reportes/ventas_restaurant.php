<?php 
error_reporting(E_ALL ^ E_NOTICE);
include 'conexion_servidor.php';
$fecha_inicial = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];
$fecha_i=str_replace("-","",$fecha_inicial);
$fecha_fin=str_replace("-","",$fecha_final);
	$sql = "SELECT
				ARTC_ARTICULO,
				ARTC_DESCRIPCION,
				(
				SELECT
					NVL(SUM( VENTAS.ARTN_VENTA_C_IMPUESTO ),0) 
				FROM
					PV_VENTAS_REPORTE_VW VENTAS 
				WHERE
					VENTAS.TICN_AAAAMMDDVENTA BETWEEN '$fecha_i' 
					AND '$fecha_fin' 
					AND ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO 
					AND TICC_SUCURSAL = '1' 
				) AS DO, 
					(
				SELECT
					NVL(SUM( VENTAS.ARTN_VENTA_C_IMPUESTO ),0) 
				FROM
					PV_VENTAS_REPORTE_VW VENTAS 
				WHERE
					VENTAS.TICN_AAAAMMDDVENTA BETWEEN '$fecha_i' 
					AND '$fecha_fin' 
					AND ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO 
					AND TICC_SUCURSAL = '2' 
				) AS ARB, 
					(
				SELECT
					NVL(SUM( VENTAS.ARTN_VENTA_C_IMPUESTO ),0) 
				FROM
					PV_VENTAS_REPORTE_VW VENTAS 
				WHERE
					VENTAS.TICN_AAAAMMDDVENTA BETWEEN '$fecha_i' 
					AND '$fecha_fin' 
					AND ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO 
					AND TICC_SUCURSAL = '3' 
				) AS VIL,
				(
				SELECT
					NVL(SUM( VENTAS.ARTN_VENTA_C_IMPUESTO ),0)
				FROM
					PV_VENTAS_REPORTE_VW VENTAS 
				WHERE
					VENTAS.TICN_AAAAMMDDVENTA BETWEEN '$fecha_i' 
					AND '$fecha_fin' 
					AND ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO 
					AND TICC_SUCURSAL = '4' 
				) AS ALLE 	
				(
				SELECT
					NVL(SUM( VENTAS.ARTN_VENTA_C_IMPUESTO ),0)
				FROM
					PV_VENTAS_REPORTE_VW VENTAS 
				WHERE
					VENTAS.TICN_AAAAMMDDVENTA BETWEEN '$fecha_i' 
					AND '$fecha_fin' 
					AND ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO 
					AND TICC_SUCURSAL = '5' 
				) AS PET	
			FROM
				COM_ARTICULOS 
			WHERE
				ARTC_FAMILIA BETWEEN 419 
				AND 423";
				$st = oci_parse($conexion_central, $sql);
				oci_execute($st);
				while ($row = oci_fetch_row($st)) {
					$v_d = $v_d + $row[2];
					$v_arb = $v_arb + $row[3];
					$v_vil = $v_vil + $row[4];
					$v_all = $v_all + $row[5];

				}
				$total = $v_all + $v_d + $v_vil + $v_arb;



				//////////////////
	$sql2 = "SELECT
				ARTC_ARTICULO,
				ARTC_DESCRIPCION,
				(
				SELECT
					NVL(SUM( VENTAS.ARTN_VENTA_C_IMPUESTO ),0) 
				FROM
					PV_VENTAS_REPORTE_VW VENTAS 
				WHERE
					VENTAS.TICN_AAAAMMDDVENTA BETWEEN '$fecha_i' 
					AND '$fecha_fin' 
					AND ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO 
					AND TICC_SUCURSAL = '1' 
				) AS DO, 
					(
				SELECT
					NVL(SUM( VENTAS.ARTN_VENTA_C_IMPUESTO ),0) 
				FROM
					PV_VENTAS_REPORTE_VW VENTAS 
				WHERE
					VENTAS.TICN_AAAAMMDDVENTA BETWEEN '$fecha_i' 
					AND '$fecha_fin' 
					AND ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO 
					AND TICC_SUCURSAL = '2' 
				) AS ARB, 
					(
				SELECT
					NVL(SUM( VENTAS.ARTN_VENTA_C_IMPUESTO ),0) 
				FROM
					PV_VENTAS_REPORTE_VW VENTAS 
				WHERE
					VENTAS.TICN_AAAAMMDDVENTA BETWEEN '$fecha_i' 
					AND '$fecha_fin' 
					AND ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO 
					AND TICC_SUCURSAL = '3' 
				) AS VIL,
				(
				SELECT
					NVL(SUM( VENTAS.ARTN_VENTA_C_IMPUESTO ),0)
				FROM
					PV_VENTAS_REPORTE_VW VENTAS 
				WHERE
					VENTAS.TICN_AAAAMMDDVENTA BETWEEN '$fecha_i' 
					AND '$fecha_fin' 
					AND ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO 
					AND TICC_SUCURSAL = '4' 
				) AS ALLE 	
			FROM
				COM_ARTICULOS 
			WHERE
				ARTC_FAMILIA BETWEEN 419 
				AND 423";
				$st2 = oci_parse($conexion_central, $sql);
				oci_execute($st2);
				while ($row2 = oci_fetch_row($st2)) {
					$v_d2 = $v_d2 + $row2[2];
					$v_arb2 = $v_arb2 + $row2[3];
					$v_vil2 = $v_vil2 + $row2[4];
					$v_all2 = $v_all2 + $row2[5];

				}
				$total2 = $v_all2 + $v_d2 + $v_vil2 + $v_arb2;
				//////////////////
				
 ?>
 <script>
		$(document).ready(function() {
			$('#example').dataTable({

				"lengthMenu":
					[[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
				
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
						<th>Diaz Ordaz</th>
						<th>Arboledas</th>
						<th>Villegas</th>
						<th>Allende</th>
						<th>Total</th>

					</tr>
				</thead>
				<body>
					<tr>
						<td align="center">
							$<?php echo "$v_d"; ?>
						</td>
						<td align="center">
							$<?php echo "$v_arb"; ?>
						</td>

						<td align="center">
							$<?php echo "$v_vil"; ?>
						</td>
						<td align="center">
							$<?php echo "$v_all"; ?>
						</td>
						<td align="center">
							$<?php echo "$total" ?>
						</td>
					</tr>
					<tr>
						<td align="center">
							$<?php echo "$v_d2"; ?>
						</td>
						<td align="center">
							$<?php echo "$v_arb2"; ?>
						</td>

						<td align="center">
							$<?php echo "$v_vil2"; ?>
						</td>
						<td align="center">
							$<?php echo "$v_all2"; ?>
						</td>
						<td align="center">
							$<?php echo "$total2" ?>
						</td>
					</tr>
		</table>
		</div>
		</body>