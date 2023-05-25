<?php 
include '../global_settings/conexion_oracle.php';
include '../global_seguridad/verificar_sesion.php';
$datos=array();
$cantidad = 0;


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

$cadenaConsulta="SELECT ID,
                    ARTC_ARTICULO,
                    ARTC_DESCRIPCION,
                    (SELECT PORCENTAJE FROM panaderia_conversion WHERE ARTICULO = panaderia_recetasventa.ARTC_ARTICULO), 
                    (SELECT CANTIDAD FROM panaderia_conversion WHERE ARTICULO = panaderia_recetasventa.ARTC_ARTICULO)
                    FROM panaderia_recetasventa 
                    WHERE ACTIVO=1 
                    GROUP BY ARTC_ARTICULO";
$consulta=mysqli_query($conexion,$cadenaConsulta);
while($row=mysqli_fetch_array($consulta)){
    $cadenaCalPro = "SELECT ID_ARTICULO, LUNES, MARTES, MIERCOLES, JUEVES, VIERNES, SABADO, ID_TABLA, DOMINGO FROM panaderia_calendarioprod WHERE ID_TABLA = '$row[0]' AND ID_ARTICULO = '$row[1]' AND FECHA_INICIO = '$fechaInicioLW' AND FECHA_FIN = '$fechaFinLW'";
    $consultaCalPro = mysqli_query($conexion, $cadenaCalPro);
    $rowCalPro =  mysqli_fetch_array($consultaCalPro);
    $prod_lunes = ($rowCalPro[1] == null ? 0 : $rowCalPro[1]);
    $prod_martes = ($rowCalPro[2] == null ? 0 : $rowCalPro[2]);
    $prod_miercoles = ($rowCalPro[3] == null ? 0 : $rowCalPro[3]);
    $prod_jueves = ($rowCalPro[4] == null ? 0 : $rowCalPro[4]);
    $prod_viernes = ($rowCalPro[5] == null ? 0 : $rowCalPro[5]);
    $prod_sabado = ($rowCalPro[6] == null ? 0 : $rowCalPro[6]);
    $prod_domingo = ($rowCalPro[8] == null ? 0 : $rowCalPro[8]);
    $sumatoria = ($prod_lunes + $prod_martes + $prod_miercoles + $prod_jueves + $prod_viernes + $prod_sabado +$prod_domingo);
    
    /*$cadenaInvPro = "SELECT COUNT(ARTC_ARTICULO) FROM panaderia_recetasventa WHERE ARTC_ARTICULO = '$row[1]'";
    $consultaInvPro = mysqli_query($conexion, $cadenaInvPro);
    $rowInvPro = mysqli_fetch_array($consultaInvPro);*/

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
  
    $cadenaCantidad = "SELECT CANTIDAD FROM panaderia_inventariospos WHERE ID_ARTICULO = '$row[1]' GROUP BY ID_ARTICULO";
    $consultaCantidad = mysqli_query($conexion, $cadenaCantidad);
    $rowCantidad = mysqli_fetch_array($consultaCantidad);
    $valorCant = ($rowCantidad[0] == "" ? 0 : $rowCantidad[0]);
  
    $cadenaMinimoInv = "SELECT CANTIDAD FROM panaderia_invrpo_cantidad WHERE ID_ARTICULO = '$row[1]' AND TIPO = '1' GROUP BY ID_ARTICULO";
    $consultaMinimoInv = mysqli_query($conexion, $cadenaMinimoInv);
    $rowMinimo = mysqli_fetch_array($consultaMinimoInv);
    $valorMin = ($rowMinimo[0] == null) ? 0 : $rowMinimo[0];

    $cadenaPedidos = "SELECT CANTIDAD FROM panaderia_cantidadproducir WHERE ID_ARTICULO = '$row[1]' AND ID_SUCURSAL = '$id_sede' GROUP BY ID_ARTICULO";
    $consultaPedido = mysqli_query($conexion, $cadenaPedido);
    $rowPedido = mysqli_fetch_array($consultaPedido);
    $valorPedido = ($rowPedido[0] == "" ? 0 : $rowPEdido[0]);

    $porcentaje = ($row[3] == null) ? 0 : $row[3];

    $cantidad = ($row[4] == null) ? 0 : $row[4];

    $total_unidades = round((1 * $valorVentas) * (1 + ($porcentaje / 100)), 2);

    $estimacion = $total_unidades + $valorPedido < 0 ? 0 : $total_unidades + $valorPedido;


    $produccion = ((($valorCant-$estimacion)-$valorMin)*-1) <= 0 ? 0 : ((($valorCant-$estimacion)-$valorMin)*-1);

    $ver = "<center><a href='#' data-tipo = 'PRODUCTO' data-idprod = '$row[0]' data-folio = '$row[1]' data-ventas = '$rowVentas[0]' data-toggle = 'modal' data-target = '#modal-detalle' class='btn btn-success'><i class='fa fa-search fa-lg' aria-hidden='true'></i></a></center>";

    array_push($datos,array(
        "tipo"=>'PRODUCTO',
        "artc_articulo"=>$row[1],
        "artc_descripcion"=>$row[2],
        "prod_semanal"=>$sumatoria,
        "prod_lunes"=>$prod_lunes,
        "prod_martes"=>$prod_martes,
        "prod_miercoles"=>$prod_miercoles,
        "prod_jueves"=>$prod_jueves,
        "prod_viernes"=>$prod_viernes,
        "prod_sabado"=>$prod_sabado,
        "prod_domingo" =>$prod_domingo,
        "faltante"=>(($sumatoria) - ($produccion)),
        "opciones"=>$ver
    ));
}

//agregar minimo de js
$cadenaConsultaSubrecetas = "SELECT ID, 
                                NOMBRE_RECETA,
                                CLAVE_RECETA
                                FROM panaderia_subrecetas
                                WHERE ACTIVO=1
                                GROUP BY CLAVE_RECETA";
$consultaSubRecetas = mysqli_query($conexion,$cadenaConsultaSubrecetas);
while ($row2=mysqli_fetch_array($consultaSubRecetas)) {
    $ver = "<center><a href='#' data-tipo = 'SUBRECETA' data-idprod = '$row2[0]' data-folio = '$row2[2]' data-toggle = 'modal' data-target = '#modal-detalle' class='btn btn-success'><i class='fa fa-search fa-lg' aria-hidden='true'></i></a></center>";
    $cadenaCalPro = "SELECT ID_ARTICULO, LUNES, MARTES, MIERCOLES, JUEVES, VIERNES, SABADO, ID_TABLA, DOMINGO FROM panaderia_calendarioprod WHERE ID_TABLA = '$row2[0]' AND ID_ARTICULO = '$row2[2]' AND FECHA_INICIO = '$fechaInicio' AND FECHA_FIN = '$fechaFin'";
    $consultaCalPro = mysqli_query($conexion, $cadenaCalPro);
    $rowCalPro =  mysqli_fetch_array($consultaCalPro);
    $prod_lunes = ($rowCalPro[1] == null ? 0 : $rowCalPro[1]);
    $prod_martes = ($rowCalPro[2] == null ? 0 : $rowCalPro[2]);
    $prod_miercoles = ($rowCalPro[3] == null ? 0 : $rowCalPro[3]);
    $prod_jueves = ($rowCalPro[4] == null ? 0 : $rowCalPro[4]);
    $prod_viernes = ($rowCalPro[5] == null ? 0 : $rowCalPro[5]);
    $prod_sabado = ($rowCalPro[6] == null ? 0 : $rowCalPro[6]);
    $prod_domingo = ($rowCalPro[8] == null ? 0 : $rowCalPro[8]);
    $sumatoria = ($prod_lunes + $prod_martes + $prod_miercoles + $prod_jueves + $prod_viernes + $prod_sabado + $prod_domingo);
    
    $cadenaInvPro = "SELECT SUM(CANTIDAD_RECETA) FROM panaderia_recetasventarenglones WHERE CLAVE_ARTICULO = '$row2[2]' AND SUBRECETA = 1";
    $consultaInvPro = mysqli_query($conexion, $cadenaInvPro);
    $rowInvPro = mysqli_fetch_array($consultaInvPro);
    
    array_push($datos,array(
        "tipo"=>'SUBRECETA',
        "artc_articulo"=>$row2[2],
        "artc_descripcion"=>$row2[1],
        "prod_semanal"=>$sumatoria,
        "prod_lunes"=>$prod_lunes,
        "prod_martes"=>$prod_martes,
        "prod_miercoles"=>$prod_miercoles,
        "prod_jueves"=>$prod_jueves,
        "prod_viernes"=>$prod_viernes,
        "prod_sabado"=>$prod_sabado,
        "prod_domingo" =>$prod_domingo,
        "faltante"=>(($rowInvPro[0]) - ($sumatoria)),
        "opciones"=>$ver
    ));
}
echo utf8_encode(json_encode($datos));
?>