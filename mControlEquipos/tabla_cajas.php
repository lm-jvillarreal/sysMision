<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');
  
  $cadena  = "SELECT id,nombre,(SELECT nombre FROM sucursales WHERE sucursales.id = cajas.id_sucursal),CASE
  id_tipo_caja WHEN '1' THEN 'Caja' WHEN '2' THEN 'Administrativa' END AS id_tipo_caja FROM cajas WHERE activo = '1' ORDER BY nombre ASC";
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo = "";
  $numero = 1;
  $activo = "";

  while ($row = mysqli_fetch_array($consulta)) 
  {
    $boton_eliminar="<a onclick='eliminar_caja($row[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a>";
    $boton_editar="<a onclick='editar_caja($row[0])' class='btn btn-warning'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></a>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Sucursal\": \"$row[2]\",
      \"Caja\": \"$row[1]\",
      \"Tipo\": \"$row[3]\",
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