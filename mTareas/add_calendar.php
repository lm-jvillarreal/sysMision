<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date("Y-m-d"); 
	$hora  = date ("h:i:s");

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
    $hex = "#";
    foreach(array('r', 'g', 'b') as $color){
		//Random number between 0 and 255.
		$val = mt_rand(0, 255);
		//Convert the random number into a Hex value.
		$dechex = dechex($val);
		//Pad with a 0 if length is less than 2.
		if(strlen($dechex) < 2){
		    $dechex = "0" . $dechex;
		}
		//Concatenate
		$hex .= $dechex;
	}


	$id    = $_POST['id'];
	
	$title = 'T-'.$id.'-';
	$consulta_agenda = mysqli_query($conexion,"SELECT id FROM agenda WHERE title LIKE '$title%'");
	$existe = mysqli_num_rows($consulta_agenda);
	if($existe == 0){
		$cadena     = mysqli_query($conexion,"SELECT nombre,folio FROM tareas WHERE id = '$id'");
		$row_cadena = mysqli_fetch_array($cadena);

		$cadena_folio = mysqli_query($conexion,"SELECT MAX(folio) FROM agenda");
		$row_folio    = mysqli_fetch_array($cadena_folio);
		$folio        = $row_folio[0] + 1;

		$title  = sanear_string($row_cadena[0]);
		$title  = 'T-'.$id.'-'.$title;
		$fecha1 = date('Y-m-d');
		$fecha1 = $fecha1 .' 12:00:00';
		$fecha2 = strtotime ('+1 day',strtotime($fecha1));
		$fecha2 = date ( 'Y-m-j' , $fecha2 );
		$fecha2 = $fecha2 .' 12:00:00';

		$cadena2 = mysqli_query($conexion,"SELECT id_usuario FROM categoria_tareas WHERE folio = '$row_cadena[1]'");
		while ($row_cadena2 = mysqli_fetch_array($cadena2)) {
			$agenda = mysqli_query($conexion,"INSERT INTO agenda (folio,title,start,end,id_usuario,fecha,hora,backgroundColor,borderColor)
				VALUES ('$folio','$title','$fecha1','$fecha2','$row_cadena2[0]','$fecha','$hora','$hex','$hex')");
		}

		echo "ok";
	}else{
		echo "duplicado";
	}
?>