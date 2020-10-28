<?php 
	include '../global_seguridad/verificar_sesion.php';

	$consulta = mysqli_query($conexion,"SELECT id, nombre, existencia, pedido FROM catalogo_materiales2 WHERE pedido != '0'");

	$cuerpo  = "";
	$numero  = 1;
	$color   = "";
	$texto   = "";
	$funcion = "";

	while ($row = mysqli_fetch_array($consulta)) 
	{
        if($row[3] == "1"){
            $texto = "Pendiente";
            $color = "warning";
            if($perfil_usuario == '1'){
            	$funcion = "onclick='pedir($row[0],1)'";
            }
        }else{
            $texto = "Pedido a Proveedor";
            $color = "success";
            $funcion = "onclick='pedir($row[0],1)'";
        }

		$status   = "<button type='button' class='btn btn-$color' $funcion>$texto</button>";
		$cancelar = "<button class='btn btn-danger' onclick='pedir($row[0],0)'><i class='fa fa-window-close fa-lg' aria-hidden='true'></i></button>";

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