<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';


$departamento = $_POST['departamento'];
$id_examen   = $_POST['id_examen'];

//$filtro =(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
$cadena = "SELECT
	COM_ARTICULOS.ARTC_ARTICULO,
	COM_ARTICULOS.ARTC_DESCRIPCION 
FROM
	COM_FAMILIAS,
	COM_ARTICULOS 
WHERE
	ARTC_FAMILIA = FAMC_FAMILIA 
	AND COM_ARTICULOS.ARTN_ESTATUS = 1 
	AND COM_FAMILIAS.FAMC_FAMILIAPADRE = '$departamento'";
$st = oci_parse($conexion_central, $cadena);
    oci_execute($st);
    $row_producto = oci_fetch_row($st);
//SELECT id, codigo FROM detalle_categoria_codigos WHERE activo = '1' AND id_categoria = '$id_catalogo'

//$consulta = mysqli_query($conexion, $cadena);
$cuerpo   = "";
$numero   = 1;
while ($row_producto = oci_fetch_row($st)){
    //$cadena_consulta = "SELECT ARTC_DESCRIPCION FROM PV_ARTICULOS WHERE ARTC_ARTICULO = '$row[1]'"

    // $cadena2 = mysqli_query($conexion,"SELECT id FROM detalle_examen WHERE codigo = '$row[1]' AND activo = '1' AND id_examen = '$id_examen'");
    //   $cantidad = mysqli_num_rows($cadena2);
    //   if($cantidad == 0){
    //     $boton_seleccionar = "<button type='button' class='btn btn-default' id='boton_$numero' onclick='seleccionar($numero)'><i class='fa fa-check fa-lg' aria-hidden='true'></i></button><input id='selecciona_$numero' type='hidden' name='seleccionado[]' form='form_datos' value='0'> <input type='hidden' name='id_codigo[]' form='form_datos' value='$row_producto[1]' class='botones'>";
    //   }else{
    //     $boton_seleccionar ="<button type='button' class='btn btn-danger btn-sm' onclick='eliminar_codigo($row[1])'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";
    //   }
    $boton_seleccionar = "<button type='button' class='btn btn-default' id='boton_$numero' onclick='seleccionar($numero)'><i class='fa fa-check fa-lg' aria-hidden='true'></i></button><input id='selecciona_$numero' type='hidden' name='seleccionado[]' form='form_datos' value='0'> <input type='hidden' name='id_codigo[]' form='form_datos' value='$row_producto[1]' class='botones'>";
    $renglon = "
	{
        \"#\": \"$numero\",
        \"Codigo\": \"$row_producto[0]\",
        \"Descripcion\": \"$row_producto[1]\",
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