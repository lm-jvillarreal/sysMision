<?php
ob_start();
require_once 'class.textPainter.php';
include '../global_seguridad/verificar_sesion.php';

$cadenaEmpleado="SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno),departamento, ext, titulo, telprocede, e_mail, telefono FROM personas WHERE id = '$id_persona'";
$consultaEmpleado=mysqli_query($conexion,$cadenaEmpleado);
$row=mysqli_fetch_array($consultaEmpleado);


//Posicion del texto
$x = "550";
$y = "100";

//Colores
$R = "010"; 
$G = "010";
$B = "010";

//Tamaño de las letras y estilo
$size = "20";
$fuente = './fuente.otf';
$celular=($row[6] =="")?"":"Cel. ".$row[6];
$titulo = ($row[3] != "")?$row[3].'. ':"";
$telefono_empresa = ($row[4] == "")?"(01) 821 212 6200":$row[4];
$text = $titulo.$row[0]. PHP_EOL . PHP_EOL .$row[1].PHP_EOL . PHP_EOL . $row[5]. PHP_EOL . PHP_EOL . 'Oficina '.$telefono_empresa.', '.'EXT. '.$row[2].PHP_EOL . PHP_EOL .$celular;

$img = new textPainter('./tarjeta.png', $text, $fuente , $size);

if(!empty($x) && !empty($y)){
    $img->setPosition($x, $y);
}

if(!empty($R) && !empty($G) && !empty($B)){
    $img->setTextColor($R,$G,$B);
}
$img->show();

file_put_contents('src/imagen_'.$id_persona.'.png', ob_get_contents());
?>