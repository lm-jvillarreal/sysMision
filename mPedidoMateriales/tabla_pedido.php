<?php 
	include '../global_seguridad/verificar_sesion.php';

	$cadena = "SELECT
                    m.id,
                    m.folio,
                    m.fecha,
                    m.id_sucursal,
                    s.nombre,
                    m.id_usuario,
                    CONCAT(
                        p.nombre,
                        ' ',
                        p.ap_paterno,
                        ' ',
                        p.ap_materno
                    )
                FROM
                    materiales m
                INNER JOIN sucursales s ON s.id = m.id_sucursal
                INNER JOIN usuarios u ON u.id = m.id_usuario
                INNER JOIN personas p ON p.id = u.id_persona
                WHERE
                    m.id_sucursal = '$id_sede'
                AND m.activo = '1'";

	$consulta = mysqli_query($conexion, $cadena);

	$cuerpo = "";
	$numero = 1;

	while ($row = mysqli_fetch_array($consulta)) 
	{
		$editar="<center><a href='editar.php?id=$row[1]'><i class='fa fa-edit fa-3x' style='color: #DF0101;'></i></a></center>";
        

		$renglon = "
			{
			\"#\": \"$numero\",
			\"Folio\": \"$row[1]\",
			\"Fecha\": \"$row[2]\",
			\"Sucursal\": \"$row[4]\",
			\"Usuario\": \"$row[6]\",
            \"Editar\": \"$editar\"
			},";
		$cuerpo = $cuerpo.$renglon;
		$numero ++;
	}
	$cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
	$tabla = "
	["
	.$cuerpo2.
	"]
	";
	echo $tabla;
 ?>