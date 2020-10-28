<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$filtro_sucursal =($solo_sucursal=='1') ? " AND sucursal='$id_sede'":"";

//$cadena_formatos = "".$filtro_sucursal;
//$consulta_formatos = mysqli_query($conexion, $cadena_formatos);
 
$cadena_formatos ="SELECT f.id, f.tipo_movimiento, s.nombre, f.estatus, date_format(f.fecha, '%d/%m/%Y'), f.nombre_solicita, f.folio_infofin
                    FROM formatos_movimientos as f 
                    INNER JOIN sucursales as s ON f.sucursal = s.id
                    WHERE (f.estatus = '0' or f.estatus = '1')".$filtro_sucursal;

$consulta_formatos = mysqli_query($conexion,$cadena_formatos);
$cuerpo ="";
while ($row_formatos = mysqli_fetch_array($consulta_formatos)) {
    if ($row_formatos[3]=='0') {
        $estatus = "<center><span class='label label-danger'>Pendiente</span></center>";
        $cancelar = "<button onclick='cancelar($row_formatos[0])' class='btn btn-danger' type='button'><i class='fa fa-trash-o fa-lg' aria-hidden='true'></i></button>";
	}elseif($row_formatos[3]=='1'){
        $estatus = "<center><span class='label label-success'>Asociado</span></center>";
        $cancelar = "";
    }
    
    $folio = "<div class='input-group' style='width:100%''><input type='number' id='folio_$row_formatos[0]' class='form-control' value='$row_formatos[6]'><span class='input-group-btn'><button onclick='asocia($row_formatos[0])' class='btn btn-success' type='button'><i class='fa fa-floppy-o fa-lg' aria-hidden='true'></i></button></span></div>";
    
    $escape_solicita = mysqli_real_escape_string($conexion,$row_formatos[5]);

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
    $renglon = "
		{
            \"id\": \"$row_formatos[0]\",
            \"movimiento\": \"$row_formatos[1] - $nom_movimiento\",
            \"sucursal\": \"$row_formatos[2]\",
            \"estatus\": \"$estatus\",
            \"fecha\": \"$row_formatos[4]\",
            \"solicita\": \"$row_formatos[5]\",
            \"folio\": \"$folio\",
            \"cancelar\": \"$cancelar\"
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
?>