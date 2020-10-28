<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

function dias_transcurridos($fecha_i,$fecha_f)
{
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	$dias 	= abs($dias); $dias = floor($dias);		
	return $dias;
}
$cuerpo ="";
$i = 1;
$cadenaProd="SELECT DISTINCT(cve_articulo), sucursal FROM faltantes_pasven where DATE(fecha_captura) BETWEEN DATE_SUB(NOW(),INTERVAL 7 DAY) AND DATE(NOW())";
$consultaProd=mysqli_query($conexion,$cadenaProd);
while($rowProd=mysqli_fetch_array($consultaProd)){

  $acumulado=0;
  $fechaActual=date("Y-m-d");
  $fechaAnterior=date("Y-m-d");

  $cadenaAcumulado="SELECT cve_articulo, depto, familia, descripcion_articulo, sucursal, DATE_FORMAT(fecha_captura,'%Y-%m-%d') FROM faltantes_pasven where cve_articulo='$rowProd[0]' and sucursal='$rowProd[1]'";
  $consultaAcumulado=mysqli_query($conexion,$cadenaAcumulado);
  
  while($rowAcumulado=mysqli_fetch_array($consultaAcumulado)){

    $fechaAnterior=$fechaActual;
    $fechaActual=$rowAcumulado[5];
    
    $dias=dias_transcurridos($fechaAnterior,$fechaActual);

    if($dias<8){
      $acumulado=$acumulado+1;
    }else{
      $acumulado=0;
    }

    $artc_articulo=$rowAcumulado[0];
    $artc_depto=mysqli_real_escape_string($conexion,$rowAcumulado[1]);
    $artc_familia=mysqli_real_escape_string($conexion,$rowAcumulado[2]);
    $artc_descripcion=mysqli_real_escape_string($conexion,$rowAcumulado[3]);
    $sucursal=mysqli_real_escape_string($conexion,$rowAcumulado[4]);
  }

  if($acumulado==0){
    $renglon = "
      {
        \"no\": \"\",
        \"depto\": \"\",
        \"fam\": \"\",
        \"codigo\": \"\",
        \"descripcion\": \"\",
        \"sucursal\": \"\",
        \"conteo\": \"\",
        \"do\": \"\",
        \"arb\": \"\",
        \"vill\": \"\",
        \"all\": \"\",
        \"pet\": \"\",
        \"cedis\": \"\"
      },";
  }else{

    $cadena_existencia = "SELECT 
    spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 1, '$artc_articulo'), 
    spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 2, '$artc_articulo'), 
    spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 3, '$artc_articulo'), 
    spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 4, '$artc_articulo'),
    spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 5, '$artc_articulo'),
    spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 99,'$artc_articulo'),
    (SELECT ARTC_DESCRIPCION FROM COM_ARTICULOS WHERE ARTC_ARTICULO='$artc_articulo')   
  FROM 
    dual";
    $st = oci_parse($conexion_central, $cadena_existencia);
    oci_execute($st);
    $row_existencia = oci_fetch_row($st);
    
    $do = "<center><a href='#' data-id = '$artc_articulo' data-suc = '1'  data-toggle = 'modal' data-target = '#modal-ue' target='blank'>$row_existencia[0]</a></center>";
    $arb = "<center><a href='#' data-id = '$artc_articulo' data-suc = '2'  data-toggle = 'modal' data-target = '#modal-ue' target='blank'>$row_existencia[1]</a></center>";
    $vill = "<center><a href='#' data-id = '$artc_articulo' data-suc = '3'  data-toggle = 'modal' data-target = '#modal-ue' target='blank'>$row_existencia[2]</a></center>";
    $all = "<center><a href='#' data-id = '$artc_articulo' data-suc = '4'  data-toggle = 'modal' data-target = '#modal-ue' target='blank'>$row_existencia[3]</a></center>";
    $pet = "<center><a href='#' data-id = '$artc_articulo' data-suc = '5'  data-toggle = 'modal' data-target = '#modal-ue' target='blank'>$row_existencia[4]</a></center>";
    $cedis = "<center><a href='#' data-id = '$artc_articulo' data-suc = '99'  data-toggle = 'modal' data-target = '#modal-ue' target='blank'>$row_existencia[5]</a></center>";
    $escape_desc=mysqli_real_escape_string($conexion,$row_existencia[6]);
    $renglon = "
    {
      \"no\": \"$i\",
      \"depto\": \"$artc_depto\",
      \"fam\": \"$artc_familia\",
      \"codigo\": \"$artc_articulo\",
      \"descripcion\": \"$escape_desc\",
      \"sucursal\": \"$sucursal\",
      \"conteo\": \"$acumulado\",
      \"do\": \"$do\",
      \"arb\": \"$arb\",
      \"vill\": \"$vill\",
      \"all\": \"$all\",
      \"pet\": \"$pet\",
      \"cedis\": \"$cedis\"
    },";
    $cuerpo = $cuerpo.$renglon;
    $i=$i+1;
  }
}
$cuerpo2 = trim($cuerpo, ',');
$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>