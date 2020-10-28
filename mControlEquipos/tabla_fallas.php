<?php 
  include '../global_seguridad/verificar_sesion.php';
  
  $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";
  
  $cadena  = "SELECT id, nombre FROM fallas_equipos WHERE activo = '1'";
  $consulta = mysqli_query($conexion, $cadena);

    $cuerpo = "";
    $numero = 1;
    $activo = "";
  while ($row = mysqli_fetch_array($consulta)) 
  {
      $boton_eliminar="<center><button type='button' onclick='eliminar_falla($row[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button></center>";
      $boton_editar="<center><button type='button' onclick='editar_falla($row[0])' class='btn btn-warning'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></button></center>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Falla\": \"$row[1]\",
      \"Editar\": \"$boton_editar\",
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