<?php
  	include '../global_seguridad/verificar_sesion.php';
  	date_default_timezone_set('America/Monterrey');
  	function sanear_string($string)
	    {
	        $string = trim($string);
	        $string = str_replace( array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
	            $string
	        );
	        $string = str_replace(array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
	            $string
	        );
	        $string = str_replace(array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
	            $string
	        );
	        $string = str_replace(array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
	            $string
	        );
	        $string = str_replace(array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
	            $string
	        );
	        $string = str_replace(array('ñ', 'Ñ', 'ç', 'Ç'),array('n', 'N', 'c', 'C',),
	            $string
	        );
	        return $string;
	    }

	$id_usuario_vacacion = $_POST['id_usuario2'];
	$fecha_inicio        = $_POST['fecha_inicio'];
	$fecha_fin           = $_POST['fecha_fin'];
	$comentarios         = $_POST['comentarios'];
	$id_registro         = $_POST['id_registro2'];
	$nombre              = $_POST['usuario'];

	if ($id_registro == 0){

		$cadena_dias = mysqli_query($conexion,"SELECT actual FROM vacaciones WHERE id_usuario = '$id_usuario_vacacion' AND activo = '1'");
		$row_dias    = mysqli_fetch_array($cadena_dias);

		$cadena_dias_usados = mysqli_query($conexion,"SELECT id FROM historico_vacaciones WHERE id_usuario = '$id_usuario_vacacion' AND activo = '1'");
		$dias_usados    = mysqli_num_rows($cadena_dias_usados);

		$dias_disponibles = $row_dias[0] - $dias_usados;

		$dias = 0;
		for($i=$fecha_inicio;$i<=$fecha_fin;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
			$dia = date("l",strtotime($i));
			if ($dia != "Sunday"){
				$dias ++;
			}
		}

		$cadena_folio = mysqli_query($conexion,"SELECT MAX(folio) FROM historico_vacaciones");
		$cantidad     = mysqli_num_rows($cadena_folio);
		if ($cantidad == 0){
			$folio = "1";
		}
		else{
			$row_folio    = mysqli_fetch_array($cadena_folio);
			$folio        = $row_folio[0] + 1;
		}

		if ($dias_disponibles != 0){
			if($dias <= $dias_disponibles){
				$dia = "";
				for($i=$fecha_inicio;$i<=$fecha_fin;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
					$dia = date("l",strtotime($i));
					if ($dia != "Sunday"){
						$cadena = mysqli_query($conexion,"INSERT INTO historico_vacaciones (folio,id_usuario,fecha_vacaciones,comentarios,fecha,hora,activo,id_usuario_registro)
		  		VALUES('$folio','$id_usuario_vacacion','$i','$comentarios','$fecha','$hora','1','$id_usuario')");
					}
				}
				echo "ok";
			}
			else{
				echo "2";
			}
		}
		else{
			echo "1";
		}
	}
	else{

		$cadena_dias = mysqli_query($conexion,"SELECT actual FROM vacaciones WHERE id_usuario = '$id_usuario_vacacion'");
		$row_dias    = mysqli_fetch_array($cadena_dias);

		$cadena_dias_usados = mysqli_query($conexion,"SELECT id FROM historico_vacaciones WHERE id_usuario = '$id_usuario_vacacion' AND folio != '$id_registro' AND activo = '1'");
		$dias_usados    = mysqli_num_rows($cadena_dias_usados);

		$dias_disponibles = $row_dias[0] - $dias_usados;

		$dias = 0;
		for($i=$fecha_inicio;$i<=$fecha_fin;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
			$dia = date("l",strtotime($i));
			if ($dia != "Sunday"){
				$dias ++;
			}
		}

		if ($dias_disponibles != 0){
			if($dias <= $dias_disponibles){
				$desactivar = mysqli_query($conexion,"UPDATE historico_vacaciones SET activo = '0' WHERE folio = '$id_registro'");
				$dia = "";
				for($i=$fecha_inicio;$i<=$fecha_fin;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
					$dia = date("l",strtotime($i));
					if ($dia != "Sunday"){
						$cadena = mysqli_query($conexion,"INSERT INTO historico_vacaciones (folio,id_usuario,fecha_vacaciones,comentarios,fecha,hora,activo,id_usuario_registro)
		  		VALUES('$id_registro','$id_usuario_vacacion','$i','$comentarios','$fecha','$hora','1','$id_usuario')");
					}
				}
				echo "ok";
			}
			else{
				echo "2";
			}
		}
		else{
			echo "1";
		}
	}
