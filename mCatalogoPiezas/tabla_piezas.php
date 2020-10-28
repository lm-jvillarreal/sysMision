<?php
include '../global_seguridad/verificar_sesion.php';

$cadenaPiezas = "SELECT
                    catalogo_piezas.codigo_interno,
                    familias_mantenimiento.nombre,
                    catalogo_piezas.descripcion,
                    catalogo_piezas.descripcion_det,
                    catalogo_piezas.foto,
                    catalogo_piezas.ult_costo_pza,
                    catalogo_piezas.unidad_med,
                    catalogo_piezas.max,
                    catalogo_piezas.min,
                    catalogo_piezas.reorden,
                    catalogo_piezas.rack,
                    catalogo_piezas.columna,
                    catalogo_piezas.fila,
                    catalogo_piezas.id_cat,
                    familias_mantenimiento.clave_familia
                  FROM
                  catalogo_piezas
                  INNER JOIN familias_mantenimiento
                  WHERE
                  catalogo_piezas.clave_familia = familias_mantenimiento.clave_familia";
$consultaPiezas = mysqli_query($conexion, $cadenaPiezas);
$cuerpo ="";
while ($rowPiezas = mysqli_fetch_array($consultaPiezas)) {
  $familia = mysqli_real_escape_string($conexion, $rowPiezas[1]);
  $descripcion = mysqli_real_escape_string($conexion, $rowPiezas[2]);
  $detalles = mysqli_real_escape_string($conexion, $rowPiezas[3]);
	$renglon = "
		{
      \"codigo_interno\": \"$rowPiezas[0]\",
      \"familia\": \"$familia\",
      \"descripcion\": \"$descripcion\",
      \"detalles\": \"$detalles\",
      \"foto\": \"\",
      \"ultimo_costo\": \"$rowPiezas[5]\",
      \"costo_promedio\": \"$rowPiezas[6]\",
      \"maximo\": \"$rowPiezas[7]\",
      \"minimo\": \"$rowPiezas[8]\",
      \"editar\": \"\"
		},";
	$cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');

$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>