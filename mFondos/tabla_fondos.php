<?php
include '../global_seguridad/verificar_sesion.php';
$id_comprador = $_POST['comprador'];

$cadenaDetalle = "SELECT DISTINCT(cve_proveedor), nombre_proveedor, ROUND(SUM(total),2) FROM fondos WHERE id_comprador = '$id_comprador' GROUP BY cve_proveedor";
$consultaDetalle = mysqli_query($conexion,$cadenaDetalle);
$cuerpo="";
while($rowDetalle =mysqli_fetch_array($consultaDetalle)){
  $totalAbonos = $rowDetalle[2];
  $cadenaCargos = "SELECT id, folio_oferta, articulo, descripcion, fecha_inicio, fecha_fin, tipo, cantidad, sucursal FROM cargos_fondos where id_comprador = '$id_comprador' and proveedor = '$rowDetalle[0]'";
  $consultaCargos = mysqli_query($conexion, $cadenaCargos);
  $totalCargos = 0;
  $totalCodigo=0;
  while($rowCargos = mysqli_fetch_array($consultaCargos)){
    $fechaInicio = str_replace("-", "", $rowCargos[4]);
    $fechaFin = str_replace("-", "", $rowCargos[5]);
  
    $cadenaTicket = "SELECT SUM(ARTN_CANTIDAD)
                    FROM PV_ARTICULOSTICKET 
                    WHERE ticn_aaaammddventa >= '$fechaInicio' AND ticn_aaaammddventa <= '$fechaFin'
                    AND ARTC_ARTICULO = '$rowCargos[2]'
                    GROUP BY ARTC_ARTICULO";
                      
    $st = oci_parse($conexion_central, $cadenaTicket);
    oci_execute($st);
    
    $rowTicket = oci_fetch_row($st);
    $cantidadArticulo = $rowTicket[0];
    //$precioArticulo = $rowTicket[1];
  
    if($rowCargos[6]=="CANTIDAD"){
      $totalCodigo = $cantidadArticulo*$rowCargos[7];
  
    }elseif($rowCargos[6]=="PORCENTAJE"){
      $porcentaje = $rowCargos[7]/100;
      $totalCodigo = $precioArticulo*$porcentaje;
      $totalCodigo = $totalCodigo * $cantidadArticulo;
    }
    $totalCargos=$totalCargos+$totalCodigo;
  }
  $resto = $totalAbonos-$totalCargos;
  $resto="$ ".round($resto,2);
    $renglon = "
      {
        \"clave_proveedor\": \"$rowDetalle[0]\",
        \"nombre_proveedor\": \"$rowDetalle[1]\",
        \"total\": \"$resto\"
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