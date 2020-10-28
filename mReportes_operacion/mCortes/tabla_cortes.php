<?php
		include 'conexion_servidor.php';
		session_name("login_supsys"); 
		session_start(); 
		date_default_timezone_set('America/Monterrey');
		$fecha = date('Y-m-d');
		$sucursal = $_SESSION["s_Sucursal"];
		$almacen = $_POST['sucursal'];
		$faltante_total = 0;
		$sobrante_total = 0;
		$date1 = date_create($_POST['fecha_inicial']);
		$date2 = date_create($_POST['fecha_final']);
		$fechauno = date_format($date1, 'd-m-Y');
		$fechados = date_format($date2, 'd-m-Y');
		//$fechados = "11-07-2018";
		$fechaaamostar = $fechauno;
		$truncate = "TRUNCATE sobrantes_faltantes";
		$exTr = mysqli_query($conexion, $truncate);
		while(strtotime($fechados) >= strtotime($fechauno))
		{
			if(strtotime($fechados) != strtotime($fechaaamostar))
			{
				$qry = "SELECT
					PV_ACUMULADOS.CCAC_CAJERO,
					(
						SUM (
							PV_ACUMULADOS.ACUN_MONTOVENTA
						) - SUM (
							PV_ACUMULADOS.ACUN_CASHBACK
						)
					) AS NETO,
					SUM(PV_ACUMULADOS.ACUN_TOTALCAPTURADO) CAPTURADO,
					CFG_USUARIOS.USUC_NOMBRE,
					CFG_USUARIOS.USUC_EMAIL
				FROM
					PV_ACUMULADOS
				INNER JOIN PV_CORTEDECAJA ON PV_CORTEDECAJA.CCAC_CAJERO = PV_ACUMULADOS.CCAC_CAJERO
				AND PV_CORTEDECAJA.CCAC_SUCURSAL = PV_ACUMULADOS.CCAC_SUCURSAL
				AND PV_CORTEDECAJA.CCAN_CONSECORTE = PV_ACUMULADOS.CCAN_CONSECORTE
				INNER JOIN CFG_USUARIOS ON CFG_USUARIOS.USUN_ID = PV_ACUMULADOS.CCAC_CAJERO
				WHERE CAAD_FECHAHORACORTE >= TRUNC (
					TO_DATE ('$fechaaamostar', 'DD/MM/YYYY')
				)
				AND CAAD_FECHAHORACORTE < TRUNC (
					TO_DATE ('$fechaaamostar', 'DD/MM/YYYY')
				) + 1
				AND PV_ACUMULADOS.CCAC_SUCURSAL = '$almacen'
				AND PV_ACUMULADOS.ACUN_CVECOBRODEV = '1'
				AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '5CRE-DO'
				AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '2PE-DO'
				AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '3PEE-DO'
				AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '5CRE-ARB'
				AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '2PE-ARB'
				AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '3PEE-ARB'
				AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '5CREDITO'
				AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '2PELECT'
				AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '3PELEC-ESP'
				AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '5CRE-ALL'
				AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '2PE-ALL'
				AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '3PEE-ALL'
				GROUP BY
				PV_ACUMULADOS.CCAC_CAJERO,
					CFG_USUARIOS.USUC_NOMBRE,
					CFG_USUARIOS.USUC_EMAIL
				ORDER BY
					PV_ACUMULADOS.CCAC_CAJERO";
				$st = oci_parse($conexion_central, $qry);
				oci_execute($st);
				//echo "$fechaaamostar<br />";
				
				while ($row = oci_fetch_row($st)) {
					$qry_dev = "SELECT
								ACUMU.CCAC_CAJERO,
								SUM (ACUMU.ACUN_MONTOVENTA)
								
							FROM
								PV_ACUMULADOS ACUMU
							INNER JOIN PV_CORTEDECAJA CORTE ON CORTE.CCAC_CAJERO = ACUMU.CCAC_CAJERO
							AND CORTE.CCAC_SUCURSAL = ACUMU.CCAC_SUCURSAL
							AND CORTE.CCAN_CONSECORTE = ACUMU.CCAN_CONSECORTE
							WHERE
								ACUMU.ACUC_FORMADEPAGO = '1EFE'
							AND CAAD_FECHAHORACORTE >= TRUNC (
								TO_DATE ('$fechaaamostar', 'DD/MM/YYYY')
							)
							AND CAAD_FECHAHORACORTE < TRUNC (
								TO_DATE ('$fechaaamostar', 'DD/MM/YYYY')
							) + 1
							AND ACUMU.CCAC_SUCURSAL = '$almacen'
							AND ACUMU.ACUN_CVECOBRODEV = '-1'
							AND ACUMU.CCAC_CAJERO = '$row[0]'
							GROUP BY
								ACUMU.CCAC_CAJERO
							ORDER BY
								ACUMU.CCAC_CAJERO";
					$st_dev = oci_parse($conexion_central, $qry_dev);
					oci_execute($st_dev);
					$row_dev = oci_fetch_row($st_dev);
					$neto_real = $row[1] - $row_dev[1];
					$total = $neto_real - $row[2];
					$total = round($total, 2);

					if ($total < 0) {
						$sobrante_total = $total;
						$sobrante_total = abs($sobrante_total);
					}else{
						$faltante_total = $total;
						$faltante_total = abs($total);
					}
					$insert = "INSERT INTO sobrantes_faltantes (
									fecha,
									sobrante,
									faltante,
									cajero,
									nombre_cajero,
									num_empleado
								)
								VALUES
									('$fechaaamostar', '$sobrante_total', '$faltante_total', '$row[0]', '$row[3]', '$row[4]')";
					$exInsert = mysqli_query($conexion, $insert);
					$faltante_total = 0;
					$sobrante_total = 0;
				}
				$fechaaamostar = date("d-m-Y", strtotime($fechaaamostar . " + 1 day"));
			}
			else
			{

				$qry = "SELECT
					PV_ACUMULADOS.CCAC_CAJERO,
					(
						SUM (
							PV_ACUMULADOS.ACUN_MONTOVENTA
						) - SUM (
							PV_ACUMULADOS.ACUN_CASHBACK
						)
					) AS NETO,
					SUM(PV_ACUMULADOS.ACUN_TOTALCAPTURADO) CAPTURADO,
					CFG_USUARIOS.USUC_NOMBRE,
					CFG_USUARIOS.USUC_EMAIL
				FROM
					PV_ACUMULADOS
				INNER JOIN PV_CORTEDECAJA ON PV_CORTEDECAJA.CCAC_CAJERO = PV_ACUMULADOS.CCAC_CAJERO
				AND PV_CORTEDECAJA.CCAC_SUCURSAL = PV_ACUMULADOS.CCAC_SUCURSAL
				AND PV_CORTEDECAJA.CCAN_CONSECORTE = PV_ACUMULADOS.CCAN_CONSECORTE
				INNER JOIN CFG_USUARIOS ON CFG_USUARIOS.USUN_ID = PV_ACUMULADOS.CCAC_CAJERO
				WHERE CAAD_FECHAHORACORTE >= TRUNC (
					TO_DATE ('$fechaaamostar', 'DD/MM/YYYY')
				)
				AND CAAD_FECHAHORACORTE < TRUNC (
					TO_DATE ('$fechaaamostar', 'DD/MM/YYYY')
				) + 1
				AND PV_ACUMULADOS.CCAC_SUCURSAL = '$almacen'
				AND PV_ACUMULADOS.ACUN_CVECOBRODEV = '1'
				AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '5CRE-DO'
				AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '2PE-DO'
				AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '3PEE-DO'
				AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '5CRE-ARB'
				AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '2PE-ARB'
				AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '3PEE-ARB'
				AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '5CREDITO'
				AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '2PELECT'
				AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '3PELEC-ESP'
				AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '5CRE-ALL'
				AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '2PE-ALL'
				AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '3PEE-ALL'
				GROUP BY
				PV_ACUMULADOS.CCAC_CAJERO,
					CFG_USUARIOS.USUC_NOMBRE,
					CFG_USUARIOS.USUC_EMAIL
				ORDER BY
					PV_ACUMULADOS.CCAC_CAJERO";
			$st = oci_parse($conexion_central, $qry);
			oci_execute($st);
				while ($row = oci_fetch_row($st)) {
					$qry_dev = "SELECT
								ACUMU.CCAC_CAJERO,
								SUM (ACUMU.ACUN_MONTOVENTA)
							FROM
								PV_ACUMULADOS ACUMU
							INNER JOIN PV_CORTEDECAJA CORTE ON CORTE.CCAC_CAJERO = ACUMU.CCAC_CAJERO
							AND CORTE.CCAC_SUCURSAL = ACUMU.CCAC_SUCURSAL
							AND CORTE.CCAN_CONSECORTE = ACUMU.CCAN_CONSECORTE
							WHERE
								ACUMU.ACUC_FORMADEPAGO = '1EFE'
							AND CAAD_FECHAHORACORTE >= TRUNC (
								TO_DATE ('$fechaaamostar', 'DD/MM/YYYY')
							)
							AND CAAD_FECHAHORACORTE < TRUNC (
								TO_DATE ('$fechaaamostar', 'DD/MM/YYYY')
							) + 1
							AND ACUMU.CCAC_SUCURSAL = '$almacen'
							AND ACUMU.ACUN_CVECOBRODEV = '-1'
							AND ACUMU.CCAC_CAJERO = '$row[0]'
							GROUP BY
								ACUMU.CCAC_CAJERO
							ORDER BY
								ACUMU.CCAC_CAJERO";
					$st_dev = oci_parse($conexion_central, $qry_dev);
					oci_execute($st_dev);
					$row_dev = oci_fetch_row($st_dev);
					$neto_real = $row[1] - $row_dev[1];
					$total = $neto_real - $row[2];
					$total = round($total, 2);

					if ($total < 0) {
						$sobrante_total = $total;
						$sobrante_total = abs($sobrante_total);
					}else{
						$faltante_total = $total;
						$faltante_total = abs($total);
					}

					$insert = "INSERT INTO sobrantes_faltantes (
									fecha,
									sobrante,
									faltante,
									cajero,
									nombre_cajero,
									num_empleado
								)
								VALUES
									('$fechaaamostar', '$sobrante_total', '$faltante_total', '$row[0]', '$row[3]', '$row[4]')";
					$exInsert = mysqli_query($conexion, $insert);
					$faltante_total = 0;
					$sobrante_total = 0;
				}

				//echo "$fechaaamostar<br />";
				break;
			}
		}
        
 ?>

 <?php 
 	$qry_sql = "SELECT
					cajero,
					nombre_cajero,
					ROUND(SUM(sobrante),2),
					ROUND(SUM(faltante),2),
					num_empleado
				FROM
					sobrantes_faltantes
				GROUP BY
					cajero";
	$exQry_sql = mysqli_query($conexion, $qry_sql);
  ?>
	<script>
		$(document).ready(function() {
			$('#example2').dataTable({

				"lengthMenu":
					[[-1], [ "All"]],
				
				 "language": {
				"url": "../assets/js/Spanish.json"
				 }
			});
		});
	</script>
	<div class="table-responsive">
	    <table id="example2" class="table table-striped table-bordered" cellspacing="0" width="100%">
	      <thead>
	        <tr>
        		<th>Cajero</th>
        		<th># Empleado</th>
        		<th>Nombre Cajero</th>
	          	<th>Sobrante total</th>
	          	<th>Faltante total</th>
	        </tr>
	      </thead>
	      <body>
	        <?php
	        while($row = mysqli_fetch_row($exQry_sql))
	        {
	        ?>
	          <tr>
	          	<td>
	          		<?php echo $row[0] ?>
	          	</td>
	          	<td>
	          		<?php echo $row[4] ?>
	          	</td>
	          	<td>
	          		<?php echo $row[1] ?>
	          	</td>
	            <td>
	              <?php echo $row[2]; ?>
	            </td>
	            <td>
	              <?php echo $row[3] ?>
	            </td>
	          </tr>
	          <?
	        }
	        ?>
	    </table>
	</div>
</body>
