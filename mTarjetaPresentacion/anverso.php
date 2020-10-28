<?php
include '../global_seguridad/verificar_sesion.php';
/**
 * Forzar la descarga de un archivo con
 * PHP. Ejemplo 1
 *
 * @author parzibyte
 */

# Pon su ruta absoluta, no importa qué tipo sea
$rutaArchivo = __DIR__ . "/anverso.png";

# Obtener nombre sin ruta completa, únicamente para sugerirlo al guardar
$nombreArchivo = basename("a_".$id_usuario.".png");

# Algunos encabezados que son justamente los que fuerzan la descarga
header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary");
header("Content-disposition: attachment; filename=$nombreArchivo");
# Leer el archivo y sacarlo al navegador
readfile($rutaArchivo);
# No recomiendo imprimir más cosas después de esto
?>