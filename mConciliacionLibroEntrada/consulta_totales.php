<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set("America/Monterrey");
$fecha=date("Y-m-d H:i:s");

$ficha_entrada = $_POST['ficha_entrada'];
$cadenaTotalEntrada = "SELECT IFNULL(SUM(monto),0) FROM alb_foliomov WHERE ficha_entrada = '$ficha_entrada' AND (modc_tipomov='ENTSOC' or modc_tipomov='ENTCOC')";
$consultaTotalEntrada = mysqli_query($conexion, $cadenaTotalEntrada);
$rowTotalEntrada = mysqli_fetch_array($consultaTotalEntrada);
$totalEntrada = $rowTotalEntrada[0];

$cadenaTotalDev = "SELECT IFNULL(SUM(monto),0) FROM alb_foliomov WHERE ficha_entrada = '$ficha_entrada' AND (modc_tipomov='DEVPRO' or modc_tipomov='DEVXCO' or modc_tipomov='DMPROV')";
$consultaTotalDev = mysqli_query($conexion, $cadenaTotalDev);
$rowTotalDev = mysqli_fetch_array($consultaTotalDev);
$totalDev =$rowTotalDev[0];

$cadenaTotalCF ="SELECT
                IFNULL(SUM(c.total_diferencia),0)
                FROM carta_faltante AS c INNER JOIN libro_diario AS l  ON c.id_orden =l.orden_compra
                WHERE c.activo='2'
                AND l.numero_nota ='$ficha_entrada'";
$consultaTotalCF = mysqli_query($conexion, $cadenaTotalCF);
$rowTotalCF = mysqli_fetch_array($consultaTotalCF);
$totalCF = $rowTotalCF[0];

$cadenaTotalNC = "SELECT  IFNULL(SUM(ne.diferencia),0), IFNULL(SUM(ne.dif_impuestos),0), ne.tipo_operacion 
FROM notas_entrada as ne INNER JOIN alb_foliomov as alb ON ne.folio_mov = alb.modn_folio AND ne.tipo_mov = alb.modc_tipomov AND ne.id_sucursal = alb.id_sucursal
WHERE alb.ficha_entrada = '$ficha_entrada' AND tipo_operacion='ABONO'";

$consultaTotalNC = mysqli_query($conexion,$cadenaTotalNC);
$rowTotalNC = mysqli_fetch_array($consultaTotalNC);
if($rowTotalNC[1]=='0'){
  $totalNC = $rowTotalNC[0];
  $totalNC = -1*$totalNC;
}else{
  $totalNC = -1*$rowTotalNC[1];
}

$cadenaTotalNC2="SELECT  IFNULL(SUM(ne.diferencia),0), IFNULL(SUM(ne.dif_impuestos),0), ne.tipo_operacion 
FROM notas_entrada as ne INNER JOIN alb_foliomov as alb ON ne.folio_mov = alb.modn_folio AND ne.tipo_mov = alb.modc_tipomov AND ne.id_sucursal = alb.id_sucursal
WHERE alb.ficha_entrada = '$ficha_entrada' AND tipo_operacion='CARGO'";
$consutaTotalNC2=mysqli_query($conexion,$cadenaTotalNC2);
$rowTotalNC2=mysqli_fetch_array($consutaTotalNC2);
if($rowTotalNC2[1]=='0'){
  $totalNC2=$rowTotalNC2[0];
}else{
  $totalNC2 = $rowTotalNC2[1];
}

$granTotal = ($totalEntrada+$totalNC+$totalNC2+$totalCF)-$totalDev;

$array=array(
  $totalEntrada,
  $totalDev,
  $totalCF,
  $totalNC,
  $granTotal,
  $totalNC2
);
$array = json_encode($array);
echo $array;
?>