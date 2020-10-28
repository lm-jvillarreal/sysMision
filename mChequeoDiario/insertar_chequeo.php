<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');

$id = $_POST['id'];
$do = $_POST['do'];
$arb = $_POST['arb'];
$vill = $_POST['vill'];
$all = $_POST['all'];

$valida = "SELECT * FROM actividadesDiarias_vidvig WHERE fecha_actividad = '$fecha'";
$consulta_valida = mysqli_query($conexion,$valida);
$row_valida = mysqli_fetch_array($consulta_valida);
$conteo = count($row_valida[0]);

if($conteo>0){
	echo "ya_existe";
}else{
    $conteo = count($id);
    for($i=0;$i<=$conteo;$i++){
        $cadena_do = "INSERT INTO actividadesDiarias_vidvig (id_actividad, hora_actividad, fecha_actividad, sucursal, fecha, hora, activo, usuario)VALUES('$id[$i]', '$do[$i]', '$fecha', '1', '$fecha', '$hora', '1', '$id_usuario')";
        $consulta_do = mysqli_query($conexion, $cadena_do);

        $cadena_arb = "INSERT INTO actividadesDiarias_vidvig (id_actividad, hora_actividad, fecha_actividad, sucursal, fecha, hora, activo, usuario)VALUES('$id[$i]', '$arb[$i]', '$fecha', '2', '$fecha', '$hora', '1', '$id_usuario')";
        $consulta_arb = mysqli_query($conexion, $cadena_arb);

        $cadena_vill = "INSERT INTO actividadesDiarias_vidvig (id_actividad, hora_actividad, fecha_actividad, sucursal, fecha, hora, activo, usuario)VALUES('$id[$i]', '$vill[$i]', '$fecha', '3', '$fecha', '$hora', '1', '$id_usuario')";
        $consulta_vill = mysqli_query($conexion, $cadena_vill);

        $cadena_all = "INSERT INTO actividadesDiarias_vidvig (id_actividad, hora_actividad, fecha_actividad, sucursal, fecha, hora, activo, usuario)VALUES('$id[$i]', '$all[$i]', '$fecha', '4', '$fecha', '$hora', '1', '$id_usuario')";
        $consulta_all = mysqli_query($conexion, $cadena_all);

        $cadena_pet = "INSERT INTO actividadesDiarias_vidvig (id_actividad, hora_actividad, fecha_actividad, sucursal, fecha, hora, activo, usuario)VALUES('$id[$i]', '$all[$i]', '$fecha', '5', '$fecha', '$hora', '1', '$id_usuario')";
        $consulta_pet = mysqli_query($conexion, $cadena_pet);
    }
    echo "ok";
}
?>
