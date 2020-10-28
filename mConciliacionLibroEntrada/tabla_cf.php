<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set("America/Monterrey");
$fecha=date("Y-m-d H:i:s");

$ficha_entrada = $_POST['ficha_entrada'];
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
  $editar ="<a href='../mCartas_faltantes/carta_faltante.php?id=$rowFolios[0]' target='blank' class='btn btn-danger'><i class='fa fa-edit' aria-hidden=true'></i></a></center>";
  
  if($rowFolios[3]=="1"){
    $status = "<center><span class='label label-warning' onclick='cancelar($rowFolios[0])'>Sin afectar</span></center>";
  }elseif($rowFolios[3]=="2"){
    $status = "<center><span class='label label-success' onclick='cancelar($rowFolios[0])'>Afectado</span></center>";
  }elseif($rowFolios[3]=="3"){
    $status = "<center><span class='label label-danger' onclick='activar($rowFolios[0])'>Cancelado</span></center>";
    $ver = "";
    $editar = "";
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
