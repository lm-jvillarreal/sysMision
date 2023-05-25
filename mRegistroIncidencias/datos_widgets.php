<?php
	include '../global_seguridad/verificar_sesion.php';
  
  $fechaI = $_POST['fecha1'];
  $fechaF = $_POST['fecha2'];
  $sucursal  = $_POST['sucursal'];
  //echo $sucursal;

  if($sucursal == ""){
    $cadena = "SELECT COUNT(i.id), i.sucursal, s.id  FROM incidencias i INNER JOIN sucursales s ON i.sucursal = s.nombre WHERE i.fecha BETWEEN CAST('$fechaI' AS DATE)
    AND CAST('$fechaF' AS DATE) and s.activo = '1' GROUP BY i.sucursal";
	  $consulta = mysqli_query($conexion, $cadena);
//echo $cadena;
    
  	while ($row = mysqli_fetch_array($consulta)){
      if($row[1] == 'DIAZ ORDAZ'){
        $Suc = "1";
      }else if($row[1] == 'ARBOLEDAS'){
        $Suc = "2";
      }else if($row[1] == 'VILLEGAS'){
        $Suc = "3";
      }else if($row[1] == 'ALLENDE'){
        $Suc = "4";
      }else if($row[1] == 'PETACA'){
        $Suc = "5";
      }else if($row[1] == 'MONTEMORELOS'){
        $Suc = "6";
      }else if($row[1] == 'CEDIS'){
        $Suc = "99";
      }
     // echo $Suc;
		  $cadena_desglose ="SELECT * FROM incidencias WHERE sucursal = '$row[1]'";
		  $consulta_desglose = mysqli_query($conexion, $cadena_desglose);
		  $row_desglose = mysqli_fetch_array($consulta_desglose);
     // echo $cadena_desglose;
		  $clase = "bg-aqua";
?>
  <div class="col-md-4 col-sm-6 col-xs-12">
    <div class="info-box <?php echo $clase;?>">
      <span class="info-box-icon" onclick="datos(<?php echo $row[2]?>)"><i class="fa fa-users"></i></span>
      <div class="info-box-content">
        <span class="info-box-text"><?php echo $row[1];?></span>
        <span class="info-box-number"><?php echo $row[0]; ?></span>
        <div class="progress">
          <div class="progress-bar" style="width: 100%" id="barra_progreso"></div>
        </div>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
<?php
  }//echo $Suc;
  }else{
    if($sucursal == '1'){
      $Suc = "DIAZ ORDAZ";
    }else if($sucursal == '2'){
      $Suc = "ARBOLEDAS";
    }else if($sucursal == '3'){
      $Suc = "VILLEGAS";
    }else if($sucursal == '4'){
      $Suc = "ALLENDE";
    }else if($sucursal == '5'){
      $Suc = "PETACA";
    }else if($sucursal == '6'){
      $Suc = "MONTEMORELOS";
    }else if($sucursal == '99'){
      $Suc = "CEDIS";
    }
    $cadena = "SELECT COUNT(id), sucursal FROM incidencias WHERE sucursal ='$Suc' 
              AND fecha BETWEEN CAST('$fechaI' AS DATE)
              AND CAST('$fechaF' AS DATE)  GROUP BY sucursal " ;
    $consulta = mysqli_query($conexion, $cadena);
    //echo $cadena;
    while ($row = mysqli_fetch_array($consulta)) {
      $cadena_desglose ="SELECT * FROM incidencias WHERE sucursal = '$row[1]'";
      $consulta_desglose = mysqli_query($conexion, $cadena_desglose);
      $row_desglose = mysqli_fetch_array($consulta_desglose);
  
      $clase = "bg-aqua";
?>
  <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="info-box <?php echo $clase;?>">
        <span class="info-box-icon" onclick="datos(<?php echo $sucursal?>)"><i class="fa fa-users"></i></span>
        <div class="info-box-content">
          <span class="info-box-text"><?php echo $row[1];?></span>
          <span class="info-box-number"><?php echo $row[0]; ?></span>
          <div class="progress">
            <div class="progress-bar" style="width: 100%" id="barra_progreso"></div>
          </div>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <?php
      }
  }
  ?>