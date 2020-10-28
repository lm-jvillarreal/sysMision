<?php
	include '../global_settings/conexion.php';
	$tipo     = $_POST['tipo'];
	$sucursal = $_POST['sucursal'];

	if ($tipo == "agrupaciones"){
		$cadena = "SELECT id,nombre FROM agrupaciones WHERE activo = '1'";
	}
	else if ($tipo == "sucursal"){
		$cadena = "SELECT id,nombre FROM sucursales WHERE activo = '1'";
	}
	else if ($tipo == "categoria"){
		$cadena = "SELECT id_categoria,CASE id_categoria 
                  WHEN '1' THEN 'Frescura y Calidad' 
                  WHEN '2' THEN 'Orden y Acomodo de Mercancia'
                  WHEN '3' THEN 'Atencion y Servicio al Cliente'
                  WHEN '4' THEN 'Limpieza en Tiendas'
                  END AS id_categoria 
                  FROM preguntas WHERE activo = '1' GROUP BY id_categoria";
	}
	$consulta = mysqli_query($conexion, $cadena);
	$opciones = "<option selected></option>";
	while ($row = mysqli_fetch_row($consulta)) {
			$opciones .= "<option value='$row[0]'>$row[1]</option>";
  	}
	echo $opciones;
?>