<?php
include '../global_seguridad/verificar_sesion.php';
$datos=array();
$cadenaCategorias="SELECT DISTINCT
                    ( FOLIO ),
                    CATEGORIA,
                    ( SELECT COUNT( * ) FROM vidvig_categorias WHERE FOLIO = c.FOLIO ) AS CANTIDAD 
                    FROM
                    vidvig_categorias AS c";
$consultaCategorias=mysqli_query($conexion,$cadenaCategorias);
while($rowCategorias=mysqli_fetch_array($consultaCategorias)){
  $ver = "<center><a href='#' data-categoria = '$rowCategorias[0]' data-cat = '$rowCategorias[1]' data-toggle = 'modal' data-target = '#modal-detalle' class='btn btn-primary' target='blank'><i class='fa fa-search fa-lg' aria-hidden='true'></i></a></center>";
  array_push($datos,array(
    'folio'=>$rowCategorias[0],
    'categoria'=>$rowCategorias[1],
    'cantidad'=>$rowCategorias[2],
    'opciones'=>$ver
  ));
}
echo utf8_encode(json_encode($datos));
?>