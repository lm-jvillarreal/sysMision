<?php 
	include '../global_seguridad/verificar_sesion.php';
	
	date_default_timezone_set('America/Monterrey');

	$hora  = date('h:i:s');

	$fecha = $_POST['fecha'];
    $folio = $_POST['folio'];
	$morralla = $_POST['morralla'];
	$faltante = $_POST['faltante'];
	$resultado = $_POST['resultado'];
	$cant_resultado = count($resultado);

	$cadena_folio = mysqli_query($conexion,"SELECT id FROM faltantes WHERE folio = '$folio'");



	$o = 0;
	while($o < $cant_resultado)
	{
		if($faltante[$o] == "" || $resultado[$o] == "")
		{
			$mensaje = "vacio";
		}
		$o++;
	}

	if ($mensaje == "")
	{
		$i = 0;
		while ($row_folio = mysqli_fetch_array($cadena_folio)) { 
			$consulta = mysqli_query($conexion,
			"UPDATE faltantes SET faltante = '$faltante[$i]', valor = '$resultado[$i]', id_usuario = '$id_usuario', id_sucursal = '$id_sede', fecha = '$fecha', hora = '$hora' WHERE id = '$row_folio[0]'");
			$i ++;
		}

		echo "ok";
	}
	else
	{
		echo $mensaje;
	}
?>
