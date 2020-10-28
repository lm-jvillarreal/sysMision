<?php
include 'global_settings/conexion.php';
$cadena_cumple = "SELECT id, CONCAT(nombre, ' ',ap_paterno), fecha_nac FROM personas WHERE DATE_FORMAT(fecha_nac, '%m%d') = DATE_FORMAT(CURDATE(),'%m%d')";
$consulta_cumple = mysqli_query($conexion, $cadena_cumple);
$conteo = mysqli_num_rows($consulta_cumple);
if ($conteo == 0) {
?>
<li>
	<a href="#">
		<h4>
			Hoy no hay cumpleaños.
			<small><i class="fa fa-birthday-cake"></i></small>
		</h4>
	</a>
</li>
<?php
} else {
	while ($row_cumple = mysqli_fetch_array($consulta_cumple)) {
		$cumpleanos = new DateTime($row_cumple[2]);
		$hoy = new DateTime();
		$annos = $hoy->diff($cumpleanos);
?>
<li>
	<a href="#">
		<div class="pull-left">
			<img src="../d_plantilla/dist/img/personas/user.jpg" class="img-circle" alt="User Image">
		</div>
		<h4>
			<?php echo $row_cumple[1] . ' | ' . $annos->y;?>
			<small><i class="fa fa-birthday-cake"></i></small>
		</h4>
		<p>Felicítalo por su cumpleaños!</p>
	</a>
</li>
	<?php
}
}
//echo $annos->y;
?>