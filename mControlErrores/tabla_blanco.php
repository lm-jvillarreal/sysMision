<?php
		date_default_timezone_set('America/Monterrey');
		$fecha = date('Y-m-d');

		// $s_idUsuario = $_SESSION["s_IdUser"];
		// $s_idPerfil = $_SESSION["sTipoUsuario"];
		// $s_Sucursal=$_SESSION["s_Sucursal"];
 ?>
<!-- jQuery 3 -->
<script src="../d_plantilla/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../d_plantilla/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="../d_plantilla/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="../d_plantilla/plugins/input-mask/jquery.inputmask.js"></script>
<script src="../d_plantilla/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="../d_plantilla/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="../d_plantilla/bower_components/moment/min/moment.min.js"></script>
<script src="../d_plantilla/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="../d_plantilla/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="../d_plantilla/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="../d_plantilla/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll -->
<script src="../d_plantilla/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="../d_plantilla/plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="../d_plantilla/bower_components/fastclick/lib/fastclick.js"></script>
<script src="../d_plantilla/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../d_plantilla/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="../d_plantilla/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../d_plantilla/dist/js/demo.js"></script>

<script src="../plugins/alertifyjs/alertify.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="../plugins/jquery-validation-1.17.0/dist/jquery.validate.js"></script>
<script type="text/javascript" src="../plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="../plugins/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.es.js" charset="UTF-8"></script>
<script type="text/javascript" src="../plugins/bootstrap-filestyle/src/bootstrap-filestyle.js"></script>

 <script>
	 $(document).ready(function() {
		 $('#blanco').dataTable({
			 "language": {
				 "url": "../assets/js/Spanish.json"
			 }
		 });
	 });
 </script>
	<div class="table-responsive">
		<table id="blanco" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th width="5%">Codigo del producto</th>
					<th>Descripcion</th>
				</tr>
			</thead>
			<body>
		</table>
	</div>
	</body>
