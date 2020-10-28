<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$folio = $_POST['folio'];
$cadena_consulta = "SELECT  ID, ARTC_ARTICULO, ARTC_DESCRIPCION, CANTIDAD_SOLICITA, CANTIDAD_SURTIDA FROM solicitud_traspasos WHERE FOLIO_PEDIDO='$folio'";
$consulta_detalle = mysqli_query($conexion,$cadena_consulta);


$i=0;
$cuerpo ="";
while ($row_consulta=mysqli_fetch_array($consulta_detalle)) {
   $cadenaExistencia = "SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, '99', '$row_consulta[1]') FROM dual";
   $consultaExistencia = oci_parse($conexion_central,$cadenaExistencia);
   oci_execute($consultaExistencia);
   $rowExistencia = oci_fetch_row($consultaExistencia);

   $liberar = "<div class='input-group' style='width:100%''><input type='number' id='id_$row_consulta[0]' class='form-control' value='$row_consulta[4]'><span class='input-group-btn'><button onclick='asignar_cant($row_consulta[0])' class='btn btn-danger' type='button'><i class='fa fa-save fa-lg' aria-hidden='true'></i></button></span></div>";
   $libera_renglon="<center><button onclick='asignar_cant($row_consulta[0])' class='btn btn-success'><i class='fa fa-check fa-lg' aria-hidden='true'></i></button></center>";
   $escape_desc = mysqli_real_escape_string($conexion,$row_consulta[2]);
   $renglon = "
		{
         \"codigo\":\"$row_consulta[1]\",
         \"descripcion\":\"$escape_desc\",
         \"existencia\":\"$rowExistencia[0]\",
         \"pedido\":\"$row_consulta[3]\",
         \"surtido\":\"$row_consulta[4]\",
         \"opciones\":\"$libera_renglon\"
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