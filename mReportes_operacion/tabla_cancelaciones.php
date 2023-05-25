<?php
		include '../global_seguridad/verificar_sesion.php';
		include '../global_settings/conexion_oracle.php';
		$datos=array();
		$sucursal = $_POST["sucursal"];
		$cajero = $_POST['cajero'];
		$fecha_inicial = $_POST['fecha_inicial'];
		$fecha_final = $_POST['fecha_final'];
		$fecha_i=str_replace("-","",$fecha_inicial);
		$fecha_f=str_replace("-","",$fecha_final);

		if(empty($cajero)){
			$cadena="";
		}else{
			$cadena="AND TICC_CAJERO = '$cajero'";
		}

		$sql = "SELECT
							TICN_AAAAMMDDVENTA,
							TICN_FOLIO,
							TO_CHAR( TICD_FECHAHORAVENTA, 'YYYY/MM/DD' ),
							ROUND( TICN_VENTA, 2 ),
							TICC_MOTIVOCANC,
							( SELECT CFG_USUARIOS.USUC_NOMBRE FROM CFG_USUARIOS WHERE CFG_USUARIOS.USUN_ID = PV_TICKETS.TICN_USUARIOAUTORIZADEV ),
							( SELECT CFG_USUARIOS.USUC_NOMBRE FROM CFG_USUARIOS WHERE CFG_USUARIOS.USUN_ID = PV_TICKETS.TICC_CAJERO )
						FROM
							PV_TICKETS
						WHERE
							TICC_SUCURSAL='$sucursal'
							AND TICN_ESTATUS = '4'
							".$cadena."
							AND TICN_AAAAMMDDVENTA BETWEEN '$fecha_i'
							AND '$fecha_f'";

		$st = oci_parse($conexion_central, $sql);
		oci_execute($st);
		while($row=oci_fetch_array($st)){
			array_push($datos,array(
				'ticn'=>$row[0],
				'ticn_folio'=>$row[1],
				'ticn_fecha'=>$row[2],
				'ticn_venta'=>$row[3],
				'ticn_motivo'=>$row[4],
				'autoriza'=>$row[5],
				'cajero'=>$row[6]
			));
		}
		echo utf8_encode(json_encode($datos));
 ?>