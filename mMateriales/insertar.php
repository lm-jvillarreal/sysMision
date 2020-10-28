<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");
$nombre      = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$bodega      = $_POST['bodega'];
$existencia  = $_POST['existencia'];
$proveedor   = $_POST['proveedor'];
$id_registro = $_POST['id_registro'];

if($id_registro == 0){
    if($nombre == null or $bodega == null or $existencia == null or $descripcion == null)
        {
            echo"1";
        }
    else
        {
            $insertar= mysqli_query($conexion,"SELECT MAX(codigo)
                                                FROM catalago_materiales") or die (mysql_error());
            $row = mysqli_fetch_array($insertar);
            $codigo = $row[0] + 1;
            $insertar= mysqli_query($conexion,"INSERT INTO catalago_materiales (
                                                    codigo,
                                                    id_bodega,
                                                    nombre,
                                                    descripcion,
                                                    proveedor,
                                                    pedido,
                                                    id_usuario,
                                                    activo,
                                                    fecha,
                                                    hora
                                                )
                                                VALUES
                                                    (
                                                        '$codigo',
                                                        '$bodega',
                                                        '$nombre',
                                                        '$descripcion',
                                                        '$proveedor',
                                                        '0',
                                                        '$id_usuario',
                                                        '1',
                                                        '$fecha',
                                                        '$hora')") or die (mysql_error());
        
        $insertar2= mysqli_query($conexion,"INSERT INTO historial_existencia_materiales (
                                                    codigo,
                                                    id_bodega,
                                                    existencia,
                                                    id_usuario,
                                                    activo,
                                                    fecha,
                                                    hora
                                                )
                                                VALUES
                                                    (
                                                        '$codigo',
                                                        '$bodega',
                                                        '$existencia',
                                                        '$id_usuario',
                                                        '1',
                                                        '$fecha',
                                                        '$hora')") or die (mysql_error());
            echo"2";
        }
}else{
    $qry = "UPDATE catalago_materiales
            SET id_bodega = '$bodega',
            nombre = '$nombre',
            descripcion = '$descripcion',
            proveedor = '$proveedor',
            activo = '1',
            fecha_edito = '$fecha',
            hora_edito = '$hora',
            id_usuario_edito = '$id_usuario'
            WHERE id = '$id_registro'";
    $Ejecutar = mysqli_query($conexion,$qry);


    $qry1 = "UPDATE historial_existencia_materiales
            SET existencia = '$existencia',
            id_bodega = '$bodega',
            activo = '1',
            fecha_edito = '$fecha',
            hora_edito = '$hora',
            id_usuario_edito = '$id_usuario'
            WHERE id_bodega = '$bodega'
            AND codigo = '$id_registro'";

    $Ejecutar1 = mysqli_query($conexion,$qry1);
    echo"2";
}

       
?>