<?php
include '../global_seguridad/verificar_sesion.php';

$folio = $_POST['folio'];
$cadena_consulta = "SELECT ARTC_ARTICULO, ARTC_DESCRIPCION, ARTC_UNIDADMEDIDA, CANTIDAD, ID, CANTIDAD_SURTIDA FROM pv_renglonespedido WHERE ID_PEDIDO='$folio'";
$consulta_detalle = mysqli_query($conexion,$cadena_consulta);


$i=0;
$cuerpo ="";
while ($row_consulta=mysqli_fetch_array($consulta_detalle)) {
   $link = "<center><a href='#' class='btn btn-danger' onclick='eliminar_renglon($row_consulta[4])'><i class='fa fa-trash-o fa-lg' aria-hidden='true'></i></a></center>";
	$renglon = "
		{
         \"codigo\":\"$row_consulta[0]\",
         \"descripcion\":\"$row_consulta[1]\",
         \"um\":\"$row_consulta[2]\",
         \"cantidad\":\"$row_consulta[3]\",
         \"surtido\":\"$row_consulta[5]\",
         \"opciones\":\"$link\"
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