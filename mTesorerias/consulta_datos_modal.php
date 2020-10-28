<?php
include '../global_seguridad/verificar_sesion.php';

  $folio          = $_POST['folio'];
  $prestamo_total = 0;
  $abonos         = 0;
  $restante       = 0;

  $cadena = mysqli_query($conexion,"SELECT SUM(resultado),semana FROM prestamos_morralla WHERE folio = '$folio'");

  $row_resultado  = mysqli_fetch_array($cadena);
  $prestamo_total = $row_resultado[0];

  $cadena2      = mysqli_query($conexion,"SELECT SUM(abono) FROM abonos WHERE folio = '$folio'");
  $cantidad     = mysqli_num_rows($cadena2);
  $row_restante = mysqli_fetch_array($cadena2);
  
  if ($cantidad == 0){
    $abonos = 0;
  }
  else{
    $abonos = $row_restante[0];
  }

  $operacion = $prestamo_total - $abonos;

  $restante = sprintf('%0.2f', $operacion);

  $array2 = array(
  	$row_resultado[1], //Semana
  	'$ '.$prestamo_total, //Prestamo Total
  	'$ '.$restante //Prestamo Restante
  	);

  $array = json_encode($array2);
  echo "$array";
?>