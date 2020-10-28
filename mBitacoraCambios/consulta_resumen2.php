<?php
	include '../global_seguridad/verificar_sesion.php';

	$sucursal = $_POST['sucursal'];
	$fecha1   = $_POST['fecha1'];
	$fecha2   = $_POST['fecha2'];

	if(!empty($sucursal)){
    	$filtro_sucursal = " AND sucursal = '$sucursal'";
	}elseif(empty($sucursal)){
	    $filtro_sucursal = "";
	}

	$cadena1 = mysqli_query($conexion,"SELECT COUNT(*) FROM bitacora_cambios WHERE fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) AND liberado = '1'".$filtro_sucursal);
	$row_total = mysqli_fetch_array($cadena1);
	$total     = number_format($row_total[0], 0, '.', ',');
	/////////////// Cadena Principal ///////////////
	
	$cadena = mysqli_query($conexion,"SELECT usuario_libera,(SELECT CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno ) FROM personas INNER JOIN usuarios ON usuarios.id_persona = personas.id WHERE usuarios.id = bitacora_cambios.usuario_libera) FROM bitacora_cambios WHERE liberado = '1' AND fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) ".$filtro_sucursal." GROUP BY usuario_libera");
	
	$numero = 1;
	$color = "";
	while($row_u = mysqli_fetch_array($cadena)){
		$cadena2 = mysqli_query($conexion,"SELECT COUNT(*) FROM bitacora_cambios WHERE liberado = '1' AND usuario_libera = '$row_u[0]' AND fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)");
		$row_cadena2 = mysqli_fetch_array($cadena2);

		$porcentaje = ($row_cadena2[0] * 100) / $row_total[0];
		$porcentaje = round($porcentaje, 2) . '%';
		if($numero == 1){
			$color = "aqua";
			$numero ++;
		}else if($numero == 2){
			$color = "green";
			$numero ++;
		}else if($numero == 3){
			$color = "yellow";
			$numero ++;
		}else if($numero == 4){
			$color = "red";
			$numero = 1;
		}
		if($row_cadena2[0] != 0){
?>
	<div class="col-md-4 col-sm-6 col-xs-12">
		<div class="info-box bg-<?php echo $color?>">
			<span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
			<div class="info-box-content">
				<span class="info-box-text"><?php echo $row_u[1]?></span>
				<span class="info-box-number"><?php echo $row_cadena2[0]?></span>

				<div class="progress">
					<div class="progress-bar" style="width: <?php echo $porcentaje?>"></div>
				</div>
				<span class="progress-description">
					<?php echo $porcentaje?> del total capturado
				</span>
			</div>
			<!-- /.info-box-content -->
		</div>
		<!-- /.info-box -->
	</div>
<?php
	$color = "";
	}
}
?>