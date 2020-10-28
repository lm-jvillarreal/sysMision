<script>
	$(document).ready(function() {
		$('#example').dataTable( {
				 "language":
				 	{"url": "../assets/js/Spanish.json" },
				 	"lengthMenu":
          		[[-1], [ "All"]],
		    });
		});
</script>
<?php

    //include '../global_settings/conexion_pruebas.php';
	// $pId_sucursal = $_POST['id_sucursal'];
	// $sucursal = $_SESSION["s_Sucursal"];
	// $s_idPerfil = $_SESSION["sTipoUsuario"];
	$pId_sucursal = "1";
	if ($pId_sucursal == "") {
		$qry = "SELECT
					mapeo.id,
					mapeo.zona,
					mapeo.mueble,
					mapeo.cara,
					mapeo.fecha,
					mapeo.id_sucursal,
					areas.nombre,
					sucursales.nombre,
					usuarios.nombre_usuario
				FROM
					inv_mapeo mapeo 
				INNER JOIN areas ON areas.id = mapeo.id_area
				INNER JOIN usuarios ON mapeo.usuario = usuarios.id
				inner join sucursales on sucursales.id = mapeo.id_sucursal
				WHERE 
					mapeo.completo = 0
				AND mapeo.contador = 9
				AND mapeo.supervisor = 3
				AND mapeo.auditor = 2
				AND mapeo.id_sucursal = '$id_sede'
				";
		
	}else{
		$qry = "SELECT
					mapeo.id,
					mapeo.zona,
					mapeo.mueble,
					mapeo.cara,
					mapeo.fecha,
					mapeo.id_sucursal,
					areas.nombre,
					sucursales.nombre,
					usuarios.nombre_usuario
				FROM
					inv_mapeo mapeo
				INNER JOIN areas ON areas.id = mapeo.id_area
				INNER JOIN usuarios ON mapeo.usuario = usuarios.id
				inner join sucursales on sucursales.id = mapeo.id_sucursal
				WHERE 
					mapeo.completo = 0
				AND mapeo.contador = 9
				AND mapeo.supervisor = 3
				AND mapeo.auditor = 2
				AND mapeo.id_sucursal = '$id_sede'
				";
	}
	//echo "$qry";
	$consulta = mysqli_query($conexion, $qry);
 ?>
	<div class="table-responsive">
		<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
	        <thead>
	            <tr>
	            	<th>Sucursal</th>
	            	<th>Area</th>
	                <th>Zona</th>
	                <th>Mueble</th>
					<th>Cara</th>
					<th>Fecha</th>
					<th>Usuario</th>
					<th>Continuar</th>
					<th>Eliminar</th>
	            </tr>
	        </thead>
	        <tbody>
	        <?php
	        	while($row = mysqli_fetch_array($consulta))
				{	?>
					<tr>
						<td><?php echo $row[7] ?></td>
						<td>
							<?php echo $row[6] ?>
						</td>
						<td>
						<center>
							<?php echo $row[1]; ?>
            			</center>
						</td>
						<td>
							<?php echo "$row[2]"; ?>
						</td>
						<td>
							<?php echo "$row[3]"; ?>
						</td>
						<td>
							<?php echo "$row[4]"; ?>
						</td>
						<td><?php echo $row[8] ?></td>
						<td align="center" width="5%">
							<a href="javascript:editar(<?php echo"$row[0]"; ?>, '<?php echo"$row[1]"; ?>', '<?php echo"$row[2]" ?>', '<?php echo"$row[3]" ?>');" onclick="javascript:estante_consecutivo(<?php echo $row[0] ?>)">
								<i class="fa fa-exclamation fa-2x color-icono" aria-hidden="true">
								</i>
							</a>
						</td>
						<td align="center">
							<a href="javascript:eliminar_prelistado(<?php echo"$row[0]"; ?>, <?php echo"$row[5]" ?>)">
								<i class="fa fa-trash fa-2x color-icono" aria-hidden="true">
								</i>
							</a>
						</td>
					</tr>
				<?php
				}
				 ?>
	        </tbody>
		</table>
