<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');

  if(!empty($_POST['folio']))
  {
    $folio = $_POST['folio'];
  }
  else
  {
    $folio = 0;
  }
  
  
  $cadena  = "SELECT faltantes.id, faltantes.folio,CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno) AS nombreP,sucursales.nombre,faltantes.fecha,faltantes.hora,faltantes.fecha_creacion
              FROM faltantes
              INNER JOIN usuarios ON usuarios.id = faltantes.id_usuario
              INNER JOIN personas ON usuarios.id_persona = personas.id
              INNER JOIN sucursales ON sucursales.id = faltantes.id_sucursal
              WHERE id_usuario = '$id_usuario'
              AND faltantes.activo = '1'
              GROUP BY faltantes.folio";
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo = "";
  $numero = 1;

  while ($row_faltante = mysqli_fetch_array($consulta)) 
  {
    $editar=($row_faltante[6] != $fecha_actual)?"<i class='ion-minus-circled fa-2x color-icono rojo' aria-hidden='true'></i>":"<a href='editar_faltante.php?folio=$row_faltante[1]'><i class='ion-edit fa-2x color-icono rojo'></i></a>";

    $eliminar=($row_faltante[1] == $folio)?"<i class='ion-minus-circled fa-2x color-icono rojo' aria-hidden='true'></i>":"<a onclick='men($row_faltante[1])'><i class='glyphicon glyphicon-trash fa-2x color-icono rojo' aria-hidden='true'></i></a>";

    $fechanueva = new DateTime ("$row_faltante[4]");
    $fecha = $fechanueva->format ("d-m-Y");

    $ver = ($row_faltante[1] == $folio)?"<i class='ion-minus-circled fa-2x color-icono rojo' aria-hidden='true'></i>":"<a href='ver_faltante.php?folio=$row_faltante[1]'><i class='ion-clipboard fa-2x color-icono rojo' aria-hidden='true'></i></a>";


    $renglon = "
      {
      \"#\": \"$numero\",
      \"Folio\": \"$row_faltante[1]\",
      \"Usuario\": \"$row_faltante[2]\",
      \"Sucursal\": \"$row_faltante[3]\",
      \"Fecha\": \"$fecha\",
      \"Hora\": \"$row_faltante[5]\",
      \"Editar\": \"$editar\",
      \"Eliminar\": \"$eliminar\",
      \"Ver\": \"$ver\"
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