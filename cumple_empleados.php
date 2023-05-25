<?php
// esto permite tener acceso desde otro servidor
//header('Access-Control-Allow-Origin: *');
// esto permite tener acceso desde otro servidor
include 'global_settings/consulta_sqlsrvr.php';

function nombremes($mes){
  setlocale(LC_TIME, 'es_ES.UTF-8');
  $nombre=strftime("%B",mktime(0, 0, 0, $mes, 1, 2000));
  return $nombre;
 }

 date_default_timezone_set("America/Monterrey");
 $num_mes = date('m');
 $letra_mes=nombremes($num_mes);

 $cadena_consulta = "SELECT RTRIM(LTRIM(e.nombre)) + ' ' + RTRIM(LTRIM(e.ap_paterno)) as Nombre, 
														FORMAT(e.fchnac, 'yyyy-MM-dd') AS fnac, 
														MONTH(e.fchnac) as 'M. Nac.',
														c.campo__14 as suc,
														c.campo__15 as depto,
														DAY(e.fchnac) as 'D. Nac.' FROM empleados as e INNER JOIN clasificacion_empleados as c ON e.codigo = c.codigo
											WHERE
														e.activo='S'
											AND   MONTH(e.fchnac) = $num_mes ORDER BY DAY(e.fchnac) ASC";

 $consulta_personas = sqlsrv_query($conn, $cadena_consulta);
 $completo = '';
 $color = 1;
 while($row_personas = sqlsrv_fetch_array($consulta_personas, SQLSRV_FETCH_ASSOC)){
	//echo $row_personas['Nombre'].' '.$row_personas['suc'].' '.$row_personas['depto'].' '.$row_personas['D. Nac.'].'<br>';
	if($color<=4){
		$color = $color;
	}else{
		$color = 1;
	}

	switch($color){
		case 1:
		$tema = "bg-green";
		break;
		case 2:
		$tema = "bg-yellow";
		break;
		case 3:
		$tema = "bg-red";
		break;
		case 4:
		$tema = "bg-aqua";
		break;
	}

	$fecha_cumple = new DateTime($row_personas['fnac']);
	$hoy = new DateTime();
	$annos = $hoy->diff($fecha_cumple);

	switch($row_personas['suc']){
		case 'DIAZ ORDAZ':
					$sucursal = 'DO';
					break;
		case 'ARBOLEDAS':
					$sucursal = 'ARB';
					break;
		case 'VILLEGAS':
					$sucursal = 'VILL';
					break;
		case 'ALLENDE':
					$sucursal = 'ALL';
					break;
		case 'PETACA':
					$sucursal = 'PET';
					break;
		case 'ADMINISTRACION':
					$sucursal = 'ADM';
					break;
	}
	$individual =
	'<div class="col-xs-12  col-sm-6 col-md-6 col-lg-3 ">
		<div class="info-box '.$tema.'">
			<span class="info-box-icon">'.$row_personas['D. Nac.'].'</span>
			<div class="info-box-content">
				<span class="progress-description">'.$row_personas['Nombre'].'</span>
				<span class="info-box-number">' . $annos->y.' años | '.$sucursal.' </span>
				<div class="progress">
					<div class="progress-bar" style="width: ' . $annos->y.'%"></div>
				</div>
				<span class="progress-description">
				'.$row_personas['depto'].' 
				</span>
			</div><!-- /.info-box-content -->
		</div><!-- /.info-box -->
	</div>';
	$completo = $completo.$individual;
	$color = $color+1;
 }
echo $completo;
?>