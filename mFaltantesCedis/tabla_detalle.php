<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$folio = $_POST['folio'];
$cadena_consulta = "SELECT  ID, ARTC_ARTICULO, ARTC_DESCRIPCION, CANTIDAD_SOLICITA, CANTIDAD_SURTIDA, FOLIO_TRASPASO FROM solicitud_traspasos WHERE FOLIO_PEDIDO='$folio'";
$consulta_detalle = mysqli_query($conexion,$cadena_consulta);


$i=0;
$cuerpo ="";
while ($row_consulta=mysqli_fetch_array($consulta_detalle)) {
   $cadenaTraspaso = "SELECT rtrn_cantidad_salida, rtrn_cantidad_entrada FROM INV_RENGLONES_TRANSFERENCIA WHERE tran_id_consecutivo='$row_consulta[5]' AND ARTC_ARTICULO='$row_consulta[1]'";
   $consultaTraspaso = oci_parse($conexion_central,$cadenaTraspaso);
   oci_execute($consultaTraspaso);
   $rowTraspaso = oci_fetch_row($consultaTraspaso);


   $escape_desc = mysqli_real_escape_string($conexion,$row_consulta[2]);
   $renglon = "
		{
         \"codigo\":\"$row_consulta[1]\",
         \"descripcion\":\"$escape_desc\",
         \"pedido\":\"$row_consulta[3]\",
         \"salida\":\"$rowTraspaso[0]\",
         \"entrada\":\"$rowTraspaso[1]\"
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