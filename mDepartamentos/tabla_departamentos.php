<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');
  
  $cadena  = "SELECT d.id,d.nombre,d.clave_departamento,d.abreviatura,a.nombre FROM departamentos d LEFT JOIN agrupaciones a ON a.id = d.id_agrupacion WHERE d.activo = '1'";
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo = "";
  $numero = 1;
  $activo = "";

  while ($row_departamentos = mysqli_fetch_array($consulta)) 
  {
  	$editar = "<a class='btn btn-warning' href='editar_departamento.php?id=$row_departamentos[0]'>Editar</a>";
  	$eliminar = "<a class='btn btn-danger' onclick='mensaje($row_departamentos[0])'>Eliminar</a>";
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Nombre\": \"$row_departamentos[1]\",
      \"Clave\": \"$row_departamentos[2]\",
      \"Abreviatura\": \"$row_departamentos[3]\",
      \"Agrupacion\": \"$row_departamentos[4]\",
      \"Editar\": \"$editar\",
      \"Eliminar\": \"$eliminar\"
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
