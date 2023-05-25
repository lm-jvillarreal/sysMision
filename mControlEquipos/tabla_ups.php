<?php 
    include '../global_seguridad/verificar_sesion.php';
    $filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
    // $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";

    $datos=array();
    $consulta = mysqli_query($conexion,"SELECT id, no_serie, (SELECT nombre FROM sucursales WHERE sucursales.id = equipo_ups.id_sucursal ),ubicacion, marca, modelo, tipo, capacidad, entrada_salida, tomacorrientes, tiempo_respaldo, garantia, series FROM equipo_ups WHERE activo = '1'");

    $cuerpo = "";
    $numero = 1;
  while ($row = mysqli_fetch_array($consulta)) 
  {
    $boton_eliminar="<button type='button' onclick='eliminar($row[0])' class='btn btn-danger btn-sm'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";
    $boton_editar="<button type='button' onclick='editar($row[0])' class='btn btn-warning btn-sm'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></button>";
    $botones = $boton_eliminar."&nbsp;".$boton_editar;
    array_push($datos,array(
      '#'=>$numero,
      'NoSerie'=>$row[1],
      'Sucursal'=>$row[2],
      'Ubicacion'=>$row[3],
      'Marca'=>$row[4],
      'Modelo'=>$row[5],
      'Tipo'=>$row[6],
      'Capacidad'=>$row[7],
      'EntradaSalida'=>$row[8],
      'TomaCorr'=>$row[9],
      'TR'=>$row[10],
      'Garantia'=>$row[11],
      'Series'=>$row[12],
      'Acciones'=>$botones

    ));
    $numero ++;
  }
  echo utf8_encode(json_encode($datos));
?>