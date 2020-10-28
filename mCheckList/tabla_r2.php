<?php 
  include '../global_seguridad/verificar_sesion.php';

  $checklist = $_POST['checklist'];
  $sucursal  = $_POST['sucursal'];
  
  $fecha1  = $_POST['fecha1'];
  $fecha2  = $_POST['fecha2'];

  $cuerpo   = "";
  $numero   = 1;
  $promedio = 0;

  if(empty($checklist) || empty($sucursal)){
    echo "[]";
    return false;
  }

  //Restaurante
  $filtro_restaurante = ($sucursal == 1 || $sucursal == 3)?"AND sub_departamentos.id != '60'":"";

  $cadena = mysqli_query($conexion,"SELECT sub_departamentos.id, sub_departamentos.nombre 
                                    FROM sub_departamentos
	                                  INNER JOIN detalle_checklist ON detalle_checklist.id_subdepartamento = sub_departamentos.id 
                                    WHERE sub_departamentos.activo = '1' AND detalle_checklist.activo = '1' 
                                    AND detalle_checklist.id_checklist = '$checklist'".$filtro_restaurante."
                                    GROUP BY sub_departamentos.id");

  while ($row = mysqli_fetch_array($cadena)){
    $cadena2 = mysqli_query($conexion,"SELECT AVG(calificacion) 
                                    FROM detalle_resultados_checklist
                                    INNER JOIN detalle_checklist ON detalle_checklist.id = detalle_resultados_checklist.id_actividad
                                    INNER JOIN resultados_checklist ON resultados_checklist.id = detalle_resultados_checklist.id_resultado
                                    WHERE detalle_checklist.id_checklist = '$checklist' AND resultados_checklist.id_sucursal = '$sucursal' AND detalle_checklist.id_subdepartamento = '$row[0]'
                                    AND detalle_resultados_checklist.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)");
    $row2 = mysqli_fetch_array($cadena2);

    $cadena3 = mysqli_query($conexion,"SELECT COUNT(*) FROM resultados_checklist WHERE id_checklist = '$checklist'
    AND id_sucursal = '$sucursal' AND resultados_checklist.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)");
    $row3 = mysqli_fetch_array($cadena3);
    $muestreo    = ($row3[0] == "")?"0":$row3[0];
    $efectividad = ($row2[0] == "")?"0":round($row2[0],2);
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Departamento\": \"$row[1]\",
      \"Muestreo\": \"$muestreo\",
      \"Efectividad\": \"$efectividad\"
      },";
    $cuerpo    = $cuerpo.$renglon;
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