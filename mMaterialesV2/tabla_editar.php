<?php 
	include '../global_seguridad/verificar_sesion.php';

	$id = $_POST['id'];

	$consulta = mysqli_query($conexion,"SELECT id, (SELECT nombre FROM catalogo_materiales2 WHERE catalogo_materiales2.id = detalle_pedido.id_material ),id_material, cantidad FROM detalle_pedido WHERE id_pedido = '$id' AND activo = '1'");

	$cuerpo  = "";
	$numero  = 1;

	while ($row = mysqli_fetch_array($consulta)) 
	{ 
		$campo = "<input type='hidden' name='id_material[]' value='$row[2]'><input type='hidden' name='id[]' value='$row[0]'><input name='id_pedido' value='$id' type='hidden'><input class='form-control' name='surtir[]' size='8' value='$row[3]'>";

		$renglon = "
			{
			\"#\": \"$numero\",
			\"Descripcion\": \"$row[1]\",
            \"Solicitado\": \"$row[3]\",
            \"Surtir\": \"$campo\"
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