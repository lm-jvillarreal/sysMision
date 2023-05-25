<?php
include '../global_seguridad/verificar_sesion.php';

//Fecha y hora actual
  date_default_timezone_set('America/Monterrey');
  $fecha=date("Y-m-d"); 
  $hora=date ("h:i:s");

$fecha_inicial = (!isset($_POST['fecha_inicio'])) ? $fecha : $_POST['fecha_inicio'];
$fecha_final = (!isset($_POST['fecha_fin'])) ? $fecha : $_POST['fecha_fin'];
$tipo_entrada=$_POST['tipo_entrada'];

$filtro_sucursal = ($solo_sucursal == '1') ? " AND le.sucursal = '$id_sede'" : "";

$cadena_ordenes = "SELECT
						le.id_proveedor,
                        (SELECT CONCAT(numero_proveedor,' ',proveedor) FROM proveedores WHERE numero_proveedor = le.id_proveedor GROUP BY numero_proveedor),
					    DATE_FORMAT(orden_compra.fecha_final, '%d/%m/%Y'),
						le.numero_nota, 
						le.numero_factura,
						le.total,
					    orden_compra.hora_inicio,
						orden_compra.hora_final,
					    TIMEDIFF(orden_compra.hora_final, orden_compra.hora_inicio),
					    le.observaciones,
						le.id,
						le.activo,
						le.sucursal,
						le.orden_compra
					FROM
						libro_diario as le 
					INNER JOIN orden_compra ON le.orden_compra = orden_compra.id
                    AND le.sucursal = orden_compra.id_sucursal
					WHERE le.tipo = '$tipo_entrada' AND (le.fecha >= '$fecha_inicial'
					AND le.fecha <= '$fecha_final')".
					$filtro_sucursal."
					ORDER BY le.numero_nota ASC";

//echo $cadena_ordenes;
$consulta_ordenes = mysqli_query($conexion, $cadena_ordenes);
$cuerpo = "";

while ($row_ordenes = mysqli_fetch_array($consulta_ordenes)) {

	if ($row_ordenes[11]=='5') {
		$liberar = "<center><span class='label label-danger'>Cancelado</span></center>";
	}elseif($row_ordenes[11]=='1'){
		$liberar = "<center><span class='label label-success'>Recibido</span></center>";
	}
	$reimprimir = "<center><a href='#' onclick='imp_folio($row_ordenes[13])'>$row_ordenes[3]</a></center>";

	$cadena_validaCF = "SELECT id FROM carta_faltante WHERE id_orden = '$row_ordenes[13]'";
	$validaCF = mysqli_query($conexion, $cadena_validaCF);
	$row_validaCF = mysqli_fetch_array($validaCF);
	$conteo = count($row_validaCF);
	if($conteo==0){
    $generar_cartas = "<center><a href='../mLiberar_orden/anexarAfter_cf.php?id=$row_ordenes[10]' class='btn btn-danger'>CF</a></center>";
    $generar_carta="";
	}elseif($conteo>0){
		$generar_carta = "<a target='blank' href='../mCartas_faltantes/carta_faltante_pdf.php?id=$row_validaCF[0]'>$row_validaCF[0]</a>";
	}
	$renglon = "
		{
			\"folio\": \"$reimprimir\",
			\"generar_carta\": \"$generar_carta\",
	   	\"no_proveedor\": \"$row_ordenes[1]\",
	   	\"fecha_entrada\": \"$row_ordenes[2]\",
	   	\"factura\": \"$row_ordenes[4]\",
	   	\"total\": \"$row_ordenes[5]\",
	   	\"hora_inicio\": \"$row_ordenes[6]\",
	   	\"hora_final\": \"$row_ordenes[7]\",
	   	\"tiempo_total\": \"$row_ordenes[8]\",
	   	\"observaciones\": \"$row_ordenes[9]\",
	   	\"sucursal\": \"$row_ordenes[12]\",
			\"cancelar\": \"$liberar\"
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
//echo $liberar;
