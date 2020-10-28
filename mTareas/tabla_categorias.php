<?php 
	include '../global_seguridad/verificar_sesion.php';
  
  	$filtro=(!empty($registros_propios) == '1')?"AND id_usuario = '$id_usuario'":"";
	$cadena   = "SELECT id,folio,nombre FROM categoria_tareas WHERE activo = '1' ".$filtro." GROUP BY folio";
	$consulta = mysqli_query($conexion, $cadena);

	$cuerpo   = "";
	$numero   = 1;
	$activo   = "";
	$disabled = "";
	while ($row = mysqli_fetch_array($consulta)) 
	{
		$qry = mysqli_query($conexion,"SELECT principal FROM categoria_tareas WHERE id ='$row[0]' AND id_usuario = '$id_usuario'");
		$row_principal = mysqli_fetch_array($qry);
		$disabled = ($row_principal[0] == "0")?"disabled = 'disabled'":"";

		$cadena2 = mysqli_query($conexion,"SELECT id FROM tareas WHERE folio = '$row[1]' AND activo != '2'");
		$existe = mysqli_num_rows($cadena2);
		if($existe == 0){
			$botones = "<center><button class='btn btn-success btn-sm' onclick='tareas($row[1],0)'><i class='fa fa-check fa-lg'></i></button></center>";
		}else{
			$boton_editar = "<button href='#' data-id = '$row[1]' data-toggle = 'modal' data-target = '#modal-default' class='btn btn-xs btn-warning' target='blank' $disabled><i class='fa fa-pencil-square fa-lg' aria-hidden='true'></i></button>";
			$boton_eliminar = "<button onclick='eliminar($row[1])' class='btn btn-xs btn-danger' $disabled><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";
			$boton_tareas = "<button onclick='tareas($row[1],0)' class='btn btn-xs btn-success'><i class='fa fa-thumb-tack fa-lg' aria-hidden='true'></i></button>";
			$botones = "<center>".$boton_eliminar.' '.$boton_editar.' '.$boton_tareas."</center>";
		}
		$nombre = "<span class='badge bg-aqua'>$row[2]</span>";
		$renglon = "
		  {
		  \"#\": \"$numero\",
		  \"Nombre\": \"$row[2]\",
		  \"Acciones\": \"$botones\"
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