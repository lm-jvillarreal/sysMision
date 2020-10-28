<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");
$cadena_consultas = " SELECT c.id, 
															c.turno, 
															CONCAT(p.nombre,' ',p.ap_paterno,' ',p.ap_materno) as Paciente,
															CONCAT(p.edad,' años'),
															c.malestar,
															c.diagnostico,
															date_format(c.fecha,'%d/%m/%Y') as Fecha,
															p.id
													FROM consulta as c INNER JOIN pacientes as p ON c.id_pacientes = p.id
													WHERE c.fecha = '$fecha'
													order by c.id desc";

$consulta_consultas = mysqli_query($conexion, $cadena_consultas);
$cuerpo = "";
while ($row_consultas = mysqli_fetch_array($consulta_consultas)) {
	
	$editar= "<center><a href='receta.php?id=$row_consultas[0]&id_paciente=$row_consultas[7]' class='btn btn-danger'><i class='fa fa-edit'></i></a></center>";

	$escape_paciente = mysqli_real_escape_string($conexion, $row_consultas[2]);
	$renglon = "
	{
		\"turno\": \"$row_consultas[1]\",
		\"paciente\": \"$escape_paciente\",
		\"edad\": \"$row_consultas[3]\", 
		\"malestar\": \"$row_consultas[4]\",
		\"diagnostico\": \"$row_consultas[5]\", 
		\"fecha\": \"$row_consultas[6]\",
		\"editar\": \"$editar\"
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
