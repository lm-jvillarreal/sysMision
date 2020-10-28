<?php
include '../global_seguridad/verificar_sesion.php';

$dest = imagecreatefrompng('src/imagen_'.$id_persona.'.png');
$src = imagecreatefrompng('src/qr_'.$id_persona.'.png');

imagealphablending($dest, false);
imagesavealpha($dest, true);

imagecopymerge($dest, $src, 170, 60, 0, 0, 350, 350, 100); //have to play with these numbers for it to work for you, etc.

header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary");
header("Content-disposition: attachment; filename=b_$id_usuario.png");
imagepng($dest);

imagedestroy($dest);
imagedestroy($src);
?>