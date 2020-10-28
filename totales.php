<?php
$conexion_central = oci_connect('INFOFIN', 'INFOFIN', '200.1.1.185/INFOFIN');
$proveedores=array('1277','1344','1352','1357','1376','1478','1580','1620','1658','1750','1895','1905','1999','2028','2032','2055','2072','2181','2193','2202','2248','2267','2285','2307','2375','2428','2473','2533','2644','2660','2683','2740','2796','2825','2830','2872','2876','2889','2942','2949','2967','2999','3041','3098','3145','3194','3195','3216','3303','3355','3363','3390','3407','3464','3483','3522','3540','3542','3550','3569','3638','3683','3717','3780','3806','3854','3878','3909','3945','3949','3972','4042','4053','4084','4089','4102','4103','4143','4156','4158','00082','00173','00178','00195','00381','00413','00457','00605','00801');
echo "<table border='1'>";
foreach($proveedores as $proveedor){
  $total_prov=0;
  $cadenaTotales="SELECT
                    ( SELECT SUM( KARN_TOTAL ) FROM INV_MOVTOS_KARDEX_VW WHERE ALMN_ALMACEN = M.ALMN_ALMACEN AND MODC_TIPOMOV = M.MODC_TIPOMOV AND MODN_FOLIO = M.MODN_FOLIO ) TOTAL 
                  FROM
                    INV_MOVIMIENTOS M 
                  WHERE
                    ( MODC_TIPOMOV = 'ENTSOC' OR MODC_TIPOMOV = 'ENTCOC' )
                    AND MOVC_CVEPROVEEDOR = '$proveedor' 
                    AND MOVD_FECHAAFECTACION >= trunc(
                    TO_DATE( '2020-01-01', 'YYYY/MM/DD' )) 
                    AND MOVD_FECHAAFECTACION < trunc(
                    TO_DATE( '2020-10-15', 'YYYY/MM/DD' )) + 1";
  $stTotales=oci_parse($conexion_central,$cadenaTotales);
  oci_execute($stTotales);
  while($rowOferta=oci_fetch_array($stTotales)){
    $total_prov+=$rowOferta[0];
  }
  //echo $proveedor.' - '.$total_prov.'<br>';
  echo "<tr><td>".$proveedor."</td><td>".round($total_prov,4)."</td></tr>";
}
echo "</table>";
?>