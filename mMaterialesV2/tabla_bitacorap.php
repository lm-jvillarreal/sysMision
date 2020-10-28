<?php 
	include '../global_seguridad/verificar_sesion.php';

	$fecha1 = $_POST['fecha1'];
	$fecha2 = $_POST['fecha2'];

	$filtro=(!empty($registros_propios) == '1')?"AND detalle_tbodega_encargados.encargado = '$id_usuario'":"";
	$consulta = mysqli_query($conexion,"SELECT
	pedido_materiales.id,
	pedido_materiales.nombre,
	CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno),
	sucursales.nombre,
	pedido_materiales.fecha,
	pedido_materiales.estatus 
	FROM pedido_materiales 
	INNER JOIN usuarios ON usuarios.id = pedido_materiales.id_usuario
	INNER JOIN personas ON personas.id = usuarios.id_persona
	INNER JOIN sucursales ON sucursales.id = personas.id_sede
	INNER JOIN detalle_pedido ON detalle_pedido.id_pedido = pedido_materiales.id
	INNER JOIN catalogo_materiales2 ON catalogo_materiales2.id = detalle_pedido.id_material
	INNER JOIN tipo_bodega ON tipo_bodega.id = catalogo_materiales2.id_tipo_bodega
	INNER JOIN detalle_tbodega_encargados ON detalle_tbodega_encargados.id_bodega = tipo_bodega.id
	WHERE pedido_materiales.activo = '1'
	AND detalle_tbodega_encargados.activo = '1' ".$filtro."
	AND (pedido_materiales.estatus = '0' OR pedido_materiales.estatus = '3' OR pedido_materiales.estatus = '4')
	AND pedido_materiales.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)
	GROUP BY pedido_materiales.id");

	$cuerpo  = "";
	$numero  = 1;

	while ($row = mysqli_fetch_array($consulta)) 
	{
		if($row[5] == 1){
			$ruta = "href='pdf.php?id_pedido=$row[0]'";
			$estatus ="<button class='btn btn-success'>Enviado</button>";
		}else if($row[5] == 2){
			$ruta = "href='pdf.php?id_pedido=$row[0]'";
			$estatus ="<button class='btn btn-warning'>Revisado</button>";
		}else if($row[5] == 0){
			$ruta = "href='pdf.php?id_pedido=$row[0]'";
			$estatus ="<button class='btn btn-danger' onclick='mostrar_comentario($row[0])'>Cancelado</button>";
		}else if($row[5] == 3){
			$ruta = "href='pdf.php?id_pedido=$row[0]'";
			$estatus ="<button class='btn btn-success'>Surtido</button>";
		}else if($row[5] == 4){
			$ruta = "href='pdf2.php?id_pedido=$row[0]'";
			$estatus ="<button class='btn btn-warning'>Surtido c/ Cambios</button>";
		}
		$boton_pdf    = "<a class='btn btn-danger' $ruta target='_blank'><i class='fa fa-file-pdf-o fa-lg' aria-hidden='true'></i></a>";

		$renglon = "
			{
			\"#\": \"$numero\",
			\"Nombre\": \"$row[1]\",
            \"Solicita\": \"$row[2]\",
            \"Sucursal\": \"$row[3]\",
            \"Fecha\": \"$row[4]\",
            \"Estatus\": \"$estatus\",
            \"VerPedido\": \"$boton_pdf\"
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