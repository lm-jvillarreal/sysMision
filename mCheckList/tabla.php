<?php 
  include '../global_seguridad/verificar_sesion.php';

  $filtro=(!empty($registros_propios) == '1')?"AND id_usuario = '$id_usuario'":"";

  $cadena  = "SELECT
  id,
  nombre,
  ( SELECT nombre FROM sucursales WHERE sucursales.id = checklist.id_sucursal ),
  ( SELECT nombre FROM departamentos_checklist WHERE departamentos_checklist.id = checklist.id_departamento ),
CASE
    id_categoria 
    WHEN '1' THEN
    'Diario' 
    WHEN '2' THEN
    'Semanal' 
    WHEN '3' THEN
    'Quincenal' ELSE 'Mensual' 
  END AS id_categoria,
CASE
    tipo 
    WHEN '1' THEN
    'Calificacion' 
    WHEN '2' THEN
    'Check' 
  END AS tipo ,
  (SELECT nombre FROM perfil WHERE perfil.id = checklist.id_perfil)
FROM
  checklist 
WHERE
  activo = '1' ".$filtro;
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo   = "";
  $numero   = 1;

  while ($row = mysqli_fetch_array($consulta)) 
  {    
    $eliminar = "<button class='btn btn-danger' onclick='eliminar($row[0])'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";
    $editar   = "<button class='btn btn-warning' onclick='editar($row[0])'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></button>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Nombre\": \"$row[1]\",
      \"Sucursal\": \"$row[2]\",
      \"Departamento\": \"$row[3]\",
      \"Categoria\": \"$row[4]\",
      \"Calificar\": \"$row[5]\",
      \"Perfil\": \"$row[6]\",
      \"Editar\": \"$editar\",
      \"Eliminar\": \"$eliminar\"
      },";
    $cuerpo    = $cuerpo.$renglon;
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