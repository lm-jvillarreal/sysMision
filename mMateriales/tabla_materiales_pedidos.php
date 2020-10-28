<?php 
	include '../global_seguridad/verificar_sesion.php';

	$cadena = "SELECT id,nombre,
                    (SELECT existencia FROM historial_existencia_materiales WHERE historial_existencia_materiales.codigo = catalago_materiales.codigo),
                    pedido 
                FROM catalago_materiales WHERE pedido != '0'";

	$consulta = mysqli_query($conexion, $cadena);

	$cuerpo = "";
    $numero = 1;
    $color  = "";
    $texto  = "";
    $funcion = "";

	while ($row = mysqli_fetch_array($consulta)) 
	{
        if($row[3] == "1"){
            $texto = "Pendiente";
            $color = "yellow";
            if($id_usuario = '2' || $id_usuario = '1'){
                $funcion = "onclick='pedir($row[0],1)'";
            }else{
            	$funcion = "";
            }
        }else{
            $texto = "Pedido a Proveedor";
            $color = "green";
            $funcion = "onclick='pedir($row[0],1)'";
        }

        $status = "<span class='badge bg-$color' $funcion>$texto</span>";
        $cancelar = "<button class='btn btn-danger' onclick='pedir($row[0],0)'>Cancelar</button>";

		$renglon = "
			{
			\"#\": \"$numero\",
			\"Nombre\": \"$row[1]\",
			\"Cantidad\": \"$row[2]\",
            \"Status\": \"$status\",
            \"Cancelar\": \"$cancelar\"
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