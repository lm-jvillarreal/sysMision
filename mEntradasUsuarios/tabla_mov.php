<?php
	include '../global_settings/conexion_oracle.php';
	$fecha_inicio = $_POST['fecha1'];
	$fecha_final  = $_POST['fecha2'];
	$sucursal     = $_POST['sucursal'];

    $cadena = "SELECT DISTINCT(MO.MOVN_USUARIOREALIZAMOV),US.USUC_NOMBRE
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
				AND ALMN_ALMACEN = '$sucursal'";

	$st = oci_parse($conexion_central, $cadena);
	oci_execute($st);
	
	$cuerpo ="";
	$numero = 1;

	while($row = oci_fetch_row($st))
    {   
    	$cadena1 = "SELECT COUNT(*) FROM INV_MOVIMIENTOS WHERE MODC_TIPOMOV = 'SXMCAR' AND MOVD_FECHAAFECTACION >= TRUNC (TO_DATE ('$fecha_inicio', 'YYYY/MM/DD')) AND MOVD_FECHAAFECTACION<TRUNC(TO_DATE('$fecha_final','YYYY/MM/DD'))+1 AND MOVN_USUARIOREALIZAMOV = '$row[0]' AND ALMN_ALMACEN = '$sucursal'";
		$st1 = oci_parse($conexion_central, $cadena1);
		oci_execute($st1);
		$row1 = oci_fetch_row($st1);

		$cadena2 = "SELECT COUNT(*) FROM INV_MOVIMIENTOS WHERE MODC_TIPOMOV = 'SXMFTA' AND MOVD_FECHAAFECTACION >= TRUNC (TO_DATE ('$fecha_inicio', 'YYYY/MM/DD')) AND MOVD_FECHAAFECTACION<TRUNC(TO_DATE('$fecha_final','YYYY/MM/DD'))+1 AND MOVN_USUARIOREALIZAMOV = '$row[0]' AND ALMN_ALMACEN = '$sucursal'";
		$st2 = oci_parse($conexion_central, $cadena2);
		oci_execute($st2);
		$row2 = oci_fetch_row($st2);

		$cadena3 = "SELECT COUNT(*) FROM INV_MOVIMIENTOS WHERE MODC_TIPOMOV = 'SXMPAN' AND MOVD_FECHAAFECTACION >= TRUNC (TO_DATE ('$fecha_inicio', 'YYYY/MM/DD')) AND MOVD_FECHAAFECTACION<TRUNC(TO_DATE('$fecha_final','YYYY/MM/DD'))+1 AND MOVN_USUARIOREALIZAMOV = '$row[0]' AND ALMN_ALMACEN = '$sucursal'";
		$st3 = oci_parse($conexion_central, $cadena3);
		oci_execute($st3);
		$row3 = oci_fetch_row($st3);

		$cadena4 = "SELECT COUNT(*) FROM INV_MOVIMIENTOS WHERE MODC_TIPOMOV = 'SXMTOR' AND MOVD_FECHAAFECTACION >= TRUNC (TO_DATE ('$fecha_inicio', 'YYYY/MM/DD')) AND MOVD_FECHAAFECTACION<TRUNC(TO_DATE('$fecha_final','YYYY/MM/DD'))+1 AND MOVN_USUARIOREALIZAMOV = '$row[0]' AND ALMN_ALMACEN = '$sucursal'";
		$st4 = oci_parse($conexion_central, $cadena4);
		oci_execute($st4);
		$row4 = oci_fetch_row($st4);

		$cadena5 = "SELECT COUNT(*) FROM INV_MOVIMIENTOS WHERE MODC_TIPOMOV = 'SXMBOD' AND MOVD_FECHAAFECTACION >= TRUNC (TO_DATE ('$fecha_inicio', 'YYYY/MM/DD')) AND MOVD_FECHAAFECTACION<TRUNC(TO_DATE('$fecha_final','YYYY/MM/DD'))+1 AND MOVN_USUARIOREALIZAMOV = '$row[0]' AND ALMN_ALMACEN = '$sucursal'";
		$st5 = oci_parse($conexion_central, $cadena5);
		oci_execute($st5);
		$row5 = oci_fetch_row($st5);

		$cadena6 = "SELECT COUNT(*) FROM INV_MOVIMIENTOS WHERE MODC_TIPOMOV = 'SXMEDO' AND MOVD_FECHAAFECTACION >= TRUNC (TO_DATE ('$fecha_inicio', 'YYYY/MM/DD')) AND MOVD_FECHAAFECTACION<TRUNC(TO_DATE('$fecha_final','YYYY/MM/DD'))+1 AND MOVN_USUARIOREALIZAMOV = '$row[0]' AND ALMN_ALMACEN = '$sucursal'";
		$st6 = oci_parse($conexion_central, $cadena6);
		oci_execute($st6);
		$row6 = oci_fetch_row($st6);

		$cadena7 = "SELECT COUNT(*) FROM INV_MOVIMIENTOS WHERE MODC_TIPOMOV = 'SXROB' AND MOVD_FECHAAFECTACION >= TRUNC (TO_DATE ('$fecha_inicio', 'YYYY/MM/DD')) AND MOVD_FECHAAFECTACION<TRUNC(TO_DATE('$fecha_final','YYYY/MM/DD'))+1 AND MOVN_USUARIOREALIZAMOV = '$row[0]' AND ALMN_ALMACEN = '$sucursal'";
		$st7 = oci_parse($conexion_central, $cadena7);
		oci_execute($st7);
		$row7 = oci_fetch_row($st7);

		$cadena8 = "SELECT COUNT(*) FROM INV_MOVIMIENTOS WHERE MODC_TIPOMOV = 'SXMFCI' AND MOVD_FECHAAFECTACION >= TRUNC (TO_DATE ('$fecha_inicio', 'YYYY/MM/DD')) AND MOVD_FECHAAFECTACION<TRUNC(TO_DATE('$fecha_final','YYYY/MM/DD'))+1 AND MOVN_USUARIOREALIZAMOV = '$row[0]' AND ALMN_ALMACEN = '$sucursal'";
		$st8 = oci_parse($conexion_central, $cadena8);
		oci_execute($st8);
		$row8 = oci_fetch_row($st8);

		$cadena9 = "SELECT COUNT(*) FROM INV_MOVIMIENTOS WHERE MODC_TIPOMOV = 'SFAACC' AND MOVD_FECHAAFECTACION >= TRUNC (TO_DATE ('$fecha_inicio', 'YYYY/MM/DD')) AND MOVD_FECHAAFECTACION<TRUNC(TO_DATE('$fecha_final','YYYY/MM/DD'))+1 AND MOVN_USUARIOREALIZAMOV = '$row[0]' AND ALMN_ALMACEN = '$sucursal'";
		$st9 = oci_parse($conexion_central, $cadena9);
		oci_execute($st9);
		$row9 = oci_fetch_row($st9);

		$cadena10 = "SELECT COUNT(*) FROM INV_MOVIMIENTOS WHERE MODC_TIPOMOV = 'SFCBOT' AND MOVD_FECHAAFECTACION >= TRUNC (TO_DATE ('$fecha_inicio', 'YYYY/MM/DD')) AND MOVD_FECHAAFECTACION<TRUNC(TO_DATE('$fecha_final','YYYY/MM/DD'))+1 AND MOVN_USUARIOREALIZAMOV = '$row[0]' AND ALMN_ALMACEN = '$sucursal'";
		$st10 = oci_parse($conexion_central, $cadena10);
		oci_execute($st10);
		$row10 = oci_fetch_row($st10);

		$cadena11 = "SELECT COUNT(*) FROM INV_MOVIMIENTOS WHERE MODC_TIPOMOV = 'EXVIGI' AND MOVD_FECHAAFECTACION >= TRUNC (TO_DATE ('$fecha_inicio', 'YYYY/MM/DD')) AND MOVD_FECHAAFECTACION<TRUNC(TO_DATE('$fecha_final','YYYY/MM/DD'))+1 AND MOVN_USUARIOREALIZAMOV = '$row[0]' AND ALMN_ALMACEN = '$sucursal'";
		$st11 = oci_parse($conexion_central, $cadena11);
		oci_execute($st11);
		$row11 = oci_fetch_row($st11);

		$cadena12 = "SELECT COUNT(*) FROM INV_MOVIMIENTOS WHERE MODC_TIPOMOV = 'ECHORI' AND MOVD_FECHAAFECTACION >= TRUNC (TO_DATE ('$fecha_inicio', 'YYYY/MM/DD')) AND MOVD_FECHAAFECTACION<TRUNC(TO_DATE('$fecha_final','YYYY/MM/DD'))+1 AND MOVN_USUARIOREALIZAMOV = '$row[0]' AND ALMN_ALMACEN = '$sucursal'";
		$st12 = oci_parse($conexion_central, $cadena12);
		oci_execute($st12);
		$row12 = oci_fetch_row($st12);

		$cadena13 = "SELECT COUNT(*) FROM INV_MOVIMIENTOS WHERE MODC_TIPOMOV = 'SCHORI' AND MOVD_FECHAAFECTACION >= TRUNC (TO_DATE ('$fecha_inicio', 'YYYY/MM/DD')) AND MOVD_FECHAAFECTACION<TRUNC(TO_DATE('$fecha_final','YYYY/MM/DD'))+1 AND MOVN_USUARIOREALIZAMOV = '$row[0]' AND ALMN_ALMACEN = '$sucursal'";
		$st13 = oci_parse($conexion_central, $cadena13);
		oci_execute($st13);
		$row13 = oci_fetch_row($st13);

		$cadena14 = "SELECT COUNT(*) FROM INV_MOVIMIENTOS WHERE MODC_TIPOMOV = 'TRADEP' AND MOVD_FECHAAFECTACION >= TRUNC (TO_DATE ('$fecha_inicio', 'YYYY/MM/DD')) AND MOVD_FECHAAFECTACION<TRUNC(TO_DATE('$fecha_final','YYYY/MM/DD'))+1 AND MOVN_USUARIOREALIZAMOV = '$row[0]' AND ALMN_ALMACEN = '$sucursal'";
		$st14 = oci_parse($conexion_central, $cadena14);
		oci_execute($st14);
		$row14 = oci_fetch_row($st14);

		$cadena15 = "SELECT COUNT(*) FROM INV_MOVIMIENTOS WHERE MODC_TIPOMOV = 'EXCONV' AND MOVD_FECHAAFECTACION >= TRUNC (TO_DATE ('$fecha_inicio', 'YYYY/MM/DD')) AND MOVD_FECHAAFECTACION<TRUNC(TO_DATE('$fecha_final','YYYY/MM/DD'))+1 AND MOVN_USUARIOREALIZAMOV = '$row[0]' AND ALMN_ALMACEN = '$sucursal'";

		$st15 = oci_parse($conexion_central, $cadena15);
		oci_execute($st15);
		$row15 = oci_fetch_row($st15);

		$cadena16 = "SELECT COUNT(*) FROM INV_MOVIMIENTOS WHERE MODC_TIPOMOV = 'EXCOMP' AND MOVD_FECHAAFECTACION >= TRUNC (TO_DATE ('$fecha_inicio', 'YYYY/MM/DD')) AND MOVD_FECHAAFECTACION<TRUNC(TO_DATE('$fecha_final','YYYY/MM/DD'))+1 AND MOVN_USUARIOREALIZAMOV = '$row[0]' AND ALMN_ALMACEN = '$sucursal'";

		$st16 = oci_parse($conexion_central, $cadena16);
		oci_execute($st16);
		$row16 = oci_fetch_row($st16);

		$cadena17 = "SELECT COUNT(*) FROM INV_MOVIMIENTOS WHERE MODC_TIPOMOV = 'SXMVAR' AND MOVD_FECHAAFECTACION >= TRUNC (TO_DATE ('$fecha_inicio', 'YYYY/MM/DD')) AND MOVD_FECHAAFECTACION<TRUNC(TO_DATE('$fecha_final','YYYY/MM/DD'))+1 AND MOVN_USUARIOREALIZAMOV = '$row[0]' AND ALMN_ALMACEN = '$sucursal'";

		$st17 = oci_parse($conexion_central, $cadena17);
		oci_execute($st17);
		$row17 = oci_fetch_row($st17);

		$cadena18 = "SELECT COUNT(*) FROM INV_MOVIMIENTOS WHERE MODC_TIPOMOV = 'SXCONV' AND MOVD_FECHAAFECTACION >= TRUNC (TO_DATE ('$fecha_inicio', 'YYYY/MM/DD')) AND MOVD_FECHAAFECTACION<TRUNC(TO_DATE('$fecha_final','YYYY/MM/DD'))+1 AND MOVN_USUARIOREALIZAMOV = '$row[0]' AND ALMN_ALMACEN = '$sucursal'";

		$st18 = oci_parse($conexion_central, $cadena18);
		oci_execute($st18);
		$row18 = oci_fetch_row($st18);

		$total = $row1[0] + $row2[0] + $row3[0] + $row4[0] + $row5[0] + $row6[0] + $row7[0] + $row8[0] + $row9[0] + $row10[0] + $row11[0] + $row12[0] + $row13[0] + $row14[0] + $row15[0] + $row16[0] + $row17[0] + $row18[0];

    	$renglon = "
		{
		\"#\": \"$numero\",
		\"Usuario\":\"$row[1]\",
		\"SXMCAR\": \"$row1[0]\",
		\"SXMFTA\": \"$row2[0]\",
		\"SXMPAN\": \"$row3[0]\",
		\"SXMTOR\": \"$row4[0]\",
		\"SXMBOD\": \"$row5[0]\",
		\"SXMEDO\": \"$row6[0]\",
		\"SXROB\": \"$row7[0]\",
		\"SXMFCI\": \"$row8[0]\",
		\"SFAACC\": \"$row9[0]\",
		\"SFCBOT\": \"$row10[0]\",
		\"EXVIGI\": \"$row11[0]\",
		\"ECHORI\": \"$row12[0]\",
		\"SCHORI\": \"$row13[0]\",
		\"TRADEP\": \"$row14[0]\",
		\"EXCONV\": \"$row15[0]\",
		\"EXCOMP\": \"$row16[0]\",
		\"SXMVAR\": \"$row17[0]\",
		\"SXCONV\": \"$row18[0]\",
		\"Total\":  \"$total\"
		},";
		if($total == 0){

		}else{
			$cuerpo = $cuerpo.$renglon;
			$numero ++;
		}
		$total = 0;
	}
	$cuerpo2 = trim($cuerpo, ',');

	$tabla = "
	["
	.$cuerpo2.
	"]
	";
	echo $tabla;
?>