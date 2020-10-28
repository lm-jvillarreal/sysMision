<?php 
    include '../global_settings/conexion_oracle.php';
    include '../global_settings/conexion.php';
    $sucursal = $_POST['sucursal'];
    $tipo = $_POST['movimiento'];
    $folio = $_POST['folio'];

    $sql = "SELECT id FROM notas_entrada WHERE folio_mov = '$folio' AND tipo_mov = '$tipo' AND id_sucursal = '$sucursal'";

    $exSql = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_row($exSql);
    echo "$row[0]";
 ?>