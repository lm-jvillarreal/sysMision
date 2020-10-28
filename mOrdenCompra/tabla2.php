<?php 
    include '../global_seguridad/verificar_sesion.php';
    // $filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
    // $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";
  
    $folio = $_POST['folio'];
    $cadena  = "SELECT id_historial, cantidad, concepto, costo, importe 
                FROM historial_ordenes
	            WHERE folio = '$folio' AND activo = '1'";
    $consulta = mysqli_query($conexion, $cadena);

    $cuerpo = "";
    $numero = 1;
  while ($row = mysqli_fetch_array($consulta)) 
  {
    $boton_eliminar="<button type='button' onclick='eliminar_detalle($row[0])' class='btn btn-danger btn-sm'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";
    $boton_editar="<button type='button' onclick='editar_detalle($row[0])' class='btn btn-warning btn-sm'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></button>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Cantidad\": \"$row[1]\",
      \"Concepto\": \"$row[2]\",
      \"Costo\": \"$ $row[3]\",
      \"Importe\": \"$ $row[4]\",
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