<?php
// esto permite tener acceso desde otro servidor
    //header('Access-Control-Allow-Origin: *');
  // esto permite tener acceso desde otro servidor
  // include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion.php';
  include '../global_settings/consulta_sqlsrvr.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$cadena_plantilla = "SELECT id, puesto, depto, cantidad, sucursal FROM plantilla_empleados";
$consulta_plantilla = mysqli_query($conexion, $cadena_plantilla);

$cuerpo ="";

while ($row_plantilla = mysqli_fetch_array($consulta_plantilla)) {

    $cadena_activos = "SELECT COUNT(DISTINCT(emp.codigo)) as cantidad FROM empleados as emp
                        INNER JOIN clasificacion_empleados AS clase ON emp.codigo = clase.codigo
                        INNER JOIN llaves AS ky ON emp.codigo = ky.codigo
                        INNER JOIN tabulador as tab ON ky.ocupacion = tab.ocupacion
                        WHERE clase.campo__14 = '$row_plantilla[4]'
                        AND clase.campo__15 = '$row_plantilla[2]'
                        AND tab.descripcion = '$row_plantilla[1]'";
                        
    //campo_14 sucursal, campo_15 departamento
    
    $consulta_activos = sqlsrv_query($conn, $cadena_activos);
    $row_activos = sqlsrv_fetch_array( $consulta_activos, SQLSRV_FETCH_ASSOC);
    $cantidad = $row_activos['cantidad'];

    $conteo = "<center>".$row_plantilla[3]."</center>";

    if($cantidad<$row_plantilla[3]){
        $cant = "<center><span class='description-percentage text-red'><i class='fa fa-caret-down'></i> ".$cantidad."</span></center>";
        $vacantes = $row_plantilla[3]-$cantidad;
        $vacantes = "<center>".$vacantes."</center>";
    }elseif($cantidad==$row_plantilla[3]){
        $cant = "<center><span class='description-percentage text-green'><i class='fa fa-caret-right'></i> ".$cantidad."</span></center>";
        $vacantes = '<center>0</center>';
    }elseif($cantidad>$row_plantilla[3]){
        $cant = "<center><span class='description-percentage text-red'><i class='fa fa-caret-up'></i> ".$cantidad."</span></center>";
        $vacantes = '<center>0</center>';
    }
	$renglon = "
		{
		\"id\": \"$row_plantilla[0]\",
		\"puesto\": \"$row_plantilla[1]\",
		\"depto\": \"$row_plantilla[2]\",
        \"cantidad\": \"$conteo\",
        \"sucursal\": \"$row_plantilla[4]\",
        \"activos\": \"$cant\",
        \"vacantes\": \"$vacantes\"
		},";
	$cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');

$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>