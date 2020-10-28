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
      $filtro_proveedor = " AND numero_proveedor = '$proveedor'";
    }else{
      $filtro_proveedor = "";
  }

    $cadena = mysqli_query($conexion,"SELECT
  (SELECT proveedores.proveedor FROM proveedores WHERE proveedores.id = carta_faltante.id_proveedor ) AS Proveedor,count( * ) AS CantidadCartas,SUM(total_diferencia) AS Monto
FROM carta_faltante WHERE activo = '2' AND fecha_afectacion BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_sucursal.$filtro_proveedor."GROUP BY carta_faltante.id_proveedor ORDER BY CantidadCartas DESC");
                        

    $cuerpo      = "";
    $numero      = 1;
  while ($row = mysqli_fetch_array($cadena)) 
  {
    $monto     = number_format($row[2], 0, '.', ',');
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Proveedor\": \"$row[0]\",
      \"Cartas Faltantes\": \"$row[1]\",
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