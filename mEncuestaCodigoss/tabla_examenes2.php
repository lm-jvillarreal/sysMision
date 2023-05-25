<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$filtro =(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
$cadena = "SELECT id, nombre,
CASE tipo_examen WHEN '1' THEN 'Códigos' WHEN '2' THEN 'Descripciones' ELSE 'Imágen' END AS tipo_examen,
            (SELECT nombre FROM categoria_codigos WHERE examenes.id_categoria = categoria_codigos.id), activo 
            FROM examenes WHERE (activo = '1' OR activo = '2')".$filtro;

$consulta = mysqli_query($conexion, $cadena);
$cuerpo   = "";
$numero   = 1;

while ($row = mysqli_fetch_array($consulta)){

    $color = ($row[4] == 2)?"success":"danger";
    $icono = ($row[4] == 2)?"check-square":"window-close";
    $boton_eliminar    = "<button type='button' class='btn btn-$color' onclick='desactivar($row[0])'><i class='fa fa-$icono fa-lg' aria-hidden='true'></i></button>";
    
    $renglon = "
	{
        \"#\": \"$numero\",
        \"Nombre\": \"$row[1]\",
        \"Tipo\": \"$row[2]\",
        \"Catalogo\": \"$row[3]\",
        \"Act\": \"$boton_eliminar\"
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
echo $tabla;
?>