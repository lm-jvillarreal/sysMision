<?php 
    include '../global_seguridad/verificar_sesion.php';
  
    $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";
  
    $cadena  = "SELECT reportes_cajas.id, sucursales.nombre, cajas.nombre,
                ( SELECT CONCAT(nombre,' - ', descripcion) FROM cajas_catalogo_equipos WHERE reportes_cajas.id_equipo = cajas_catalogo_equipos.id ),
                id_falla, fallas_equipos.nombre, STATUS, reportes_cajas.comentario 
                FROM reportes_cajas 
                INNER JOIN cajas ON cajas.id = reportes_cajas.id_caja
                INNER JOIN sucursales ON sucursales.id = cajas.id_sucursal
                LEFT JOIN fallas_equipos ON fallas_equipos.id = reportes_cajas.id_falla
                WHERE reportes_cajas.activo = '1' AND (status = '2' OR status = '3' OR status = '4')".$filtro_sucursal;          
    $consulta = mysqli_query($conexion, $cadena);

    $cuerpo = "";
    $numero = 1;
    $activo = "";
    while ($row = mysqli_fetch_array($consulta)) 
    {
        $falla = ($row[5] == "")?$row[4]:$row[5];
        $solucion = ($row[7] == "")?"-":$row[7];
        
        if($row[6] == 2){
            $color2 = "yellow";
            $texto = "Revisado";
        }else if($row[6] == 3){
            $color2 = "blue";
            $texto = "Reparado";
        }else{
            $color2 = "green";
            $texto = "Liberado";
        }
        $status = "<center><small class='label label-lg bg-$color2'>$texto</small></center>";

        $renglon = "
        {
        \"#\": \"$numero\",
        \"Sucursal\": \"$row[1]\",
        \"Caja\": \"$row[2]\",
        \"Equipo\": \"$row[3]\",
        \"Fallo\": \"$falla\",
        \"Solucion\": \"$solucion\",
        \"Status\": \"$status\"
        },";
        $cuerpo = $cuerpo.$renglon;
        $numero ++;
    }
    $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
    $tabla = "
        ["
        .$cuerpo2.
        "]
        ";
    echo $tabla;
?>