<?php
include '../global_seguridad/verificar_sesion.php';

$filtro =(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
$cadena = "SELECT id, nombre FROM categoria_codigos WHERE activo = '1'".$filtro;

$consulta = mysqli_query($conexion, $cadena);
$cuerpo   = "";
$numero   = 1;
while ($row = mysqli_fetch_array($consulta)){

    $boton_editar = "<button type='button' class='btn btn-warning' onclick='editar_categoria($row[0])'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></button>";
    $boton_eliminar = "<button type='button' class='btn btn-danger' onclick='eliminar_categoria($row[0])'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";
    
    $renglon = "
	{
        \"#\": \"$numero\",
        \"Nombre\": \"$row[1]\",
        \"Editar\": \"$boton_editar\",
        \"Eliminar\": \"$boton_eliminar\"
	},";
	$cuerpo = $cuerpo.$renglon;
    $numero ++;
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