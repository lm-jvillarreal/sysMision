<?php
include '../global_seguridad/verificar_sesion.php';

$folio = $_POST['folio'];
$cadena_consulta = "SELECT ARTC_ARTICULO, ARTC_DESCRIPCION, ARTC_UNIDADMEDIDA, CANTIDAD, ID, CANTIDAD_SURTIDA FROM pv_renglonespedido WHERE ID_PEDIDO='$folio'";
$consulta_detalle = mysqli_query($conexion,$cadena_consulta);


$i=0;
$cuerpo ="";
while ($row_consulta=mysqli_fetch_array($consulta_detalle)) {
   $liberar = "<div class='input-group' style='width:100%''><input type='number' id='id_$row_consulta[4]' class='form-control' value='$row_consulta[5]'><span class='input-group-btn'><button onclick='asignar_cant($row_consulta[4])' class='btn btn-danger' type='button'><i class='fa fa-save fa-lg' aria-hidden='true'></i></button></span></div>";
	$renglon = "
		{
         \"codigo\":\"$row_consulta[0]\",
         \"descripcion\":\"$row_consulta[1]\",
         \"um\":\"$row_consulta[2]\",
         \"cantidad\":\"$row_consulta[3]\",
         \"opciones\":\"$liberar\"
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