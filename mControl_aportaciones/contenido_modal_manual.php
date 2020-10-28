<?php
include '../global_settings/conexion.php';

$id_registro = $_POST['id'];

$cadena_nc = "SELECT 
				aportaciones.id,
			    aportaciones.tipo_movimiento,
				aportaciones.folio_movimiento, 
				aportaciones.cve_proveedor, 
				aportaciones.nombre_proveedor, 
				aportaciones.fecha_afectacion, 
				sucursales.nombre, 
				CONCAT('$',FORMAT(aportaciones.total,2)),
			    CONCAT(personas.nombre,' ',personas.ap_paterno, ' ',personas.ap_materno),
			    aportaciones.metodo_pago,
			    aportaciones.referencia
			FROM aportaciones 
			INNER JOIN sucursales ON aportaciones.id_sucursal = sucursales.id
			INNER JOIN usuarios ON aportaciones.usuario = usuarios.id
			INNER JOIN personas ON usuarios.id_persona = personas.id
			AND aportaciones.id = '$id_registro'";

$consulta_nc = mysqli_query($conexion, $cadena_nc);

$row_nc = mysqli_fetch_array($consulta_nc);

$imprimir = '
<div class="container">
	<div class="col-md-12">
		<label>Folio:&nbsp;</label>'.$row_nc[2].'<br>
		<label>Clave del Proveedor:&nbsp;</label>'.$row_nc[3].'<br>
		<label>Nombre del Proveedor:&nbsp;</label>'.$row_nc[4].'<br>
		<label>Método de pago:&nbsp;</label>'.$row_nc[9].'<br>
		<label>Total:&nbsp;</label>'.$row_nc[7].'<br>
		<label>Referencia:&nbsp;</label>'.$row_nc[10].'<br>
		<label>Realizó:&nbsp;</label>'.$row_nc[8].'<br>
	</div>
</div>
';

echo $imprimir;
?>