<?php
include '../global_seguridad/verificar_sesion.php';
$codigo_corte=$_POST['codigo_corte'];
$id_costeo=$_POST['id_costeo'];
$datos=[];
$cadenaConsulta="SELECT ID, ARTC_ARTICULO, ARTC_DESCRIPCION FROM carniceria_catalogorenglones WHERE CODIGO_CORTE='$codigo_corte' AND ACTIVO=1";
$consulta=mysqli_query($conexion,$cadenaConsulta);
while($row=mysqli_fetch_array($consulta)){

  $cadenaCosteo="SELECT ARTC_CANTIDAD, ARTC_PORCENTAJE, ARTC_COSTOTOTAL, ARTC_COSTOUNITARIO, ARTC_MARGEN, ARTC_PRECIOVENTA FROM carniceria_costeorenglones WHERE ID_COSTEO='$id_costeo' AND ARTC_ARTICULO='$row[1]'";
  $consultaCosteo=mysqli_query($conexion,$cadenaCosteo);
  $rowCosteo=mysqli_fetch_array($consultaCosteo);
  if(count($rowCosteo[0])==0){
    $artc_costototal='';
    $artc_costounitario='';
    $artc_precioventa='';
    $cantidad="<center><a href='#' onclick='cant(\"$codigo_corte\",$row[0])' class='btn btn-success btn-sm'><i class='fa fa-check fa-lg' aria-hidden='true'></i></a></center>";
  }else{
    $artc_costototal='$'.number_format($rowCosteo[2],2,'.',',');
    $artc_costounitario='$'.number_format($rowCosteo[3],2,'.',',');
    $artc_precioventa='$'.number_format($rowCosteo[5],2,'.',',');
    $cantidad="";
  }
  
  array_push($datos,array(
    "id"=>$row[0],
    "artc_codigo"=>$row[1],
    "artc_descripcion"=>$row[2],
    "artc_cantidad"=>round($rowCosteo[0],2),
    "artc_porcentaje"=>round($rowCosteo[1],2),
    "artc_costototal"=>$artc_costototal,
    "artc_costounitario"=>$artc_costounitario,
    "artc_margen"=>round($rowCosteo[4],2),
    "artc_precioventa"=>$artc_precioventa,
    "opciones"=>$cantidad
  ));
}
echo utf8_encode(json_encode($datos));
?>