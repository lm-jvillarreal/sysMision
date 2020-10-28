<?php 
    include '../global_seguridad/verificar_sesion.php';
    // $filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
    // $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";
  
    $cadena  = "SELECT
                  id_sal,
                  orden_trabajo,
                  solicitante,
                  DATE_FORMAT(fecha, '%d-%m-%Y'),
                  (SELECT nombre FROM sucursales WHERE sucursales.id = salidas.id_sucursal),
                  area,
                  comentarios,
                  referencia
                FROM salidas
                WHERE activo = '1'
                ORDER BY folio DESC";
    $consulta = mysqli_query($conexion, $cadena);

    $cuerpo = "";
    $numero = 1;
  while ($row = mysqli_fetch_array($consulta)) 
  {
    $comentario = mysqli_real_escape_string($conexion, $row[6]);
    // $boton_eliminar="<center><button type='button' onclick='eliminar($row[0])' class='btn btn-danger btn-sm'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button></center>";
    // $boton_editar="<center><button type='button' onclick='editar($row[0])' class='btn btn-warning btn-sm'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></button></center>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"OrdenT\": \"$row[1]\",
      \"Solicitante\": \"$row[2]\",
      \"Fecha\": \"$row[3]\",
      \"Sucursal\": \"$row[4]\",
      \"Area\": \"$row[5]\",
      \"Comentarios\": \"$comentario\",
      \"Referencias\": \"$row[7]\"
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