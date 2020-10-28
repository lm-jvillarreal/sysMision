<?php
	include 'conexion_calendario.php';
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	
	$fecha =date("Y-m-d"); 
	$hora  =date ("H:i:s");
	$title = "";

	$nombre =$_POST['title'];
	$start  =$_POST['start'];
	$end    =$_POST['end'];

	$consulta = mysqli_query($conexion,"SELECT backgroundColor FROM agenda WHERE title = '$title'");
	$cant     = mysqli_num_rows($consulta);
	$row      = mysqli_fetch_array($consulta);
	$hex = '#';
	if ($cant != 0){
		$hex = $row[0];
	}
	else{
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
	}
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

	$title        = sanear_string($nombre);
	$folio        = 0;
	$cadena_folio = mysqli_query($conexion,"SELECT MAX(folio) FROM agenda");
	$row_folio    = mysqli_fetch_array($cadena_folio);
	$folio        = $row_folio[0] + 1;
	
	$sql = "INSERT INTO agenda (folio,title, start, end, id_usuario, fecha, hora,backgroundColor,borderColor) VALUES (:folio,:title, :start, :end, :id_usuario, :fecha, :hora, :backgroundColor, :borderColor)";
	$q   = $bdd->prepare($sql);
	$q->execute(array(':folio'=>$folio,':title'=>$title, ':start'=>$start, ':end'=>$end, ':id_usuario'=>$id_usuario,':fecha'=>$fecha,':hora'=>$hora,':backgroundColor'=>$hex,':borderColor'=>$hex));
	echo "ok";
?>