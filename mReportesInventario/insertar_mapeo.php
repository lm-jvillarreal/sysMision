<?php
    include "../global_settings/conexion_pruebas.php";
    //include '../global_seguridad/verificar_sesion.php';
    date_default_timezone_set("America/Monterrey");
    $fecha = date('Y-m-d');
    $hora = date('H:i:s');
    $pMueble = $_POST['txtMueble'];
    $pZona = $_POST['txtZona'];
    $pCara = $_POST['txtCara'];
    $pArea = $_POST['cmbArea'];

    $select = "SELECT id FROM inv_mapeo WHERE zona = '$pZona' AND mueble = '$pMueble' AND cara = '$pCara' AND activo = 1";
    //echo "$select";
    $exSelect = mysqli_query($conexion, $select);
    $num = mysqli_num_rows($exSelect);

    if ($num != 0) {
        echo "false";
    }
    else{

        $qry= "INSERT INTO inv_mapeo (
                    id_sucursal,
                    fecha,
                    usuario,
                    activo,
                    mueble,
                    zona,
                    cara,
                    contador,
                    supervisor,
                    auditor,
                    completo,
                    asignado,
                    asignado_persona,
                    id_area,
                    impreso
                )
                VALUES
                    (
                        '1',
                        '$fecha',
                        '1',
                        1,
                        '$pMueble',
                        '$pZona',
                        '$pCara',
                        2,
                        3,
                        2,
                        0,
                        0,
                        0,
                        '$pArea',
                        0
                    )";
                    //echo "$qry";
            $consulta=mysqli_query($conexion,$qry);

        $max = "SELECT
                	MAX(inv_mapeo.id)
                FROM
                	inv_mapeo";
        $exMax = mysqli_query($conexion, $max);
        $row=mysqli_fetch_row($exMax);
        echo "$row[0]";
    }
 ?>
