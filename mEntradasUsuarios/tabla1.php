<?php
	include '../global_settings/conexion_oracle.php';
	
	$fecha1 = $_POST['fecha1'];
	$fecha2 = $_POST['fecha2'];

    $cadena = "SELECT DISTINCT
	MO.MOVN_USUARIOREALIZAMOV,
	US.USUC_NOMBRE,
	(
		SELECT
			COUNT (ALMN_ALMACEN)
		FROM
			INV_MOVIMIENTOS
		WHERE
			MOVD_FECHAAFECTACION >= TRUNC (
				TO_DATE ('$fecha1', 'YYYY/MM/DD')
			)
		AND MOVD_FECHAAFECTACION < TRUNC (
			TO_DATE ('$fecha2', 'YYYY/MM/DD')
		) + 1
		AND (
			MODC_TIPOMOV = 'ENTCOC'
			OR MODC_TIPOMOV = 'ENTSOC'
		)
		AND MOVN_USUARIOREALIZAMOV = MO.MOVN_USUARIOREALIZAMOV
	) AS Cantidad
FROM
	INV_MOVIMIENTOS MO
INNER JOIN CTB_USUARIO US ON US.USUS_USUARIO = MO.MOVN_USUARIOREALIZAMOV
WHERE
	MOVD_FECHAAFECTACION >= TRUNC (
		TO_DATE ('$fecha1', 'YYYY/MM/DD')
	)
AND MOVD_FECHAAFECTACION < TRUNC (
	TO_DATE ('$fecha2', 'YYYY/MM/DD')
) + 1
AND (
	MODC_TIPOMOV = 'ENTCOC'
	OR MODC_TIPOMOV = 'ENTSOC'
)
AND (
		 MOVN_USUARIOREALIZAMOV = '3007'
	OR MOVN_USUARIOREALIZAMOV = '3012'
	OR MOVN_USUARIOREALIZAMOV = '3013'
	OR MOVN_USUARIOREALIZAMOV = '3057'
	OR MOVN_USUARIOREALIZAMOV = '3063'
	OR MOVN_USUARIOREALIZAMOV = '3064'
	OR MOVN_USUARIOREALIZAMOV = '3102'
	OR MOVN_USUARIOREALIZAMOV = '3114'
	OR MOVN_USUARIOREALIZAMOV = '3206'
	OR MOVN_USUARIOREALIZAMOV = '3232'
) ORDER BY Cantidad DESC";

	$st = oci_parse($conexion_central, $cadena);
	oci_execute($st);
	
	$cuerpo ="";
	$numero = 1;
	$sucursal = "";

	while($row = oci_fetch_row($st)){
		// if($row[3] == 1){
		// 	$sucursal = "Diaz Ordaz";
		// }else if($row[3] == 2){
		// 	$sucursal = "Arboledas";
		// }else if($row[3] == 3){
		// 	$sucursal = "Villegas";
		// }else if($row[3] == 4){
		// 	$sucursal = "Allende";
		// }
		if($numero <= 3){
			if($numero == 1){
				$principal = $row[2];
			}
			$porcentaje = ($row[2] * 100) / $principal;
	?>
		<div class="progress-group">
	        <span class="progress-text"><?php echo $row[1].' '.$sucursal;?></span>
	        <span class="progress-number"><b><?php echo $row[2];?></b></span>

	        <div class="progress progress-sm active">
		        <div class="progress-bar progress-bar-red progress-bar-striped" role="progressbar" aria-valuenow=" <?php echo $porcentaje;;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $porcentaje.'%';?>">
		          <span class="sr-only">20% Complete</span>
		        </div>
	      	</div>
	        <!-- <div class="progress sm">
	          <div class="progress-bar progress-bar-red" style="width: <?php echo $porcentaje.'%';?>"></div>
	        </div> -->
	      </div>
	<?php
		$porcentaje = 0;
		$numero ++;
		}
	}
?>