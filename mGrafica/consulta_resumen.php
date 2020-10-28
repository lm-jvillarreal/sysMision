<?php
include '../global_seguridad/verificar_sesion.php';
$fecha_inicio =$_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];

$cadena_turnos = "SELECT COUNT(*) FROM turnos WHERE fecha between '$fecha_inicio' and '$fecha_fin'";
$consulta_turnos = mysqli_query($conexion, $cadena_turnos);
$row_turnos = mysqli_fetch_array($consulta_turnos);
$total_turnos = number_format($row_turnos[0], 0, '.', ',');

$cadena_consultas = "SELECT COUNT(*) FROM consulta WHERE fecha between '$fecha_inicio' and '$fecha_fin'";
$consulta_consultas = mysqli_query($conexion, $cadena_consultas);
$row_consultas = mysqli_fetch_array($consulta_consultas);
if($row_turnos[0]=="0"){
    $porcentaje_consultas = "0";
}else{
    $porcentaje_consultas = ($row_consultas[0] * 100) / $row_turnos[0];
}
$porcentaje_consultas = round($porcentaje_consultas, 2) . '%';
$texto_consultas = $porcentaje_consultas." de turnos impresos";

$cadena_hombres = "SELECT COUNT(p.id) 
                    FROM pacientes as p INNER JOIN consulta as c ON p.id = c.id_pacientes
                    and c.fecha between '$fecha_inicio' and '$fecha_fin' 
                    and p.sexo = 'Masculino'";
$consulta_hombres = mysqli_query($conexion, $cadena_hombres);
$row_hombres = mysqli_fetch_array($consulta_hombres);
if($row_consultas[0]=="0"){
    $porcentaje_hombres = "0";
}else{
    $porcentaje_hombres = ($row_hombres[0] * 100) / $row_consultas[0];
}
$porcentaje_hombres = round($porcentaje_hombres, 2) . '%';
$texto_hombres = $porcentaje_hombres." del total de consultas";

$cadena_mujeres = "SELECT COUNT(p.id) 
                    FROM pacientes as p INNER JOIN consulta as c ON p.id = c.id_pacientes
                    and c.fecha between '$fecha_inicio' and '$fecha_fin' 
                    and p.sexo = 'Femenino'";
$consulta_mujeres = mysqli_query($conexion, $cadena_mujeres);
$row_mujeres = mysqli_fetch_array($consulta_mujeres);
if($row_consultas[0]=="0"){
    $porcentaje_mujeres = "0";
}else{
    $porcentaje_mujeres = ($row_mujeres[0] * 100) / $row_consultas[0];
}
$porcentaje_mujeres = round($porcentaje_mujeres, 2) . '%';
$texto_mujeres = $porcentaje_mujeres." del total de consultas";

$cadena_eramirez = "SELECT COUNT(*) 
FROM consulta WHERE usuario = '97' and (fecha between '$fecha_inicio' and '$fecha_fin')";
$consulta_eramirez = mysqli_query($conexion, $cadena_eramirez);
$row_eramirez = mysqli_fetch_array($consulta_eramirez);
if($row_consultas[0]=="0"){
    $porcentaje_eramirez = "0";
}else{
    $porcentaje_eramirez = ($row_eramirez[0] * 100) / $row_consultas[0];
}
$porcentaje_eramirez = round($porcentaje_eramirez, 2) . '%';
$texto_eramirez = $porcentaje_eramirez." del total de consultas";

$cadena_preyes = "SELECT COUNT(*) 
FROM consulta WHERE usuario = '91' and (fecha between '$fecha_inicio' and '$fecha_fin')";
$consulta_preyes = mysqli_query($conexion, $cadena_preyes);
$row_preyes = mysqli_fetch_array($consulta_preyes);
if($row_consultas[0]=="0"){
    $porcentaje_preyes = "0";
}else{
    $porcentaje_preyes = ($row_preyes[0] * 100) / $row_consultas[0];
}
$porcentaje_preyes = round($porcentaje_preyes, 2) . '%';
$texto_preyes = $porcentaje_preyes." del total de consultas";

$cadena_jprado = "SELECT COUNT(*) 
FROM consulta WHERE usuario = '162' and (fecha between '$fecha_inicio' and '$fecha_fin')";
$consulta_jprado = mysqli_query($conexion, $cadena_jprado);
$row_jprado = mysqli_fetch_array($consulta_jprado);
if($row_consultas[0]=="0"){
    $porcentaje_jprado = "0";
}else{
    $porcentaje_jprado = ($row_jprado[0] * 100) / $row_consultas[0];
}
$porcentaje_jprado = round($porcentaje_jprado, 2) . '%';
$texto_jprado = $porcentaje_jprado." del total de consultas";

$cadena_promedio = "SELECT count(c.id),SUM(p.edad)
FROM consulta as c inner join pacientes as p ON c.id_pacientes = p.id
and (c.fecha between '$fecha_inicio' and '$fecha_fin')";

$consulta_promedio = mysqli_query($conexion, $cadena_promedio);
$row_promedio = mysqli_fetch_array($consulta_promedio);
$promedio_edad = $row_promedio[1]/$row_promedio[0];
$promedio_edad = round($promedio_edad,0).' años';

$cadena_recetas = "SELECT COUNT(distinct(folio)) as recetas FROM receta where fecha between '$fecha_inicio' and '$fecha_fin'";
$consulta_recetas = mysqli_query($conexion, $cadena_recetas);
$row_recetas = mysqli_fetch_array($consulta_recetas);
if($row_recetas[0]=="0"){
    $porcentaje_recetas = "0";
}else{
    $porcentaje_recetas = ($row_recetas[0] * 100) / $row_consultas[0];
}
$porcentaje_recetas = round($porcentaje_recetas, 2) . '%';
$texto_recetas = $porcentaje_recetas." del total de consultas";

$cadena_recetas_eramirez = "SELECT COUNT(distinct(folio)) as recetas FROM receta where id_medico = '97' AND (fecha between '$fecha_inicio' and '$fecha_fin')";
//echo $cadena_recetas_eramirez;
$consulta_recetas_eramirez = mysqli_query($conexion, $cadena_recetas_eramirez);
$row_recetas_eramirez = mysqli_fetch_array($consulta_recetas_eramirez);
if($row_eramirez[0]=="0"){
    $porcentaje_recetas_eramirez = "0";
}else{
    $porcentaje_recetas_eramirez = ($row_recetas_eramirez[0] * 100) / $row_eramirez[0];
}
$porcentaje_recetas_eramirez = round($porcentaje_recetas_eramirez, 2) . '%';
$texto_recetas_eramirez = $porcentaje_recetas_eramirez." del total de consultas";

$cadena_recetas_preyes = "SELECT COUNT(distinct(folio)) as recetas FROM receta where id_medico = '91' AND fecha between '$fecha_inicio' and '$fecha_fin'";
$consulta_recetas_preyes = mysqli_query($conexion, $cadena_recetas_preyes);
$row_recetas_preyes = mysqli_fetch_array($consulta_recetas_preyes);
if($row_preyes[0]=="0"){
    $porcentaje_recetas_preyes = "0";
}else{
    $porcentaje_recetas_preyes = ($row_recetas_preyes[0] * 100) / $row_preyes[0];
}
$porcentaje_recetas_preyes = round($porcentaje_recetas_preyes, 2) . '%';
$texto_recetas_preyes = $porcentaje_recetas_preyes." del total de consultas";

$cadena_recetas_jprado = "SELECT COUNT(distinct(folio)) as recetas FROM receta where id_medico = '162' AND fecha between '$fecha_inicio' and '$fecha_fin'";
$consulta_recetas_jprado = mysqli_query($conexion, $cadena_recetas_jprado);
$row_recetas_jprado = mysqli_fetch_array($consulta_recetas_jprado);
if($row_jprado[0]=="0"){
    $porcentaje_recetas_jprado = "0";
}else{
    $porcentaje_recetas_jprado = ($row_recetas_jprado[0] * 100) / $row_jprado[0];
}
$porcentaje_recetas_jprado = round($porcentaje_recetas_jprado, 2) . '%';
$texto_recetas_jprado = $porcentaje_recetas_jprado." del total de consultas";

$cadena_medicamento = "SELECT COUNT(id) as medicamento FROM receta where fecha between '$fecha_inicio' and '$fecha_fin'";
$consulta_medicamento = mysqli_query($conexion, $cadena_medicamento);
$row_medicamento = mysqli_fetch_array($consulta_medicamento);

$cadena_surtido = "SELECT COUNT(id) as medicamento FROM receta where fecha between '$fecha_inicio' and '$fecha_fin' and surtido = '1'";
$consulta_surtido = mysqli_query($conexion, $cadena_surtido);
$row_surtido = mysqli_fetch_array($consulta_surtido);
if($row_medicamento[0]=="0"){
    $porcentaje_surtido = "0";
}else{
    $porcentaje_surtido = ($row_surtido[0] * 100) / $row_medicamento[0];
}
$porcentaje_surtido = round($porcentaje_surtido, 2) . '%';
$texto_surtido = $porcentaje_surtido." del total recetado";

$cadena_surtido_eramirez = "SELECT COUNT(id) as medicamento FROM receta where fecha between '$fecha_inicio' and '$fecha_fin' and surtido = '1' and id_medico = '97'";
$consulta_surtido_eramirez = mysqli_query($conexion, $cadena_surtido_eramirez);
$row_surtido_eramirez = mysqli_fetch_array($consulta_surtido_eramirez);
if($row_medicamento[0]=="0"){
    $porcentaje_surtido_eramirez = "0";
}else{
    $porcentaje_surtido_eramirez = ($row_surtido_eramirez[0] * 100) / $row_medicamento[0];
}
$porcentaje_surtido_eramirez = round($porcentaje_surtido_eramirez, 2) . '%';
$texto_surtido_eramirez = $porcentaje_surtido_eramirez." del total recetado";

$cadena_surtido_preyes = "SELECT COUNT(id) as medicamento FROM receta where fecha between '$fecha_inicio' and '$fecha_fin' and surtido = '1' and id_medico = '91'";
$consulta_surtido_preyes = mysqli_query($conexion, $cadena_surtido_preyes);
$row_surtido_preyes = mysqli_fetch_array($consulta_surtido_preyes);
if($row_medicamento[0]=="0"){
    $porcentaje_surtido_preyes = "0";
}else{
    $porcentaje_surtido_preyes = ($row_surtido_preyes[0] * 100) / $row_medicamento[0];
}
$porcentaje_surtido_preyes = round($porcentaje_surtido_preyes, 2) . '%';
$texto_surtido_preyes = $porcentaje_surtido_preyes." del total recetado";

$cadena_surtido_jprado = "SELECT COUNT(id) as medicamento FROM receta where fecha between '$fecha_inicio' and '$fecha_fin' and surtido = '1' and id_medico = '162'";
$consulta_surtido_jprado = mysqli_query($conexion, $cadena_surtido_jprado);
$row_surtido_jprado = mysqli_fetch_array($consulta_surtido_jprado);
if($row_medicamento[0]=="0"){
    $porcentaje_surtido_jprado = "0";
}else{
    $porcentaje_surtido_jprado = ($row_surtido_jprado[0] * 100) / $row_medicamento[0];
}
$porcentaje_surtido_jprado = round($porcentaje_surtido_jprado, 2) . '%';
$texto_surtido_jprado = $porcentaje_surtido_jprado." del total recetado";

$cadena_promReceta = "SELECT COUNT(id) as medicamento, COUNT(distinct(folio)) as recetas FROM receta where fecha between '$fecha_inicio' and '$fecha_fin'";
$consulta_promReceta = mysqli_query($conexion, $cadena_promReceta);
$row_promReceta = mysqli_fetch_array($consulta_promReceta);
$promedio_medicamento = $row_promReceta[0]/$row_promReceta[1];
$promedio_medicamento = round($promedio_medicamento,0);

$cadena_recSurt = "SELECT COUNT(distinct(folio)) FROM receta where fecha between '$fecha_inicio' and '$fecha_fin' and surtido = '1'";
$consulta_recSurt = mysqli_query($conexion, $cadena_recSurt);
$row_recSurt = mysqli_fetch_array($consulta_recSurt);
if($row_recetas[0]=="0"){
    $porcentaje_recSurt = "0";
}else{
    $porcentaje_recSurt = ($row_recSurt[0] * 100) / $row_recetas[0];
}
$porcentaje_recSurt = round($porcentaje_recSurt, 2) . '%';
$texto_recSurt = $porcentaje_recSurt." del total de recetas";

$array = array(
    $total_turnos, //Total turnos
    $row_consultas[0],
    $porcentaje_consultas,
    $texto_consultas,
    $row_hombres[0],
    $porcentaje_hombres,
    $texto_hombres,
    $row_mujeres[0],
    $porcentaje_mujeres,
    $texto_mujeres,
    $row_eramirez[0],
    $porcentaje_eramirez,
    $texto_eramirez,
    $row_preyes[0],
    $porcentaje_preyes,
    $texto_preyes,
    $promedio_edad,
    $row_recetas_eramirez[0],
    $porcentaje_recetas_eramirez,
    $texto_recetas_eramirez,
    $row_recetas_preyes[0],
    $porcentaje_recetas_preyes,
    $texto_recetas_preyes,
    $row_medicamento[0],
    $row_surtido_eramirez[0],
    $porcentaje_surtido_eramirez,
    $texto_surtido_eramirez,
    $row_surtido_preyes[0],
    $porcentaje_surtido_preyes,
    $texto_surtido_preyes,
    $promedio_medicamento,
    $row_recSurt[0],
    $porcentaje_recSurt,
    $texto_recSurt,
    $row_jprado[0],
    $porcentaje_jprado,
    $texto_jprado,
    $row_recetas_jprado[0],
    $porcentaje_recetas_jprado,
    $texto_recetas_jprado,
    $row_surtido_jprado[0],
    $porcentaje_surtido_jprado,
    $texto_surtido_jprado,
);
$array_datos = json_encode($array);
echo $array_datos;
?>