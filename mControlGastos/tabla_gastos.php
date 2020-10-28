<?php
    include '../global_seguridad/verificar_sesion.php';

    $cadena = "SELECT id,folio,descripcion,fecha FROM control_gastos WHERE activo = '1'";
    $consulta = mysqli_query($conexion, $cadena);

    $cuerpo    = "";
    $numero    = 1;

  while ($row = mysqli_fetch_array($consulta)) 
  {
    $boton_eliminar = "<a onclick='eliminar_gasto($row[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a>";
    $boton_ver = "<a onclick='estilo_tablas1($row[1])' class='btn btn-danger'><i class='fa fa-eye fa-lg' aria-hidden='true'></i></a>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Descripcion\": \"$row[2]\",
      \"Fecha\": \"$row[3]\",
      \"Ver\": \"$boton_ver\",
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