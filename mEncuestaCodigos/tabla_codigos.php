<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';


$id_catalogo = $_POST['id_catalogo'];
$id_examen   = $_POST['id_examen'];

//$filtro =(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
$cadena = "SELECT id, codigo FROM detalle_categoria_codigos WHERE activo = '1' AND id_categoria = '$id_catalogo'";

$consulta = mysqli_query($conexion, $cadena);
$cuerpo   = "";
$numero   = 1;
while ($row = mysqli_fetch_array($consulta)){
    $cadena_consulta = "SELECT ARTC_DESCRIPCION FROM PV_ARTICULOS WHERE ARTC_ARTICULO = '$row[1]'";
    $st = oci_parse($conexion_central, $cadena_consulta);
    oci_execute($st);
    $row_producto = oci_fetch_row($st);

    $cadena2 = mysqli_query($conexion,"SELECT id FROM detalle_examen WHERE codigo = '$row[1]' AND activo = '1' AND id_examen = '$id_examen'");
      $cantidad = mysqli_num_rows($cadena2);
      if($cantidad == 0){
        $boton_seleccionar = "<button type='button' class='btn btn-default' id='boton_$numero' onclick='seleccionar($numero)'><i class='fa fa-check fa-lg' aria-hidden='true'></i></button><input id='selecciona_$numero' type='hidden' name='seleccionado[]' form='form_datos' value='0'> <input type='hidden' name='id_codigo[]' form='form_datos' value='$row[1]' class='botones'>";
      }else{
        $boton_seleccionar ="<button type='button' class='btn btn-danger btn-sm' onclick='eliminar_codigo($row[1])'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";
      }
    
    $renglon = "
	{
        \"#\": \"$numero\",
        \"Codigo\": \"$row[1]\",
        \"Descripcion\": \"$row_producto[0]\",
        \"Seleccionar\": \"$boton_seleccionar\"
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