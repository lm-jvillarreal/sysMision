<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$id_categoria = $_POST['id_categoria'];

$filtro =(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
$cadena = "SELECT id, codigo FROM detalle_categoria_codigos WHERE activo = '1' AND id_categoria = '$id_categoria'".$filtro." ORDER BY id DESC";

$consulta = mysqli_query($conexion, $cadena);
$cuerpo   = "";
$numero   = 1;
$color    = "";
while ($row = mysqli_fetch_array($consulta)){

    $cadena_consulta = "SELECT ARTC_DESCRIPCION FROM PV_ARTICULOS WHERE ARTC_ARTICULO = '$row[1]'";
    $st = oci_parse($conexion_central, $cadena_consulta);
    oci_execute($st);
    $row_producto = oci_fetch_row($st);

    if (file_exists('images/'.$row[0].'.png')){
        $ruta = 'images/'.$row[0].'.png?'.$hora;
        $imagenes = "<a class='venobox btn btn-warning btn-sm' href='$ruta' alt='Imagen $numero' data-gall='myGallery_$numero' title='$row_producto[0]'><i class='fa fa-image fa-lg' aria-hidden='true'></i></a>";
        // $boton_ver="<a class='venobox btn btn-$color btn-sm' href='$ruta' alt='Imagen 1' data-gall='myGallery_$numero' title='$row_producto[1]'><i class='fa fa-file-image-o fa-lg'></i></a>";
        $color = "success";
    }else{
        $imagenes = "";
        $color    = "danger";
    }

    $boton_imagen = "<button type='button' class='btn btn-$color btn-sm' onclick='abrirModalSubir($row[0])'><i class='fa fa-cloud-upload fa-lg' aria-hidden='true'></i></button>";
    $boton_eliminar = "<button type='button' class='btn btn-danger' onclick='eliminar_detalle($row[0])'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";
    
    $renglon = "
	{
        \"#\": \"$numero\",
        \"Codigo\": \"$row[1]\",
        \"Descripcion\": \"$row_producto[0]\",
        \"Imagen\": \"$boton_imagen $imagenes\",
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