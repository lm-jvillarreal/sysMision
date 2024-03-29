<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha =date('Y-m-d');
$hora  =date('h:i:s');

/////////////////////////////////////CONTROL TIEMPOS///////////////////////////////////////////////////////////
$nombre_usuario = $_POST['nombre_usuario'];

$f_inicio = $_POST['fecha_inicio'];
$f_fin    = $_POST['fecha_fin'];

$fecha_inicio = substr($f_inicio,0,10);
$hora_inicio  = substr($f_inicio,11,15);
$hora_final   = substr($f_fin,11,15);

$tipo_registro  = $_POST['tipo_registro'];
$comentario     = $_POST['comentario'];
$Inicio         = "";
$Final          = "";
$interval       = "";
$diferencia     = "";
$cadena			= "";

$Inicio     = new DateTime($f_inicio);
$Final      = new DateTime($f_fin);
$interval   = $Inicio->diff($Final);
$diferencia = $interval->format('%h:%i');

if($tipo_registro == "5") {
    $cadena1 = "INSERT INTO me_control_tiempos (fecha,hora_inicio,hora_fin,diferencia,comentarios,id_usuario,tipo,fecha_registro,hora_registro,id_persona,activo)
			    VALUES('$fecha_inicio','$hora_inicio','$hora_final','$diferencia','$comentario','$id_usuario','$tipo_registro','$fecha','$hora','$nombre_usuario','1')";
     $consulta = mysqli_query($conexion,$cadena1);   
     $cadena2= "INSERT INTO me_control_tiempos (fecha,hora_inicio,hora_fin,diferencia,comentarios,id_usuario,tipo,fecha_registro,hora_registro,id_persona,activo)
                VALUES('$fecha_inicio','$hora_inicio','$hora_final','$diferencia','Doble','$id_usuario','$tipo_registro','$fecha','$hora','$nombre_usuario','1')";
    $consulta2 = mysqli_query($conexion, $cadena2);
    
}else{
    $cadena1 = "INSERT INTO me_control_tiempos (fecha,hora_inicio,hora_fin,diferencia,comentarios,id_usuario,tipo,fecha_registro,hora_registro,id_persona,activo)
			 VALUES('$fecha_inicio','$hora_inicio','$hora_final','$diferencia','$comentario','$id_usuario','$tipo_registro','$fecha','$hora','$nombre_usuario','1')";
    $consulta = mysqli_query($conexion,$cadena1);
}


/////////////////////////////////////CONTROL TIEMPOS///////////////////////////////////////////////////////////

// /////////////////////////////////////AGENDA///////////////////////////////////////////////////////////
$cadena_nombre         = "";
$nombre                = "";
$cadena                = "";
$tipo                  = "";
$fecha_completa_inicio = "";
$fecha_completa_final  = "";
$color                 = "";

$fecha_nueva = date($fecha_inicio);
$nuevafecha  = strtotime ( '+1 day' , strtotime ( $fecha_nueva ) ) ;
$nuevafecha  = date ( 'Y-m-d' , $nuevafecha );

$cadena_nombre = mysqli_query($conexion,"SELECT CONCAT(personas.nombre,' ',personas.ap_paterno) 
											FROM personas WHERE id = '$nombre_usuario'");
$row_nombre = mysqli_fetch_array($cadena_nombre);

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

$title = sanear_string($row_nombre[0]);

if ($tipo_registro == "1"){
	$tipo  = "Extra";
	$color = "#088A08";
}
else if ($tipo_registro == "2"){
    $tipo  = "Permiso";
	$color = "#FF0000";
}else if ($tipo_registro == "5"){
	$tipo  = "Extra";
	$color = "#088A08";
}

$fecha_completa_inicio = $fecha_inicio .' 12:00:00';
$fecha_completa_final  = $nuevafecha .' 12:00:00';

$cadena_folio = mysqli_query($conexion,"SELECT MAX(folio) FROM agenda");
$row_folio    = mysqli_fetch_array($cadena_folio);
$folio        = $row_folio[0] + 1;

$nombre = $title.' - '.$tipo;

$cadena = mysqli_query($conexion,"INSERT INTO agenda (folio,title,start,end,id_usuario,fecha,hora,backgroundColor,borderColor)
			VALUES ('$folio','$nombre','$fecha_completa_inicio','$fecha_completa_final','$id_usuario','$fecha','$hora','$color','$color')");

$consulta_usuario = mysqli_query($conexion,"SELECT id FROM usuarios WHERE id_persona = '$nombre_usuario'");
$row_usuario = mysqli_fetch_array($consulta_usuario);

if($row_usuario[0] != $id_usuario){
    $cadena = "INSERT INTO agenda (folio,title,start,end,id_usuario,fecha,hora,backgroundColor,borderColor)
            VALUES ('$folio','$nombre','$fecha_completa_inicio','$fecha_completa_final','$row_usuario[0]','$fecha','$hora','$color','$color')";
    $consulta = mysqli_query($conexion,$cadena);
}
echo "ok";
// /////////////////////////////////////AGENDA///////////////////////////////////////////////////////////
?>