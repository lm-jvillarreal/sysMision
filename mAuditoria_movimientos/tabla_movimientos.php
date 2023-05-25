<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
// $folio = $_POST['folio'];
//AGUA BONAFONT 12 1.5 LTS.
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

$fecha_inicio = $_POST['fi'];
$fecha_fin = $_POST['ff'];
$sucursal = $_POST['suc'];
$now = new DateTime();
$cuerpo = "";
// MERMA CARNICERIA
$cantidad_sxmcar = 0;
$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
                    FROM INV_MOVIMIENTOS
                    WHERE MODC_TIPOMOV = 'SXMCAR'
                    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                    AND ALMN_ALMACEN = '$sucursal'";
				
$consulta_sxmcar = oci_parse($conexion_central, $cadena_consulta);
oci_execute($consulta_sxmcar);

while($row_sxmcar = oci_fetch_array($consulta_sxmcar)){
    $cantidad_sxmcar = oci_num_rows($consulta_sxmcar);
    $f_sxmcar = new DateTime($row_sxmcar[4]);
}
if($cantidad_sxmcar==0){
    $interval_sxmcar="No existen registros";
}else{
    $interval_sxmcar = $f_sxmcar->diff($now)->format("%d");
    if($interval_sxmcar >0 AND $interval_sxmcar<10){
        $interval_sxmcar = '0'.$interval_sxmcar;
    }
    $interval_sxmcar = $interval_sxmcar." días de retraso";
}

$renglon_sxmcar = "
{
    \"movimiento\": \"Merma Carniceria\",
    \"retraso\": \"$interval_sxmcar\"
},";

//MERMA FRUTERIA
$cantidad_sxmfta = 0;
$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
                    FROM INV_MOVIMIENTOS
                    WHERE MODC_TIPOMOV = 'SXMFTA'
                    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                    AND ALMN_ALMACEN = '$sucursal'";
				
$consulta_sxmfta = oci_parse($conexion_central, $cadena_consulta);
oci_execute($consulta_sxmfta);

while($row_sxmfta = oci_fetch_array($consulta_sxmfta)){
    $cantidad_sxmfta = oci_num_rows($consulta_sxmfta);
    $f_sxmfta = new DateTime($row_sxmfta[4]);
}
if($cantidad_sxmfta==0){
    $interval_sxmfta="No existen registros";
}else{
    $interval_sxmfta = $f_sxmfta->diff($now)->format("%d");
    if($interval_sxmfta >0 AND $interval_sxmfta<10){
        $interval_sxmfta = '0'.$interval_sxmfta;
    }
    $interval_sxmfta = $interval_sxmfta." días de retraso";
}

$renglon_sxmfta = "
{
    \"movimiento\": \"Merma Fruta\",
    \"retraso\": \"$interval_sxmfta\"
},";

//MERMA PANADERIA
$cantidad_sxmpan = 0;
$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
                    FROM INV_MOVIMIENTOS
                    WHERE MODC_TIPOMOV = 'SXMPAN'
                    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                    AND ALMN_ALMACEN = '$sucursal'";
				
$consulta_sxmpan = oci_parse($conexion_central, $cadena_consulta);
oci_execute($consulta_sxmpan);

while($row_sxmpan = oci_fetch_array($consulta_sxmpan)){
    $cantidad_sxmpan = oci_num_rows($consulta_sxmpan);
    $f_sxmpan = new DateTime($row_sxmpan[4]);
}
if($cantidad_sxmpan==0){
    $interval_sxmpan="No existen registros";
}else{
    $interval_sxmpan = $f_sxmpan->diff($now)->format("%d");
    if($interval_sxmpan >0 AND $interval_sxmpan<10){
        $interval_sxmpan = '0'.$interval_sxmpan;
    }
    $interval_sxmpan = $interval_sxmpan." días de retraso";
}

$renglon_sxmpan = "
{
    \"movimiento\": \"Merma Panadería\",
    \"retraso\": \"$interval_sxmpan\"
},";

//MERMA TORTILLERIA
$cantidad_sxmtor = 0;
$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
                    FROM INV_MOVIMIENTOS
                    WHERE MODC_TIPOMOV = 'SXMTOR'
                    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                    AND ALMN_ALMACEN = '$sucursal'";
				
$consulta_sxmtor = oci_parse($conexion_central, $cadena_consulta);
oci_execute($consulta_sxmtor);

while($row_sxmtor = oci_fetch_array($consulta_sxmtor)){
    $cantidad_sxmtor = oci_num_rows($consulta_sxmtor);
    $f_sxmtor = new DateTime($row_sxmtor[4]);
}
if($cantidad_sxmtor==0){
    $interval_sxmtor="No existen registros";
}else{
    $interval_sxmtor = $f_sxmtor->diff($now)->format("%d");
    if($interval_sxmtor >0 AND $interval_sxmtor<10){
        $interval_sxmtor = '0'.$interval_sxmtor;
    }
    $interval_sxmtor = $interval_sxmtor." días de retraso";
}

$renglon_sxmtor = "
{
    \"movimiento\": \"Merma Tortillería\",
    \"retraso\": \"$interval_sxmtor\"
},";

//MERMA DE BODEGA
$cantidad_sxmbod = 0;
$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
    FROM INV_MOVIMIENTOS
    WHERE MODC_TIPOMOV = 'SXMBOD'
    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
    AND ALMN_ALMACEN = '$sucursal'";
				
$consulta_sxmbod = oci_parse($conexion_central, $cadena_consulta);
oci_execute($consulta_sxmbod);
while($row_sxmbod = oci_fetch_array($consulta_sxmbod)){
    $cantidad_sxmbod = oci_num_rows($consulta_sxmbod);
    $f_sxmbod = new DateTime($row_sxmbod[4]);
}if($cantidad_sxmbod==0){
    $interval_sxmbod="No existen registros";
}else{
    $interval_sxmbod = $f_sxmbod->diff($now)->format("%d");
    if($interval_sxmbod >0 AND $interval_sxmbod<10){
        $interval_sxmbod = '0'.$interval_sxmbod;
    }
    $interval_sxmbod = $interval_sxmbod." días de retraso";
}

$renglon_sxmbod = "
{
    \"movimiento\": \"Merma Bodega\",
    \"retraso\": \"$interval_sxmbod\"
},";

//MERMA MAL ESTADO
$cantidad_sxmedo = 0;
$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
    FROM INV_MOVIMIENTOS
    WHERE MODC_TIPOMOV = 'SXMEDO'
    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
    AND ALMN_ALMACEN = '$sucursal'";
				
$consulta_sxmedo = oci_parse($conexion_central, $cadena_consulta);
oci_execute($consulta_sxmedo);
while($row_sxmedo = oci_fetch_array($consulta_sxmedo)){
    $cantidad_sxmedo = oci_num_rows($consulta_sxmedo);
    $f_sxmedo = new DateTime($row_sxmedo[4]);
}
if($cantidad_sxmedo==0){
    $interval_sxmedo="No existen registros";
}else{
    $interval_sxmedo = $f_sxmedo->diff($now)->format("%d");
    if($interval_sxmedo >0 AND $interval_sxmedo<10){
        $interval_sxmedo = '0'.$interval_sxmedo;
    }
    $interval_sxmedo = $interval_sxmedo." días de retraso";
}

$renglon_sxmedo = "
{
    \"movimiento\": \"Merma Mal Estado\",
    \"retraso\": \"$interval_sxmedo\"
},";

//MERMA CADUCIDAD
$cantidad_sxmcad = 0;
$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
    FROM INV_MOVIMIENTOS
    WHERE MODC_TIPOMOV = 'SXMCAD'
    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
    AND ALMN_ALMACEN = '$sucursal'";
				
$consulta_sxmcad = oci_parse($conexion_central, $cadena_consulta);
oci_execute($consulta_sxmcad);
while($row_sxmcad = oci_fetch_array($consulta_sxmcad)){
    $cantidad_sxmcad = oci_num_rows($consulta_sxmcad);
    $f_sxmcad = new DateTime($row_sxmcad[4]);
}
if($cantidad_sxmcad==0){
    $interval_sxmcad="No existen registros";
}else{
    $interval_sxmcad = $f_sxmcad->diff($now)->format("%d");
    if($interval_sxmcad >0 AND $interval_sxmcad<10){
        $interval_sxmcad = '0'.$interval_sxmcad;
    }
    $interval_sxmcad = $interval_sxmcad." días de retraso";
}

$renglon_sxmcad = "
{
    \"movimiento\": \"Merma Por Caducidad\",
    \"retraso\": \"$interval_sxmcad\"
},";

//SALIDA POR ROBO
$cantidad_sxrob = 0;
$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
    FROM INV_MOVIMIENTOS
    WHERE MODC_TIPOMOV = 'SXROB'
    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
    AND ALMN_ALMACEN = '$sucursal'";
				
$consulta_sxrob = oci_parse($conexion_central, $cadena_consulta);
oci_execute($consulta_sxrob);
while($row_sxrob = oci_fetch_array($consulta_sxrob)){
    $cantidad_sxrob = oci_num_rows($consulta_sxrob);
    $f_sxrob = new DateTime($row_sxrob[4]);
}
if($cantidad_sxrob==0){
    $interval_sxrob="No existen registros";
}else{
    $interval_sxrob = $f_sxrob->diff($now)->format("%d");
    if($interval_sxrob >0 AND $interval_sxrob<10){
        $interval_sxrob = '0'.$interval_sxrob;
    }
    $interval_sxrob = $interval_sxrob." días de retraso";
}

$renglon_sxrob = "
{
    \"movimiento\": \"Salida por Robo\",
    \"retraso\": \"$interval_sxrob\"
},";

//MERMA FARMACIA
$cantidad_sxmfci = 0;
$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
    FROM INV_MOVIMIENTOS
    WHERE MODC_TIPOMOV = 'SXMFCI'
    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
    AND ALMN_ALMACEN = '$sucursal'";
				
$consulta_sxmfci = oci_parse($conexion_central, $cadena_consulta);
oci_execute($consulta_sxmfci);
while($row_sxmfci = oci_fetch_array($consulta_sxmfci)){
    $cantidad_sxmfci = oci_num_rows($consulta_sxmfci);
    $f_sxmfci = new DateTime($row_sxmfci[4]);
}
if($cantidad_sxmfci==0){
    $interval_sxmfci="No existen registros";
}else{
    $interval_sxmfci = $f_sxmfci->diff($now)->format("%d");
    if($interval_sxmfci >0 AND $interval_sxmfci<10){
        $interval_sxmfci = '0'.$interval_sxmfci;
    }
    $interval_sxmfci = $interval_sxmfci." días de retraso";
}
$renglon_sxmfci = "
{
    \"movimiento\": \"Merma Farmacia\",
    \"retraso\": \"$interval_sxmfci\"
},";

//Salida FARM ACCIDENTES
$cantidad_sfaacc = 0;
$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
	FROM INV_MOVIMIENTOS
	WHERE MODC_TIPOMOV = 'SFAACC'
	AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
	AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
	AND ALMN_ALMACEN = '$sucursal'";
				
$consulta_sfaacc = oci_parse($conexion_central, $cadena_consulta);
oci_execute($consulta_sfaacc);
while($row_sfaacc = oci_fetch_array($consulta_sfaacc)){
    $cantidad_sfaacc = oci_num_rows($consulta_sfaacc);
    $f_sfaacc = new DateTime($row_sfaacc[4]);
}
if($cantidad_sfaacc==0){
    $interval_sfaacc = "No existen registros";
}else{
    $interval_sfaacc = $f_sfaacc->diff($now)->format("%d");
    if($interval_sfaacc >0 AND $interval_sfaacc<10){
        $interval_sfaacc = '0'.$interval_sfaacc;
    }
    $interval_sfaacc = $interval_sfaacc." días de retraso";
}
$renglon_sfaacc = "
{
    \"movimiento\": \"Salida Farm. Accidentes\",
    \"retraso\": \"$interval_sfaacc\"
},";

//SALIDA FARMACIA BOTIQUIN
$cantidad_sfcbot = 0;
$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
    FROM INV_MOVIMIENTOS
    WHERE MODC_TIPOMOV = 'SFCBOT'
    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
    AND ALMN_ALMACEN = '$sucursal'";
				
$consulta_sfcbot = oci_parse($conexion_central, $cadena_consulta);
oci_execute($consulta_sfcbot);
while($row_sfcbot = oci_fetch_array($consulta_sfcbot)){
    $cantidad_sfcbot = oci_num_rows($consulta_sfcbot);
    $f_sfcbot = new DateTime($row_sfcbot[4]);
}
if($cantidad_sfcbot==0){
    $interval_sfcbot="No existen registros";
}else{
    $interval_sfcbot = $f_sfcbot->diff($now)->format("%d");
    if($interval_sfcbot >0 AND $interval_sfcbot<10){
        $interval_sfcbot = '0'.$interval_sfcbot;
    }
    $interval_sfcbot = $interval_sfcbot." días de retraso";
}

$renglon_sfcbot = "
{
    \"movimiento\": \"Salida Farm. Botiquín\",
    \"retraso\": \"$interval_sfcbot\"
},";

//Entrada por Vigilancia
$cantidad_exvigi=0;
$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
    FROM INV_MOVIMIENTOS
    WHERE MODC_TIPOMOV = 'EXVIGI'
    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
    AND ALMN_ALMACEN = '$sucursal'";
				
$consulta_exvigi = oci_parse($conexion_central, $cadena_consulta);
oci_execute($consulta_exvigi);
while($row_exvigi = oci_fetch_array($consulta_exvigi)){
    $cantidad_exvigi = oci_num_rows($consulta_exvigi);
    $f_exvigi = new DateTime($row_exvigi[4]);
}
if($cantidad_exvigi==0){
    $interval_exvigi="No existen registros";
}else{
    $interval_exvigi = $f_exvigi->diff($now)->format("%d");
    if($interval_exvigi >0 AND $interval_exvigi<10){
        $interval_exvigi = '0'.$interval_exvigi;
    }
    $interval_exvigi = $interval_exvigi." días de retraso";
}

$renglon_exvigi = "
{
    \"movimiento\": \"Entrada Vigilancia\",
    \"retraso\": \"$interval_exvigi\"
},";

//Entrada por conversion de chorizo
$cantidad_echori =0;
$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
    FROM INV_MOVIMIENTOS
    WHERE MODC_TIPOMOV = 'ECHORI'
    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
    AND ALMN_ALMACEN = '$sucursal'";
				
$consulta_echori = oci_parse($conexion_central, $cadena_consulta);
oci_execute($consulta_echori);
while($row_echori = oci_fetch_array($consulta_echori)){
    $cantidad_echori = oci_num_rows($consulta_echori);
    $f_echori = new DateTime($row_echori[4]);
}
if($cantidad_echori==0){
    $interval_echori="No existen registros";
}else{
    $interval_echori = $f_echori->diff($now)->format("%d");
    if($interval_echori >0 AND $interval_echori<10){
        $interval_echori = '0'.$interval_echori;
    }
    $interval_echori = $interval_echori." días de retraso";
}

$renglon_echori = "
{
    \"movimiento\": \"Ent. Conv. Chorizo\",
    \"retraso\": \"$interval_echori\"
},";

//Salida por conversion de chorizo
$cantidad_schori = 0;
$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
    FROM INV_MOVIMIENTOS
    WHERE MODC_TIPOMOV = 'SCHORI'
    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
    AND ALMN_ALMACEN = '$sucursal'";
				
$consulta_schori = oci_parse($conexion_central, $cadena_consulta);
oci_execute($consulta_schori);
while($row_schori = oci_fetch_array($consulta_schori)){
    $cantidad_schori = oci_num_rows($consulta_schori);
    $f_schori = new DateTime($row_schori[4]);
}
if($cantidad_schori==0){
    $interval_schori="No existen registros";
}else{
    $interval_schori = $f_schori->diff($now)->format("%d");
    if($interval_schori >0 AND $interval_schori<10){
        $interval_schori = '0'.$interval_schori;
    }
    $interval_schori = $interval_schori." días de retraso";
}
$renglon_schori = "
{
    \"movimiento\": \"Sal. Conv. Chorizo\",
    \"retraso\": \"$interval_schori\"
},";

//Traspasos entre departamentos
$cantidad_tradep = 0;
$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
    FROM INV_MOVIMIENTOS
    WHERE MODC_TIPOMOV = 'TRADEP'
    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
    AND ALMN_ALMACEN = '$sucursal'";
				
$consulta_tradep = oci_parse($conexion_central, $cadena_consulta);
oci_execute($consulta_tradep);
while($row_tradep = oci_fetch_array($consulta_tradep)){
    $cantidad_tradep = oci_num_rows($consulta_tradep);
    $f_tradep = new DateTime($row_tradep[4]);
}
if($cantidad_tradep==0){
    $interval_tradep="No existen registros";
}else{
    $interval_tradep = $f_tradep->diff($now)->format("%d");
    if($interval_tradep >0 AND $interval_tradep<10){
        $interval_tradep = '0'.$interval_tradep;
    }
    $interval_tradep = $interval_tradep." días de retraso";
}
$renglon_tradep = "
{
    \"movimiento\": \"Trans. entre Deptos.\",
    \"retraso\": \"$interval_tradep\"
},";

//Ent. conv. arts
$cantidad_exconv=0;
$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
    FROM INV_MOVIMIENTOS
    WHERE MODC_TIPOMOV = 'EXCONV'
    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
    AND ALMN_ALMACEN = '$sucursal'";
				
$consulta_exconv = oci_parse($conexion_central, $cadena_consulta);
oci_execute($consulta_exconv);
while($row_exconv = oci_fetch_array($consulta_exconv)){
    $cantidad_exconv = oci_num_rows($consulta_exconv);
    $f_exconv = new DateTime($row_exconv[4]);
}
if($cantidad_exconv==0){
    $interval_exconv="No existen registros";
}else{
    $interval_exconv = $f_exconv->diff($now)->format("%d");
    if($interval_exconv >0 AND $interval_exconv<10){
        $interval_exconv = '0'.$interval_exconv;
    }
    $interval_exconv = $interval_exconv." días de retraso";
}
$renglon_exconv = "
{
    \"movimiento\": \"Ent. Conv. Arts.\",
    \"retraso\": \"$interval_exconv\"
},";

$cantidad_devpro=0;
$cadena_consulta="SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
FROM INV_MOVIMIENTOS
WHERE MODC_TIPOMOV = 'DEVPRO'
AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
AND ALMN_ALMACEN = '$sucursal'";
$consulta_devpro=oci_parse($conexion_central,$cadena_consulta);
oci_execute($consulta_devpro);
while($row_devpro = oci_fetch_array($consulta_devpro)){
    $cantidad_devpro = oci_num_rows($consulta_devpro);
    $f_devpro = new DateTime($row_devpro[4]);
}
if($cantidad_devpro==0){
    $interval_devpro="No existen registros";
}else{
    $interval_devpro = $f_devpro->diff($now)->format("%d");
    if($interval_devpro >0 AND $interval_devpro<10){
        $interval_devpro = '0'.$interval_devpro;
    }
    $interval_devpro = $interval_devpro." días de retraso";
}
$renglon_devpro = "
{
    \"movimiento\": \"Devolución Individual\",
    \"retraso\": \"$interval_devpro\"
},";

$cantidad_dmprov=0;
$cadena_consulta="SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
FROM INV_MOVIMIENTOS
WHERE MODC_TIPOMOV = 'DMPROV'
AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
AND ALMN_ALMACEN = '$sucursal'";
$consulta_dmprov=oci_parse($conexion_central,$cadena_consulta);
oci_execute($consulta_dmprov);
while($row_dmprov = oci_fetch_array($consulta_dmprov)){
    $cantidad_dmprov = oci_num_rows($consulta_dmprov);
    $f_dmprov = new DateTime($row_dmprov[4]);
}
if($cantidad_dmprov==0){
    $interval_dmprov="No existen registros";
}else{
    $interval_dmprov = $f_dmprov->diff($now)->format("%d");
    if($interval_dmprov >0 AND $interval_dmprov<10){
        $interval_dmprov = '0'.$interval_dmprov;
    }
    $interval_dmprov = $interval_dmprov." días de retraso";
}
$renglon_dmprov = "
{
    \"movimiento\": \"Devolución Masiva a Proveedor\",
    \"retraso\": \"$interval_dmprov\"
},";

$cantidad_devctr=0;
$cadena_consulta="SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
FROM INV_MOVIMIENTOS
WHERE MODC_TIPOMOV = 'DEVCTR'
AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
AND ALMN_ALMACEN = '$sucursal'";
$consulta_devctr=oci_parse($conexion_central,$cadena_consulta);
oci_execute($consulta_devctr);
while($row_devctr = oci_fetch_array($consulta_devctr)){
    $cantidad_devctr = oci_num_rows($consulta_devctr);
    $f_devctr = new DateTime($row_devctr[4]);
}
if($cantidad_devctr==0){
    $interval_devctr="No existen registros";
}else{
    $interval_devctr = $f_devctr->diff($now)->format("%d");
    if($interval_devctr >0 AND $interval_devctr<10){
        $interval_devctr = '0'.$interval_devctr;
    }
    $interval_devctr = $interval_devctr." días de retraso";
}
$renglon_devctr = "
{
    \"movimiento\": \"Devolución Centralizada\",
    \"retraso\": \"$interval_devctr\"
},";

$cantidad_devxco=0;
$cadena_consulta="SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
FROM INV_MOVIMIENTOS
WHERE MODC_TIPOMOV = 'DEVXCO'
AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
AND ALMN_ALMACEN = '$sucursal'";
$consulta_devxco=oci_parse($conexion_central,$cadena_consulta);
oci_execute($consulta_devxco);
while($row_devxco = oci_fetch_array($consulta_devxco)){
    $cantidad_devxco = oci_num_rows($consulta_devxco);
    $f_devxco = new DateTime($row_devxco[4]);
}
if($cantidad_devxco==0){
    $interval_devxco="No existen registros";
}else{
    $interval_devxco = $f_devxco->diff($now)->format("%d");
    if($interval_devxco >0 AND $interval_devxco<10){
        $interval_devxco = '0'.$interval_devxco;
    }
    $interval_devxco = $interval_devxco." días de retraso";
}
$renglon_devxco = "
{
    \"movimiento\": \"Devolución por Corrección\",
    \"retraso\": \"$interval_devxco\"
},";

$renglon = $renglon_sxmcar.$renglon_sxmfta.$renglon_sxmpan.$renglon_sxmtor.$renglon_sxmbod.$renglon_sxmedo.$renglon_sxmcad.$renglon_sxrob.$renglon_sxmfci.$renglon_sfaacc.$renglon_sfcbot.$renglon_exvigi.$renglon_echori.$renglon_schori.$renglon_tradep.$renglon_exconv.$renglon_devpro.$renglon_dmprov.$renglon_devctr.$renglon_devxco;
$cuerpo = $cuerpo.$renglon;
$cuerpo2 = trim($cuerpo, ',');
$tabla = "
["
.$cuerpo2.
"]
";
//echo $cadena_cartas;
echo $tabla;
?>
