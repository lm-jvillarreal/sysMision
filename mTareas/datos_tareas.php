<?php
	include '../global_seguridad/verificar_sesion.php';
	$fecha_completa = $fecha.' '.$hora;

	$folio  = $_POST['folio'];
  $tarea  = (isset($_POST['tarea']))?$_POST['tarea']:"";
  $filtro = ($tarea == 0)?"":" AND id = '$tarea'";
  $filtro = "";
	$cadena = mysqli_query($conexion,"SELECT id,nombre,fecha,hora,activo, (SELECT personas.nombre FROM personas INNER JOIN usuarios ON usuarios.id_persona = personas.id WHERE usuarios.id = tareas.id_usuario) FROM tareas WHERE folio = '$folio' $filtro AND activo != '0'");
  $datos    = "";
  $fecha_bd = "";
  $numero   = 1;
  $estilo   = "";
  $estilo1  = "";
  $title    ="";
	while ($row = mysqli_fetch_array($cadena)) {

    $title = 'T-'.$row[0].'-';
    $cadena_verificar_evento = mysqli_query($conexion,"SELECT folio FROM agenda WHERE title  LIKE '$title%'");
    $existe = mysqli_num_rows($cadena_verificar_evento);
    $row_agenda = mysqli_fetch_array($cadena_verificar_evento);
    $calendario = ($existe == 0)?"<i class='fa fa-calendar-plus-o' onclick='add_calendar($row[0])'></i>":"<i class='fa fa-calendar-times-o' onclick='eliminar_agenda($row_agenda[0])'></i>";

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
                <input type='checkbox' value='' onchange='terminar_tarea($row[0])' $estilo1>
                <span class='text' id='tarea$numero' $estilo>$row[1]</span>
                <input type='text' name='nombre_tarea' id='nombre_tarea_$numero' class='hidden' value='$row[1]' onchange='actualizar_tarea($numero,$row[0])'>
                <small class='label label-danger'><i class='fa fa-clock-o'></i> $tiempo</small>
                <small class='label label-success'>$row[5]</small>
                <div class='tools'>
                  <i class='fa fa-plus-square' onclick='tareas2($row[0])'></i>
                  $calendario
                  <i class='fa fa-edit' onclick='editar_tarea($numero)'></i>
                  <i class='fa fa-trash-o' onclick='eliminar_tarea($row[0])'></i>
                </div>
             </li>";
    $numero ++;
	}
	$datos .="<li id='nuevo' style='display:none;'>
              <span class='handle'>
                <i class='fa fa-ellipsis-v'></i>
                <i class='fa fa-ellipsis-v'></i>
              </span>
              <input type='checkbox' value=''>
              <input type='text' name='nueva_tarea' id='nueva_tarea' class='form-control' value='' onchange='insertar_nueva(this.value)'>
              <small class='label label-danger'><i class='fa fa-clock-o'></i>--</small>
              <div class='tools'>
                <i class='fa  fa-calendar-plus-o'></i>
                <i class='fa fa-edit'></i>
                <i class='fa fa-trash-o'></i>
              </div>
            </li>";
	echo $datos;
?>