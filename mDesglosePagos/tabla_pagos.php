<?php
include '../global_settings/conexion_oracle.php';
include '../global_seguridad/verificar_sesion.php';
$fi = $_POST['fi'];
$ff = $_POST['ff'];

$datos=array();

$cadenaPagos="SELECT
              DISTINCT(NUMEROCHEQUE),
              (SELECT TRIM(BENEFICIARIO) FROM BAN_PAGOS_FACTURAS_VW WHERE NUMEROCHEQUE=P.NUMEROCHEQUE AND ROWNUM=1) PROVEEDOR,
              (SELECT TO_CHAR(SUM(MONTOPAGAR),'$999,999.99') FROM BAN_PAGOS_FACTURAS_VW WHERE NUMEROCHEQUE=P.NUMEROCHEQUE) MONTO
              FROM
              BAN_PAGOS_FACTURAS_VW P
              WHERE
              FECHACHEQUE >= TRUNC(
              TO_DATE( '$fi', 'YYYY-MM-DD' )) 
              AND FECHACHEQUE <= TRUNC(
              TO_DATE( '$ff', 'YYYY-MM-DD' ))
              GROUP BY NUMEROCHEQUE";
$consultaPagos = oci_parse($conexion_central, $cadenaPagos);
oci_execute($consultaPagos);
while($row = oci_fetch_row($consultaPagos)){
  $detalle="<center><a href='index_.php?chk=$row[0]' class='btn btn-danger btn-sm'><i class='fa fa-search fa-lg' aria-hidden='true'></i></a></center>";
  array_push($datos,array(
    'folio'=>$row[0],
    'proveedor'=>$row[1],
    'monto'=>$row[2],
    'opciones'=>$detalle
  ));
}
echo utf8_encode(json_encode($datos));
?>