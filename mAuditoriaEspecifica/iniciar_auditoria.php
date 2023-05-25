<?php
include '../global_seguridad/verificar_sesion.php';
$fechahora=date("Y-m-d H:i:s");

$auditor = $_POST['auditor'];
$categoria = $_POST['categoria'];

$cadenaValidar ="SELECT COUNT(ID) FROM vidvig_auditoria WHERE SUCURSAL='$id_sede' AND ESTATUS=1";
$validarEstatus=mysqli_query($conexion,$cadenaValidar);
$rowValidar=mysqli_fetch_array($validarEstatus);
if($rowValidar[0]>0){
  echo"pendientes";
}else{
  $cadena_auditoria="INSERT INTO vidvig_auditoria (ID_AUDITOR, ID_CATEGORIA, FECHAHORA, ACTIVO, USUARIO, SUCURSAL, ESTATUS)VALUES('$auditor','$categoria','$fechahora','1','$id_usuario','$id_sede','1')";
  $consulta_auditoria=mysqli_query($conexion,$cadena_auditoria);

  $cadenaConsulta="SELECT MAX(ID) FROM vidvig_auditoria";
  $consultaAuditoria=mysqli_query($conexion,$cadenaConsulta);
  $rowAuditoria=mysqli_fetch_array($consultaAuditoria);

  $cadenaAreas="SELECT ID FROM vidvig_areas WHERE ACTIVO = '1'";
  $consutaAreas = mysqli_query($conexion, $cadenaAreas);
  while($rowAreas=mysqli_fetch_array($consutaAreas)){
    $cadenaArticulos="SELECT ARTC_ARTICULO, ARTC_DESCRIPCION FROM vidvig_categorias WHERE FOLIO='$categoria'";
    $consultaArticulos = mysqli_query($conexion,$cadenaArticulos);
    while($rowArticulos=mysqli_fetch_array($consultaArticulos)){
      $cadenaRenglones="INSERT INTO vidvig_renglonesauditoria (ID_AUDITORIA, ARTC_ARTICULO, ID_AREA, ESTATUS, FECHAHORA, ACTIVO, USUARIO)VALUES('$rowAuditoria[0]','$rowArticulos[0]','$rowAreas[0]','1','$fechahora','1','$id_usuario')";
      $insertarRenglones=mysqli_query($conexion,$cadenaRenglones);
    }
  }
}
?>