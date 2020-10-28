<?php 
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');

	$hora  = date('h:i:s');
	$fecha = date('Y-m-d');

	$folio    = $_POST['folio'];
	$resultado = $_POST['resultado'];
	$cantidad = $_POST['cantidad'];
	$mensaje  = "";

	$cant_resultado = count($cantidad);
	$cadena_folio = "SELECT id FROM prestamos_morralla WHERE folio = '$folio' order by cast(morralla AS DECIMAL(10,2)) desc";
	$consulta_folio = mysqli_query($conexion,$cadena_folio);

	$o = 0;
	while($o < $cant_resultado)
	{
		if($cantidad[$o] == "" || $resultado[$o] == "")
		{
			$mensaje = "vacio";
		}
		$o++;
	}

	if ($mensaje == "")
	{
		$i = 0;
		while ($row_folio = mysqli_fetch_array($consulta_folio)) {
			$cadenaActualiza = "UPDATE prestamos_morralla SET cantidad = '$cantidad[$i]', resultado = '$resultado[$i]', id_usuario = '$id_usuario', id_sucursal = '$id_sede', fecha = '$fecha', hora = '$hora' WHERE id = '$row_folio[0]'";
			$consulta = mysqli_query($conexion,$cadenaActualiza);
			//echo $cadenaActualiza."\n";
			$i ++;
		}
		echo "ok";
	}
	else
	{
		echo $mensaje;
	}
?>
