<?php 
	include '../global_seguridad/verificar_sesion.php';

	$cadena = "SELECT
                            h.id,
                            h.id_bodega,
                            b.nombre AS bodega,
                            h.codigo,
                            c.nombre,
                            c.descripcion,
                            h.existencia,
                            h.fecha,
                            h.hora,
                            h.activo,
                            h.id_usuario,
                            CONCAT(
                                p.nombre,
                                ' ',
                                p.ap_paterno,
                                ' ',
                                p.ap_materno
                            ) AS persona,
                            c.id
                        FROM
                            historial_existencia_materiales h
                        INNER JOIN bodega b ON b.id = h.id_bodega
                        INNER JOIN catalago_materiales c ON c.codigo = h.codigo
                        INNER JOIN usuarios u ON u.id = h.id_usuario
                        INNER JOIN personas p ON p.id = u.id_persona";

	$consulta = mysqli_query($conexion, $cadena);

	$cuerpo = "";
	$numero = 1;

	while ($row = mysqli_fetch_array($consulta)) 
	{
		$editar="<a href='editar.php?id=$row[12]'><i class='fa fa-edit fa-3x' style='color: #DF0101;'></i></a>";
        

		$renglon = "
			{
			\"#\": \"$numero\",
			\"Bodega\": \"$row[2]\",
			\"Codigo\": \"$row[3]\",
			\"Nombre\": \"$row[4]\",
			\"Descripción\": \"$row[5]\",
			\"Existencia\": \"$row[6]\",
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