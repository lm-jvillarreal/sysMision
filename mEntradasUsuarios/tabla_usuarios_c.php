<?php
	include '../global_seguridad/verificar_sesion.php';
	include "../global_settings/conexion_oracle.php";

    $fecha1 = $_POST['fecha1'];
    $fecha2 = $_POST['fecha2'];
    $tipo = $_POST['tipo'];
    $sucursal = (isset($_POST['sucursal']))?$_POST['sucursal']:"";

    $filtro = ($sucursal != "")?" AND inv_mapeo.id_sucursal = '$sucursal'":"";

    $cadena = mysqli_query($conexion,"SELECT COUNT( inv_captura.id ) AS Cantidad,
	( SELECT CONCAT( personas.nombre, ' ', personas.ap_paterno, ' ', personas.ap_materno ) 
	    FROM usuarios
		INNER JOIN personas ON personas.id = usuarios.id_persona 
	    WHERE usuarios.id = inv_captura.usuario 
	) 
    FROM inv_mapeo
	INNER JOIN inv_captura ON inv_captura.id_mapeo = inv_mapeo.id 
	WHERE inv_mapeo.activo = 0
	AND inv_mapeo.completo = 1
	AND inv_mapeo.asignado = 0 
	AND inv_mapeo.contador = 6".$filtro." 
    GROUP BY inv_captura.usuario
    ORDER BY Cantidad DESC");

    $numero = 1;
    $cuerpo = "";
	while($row = mysqli_fetch_array($cadena))
    {   
    	$renglon = "
		{
		\"#\": \"$numero\",
		\"Usuario\": \"$row[1]\",
		\"Total\": \"$row[0]\"
		},";
		$cuerpo = $cuerpo.$renglon;
		$numero ++;
	}
	$cuerpo2 = trim($cuerpo, ',');

	$tabla = "
	["
	.$cuerpo2.
	"]
	";
	echo $tabla;
?>