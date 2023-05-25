<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

$filtro_registros_propios = ($registros_propios=='1')?" AND c.usuario='$id_usuario'":"";

$cadena_caducidad = "SELECT c.codigo_articulo, 
                            c.descripcion_articulo, 
                            s.nombre, 
                            DATE_FORMAT(c.fecha_caducidad,'%d/%m/%Y'), 
                            c.cantidad, 
                            c.lote,
                            c.sucursal,
                            c.fecha,
                            c.id
                    FROM far_medicamentosCaducan AS c 
                    INNER JOIN sucursales as s 
                    ON c.sucursal = s.id 
                    WHERE (c.estatus = '1' OR c.estatus = '2') AND c.cantidad>0 and sucursal = '5'".$filtro_registros_propios;

$consulta_caducidad = mysqli_query($conexion, $cadena_caducidad);
$cuerpo ="";
while ($row_caducidad = mysqli_fetch_array($consulta_caducidad)) {

    $cadena_consulta = "SELECT 
    (SELECT FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE FAM.FAMC_FAMILIAPADRE = COM_FAMILIAS.FAMC_FAMILIA AND ROWNUM =1) AS Departamento,
    FAM.FAMC_DESCRIPCION,
    COM_ARTICULOS.ARTC_ARTICULO, 
    COM_ARTICULOS.ARTC_DESCRIPCION
    FROM COM_ARTICULOS
    INNER JOIN COM_FAMILIAS FAM ON FAM.FAMC_FAMILIA = COM_ARTICULOS.ARTC_FAMILIA
    WHERE com_articulos.artc_articulo = '$row_caducidad[0]'";

    $st = oci_parse($conexion_central, $cadena_consulta);
    oci_execute($st);
    $row_producto = oci_fetch_row($st);
    $departamento = mysqli_real_escape_string($conexion, $row_producto[0]);
    $familia = mysqli_real_escape_string($conexion, $row_producto[1]);
    $descripcion = $row_producto[3];

    $escape_descripcion = mysqli_real_escape_string($conexion, $row_caducidad[1]);
    $traspaso = "<center><a href='#' data-id = '$row_caducidad[8]' data-suc = '$row_caducidad[6]' data-max = '$row_caducidad[4]' data-toggle = 'modal' data-target = '#modal-traspaso' class='btn btn-danger' target='blank'><i class='fa fa-refresh fa-lg' aria-hidden='true'></a></center>";
	$renglon = "
	{
		\"codigo\": \"$row_caducidad[0]\",
        \"descripcion\": \"$escape_descripcion\",
        \"depto\": \"$departamento\",
        \"familia\": \"$familia\",
        \"lote\": \"$row_caducidad[5]\",
        \"caducidad\": \"$row_caducidad[3]\",
        \"captura\": \"$row_caducidad[7]\",
        \"cantidad\": \"$row_caducidad[4]\",
        \"traspaso\": \"$traspaso\"
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