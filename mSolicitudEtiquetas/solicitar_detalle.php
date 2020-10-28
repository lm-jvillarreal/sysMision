<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("H:i:s");

$id = $_POST['id'];
$cantidad = $_POST['cantidad'];
$id_solicitud = $_POST['id_solicitud'];

$conteo = count($id);

for ($i=0; $i < $conteo; $i++) {
	$cadena_actualizar = "UPDATE detalle_solicitud SET cantidad = '$cantidad[$i]' WHERE id='$id[$i]'";
	$consulta_editar = mysqli_query($conexion, $cadena_actualizar);

}
$cadena_solicitar = "UPDATE solicitud_etiquetas SET estatus = '3', activo='1' WHERE id = '$id_solicitud[0]'";
$consulta_solicitud = mysqli_query($conexion, $cadena_solicitar);
echo "ok";

// /////////////////////////////////////AGENDA///////////////////////////////////////////////////////////
$cadena                = "";
$fecha_completa_inicio = "";
$fecha_completa_final  = "";
$color = "#ee5253";

$fecha_nueva = date($fecha);
$nuevafecha  = strtotime ( '+1 day' , strtotime ( $fecha_nueva ) ) ;
$nuevafecha  = date ( 'Y-m-d' , $nuevafecha );

$cadena_evento = mysqli_query($conexion,"SELECT nombre,
                        (SELECT formatos_etiquetas.nombre FROM formatos_etiquetas WHERE solicitud_etiquetas.formato = formatos_etiquetas.id )
                    FROM solicitud_etiquetas
                    WHERE id = '$id_solicitud[0]'");
$row = mysqli_fetch_array($cadena_evento);
if($row[0] == "" && $row[1] == ""){

}else{
    $title = $id_solicitud[0].'-'.$row[0].'-'.$row[1]; //Añado el id para poderlo eliminar mas adelante

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

    $title = sanear_string($title);
    if($id_sede == "1"){
        $sucu = "D.O";
    }else if($id_sede == "2"){
        $sucu = "ARB.";
    }else if ($id_sede == "3"){
        $sucu = "VILL.";
    }else{
        $sucu = "ALL.";
    }
    $title = $title.'-'.$sucu;
    // if($tilte == "-"){

    // }else{
        $fecha_completa_inicio = $fecha .' 12:00:00';
        $fecha_completa_final  = $nuevafecha .' 12:00:00';

        $cadena_folio = mysqli_query($conexion,"SELECT MAX(folio) FROM agenda");
        $row_folio    = mysqli_fetch_array($cadena_folio);
        $folio        = $row_folio[0] + 1;

        $cadena_eventos = mysqli_query($conexion,"SELECT usuarios.id,usuarios.nombre_usuario
                            FROM usuarios
                            INNER JOIN personas ON personas.id = usuarios.id_persona
                            WHERE personas.id_sede = '$id_sede' AND usuarios.id_perfil = '11' OR usuarios.id = '2'");
        while($row_e = mysqli_fetch_array($cadena_eventos)){
            $cadena = mysqli_query($conexion,"INSERT INTO agenda (folio,title,start,end,id_usuario,fecha,hora,backgroundColor,borderColor)
        VALUES ('$folio','$title','$fecha_completa_inicio','$fecha_completa_final','$row_e[0]','$fecha','$hora','$color','$color')");
        }
    //}
}
?>