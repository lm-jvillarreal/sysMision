<?php
    include '../global_seguridad/verificar_sesion.php';
    
    function ultimo_dia() { 
        $month = date('m');
        $year = date('Y');
        $day = date("d", mktime(0,0,0, $month+1, 0, $year));
        return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
    };
    $fecha2 = ultimo_dia();
    
    $id_registro = $_POST['id_registro'];
    $id_caja    = $_POST['id_caja'];
    $id_equipo = $_POST['id_equipo'];
    $tipo = $_POST['tipo'];
    if($tipo == 1){
        if(!isset($_POST['id_falla'])){
            echo "vacio";
            return false;
        }else{
            $falla = $_POST['id_falla'];
        }
    }else{
        $falla = $_POST['descripcion'];
        if($falla == ""){
            echo "vacio";
            return false;
        }
    }
    $folio = "";
	if ($id_registro == 0){
        $cadena_verificar = mysqli_query($conexion,"SELECT id FROM reportes_cajas WHERE activo = '1' AND status = '1' AND id_caja = '$id_caja' AND id_equipo = '$id_equipo'");
		$existe = mysqli_num_rows($cadena_verificar);
		if($existe == 0){
            $consulta = mysqli_query($conexion,"INSERT INTO reportes_cajas (id_caja, id_equipo, id_falla, tipo, status, activo, fecha, hora, id_usuario) VALUES ('$id_caja','$id_equipo','$falla','$tipo','1','1','$fecha','$hora','$id_usuario')");
            ///Calendario
            $consulta_folio = mysqli_query($conexion,"SELECT MAX(folio) FROM agenda");
            $row_folio = mysqli_fetch_array($consulta_folio);
            
            $consulta_id = mysqli_query($conexion,"SELECT MAX(id) FROM reportes_cajas");
            $row_id = mysqli_fetch_array($consulta_id);
            $folio = $row_id[0] + 1;

            $title=$folio."-Reporte Falla. ".$nombre_sede;
            $fecha_completa = $fecha.' 12:00:00';
            $fecha_completa2 = $fecha2.' 12:00:00';
            $cadena_calendario = mysqli_query($conexion,"INSERT INTO agenda (folio, title, start, end, id_usuario, fecha, hora, backgroundColor, borderColor) VALUES ('$row_folio[0]','$title','$fecha_completa','$fecha_completa2','104','$fecha','$hora','#FF0000','#FF0000')");
			echo "ok";
		}else{
			echo "duplicado";
		}
	}else{
        $actualizar  = mysqli_query($conexion,"UPDATE reportes_cajas SET id_falla = '$falla', tipo = '$tipo', id_caja = '$id_caja', id_equipo = '$id_equipo', fecha = '$fecha', hora = '$hora', id_usuario = '$id_usuario' WHERE id = '$id_registro'");
		echo "ok";
	}
?>