<?php
include '../global_seguridad/verificar_sesion.php';
$datos=array();
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$ayer = date( "Y-m-d", strtotime( "-1 day", strtotime( $fecha ) ) ); 
$hora=date ("h:i:s");

$filtro_sucursal =($solo_sucursal=='1') ? " AND sucursal='$id_sede'":"";

$cadena_cambios = "SELECT id,
                          tipo,
                          descripcion,
                          fecha_movimiento,
                          usuario_encargado, 
                          DATE_FORMAT(fecha_captura, '%d/%m/%Y'), 
                          sucursal, 
                          comentario_libera, 
                          liberado, 
                          nombre_encargado,
                          no_aplica,
                          entregado
                   FROM bitacora_cambios 
                   WHERE (fecha BETWEEN '$ayer' AND '$fecha')
                   AND liberado = '0'".$filtro_sucursal."";
                   
$consulta_cambios = mysqli_query($conexion, $cadena_cambios);
//ECHO $cadena_cambios;

while ($row_cambios = mysqli_fetch_array($consulta_cambios)) {
    
    if($row_cambios[7]==""){
        $clase = "btn btn-danger btn-sm";
    }
    else{
        $clase = "btn btn-success btn-sm";
    }
    if($row_cambios[8]=='1'){
        $ro = "disabled";
    }
    else{
        $ro = "";
    }
    if($row_cambios[9]==NULL){
        $cadena_encargado = "SELECT usuarios.id,  CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno)
        FROM usuarios
        INNER JOIN personas 
        WHERE usuarios.id_persona = personas.id AND usuarios.id = '$row_cambios[4]'";
        $consulta_encargado = mysqli_query($conexion, $cadena_encargado);
        $row_encargado = mysqli_fetch_array($consulta_encargado);
        $nombre_encargado =trim($row_encargado[1]);
    }else{
        $nombre_encargado = trim($row_cambios[9]);
    }
    $escape_descripcion=mysqli_real_escape_string($conexion, $row_cambios[2]);
    $escape_comentario = mysqli_real_escape_string($conexion, $row_cambios[7]);
    $escape_encargado = mysqli_real_escape_string($conexion, $nombre_encargado);
    $link = "<center><a href='#' class='btn btn-danger'>Editar</a></center>";
    if($row_cambios[10]==""){
        $autorizar = "<div class='input-group' style='width:70%''><input type='text' id='folio_$row_cambios[0]' class='form-control input-sm' $ro><span class='input-group-btn'><button onclick='libera_gerencia($row_cambios[0])' class='btn btn-danger btn-sm' type='button' $ro><i class='fa fa-floppy-o fa-lg' aria-hidden='true'></i></button></span></div>&nbsp;<button class='$clase' type='button' data-id='$row_cambios[0]' data-coment='$escape_comentario' data-toggle='modal' data-target='#modal-comentario'><i class='fa fa-commenting fa-lg' aria-hidden='true'></i></button>&nbsp;<button class='btn btn-default btn-sm' type='button' data-id='$row_cambios[0]' data-entregado='$row_cambios[11]' data-toggle='modal' data-target='#modal-entregado'><i class='fa fa-print fa-lg' aria-hidden='true'></i></button>";
    }else{
        $autorizar=$row_cambios[10];
    }
    
    array_push($datos,array(
        'id'=>$row_cambios[0],
        'tipo'=>$row_cambios[1],
        'descripcion'=>$escape_descripcion,
        'sucursal'=>$row_cambios[6],
        'fecha_movimiento'=>$row_cambios[5],
        'encargado'=>$escape_encargado,
        'entregado'=>$row_cambios[11],
        'validar'=>$autorizar
    ));
}
echo utf8_encode(json_encode($datos));
?>