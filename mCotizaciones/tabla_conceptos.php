<?php 
  include '../global_seguridad/verificar_sesion.php';

  $id_cotizacion = $_POST['id_cotizacion'];

  $cadena = mysqli_query($conexion,"SELECT id, nombre FROM conceptos_cotizacion WHERE activo = '1' AND id_cotizacion = '$id_cotizacion'");
  $cuerpo = "";
  $numero = 1;

  while($row = mysqli_fetch_array($cadena)){
    $boton_eliminar = "<a onclick='eliminar_concepto($row[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a>";
    $boton_editar   = "<a class='btn btn-warning' onclick='editar_concepto($row[0])'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></a>";
    
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Nombre\": \"$row[1]\",
      \"Editar\": \"$boton_editar\",
      \"Eliminar\": \"$boton_eliminar\"
      },";
    $cuerpo    = $cuerpo.$renglon;
    $numero ++;
    # Sumar el incremento para que en algún momento termine el ciclo
  }

  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
  ["
  .$cuerpo2.
  "]
  ";
  echo $tabla;

 ?>