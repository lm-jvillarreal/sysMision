<?php
include '../global_seguridad/verificar_sesion.php';
$datos=array();
$articulo=$_POST['articulo'];
$f_inicio=$_POST['f_inicio'];
$f_fin=$_POST['f_fin'];
$cadenaCoincidencias="SELECT id, codigo, descripcion, id_solicitud, formato, fecha, ( SELECT sucursal FROM solicitud_etiquetas WHERE id = detalle_solicitud.id_solicitud ) AS sucursal FROM detalle_solicitud WHERE
codigo LIKE '%$articulo%'
AND (fecha>='$f_inicio' AND fecha<='$f_fin') GROUP BY id_solicitud";
$consultaCoincidencias=mysqli_query($conexion,$cadenaCoincidencias);
while($rowCoincidencias=mysqli_fetch_array($consultaCoincidencias)){
  if($rowCoincidencias[6]=='1'){
    $sucursal = "DIAZ ORDAZ";
  }else if($rowCoincidencias[6]=='2'){
    $sucursal = "ARBOLEDAS";
  }else if($rowCoincidencias[6]=='3'){
    $sucursal = "VILLEGAS";
  }else if($rowCoincidencias[6]=='4'){
    $sucursal = "ALLENDE";
  }else if($rowCoincidencias[6]=='5'){
    $sucursal = "PETACA";
  }else if($rowCoincidencias[6]=='6'){
    $sucursal = "MONTEMORELOS";
  }
  //$link="<a href='carta_faltante_pdf.php?id=$rowCoincidencias[0]' target='blank'>$rowCoincidencias[0]</a>";
  array_push($datos,array(
    'id'=>$rowCoincidencias[0],
    'folio_solicitud'=>$rowCoincidencias[3],
    'sucursal'=>$sucursal,
    'codigo'=>$rowCoincidencias[1],
    'descripcion'=>$rowCoincidencias[2],
    'fecha'=>$rowCoincidencias[5]
  ));
}

echo utf8_encode(json_encode($datos));
?>