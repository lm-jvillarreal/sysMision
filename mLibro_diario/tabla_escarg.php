<?php
include '../global_seguridad/verificar_sesion.php';
$ficha_entrada=$_POST['ficha_entrada'];



$cadenaEscarg="SELECT ID, ARTC_ARTICULO, ARTC_DESCRIPCION, ARTC_CANTIDAD FROM recibo_escarg WHERE FICHA_ENTRADA='$ficha_entrada'";
$consultaEscarg=mysqli_query($conexion,$cadenaEscarg);
$cuerpo = "";
while($rowEscarg=mysqli_fetch_array($consultaEscarg)){
  $eliminar = "<center><a href='#' class='btn btn-danger' onclick='eliminar_escarg($rowEscarg[0])'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a></center>";
  $cantidad = "<div class='input-group' style='width:100%''><input type='text' id='folio_$rowEscarg[0]' class='form-control' value='$rowEscarg[3]'><span class='input-group-btn'><button onclick='cantidad_escarg($rowEscarg[0])' class='btn btn-danger' type='button'><i class='fa fa-save fa-lg' aria-hidden='true'></i></button></span></div>";
$renglon = "
		{
			\"artc_articulo\": \"$ficha_entrada\",
			\"artc_descripcion\": \"$rowEscarg[2]\",
      \"artc_cantidad\": \"$cantidad\",
      \"opciones\": \"$eliminar\"
	  },";
	$cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');
$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>