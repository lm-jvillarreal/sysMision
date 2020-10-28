<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');
  
  $cadena  = "SELECT id,marca,CASE
                id_equipo 
                WHEN '1' THEN
                'Terminal' 
                WHEN '2' THEN
                'Escaner' 
                ELSE 'Otro'
              END AS id_equipo FROM marcas WHERE activo = '1'";
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo = "";
  $numero = 1;
  $activo = "";

  while ($row_marca = mysqli_fetch_array($consulta)) 
  {
    $boton_eliminar="<a onclick='eliminar_marca($row_marca[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a>";
    $boton_editar="<a onclick='editar_marca($row_marca[0])' class='btn btn-warning'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></a>";
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Nombre\": \"$row_marca[1]\",
      \"Equipo\": \"$row_marca[2]\",
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