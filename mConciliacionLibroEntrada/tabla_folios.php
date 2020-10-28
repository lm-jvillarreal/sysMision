<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set("America/Monterrey");
$fecha=date("Y-m-d H:i:s");

$ficha_entrada = $_POST['ficha_entrada'];
$cadenaFolios = "SELECT modn_folio, modc_tipomov, monto, id FROM alb_foliomov WHERE ficha_entrada = '$ficha_entrada'";
$consultaFolios = mysqli_query($conexion,$cadenaFolios);

$cuerpo="";
while ($rowFolios = mysqli_fetch_array($consultaFolios))
{
  $eliminar = "<a href='#' class='btn btn-danger' onclick='eliminar($rowFolios[3])'><i class='fa fa-trash-o fa-lg' aria-hidden=true'></i></a>";
  $renglon = "
    {
      \"folio\": \"$rowFolios[0]\",
      \"tipo_movimiento\": \"$rowFolios[1]\",
      \"monto\": \"$rowFolios[2]\",
      \"opciones\": \"$eliminar\"
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
