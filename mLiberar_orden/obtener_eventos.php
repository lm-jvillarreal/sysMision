<?php
// Incluimos nuestro archivo config
include '../global_seguridad/verificar_sesion.php';
include 'config.php';
// Sentencia sql para traer los eventos desde la base de datos
$filtro_sucursal = ($solo_sucursal == '1') ? " WHERE id_sucursal = '$id_sede'" : "";
$sql="SELECT * FROM eventos".$filtro_sucursal;

//echo $sql;
// Verificamos si existe un dato
if ($conn_cal->query($sql)->num_rows)
{ 
    // creamos un array
    $datos = array(); 

    //guardamos en un array multidimensional todos los datos de la consulta
    $i=0; 

    // Ejecutamos nuestra sentencia sql
    $e = $conn_cal->query($sql); 

    while($row=$e->fetch_array()) // realizamos un ciclo while para traer los eventos encontrados en la base de dato
    {
        // Alimentamos el array con los datos de los eventos
        $datos[$i] = $row; 
        $i++;
    }

    // Transformamos los datos encontrado en la BD al formato JSON
        echo json_encode(
                array(
                    "success" => 1,
                    "result" => $datos
                )
            );
}
    else
    {
        // Si no existen eventos mostramos este mensaje.
        echo "No hay datos"; 
    }
?>
