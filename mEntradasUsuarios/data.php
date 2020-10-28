<?php
	include '../global_settings/conexion_oracle.php';
	$fecha_final  = $_POST['fecha_final'];
	$fecha_inicio = $_POST['fecha_inicio'];

	$cadena = "SELECT DISTINCT
            US.USUC_NOMBRE,
            (
                SELECT
                    COUNT (ALMN_ALMACEN)
                FROM
                    INV_MOVIMIENTOS
                WHERE
                    MOVD_FECHAAFECTACION >= TRUNC (
                        TO_DATE (
                            '$fecha_inicio',
                            'YYYY/MM/DD'
                        )
                    )
                AND MOVD_FECHAAFECTACION < TRUNC (
                    TO_DATE (
                        '$fecha_final',
                        'YYYY/MM/DD'
                    )
                ) + 1
                AND (
                    MODC_TIPOMOV = 'ENTCOC'
                    OR MODC_TIPOMOV = 'ENTSOC'
                )
                AND MOVN_USUARIOREALIZAMOV = MO.MOVN_USUARIOREALIZAMOV
		            ) AS Cantidad
		        FROM
		            INV_MOVIMIENTOS MO
		        INNER JOIN CTB_USUARIO US ON US.USUS_USUARIO = MO.MOVN_USUARIOREALIZAMOV
		        WHERE
		            MOVD_FECHAAFECTACION >= TRUNC (
		                TO_DATE ('$fecha_inicio', 'YYYY/MM/DD')
		            )
		        AND MOVD_FECHAAFECTACION < TRUNC (
		            TO_DATE ('$fecha_final', 'YYYY/MM/DD')
		        ) + 1
		        AND (
		            MODC_TIPOMOV = 'ENTCOC'
		            OR MODC_TIPOMOV = 'ENTSOC'
		        )
		        AND (
											MOVN_USUARIOREALIZAMOV = '3007'
										OR MOVN_USUARIOREALIZAMOV = '3012'
										OR MOVN_USUARIOREALIZAMOV = '3013'
										OR MOVN_USUARIOREALIZAMOV = '3057'
										OR MOVN_USUARIOREALIZAMOV = '3063'
										OR MOVN_USUARIOREALIZAMOV = '3064'
										OR MOVN_USUARIOREALIZAMOV = '3102'
										OR MOVN_USUARIOREALIZAMOV = '3114'
										OR MOVN_USUARIOREALIZAMOV = '3206'
										OR MOVN_USUARIOREALIZAMOV = '3232'
										OR MOVN_USUARIOREALIZAMOV = '3476'
										OR MOVN_USUARIOREALIZAMOV = '3491'
		        ) ORDER BY Cantidad DESC";
    $st = oci_parse($conexion_central, $cadena);
    oci_execute($st);
    $json     = [];
    while ($row = oci_fetch_row($st)) {
    	$json[] = [(string)$row[0], (int)$row[1]];
        
    }

	echo json_encode($json);
?>