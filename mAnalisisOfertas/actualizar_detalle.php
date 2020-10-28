<?php
include '../global_settings/conexion_oracle.php';
include '../global_seguridad/verificar_sesion.php';

$folio = $_POST['folio'];

$cadenaDeshabilita ="UPDATE registro_ofertas_detalle SET activo = '0' WHERE folio_oferta = '$folio'";
$deshabilita = mysqli_query($conexion, $cadenaDeshabilita);

$cadena_detalle = "SELECT articulo, fecha_inicio, fecha_fin, desc_articulo, id FROM registro_ofertas WHERE folio_oferta = '$folio'";
$consulta_detalle = mysqli_query($conexion, $cadena_detalle);

while($row = mysqli_fetch_array($consulta_detalle)){
  $fecha_inicio = $row[1];
  $fecha_fin = $row[2];

  $fecha1 = new DateTime($fecha_inicio);
  $fecha2 = new DateTime($fecha_fin);
  $diff = $fecha1->diff($fecha2);

  $dias = $diff->days;
  $dias = $dias + 1;

  //echo $dias;
  $folio_inicial = date("Y-m-d", strtotime($fecha_inicio . "- 1 days"));
  $folioInicial = str_replace("-", "", $folio_inicial);

  $folio_final = date("Y-m-d", strtotime($folio_inicial . "- " . $dias . " days"));
  $folioFinal = str_replace("-", "", $folio_final);

  for ($c = 1; $c <= 5; $c = $c + 1) {
    switch ($c) {
      case 1:
        $sucursal = 'Diaz Ordaz';
        break;
      case 2:
        $sucursal = 'Arboledas';
        break;
      case 3:
        $sucursal = 'Villegas';
        break;
      case 4:
        $sucursal = 'Allende';
        break;
      case 5:
        $sucursal = 'La Petaca';
        break;
    }
    $cadenaDatos = "SELECT * FROM (SELECT
                  detalle.modc_tipomov as Movimiento,
                  detalle.MODN_FOLIO as folio,
                  TO_CHAR(movs.MOVD_FECHAAFECTACION, 'DD/MM/YYYY') as fecha,
                  detalle.RMON_CANTSURTIDA as cantidad,
                  (SELECT CONCAT(PROC_CVEPROVEEDOR,TRIM(PROC_NOMBRE)) FROM cxp_proveedores WHERE TRIM(PROC_CVEPROVEEDOR) = TRIM(movs.MOVC_CVEPROVEEDOR)) AS Proveedor,
                  (SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, '$c', detalle.ARTC_ARTICULO ) FROM dual ) AS Existencia
                  FROM
                  INV_RENGLONES_MOVIMIENTOS detalle
                  INNER JOIN INV_MOVIMIENTOS movs ON movs.ALMN_ALMACEN = detalle.ALMN_ALMACEN 
                  AND detalle.MODN_FOLIO = movs.MODN_FOLIO 
                  AND movs.MODC_TIPOMOV = detalle.MODC_TIPOMOV 
                  WHERE
                  ARTC_ARTICULO = '$row[0]' 
                  AND movs.ALMN_ALMACEN = '$c' 
                  AND detalle.ALMN_ALMACEN = '$c'
                  AND movs.MOVD_FECHAAFECTACION IS NOT NULL
                  AND ( detalle.MODC_TIPOMOV = 'ENTSOC' OR detalle.MODC_TIPOMOV = 'ENTCOC' OR detalle.MODC_TIPOMOV = 'ETRANS')
                  ORDER BY
                  movs.MOVD_FECHAAFECTACION DESC)
                WHERE ROWNUM <=1";
    //echo $cadenaDatos;
    $consultaPrincipal = oci_parse($conexion_central, $cadenaDatos);
    oci_execute($consultaPrincipal);
    $row_articulo = oci_fetch_row($consultaPrincipal);

    $cadenaVentas = "SELECT NVL(SUM(ARTN_CANTIDAD),0) FROM PV_ARTICULOSTICKET WHERE ticn_aaaammddventa > $folioFinal AND ticn_aaaammddventa <= $folioInicial AND ticc_sucursal = '$c' AND artc_articulo = '$row[0]'";
    $consultaVentas = oci_parse($conexion_central, $cadenaVentas);
    oci_execute($consultaVentas);
    $row_ventas = oci_fetch_row($consultaVentas);
    //echo $cadenaVentas;
    if ($row_ventas[0] == "0") {
      $promedio = 0;
      $dias_inv = "NA";
    } else {
      $promedio = $row_ventas[0] / $dias;
      $promedio = round($promedio,2);
      if ($row_articulo[5] == "0") {
        $dias_inv = "0";
      } else {
        $dias_inv = $row_articulo[5] / $promedio;
        $dias_inv = round($dias_inv, 2);
      }
    }

    $cadenaInsertar = "INSERT INTO registro_ofertas_detalle(id_registro_ofertas, id_sucursal, tipo_movimiento, folio_movimiento, fecha_movimiento, artc_articulo, artc_descripcion, cantidad, proveedor, teorico, ventas, dias_inventario, fecha_actualizacion, activo, usuario, folio_oferta)VALUES('$row[4]','$c','$row_articulo[0]','$row_articulo[1]','$row_articulo[2]','$row[0]','$row[3]','$row_articulo[3]','$row_articulo[4]','$row_articulo[5]','$promedio','$dias_inv','$fecha $hora','1','$id_usuario','$folio')";
    $insertarDetalle = mysqli_query($conexion, $cadenaInsertar);
    //echo $cadenaInsertar;
    //$i = $i + 1;
  }
}
echo "ok";
?>