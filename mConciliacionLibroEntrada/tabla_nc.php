<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set("America/Monterrey");
$fecha=date("Y-m-d H:i:s");

$ficha_entrada = $_POST['ficha_entrada'];
$cadenaFolios = "SELECT ne.id, ne.folio_mov, ne.tipo_mov, ne.diferencia, ne.dif_impuestos, ne.id_sucursal 
                  FROM notas_entrada as ne INNER JOIN alb_foliomov as alb ON ne.folio_mov = alb.modn_folio AND ne.tipo_mov = alb.modc_tipomov AND ne.id_sucursal = alb.id_sucursal
                  WHERE alb.ficha_entrada = '$ficha_entrada'";
$consultaFolios = mysqli_query($conexion,$cadenaFolios);

$cuerpo="";
while ($rowFolios = mysqli_fetch_array($consultaFolios))
{
  if(is_null($rowFolios[4])){
    $monto = $rowFolios[3];
  }else{
    $monto=$rowFolios[4];
  }
  $ver ="<center><a href='../mFacturasEntradasNew/nota_cargo.php?folio=$rowFolios[1]&tipo_mov=$rowFolios[2]&sucursal=$rowFolios[5]' target='blank' class='btn btn-primary'><i class='fa fa-search' aria-hidden=true'></i></a>";
  $editar ="<a href='' target='blank' class='btn btn-danger'><i class='fa fa-edit' aria-hidden=true'></i></a></center>";
  $opciones=$ver;
  $renglon = "
    {
      \"folio\":    \"$rowFolios[1]\",
      \"tipo\":     \"$rowFolios[2]\",
      \"monto\":    \"$monto\",
      \"opciones\": \"$opciones\"
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
