  <?php 
	include '../global_seguridad/verificar_sesion.php';
	
	$filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
	
	$cadena = "SELECT folio,actividad,hora_inicio,hora_final,cronometro,SEC_TO_TIME(TIME_TO_SEC(hora_final) - TIME_TO_SEC(hora_inicio))
				FROM actividades_usuario
				WHERE activo = '1' AND tipo = '2' AND fecha='$fecha' ".$filtro."ORDER BY id DESC";
		                     						
	$consulta = mysqli_query($conexion, $cadena);
	$cuerpo          = "";
	$numero          = 1;
	$boton_editar    = "";
	$boton_eliminar  = "";
	$hora            = "";
	$hora1           = "";
	$boton_actividad = "";
	$texto2          = "";
	$color           = "";
	$check           = "";
	 
	  while ($row = mysqli_fetch_array($consulta)) {
	  	 //Cadena verificar si fue asignada
	  	$cadena_verificar = mysqli_query($conexion,"SELECT COUNT(*) FROM actividades_usuario WHERE folio = '$row[0]' AND activo = '1'");
	  	$existe = mysqli_fetch_array($cadena_verificar);
	  	if($existe[0] > 1){
	  		$cadena2 = mysqli_query($conexion,"SELECT principal FROM actividades_usuario WHERE folio = '$row[0]' AND id_usuario = '$id_usuario'");
	  		$row2 = mysqli_fetch_array($cadena2);
	  		if($row2[0] == "1"){
	  			$cadena3 = mysqli_query($conexion,"SELECT (SELECT CONCAT(personas.nombre,' ',personas.ap_paterno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = actividades_usuario.id_usuario),estatus FROM actividades_usuario WHERE folio = '$row[0]' AND principal = '0'");
	  			$row3 = mysqli_fetch_array($cadena3);
	  			$color = ($row3[1] == 0)?"orange":"green";
	  			$texto2 = "<span class='badge bg-$color'>Asignado a $row3[0]</span>";
	  		}else{
	  			$cadena3 = mysqli_query($conexion,"SELECT (SELECT CONCAT(personas.nombre,' ',personas.ap_paterno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = actividades_usuario.id_usuario ) FROM actividades_usuario WHERE folio = '$row[0]' AND principal = '1'");
	  			$row3 = mysqli_fetch_array($cadena3);
	  			$texto2 = "<span class='badge bg-green'>Asignado por $row3[0]</span>";
	  			$cadena4 = mysqli_query($conexion,"SELECT estatus FROM actividades_usuario WHERE folio = '$row[0]' AND id_usuario = '$id_usuario'");
	  			$row4 = mysqli_fetch_array($cadena4);
	  			if($row4[0] == 0){
	  				$check = "<button class='btn btn-warning btn-xs' onclick='completar($row[0])'><i class='fa fa-check fa-sm' aria-hidden='true'></i></button>";
	  			}else{
	  				$check = "";
	  			}
	  		}
	  	}


	  	if($row[2] != "" && $row[3] != ""){
			$dif = "<button class='btn btn-danger btn-xs'><i class='fa fa-clock-o fa-sm' aria-hidden='true'></i> $row[5]</button>";
			$boton_principal = $dif;
	  	}else{
	  		if($row[4] == 1){
				$hora_inicio     = "<button class='btn btn-success btn-xs'>$row[2]</button>";
				$boton_iniciar   = "<button onclick='terminar($row[0])' class='btn btn-xs btn-danger'><i class='fa fa-clock-o fa-sm' aria-hidden='true'></i></button>";
				$boton_principal = $hora_inicio.'  '.$boton_iniciar;
		  	}else{
				$boton_principal = "";
				$cadenav2        = mysqli_query($conexion,"SELECT id_usuario,principal,id FROM actividades_usuario WHERE folio = '$row[0]'");
				$cantidadv2 = mysqli_num_rows($cadenav2);
				while ($rowv2    = mysqli_fetch_array($cadenav2)) {
					if($cantidadv2 == 1){
						// $boton_principal = "<button class='btn btn-success btn-xs' onclick='iniciar($rowv2[2])'><i class='fa fa-clock-o fa-sm' aria-hidden='true'></i></button>";
					}else{
						if($rowv2[0] == $id_usuario && $rowv2[1] == 0){
							$boton_principal = "<button class='btn btn-success btn-xs' onclick='iniciar($rowv2[2])'><i class='fa fa-clock-o fa-sm' aria-hidden='true'></i></button>";
							break;
						}else{
							$boton_principal = "";
						}
					}
				}
		  	}
	  	}

	  	$boton_actividad = "<label id='lblactividad_$numero' ondblclick='mostrar($numero)'>$row[1]</label><input type='text' id='inputactividad_$numero' class='form-control hidden' value='$row[1]' onchange='editar_act($numero,$row[0])' style='width:100%'>";
		
		$boton_editar   = "<button class='btn btn-warning' onclick='editar_registro($row[0])'>Editar</button>";
		$boton_eliminar = "<button class='btn btn-danger' onclick='eliminar($row[0])'><i class='fa fa-trash fa-lg' aria-hidden='true'></button>";

		$renglon = "
		{
			\"#\": \"$numero\",
			\"Nombre\": \"$boton_actividad $texto2\",
		    \"Iniciar\": \"$boton_principal $check\",
		    \"Editar\": \"$boton_editar\",
		    \"Eliminar\": \"$boton_eliminar\"
		},";
		$cuerpo = $cuerpo.$renglon;
		$numero ++;
		$texto2 = "";
		$check  = "";
	}

	$cadena = "SELECT folio,actividad,hora_inicio,hora_final,cronometro,SEC_TO_TIME(TIME_TO_SEC(hora_final) - TIME_TO_SEC(hora_inicio))
				FROM actividades_usuario
				WHERE activo = '1' AND tipo = '2' AND estatus ='0' AND fecha != '$fecha' ".$filtro."ORDER BY id DESC";
		                     						
	$consulta = mysqli_query($conexion, $cadena);
	$numero          = 1;
	$boton_editar    = "";
	$boton_eliminar  = "";
	$hora            = "";
	$hora1           = "";
	$boton_actividad = "";
	$texto2          = "";
	$color           = "";
	$check           = "";
	 
	  while ($row11 = mysqli_fetch_array($consulta)) {
	  	 //Cadena verificar si fue asignada
	  	$cadena_verificar = mysqli_query($conexion,"SELECT COUNT(*) FROM actividades_usuario WHERE folio = '$row11[0]' AND activo = '1'");
	  	$existe = mysqli_fetch_array($cadena_verificar);
	  	if($existe[0] > 1){
	  		$cadena2 = mysqli_query($conexion,"SELECT principal FROM actividades_usuario WHERE folio = '$row11[0]' AND id_usuario = '$id_usuario'");
	  		$row2 = mysqli_fetch_array($cadena2);
	  		if($row2[0] == "1"){
	  			$cadena3 = mysqli_query($conexion,"SELECT (SELECT CONCAT(personas.nombre,' ',personas.ap_paterno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = actividades_usuario.id_usuario),estatus FROM actividades_usuario WHERE folio = '$row11[0]' AND principal = '0'");
	  			$row3 = mysqli_fetch_array($cadena3);
	  			$color = ($row3[1] == 0)?"orange":"green";
	  			$texto2 = "<span class='badge bg-$color'>Asignado a $row3[0]</span>";
	  		}else{
	  			$cadena3 = mysqli_query($conexion,"SELECT (SELECT CONCAT(personas.nombre,' ',personas.ap_paterno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = actividades_usuario.id_usuario ) FROM actividades_usuario WHERE folio = '$row11[0]' AND principal = '1'");
	  			$row3 = mysqli_fetch_array($cadena3);
	  			$texto2 = "<span class='badge bg-green'>Asignado por $row3[0]</span>";
	  			$cadena4 = mysqli_query($conexion,"SELECT estatus FROM actividades_usuario WHERE folio = '$row11[0]' AND id_usuario = '$id_usuario'");
	  			$row4 = mysqli_fetch_array($cadena4);
	  			if($row4[0] == 0){
	  				$check = "<button class='btn btn-warning btn-xs' onclick='completar($row11[0])'><i class='fa fa-check fa-sm' aria-hidden='true'></i></button>";
	  			}else{
	  				$check = "";
	  			}
	  		}
	  	}


	  	if($row11[2] != "" && $row11[3] != ""){
			$dif = "<button class='btn btn-danger btn-xs'><i class='fa fa-clock-o fa-sm' aria-hidden='true'></i> $row11[5]</button>";
			$boton_principal = $dif;
	  	}else{
	  		if($row11[4] == 1){
				$hora_inicio     = "<button class='btn btn-success btn-xs'>$row11[2]</button>";
				$boton_iniciar   = "<button onclick='terminar($row11[0])' class='btn btn-xs btn-danger'><i class='fa fa-clock-o fa-sm' aria-hidden='true'></i></button>";
				$boton_principal = $hora_inicio.'  '.$boton_iniciar;
		  	}else{
				$boton_principal = "";
				$cadenav2        = mysqli_query($conexion,"SELECT id_usuario,principal,id FROM actividades_usuario WHERE folio = '$row11[0]'");
				$cantidadv2 = mysqli_num_rows($cadenav2);
				while ($rowv2    = mysqli_fetch_array($cadenav2)) {
					if($cantidadv2 == 1){
						// $boton_principal = "<button class='btn btn-success btn-xs' onclick='iniciar($rowv2[2])'><i class='fa fa-clock-o fa-sm' aria-hidden='true'></i></button>";
					}else{
						if($rowv2[0] == $id_usuario && $rowv2[1] == 0){
							$boton_principal = "<button class='btn btn-success btn-xs' onclick='iniciar($rowv2[2])'><i class='fa fa-clock-o fa-sm' aria-hidden='true'></i></button>";
							break;
						}else{
							$boton_principal = "";
						}
					}
				}
		  	}
	  	}

	  	$boton_actividad = "<label id='lblactividad_$numero' ondblclick='mostrar($numero)'>$row11[1]</label><input type='text' id='inputactividad_$numero' class='form-control hidden' value='$row11[1]' onchange='editar_act($numero,$row11[0])' style='width:100%'>";
		
		$boton_editar   = "<button class='btn btn-warning' onclick='editar_registro($row11[0])'>Editar</button>";
		$boton_eliminar = "<button class='btn btn-danger' onclick='eliminar($row11[0])'><i class='fa fa-trash fa-lg' aria-hidden='true'></button>";

		$renglon = "
		{
			\"#\": \"$numero\",
			\"Nombre\": \"$boton_actividad $texto2\",
		    \"Iniciar\": \"$boton_principal $check\",
		    \"Editar\": \"$boton_editar\",
		    \"Eliminar\": \"$boton_eliminar\"
		},";
		$cuerpo = $cuerpo.$renglon;
		$numero ++;
		$texto2 = "";
		$check  = "";
	}

	$cuerpo2 = trim($cuerpo, ',');
	$tabla = "
	["
	.$cuerpo2.
	"]
	";
	echo $tabla;
	?>