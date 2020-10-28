<?php
require_once 'class.textPainter.php';
include '../global_seguridad/verificar_sesion.php';

//Posicion del texto
$x = "535";
$y = "70";

//Colores
$R = "153"; 
$G = "153";
$B = "153";

//Tamaño de las letras y estilo
$size = "30";
$fuente = './fuente.ttf';

$cadena = mysqli_query($conexion,"SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno),departamento, ext, titulo, telprocede, telefono FROM personas WHERE id = '$id_persona'");
$row = mysqli_fetch_array($cadena);

$titulo = ($row[3] != "")?$row[3].'. ':"";
$telefono_empresa = ($row[4] == "")?"(01) 821 212 6200":$row[4];
$telefono_persona = ($row[5] == "")?"":$row[5];
$text = $titulo.$row[0]. PHP_EOL .$row[1]. PHP_EOL .'Cel. '.$telefono_persona. PHP_EOL .'Tel. '.$telefono_empresa.', '.'Ext.'.$row[2] ;

$img = new textPainter('./plantilla.jpeg', $text, $fuente , $size);

if(!empty($x) && !empty($y)){
    $img->setPosition($x, $y);
}

if(!empty($R) && !empty($G) && !empty($B)){
    $img->setTextColor($R,$G,$B);
}

$img->show();
?>
