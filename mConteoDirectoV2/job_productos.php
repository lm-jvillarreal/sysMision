<?php
    //include "../global_settings/conexion_pruebas.php";
    //include "../global_settings/conexion.php";
    include '../global_settings/conexion_oracle.php';
    $con=mysqli_connect("200.1.1.178","root","Xoops1991","sysadmision2");
            // Check connection
            if (mysqli_connect_errno())
              {
              echo "Failed to connect to MySQL: " . mysqli_connect_error();
              }
ini_set('max_execution_time', 600);



    $sql = "SELECT artc_articulo, artc_descripcion FROM com_articulos";
    $st = oci_parse($conexion_central, $sql);
    oci_execute($st);


    while ($row = oci_fetch_row($st)) {
        // $sql2 = "INSERT INTO productos (codigo_producto, descripcion) VALUES('$row[0]', '$row[1]')";
        // echo "$sql2";
        // $exs2 = mysqli_query($conexion, $sql2) or die(mysqli_error());





            // Perform a query, check for error
            if (!mysqli_query($con,"INSERT INTO productos (codigo_producto, descripcion) VALUES('$row[0]', '$row[1]')"))
              {
              echo("Error description: " . mysqli_error($con));
              }

            
    }
    mysqli_close($con);
    
 ?>
