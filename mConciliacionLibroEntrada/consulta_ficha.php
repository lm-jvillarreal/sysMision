<?php
include '../global_seguridad/verificar_sesion.php';
$ficha_entrada = $_POST['ficha_entrada'];
$cadenaFicha = "SELECT  l.id,
                        l.sucursal,
                        l.numero_nota,
                        l.orden_compra,
                        (SELECT DISTINCT(TRIM(numero_proveedor)) FROM proveedores WHERE numero_proveedor = l.id_proveedor) as 'Proveedor',
                        (SELECT DISTINCT(proveedor) FROM proveedores WHERE numero_proveedor = l.id_proveedor) as 'Proveedor',
                        l.numero_factura,
                        l.total as 'Total Factura',
                        l.observaciones,
                        date_format(l.fecha,'%d/%m/%Y') as fecha
                    FROM libro_diario as l where l.numero_nota = '$ficha_entrada'";
$consultaFicha = mysqli_query($conexion,$cadenaFicha);



$rowFicha = mysqli_fetch_array($consultaFicha);

$array = array(
  $rowFicha[4],//Clave proveedor
  $rowFicha[5],//Nombre proveedor
  $rowFicha[6],//Numero de remision
  $rowFicha[7], //Total de remisión  
  $rowFicha[0]
);
$array = json_encode($array);
echo $array;
?>