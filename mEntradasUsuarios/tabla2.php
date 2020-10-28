<?php
    include '../global_seguridad/verificar_sesion.php';
    include '../global_settings/conexion_oracle.php';

    $fecha1 = $_POST['fecha1'];
	$fecha2 = $_POST['fecha2'];
    
    $json            = [];
    $nombre_sucursal = "";
   	$cadena = "SELECT COUNT(*) AS cantidad,US.USUC_NOMBRE
                FROM INV_MOVIMIENTOS MO
                INNER JOIN CTB_USUARIO US ON US.USUS_USUARIO = MO.MOVN_USUARIOREALIZAMOV
                WHERE MOVD_FECHAAFECTACION >= TRUNC ( TO_DATE ('$fecha1', 'YYYY/MM/DD'))
                AND MOVD_FECHAAFECTACION < TRUNC ( TO_DATE ('$fecha2', 'YYYY/MM/DD')) + 1
                AND (MODC_TIPOMOV = 'SXMCAR' OR MODC_TIPOMOV = 'SXMFTA' OR MODC_TIPOMOV = 'SXMPAN' OR MODC_TIPOMOV = 'SXMTOR' OR MODC_TIPOMOV = 'SXMBOD' OR MODC_TIPOMOV = 'SXMEDO' OR MODC_TIPOMOV = 'SXROB' OR MODC_TIPOMOV = 'SXMFCI' OR MODC_TIPOMOV = 'SFAACC' OR MODC_TIPOMOV = 'SFCBOT' OR MODC_TIPOMOV = 'EXVIGI' OR MODC_TIPOMOV = 'ECHORI' OR MODC_TIPOMOV = 'SCHORI' OR MODC_TIPOMOV = 'TRADEP' OR MODC_TIPOMOV = 'EXCONV' OR MODC_TIPOMOV = 'EXCOMP' OR MODC_TIPOMOV = 'SXMVAR' OR MODC_TIPOMOV = 'SXCONV' )
                GROUP BY US.USUC_NOMBRE ORDER BY cantidad DESC";
    $st = oci_parse($conexion_central, $cadena);
    oci_execute($st);
    $numero = 0;
    $limite = 100;
    while($row = oci_fetch_row($st)){
    	if($numero < 3){
            if($numero == 0){
                $principal = $row[0];
            }
            $porcentaje = ($row[0] * 100) / $principal;
?>
		<div class="progress-group">
		  <span class="progress-text"><?php echo $row[1];?></span>
		  <span class="progress-number"><b><?php echo $row[0];?></b></span>
        
            <div class="progress progress-sm active">
                <div class="progress-bar progress-bar-yellow progress-bar-striped" role="progressbar" aria-valuenow=" <?php echo $porcentaje;;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $porcentaje.'%';?>">
                </div>
            </div>
		  <!-- <div class="progress sm">
		    <div class="progress-bar progress-bar-yellow" style="width: <?php echo $porcentaje;?>%"></div>
		  </div> -->
		</div>
<?php	
	       $numero ++;
	    }
		$sucursal = "";
	}

?>