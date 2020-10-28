<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set("America/Monterrey");
$fecha=date("Y-m-d H:i:s");

$ficha_entrada = $_POST['ficha_entrada'];

$cadenaFolios = "SELECT artc_articulo, artc_descripcion, artc_cantidad
                  FROM recibo_escarg where ficha_entrada='$ficha_entrada'";
$consultaFolios = mysqli_query($conexion,$cadenaFolios);

$cuerpo="";
while ($row = mysqli_fetch_array($consultaFolios))
{
  $eliminar = "<a href='#' class='btn btn-danger' onclick='eliminar($row[0])'><i class='fa fa-trash-o fa-lg' aria-hidden=true'></i></a>";
  $renglon = "
    {
      \"artc_articulo\": \"$row[0]\",
      \"artc_descripcion\": \"$row[1]\",
      \"cantidad\": \"$row[2]\",
      \"opciones\": \"\"
    },";
  $cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>
