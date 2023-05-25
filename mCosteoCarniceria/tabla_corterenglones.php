<?php
include '../global_seguridad/verificar_sesion.php';
$id_catalogo=$_POST['id_catalogo'];
$datos=[];
$cadena="SELECT ID, ARTC_ARTICULO, ARTC_DESCRIPCION FROM carniceria_catalogorenglones WHERE ID_CATALOGO='$id_catalogo'";
$consulta=mysqli_query($conexion,$cadena);
while($row=mysqli_fetch_array($consulta)){
  $eliminar="<center><a href='#' onclick='eliminar($row[0])' class='btn btn-danger btn-sm'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a></center>";
  array_push($datos,array(
    "id"=>$row[0],
    "artc_codigo"=>$row[1],
    "artc_corte"=>$row[2],
    "opciones"=>$eliminar
  ));
}
echo utf8_encode(json_encode($datos));
?>