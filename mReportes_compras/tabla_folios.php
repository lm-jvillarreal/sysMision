<?php
include '../global_seguridad/verificar_sesion.php';
$datos=array();
$cadenaFolios="SELECT DISTINCT(folios.FOLIO), 
                CONCAT(folios.FOLIO_FECHAINICIO,' - ',folios.FOLIO_FECHAFIN) as rango,
                  (SELECT nombre FROM sucursales WHERE id=folios.FOLIO_SUCURSAL) as Sucursal,
                  (SELECT COUNT(*) FROM com_kardexMovimientos WHERE FOLIO=folios.FOLIO) as conteo,
                   DATE_FORMAT(FECHAHORA_FOLIO,'%d/%m/%Y') as Fecha,
                  (SELECT nombre_usuario FROM usuarios WHERE id = folios.USUARIO) as usuario
                FROM com_kardexMovimientos AS folios  WHERE folios.ACTIVO = '1' GROUP BY FOLIO";

$folios=mysqli_query($conexion,$cadenaFolios);
while($rowFolios=mysqli_fetch_array($folios)){
  $ver = "<center><a href='#' data-folio = '$rowFolios[0]' data-toggle = 'modal' data-target = '#modal-kardex' class='btn btn-primary' target='blank'><i class='fa fa-search fa-lg' aria-hidden='true'></i></a>";
  $eliminar="<a href='#' onclick='eliminar_folio($rowFolios[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a></center>";
  $opciones=$ver." ".$eliminar;
  array_push($datos,array(
    'folio'=>$rowFolios[0],
    'rango'=>$rowFolios[1],
    'cantidad'=>$rowFolios[3],
    'fecha'=>$rowFolios[4],
    'sucursal'=>$rowFolios[2],
    'usuario'=>$rowFolios[5],
    'opciones'=>$opciones
  ));
}
echo utf8_encode(json_encode($datos));
?>