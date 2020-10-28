<?php
	include '../global_seguridad/verificar_sesion.php';

  $id_promotor = $_POST['id_promotor'];
  $fechaBD     = $_POST['fecha'];

  $cadena = mysqli_query($conexion,"SELECT hora_entrada,hora_salida,id FROM registro_entrada WHERE id_promotor = '$id_promotor' AND fecha = '$fechaBD' AND id_sucursal = '$id_sede'");
  $row = mysqli_fetch_array($cadena);

  $cadena_cajas = mysqli_query($conexion,"SELECT SUM(registro_actividades.cajas_surtidas),COUNT(*)
                FROM registro_actividades
                INNER JOIN actividades_promotor ON actividades_promotor.id = registro_actividades.id_actividad
                WHERE actividades_promotor.id_promotor = '$id_promotor' AND registro_actividades.fecha = '$fechaBD' AND registro_actividades.id_sucursal = '$id_sede'");
    $row_cajas = mysqli_fetch_array($cadena_cajas);
    $cantidad_cajas       = ($row_cajas[0] != "")?$row_cajas[0]:0;

  $cadena2 = mysqli_query($conexion,"SELECT COUNT(*) FROM registro_actividades INNER JOIN actividades_promotor ON actividades_promotor.id =  registro_actividades.id_actividad WHERE actividades_promotor.id_promotor = '$id_promotor' AND registro_actividades.fecha = '$fecha'");
  $row2 = mysqli_fetch_array($cadena2);
  $cantidad = $row2[0];

  $array = array($row[0],$row[1],$cantidad_cajas,$row[2],$cantidad);
  echo json_encode($array);
?>
