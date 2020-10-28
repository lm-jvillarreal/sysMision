<?php
include '../global_seguridad/verificar_sesion.php';
include '../precio_venta.php';
date_default_timezone_set("America/Monterrey");
$fecha = date("Y-m-d");
$hora = date("H:i:s");

$id_receta = $_POST['id_receta'];

$cadenaReceta = "SELECT r.id, r.codigo_receta, r.nombre_receta, (r.rendimiento), ((100-r.costo_operativo)/100), (r.margen_sugerido/100),
                (SELECT IFNULL(SUM(detalle.cantidad*catalogo.costo_total),0)
                  FROM cp_detalle_receta AS detalle INNER JOIN cp_productos AS catalogo ON detalle.artc_articulo = catalogo.artc_articulo
                  WHERE detalle.id_receta = r.id) as SUBTOTAL,
                (SELECT IFNULL(SUM(cantidad),0) FROM cp_detalle_receta WHERE id_receta = r.id) as cantidad, (r.ieps/100) as ieps
                FROM cp_recetas as r inner join cp_detalle_receta as d ON r.id=d.id_receta
                AND r.id = '$id_receta'
                GROUP BY r.id";

$consultaReceta = mysqli_query($conexion,$cadenaReceta);
$rowReceta = mysqli_fetch_array($consultaReceta);

$peso_total = $rowReceta[7];
$peso_unidad = $rowReceta[3];
$rendimiento = $peso_total/$peso_unidad;
$margenOperativo = $rowReceta[4];
$margenSugerido = $rowReceta[5];
$subtotal = $rowReceta[6];
$costoIngredientes=$subtotal/$rendimiento;
$stOperativo = $subtotal/$margenOperativo;
$costo = $stOperativo/$rendimiento;
$pp_sugerido = $costo/$margenSugerido;
$pp_sugerido = $pp_sugerido*(1+$rowReceta[8]);
$pp_actual = precioVenta($rowReceta[1]);
$margen_actual = (1-($costo/$pp_actual))*100;
$margen_actual = round($margen_actual,2);
$moReal = 100-($margenOperativo*100);
$msReal = 100-($margenSugerido*100);
$cadenaInsertar = "INSERT INTO cp_resumen_receta (id_receta, codigo_receta, nombre_receta, rendimiento, margen_operativo, margen_sugerido, subtotal, total, costo, precio_sugerido, pp_actual, margen_actual, fecha, hora, activo, usuario,costo_ingredientes)VALUES('$id_receta', '$rowReceta[1]', '$rowReceta[2]', '$rendimiento', '$moReal', '$msReal', '$subtotal', '$stOperativo', '$costo', '$pp_sugerido', '$pp_actual', '$margen_actual', '$fecha', '$hora', '1', '$id_usuario','$costoIngredientes')";
$finalizar = mysqli_query($conexion, $cadenaInsertar);
echo $cadenaInsertar;
?>