<?php
    error_reporting(E_ALL ^ E_NOTICE);
    session_name("login_supsys"); 
    session_start(); 
    //include'../global_seguridad/verificar_sesion.php';
    //include'../configuracion/conexion_servidor.php';
    //session_start();
    //ob_start();
	  $s_idUsuario = $_SESSION["s_IdUser"];
    $variable=$_SESSION["s_IdNameUser"];
    $nombre=$_SESSION["s_IdPersona"];
    $sucursal = $_SESSION["s_Sucursal"];
    $s_idPerfil = $_SESSION["sTipoUsuario"];
?>
  <!DOCTYPE html>
  <html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta content="charset=utf-8">
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>SupSys</title>
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <link rel="stylesheet" href="../assets/css/animate.css">
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.css" />
    <link rel="stylesheet" href="../assets/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="../assets/css/custom.css" />
    <link rel="stylesheet" href="../assets/css/responsiveslides.css">
    <link rel="stylesheet" href="../assets/css/demo.css">
    <link rel="stylesheet" href="../assets/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="../assets/plugins/select2/select2.css" />
    <link rel="stylesheet" href="../assets/sweetalert2-master/dist/sweetalert2.css">
    <link href='../iconos/logo.png' rel='shortcut icon' type='image/png' />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="../assets/css/personal.css" />
    <script src="funciones.js"></script>
    <script src="../plugins/jquery/jquery-1.8.3.min.js"></script>
    <script src="../assets/sweetalert2-master/dist/sweetalert2.js"></script>
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/jquery.metisMenu.js"></script>
    <script src="../assets/js/responsiveslides.min.js"></script>
    <script src="../assets/plugins/select2/select2.full.min.js"></script>
    <script type="text/javascript" src="../plugins/bootstrap-filestyle/src/bootstrap-filestyle.js"></script>
  </head>

  <body onload="javascript:blanco()">
    <div id="wrapper">
      <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">SupSys</a>
        </div>
        <div style="color: white; padding: 15px 50px 5px 50px; float: right; font-size: 16px;"> &nbsp; <a href="../login/cerrarsesion.php" class="btn btn-danger square-btn-adjust">Cerrar Sesion</a></div>
      </nav>
      <!-- /. NAV TOP  -->
      <nav class="navbar-default navbar-side" role="navigation">
        <?php 
        include ("menu.php");
        ?>
      </nav>
      <!-- /. NAV SIDE  -->
      <div id="page-wrapper">
        <div id="page-inner">
          <div class="row">
            <div class="col-md-12">
              <h5 align="right">Bienvenido(a): <b></b></h5>
              <?php
                        // include 'modal.php';
                        // if($s_idPerfil == 1)
                        // {
                        //     echo"<h5 align='right'>Perfil: <b>Administrador</b></h5><br>";
                        // }
                        // else if($s_idPerfil == 2)
                        // {
                        //     echo"<h5 align='right'>Perfil: <b>Comprador</b></h5><br>";
                        // }
                        // else if($s_idPerfil == 3)
                        // {
                        //     echo"<h5 align='right'>Perfil: <b>Almacenista</b></h5>";
                        //     echo"<h5 align='right'>Sucursal: <b> $s_idSucursal </b></h5><br>";
                        // }
                        // else if($s_idPerfil == 5)
                        // {
                        //     echo"<h5 align='right'>Perfil: <b>Gerente</b></h5>";
                        //     echo"<h5 align='right'>Sucursal: <b> $s_idSucursal </b></h5><br>";
                        // }
                        //  else if($s_idPerfil == 6)
                        // {
                        //     echo"<h5 align='right'>Perfil: <b>Administrador Rey</b></h5><br>";
                        // }
                        ?>                                             
            </div>
          </div>
          <h2>Faltantes y Sobrantes de cajeros</h2>
          <div class="row">
            <div class="col-lg-6">
              <form id="frmDatos" action="rpt_analisis.php" method="POST">
                <br>
                <label for="">Fecha_inicial</label>
                <input type="date" class="form-control" name="fecha_inicial">
                <label for="">Fecha final</label>
                <input type="date" name="fecha_final" class="form-control">
                <label for="">Sucursal</label>
                <select class="form-control" name="sucursal" id="">
                  <option value="1">Diaz Ordaz</option>
                  <option value="2">Arboledas</option>
                  <option value="3">Villegas</option>
                  <option value="4">Allende</option>
                </select>
                <br>
                <a href="javascript:consulta();" onclick="bitacora(<?php echo $s_idUsuario ?>, 26);" class="btn btn-danger">Consultar</a>
                <input type="submit" class="btn btn-danger" value="Generar excel">
              </form>
            </div>
            <div class="col-lg-6">
              <p>Atención: El total de faltante puede verse alterado cuando la cajera(o) use una forma de pago en punto de venta y registre otra en corte de caja.</p>
              <p>Ejemplo: En punto de venta, un pago electronico especial se registra como pago en efectivo, pero en el corte de caja, se registra como pago electronico especial, ocasionando un faltante efectivo inexistente.</p>
            </div>
            <br>
            <div class="col-lg-4">
              <br>
              <br>
            </div>
          </div>
          <hr>

          <div id="contenedor_tabla">
          </div>


          
    <script type="text/javascript">
            $(document).ready(function(){
            $("#cmbProveedor").select2();
        });
    </script>
  </body>
  </html>

