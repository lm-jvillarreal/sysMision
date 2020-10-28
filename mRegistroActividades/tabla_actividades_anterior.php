  <?php 
	include '../global_settings/conexion.php';
	$cadena = "SELECT
					id,
					(
						SELECT
							CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno)
						FROM
							personas
						WHERE
							personas.id = actividades_usuario.id_persona
					),
					actividad,
				fecha_realizacion
				FROM
					actividades_usuario
				WHERE activo = '1' AND tipo = '1'";
		                     						
	 $consulta = mysqli_query($conexion, $cadena);
	 $cuerpo = "";
	 $numero = 1;
	 $boton_editar = "";
	 $boton_eliminar = "";
	 
	  while ($row = mysqli_fetch_array($consulta)) {
		$boton_editar = "<button class='btn btn-warning' onclick='editar_registro($row[0])'>Editar</button>";
		$boton_eliminar = "<button class='btn btn-danger' onclick='eliminar($row[0])'>Eliminar</button>";
		$renglon = "
		{
			\"#\": \"$numero\",
			\"Nombre\": \"$row[1]\",
			\"Actividad\": \"$row[2]\",
		    \"Fecha\": \"$row[3]\",
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