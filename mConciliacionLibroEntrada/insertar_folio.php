<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
$modc_tipomov = $_POST['modc_tipomov'];
$modn_folio = $_POST['modn_folio'];
$ficha_entrada = $_POST['ficha_entrada'];
$id_ficha = $_POST['id_ficha'];
if($modc_tipomov=='ENTCOC' || $modc_tipomov=='ENTSOC'){
  $cadenaMonto = "SELECT ARTC_ARTICULO, rmon_costo_renglon_mb, rmon_ieps_sn, rmoc_cveieps, (SELECT ARTC_CVEIVA FROM COM_ARTICULOS WHERE ARTC_ARTICULO=INV_RENGLONES_MOVIMIENTOS.ARTC_ARTICULO)
  FROM INV_RENGLONES_MOVIMIENTOS WHERE ALMN_ALMACEN = '$id_sede' AND MODC_TIPOMOV = '$modc_tipomov' AND MODN_FOLIO ='$modn_folio'";
  $consultaFolio = oci_parse($conexion_central, $cadenaMonto);
  oci_execute($consultaFolio);
  $monto=0;
  $renglon=0;
  while($rowFolio = oci_fetch_row($consultaFolio)){

    if($rowFolio[4]=='SINIVA'){
      $iva=0;
    }elseif($rowFolio[4]=='IVACOM'){
      $iva = $rowFolio[1] * 0.16;
    }

    if($rowFolio[2]=='0'){
      $ieps=0;
    }elseif($rowFolio[2]=='1' && $rowFolio[3]=='IEPSG'){
      $ieps=$rowFolio[1]*0.08;
    }elseif($rowFolio[2]=='1' && $rowFolio[3]=='IEPS6'){
      $ieps=$rowFolio[1]*0.06;
    }else{
      $ieps=0;
    }
    $renglon = $rowFolio[1]+$iva+$ieps;
    $monto=$monto+$renglon;
  }
  $monto = round($monto,2);
}else{
  $cadenaMonto="SELECT (SELECT NC.NCCN_IMPORTE FROM cxp_notascarcre NC WHERE nc.nccv_numncc = inv_movimientos.movc_cxp_remision AND TRIM(PROC_CVEPROVEEDOR) = TRIM(inv_movimientos.MOVC_CVEPROVEEDOR)) TOTAL
                FROM INV_MOVIMIENTOS WHERE ALMN_ALMACEN = '$id_sede' AND MODC_TIPOMOV = '$modc_tipomov' AND MODN_FOLIO ='$modn_folio'";
  $consultaFolio=oci_parse($conexion_central,$cadenaMonto);
  oci_execute($consultaFolio);
  $rowFolio=oci_fetch_row($consultaFolio);
  $monto=$rowFolio[0];
}
echo $cadenaMonto;
$cadenaInsertar = "INSERT INTO alb_foliomov (id_fichaentrada, ficha_entrada, modc_tipomov, modn_folio, monto, id_sucursal, fecha, activo, usuario) VALUES('$id_ficha', '$ficha_entrada', '$modc_tipomov', '$modn_folio', '$monto','$id_sede', '$fecha $hora', '1', '$id_usuario')";
$insertarFolio = mysqli_query($conexion, $cadenaInsertar);
//echo $cadenaInsertar;
?>