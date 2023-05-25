<?php
include '../global_seguridad/verificar_sesion.php';
$folio_pedido = $_POST['folio_pedido'];

$cadenaPedido = "SELECT ARTC_ARTICULO, ARTC_DESCRIPCION, ARTC_UNIDADMEDIDA, ARTC_PRECIOANTIMP, ARTC_PRECIOVENTA, CANTIDAD, ARTC_PRECIORENGLON, ID FROM pv_renglonespedido WHERE ID_PEDIDO = '$folio_pedido'";
$consultaPedido = mysqli_query($conexion,$cadenaPedido);

$cuerpo="";
while($rowPedido=mysqli_fetch_array($consultaPedido)){
  $link = "<center><a href='#' class='btn btn-danger' onclick='eliminar_renglon($rowPedido[7])'><i class='fa fa-trash-o fa-lg' aria-hidden='true'></i></a></center>";
  $costo_unitario=round($rowPedido[4],2);
  $total=round($rowPedido[6],2);
  $renglon = "
		{
      \"codigo\":\"$rowPedido[0]\",
      \"descripcion\":\"$rowPedido[1]\",
      \"um\":\"$rowPedido[2]\",
      \"costo_unitario\":\"$costo_unitario\",
      \"cantidad\":\"$rowPedido[5]\",
      \"total\":\"$total\",
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