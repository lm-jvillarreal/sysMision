<?php
include '../global_settings/conexion_oracle.php';
include '../global_seguridad/verificar_sesion.php';
$folio_pago = $_POST['folio_pago'];

$datos=array();

$cadenaFolios="SELECT TRIM(BENEFICIARIO), TRIM(FACTURA), DESCFACTURA, TO_CHAR(MONTOPAGAR, '$999,999.99') FROM BAN_PAGOS_FACTURAS_VW WHERE NUMEROCHEQUE='$folio_pago'";
$consulta_facturas = oci_parse($conexion_central, $cadenaFolios);
oci_execute($consulta_facturas);
while($row = oci_fetch_row($consulta_facturas)){

  $cadenaNC="SELECT TO_CHAR(SUM(NCCN_IMPORTE),'$99,999.99')
              FROM
                CXP_NOTASCARCRE NC
              WHERE
                NCCC_NUMFACT = '$row[1]'";
  $consultaNC=oci_parse($conexion_central,$cadenaNC);
  oci_execute($consultaNC);
  $rowNC=oci_fetch_row($consultaNC);
  $nc="<a href='#' onclick=tabla_nc('$row[1]')>$rowNC[0]</a>";

  $cadenaINV="SELECT ALMN_ALMACEN, MODC_TIPOMOV, MODN_FOLIO, TO_CHAR(MOVD_FECHAAFECTACION, 'DD/MM/YYYY') FROM INV_MOVIMIENTOS WHERE MOVC_CXP_REMISION='$row[1]'";
  $consultaINV = oci_parse($conexion_central, $cadenaINV);
  oci_execute($consultaINV);
  $rowINV = oci_fetch_row($consultaINV);

  $cadenaFE="SELECT 
              ficha_entrada,
              (SELECT DATE_FORMAT(fecha, '%d/%m/%Y') FROM libro_diario WHERE numero_nota=alb_foliomov.ficha_entrada)
             FROM 
              alb_foliomov 
             WHERE modc_tipomov='$rowINV[1]' 
              AND modn_folio='$rowINV[2]' 
              AND id_sucursal='$rowINV[0]'";
  $consultaFE=mysqli_query($conexion,$cadenaFE);
  $rowFE=mysqli_fetch_array($consultaFE);

  $ficha_entrada = $rowFE[0];
  $cadenaCF = "SELECT SUM(total_diferencia)
                    FROM carta_faltante AS c INNER JOIN libro_diario AS l  ON c.id_orden =l.orden_compra
                    WHERE l.numero_nota ='$ficha_entrada' AND (c.activo='1' OR c.activo='2')
                    group by (c.id)";
  $consultaCF = mysqli_query($conexion,$cadenaFolios);
  $rowCF = mysqli_fetch_array($consultaCF);
  $cf="<a href='#' onclick=tabla_cf('$row[1]')>$rowCF[0]</a>";

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
$rowDC = mysqli_fetch_array($consultaDC);

if(is_null($rowDC[4])){
  $dc = $rowDC[3];
}else{
  $dc=$rowDC[4];
}
$dc="<a href='#' onclick=tabla_dc('$row[1]')>$dc</a>";
$factura = "<a href='#' data-almacen='$rowINV[0]' data-tipomov = '$rowINV[1]' data-foliomov='$rowINV[2]' data-fechaafectacion='$rowINV[3]' data-ficha='$rowFE[1]' data-toggle = 'modal' data-target = '#modal-entradas'>$row[1]</a>";
  array_push($datos,array(
    'proveedor'=>$row[0],
    'factura'=>$factura,
    'descripcion'=>$row[2],
    'monto'=>$row[3],
    'carcre'=>$nc,
    'cf'=>$cf,
    'cp'=>$dc
  ));
}
echo utf8_encode(json_encode($datos));
?>