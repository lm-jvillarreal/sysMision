<?php
include "../global_settings/conexion_oracle.php";
$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
    FROM INV_MOVIMIENTOS
    WHERE MODC_TIPOMOV = 'SXMCAR'
    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('2019-05-01','YYYY-MM-DD'))
    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('2019-05-31', 'YYYY-MM-DD'))
    AND ALMN_ALMACEN = '1'";
				
    $consulta_sxmcar = oci_parse($conexion_central, $cadena_consulta);
    oci_execute($consulta_sxmcar);
    while($row_sxmcar = oci_fetch_array($consulta_sxmcar)){
        $conteo_row = oci_num_rows($consulta_sxmcar);
    }
    echo $conteo_row;
    
?>