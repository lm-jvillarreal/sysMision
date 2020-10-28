<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha_actual = date('Y-m-d');
	$id_persona = $_POST['dato'];

	$cadena  = "SELECT CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno),me_control_tiempos.id FROM me_control_tiempos INNER JOIN personas ON personas.id = me_control_tiempos.id_persona
	WHERE id_persona = '$id_persona'";
	$consulta = mysqli_query($conexion, $cadena);
	$row = mysqli_fetch_array($consulta);

	$cadena_horas = mysqli_query($conexion,"SELECT tabla.Persona,tabla.Extra,tabla.Permiso,SEC_TO_TIME(tabla.Extra - tabla.Permiso)
                      FROM
                      (
                        SELECT
                            me_control_tiempos.id_persona AS Persona,
                            (
                            SELECT SUM(TIME_TO_SEC(diferencia))
                            FROM me_control_tiempos me1
                            WHERE activo = '1'
                            AND me1.id_persona = me_control_tiempos.id_persona
                            AND me1.tipo = '1'
                            ) AS Extra,
                            (
                            SELECT SUM(TIME_TO_SEC(diferencia))
                            FROM me_control_tiempos me1
                            WHERE activo = '1'
                            AND me1.id_persona = me_control_tiempos.id_persona
                            AND (me1.tipo = '2' OR me1.tipo = '3')
                            ) AS Permiso
                        FROM me_control_tiempos
                        WHERE id_persona = '$id_persona'
                        GROUP BY id_persona
                      ) AS tabla");
    $row_hora = mysqli_fetch_array($cadena_horas);

    if(strpos($row_hora[3],'-') !== false){
      	$valor = "-";
		$boton = "<button class='btn btn-danger' disabled> <i class='fa fa-money fa-lg' aria-hidden='true'></i></button>";
    }else{
		$valor = "+";
		$boton = "<a href='#' data-id = '$row[1]' data-toggle = 'modal' data-target = '#modal-default' class='btn btn-danger' target='blank'> <i class='fa fa-money fa-lg' aria-hidden='true'></i></a>";
    }

	// if($diferencia_favor > $diferencia_contra){
	// 	$valor = "+";
	// 	$boton = "<a href='#' data-id = '$row[1]' data-toggle = 'modal' data-target = '#modal-default' class='btn btn-danger' target='blank'> <i class='fa fa-money fa-lg' aria-hidden='true'></i></a>";
	// }
	// else{
	// 	$valor = "-";
	// 	$boton = "<button class='btn btn-danger' disabled> <i class='fa fa-money fa-lg' aria-hidden='true'></i></button>";
	// }

	
	$array = array($row[0],$boton);
	echo json_encode($array);
?>
