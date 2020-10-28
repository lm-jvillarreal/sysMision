<?php 
  include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion_oracle.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');
    $factura = $_POST['factura'];
    $proveedor = $_POST['proveedor'];
    $proveedor = trim($proveedor);
    $tipo = $_POST['tipo'];
  $cadena  = "SELECT 
                CASE ALMN_ALMACEN
                  WHEN 1 THEN 'Diaz Ordaz'
                  WHEN 2 THEN 'Arboledas'
                  WHEN 3 THEN 'Villegas'
                  WHEN 4 THEN 'Allende'
                  ELSE 'Otra' END,

                  MODN_FOLIO, MOVD_FECHAAFECTACION 

              FROM INV_MOVIMIENTOS 
              WHERE 
                  MODC_TIPOMOV = '$tipo' 
              AND 
                  MOVC_CVEPROVEEDOR = '$proveedor' 
              AND 
                  MOVC_CXP_REMISION = '$factura'";
                  //echo "$cadena";
    $st = oci_parse($conexion_central, $cadena);
    oci_execute($st);

$cuerpo ="";

  while ($row = oci_fetch_array($st)) 
  {

    $numero = 1;
    $renglon = "
      {
      \"s\": \"$numero\",
      \"sucursal\": \"$row[0]\",
      \"folio\": \"$row[1]\",
      \"fecha\": \"$row[2]\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
    $clase = "";
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
    ["
    .$cuerpo2.
    "]
    ";
  echo $tabla;
?>