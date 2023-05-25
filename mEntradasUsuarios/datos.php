<?php
	include '../global_seguridad/verificar_sesion.php';
	include "../global_settings/conexion_oracle.php";

    $fecha_completa1 = $_POST['fecha1'];
    $fecha_completa2 = $_POST['fecha2'];
    $sucursal        = $_POST['sucursal'];


    $fecha1 = substr($fecha_completa1, 0,10);
    $fecha2 = substr($fecha_completa1, 12,11);

    if($fecha_completa2 == $fecha.' - '.$fecha || empty($_POST['fecha2'])){
        $fecha1_mes = date("Y-m-d",strtotime($fecha1."- 1 month")); //a un mes
        $fecha2_mes = date("Y-m-d",strtotime($fecha2."- 1 month")); //a un mes
    }else{
        $fecha1_mes = substr($fecha_completa2, 0,10);
        $fecha2_mes = substr($fecha_completa2, 12,11);
    }

	$cantidad        = 0;
	$cantidad_sfaacc = 0;
	$cantidad_sxmcar = 0;
	$cantidad_sxmfta = 0;
	$cantidad_sxmpan = 0;
	$cantidad_sxmtor = 0;
	$cantidad_sxmbod = 0;
	$cantidad_sxmedo = 0;
	$cantidad_sxrob  = 0;
	$cantidad_sxmfci = 0;
	$cantidad_sfaacc = 0;
	$cantidad_sfcbot = 0;
	$cantidad_exvigi = 0;
	$cantidad_echori = 0;
	$cantidad_schori = 0;
	$cantidad_tradep = 0;
	$cantidad_exconv = 0;

	$cantidad2        = 0;
	$cantidad_sfaacc2 = 0;
	$cantidad_sxmcar2 = 0;
	$cantidad_sxmfta2 = 0;
	$cantidad_sxmpan2 = 0;
	$cantidad_sxmtor2 = 0;
	$cantidad_sxmbod2 = 0;
	$cantidad_sxmedo2 = 0;
	$cantidad_sxrob2  = 0;
	$cantidad_sxmfci2 = 0;
	$cantidad_sfaacc2 = 0;
	$cantidad_sfcbot2 = 0;
	$cantidad_exvigi2 = 0;
	$cantidad_echori2 = 0;
	$cantidad_schori2 = 0;
	$cantidad_tradep2 = 0;
	$cantidad_exconv2 = 0;

	///////////////////////////////////// Auditoria Entradas /////////////////////
	$cadena_afectados = "SELECT COUNT(*) FROM INV_MOVIMIENTOS
							WHERE (modc_tipomov = 'ENTSOC' OR modc_tipomov = 'ENTCOC')
							AND movd_fechaafectacion >= trunc(TO_DATE ('$fecha1', 'YYYY/MM/DD'))
							AND movd_fechaafectacion < trunc(TO_DATE ('$fecha2', 'YYYY/MM/DD'))+1
							AND ALMN_ALMACEN = '$sucursal'
							ORDER BY modn_folio ASC";

	$consulta_afectados = oci_parse($conexion_central, $cadena_afectados);
						  oci_execute($consulta_afectados);
	$row_afectados = oci_fetch_row($consulta_afectados);
	$afectados_do = $row_afectados[0];

	$cadena_afectados = "SELECT COUNT(*) FROM INV_MOVIMIENTOS
							WHERE (modc_tipomov = 'ENTSOC' OR modc_tipomov = 'ENTCOC')
							AND movd_fechaafectacion >= trunc(TO_DATE ('$fecha1_mes', 'YYYY/MM/DD'))
							AND movd_fechaafectacion < trunc(TO_DATE ('$fecha2_mes', 'YYYY/MM/DD'))+1
							AND ALMN_ALMACEN = '$sucursal'
							ORDER BY modn_folio ASC";

	$consulta_afectados = oci_parse($conexion_central, $cadena_afectados);
						  oci_execute($consulta_afectados);
	$row_afectados = oci_fetch_row($consulta_afectados);
	$afectados_do2 = $row_afectados[0];

    if($afectados_do == $afectados_do2){
        $texto_afectado = "igual";
        $porcentaje_afectados = '0 %';
    }else{
        if($afectados_do2 != 0){
            $diferencia_afectados = ($afectados_do * 100) /$afectados_do2;
            $diferencia_afectados = round($diferencia_afectados,2); //Porentaje de diferencia
            if($diferencia_afectados < 100){
                $texto_afectado = "mayor";
                $porcentaje_afectados = (100 - $diferencia_afectados).' %';
            }else{
                $texto_afectado = "menor";
                $porcentaje_afectados = ($diferencia_afectados - 100).' %';
            }
        }else{
            $diferencia_afectados = 0;
            $texto_afectado = "mayor2";
            $porcentaje_afectados = (100 - $diferencia_afectados).' %';
        }
    }  

	///////////////////////////////////// Auditoria Movimientos /////////////////////
	$cadena  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
    FROM INV_MOVIMIENTOS
    WHERE (MODC_TIPOMOV = 'SXMCAR' OR MODC_TIPOMOV = 'SXMFTA' OR MODC_TIPOMOV = 'SXMPAN' OR MODC_TIPOMOV = 'SXMTOR' OR MODC_TIPOMOV = 'SXMBOD' OR MODC_TIPOMOV = 'SXMEDO' OR MODC_TIPOMOV = 'SXROB' OR MODC_TIPOMOV = 'SXMFCI' OR MODC_TIPOMOV = 'SFAACC' OR MODC_TIPOMOV = 'SFCBOT' OR MODC_TIPOMOV = 'EXVIGI' OR MODC_TIPOMOV = 'ECHORI' OR MODC_TIPOMOV = 'SCHORI' OR MODC_TIPOMOV = 'TRADEP' OR MODC_TIPOMOV = 'EXCONV')
    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha1','YYYY-MM-DD'))
    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha2', 'YYYY-MM-DD'))
    AND ALMN_ALMACEN = '$sucursal'";
				
    $consulta = oci_parse($conexion_central, $cadena);
    oci_execute($consulta);
    while($row = oci_fetch_array($consulta)){
        $cantidad = oci_num_rows($consulta);
	}

	$cadena  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
    FROM INV_MOVIMIENTOS
    WHERE (MODC_TIPOMOV = 'SXMCAR' OR MODC_TIPOMOV = 'SXMFTA' OR MODC_TIPOMOV = 'SXMPAN' OR MODC_TIPOMOV = 'SXMTOR' OR MODC_TIPOMOV = 'SXMBOD' OR MODC_TIPOMOV = 'SXMEDO' OR MODC_TIPOMOV = 'SXROB' OR MODC_TIPOMOV = 'SXMFCI' OR MODC_TIPOMOV = 'SFAACC' OR MODC_TIPOMOV = 'SFCBOT' OR MODC_TIPOMOV = 'EXVIGI' OR MODC_TIPOMOV = 'ECHORI' OR MODC_TIPOMOV = 'SCHORI' OR MODC_TIPOMOV = 'TRADEP' OR MODC_TIPOMOV = 'EXCONV')
    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha1_mes','YYYY-MM-DD'))
    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha2_mes', 'YYYY-MM-DD'))
    AND ALMN_ALMACEN = '$sucursal'";
                
    $consulta = oci_parse($conexion_central, $cadena);
    oci_execute($consulta);
    while($row = oci_fetch_array($consulta)){
        $cantidad2 = oci_num_rows($consulta);
    }

    if($cantidad == $cantidad2){
        $texto_cantidad = "igual";
        $porcentaje_cantidad = '0 %';
    }else{
        if($cantidad2 != 0){
            $diferencia_cantidad = ($cantidad * 100) /$cantidad2;
            $diferencia_cantidad = round($diferencia_cantidad,1); //Porentaje de diferencia
            if($diferencia_cantidad < 100){
                $texto_cantidad = "menor";
                $porcentaje_cantidad = (100 - $diferencia_cantidad).' %';
            }else{
                $texto_cantidad = "mayor";
                $porcentaje_cantidad = ($diferencia_cantidad - 100).' %';
            }
        }else{
            $diferencia_cantidad = 0;
            $texto_cantidad = "mayor";
            $porcentaje_cantidad = (100 - $diferencia_cantidad).' %';
        }
    }

	////////////////////////////Devoluciones/////////////////////////////

	$cadena     = mysqli_query($conexion,"SELECT id FROM devoluciones WHERE status = '1' AND id_sucursal = '$sucursal' AND fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)");
	$cantidad_d = mysqli_num_rows($cadena);

	$cadena     = mysqli_query($conexion,"SELECT id FROM devoluciones WHERE status = '1' AND id_sucursal = '$sucursal' AND fecha BETWEEN CAST('$fecha1_mes' AS DATE) AND CAST('$fecha2_mes' AS DATE)");
	$cantidad_d2 = mysqli_num_rows($cadena);

    if($cantidad_d == $cantidad_d2){
        $texto_devoluciones = "igual";
        $porcentaje_devoluciones = '0 %';

    }else{
        if($cantidad_d2 != 0){
            $diferencia_devoluciones = ($cantidad_d * 100) /$cantidad_d2;
            $diferencia_devoluciones = round($diferencia_devoluciones,2); //Porentaje de diferencia
            if($diferencia_devoluciones < 100){
                $texto_devoluciones = "menor";
                $porcentaje_devoluciones = (100 - $diferencia_devoluciones).' %';
            }else{
                $texto_devoluciones = "mayor";
                $porcentaje_devoluciones = ($diferencia_devoluciones - 100).' %';
            }
        }else{
            $diferencia_devoluciones = 0;
            $texto_devoluciones = "mayor";
            $porcentaje_devoluciones = (100 - $diferencia_devoluciones).' %';
        }
    }

	/////////////Cartas Faltantes //////////////////////////////
	$cadena = mysqli_query($conexion,"SELECT id FROM carta_faltante WHERE
	activo = '2' AND fecha_afectacion BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) AND id_sucursal = '$sucursal'");
	$cantidad_c = mysqli_num_rows($cadena);

	$cadena = mysqli_query($conexion,"SELECT id FROM carta_faltante WHERE
	activo = '2' AND fecha_afectacion BETWEEN CAST('$fecha1_mes' AS DATE) AND CAST('$fecha2_mes' AS DATE) AND id_sucursal = '$sucursal'");
	$cantidad_c2 = mysqli_num_rows($cadena);

    if($cantidad_c == $cantidad_c2){
        $texto_cf = "igual";
        $porcentaje_cf = '0 %';
    }else{
        if($cantidad_c2 != 0){
            $diferencia_cf = ($cantidad_c * 100) /$cantidad_c2;
            $diferencia_cf = round($diferencia_cf,2); //Porentaje de diferencia
            if($diferencia_cf < 100){
                $texto_cf = "menor";
                $porcentaje_cf = (100 - $diferencia_cf).' %';
            }else{
                $texto_cf = "mayor";
                $porcentaje_cf = ($diferencia_cf - 100).' %';
            }
        }else{
            $diferencia_cf = 0;
            $texto_cf = "mayor";
            $porcentaje_cf = (100 - $diferencia_cf).' %';
        }
    }

	////////////////// Errores /////////////////////////
	$cadena = mysqli_query($conexion,"SELECT id FROM me_control_errores WHERE
	activo = '1' AND fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) AND id_sucursal = '$sucursal'");
	$cantidad_e = mysqli_num_rows($cadena);

	$cadena = mysqli_query($conexion,"SELECT id FROM me_control_errores WHERE
	activo = '1' AND fecha BETWEEN CAST('$fecha1_mes' AS DATE) AND CAST('$fecha2_mes' AS DATE) AND id_sucursal = '$sucursal'");
	$cantidad_e2 = mysqli_num_rows($cadena);

    if($cantidad_e == $cantidad_e2){
        $texto_e = "igual";
        $porcentaje_e = '0 %';
    }else{
        if($cantidad_e2 != 0){
            $diferencia_e = ($cantidad_e * 100) /$cantidad_e2;
            $diferencia_e = round($diferencia_e,2); //Porentaje de diferencia
            if($diferencia_e < 100){
                $texto_e = "menor";
                $porcentaje_e = (100 - $diferencia_e).' %';
            }else{
                $texto_e = "mayor";
                $porcentaje_e = ($diferencia_e - 100).' %';
            }
        }else{
            $diferencia_e = 0;
            $texto_e = "mayor";
            $porcentaje_e = (100 - $diferencia_e).' %';
        }
    }

	///////////////// Control Tiempo (Extra) ///
	$cadena = mysqli_query($conexion,"SELECT COUNT(*) FROM alb_resumenEntradas where ficha_entrada like '$sucursal%' and (fecha between '$fecha1' and '$fecha2')");
	$rowte = mysqli_fetch_array($cadena);
	$tiempo_ex = $rowte[0];

	///////////////// Control Tiempo (Permiso) ////////////////////
	$cadena = mysqli_query($conexion,"SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(me_control_tiempos.diferencia)))
										FROM me_control_tiempos
										INNER JOIN personas ON personas.id = me_control_tiempos.id_persona
										WHERE me_control_tiempos.tipo = '2' AND personas.id_sede = '$sucursal' 
										AND me_control_tiempos.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)");
	$rowtp = mysqli_fetch_array($cadena);
	$tiempo_pe = ($rowtp[0] == "")?"00:00":$rowtp[0];

	///////////////// Etiquetas (Impresas) ////////////////////
	$cadena = mysqli_query($conexion,"SELECT id FROM solicitud_etiquetas WHERE estatus = '2' AND activo = '1' AND sucursal = '$sucursal' AND fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) ");
	$e_impresas = mysqli_num_rows($cadena);

	$cadena = mysqli_query($conexion,"SELECT id FROM solicitud_etiquetas WHERE estatus = '2' AND activo = '1' AND sucursal = '$sucursal' AND fecha BETWEEN CAST('$fecha1_mes' AS DATE) AND CAST('$fecha2_mes' AS DATE) ");
	$e_impresas2 = mysqli_num_rows($cadena);

    if($e_impresas == $e_impresas2){
        $texto_impresas = "igual";
        $porcentaje_impresas = '0 %';
    }else{
        if($e_impresas2 != 0){
            $diferencia_impresas = ($e_impresas * 100) /$e_impresas2;
            $diferencia_impresas = round($diferencia_impresas,2); //Porentaje de diferencia

            if($diferencia_impresas < 100){
                $texto_impresas = "menor";
                $porcentaje_impresas = (100 - $diferencia_impresas).' %';
            }else{
                $texto_impresas = "mayor";
                $porcentaje_impresas = ($diferencia_impresas - 100).' %';
            }
        }else{
            $diferencia_impresas = 0;
            $texto_impresas = "mayor";
            $porcentaje_impresas = (100 - $diferencia_impresas).' %';
        }
    }

	///////////////// Solicitud (Materiales) ////////////////////
	$cadena = mysqli_query($conexion,"SELECT .pedido_materiales.id 
                            FROM pedido_materiales
                            INNER JOIN usuarios ON usuarios.id = pedido_materiales.id_usuario
                            INNER JOIN personas ON personas.id = usuarios.id_persona 
                            AND pedido_materiales.activo = '1'
                            AND personas.id_sede = '$sucursal' 
                            AND pedido_materiales.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)");
	$p_materiales = mysqli_num_rows($cadena);

	$cadena = mysqli_query($conexion,"SELECT .pedido_materiales.id 
                            FROM pedido_materiales
                            INNER JOIN usuarios ON usuarios.id = pedido_materiales.id_usuario
                            INNER JOIN personas ON personas.id = usuarios.id_persona 
                            AND pedido_materiales.activo = '1'
                            AND personas.id_sede = '$sucursal' 
                            AND pedido_materiales.fecha BETWEEN CAST('$fecha1_mes' AS DATE) AND CAST('$fecha2_mes' AS DATE)");
	$p_materiales2 = mysqli_num_rows($cadena);

    if($p_materiales == $p_materiales2){
        $texto_materiales = "igual";
        $porcentaje_materiales = '0 %';
    }else{
        if($p_materiales2 != 0){
            $diferencia_materiales = ($p_materiales * 100) /$p_materiales2;
            $diferencia_materiales = round($diferencia_materiales,2); //Porentaje de diferencia
            if($diferencia_materiales < 100){
                $texto_materiales = "menor";
                $porcentaje_materiales = (100 - $diferencia_materiales).' %';
            }else{
                $texto_materiales = "mayor";
                $porcentaje_materiales = ($diferencia_materiales - 100).' %';
            }
        }else{
            $diferencia_materiales = 0;
            $texto_materiales = "mayor";
            $porcentaje_materiales = (100 - $diferencia_materiales).' %';
        }
    }

	///////////////// Altas ////////////////////
	$cadena = mysqli_query($conexion,"SELECT id FROM altas_productos WHERE activo = '1' AND id_sucursal = '$sucursal' AND fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) GROUP BY folio ");
	$altas = mysqli_num_rows($cadena);

	$cadena = mysqli_query($conexion,"SELECT id FROM altas_productos WHERE activo = '1' AND id_sucursal = '$sucursal' AND fecha BETWEEN CAST('$fecha1_mes' AS DATE) AND CAST('$fecha2_mes' AS DATE) GROUP BY folio ");
	$altas2 = mysqli_num_rows($cadena);

    if($altas == $altas2){
        $texto_altas = "igual";
        $porcentaje_altas = '0 %';
    }else{
        if($altas2 != 0){
            $diferencia_altas = ($altas * 100) /$altas2;
            $diferencia_altas = round($diferencia_altas,2); //Porentaje de diferencia

            if($diferencia_altas < 100){
                $texto_altas = "menor";
                $porcentaje_altas = (100 - $diferencia_altas).' %';
            }else{
                $texto_altas = "mayor";
                $porcentaje_altas = ($diferencia_altas - 100).' %';
            }

        }else{
            $diferencia_altas = 0;
            $texto_altas = "mayor";
            $porcentaje_altas = (100 - $diferencia_altas).' %';
        }
    }

	///////////////// Cambios ////////////////////
	$cadena = mysqli_query($conexion,"SELECT id FROM bitacora_cambios WHERE fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) AND tipo = 'C' AND liberado = '1' AND sucursal = '$sucursal'");
	$cambios = mysqli_num_rows($cadena);

	$cadena = mysqli_query($conexion,"SELECT id FROM bitacora_cambios WHERE fecha BETWEEN CAST('$fecha1_mes' AS DATE) AND CAST('$fecha2_mes' AS DATE) AND tipo = 'C' AND liberado = '1' AND sucursal = '$sucursal'");
	$cambios2 = mysqli_num_rows($cadena);

    if($cambios == $cambios2){
        $texto_cambios = "igual";
        $porcentaje_cambios = '0 %';
    }else{
        if($cambios2 != 0){
            $diferencia_cambios = ($cambios * 100) /$cambios2;
            $diferencia_cambios = round($diferencia_cambios,2); //Porentaje de diferencia

            if($diferencia_cambios < 100){
                $texto_cambios = "menor";
                $porcentaje_cambios = (100 - $diferencia_cambios).' %';
            }else{
                $texto_cambios = "mayor";
                $porcentaje_cambios = ($diferencia_cambios - 100).' %';
            }

        }else{
            $diferencia_cambios = 0;
            $texto_cambios = "mayor";
            $porcentaje_cambios = (100 - $diferencia_cambios).' %';
        }
    }

	///////////////// Ofertas ////////////////////
	$cadena = mysqli_query($conexion,"SELECT id FROM bitacora_cambios WHERE fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) AND tipo = 'O' AND liberado = '1' AND sucursal = '$sucursal'");
	$ofertas = mysqli_num_rows($cadena);

	$cadena = mysqli_query($conexion,"SELECT id FROM bitacora_cambios WHERE fecha BETWEEN CAST('$fecha1_mes' AS DATE) AND CAST('$fecha2_mes' AS DATE) AND tipo = 'O' AND liberado = '1' AND sucursal = '$sucursal'");
	$ofertas2 = mysqli_num_rows($cadena);

    if($ofertas == $ofertas2){
        $texto_ofertas = "igual";
        $porcentaje_ofertas = '0 %';
    }else{
        if($ofertas2 != 0){
            $diferencia_ofertas = ($ofertas * 100) /$ofertas2;
            $diferencia_ofertas = round($diferencia_ofertas,2); //Porentaje de diferencia

            if($diferencia_ofertas < 100){
                $texto_ofertas = "menor";
                $porcentaje_ofertas = (100 - $diferencia_ofertas).' %';
            }else{
                $texto_ofertas = "mayor";
                $porcentaje_ofertas = ($diferencia_ofertas - 100).' %';
            }

        }else{
            $diferencia_ofertas = 0;
            $texto_ofertas = "mayor";
            $porcentaje_ofertas = (100 - $diferencia_ofertas).' %';
        }
    }

	///////////////// Notas Entrada ////////////////////
	$cadena = mysqli_query($conexion,"SELECT id FROM notas_entrada WHERE fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) AND id_sucursal = '$sucursal'");
	$notas = mysqli_num_rows($cadena);

	$cadena = mysqli_query($conexion,"SELECT id FROM notas_entrada WHERE fecha BETWEEN CAST('$fecha1_mes' AS DATE) AND CAST('$fecha2_mes' AS DATE) AND id_sucursal = '$sucursal'");
	$notas2 = mysqli_num_rows($cadena);

    if($notas == $notas2){
        $texto_notas = "igual";
        $porcentaje_notas = '0 %';
    }else{
        if($notas2 != 0){
            $diferencia_notas = ($notas * 100) /$notas2;
            $diferencia_notas = round($diferencia_notas,2); //Porentaje de diferencia

            if($diferencia_notas < 100){
                $texto_notas = "menor";
                $porcentaje_notas = (100 - $diferencia_notas).' %';
            }else{
                $texto_notas = "mayor";
                $porcentaje_notas = ($diferencia_notas - 100).' %';
            }

        }else{
            $diferencia_notas = 0;
            $texto_notas = "mayor";
            $porcentaje_notas = (100 - $diferencia_notas).' %';
        }
    }

	///////////////////////////////////// Devolcion p correccion /////////////////////
	$cadena_devoluciones = "SELECT COUNT(*) FROM INV_MOVIMIENTOS
							WHERE modc_tipomov = 'DEVXCO'
							AND movd_fechaafectacion >= trunc(TO_DATE ('$fecha1', 'YYYY/MM/DD'))
							AND movd_fechaafectacion < trunc(TO_DATE ('$fecha2', 'YYYY/MM/DD'))+1
							AND ALMN_ALMACEN = '$sucursal'";

	$consulta_devoluciones = oci_parse($conexion_central, $cadena_devoluciones);
						  oci_execute($consulta_devoluciones);
	$row_devoluciones = oci_fetch_row($consulta_devoluciones);
	$dev = $row_devoluciones[0];

	$cadena_devoluciones = "SELECT COUNT(*) FROM INV_MOVIMIENTOS
							WHERE modc_tipomov = 'DEVXCO'
							AND movd_fechaafectacion >= trunc(TO_DATE ('$fecha1_mes', 'YYYY/MM/DD'))
							AND movd_fechaafectacion < trunc(TO_DATE ('$fecha2_mes', 'YYYY/MM/DD'))+1
							AND ALMN_ALMACEN = '$sucursal'";

	$consulta_devoluciones = oci_parse($conexion_central, $cadena_devoluciones);
						  oci_execute($consulta_devoluciones);
	$row_devoluciones = oci_fetch_row($consulta_devoluciones);
	$dev2 = $row_devoluciones[0];

    if($dev == $dev2){
        $texto_dev = "igual";
        $porcentaje_dev = '0 %';
    }else{
        if($dev2 != 0){
            // echo $dev.'-'.$dev2;
            $diferencia_dev = ($dev * 100) / $dev2;
            $diferencia_dev = round($diferencia_dev,2); //Porentaje de diferencia
            if($diferencia_dev < 100){
                $texto_dev = "menor";
                $porcentaje_dev = (100 - $diferencia_dev).' %';
            }else{
                $texto_dev = "mayor";
                $porcentaje_dev = ($diferencia_dev - 100).' %';
            }

        }else{
            $diferencia_dev = 0;
            $texto_dev = "mayor";
            $porcentaje_dev = (100 - $diferencia_dev).' %';
        }
    }
    ///////////////////////////////////// INF MOV ASOCIADOS /////////////////////
    $cadena_infmovaso = "SELECT COUNT(*)
                            FROM formatos_movimientos AS f
                            INNER JOIN sucursales AS s ON f.sucursal = s.id 
                            WHERE f.estatus = '1'
                            AND f.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)
                            AND sucursal = '$sucursal'";

    $consulta_infmovaso = mysqli_query($conexion,$cadena_infmovaso);
    $row_infmovaso      = mysqli_fetch_array($consulta_infmovaso);
    $infmovaso          = $row_infmovaso[0];

    $cadena_infmovaso = "SELECT COUNT(*)
                            FROM formatos_movimientos AS f
                            INNER JOIN sucursales AS s ON f.sucursal = s.id 
                            WHERE f.estatus = '1'
                            AND f.fecha BETWEEN CAST('$fecha1_mes' AS DATE) AND CAST('$fecha2_mes' AS DATE)
                            AND sucursal = '$sucursal'";

    $consulta_infmovaso = mysqli_query($conexion,$cadena_infmovaso);
    $row_infmovaso      = mysqli_fetch_array($consulta_infmovaso);
    $infmovaso2         = $row_infmovaso[0];

    if($infmovaso == $infmovaso2){
        $texto_infmovaso = "igual";
        $porcentaje_infmovaso = '0 %';
    }else{
        if($infmovaso2 != 0){
            $diferencia_infmovaso = ($infmovaso * 100) / $infmovaso2;
            $diferencia_infmovaso = round($diferencia_infmovaso,2); //Porentaje de diferencia

            if($diferencia_infmovaso < 100){
                $texto_infmovaso = "menor";
                $porcentaje_infmovaso = (100 - $diferencia_infmovaso).' %';
            }else{
                $texto_infmovaso = "mayor";
                $porcentaje_infmovaso = ($diferencia_infmovaso - 100).' %';
            }

        }else{
            $diferencia_infmovaso = 0;
            $texto_infmovaso = "mayor";
            $porcentaje_infmovaso = (100 - $diferencia_infmovaso).' %';
        }
    }

    ///////////////////////////////////// INF MOV CANCELADOS /////////////////////
    $cadena_infmovcan = "SELECT COUNT(*)
                            FROM formatos_movimientos AS f
                            INNER JOIN sucursales AS s ON f.sucursal = s.id 
                            WHERE f.estatus = '3'
                            AND f.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)
                            AND sucursal = '$sucursal'";

    $consulta_infmovcan = mysqli_query($conexion,$cadena_infmovcan);
    $row_infmovcan      = mysqli_fetch_array($consulta_infmovcan);
    $infmovcan          = $row_infmovcan[0];

    $cadena_infmovcan = "SELECT COUNT(*)
                            FROM formatos_movimientos AS f
                            INNER JOIN sucursales AS s ON f.sucursal = s.id 
                            WHERE f.estatus = '3'
                            AND f.fecha BETWEEN CAST('$fecha1_mes' AS DATE) AND CAST('$fecha2_mes' AS DATE)
                            AND sucursal = '$sucursal'";

    $consulta_infmovcan = mysqli_query($conexion,$cadena_infmovcan);
    $row_infmovcan      = mysqli_fetch_array($consulta_infmovcan);
    $infmovcan2         = $row_infmovcan[0];

    if($infmovcan == $infmovcan2){
        $texto_infmovcan = "igual";
        $porcentaje_infmovcan = '0 %';
    }else{
        if($infmovcan2 != 0){
            $diferencia_infmovcan = ($infmovcan * 100) / $infmovcan2;
            $diferencia_infmovcan = round($diferencia_infmovcan,2); //Porentaje de diferencia

            if($diferencia_infmovcan < 100){
                $texto_infmovcan = "menor";
                $porcentaje_infmovcan = (100 - $diferencia_infmovcan).' %';
            }else{
                $texto_infmovcan = "mayor";
                $porcentaje_infmovcan = ($diferencia_infmovcan - 100).' %';
            }
        }else{
            $diferencia_infmovcan = 0;
            $texto_infmovcan = "mayor";
            $porcentaje_infmovcan = (100 - $diferencia_infmovcan).' %';
        }
    }

	$array = array(
				$afectados_do.' <sub>('.$afectados_do2.')</sub>', //AuditoriaEntradas
				$porcentaje_afectados, //AuditoriaEntradas
				$texto_afectado, //AuditoriaEntradas
				$cantidad.' <sub>('.$cantidad2.')</sub>', //Cantidad
				$porcentaje_cantidad, //Cantidad
				$texto_cantidad, //Cantidad
				$cantidad_d.' <sub>('.$cantidad_d2.')</sub>', //Devoluciones
				$porcentaje_devoluciones, //Devoluciones
				$texto_devoluciones, //Devoluciones
				$cantidad_c.' <sub>('.$cantidad_c2.')</sub>', //CartasFal
				$porcentaje_cf, //CartasFal
				$texto_cf, //CartasFal
				$cantidad_e.' <sub>('.$cantidad_e2.')</sub>', //Errores
				$porcentaje_e, //Errores
				$texto_e, //Errores
				$tiempo_ex,
				$tiempo_pe,
				$e_impresas.' <sub>('.$e_impresas2.')</sub>', //Impresas
				$porcentaje_impresas, //Impresas
				$texto_impresas, //Impresas
				$p_materiales.' <sub>('.$p_materiales2.')</sub>', //Materiales
				$porcentaje_materiales, //Materiales
				$texto_materiales, //Materiales
				$altas.' <sub>('.$altas2.')</sub>', //Altas
				$porcentaje_altas, //Altas
				$texto_altas, //Altas
				$cambios.' <sub>('.$cambios2.')</sub>', //Cambios
				$porcentaje_cambios, //Cambios
				$texto_cambios, //Cambios
				$ofertas.' <sub>('.$ofertas2.')</sub>', //Ofertas
				$porcentaje_ofertas, //Ofertas
				$texto_ofertas, //Ofertas
				$notas.' <sub>('.$notas2.')</sub>', //Notas
				$porcentaje_notas, //Notas
				$texto_notas, //Notas
				$dev.' <sub>('.$dev2.')</sub>', //Dev
				$porcentaje_dev, //Dev
				$texto_dev, //Dev
                $infmovaso.' <sub>('.$infmovaso2.')</sub>', //INFMOVASO
                $porcentaje_infmovaso, //INFMOVASO
                $texto_infmovaso, //INFMOVASO
                $infmovcan.' <sub>('.$infmovcan2.')</sub>', //INFMOVASO
                $porcentaje_infmovcan, //INFMOVASO
                $texto_infmovcan //INFMOVASO
			);
	echo json_encode($array);
?>