<?php
  	include '../global_seguridad/verificar_sesion.php';

  	$folio = $_POST['folio'];

  	$cadena = mysqli_query($conexion,"SELECT id,pregunta,tipo FROM n_preguntas WHERE folio = '$folio' AND activo = '1'");
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
			<?php
				if($row[2] == "1"){ //Cualitativo
					echo " 	<input type='radio' name='respuesta$numero' value='Si' checked='true'>
							<label>Si</label>
							<input type='radio' name='respuesta$numero' value='No'>
							<label>No</label>";
				}else if($row[2] == "2"){
					echo "<label>Muy Malo</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>Muy Bueno</label><br>
					<input type='radio' name='respuesta$numero' value='1' checked='true'>
						  <label>1</label>
						  <input type='radio' name='respuesta$numero' value='2'>
						  <label>2</label>
						  <input type='radio' name='respuesta$numero' value='3'>
						  <label>3</label>
						  <input type='radio' name='respuesta$numero' value='4'>
						  <label>4</label>
						  <input type='radio' name='respuesta$numero' value='5'>
						  <label>5</label>";
				}else if ($row[2] == "3"){
					echo "<input type='text' class='form-control' name='respuesta$numero' placeholder='Comentario'>".'<br>';
				}else{
					$cadena2 = mysqli_query($conexion,"SELECT id,respuesta FROM n_respuestas WHERE id_pregunta = '$row[0]' AND activo = '1'");
					$combo = "<select name='respuesta$numero' class='form-control combo2' style='width:100%'>";
					
					while ($row2 = mysqli_fetch_array($cadena2)) {
						$combo .= "<option value='$row2[0]'>$row2[1]</option>";
					}
					$combo .= "</select> <br>";
					echo $combo;
				}
			?>
		</td>
	</tr>
	<br>	
<?php
	$numero ++;
	}
?>