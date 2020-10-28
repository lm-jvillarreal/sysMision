<?php
	include '../global_seguridad/verificar_sesion.php';
	$fecha_completa = $fecha.' '.$hora;

  $tarea = $_POST['tarea'];
	$cadena = mysqli_query($conexion,"SELECT id,nombre,fecha,hora,activo,(SELECT personas.nombre FROM personas INNER JOIN usuarios ON usuarios.id_persona = personas.id WHERE usuarios.id = tareas_pasos.id_usuario) FROM tareas_pasos WHERE id_tarea = '$tarea' AND activo != '0'");

  $datos    = "";
  $fecha_bd = "";
  $numero   = 1;
  $estilo   = "";
  $estilo1  = "";
	while ($row = mysqli_fetch_array($cadena)) {

		$fecha_bd = $row[2].' '.$row[3];
		$date1 = new DateTime($fecha_completa);
		$date2 = new DateTime($fecha_bd);
		$diff = $date1->diff($date2);

		$horas   = ($diff->h != 0)?$diff->h	.' horas':"";
		$minutos = $diff->i	.' minutos';
		$tiempo  = $horas.' '.$minutos;

		$estilo   = ($row[4] == "2")?"class='done'":"";
		$estilo1 = ($row[4] == "2")?"checked='true'":"";

		$datos.="<li $estilo>
              <span class='handle'>
                <i class='fa fa-ellipsis-v'></i>
                <i class='fa fa-ellipsis-v'></i>
              </span>
              <input type='checkbox' value='' onchange='terminar_paso($row[0])' $estilo1>
              <span class='text' id='paso$numero' $estilo>$row[1]</span>
              <input type='text' name='nombre_paso' id='nombre_paso_$numero' class='hidden' value='$row[1]' onchange='actualizar_paso($numero,$row[0])'>
              <small class='label label-danger'><i class='fa fa-clock-o'></i> $tiempo</small>
              <small class='label label-success'>$row[5]</small>
              <div class='tools'>
                <i class='fa fa-edit' onclick='editar_paso($numero)'></i>
                <i class='fa fa-trash-o' onclick='eliminar_paso($row[0])'></i>
              </div>
            </li>";
    $numero ++;
	}
	$datos .="<li id='nuevo' style=''>
                <span class='handle'>
                  <i class='fa fa-ellipsis-v'></i>
                  <i class='fa fa-ellipsis-v'></i>
                </span>
                <input type='checkbox' value=''>
                <input type='text' name='nuevo_paso' id='nuevo_paso' class='' value='' onchange='insertar_paso(this.value)'>
                <small class='label label-danger'><i class='fa fa-clock-o'></i>--</small>
                <div class='tools'>
                  <i class='fa fa-edit'></i>
                  <i class='fa fa-trash-o'></i>
                </div>
                </li>";
	echo $datos;
?>