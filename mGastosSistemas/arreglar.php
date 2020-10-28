<?php
	include '../global_settings/conexion_oracle.php';
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');

$cadena = mysqli_query($conexion,"SELECT id,proveedor,fecha_movimiento,gasto FROM gastos_sistemas WHERE (folio_factura is null OR folio_factura = '')");
$numero = 0;
while ($row = mysqli_fetch_array($cadena)) {
  $cadena_detalle = "SELECT CONCAT(CONCAT(CP.PROC_CVEPROVEEDOR,'' ), CP.PROC_NOMBRE),
                        CM.MOVN_MONTO,
                        CM.MOVD_FECHA,
                        CP.PROC_CVEPROVEEDOR,
                        CM.MOVC_REFERENCIAC1
                      FROM CXP_MOVIMIENTOS CM
                      INNER JOIN CXP_PROVEEDORES CP ON CP.PROC_CVEPROVEEDOR = CM.PROC_CVEPROVEEDOR
                      WHERE CM.MOVD_FECHA >= TO_DATE('$row[2]','YYYY/MM/DD')
                      AND MOVN_REFERENCIAN2 IS NOT NULL
                      AND CM.MOVN_MONTO = '$row[3]'";

    $consulta_detalle = oci_parse($conexion_central, $cadena_detalle);
    oci_execute($consulta_detalle);

  $row2 = oci_fetch_row($consulta_detalle);
  $actualizar = mysqli_query($conexion,"UPDATE gastos_sistemas SET folio_factura = '$row2[4]' WHERE id = '$row[0]'");
  $numero ++;
  
}
echo $numero.' Registros Modificados';
?>