<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$folio = $_POST['folio'];

date_default_timezone_set("America/Monterrey");
$fecha = date("Y-m-d");
$fecha_f = str_replace("-","",$fecha);
$hora = date("H:i:s");

$cadenaConsulta = "SELECT id, articulo, sucursal FROM auditoria_pv WHERE folio = '$folio'";
$consultaCodigo = mysqli_query($conexion, $cadenaConsulta);

while($rowCodigo = mysqli_fetch_array($consultaCodigo)){
  $codigo = $rowCodigo[1];

  $cadenaPrincipal = "SELECT
										INV_ARTICULOS_DETALLE.ARTC_ARTICULO AS Codigo,
										INV_ARTICULOS_DETALLE.ARTC_DESCRIPCION,
										INV_ARTICULOS_DETALLE.ARTN_ULTIMOPRECIO,
										familias.FAMC_DESCRIPCION AS Familia,
										(SELECT COM_FAMILIAS.FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE COM_FAMILIAS.FAMC_FAMILIA = familias.FAMC_FAMILIAPADRE ) AS Departamento,
										(SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, '$rowCodigo[2]', INV_ARTICULOS_DETALLE.ARTC_ARTICULO ) FROM dual ) AS Existencia,
										ROUND( INV_ARTICULOS_DETALLE.ARTN_COSTO_PROMEDIO, 2) AS C_PROM,
										(SELECT AREN_CANTIDAD FROM INV_ARTICULOS_EMPAQUE WHERE ARTC_ARTICULO = INV_ARTICULOS_DETALLE.ARTC_ARTICULO AND ROWNUM = 1) AS U_EMP
										FROM
										INV_ARTICULOS_DETALLE
										INNER JOIN COM_FAMILIAS familias ON familias.FAMC_FAMILIA = INV_ARTICULOS_DETALLE.ARTC_FAMILIA
										WHERE INV_ARTICULOS_DETALLE.ARTC_ARTICULO = '$codigo'";

  $consultaPrincipal = oci_parse($conexion_central,$cadenaPrincipal);
  oci_execute($consultaPrincipal);
  $row_articulo = oci_fetch_row($consultaPrincipal);

  $conteo = count($row_articulo);
  if ($conteo==0) {
    echo "no_existe";
  }else{
    if($row_articulo[2]==NULL){
      $ultimoCosto = 0;
    }else{
      $ultimoCosto = $row_articulo[2];
    }
    $cadena_ue = "SELECT * FROM (SELECT
                                detalle.MODN_FOLIO,
                                TO_CHAR(movs.MOVD_FECHAAFECTACION, 'DD/MM/YYYY'),
                                detalle.modc_tipomov,
                                NVL(detalle.RMON_CANTSURTIDA,0),
                                detalle.RMOC_UNIMEDIDA,
                                (SELECT CONCAT(PROC_CVEPROVEEDOR,PROC_NOMBRE) FROM cxp_proveedores WHERE TRIM(PROC_CVEPROVEEDOR) = TRIM(movs.MOVC_CVEPROVEEDOR)) AS Proveedor,
                                TO_CHAR(movs.MOVD_FECHAAFECTACION, 'YYYY-MM-DD')
                                FROM
                                INV_RENGLONES_MOVIMIENTOS detalle
                                INNER JOIN INV_MOVIMIENTOS movs ON movs.ALMN_ALMACEN = detalle.ALMN_ALMACEN 
                                AND detalle.MODN_FOLIO = movs.MODN_FOLIO 
                                AND movs.MODC_TIPOMOV = detalle.MODC_TIPOMOV 
                                WHERE
                                ARTC_ARTICULO = '$codigo' 
                                AND movs.ALMN_ALMACEN = '$rowCodigo[2]' 
                                AND detalle.ALMN_ALMACEN = '$rowCodigo[2]'
                                AND movs.MOVD_FECHAAFECTACION IS NOT NULL
                                AND ( detalle.MODC_TIPOMOV = 'ENTSOC' OR detalle.MODC_TIPOMOV = 'ENTCOC' OR detalle.MODC_TIPOMOV = 'ETRANS')
                                ORDER BY
                                movs.MOVD_FECHAAFECTACION DESC)
                  WHERE ROWNUM <=1";

    $st = oci_parse($conexion_central, $cadena_ue);
    oci_execute($st);
    $row_ue = oci_fetch_row($st);

    $fecha_i = str_replace("-","",$row_ue[6]);
    $cadenaVentas = "SELECT
                       NVL(SUM (DETALLE.ARTN_CANTIDAD),0)
                    FROM
                      PV_ARTICULOSTICKET detalle
                    INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA
                    AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO
                    WHERE
                      DETALLE.ARTC_ARTICULO = '$codigo'
                    AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i'
                    AND '$fecha_f'
                    AND TIK.TICC_SUCURSAL = '$rowCodigo[2]'
                    AND DETALLE.TICC_SUCURSAL = '$rowCodigo[2]'
                    AND TIK.TICN_ESTATUS = 3";
    $consultaVentas = oci_parse($conexion_central, $cadenaVentas);
    oci_execute($consultaVentas);
    $row_ventas = oci_fetch_row($consultaVentas);

    $faltante = $row_ventas[0] - $row_articulo[5];

    if($faltante == 0 || $row_articulo[7]==""){
      $fue = 0;
    }elseif($faltante < 0){
      $faltante_ue=($faltante * -1)/$row_articulo[7];
      $fue = ceil($faltante_ue);
      $fue = $fue * -1;
    }else{
      $faltante_ue=($faltante)/$row_articulo[7];
      $fue = ceil($faltante_ue);
    }

    $f_inicio = new DateTime($row_ue[6]);
    $f_fin = new DateTime($fecha);
    $diff = $f_inicio->diff($f_fin);
    $dias = $diff->days;
    $dias = $dias +1;

    if(empty($row_ventas[0])){
      $dias_inventario="";
      $mes_inventario = "";
    }else{
      $dias_inventario = $row_articulo[5]/($row_ventas[0]/$dias);//existencias/(ventas/dias)
      $dias_inventario = ROUND($dias_inventario);
      $mes_inventario = $dias_inventario/30;
      $mes_inventario = round($mes_inventario,2);
    }
    if($row_ue[3]==''){
      $cantidad_mov=0;
    }else{
      $cantidad_mov=$row_ue[3];      
    }
    $cadenaActualizar = "UPDATE auditoria_pv SET descripcion = '$row_articulo[1]', existencia = '$row_articulo[5]', ultima_entrada = '$row_ue[1]', tipo_mov = '$row_ue[2]', folio_mov = '$row_ue[0]', cantidad_mov = '$cantidad_mov', proveedor = '$row_ue[5]', departamento = '$row_articulo[4]', familia = '$row_articulo[3]', ultimo_costo = '$ultimoCosto', unidad_empaque = '$row_articulo[7]', ventas = '$row_ventas[0]', teorico = '$row_articulo[5]', faltante = '$faltante', faltante_cajas = '$fue', dias_inv = '$dias_inventario', meses_inv = '$mes_inventario', fecha = '$fecha', hora = '$hora', activo = '2' WHERE id = '$rowCodigo[0]'";
    $actualizarArticulo = mysqli_query($conexion, $cadenaActualizar);
    //echo $cadenaActualizar;
  }
}
echo "ok";
?>