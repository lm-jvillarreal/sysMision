<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_sucursales.php';

$folio = $_POST['folio'];
$tipo_mov = $_POST['tipo_mov'];

if($id_sede=='1'){
    $conexion_sucursal=$conexion_do;
}elseif($id_sede=='2'){
    $conexion_sucursal=$conexion_arb;
}elseif($id_sede=='3'){
    $conexion_sucursal=$conexion_vill;
}elseif($id_sede=='4'){
    $conexion_sucursal=$conexion_all;
}elseif($id_sede=='5'){
    $conexion_sucursal=$conexion_lp;
}
if($tipo_mov=='O'){
    $cadena_folio = "SELECT  COOC_DESCRIPCION, cood_vigencia_fin
    FROM pvs_configuracion_oferta WHERE COON_ID_OFERTA = '$folio'";
}elseif($tipo_mov=='C'){
    $cadena_folio = "SELECT IARC_DESCRIPCION, iard_fecha_autorizacion 
    FROM pvs_importacion_articulos 
    WHERE iarn_id_importacion = '$folio'";
}

$sr_folio = oci_parse($conexion_sucursal, $cadena_folio);
oci_execute($sr_folio);

$row_folio = oci_fetch_row($sr_folio);

$array_datos  = array(		
    $row_folio[0],//Sucursal
    $row_folio[1] //Proveedor
);
$array_completo = json_encode($array_datos);
echo $array_completo;
?>
