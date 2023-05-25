<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
$datos=array();
$cadenaConsulta="SELECT 
                  (SELECT FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE FAM.FAMC_FAMILIAPADRE = COM_FAMILIAS.FAMC_FAMILIA AND ROWNUM =1) AS Departamento,
                  FAM.FAMC_DESCRIPCION,
                  COM_ARTICULOS.ARTC_ARTICULO, 
                  COM_ARTICULOS.ARTC_DESCRIPCION,
                  (
                  SELECT 
                      spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 1, COM_ARTICULOS.ARTC_ARTICULO)
                    FROM 
                      dual
                  ) DO,
                  (SELECT 
                              
                              spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 2, COM_ARTICULOS.ARTC_ARTICULO)
                            FROM 
                              dual) ARB,
                  (SELECT 
                              spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 3, COM_ARTICULOS.ARTC_ARTICULO)
                              
                            FROM 
                              dual) VILL,
                  (SELECT 
                              spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 4, COM_ARTICULOS.ARTC_ARTICULO)
                            FROM 
                              dual) ALLE,
                  (SELECT 
                              spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 5, COM_ARTICULOS.ARTC_ARTICULO)
                            FROM 
                              dual) PET,
                  (SELECT 
                              spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 99, COM_ARTICULOS.ARTC_ARTICULO)
                            FROM 
                              dual) CEDIS,
                  TO_CHAR(COM_ARTICULOS.ARTD_ALTA,'DD/MM/YYYY')
                  FROM COM_ARTICULOS
                  INNER JOIN COM_FAMILIAS FAM ON FAM.FAMC_FAMILIA = COM_ARTICULOS.ARTC_FAMILIA
                  WHERE com_articulos.artn_estatus='1'";

$st = oci_parse($conexion_central, $cadenaConsulta);
      oci_execute($st);
while($rowExistencias = oci_fetch_array($st)){
  array_push($datos,array(
    'depto'=>$rowExistencias[0],
    'familia'=>$rowExistencias[1],
    'articulo'=>$rowExistencias[2],
    'descripcion'=>$rowExistencias[3],
    'alta'=>$rowExistencias[10],
    'do'=>$rowExistencias[4],
    'arb'=>$rowExistencias[5],
    'vill'=>$rowExistencias[6],
    'all'=>$rowExistencias[7],
    'pet'=>$rowExistencias[8],
    'cedis'=>$rowExistencias[9]
  ));
}
echo utf8_encode(json_encode($datos));
?>