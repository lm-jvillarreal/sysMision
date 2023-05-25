<?php
$imagen = base64_decode($_POST["imagen"]);
$usuario = $_POST["usuario"];

$fecha = date("Ymd");
$hora = date("His");

$nombre = $fecha."_".$hora."_".$usuario.".jpg";
$directorio = $nombre;

file_put_contents($directorio, $imagen);
?>