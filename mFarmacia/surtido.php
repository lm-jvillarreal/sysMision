<?php
	include '../global_seguridad/verificar_sesion.php';
	$folio = $_POST['id_registro'];

	$consulta_verifica = mysqli_query($conexion, "SELECT surtido FROM receta WHERE id = '$folio'");
	$row_verifica = mysqli_fetch_array($consulta_verifica);

	if ($row_verifica[0]=='0') {
		$surtido = '1';
	}elseif($row_verifica[0]=='1'){
		$surtido = '0';
	}

	$modifica_estado = mysqli_query($conexion, "UPDATE receta SET surtido = '$surtido' WHERE id = '$folio'");

	echo "ok";
?>