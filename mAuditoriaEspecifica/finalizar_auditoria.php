<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
$fechahora=date("Y-m-d H:i:s");
$cadenaValidar="SELECT COUNT(ID) FROM vidvig_renglonesauditoria WHERE ESTATUS='1' AND USUARIO='$id_usuario'";
$consultaValidar=mysqli_query($conexion,$cadenaValidar);
$rowValidar=mysqli_fetch_array($consultaValidar);
if($rowValidar[0]>0){
  echo "no_finalizado";
}else{

  $cadenaFolio="SELECT ID FROM vidvig_auditoria WHERE ESTATUS='1'";
  $consultaFolio=mysqli_query($conexion,$cadenaFolio);
  $rowFolio=mysqli_fetch_array($consultaFolio);

  $cadenaConsolida="SELECT DISTINCT
                      ( ARTC_ARTICULO ),
                      SUM( CANTIDAD )
                    FROM
                      vidvig_renglonesauditoria
                    WHERE
                      ID_AUDITORIA = '$rowFolio[0]'
                    GROUP BY
                      ARTC_ARTICULO";
  $consultaConsolida=mysqli_query($conexion,$cadenaConsolida);
  while($rowConsolida=mysqli_fetch_array($consultaConsolida)){
    $cadenaExistencia = "SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, $id_sede, '$rowConsolida[0]') FROM dual";
    $consultaExistencia = oci_parse($conexion_central,$cadenaExistencia);
    oci_execute($consultaExistencia);
    $row_existencia = oci_fetch_row($consultaExistencia);

    $cadenaConsolidar="INSERT INTO vidvig_renglonesauditoria (ID_AUDITORIA, ARTC_ARTICULO, CANTIDAD, TEORICO, ESTATUS, FECHAHORA, ACTIVO, USUARIO)VALUES('$rowFolio[0]','$rowConsolida[0]','$rowConsolida[1]','$row_existencia[0]','0','$fechahora','1','$id_usuario')";
    $consultaConsolidar=mysqli_query($conexion,$cadenaConsolidar);
  }

  $cadenaFinalizar="UPDATE vidvig_auditoria SET ESTATUS='2' WHERE SUCURSAL='$id_sede' AND USUARIO='$id_usuario'";
  $consultaFinalizar=mysqli_query($conexion,$cadenaFinalizar);
  echo "ok";
}
?>