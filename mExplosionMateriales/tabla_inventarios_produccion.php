<?php
include '../global_settings/conexion_oracle.php';
include '../global_seguridad/verificar_sesion.php';

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

$dt = new DateTime(); 
$dt->setISODate($dt->format('o'), $dt->format('W') - 2);
$periods = new DatePeriod($dt, new DateInterval('P1D'), 6);
$days = iterator_to_array($periods);
$fechaInicioLW = $days[0]->format("Ymd");
$fechaFinLW = $days[6]->format("Ymd");

$porcentaje;
$cantidad;
$total_unidades;
$estimacion;
$datos=array();
$cadenaConsulta="SELECT
                  ID, 
                  ARTC_ARTICULO, 
                  ARTC_DESCRIPCION,
                  COUNT(ARTC_DESCRIPCION),
                  (SELECT PORCENTAJE FROM panaderia_conversion WHERE ARTICULO = panaderia_recetasventa.ARTC_ARTICULO), 
                  (SELECT CANTIDAD FROM panaderia_conversion WHERE ARTICULO = panaderia_recetasventa.ARTC_ARTICULO)
                  FROM panaderia_recetasventa 
                  WHERE ACTIVO=1  
                  GROUP BY ARTC_ARTICULO";

$consulta=mysqli_query($conexion,$cadenaConsulta);
while($row=mysqli_fetch_array($consulta)){

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
  $valorVentas = ($rowVentas[0] == "" ? 0 : $rowVentas[0]);

  $cadenaMinimoInv = "SELECT CANTIDAD FROM  panaderia_invpro_cantidad WHERE ID_ARTICULO = '$row[1]' AND TIPO = '1' GROUP BY ID_ARTICULO";
  $consultaMinimoInv = mysqli_query($conexion, $cadenaMinimoInv);
  $rowMinimo = mysqli_fetch_array($consultaMinimoInv);
  $valorMin = ($rowMinimo[0] == null ) ? 0 : $rowMinimo[0];

  $cadenaCantidad = "SELECT CANTIDAD FROM panaderia_inventariospos WHERE ID_ARTICULO = '$row[1]' GROUP BY ID_ARTICULO";
  $consultaCantidad = mysqli_query($conexion, $cadenaCantidad);
  $rowCantidad = mysqli_fetch_array($consultaCantidad);
  $valorCant = ($rowCantidad[0]=="" ? 0 : $rowCantidad[0]);

  $InsertCant = "<center><a href='#'' data-idreg = '$row[0]' data-idprod = '$row[1]' data-toggle = 'modal' data-target = '#modal-produccion' class='btn btn-default'  target='blank'><i class='fa fa-pencil fa-lg' aria-hidden='true'></i></a></center>";
  
  
  $cadenaPedido = "SELECT CANTIDAD FROM panaderia_cantidadproducir WHERE ID_ARTICULO = '$row[1]' AND ID_SUCURSAL = '$id_sede' GROUP BY ID_ARTICULO";
  $consultaPedido = mysqli_query($conexion, $cadenaPedido);
  $rowPedido = mysqli_fetch_array($consultaPedido);
  $valorPedido = ($rowPedido[0]=="" ? 0 : $rowPedido[0]);
  /**
   *ya hecho: agregar lo de pedidos del día 10
   */

  $porcentaje = ($row[4] == null) ? 0 : $row[4];
  
  $cantidad = ($row[5] == null) ? 0 : $row[5];
  
  $total_unidades = round((1 * $valorVentas) * (1 + ($porcentaje / 100)), 2);
  
  $estimacion = $total_unidades + $valorPedido < 0 ? 0 : $total_unidades + $valorPedido;

  //$produccion = ((($valorCant-$rowVentas[0])-$valorMin)*-1) <= 0 ? 0 : ((($valorCant-$rowVentas[0])-$valorMin)*-1);

  $produccion = ((($valorCant-$estimacion)-$valorMin)*-1) <= 0 ? 0 : ((($valorCant-$estimacion)-$valorMin)*-1);
  $input = "<div class='input-group' style='width:100%''><input type='number'  class='form-control' value='$valorMin'></input></div>";
  array_push($datos,array(
    "id"=>$row[0],
    "artc_articulo"=>$row[1],
    "artc_descripcion"=>$row[2],
    "holder"=>$input,
    "existencias"=>$valorCant,
    "total"=>($estimacion),
    "produccion"=>$produccion
    // "insertar"=>$InsertCant,
  ));
}
echo utf8_encode(json_encode($datos));