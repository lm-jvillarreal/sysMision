<?php
include '../global_seguridad/verificar_sesion.php';
$id_costeo=$_POST['id_costeo'];
$cadenaCosteo="SELECT ARTC_PESOENT, ARTC_COSTOKILO FROM carniceria_costeo WHERE ID='$id_costeo'";
$consultaCosteo=mysqli_query($conexion,$cadenaCosteo);
$rowCosteo=mysqli_fetch_array($consultaCosteo);

$cadenaSuma="SELECT SUM(ARTC_CANTIDAD) FROM carniceria_costeorenglones WHERE ID_COSTEO='$id_costeo'";
$consultaSuma=mysqli_query($conexion,$cadenaSuma);
$rowSuma=mysqli_fetch_array($consultaSuma);

//variables redondeo
$artc_pesoent=$rowCosteo[0];
$artc_costokilo=$rowCosteo[1];
$suma_artccantidad=$rowSuma[0];

//realizar cálculos a dos decimales
$merma_kg=$artc_pesoent-$suma_artccantidad;
$merma_valor=$artc_costokilo*$merma_kg;
$costo_total=$artc_pesoent*$artc_costokilo;
$costo_totalmerma=$merma_valor+$costo_total;
$costo_kiloneto=$costo_totalmerma/$suma_artccantidad;

$cadenaRenglones="SELECT ID, ARTC_ARTICULO, ARTC_CANTIDAD, ARTC_PRECIOVENTA FROM carniceria_costeorenglones WHERE ID_COSTEO='$id_costeo'";
$consultaRenglones=mysqli_query($conexion,$cadenaRenglones);
while($rowRenglones=mysqli_fetch_array($consultaRenglones)){
  //variables redondeadas
  $artc_cantidad=$rowRenglones[2];
  $artc_precioventa=$rowRenglones[3];

  //cálculos a dos decimales
  $artc_porcentaje=round(($artc_cantidad/$suma_artccantidad)*100,3);
  $costo_totalartc=$costo_kiloneto*$artc_cantidad;
  $costo_kiloartc=$costo_totalartc/$artc_cantidad;
  $margen_artc=(1-($costo_kiloartc/$artc_precioventa))*100;
  $cadenaActualizar="UPDATE carniceria_costeorenglones SET ARTC_PORCENTAJE ='$artc_porcentaje', ARTC_COSTOTOTAL='$costo_totalartc', ARTC_COSTOUNITARIO='$costo_kiloartc', ARTC_MARGEN='$margen_artc' WHERE ID='$rowRenglones[0]'";
  $actualizar=mysqli_query($conexion,$cadenaActualizar);
}


$cadenaFinalizar = "UPDATE carniceria_costeo SET ARTC_PESOCORTE=$suma_artccantidad, MERMA_PESO=$merma_kg, MERMA_COSTO=$merma_valor, ARTC_COSTOTOTAL=$costo_total, ARTC_COSTOGLOBAL=$costo_totalmerma, ARTC_COSTOKILONETO=$costo_kiloneto, ESTATUS='1' WHERE ID='$id_costeo'";
$final=mysqli_query($conexion,$cadenaFinalizar);
echo "ok";
?>