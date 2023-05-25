<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
$fechahora=date('Y-m-d H:i:s');
$id=$_POST['id'];
$artc_articulo=$_POST['artc_articulo'];
$sucursal=$_POST['sucursal'];
$observacion=$_POST['comentario'];

$cadenaExistencia="SELECT spin_articulos.fn_existencia_disponible_todos(13, NULL, NULL, 1, 1, $sucursal, $artc_articulo)FROM dual";
$consulta_existencia = oci_parse($conexion_central, $cadenaExistencia);
oci_execute($consulta_existencia);
$rowExistencia=oci_fetch_row($consulta_existencia);

$cadenaLiberar="UPDATE revision_faltantes SET ACTIVO='2', OBSERVACIONES='$observacion', TEORICO_AJUSTE='$rowExistencia[0]', FECHAHORA_AJUSTE='$fechahora' WHERE ID='$id'";
$liberar=mysqli_query($conexion,$cadenaLiberar);
echo "ok";
?>