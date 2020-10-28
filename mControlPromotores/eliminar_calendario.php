<?php
	include '../global_seguridad/verificar_sesion.php';

    $id_promotor = $_POST['id_promotor'];
    $id_sucursal = $_POST['id_sucursal'];
    $dia         = $_POST['dia'];

    $cadena      = mysqli_query($conexion,"SELECT MAX(dia) FROM agenda_promotores WHERE id_promotor = '$id_promotor' AND id_sucursal = '$id_sucursal'");
    $row_cadena  = mysqli_fetch_array($cadena);
    $fechaInicio = strtotime($fecha);
    $fechaFin    = strtotime($row_cadena[0]);

    $dia_select  = "";
    $numero = 0;
    for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
        //Sacar el dia de la semana con el modificador N de la funcion date
        $dias = date('N', $i);
        if($dia == $dias){
            $dia_select = date("Y-m-d", $i);
            $cadena     = mysqli_query($conexion,"UPDATE agenda_promotores SET activo = '0' WHERE id_promotor = '$id_promotor' AND dia = '$dia_select' AND id_sucursal = '$id_sucursal'");
            $numero ++;
        }
        $cadena     = "";
        $dia_select = "";
    }
    $array = array('ok',$numero);
    echo json_encode($array);
?>