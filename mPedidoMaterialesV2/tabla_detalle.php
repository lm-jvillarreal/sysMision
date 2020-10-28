<?php 
	include '../global_seguridad/verificar_sesion.php';

	$id_pedido = $_POST['id_pedido'];

	$consulta = mysqli_query($conexion,"SELECT detalle_pedido.id, catalogo_materiales2.nombre, catalogo_materiales2.descripcion, detalle_pedido.cantidad
		FROM detalle_pedido INNER JOIN catalogo_materiales2 ON catalogo_materiales2.id = detalle_pedido.id_material 
		WHERE detalle_pedido.activo = '1' AND detalle_pedido.id_pedido = '$id_pedido'");

	$cuerpo  = "";
	$numero  = 1;
	$color   = "";
	$texto   = "";
	$funcion = "";

	while ($row = mysqli_fetch_array($consulta)) 
	{
		$boton_editar="<button onclick='editar_detalle($row[0])' class='btn btn-warning'><i class='fa fa-edit fa-lg' aria-hidden='true'></button>";
    	$boton_eliminar="<button onclick='eliminar_detalle($row[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";

		$renglon = "
			{
			\"#\": \"$numero\",
			\"Nombre\": \"$row[1]\",
			\"Descripcion\": \"$row[2]\",
            \"Cantidad\": \"$row[3]\",
            \"Editar\": \"$boton_editar\",
            \"Eliminar\": \"$boton_eliminar\"
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