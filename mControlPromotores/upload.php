<?php
    include '../global_seguridad/verificar_sesion.php';
    $id_promotor=trim($_POST["id_promotor_modal_subir"]).'.jpg';
    if (is_array($_FILES) && count($_FILES) > 0) {
        if (($_FILES["file"]["type"] == "image/pjpeg")
            || ($_FILES["file"]["type"] == "image/jpeg")) {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], "logos/".$id_promotor)) {
                //more code here...
                echo "logos/".$id_promotor;
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