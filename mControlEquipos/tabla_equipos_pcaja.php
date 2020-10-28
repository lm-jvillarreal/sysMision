<?php 
  include '../global_seguridad/verificar_sesion.php';
  $filtro=(!empty($registros_propios) == '1')?" AND detalle_caja.id_usuario = '$id_usuario'":"";
  
  $id_caja = $_POST['id_caja'];
  $cadena  = "SELECT detalle_caja.id, cajas_catalogo_equipos.nombre, cajas_catalogo_equipos.descripcion, detalle_caja.tipo 
              FROM detalle_caja 
              INNER JOIN cajas_catalogo_equipos ON cajas_catalogo_equipos.id = detalle_caja.id_equipo
              WHERE detalle_caja.activo = '1' AND detalle_caja.id_caja = '$id_caja'".$filtro;
  // echo $cadena;
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo = "";
  $numero = 1;
  $activo = "";
  while ($row = mysqli_fetch_array($consulta)) 
  {
    $boton_eliminar="<button type='button' onclick='eliminar_equipo($row[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";
    $boton_editar="<button type='button' onclick='editar_equipo($row[0])' class='btn btn-warning'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></button>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Nombre\": \"$row[1]\",
      \"Descripcion\": \"$row[2]\",
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