<?php
  
    include '../global_seguridad/verificar_sesion.php';

    $nombre       = $_POST['nombre'];
    $tipo         = $_POST['tipo'];
    $catalogo     = $_POST['catalogo'];
    $seleccionado = (isset($_POST['seleccionado']))?$_POST['seleccionado']:"";
    $id_codigo    = (isset($_POST['id_codigo']))?$_POST['id_codigo']:"";
    $id_registro  = $_POST['id_registro'];
    $cantidad     = (isset($_POST['id_codigo']))?count($id_codigo):0;;
    $existe       = "";

    if($id_registro == 0){
        for ($i=0; $i < $cantidad ; $i++) { 
            if($seleccionado[$i] != "0"){
                $existe = "SI";
                break;
            }
        }
        if($existe == "SI"){
            $cadena_principal = mysqli_query($conexion,"INSERT INTO examenes (nombre, tipo_examen, id_categoria, fecha, hora , activo, id_usuario) VALUES ('$nombre','$tipo','$catalogo','$fecha','$hora','1','$id_usuario')");
            $cadena_select = mysqli_query($conexion,"SELECT MAX(id) FROM examenes");
            $row_select = mysqli_fetch_array($cadena_select);
            $folio = $row_select[0];
            for ($i=0; $i < $cantidad ; $i++) { 
                if($seleccionado[$i] == "1"){
                    $verificar = mysqli_query($conexion,"SELECT id FROM detalle_examen WHERE codigo = '$id_codigo[$i]' AND id_examen = '$folio'");
                    $existe_v = mysqli_num_rows($verificar);
                    $row_v = mysqli_fetch_array($verificar);
                    if($existe_v != 0){
                        $cadena = mysqli_query($conexion,"UPDATE detalle_examen SET activo = '1' WHERE id = '$row_v[0]'");
                    }else{
                        $cadena = mysqli_query($conexion,"INSERT INTO detalle_examen (id_examen,codigo, fecha, hora, activo, id_usuario) VALUEs('$folio','$id_codigo[$i]','$fecha','$hora','1','$id_usuario')");
                    }
                }
            }
            echo "ok";
        }else{
            echo "vacio";
        }
    }else{
        $cadena_principal = mysqli_query($conexion,"UPDATE examenes SET nombre = '$nombre', tipo_examen = '$tipo', id_categoria = '$catalogo' WHERE id = '$id_registro'");
        if($cantidad != 0){
            for ($i=0; $i < $cantidad ; $i++) { 
                if($seleccionado[$i] == "1"){
                    $verificar = mysqli_query($conexion,"SELECT id FROM detalle_examen WHERE codigo = '$id_codigo[$i]' AND id_examen = '$id_registro'");
                    $existe_v = mysqli_num_rows($verificar);
                    $row_v = mysqli_fetch_array($verificar);
                    if($existe_v != 0){
                        $cadena = mysqli_query($conexion,"UPDATE detalle_examen SET activo = '1' WHERE id = '$row_v[0]'");
                    }else{
                        $cadena = mysqli_query($conexion,"INSERT INTO detalle_examen (id_examen,codigo, fecha, hora, activo, id_usuario) VALUEs('$id_registro','$id_codigo[$i]','$fecha','$hora','1','$id_usuario')");
                    }
                }
            }
        }
        echo "ok";
    }
?>