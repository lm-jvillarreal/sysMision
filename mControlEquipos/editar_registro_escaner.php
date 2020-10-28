<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date("Y-m-d"); 
	$hora  = date ("h:i:s");

	$id = $_POST['id'];
	
	$cadena = mysqli_query($conexion,"SELECT equipos_escaner.id,
                                        equipos_escaner.id_marca,
                                        (SELECT marca FROM marcas WHERE marcas.id = equipos_escaner.id_marca),
                                        equipos_escaner.id_modelo,
                                        (SELECT modelo FROM modelos WHERE modelos.id = equipos_escaner.id_modelo),
                                        equipos_escaner.id_caja,
                                        (SELECT CONCAT(nombre,' ',(SELECT nombre FROM sucursales WHERE sucursales.id = cajas.id_sucursal)) FROM cajas WHERE cajas.id = equipos_escaner.id_caja),
                                        equipos_escaner.serie,
                                        equipos_escaner.class_no,
                                        equipos_escaner.fecha_fabricacion,
                                        equipos_escaner.no_serial,
                                        equipos_escaner.ruta
                                    FROM
                                    equipos_escaner
                                    INNER JOIN cajas ON cajas.id = equipos_escaner.id_caja
                                    WHERE
                                    equipos_escaner.activo = '1' 
						              AND equipos_escaner.id = '$id'");

	$row = mysqli_fetch_array($cadena);

    $array  = array($row[0], //id
                    $row[1], //id_marca
                    $row[2], //marca
                    $row[3], //id_modelo
                    $row[4], //modelo
                    $row[5], //id_caja
                    $row[6], //caja
                    $row[7], //serie
                    $row[8], //class_no
                    $row[9], //fecha_fabricacion
                    $row[10], //no_serial
                    $row[11], //ruta
                    );
	$array1 = json_encode($array);
	
	echo $array1;
	
?>