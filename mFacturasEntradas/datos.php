<?php 
	include '../global_settings/conexion.php';
	include '../global_settings/conexion_oracle.php';
	  $id_nota =$_POST['folio'];
	  $select = "SELECT
                id,
                folio_mov,
                tipo_mov,
                id_sucursal
              FROM
                notas_entrada
              WHERE
                id = '$id_nota'";
    $exSelect = mysqli_query($conexion, $select);
    $row = mysqli_fetch_row($exSelect);

    $qry = "SELECT
              ARTC_ARTICULO,
              ARTC_DESCRIPCION,
              RMON_CANTSURTIDA
            FROM
              INV_RENGLONES_MOV_DESC_VW
            WHERE
              MODN_FOLIO = '$row[1]'
            AND ALMN_ALMACEN = '$row[3]'
            AND MODC_TIPOMOV = '$row[2]'";
             //echo "$qry";
      $st = oci_parse($conexion_central, $qry);
      oci_execute($st);

 $cuerpo ="";
$n =1;
while ($row_gastos = oci_fetch_array($st)) {

	$sel_dif = "SELECT id_nota, codigo_producto, cantidad, diferencia, total FROM detalle_nota WHERE id_nota = '$id_nota' AND codigo_producto = '$row[0]'";
            $exSdif = mysqli_query($conexion, $sel_dif);
            $row_d = mysqli_fetch_row($exSdif);
            $check = "<input type='checkbox'>";

            $input = "<input value='$row_d[3]' id='dif_$n' class='form-control' type='text'>";

        	$cantidad = "<input class= 'form-control' type='text' id='cantidad_ $n;' value='$row_gastos[2]' readonly>";
        	$total = "<input readonly value= '$row_d[4]' type='text' id='total_<? echo $n ?>' class='form-control'>";

	$renglon = "
		{
		\"a\": \"$check\",
		\"articulo\": \"$row_gastos[0]\",
		\"descrpicion\": \"$row_gastos[1]\",
		\"cantidad\": \"$cantidad\",
		\"dif\": \"$input\",
		\"total\": \"$total\"
		},";
	$cuerpo = $cuerpo.$renglon;
	$n++;
}
$cuerpo2 = trim($cuerpo, ',');

$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>