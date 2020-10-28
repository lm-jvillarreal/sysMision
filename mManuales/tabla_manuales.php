<?php 
  include '../global_seguridad/verificar_sesion.php';
  $filtro=(!empty($registros_propios) == '1')?"AND id_usuario = '$id_usuario'":"";
  
  $cadena  = "SELECT id,nombre,descripcion,categoria,ruta
              FROM manuales                
              WHERE activo = '1' ".$filtro;
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo = "";
  $numero = 1;
  $activo = "";

  while ($row = mysqli_fetch_array($consulta)) 
  {
    $boton_eliminar = "<a onclick='eliminar($row[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a>";
    $boton_editar   = "<a class='btn btn-warning' onclick='editar_registro($row[0])'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></a>";
    $boton_ver      = "<a class='btn btn-primary' href='$row[4]' target='_blank'><i class='fa fa-eye fa-lg' aria-hidden='true'></i></a>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Nombre\": \"$row[1]\",
      \"Descripcion\": \"$row[2]\",
      \"Categoria\": \"$row[3]\",
      \"Editar\": \"$boton_editar\",
      \"Eliminar\": \"$boton_eliminar\",
      \"Ver\": \"$boton_ver\"
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