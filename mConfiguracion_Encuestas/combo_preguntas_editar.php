<?php
	include '../global_seguridad/verificar_sesion.php';
	
	if(!empty($_POST['folio'])){
	    $folio = $_POST['folio'];
	}else{
		$folio = "";
	}

	$selecionadas = "";
	$opciones = "";
	$cadena = mysqli_query($conexion,"SELECT p.id,p.pregunta,p.folio FROM encuestas e INNER JOIN preguntas p ON p.id = e.id_pregunta WHERE e.folio_cuestionario = '$folio' AND e.activo = '1'");

	while($row_preguntas_selec = mysqli_fetch_array($cadena)){
		$selecionadas .= "AND folio != '".$row_preguntas_selec[2]."'";
		$opciones .= "<option value='$row_preguntas_selec[0]' selected>$row_preguntas_selec[1]</option>";
	}
	
	$cadena_preguntas = mysqli_query($conexion,"SELECT id,pregunta FROM preguntas WHERE activo = '1' ".$selecionadas." GROUP BY folio");
	while ($row_preguntas_no_selec = mysqli_fetch_array($cadena_preguntas)) {
		$opciones .="<option value='$row_preguntas_no_selec[0]'>$row_preguntas_no_selec[1]</option>";
  	}
  	echo $opciones;
?>