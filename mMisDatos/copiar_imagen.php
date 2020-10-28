<?php
include '../global_seguridad/verificar_sesion.php';

$f_nombre = $_FILES["archivos"]['name'];
$f_tamano = $_FILES["archivos"]['size']; 
$f_tipo = $_FILES["archivos"]['type'];

$extension = end(explode(".", $_FILES['archivos']['name']));

if ($f_nombre != "") 
        {
            $destino =  "../d_plantilla/dist/img/personas/". $id_usuario.".".$extension;
                if (copy($_FILES['archivos']['tmp_name'],$destino))
                { 
                    $status = "Archivo subido"; 
                }  
                else  
                { 
                    $status = "Error al subir el archivo"; 
                } 
        }
?>