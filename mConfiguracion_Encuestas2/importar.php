<?php
	include 'simplexlsx.class.php';
	include '../global_seguridad/verificar_sesion.php';
	
	date_default_timezone_set('America/Monterrey');
	$fecha=date("Y-m-d"); 
	$hora=date ("h:i:s");

	$nombre_encuesta = $_POST['n_encuesta'];
	$nombre_encuesta = trim($nombre_encuesta);

	$consulta_folio = mysqli_query($conexion,"SELECT MAX(folio) FROM n_encuestas");
	$row = mysqli_fetch_array($consulta_folio);
	$folio = ($row[0] == "")?"1":$row[0] + 1;
	$cadena = mysqli_query($conexion,"INSERT INTO n_encuestas (folio,nombre,fecha,hora,activo,id_usuario)
				VALUES ('$folio','$nombre_encuesta','$fecha','$hora','1','$id_usuario')");


	if(!empty($_FILES['plantilla']['name'])){
		$tamano  = $_FILES["plantilla"]['size'];
		$tipo    = $_FILES["plantilla"]['type'];
		$archivo = $_FILES["plantilla"]['name'];

		$destino =  "./plantilla.xlsx";
		if (copy($_FILES['plantilla']['tmp_name'],$destino)) 
	    {
	        $status = "ok";
	    } 
	    else 
	    {
	        $status = "Error al subir el archivo";
	    }
	}	

	$xlsx = new SimpleXLSX( './plantilla.xlsx' );
	$conn = new PDO( "mysql:host=200.1.1.178;dbname=sysadmision2;charset=utf8", "root", "Xoops1991");
	$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $conn->prepare( "INSERT INTO n_preguntas (pregunta, tipo, folio, activo, fecha, hora, id_usuario) VALUES (?, ?, '$folio','1','$fecha','$hora','$id_usuario')");
	$stmt->bindParam( 1, $pregunta);
	$stmt->bindParam( 2, $tipo);
	foreach ($xlsx->rows() as $fields)
	{
		$pregunta   = $fields[0];
		$pregunta = trim($pregunta);
		$tipo       = $fields[1];
		$tipo = trim($tipo);
		if($pregunta != "Nombre de Pregunta" && $tipo != "Tipo de Pregunta"){
			$stmt->execute();
		}
	}
	echo "ok";
?>