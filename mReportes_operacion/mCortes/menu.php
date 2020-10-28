<div class="sidebar-collapse">
	<ul class="nav" id="main-menu">
		<li class="text-center">
			<br>
			<img src="../assets/img/logo.png" width="180" height="90">
		</li>
		<br>
				<li>
					<a class='active-menu' href='../../inicio/index.php'><i class='fa fa-home fa-2x'></i>Inicio</a>
				</li>
		<?php if ($s_idPerfil == 7 || $s_idPerfil == 8) {?>
			<li>
				<a class='menu' href='../mEtiquetas/index.php'><i class='fa fas fa-ticket-alt fa-2x'></i>Etiquetas</a>
			</li>
			<li>
				<a class='menu' href='../mAuditoria/'><i class='fas fa-search fa-2x'></i>Auditoria de precios</a>
			</li>
		<?}else{?>
			<li>
				<a class='menu' href='../mEtiquetas/index_sistemas.php'><i class='fas fa-ticket-alt fa-2x'></i>Etiquetas</a>
			</li>
			<li>
				<a class='menu' href='../mAuditoria/index_sistemas.php'><i class='fas fa-search fa-2x'></i>Auditoria de precios</a>
			</li>

			<?} ?>				
				<li>
					<a class='menu' href='../mBitacora/'><i class='fas fa-address-book fa-2x'></i>Bitacora Reportes</a>
				</li>
				<li>
					<a href="../mBitacoraManuales"><i class="fas fa-book fa-2x"></i>Bitacora Manuales</a>
				</li>
				<li>
					<a class='menu' href="#"><i class='fas fa-code fa-2x'></i>Diferencia de costos</a>
				</li>
				<li>
					<a href="../mRevFac/" class="menu"><i class="far fa-clipboard fa-2x"></i>Revision de facturas</a>
				</li>
				<li>
					<a href="../mVerificador_inv/" class="menu"><i class="fas fa-check fa-2x"></i>Verificador de inventarios</a>
				</li>
				<li>
					<a href="../mTurnos/" class="menu"><i class="fas fa-sort-numeric-up fa-2x"></i>Turnos para proveedores</a>
				</li>
				<li>
					<a href="../mCantidadEntradas/" class="menu"><i class="fas fas fa-chart-bar fa-2x"></i>Ordenes por usuario</a>
				</li>
				<li>
					<a href="../mPersonaAutoriza/" class="menu"><i class="fab fa-autoprefixer fa-2x"></i>Persona autoriza</a>
				</li>
				<li>
					<a href="../mVentana/" class="menu"><i class="fas fa-cart-plus fa-2x"></i>Consulta Articulos</a>
				</li>
				<li>
					<a href="../mPedidosArtc/" class="menu"><i class="fas fa-plus fa-2x"></i>Pedidos</a>
				</li>
				<li>
					<?php if ($s_idPerfil == 1) {?>
					<a href="../mCloud/" class="menu"><i class="fas fa-book fa-2x"></i>Manuales</a>
					<?}else{?>
					<a href="../mCloud/index_descarga.php" class="menu"><i class="fas fa-book fa-2x"></i>Manuales</a>
					<?}?>
				</li>
				<li>
					<?php if ($s_idPerfil == 5 || $s_idPerfil == 1) {?>
					<a href="../mListaCostos/" class="menu"><i class="fas fa-list-ul fa-2x"></i>Lista de costos</a>
					<?}else if ($s_idPerfil == 10) {?>
					<a href="../mListaCostos/index_lista.php" class="menu"><i class="fas fa-list-ul fa-2x"></i>Lista de costos</a>
					<?}?>
				</li>
				<li>
					<a href="../mCortes" class="menu"><i class="far fa-frown fa-2x"></i> Faltantes</a>
				</li>					
				<li>
					<a href="../mAjustesPositivos/" class="menu"><i class="fas fa-adjust fa-2x"></i>Ajustes de inventario</a>
				</li>
				<li>
					<a href="../mNotas/" class="menu"><i class="fas fa-times fa-2x"></i></i>Diferencia en precios</a>
				</li>
				<li>
					<a href="../mCancelaciones" class="menu"><i class="fas fa-ban fa-2x"></i>Cancelaciones por cajero</a>
				</li>
		</div>