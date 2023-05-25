<?php
include '../global_seguridad/verificar_sesion.php';
$datos=array();
$cadenaAuditorias="SELECT
                    R.ID_AUDITORIA,
                    ( SELECT CATEGORIA FROM vidvig_categorias AS C INNER JOIN vidvig_auditoria AS V ON C.ID = V.ID_CATEGORIA WHERE V.ID = R.ID_AUDITORIA ) CATEGORIA,
                    (
                    SELECT
                      CONCAT( V.NOMBRE, ' ', V.AP_PATERNO, ' ', V.AP_MATERNO ) 
                    FROM
                      vidvig_auditoria AS A
                      INNER JOIN vidvig_vigilantes AS V ON A.ID_AUDITOR = V.ID 
                    WHERE
                      A.ID = R.ID_AUDITORIA 
                    ) AUDITOR,
                    R.ARTC_ARTICULO,
                    ( SELECT ARTC_DESCRIPCION FROM vidvig_categorias WHERE ARTC_ARTICULO = R.ARTC_ARTICULO ) DESCRIPCION,
                    R.CANTIDAD,
                    R.TEORICO,
                    ( R.CANTIDAD - R.TEORICO ) DIF,
                    ( SELECT nombre FROM sucursales AS S INNER JOIN vidvig_auditoria AS A ON S.id = A.SUCURSAL WHERE A.ID = R.ID_AUDITORIA ) SUCURSAL,
                    R.FECHAHORA,
                    R.ID 
                    FROM
                    vidvig_renglonesauditoria AS R 
                    WHERE
                    R.ESTATUS = '0'";
$consultaAuditorias=mysqli_query($conexion,$cadenaAuditorias);
while($rowAuditorias=mysqli_fetch_array($consultaAuditorias)){
  $ver = "<center><a href='#' onclick='recontar($rowAuditorias[10])' class='btn btn-danger'><i class='fa fa-refresh fa-lg' aria-hidden='true'></i></a></center>";
  array_push($datos,array(
    'folio'=>$rowAuditorias[0],
    'categoria'=>$rowAuditorias[1],
    'vigilante'=>$rowAuditorias[2],
    'artc_articulo'=>$rowAuditorias[3],
    'artc_descripcion'=>$rowAuditorias[4],
    'conteo'=>$rowAuditorias[5],
    'teorico'=>$rowAuditorias[6],
    'diferencia'=>$rowAuditorias[7],
    'sucursal'=>$rowAuditorias[8],
    'fechahora'=>$rowAuditorias[9],
    'opciones'=>$ver
  ));
}
echo utf8_encode(json_encode($datos));
?>