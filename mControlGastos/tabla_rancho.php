<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');
  
  $cadena  = "SELECT id,nombre_rancho,CASE
                tipo 
                WHEN '1' THEN
                'Rancho' 
                WHEN '2' THEN
                'Huerta' 
                ELSE 'Local'
              END AS tipo,
              CASE
                estado 
                WHEN '1' THEN
                'N.L' 
                WHEN '2' THEN
                'Tamps'
              END AS estado,
              CASE
                municipio 
                WHEN '1' THEN
                'Linares' 
                WHEN '2' THEN
                'Gral. Teran'
                ELSE 'Villagran'
              END AS municipio,
              encargado FROM ranchos WHERE activo = '1'";
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo = "";
  $numero = 1;
  $activo = "";

  while ($row_marca = mysqli_fetch_array($consulta)) 
  {
    $boton_eliminar="<a onclick='eliminar_rancho($row_marca[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a>";
    $boton_editar="<a onclick='editar_rancho($row_marca[0])' class='btn btn-warning'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></a>";
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Nombre\": \"$row_marca[1]\",
      \"Tipo\": \"$row_marca[2]\",
      \"Estado\": \"$row_marca[3]\",
      \"Municipio\": \"$row_marca[4]\",
      \"Encargado\": \"$row_marca[5]\",
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