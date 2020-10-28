<?php
	include '../global_seguridad/verificar_sesion.php';
	include '../global_settings/conexion_oracle.php';
	
	$fecha1 = $_POST['fecha1'];
	$fecha2 = $_POST['fecha2'];

	$numero = 1;
	$cuerpo = "";
	$sucursal = "";

	$cadena1 = "SELECT COUNT(*) AS Cantidad,ALMN_ALMACEN  FROM INV_MOVIMIENTOS WHERE (MODC_TIPOMOV = 'SXMCAR' OR MODC_TIPOMOV = 'SXMFTA' OR MODC_TIPOMOV = 'SXMPAN' OR MODC_TIPOMOV = 'SXMTOR' OR MODC_TIPOMOV = 'SXMBOD' OR MODC_TIPOMOV = 'SXMEDO' OR MODC_TIPOMOV = 'SXROB' OR MODC_TIPOMOV = 'SXMFCI' OR MODC_TIPOMOV = 'SFAACC' OR MODC_TIPOMOV = 'SFCBOT' OR MODC_TIPOMOV = 'EXVIGI' OR MODC_TIPOMOV = 'ECHORI' OR MODC_TIPOMOV = 'SCHORI' OR MODC_TIPOMOV = 'TRADEP' OR MODC_TIPOMOV = 'EXCONV' OR MODC_TIPOMOV = 'EXCOMP' OR MODC_TIPOMOV = 'SXMVAR' OR MODC_TIPOMOV = 'SXCONV' ) AND MOVD_FECHAAFECTACION >= TRUNC (TO_DATE ('$fecha1', 'YYYY/MM/DD')) AND MOVD_FECHAAFECTACION<TRUNC(TO_DATE('$fecha2','YYYY/MM/DD'))+1  GROUP BY ALMN_ALMACEN ORDER BY Cantidad DESC";
	$st1 = oci_parse($conexion_central, $cadena1);
	oci_execute($st1);
	$numero = 1;
    while ($row = oci_fetch_row($st1)) {
    	if($row[1] == 1){
    		$sucursal = "Diaz Ordaz";
    	}else if($row[1] == 2){
    		$sucursal = "Arboledas";
    	}else if($row[1] == 3){
    		$sucursal = "Villegas";
    	}else if($row[1] == 4){
    		$sucursal = "Allende";
    	}else if($row[1] == 5){
    		$sucursal = "La Petaca";
    	}else if($row[1] == 99){
    		$sucursal = "CEDIS";
    	}
    	if($numero == 1){
            $principal = $row[0];
        }
        $porcentaje = ($row[0] * 100) / $principal;
	?>
		<div class="progress-group">
	      <span class="progress-text"><?php echo $sucursal;?></span>
	      <span class="progress-number"><b><?php echo $row[0];?></b></span>

			<div class="progress progress-sm active">
		        <div class="progress-bar progress-bar-green progress-bar-striped" role="progressbar" aria-valuenow=" <?php echo $porcentaje;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $porcentaje.'%';?>">
		        </div>
		    </div>
	      <!-- <div class="progress sm">
	        <div class="progress-bar progress-bar-black" style="width: <?php echo $porcentaje.'%'?>"></div>
	      </div> -->
	    </div>
	<?php
		$numero ++;
}
?>    