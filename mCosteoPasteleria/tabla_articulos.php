<?php
include '../global_seguridad/verificar_sesion.php';
$datos=array();
$cadenaConsulta="SELECT
                  ID,
                  ARTC_ARTICULO, 
                  ARTC_DESCRIPCION, 
                  PROVEEDOR, 
                  RMON_ULTIMOPRECIO, 
                  UNIMEDIDA_VENTA, 
                  FACTOR_EMPAQUE, 
                  PORCENTAJE_MERMA, 
                  FECHAHORA, 
                  ACTIVO, 
                  USUARIO 
                FROM pasteleria_articulos 
                WHERE ACTIVO=1";

$consulta=mysqli_query($conexion,$cadenaConsulta);
while($row=mysqli_fetch_array($consulta)){
  array_push($datos,array(
    "id"=>$row[0],
    "artc_articulo"=>$row[1],
    "artc_descripcion"=>$row[2],
    "proveedor"=>$row[3],
    "rmon_ultimoprecio"=>$row[4],
    "unimedida_venta"=>$row[5],
    "factor_empaque"=>$row[6],
    "porcentaje_merma"=>$row[7],
    "fechahora"=>$row[8]
  ));
}
echo utf8_encode(json_encode($datos));