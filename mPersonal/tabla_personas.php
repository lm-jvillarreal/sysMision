
<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$cadena_personas = "SELECT p.id,
	CONCAT(p.nombre, ' ',p.ap_paterno,' ',p.ap_materno), p.e_mail, p.telefono, date_format(p.fecha_nac, '%d/%m/%Y'),
    p.actualizado, perfil.nombre
    FROM personas as p 
    INNER JOIN usuarios as u ON p.id = u.id_persona
    INNER JOIN perfil ON u.id_perfil = perfil.id";
$consulta_personas = mysqli_query($conexion, $cadena_personas);

$cuerpo ="";

while ($row_personas = mysqli_fetch_array($consulta_personas)) {
	if ($row_personas[5]=='0') {
		$actualizado = "<center><span class='label label-danger'>Pendiente</span></center>";
	}elseif($row_personas[5]=='1'){
		$actualizado = "<center><span class='label label-success'>Actualizado</span></center>";
	}
	$renglon = "
		{
		\"id\": \"$row_personas[0]\",
		\"nombre\": \"$row_personas[1]\",
		\"telefono\": \"$row_personas[3]\",
		\"correo\": \"$row_personas[2]\",
		\"fecha_nac\": \"$row_personas[4]\",
		\"perfil\": \"$row_personas[6]\",
		\"actualizado\": \"$actualizado\"
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