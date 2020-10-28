<?php
include "../global_seguridad/verificar_sesion.php";

date_default_timezone_set('America/Monterrey');
$anio = date("Y");

$sucursal = $_POST['sucursal'];
$folio_inicial = $_POST['folio_inicial'];
$folio_final = $_POST['folio_final'];

$cadena_datos = "SELECT tiraje_boletos, boletos_block, id FROM configuracion_sorteos WHERE anio = '$anio' AND activo = '1'";
$consulta_datos = mysqli_query($conexion, $cadena_datos);
$row_datos = mysqli_fetch_array($consulta_datos);
//echo $cadena_datos;
$tiraje = $row_datos[0];
$boletos_block = $row_datos[1];

if($folio_inicial >= 1 AND $folio_final <= $tiraje){

    $cadena_validar = "SELECT 0 FROM dispersion_boletos WHERE (folio_inicial <= '$folio_inicial' AND folio_final >= '$folio_inicial') OR folio_final >= '$folio_final' AND anio = '$anio' AND activo = '1' AND id_sorteo = '$row_datos[2]' LIMIT 1";
    $consulta_validar = mysqli_query($conexion, $cadena_validar);
    //echo $cadena_validar;
    $row_validar = mysqli_fetch_array($consulta_validar);
    if($row_validar[0] >= 1){
        echo "rango_asignado";
    }else{
        //Aqui se calcula los valores
       $cantidad = $folio_final - $folio_inicial +1;
       $blocks = $cantidad / $boletos_block;
       $porcentaje = ($cantidad/$tiraje)*100;

        $array=array(
            $blocks,
            $porcentaje
        );
        $array_datos = json_encode($array);
        echo $array_datos;
    }

}else{
    echo "rango_invalido";
}
?>