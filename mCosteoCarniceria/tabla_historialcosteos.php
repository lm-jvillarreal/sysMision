<?php
include '../global_seguridad/verificar_sesion.php';
$sucursal=$_POST['sucursal'];
$cadenaCosteo="SELECT
                ID,
                ARTC_CODIGO,
                ARTC_CORTE,
                PROC_PROVEEDOR,
                FORMAT(ARTC_PESOENT,2),
                FORMAT(ARTC_PESOCORTE,2),
                FORMAT(MERMA_PESO,2),
                FORMAT(MERMA_COSTO,2),
                FORMAT(ARTC_COSTOKILO ,2),
                FORMAT(ARTC_COSTOTOTAL,2),
                FORMAT(ARTC_COSTOGLOBAL,2),
                FORMAT(ARTC_COSTOKILONETO,2)
                FROM
                carniceria_costeo 
                WHERE
                ESTATUS = 1
                AND SUCURSAL = '$sucursal'
                AND DATE_FORMAT(FECHAHORA,'%Y-%m-%d')='$fecha'";
$datos=[];
$consultaCosteo=mysqli_query($conexion,$cadenaCosteo);
while($rowCosteo=mysqli_fetch_array($consultaCosteo)){
  $ver = "<center><a href='#' data-folio = '$rowCosteo[0]' data-toggle = 'modal' data-target = '#modal_costeorenglones' class='btn btn-primary btn-sm'><i class='fa fa-search fa-lg' aria-hidden='true'></i></a></center>";
  array_push($datos,[
    'id'=>$rowCosteo[0],
    'artc_articulo'=>$rowCosteo[1],
    'artc_descripcion'=>$rowCosteo[2],
    'proc_proveedor'=>$rowCosteo[3],
    'artc_pesoent'=>$rowCosteo[4],
    'artc_pesocorte'=>$rowCosteo[5],
    'merma_peso'=>$rowCosteo[6],
    'merma_costo'=>$rowCosteo[7],
    'artc_costokilo'=>$rowCosteo[8],
    'artc_costototal'=>$rowCosteo[9],
    'artc_costoglobal'=>$rowCosteo[10],
    'artc_costokiloneto'=>$rowCosteo[11],
    'opciones'=>$ver
  ]);
}
echo utf8_encode(json_encode($datos));
?>