    <!-- Logo -->
    <a href="../mPanel_control/index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>C</b>P</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="../d_plantilla/dist/img/logo.png" width="35%"><b>Central</b>Point</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown messages-menu">
            <a onclick="verificador_inventario();" class="dropdown-toggle" data-toggle="dropdown" title="Verificador de Inventario">
              <i class="fa fa-search"></i>
            </a>
          </li>
          <li class="dropdown messages-menu">
            <a onclick="verificador_precios();" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-barcode"></i>
            </a>
          </li>
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-birthday-cake"></i>
              <span class="label label-success"><?php include 'conteo_cumple.php'; ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Cumpleaños de hoy</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <?php include 'edad.php'; ?>
                </ul>
              </li>
            </ul>
          </li>
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell"></i>
              <span class="label label-warning">
                <div id="cantidad_notificaciones"></div>
              </span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">
                <div id="cantidad_notificaciones1"></div>
              </li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu" id="cuerpo">

                </ul>
              </li>
              <li class="footer"><a href="../mAgendaPersonal/index.php">Ver Todo</a></li>
            </ul>
          </li>
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-question-circle"></i>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Manual de Usuario</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <!-- Task item -->
                    <a href="" data-toggle="modal" data-target="#modal">
                      <h3>
                        Visualizar Manual de <?php echo $nombre_modulo; ?>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-green" style="width: 100%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                </ul>
              </li>
              <li class="footer">
                <a href="../mManuales/ver_manuales.php">Ver todos los manuales</a>
              </li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo "../d_plantilla/dist/img/personas/".$imagen_persona; ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $nombre_persona; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo "../d_plantilla/dist/img/personas/".$imagen_persona; ?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo $nombre_persona; ?> - <?php echo $nombre_perfil;
                                                    $newDate = strftime("%B de %Y", strtotime($fechaAlta_usuario));
                                                    ?>
                  <small>Miembro desde <?php echo $newDate; ?></small>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="../global_seguridad/cerrarsesion.php" class="btn btn-default btn-flat">Cerrar Sesi&oacute;n</a>
                </div>
                <div class="pull-left">
                  <a href="../mMisDatos/index.php" class="btn btn-default btn-flat">Mis Datos</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <!--<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>-->
          </li>
        </ul>
      </div>
    </nav>