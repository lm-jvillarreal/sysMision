<?php
include '../global_seguridad/verificar_sesion.php';
$fechahora = date("Y-m-d H:i:s");
$id_tabla = $_POST['id_receta'];
$clave_receta = $_POST['clave_receta'];
$tipo = $_POST['tipo'];
$prod_lunes = $_POST['prod_lunes'];
$prod_martes = $_POST['prod_martes'];
$prod_miercoles = $_POST['prod_miercoles'];
$prod_jueves = $_POST['prod_jueves'];
$prod_viernes = $_POST['prod_viernes'];
$prod_sabado = $_POST['prod_sabado'];
$prod_domingo = $_POST['prod_domingo'];
$tipo_real = ($tipo == "PRODUCTO" ? '1' : '0');

// W /*+ 1 se agregó para la semana siguiente*/
$dt = new DateTime();
$dt->setISODate($dt->format('o'), $dt->format('W') + 1);
$periods = new DatePeriod($dt, new DateInterval('P1D'), 6);
$days = iterator_to_array($periods);
$diaInicial = $days[0]->format("Ymd");
$diaFinal = $days[6]->format("Ymd");
//
$cadenaReceta = "SELECT ID,
                ID_ARTICULO,
                ID_TABLA,
                LUNES,
                MARTES,
                MIERCOLES,
                JUEVES,
                VIERNES,
                SABADO,
                DOMINGO,
                TIPO,
                FECHA_INICIO,
                FECHA_FIN
                FROM panaderia_calendarioprod
                WHERE ID_ARTICULO = '$clave_receta'
                AND FECHA_INICIO = '$diaInicial'
                AND FECHA_FIN = '$diaFinal'";
$consultaReceta=mysqli_query($conexion,$cadenaReceta);
$rowReceta=mysqli_fetch_array($consultaReceta);

if ($rowReceta[1] != null) {
    $cadenaUpdate = "UPDATE panaderia_calendarioprod 
    SET LUNES = '$prod_lunes', MARTES = '$prod_martes', MIERCOLES = '$prod_miercoles', JUEVES ='$prod_jueves', VIERNES = '$prod_viernes', SABADO = '$prod_sabado', DOMINGO = '$prod_domingo', FECHAHORA = '$fechahora', ACTIVO = '1', USUARIO = '$id_usuario'
    WHERE ID_ARTICULO = $rowReceta[1] AND FECHA_INICIO = '$diaInicial' AND FECHA_FIN = '$diaFinal'";
    $insertar = mysqli_query($conexion, $cadenaUpdate);
    echo "ok";
    
}else{
    $cadenaInsertar = "INSERT INTO panaderia_calendarioprod 
    (ID_ARTICULO, FECHA_INICIO, FECHA_FIN, LUNES, MARTES, MIERCOLES, JUEVES, VIERNES, SABADO, DOMINGO, ID_TABLA, TIPO, FECHAHORA, ACTIVO, USUARIO) 
    VALUES 
    ('$clave_receta', $diaInicial, $diaFinal, '$prod_lunes', '$prod_martes', '$prod_miercoles', '$prod_jueves', '$prod_viernes', '$prod_sabado', $prod_domingo, '$id_tabla', '$tipo_real', '$fechahora', '1', '$id_usuario')";
    $insertar = mysqli_query($conexion, $cadenaInsertar);
    echo "ok";
}



?>