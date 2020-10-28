<?php
    include '../global_seguridad/verificar_sesion.php';
    $id_codigo=trim($_POST["id_codigo"]).'.png';
    if (is_array($_FILES) && count($_FILES) > 0) {
        if (($_FILES["file"]["type"] == "image/png")
            || ($_FILES["file"]["type"] == "image/png")) {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], "images/".$id_codigo)) {
                //more code here...
                echo "images/".$id_codigo;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
?>