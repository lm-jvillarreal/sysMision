<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
$artc_articulo = $_POST['artc_articulo'];
$folio=$_POST['folio'];
$categoria=$_POST['categoria'];
$cadena_consulta = "SELECT 
                      (SELECT FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE FAM.FAMC_FAMILIAPADRE = COM_FAMILIAS.FAMC_FAMILIA AND ROWNUM =1) AS Departamento,
                      FAM.FAMC_DESCRIPCION,
                      COM_ARTICULOS.ARTC_ARTICULO, 
                      COM_ARTICULOS.ARTC_DESCRIPCION
                    FROM COM_ARTICULOS
                      INNER JOIN COM_FAMILIAS FAM ON FAM.FAMC_FAMILIA = COM_ARTICULOS.ARTC_FAMILIA
                      WHERE com_articulos.artc_articulo = '$artc_articulo'";

$st = oci_parse($conexion_central, $cadena_consulta);
oci_execute($st);

$row_producto = oci_fetch_row($st);
$departamento = $row_producto[0];
$familia = $row_producto[1];
$descripcion = $row_producto[3];

$existe = oci_num_rows($st);
if($existe==0){
  echo "no_existe";
}else{
  $cadenaValidar="SELECT COUNT(ARTC_ARTICULO) FROM vidvig_categorias WHERE FOLIO='$folio' AND ARTC_ARTICULO='$artc_articulo'";
  $consultaValidar=mysqli_query($conexion,$cadenaValidar);
  $rowValidar=mysqli_fetch_array($consultaValidar);
  if($rowValidar[0]>0){
    echo "ya_registrado";
  }else{
    $cadena_insertar = "INSERT INTO vidvig_categorias (FOLIO, CATEGORIA, ARTC_ARTICULO, ARTC_DESCRIPCION, FECHAHORA, ACTIVO, USUARIO)VALUES('$folio', '$categoria', '$artc_articulo', '$descripcion', '$fechahora', '1', '$id_usuario')";
    $consulta_insertar=mysqli_query($conexion, $cadena_insertar);
    echo $rowValidar[0];
  }

  
}
?>