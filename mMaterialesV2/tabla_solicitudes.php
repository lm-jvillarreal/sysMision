<?php 
	include '../global_seguridad/verificar_sesion.php';

	$filtro=(!empty($registros_propios) == '1')?" AND detalle_tbodega_encargados.encargado = '$id_usuario'
	AND detalle_tbodega_encargados.activo = '1'":"";

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
	INNER JOIN detalle_tbodega_encargados ON detalle_tbodega_encargados.id_bodega = catalogo_materiales2.id_tipo_bodega
	WHERE pedido_materiales.activo = '1'".$filtro."
	AND (pedido_materiales.estatus = '1' OR pedido_materiales.estatus = '2')
	GROUP BY pedido_materiales.id");

	$cuerpo  = "";
	$numero  = 1;

	while ($row = mysqli_fetch_array($consulta)) 
	{
		$boton_pdf    = "<button type='button' class='btn btn-danger' onclick='ver_pdf($row[0])'><i class='fa fa-file-pdf-o fa-lg' aria-hidden='true'></i></button>";
		$boton_surtir = "<button class='btn btn-success' onclick='surtir($row[0])'><i class='fa fa-check-square fa-lg' aria-hidden='true'></i></button>";
		$boton_surtirp = "<button class='btn btn-warning' type='button' href='#' data-id = '$row[0]' data-toggle = 'modal' data-target = '#modal-surtir2' target='blank'><i class='fa fa-pencil-square fa-lg' aria-hidden='true'></i></button>";
		$boton_cancelar = "<div class='input-group margin'><input type='text' id='input$numero' class='form-control' placeholder='Comentario'><span class='input-group-btn'><button type='button' class='btn btn-danger btn-flat' onclick='cancelar($row[0],$numero)'><i class='fa fa-window-close fa-lg' aria-hidden='true'></i></button></span></div>";

		$renglon = "
			{
			\"#\": \"$numero\",
			\"Nombre\": \"$row[1]\",
            \"Solicita\": \"$row[2]\",
            \"Sucursal\": \"$row[3]\",
            \"Fecha\": \"$row[4]\",
            \"VerPedido\": \"$boton_pdf\",
            \"SurtirP\": \"$boton_surtirp\",
            \"Surtir\": \"$boton_surtir\",
            \"Cancelar\": \"$boton_cancelar\"
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