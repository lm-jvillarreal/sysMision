<?php
include '../global_seguridad/verificar_sesion.php';
$datos=array();
$cadenaDetalle="SELECT
                  r.ID,
                  r.ID_AUDITORIA,
                  r.ARTC_ARTICULO,
                  ( SELECT ARTC_DESCRIPCION FROM vidvig_categorias WHERE ARTC_ARTICULO = r.ARTC_ARTICULO LIMIT 1 ) DESCRIPCION,
                  ( SELECT AREA FROM vidvig_areas WHERE ID = r.ID_AREA ) AREA,
                  r.CANTIDAD
                FROM
                vidvig_renglonesauditoria AS r
                INNER JOIN vidvig_auditoria AS a ON r.ID_AUDITORIA = a.ID 
                WHERE
                  r.ID_AREA = ( SELECT MIN( ID_AREA ) FROM vidvig_renglonesauditoria WHERE ESTATUS = 1 ) 
                  AND a.SUCURSAL = '$id_sede'
                  AND a.ESTATUS='1'";
$consultaDetalle=mysqli_query($conexion,$cadenaDetalle);
while($rowDetalle=mysqli_fetch_array($consultaDetalle)){
  $cadenaActualiza="UPDATE vidvig_renglonesauditoria SET CANTIDAD='$cantidad', ESTATUS='2' WHERE ID='$rowDetalle[0]'";
  $actualizaCantidad=mysqli_query($conexion,$cadenaActualiza);
}
echo "ok";
?>
