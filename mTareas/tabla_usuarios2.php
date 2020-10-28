<?php 
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date('Y-m-d');

	$folio = $_POST['folio'];
  
	$cadena   = "SELECT id,(SELECT CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = categoria_tareas.id_usuario) FROM categoria_tareas WHERE activo = '1' AND folio = '$folio' AND id_usuario != '$id_usuario'";
	$consulta = mysqli_query($conexion, $cadena);

	$cuerpo = "";
	$numero = 1;
	$activo = "";

	while ($row = mysqli_fetch_array($consulta)) 
	{
		$boton = "<button class='btn btn-danger' onclick='eliminar_usuario($row[0])'>Eliminar</button>";
		$renglon = "
		  {
		  \"#\": \"$numero\",
		  \"Nombre\": \"$row[1]\",
		  \"Eliminar\": \"$boton\"
		  },";
		$cuerpo = $cuerpo.$renglon;
		$numero ++;
	}

	$cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
	$tabla = "
		["
		.$cuerpo2.
		"]
		";
	echo $tabla;
?>