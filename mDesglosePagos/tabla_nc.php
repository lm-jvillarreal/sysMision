<?php
include '../global_settings/conexion_oracle.php';
include '../global_seguridad/verificar_sesion.php';
$factura = $_POST['factura'];

$datos=array();

$cadenaNC="SELECT
            CONCAT(
              TRIM( PROC_CVEPROVEEDOR ),
              CONCAT(
                ' ',
                (
                SELECT
                  TRIM( PROC_NOMBRE ) 
                FROM
                  CXP_PROVEEDORES 
                WHERE
                TRIM( PROC_CVEPROVEEDOR ) = TRIM( NC.PROC_CVEPROVEEDOR )))) PROVEEDOR,
            NCCV_NUMNCC,
            TO_CHAR( NCCD_CONTABILIZACION, 'DD/MM/YYYY' ) Contabiliza,
            TO_CHAR(NCCN_IMPORTE,'$99,999.99') MONTO
            FROM
            CXP_NOTASCARCRE NC 
            WHERE
            NCCC_NUMFACT = '$factura'";
$consulta_nc = oci_parse($conexion_central, $cadenaNC);
oci_execute($consulta_nc);
while($row = oci_fetch_row($consulta_nc)){
  array_push($datos,array(
    'proveedor'=>$row[0],
    'folio'=>$row[1],
    'fecha'=>$row[2],
    'monto'=>$row[3]
  ));
}
echo utf8_encode(json_encode($datos));
?>