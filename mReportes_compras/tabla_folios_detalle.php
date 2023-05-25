<?php
include '../global_seguridad/verificar_sesion.php';
$datos=array();
$cadenaFolios="SELECT DISTINCT(folios.FOLIO), 
                  FOLIO_DESCRIPCION,
                  (SELECT nombre FROM sucursales WHERE id=folios.FOLIO_SUCURSAL) as Sucursal,
                  (SELECT COUNT(*) FROM com_detalleArticulos WHERE FOLIO=folios.FOLIO) as conteo,
                  DATE_FORMAT(FOLIO_FECHAHORA,'%d/%m/%Y') as Fecha,
                  (SELECT nombre_usuario FROM usuarios WHERE id = folios.USUARIO) as usuario
                FROM com_detalleArticulos AS folios  WHERE folios.ACTIVO = '1' GROUP BY FOLIO";

$folios=mysqli_query($conexion,$cadenaFolios);
while($rowFolios=mysqli_fetch_array($folios)){
  $ver = "<a href='#' data-folio = '$rowFolios[0]' data-toggle = 'modal' data-target = '#modal-detalle' class='btn btn-primary' target='blank'><i class='fa fa-search fa-lg' aria-hidden='true'></i></a>";
  $eliminar="<a href='#' onclick='eliminar($rowFolios[0])' class='btn btn-danger'><i class='fa fa-trash-o fa-lg' aria-hidden='true'></i></a>";
  $opciones="<center>".$ver."&nbsp;".$eliminar."</center>";
  array_push($datos,array(
    'folio'=>$rowFolios[0],
    'descripcion'=>$rowFolios[1],
    'cantidad'=>$rowFolios[3],
    'fecha'=>$rowFolios[4],
    'sucursal'=>$rowFolios[2],
    'usuario'=>$rowFolios[5],
    'opciones'=>$opciones
  ));
}
echo utf8_encode(json_encode($datos));
?>