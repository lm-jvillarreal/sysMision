<?php 
include '../global_seguridad/verificar_sesion.php';


$cadena="SELECT DISTINCT(FOLIO_PEDIDO), DESCRIPCION_TRASPASO, DATE_FORMAT(FECHAHORA_SOLICITA,'%d/%m/%Y'),
        (SELECT COUNT(*) FROM solicitud_traspasos WHERE FOLIO_PEDIDO=T.FOLIO_PEDIDO) AS ARTICULOS,
        (SELECT nombre_usuario FROM usuarios WHERE id=T.ID_SOLICITA) AS SOLICITA,
        ESTATUS,
        (SELECT nombre FROM sucursales WHERE id=T.SUCURSAL),
        FOLIO_TRASPASO
        FROM solicitud_traspasos AS T
        WHERE (T.ESTATUS='1' OR T.ESTATUS='2' OR T.ESTATUS='4') AND isnull(ARTC_ENVIADO) AND ACTIVO='1'";
$consulta = mysqli_query($conexion,$cadena);

$cuerpo = "";
$numero = 1;
while ($row = mysqli_fetch_array($consulta)) 
{
  if($row[5]=='1'){
    $estatus="<center><span class='label label-danger'>En espera</span></center>";
    $link = "<center><a href='#' data-folio = '$row[0]' data-toggle = 'modal' data-target = '#modal-detalle' class='btn btn-success' target='blank'><i class='fa fa-pencil-square-o fa-lg' aria-hidden='true'></i></a></center>";
  }elseif($row[5]=='2'){
    $estatus="<center><span class='label label-success'>Surtido</span></center>";
    $link="<center><a href='#' onclick='valida_folio($row[0])' class='btn btn-primary'><i class='fa fa-check fa-lg' aria-hidden='true'></i></a></center>";
  }elseif($row[5]=='3'){
    $estatus="<center><span class='label label-success'>Capturado</span></center>";
    $link="";
  }elseif($row[5]=='4'){
    $estatus="<center><span class='label label-primary'>$row[7]</span></center>";
    $link="<center><a href='#' onclick='traspaso($row[0],$row[7])' class='btn btn-success'><i class='fa fa-check fa-lg' aria-hidden='true'></i></a></center>";
  }
  $renglon = "
    {
      \"folio\":\"$row[0]\",
      \"pedido\":\"$row[1]\",
      \"fecha\":\"$row[2]\",
      \"articulos\":\"$row[3]\",
      \"solicita\":\"$row[4]\",
      \"sucursal\":\"$row[6]\",
      \"estatus\":\"$estatus\",
      \"opciones\":\"$link\"
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