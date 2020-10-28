<?php
include 'conexion_calendario.php';
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');

$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");
/* VALUES */
$id=$_POST['id'];
$title=$_POST['title'];
$start=$_POST['start'];
$end=$_POST['end'];
 
// connexion à la base de données
$cadena = mysqli_query($conexion,"SELECT folio FROM agenda WHERE id = $id");
$row = mysqli_fetch_array($cadena);
$sql = "UPDATE agenda SET title=?, start=?, end=?, fecha=?,hora=? WHERE folio=?";
$q = $bdd->prepare($sql);
$q->execute(array($title,$start,$end,$fecha,$hora,$row[0]));
echo "ok";
?>