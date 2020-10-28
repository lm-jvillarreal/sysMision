<?php                 
    include '../global_seguridad/verificar_sesion.php';
    date_default_timezone_set('America/Monterrey');
    $fecha = date('Y-m-d');
    $hora  = date('h:i:s');
//comprobamos que sea una petición ajax
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
 
    //obtenemos el archivo a subir
    $files = $_FILES['archivo']['name'];
 
     $i = 0;
    //comprobamos si el archivo ha subido
    foreach($files as $file)
    {
        if (move_uploaded_file($_FILES['archivo']['tmp_name'][$i],"files/".$_FILES['archivo']['name'][$i]))
        {
            $ruta = "audios/" . $_FILES['archivo']['name'][$i];
                $cadena = mysqli_query($conexion,"INSERT INTO audios (ruta,fecha,hora,id_usuario) VALUES ('$ruta','$fecha','$hora','$id_usuario')");
            $i++;
        }
    }
}else{
    throw new Exception("Error Processing Request", 1);   
}
?>