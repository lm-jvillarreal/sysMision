<?php
include '../global_seguridad/verificar_sesion.php';
$fecha_inicial=$_POST['fecha_inicial'];
$fecha_final=$_POST['fecha_final'];
$sucursal=$_POST['sucursal'];
$corte_primario=$_POST['corte_primario'];
$cadenaCosteo="SELECT
                ID,
                ARTC_CODIGO,
                ARTC_CORTE,
                PROC_PROVEEDOR,
                FORMAT(ARTC_PESOENT,2),
                FORMAT(ARTC_COSTOKILO ,2)
                FROM
                carniceria_costeo 
                WHERE
                ESTATUS = 2
                AND SUCURSAL = '$sucursal'
                AND ARTC_CODIGO='$corte_primario'
                AND (DATE_FORMAT(FECHAHORA,'%Y-%m-%d')>='$fecha_inicial' AND DATE_FORMAT(FECHAHORA,'%Y-%m-%d')<='$fecha_final')";
                
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
    'artc_costokilo'=>$rowCosteo[5],
    'opciones'=>$ver
  ]);
}
echo utf8_encode(json_encode($datos));
?>