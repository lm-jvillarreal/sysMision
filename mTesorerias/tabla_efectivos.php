<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');

  $filtro=(!empty($registros_propios) == '1')?"AND id_usuario = '$id_usuario'":"";

  if(!empty($_POST['folio']))
  {
    $folio = $_POST['folio'];
  }
  else
  {
    $folio = 0;
  }
  
  
  $cadena  = "SELECT efectivos.id, 
                     efectivos.folio,
                     CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno) AS nombreP,
                     sucursales.nombre,
                     efectivos.fecha,
                     efectivos.hora,
                     efectivos.fecha_creacion,
                     efectivos.total_efectivos,
                     efectivos.tarjetas_credito,
                     efectivos.total_t,
                     efectivos.b_total,
                     efectivos.id_sucursal
              FROM efectivos
              INNER JOIN usuarios ON usuarios.id = efectivos.id_usuario
              INNER JOIN personas ON usuarios.id_persona = personas.id
              INNER JOIN sucursales ON sucursales.id = efectivos.id_sucursal
              AND efectivos.activo = '1'".$filtro."
              ORDER BY efectivos.id DESC";
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo = "";
  $numero = 1;
  $clase  = "";

  while ($row_efectivo = mysqli_fetch_array($consulta)) 
  {
    $total_general = $row_efectivo[7] + $row_efectivo[8] + $row_efectivo[9] + $row_efectivo[10];
    
    $clase=($row_efectivo[6] != $fecha_actual)?"disabled":"";

    $editar = "<a onclick='editar_efectivos($row_efectivo[1])' class='btn btn-warning ".$clase."'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></a>";

    $eliminar = "<a onclick='mensaje_eliminar($row_efectivo[1])' class='btn btn-danger ".$clase."'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a>";

    $fechanueva = new DateTime ("$row_efectivo[4]");
    $fecha = $fechanueva->format ("d-m-Y");

    $ver ="<a onclick='ver_efectivos($row_efectivo[1])' class='btn btn-primary'><i class='fa fa-eye fa-lg' aria-hidden='true'></i></a>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Folio\": \"$row_efectivo[1]\",
      \"Usuario\": \"$row_efectivo[2]\",
      \"Sucursal\": \"$row_efectivo[3]\",
      \"Total_general\": \"$ $total_general\",
      \"Fecha\": \"$fecha\",
      \"Hora\": \"$row_efectivo[5]\",
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