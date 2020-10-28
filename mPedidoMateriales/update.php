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

for ($i=0; $i < $longitud; $i++) 
    {
        if($pedido[$i] == null)
            {
                echo"1";
            }
        else
            {
                for ($i=0; $i < $longitud; $i++) 
                    { 
                    
                        $qry = "UPDATE historial_pedido_materiales
                                SET pedido = '$pedido[$i]',
                                 id_usuario = '$id_usuario'
                                WHERE
                                    folio = '$folio'
                                AND codigo = '$codigo[$i]'";
                        $result1 = mysqli_query($conexion, $qry);    
                    }            
                echo"2";
            }
    }    
?>