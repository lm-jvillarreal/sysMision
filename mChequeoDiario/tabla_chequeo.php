<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
//$fecha = '2019-07-18';
$hora=date ("H:i:s");

$cadena_actividades = "SELECT a.id, a.actividad, a.actividad, a.fin_do, a.fin_arb, a.fin_vill, a.fin_all, a.fin_pet FROM catalogoActividades_vidvig as a";

$consulta_actividades = mysqli_query($conexion, $cadena_actividades);
$cuerpo ="";
$hora_do="";
while ($row_actividades = mysqli_fetch_array($consulta_actividades)) {
    $escape_actividad = mysqli_real_escape_string($conexion, $row_actividades[1]);

    $cadena_do = "SELECT hora_actividad FROM actividadesDiarias_vidvig where fecha_actividad = '$fecha' and sucursal = '1' and id_actividad = '$row_actividades[0]'";
    $consulta_do = mysqli_query($conexion, $cadena_do);
    $row_do = mysqli_fetch_array($consulta_do);

    $cadena_arb = "SELECT hora_actividad FROM actividadesDiarias_vidvig where fecha_actividad = '$fecha' and sucursal = '2' and id_actividad = '$row_actividades[0]'";
    $consulta_arb = mysqli_query($conexion, $cadena_arb);
    $row_arb = mysqli_fetch_array($consulta_arb);

    $cadena_vill = "SELECT hora_actividad FROM actividadesDiarias_vidvig where fecha_actividad = '$fecha' and sucursal = '3' and id_actividad = '$row_actividades[0]'";
    $consulta_vill = mysqli_query($conexion, $cadena_vill);
    $row_vill = mysqli_fetch_array($consulta_vill);

    $cadena_all = "SELECT hora_actividad FROM actividadesDiarias_vidvig where fecha_actividad = '$fecha' and sucursal = '4' and id_actividad = '$row_actividades[0]'";
    $consulta_all = mysqli_query($conexion, $cadena_all);
    $row_all = mysqli_fetch_array($consulta_all);

    $cadena_pet = "SELECT hora_actividad FROM actividadesDiarias_vidvig where fecha_actividad = '$fecha' and sucursal = '5' and id_actividad = '$row_actividades[0]'";
    $consulta_pet = mysqli_query($conexion, $cadena_pet);
    $row_pet = mysqli_fetch_array($consulta_pet);

    if(strtotime($row_do[0])>strtotime($row_actividades[3])){
        $hora_do =  "<center><span class='label label-danger'>".$row_do[0]."</span></center>";
    }else{
        $hora_do =  "<center><span class='label label-success'>".$row_do[0]."</span></center>";
    }

    if(strtotime($row_arb[0])>strtotime($row_actividades[4])){
        $hora_arb =  "<center><span class='label label-danger'>".$row_arb[0]."</span></center>";
    }else{
        $hora_arb =  "<center><span class='label label-success'>".$row_arb[0]."</span></center>";
    }

    if(strtotime($row_vill[0])>strtotime($row_actividades[5])){
        $hora_vill =  "<center><span class='label label-danger'>".$row_vill[0]."</span></center>";
    }else{
        $hora_vill =  "<center><span class='label label-success'>".$row_vill[0]."</span></center>";
    }

    if(strtotime($row_all[0])>strtotime($row_actividades[6])){
        $hora_all =  "<center><span class='label label-danger'>".$row_all[0]."</span></center>";
    }else{
        $hora_all =  "<center><span class='label label-success'>".$row_all[0]."</span></center>";
    }

    if(strtotime($row_pet[0])>strtotime($row_actividades[7])){
        $hora_pet =  "<center><span class='label label-danger'>".$row_pet[0]."</span></center>";
    }else{
        $hora_pet =  "<center><span class='label label-success'>".$row_pet[0]."</span></center>";
    }
	$renglon = "
	{
        \"id\": \"$row_actividades[0]\",
        \"actividad\": \"$escape_actividad\",
        \"rango_do\": \"$hora_do\",
        \"rango_arb\": \"$hora_arb\",
        \"rango_vill\": \"$hora_vill\",
        \"rango_all\": \"$hora_all\",
        \"rango_pet\": \"$hora_pet\"
	},";
	$cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');
$tabla = "
["
.$cuerpo2.
"]
";
//echo $cadena_cartas;
echo $tabla;
?>