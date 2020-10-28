<?php
	include '../global_seguridad/verificar_sesion.php';

	if(!empty($_POST['folio'])){
	    $folio = $_POST['folio'];
	}else{
		$folio = "";
	}
	$cadena_sucur_dif = "";
	$opciones         = "";

	$cadena = mysqli_query($conexion,"SELECT s.id,s.nombre FROM cuestionarios c INNER JOIN sucursales s ON c.id_sucursal = s.id WHERE c.folio = '$folio' AND c.activo = '1'");


	while ($row_sucursales_selec = mysqli_fetch_array($cadena)) {
		$cadena_sucur_dif       .= "AND id != '".$row_sucursales_selec[0]."'";
		$opciones .= "<option value='$row_sucursales_selec[0]' selected>$row_sucursales_selec[1]</option>";
	}


	$cadena_sucur = "SELECT id, nombre FROM sucursales WHERE activo = '1' ".$cadena_sucur_dif;
	$consulta = mysqli_query($conexion, $cadena_sucur);
	 
	while ($row_sucur = mysqli_fetch_row($consulta)) {
			$opciones .= "<option value='$row_sucur[0]'>$row_sucur[1]</option>";
  	}

  	echo $opciones;
?>