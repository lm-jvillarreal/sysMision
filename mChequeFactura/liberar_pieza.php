<?
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");
$gId=$_POST["id"]; 

$actualizar = mysqli_query($conexion,"UPDATE historial_requisicion
                                                SET activo = '0'
                                                WHERE
                                                    id = '$gId'");

$consulta=mysqli_query($conexion,"SELECT
                                        h.id,
                                        h.codigo_interno,
                                        h.id_almacen,
                                        h.cantidad
                                    FROM
                                        historial_requisicion h
                                    WHERE
                                        h.id = '$gId'");
$row=mysqli_fetch_row($consulta);

$consulta2=mysqli_query($conexion,"SELECT
                                        h.id,
                                        h.codigo_interno,
                                        h.id_almacen,
                                        h.cantidad
                                    FROM
                                        historial_existencias h
                                    WHERE
                                        h.codigo_interno = '$row[1]'");
$row1=mysqli_fetch_row($consulta2);

$NuevaCantidad = $row1[3] - $row[3];

$actualizar2 = "UPDATE historial_existencias
                                        SET cantidad = '$NuevaCantidad'
                                        WHERE
                                            codigo_interno = '$row[1]'
                                        AND id_almacen = '$row[2]'";
$ejecutar=mysqli_query($conexion,$actualizar2);
echo"$actualizar2";
?>