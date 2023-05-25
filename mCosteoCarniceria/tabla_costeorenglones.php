<?php
include '../global_seguridad/verificar_sesion.php';
$datos=[];
$id_costeo=$_POST['id_costeo'];
$cadenaRenglones="SELECT
                  ARTC_ARTICULO,
                  ARTC_DESCRIPCION,
                  FORMAT(ARTC_CANTIDAD,2),
                  FORMAT(ARTC_PORCENTAJE,2),
                  FORMAT(ARTC_COSTOTOTAL,2),
                  FORMAT(ARTC_COSTOUNITARIO,2),
                  FORMAT(ARTC_MARGEN,2),
                  FORMAT(ARTC_PRECIOVENTA,2),
                  ID
                  FROM
                  carniceria_costeorenglones
                  WHERE ID_COSTEO='$id_costeo'";
$consultaRenglones=mysqli_query($conexion,$cadenaRenglones);
$i=1;
while($rowRenglones=mysqli_fetch_array($consultaRenglones)){
  $pepub = "<center><a href='#' onclick='cambiar_precio($rowRenglones[8])' class='btn btn-danger btn-sm'><i class='fa fa-usd fa-lg' aria-hidden='true'></i></a></center>";
  array_push($datos,[
    'numero'=>$i,
    'artc_articulo'=>$rowRenglones[0],
    'artc_descripcion'=>$rowRenglones[1],
    'artc_cantidad'=>$rowRenglones[2],
    'artc_porcentaje'=>$rowRenglones[3],
    'artc_costototal'=>$rowRenglones[4],
    'artc_costounitario'=>$rowRenglones[5],
    'artc_margen'=>$rowRenglones[6],
    'artc_precioventa'=>$rowRenglones[7],
    'opciones'=>$pepub
  ]);
  $i++;
}
echo utf8_encode(json_encode($datos));
?>