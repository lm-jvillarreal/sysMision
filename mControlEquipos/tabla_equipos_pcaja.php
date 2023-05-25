<?php 
  include '../global_seguridad/verificar_sesion.php';
  $filtro=(!empty($registros_propios) == '1')?" AND detalle_caja.id_usuario = '$id_usuario'":"";
  
  $id_caja = $_POST['id_caja'];
  $cadena  = "SELECT detalle_caja.id, tipos_equipos.nombre, detalle_caja.tipo 
              FROM detalle_caja
	            INNER JOIN tipos_equipos ON tipos_equipos.id_tipo = detalle_caja.id_equipo 
              WHERE detalle_caja.activo = '1'  AND detalle_caja.id_caja = '$id_caja'";
              // .$filtro;
  // echo $cadena;
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo = "";
  $numero = 1;
  $activo = "";
  while ($row = mysqli_fetch_array($consulta)) 
  {
    $boton_eliminar="<button type='button' onclick='eliminar_equipo($row[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";
    $boton_editar="<button type='button' onclick='editar_equipo($row[0])' class='btn btn-warning'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></button>";

    array_push($datos, array(
      '#'=>$numero,
      'Nombre'=>$row[1],
      'Editar'=>$boton_editar,
      'Eliminar'=>$boton_eliminar
    ));
    // $renglon = "
    //   {
    //   \"#\": \"$numero\",
    //   \"Nombre\": \"$row[1]\",
    //   \"Editar\": \"$boton_editar\",
    //   \"Eliminar\": \"$boton_eliminar\"
    //   },";
    // $cuerpo = $cuerpo.$renglon;
    $numero ++;
  }
  // $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  // $tabla = "
  //   ["
  //   .$cuerpo2.
  //   "]
  //   ";
  // echo $tabla;
  echo utf8_encode(json_encode($datos));
?>