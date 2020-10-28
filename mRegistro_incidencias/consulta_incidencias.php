<?php
include '../global_settings/conexion.php';

$categoria = $_POST['categoria'];

if(empty($categoria)){
    $cadena_categoria ="";
    $data[] = array("id"=>"", "text"=>""); 
}else{
    if(!isset($_POST['searchTerm'])){ 
        $cadena_categoria = "SELECT id, incidencia FROM incidencias_vidvig WHERE activo = '1' AND id_categora = '$categoria'";
    }else{ 
        $search = $_POST['searchTerm'];   
        $cadena_categoria = "SELECT id, incidencia FROM incidencias_vidvig WHERE activo = '1' AND id_categora = '$categoria' AND incidencia LIKE '%".$search."%'";
    }
    $consulta_categoria = mysqli_query($conexion, $cadena_categoria);

    $data = array();
        while ($row_categoria=mysqli_fetch_array($consulta_categoria)) {
        $data[] = array("id"=>$row_categoria[0], "text"=>$row_categoria[1]); 
    }
}
echo json_encode($data);
?>