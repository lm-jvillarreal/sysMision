<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
$datos=array();
$fecha_inicio=$_POST['fecha_inicio'];
$fecha_fin=$_POST['fecha_fin'];
$sucursal=$_POST['sucursal'];

$cadenaConsulta="SELECT 
                  SUM(ARTC_CANTIDAD) AS CANTIDAD,
                  ARTC_ARTICULO,
                  ARTC_DESCRIPCION,
                  ARTC_FAMILIA,
                  FORMAT(ARTC_PRECIO,2),
                  FORMAT(ARTC_CAMBIOPRECIO,2),
                  FORMAT(ARTC_DIFERENCIAPRECIO,2),
                  FORMAT(SUM(TOTAL_DIFERENCIAPRECIO),2) AS TOTAL,
                  date_format(FECHAHORA_CAMBIO,'%d/%m/%Y %H:%i:%s') AS FECHA
                  FROM valecaja_provisional
                  WHERE SUCURSAL='$sucursal' AND ESTATUS='2'
                  AND (date_format(FECHAHORA_CAMBIO,'%Y-%m-%d')>='$fecha_inicio' AND date_format(FECHAHORA_CAMBIO,'%Y-%m-%d')<='$fecha_fin')
                  GROUP BY FOLIO_TICKET";
$consultaResumen=mysqli_query($conexion,$cadenaConsulta);

while($row=mysqli_fetch_array($consultaResumen)){

  $cadenaDepto="SELECT F.FAMC_DESCRIPCION 
                FROM COM_FAMILIAS FAM INNER JOIN COM_FAMILIAS F ON FAM.FAMC_FAMILIAPADRE=F.FAMC_FAMILIA
                WHERE FAM.FAMC_FAMILIA='$row[3]'";

  $consultaDepto = oci_parse($conexion_central,$cadenaDepto);
  oci_execute($consultaDepto);
  $rowDepto=oci_fetch_row($consultaDepto);

  array_push($datos,array(
    'cantidad'=>$row[0],
    'codigo'=>$row[1],
    'descripcion'=>$row[2],
    'departamento'=>$rowDepto[0],
    'artc_precio'=>$row[4],
    'artc_cambioprecio'=>$row[5],
    'artc_diferencia'=>$row[6],
    'total'=>$row[7],
    'fecha'=>$row[8]
  ));
}
echo utf8_encode(json_encode($datos));
?>