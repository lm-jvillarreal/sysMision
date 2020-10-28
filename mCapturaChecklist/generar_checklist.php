<?php
	include '../global_seguridad/verificar_sesion.php';
	$checklist = $_POST['checklist'];

	$cadena_c = mysqli_query($conexion,"SELECT nombre FROM checklist WHERE id = '$checklist'");
	$row_c    = mysqli_fetch_array($cadena_c);

    $estado = "collapse-box";
    $cadena = "SELECT sub_departamentos.id, sub_departamentos.nombre,checklist.tipo
				FROM detalle_checklist 
				INNER JOIN sub_departamentos ON sub_departamentos.id = detalle_checklist.id_subdepartamento
				INNER JOIN checklist ON checklist.id = detalle_checklist.id_checklist
				WHERE detalle_checklist.activo = '1' 
				AND detalle_checklist.programada = '1'  AND id_checklist = '$checklist'";
  	$consulta = mysqli_query($conexion, $cadena);
  	$numero = 1;
    while ($row = mysqli_fetch_row($consulta)) {
?>
	<h2><?php echo $row_c[0]?></h2>
	<div class="row">
    	<div class="col-md-12">
	      	<div class="box box-danger <?php echo $estado; ?> box-solid">
	            <div class="box-header with-border" data-widget="collapse">
	              <h3 class="box-title"><?php echo $row[1] ?></h3>
	              <!-- /.box-tools -->
	            </div>
	        	<!-- /.box-header -->
	            <div class="box-body">
	            	<div class="table-responsive">
		            	<table  class="table table-striped table-bordered" cellspacing="0" width="100%">
		            		<thead>
		                      <tr>
		                        <th style="width: 2%">#</th>
		                        <th>Actividad</th>
		                        <th style="width: 5%">Resultado</th>
		                      </tr>
		                    </thead>
			              	<?php
			                $cadena2 = "SELECT id,nombre FROM detalle_checklist WHERE id_checklist = '$checklist' AND activo = '1' AND programada = '1' AND id_subdepartamento = '$row[0]'";
			                $consulta2 = mysqli_query($conexion, $cadena2);
			                while ($row2 = mysqli_fetch_row($consulta2)) {
			                	$boton_numero = '<button class="btn btn-info contador" value="'.$numero.'">'.$numero.'</button>';
				                if($row[2] == 1){
						    		$campo = '<center><button type="button" class="btn btn-danger calificacion bloqueado" value="0" id="boton_'.$numero.'" disabled>0</button></center>';	
						    	}else{
						    		$campo = '<center><button type="button" class="btn btn-danger sino bloqueado" value="no" id="boton_'.$numero.'" disabled>No</button></center>';
						    	}
			                ?>
			                  <tr>
			                  	<td><?php echo $boton_numero;?></td>
			                  	<td><?php echo $row2[1];?></td>
			                  	<td><?php echo $campo;?></td>
			                  </tr>
			                </a>
			                <?php
			                $numero ++;
			                }
			              	?>
	              		</table>
	              	</div>
	            </div>
	        	<!-- /.box-body -->
	      	</div>
      <!-- /.box -->
    	</div>
  	</div>
<?php
    $estado = "collapsed-box";
    }
?>