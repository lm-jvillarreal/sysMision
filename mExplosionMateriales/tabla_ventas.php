<?php
include '../global_settings/conexion_oracle.php';
include '../global_seguridad/verificar_sesion.php';

$fecIni = str_replace("-","",$_POST["fecha_inicial"]);
$fecFin = str_replace("-","",$_POST["fecha_final"]);
$parametro = $_POST['parametro'];

$diaInicio="Monday";
$diaFin="Saturday";

$strFecha = strtotime(date("Ymd"));

$fechaInicio = date('Ymd',strtotime('last '.$diaInicio,$strFecha));
$fechaFin = date('Ymd',strtotime('next '.$diaFin,$strFecha));

if(date("l",$strFecha)==$diaInicio){
$fechaInicio= date("Ymd",$strFecha);
}
if(date("l",$strFecha)==$diaFin){
$fechaFin= date("Ymd",$strFecha);
}


if($parametro==0){
  $dt = new DateTime(); 
  $dt->setISODate($dt->format('o'), $dt->format('W') - 2);
  $periods = new DatePeriod($dt, new DateInterval('P1D'), 6);
  $days = iterator_to_array($periods);
  $fechaInicioLW = $days[0]->format("Ymd");
  $fechaFinLW = $days[6]->format("Ymd");
}else{
  $fechaInicioLW = $fecIni;
  $fechaFinLW = $fecFin;
}



$datos=array();
$cadenaConsulta="SELECT ID,
                        ARTC_ARTICULO, 
                        ARTC_DESCRIPCION,
                        (SELECT PORCENTAJE FROM panaderia_conversion WHERE ARTICULO = panaderia_recetasventa.ARTC_ARTICULO), 
                        (SELECT CANTIDAD FROM panaderia_conversion WHERE ARTICULO = panaderia_recetasventa.ARTC_ARTICULO)
                  FROM panaderia_recetasventa WHERE ACTIVO = '1' GROUP BY ARTC_DESCRIPCION";
//$id_sede;
$consulta=mysqli_query($conexion,$cadenaConsulta);
$porcentaje;
$cantidad;
$total_unidades;
while($row=mysqli_fetch_array($consulta)){
  //$cadenaConsultaConversion = "SELECT PORCENTAJE, CANTIDAD FROM panaderia_conversion WHERE ARTICULO = '$row[1]'";
  //$consultaConversion = mysqli_query($conexion, $cadenaConsultaConversion);
  
  $cadenaConsulta="SELECT
                NVL(sum(ARTN_CANTIDAD),0) 
                FROM
                PV_VENTAS_REPORTE_VW 
                WHERE
                TICC_SUCURSAL = '$id_sede' 
                AND ( TICN_AAAAMMDDVENTA BETWEEN '$fechaInicioLW' AND '$fechaFinLW' ) 
                AND ARTC_ARTICULO = '$row[1]' 
                AND ( 
                TICN_TIPOMOV = '1' 
                OR TICN_TIPOMOV = '9')";
  $consulta_ventas=oci_parse($conexion_central, $cadenaConsulta);
  oci_execute($consulta_ventas);
  $rowVentas=oci_fetch_array($consulta_ventas);

  /*while ($row2 = mysqli_fetch_array($consultaConversion)) {
    $porcentaje = $row2[0];
    $cantidad = $row2[1];
    $total_unidades = round((1 * $rowVentas[0]) * (1 * ($row2[0] / 100)), 2);
  }*/

  $porcentaje = ($row[3] == null ) ? 0 : $row[3];
  $cantidad = ($row[4] == null) ? 0 : $row[4];
  $total_unidades = round((1 * $rowVentas[0]) * (1 + ($porcentaje / 100)), 2);
  $inputP = "<div class='input-group' style='width:100%''><input type='number'  class='form-control' value='$porcentaje'></input></div>";
  $inputPiezas = "<div class='input-group' style='width:100%''><input type='number'  class='form-control' value='$cantidad'></input></div>";
  // $InsertCant = "<center><a href='#' data-tipo = 'RECETA' data-idreg = '$row[0]' data-idProd = '$row[1]' data-toggle = 'modal' data-target = '#modal-proyeccion' class='btn btn-default'  target='blank'><i class='fa fa-pencil fa-lg' aria-hidden='true'></i></a></center>";
  array_push($datos,array(
    "ARTC_ARTICULO" => $row[1],
    "descripcion" => $row[2],
    "cantidad" => $rowVentas[0],
    "porcentaje" => $inputP,
    "numero_piezas" => $inputPiezas,
    "total_unidades" => ($total_unidades == 0 ? $cantidad : $total_unidades),
    "acciones" => $InsertCant
  ));
  $porcentaje = 0;
  $cantidad = 0;
  $total_unidades = 0;
}
echo utf8_encode(json_encode($datos));