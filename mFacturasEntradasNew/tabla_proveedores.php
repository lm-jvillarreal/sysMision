<?php
    include '../global_seguridad/verificar_sesion.php';

    $sucursal  = $_POST['sucursal'];
    $fecha1    = $_POST['fecha1'];
    $fecha2    = $_POST['fecha2'];
    $proveedor = $_POST['proveedor'];

    if(!empty($sucursal)){
        $filtro_sucursal = " AND id_sucursal = '$sucursal'";
    }elseif(empty($sucursal)){
        $filtro_sucursal = "";
    }
    if(!empty($proveedor)){
      $proveedor = trim($proveedor);
      $filtro_proveedor = " AND proveedor = '$proveedor'";
    }else{
      $filtro_proveedor = "";
  }

    $cadena = mysqli_query($conexion,"SELECT id,proveedor,COUNT(*) as CantidadNotas,SUM(diferencia)
FROM notas_entrada  WHERE fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_sucursal.$filtro_proveedor."GROUP BY proveedor ORDER BY CantidadNotas DESC");
                        

    $cuerpo      = "";
    $numero      = 1;
  while ($row = mysqli_fetch_array($cadena)) 
  {
    $monto     = number_format($row[3], 0, '.', ',');
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Proveedor\": \"$row[1]\",
      \"Cartas Faltantes\": \"$row[2]\",
      \"Monto Total\": \"$ $monto\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
    $fecha_nueva = "";
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
    ["
    .$cuerpo2.
    "]
    ";
  echo $tabla;
?>