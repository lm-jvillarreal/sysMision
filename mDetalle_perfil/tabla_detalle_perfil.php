<?php 
include '../global_settings/conexion.php';
	$cadena_modulos = "SELECT
	detalle_perfil.id,
	perfil.nombre,
	modulos.nombre 
FROM
	detalle_perfil
	INNER JOIN perfil ON detalle_perfil.id_perfil = perfil.id
	INNER JOIN modulos ON detalle_perfil.id_modulo = modulos.id";
	//Restricción para una sola verificación
	//AND lista_proyectos.verificado='0'

	$consulta = mysqli_query($conexion, $cadena_modulos);
 ?>
	<div class="table-responsive">
        <table id="lista_perfiles" class="table table-striped table-bordered" cellspacing="0" width="100%">
	        <thead>
	            <tr>
	                <th width="5%">#</th>
	                <th>Perfil</th>
	                <th>Módulo</th>
	                <th width="10%">Editar</th>
	            </tr>
	        </thead>
	        <tbody>
	        <?php 
	        	while($row = mysqli_fetch_row($consulta))
				{	
					?>
					
					<tr>
						<td>
							<?php echo $row[0]; ?>
						</td>
						<td>
							<?php echo $row[1]?>
						</td>
						<td>
							<?php echo $row[2]; ?>
						</td>
						<td class="text-center">
							<a href="eliminar_detalle.php?id=<?php echo $row[0] ?>" class="btn btn-danger text-center"><i class="fa fa-trash" aria-hidden="true"></i></a>
						</td>
					</tr>
				<?php 
				}
				 ?>
	        </tbody>  
		</table>
	</div>