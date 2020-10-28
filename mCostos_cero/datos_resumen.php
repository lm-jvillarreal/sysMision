<?php
  	include '../global_seguridad/verificar_sesion.php';

	$tipo   = $_POST['tipo'];

	//if(!empty($_POST['tipo'])){
		if($tipo == 1){ //Movimientos
			$cadena = mysqli_query($conexion,"SELECT (SELECT CONCAT(personas.nombre,' ',personas.ap_paterno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = costos_cero.id_resuelve),COUNT(*) FROM costos_cero WHERE costos_cero.estatus = '3' GROUP BY id_resuelve");
			$icono = "fa-user";
		}else if ($tipo == 2){ //Sucursales
			$cadena = mysqli_query($conexion,"SELECT (SELECT nombre FROM sucursales WHERE sucursales.id = costos_cero.sucursal), COUNT(*) FROM costos_cero INNER JOIN usuarios ON costos_cero.id_resuelve = usuarios.id WHERE costos_cero.estatus = '3' GROUP BY sucursal");
			$icono = "fa-building";
		}
		$numero = 0;
		$colores = array('bg-yellow','bg-green','bg-red','bg-light-blue','bg-purple','bg-blue','bg-red','bg-maroon','bg-navy','bg-teal');
		while($row = mysqli_fetch_array($cadena)){
			if($row[0] != ""){

?>
			<div class="col-md-3">
				<div class="info-box <?php echo $colores[$numero];?>">
					<span class="info-box-icon"><i class="fa <?php echo $icono;?> fa-lg"></i></span>
					<div class="info-box-content">
						<span class="info-box-text"><?php echo $row[0]?></span>
						<span class="info-box-number"><?php echo $row[1]?></span>

						<div class="progress">
							<div class="progress-bar" style="width: 100%"></div>
						</div>
						<span class="progress-description">
						</span>
					</div>
					<!-- /.info-box-content -->
				</div>
			</div>
<?php
			$numero ++;
			}else{
				continue;
			}
		}
?>