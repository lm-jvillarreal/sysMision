<?php
define('directorio',"");
$archivo = $_POST["filename"];
if(move_uploaded_file($_FILES["picture"]["tmp_name"],$archivo)){
    echo $archivo;
}else{
    echo"falla";
}
/*$imagen = base64_decode($_POST["imagen"]);
$usuario = $_POST["usuario"];

$fecha = date("Ymd");
$hora = date("His");

$nombre = $fecha."_".$hora."_".$usuario.".jpg";
$directorio = $nombre;

file_put_contents($directorio, $imagen);*/
?>