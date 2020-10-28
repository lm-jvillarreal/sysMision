<?php
	include '../global_seguridad/verificar_sesion.php';
	include "../global_settings/conexion_oracle.php";

    $fecha1 = $_POST['fecha1'];
    $fecha2 = $_POST['fecha2'];
    $tipo = $_POST['tipo'];
    $sucursal = (isset($_POST['sucursal']))?$_POST['sucursal']:"";
    
    $filtro = ($sucursal != "")?"AND id_sucursal = '$sucursal'":"";
    $filtro2 = ($tipo == 1)?" AND contador = 9":"AND contador = 6";

    $cadena = mysqli_query($conexion,"SELECT COUNT(*) AS Cant,
	(SELECT CONCAT( personas.nombre, ' ', personas.ap_paterno, ' ', personas.ap_materno ) 
	FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id =inv_mapeo.usuario 
	) 
    FROM inv_mapeo 
    WHERE fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)
    AND activo = '0' AND completo = '1' ".$filtro.$filtro2." GROUP BY usuario ORDER BY Cant DESC");
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