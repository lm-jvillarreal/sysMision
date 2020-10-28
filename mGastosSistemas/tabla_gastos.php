<?php
    include '../global_settings/conexion_oracle.php';
    include '../global_seguridad/verificar_sesion.php';
    date_default_timezone_set('America/Monterrey');

    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin    = $_POST['fecha_fin'];
    $proveedor    = $_POST['proveedor'];
    $filtro_proveedor = (!empty($proveedor))?" AND CP.PROC_CVEPROVEEDOR = '$proveedor'":"";

    // $cadena_detalle = "SELECT CONCAT(CONCAT(CP.PROC_CVEPROVEEDOR,'' ), CP.PROC_NOMBRE),
    //                       CM.MOVN_MONTO,
    //                       CM.MOVD_FECHA,
    //                       CP.PROC_CVEPROVEEDOR,
    //                       CM.MOVC_REFERENCIAC1
    //                     FROM CXP_MOVIMIENTOS CM
    //                     INNER JOIN CXP_PROVEEDORES CP ON CP.PROC_CVEPROVEEDOR = CM.PROC_CVEPROVEEDOR
    //                     WHERE CM.MOVD_FECHA >= TO_DATE('$fecha_inicio','YYYY/MM/DD')
    //                     AND CM.MOVD_FECHA <= TO_DATE('$fecha_fin','YYYY/MM/DD')
    //                     AND MOVN_REFERENCIAN2 IS NOT NULL ".$filtro_proveedor;
    $cadena_detalle = "SELECT CXPC_INDICEPOL, 
    (SELECT CONCAT(CONCAT(PROC_CVEPROVEEDOR,'' ), PROC_NOMBRE) FROM CXP_PROVEEDORES WHERE PROC_CVEPROVEEDOR=cxp_cxp.proc_cveproveedor) PROV, 
    CXPN_TOTPAGADO, cxpd_fechafact, proc_cveproveedor, TRIM(CXPC_NUMFACT) FACT
    FROM CXP_CXP 
    WHERE proc_cveproveedor = '$proveedor'
    AND cxpd_fechafact >= TO_DATE('$fecha_inicio','YYYY/MM/DD')
    AND cxpd_fechafact <= TO_DATE('$fecha_fin','YYYY/MM/DD')
    ORDER BY cxpc_numfact ASC";
                        
    $consulta_detalle = oci_parse($conexion_central, $cadena_detalle);
    oci_execute($consulta_detalle);

    $cuerpo      = "";
    $numero      = 1;
    $fecha_nueva = "";
    $dato        = "";
    $input       = "";
    $input2      = "";
  while ($row = oci_fetch_row($consulta_detalle)) 
  {
    $fecha_nueva = date("Ymd", strtotime($row[3]));
    $fecha_nueva2 = date("Y-m-d", strtotime($row[3]));

    $cadena_verificar="SELECT id FROM gastos_sistemas WHERE activo = '1' AND gasto = '$row[2]' AND folio_factura = '$row[5]'";
    $consulta_verificar = mysqli_query($conexion,$cadena_verificar);
    $row_verificar=mysqli_fetch_array($consulta_verificar);

    $existe = COUNT($row_verificar[0]);
    if($existe != 0){
      $texto = "<span class='badge bg-red'>Ya existe</span>";
      $disabled = "disabled";
    }else{
      $disabled = "";
      $texto = "";
    }
    
    $boton_seleccionar   = "<button class='btn btn-danger' onclick='seleccionar($row[2],$fecha_nueva,$numero)' $disabled><i class='fa fa-check-square fa-lg' aria-hidden='true'></i></button>";
    $input  = "<input id='$numero' value='$row[4]' class='hidden'>";
    $input2 = "<input id='ff$numero' value='$row[5]' class='hidden'>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Proveedor\": \"$row[1]  $texto\",
      \"Costo\": \"$ $row[2]\",
      \"Fecha\": \"$row[3]\",
      \"Folio Factura\": \"$row[5]\",
      \"Seleccionar\": \"$boton_seleccionar $input $input2\"
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