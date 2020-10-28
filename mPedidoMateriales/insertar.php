<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$folio = $_POST["folio"];
$codigo = $_POST["codigo"];
$bodega = $_POST["bodega"];
$pedido = $_POST["pedido"];
$longitud = count($pedido);

$consulta1="SELECT
              id,
              nombre
          FROM
              bodega
          WHERE
              activo = '1'
          AND nombre = '$bodega'";
$ejecuta1 = mysqli_query($conexion,$consulta1);
$row1 = mysqli_fetch_array($ejecuta1);

$consulta ="SELECT
                id,
                fecha,
                hora
            FROM
                materiales
            WHERE
                fecha = '$fecha'
            AND id_sucursal = '$id_sede'";
$ejecuta = mysqli_query($conexion,$consulta);
$count = mysqli_num_rows($ejecuta);
$row = mysqli_fetch_array($ejecuta);

// if($count != 0)
//     {
//         echo"$row[2]";
//     }
// else
//     {
        for ($i=0; $i < $longitud; $i++) 
            {
                if($pedido[$i] == null)
                    {
                        echo"1";
                    }
                else
                    {
                        $consulta="INSERT INTO materiales (
                                                folio,
                                                fecha,
                                                hora,
                                                activo,
                                                id_usuario,
                                                id_sucursal
                                            )
                                            VALUES
                                                (
                                                    '$folio',
                                                    '$fecha',
                                                    '$hora',
                                                    '1', 
                                                    '$id_usuario',
                                                    '$id_sede')";       
                        $result = mysqli_query($conexion, $consulta);

                        for ($i=0; $i < $longitud; $i++) 
                            { 
                                $consulta1="INSERT INTO historial_pedido_materiales (
                                                folio,
                                                id_bodega,
                                                codigo,
                                                pedido,
                                                fecha,
                                                hora,
                                                activo,
                                                id_usuario
                                            )
                                            VALUES
                                                (
                                                    '$folio',
                                                    '$row1[0]',
                                                    '$codigo[$i]',
                                                    '$pedido[$i]',
                                                    '$fecha',
                                                    '$hora',
                                                    '1', 
                                                    '$id_usuario')";       
                                $result1 = mysqli_query($conexion, $consulta1);    
                            }            
                        echo"2";
                    }
            }   
    //}  
?>