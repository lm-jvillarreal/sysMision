<?php
include '../global_seguridad/verificar_sesion.php';
$folio = $_POST['folio'];
$usuario = $_POST['usuario'];

$cadenaFolio = "SELECT folio_desc, 
                       articulo, 
                       descripcion, 
                       IFNULL(existencia,0.0), 
                       ultima_entrada, 
                       tipo_mov, 
                       folio_mov, 
                       IFNULL(cantidad_mov,0.0), 
                       proveedor, 
                       departamento, 
                       familia, 
                       IFNULL(ultimo_costo,0.0), 
                       unidad_empaque, 
                       IFNULL(ventas,0.0), 
                       IFNULL(teorico,0.0), 
                       IFNULL(faltante,0.0), 
                       IFNULL(faltante_cajas,0.0), 
                       dias_inv, 
                       meses_inv, 
                       codigo_comentario,
                       sucursal 
                FROM auditoria_pv WHERE folio = '$folio'";
$consultaFolio = mysqli_query($conexion, $cadenaFolio);

$cadena_folio = "SELECT IFNULL(MAX(folio),0)+1 FROM auditoria_pv";
$consulta_folio = mysqli_query($conexion,$cadena_folio);
$row_folio = mysqli_fetch_array($consulta_folio);
$folio_registro = $row_folio[0];

while($rowFolio = mysqli_fetch_array($consultaFolio)){
  $cadenaInsertar = "INSERT INTO auditoria_pv ( folio,
                                                folio_desc, 
                                                articulo, 
                                                descripcion, 
                                                existencia, 
                                                ultima_entrada, 
                                                tipo_mov, 
                                                folio_mov, 
                                                cantidad_mov, 
                                                proveedor, 
                                                departamento, 
                                                familia, 
                                                ultimo_costo, 
                                                unidad_empaque, 
                                                ventas, 
                                                teorico, 
                                                faltante, 
                                                faltante_cajas, 
                                                dias_inv, 
                                                meses_inv, 
                                                codigo_comentario,
                                                fecha,
                                                hora,
                                                activo,
                                                usuario,
                                                sucursal)VALUES(
                                                  '$folio_registro',
                                                  '$rowFolio[0]',
                                                  '$rowFolio[1]',
                                                  '$rowFolio[2]',
                                                  '$rowFolio[3]',
                                                  '$rowFolio[4]',
                                                  '$rowFolio[5]',
                                                  '$rowFolio[6]',
                                                  '$rowFolio[7]',
                                                  '$rowFolio[8]',
                                                  '$rowFolio[9]',
                                                  '$rowFolio[10]',
                                                  '$rowFolio[11]',
                                                  '$rowFolio[12]',
                                                  '$rowFolio[13]',
                                                  '$rowFolio[14]',
                                                  '$rowFolio[15]',
                                                  '$rowFolio[16]',
                                                  '$rowFolio[17]',
                                                  '$rowFolio[18]',
                                                  '$rowFolio[19]',
                                                  '$fecha',
                                                  '$hora',
                                                  '2',
                                                  '$usuario',
                                                  '$rowFolio[20]'
                                                )";
  $consultaInsertar = mysqli_query($conexion,$cadenaInsertar);
}
echo $cadenaInsertar;
?>