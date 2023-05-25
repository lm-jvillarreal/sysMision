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
  $cadena="SELECT
              detalle_checklist.nombre,
              sub_departamentos.nombre,
              AVG(detalle_resultados_checklist.calificacion)
              FROM detalle_resultados_checklist
              LEFT JOIN detalle_checklist ON detalle_resultados_checklist.id_actividad = detalle_checklist.id
              LEFT JOIN sub_departamentos ON sub_departamentos.id = detalle_checklist.id_subdepartamento
              INNER JOIN resultados_checklist ON resultados_checklist.id = detalle_resultados_checklist.id_resultado
            WHERE detalle_resultados_checklist.fecha BETWEEN CAST('$fecha1' AS DATE)
                      AND CAST('$fecha2' AS DATE)
            AND detalle_checklist.id_checklist = '$checklist'
            AND resultados_checklist.id_sucursal = '$sucursal'
            GROUP BY  id_actividad";
  
  $cadena = mysqli_query($conexion,$cadena);

  while ($row = mysqli_fetch_array($cadena)){
    
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Actividad\": \"$row[0]\",
      \"Promedio\": \"$row[2]\",
      \"Descripcion\": \"$row[1]\"
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