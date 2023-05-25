<?php
include '../global_settings/conexion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha=date("Y-m-d"); 
  $hora=date ("h:i:s");
  $prefijo = date("Y").date("m").date("d");

  $cadena_turnos = "SELECT t.id,
													(SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM pacientes WHERE id = c.id_pacientes),
													CONCAT(date_format(t.fecha,'%d/%m/%Y'),' ',t.hora,' - ',c.hora),
													t.consecutivo, 
													t.prefijo 
										FROM turnos as t
										INNER JOIN consulta AS c ON t.consecutivo = c.turno 
										WHERE t.fecha = '$fecha' AND c.fecha = '$fecha'";
						
	//Restricción para una sola verificación
	//AND lista_proyectos.verificado='0'
 //echo $cadena_modulos;
 $consulta_turnos = mysqli_query($conexion, $cadena_turnos);
 $cuerpo = "";
 
while ($row_turnos = mysqli_fetch_array($consulta_turnos)) {
	$imprimir= "<button onclick='reimpresion($row_turnos[3],$row_turnos[4]);' type='button' class='btn btn-warning text-center'>Imprimir</button>";
	$renglon = "
	{
		\"id\": \"$row_turnos[0]\",
		\"fecha\": \"$row_turnos[2]\",
		\"paciente\": \"$row_turnos[1]\",
		\"consecutivo\": \"$row_turnos[3]\", 
		\"imprimir\": \"$imprimir\"
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
