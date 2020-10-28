<table class="table table-striped table-bordered" cellspacing="0" width="100%" id="encuesta">
  	<thead>
    	<tr>
      		<th width="5%">#</th>
      		<th>Pregunta</th>
      		<th width="45%">Respuesta</th>
    	</tr>
  	</thead>
  	<tbody>
	<?php
		include '../global_settings/conexion.php';	
		$id = $_POST['id'];
		$cadena_encuesta = mysqli_query($conexion,"SELECT comentario FROM s_encuestas WHERE folio = '$id'");
		$row_encuesta = mysqli_fetch_array($cadena_encuesta);
		$cadena = mysqli_query($conexion,"SELECT id,pregunta FROM s_preguntas WHERE folio = '$id'");
		$numero = 1;
		while ($row = mysqli_fetch_array($cadena)) {
	?>
		<tr>
			<td>
				<label><?php echo $numero.'.-';?></label>
			</td>
			<td>
				<label><?php echo $row[1]?></label>
			</td>
			<td>
				<input type="hidden" name="encuesta" class="form-control" value="<?php echo $id;?>">
				<input type="hidden" name="pregunta[]" class="form-control" value="<?php echo $row[0]?>">
				<input type="text" name="respuesta[]" class="form-control" placeholder='Respuesta'>
			</td>
		</tr>
	<?php
		$numero ++;
		}	
	?>
	<tbody>
</table>  
<?php
	if($row_encuesta[0] == "1"){
?>
	<label for="">*Comentario Libre</label>
	<br>
	<textarea name="comentario" id="comentario" cols="111" rows="5" style="resize:none;" class="form-control" placeholder="Añade tu Comentario"></textarea>
<?php
	}
?>	