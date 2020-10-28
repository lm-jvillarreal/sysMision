<?php
	include '../global_seguridad/verificar_sesion.php';

	$fecha1   = $_POST['fecha1'];
	$fecha2   = $_POST['fecha2'];
	$sucursal = $_POST['sucursal'];

  $cantidad_cajas       = 0;
  $cantidad_actividades = 0;
  $nombre_promotor      = "";
  $nombre_compañia      = "";
  $duracion             = "";
  $color                = "";
  $numero               = 0;
  $horario              = "";
  $foto                 = "";
  $icono                = "";
  $ruta                 = "";
  $color2 = "";

	$cadena_principal = mysqli_query($conexion,"SELECT promotores.id,CONCAT( promotores.nombre, ' ', promotores.ap_paterno ) AS Nombre,promotores.compañia,agenda_promotores.hora_inicio,agenda_promotores.hora_fin, registro_entrada.hora_salida  
												FROM registro_entrada
												INNER JOIN promotores ON promotores.id = registro_entrada.id_promotor
												INNER JOIN agenda_promotores ON agenda_promotores.id_promotor = promotores.id  
												WHERE registro_entrada.fecha BETWEEN CAST( '$fecha1' AS DATE ) AND CAST( '$fecha2' AS DATE ) AND registro_entrada.id_sucursal = '$sucursal' GROUP BY promotores.id");

	while ($row_principal = mysqli_fetch_array($cadena_principal)) {
    $color2 = ($row_principal[5] == "")?"yellow":"red";
		$nombre_promotor = $row_principal[1];
		$nombre_compañia = $row_principal[2];
		$horario = substr($row_principal[3],0,5).'-'.substr($row_principal[4],0,5);

		$cadena_cajas = mysqli_query($conexion,"SELECT SUM(registro_actividades.cajas_surtidas),COUNT(*)
								FROM registro_actividades
								INNER JOIN actividades_promotor ON actividades_promotor.id = registro_actividades.id_actividad
								WHERE actividades_promotor.id_promotor = '$row_principal[0]' AND registro_actividades.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) AND registro_actividades.id_sucursal = '$sucursal'");
		$row_cajas = mysqli_fetch_array($cadena_cajas);
		$cantidad_cajas       = ($row_cajas[0] != "")?$row_cajas[0]:0;
		$cantidad_actividades = $row_cajas[1];
    $ruta = "logos/".$row_principal[0].'.jpg';
    if(file_exists($ruta)){
      $ruta = "logos/".$row_principal[0].'.jpg';
    }else{
      $ruta = "logos/logo.png";
    }
?>
	<div class="col-md-4 card<?php echo $numero;?>">
        <!-- Widget: user widget style 1 -->
        <div class="box box-widget widget-user-2">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <div class="widget-user-header bg-<?php echo $color2;?>">
            <div class="widget-user-image">
              <img class="img-circle" src="<?php echo $ruta;?>" alt="User Avatar">
            </div>
            <!-- /.widget-user-image -->
            <center>
            	<h4 class=""><?php echo $nombre_promotor;?></h4>
            	<h5 class=""><?php echo $nombre_compañia;?></h5>
            	<!-- <h5 class="">(<?php echo $horario;?>)</h5> -->
            </center>
          </div>
          <div class="box-footer no-padding">
            <ul class="nav nav-stacked">
              <li><a>Cajas Surtidas <span class="pull-right badge bg-yellow"><?php echo $cantidad_cajas;?></span></a></li>
              <li><a onclick="mostrar(<?php echo $numero?>)">Desglose Actividades <span class="pull-right badge bg-blue"><?php echo $cantidad_actividades;?></span></a></li>
              <?php
              	$cadena_des_act = mysqli_query($conexion,"SELECT actividades_promotor.actividad,SEC_TO_TIME(SUM(TIME_TO_SEC(registro_actividades.duracion)))
              						FROM registro_actividades 
									INNER JOIN actividades_promotor ON actividades_promotor.id = registro_actividades.id_actividad
									WHERE actividades_promotor.id_promotor = '$row_principal[0]' AND registro_actividades.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) AND registro_actividades.id_sucursal = '$sucursal' GROUP BY actividades_promotor.actividad");
              	while ($row_des_act = mysqli_fetch_array($cadena_des_act)) {
      					$duracion = ($row_des_act[1] == "")?"en proceso":$row_des_act[1];
      					$color    = ($row_des_act[1] == "")?"yellow":"green";
              ?>
              		<li class="hidden p<?php echo $numero;?>"><a>*<?php echo $row_des_act[0]?> <span class='pull-right badge bg-<?php echo $color;?>'><?php echo $duracion;?></span></a></li>
              <?php
              		$duracion = "";
					        $color    = "";
              	}
              ?>
              <li><a onclick="mostrar2(<?php echo $numero?>)"> Desglose Horario</a></li>
              <?php
              $cadena_ver = mysqli_query($conexion,"SELECT dia FROM agenda_promotores 
              WHERE dia BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) 
              AND activo != '0' AND id_sucursal = '$sucursal' AND id_promotor = '$row_principal[0]' ORDER BY dia");

              while ($row_ver = mysqli_fetch_array($cadena_ver)) {
                $cadena_ver2 = mysqli_query($conexion,"SELECT id,hora_entrada,hora_salida,SEC_TO_TIME((TIME_TO_SEC(registro_entrada.hora_salida) - TIME_TO_SEC(registro_entrada.hora_entrada))) FROM registro_entrada WHERE fecha = '$row_ver[0]' AND id_sucursal = '$sucursal' AND id_promotor = '$row_principal[0]'");
                $existe_ver = mysqli_num_rows($cadena_ver2);
                $cadena_ver2_row = mysqli_fetch_array($cadena_ver2);
                if($existe_ver == 0){
                ?>
                  <li class="hidden hor<?php echo $numero;?>"><a>* <?php echo $row_ver[0]?><span class="pull-right  badge bg-yellow">NO ASISTIO</span></a></li>
                <?php
                }else{
                ?>
                  <li class="hidden hor<?php echo $numero;?>"><a>* <?php echo $row_ver[0]?><span class="pull-right  badge bg-red"><?php echo substr($cadena_ver2_row[1], 0,5).'-'.substr($cadena_ver2_row[2], 0,5).', Tiempo: '.$cadena_ver2_row[3];?></span></a></li>
                <?php
                }

              }
                $cadena_multimedia = mysqli_query($conexion,"SELECT registro_actividades.id FROM registro_actividades INNER JOIN actividades_promotor ON registro_actividades.id_actividad = actividades_promotor.id WHERE  actividades_promotor.id_promotor = '$row_principal[0]' AND registro_actividades.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) AND registro_actividades.id_sucursal = '$sucursal'");
                $numero_foto = 0;
                $estatus = "";
                while ($row_multimedia = mysqli_fetch_array($cadena_multimedia)) {
                  $foto ='../mListaPromotores/evidencia/ev_'.$row_multimedia[0].'.jpg';
                  if (file_exists($foto)){
                    $estatus =($numero_foto == 0)?"":"hidden";
                    $icono.="<a class='venobox $estatus' href='$foto' alt='Imagen 1' data-gall='myGallery_$numero' title='$nombre_promotor'><i class='fa fa-file-image-o fa-lg'></i></a>";
                    $numero_foto ++;
                  }
                }
                if($icono != ""){
                  echo "<li class=''>".$icono."</li>";
                }
              ?>
            </ul>
          </div>
        </div>
        <!-- /.widget-user -->
  </div>
<?php
    $foto = "";
    $icono = "";
    $numero ++;
    $ruta = "";
	}
?>