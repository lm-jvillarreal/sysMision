<?php
    include '../global_seguridad/verificar_sesion.php';

    $fecha1   = $_POST['fecha1'];
    $fecha2   = $_POST['fecha2'];
    $sucursal = $_POST['sucursal'];
    $apartado = $_POST['apartado'];
    
    $json           = [];
    $nombre         = "";
    $cantidad_cajas = 0;

    if(!empty($_POST['fecha1']) && !empty($_POST['fecha2'])){
        $filtro  = " AND fecha_creacion BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)";
        $filtro2 = " WHERE fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)";
    }else{
        $filtro  = "";
        $filtro2 = "";
    }
    if(!empty($_POST['sucursal'])){
        $filtro_suc = " AND id_sucursal = '$sucursal'";
    }else{
        $filtro_suc = "";
    }
    if(empty($_POST['apartado'])){
        $cadena = mysqli_query($conexion,"SELECT(
        SUM( efectivo ) + SUM( efectivo1 ) + SUM( efectivo2 ) + SUM( complemento ) + SUM( cheques_serfin ) + SUM( cheques_locales ) + SUM( tarjetas_credito )) AS Efectivos,(
        SUM( t_debito ) + SUM( t_prepago ) + SUM( t_accor ) + SUM( t_ecovale ) + SUM( t_efectivale ) + SUM( t_sivale ) + SUM( t_tiendapass ) + SUM( t_toka )) AS TarjetasDebito,(
        SUM( b_prest_mex ) + SUM( b_prest_uni ) + SUM( b_accor ) + SUM( b_efectivale ) + SUM( b_mision_esp ) + SUM( b_creditos ) + SUM( b_tengo_despensa ) + SUM( b_toka )) AS Bonos 
        FROM efectivos WHERE activo = '1'".$filtro.$filtro_suc);
        $row = mysqli_fetch_array($cadena);

        $cadena2 = mysqli_query($conexion,"SELECT SUM(abono) FROM abonos".$filtro2.$filtro_suc);
        $row2 = mysqli_fetch_array($cadena2);

        $cadena3 = mysqli_query($conexion,"SELECT SUM(cantidad) FROM otros WHERE activo = '1'".$filtro.$filtro_suc);
        $row3 = mysqli_fetch_array($cadena3);

        $json[] = [(string)"Efectivos",(double)$row[0]]; 
        $json[] = [(string)"Tarjetas Debito",(double)$row[1]];
        $json[] = [(string)"Bonos",(double)$row[2]];
        $json[] = [(string)"Abonos a Prestamos",(double)$row2[0]];
        $json[] = [(string)"Otros",(double)$row3[0]];
    }else{
        if($apartado == 1){
            $cadena = mysqli_query($conexion,"SELECT
            SUM(efectivo), SUM(efectivo1), SUM(efectivo2), SUM(complemento), SUM(cheques_serfin), SUM(cheques_locales), SUM(tarjetas_credito) 
            FROM efectivos WHERE activo = '1'".$filtro.$filtro_suc);
            $row = mysqli_fetch_array($cadena);
            $json[] = [(string)"Efectivo",(double)$row[0]]; 
            $json[] = [(string)"Efectivo1",(double)$row[1]]; 
            $json[] = [(string)"Efectivo2",(double)$row[2]]; 
            $json[] = [(string)"Complemento",(double)$row[3]]; 
            $json[] = [(string)"Cheques Serfin",(double)$row[4]]; 
            $json[] = [(string)"Cheques Locales",(double)$row[5]];
            $json[] = [(string)"Tarjetas Credito",(double)$row[6]]; 

        }else if($apartado == 2){
            $cadena = mysqli_query($conexion,"SELECT SUM(t_debito), SUM(t_prepago), SUM(t_accor), SUM(t_ecovale), SUM(t_efectivale), SUM(t_sivale), SUM(t_tiendapass), SUM(t_toka)
            FROM efectivos WHERE activo = '1'".$filtro.$filtro_suc);
            $row = mysqli_fetch_array($cadena);
            $json[] = [(string)"T. Debito",(double)$row[0]]; 
            $json[] = [(string)"T. Prepago",(double)$row[1]]; 
            $json[] = [(string)"T. ACCOR",(double)$row[2]]; 
            $json[] = [(string)"T. Ecovale",(double)$row[3]]; 
            $json[] = [(string)"T. Efectivale",(double)$row[4]]; 
            $json[] = [(string)"T. SiVale",(double)$row[5]];
            $json[] = [(string)"T. Tienda Pass",(double)$row[6]];
            $json[] = [(string)"T. Toka",(double)$row[7]];

        }else if($apartado == 3){
            $cadena = mysqli_query($conexion,"SELECT SUM(b_prest_mex), SUM(b_prest_uni), SUM(b_accor), SUM(b_efectivale), SUM(b_mision_esp), SUM(b_creditos), SUM(b_tengo_despensa) 
            FROM efectivos WHERE activo = '1'".$filtro.$filtro_suc);
            $row = mysqli_fetch_array($cadena);
            $json[] = [(string)"B. Prestaciones Mex.",(double)$row[0]]; 
            $json[] = [(string)"B. Prestaciones Uni.",(double)$row[1]]; 
            $json[] = [(string)"B. ACCOR",(double)$row[2]]; 
            $json[] = [(string)"B. Efectivale",(double)$row[3]]; 
            $json[] = [(string)"B. Mision Especial",(double)$row[4]]; 
            $json[] = [(string)"B. Creditos",(double)$row[5]];
            $json[] = [(string)"B. Tengo Desp",(double)$row[6]];
        }

    }

    echo json_encode($json);
?>