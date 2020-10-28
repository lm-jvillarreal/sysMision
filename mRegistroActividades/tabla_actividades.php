  <?php 
	include '../global_settings/conexion.php';
	$fecha1 = $_POST['fecha1'];
	$fecha2 = $_POST['fecha2'];
	$cadena = "SELECT
				id,
				actividad,
				fecha,
				hora_inicio,
				hora_final
				FROM
					actividades_usuario
				WHERE activo = '1' AND tipo = '2' AND fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)
				ORDER BY id DESC";
		                     						
	 $consulta = mysqli_query($conexion, $cadena);
	$cuerpo         = "";
	$numero         = 1;
	$boton_editar   = "";
	$boton_eliminar = "";
	$dif            = "";
	$date1          = "";
	$date2          = "";
	 
	  while ($row = mysqli_fetch_array($consulta)) {
			$date1 = new DateTime($row[3]);
			$date2 = new DateTime($row[4]);
			$diff = $date1->diff($date2);
			$diferencia =  $diff->format('%H:%i:%s');
			$diferencia = ($diferencia == "00:0:0")?" -":$diferencia;	
			$dif = "<button class='btn btn-danger btn-sm'><i class='fa fa-clock-o fa-sm' aria-hidden='true'></i>$diferencia</button>";
		$renglon = "
		{
			\"#\": \"$numero\",
			\"Nombre\": \"$row[1]\",
			\"Fecha\": \"$row[2]\",
		    \"Duracion\": \"$dif\",
		    \"Editar\": \"$boton_editar\",
		    \"Eliminar\": \"$boton_eliminar\"
		},";
		$cuerpo = $cuerpo.$renglon;
		$numero ++;
	}

	$cuerpo2 = trim($cuerpo, ',');
	$tabla = "
	["
	.$cuerpo2.
	"]
	";
	echo $tabla;
	?>