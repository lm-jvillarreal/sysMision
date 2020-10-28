<script>
	$(document).ready(function() {
		$('#example').dataTable( {
				 "language":
				 	{"url": "../assets/js/Spanish.json" },
				 	"lengthMenu":
          [[-1], [ "All"]]
		    });
		});
</script>
<?php
    //include '../global_seguridad/.php';
	//session_name("login_supsys"); 
	//session_start(); 
	//$id_sucursal = $_SESSION['id_sucursal'];
	//$s_idPerfil = $_SESSION["sTipoUsuario"];
	//$var = $_SESSION["id_sucursal"]; 
	$qry = "SELECT
				mapeo.id,
				mapeo.zona,
				mapeo.mueble,
				mapeo.cara,
				mapeo.fecha,
				mapeo.impreso,
				sucursales.nombre
			FROM
				inv_mapeo mapeo
			INNER JOIN sucursales ON sucursales.id = mapeo.id_sucursal
			WHERE
				mapeo.activo = 1
			AND mapeo.completo = 1
			AND mapeo.contador = 2";
	$consulta = mysqli_query($conexion, $qry);
 ?>
	<div class="table-responsive">
		<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
	        <thead>
	            <tr>
	            	<th>Sucursal</th>
	                <th>Zona</th>
	                <th>Mueble</th>
					<th>Cara</th>
					<th>Fecha</th>
					<th>Capturar</th>
	            </tr>
	        </thead>
	        <tbody>
	        <?php
	        	while($row = mysqli_fetch_array($consulta))
				{	?>
					<tr>
						<td align="center">
							<?php echo "$row[6]"; ?>
						</td>
						<td align="center">
							<?php echo $row[1]; ?>
						</td>
						<td align="center">
							<?php echo "$row[2]"; ?>
						</td>
						<td align="center">
							<?php echo "$row[3]"; ?>
						</td>
						<td align="center">
							<?php echo "$row[4]"; ?>
						</td>
						<td align="center" width="5%">
							<a href="javascript:buscar('<?php echo "$row[0]"; ?>', '<?php echo "$row[1]"; ?>', '<?php echo "$row[2]"; ?>', '<?php echo "$row[3]"; ?>');"><i class="fa fa-eye fa-2x color-icono" aria-hidden="true"></i></a>
							</a>
						</td>
					</tr>
				<?php
				}
				 ?>
	        </tbody>
		</table>
