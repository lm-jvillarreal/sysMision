<?php
    //include "../global_seguridad/verificar_sesion.php";
    include'../configuracion/conexion_servidor.php';
    
    $s_idUsuario = $_SESSION["s_IdUser"];
    $s_idSucursal=$_SESSION["s_IdSucursal"];
    $s_idPerfil = $_SESSION["sTipoUsuario"];
    $p_upload=$_POST["action"];
    $titulo = $_POST['titulo'];
    date_default_timezone_set('America/Monterrey');
    $fecha = date('Y-m-d');
    $hora = date('H:i:s');

    $archivo = $_FILES["archivos"]['name'];
    echo "$archivo";
    $tamano = $_FILES["archivos"]['size'];
    $tipo = $_FILES["archivos"]['type'];

        if ($archivo != "") 
        {  
            $destino =  "docs/". $archivo; 
                if (copy($_FILES['archivos']['tmp_name'],$destino))  
                { 
                    $status = "Archivo subido"; 
                }  
                else  
                { 
                    $status = "Error al subir el archivo"; 
                } 
                echo "$status";
        }



        $qry = "INSERT INTO archivos_manuales (titulo, ruta, fecha, hora)
                VALUES
                    ('$titulo', '$destino', '$fecha', '$hora')";
                    echo "$qry";
        $exQry = mysqli_query($conexion_mysql, $qry);
        header('Location: index.php');
?>