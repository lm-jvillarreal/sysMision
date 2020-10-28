<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha = date('d/m/Y');
$hora=date ("h:i:s");

$artc_articulo = $_POST['artc_articulo'];

$cadenaOfertas = "SELECT
                    artc.AROC_ARTICULO as articulo,
                    (SELECT ARTC_DESCRIPCION FROM COM_ARTICULOS WHERE ARTC_ARTICULO='$artc_articulo') Descripcion,
                    confi.coon_id_oferta as Folio,
                    confi.cooc_descripcion as Descripcion,
                    (SELECT ALMC_NOMBRE FROM COM_ALMACENES WHERE almn_almacen=artc.aroc_sucursal) AS SUCURSAL,
                    artc.aron_porcdescuentooprecio as p_oferta,
                    to_char(confi.cood_vigencia_fin,'DD/MM/YYYY') as vigencia
                  FROM pv_configuracion_oferta  confi
                  INNER JOIN pv_articulos_oferta artc
                  ON confi.coon_id_oferta = artc.coon_id_oferta
                  AND confi.cood_vigencia_ini <= TO_DATE('$fecha','dd/mm/yyyy')
                  AND confi.cood_vigencia_fin >= TO_DATE('$fecha','dd/mm/yyyy')
                  AND artc.aroc_articulo = '$artc_articulo'
                  AND confi.coon_baja_sn = '0'
                  AND artc.aron_baja_sn = '0'
                  order by artc.aron_porcdescuentooprecio ASC";
$consultaOfertas = oci_parse($conexion_central, $cadenaOfertas);
oci_execute($consultaOfertas);

$cuerpo ="";

while ($rowOfertas = oci_fetch_row($consultaOfertas)) {
  $esc_articulo = mysqli_real_escape_string($conexion,$rowOfertas[1]);
  $esc_oferta = mysqli_real_escape_string($conexion,$rowOfertas[3]);
  $baja = "<a href='#' class='btn btn-danger' onclick='baja($rowOfertas[2])'><i class='fa fa-trash-o fa-lg' aria-hidden=true'></i></a>";
	$renglon = "
		{
      \"articulo\": \"$rowOfertas[0]\",
      \"descripcion\": \"$esc_articulo\",
      \"folio\": \"$rowOfertas[2]\",
      \"desc_oferta\": \"$esc_oferta\",
      \"sucursal\": \"$rowOfertas[4]\",
      \"precio_oferta\": \"$rowOfertas[5]\",
      \"vigencia\": \"$rowOfertas[6]\",
      \"baja\": \"$baja\"
		},";
	$cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');

$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>