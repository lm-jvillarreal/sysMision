    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="../d_plantilla/dist/img/personas/user.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $nombre_persona; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i><?php echo $nombre_sede; ?></a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Acceso Rápido</li>
      </ul>
      <div class="sidebar-form">
        <div class="input-group">
          <select name="modulos" id="modulos" class="form-control" style="width: 100%"></select>
          <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
            </button>
          </span>
        </div>
      </div>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Control de Producción</li>
       <li class="active"><a href="index.php"><i class="fa fa-bars"></i> <span>Registro de Merma</span></a></li>
        <li><a href="registro_pedido.php"><i class="fa fa-bars"></i> <span>Registro de Pedido</span></a></li>
        <li><a href="registro_produccion.php"><i class="fa fa-bars"></i> <span>Registro de Producción</span></a></li>
        <li><a href="registro_existencias.php"><i class="fa fa-bars"></i> <span>Existencias iniciales</span></a></li>
      </ul>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Opciones de navegaci&oacute;n</li>
        <li><a href="../mPanel_control/index.php"><i class="fa fa-dashboard"></i> <span>Panel de Control</span></a></li>
        <li><a href="../mAgendaPersonal/index.php"><i class="fa fa-calendar"></i> <span>Agenda personal</span></a></li>
        <li><a href="../mCambiarContra/index.php"><i class="fa fa-key"></i> <span>Cambiar Contrase&ntilde;a</span></a></li>
        <li><a href="../global_seguridad/cerrarsesion.php"><i class="fa fa-unlock-alt"></i> <span>Cerrar Sesión</span></a></li>
      </ul>
    </section>