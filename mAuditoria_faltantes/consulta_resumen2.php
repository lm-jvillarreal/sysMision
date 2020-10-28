<?php
include '../global_seguridad/verificar_sesion.php';

$sucursal = $_POST['sucursal'];
$fecha_inicial = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];

if(!empty($sucursal)){
    $filtro_sucursal = " AND sucursal = '$sucursal'";
}elseif(empty($sucursal)){
    $filtro_sucursal = "";
}
//Consulta de totales
$cadena_total = "SELECT COUNT(*) FROM faltantes_pasven WHERE  DATE(fecha_captura) BETWEEN DATE('$fecha_inicial') AND DATE('$fecha_final')".$filtro_sucursal;
$consulta_total = mysqli_query($conexion, $cadena_total);
$row_total = mysqli_fetch_array($consulta_total);
$total = number_format($row_total[0], 0, '.', ',');

//Consulta de estatus 2
$cadena_gerente = "SELECT COUNT(*) FROM faltantes_pasven WHERE  DATE(fecha_captura) BETWEEN DATE('$fecha_inicial') AND DATE('$fecha_final') AND estatus = '2'".$filtro_sucursal;
$consulta_gerente = mysqli_query($conexion, $cadena_gerente);
$row_gerente = mysqli_fetch_array($consulta_gerente);
if($row_gerente[0]=="0"){
    $porcentaje_gerente="0";
}else{
    $porcentaje_gerente = ($row_gerente[0] * 100) / $row_total[0];
}
$porcentaje_gerente = round($porcentaje_gerente, 2) . '%';
$texto_gerente = $porcentaje_gerente." del total capturado";


//Consulta estatus 3 y 4
$cadena_enviados = "SELECT COUNT(*) FROM faltantes_pasven WHERE  DATE(fecha_captura) BETWEEN DATE('$fecha_inicial') AND DATE('$fecha_final') AND (estatus = '3' or estatus = '4')".$filtro_sucursal;
$consulta_enviados = mysqli_query($conexion, $cadena_enviados);
$row_enviados = mysqli_fetch_array($consulta_enviados);
if($row_enviados[0]=="0"){
    $porcentaje_enviados ="0";
}else{
    $porcentaje_enviados = ($row_enviados[0] * 100) / $row_total[0];
}
$porcentaje_enviados = round($porcentaje_enviados, 2) . '%';
$texto_enviados = $porcentaje_enviados." del total capturado";

//Estatus 4
$cadena_resCompras = "SELECT COUNT(*) FROM faltantes_pasven WHERE  DATE(fecha_captura) BETWEEN DATE('$fecha_inicial') AND DATE('$fecha_final') AND estatus = '4'".$filtro_sucursal;
$consulta_resCompras = mysqli_query($conexion, $cadena_resCompras);
$row_resCompras = mysqli_fetch_array($consulta_resCompras);
if($row_enviados[0]=="0"){
    $porcentaje_resCompras = "0";
}else{
    $porcentaje_resCompras = ($row_resCompras[0] * 100) / $row_enviados[0];
}
$porcentaje_resCompras = round($porcentaje_resCompras, 2) . '%';
$texto_resCompras = $porcentaje_resCompras." de lo enviado a compras";

//Estatus 5
$cadena_entrada = "SELECT COUNT(*) FROM faltantes_pasven WHERE  DATE(fecha_captura) BETWEEN DATE('$fecha_inicial') AND DATE('$fecha_final') AND (estatus = '5' or estatus = '7' or estatus = '8' or estatus = '9')".$filtro_sucursal;
$consulta_entrada = mysqli_query($conexion, $cadena_entrada);
$row_entrada = mysqli_fetch_array($consulta_entrada);
if($row_entrada[0]=="0"){
    $porcentaje_entrada="0";
}else{
    $porcentaje_entrada = ($row_entrada[0] * 100) / $row_total[0];
}
$porcentaje_entrada = round($porcentaje_entrada, 2) . '%';
$texto_entrada = $porcentaje_entrada." del total capturado";


//Estatus 7 y 8
$cadena_piso = "SELECT COUNT(*) FROM faltantes_pasven WHERE  DATE(fecha_captura) BETWEEN DATE('$fecha_inicial') AND DATE('$fecha_final') AND (estatus = '7' or estatus = '8' or estatus = '9')".$filtro_sucursal;
$consulta_piso = mysqli_query($conexion, $cadena_piso);
$row_piso = mysqli_fetch_array($consulta_piso);
if($row_entrada[0]=="0"){
    $porcentaje_piso = "0";
}else{
    $porcentaje_piso = ($row_piso[0] * 100) / $row_entrada[0];
}
$porcentaje_piso = round($porcentaje_piso, 2) . '%';
$texto_piso = $porcentaje_piso." del total recibido";

//estatus 8
$cadena_audita = "SELECT COUNT(*) FROM faltantes_pasven WHERE  DATE(fecha_audita) BETWEEN DATE('$fecha_inicial') AND DATE('$fecha_final') AND (estatus = '8' OR estatus = '9')".$filtro_sucursal;
$consulta_audita = mysqli_query($conexion, $cadena_audita);
$row_audita = mysqli_fetch_array($consulta_audita);
if($row_piso[0]=="0"){
    $porcentaje_audita = "0";
}else{
    $porcentaje_audita = ($row_audita[0] * 100) / $row_piso[0];
}
$porcentaje_audita = round($porcentaje_audita, 2) . '%';
$texto_audita = $porcentaje_audita." de lo marcado por Gerencia";

$cadena_auditaBien = "SELECT COUNT(*) FROM faltantes_pasven WHERE  DATE(fecha_audita) BETWEEN DATE('$fecha_inicial') AND DATE('$fecha_final') AND estatus = '8'".$filtro_sucursal;
$consulta_auditaBien = mysqli_query($conexion, $cadena_auditaBien);
$row_auditaBien = mysqli_fetch_array($consulta_auditaBien);
if($row_auditaBien[0]=="0"){
    $porcentaje_auditaBien = "0";
}else{
    $porcentaje_auditaBien = ($row_auditaBien[0] * 100) / $row_audita[0];
}
$porcentaje_auditaBien = round($porcentaje_auditaBien, 2) . '%';
$texto_auditaBien = $porcentaje_auditaBien." de lo auditado en piso";

$cadena_auditaMal = "SELECT COUNT(*) FROM faltantes_pasven WHERE  DATE(fecha_captura) BETWEEN DATE('$fecha_inicial') AND DATE('$fecha_final') AND estatus = '9'".$filtro_sucursal;
$consulta_auditaMal = mysqli_query($conexion, $cadena_auditaMal);
$row_auditaMal = mysqli_fetch_array($consulta_auditaMal);
if($row_auditaMal[0]=="0"){
    $porcentaje_auditaMal = "0";
}else{
    $porcentaje_auditaMal = ($row_auditaMal[0] * 100) / $row_audita[0];
}
$porcentaje_auditaMal = round($porcentaje_auditaMal, 2) . '%';
$texto_auditaMal = $porcentaje_auditaMal." de lo auditado en piso";

//estatus 8
$cadena_ajuste = "SELECT COUNT(*) FROM faltantes_pasven WHERE  DATE(fecha_captura) BETWEEN DATE('$fecha_inicial') AND DATE('$fecha_final') AND estatus = '10'".$filtro_sucursal;
$consulta_ajuste = mysqli_query($conexion, $cadena_ajuste);
$row_ajuste = mysqli_fetch_array($consulta_ajuste);
if($row_total[0]=="0"){
    $porcentaje_ajuste = "0";
}else{
    $porcentaje_ajuste = ($row_ajuste[0] * 100) / $row_total[0];
}
$porcentaje_ajuste = round($porcentaje_ajuste, 2) . '%';
$texto_ajuste = $porcentaje_ajuste." del total registrado";

$array = array(
    $total, //Total capturado
    $row_gerente[0], //Total estatus 2
    $porcentaje_gerente, //Porcentje estatus 2
    $texto_gerente, //Texto de porcentaje
    $row_enviados[0], //Total estatus 3 y 4
    $porcentaje_enviados, //Porcentaje estatus 3 y 4
    $texto_enviados,
    $row_resCompras[0],
    $porcentaje_resCompras,
    $texto_resCompras,
    $row_entrada[0],
    $porcentaje_entrada,
    $texto_entrada,
    $row_piso[0],
    $porcentaje_piso,
    $texto_piso,
    $row_audita[0],
    $porcentaje_audita,
    $texto_audita,
    $row_auditaBien[0],
    $porcentaje_auditaBien,
    $texto_auditaBien,
    $row_auditaMal[0],
    $porcentaje_auditaMal,
    $texto_auditaMal,
    $row_ajuste[0],
    $porcentaje_ajuste,
    $texto_ajuste
);
$array_datos = json_encode($array);
echo $array_datos;
?>
