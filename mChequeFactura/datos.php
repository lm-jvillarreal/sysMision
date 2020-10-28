<?php 
	include '../global_settings/conexion_oracle.php';
	$factura = $_POST['factura'];


	ini_set('max_execution_time', 1000); 

	$qry = "SELECT 
			    docs.proc_cveproveedor, (docs.DOCN_IMPORTE + docs.DOCN_IVA), docs.docn_numcheque, CXP_PROVEEDORES.PROC_NOMBRE
			FROM CXP_DOCUMENTOS docs
			INNER JOIN CXP_PROVEEDORES on CXP_PROVEEDORES.PROC_CVEPROVEEDOR = docs.proc_cveproveedor
			WHERE docs.CXPC_NUMFACT = '$factura' 
			AND docs.DOCN_TIPOPAGO = 0";
	$st = oci_parse($conexion_central, $qry);
	oci_execute($st);

 $cuerpo ="";

while ($row_gastos = oci_fetch_array($st)) {
	$link_detalle = "<center><a href='#' data-id = '$row_gastos[0]' data-toggle = 'modal' data-target = '#modal-default' class='btn btn-danger' target='blank'>$row_gastos[0]</a></center>";
	$renglon = "
		{
		\"clave\": \"$row_gastos[0]\",
		\"proveedor\": \"$row_gastos[3]\",
		\"factura\": \"$factura\",
		\"importe\": \"$row_gastos[1]\",
		\"cheque\": \"$row_gastos[2]\"
		},";
	$cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');

$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>