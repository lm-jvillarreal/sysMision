<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');

  $id_usuario = $_POST['id_usuario'];

  $cadena  = "SELECT DISTINCT(folio),comentarios FROM historico_vacaciones WHERE id_usuario = '$id_usuario' AND activo = '1'";
  
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo    = "";
  $numero    = 1;
  $fecha_fin = "";
  while ($row = mysqli_fetch_array($consulta)) 
  {
    $cadena2 = mysqli_query($conexion,"SELECT MIN(fecha_vacaciones),MAX(fecha_vacaciones) FROM historico_vacaciones WHERE folio = '$row[0]' AND activo = '1'");
    $row2 = mysqli_fetch_array($cadena2);
    $fecha_fin = ($row2[1] == "")?$row2[0]:$row2[1];

    $cadena3  = mysqli_query($conexion,"SELECT id FROM historico_vacaciones WHERE folio = '$row[0]' AND activo = '1'");
    $cantidad = mysqli_num_rows($cadena3);
    
    if($row[0] != ""){
      $boton_eliminar = "<button class='btn btn-danger' onclick='eliminar($row[0])'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";
      $boton_editar   = "<button class='btn btn-warning' onclick='editar($row[0])'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></button>";
      $renglon = "
        {
        \"#\": \"$numero\",
        \"Fecha Inicio\": \"$row2[0]\",
        \"Fecha Final\": \"$fecha_fin\",
        \"Cantidad Dias\": \"$cantidad\",
        \"Comentarios\": \"$row[1]\",
        \"Editar\": \"$boton_editar\",
        \"Eliminar\": \"$boton_eliminar\"
        },";
      $cuerpo = $cuerpo.$renglon;
      $numero ++;
      $invitados = "";
    }
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
  ["
  .$cuerpo2.
  "]
  ";
  echo $tabla;

 ?>