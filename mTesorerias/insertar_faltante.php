<?php 
	include '../global_seguridad/verificar_sesion.php';
	
	date_default_timezone_set('America/Monterrey');

	$fecha_actual = date('Y-m-d');
	$fecha    = strtotime('-1 day', strtotime($fecha_actual));
	$fecha    = date('Y-m-d', $fecha);

    $hora  = date('h:i:s');
    
    $cadena_folio = mysqli_query($conexion,"SELECT MAX(folio) FROM faltantes");
    $row_folio = mysqli_fetch_array($cadena_folio);

    if($row_folio == "")
    {
    	$folio = 1;
    }
    else
    {
    	$folio = $row_folio[0] + 1;
    }

    $mensaje = "";
	$morralla       = $_POST['morralla'];
	$faltante       = $_POST['faltante'];
	$resultado      = $_POST['resultado'];
	$cant_resultado = count($resultado);

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
		for ($i=0; $i < $cant_resultado ; $i++) { 
			$consulta = mysqli_query($conexion,
			"INSERT INTO faltantes (folio,moneda,faltante,valor,fecha,hora,fecha_creacion,hora_creacion,activo,id_usuario,id_sucursal)
				VALUES('$folio','$morralla[$i]','$faltante[$i]','$resultado[$i]','$fecha','$hora','$fecha_actual','$hora','1','$id_usuario','$id_sede')");
		}
		echo "ok";
	}
	else
	{
		echo $mensaje;
	}
?>
