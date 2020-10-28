<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  
  
  if(!empty($_POST['folio']))
  {
    $folio = $_POST['folio'];
  }
  else
  {
    $folio = 0;
  }
  
  $cadena  = "SELECT moneda,faltante,valor FROM faltantes WHERE folio = '$folio'";
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo = "";
  $numero = 1;

  while ($row = mysqli_fetch_array($consulta)) 
  {
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Moneda\": \"$row[0]\",
      \"Faltante\": \"$row[1]\",
      \"Valor\": \"$row[2]\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
  ["
  .$cuerpo2.
  "]
  ";
  echo $tabla;

 ?>