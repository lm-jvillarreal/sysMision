<?php
include '../global_seguridad/verificar_sesion.php';
$datos=array();
$articulo=$_POST['articulo'];
$f_inicio=$_POST['f_inicio'];
$f_fin=$_POST['f_fin'];
$cadenaCoincidencias="SELECT
id_carta_faltante,
( SELECT no_orden FROM carta_faltante WHERE id = detalle_carta_faltante.id_carta_faltante ) AS entrada,
cantidad_producto,
descripcion,
costo_unitario,
total_renglon,
fecha 
FROM
detalle_carta_faltante 
WHERE
descripcion LIKE '%$articulo%'
AND (fecha>='$f_inicio' AND fecha<='$f_fin')";
$consultaCoincidencias=mysqli_query($conexion,$cadenaCoincidencias);
while($rowCoincidencias=mysqli_fetch_array($consultaCoincidencias)){
  $link="<a href='carta_faltante_pdf.php?id=$rowCoincidencias[0]' target='blank'>$rowCoincidencias[0]</a>";
  array_push($datos,array(
    'id_carta'=>$link,
    'folio_entrada'=>$rowCoincidencias[1],
    'cantidad'=>$rowCoincidencias[2],
    'descripcion'=>$rowCoincidencias[3],
    'costo_unitario'=>$rowCoincidencias[4],
    'total'=>$rowCoincidencias[5],
    'fecha'=>$rowCoincidencias[6]
  ));
}

echo utf8_encode(json_encode($datos));
?>