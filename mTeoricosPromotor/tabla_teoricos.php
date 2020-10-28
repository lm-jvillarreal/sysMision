<?php
include '../global_settings/conexion.php';
include '../global_settings/conexion_oracle.php';
//Fecha y hora actual
  date_default_timezone_set('America/Monterrey');
  $fecha=date("Y-m-d"); 
  $hora=date ("h:i:s");

$id_promotor = $_POST['promotor'];

//$fecha_inicio = (!isset($_POST['fecha_inicial'])) ? $fecha : $_POST['fecha_inicial'];
//$fecha_fin = (!isset($_POST['fecha_final'])) ? $fecha : $_POST['fecha_final'];
//$sucursal = ($_POST['sucursal']=="") ? "" : " AND ALMN_ALMACEN ='".$_POST['sucursal']."'";

$cadena_proveedor = "SELECT clave_proveedor FROM promotores WHERE id='$id_promotor'";
$consulta_proveedor = mysqli_query($conexion,$cadena_proveedor);
$row_proveedor = mysqli_fetch_array($consulta_proveedor);
$proveedor = trim($row_proveedor[0]);
//echo $cadena_proveedor;
$cadena_traspasos = "SELECT DISTINCT
                    LIS.ARTC_ARTICULO,
                    artic.ARTC_DESCRIPCION,
                    (SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 1, LIS.ARTC_ARTICULO) FROM dual)
                    FROM
                    COM_ARTICULOSLISTAPRECIOS lis
                    INNER JOIN PV_ARTICULOS artic ON artic.ARTC_ARTICULO = LIS.ARTC_ARTICULO
                    INNER JOIN COM_FAMILIAS familia ON familia.FAMC_FAMILIA = artic.ARTC_FAMILIA
                    INNER JOIN  CXP_PROVEEDORES prov ON trim(prov.PROC_CVEPROVEEDOR) = LIS.PROC_CVEPROVEEDOR 	
                    WHERE
                    lis.PROC_CVEPROVEEDOR = '$proveedor'";
//echo $cadena_traspasos;
$cuerpo ="";

$consulta_traspasos = oci_parse($conexion_central, $cadena_traspasos);
                  oci_execute($consulta_traspasos);
$i=1;
while ($row_traspasos = oci_fetch_row($consulta_traspasos)) {
	$renglon = "
		{
		\"id\": \"$i\",
        \"codigo_artc\": \"$row_traspasos[0]\",
        \"desc_artc\": \"$row_traspasos[1]\",
        \"existencia\": \"$row_traspasos[2]\"
	  },";
    $cuerpo = $cuerpo.$renglon;
    $i=$i+1;
}
$cuerpo2 = trim($cuerpo, ',');
$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>