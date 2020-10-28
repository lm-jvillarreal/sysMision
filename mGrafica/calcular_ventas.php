<?php
include '../global_seguridad/verificar_sesion.php'; 
 $fecha1 = $_POST['fecha1'];
 $fecha2  = $_POST['fecha2'];

$medicamento= "SELECT surtido FROM receta WHERE fecha BETWEEN '$fecha1' AND '$fecha2'";
$consulta = mysqli_query($conexion, $medicamento);
$cantidad_total = mysqli_num_rows($consulta);

$no_surtidos = 0;
$surtidos = 0;
while ($row = mysqli_fetch_array($consulta)) {
  if ($row[0]==0) {

    $no_surtidos += 1;
  }
  else{
    $surtidos += 1;
  }
 }

 if ($surtidos==0) {
 	$porciento=0;

 }
 else {

 	$porciento= $surtidos * 100 / $cantidad_total;
 	$porciento = round($porciento,1);

 }

$array_resultado = array($surtidos,$no_surtidos,$porciento);

$array = json_encode($array_resultado);


 echo $array;



// echo "Fecha Inicio: ".$fecha1.'<br>';
// echo "Fecha final: ".$fecha2.'<br>';
?>