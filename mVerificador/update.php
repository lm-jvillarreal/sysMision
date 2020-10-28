<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");
$id = $_POST['id'];
$codigo = $_POST['codigo'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$bodega = $_POST['bodega'];
$existencia = $_POST['existencia'];

if($nombre == null or $bodega == null or $existencia == null or $descripcion == null)
    {
        echo"1";
    }
else
    {
    
        $qry = "UPDATE catalago_materiales
                SET id_bodega = '$bodega',
                 nombre = '$nombre',
                 descripcion = '$descripcion',
                 activo = '1',
                 fecha_edito = '$fecha',
                 hora_edito = '$hora',
                 id_usuario_edito = '$id_usuario'
                WHERE
                    id = '$id'";
        $Ejecutar = mysqli_query($conexion,$qry);
        
    
        $qry1 = "UPDATE historial_existencia_materiales
                SET existencia = '$existencia',
                 id_bodega = '$bodega',
                 activo = '1',
                 fecha_edito = '$fecha',
                 hora_edito = '$hora',
                 id_usuario_edito = '$id_usuario'
                WHERE
                    id_bodega = '$bodega'
                AND codigo = '$codigo'";
        $Ejecutar1 = mysqli_query($conexion,$qry1);
        echo"2";
    }       
?>