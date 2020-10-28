    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="../d_plantilla/dist/img/personas/user.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $nombre_persona; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> En L&iacute;nea</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Opciones del módulo</li>
        <li class="active"><a href="index.php"><i class="fa fa-bars"></i> <span>Resumen de aportaciones.</span></a></li>
        <li><a href="registro_aportaciones.php"><i class="fa fa-bars"></i> <span>Aportaciones en especie.</span></a></li>
        <li><a href="registro_nc.php"><i class="fa fa-bars"></i> <span>Aportaciones por N.C.</span></a></li>
        <li><a href="registro_manual.php"><i class="fa fa-bars"></i> <span>Aportaciones manuales.</span></a></li>
      </ul>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Opciones de navegaci&oacute;n</li>
        <li><a href="../mPanel_control/index.php"><i class="fa fa-dashboard"></i> <span>Panel de Control</span></a></li>
        <li><a href="#"><i class="fa fa-picture-o"></i> <span>Cambiar Fotograf&iacute;a</span></a></li>
        <li><a href="../mCambiarContra/index.php"><i class="fa fa-key"></i> <span>Cambiar Contrase&ntilde;a</span></a></li>
        <li><a href="../global_seguridad/cerrarsesion.php"><i class="fa fa-unlock-alt"></i> <span>Cerrar Sesión</span></a></li>
      </ul>
    </section>