  <?php 
	include '../global_seguridad/verificar_sesion.php';

	$usuario = $_POST['usuario'];
	$fecha1  = $_POST['fecha1'];
	$fecha2  = $_POST['fecha2'];
	
	$cadena = "SELECT folio,actividad,SEC_TO_TIME(TIME_TO_SEC(hora_final) - TIME_TO_SEC(hora_inicio)),estatus
				FROM actividades_usuario
				WHERE activo = '1' AND tipo = '2' AND fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) AND id_usuario = '$usuario'";
		                     						
	$consulta = mysqli_query($conexion, $cadena);
	$cuerpo   = "";
	$numero   = 1;
	$icono    = "";
	 
	  while ($row = mysqli_fetch_array($consulta)) {

	  	if($row[3] == 0){
	  		$icono = "<button class='btn btn-danger btn-sm'><i class='fa fa-times fa-sm' aria-hidden='true'></i></button>";
	  	}else{
	  		$icono = "<button class='btn btn-success btn-sm'><i class='fa fa-check fa-sm' aria-hidden='true'></i></button>";
	  	}

		$renglon = "
		{
			\"#\": \"$numero\",
			\"Nombre\": \"$row[1]\",
		    \"Tiempo\": \"$row[2]\",
		    \"Estatus\": \"$icono\"
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