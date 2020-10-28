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
                            c.id,
							c.proveedor,
							c.pedido
                        FROM
                            historial_existencia_materiales h
                        INNER JOIN bodega b ON b.id = h.id_bodega
                        INNER JOIN catalago_materiales c ON c.codigo = h.codigo
                        INNER JOIN usuarios u ON u.id = h.id_usuario
                        INNER JOIN personas p ON p.id = u.id_persona";

	$consulta = mysqli_query($conexion, $cadena);

	$cuerpo   = "";
	$numero   = 1;
	$texto    = "";
	$clase    = "";
	$disabled = "";

	while ($row = mysqli_fetch_array($consulta)) 
	{
		if($row[14]== "1" || $row[14]== "2"){
			$clase = "success";
			$texto = "Pedido";
			$disabled = "disabled";
		}else{
			$clase = "warning";
			$texto = "Pedir";
			$disabled = "";
		}
		$editar="<a onclick='editar_registro($row[12])' class='btn btn-danger'>Editar</a>";
		$existencia = "<p id='existenciabd$numero' ondblclick='activar($numero)'>$row[6]</p><input id='nueva_existencia$numero' name='nueva_existencia' value='$row[6]' class='form-control hidden' onblur='actualizar_existencia(this.value,$row[0])'>";
		$pedir = "<button class='btn btn-$clase' onclick='pedir($row[12],1)' $disabled >$texto</button>";

		$renglon = "
			{
			\"#\": \"$numero\",
			\"Bodega\": \"$row[2]\",
			\"Codigo\": \"$row[3]\",
			\"Nombre\": \"$row[4]\",
			\"Descripción\": \"$row[5]\",
			\"Proveedor\": \"$row[13]\",
			\"Existencia\": \"$existencia\",
			\"Pedir\": \"$pedir\",
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