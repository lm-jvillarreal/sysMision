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
        <li class="header">Opciones del módulo</li>
        <li class="active"><a href="index.php"><i class="fa fa-bars"></i> <span>R. Compras y pagos</span></a></li>
        <li class="active"><a href="index_rpt_facturas_uuid.php"><i class="fa fa-bars"></i> <span>R. Facturas UUID</span></a></li>
        <li class="active"><a href="index_rpt_facturas_ingresos.php"><i class="fa fa-bars"></i> <span>R. Facturas-Ingresos</span></a></li>
        <li class="active"><a href="index_rpt_comprobantes_cheques.php"><i class="fa fa-bars"></i> <span>R. Comprobantes-Cheques</span></a></li>
        <li class="active"><a href="index_rpt_comprobantes_transferencias.php"><i class="fa fa-bars"></i> <span>R. Comprobantes-Transferencias</span></a></li>
        <li class="active"><a href="index_rpt_creditos.php"><i class="fa fa-bars"></i> <span>R. Creditos</span></a></li>
      </ul>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Opciones de navegaci&oacute;n</li>
        <li><a href="../mPanel_control/index.php"><i class="fa fa-dashboard"></i> <span>Panel de Control</span></a></li>
        <li><a href="#"><i class="fa fa-picture-o"></i> <span>Cambiar Fotograf&iacute;a</span></a></li>
        <li><a href="../mCambiarContra/index.php"><i class="fa fa-key"></i> <span>Cambiar Contrase&ntilde;a</span></a></li>
        <li><a href="../global_seguridad/cerrarsesion.php"><i class="fa fa-unlock-alt"></i> <span>Cerrar Sesión</span></a></li>
      </ul>
    </section>