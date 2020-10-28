    <?php
      $cadena_mods = "SELECT COUNT(acceso_modulos.id_modulo), modulos.nombre, modulos.nombre_carpeta
                    FROM acceso_modulos INNER JOIN modulos 
                    ON acceso_modulos.id_modulo = modulos.id 
                    AND acceso_modulos.id_usuario = '$id_usuario' AND modulos.panel_control = '1' GROUP BY id_modulo
                    ORDER BY COUNT(acceso_modulos.id_modulo) DESC LIMIT 5";

      $consulta_mods = mysqli_query($conexion, $cadena_mods);
    ?> 
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
        <li class="header">Opciones del módulo</li>
        <li class=""><a href="index.php"><i class="fa fa-bars"></i> <span>Preguntas</span></a></li>
        <li class=""><a href="cuestionario.php"><i class="fa fa-bars"></i> <span>Cuestionarios</span></a></li>
        <li class="active"><a href="resultados.php"><i class="fa fa-bars"></i> <span>Resultados</span></a></li>
      </ul>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Opciones de navegaci&oacute;n</li>
        <li><a href="../mPanel_control/index.php"><i class="fa fa-dashboard"></i> <span>Panel de Control</span></a></li>
        <li><a href="#"><i class="fa fa-picture-o"></i> <span>Cambiar Fotograf&iacute;a</span></a></li>
        <li><a href="../mCambiarContra/index.php"><i class="fa fa-key"></i> <span>Cambiar Contrase&ntilde;a</span></a></li>
        <li><a href="../global_seguridad/cerrarsesion.php"><i class="fa fa-unlock-alt"></i> <span>Cerrar Sesión</span></a></li>
      </ul>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Módulos Favoritos</li>
        <?php
        while($row_mods = mysqli_fetch_array($consulta_mods)){
        ?>
          <li><a href="<?php echo '../'.$row_mods[2].'/index.php'; ?>"><i class="fa fa-bars"></i> <span><?php echo $row_mods[1]; ?></span></a></li>
        <?php
        }
        ?>
      </ul>
    </section>