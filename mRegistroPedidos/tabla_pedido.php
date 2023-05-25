<?php
include '../global_seguridad/verificar_sesion.php';
$folio_pedido = $_POST['folio_pedido'];
$datos=array();
$cadenaPedido = "SELECT ARTC_ARTICULO, ARTC_DESCRIPCION, ARTC_UNIDADMEDIDA, ARTC_PRECIOANTIMP, ARTC_PRECIOVENTA, CANTIDAD, ARTC_PRECIORENGLON, ID FROM pv_renglonespedido WHERE ID_PEDIDO = '$folio_pedido' ORDER BY ID DESC";
$consultaPedido = mysqli_query($conexion,$cadenaPedido);

while($rowPedido=mysqli_fetch_array($consultaPedido)){
  $link = "<center><a href='#' class='btn btn-danger' onclick='eliminar_renglon($rowPedido[7])'><i class='fa fa-trash-o fa-lg' aria-hidden='true'></i></a></center>";
  $costo_unitario=round($rowPedido[4],2);
  $total=round($rowPedido[6],2);
  
array_push($datos,array(
   'codigo'=>$rowPedido[0],
   'descripcion'=>$rowPedido[1],
   'um'=>$rowPedido[2],
   'costo_unitario'=>$costo_unitario,
   'cantidad'=>$rowPedido[5],
   'total'=>$total,
   'opciones'=>$link
 ));
}
echo utf8_encode(json_encode($datos));
?>