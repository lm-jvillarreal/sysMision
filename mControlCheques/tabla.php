<?php
include '../global_seguridad/verificar_sesion.php';

$filtro=(!empty($registros_propios) == '1')?" AND usuario = '$id_usuario'":"";
$solo_suc = ($solo_sucursal == '1') ? " AND sucursal='$id_sede'" : "";

$cadena  = "SELECT
id,
banco,
terminacion,
empresa,
DATE_FORMAT(fecha_venta,'%d/%m/%Y'),
autoriza,
beneficiario,
monto,
nombre_cliente,
direccion_cliente,
telefono_cliente,
activo,
fecha 
FROM
control_cheques 
WHERE
activo = '1' ".$filtro.$solo_suc."
ORDER BY
fecha DESC";
  
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo         = "";

  while ($row_incidencias = mysqli_fetch_array($consulta)) 
  {
    $editar   = "<button class='btn btn-warning' onclick='editar($row_incidencias[0])'><i class='fa fa-edit fa-sm'></i></button>";
  	$eliminar = "<a class='btn btn-danger' onclick='estatus($row_incidencias[0])'><i class='fa fa-trash fa-sm'></i></a>";
    $renglon = "
      {
      \"id\":           \"$row_incidencias[0]\",
      \"banco\":        \"$row_incidencias[1]\",
      \"terminacion\":  \"$row_incidencias[2]\",
      \"empresa\":      \"$row_incidencias[3]\",
      \"fecha_venta\":  \"$row_incidencias[4]\",
      \"autoriza\":     \"$row_incidencias[5]\",
      \"beneficiario\": \"$row_incidencias[6]\",
      \"monto\":        \"$row_incidencias[7]\",
      \"cliente\":      \"$row_incidencias[8]\",
      \"direccion\":    \"$row_incidencias[9]\",
      \"telefono\":     \"$row_incidencias[10]\",
      \"eliminar\":     \"$eliminar\",
      \"editar\":       \"$editar\",
      \"fecha\":        \"$row_incidencias[12]\"
      },";
    $cuerpo = $cuerpo.$renglon;
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
  ["
  .$cuerpo2.
  "]
  ";
  echo $tabla;
 ?>