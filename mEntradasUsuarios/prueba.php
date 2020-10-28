<?php
	include "../global_settings/conexion_oracle.php";

	$cadena2 = "SELECT DISTINCT(MODC_TIPOMOV) FROM INV_MOVIMIENTOS WHERE ALMN_ALMACEN = '1'";
	$cadena = "SELECT DISTINCT(MODC_TIPOMOV)
						FROM
						INV_MOVIMIENTOS
						INNER JOIN CTB_USUARIO ON CTB_USUARIO.USUS_USUARIO = MOVN_USUARIOREALIZAMOV
						WHERE ALMN_ALMACEN = '1'";
	$consulta = oci_parse($conexion_central, $cadena2);
    oci_execute($consulta);
    while($row = oci_fetch_array($consulta)){
        echo $row[0].'<br>';
	}
?>