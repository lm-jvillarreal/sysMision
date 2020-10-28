<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');
  
  $cadena  = "SELECT id,nombre,descripcion,categoria,ruta
              FROM manuales                
              WHERE activo = '1'";
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo = "";
  $numero = 1;
  $activo = "";

  while ($row = mysqli_fetch_array($consulta)) 
  {
    $boton_eliminar = "<a onclick='eliminar($row[0])' class='btn btn-danger'>Eliminar</a>";
    $boton_editar   = "<a class='btn btn-warning' onclick='editar_registro($row[0])'>Editar</a>";
    $boton_ver      = "<a class='btn btn-danger' onclick='abrir($row[0])'>Seleccionar</a>";

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