<?php
    include '../global_seguridad/verificar_sesion.php';

    $folio = $_POST['folio'];

    $cadena = "SELECT id,uuid,rfc_emisor,nombre_emisor,fecha_emision,fecha_certificacion_sat,monto,efecto_comprobante FROM detalle_control_gastos WHERE activo = '1' AND folio = '$folio'";
    $consulta = mysqli_query($conexion, $cadena);

    $cuerpo    = "";
    $numero    = 1;

  while ($row = mysqli_fetch_array($consulta)) 
  {
    $boton_eliminar = "<a onclick='eliminar_gasto($row[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a>";
    $monto = number_format($row[6], 0, '.', ',');
    $fecha_emision = substr($row[4],0, 19);
    $fcs = substr($row[5],0, 19);

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Uuid\": \"$row[1]\",
      \"RFCE\": \"$row[2]\",
      \"NEmisor\": \"$row[3]\",
      \"FEmision\": \"$fecha_emision\",
      \"FCS\": \"$fcs\",
      \"Monto\": \"$$monto\",
      \"EC\": \"$row[7]\",
      \"Eliminar\": \"$boton_eliminar\"
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