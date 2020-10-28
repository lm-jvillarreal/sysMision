<?php 
	include '../global_seguridad/verificar_sesion.php';

	$filtro=(!empty($registros_propios) == '1')?"AND id_usuario = '$id_usuario'":"";

	$consulta = mysqli_query($conexion,"SELECT id, nombre, estatus FROM pedido_materiales WHERE activo = '1'".$filtro);

	$cuerpo   = "";
	$numero   = 1;
	$disabled = "";

	while ($row = mysqli_fetch_array($consulta)) 
	{
		//Verifico el estado del pedido y dependiendo el estado es las opciones que le da al usuario.
		
		if($row[2] == 1){
			$ruta = "href='pdf.php?id_pedido=$row[0]'";
			$estatus ="<button class='btn btn-success'>Enviado</button>";
			$disabled = "";
		}else if($row[2] == 2){
			$ruta = "href='pdf.php?id_pedido=$row[0]'";
			$estatus ="<button class='btn btn-warning'>Revisado</button>";
			$disabled = "disabled";
		}else if($row[2] == 0){
			$ruta = "href='pdf.php?id_pedido=$row[0]'";
			$estatus ="<button class='btn btn-danger' onclick='mostrar_comentario($row[0])'>Cancelado</button>";
			$disabled = "disabled";
		}else if($row[2] == 3){
			$ruta = "href='pdf.php?id_pedido=$row[0]'";
			$estatus ="<button class='btn btn-primary'>Surtido</button>";
			$disabled = "disabled";
		}else if($row[2] == 4){
			$ruta = "href='pdf2.php?id_pedido=$row[0]'";
			$estatus ="<button class='btn btn-warning'>Surtido c/ Cambios</button>";
			$disabled = "disabled";
		}

		
		$boton_editar="<button onclick='editar_pedido($row[0])' class='btn btn-warning' $disabled><i class='fa fa-edit fa-lg' aria-hidden='true'></button>";
    	$boton_eliminar="<button onclick='eliminar_pedido($row[0])' class='btn btn-danger' $disabled><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";
    	$boton_pdf = "<a $ruta target='_blank' ><button class='btn btn-danger'><i class='fa fa-file-pdf-o fa-lg' aria-hidden='true'></i></button></a>";
		$renglon = "
			{
			\"#\": \"$numero\",
			\"Nombre\": \"$row[1]\",
			\"Estatus\": \"$estatus\",
            \"Editar\": \"$boton_editar\",
            \"Eliminar\": \"$boton_eliminar\",
            \"PDF\": \"$boton_pdf\"
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