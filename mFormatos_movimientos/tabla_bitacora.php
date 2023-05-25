<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$fecIni = $_POST["fecha_inicial"];
$fecFin = str_replace("-","",$_POST["fecha_final"]);
$parametro = $_POST['parametro'];
$fecha      = date('Y-m-d');
$prim_dia   = date('Y-m-01');

if($parametro==0){
    $fechaInicioLW = $prim_dia;
    $fechaFinLW = $fecha;
  }else{
    $fechaInicioLW = $fecIni;
    $fechaFinLW = $fecFin;
  }

$filtro_sucursal =($solo_sucursal=='1') ? " AND sucursal='$id_sede'":"";
 
$cadena_formatos ="SELECT f.id, f.tipo_movimiento, s.nombre, f.estatus, date_format(f.fecha, '%d/%m/%Y'), f.nombre_solicita, f.folio_infofin, f.usuario_libera, nombre_genera
                    FROM formatos_movimientos as f
                    INNER JOIN sucursales as s ON f.sucursal = s.id
                    WHERE f.fecha BETWEEN CAST('$fechaInicioLW' AS DATE) 
                    AND CAST('$fechaFinLW' AS DATE) 
                    AND (f.estatus = '1' OR f.estatus = '2' OR f.estatus = '3')";

$consulta_formatos = mysqli_query($conexion,$cadena_formatos);
$cuerpo ="";
while ($row_formatos = mysqli_fetch_array($consulta_formatos)) {
    if($row_formatos[3]=='1'){
        $estatus = "<center><span class='label label-primary'>Asociado</span></center>";
    }elseif ($row_formatos[3]=='2') {
        $estatus = "<center><span class='label label-success'>Liberado</span></center>";
	}elseif($row_formatos[3]=='3'){
        $estatus = "<center><span class='label label-danger'>Cancelado</span></center>";
    }
    
    if($row_formatos[1]=='ECHORI'){
      $nom_movimiento='CONVERSION CHORIZO';
    }elseif($row_formatos[1]=='EXCONV'){
        $nom_movimiento='CONVERSION ARTICULOS';
    }elseif($row_formatos[1]=='EXVIGI'){
        $nom_movimiento='ENTRADA POR VIGILANCIA';
    }elseif($row_formatos[1]=='SXMBOD'){
        $nom_movimiento = 'MERMA BODEGA';
    }elseif($row_formatos[1]=='SXMCAR'){
        $nom_movimiento='MERMA CARNICERIA';
    }elseif($row_formatos[1]=='SXMFCI'){
        $nom_movimiento='MERMA FARMACIA';
    }elseif($row_formatos[1]=='SXMFTA'){
        $nom_movimiento='MERMA FRUTAS Y VERDURAS';
    }elseif($row_formatos[1]=='SXMEDO'){
        $nom_movimiento='MERMA MAL ESTADO';
    }elseif($row_formatos[1]=='SXMCAD'){
        $nom_movimiento='MERMA POR CADUCIDAD';
    }elseif($row_formatos[1]=='SXMPAN'){
        $nom_movimiento='MERMA PANADERÍA';
    }elseif($row_formatos[1]=='SXMTOR'){
        $nom_movimiento='MERMA TORTILLERÍA';
    }elseif($row_formatos[1]=='SXMVAR'){
        $nom_movimiento='MERMA VARIEDADES';
    }elseif($row_formatos[1]=='SFAACC'){
        $nom_movimiento='FARMACIA ACCIDENTES';
    }elseif($row_formatos[1]=='SFCBOT'){
        $nom_movimiento='FARMACIA BOTIQUÍN';
    }elseif($row_formatos[1]=='SXROB'){
        $nom_movimiento='SALIDA POR ROBO';
    }elseif($row_formatos[1]=='TRADEP'){
        $nom_movimiento='TRANSFERENCIA DEPTOS.';
    }

    $cadena_libera = "SELECT CONCAT(p.nombre,' ',p.ap_paterno,' ',p.ap_materno)FROM personas as p INNER JOIN usuarios as u ON p.id=u.id_persona AND u.id = '$row_formatos[8]'";
    $usuario_libera = mysqli_query($conexion, $cadena_libera);
    $row_libera = mysqli_fetch_array($usuario_libera);
    $nombre_libera = $row_libera[0];

    $renglon = "
		{
			\"id\": \"$row_formatos[0]\",
			\"movimiento\": \"$row_formatos[1] - $nom_movimiento\",
			\"sucursal\": \"$row_formatos[2]\",
			\"estatus\": \"$estatus\",
			\"fecha\": \"$row_formatos[4]\",
            \"solicita\": \"$row_formatos[5]\",
            \"libera\": \"$nombre_libera\",
			\"folio\": \"$row_formatos[6]\"
		},";
	$cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');

$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
