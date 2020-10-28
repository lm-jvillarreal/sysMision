<?php

$concepto = $_POST['concepto'];
$cantidad = $_POST['cantidad'];

$cant_concepto = count($concepto);
$cant_cantidad = count($cantidad);

for ($i=0; $i <= $cant_cantidad ; $i++) { 
	echo $concepto[$i];
	echo $cantidad[$i];
}

?>