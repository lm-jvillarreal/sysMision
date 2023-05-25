<?php
include '../global_seguridad/verificar_sesion.php';
$fechahora=date("Y-m-d H:i:s");
$fecha=date("Y-m-d");
$prefijo=date("Y").date("m").date("d");
$proveedor=$_POST['proveedor'];
$nombre_proveedor=$_POST['nombre_proveedor'];
$cadenaConsec="SELECT IFNULL(MAX(CONSECUTIVO_REMISION),0) FROM inv_remisiones WHERE SUCURSAL='$id_sede' AND DATE_FORMAT(FECHAHORA, '%Y-%m-%d')='$fecha'";
$consultaConsec=mysqli_query($conexion,$cadenaConsec);
$rowConsec=mysqli_fetch_array($consultaConsec);
$consecutivo=$rowConsec[0]+1;
$cadenaInsertar="INSERT INTO inv_remisiones (PREFIJO_REMISION, CONSECUTIVO_REMISION, PROC_PROVEEDOR, NOMBRE_PROVEEDOR, SUCURSAL, ESTATUS_REMISION, FECHAHORA, ACTIVO, USUARIO)VALUES('$prefijo','$consecutivo','$proveedor','$nombre_proveedor','$id_sede','1','$fechahora','1','$id_usuario')";
 $consultaInsertar=mysqli_query($conexion,$cadenaInsertar);
echo "ok";
            /////////////////////////notificaciones///////////////////////////////////////////////
    $cadena_agenda                = "";//consulta para insertar en la taba agenda
    $fecha_completa_inicio = "";       //fecha inicial para insertar en agenda
    $fecha_completa_final  = "";       //fecha final para insertar en agenda
    $color = "#ee5253";                //color para insertar en agenda
    $fecha_nueva = date($fecha);
    $nuevafecha  = strtotime ( '+1 day' , strtotime ( $fecha_nueva ) ) ;
    $nuevafecha  = date ( 'Y-m-d' , $nuevafecha );

    $cadena_remisiones = mysqli_query($conexion,"SELECT PREFIJO_REMISION
    FROM inv_remisiones
    WHERE ID = '$consecutivo' AND SUCURSAL = '$id_sede' AND ESTATUS_REMISION = '1'");
    $row_remisiones = mysqli_fetch_array($cadena_remisiones);    

    function sanear_string($string)
    {
        $string = trim($string);
        $string = str_replace( array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $string
        );
        $string = str_replace(array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $string
        );
        $string = str_replace(array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $string
        );
        $string = str_replace(array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $string
        );
        $string = str_replace(array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $string
        );
        $string = str_replace(array('ñ', 'Ñ', 'ç', 'Ç'),array('n', 'N', 'c', 'C',),
            $string
        );
        return $string;
    }

    $title = sanear_string($prefijo.$consecutivo);
    if($id_sede == "1"){
        $sucu = "D.O";
    }else if($id_sede == "2"){
        $sucu = "ARB.";
    }else if ($id_sede == "3"){
        $sucu = "VILL.";
    }else if($id_sede == "4"){
        $sucu = "ALL.";
    }else{
        $sucu = "PET.";
    }
    $add ="REMISION: ";
    $title = $add.'-'.$title.'-'.$sucu;

    $fecha_completa_inicio = $fecha .' 12:00:00';
    $fecha_completa_final  = $nuevafecha .' 12:00:00';

    $cadena_folio = mysqli_query($conexion,"SELECT MAX(folio) FROM agenda");
    $row_folio    = mysqli_fetch_array($cadena_folio);
    $folio        = $row_folio[0] + 1;

    $cadena_eventos = mysqli_query($conexion,"SELECT usuarios.id,usuarios.nombre_usuario
    FROM usuarios
    INNER JOIN personas ON personas.id = usuarios.id_persona
    WHERE personas.id_sede = '$id_sede' and usuarios.activo = '1' AND usuarios.id_perfil = '11' OR   usuarios.id = '2'");
    while($row_e = mysqli_fetch_array($cadena_eventos)){
        $cadena_agenda = mysqli_query($conexion,"INSERT INTO agenda (folio,title,start,end,id_usuario,fecha,hora,backgroundColor,borderColor)
        VALUES ('$folio','$title','$fecha_completa_inicio','$fecha_completa_final','$row_e[0]','$fecha','$hora','$color','$color')");
    }
    /////////////////////////////////////////notificaciones////////////////////////////////////////////////////////
?>