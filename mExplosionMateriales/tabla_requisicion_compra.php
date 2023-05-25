<?php
include '../global_seguridad/verificar_sesion.php';
$datos=array();
$cadenaConsulta="SELECT
                   ID,
                  ARTC_ARTICULO, 
                  ARTC_DESCRIPCION, 
                  PROVEEDOR, 
                  RMON_ULTIMOPRECIO, 
                  UNIMEDIDA_VENTA, 
                  FACTOR_EMPAQUE, 
                  PORCENTAJE_MERMA, 
                  FECHAHORA, 
                  ACTIVO, 
                  USUARIO
                FROM panaderia_articulos 
                WHERE ACTIVO=1";
$consulta=mysqli_query($conexion,$cadenaConsulta);
while($row=mysqli_fetch_array($consulta)){

    $cadenaConsultaRecetasVentas = "SELECT  
    sum(CANTIDAD_RECETA)
    FROM panaderia_recetasventarenglones WHERE CLAVE_ARTICULO='$row[1]' AND SUBRECETA='0' GROUP BY CLAVE_ARTICULO";
    $consultaRV = mysqli_query($conexion, $cadenaConsultaRecetasVentas);
    $rowRV = mysqli_fetch_array($consultaRV);
    $valorRv = $rowRV[0] < 0 ? 0 : $rowRV[0];

    $cadenaSubrecetasReglones = "SELECT 
    sum(CANTIDAD_RECETA)
    FROM panaderia_subrecetasrenglones WHERE ID_ARTICULO = '$row[1]' AND SUBRECETA='0' GROUP BY ID_ARTICULO";
    $consultaSR = mysqli_query($conexion, $cadenaSubrecetasReglones);
    $rowSR = mysqli_fetch_array($consultaSR);
    $valorSR = $rowSR[0] < 0 ? 0 : $rowSR[0];

    $cadenaMinimoInv = "SELECT CANTIDAD FROM  panaderia_invpro_cantidad WHERE ID_ARTICULO = '$row[1]' AND TIPO = '3' GROUP BY ID_ARTICULO"; 
    $consultaMinimoInv = mysqli_query($conexion, $cadenaMinimoInv);
    $rowMinimo = mysqli_fetch_array($consultaMinimoInv);
    $valorMin = ($rowMinimo[0] == null ) ? 0 : $rowMinimo[0];

    $cadenaRequisicion = "SELECT DIAS_ENTREGA, CANTIDAD_ORDENAR FROM panaderia_requisicion WHERE ID_ARTICULO = '$row[1]' GROUP BY ID_ARTICULO"; 
    $consultaRequisicion = mysqli_query($conexion, $cadenaRequisicion);
    $rowReq = mysqli_fetch_array($consultaRequisicion);
    $diasReq = ($rowReq[0] == null ) ? 0 : $rowReq[0];
    $cantReq = ($rowReq[1] == null ) ? 0 : $rowReq[1];
    $modDias = 0;
    if ($diasReq % 7 == 0) {
        $modDias = $diasReq;
    }else{
        $modDias = ceil($diasReq / 7) + 1;
    }
    if ($modDias == 0) {
        $modDias = 1;
    }
    $costo_total = 0;
    if ($cantReq > 0 ) {
        $costo_total = ($cantReq + $valorMin) * ceil($modDias/7) * $row[4];
    }else{
        $costo_total = (ceil($valorRV) + ceil($valorSR) + $valorMin) * ceil($modDias / 7) * $row[4];
    }
    
    //ceil($modDias/7) + 1 . " _ _ " . (ceil($modDias/7) * $valorMin)
    //$InsertCant = "<center><a href='#' data-tipo = 'ARTICULO' data-idreg = '$row[0]' data-idProd = '$row[1]' data-toggle = 'modal' data-target = '#modal-req' class='btn btn-default'  target='blank'><i class='fa fa-pencil fa-lg' aria-hidden='true'></i></a></center>";
    $input_co = "<div class='input-group' style='width:100%''><input type='number'  class='form-control' value='$cantReq'></input></div>";
    $input_de = "<div class='input-group' style='width:100%''><input type='number'  class='form-control' value='$diasReq'></input></div>";
    array_push($datos,array(
        "id"=>$row[0],
        "artc_articulo"=>$row[1],
        "artc_descripcion"=>$row[2],
        "minimo_inv"=>((ceil($modDias/7) * ($valorMin + ceil($valorRV) + ceil($valorSR)))),
        "proveedor"=>$row[3],
        "rmon_ultimoprecio"=>$row[4],
        "unimedida_venta"=>$row[5],
        "factor_empaque"=>$row[6],
        "porcentaje_merma"=>$row[7],
        "fechahora"=>$row[8],
        "holder"=>(ceil($modDias/7) * ($valorMin + ($valorRV) + ($valorSR))),
        "dias_req"=>$input_de,
        "cant_req"=>$input_co,
        "costo_total" =>round($costo_total,2),
        "dias"=>$diasReq,
        "cantidad"=>$cantReq/*,
        "acciones"=>$InsertCant*/
    ));
}
echo utf8_encode(json_encode($datos));