<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
$datos=array();

$factura = $_POST['factura'];

$cadenaINV="SELECT ALMN_ALMACEN, MODC_TIPOMOV, MODN_FOLIO FROM INV_MOVIMIENTOS WHERE MOVC_CXP_REMISION='$factura'";
$consultaINV = oci_parse($conexion_central, $cadenaINV);
oci_execute($consultaINV);
$rowINV = oci_fetch_row($consultaINV);

$cadenaDC = "SELECT
              id,
              folio_mov,
              tipo_mov,
              diferencia,
              dif_impuestos,
              id_sucursal 
              FROM
              notas_entrada 
              WHERE
              id_sucursal = '$rowINV[0]' 
              AND tipo_mov = '$rowINV[1]' 
              AND folio_mov = '$rowINV[2]'";
$consultaDC = mysqli_query($conexion,$cadenaDC);

while ($rowDC = mysqli_fetch_array($consultaDC))
{
  if(is_null($rowDC[4])){
    $monto = $rowDC[3];
  }else{
    $monto=$rowDC[4];
  }
  $ver ="<center><a href='../mFacturasEntradasNew/nota_cargo.php?folio=$rowDC[1]&tipo_mov=$rowDC[2]&sucursal=$rowDC[5]' target='blank' class='btn btn-primary'><i class='fa fa-search' aria-hidden=true'></i></a>";
  $editar ="<a href='' target='blank' class='btn btn-danger'><i class='fa fa-edit' aria-hidden=true'></i></a></center>";
  $opciones=$ver;
  
  array_push($datos,array(
    'folio'=>$rowDC[1],
    'tipo'=>$rowDC[2],
    'monto'=>round($monto,2),
    'opciones'=>$opciones
  ));
}
echo utf8_encode(json_encode($datos));
?>
