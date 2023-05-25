<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
date_default_timezone_set("America/Monterrey");
$fecha=date("Y-m-d H:i:s");

$factura=$_POST['factura'];
$cadenaINV="SELECT ALMN_ALMACEN, MODC_TIPOMOV, MODN_FOLIO FROM INV_MOVIMIENTOS WHERE MOVC_CXP_REMISION='$factura'";
$consultaINV = oci_parse($conexion_central, $cadenaINV);
oci_execute($consultaINV);
$rowINV = oci_fetch_row($consultaINV);

$cadenaFE="SELECT ficha_entrada FROM alb_foliomov WHERE modc_tipomov='$rowINV[1]' AND modn_folio='$rowINV[2]' AND id_sucursal='$rowINV[0]'";
$consultaFE=mysqli_query($conexion,$cadenaFE);
$rowFE=mysqli_fetch_array($consultaFE);

$ficha_entrada = $rowFE[0];
$cadenaFolios = "SELECT c.id, 
                  c.tipo_orden,
                  c.total_diferencia,
                  c.activo
                  FROM carta_faltante AS c INNER JOIN libro_diario AS l  ON c.id_orden =l.orden_compra
                  WHERE l.numero_nota ='$ficha_entrada'
                  group by (c.id)";
$consultaFolios = mysqli_query($conexion,$cadenaFolios);

$cuerpo="";
while ($rowFolios = mysqli_fetch_array($consultaFolios))
{
  $ver ="<center><a href='../mCartas_faltantes/carta_faltante_pdf.php?id=$rowFolios[0]' target='blank' class='btn btn-primary'><i class='fa fa-search' aria-hidden=true'></i></a>";
  
  if($rowFolios[3]=="1"){
    $status = "<center><span class='label label-warning' onclick='cancelar($rowFolios[0])'>Sin afectar</span></center>";
  }elseif($rowFolios[3]=="2"){
    $status = "<center><span class='label label-success' onclick='cancelar($rowFolios[0])'>Afectado</span></center>";
  }elseif($rowFolios[3]=="3"){
    $status = "<center><span class='label label-danger' onclick='activar($rowFolios[0])'>Cancelado</span></center>";
    $ver = "";
  }

  $renglon = "
    {
      \"folio\": \"$rowFolios[0]\",
      \"tipo\": \"$rowFolios[1]\",
      \"monto\": \"$rowFolios[2]\",
      \"opciones\": \"$ver $editar\",
      \"estatus\": \"$status\"
    },";
  $cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>
