<?php
  	include '../global_seguridad/verificar_sesion.php';

	$tipo   = $_POST['tipo'];
	$fecha1 = $_POST['fecha1'];
	$fecha2 = $_POST['fecha2'];

	if(!empty($_POST['tipo'])){
		if($tipo == 1){ //Movimientos
			$cadena = mysqli_query($conexion,"SELECT tipo_movimiento,COUNT(*) FROM formatos_movimientos WHERE fecha BETWEEN CAST( '$fecha1' AS DATE ) AND CAST( '$fecha2' AS DATE ) GROUP BY tipo_movimiento");
			$icono = "fa-arrows-h";
		}else if ($tipo == 2){ //Sucursales
			$cadena = mysqli_query($conexion,"SELECT (SELECT nombre FROM sucursales WHERE sucursales.id = formatos_movimientos.sucursal),COUNT(*) FROM formatos_movimientos WHERE fecha BETWEEN CAST( '$fecha1' AS DATE ) AND CAST( '$fecha2' AS DATE ) GROUP BY sucursal");
			$icono = "fa-building";
		}else if ($tipo == 3){ //Estatus
			$cadena = mysqli_query($conexion,"SELECT CASE
	                estatus 
	                WHEN '0' THEN
	                'Pendiente' 
	                WHEN '1' THEN
	                'Asociado'
					WHEN '2' THEN
	                'Liberado'
					WHEN '3' THEN
	                'Cancelado'
	              END AS estatus,COUNT(*) FROM formatos_movimientos WHERE fecha BETWEEN CAST( '$fecha1' AS DATE ) AND CAST( '$fecha2' AS DATE ) GROUP BY estatus");
			$icono = "fa-building";
		}else if ($tipo == 4){ //Usuario Solicita
			$cadena = mysqli_query($conexion,"SELECT (SELECT CONCAT(personas.nombre,' ',personas.ap_paterno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = formatos_movimientos.usuario_solicita),COUNT(*) FROM formatos_movimientos WHERE fecha BETWEEN CAST( '$fecha1' AS DATE ) AND CAST( '$fecha2' AS DATE ) GROUP BY usuario_solicita");
			$icono = "fa-user";
		}else if($tipo == 5){
			$cadena = mysqli_query($conexion,"SELECT (SELECT CONCAT(personas.nombre,' ',personas.ap_paterno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = formatos_movimientos.usuario_libera),COUNT(*) FROM formatos_movimientos WHERE fecha BETWEEN CAST( '$fecha1' AS DATE ) AND CAST( '$fecha2' AS DATE ) GROUP BY usuario_libera");
			$icono = "fa-user";
		}
		$numero = 0;
		$colores = array('bg-yellow','bg-green','bg-red','bg-light-blue','bg-purple','bg-blue','bg-red','bg-maroon','bg-navy','bg-teal');
		while($row = mysqli_fetch_array($cadena)){
			if($numero == 9){
				$numero = 0;
			}
			if($tipo == 3){
				if($numero == 0){
					$icono = "fa-exclamation";
				}else{
					$icono = "fa-check";
				}
			}
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
			}else{
				continue;
			}
			$numero ++;
		}
	}else{
		$cadena = mysqli_query($conexion,"SELECT (SELECT nombre FROM sucursales WHERE sucursales.id = formatos_movimientos.sucursal),COUNT(*) FROM formatos_movimientos WHERE activo = '1' AND fecha BETWEEN CAST( '$fecha1' AS DATE ) AND CAST( '$fecha2' AS DATE ) GROUP BY sucursal");
		$icono = "fa-building";
		$numero = 0;
		
		$colores = array('bg-yellow','bg-green','bg-red','bg-light-blue','bg-purple','bg-blue','bg-red','bg-maroon','bg-navy','bg-teal');
		echo "<h4>Sucursales</h4>";
		while($row = mysqli_fetch_array($cadena)){
			if($numero == 9){
				$numero = 0;
			}
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
			}else{
				continue;
			}
			$numero ++;
		}
	}
?>