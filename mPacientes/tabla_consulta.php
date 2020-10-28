  <?php 
	include '../global_settings/conexion.php';
	$cadena_consulta = "SELECT 
		                   consulta.id,
		                   CONCAT( pacientes.nombre, ' ', pacientes.ap_paterno, ' ',pacientes.ap_materno ),
		                   consulta.turno,
		                   DATE_FORMAT(consulta.fecha, '%d/%m/%Y'),
		                   pacientes.id
                           FROM pacientes pacientes INNER JOIN consulta consulta ON (pacientes.id=consulta.id_pacientes)";
		                     						

	 $consulta_consulta = mysqli_query($conexion, $cadena_consulta);
	 $cuerpo = "";
	 
	  while ($row_consulta = mysqli_fetch_array($consulta_consulta)) {
		$receta= "<a href='receta.php?id=$row_consulta[0]&id_paciente=$row_consulta[4]' class='btn btn-danger text-center'>Recetar</a>";
		
		$renglon = "
		{
			\"id\": \"$row_consulta[0]\",
			\"nombre_completo\": \"$row_consulta[1]\",
			\"turno\": \"$row_consulta[2]\",
		    \"fecha\": \"$row_consulta[3]\",
		    \"receta\": \"$receta\"
		},";
		$cuerpo = $cuerpo.$renglon;
	}

	$cuerpo2 = trim($cuerpo, ',');
	$tabla = "
	["
	.$cuerpo2.
	"]
	";
	echo $tabla;
	?>