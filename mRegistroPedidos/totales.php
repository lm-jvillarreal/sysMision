<?php
include '../global_seguridad/verificar_sesion.php';
$folio_pedido = $_POST['pedido'];

$cadenaPedido = "SELECT CONCAT('$',ROUND(ifnull(SUM(ARTC_PRECIOANTIMP*CANTIDAD),0),2)) AS SUBTOTAL,
                  CONCAT('$',ROUND(ifnull(SUM((ARTC_PRECIOVENTA*CANTIDAD)-(ARTC_PRECIOANTIMP*CANTIDAD)),0),2)) AS IMPUESTOS,
                  CONCAT('$',ROUND(ifnull(SUM(ARTC_PRECIORENGLON),0),2)) AS TOTAL,
                  ROUND(ifnull(SUM(ARTC_PRECIORENGLON),0),2) AS TOTAL2
                  FROM pv_renglonespedido WHERE ID_PEDIDO = '$folio_pedido'";
$consultaPedido = mysqli_query($conexion,$cadenaPedido);
$rowPedido = mysqli_fetch_array($consultaPedido);
$array=array(
  $rowPedido[0],
  $rowPedido[1],
  $rowPedido[2],
  $rowPedido[3]
);
$array=json_encode($array);
echo $array;
?>